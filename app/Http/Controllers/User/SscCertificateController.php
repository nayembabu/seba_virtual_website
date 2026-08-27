<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SscCertificate;
use App\Models\ServiceCharge;
use App\Models\Transaction;
use App\Helpers\DateToWordsHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SscCertificateController extends Controller
{
    private function numberToWords($num)
    {
        $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        $teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        
        if ($num < 10) return $ones[$num];
        if ($num < 20) return $teens[$num - 10];
        if ($num < 100) return $tens[floor($num/10)] . ($num % 10 ? ' ' . $ones[$num % 10] : '');
        if ($num < 1000) return $ones[floor($num/100)] . ' Hundred' . ($num % 100 ? ' and ' . $this->numberToWords($num % 100) : '');
        return $this->numberToWords(floor($num/1000)) . ' Thousand' . ($num % 1000 ? ' ' . $this->numberToWords($num % 1000) : '');
    }
    // List all certificates
    public function index()
    {
        try {
            $title = 'SSC Certificate List';
            $objects = SscCertificate::where('user_id', auth()->id())->get();
            return view('user.ssc_certificate.index', compact('objects', 'title'));
        } catch (\Exception $e) {
            Log::error('Error fetching SSC certificates: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'error' => $e
            ]);
            return back()->with('error', 'সার্টিফিকেট তালিকা লোড করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
        }
    }

    // Show a single certificate
    public function show($id)
    {
        try {
            $ssc_certificate = SscCertificate::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
                
            return view('user.ssc_certificate.show', compact('ssc_certificate'));
        } catch (\Exception $e) {
            Log::error('Error showing SSC certificate: ' . $e->getMessage(), [
                'certificate_id' => $id,
                'user_id' => auth()->id(),
                'error' => $e
            ]);
            return back()->with('error', 'সার্টিফিকেট দেখাতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
        }
    }

    // Edit form
    public function edit($id)
    {
        try {
            $ssc_certificate = SscCertificate::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            return view('user.ssc_certificate.edit', compact('ssc_certificate'));
        } catch (\Exception $e) {
            Log::error('Error loading SSC certificate edit form: ' . $e->getMessage(), [
                'certificate_id' => $id,
                'user_id' => auth()->id(),
                'error' => $e
            ]);
            return back()->with('error', 'সার্টিফিকেট এডিট ফর্ম লোড করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
        }
    }

    // Update certificate
    public function update(Request $request, $id)
    {
        try {
            $ssc_certificate = SscCertificate::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $messages = [
                'dbcsc_no.required' => 'DBCSC নম্বর প্রয়োজন',
                'serial_no_dbs.required' => 'সিরিয়াল নম্বর প্রয়োজন',
                'registration_no.required' => 'রেজিস্ট্রেশন নম্বর প্রয়োজন',
                'registration_year.required' => 'রেজিস্ট্রেশন বছর প্রয়োজন',
                'registration_year.integer' => 'রেজিস্ট্রেশন বছর সঠিক নয়',
                'registration_year.min' => 'রেজিস্ট্রেশন বছর সঠিক নয়',
                'registration_year.max' => 'রেজিস্ট্রেশন বছর সঠিক নয়',
                'student_name.required' => 'শিক্ষার্থীর নাম প্রয়োজন',
                'father_name.required' => 'পিতার নাম প্রয়োজন',
                'mother_name.required' => 'মাতার নাম প্রয়োজন',
                'school_name.required' => 'স্কুলের নাম প্রয়োজন',
                'school_address.required' => 'স্কুলের ঠিকানা প্রয়োজন',
                'roll_no.required' => 'রোল নম্বর প্রয়োজন',
                'student_group.required' => 'গ্রুপ নির্বাচন করুন',
                'gpa.required' => 'জিপিএ প্রয়োজন',
                'gpa.numeric' => 'জিপিএ সঠিক নয়',
                'gpa.min' => 'জিপিএ ০ থেকে ৫ এর মধ্যে হতে হবে',
                'gpa.max' => 'জিপিএ ০ থেকে ৫ এর মধ্যে হতে হবে',
                'dob_day_month_words.required' => 'জন্ম তারিখ (দিন ও মাস) প্রয়োজন',
                'dob_year_words.required' => 'জন্ম বছর (কথায়) প্রয়োজন',
                'publication_date.required' => 'প্রকাশের তারিখ প্রয়োজন',
                'publication_date.integer' => 'প্রকাশের তারিখ সঠিক নয়',
                'publication_year.required' => 'প্রকাশের বছর প্রয়োজন',
                'publication_year.integer' => 'প্রকাশের বছর সঠিক নয়'
            ];

            $validated = $request->validate([
                'serial_no_dbs' => 'required|string|max:50',
                'registration_no' => 'required|string|max:50',
                'registration_year' => 'required|integer|min:1900|max:' . date('Y'),
                'dbcsc_no' => 'required|string|max:50',
                'student_name' => 'required|string|max:255',
                'father_name' => 'required|string|max:255',
                'mother_name' => 'required|string|max:255',
                'school_name' => 'required|string|max:255',
                'school_address' => 'required|string',
                'roll_no' => 'required|string|max:50',
                'student_group' => 'required|string|in:Science,Commerce,Arts',
                'gpa' => 'required|numeric|min:0|max:5',
                'dob' => 'required|date',
                'publication_date' => 'required|integer|min:1900|max:' . date('Y'),
                'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            ], $messages);

            // Convert date to words
            $dob = \Carbon\Carbon::parse($validated['dob']);
            $dayNames = [
                'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth',
                'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth',
                'Eighteenth', 'Nineteenth', 'Twentieth', 'Twenty-first', 'Twenty-second', 'Twenty-third',
                'Twenty-fourth', 'Twenty-fifth', 'Twenty-sixth', 'Twenty-seventh', 'Twenty-eighth',
                'Twenty-ninth', 'Thirtieth', 'Thirty-first'
            ];
            
            $monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            
            $validated['dob_day_month_words'] = $dayNames[$dob->day - 1] . ' ' . $monthNames[$dob->month - 1];
            $validated['dob_year_words'] = $this->numberToWords($dob->year);

            $ssc_certificate->update($validated);
            
            Log::info('SSC Certificate updated successfully', [
                'certificate_id' => $ssc_certificate->id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('user.ssc_certificate.index')
                ->with('success', 'এসএসসি সার্টিফিকেট সফলভাবে আপডেট করা হয়েছে।');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('SSC Certificate validation failed', [
                'user_id' => auth()->id(),
                'errors' => $e->errors()
            ]);
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating SSC certificate: ' . $e->getMessage(), [
                'certificate_id' => $sscCertificate->id,
                'user_id' => auth()->id(),
                'error' => $e
            ]);
            return back()->with('error', 'সার্টিফিকেট আপডেট করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
        }
    }

  public function destroy($id)
{
    try {
        Log::info('Attempting to delete certificate', [
            'certificate_id' => $id,
            'user_id' => auth()->id(),
            'request_method' => request()->method()
        ]);

        // Find certificate and verify ownership
        $ssc_certificate = SscCertificate::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $certificateDetails = [
            'id' => $ssc_certificate->id,
            'student_name' => $ssc_certificate->student_name,
            'user_id' => $ssc_certificate->user_id
        ];

        // Delete attempt
        $ssc_certificate->delete();

        Log::info('SSC Certificate deleted successfully', [
            'certificate' => $certificateDetails
        ]);

        // ✅ Return redirect with success message
        return redirect()->route('user.ssc_certificate.index')
                         ->with('success', 'এসএসসি সার্টিফিকেট সফলভাবে মুছে ফেলা হয়েছে।');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::error('Certificate not found or unauthorized', [
            'certificate_id' => $id,
            'user_id' => auth()->id(),
            'error' => $e->getMessage()
        ]);

        return redirect()->route('user.ssc_certificate.index')
                         ->with('error', 'সার্টিফিকেট খুঁজে পাওয়া যায়নি অথবা অনুমতি নেই।');

    } catch (\Exception $e) {
        Log::error('Error deleting SSC certificate', [
            'certificate_id' => $id,
            'user_id' => auth()->id(),
            'error' => $e->getMessage()
        ]);

        return redirect()->route('user.ssc_certificate.index')
                         ->with('error', 'সার্টিফিকেট মুছে ফেলতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
    }
}


    // Show the form
    public function create()
    {
        try {
            return view('user.ssc_certificate.create');
        } catch (\Exception $e) {
            Log::error('Error loading SSC certificate create form: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'error' => $e
            ]);
            return back()->with('error', 'সার্টিফিকেট তৈরির ফর্ম লোড করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
        }
    }

    // Store the form data
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $serviceCharge = ServiceCharge::where('service_name', 'certificate')->first();

            if (!$serviceCharge) {
                Log::warning('Service charge not configured for SSC certificate', [
                    'user_id' => auth()->id()
                ]);
                return back()->with('error', 'সার্ভিস চার্জ কনফিগার করা হয়নি।');
            }

            if ($user->balance < $serviceCharge->amount) {
                Log::info('Insufficient balance for SSC certificate creation', [
                    'user_id' => auth()->id(),
                    'balance' => $user->balance,
                    'required_amount' => $serviceCharge->amount
                ]);
                return back()->with('error', 'অপর্যাপ্ত ব্যালেন্স। অনুগ্রহ করে আপনার ব্যালেন্স রিচার্জ করুন।');
            }

            $messages = [
                'serial_no_dbs.required' => 'সিরিয়াল নম্বর প্রয়োজন',
                'registration_no.required' => 'রেজিস্ট্রেশন নম্বর প্রয়োজন',
                'registration_year.required' => 'রেজিস্ট্রেশন বছর প্রয়োজন',
                'dbcsc_no.required' => 'DBCSC নম্বর প্রয়োজন',
                'student_name.required' => 'শিক্ষার্থীর নাম প্রয়োজন',
                'father_name.required' => 'পিতার নাম প্রয়োজন',
                'mother_name.required' => 'মাতার নাম প্রয়োজন',
                'school_name.required' => 'স্কুলের নাম প্রয়োজন',
                'school_address.required' => 'স্কুলের ঠিকানা প্রয়োজন',
                'roll_no.required' => 'রোল নম্বর প্রয়োজন',
                'student_group.required' => 'গ্রুপ নির্বাচন করুন',
                'gpa.required' => 'জিপিএ প্রয়োজন',
                'gpa.numeric' => 'জিপিএ সঠিক নয়',
                'gpa.min' => 'জিপিএ ০ থেকে ৫ এর মধ্যে হতে হবে',
                'gpa.max' => 'জিপিএ ০ থেকে ৫ এর মধ্যে হতে হবে',
                'dob.required' => 'জন্ম তারিখ প্রয়োজন',
                'publication_date.required' => 'প্রকাশের তারিখ প্রয়োজন',
                'publication_year.required' => 'প্রকাশের বছর প্রয়োজন'
            ];

            $validated = $request->validate([
                'serial_no_dbs' => 'required|string|max:50',
                'registration_no' => 'required|string|max:50',
                'registration_year' => 'required|integer|min:1900|max:' . date('Y'),
                'dbcsc_no' => 'required|string|max:50',
                'student_name' => 'required|string|max:255',
                'father_name' => 'required|string|max:255',
                'mother_name' => 'required|string|max:255',
                'school_name' => 'required|string|max:255',
                'school_address' => 'required|string',
                'roll_no' => 'required|string|max:50',
                'student_group' => 'required|string|in:Science,Commerce,Arts',
                'gpa' => 'required|numeric|min:0|max:5',
                'dob' => 'required|date',
                'publication_date' => 'required|integer|min:1900|max:' . date('Y'),
                'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            ], $messages);

            // Convert date to words
            $dob = \Carbon\Carbon::parse($validated['dob']);
            $dayNames = [
                'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth',
                'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth',
                'Eighteenth', 'Nineteenth', 'Twentieth', 'Twenty-first', 'Twenty-second', 'Twenty-third',
                'Twenty-fourth', 'Twenty-fifth', 'Twenty-sixth', 'Twenty-seventh', 'Twenty-eighth',
                'Twenty-ninth', 'Thirtieth', 'Thirty-first'
            ];
            
            $monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            
            $validated['dob_day_month_words'] = $dayNames[$dob->day - 1] . ' ' . $monthNames[$dob->month - 1];
            $validated['dob_year_words'] = $this->numberToWords($dob->year);

            \DB::beginTransaction();

            try {
                $validated['user_id'] = auth()->id();
                $certificate = SscCertificate::create($validated);

                // Deduct the service charge from user's balance
                $user->balance -= $serviceCharge->amount;
                $user->save();

                // Create transaction record
                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => -$serviceCharge->amount,
                    'details' => 'এসএসসি সার্টিফিকেট সার্ভিস চার্জ',
                    'trx' => uniqid('TRX'),
                ]);
                
                \DB::commit();

                Log::info('SSC Certificate created successfully', [
                    'certificate_id' => $certificate->id,
                    'user_id' => auth()->id(),
                    'amount_charged' => $serviceCharge->amount
                ]);

                return redirect()->route('user.ssc_certificate.index')
                    ->with('success', 'এসএসসি সার্টিফিকেট তথ্য সফলভাবে জমা দেওয়া হয়েছে।');

            } catch (\Exception $e) {
                \DB::rollback();
                Log::error('Error in SSC certificate creation transaction: ' . $e->getMessage(), [
                    'user_id' => auth()->id(),
                    'error' => $e,
                    'request_data' => $request->except(['_token'])
                ]);
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('SSC Certificate validation failed', [
                'user_id' => auth()->id(),
                'errors' => $e->errors()
            ]);
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error in SSC certificate creation: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'error' => $e
            ]);
            return back()
                ->with('error', 'একটি অপ্রত্যাশিত ত্রুটি ঘটেছে। অনুগ্রহ করে আবার চেষ্টা করুন।')
                ->withInput();
        }
    }
}