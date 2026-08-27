<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Nid;
use App\Models\ServiceCharge;
use App\Models\Transaction;
use App\Services\NidPdfParserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NidCardController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();

            return $next($request);
        });
    }

    public function index()
    {
        $nids = Nid::where('user_id', $this->user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('user.nidcard.index', compact('nids'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type', Nid::TYPE_NID);
        $map = [
            Nid::TYPE_APPLICATION => 'user.nidcard.application',
            Nid::TYPE_SIGN_TO_SERVER => 'user.nidcard.sign-to-server',
            Nid::TYPE_CDMS => 'user.nidcard.cdms',
            Nid::TYPE_NID => 'user.nidcard.create',
        ];
        if (! array_key_exists($type, $map)) {
            $type = Nid::TYPE_NID;
        }

        return view($map[$type], [
            'title' => 'Create NID Card',
            'type' => $type,
        ]);
    }

    public function parsePdf(Request $request): JsonResponse
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240', // max 10 MB
        ]);

        $result = (new NidPdfParserService())->parsePdf($request->file('pdf'));

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $type = $request->input('type', Nid::TYPE_NID);

        if (! in_array($type, [Nid::TYPE_NID, Nid::TYPE_APPLICATION, Nid::TYPE_SIGN_TO_SERVER, Nid::TYPE_CDMS], true)) {
            $type = Nid::TYPE_NID;
        }

        $fee = ServiceCharge::getCharge('nidcard');
        if ($fee <= 0) {
            $fee = ServiceCharge::getCharge('smartcard');
        }

        if ($fee > 0 && (float) $user->balance < $fee) {
            return back()->withInput()->with('error', 'You do not have enough balance for this service.');
        }

        $needsSignature = in_array($type, [Nid::TYPE_NID, Nid::TYPE_APPLICATION], true);
        $needsPresentBlock = in_array($type, [Nid::TYPE_CDMS, Nid::TYPE_SIGN_TO_SERVER], true);
        $needsCdmsOnly = $type === Nid::TYPE_CDMS;

        $rules = [
            'type' => ['required', Rule::in([Nid::TYPE_NID, Nid::TYPE_APPLICATION, Nid::TYPE_SIGN_TO_SERVER, Nid::TYPE_CDMS])],
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'nid_number' => 'required|string|max:50',
            'pin_number' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'issue_date' => 'required|date',
            'address' => 'required|string',
            'gender' => 'required|string|in:male,female,other',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($needsSignature) {
            $rules['signature'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            $rules['signature'] = 'prohibited';
        }

        if ($needsPresentBlock) {
            $rules['present_address'] = 'required|string';
            $rules['spouse_name'] = 'nullable|string|max:255';
            $rules['education'] = 'nullable|string|max:255';
            $rules['religion'] = 'nullable|string|max:100';
            $rules['occupation'] = 'nullable|string|max:255';
        }
        if ($needsCdmsOnly) {
            $rules['vote_center'] = 'nullable|string|max:255';
            $rules['voter_no'] = 'nullable|string|max:100';
            $rules['form_no'] = 'nullable|string|max:100';
        }

        $validated = $request->validate($rules);

        if ($fee > 0) {
            $user->balance = (float) $user->balance - $fee;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $fee,
                'type' => 'debit',
                'details' => 'NID Card creation ('.$type.')',
                'tx_id' => strtoupper('NID'.uniqid()),
            ]);
        }

        $nid = new Nid;
        $nid->user_id = $user->id;
        $nid->type = $type;
        $nid->fill([
            'name_en' => $validated['name_en'],
            'name_bn' => $validated['name_bn'],
            'father_name' => $validated['father_name'],
            'mother_name' => $validated['mother_name'],
            'date_of_birth' => $validated['date_of_birth'],
            'birth_place' => $validated['birth_place'],
            'nid_number' => $validated['nid_number'],
            'pin_number' => $validated['pin_number'] ?? null,
            'blood_group' => $validated['blood_group'] ?? null,
            'issue_date' => $validated['issue_date'],
            'address' => $validated['address'],
            'gender' => $validated['gender'],
        ]);

        if ($needsPresentBlock) {
            $nid->present_address = $validated['present_address'];
            $nid->spouse_name = $validated['spouse_name'] ?? null;
            $nid->education = $validated['education'] ?? null;
            $nid->religion = $validated['religion'] ?? null;
            $nid->occupation = $validated['occupation'] ?? null;
        } else {
            $nid->present_address = null;
            $nid->spouse_name = null;
            $nid->education = null;
            $nid->religion = null;
            $nid->occupation = null;
        }


        $baseDir = 'nid_cards/'.$user->id;
        
        

                
                
        // ---------- Photo ----------
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store($baseDir.'/photos', 'public');
            $nid->photo = $path;
        } elseif ($request->filled('img_photo')) {
            $photoPath = $this->saveBase64Image($request->input('img_photo'), $baseDir.'/photos');
            if ($photoPath) {
                $nid->photo = $photoPath;
            }
        }
        
        // ---------- Signature ----------
        if ($needsSignature) {
            if ($request->hasFile('signature')) {
                $path = $request->file('signature')->store($baseDir.'/signatures', 'public');
                $nid->signature = $path;
            } elseif ($request->filled('img_sign')) {
                $signPath = $this->saveBase64Image($request->input('img_sign'), $baseDir.'/signatures');
                if ($signPath) {
                    $nid->signature = $signPath;
                }
            }
        } else {
            $nid->signature = null;
        }

        $nid->vote_center = $request->input('vote_center') ?? null;
        $nid->voter_no = $request->input('voter_no') ?? null;
        $nid->form_no = $request->input('form_no') ?? null;
        



        $nid->save();

        return redirect()->route('user.nid-card.index')->with('success', 'NID card record saved successfully.');
    }
    
    private function saveBase64Image(string $base64String, string $directory): ?string
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
            return null;
        }

        $extension = $matches[1];
        $imageData = substr($base64String, strpos($base64String, ',') + 1);
        $decodedImage = base64_decode($imageData, true);

        if ($decodedImage === false) {
            return null;
        }

        $filename = Str::uuid().'.'.$extension;
        $path = $directory.'/'.$filename;

        Storage::disk('public')->put($path, $decodedImage);

        return $path;
    }

    protected function nidForUser(int $id): Nid
    {
        return Nid::where('id', $id)->where('user_id', $this->user->id)->firstOrFail();
    }

    protected function showPayload(Nid $nid): array
    {
        $banglaName = $nid->name_bn;
        $englishName = $nid->name_en;
        $fatherName = $nid->father_name;
        $motherName = $nid->mother_name;
        $dateOfBirth = $nid->date_of_birth;
        $formattedDob = $nid->date_of_birth
            ? $nid->date_of_birth->format('d M Y')
            : '';
        $nidNumber = $nid->nid_number;
        $formattedNid = $nid->nid_number;
        $bloodGroup = $nid->blood_group ?: 'N/A';
        $address = $nid->address;
        $birthPlace = $nid->birth_place ?: 'N/A';
        $issueDate = $nid->issue_date
            ? $nid->issue_date->format('d M Y')
            : 'N/A';
        $photo = $nid->photo ? : '';
        $signature = $nid->signature ?: '';
        $pin = $nid->pin_number ?? '';
        $present_address = $nid->present_address ?? '';
        $spouse_name = $nid->spouse_name ?? '';
        $education = $nid->education ?? '';
        $religion = $nid->religion ?? '';
        $occupation = $nid->occupation ?? '';
        $vote_center = $nid->vote_center ?? '';
        $voter_no = $nid->voter_no ?? '';
        $form_no = $nid->form_no ?? '';

        return compact(
            'nid',
            'banglaName',
            'englishName',
            'fatherName',
            'motherName',
            'dateOfBirth',
            'formattedDob',
            'nidNumber',
            'formattedNid',
            'bloodGroup',
            'address',
            'birthPlace',
            'issueDate',
            'photo',
            'signature',
            'pin',
            'present_address',
            'spouse_name',
            'education',
            'religion',
            'occupation',
            'vote_center',
            'voter_no',
            'form_no',

        );
    }



    public function view(int $id, $type)
    {

        $nid = $this->nidForUser($id);
        $view = "user.nidcard.$type";

        return view($view, $this->showPayload($nid));
    }


    public function print(int $id)
    {
        $nid = $this->nidForUser($id);

        return view('user.nidcard.print', $this->showPayload($nid));
    }

    public function verify(int $id)
    {
        $nid = Nid::findOrFail($id);

        return view('user.nidcard.show', $this->showPayload($nid) + ['viewLayout' => $nid->type]);
    }

    public function edit(int $id)
    {
        $nid = $this->nidForUser($id);

        return view('user.nidcard.edit', [
            'title' => 'Edit NID Card',
            'type' => $nid->type,
            'nid' => $nid,
        ]);
    }

    public function update(Request $request, int $id)
    {
//        dd($request->all());
        $nid = $this->nidForUser($id);
        $type = $nid->type;

        $needsSignature = in_array($type, [Nid::TYPE_NID, Nid::TYPE_APPLICATION], true);
        $needsPresentBlock = in_array($type, [Nid::TYPE_CDMS, Nid::TYPE_SIGN_TO_SERVER], true);
        $needsCdmsOnly = $type === Nid::TYPE_CDMS;

        $rules = [
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'nid_number' => 'required|string|max:50',
            'pin_number' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'issue_date' => 'required|date',
            'address' => 'required|string',
            'gender' => 'required|string|in:male,female,other',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($needsPresentBlock) {
            $rules['present_address'] = 'required|string';
            $rules['spouse_name'] = 'nullable|string|max:255';
            $rules['education'] = 'nullable|string|max:255';
            $rules['religion'] = 'nullable|string|max:100';
            $rules['occupation'] = 'nullable|string|max:255';
        }
        if ($needsCdmsOnly) {
            $rules['vote_center'] = 'nullable|string|max:255';
            $rules['voter_no'] = 'nullable|string|max:100';
            $rules['form_no'] = 'nullable|string|max:100';
        }

        $validated = $request->validate($rules);

        $nid->fill([
            'name_en' => $validated['name_en'],
            'name_bn' => $validated['name_bn'],
            'father_name' => $validated['father_name'],
            'mother_name' => $validated['mother_name'],
            'date_of_birth' => $validated['date_of_birth'],
            'birth_place' => $validated['birth_place'],
            'nid_number' => $validated['nid_number'],
            'pin_number' => $validated['pin_number'] ?? null,
            'blood_group' => $validated['blood_group'] ?? null,
            'issue_date' => $validated['issue_date'],
            'address' => $validated['address'],
            'gender' => $validated['gender'],
        ]);

        if ($needsPresentBlock) {
            $nid->present_address = $validated['present_address'];
            $nid->spouse_name = $validated['spouse_name'] ?? null;
            $nid->education = $validated['education'] ?? null;
            $nid->religion = $validated['religion'] ?? null;
            $nid->occupation = $validated['occupation'] ?? null;
        }
        if ($needsCdmsOnly) {
            $nid->vote_center = $validated['vote_center'] ?? null;
            $nid->voter_no = $validated['voter_no'] ?? null;
            $nid->form_no = $validated['form_no'] ?? null;
        }

        $baseDir = 'nid_cards/'.$this->user->id;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store($baseDir.'/photos', 'public');
            $nid->photo = $path;
        }

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store($baseDir.'/signatures', 'public');
            $nid->signature = $path;
        }

        $nid->save();

        return redirect()->route('user.nid-card.index')->with('success', 'NID card updated successfully.');
    }

    public function destroy(int $id)
    {
        $nid = $this->nidForUser($id);
        $nid->delete();

        return redirect()->route('user.nid-card.index')->with('success', 'Record deleted.');
    }
}
