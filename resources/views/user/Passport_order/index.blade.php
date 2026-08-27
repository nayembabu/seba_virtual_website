@extends('user.layouts.app')
@section('title')
    পাসপোর্ট সার্ভিস
@endsection

@push('style')
    <style>
        .classic-card {
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .form-container {
            display: none;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        .form-container.active {
            display: block !important;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-option {
            position: relative;
            padding: 10px 15px;
            font-size: 0.95rem;
            text-align: left;
            margin-bottom: 5px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            height: 100%;
            min-height: 60px;
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
            color: #2c3e50;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            cursor: pointer;
        }

        .btn-option .btn-text {
            font-size: 0.92rem;
            color: #2c3e50;
            font-weight: 500;
        }

        .btn-option .text-block {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .option-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            padding: 0 15px;
        }

        .option-column {
            display: grid;
            grid-template-rows: repeat(1, 1fr);
            gap: 12px;
        }

        @media (max-width: 768px) {
            .option-grid {
                gap: 8px;
                padding: 10px;
            }

            .btn-option {
                height: 90px;
                min-height: 90px;
                max-height: 90px;
                padding: 8px;
                display: flex;
                align-items: center;
                justify-content: flex-start;
            }

            .btn-option .btn-text {
                font-size: 0.75rem;
                line-height: 1.3;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                word-break: break-word;
                margin: 0;
            }

            .btn-option i {
                font-size: 1rem;
                margin-right: 6px;
                width: 16px;
                flex-shrink: 0;
            }

            .btn-option .badge {
                font-size: 0.7rem;
                padding: 3px 6px;
                margin-left: 4px;
                flex-shrink: 0;
                min-width: 42px;
                text-align: center;
            }

            .text-block {
                flex: 1;
                min-width: 0;
                padding-right: 4px;
                display: flex;
                align-items: center;
            }
        }

        .btn-option i {
            font-size: 1.1rem;
            margin-right: 12px;
            color: #3498db;
            width: 24px;
            text-align: center;
        }

        .btn-option .badge {
            font-size: 0.9rem;
            padding: 5px 12px;
            background: #3498db;
            color: white;
            border-radius: 20px;
            margin-left: auto;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .btn-option:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            border-color: #3498db;
            background: linear-gradient(to bottom, #ffffff 0%, #e9f2ff 100%);
        }

        .btn-option.active {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border-color: #2980b9;
        }

        .btn-option.active i {
            color: white;
        }

        .btn-option.active .btn-text {
            color: white;
        }

        .btn-option.active .badge {
            background: white;
            color: #2980b9;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }

        .modal-header .modal-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6c757d;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-modal:hover {
            color: #dc3545;
        }

        /* Desktop table: white header bg + black bold text (was missing before) */
        .classic-table {
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            overflow: hidden;
        }

        .classic-table thead {
            background: #ffffff !important;
            border-bottom: 2px solid #dee2e6;
        }

        .classic-table thead th {
            color: #000000 !important;
            font-weight: 600;
            vertical-align: middle;
        }

        .mobile-order-row {
            background: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
            font-size: 0.9rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .row-number {
            font-weight: 600;
            color: #1e4c78;
            margin-right: 15px;
            min-width: 28px;
            text-align: center;
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .row-content {
            flex: 1;
            color: #333;
            display: grid;
            grid-gap: 8px;
        }

        .row-content .info-line {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .row-content .service-type {
            font-weight: 500;
            color: #1e4c78;
        }

        .row-content .order-date {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .row-content .text-muted {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .row-content .btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .mobile-order-row {
                font-size: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="card classic-card m-0 m-md-4 my-4 m-md-0">
        <div class="card-body">
            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Service Buttons -->
            <div class="option-grid">
                <div class="option-column">
                    <button type="button" class="btn-option" onclick="toggleForm(1)">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;MRP Passport to SB Copy</span>
                        </div>
                        <span class="badge">৳{{ $passportTypes[1]->cost ?? 100 }}</span>
                    </button>
                    <button type="button" class="btn-option" onclick="toggleForm(2)">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;E-Passport to Delivery Slip</span>
                        </div>
                        <span class="badge">৳{{ $passportTypes[2]->cost ?? 120 }}</span>
                    </button>
                </div>
                <div class="option-column">
                    <button type="button" class="btn-option" onclick="toggleForm(3)">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;NID/Nibondhon to Passport Info</span>
                        </div>
                        <span class="badge">৳{{ $passportTypes[3]->cost ?? 150 }}</span>
                    </button>
                    <button type="button" class="btn-option" onclick="toggleForm(4)">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;BMET 78% Approve</span>
                        </div>
                        <span class="badge">৳{{ $passportTypes[4]->cost ?? 200 }}</span>
                    </button>
                </div>
            </div>

            <!-- Forms Container -->
            <div class="forms-wrapper mt-4">
                <!-- Form 1: MRP Passport -->
                <div id="form1" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">MRP Passport to SB Copy</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.passport.order.store') }}" method="POST" class="needs-validation" id="passportForm" novalidate>
                        @csrf
                        <input type="hidden" name="form_type" value="1">
                        <div class="form-group mb-3">
            <textarea
                    class="form-control"
                    id="passport_info"
                    rows="4"
                    required
                    style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                    placeholder="নাম: John Doe
পাসপোর্ট নং: A12345678
জন্ম তারিখ: 1990-01-15"
            >নাম:
পাসপোর্ট নং:
জন্ম তারিখ: </textarea>
                        </div>

                        <!-- Hidden fields for controller validation -->
                        <input type="hidden" name="form_data[name]" id="hidden_name">
                        <input type="hidden" name="form_data[passport_no]" id="hidden_passport_no">
                        <input type="hidden" name="form_data[dob]" id="hidden_dob">

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-success" onclick="submitPassportForm()">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <script>
                    function submitPassportForm() {
                        const textarea = document.getElementById('passport_info');
                        const lines = textarea.value.split('\n');

                        let name = '';
                        let passportNo = '';
                        let dob = '';

                        lines.forEach(line => {
                            if (line.includes('নাম:')) {
                                name = line.split('নাম:')[1].trim();
                            }
                            if (line.includes('পাসপোর্ট নং:')) {
                                passportNo = line.split('পাসপোর্ট নং:')[1].trim();
                            }
                            if (line.includes('জন্ম তারিখ:')) {
                                dob = line.split('জন্ম তারিখ:')[1].trim();
                            }
                        });

                        if (!name) {
                            alert('অনুগ্রহ করে নাম লিখুন');
                            return false;
                        }

                        if (!passportNo) {
                            alert('অনুগ্রহ করে পাসপোর্ট নম্বর লিখুন');
                            return false;
                        }

                        if (!dob) {
                            alert('অনুগ্রহ করে জন্ম তারিখ লিখুন');
                            return false;
                        }

                        const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
                        if (!dateRegex.test(dob)) {
                            alert('অনুগ্রহ করে জন্ম তারিখ YYYY-MM-DD ফরম্যাটে লিখুন (উদাহরণ: 1990-01-15)');
                            return false;
                        }

                        document.getElementById('hidden_name').value = name;
                        document.getElementById('hidden_passport_no').value = passportNo;
                        document.getElementById('hidden_dob').value = dob;

                        document.getElementById('passportForm').submit();
                        return true;
                    }
                </script>

                <!-- Form 2: E-Passport -->
                <div id="form2" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">E-Passport to Delivery Slip</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.passport.order.store') }}" method="POST" class="needs-validation" id="passportForm2" novalidate>
                        @csrf
                        <input type="hidden" name="form_type" value="2">
                        <div class="form-group mb-3">
            <textarea
                    class="form-control"
                    id="passport_info2"
                    rows="4"
                    required
                    style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                    placeholder="নাম: John Doe
পাসপোর্ট নং: A12345678
জন্ম তারিখ: 1990-01-15"
            >নাম:
পাসপোর্ট নং:
জন্ম তারিখ: </textarea>
                        </div>

                        <!-- Hidden fields for controller validation -->
                        <input type="hidden" name="form_data[name]" id="hidden_name2">
                        <input type="hidden" name="form_data[passport_no]" id="hidden_passport_no2">
                        <input type="hidden" name="form_data[dob]" id="hidden_dob2">

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-success" onclick="submitPassportForm2()">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <script>
                    function submitPassportForm2() {
                        const textarea = document.getElementById('passport_info2');
                        const lines = textarea.value.split('\n');

                        let name = '';
                        let passportNo = '';
                        let dob = '';

                        lines.forEach(line => {
                            if (line.includes('নাম:')) {
                                name = line.split('নাম:')[1].trim();
                            }
                            if (line.includes('পাসপোর্ট নং:')) {
                                passportNo = line.split('পাসপোর্ট নং:')[1].trim();
                            }
                            if (line.includes('জন্ম তারিখ:')) {
                                dob = line.split('জন্ম তারিখ:')[1].trim();
                            }
                        });

                        if (!name) {
                            alert('অনুগ্রহ করে নাম লিখুন');
                            return false;
                        }

                        if (!passportNo) {
                            alert('অনুগ্রহ করে পাসপোর্ট নম্বর লিখুন');
                            return false;
                        }

                        if (!dob) {
                            alert('অনুগ্রহ করে জন্ম তারিখ লিখুন');
                            return false;
                        }

                        const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
                        if (!dateRegex.test(dob)) {
                            alert('অনুগ্রহ করে জন্ম তারিখ YYYY-MM-DD ফরম্যাটে লিখুন (উদাহরণ: 1990-01-15)');
                            return false;
                        }

                        document.getElementById('hidden_name2').value = name;
                        document.getElementById('hidden_passport_no2').value = passportNo;
                        document.getElementById('hidden_dob2').value = dob;

                        document.getElementById('passportForm2').submit();
                        return true;
                    }
                </script>

                <!-- Form 3: NID to Passport -->
                <div id="form3" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">NID/Nibondhon to Passport Info</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.passport.order.store') }}" method="POST" class="needs-validation" id="passportForm3" novalidate>
                        @csrf
                        <input type="hidden" name="form_type" value="3">
                        <div class="form-group mb-3">
            <textarea
                    class="form-control"
                    id="passport_info3"
                    rows="4"
                    required
                    style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                    placeholder="নাম: John Doe
এনআইডি/নিবন্ধন নং: 1234567890
জন্ম তারিখ: 1990-01-15"
            >নাম:
এনআইডি/নিবন্ধন নং:
জন্ম তারিখ: </textarea>
                        </div>

                        <!-- Hidden fields for controller validation -->
                        <input type="hidden" name="form_data[name]" id="hidden_name3">
                        <input type="hidden" name="form_data[nid_no]" id="hidden_nid_no3">
                        <input type="hidden" name="form_data[dob]" id="hidden_dob3">

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-success" onclick="submitPassportForm3()">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- Form 4: BMET -->
                <div id="form4" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">BMET 78% Approve</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.passport.order.store') }}" method="POST" class="needs-validation" id="passportForm4" novalidate>
                        @csrf
                        <input type="hidden" name="form_type" value="4">
                        <div class="form-group mb-3">
            <textarea
                    class="form-control"
                    id="passport_info4"
                    rows="4"
                    required
                    style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                    placeholder="নাম: John Doe
পাসপোর্ট নং: A12345678
জন্ম তারিখ: 1990-01-15"
            >নাম:
পাসপোর্ট নং:
জন্ম তারিখ: </textarea>
                        </div>

                        <!-- Hidden fields for controller validation -->
                        <input type="hidden" name="form_data[name]" id="hidden_name4">
                        <input type="hidden" name="form_data[passport_no]" id="hidden_passport_no4">
                        <input type="hidden" name="form_data[dob]" id="hidden_dob4">

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-success" onclick="submitPassportForm4()">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <script>
                    function submitPassportForm3() {
                        const textarea = document.getElementById('passport_info3');
                        const lines = textarea.value.split('\n');

                        let name = '';
                        let nidNo = '';
                        let dob = '';

                        lines.forEach(line => {
                            if (line.includes('নাম:')) {
                                name = line.split('নাম:')[1].trim();
                            }
                            if (line.includes('এনআইডি/নিবন্ধন নং:')) {
                                nidNo = line.split('এনআইডি/নিবন্ধন নং:')[1].trim();
                            }
                            if (line.includes('জন্ম তারিখ:')) {
                                dob = line.split('জন্ম তারিখ:')[1].trim();
                            }
                        });

                        if (!name) {
                            alert('অনুগ্রহ করে নাম লিখুন');
                            return false;
                        }

                        if (!nidNo) {
                            alert('অনুগ্রহ করে এনআইডি/নিবন্ধন নম্বর লিখুন');
                            return false;
                        }

                        if (!dob) {
                            alert('অনুগ্রহ করে জন্ম তারিখ লিখুন');
                            return false;
                        }

                        const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
                        if (!dateRegex.test(dob)) {
                            alert('অনুগ্রহ করে জন্ম তারিখ YYYY-MM-DD ফরম্যাটে লিখুন (উদাহরণ: 1990-01-15)');
                            return false;
                        }

                        document.getElementById('hidden_name3').value = name;
                        document.getElementById('hidden_nid_no3').value = nidNo;
                        document.getElementById('hidden_dob3').value = dob;

                        document.getElementById('passportForm3').submit();
                        return true;
                    }

                    function submitPassportForm4() {
                        const textarea = document.getElementById('passport_info4');
                        const lines = textarea.value.split('\n');

                        let name = '';
                        let passportNo = '';
                        let dob = '';

                        lines.forEach(line => {
                            if (line.includes('নাম:')) {
                                name = line.split('নাম:')[1].trim();
                            }
                            if (line.includes('পাসপোর্ট নং:')) {
                                passportNo = line.split('পাসপোর্ট নং:')[1].trim();
                            }
                            if (line.includes('জন্ম তারিখ:')) {
                                dob = line.split('জন্ম তারিখ:')[1].trim();
                            }
                        });

                        if (!name) {
                            alert('অনুগ্রহ করে নাম লিখুন');
                            return false;
                        }

                        if (!passportNo) {
                            alert('অনুগ্রহ করে পাসপোর্ট নম্বর লিখুন');
                            return false;
                        }

                        if (!dob) {
                            alert('অনুগ্রহ করে জন্ম তারিখ লিখুন');
                            return false;
                        }

                        const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
                        if (!dateRegex.test(dob)) {
                            alert('অনুগ্রহ করে জন্ম তারিখ YYYY-MM-DD ফরম্যাটে লিখুন (উদাহরণ: 1990-01-15)');
                            return false;
                        }

                        document.getElementById('hidden_name4').value = name;
                        document.getElementById('hidden_passport_no4').value = passportNo;
                        document.getElementById('hidden_dob4').value = dob;

                        document.getElementById('passportForm4').submit();
                        return true;
                    }
                </script>

                <!-- Orders Table -->
                <div class="mt-5">
                    <div class="mb-3" style="background: linear-gradient(90deg, #1e4c78 0%, #3498db 100%); color: white; padding: 10px 15px; border-radius: 4px;">
                        <h5 class="m-0 text-center">অর্ডার তালিকা</h5>
                    </div>

                    @if(isset($orders))
                        <div class="alert alert-info">
                            সর্বমোট অর্ডার: {{ $orders->count() }} টি
                        </div>
                    @endif

                    <!-- Desktop View -->
                    <div class="classic-table d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>ক্রমিক</th>
                                    <th>সেবার ধরন</th>
                                    <th>নাম</th>
                                    <th>পাসপোর্ট/এনআইডি</th>
                                    <th>তারিখ</th>
                                    <th>স্ট্যাটাস</th>
                                    <th>ডাউনলোড</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse(($orders ?? [])->sortByDesc('created_at') as $key => $order)
                                    <tr>
                                        <td>{{ ($orders->count() - $key) }}</td>
                                        <td>
                                            @switch($order->form_type)
                                                @case(1)
                                                    MRP to SB Copy
                                                    @break
                                                @case(2)
                                                    E-Passport to Delivery
                                                    @break
                                                @case(3)
                                                    NID to Passport Info
                                                    @break
                                                @case(4)
                                                    BMET 78% Approve
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @php
                                                try {
                                                    $formData = is_string($order->form_data) ? json_decode($order->form_data, true) : $order->form_data;
                                                    echo isset($formData['name']) ? $formData['name'] : 'N/A';
                                                } catch (\Exception $e) {
                                                    echo 'N/A';
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                                try {
                                                    if (isset($formData['passport_no'])) {
                                                        echo $formData['passport_no'];
                                                    } elseif (isset($formData['nid_no'])) {
                                                        echo $formData['nid_no'];
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                } catch (\Exception $e) {
                                                    echo 'N/A';
                                                }
                                            @endphp
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if($order->status == 0)
                                                <span class="text-warning fw-bold">⏳ পেন্ডিং</span>
                                            @elseif($order->status == 1)
                                                <span class="text-info fw-bold">✓ অনুমোদিত</span>
                                            @elseif($order->status == 2)
                                                <span class="text-success fw-bold">✔ সম্পন্ন</span>
                                            @else
                                                <span class="text-danger fw-bold">✕ বাতিল</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->status == 3 && $order->reject_note)
                                                <div class="text-danger mb-0" style="padding: 8px 12px; font-size: 0.9rem;">
                                                    <strong>বাতিলের কারণ:</strong><br>
                                                    {{ $order->reject_note }}
                                                </div>
                                            @elseif($order->status == 2 && $order->admin_note && (strpos($order->admin_note, '/passport_pdfs/') === 0 || strpos($order->admin_note, '/storage/') === 0))
                                                <a href="{{ route('user.passport.order.download', $order->id) }}" class="btn btn-sm" style="background-color: #27ae60; color: white; border: none; padding: 6px 12px; border-radius: 4px;" title="ডাউনলোড করুন">
                                                    <i class="fas fa-download"></i> ডাউনলোড
                                                </a>
                                            @elseif($order->status == 2 && $order->text)
                                                <div class="text-info mb-0" style="padding: 8px 12px; font-size: 0.9rem; display: flex; justify-content: space-between; align-items: center;">
                                                    <div>
                                                        <strong>অ্যাডমিনের নোট:</strong><br>
                                                        {{ $order->text }}
                                                    </div>
                                                    <button onclick="copyText('{{ addslashes($order->text) }}')" class="btn btn-sm" style="background-color: #3498db; color: white; border: none; padding: 6px 12px; border-radius: 4px; margin-left: 10px; flex-shrink: 0;" title="কপি করুন">
                                                        <i class="fas fa-copy"></i> কপি
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-muted">নেই</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3">কোন অর্ডার নেই</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile View -->
                    <div class="d-md-none">
                        @forelse(($orders ?? [])->sortByDesc('created_at') as $key => $order)
                            <div class="mobile-order-row">
                                <div class="row-number">{{ ($orders->count() - $key) }}</div>
                                <div class="row-content">
                                    <div class="info-line">
                            <span class="service-type">
                                @switch($order->form_type)
                                    @case(1)
                                        MRP to SB Copy
                                        @break
                                    @case(2)
                                        E-Passport to Delivery
                                        @break
                                    @case(3)
                                        NID to Passport Info
                                        @break
                                    @case(4)
                                        BMET 78% Approve
                                        @break
                                @endswitch
                            </span>
                                    </div>
                                    <div class="info-line">
                                        @php
                                            try {
                                                $formData = is_string($order->form_data) ? json_decode($order->form_data, true) : $order->form_data;
                                                $name = isset($formData['name']) ? $formData['name'] : 'N/A';
                                                $documentNo = '';
                                                if (isset($formData['passport_no'])) {
                                                    $documentNo = $formData['passport_no'];
                                                } elseif (isset($formData['nid_no'])) {
                                                    $documentNo = $formData['nid_no'];
                                                }
                                            } catch (\Exception $e) {
                                                $name = 'N/A';
                                                $documentNo = 'N/A';
                                            }
                                        @endphp
                                        <span>{{ $documentNo }}</span>
                                        <span class="text-muted">|</span>
                                        <span>{{ $name }}</span>
                                    </div>
                                    <div class="info-line">
                                        @if($order->status == 0)
                                            <span class="text-warning fw-bold">⏳ পেন্ডিং</span>
                                        @elseif($order->status == 1)
                                            <span class="text-info fw-bold">✓ অনুমোদিত</span>
                                        @elseif($order->status == 2)
                                            <span class="text-success fw-bold">✔ সম্পন্ন</span>
                                        @else
                                            <span class="text-danger fw-bold">✕ বাতিল</span>
                                        @endif
                                        <span class="order-date">{{ $order->created_at->format('d/m/Y') }}</span>
                                    </div>

                                    @if($order->status == 3 && $order->reject_note)
                                        <div class="info-line">
                                            <div class="p-2 bg-light border-start border-3 border-danger rounded reason-box">
                                                <strong>কারণ:</strong> {{ $order->reject_note ?? 'কোন কারণ উল্লেখ করা হয়নি' }}
                                            </div>
                                        </div>
                                    @elseif($order->status == 2 && $order->admin_note && (strpos($order->admin_note, '/passport_pdfs/') === 0 || strpos($order->admin_note, '/storage/') === 0))
                                        <div class="info-line">
                                            <a href="{{ route('user.passport.order.download', $order->id) }}" class="btn btn-sm" style="background-color: #27ae60; color: white; border: none; width: 100%;">
                                                <i class="fas fa-download"></i> ডাউনলোড
                                            </a>
                                        </div>
                                    @elseif($order->status == 2 && $order->text)
                                        <div class="info-line">
                                            <div class="alert alert-info mb-0" style="padding: 8px 12px; font-size: 0.85rem; width: 100%; display: flex; justify-content: space-between; align-items: center;">
                                                <div>
                                                    <strong>অ্যাডমিনের নোট:</strong><br>
                                                    {{ $order->text }}
                                                </div>
                                                <button onclick="copyText('{{ addslashes($order->text) }}')" class="btn btn-sm" style="background-color: #3498db; color: white; border: none; margin-left: 8px; flex-shrink: 0;">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="info-line">
                                            <span class="text-muted">নেই</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-3 text-muted">
                                কোন অর্ডার নেই
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleForm(formId) {
                var forms = document.querySelectorAll('.form-container');
                var buttons = document.querySelectorAll('.btn-option');
                var targetForm = document.getElementById('form' + formId);

                forms.forEach(function(form) {
                    form.classList.remove('active');
                });

                buttons.forEach(function(btn) {
                    btn.classList.remove('active');
                });

                if (targetForm) {
                    targetForm.classList.add('active');

                    buttons.forEach(function(btn, index) {
                        if (index + 1 === formId || btn.getAttribute('onclick') === 'toggleForm(' + formId + ')') {
                            btn.classList.add('active');
                        }
                    });

                    setTimeout(function() {
                        targetForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }, 100);
                }
            }

            function hideAllForms() {
                var forms = document.querySelectorAll('.form-container');
                var buttons = document.querySelectorAll('.btn-option');

                forms.forEach(function(form) {
                    form.classList.remove('active');
                });

                buttons.forEach(function(btn) {
                    btn.classList.remove('active');
                });
            }

            function copyText(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(function() {
                        console.log('Text copied successfully');
                    }).catch(function(err) {
                        fallbackCopyText(text);
                    });
                } else {
                    fallbackCopyText(text);
                }
            }

            function fallbackCopyText(text) {
                var textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();

                try {
                    document.execCommand('copy');
                } catch (err) {
                    console.error('Copy failed:', err);
                }

                document.body.removeChild(textarea);
            }

            document.addEventListener('DOMContentLoaded', function() {
                var forms = document.querySelectorAll('.needs-validation');

                forms.forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    });
                });
            });
        </script>

@endsection