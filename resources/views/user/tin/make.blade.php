@extends('user.layouts.app')

@section('title')
    Tin Make
@endsection

@section('content')
    @php
        $districts = Config::get('districts');
    @endphp



    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="container-fluid py-3">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="form-card">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold m-0"><i class="fas fa-file-invoice text-primary"></i> TIN Certificate
                                জেনারেট</h3>
                            <div class="price-badge m-0 shadow-sm">
                                সার্ভিস ফি: ৳30.00
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

                        <form action="{{ route('user.tin.store') }}" method="POST" id="tinForm">
                            @csrf

                            @php
                                $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'tin')->first();
                            @endphp

                            @if($serviceCharge)
                                <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                                        <div>
                                            <h6 class="alert-heading mb-1 font-weight-bold">সার্ভিস চার্জ</h6>
                                            <p class="mb-0 small text-muted">প্রতিটি টিন সার্টিফিকেট তৈরির জন্য <span class="font-weight-bold text-danger">{{ number_format($serviceCharge->amount, 2) }}</span> টাকা কাটা হবে।</p>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <input type="hidden" name="generate_tin" value="1">

                            <div class="section-title">ব্যক্তিগত তথ্য (Taxpayer Details)</div>
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label>করদাতার নাম (Taxpayer's Name) <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control fw-bold"
                                           value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>পিতার নাম (Father's Name) <span class="text-danger">*</span></label>
                                    <input type="text" name="fatherName" id="fatherName" class="form-control"
                                           value="{{ old('fatherName') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>মাতার নাম (Mother's Name) <span class="text-danger">*</span></label>
                                    <input type="text" name="motherName" id="motherName" class="form-control"
                                           value="{{ old('motherName') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>জন্ম তারিখ (Date of Birth) <span class="text-danger">*</span></label>
                                    <input type="date" name="dob" id="dob" class="form-control flatpickr-input"
                                           value="{{ old('dob') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>ইস্যুর তারিখ (Certificate Date)</label>
                                    <input type="date" name="certDate" id="todayDate" class="form-control flatpickr-input"
                                           value="{{ old('certDate', date('Y-m-d')) }}">
                                </div>
                            </div>

                            <div class="section-title">বর্তমান ঠিকানা (Present Address)</div>
                            <div class="address-box row">
                                <div class="col-md-6 mb-3">
                                    <label>ঠিকানা লাইন ১</label>
                                    <input type="text" name="curr_line1" id="curr_line1" class="form-control"
                                           value="{{ old('curr_line1') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>ঠিকানা লাইন ২</label>
                                    <input type="text" name="curr_line2" id="curr_line2" class="form-control"
                                           value="{{ old('curr_line2') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>জেলা (District)</label>
                                    <select name="currDistrict" id="currDistrict" class="form-select form-control" required>
                                        <option value="">Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district }}" {{ old('currDistrict') == $district ? 'selected' : '' }}>
                                                {{ $district }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>থানা (Thana/Upazila)</label>
                                    <select name="currThana" id="currThana" class="form-select form-control" required>
                                        <option value="">Select Thana</option>
                                        {{-- Populated via JavaScript based on district selection --}}
                                        @if(old('currThana'))
                                            <option value="{{ old('currThana') }}" selected>{{ old('currThana') }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>পোস্ট কোড</label>
                                    <input type="text" name="curr_post" id="curr_post" class="form-control"
                                           value="{{ old('curr_post') }}">
                                </div>
                            </div>

                            <div class="form-check mb-4 fw-bold text-primary">
                                <input class="form-check-input" type="checkbox" id="sameAddress">
                                <label class="form-check-label" for="sameAddress" style="font-size: 1rem; cursor: pointer;">
                                    স্থায়ী ঠিকানা বর্তমান ঠিকানার অনুরূপ (Same as Present Address)
                                </label>
                            </div>

                            <div class="section-title">স্থায়ী ঠিকানা (Permanent Address)</div>
                            <div class="address-box row">
                                <div class="col-md-6 mb-3">
                                    <label>ঠিকানা লাইন ১</label>
                                    <input type="text" name="perm_line1" id="perm_line1" class="form-control"
                                           value="{{ old('perm_line1') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>ঠিকানা লাইন ২</label>
                                    <input type="text" name="perm_line2" id="perm_line2" class="form-control"
                                           value="{{ old('perm_line2') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>জেলা (District)</label>
                                    <select name="permDistrict" id="permDistrict" class="form-select form-control" required>
                                        <option value="">Select District</option>
                                        @foreach(config('districts') as $district)
                                            <option value="{{ $district }}" {{ old('permDistrict') == $district ? 'selected' : '' }}>
                                                {{ $district }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>থানা (Thana/Upazila)</label>
                                    <select name="permThana" id="permThana" class="form-select form-control" required>
                                        <option value="">Select Thana</option>
                                        @if(old('permThana'))
                                            <option value="{{ old('permThana') }}" selected>{{ old('permThana') }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>পোস্ট কোড</label>
                                    <input type="text" name="perm_post" id="perm_post" class="form-control"
                                           value="{{ old('perm_post') }}">
                                </div>
                            </div>

                            <div class="section-title">ট্যাক্স অফিস তথ্য (Taxes Information)</div>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label>Taxes Circle</label>
                                    <input type="text" name="taxesCircle" id="taxesCircle" class="form-control text-primary fw-bold"
                                           value="{{ old('taxesCircle') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Taxes Zone</label>
                                    <input type="text" name="taxesZone" id="taxesZone" class="form-control text-primary fw-bold"
                                           value="{{ old('taxesZone') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Office Address</label>
                                    <input type="text" name="officeAddress" id="officeAddress" class="form-control"
                                           value="{{ old('officeAddress') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Office Phone</label>
                                    <input type="text" name="officePhone" id="officePhone" class="form-control"
                                           value="{{ old('officePhone') }}" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="text-center w-100 fs-5 text-danger">TIN Number (অটো-জেনারেটেড)</label>
                                    <input type="number" name="tin_number" id="tinNumber"
                                           value="{{ old('tin_number', generateTinNumber()) }}"
                                           class="form-control form-control-lg text-center fw-bold bg-light">
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm">
                                    <i class="fas fa-cogs"></i> জেনারেট করুন (৳30.00)
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        .form-group {
            margin-bottom: 1rem;
        }

        .card-body {
            padding: 1rem;
        }

        .form-control {
            padding: 0.4rem 0.75rem;
            height: calc(1.5em + 0.75rem + 2px);
            border: 1px solid #e2e5ec;
            border-radius: 4px;
            padding: 0.65rem 1rem;
            height: calc(1.5em + 1.3rem + 2px);
            font-size: 1rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: #3699ff;
            box-shadow: 0 0 0 0.2rem rgba(54, 153, 255, 0.25);
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #f7f8fa;
            opacity: 1;
        }

        .custom-file-input:focus ~ .custom-file-label {
            border-color: #3699ff;
            box-shadow: 0 0 0 0.2rem rgba(54, 153, 255, 0.25);
        }

        .card {
            border: none;
            box-shadow: 0 0 20px 0 rgba(76, 87, 125, 0.02);
            margin-bottom: 2rem;
        }

        .card-header {
            background-color: #f7f8fa;
            border-bottom: 1px solid #ebedf2;
            padding: 1rem 1.25rem;
        }

        .section-title {
            color: #181C32;
            font-size: 1.275rem;
            font-weight: 600;
        }

        .required-label::after {
            content: " *";
            color: #f64e60;
        }

        .form-text {
            color: #7E8299;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .btn-lg {
            padding: 0.825rem 1.42rem;
            font-size: 1.08rem;
            line-height: 1.5;
            border-radius: 0.42rem;
        }

        .alert {
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid transparent;
            border-radius: 0.42rem;
        }

        .border-left {
            border-left: 0.25rem solid !important;
        }
    </style>
    <style>
        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            border-bottom: 0;
            padding: 1rem 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .custom-file {
            position: relative;
            display: inline-block;
            width: 100%;
            height: calc(1.5em + 1.25rem + 2px);
        }

        .custom-file-input {
            position: relative;
            z-index: 2;
            width: 100%;
            height: calc(1.5em + 1.25rem + 2px);
            margin: 0;
            opacity: 0;
        }

        .custom-file-label {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1;
            height: calc(1.5em + 1.25rem + 2px);
            padding: 0.625rem 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #e2e5ec;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out;
        }

        .custom-file-label::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 3;
            display: block;
            height: calc(1.5em + 1.25rem);
            padding: 0.625rem 1rem;
            line-height: 1.5;
            color: #495057;
            content: "Browse";
            background-color: #f7f8fa;
            border-left: inherit;
            border-radius: 0 4px 4px 0;
        }

        .select2-container .select2-selection--single {
            height: 45px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 45px;
            padding-left: 15px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 45px;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/zone/district-thana.js.download') }}"></script>
    <script src="{{ asset('assets/zone/zone-info.js.download') }}"></script>

    <script>
        $(document).ready(function () {
            flatpickr(".flatpickr-input", {});
        })
        // জেলা-থানা এবং জোন অটো-ফিলের লজিক
        function populateDistricts() {
            const currD = document.getElementById('currDistrict');
            const permD = document.getElementById('permDistrict');
            if (typeof districts !== 'undefined') {
                districts.forEach(d => {
                    currD.add(new Option(d, d));
                    permD.add(new Option(d, d));
                });
            }
        }

        function loadThanas(dId, tId) {
            const district = document.getElementById(dId).value;
            const thanaSelect = document.getElementById(tId);
            thanaSelect.innerHTML = '<option value="">Select Thana</option>';
            if (typeof thanaData !== 'undefined' && thanaData[district]) {
                thanaData[district].forEach(th => thanaSelect.add(new Option(th, th)));
            }
        }

        function autoFillTaxInfo() {
            const dist = document.getElementById('currDistrict').value;
            const thana = document.getElementById('currThana').value;
            const key = `${dist}_${thana}`;
            if (typeof taxZoneMapping !== 'undefined' && taxZoneMapping[key]) {
                const data = taxZoneMapping[key];
                document.getElementById('taxesCircle').value = data.circle;
                document.getElementById('taxesZone').value = data.zone;
                document.getElementById('officeAddress').value = data.address;
                document.getElementById('officePhone').value = data.phone;
            }
        }

        document.getElementById('currDistrict').addEventListener('change', () => {
            loadThanas('currDistrict', 'currThana');
            autoFillTaxInfo();
        });
        document.getElementById('currThana').addEventListener('change', autoFillTaxInfo);
        document.getElementById('permDistrict').addEventListener('change', () => loadThanas('permDistrict', 'permThana'));

        document.getElementById('sameAddress').addEventListener('change', function () {
            if (this.checked) {
                document.getElementById('perm_line1').value = document.getElementById('curr_line1').value;
                document.getElementById('perm_line2').value = document.getElementById('curr_line2').value;
                document.getElementById('permDistrict').value = document.getElementById('currDistrict').value;
                loadThanas('permDistrict', 'permThana');
                setTimeout(() => {
                    document.getElementById('permThana').value = document.getElementById('currThana').value;
                }, 100);
                document.getElementById('perm_post').value = document.getElementById('curr_post').value;
            }
        });

        populateDistricts();

        // SweetAlert Error/Success Message ও পেমেন্ট কনফার্মেশন
        $(document).ready(function () {

            $('#tinForm').on('submit', function (e) {
                return confirm("আপনি কি নিশ্চিত? সার্টিফিকেটটি জেনারেট করতে আপনার ব্যালেন্স থেকে ৳30.00 কাটা হবে।");
            });
        });
    </script>
@endpush
