@extends('user.layouts.app')
@section('title') @lang('সকল প্রত্যয়ন') @endsection
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body { font-family: 'SolaimanLipi', 'NotoSansBengali', sans-serif !important; background: #f8fafc; }
.card-official { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
.section-title { background: linear-gradient(135deg, #4f46e5, #3730a3); color: #fff; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 16px; margin-bottom: 18px; }
.form-label { font-weight: 600; color: #1e293b; font-size: 13px; }
.form-control, .form-select { border-radius: 8px; padding: 8px 12px; border: 1px solid #d1d5db; font-size: 14px; }
.form-control:focus, .form-select:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.15); }
.submit-btn { background: linear-gradient(135deg, #4f46e5, #3730a3); border: none; padding: 14px 40px; font-size: 18px; border-radius: 12px; color: #fff; font-weight: 700; box-shadow: 0 6px 20px rgba(79,70,229,0.3); }
.submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79,70,229,0.4); }
.table-wrap { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; overflow-x: auto; padding: 20px; margin-top: 24px; }
.data-table { width: 100%; border-collapse: collapse; min-width: 650px; }
.data-table th { background: #f8fafc; padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; }
.data-table td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid #f1f5f9; color: #334155; }
.badge-success { background: #dcfce7; color: #16a34a; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; }
</style>
@endpush
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0" style="color:#1e293b;">📜 সকল প্রত্যয়ন সনদপত্র</h3>
        <span class="badge bg-danger fs-6 px-4 py-2">সার্ভিস ফি: ৳১৫০.০০</span>
    </div>

    <div class="card card-official p-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span></span>
            <button type="button" class="btn btn-info" onclick="autoFillForm()">
                <i class="fas fa-magic"></i> অটো ফিল
            </button>
        </div>
        <form id="certForm" method="POST">
            @csrf
            <input type="hidden" name="certificate_no" id="certificate_no" value="{{ $certificate_no }}">
            <input type="hidden" name="issue_date" value="{{ date('Y-m-d') }}">

            <div class="section-title">১। অফিসিয়াল তথ্য</div>
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">কার্যালয়ের ধরন</label>
                    <select name="office_type" class="form-select">
                        <option value="ইউনিয়ন পরিষদ">ইউনিয়ন পরিষদ</option>
                        <option value="পৌরসভা">পৌরসভা</option>
                        <option value="সিটি কর্পোরেশন">সিটি কর্পোরেশন</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">ওয়ার্ড/ইউপি নং</label>
                    <input type="text" name="union_no" class="form-control" placeholder="০১">
                </div>
                <div class="col-md-4">
                    <label class="form-label">ইউনিয়ন/পৌরসভার নাম</label>
                    <input type="text" name="union_name" class="form-control" placeholder="যেমন: দুর্গাপুর দক্ষিণ ইউনিয়ন">
                </div>
                <div class="col-md-3">
                    <label class="form-label">উপজেলা ও জেলা</label>
                    <input type="text" name="upazila" class="form-control" placeholder="যেমন: কুমিল্লা আদর্শ সদর">
                </div>
            </div>

            <div class="section-title">২। সনদের বিবরণ</div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label required-field">সনদের ধরন</label>
                    <select name="cert_type" id="cert_type" class="form-select" required>
                        <option value="national">জাতীয়তা সনদপত্র</option>
                        <option value="warisan">ওয়ারিশ সনদপত্র</option>
                        <option value="character">চারিত্রিক সনদপত্র</option>
                        <option value="family">পারিবারিক সনদপত্র</option>
                        <option value="unmarried">অবিবাহিত সনদপত্র</option>
                        <option value="landless">ভূমিহীন সনদপত্র</option>
                        <option value="income">বার্ষিক আয় সনদপত্র</option>
                        <option value="remarriage">পুনর্বিবাহ না হওয়া সনদপত্র</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">ভাষা</label>
                    <select name="language" class="form-select">
                        <option value="bn">বাংলা</option>
                        <option value="en">English</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">সনদ নম্বর</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ $certificate_no }}" disabled>
                        <button type="button" class="btn btn-outline-primary" onclick="generateCertNo()">নতুন</button>
                    </div>
                </div>
            </div>

            <div class="section-title">৩। নাগরিকের তথ্য</div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label required-field">আবেদনকারীর নাম</label>
                    <input type="text" name="applicant_name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label required-field">এনআইডি / জন্ম নম্বর</label>
                    <input type="text" name="nid_no" class="form-control" required>
                </div>
                <div class="col-md-4" id="income_field_wrapper" style="display:none;">
                    <label class="form-label">বার্ষিক আয়ের পরিমাণ</label>
                    <input type="text" name="income_amount" class="form-control" placeholder="যেমন: ১,২০,০০০/-">
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">পিতার নাম</label>
                    <input type="text" name="father_name" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">মাতার নাম</label>
                    <input type="text" name="mother_name" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">স্বামী/স্ত্রীর নাম</label>
                    <input type="text" name="spouse_name" class="form-control">
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">গ্রাম / মহল্লা</label>
                    <input type="text" name="present_village" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">ডাকঘর</label>
                    <input type="text" name="present_post" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">উপজেলা</label>
                    <input type="text" name="present_upazila" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">জেলা</label>
                    <input type="text" name="present_district" class="form-control">
                </div>
            </div>

            <div id="members_wrapper" class="p-3 border rounded bg-light mb-4" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">👨‍👩‍👧‍👦 ওয়ারিশ / পারিবারিক সদস্যদের তালিকা</h6>
                    <button type="button" class="btn btn-sm btn-success" onclick="addMember()">＋ নতুন সদস্য</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered bg-white" id="members_table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>নাম</th>
                                <th>সম্পর্ক</th>
                                <th>বয়স</th>
                                <th>এনআইডি</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody id="members_body">
                            <tr>
                                <td class="text-center idx">1</td>
                                <td><input type="text" name="member_name[]" class="form-control form-control-sm" placeholder="নাম"></td>
                                <td><input type="text" name="member_relation[]" class="form-control form-control-sm" placeholder="সম্পর্ক"></td>
                                <td><input type="text" name="member_age[]" class="form-control form-control-sm" placeholder="বয়স"></td>
                                <td><input type="text" name="member_nid[]" class="form-control form-control-sm" placeholder="এনআইডি"></td>
                                <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeMember(this)">✖</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section-title">৪। প্রস্তুতকারী ও অনুমোদনকারী</div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">প্রস্তুতকারীর নাম (বাংলা)</label>
                    <input type="text" name="prepared_by" class="form-control" placeholder="যেমন: কে. এম. রফিকুল ইসলাম">
                    <label class="form-label mt-2">প্রস্তুতকারীর ইংরেজি সিল</label>
                    <textarea name="prepared_seal_en" class="form-control" rows="2" placeholder="K. M. ROFIQUL ISLAM&#10;UP SECRETARY&#10;UNION PARISHAD"></textarea>
                </div>
                <div class="col-md-6">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">অনুমোদনকারীর পদবী</label>
                            <select name="authority_title" class="form-select">
                                <option value="চেয়ারম্যান">চেয়ারম্যান</option>
                                <option value="কাউন্সিলর">কাউন্সিলর</option>
                                <option value="মেয়র">মেয়র</option>
                                <option value="প্রশাসক">প্রশাসক</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">অনুমোদনকারীর নাম</label>
                            <input type="text" name="authority_name" class="form-control" placeholder="যেমন: মোঃ আলী আশ্রাফ">
                        </div>
                    </div>
                    <label class="form-label mt-2">চেয়ারম্যানের ইংরেজি সিল</label>
                    <textarea name="authority_seal_en" class="form-control" rows="2" placeholder="MD. ALI ASHRAF&#10;CHAIRMAN&#10;UNION PARISHAD"></textarea>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="submit-btn" id="submitBtn">
                    <span class="spinner-border spinner-border-sm d-none me-2"></span>
                    💾 ৳১৫০ কেটে পিডিএফ ডাউনলোড করুন
                </button>
            </div>
        </form>
    </div>

    <div class="table-wrap">
        <h5 class="mb-3" style="color:#1e293b;">📋 জমা দেওয়া সনদপত্রসমূহ</h5>
        <table class="data-table">
            <thead>
                <tr>
                    <th>সনদ নং</th>
                    <th>ধরন</th>
                    <th>নাম</th>
                    <th>ইস্যু তারিখ</th>
                    <th>স্ট্যাটাস</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr>
                    <td>{{ $app->certificate_no }}</td>
                    <td>{{ $app->cert_type }}</td>
                    <td>{{ $app->applicant_name }}</td>
                    <td>{{ $app->issue_date->format('d M, Y') }}</td>
                    <td><span class="badge-success">{{ $app->status }}</span></td>
                    <td>
                        <a href="{{ route('user.certificate.download', $app->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-download"></i> PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:30px;color:#94a3b8;">কোনো সনদপত্র নেই</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">{{ $applications->links() }}</div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    $('#cert_type').on('change', function(){
        var v = $(this).val();
        $('#income_field_wrapper').toggle(v === 'income');
        $('#members_wrapper').toggle(v === 'warisan' || v === 'family');
    });
    $('#certForm').on('submit', function(e){
        e.preventDefault();
        var valid = true;
        $(this).find('[required]').each(function(){
            if(!$(this).val().trim()){ $(this).addClass('is-invalid'); valid=false; }
            else { $(this).removeClass('is-invalid'); }
        });
        if(!valid){ Swal.fire({icon:'error',title:'ত্রুটি!',text:'সব আবশ্যক ফিল্ড পূরণ করুন'}); return; }
        Swal.fire({
            title:'নিশ্চিত করুন',
            html:'আপনি কি ৳১৫০ কেটে সনদপত্র তৈরি করতে চান?',
            icon:'question',
            showCancelButton:true,
            confirmButtonColor:'#4f46e5',
            cancelButtonColor:'#6c757d',
            confirmButtonText:'হ্যাঁ, তৈরি করুন',
            cancelButtonText:'বাতিল'
        }).then(function(r){
            if(r.isConfirmed){
                var btn=$('#submitBtn');
                btn.prop('disabled',true).find('.spinner-border').removeClass('d-none');
                btn.find('.spinner-border').after(' তৈরি হচ্ছে...');
                $.ajax({
                    url: '{{ route("user.certificate.submit") }}',
                    type:'POST',
                    data: new FormData(e.target),
                    dataType:'json',
                    contentType:false,
                    processData:false,
                    headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
                    success:function(resp){
                        if(resp.status==='success'){
                            Swal.fire({icon:'success',title:'সফল!',text:'সনদপত্র তৈরি হচ্ছে...'});
                            if(resp.redirect) window.location.href = resp.redirect;
                        } else {
                            Swal.fire({icon:'error',title:'ত্রুটি!',text:resp.message});
                        }
                    },
                    error:function(){
                        Swal.fire({icon:'error',title:'সার্ভার ত্রুটি',text:'সার্ভারে সমস্যা হয়েছে'});
                    },
                    complete:function(){
                        btn.prop('disabled',false).find('.spinner-border').addClass('d-none');
                        btn.html('💾 ৳১৫০ কেটে পিডিএফ ডাউনলোড করুন');
                    }
                });
            }
        });
    });
});
window.autoFillForm = function(){
    $('select[name="office_type"]').val('ইউনিয়ন পরিষদ');
    $('input[name="union_no"]').val('০১');
    $('input[name="union_name"]').val('দুর্গাপুর দক্ষিণ ইউনিয়ন');
    $('input[name="upazila"]').val('কুমিল্লা আদর্শ সদর');
    $('select[name="cert_type"]').val('national');
    $('select[name="language"]').val('bn');
    $('input[name="applicant_name"]').val('মোঃ আব্দুর রহমান');
    $('input[name="nid_no"]').val('১২৩৪৫৬৭৮৯০');
    $('input[name="father_name"]').val('মোঃ আব্দুল করিম');
    $('input[name="mother_name"]').val('মোছাঃ রহিমা খাতুন');
    $('input[name="spouse_name"]').val('মোছাঃ ফাতেমা বেগম');
    $('input[name="present_village"]').val('পূর্ব মধ্যপাড়া');
    $('input[name="present_post"]').val('দুর্গাপুর');
    $('input[name="present_upazila"]').val('কুমিল্লা আদর্শ সদর');
    $('input[name="present_district"]').val('কুমিল্লা');
    $('input[name="prepared_by"]').val('কে. এম. রফিকুল ইসলাম');
    $('textarea[name="prepared_seal_en"]').val('K. M. ROFIQUL ISLAM\nUP SECRETARY\nUNION PARISHAD');
    $('select[name="authority_title"]').val('চেয়ারম্যান');
    $('input[name="authority_name"]').val('মোঃ আলী আশ্রাফ');
    $('textarea[name="authority_seal_en"]').val('MD. ALI ASHRAF\nCHAIRMAN\nUNION PARISHAD');
    generateCertNo();
    Swal.fire({icon:'success',title:'অটো ফিল সম্পন্ন!',text:'সব ফিল্ড পূরণ করা হয়েছে',timer:1500,showConfirmButton:false});
};
window.generateCertNo = function(){
    $.get('{{ route("user.certificate.generate") }}', function(d){
        if(d.success) { $('#certificate_no').val(d.certificate_no); }
    });
};
function addMember(){
    var i=$('#members_body tr').length+1;
    $('#members_body').append('<tr><td class="text-center idx">'+i+'</td><td><input type="text" name="member_name[]" class="form-control form-control-sm"></td><td><input type="text" name="member_relation[]" class="form-control form-control-sm"></td><td><input type="text" name="member_age[]" class="form-control form-control-sm"></td><td><input type="text" name="member_nid[]" class="form-control form-control-sm"></td><td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeMember(this)">✖</button></td></tr>');
}
function removeMember(btn){
    if($('#members_body tr').length>1){ $(btn).closest('tr').remove(); $('#members_body tr').each(function(i){$(this).find('.idx').text(i+1);}); }
    else { Swal.fire({icon:'warning',text:'সর্বনিম্ন একজন সদস্য থাকতে হবে'}); }
}
</script>
@endsection
