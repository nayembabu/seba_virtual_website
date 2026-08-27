@extends('user.layouts.app')
@section('title')
    নাগরিক সনদ তৈরি
@endsection
@php
    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'nagorik_sonod')->first();
@endphp


@section('content')
<div class=" card-primary m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row">
            <div >
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-info">
                        <i class="fas fa-file-alt"></i> নাগরিক সনদ তৈরি ফরম
                    </h3>
                    <a href="{{ route('user.nagorik-sonod.index') }}" class="btn btn-dark">
                        <i class="fas fa-arrow-left"></i> তালিকায় ফিরে যান
                    </a>
                </div>
                <hr class="border-primary">
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-danger">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>ত্রুটি!</strong>
                </div>
                <ul class="list-unstyled mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-times mr-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success border-success">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if($serviceCharge)
            <div class="alert alert-info border-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-2x mr-3"></i>
                    <div>
                        <h4 class="alert-heading mb-1">সার্ভিস চার্জ</h4> 
                        <p class="mb-0"  >প্রতিটি কার্ড তৈরির জন্য <span class="font-weight-bold"  style="color:red; " > {{ number_format($serviceCharge->amount, 1) }}</span> টাকা কাটা হবে।</p>
                    </div>
                </div>
            </div>
        @endif


        <div class="card">
            <div class="card-body">
            <form action="{{ route('user.nagorik-sonod.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div >
                        <!-- ইউনিয়ন তথ্য -->
                        <div class=" bg-light">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-building"></i> ইউনিয়ন পরিষদ তথ্য
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">
                                                <i class="fas fa-home"></i> ইউনিয়ন পরিষদ
                                            </label>
                                            <input type="text" name="union_name" class="form-control form-control-lg text-center" value="৭ নংনারায়ণপুর ইউনিয়ন পরিষদ" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">
                                                <i class="fas fa-map-marker-alt"></i> ইউনিয়নের ঠিকানা
                                            </label>
                                            <input type="text" name="union_address" class="form-control form-control-lg text-center" value="ডাকঃ নারায়ণপুর, উপজেলাঃ নবাবগঞ্জ, জেলাঃ ঢাকা" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ব্যক্তিগত তথ্য -->
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-user"></i> ব্যক্তিগত তথ্য
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">
                                                <i class="fas fa-user-circle"></i> নাম
                                            </label>
                                            <input type="text" name="name" class="form-control" placeholder="আপনার পূর্ণ নাম লিখুন" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">
                                                <i class="fas fa-male"></i> পিতার নাম
                                            </label>
                                            <input type="text" name="father_name" class="form-control" placeholder="পিতার নাম লিখুন" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">
                                                <i class="fas fa-female"></i> মাতার নাম
                                            </label>
                                            <input type="text" name="mother_name" class="form-control" placeholder="মাতার নাম লিখুন" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">
                                                <i class="fas fa-user-friends"></i> স্বামীর নাম (যদি থাকে)
                                            </label>
                                            <input type="text" name="husband_name" class="form-control" placeholder="স্বামীর নাম লিখুন (ঐচ্ছিক)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ঠিকানা এবং পরিচয় -->
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-address-card"></i> ঠিকানা এবং পরিচয়
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">
                                                <i class="fas fa-map-marked-alt"></i> স্থায়ী ঠিকানা
                                            </label>
                                            <textarea name="address" class="form-control" rows="3" placeholder="আপনার স্থায়ী ঠিকানা লিখুন" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">
                                                <i class="fas fa-map"></i> ওয়ার্ড নং
                                            </label>
                                            <input type="text" name="ward_no" class="form-control" placeholder="ওয়ার্ড নম্বর লিখুন" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">
                                                <i class="fas fa-id-card"></i> এনআইডি নম্বর
                                            </label>
                                            <input type="text" name="nid_number" class="form-control" placeholder="জাতীয় পরিচয়পত্র নম্বর লিখুন" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label font-weight-bold">
                                                <i class="fas fa-calendar-alt"></i> জন্ম তারিখ
                                            </label>
                                            <input type="date" name="birth_date" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <!-- সার্টিফিকেট তথ্য -->
                        <div class="bg-light">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-certificate"></i> সার্টিফিকেট তথ্য
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold">
                                        <i class="fas fa-hashtag"></i> সার্টিফিকেট নম্বর
                                    </label>
                                    <select name="certificate_number" class="form-control" required>
                                        <option value="">বছর নির্বাচন করুন</option>
                                        @php
                                            $currentYear = date('Y');
                                            for($year = $currentYear; $year >= $currentYear - 10; $year--) {
                                                echo "<option value='{$year}'>{$year}</option>";
                                            }
                                        @endphp
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label font-weight-bold">
                                        <i class="fas fa-calendar-check"></i> ইস্যু তারিখ
                                    </label>
                                    <input type="date" name="issue_date" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label font-weight-bold">
                                        <i class="fas fa-camera"></i> ছবি আপলোড
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" name="photo" id="photo" class="custom-file-input" accept="image/*" required>
                                        <label class="custom-file-label" for="photo">ছবি নির্বাচন করুন</label>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <img id="img" src="" alt="ছবি প্রিভিউ" class="img-thumbnail" style="max-width: 150px; display: none;">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">
                                    <i class="fas fa-save"></i> সনদ তৈরি করুন
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Handle file input change
        $(document).on('change', 'body #photo', function() {
            let file = $(this)[0].files[0];
            let src = URL.createObjectURL(file);
            $('#img').attr('src', src).show();
            
            // Update file input label
            let fileName = file.name;
            $(this).next('.custom-file-label').html(fileName);
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Add input masks if needed
        if($.fn.inputmask) {
            $('[name="nid_number"]').inputmask("9999999999", { placeholder: "" });
            $('[name="ward_no"]').inputmask("9{1,2}", { placeholder: "" });
        }
    });
</script>
@endpush
