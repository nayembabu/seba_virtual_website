@extends('user.layouts.app')

@section('title')
    জন্ম নিবন্ধন - সম্পাদনা করুন
@endsection

@section('content')
<style>
    /* (Use same CSS from create page for consistency) */
    .form-group { margin-bottom: 1rem; }
    .card-body { padding: 1rem; }
    .form-control {
        padding: 0.65rem 1rem;
        height: calc(1.5em + 1.3rem + 2px);
        border: 1px solid #e2e5ec;
        border-radius: 4px;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #3699ff;
        box-shadow: 0 0 0 0.2rem rgba(54, 153, 255, 0.25);
    }
    .card { border: none; box-shadow: 0 0 20px rgba(76,87,125,0.02); margin-bottom: 2rem; }
    .card-header { background-color: #f7f8fa; border-bottom: 1px solid #ebedf2; padding: 1rem 1.25rem; }
    .btn-lg { padding: 0.825rem 1.42rem; font-size: 1.08rem; border-radius: 0.42rem; }
</style>

<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row justify-content-between mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-primary mb-0">
                        <i class="fas fa-edit fa-fw"></i> জন্ম নিবন্ধন - সম্পাদনা করুন
                    </h3>
                    <a href="{{ route('user.nibondon.index') }}" class="btn btn-dark">
                        <i class="fas fa-arrow-left fa-fw"></i> তালিকায় ফিরে যান
                    </a>
                </div>
                <hr class="border-primary opacity-75 mt-3">
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-left border-danger border-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                    <div>
                        <h4 class="alert-heading mb-1">ত্রুটি সংশোধন করুন!</h4>
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-times-circle mr-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('user.nibondon.update', $nibondon->id) }}" method="POST" enctype="multipart/form-data" id="birthRegistrationForm">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- LEFT COLUMN -->
                <div class="col-lg-6">
                    <!-- Personal Information -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-user mr-2"></i> ব্যক্তিগত তথ্য</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name_en">
                                    <i class="fa fa-user text-primary"></i> নাম (ইংরেজি)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-fonts"></i></span>
                                <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $nibondon->name_en) }}" required>
                            </div>
                            </div>
                            <label for="name_bn">
                                    <i class="fa fa-user text-primary"></i> নাম (বাংলা)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-translate"></i></span>
                                <input type="text" name="name_bn" class="form-control" value="{{ old('name_bn', $nibondon->name_bn) }}" required>
                            </div>
                           
                            <div class="form-group mb-3">
                                 <label for="gender">
                                    <i class="fa fa-venus-mars text-primary"></i> লিঙ্গ<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <select name="gender" class="form-control" required>
                                    <option value="">নির্বাচন করুন</option>
                                    <option value="male" {{ old('gender', $nibondon->gender) == 'male' ? 'selected' : '' }}>পুরুষ</option>
                                    <option value="female" {{ old('gender', $nibondon->gender) == 'female' ? 'selected' : '' }}>মহিলা</option>
                                    <option value="other" {{ old('gender', $nibondon->gender) == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                                </select>
                            </div>
                            </div>
                            <div class="form-group mb-3">
                                 <label for="date_of_birth">
                                    <i class="fa fa-calendar text-primary"></i> জন্ম তারিখ<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $nibondon->date_of_birth ? date('Y-m-d', strtotime($nibondon->date_of_birth)) : '') }}" required>
                            </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="birth_place_en">
                                    <i class="fa fa-map-marker text-primary"></i> জন্মস্থান (ইংরেজি)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin-map-fill"></i></span>
                                <input type="text" name="birth_place_en" class="form-control" value="{{ old('birth_place_en', $nibondon->birth_place_en) }}" required>
                            </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="birth_place_bn">
                                    <i class="fa fa-map-marker text-primary"></i> জন্মস্থান (বাংলা)<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin-map-fill"></i></span>
                                <input type="text" name="birth_place_bn" class="form-control" value="{{ old('birth_place_bn', $nibondon->birth_place_bn) }}" required>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parent Information -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-users mr-2"></i> পিতা-মাতার তথ্য</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-user text-primary"></i> পিতার নাম (ইংরেজি)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="father_name_en" class="form-control" value="{{ old('father_name_en', $nibondon->father_name_en) }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-user text-primary"></i> পিতার নাম (বাংলা)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="father_name_bn" class="form-control" value="{{ old('father_name_bn', $nibondon->father_name_bn) }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-flag text-primary"></i> পিতার জাতীয়তা (ইংরেজি)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-flag"></i></span>
                                    <input type="text" name="father_nationality_en" class="form-control" value="{{ old('father_nationality_en', $nibondon->father_nationality_en) }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-flag text-primary"></i> পিতার জাতীয়তা (বাংলা)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-flag"></i></span>
                                    <input type="text" name="father_nationality_bn" class="form-control" value="{{ old('father_nationality_bn', $nibondon->father_nationality_bn) }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-user text-primary"></i> মাতার নাম (ইংরেজি)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="mother_name_en" class="form-control" value="{{ old('mother_name_en', $nibondon->mother_name_en) }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-user text-primary"></i> মাতার নাম (বাংলা)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="mother_name_bn" class="form-control" value="{{ old('mother_name_bn', $nibondon->mother_name_bn) }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-flag text-primary"></i> মাতার জাতীয়তা (ইংরেজি)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-flag"></i></span>
                                    <input type="text" name="mother_nationality_en" class="form-control" value="{{ old('mother_nationality_en', $nibondon->mother_nationality_en) }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-flag text-primary"></i> মাতার জাতীয়তা (বাংলা)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-flag"></i></span>
                                    <input type="text" name="mother_nationality_bn" class="form-control" value="{{ old('mother_nationality_bn', $nibondon->mother_nationality_bn) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-6">
                    <!-- Registration Info -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> নিবন্ধন তথ্য</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-hashtag text-primary"></i> নিবন্ধন নম্বর<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    <input type="text" name="registration_no" class="form-control" value="{{ old('registration_no', $nibondon->registration_no) }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-calendar text-primary"></i> নিবন্ধন তারিখ<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="date" name="registration_date" class="form-control" value="{{ old('registration_date', $nibondon->registration_date ? date('Y-m-d', strtotime($nibondon->registration_date)) : '') }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-calendar text-primary"></i> ইস্যু তারিখ<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="date" name="issue_date" class="form-control" value="{{ old('issue_date', $nibondon->issue_date ? date('Y-m-d', strtotime($nibondon->issue_date)) : '') }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-building text-primary"></i> অফিসের নাম (বাংলা)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" name="office_name_bn" class="form-control" value="{{ old('office_name_bn', $nibondon->office_name_bn) }}" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-map text-primary"></i> জেলার তথ্য (বাংলা)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="district_info_bn" class="form-control" value="{{ old('district_info_bn', $nibondon->district_info_bn) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-warning text-dark py-3">
                            <h5 class="mb-0"><i class="fas fa-home mr-2"></i> ঠিকানা তথ্য</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-home text-primary"></i> স্থায়ী ঠিকানা (ইংরেজি)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house"></i></span>
                                    <textarea name="permanent_address_en" class="form-control" rows="3" required>{{ old('permanent_address_en', $nibondon->permanent_address_en) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label><i class="fa fa-home text-primary"></i> স্থায়ী ঠিকানা (বাংলা)<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house"></i></span>
                                    <textarea name="permanent_address_bn" class="form-control" rows="3" required>{{ old('permanent_address_bn', $nibondon->permanent_address_bn) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success btn-lg px-5">
                    <i class="fa fa-check-circle"></i> আপডেট করুন
                </button>
                <a href="{{ route('user.nibondon.index') }}" class="btn btn-danger btn-lg px-5 ml-3">
                    <i class="fa fa-times"></i> বাতিল
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const regDate = document.getElementById('registration_date');
    const dob = document.querySelector('[name="date_of_birth"]');
    
    regDate.addEventListener('change', function () {
        if (new Date(this.value) < new Date(dob.value)) {
            alert('নিবন্ধন তারিখ জন্ম তারিখের পরে হতে হবে!');
            this.value = '';
        }
    });
});
</script>
@endpush
