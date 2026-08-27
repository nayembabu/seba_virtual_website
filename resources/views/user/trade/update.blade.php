@extends('user.layouts.app')
@section('title')
    ট্রেড লাইসেন্স সম্পাদনা
@endsection

@section('content')
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
</style>

<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="card-title text-primary">
                        <i class="fas fa-store fa-fw"></i> ট্রেড লাইসেন্স সম্পাদনা
                    </h3>
                    <a href="{{ route('user.trade.index') }}" class="btn btn-dark">
                        <i class="fas fa-arrow-left fa-fw"></i> তালিকায় ফিরে যান
                    </a>
                </div>
                <hr class="border-primary opacity-75">
            </div>
        </div>

        <div class="alert alert-info border-info mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x mr-3"></i>
                <div>
                    <h4 class="alert-heading mb-1">সার্ভিস চার্জ</h4>
                    <p class="mb-0 font-weight-bold">{{ inum(get_settings()->nagad_fee) }} টাকা</p>
                </div>
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

        <form action="{{ route('user.trade.update', $trade->id) }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-6">
                    <!-- Business Information Card -->
                    <div class="card border-info mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-store-alt mr-2"></i>ব্যবসা প্রতিষ্ঠানের তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-building mr-1"></i>ব্যবসা প্রতিষ্ঠানের নাম
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="b_name" 
                                            placeholder="প্রতিষ্ঠানের নাম লিখুন" 
                                            value="{{ old('b_name', $trade->b_name) }}" 
                                            required 
                                            oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-briefcase mr-1"></i>ব্যবসার ধরন
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="b_type" 
                                            placeholder="ব্যবসার ধরন লিখুন"
                                            value="{{ old('b_type', $trade->b_type) }}" 
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-user-tie mr-1"></i>মালিকানার ধরন
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="malik_type" 
                                            placeholder="মালিকানার ধরন লিখুন"
                                            value="{{ old('malik_type', $trade->malik_type) }}" 
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-map-marker-alt mr-1"></i>ব্যবসা প্রতিষ্ঠানের ঠিকানা
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="bu_name" 
                                            placeholder="ব্যবসা প্রতিষ্ঠানের পূর্ণ ঠিকানা লিখুন"
                                            value="{{ old('bu_name', $trade->bu_name) }}" 
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-calendar-alt mr-1"></i>অর্থ বছর
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="account_year" 
                                            value="{{ old('account_year', $trade->account_year) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-hashtag mr-1"></i>ট্রেড লাইসেন্স নম্বর
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="trade_no" 
                                            value="{{ old('trade_no', $trade->trade_no) }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Card -->
                    <div class="card border-primary mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-user-circle mr-2"></i>ব্যক্তিগত তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-user mr-1"></i>মালিকের নাম
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="malik_name" 
                                            placeholder="মালিকের পূর্ণ নাম লিখুন" 
                                            value="{{ old('malik_name', $trade->malik_name) }}" 
                                            required 
                                            oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-user-friends mr-1"></i>পিতার নাম
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="father_name" 
                                            placeholder="পিতার নাম লিখুন"
                                            value="{{ old('father_name', $trade->father_name) }}" 
                                            required 
                                            oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-user-friends mr-1"></i>মাতার নাম
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="mother_name" 
                                            placeholder="মাতার নাম লিখুন"
                                            value="{{ old('mother_name', $trade->mother_name) }}" 
                                            required 
                                            oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-ring mr-1"></i>স্ত্রীর নাম
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="wife_name" 
                                            placeholder="স্ত্রীর নাম লিখুন"
                                            value="{{ old('wife_name', $trade->wife_name) }}" 
                                            required 
                                            oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-id-card mr-1"></i>এনআইডি নম্বর
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="nid_no" 
                                            placeholder="এনআইডি নম্বর লিখুন"
                                            value="{{ old('nid_no', $trade->nid_no) }}" 
                                            required 
                                            oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-map-marker-alt mr-1"></i>স্থায়ী ঠিকানা
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="address" 
                                            placeholder="স্থায়ী ঠিকানা লিখুন"
                                            value="{{ old('address', $trade->address) }}" 
                                            required 
                                            oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="col-lg-6">
                    <!-- Union Council Information Card -->
                    <div class="card border-primary mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-landmark mr-2"></i>ইউনিয়ন পরিষদের তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-building mr-1"></i>ইউনিয়ন পরিষদের নাম
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="union_name" 
                                            placeholder="ইউনিয়ন পরিষদের নাম লিখুন"
                                            value="{{ old('union_name', $trade->union_name) }}"
                                            required 
                                            oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-map-marked-alt mr-1"></i>ইউনিয়ন পরিষদের ঠিকানা
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="union_address" 
                                            placeholder="ইউনিয়ন পরিষদের পূর্ণ ঠিকানা"
                                            value="{{ old('union_address', $trade->union_address) }}"
                                            required 
                                            oninput="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- License Period Card -->
                    <div class="card border-info mb-4">
                        <div class="card-header bg-info text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-file-alt mr-2"></i>লাইসেন্স সময়কাল
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-calendar mr-1"></i>শুরুর তারিখ
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="start-date"
                                            name="start_date"
                                            placeholder="YYYY-MM-DD"
                                            value="{{ old('start_date', $trade->start_date) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-calendar-check mr-1"></i>মেয়াদ উত্তীর্ণের তারিখ
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="expiry-date" 
                                            name="ex_date"
                                            placeholder="YYYY-MM-DD"
                                            value="{{ old('ex_date', $trade->ex_date) }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fees and Amounts Card -->
                    <div class="card border-success mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-money-bill-wave mr-2"></i>ফি ও চার্জের তথ্য
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-file-invoice-dollar mr-1"></i>ট্রেড লাইসেন্স ফি
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="fee" 
                                            value="{{ old('fee', $trade->fee) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-percent mr-1"></i>ভ্যাট
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="vat_amount" 
                                            value="{{ old('vat_amount', $trade->vat_amount) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            <i class="fas fa-edit mr-1"></i>সংশোধন ফি
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="cr_amount" 
                                            value="{{ old('cr_amount', $trade->cr_amount) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-landmark mr-1"></i>আয়কর
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="tax_amount" 
                                            value="{{ old('tax_amount', $trade->tax_amount) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-coins mr-1"></i>ফান্ড ট্যাক্স
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="fund_amount" 
                                            value="{{ old('fund_amount', $trade->fund_amount) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-sign mr-1"></i>সাইনবোর্ড ফি
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="sine_amount" 
                                            value="{{ old('sine_amount', $trade->sine_amount) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-file-alt mr-1"></i>পারমিট ফি
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="permit_amount" 
                                            value="{{ old('permit_amount', $trade->permit_amount) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-hand-holding-usd mr-1"></i>বকেয়া
                                        </label>
                                        <input type="number" 
                                            class="form-control" 
                                            name="due_amount" 
                                            value="{{ old('due_amount', $trade->due_amount) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-cogs mr-1"></i>সার্ভিস চার্জ
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="charge_amount" 
                                            value="{{ old('charge_amount', $trade->charge_amount) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            <i class="fas fa-plus-circle mr-1"></i>অন্যান্য চার্জ
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="others_amount" 
                                            value="{{ old('others_amount', $trade->others_amount) }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label required-label">
                                            <i class="fas fa-calculator mr-1"></i>মোট পরিমাণ
                                        </label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="total_amount" 
                                            placeholder="মোট টাকার পরিমাণ"
                                            value="{{ old('total_amount', $trade->total_amount) }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5" name="update">
                    <i class="fas fa-save mr-2"></i>ট্রেড লাইসেন্স আপডেট করুন
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize flatpickr for date inputs
        const startDatePicker = flatpickr('#start-date', {
            dateFormat: 'Y-m-d',
            allowInput: true,
            minDate: 'today',
            onChange: function(selectedDates) {
                // Update expiry date min date
                const startDate = selectedDates[0];
                expiryDatePicker.set('minDate', startDate);
            }
        });

        const expiryDatePicker = flatpickr('#expiry-date', {
            dateFormat: 'Y-m-d',
            allowInput: true,
            minDate: 'today',
            onChange: function(selectedDates) {
                // Validate expiry date is after start date
                const expiryDate = selectedDates[0];
                const startDate = startDatePicker.selectedDates[0];
                if (startDate && expiryDate < startDate) {
                    this.clear();
                    alert('মেয়াদ উত্তীর্ণের তারিখ অবশ্যই শুরুর তারিখের পরে হতে হবে।');
                }
            }
        });

        // Initialize custom file inputs
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', function(e) {
                const fileName = this.files[0].name;
                const nextSibling = this.nextElementSibling;
                nextSibling.innerText = fileName;
            });
        });

        // Calculate total amount
        function calculateTotal() {
            const fields = [
                'fee', 'vat_amount', 'cr_amount', 'tax_amount', 
                'fund_amount', 'sine_amount', 'permit_amount',
                'due_amount', 'charge_amount', 'others_amount'
            ];
            
            let total = 0;
            fields.forEach(field => {
                const input = document.querySelector(`input[name="${field}"]`);
                const value = input.value.replace(/[^\d.]/g, '');
                total += parseFloat(value) || 0;
            });

            document.querySelector('input[name="total_amount"]').value = total.toFixed(2);
        }

        // Add event listeners for amount fields
        const amountFields = document.querySelectorAll('input[name="fee"], input[name="vat_amount"], input[name="cr_amount"], input[name="tax_amount"], input[name="fund_amount"], input[name="sine_amount"], input[name="permit_amount"], input[name="due_amount"], input[name="charge_amount"], input[name="others_amount"]');
        amountFields.forEach(field => {
            field.addEventListener('input', calculateTotal);
        });

        // Initialize total calculation on page load
        calculateTotal();
    });
</script>

@endsection

@push('js')
<script>
    $(document).on('change','body #photo',function(){
        let file = $(this)[0].files[0];
        let src = URL.createObjectURL(file);
        $('#img').attr('src',src);
    });
</script>
@endpush