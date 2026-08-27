@extends('user.layouts.app')

@section('title')
    সীম বায়োমেট্রিক    সার্ভিস
@endsection

@push('style')
    <style>
        .classic-card {
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
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
            padding-bottom: 20px;
            margin-bottom: 25px;
            border-bottom: 2px solid #e9ecef;
        }

        .modal-header .modal-title {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: #6c757d;
            padding: 5px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .close-modal:hover {
            color: #dc3545;
            background: #f8f9fa;
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
            text-align: left;
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
            .option-grid {
                gap: 6px;
                padding: 8px;
            }

            .btn-option {
                height: 60px;
                min-height: 60px;
                max-height: 60px;
                padding: 6px;
                display: flex;
                align-items: center;
                justify-content: flex-start;
            }

            .btn-option .btn-text {
                font-size: 0.7rem;
                line-height: 1.2;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                word-break: break-word;
                margin: 0;
            }

            .btn-option i {
                font-size: 0.85rem;
                margin-right: 4px;
                width: 12px;
                flex-shrink: 0;
            }

            .btn-option .badge {
                font-size: 0.65rem;
                padding: 2px 4px;
                margin-left: 3px;
                flex-shrink: 0;
                min-width: 35px;
                text-align: center;
            }

            .text-block {
                flex: 1;
                min-width: 0;
                padding-right: 4px;
                display: flex;
                align-items: center;
            }

            .mobile-order-row {
                font-size: 0.8rem;
            }
        }
    </style>

    <script>
        window.toggleForm = function(operator) {
            hideAllForms();

            var targetForm = document.getElementById(operator);
            var selectedButton = document.querySelector(`button[onclick*="toggleForm('${operator}')"]`);

            if (targetForm) {
                targetForm.classList.add('active');

                if (selectedButton) {
                    selectedButton.classList.add('active');
                }

                setTimeout(function() {
                    targetForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            } else {
                console.error('Form not found:', operator);
            }
        };

        window.hideAllForms = function() {
            var forms = document.querySelectorAll('.form-container');
            var buttons = document.querySelectorAll('.btn-option');

            forms.forEach(function(form) {
                form.classList.remove('active');
            });

            buttons.forEach(function(btn) {
                btn.classList.remove('active');
            });
        };

        window.submitForm = function(operator) {
            const textarea = document.getElementById('number_info_' + operator);
            if (!textarea) {
                alert('ফর্মে সমস্যা হয়েছে');
                return false;
            }

            const lines = textarea.value.split('\n');
            let number = '';

            lines.forEach(line => {
                if (line.includes('নাম্বার:')) {
                    number = line.split('নাম্বার:')[1].trim();
                }
            });

            if (!number) {
                alert('অনুগ্রহ করে নাম্বার দিন');
                return false;
            }

            let numberRegex;
            let operatorName;

            switch(operator) {
                case 'gp':
                    numberRegex = /^01[7]\d{8}$/;
                    operatorName = 'জিপি';
                    break;
                case 'robi':
                    numberRegex = /^01[8/6]\d{8}$/;
                    operatorName = 'রবি';
                    break;
                case 'banglalink':
                    numberRegex = /^01[9]\d{8}$/;
                    operatorName = 'বাংলালিংক';
                    break;
                case 'teletalk':
                    numberRegex = /^01[5]\d{8}$/;
                    operatorName = 'টেলিটক';
                    break;
                case 'brilliant':
                    numberRegex = /^01\d{9}$/;
                    operatorName = 'ব্রিরিলিয়ান্ট';
                    break;
            }

            if (!numberRegex.test(number)) {
                alert('অনুগ্রহ করে সঠিক ' + operatorName + ' নাম্বার ফরম্যাট ব্যবহার করুন');
                return false;
            }

            const hiddenField = document.getElementById('hidden_number_' + operator);
            if (!hiddenField) {
                alert('ফর্মে সমস্যা হয়েছে');
                return false;
            }

            hiddenField.value = number;

            const form = document.getElementById(operator + 'Form');
            if (form) {
                form.submit();
            } else {
                alert('ফর্মে সমস্যা হয়েছে');
                return false;
            }

            return true;
        };

        window.copyText = function(text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function() {
                    console.log('Text copied to clipboard successfully');
                }).catch(function(err) {
                    console.error('Failed to copy:', err);
                });
            } else {
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);

                textarea.select();
                document.execCommand('copy');

                document.body.removeChild(textarea);
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            hideAllForms();
        });
    </script>
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
                    <button type="button" class="btn-option" onclick="toggleForm('gp')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;জিপি</span>
                        </div>
                        <span class="badge">৳{{ $simTypes[1]->cost ?? 50 }}</span>
                    </button>
                    <button type="button" class="btn-option" onclick="toggleForm('robi')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;রবি/এয়ারটেল</span>
                        </div>
                        <span class="badge">৳{{ $simTypes[2]->cost ?? 50 }}</span>
                    </button>
                    <button type="button" class="btn-option" onclick="toggleForm('banglalink')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;বাংলালিংক</span>
                        </div>
                        <span class="badge">৳{{ $simTypes[3]->cost ?? 50 }}</span>
                    </button>
                </div>
                <div class="option-column">
                    <button type="button" class="btn-option" onclick="toggleForm('teletalk')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;টেলিটক</span>
                        </div>
                        <span class="badge">৳{{ $simTypes[4]->cost ?? 50 }}</span>
                    </button>
                    <button type="button" class="btn-option" onclick="toggleForm('brilliant')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;ব্রিরিলিয়ান্ট নং টু অরজিনাল নং</span>
                        </div>
                        <span class="badge">৳{{ $simTypes[5]->cost ?? 50 }}</span>
                    </button>
                </div>
            </div>

            <!-- Forms Container -->
            <div class="forms-wrapper mt-4">
                <!-- GP Form -->
                <div id="gp" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">জিপি নাম্বার বায়োমেট্রিক</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.conversion.store') }}" method="POST" class="needs-validation" id="gpForm" novalidate>
                        @csrf
                        <input type="hidden" name="type" value="1">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_gp"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নাম্বার: ০১৭XXXXXXXX">নাম্বার: </textarea>
                        </div>

                        <input type="hidden" name="number" id="hidden_number_gp">

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-primary" onclick="submitForm('gp')">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- Robi Form -->
                <div id="robi" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">রবি/এয়ারটেল নাম্বার বায়োমেট্রিক</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.conversion.store') }}" method="POST" class="needs-validation" id="robiForm" novalidate>
                        @csrf
                        <input type="hidden" name="type" value="2">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_robi"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নাম্বার: ০১৮XXXXXXXX">নাম্বার: </textarea>
                        </div>

                        <input type="hidden" name="number" id="hidden_number_robi">

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-danger" onclick="submitForm('robi')">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- Banglalink Form -->
                <div id="banglalink" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">বাংলালিংক নাম্বার বায়োমেট্রিক</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.conversion.store') }}" method="POST" class="needs-validation" id="banglalinkForm" novalidate>
                        @csrf
                        <input type="hidden" name="type" value="3">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_banglalink"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নাম্বার: ০১৯XXXXXXXX">নাম্বার: </textarea>
                        </div>

                        <input type="hidden" name="number" id="hidden_number_banglalink">

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-success" onclick="submitForm('banglalink')">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- Teletalk Form -->
                <div id="teletalk" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">টেলিটক নাম্বার বায়োমেট্রিক</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.conversion.store') }}" method="POST" class="needs-validation" id="teletalkForm" novalidate>
                        @csrf
                        <input type="hidden" name="type" value="4">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_teletalk"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নাম্বার: ০১৫XXXXXXXX">নাম্বার: </textarea>
                        </div>

                        <input type="hidden" name="number" id="hidden_number_teletalk">

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-info" onclick="submitForm('teletalk')">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- Brilliant Form -->
                <div id="brilliant" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">ব্রিরিলিয়ান্ট নাম্বার বায়োমেট্রিক</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.conversion.store') }}" method="POST" class="needs-validation" id="brilliantForm" novalidate>
                        @csrf
                        <input type="hidden" name="type" value="5">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_brilliant"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নাম্বার: ০১XXXXXXXXX">নাম্বার: </textarea>
                        </div>

                        <input type="hidden" name="number" id="hidden_number_brilliant">

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-warning" onclick="submitForm('brilliant')">জমা দিন</button>
                        </div>
                    </form>
                </div>
            </div>

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
                                <th>অপারেটর</th>
                                <th>নাম্বার</th>
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
                                        @switch($order->type)
                                            @case(1) জিপি @break
                                            @case(2) রবি/এয়ারটেল @break
                                            @case(3) বাংলালিংক @break
                                            @case(4) টেলিটক @break
                                            @case(5) ব্রিরিলিয়ান্ট @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @php
                                            try {
                                                $formData = is_string($order->form_data) ? json_decode($order->form_data) : $order->form_data;
                                                echo $formData->number ?? 'N/A';
                                            } catch (\Exception $e) {
                                                echo 'N/A';
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</td>
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
                                        @if($order->status == 3)
                                            <div class="text-danger mb-0" style="font-size: 0.8rem; width: 100%;">
                                                <strong>বাতিলের কারণ:</strong><br>
                                                {{ $order->reject_note ?? 'কোন কারণ উল্লেখ করা হয়নি' }}
                                            </div>
                                        @elseif($order->admin_note && file_exists(public_path($order->admin_note)))
                                            <a href="{{ route('user.sim.conversion.download-pdf', $order->id) }}" class="btn btn-sm btn-primary" download title="PDF ডাউনলোড করুন">
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
                                    <td colspan="6" class="text-center text-muted py-3">কোন অর্ডার নেই</td>
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
                                @switch($order->type)
                                    @case(1) জিপি @break
                                    @case(2) রবি/এয়ারটেল @break
                                    @case(3) বাংলালিংক @break
                                    @case(4) টেলিটক @break
                                    @case(5) ব্রিরিলিয়ান্ট @break
                                @endswitch
                            </span>
                                    <span>
                                @php
                                    try {
                                        $formData = is_string($order->form_data) ? json_decode($order->form_data) : $order->form_data;
                                        echo $formData->number ?? 'N/A';
                                    } catch (\Exception $e) {
                                        echo 'N/A';
                                    }
                                @endphp
                            </span>
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
                                    <span class="order-date">{{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</span>
                                </div>
                                <div class="info-line">
                                    @if($order->status == 3)
                                        <div class="info-line">
                                            <div class="p-2 bg-light border-start border-3 border-danger rounded reason-box">
                                                <strong>কারণ:</strong> {{ $order->reject_note ?? 'কোন কারণ উল্লেখ করা হয়নি' }}
                                            </div>
                                        </div>
                                    @elseif($order->admin_note && file_exists(public_path($order->admin_note)))
                                        <a href="{{ route('user.sim.conversion.download-pdf', $order->id) }}" class="btn btn-sm btn-primary" download style="width: 100%;" title="PDF ডাউনলোড করুন">
                                            <i class="fas fa-download"></i> ডাউনলোড
                                        </a>
                                    @elseif($order->status == 2 && $order->text)
                                        <div class="text-info mb-0" style="padding: 8px 12px; font-size: 0.85rem; width: 100%; display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <strong>অ্যাডমিনের নোট:</strong><br>
                                                {{ $order->text }}
                                            </div>
                                            <button onclick="copyText('{{ addslashes($order->text) }}')" class="btn btn-sm" style="background-color: #3498db; color: white; border: none; margin-left: 8px; flex-shrink: 0;">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-muted">নেই</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-3 text-muted">
                            কোন অর্ডার নেই
                        </div>
                    @endforelse
                </div>

                @if($orders->hasPages())
                    {{ $orders->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection