@extends('user.layouts.app')

@section('title')
    মৃত্যু সনদপত্র - সম্পাদনা করুন
@endsection

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="card-title text-primary mb-0">
                <i class="fas fa-file-medical fa-fw"></i> মৃত্যু সনদপত্র - সম্পাদনা
            </h3>
            <a href="{{ route('user.death_certificate.index') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left fa-fw"></i> তালিকায় ফিরে যান
            </a>
        </div>

        <hr class="border-primary opacity-75 mt-3">

   

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

        <form action="{{ route('user.death_certificate.update', $deathCertificate->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-6">
                    <!-- অফিস তথ্য -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-building mr-2"></i> অফিস তথ্য</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-university text-primary"></i> নিবন্ধন নম্বর<span class="text-danger">*</span></label>
                                <input type="text" name="registration_no" value="{{ old('registration_no', $deathCertificate->registration_no) }}" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                               <label><i class="fa fa-building text-primary"></i> অফিসের নাম<span class="text-danger">*</span></label>
                                <input type="text" name="office_name" value="{{ old('office_name', $deathCertificate->office_name) }}" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-map-marker text-primary"></i> অফিসের ঠিকানা<span class="text-danger">*</span></label>
                                <textarea name="office_address" rows="2" class="form-control" required>{{ old('office_address', $deathCertificate->office_address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- মৃত ব্যক্তির তথ্য -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-danger text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-user mr-2"></i> মৃত ব্যক্তির তথ্য</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-user text-primary"></i> নাম (বাংলায়)<span class="text-danger">*</span></label>
                                <input type="text" name="name_bengali" value="{{ old('name_bengali', $deathCertificate->name_bengali) }}" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                               <label><i class="fa fa-user text-primary"></i> নাম (ইংরেজি)</label>
                                <input type="text" name="name_english" value="{{ old('name_english', $deathCertificate->name_english) }}" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-venus-mars text-primary"></i> লিঙ্গ<span class="text-danger">*</span></label>
                                <select name="gender" class="form-control" required>
                                    <option value="">নির্বাচন করুন</option>
                                    <option value="male" {{ old('gender', $deathCertificate->gender) == 'male' ? 'selected' : '' }}>পুরুষ</option>
                                    <option value="female" {{ old('gender', $deathCertificate->gender) == 'female' ? 'selected' : '' }}>মহিলা</option>
                                    <option value="other" {{ old('gender', $deathCertificate->gender) == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-calendar text-primary"></i> মৃত্যুর তারিখ<span class="text-danger">*</span></label>
                                <input type="date" name="date_of_death" value="{{ old('date_of_death', $deathCertificate->date_of_death ? date('Y-m-d', strtotime($deathCertificate->date_of_death)) : '') }}" class="form-control date" required>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-envelope text-primary"></i> ইমেইল</label>
                                <input type="email" name="email" value="{{ old('email', $deathCertificate->email) }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-6">
                    <!-- পারিবারিক তথ্য -->
                    <div class="card border-0  mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-users mr-2"></i> পারিবারিক তথ্য</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><i class="fa fa-male text-primary"></i> পিতার নাম (বাংলায়)<span class="text-danger">*</span></label>
                                <input type="text" name="father_name_bengali" value="{{ old('father_name_bengali', $deathCertificate->father_name_bengali) }}" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-male text-primary"></i> পিতার নাম (ইংরেজি)</label>
                                <input type="text" name="father_name_english" value="{{ old('father_name_english', $deathCertificate->father_name_english) }}" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-female text-primary"></i> মাতার নাম (বাংলায়)<span class="text-danger">*</span></label>
                                <input type="text" name="mother_name_bengali" value="{{ old('mother_name_bengali', $deathCertificate->mother_name_bengali) }}" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                               <label><i class="fa fa-female text-primary"></i> মাতার নাম (ইংরেজি)</label>
                                <input type="text" name="mother_name_english" value="{{ old('mother_name_english', $deathCertificate->mother_name_english) }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    

                    <!-- ঠিকানা -->
                    <div class="card border-0 mb-4">
                        <div class="card-header bg-warning text-dark py-3">
                            <h5 class="mb-0"><i class="fas fa-map-marked-alt mr-2"></i> ঠিকানা সংক্রান্ত</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                               <label><i class="fa fa-hospital text-primary"></i> মৃত্যুর স্থান (বাংলায়)<span class="text-danger">*</span></label>
                                <input type="text" name="place_of_death_bengali" value="{{ old('place_of_death_bengali', $deathCertificate->place_of_death_bengali) }}" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-hospital text-primary"></i> মৃত্যুর স্থান (ইংরেজি)</labe>
                                <input type="text" name="place_of_death_english" value="{{ old('place_of_death_english', $deathCertificate->place_of_death_english) }}" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                               <label><i class="fa fa-home text-primary"></i> স্থায়ী ঠিকানা (বাংলায়)<span class="text-danger">*</span></label>
                                <textarea name="permanent_address_bengali" rows="2" class="form-control" required>{{ old('permanent_address_bengali', $deathCertificate->permanent_address_bengali) }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                               <label><i class="fa fa-home text-primary"></i> স্থায়ী ঠিকানা (ইংরেজি)</label<label><i class="fa fa-home text-primary"></i> স্থায়ী ঠিকানা (বাংলায়)<span class="text-danger">*</span></label>l>
                                <textarea name="permanent_address_english" rows="2" class="form-control">{{ old('permanent_address_english', $deathCertificate->permanent_address_english) }}</textarea>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    

                    <!-- সনদপত্র তথ্য -->

                  
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-certificate mr-2"></i> সনদপত্র তথ্য</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                 <label><i class="fa fa-calendar text-primary"></i> নিবন্ধন তারিখ<span class="text-danger">*</span></label>
                                <input type="date" name="registration_date" value="{{ old('registration_date', $deathCertificate->registration_date ? date('Y-m-d', strtotime($deathCertificate->registration_date)) : '') }}" class="form-control date" required>
                            </div>

                            <div class="form-group mb-3">
                                <label><i class="fa fa-calendar text-primary"></i> ইস্যু তারিখ<span class="text-danger">*</span></label>
                                <input type="date" name="issue_date" value="{{ old('issue_date', $deathCertificate->issue_date ? date('Y-m-d', strtotime($deathCertificate->issue_date)) : '') }}" class="form-control date" required>
                            </div>
                        </div>
</div>
               
            

            <!-- Submit Buttons -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fa fa-save"></i> হালনাগাদ করুন
                </button>
                <a href="{{ route('user.death_certificate.index') }}" class="btn btn-danger btn-lg ml-3">
                    <i class="fa fa-times"></i> বাতিল
                </a>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        // Flatpickr for date inputs
        $(".date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true
        });
        
        // Form validation
        $('form').on('submit', function(e) {
            let isValid = true;
            $(this).find('[required]').each(function() {
                if ($(this).val() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('দয়া করে সমস্ত প্রয়োজনীয় তথ্য প্রদান করুন।');
            }
        });
    });
</script>
@endpush
@endsection
