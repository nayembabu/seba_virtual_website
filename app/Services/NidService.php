<?php

namespace App\Services;

use App\Models\ServerCopy;
use App\Models\Settings;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class NidService
{
    private const VERIFIED_KEYS = [
        'National_ID', 'Pin', 'Voter_No', 'Voter_Area',
        'Name_Bangla_', 'Name_English_', 'Date_of_Birth',
        'Father_Name', 'Mother_Name', 'Spouse_Name',
        'Gender', 'Education', 'Blood_Group', 'Birth_Place',
        'Religion', 'present_address', 'permanent_address', 'photo',
    ];

    // ─── Detect type from raw input string ──────────────────────────────────
    public function detectType(string $raw): ?array
    {
        $raw = trim($raw);

        if (preg_match('/^NIDFN(\d{8,9})$/i', $raw, $m)) {
            return ['type' => 'formNumber', 'number' => 'NIDFN' . $m[1]];
        }

        if (preg_match('/^(?:BRN|UBRN|BIRTH)[:\-\s]*(\d{17})$/i', $raw, $m)) {
            return ['type' => 'birthCertNumber', 'number' => $m[1]];
        }

        if (!ctype_digit($raw)) return null;

        $len = strlen($raw);

        return match (true) {
            in_array($len, [10, 13, 17]) => ['type' => 'nidNumber', 'number' => $raw],
            $len === 12 => ['type' => 'voterNumber', 'number' => $raw],
            $len === 8 => ['type' => 'formNumber', 'number' => $raw],
            $len === 9 => ['type' => 'formNumber', 'number' => 'NIDFN' . $raw],
            default => null,
        };
    }

    // ─── Call the internal NID API routes ────────────────────────────────────
    public function fetchFromApi(string $type, string $number): ?array
    {
        try {
            $nidUrl = 'https://my-service.e-serviceportal.com/api.php';
            $searchUrl = 'https://my-service.e-serviceportal.com/api.php';
            if (in_array($type, ['nidNumber', 'voterNumber'])) {
                $response = Http::timeout(30)
                    ->withoutVerifying()
                    ->get($nidUrl, [$type => $number]);
            } else {
                $response = Http::timeout(30)
                    ->withoutVerifying()
                    ->get($searchUrl, [$type => $number]);
            }

            $data = $response->json();

            if (empty($data['National_ID'])){
                Log::error('NidService fetchFromApi error: ' . $response->body());
                return null;
            };

            return $data;

        } catch (\Exception $e) {
            \Log::error('NidService fetchFromApi error: ' . $e->getMessage());
            return null;
        }
    }

    public function onlyVerifiedKeys(array $data): array
    {
        return array_intersect_key($data, array_flip(self::VERIFIED_KEYS));
    }

    public function detectItem(string $input): ?array
    {
        $items = $this->extractItems(trim($input));

        return $items[0] ?? null;
    }

    // ─── Save base64 image to storage ────────────────────────────────────────
    public function saveImage(?string $base64): ?string
    {
        if (empty($base64)) return null;

        try {
            $bin = base64_decode($base64);
            $name = 'photos/' . Str::uuid() . '.jpg';
            Storage::disk('public')->put($name, $bin);
            return $name;
        } catch (\Exception $e) {
            return null;
        }
    }

    // ════════════════════════════════════════════════════════════════════════
    // PDF GENERATION — DomPDF (pure PHP, works on shared hosting)
    // ════════════════════════════════════════════════════════════════════════
    //
    // $printUrl is no longer used for fetching over HTTP — instead we pass
    // the record ID + nationalId directly and render the Blade view to PDF
    // in-process. This avoids needing curl/wkhtmltopdf to "visit a URL".
    //
    // For backward compatibility, this method still accepts a URL like
    // "/print/{id}/{nid}" and extracts the id/nid from it.
    // ════════════════════════════════════════════════════════════════════════
    public function generatePdf(string $printUrl, string $filename, $record): bool
    {
        try {
            // Extract base64 id/nid from the print URL: /print/{id}/{nid}
            $path = trim(parse_url($printUrl, PHP_URL_PATH) ?? '', '/');
            $parts = explode('/', $path);

            // $parts = ['print', '{id}', '{nid}']
            if (count($parts) < 3) {
                \Log::error('generatePdf: invalid print URL: ' . $printUrl);
                return false;
            }

            $id = base64_decode($parts[1]);
            $nid = base64_decode($parts[2]);

            if (!$record) {
                $record = \App\Models\ServerCopy::where('id', $id)
                    ->where('nationalId', $nid)
                    ->first();
            }

            if (!$record) {
                \Log::error("generatePdf: record not found id=$id nid=$nid");
                return false;
            }

            return $this->generatePdfFromRecord($record, $filename);

        } catch (\Exception $e) {
            \Log::error('generatePdf error: ' . $e->getMessage());
            return false;
        }
    }

    // ─── Direct generation from a ServerCopy record ──────────────────────────


    // ─────────────────────────────────────────────────────────────────────────

    private function fetchImageAsDataUri(?string $url): ?string
    {
        if (empty($url) || empty(trim((string)$url))) return null;

        try {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ]);
            $bytes = curl_exec($ch);
            $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $ctype = (string)curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err || !$bytes || $httpCode !== 200) {
                \Log::warning("fetchImage failed — HTTP:{$httpCode} err:{$err} url:{$url}");
                return null;
            }

            // Clean up Content-Type header (e.g., "image/jpeg; charset=utf-8" -> "image/jpeg")
            $mime = strtolower(trim(explode(';', $ctype)[0]));

            // CRITICAL FIX: If the response is HTML, JSON, or XML, it's an error page (e.g. Laravel 404/500 screen)
            if (str_contains($mime, 'text') || str_contains($mime, 'html') || str_contains($mime, 'json')) {
                \Log::warning("fetchImage blocked — URL returned an error page/HTML contents instead of raw image. Mime received: {$mime} for URL: {$url}");
                return null;
            }

            // Strict allowed image types check
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($mime, $allowedMimes)) {
                $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
                $mime = match ($ext) {
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                    'jpg', 'jpeg' => 'image/jpeg',
                    default => null // Stop fallback if it doesn't look like a valid image extension
                };
            }

            // If it's still not a valid image mime type, reject it
            if (!$mime || !in_array($mime, $allowedMimes)) {
                \Log::warning("fetchImage rejected — Invalid content type structure: {$ctype} for URL: {$url}");
                return null;
            }

            return 'data:' . $mime . ';base64,' . base64_encode($bytes);

        } catch (\Throwable $e) {
            \Log::warning('fetchImage exception: ' . $e->getMessage());
            return null;
        }
    }

    public function normalise(mixed $raw): array
    {
        if (is_string($raw)) $raw = json_decode($raw, true) ?? [];
        if (!is_array($raw)) $raw = [];
        return json_decode(json_encode($raw), true);
    }


    public function generatePdfFromRecord(ServerCopy $record, string $filename, bool $verified = false): bool
    {
        try {

            $outputDir = public_path('pdf');
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }
            $outputPath = $outputDir . '/' . $filename . '.pdf';

            if (file_exists($outputPath)) {
                return true;
            }
            $data = $this->normalise($record->api_response);

            // ── Verified mode: expose only whitelisted keys ───────────────────────
            if ($verified) {
                $data = array_intersect_key($data, array_flip(self::VERIFIED_KEYS));
            }

            $photoDataUri = $data['photo'] ?? $data['Photo'] ?? null;
            $signDataUri  = $verified ? null : ($data['signature'] ?? $data['Signature'] ?? null);

            // Render Blade
            $html = View::make(
                'user.search.print',
                compact('record', 'data', 'photoDataUri', 'signDataUri', 'verified')
            )->render();


            // VPS PDF API
            $response = Http::retry(
                3,
                3000
            )
                ->timeout(180)
                ->accept('application/pdf')
                ->post(
                    'https://pdf.e-serviceportal.com/generate-pdf',
                    [
                        'html' => $html
                    ]
                );


            if (!$response->successful()) {

                \Log::error(
                    'PDF API Error: ' . $response->body()
                );

                return false;
            }

            file_put_contents(
                $outputPath,
                $response->body()
            );

            clearstatcache();

            if (!file_exists($outputPath)) {

                Log::error('Invalid PDF generated', [
                    'file' => $outputPath,
                    'size' => file_exists($outputPath)
                        ? filesize($outputPath)
                        : 0
                ]);

                return false;
            }

            Log::info('PDF Generated', [
                'file' => $outputPath,
                'size' => filesize($outputPath)
            ]);

            return true;

        } catch (\Exception $e) {

            \Log::error(
                'generatePdfFromRecord: '
                . $e->getMessage()
            );

            return false;
        }
    }

    // ─────────────────────────────────────────────────────────────────────────

    private function writeMpdf(string $html, string $outputPath): bool
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 8,
            'margin_bottom' => 8,
            'margin_left' => 8,
            'margin_right' => 8,

            'fontDir' => array_merge(
                $defaultConfig['fontDir'],
                [public_path('fonts')]
            ),

            'fontdata' => $defaultFontConfig['fontdata'] + [
                    'siyamrupali' => [
                        'R' => 'Siyamrupali.ttf',
                        'useOTL' => 0xFF,
                        'useKashida' => 75,
                    ],
                ],

            'default_font' => 'siyamrupali',
        ]);

        // --- ADD THESE 3 LINES TO FIX THE -1 ARRAY KEY ERROR ---
        $mpdf->shrink_tables_to_fit = 0; // Prevents nested table scaling crashes
        $mpdf->keep_table_proportions = true;
        $mpdf->autoPageBreak = true;
        // -------------------------------------------------------

        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output($outputPath, \Mpdf\Output\Destination::FILE);

        clearstatcache();
        return file_exists($outputPath) && filesize($outputPath) > 500;
    }

    private function writeDompdf(string $html, string $outputPath): bool
    {
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', false);   // images are base64, no remote needed
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'SolaimanLipi');
        // Allow base64 @font-face from the blade
        $options->set('isPhpEnabled', false);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($outputPath, $dompdf->output());

        clearstatcache();
        return file_exists($outputPath) && filesize($outputPath) > 500;
    }

    /**
     * ডেমো সার্চের জন্য মক/ফেক API রেসপন্স তৈরি করার মেথড।
     */
    public function getDemoApiResponse(string $number): array
    {
        // ছোট baseline ১x১ ব্ল্যাঙ্ক ইমেজ — সাইজ পরিবর্তন না করেও কাজ করবে
        $dummyBase64Image = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
        return [
            'National_ID' => $number === 'demo' || str_starts_with($number, 'demo') ? '1234567890123' : $number,
            'Pin' => '19980000001234567',
            'Status' => 'checked',
            'Afis_Status' => 'NO_MATCH',
            'Lock_Flag' => 'N',
            'Voter_No' => '987654321012',
            'Form_No' => '00000000',
            'Sl_No' => '001',
            'Tag' => 'demo_2026',
            'Name_Bangla_' => 'মোঃ ডেমো ইউজার',
            'Name_English_' => 'Md Demo User',
            'Date_of_Birth' => '1998-01-01',
            'Birth_Place' => 'ঢাকা',
            'Birth_Other' => '',
            'Birth_Registration_No' => '19980000000000001',
            'Father_Name' => 'মোঃ ডেমো পিতা',
            'Mother_Name' => 'মোসাম্মৎ ডেমো মাতা',
            'Spouse_Name' => '',
            'Gender' => 'male',
            'Marital' => 'single',
            'Occupation' => 'student',
            'Disability' => '',
            'Disability_Other' => '',
            'Education' => 'স্নাতক',
            'Education_Other' => '',
            'Education_Sub' => '',
            'Identification' => '',
            'Blood_Group' => 'O+',
            'TIN' => '',
            'Driving' => '',
            'Passport' => '',
            'Laptop_ID' => '',
            'NID_Father' => '',
            'NID_Mother' => '',
            'Nid_Spouse' => '',
            'Voter_No_Father' => '',
            'Voter_No_Mother' => '',
            'Voter_No_Spouse' => '',
            'Phone' => '',
            'Mobile' => '01700000000',
            'Email' => '',
            'Religion' => 'Islam',
            'Religion_Other' => '',
            'Death_Date_Of_Father' => '',
            'Death_Date_Of_Mother' => '',
            'Death_Date_Of_Spouse' => '',
            'No_Finger' => '0',
            'No_Finger_Print' => '0',
            'Voter_Area' => 'মিরপুর (100000)',
            'Voter_At' => 'permanent',
            'present_address' => [
                'Division' => 'ঢাকা',
                'District' => 'ঢাকা',
                'RMO' => '',
                'City_Corporation_Or_Municipality' => '',
                'Upozila' => 'মিরপুর',
                'Union_Ward' => 'ওয়ার্ড নং-০১',
                'Mouza_Moholla' => '',
                'Additional_Mouza_Moholla' => '',
                'Ward_For_Union_Porishod' => '',
                'Village_Road' => 'ডেমো রোড',
                'Additional_Village_Road' => '',
                'Home_Holding_No' => '১২৩/এ',
                'Post_Office' => 'মিরপুর-১০',
                'Postal_Code' => '1216',
                'Region' => 'ঢাকা',
            ],
            'permanent_address' => [
                'Division' => 'ঢাকা',
                'District' => 'ঢাকা',
                'RMO' => '',
                'City_Corporation_Or_Municipality' => '',
                'Upozila' => 'মিরপুর',
                'Union_Ward' => 'ওয়ার্ড নং-০১',
                'Mouza_Moholla' => '',
                'Additional_Mouza_Moholla' => '',
                'Ward_For_Union_Porishod' => '',
                'Village_Road' => 'ডেমো রোড',
                'Additional_Village_Road' => '',
                'Home_Holding_No' => '১২৩/এ',
                'Post_Office' => 'মিরপুর-১০',
                'Postal_Code' => '1216',
                'Region' => 'ঢাকা',
            ],
            'photo' => $dummyBase64Image,
            'signature' => $dummyBase64Image,
            'search_by' => $number,
        ];
    }

    public function extractItems(string $text): array
    {
        // ── Step 1: collect verified numbers (v-prefix) and strip the "v" ──
        $verifiedNumbers = [];
        if (preg_match_all('/(?<!\d)v(\d{8,20})(?!\d)/i', $text, $vMatches)) {
            foreach ($vMatches[1] as $vNum) {
                $verifiedNumbers[$vNum] = true;
            }
            // Strip the "v" so the main regex sees bare digits
            $text = preg_replace('/(?<!\d)v(\d{8,20})(?!\d)/i', '$1', $text);
        }

        // ── Step 2: standard extraction ─────────────────────────────────────
        preg_match_all('/\b(NIDFN|BRN|UBRN|BIRTH)?\s*[:\-]?\s*(\d{8,20})\b/i', $text, $matches, PREG_SET_ORDER);

        $detected = [];
        foreach ($matches as $v) {
            $prefix     = strtoupper($v[1] ?? '');
            $num        = $v[2];
            $len        = strlen($num);
            $isVerified = isset($verifiedNumbers[$num]);

            if (in_array($prefix, ['BRN', 'UBRN', 'BIRTH']) && $len === 17) {
                $detected[] = ['type' => 'birthCertNumber', 'number' => $num,             'verified' => $isVerified];
            } elseif ($prefix === 'NIDFN') {
                $detected[] = ['type' => 'formNumber',      'number' => 'NIDFN' . $num,   'verified' => $isVerified];
            } elseif (in_array($len, [10, 13, 17])) {
                $detected[] = ['type' => 'nidNumber',        'number' => $num,             'verified' => $isVerified];
            } elseif ($len === 12) {
                $detected[] = ['type' => 'voterNumber',      'number' => $num,             'verified' => $isVerified];
            } elseif ($len === 8) {
                $detected[] = ['type' => 'formNumber',       'number' => $num,             'verified' => $isVerified];
            } elseif ($len === 9) {
                $detected[] = ['type' => 'formNumber',       'number' => 'NIDFN' . $num,   'verified' => $isVerified];
            }
        }

        return collect($detected)->unique('number')->values()->all();
    }
}
