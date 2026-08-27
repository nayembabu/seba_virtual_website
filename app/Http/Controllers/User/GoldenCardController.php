<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GoldenCard;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class GoldenCardController extends Controller
{
    public function index()
    {
        $lastCard = GoldenCard::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->value('card_no');

        if ($lastCard) {
            $parts = explode('/', $lastCard);
            $num = isset($parts[2]) ? intval($parts[2]) + 1 : 1;
        } else {
            $num = 1;
        }
        $card_no = 'GC/' . str_pad($num, 6, '0', STR_PAD_LEFT) . '/' . date('Y');

        $cards = GoldenCard::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('user.golden-card-form', compact('card_no', 'cards'));
    }

    public function generateCardNo()
    {
        $lastCard = GoldenCard::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->value('card_no');

        if ($lastCard) {
            $parts = explode('/', $lastCard);
            $num = isset($parts[2]) ? intval($parts[2]) + 1 : 1;
        } else {
            $num = 1;
        }
        $nextCardNo = 'GC/' . str_pad($num, 6, '0', STR_PAD_LEFT) . '/' . date('Y');

        return response()->json([
            'success' => true,
            'nextCardNo' => $nextCardNo
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'card_no' => 'required|string|max:50',
            'name_bn' => 'required|string|max:255',
            'mother_bn' => 'required|string|max:255',
            'father_bn' => 'required|string|max:255',
            'disability_bn' => 'required|string|max:255',
            'dob' => 'required|string|max:20',
            'id_no' => 'required|string|max:50',
            'address_bn' => 'required|string',
            'issue_date' => 'required|string|max:20',
            'name_en' => 'required|string|max:255',
            'mother_en' => 'required|string|max:255',
            'father_en' => 'required|string|max:255',
            'disability_en' => 'required|string|max:255',
            'blood_group' => 'nullable|string|max:20',
            'mobile' => 'required|string|max:20',
            'address_en' => 'required|string',
            'photo' => 'nullable|image|max:5120',
            'signature' => 'nullable|image|max:2048',
        ]);

        $cost = 30;
        $user = Auth::user();

        if ($user->balance < $cost) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'অপর্যাপ্ত ব্যালেন্স। অনুগ্রহ করে রিচার্জ করুন।'
                ]);
            }
            return back()->with('error', 'অপর্যাপ্ত ব্যালেন্স। অনুগ্রহ করে রিচার্জ করুন।')->withInput();
        }

        DB::beginTransaction();
        try {
            $data = $request->except(['_token', 'photo', 'signature']);
            $data['user_id'] = $user->id;

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('golden-cards/photos', 'public');
            }
            if ($request->hasFile('signature')) {
                $data['signature'] = $request->file('signature')->store('golden-cards/signatures', 'public');
            }

            $card = GoldenCard::create($data);

            $user->decrement('balance', $cost);
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'out',
                'amount' => $cost,
                'tx_id' => 'GC-' . $card->card_no,
                'description' => 'গোল্ডেন কার্ড আবেদন',
                'details' => 'ref_id=' . $card->id . '|ref_type=golden_card',
            ]);

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'success' => true,
                    'message' => 'আপনার গোল্ডেন কার্ড আবেদন সফলভাবে জমা দেওয়া হয়েছে',
                    'card_id' => $card->id,
                    'card_no' => $card->card_no,
                    'cost' => $cost,
                    'redirect' => route('user.golden-card.index')
                ]);
            }

            return redirect()->route('user.golden-card.index')
                ->with('success', 'আপনার গোল্ডেন কার্ড আবেদন সফলভাবে জমা দেওয়া হয়েছে');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'আবেদন জমা দিতে সমস্যা হয়েছে: ' . $e->getMessage()
                ]);
            }
            return back()->with('error', 'আবেদন জমা দিতে সমস্যা হয়েছে: ' . $e->getMessage())->withInput();
        }
    }

    public function print($id)
    {
        $card = GoldenCard::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $html = view('user.golden-card-pdf', ['card' => $card])->render();

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $fontDirs[] = public_path('fonts');

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $fontData['nikosh'] = ['R' => 'Nikosh.ttf', 'I' => 'Nikosh.ttf'];
        $fontData['notosansbengali'] = [
            'R' => 'NotoSansBengali-Regular.ttf',
            'B' => 'NotoSansBengali-Bold.ttf',
        ];

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'fontDir' => $fontDirs,
            'fontdata' => $fontData,
            'default_font' => 'nikosh',
            'tempDir' => storage_path('app/mpdf'),
        ]);
        $mpdf->WriteHTML($html);
        return response($mpdf->Output('golden-card-' . $card->card_no . '.pdf', 'S'))
            ->header('Content-Type', 'application/pdf');
    }
}
