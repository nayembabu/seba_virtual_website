<?php
namespace App\Http\Controllers;

use App\Models\NidData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class NidCardController extends Controller
{
    public function parsePdf($type)
    {
        
        if (!request()->hasFile('pdf')) {
            return response()->json(['error' => 'No PDF file uploaded'], 400);
        }

        $apiKey = config('services.sokolseba.api_key'); // .env এ SOKOLSEBA_API_KEY রাখুন
        $pdfPath = request()->file('pdf')->getPathname();
        $pdfName = request()->file('pdf')->getClientOriginalName();

        $curlFile = new \CURLFile($pdfPath, request()->file('pdf')->getMimeType(), $pdfName);

        $postData = [
            'pdf'      => $curlFile,
            'api_key'  => $apiKey,
            'domain'   => request()->getHost(),
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://sokolseba.icu/v1-make.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: multipart/form-data',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return response()->json(['error' => 'cURL Error: ' . $curlError], 500);
        }

        $result = json_decode($response, true);

        if ($httpCode !== 200) {
            return response()->json(['error' => 'API request failed', 'response' => $result], $httpCode);
        }

        // এখানে $result থেকে ডেটা নিয়ে NidData মডেলে সেভ করতে পারেন প্রয়োজন অনুযায়ী
        // NidData::create([...]);

        return response()->json($result);
    }
}