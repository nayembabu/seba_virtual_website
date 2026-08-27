<?php

namespace App\Http\Controllers;

use App\Models\ServerCopy;
use App\Models\Setting;
use App\Services\NidService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    private NidService $nid;

    public function __construct(NidService $nid) {
        $this->nid = $nid;
    }

    // ─── Show search form ────────────────────────────────────────────────────
    public function index()
    {
        $user    = Auth::user();
        $history = ServerCopy::where('user_id', $user->id)
            ->latest()
            ->limit(20)
            ->get();

        return view('user.search.index', compact('user', 'history'));
    }

    // ─── Handle search POST ──────────────────────────────────────────────────
    public function search(Request $request)
    {
        // $request->validate(['query' => 'required|string|max(30)']);

        $raw      = trim($request->input('query'));
        $user     = Auth::user();
        $cost = getServiceCharge('auto-service');
        $cost = $cost > 0 ? $cost : 50;

        // ── ডেমো চেক ──────────────────────────────────────────────────────────
        if (strtolower($raw) === 'demo') {
            $type   = 'demo';
            $number = 'demo';
        } else {
            // ── handle মেথডের মত আইডি এবং টাইপ ডিটেকশন লজিক ──────────────────
            preg_match_all('/\b(NIDFN|BRN|UBRN|BIRTH)?\s*[:\-]?\s*(\d{8,20})\b/i', $raw, $matches, PREG_SET_ORDER);

            $type   = null;
            $number = null;

            if (!empty($matches)) {
                // প্রথম ম্যাচটি প্রসেস করা হচ্ছে
                $v      = $matches[0];
                $prefix = strtoupper($v[1] ?? '');
                $num    = $v[2];
                $len    = strlen($num);

                if (in_array($prefix, ['BRN', 'UBRN', 'BIRTH']) && $len === 17) {
                    $type   = 'birthCertNumber';
                    $number = $num;
                } elseif ($prefix === 'NIDFN') {
                    $type   = 'formNumber';
                    $number = 'NIDFN' . $num;
                } elseif (in_array($len, [10, 13, 17])) {
                    $type   = 'nidNumber';
                    $number = $num;
                } elseif ($len === 12) {
                    $type   = 'voterNumber';
                    $number = $num;
                } elseif ($len === 8) {
                    $type   = 'formNumber';
                    $number = $num;
                } elseif ($len === 9) {
                    $type   = 'formNumber';
                    $number = 'NIDFN' . $num;
                }
            }

            // যদি কোনো ভ্যালিড ফরম্যাট ডিটেক্ট না হয়
            if (!$type || !$number) {
                return back()->with('error', 'Invalid ID format. Use 10/13/17 digit NID, 12 digit Voter No, 8/9 digit Form No, or BRN prefix for Birth Cert.');
            }
        }

        // ── Check credit ──────────────────────────────────────────────────────
        if ($user->balance < $cost) {
            return back()->with('error', 'Insufficient balance. Please recharge.');
        }

        // ── Check cache in DB ─────────────────────────────────────────────────
        $existing = ServerCopy::where('search_by', $number)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return $this->downloadPdf($existing->id);
        }

        // ── Call NID API ──────────────────────────────────────────────────────
        if ($type === 'demo') {
            $apiData = $this->nid->getDemoApiResponse('demo');
        } else {
            $apiData = $this->nid->fetchFromApi($type, $number);
        }

        if (!$apiData) {
            return back()->with('error', "No data found for: $number");
        }

        // ── Save to DB & deduct credit ────────────────────────────────────────
        try {
            DB::beginTransaction();

            $record = ServerCopy::create([
                'user_id'    => $user->id,
                'user_mail'    => $user->email,
                'nameBn'       => $apiData['Name_Bangla_']  ?? $apiData['NameBangla'] ?? '',
                'nameEn'       => $apiData['Name_English_'] ?? $apiData['NameEnglish'] ?? '',
                'nationalId'   => $apiData['National_ID']   ?? '',
                'pin'          => $apiData['Pin'] ?? '',
                'voter_no'     => $apiData['Voter_No'] ?? '',
                'photo_path'   => $this->nid->saveImage($apiData['photo'] ?? ''),
                'sign_path'    => $this->nid->saveImage($apiData['signature'] ?? ''),
                'api_response' => $apiData,
                'parent_id'    => $user->parent_id,
                'search_by'    => $number,
                'specify'      => ($type === 'demo') ? 1 : 0,
            ]);

            DB::table('users')
                ->where('id', $user->id)
                ->decrement('balance', $cost);

            DB::commit();

            return $this->downloadPdf($record->id);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            Log::error('Search save error: ' . $e->getMessage());
            return back()->with('error', 'Database error. Please try again.');
        }
    }
// ─── Download PDF ────────────────────────────────────────────────────────
    public function downloadPdf(int $id)
    {
        $record = ServerCopy::where('id', $id)
            ->where('user_mail', Auth::user()->email)
            ->firstOrFail();

        $filename = $record->search_by;
        $pdfPath  = public_path("pdf/{$filename}.pdf");

        $ok = $this->nid->generatePdfFromRecord($record, $filename);

        if (!$ok) {
            return back()->with('error', 'PDF generation failed.');
        }

        return response()->download($pdfPath, "{$filename}.pdf", [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
