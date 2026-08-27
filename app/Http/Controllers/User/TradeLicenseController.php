<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TradeLicenseApplication;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class TradeLicenseController extends Controller
{
    public function index($city)
    {
        if (!in_array($city, ['dncc', 'dscc'])) {
            abort(404);
        }

        $prefix = $city === 'dncc' ? 'TRAD/DNCC' : 'TRAD/DSCC';
        $lastLicense = TradeLicenseApplication::where('city', $city)
            ->where('license_no', 'like', $prefix . '/%')
            ->orderBy('id', 'desc')
            ->value('license_no');

        if ($lastLicense) {
            $parts = explode('/', $lastLicense);
            $num = isset($parts[2]) ? intval($parts[2]) + 1 : 1;
        } else {
            $num = 1;
        }
        $license_no = $prefix . '/' . str_pad($num, 6, '0', STR_PAD_LEFT) . '/' . date('Y');

        $applications = TradeLicenseApplication::where('user_id', Auth::id())
            ->where('city', $city)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('user.trade-license-form', compact('city', 'license_no', 'applications'));
    }

    public function generateLicenseNo($city)
    {
        if (!in_array($city, ['dncc', 'dscc'])) {
            return response()->json(['success' => false, 'message' => 'Invalid city']);
        }

        $prefix = $city === 'dncc' ? 'TRAD/DNCC' : 'TRAD/DSCC';
        $lastLicense = TradeLicenseApplication::where('city', $city)
            ->where('license_no', 'like', $prefix . '/%')
            ->orderBy('id', 'desc')
            ->value('license_no');

        if ($lastLicense) {
            $parts = explode('/', $lastLicense);
            $num = isset($parts[2]) ? intval($parts[2]) + 1 : 1;
        } else {
            $num = 1;
        }
        $nextLicenseNo = $prefix . '/' . str_pad($num, 6, '0', STR_PAD_LEFT) . '/' . date('Y');

        return response()->json([
            'success' => true,
            'nextLicenseNo' => $nextLicenseNo
        ]);
    }

    public function submit(Request $request)
    {
        $city = $request->input('city');
        if (!in_array($city, ['dncc', 'dscc'])) {
            return response()->json(['status' => 'error', 'message' => 'Invalid city']);
        }

        $request->validate([
            'license_no' => 'required|string|max:50',
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'father_husband_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'business_nature' => 'required|string|max:100',
            'business_type' => 'required|string|max:100',
            'nid_passport_birth_no' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'financial_year' => 'required|string|max:20',
            'business_start_date' => 'required|date',
            'license_validity_date' => 'required|date',
            'declaration' => 'required|accepted',
            'total_fee' => 'required|numeric',
            'owner_photo' => 'nullable|image|max:5120',
            'other_documents.*' => 'nullable|file|max:10240',
        ]);

        $cost = 50;
        $user = Auth::user();

        if ($user->balance < $cost) {
            return response()->json([
                'status' => 'error',
                'message' => '??????????????????????????? ?????????????????????????????? ????????????????????? ????????? ????????????????????? ???????????????'
            ]);
        }

        DB::beginTransaction();
        try {
            $data = $request->except(['_token', 'city', 'declaration', 'owner_photo', 'other_documents']);
            $data['user_id'] = $user->id;
            $data['city'] = $city;
            $data['status'] = 'pending';

            if ($request->hasFile('owner_photo')) {
                $data['owner_photo'] = $request->file('owner_photo')->store('trade-licenses/photos', 'public');
            }
            if ($request->hasFile('other_documents')) {
                $files = [];
                foreach ($request->file('other_documents') as $file) {
                    $files[] = $file->store('trade-licenses/documents', 'public');
                }
                $data['other_documents'] = json_encode($files);
            }

            $application = TradeLicenseApplication::create($data);

            $user->decrement('balance', $cost);
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'out',
                'amount' => $cost,
                'tx_id' => 'TRADE-' . $application->license_no,
                'description' => $city === 'dncc' ? 'DNCC ??????????????? ???????????????????????? ???????????????' : 'DSCC ??????????????? ???????????????????????? ???????????????',
                'details' => 'ref_id=' . $application->id . '|ref_type=trade_license',
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => '??????????????? ??????????????? ???????????????????????? ??????????????? ????????????????????? ????????? ?????????????????? ??????????????????',
                'application_id' => $application->id,
                'license_no' => $application->license_no,
                'cost' => $cost,
                'redirect' => route('user.' . $city . '-trade.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => '??????????????? ????????? ???????????? ?????????????????? ??????????????????: ' . $e->getMessage()
            ]);
        }
    }

    public function print($id)
    {
        $app = TradeLicenseApplication::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $html = view('user.trade-license-pdf', ['app' => $app])->render();

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $fontDirs[] = public_path('fonts');

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $fontData['nikosh'] = [
            'R' => 'Nikosh.ttf',
            'I' => 'Nikosh.ttf',
        ];
        $fontData['notosansbengali'] = [
            'R' => 'NotoSansBengali-Regular.ttf',
            'B' => 'NotoSansBengali-Bold.ttf',
        ];

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 6,
            'margin_right' => 6,
            'margin_top' => 6,
            'margin_bottom' => 6,
            'fontDir' => $fontDirs,
            'fontdata' => $fontData,
            'default_font' => 'nikosh',
            'tempDir' => storage_path('app/mpdf'),
        ]);
        $mpdf->WriteHTML($html);
        return response($mpdf->Output('trade-license-' . $app->license_no . '.pdf', 'S'))
            ->header('Content-Type', 'application/pdf');
    }
}
