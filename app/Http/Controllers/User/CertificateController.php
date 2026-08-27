<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CertificateApplication;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function index()
    {
        $lastCert = CertificateApplication::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->value('certificate_no');

        if ($lastCert) {
            $num = intval(substr($lastCert, -6)) + 1;
        } else {
            $num = 1;
        }
        $certificate_no = date('Y') . str_pad($num, 6, '0', STR_PAD_LEFT);

        $applications = CertificateApplication::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('user.certificate-form', compact('certificate_no', 'applications'));
    }

    public function generateNo()
    {
        $lastCert = CertificateApplication::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->value('certificate_no');

        if ($lastCert) {
            $num = intval(substr($lastCert, -6)) + 1;
        } else {
            $num = 1;
        }
        $certificate_no = date('Y') . str_pad($num, 6, '0', STR_PAD_LEFT);

        return response()->json([
            'success' => true,
            'certificate_no' => $certificate_no
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'certificate_no' => 'required|string|max:50',
            'office_type' => 'required|string',
            'union_no' => 'nullable|string|max:50',
            'union_name' => 'nullable|string|max:255',
            'upazila' => 'nullable|string|max:255',
            'cert_type' => 'required|string',
            'language' => 'required|string',
            'issue_date' => 'required|date',
            'applicant_name' => 'required|string|max:255',
            'nid_no' => 'required|string|max:50',
            'income_amount' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'present_village' => 'nullable|string|max:255',
            'present_post' => 'nullable|string|max:255',
            'present_upazila' => 'nullable|string|max:255',
            'present_district' => 'nullable|string|max:255',
            'member_name.*' => 'nullable|string|max:255',
            'member_relation.*' => 'nullable|string|max:255',
            'member_age.*' => 'nullable|string|max:255',
            'member_nid.*' => 'nullable|string|max:255',
            'prepared_by' => 'nullable|string|max:255',
            'prepared_seal_en' => 'nullable|string',
            'authority_title' => 'nullable|string|max:100',
            'authority_name' => 'nullable|string|max:255',
            'authority_seal_en' => 'nullable|string',
        ]);

        $fee = 150;
        $user = Auth::user();

        if ($user->balance < $fee) {
            return response()->json([
                'status' => 'error',
                'message' => 'অপর্যাপ্ত ব্যালেন্স। অনুগ্রহ করে রিচার্জ করুন।'
            ]);
        }

        DB::beginTransaction();
        try {
            $data = $request->except(['_token', '_method', 'member_name', 'member_relation', 'member_age', 'member_nid']);
            $data['user_id'] = $user->id;
            $data['fee'] = $fee;
            $data['status'] = 'approved';

            if ($request->has('member_name')) {
                $members = [];
                foreach ($request->member_name as $i => $name) {
                    if ($name) {
                        $members[] = [
                            'name' => $name,
                            'relation' => $request->member_relation[$i] ?? '',
                            'age' => $request->member_age[$i] ?? '',
                            'nid' => $request->member_nid[$i] ?? '',
                        ];
                    }
                }
                $data['members'] = $members;
            }

            $application = CertificateApplication::create($data);

            $user->decrement('balance', $fee);
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'out',
                'amount' => $fee,
                'tx_id' => 'CERT-' . $application->certificate_no,
                'description' => 'সকল প্রত্যয়ন সনদ (' . $application->certificate_no . ')',
                'details' => 'ref_id=' . $application->id . '|ref_type=certificate',
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => 'সনদপত্র সফলভাবে তৈরি করা হয়েছে',
                'certificate_no' => $application->certificate_no,
                'id' => $application->id,
                'redirect' => route('user.certificate.download', $application->id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'সমস্যা হয়েছে: ' . $e->getMessage()
            ]);
        }
    }

    public function download($id)
    {
        $cert = CertificateApplication::findOrFail($id);
        if ($cert->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('user.certificate-pdf', compact('cert'));
        return $pdf->download('Certificate_' . $cert->certificate_no . '.pdf');
    }

    public function downloadById($id)
    {
        return $this->download($id);
    }
}
