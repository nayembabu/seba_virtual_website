@extends('user.layouts.app')

@section('title')
    সিম নেটওয়ার্ক সার্ভিস
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
        window.toggleForm = function(formId) {
            hideAllForms();

            var targetForm = document.getElementById(formId);
            var selectedButton = document.querySelector(`button[onclick*="toggleForm('${formId}')"]`);

            if (targetForm) {
                targetForm.classList.add('active');

                if (selectedButton) {
                    selectedButton.classList.add('active');
                }

                setTimeout(function() {
                    targetForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            } else {
                console.error('Form not found:', formId);
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

        window.submitForm = function(formId, type) {
            const form = document.getElementById(formId + 'Form');
            if (!form) {
                alert('ফর্মে সমস্যা হয়েছে');
                return false;
            }

            const textarea = document.getElementById('number_info_' + formId);
            if (!textarea) {
                alert('ফর্মে সমস্যা হয়েছে');
                return false;
            }

            const lines = textarea.value.split('\n');

            if (type === 1 || type === 2 || type === 3 || type === 4 || type === 8) {
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

                const hiddenField = document.getElementById('hidden_number_' + formId);
                if (hiddenField) {
                    hiddenField.value = number;
                }

            } else if (type === 5) {
                let nid10 = '';
                let nid17 = '';
                lines.forEach(line => {
                    if (line.includes('Nid 10 Digit:')) {
                        nid10 = line.split('Nid 10 Digit:')[1].trim();
                    }
                    if (line.includes('Nid 17 Digit:')) {
                        nid17 = line.split('Nid 17 Digit:')[1].trim();
                    }
                });

                if (!nid10 && !nid17) {
                    alert('অনুগ্রহ করে কমপক্ষে একটি NID নাম্বার দিন');
                    return false;
                }

                document.getElementById('hidden_nid_10_' + formId).value = nid10;
                document.getElementById('hidden_nid_17_' + formId).value = nid17;

            } else if (type === 6) {
                let imei1 = '';
                let imei2 = '';
                lines.forEach(line => {
                    if (line.includes('IMEI-1 নাম্বার দেন:')) {
                        imei1 = line.split('IMEI-1 নাম্বার দেন:')[1].trim();
                    }
                    if (line.includes('IMEI-2 নাম্বার দেন:')) {
                        imei2 = line.split('IMEI-2 নাম্বার দেন:')[1].trim();
                    }
                });

                if (!imei1) {
                    alert('অনুগ্রহ করে IMEI-1 নাম্বার দিন');
                    return false;
                }

                document.getElementById('hidden_imei_1_' + formId).value = imei1;
                document.getElementById('hidden_imei_2_' + formId).value = imei2;

            } else if (type === 7) {
                let imei1 = '';
                let imei2 = '';
                let lastUsedNumber = '';
                let lostDate = '';

                lines.forEach(line => {
                    if (line.includes('IMEI-1 নাম্বার দেন:')) {
                        imei1 = line.split('IMEI-1 নাম্বার দেন:')[1].trim();
                    }
                    if (line.includes('IMEI-2 নাম্বার দেন:')) {
                        imei2 = line.split('IMEI-2 নাম্বার দেন:')[1].trim();
                    }
                    if (line.includes('সর্বশেষ ব্যবহৃত নাম্বর:')) {
                        lastUsedNumber = line.split('সর্বশেষ ব্যবহৃত নাম্বর:')[1].trim();
                    }
                    if (line.includes('হারানোর তারিখ:')) {
                        lostDate = line.split('হারানোর তারিখ:')[1].trim();
                    }
                });

                if (!imei1) {
                    alert('অনুগ্রহ করে IMEI-1 নাম্বার দিন');
                    return false;
                }

                document.getElementById('hidden_imei_1_' + formId).value = imei1;
                document.getElementById('hidden_imei_2_' + formId).value = imei2;
                document.getElementById('hidden_last_used_number_' + formId).value = lastUsedNumber;
                document.getElementById('hidden_lost_date_' + formId).value = lostDate;

            } else if (type === 9) {
                let bkashNumber = '';
                lines.forEach(line => {
                    if (line.includes('বিকাশ নাম্বার:')) {
                        bkashNumber = line.split('বিকাশ নাম্বার:')[1].trim();
                    }
                });

                if (!bkashNumber) {
                    alert('অনুগ্রহ করে বিকাশ নাম্বার দিন');
                    return false;
                }

                document.getElementById('hidden_bkash_number_' + formId).value = bkashNumber;

            } else if (type === 10) {
                let nagadNumber = '';
                lines.forEach(line => {
                    if (line.includes('নগদ নাম্বার:')) {
                        nagadNumber = line.split('নগদ নাম্বার:')[1].trim();
                    }
                });

                if (!nagadNumber) {
                    alert('অনুগ্রহ করে নগদ নাম্বার দিন');
                    return false;
                }

                document.getElementById('hidden_nagad_number_' + formId).value = nagadNumber;

            } else if (type === 11) {
                let rocketNumber = '';
                lines.forEach(line => {
                    if (line.includes('রকেট নাম্বার:')) {
                        rocketNumber = line.split('রকেট নাম্বার:')[1].trim();
                    }
                });

                if (!rocketNumber) {
                    alert('অনুগ্রহ করে রকেট নাম্বার দিন');
                    return false;
                }

                document.getElementById('hidden_rocket_number_' + formId).value = rocketNumber;
            }

            form.submit();

            return true;
        };

        window.copyText = function(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';

            document.body.appendChild(textarea);

            textarea.select();
            document.execCommand('copy');

            document.body.removeChild(textarea);

            alert('✓ টেক্সট কপি হয়েছে!');
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
                    <button type="button" class="btn-option" onclick="toggleForm('call_list')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;কল লিস্ট ৩ মাস</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[1]->cost ?? 100 }}</span>
                    </button>

                    <button type="button" class="btn-option" onclick="toggleForm('robi_sms')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;রবি/এয়ারটেল SMS লিস্ট</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[2]->cost ?? 80 }}</span>
                    </button>

                    <button type="button" class="btn-option" onclick="toggleForm('banglalink_sms')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;বাংলালিংক/গ্রামীন SMS লিস্ট</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[3]->cost ?? 80 }}</span>
                    </button>

                    <button type="button" class="btn-option" onclick="toggleForm('number_to_location')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;নাম্বার টু লোকেশন</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[4]->cost ?? 50 }}</span>
                    </button>

                    <button type="button" class="btn-option" onclick="toggleForm('nid_to_numbers')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;NID টু সকল নাম্বার</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[5]->cost ?? 150 }}</span>
                    </button>

                    <button type="button" class="btn-option" onclick="toggleForm('imei_to_location')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;IMEI টু লোকেশন</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[6]->cost ?? 120 }}</span>
                    </button>
                </div>

                <div class="option-column">
                    <button type="button" class="btn-option" onclick="toggleForm('imei_to_active')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;IMEI টু এক্টিভ নাম্বার</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[7]->cost ?? 120 }}</span>
                    </button>

                    <button type="button" class="btn-option" onclick="toggleForm('number_to_imei')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;নাম্বার টু IMEI</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[8]->cost ?? 100 }}</span>
                    </button>

                    <button type="button" class="btn-option" onclick="toggleForm('bkash_info')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;বিকাশ ইনফরমেশন</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[9]->cost ?? 200 }}</span>
                    </button>

                    <button type="button" class="btn-option" onclick="toggleForm('nagad_info')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;নগদ ইনফরমেশন</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[10]->cost ?? 200 }}</span>
                    </button>

                    <button type="button" class="btn-option" onclick="toggleForm('rocket_info')">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block">
                            <span class="btn-text">&nbsp;রকেট ইনফরমেশন</span>
                        </div>
                        <span class="badge">৳{{ $simNetworkTypes[11]->cost ?? 200 }}</span>
                    </button>
                </div>
            </div>

            <!-- Forms Container -->
            <div class="forms-wrapper mt-4">
                <!-- 1. Call List 3 Month Form -->
                <div id="call_list" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">কল লিস্ট ৩ মাস</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="call_listForm">
                        @csrf
                        <input type="hidden" name="type" value="1">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_call_list"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নাম্বার: ০১XXXXXXXXX">নাম্বার: </textarea>
                        </div>
                        <input type="hidden" name="number" id="hidden_number_call_list">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-primary" onclick="submitForm('call_list', 1)">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- 2. Robi/Airtel SMS List Form -->
                <div id="robi_sms" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">রবি/এয়ারটেল SMS লিস্ট</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="robi_smsForm">
                        @csrf
                        <input type="hidden" name="type" value="2">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_robi_sms"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নাম্বার: ০১XXXXXXXXX">নাম্বার: </textarea>
                        </div>
                        <input type="hidden" name="number" id="hidden_number_robi_sms">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-danger" onclick="submitForm('robi_sms', 2)">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- 3. Banglalink/Grameenphone SMS List Form -->
                <div id="banglalink_sms" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">বাংলালিংক/গ্রামীন SMS লিস্ট</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="banglalink_smsForm">
                        @csrf
                        <input type="hidden" name="type" value="3">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_banglalink_sms"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নাম্বার: ০১XXXXXXXXX">নাম্বার: </textarea>
                        </div>
                        <input type="hidden" name="number" id="hidden_number_banglalink_sms">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-success" onclick="submitForm('banglalink_sms', 3)">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- 4. Number to Location Form -->
                <div id="number_to_location" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">নাম্বার টু লোকেশন</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="number_to_locationForm">
                        @csrf
                        <input type="hidden" name="type" value="4">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_number_to_location"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নাম্বার: ০১XXXXXXXXX">নাম্বার: </textarea>
                        </div>
                        <input type="hidden" name="number" id="hidden_number_number_to_location">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-info" onclick="submitForm('number_to_location', 4)">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- 5. NID to All Numbers Form -->
                <div id="nid_to_numbers" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">NID টু সকল নাম্বার</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="nid_to_numbersForm">
                        @csrf
                        <input type="hidden" name="type" value="5">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_nid_to_numbers"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="Nid 10 Digit: &#10;Nid 17 Digit: ">Nid 10 Digit:
Nid 17 Digit: </textarea>
                        </div>
                        <input type="hidden" name="nid_10" id="hidden_nid_10_nid_to_numbers">
                        <input type="hidden" name="nid_17" id="hidden_nid_17_nid_to_numbers">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-warning" onclick="submitForm('nid_to_numbers', 5)">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- 6. IMEI to Location Form -->
                <div id="imei_to_location" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">IMEI টু লোকেশন</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="imei_to_locationForm">
                        @csrf
                        <input type="hidden" name="type" value="6">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_imei_to_location"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="IMEI-1 নাম্বার দেন: &#10;IMEI-2 নাম্বার দেন: ">IMEI-1 নাম্বার দেন:
IMEI-2 নাম্বার দেন: </textarea>
                        </div>
                        <input type="hidden" name="imei_1" id="hidden_imei_1_imei_to_location">
                        <input type="hidden" name="imei_2" id="hidden_imei_2_imei_to_location">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-primary" onclick="submitForm('imei_to_location', 6)">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- 7. IMEI to Active Number Form -->
                <div id="imei_to_active" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">IMEI টু এক্টিভ নাম্বার</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="imei_to_activeForm">
                        @csrf
                        <input type="hidden" name="type" value="7">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_imei_to_active"
                                rows="6"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="IMEI-1 নাম্বার দেন: &#10;IMEI-2 নাম্বার দেন: &#10;সর্বশেষ ব্যবহৃত নাম্বর: &#10;হারানোর তারিখ: ">IMEI-1 নাম্বার দেন:
IMEI-2 নাম্বার দেন:

সর্বশেষ ব্যবহৃত নাম্বর:
হারানোর তারিখ: </textarea>
                        </div>
                        <input type="hidden" name="imei_1" id="hidden_imei_1_imei_to_active">
                        <input type="hidden" name="imei_2" id="hidden_imei_2_imei_to_active">
                        <input type="hidden" name="last_used_number" id="hidden_last_used_number_imei_to_active">
                        <input type="hidden" name="lost_date" id="hidden_lost_date_imei_to_active">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-danger" onclick="submitForm('imei_to_active', 7)">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- 8. Number to IMEI Form -->
                <div id="number_to_imei" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">নাম্বার টু IMEI</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="number_to_imeiForm">
                        @csrf
                        <input type="hidden" name="type" value="8">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_number_to_imei"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নাম্বার: ০১XXXXXXXXX">নাম্বার: </textarea>
                        </div>
                        <input type="hidden" name="number" id="hidden_number_number_to_imei">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-success" onclick="submitForm('number_to_imei', 8)">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- 9. Bkash Information Form -->
                <div id="bkash_info" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">বিকাশ ইনফরমেশন</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="bkash_infoForm">
                        @csrf
                        <input type="hidden" name="type" value="9">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_bkash_info"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="বিকাশ নাম্বার: ০১XXXXXXXXX">বিকাশ নাম্বার: </textarea>
                        </div>
                        <input type="hidden" name="bkash_number" id="hidden_bkash_number_bkash_info">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-info" onclick="submitForm('bkash_info', 9)">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- 10. Nagad Information Form -->
                <div id="nagad_info" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">নগদ ইনফরমেশন</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="nagad_infoForm">
                        @csrf
                        <input type="hidden" name="type" value="10">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_nagad_info"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="নগদ নাম্বার: ০১XXXXXXXXX">নগদ নাম্বার: </textarea>
                        </div>
                        <input type="hidden" name="nagad_number" id="hidden_nagad_number_nagad_info">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-warning" onclick="submitForm('nagad_info', 10)">জমা দিন</button>
                        </div>
                    </form>
                </div>

                <!-- 11. Rocket Information Form -->
                <div id="rocket_info" class="form-container">
                    <div class="modal-header">
                        <h5 class="modal-title">রকেট ইনফরমেশন</h5>
                        <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                    </div>
                    <form action="{{ route('user.sim.network.store') }}" method="POST" id="rocket_infoForm">
                        @csrf
                        <input type="hidden" name="type" value="11">
                        <div class="form-group mb-3">
                        <textarea
                                class="form-control"
                                id="number_info_rocket_info"
                                rows="4"
                                required
                                style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                                placeholder="রকেট নাম্বার: ০১XXXXXXXXX">রকেট নাম্বার: </textarea>
                        </div>
                        <input type="hidden" name="rocket_number" id="hidden_rocket_number_rocket_info">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                            <button type="button" class="btn btn-primary" onclick="submitForm('rocket_info', 11)">জমা দিন</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="mt-5">
                <div class="mb-3" style="background: linear-gradient(90deg, #1e4c78 0%, #3498db 100%); color: white; padding: 10px 15px; border-radius: 4px;">
                    <h5 class="m-0 text-center">অর্ডার তালিকা</h5>
                </div>

                @if(isset($orders) && $orders->count() > 0)
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
                                <th>সার্ভিস</th>
                                <th>তথ্য</th>
                                <th>তারিখ</th>
                                <th>স্ট্যাটাস</th>
                                <th>ডাউনলোড</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse(($orders ?? [])->sortByDesc('created_at') as $key => $order)
                                <tr>
                                    <td>{{ $orders->count() - $key }}</td>
                                    <td>
                                        @switch($order->type)
                                            @case(1) কল লিস্ট ৩ মাস @break
                                            @case(2) রবি/এয়ারটেল SMS @break
                                            @case(3) বাংলালিংক SMS @break
                                            @case(4) নাম্বার টু লোকেশন @break
                                            @case(5) NID টু নাম্বার @break
                                            @case(6) IMEI টু লোকেশন @break
                                            @case(7) IMEI টু এক্টিভ @break
                                            @case(8) নাম্বার টু IMEI @break
                                            @case(9) বিকাশ ইনফো @break
                                            @case(10) নগদ ইনফো @break
                                            @case(11) রকেট ইনফো @break
                                            @default N/A
                                        @endswitch
                                    </td>
                                    <td>
                                        @php
                                            try {
                                                $formData = is_string($order->form_data) ? json_decode($order->form_data, true) : $order->form_data;
                                                if (isset($formData['number'])) {
                                                    echo $formData['number'];
                                                } elseif (isset($formData['nid_10']) || isset($formData['nid_17'])) {
                                                    echo ($formData['nid_10'] ?? '') . ' / ' . ($formData['nid_17'] ?? '');
                                                } elseif (isset($formData['imei_1'])) {
                                                    echo 'IMEI: ' . $formData['imei_1'];
                                                } elseif (isset($formData['bkash_number'])) {
                                                    echo $formData['bkash_number'];
                                                } elseif (isset($formData['nagad_number'])) {
                                                    echo $formData['nagad_number'];
                                                } elseif (isset($formData['rocket_number'])) {
                                                    echo $formData['rocket_number'];
                                                } else {
                                                    echo 'N/A';
                                                }
                                            } catch (\Exception $e) {
                                                echo 'N/A';
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
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
                                        @elseif($order->admin_note && str_contains($order->admin_note, '.pdf'))
                                            <a href="{{ route('user.sim.network.download-pdf', $order->id) }}"
                                               class="btn btn-sm btn-success"
                                               title="PDF ডাউনলোড করুন">
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
                            <div class="row-number">{{ $orders->count() - $key }}</div>
                            <div class="row-content">
                                <div class="info-line">
                            <span class="service-type">
                                @switch($order->type)
                                    @case(1) কল লিস্ট ৩ মাস @break
                                    @case(2) রবি SMS @break
                                    @case(3) বাংলালিংক SMS @break
                                    @case(4) নাম্বার টু লোকেশন @break
                                    @case(5) NID টু নাম্বার @break
                                    @case(6) IMEI টু লোকেশন @break
                                    @case(7) IMEI টু এক্টিভ @break
                                    @case(8) নাম্বার টু IMEI @break
                                    @case(9) বিকাশ @break
                                    @case(10) নগদ @break
                                    @case(11) রকেট @break
                                @endswitch
                            </span>
                                </div>
                                <div class="info-line">
                            <span class="text-muted">
                                @php
                                    try {
                                        $formData = is_string($order->form_data) ? json_decode($order->form_data, true) : $order->form_data;
                                        if (isset($formData['number'])) {
                                            echo $formData['number'];
                                        } elseif (isset($formData['nid_10']) || isset($formData['nid_17'])) {
                                            echo ($formData['nid_10'] ?? '') . ' / ' . ($formData['nid_17'] ?? '');
                                        } elseif (isset($formData['imei_1'])) {
                                            echo 'IMEI: ' . $formData['imei_1'];
                                        } elseif (isset($formData['bkash_number'])) {
                                            echo $formData['bkash_number'];
                                        } elseif (isset($formData['nagad_number'])) {
                                            echo $formData['nagad_number'];
                                        } elseif (isset($formData['rocket_number'])) {
                                            echo $formData['rocket_number'];
                                        } else {
                                            echo 'N/A';
                                        }
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
                                    @elseif($order->admin_note && str_contains($order->admin_note, '.pdf'))
                                        <a href="{{ route('user.sim.network.download-pdf', $order->id) }}"
                                           class="btn btn-sm btn-success"
                                           style="width: 100%;"
                                           title="PDF ডাউনলোড করুন">
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

                @if(isset($orders) && $orders->hasPages())
                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection