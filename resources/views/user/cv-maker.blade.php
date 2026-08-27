@extends('user.layouts.app')
@section('title') সিভি মেক @endsection


@if(isset($editCv))
<script>
var editCv = @json($editCv);
document.addEventListener('DOMContentLoaded', function() {
    if (!editCv) return;
    var fields = ['name','title','email','phone','address','linkedin','father_name','mother_name','dob','blood_group','religion','marital_status','nid','objective','skills','hobbies'];
    fields.forEach(function(f) {
        if (editCv[f]) {
            var inp = document.querySelector('input[name="'+f+'"], textarea[name="'+f+'"]');
            if (inp) inp.value = editCv[f];
        }
    });
    if (editCv.cv_type) {
        var radio = document.querySelector('input[name="cv_type"][value="'+editCv.cv_type+'"]');
        if (radio) radio.checked = true;
    }
    if (editCv.education && editCv.education.length > 0) {
        var wrapper = document.getElementById('edu_wrapper');
        if (wrapper) wrapper.innerHTML = '';
        editCv.education.forEach(function(edu, i) {
            var isReg = editCv.cv_type === 'bd_popular' ? 'block' : 'none';
            var html = '<div class="dynamic-row"><i class="fas fa-times remove-btn" onclick="this.parentElement.remove()"></i><div class="row g-3">' +
                '<div class="col-md-3"><input type="text" name="edu_degree[]" list="degree_list" class="form-control" placeholder="ডিগ্রি" value="' + (edu.degree||'') + '"></div>' +
                '<div class="col-md-4"><input type="text" name="edu_institute[]" class="form-control" placeholder="প্রতিষ্ঠান" value="' + (edu.institute||'') + '"></div>' +
                '<div class="col-md-2"><input type="text" name="edu_year[]" class="form-control" placeholder="সাল" value="' + (edu.year||'') + '"></div>' +
                '<div class="col-md-3"><input type="text" name="edu_cgpa[]" class="form-control" placeholder="CGPA" value="' + (edu.cgpa||'') + '"></div>' +
                '<div class="col-md-6 req-regular" style="display:' + isReg + '"><input type="text" name="edu_board[]" class="form-control" placeholder="বোর্ড" value="' + (edu.board||'') + '"></div>' +
                '<div class="col-md-6 req-regular" style="display:' + isReg + '"><input type="text" name="edu_group[]" list="group_list" class="form-control" placeholder="গ্রুপ" value="' + (edu.group||'') + '"></div>' +
                '</div></div>';
            if (wrapper) wrapper.insertAdjacentHTML('beforeend', html);
            if (i === 0 && wrapper) wrapper.innerHTML = html; // replace first dummy
        });
    }
    if (editCv.experience && editCv.experience.length > 0) {
        var wrapper = document.getElementById('exp_wrapper');
        if (wrapper) wrapper.innerHTML = '';
        editCv.experience.forEach(function(exp) {
            var html = '<div class="dynamic-row"><i class="fas fa-times remove-btn" onclick="this.parentElement.remove()"></i><div class="row g-3">' +
                '<div class="col-md-4"><input type="text" name="exp_role[]" class="form-control" placeholder="পদের নাম" value="' + (exp.role||'') + '"></div>' +
                '<div class="col-md-5"><input type="text" name="exp_company[]" class="form-control" placeholder="কোম্পানি" value="' + (exp.company||'') + '"></div>' +
                '<div class="col-md-3"><input type="text" name="exp_duration[]" class="form-control" placeholder="সময়কাল" value="' + (exp.duration||'') + '"></div>' +
                '</div></div>';
            if (wrapper) wrapper.insertAdjacentHTML('beforeend', html);
        });
    }
    if (editCv.references && editCv.references.length > 0) {
        var wrapper = document.getElementById('ref_wrapper');
        if (wrapper) wrapper.innerHTML = '';
        editCv.references.forEach(function(ref) {
            var html = '<div class="dynamic-row"><i class="fas fa-times remove-btn" onclick="this.parentElement.remove()"></i><div class="row g-3">' +
                '<div class="col-md-3"><input type="text" name="ref_name[]" class="form-control" placeholder="Name" value="' + (ref.name||'') + '"></div>' +
                '<div class="col-md-3"><input type="text" name="ref_designation[]" class="form-control" placeholder="Designation" value="' + (ref.designation||'') + '"></div>' +
                '<div class="col-md-3"><input type="text" name="ref_company[]" class="form-control" placeholder="Company" value="' + (ref.company||'') + '"></div>' +
                '<div class="col-md-3"><input type="text" name="ref_contact[]" class="form-control" placeholder="Contact" value="' + (ref.contact||'') + '"></div>' +
                '</div></div>';
            if (wrapper) wrapper.insertAdjacentHTML('beforeend', html);
        });
    }
    toggleLayout();
});
</script>
@endif

@if(isset($previewData) && count($previewData) > 0)
<script>
var previewData = @json($previewData);
document.addEventListener('DOMContentLoaded', function() {
    if (!previewData) return;
    var fields = ['name','title','email','phone','address','father_name','mother_name','dob','blood_group','religion','marital_status','nid','objective','skills','hobbies'];
    fields.forEach(function(f) {
        if (previewData[f]) {
            var inp = document.querySelector('input[name="'+f+'"], textarea[name="'+f+'"]');
            if (inp) inp.value = previewData[f];
        }
    });
    if (previewData.cv_type) {
        var radio = document.querySelector('input[name="cv_type"][value="'+previewData.cv_type+'"]');
        if (radio) radio.checked = true;
    }
    // Education
    if (previewData.education && previewData.education.length > 0) {
        var wrapper = document.getElementById('edu_wrapper');
        if (wrapper) wrapper.innerHTML = '';
        previewData.education.forEach(function(edu) {
            var isReg = previewData.cv_type === 'bd_popular' ? 'block' : 'none';
            var html = '<div class="dynamic-row"><i class="fas fa-times remove-btn" onclick="this.parentElement.remove()"></i><div class="row g-3">' +
                '<div class="col-md-3"><input type="text" name="edu_degree[]" list="degree_list" class="form-control" placeholder="\u09a1\u09bf\u0997\u09cd\u09b0\u09bf" value="' + (edu.degree||'') + '"></div>' +
                '<div class="col-md-4"><input type="text" name="edu_institute[]" class="form-control" placeholder="\u09aa\u09cd\u09b0\u09a4\u09bf\u09b7\u09cd\u09a0\u09be\u09a8" value="' + (edu.institute||'') + '"></div>' +
                '<div class="col-md-2"><input type="text" name="edu_year[]" class="form-control" placeholder="\u09b8\u09be\u09b2" value="' + (edu.year||'') + '"></div>' +
                '<div class="col-md-3"><input type="text" name="edu_cgpa[]" class="form-control" placeholder="CGPA" value="' + (edu.cgpa||'') + '"></div>' +
                '<div class="col-md-6 req-regular" style="display:' + isReg + '"><input type="text" name="edu_board[]" class="form-control" placeholder="\u09ac\u09cb\u09b0\u09cd\u09a1" value="' + (edu.board||'') + '"></div>' +
                '<div class="col-md-6 req-regular" style="display:' + isReg + '"><input type="text" name="edu_group[]" list="group_list" class="form-control" placeholder="\u0997\u09cd\u09b0\u09c1\u09aa" value="' + (edu.group||'') + '"></div>' +
                '</div></div>';
            if (wrapper) wrapper.insertAdjacentHTML('beforeend', html);
        });
    }
    // Experience
    if (previewData.experience && previewData.experience.length > 0) {
        var wrapper = document.getElementById('exp_wrapper');
        if (wrapper) wrapper.innerHTML = '';
        previewData.experience.forEach(function(exp) {
            var html = '<div class="dynamic-row"><i class="fas fa-times remove-btn" onclick="this.parentElement.remove()"></i><div class="row g-3">' +
                '<div class="col-md-4"><input type="text" name="exp_role[]" class="form-control" placeholder="\u09aa\u09a6\u09c7\u09b0 \u09a8\u09be\u09ae" value="' + (exp.role||'') + '"></div>' +
                '<div class="col-md-5"><input type="text" name="exp_company[]" class="form-control" placeholder="\u0995\u09cb\u09ae\u09cd\u09aa\u09be\u09a8\u09bf" value="' + (exp.company||'') + '"></div>' +
                '<div class="col-md-3"><input type="text" name="exp_duration[]" class="form-control" placeholder="\u09b8\u09ae\u09af\u09bc\u0995\u09be\u09b2" value="' + (exp.duration||'') + '"></div>' +
                '</div></div>';
            if (wrapper) wrapper.insertAdjacentHTML('beforeend', html);
        });
    }
    // References
    if (previewData.references && previewData.references.length > 0) {
        var wrapper = document.getElementById('ref_wrapper');
        if (wrapper) wrapper.innerHTML = '';
        previewData.references.forEach(function(ref) {
            var html = '<div class="dynamic-row"><i class="fas fa-times remove-btn" onclick="this.parentElement.remove()"></i><div class="row g-3">' +
                '<div class="col-md-3"><input type="text" name="ref_name[]" class="form-control" placeholder="Name" value="' + (ref.name||'') + '"></div>' +
                '<div class="col-md-3"><input type="text" name="ref_designation[]" class="form-control" placeholder="Designation" value="' + (ref.designation||'') + '"></div>' +
                '<div class="col-md-3"><input type="text" name="ref_company[]" class="form-control" placeholder="Company" value="' + (ref.company||'') + '"></div>' +
                '<div class="col-md-3"><input type="text" name="ref_contact[]" class="form-control" placeholder="Contact" value="' + (ref.contact||'') + '"></div>' +
                '</div></div>';
            if (wrapper) wrapper.insertAdjacentHTML('beforeend', html);
        });
    }
});
</script>
@endif

<script>
var userProfile = {
    name: '{!! str_replace(["'","\\"], ["\\'","\\\\"], $user->name ?? '') !!}',
    email: '{!! str_replace(["'","\\"], ["\\'","\\\\"], $user->email ?? '') !!}',
    phone: '{!! str_replace(["'","\\"], ["\\'","\\\\"], $user->phone ?? '') !!}',
    dob: '{!! str_replace(["'","\\"], ["\\'","\\\\"], $user->dob ?? '') !!}',
    nid: '{!! str_replace(["'","\\"], ["\\'","\\\\"], $user->nid ?? '') !!}'
};
function autoFillUserData() {
    var map = {name:'name', email:'email', phone:'phone', dob:'dob', nid:'nid'};
    for (var key in map) {
        if (userProfile[key]) {
            var inp = document.querySelector('input[name="'+map[key]+'"]');
            if (inp) inp.value = userProfile[key];
        }
    }
}
</script>

@push('css')
<style>
    .card-header-custom { background: #0f172a; color: #fff; border-radius: 8px 8px 0 0; padding: 15px 20px; border-bottom: 3px solid #ffdbd0; }
    .type-card { border: 2px solid #cbd5e1; border-radius: 12px; padding: 20px 15px; cursor: pointer; transition: all 0.3s ease; background: #fff; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05); height: 100%; display: flex; flex-direction: column; justify-content: center; }
    .type-card:hover { border-color: #0f172a; box-shadow: 0 8px 20px rgba(15, 23, 42, 0.15); transform: translateY(-4px); }
    .type-card i { color: #64748b; transition: 0.3s; }
    input[type="radio"]:checked + .type-card { border-color: #0f172a; background: #0f172a; color: white; }
    input[type="radio"]:checked + .type-card h5, input[type="radio"]:checked + .type-card small { color: #fff !important; }
    input[type="radio"]:checked + .type-card i { color: #ffdbd0 !important; }
    .req-regular { display: none; }
    .section-title { color: #0f172a; border-bottom: 2px solid #ffdbd0; padding-bottom: 5px; margin: 30px 0 18px 0; font-weight: bold; display: flex; justify-content: space-between; align-items: center; font-size: 1.1rem; }
    .dynamic-row { background: #f8fafc; padding: 18px; border-radius: 8px; border: 1px dashed #94a3b8; margin-bottom: 12px; position: relative; transition: 0.3s; }
    .dynamic-row:hover { border-color: #0f172a; }
    .remove-btn { position: absolute; top: 12px; right: 12px; color: #ef4444; cursor: pointer; font-size: 18px; transition: 0.2s; }
    .remove-btn:hover { color: #b91c1c; transform: scale(1.1); }
    .obj-btn { font-size: 13px; padding: 6px 15px; margin: 0 4px 8px 0; border-radius: 20px; font-weight: 600; border: 1px solid #0f172a; color: #0f172a; background: transparent; transition: 0.3s; }
    .obj-btn:hover { background: #0f172a; color: #ffdbd0; }
    .btn-submit-cv { background: #0f172a; color: #fff; border: none; transition: 0.3s; font-weight: bold; font-size: 1.1rem; padding: 12px 30px; border-radius: 30px; }
    .btn-submit-cv:hover { background: #1e293b; color: #ffdbd0; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(15, 23, 42, 0.3); }
    .form-control, .form-select { border: 1px solid #cbd5e1; }
    .form-control:focus, .form-select:focus { border-color: #0f172a; box-shadow: 0 0 0 0.2rem rgba(15, 23, 42, 0.1); }
</style>
@endpush

@section('content')
<datalist id="title_list"><option value="Software Engineer"><option value="Teacher"><option value="Graphic Designer"><option value="Accountant"><option value="Civil Engineer"><option value="Marketing Executive"></datalist>
<datalist id="blood_list"><option value="A+"><option value="A-"><option value="B+"><option value="B-"><option value="O+"><option value="O-"><option value="AB+"><option value="AB-"></datalist>
<datalist id="religion_list"><option value="Islam"><option value="Hinduism"><option value="Buddhism"><option value="Christianity"></datalist>
<datalist id="marital_list"><option value="Single"><option value="Married"><option value="Divorced"></datalist>
<datalist id="degree_list"><option value="SSC"><option value="HSC"><option value="B.Sc"><option value="B.A"><option value="BBA"><option value="M.Sc"><option value="MBA"><option value="Diploma"></datalist>
<datalist id="group_list"><option value="Science"><option value="Humanities"><option value="Business Studies"><option value="CSE"><option value="Accounting"><option value="English"></datalist>

<div class="container-fluid">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <span class="fs-5 fw-bold"><i class="fas fa-file-user me-2"></i>অ্যাডভান্সড সিভি মেকার</span>
            <span class="badge bg-light text-dark fs-6 rounded-pill px-3 py-2 shadow-sm">সার্ভিস চার্জ: ৳{{ $charge ?? 0 }}</span>
        </div>

        <div class="card-body p-4 p-md-5">
            <form action="{{ isset($editCv) ? route('user.cv-maker.update', $editCv->id) : route('user.cv-maker.store') }}" method="POST" enctype="multipart/form-data" id="cvForm">
                @csrf
                @if(isset($editCv)) @method('PUT') @endif
                <input type="hidden" name="generate_cv" value="1">

                <div class="text-center mb-4 pb-2 border-bottom">
                    <h4 class="fw-bold mb-1"><i class="fas fa-plus-circle me-2" style="color:var(--cv-theme,#2563eb);"></i>নতুন সিভি তৈরি করুন</h4>
                </div>

                <div class="row justify-content-center mb-4 g-3">
                    <div class="col-md-5 col-sm-6">
                        <label class="w-100 h-100">
                            <input type="radio" name="cv_type" value="professional" class="d-none" onchange="toggleLayout()" checked>
                            <div class="type-card">
                                <i class="fab fa-linkedin fa-2x mb-3"></i>
                                <h5 class="fw-bold mb-1">প্রফেশনাল সিভি</h5>
                                <small class="text-muted">LinkedIn Standard, 1-2 Page</small>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-5 col-sm-6">
                        <label class="w-100 h-100">
                            <input type="radio" name="cv_type" value="bd_popular" class="d-none" onchange="toggleLayout()">
                            <div class="type-card">
                                <i class="fas fa-table fa-2x mb-3"></i>
                                <h5 class="fw-bold mb-1">বিডি পপুলার সিভি</h5>
                                <small class="text-muted">Table Format, Detailed Bio</small>
                            </div>
                        </label>
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;"><h5 class="section-title mb-0">ব্যক্তিগত তথ্য (Personal Info)</h5><button type="button" class="btn btn-sm btn-warning fw-bold" onclick="autoFillUserData()" style="border-radius:20px;"><i class="fas fa-magic me-1"></i> অটো ফিল</button></div>
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label fw-bold">পূর্ণ নাম (English)</label><input type="text" name="name" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label fw-bold">পেশা / পদবি</label><input type="text" name="title" list="title_list" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">ছবি (ঐচ্ছিক)</label><input type="file" name="profile_photo" class="form-control" accept="image/png, image/jpeg"><input type="hidden" name="sections[]" value="photo"></div>

                    <div class="col-md-3"><label class="form-label fw-bold">ইমেইল</label><input type="email" name="email" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label fw-bold">মোবাইল</label><input type="text" name="phone" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label fw-bold">ঠিকানা</label><input type="text" name="address" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label fw-bold">LinkedIn / URL</label><input type="text" name="linkedin" class="form-control"></div>

                    <div class="col-md-4 req-regular"><label class="form-label fw-bold">পিতার নাম</label><input type="text" name="father_name" class="form-control"></div>
                    <div class="col-md-4 req-regular"><label class="form-label fw-bold">মাতার নাম</label><input type="text" name="mother_name" class="form-control"></div>
                    <div class="col-md-4 req-regular"><label class="form-label fw-bold">জন্ম তারিখ</label><input type="text" name="dob" class="form-control" placeholder="DD/MM/YYYY"></div>
                    <div class="col-md-3 req-regular"><label class="form-label fw-bold">রক্তের গ্রুপ</label><input type="text" name="blood_group" list="blood_list" class="form-control"></div>
                    <div class="col-md-3 req-regular"><label class="form-label fw-bold">ধর্ম</label><input type="text" name="religion" list="religion_list" class="form-control"></div>
                    <div class="col-md-3 req-regular"><label class="form-label fw-bold">বৈবাহিক অবস্থা</label><input type="text" name="marital_status" list="marital_list" class="form-control"></div>
                    <div class="col-md-3 req-regular"><label class="form-label fw-bold">NID / পাসপোর্ট নং</label><input type="text" name="nid" class="form-control"></div>
                </div>

                <h5 class="section-title">
                    ক্যারিয়ার অবজেক্টিভ (Career Objective)
                    <div class="form-check form-switch fs-6 m-0"><input class="form-check-input" type="checkbox" name="sections[]" value="objective" checked></div>
                </h5>
                <div class="mb-2">
                    <button type="button" class="obj-btn" onclick="setObj(1)">Fresher Template</button>
                    <button type="button" class="obj-btn" onclick="setObj(2)">Experienced Template</button>
                    <button type="button" class="obj-btn" onclick="setObj(3)">Creative Template</button>
                </div>
                <textarea name="objective" id="obj_box" class="form-control" rows="4" placeholder="Write or select a smart template..."></textarea>

                <h5 class="section-title">
                    শিক্ষাগত যোগ্যতা (Education)
                    <div class="form-check form-switch fs-6 m-0"><input class="form-check-input" type="checkbox" name="sections[]" value="education" checked></div>
                </h5>
                <div id="edu_wrapper">
                    <div class="dynamic-row">
                        <div class="row g-3">
                            <div class="col-md-3"><input type="text" name="edu_degree[]" list="degree_list" class="form-control" placeholder="ডিগ্রি (e.g. B.Sc)"></div>
                            <div class="col-md-4"><input type="text" name="edu_institute[]" class="form-control" placeholder="প্রতিষ্ঠান (Institute)"></div>
                            <div class="col-md-2"><input type="text" name="edu_year[]" class="form-control" placeholder="পাসের সাল"></div>
                            <div class="col-md-3"><input type="text" name="edu_cgpa[]" class="form-control" placeholder="CGPA/Result"></div>
                            <div class="col-md-6 req-regular"><input type="text" name="edu_board[]" class="form-control" placeholder="বোর্ড / বিশ্ববিদ্যালয়"></div>
                            <div class="col-md-6 req-regular"><input type="text" name="edu_group[]" list="group_list" class="form-control" placeholder="গ্রুপ / সাবজেক্ট"></div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-dark mt-1" onclick="addEdu()"><i class="fas fa-plus me-1"></i> শিক্ষা যোগ করুন</button>

                <h5 class="section-title">
                    কাজের অভিজ্ঞতা (Experience)
                    <div class="form-check form-switch fs-6 m-0"><input class="form-check-input" type="checkbox" name="sections[]" value="experience" checked></div>
                </h5>
                <div id="exp_wrapper">
                    <div class="dynamic-row">
                        <div class="row g-3">
                            <div class="col-md-4"><input type="text" name="exp_role[]" class="form-control" placeholder="পদের নাম (Position)"></div>
                            <div class="col-md-5"><input type="text" name="exp_company[]" class="form-control" placeholder="কোম্পানি/প্রতিষ্ঠান (Company)"></div>
                            <div class="col-md-3"><input type="text" name="exp_duration[]" class="form-control" placeholder="সময়কাল (e.g. 2020-Present)"></div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-dark mt-1" onclick="addExp()"><i class="fas fa-plus me-1"></i> অভিজ্ঞতা যোগ করুন</button>

                <h5 class="section-title">
                    দক্ষতা ও শখ (Skills &amp; Hobbies)
                    <div class="form-check form-switch fs-6 m-0"><input class="form-check-input" type="checkbox" name="sections[]" value="skills" checked></div>
                </h5>
                <div class="row g-3">
                    <div class="col-md-6"><input type="text" name="skills" class="form-control" placeholder="দক্ষতা (Skills - কমা দিয়ে লিখুন)"></div>
                    <div class="col-md-6 req-regular"><input type="text" name="hobbies" class="form-control" placeholder="শখ (Hobbies - কমা দিয়ে লিখুন)"></div>
                </div>

                <h5 class="section-title">
                    রেফারেন্স (References)
                    <div class="form-check form-switch fs-6 m-0"><input class="form-check-input" type="checkbox" name="sections[]" value="references" checked></div>
                </h5>
                <div id="ref_wrapper">
                    <div class="dynamic-row">
                        <div class="row g-3">
                            <div class="col-md-3"><input type="text" name="ref_name[]" class="form-control" placeholder="Name"></div>
                            <div class="col-md-3"><input type="text" name="ref_designation[]" class="form-control" placeholder="Designation"></div>
                            <div class="col-md-3"><input type="text" name="ref_company[]" class="form-control" placeholder="Company"></div>
                            <div class="col-md-3"><input type="text" name="ref_contact[]" class="form-control" placeholder="Email / Phone"></div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-dark mt-1" onclick="addRef()"><i class="fas fa-plus me-1"></i> রেফারেন্স যোগ করুন</button>

                <div class="text-center mt-5 mb-2">
                    <button type="submit" class="btn-submit-cv px-5 shadow"><i class="fas fa-check-circle me-2"></i> সিভি তৈরি করুন</button>
                </div>
            </form>

            @if(isset($cvs) && $cvs->count() > 0)
            <hr class="my-5">
            <h5 class="fw-bold mb-3"><i class="fas fa-history me-2"></i>আমার সিভি সমূহ</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>নাম</th>
                            <th>টেমপ্লেট</th>
                            <th>তারিখ</th>
                            <th>অ্যাক্শন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cvs as $cvItem)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cvItem->name }}</td>
                            <td>{{ $cvItem->cv_type == 'bd_popular' ? 'বিডি পপুলার' : 'প্রফেশনাল' }}</td>
                            <td>{{ $cvItem->created_at->format('d/m/Y h:i A') }}</td>
                            <td>
                                <a href="{{ route('user.cv-maker.view', $cvItem->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> প্রিভিউ</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

@push('js')

<script>

    const objs = {

        1: "A highly motivated and enthusiastic fresher with a strong academic background, eager to secure an entry-level position. Looking forward to leveraging my learning capabilities, analytical skills, and adaptable nature in a dynamic environment where I can continuously learn, contribute effectively to team goals, and build a strong foundation for a successful long-term career.",

        2: "Results-driven and highly analytical professional with a proven track record of successful project execution and team leadership. Seeking to utilize my extensive industry experience, strategic planning abilities, and problem-solving skills to drive organizational growth, optimize operational efficiency, and deliver sustainable business solutions in a challenging corporate environment.",

        3: "Innovative and highly adaptable professional with a strong passion for creative problem-solving and dynamic project management. Looking for a challenging role in a forward-thinking organization where I can utilize my out-of-the-box thinking, technical proficiency, and collaborative mindset to drive impactful results and foster continuous innovation."

    };

    function setObj(id) { document.getElementById('obj_box').value = objs[id]; }



    function toggleLayout() {

        var isRegular = document.querySelector('input[name="cv_type"]:checked').value === 'bd_popular';

        document.querySelectorAll('.req-regular').forEach(function(el) { el.style.display = isRegular ? 'block' : 'none'; });

    }

    window.onload = toggleLayout;



    function addEdu() {

        var isReg = document.querySelector('input[name="cv_type"]:checked').value === 'bd_popular' ? 'block' : 'none';

        var html = '<div class="dynamic-row"><i class="fas fa-times remove-btn" onclick="this.parentElement.remove()"></i><div class="row g-3"><div class="col-md-3"><input type="text" name="edu_degree[]" list="degree_list" class="form-control" placeholder="ডিগ্রি"></div><div class="col-md-4"><input type="text" name="edu_institute[]" class="form-control" placeholder="প্রতিষ্ঠান"></div><div class="col-md-2"><input type="text" name="edu_year[]" class="form-control" placeholder="সাল"></div><div class="col-md-3"><input type="text" name="edu_cgpa[]" class="form-control" placeholder="CGPA"></div><div class="col-md-6 req-regular" style="display:' + isReg + '"><input type="text" name="edu_board[]" class="form-control" placeholder="বোর্ড"></div><div class="col-md-6 req-regular" style="display:' + isReg + '"><input type="text" name="edu_group[]" list="group_list" class="form-control" placeholder="গ্রুপ"></div></div></div>';

        document.getElementById('edu_wrapper').insertAdjacentHTML('beforeend', html);

    }



    function addExp() {

        var html = '<div class="dynamic-row"><i class="fas fa-times remove-btn" onclick="this.parentElement.remove()"></i><div class="row g-3"><div class="col-md-4"><input type="text" name="exp_role[]" class="form-control" placeholder="পদের নাম"></div><div class="col-md-5"><input type="text" name="exp_company[]" class="form-control" placeholder="কোম্পানি"></div><div class="col-md-3"><input type="text" name="exp_duration[]" class="form-control" placeholder="সময়কাল"></div></div></div>';

        document.getElementById('exp_wrapper').insertAdjacentHTML('beforeend', html);

    }



    function addRef() {

        var html = '<div class="dynamic-row"><i class="fas fa-times remove-btn" onclick="this.parentElement.remove()"></i><div class="row g-3"><div class="col-md-3"><input type="text" name="ref_name[]" class="form-control" placeholder="Name"></div><div class="col-md-3"><input type="text" name="ref_designation[]" class="form-control" placeholder="Designation"></div><div class="col-md-3"><input type="text" name="ref_company[]" class="form-control" placeholder="Company"></div><div class="col-md-3"><input type="text" name="ref_contact[]" class="form-control" placeholder="Contact"></div></div></div>';

        document.getElementById('ref_wrapper').insertAdjacentHTML('beforeend', html);

    }



    document.addEventListener('DOMContentLoaded', function() {

        var form = document.getElementById('cvForm');

        if (form) {

            form.addEventListener('submit', function(e) {

                var badge = document.querySelector('.badge');

                var charge = badge ? badge.textContent.replace(/[^0-9]/g, '') : '5';

                if (!confirm('সিভি জেনারেট করতে আপনার ব্যালেন্স থেকে ৳' + charge + '.00 চার্জ করা হবে। আপনি কি নিশ্চিত?')) {

                    e.preventDefault();

                }

            });

        }

    });

</script>

@endpush

@endsection
