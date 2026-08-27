@extends('user.layouts.app')
@section('title')
    সাইন কপি অর্ডার
@endsection

@push('style')
    <style>
        .classic-card {
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .classic-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            margin: -1.25rem -1.25rem 1rem -1.25rem;
        }

        .btn-option {
            position: relative;
            padding: 8px 12px;
            font-size: 0.82rem;
            text-align: left;
            margin-bottom: 5px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            height: 100%;
            min-height: 60px;
            background: #ffffff;
            color: #2c3e50;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .btn-option .btn-text {
            font-size: 0.82rem;
            color: #2c3e50;
            font-weight: 500;
            line-height: 1.2;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-word;
        }

        .btn-option .btn-subtext {
            font-size: 0.80rem;
            color: #666;
            margin-left: 4px;
        }

        .btn-option .text-block {
            flex: 1;
            min-width: 0;
            padding-right: 8px;
        }

        .option-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
            padding: 0 15px;
        }

        .option-column {
            display: grid;
            grid-template-rows: repeat(3, 1fr);
            gap: 15px;
        }

        .btn-option i {
            font-size: 1.0rem;
            margin-right: 12px;
            color: #3498db;
            width: 24px;
            text-align: center;
        }

        .btn-option .badge {
            font-size: 0.85rem;
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
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

        .btn-option.active .badge {
            background: white;
            color: #2980b9;
        }

        @media (max-width: 768px) {
            .option-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                padding: 10px;
            }

            .option-column {
                display: grid;
                grid-template-columns: 1fr;
                grid-template-rows: auto;
                gap: 10px;
            }

            .btn-option {
                min-height: 70px;
                padding: 8px 10px;
                font-size: 0.85rem;
                margin-bottom: 0;
            }

            .btn-option i {
                font-size: 1rem;
                margin-right: 8px;
                width: 20px;
            }

            .btn-option .badge {
                font-size: 0.75rem;
                padding: 4px 8px;
                margin-left: 5px;
            }

            .btn-option .btn-text {
                font-size: 0.85rem;
                line-height: 1.2;
            }

            .text-block {
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
        }

        .btn-option:hover {
            border-color: #1976d2;
            background: #f8f9fa;
            transform: translateY(-2px);
        }

        .btn-option.active {
            background: linear-gradient(to right, #1976d2, #2196f3);
            color: white;
            border: none;
        }

        .btn-option i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .btn-option .badge {
            background: #1976d2;
            color: white;
        }

        .btn-option.active .badge {
            background: white;
            color: #1976d2;
        }

        .form-container {
            width: 100%;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: none;
            margin-top: 20px;
            opacity: 0;
            transition: all 0.3s ease-out;
        }

        .form-container.active {
            opacity: 1;
            display: block;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: #666;
            cursor: pointer;
            padding: 0;
        }

        /* Desktop table styling */
        .classic-table {
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            overflow: hidden;
            width: 100% !important;
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

        /* Mobile Order Row Styles (matches id-card order blade design) */
        .mobile-order-row {
            background: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
            font-size: 0.85rem;
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
            font-size: 0.80rem;
        }

        .row-content .btn-sm {
            padding: 5px 10px;
            font-size: 0.75rem;
            border-radius: 4px;
        }

        .row-content .reason-box {
            font-size: 0.75rem;
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="card classic-card m-0 m-md-4 my-4 m-md-0">
        <div class="card-body">
            <!-- Error/Success Alerts -->
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
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Option Buttons Grid -->
            <div class="option-grid">
                <div class="option-column">
                    <button type="button" class="btn-option" data-form="1">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block"><span class="btn-text">&nbsp;১০/১২/১৭ দিয়ে সাইন</span></div>
                        <span class="badge">৳{{ $orderTypes[1]->cost ?? 50 }}</span>
                    </button>
                    <button type="button" class="btn-option" data-form="2">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block"><span class="btn-text">&nbsp;ফরম/নিবন্ধন নং/১৩ডিজিট দিয়ে সাইন</span></div>
                        <span class="badge">৳{{ $orderTypes[2]->cost ?? 60 }}</span>
                    </button>
                    <button type="button" class="btn-option" data-form="3">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block"><span class="btn-text">&nbsp;অফিসিয়াল সারভার কপি</span></div>
                        <span class="badge">৳{{ $orderTypes[3]->cost ?? 70 }}</span>
                    </button>
                </div>
                <div class="option-column">
                    <button type="button" class="btn-option" data-form="4">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block"><span class="btn-text">&nbsp;NID CMS COPY অর্ডার</span></div>
                        <span class="badge">৳{{ $orderTypes[4]->cost ?? 80 }}</span>
                    </button>
                    <button type="button" class="btn-option" data-form="5">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block"><span class="btn-text">&nbsp;নাম ঠিকানা দিয়ে সাইন</span></div>
                        <span class="badge">৳{{ $orderTypes[5]->cost ?? 90 }}</span>
                    </button>
                    <button type="button" class="btn-option" data-form="6">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-block"><span class="btn-text">&nbsp;ম্যাচ ফাউন্ড / ডাবল ভোটার অ্যাকটিভ কপি</span></div>
                        <span class="badge">৳{{ $orderTypes[6]->cost ?? 100 }}</span>
                    </button>
                </div>
            </div>

            <!-- Form 1 -->
            <div id="form1" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">১০/১২/১৭ দিয়ে সাইন</h5>
                    <button type="button" class="close-modal" onclick="hideForm()">&times;</button>
                </div>
                <form action="{{ route('user.sign.copy.order.store') }}" method="POST" class="needs-validation" id="form1Form" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="1">
                    <div class="form-group mb-3">
                        <textarea class="form-control" id="form1_info" name="form_info" rows="4" required style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;" oninput="syncInput1(this)" onkeydown="handleEnterKey1(event, this)">নাম:&#10;এনআইডি নম্বর: </textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideForm()">বাতিল</button>
                        <button type="submit" class="btn btn-success">জমা দিন</button>
                    </div>
                </form>
            </div>

            <!-- Form 2 -->
            <div id="form2" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">ফরম/নিবন্ধন নং/১৩ডিজিট দিয়ে সাইন</h5>
                    <button type="button" class="close-modal" onclick="hideForm()">&times;</button>
                </div>
                <form action="{{ route('user.sign.copy.order.store') }}" method="POST" class="needs-validation" id="form2Form" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="2">
                    <div class="form-group mb-3">
                        <textarea class="form-control" id="form2_info" name="form_info" rows="5" required style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;" oninput="syncInput2(this)" onkeydown="handleEnterKey2(event, this)">নাম:&#10;নিবন্ধন নম্বর: </textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideForm()">বাতিল</button>
                        <button type="submit" class="btn btn-success">জমা দিন</button>
                    </div>
                </form>
            </div>

            <!-- Form 3 -->
            <div id="form3" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">অফিসিয়াল সারভার কপি</h5>
                    <button type="button" class="close-modal" onclick="hideForm()">&times;</button>
                </div>
                <form action="{{ route('user.sign.copy.order.store') }}" method="POST" class="needs-validation" id="form3Form" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="3">
                    <div class="form-group mb-3">
                        <textarea class="form-control" id="form3_info" name="form_info" rows="5" required style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;" oninput="syncInput3(this)" onkeydown="handleEnterKey3(event, this)">এনআইডি নম্বর:&#10;জন্ম তারিখ: </textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideForm()">বাতিল</button>
                        <button type="submit" class="btn btn-success">জমা দিন</button>
                    </div>
                </form>
            </div>

            <!-- Form 4 -->
            <div id="form4" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">NID CMS COPY অর্ডার</h5>
                    <button type="button" class="close-modal" onclick="hideForm()">&times;</button>
                </div>
                <form action="{{ route('user.sign.copy.order.store') }}" method="POST" class="needs-validation" id="form4Form" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="4">
                    <div class="form-group mb-3">
                        <textarea class="form-control" id="form4_info" name="form_info" rows="6" required style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;" oninput="syncInput4(this)" onkeydown="handleEnterKey4(event, this)">এনআইডি নম্বর:&#10;জন্ম তারিখ: </textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideForm()">বাতিল</button>
                        <button type="submit" class="btn btn-success">জমা দিন</button>
                    </div>
                </form>
            </div>

            <!-- Form 5 -->
            <div id="form5" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">নাম ঠিকানা দিয়ে সাইন</h5>
                    <button type="button" class="close-modal" onclick="hideForm()">&times;</button>
                </div>
                <form action="{{ route('user.sign.copy.order.store') }}" method="POST" class="needs-validation" id="form5Form" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="5">
                    <div class="form-group mb-3">
                        <textarea class="form-control" id="form5_info" name="form_info" rows="16" required style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;" oninput="syncInput(this)" onkeydown="handleEnterKey(event, this)">নিজ নাম:&#10;পিতার নাম: &#10;মাতার নাম: &#10;স্বামী/স্ত্রী নাম: &#10;জন্ম সনদ (যদি থাকে): &#10;বিভাগ: &#10;জেলা: &#10;উপজেলা: &#10;ইউনিয়ন/পৌরসভা/সিটি করপোরেশন: &#10;ওয়ার্ড নং: &#10;ডাকঘর: &#10;গ্রাম: &#10;পিতার এনআইডি নং (যদি থাকে): &#10;মাতার এনআইডি নং (যদি থাকে): &#10;সাথে ভোটার হওয়া একজনের এনআইডি: </textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideForm()">বাতিল</button>
                        <button type="submit" class="btn btn-success">জমা দিন</button>
                    </div>
                </form>
            </div>

            <!-- Form 6 -->
            <div id="form6" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">ম্যাচ ফাউন্ড /ডাবল ভোটার অ্যাকটিভ কপি</h5>
                    <button type="button" class="close-modal" onclick="hideForm()">&times;</button>
                </div>
                <form action="{{ route('user.sign.copy.order.store') }}" method="POST" class="needs-validation" id="form6Form" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="6">
                    <div class="form-group mb-3">
                        <textarea class="form-control" id="form6_info" name="form_info" rows="16" required style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;" oninput="syncInput6(this)" onkeydown="handleEnterKey6(event, this)">নিজ নাম:&#10;পিতার নাম: &#10;মাতার নাম: &#10;স্বামী/স্ত্রী নাম: &#10;জন্ম সনদ (যদি থাকে): &#10;বিভাগ: &#10;জেলা: &#10;উপজেলা: &#10;ইউনিয়ন/পৌরসভা/সিটি করপোরেশন: &#10;ওয়ার্ড নং: &#10;ডাকঘর: &#10;গ্রাম: &#10;পিতার এনআইডি নং (যদি থাকে): &#10;মাতার এনআইডি নং (যদি থাকে): &#10;সাথে ভোটার হওয়া একজনের এনআইডি: </textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">ব্যক্তির ছবি (যদি থাকে)</label>
                        <div class="file-upload">
                            <input type="file" class="form-control" name="form_data[photo]" accept="image/*">
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideForm()">বাতিল</button>
                        <button type="submit" class="btn btn-success">জমা দিন</button>
                    </div>
                </form>
            </div>

            <!-- Orders Table Section -->
            <div class="mt-4">
                <div class="mb-3" style="background: linear-gradient(90deg, #1e4c78 0%, #3498db 100%); color: white; padding: 10px 15px; border-radius: 4px;">
                    <h5 class="m-0 text-center">অর্ডার তালিকা</h5>
                </div>
                @if(isset($orders))
                    <div class="alert alert-info">
                        সর্বমোট অর্ডার: {{ $orders->count() }} টি
                    </div>
                @endif

                @php
                    // Helper closures used by both desktop & mobile views to avoid duplicating logic
                    $formTypeText = function ($order) {
                        return match ((int) $order->form_type) {
                            1 => '১০/১২/১৭ দিয়ে সাইন',
                            2 => 'ফরম/নিবন্ধন নং দিয়ে সাইন',
                            3 => 'অফিসিয়াল সারভার কপি',
                            4 => 'NID CMS COPY',
                            5 => 'নাম ঠিকানা দিয়ে সাইন',
                            6 => 'ম্যাচ ফাউন্ড কপি',
                            default => '—',
                        };
                    };
                    $getFormData = function ($order) {
                        try {
                            return is_array($order->form_data) ? $order->form_data : json_decode($order->form_data, true);
                        } catch (\Exception $e) {
                            return [];
                        }
                    };
                @endphp

                        <!-- Desktop View -->
                <div class="classic-table d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead>
                            <tr>
                                <th>ক্রমিক</th>
                                <th>অর্ডার ধরন</th>
                                <th>এনআইডি/ফরম নং</th>
                                <th>নাম</th>
                                <th>তারিখ</th>
                                <th>স্ট্যাটাস</th>
                                <th>ডাউনলোড / কারণ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orders ?? [] as $key => $order)
                                @php $formData = $getFormData($order); @endphp
                                <tr>
                                    <td>{{ ($orders ? $orders->count() : 0) - $key }}</td>
                                    <td>{{ $formTypeText($order) }}</td>
                                    <td>{{ $formData['nid'] ?? ($formData['registration_no'] ?? 'N/A') }}</td>
                                    <td>{{ $formData['name'] ?? 'N/A' }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($order->status == 0)
                                            <span class="text-warning fw-bold">⏳ পেন্ডিং</span>
                                        @elseif($order->status == 1)
                                            <span class="text-info fw-bold">✓ অনুমোদিত</span>
                                        @elseif($order->status == 2)
                                            <span class="text-danger fw-bold">✕ বাতিল</span>
                                        @elseif($order->status == 3)
                                            <span class="text-success fw-bold">✔ সম্পন্ন</span>
                                        @else
                                            <span class="text-muted">অজানা</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->status == 2)
                                            <div class="p-1 bg-light border-start border-3 border-danger rounded" style="font-size: 0.78rem;">
                                                {{ $order->status_note ?? 'কোন কারণ উল্লেখ করা হয়নি' }}
                                            </div>
                                        @elseif($order->admin_note)
                                            <a href="{{ route('pdf.download', $order->admin_note) }}" class="btn btn-sm" style="background-color: #27ae60; color: white; border: none; padding: 4px 8px; border-radius: 4px;" title="ডাউনলোড করুন">
                                                <i class="fas fa-download"></i> ডাউনলোড
                                            </a>
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
                    @forelse($orders ?? [] as $key => $order)
                        @php $formData = $getFormData($order); @endphp
                        <div class="mobile-order-row">
                            <div class="row-number">{{ ($orders ? $orders->count() : 0) - $key }}</div>
                            <div class="row-content">
                                <div class="info-line">
                                    <span class="service-type">{{ $formTypeText($order) }}</span>
                                </div>
                                <div class="info-line">
                                    @if($order->status == 0)
                                        <span class="text-warning fw-bold">⏳ পেন্ডিং</span>
                                    @elseif($order->status == 1)
                                        <span class="text-info fw-bold">✓ অনুমোদিত</span>
                                    @elseif($order->status == 2)
                                        <span class="text-danger fw-bold">✕ বাতিল</span>
                                    @elseif($order->status == 3)
                                        <span class="text-success fw-bold">✔ সম্পন্ন</span>
                                    @else
                                        <span class="text-muted">অজানা</span>
                                    @endif
                                    <span class="order-date">{{ $order->created_at->format('d/m/Y') }}</span>
                                </div>

                                @if($order->status == 2)
                                    <div class="info-line">
                                        <div class="p-2 bg-light border-start border-3 border-danger rounded reason-box">
                                            <strong>কারণ:</strong> {{ $order->status_note ?? 'কোন কারণ উল্লেখ করা হয়নি' }}
                                        </div>
                                    </div>
                                @elseif($order->admin_note)
                                    <div class="info-line">
                                        <a href="{{ route('pdf.download', $order->admin_note) }}" class="btn btn-sm" style="background-color: #27ae60; color: white; border: none; width: 100%;" title="ডাউনলোড করুন">
                                            <i class="fas fa-download"></i> ডাউনলোড
                                        </a>
                                    </div>
                                @else
                                    <div class="info-line">
                                        <span class="text-muted">নেই</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-3 text-muted">কোন অর্ডার নেই</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            // Form 1 Templates & Logic
            const templateLines1 = ['নাম: ', 'এনআইডি নম্বর: ', 'ঠিকানা: ', 'মোবাইল নম্বর: '];
            function handleEnterKey1(event, textarea) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const cursorPos = textarea.selectionStart; const text = textarea.value; const lines = text.split('\n');
                    let currentLineNum = 0; let charCount = 0;
                    for (let i = 0; i < lines.length; i++) {
                        if (charCount + lines[i].length >= cursorPos) { currentLineNum = i; break; }
                        charCount += lines[i].length + 1;
                    }
                    if (currentLineNum < lines.length - 1) {
                        let nextLinePos = charCount + lines[currentLineNum].length + 1;
                        if (currentLineNum + 1 < templateLines1.length) { nextLinePos += templateLines1[currentLineNum + 1].length; }
                        textarea.selectionStart = textarea.selectionEnd = nextLinePos;
                    }
                }
            }
            function parseFormData1(text) {
                const lines = text.split('\n');
                const fieldMap = { 'নাম': 'name', 'এনআইডি নম্বর': 'nid', 'ঠিকানা': 'address', 'মোবাইল নম্বর': 'mobile' };
                const formData = {};
                lines.forEach(line => {
                    const colonIndex = line.indexOf(':');
                    if (colonIndex !== -1) {
                        const label = line.substring(0, colonIndex).trim(); const value = line.substring(colonIndex + 1).trim();
                        if (fieldMap[label] && value !== '') { formData[fieldMap[label]] = value; }
                    }
                });
                return formData;
            }
            function syncInput1(textarea) { updateHiddenInputs1(parseFormData1(textarea.value)); }
            function updateHiddenInputs1(formData) {
                const form = document.querySelector('#form1Form');
                form.querySelectorAll('input[name^="form_data["]').forEach(el => el.remove());
                for (const [key, value] of Object.entries(formData)) {
                    if (value && value.trim() !== '') {
                        const input = document.createElement('input'); input.type = 'hidden'; input.name = `form_data[${key}]`; input.value = value.trim(); form.appendChild(input);
                    }
                }
            }

            // Form 2 Templates & Logic
            const templateLines2 = ['নাম: ', 'নিবন্ধন নম্বর: ', 'জেলা: ', 'উপজেলা: ', 'মোবাইল নম্বর: '];
            function handleEnterKey2(event, textarea) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const cursorPos = textarea.selectionStart; const text = textarea.value; const lines = text.split('\n');
                    let currentLineNum = 0; let charCount = 0;
                    for (let i = 0; i < lines.length; i++) {
                        if (charCount + lines[i].length >= cursorPos) { currentLineNum = i; break; }
                        charCount += lines[i].length + 1;
                    }
                    if (currentLineNum < lines.length - 1) {
                        let nextLinePos = charCount + lines[currentLineNum].length + 1;
                        if (currentLineNum + 1 < templateLines2.length) { nextLinePos += templateLines2[currentLineNum + 1].length; }
                        textarea.selectionStart = textarea.selectionEnd = nextLinePos;
                    }
                }
            }
            function parseFormData2(text) {
                const lines = text.split('\n');
                const fieldMap = { 'নাম': 'name', 'নিবন্ধন নম্বর': 'registration_no', 'জেলা': 'district', 'উপজেলা': 'upazila', 'মোবাইল নম্বর': 'mobile' };
                const formData = {};
                lines.forEach(line => {
                    const colonIndex = line.indexOf(':');
                    if (colonIndex !== -1) {
                        const label = line.substring(0, colonIndex).trim(); const value = line.substring(colonIndex + 1).trim();
                        if (fieldMap[label] && value !== '') { formData[fieldMap[label]] = value; }
                    }
                });
                return formData;
            }
            function syncInput2(textarea) { updateHiddenInputs2(parseFormData2(textarea.value)); }
            function updateHiddenInputs2(formData) {
                const form = document.querySelector('#form2Form');
                form.querySelectorAll('input[name^="form_data["]').forEach(el => el.remove());
                for (const [key, value] of Object.entries(formData)) {
                    if (value && value.trim() !== '') {
                        const input = document.createElement('input'); input.type = 'hidden'; input.name = `form_data[${key}]`; input.value = value.trim(); form.appendChild(input);
                    }
                }
            }

            // Form 3 Templates & Logic
            const templateLines3 = ['এনআইডি নম্বর: ', 'জন্ম তারিখ: ', 'জেলা: ', 'উপজেলা: ', 'মোবাইল নম্বর: '];
            function handleEnterKey3(event, textarea) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const cursorPos = textarea.selectionStart; const text = textarea.value; const lines = text.split('\n');
                    let currentLineNum = 0; let charCount = 0;
                    for (let i = 0; i < lines.length; i++) {
                        if (charCount + lines[i].length >= cursorPos) { currentLineNum = i; break; }
                        charCount += lines[i].length + 1;
                    }
                    if (currentLineNum < lines.length - 1) {
                        let nextLinePos = charCount + lines[currentLineNum].length + 1;
                        if (currentLineNum + 1 < templateLines3.length) { nextLinePos += templateLines3[currentLineNum + 1].length; }
                        textarea.selectionStart = textarea.selectionEnd = nextLinePos;
                    }
                }
            }
            function parseFormData3(text) {
                const lines = text.split('\n');
                const fieldMap = { 'এনআইডি নম্বর': 'nid', 'জন্ম তারিখ': 'dob', 'জেলা': 'district', 'উপজেলা': 'upazila', 'মোবাইল নম্বর': 'mobile' };
                const formData = {};
                lines.forEach(line => {
                    const colonIndex = line.indexOf(':');
                    if (colonIndex !== -1) {
                        const label = line.substring(0, colonIndex).trim(); const value = line.substring(colonIndex + 1).trim();
                        if (fieldMap[label] && value !== '') { formData[fieldMap[label]] = value; }
                    }
                });
                return formData;
            }
            function syncInput3(textarea) { updateHiddenInputs3(parseFormData3(textarea.value)); }
            function updateHiddenInputs3(formData) {
                const form = document.querySelector('#form3Form');
                form.querySelectorAll('input[name^="form_data["]').forEach(el => el.remove());
                for (const [key, value] of Object.entries(formData)) {
                    if (value && value.trim() !== '') {
                        const input = document.createElement('input'); input.type = 'hidden'; input.name = `form_data[${key}]`; input.value = value.trim(); form.appendChild(input);
                    }
                }
            }

            // Form 4 Templates & Logic
            const templateLines4 = ['এনআইডি নম্বর: ', 'জন্ম তারিখ: ', 'জেলা: ', 'উপজেলা: ', 'ইউনিয়ন/পৌরসভা: ', 'মোবাইল নম্বর: '];
            function handleEnterKey4(event, textarea) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const cursorPos = textarea.selectionStart; const text = textarea.value; const lines = text.split('\n');
                    let currentLineNum = 0; let charCount = 0;
                    for (let i = 0; i < lines.length; i++) {
                        if (charCount + lines[i].length >= cursorPos) { currentLineNum = i; break; }
                        charCount += lines[i].length + 1;
                    }
                    if (currentLineNum < lines.length - 1) {
                        let nextLinePos = charCount + lines[currentLineNum].length + 1;
                        if (currentLineNum + 1 < templateLines4.length) { nextLinePos += templateLines4[currentLineNum + 1].length; }
                        textarea.selectionStart = textarea.selectionEnd = nextLinePos;
                    }
                }
            }
            function parseFormData4(text) {
                const lines = text.split('\n');
                const fieldMap = { 'এনআইডি নম্বর': 'nid', 'জন্ম তারিখ': 'dob', 'জেলা': 'district', 'উপজেলা': 'upazila', 'ইউনিয়ন/পৌরসভা': 'union', 'মোবাইল নম্বর': 'mobile' };
                const formData = {};
                lines.forEach(line => {
                    const colonIndex = line.indexOf(':');
                    if (colonIndex !== -1) {
                        const label = line.substring(0, colonIndex).trim(); const value = line.substring(colonIndex + 1).trim();
                        if (fieldMap[label] && value !== '') { formData[fieldMap[label]] = value; }
                    }
                });
                return formData;
            }
            function syncInput4(textarea) { updateHiddenInputs4(parseFormData4(textarea.value)); }
            function updateHiddenInputs4(formData) {
                const form = document.querySelector('#form4Form');
                form.querySelectorAll('input[name^="form_data["]').forEach(el => el.remove());
                for (const [key, value] of Object.entries(formData)) {
                    if (value && value.trim() !== '') {
                        const input = document.createElement('input'); input.type = 'hidden'; input.name = `form_data[${key}]`; input.value = value.trim(); form.appendChild(input);
                    }
                }
            }

            // Universal Forms 5 & 6 Configuration Mapping
            const fieldMap = {
                'নিজ নাম': 'name', 'পিতার নাম': 'father_name', 'মাতার নাম': 'mother_name', 'স্বামী/স্ত্রী নাম': 'spouse_name',
                'জন্ম সনদ (যদি থাকে)': 'birth_cert', 'বিভাগ': 'division', 'জেলা': 'district', 'উপজেলা': 'upazila',
                'ইউনিয়ন/পৌরসভা/সিটি করপোরেশন': 'union', 'ওয়ার্ড নং': 'ward', 'ডাকঘর': 'post_office', 'গ্রাম': 'village',
                'পিতার এনআইডি নং (যদি থাকে)': 'father_nid', 'মাতার এনআইডি নং (যদি থাকে)': 'mother_nid', 'সাথে ভোটার হওয়া একজনের এনআইডি': 'voter_nid'
            };

            function parseFormData(text) {
                const lines = text.split('\n'); const formData = {};
                lines.forEach(line => {
                    const colonIndex = line.indexOf(':');
                    if (colonIndex !== -1) {
                        const label = line.substring(0, colonIndex).trim(); const value = line.substring(colonIndex + 1).trim();
                        for (const [bengaliLabel, fieldName] of Object.entries(fieldMap)) {
                            if ((label === bengaliLabel || label === bengaliLabel.replace(' (যদি থাকে)', '')) && value !== '') {
                                formData[fieldName] = value; break;
                            }
                        }
                    }
                });
                return formData;
            }

            function updateHiddenInputs(formData) {
                const form = document.querySelector('#form5Form'); if (!form) return;
                form.querySelectorAll('input[name^="form_data["]').forEach(el => el.remove());
                Object.entries(formData).forEach(([key, value]) => {
                    if (value && value.trim() !== '') {
                        const input = document.createElement('input'); input.type = 'hidden'; input.name = `form_data[${key}]`; input.value = value.trim(); form.appendChild(input);
                    }
                });
            }

            function syncInput(textarea) { updateHiddenInputs(parseFormData(textarea.value)); }

            const templateLines = Object.keys(fieldMap);
            function handleEnterKey(event, textarea) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const cursorPos = textarea.selectionStart; const text = textarea.value; const lines = text.split('\n');
                    let currentLineNum = 0; let charCount = 0;
                    for (let i = 0; i < lines.length; i++) {
                        if (charCount + lines[i].length >= cursorPos) { currentLineNum = i; break; }
                        charCount += lines[i].length + 1;
                    }
                    if (currentLineNum < lines.length - 1) {
                        let nextLinePos = charCount + lines[currentLineNum].length + 1;
                        if (currentLineNum + 1 < templateLines.length) { nextLinePos += templateLines[currentLineNum + 1].length + 2; }
                        textarea.selectionStart = textarea.selectionEnd = nextLinePos;
                    }
                }
            }

            function syncInput6(textarea) { updateHiddenInputs6(parseFormData(textarea.value)); }
            function updateHiddenInputs6(formData) {
                const form = document.querySelector('#form6Form'); if (!form) return;
                form.querySelectorAll('input[name^="form_data["]').forEach(el => { if (el.type !== 'file') el.remove(); });
                for (const [key, value] of Object.entries(formData)) {
                    if (value && value.trim() !== '') {
                        const input = document.createElement('input'); input.type = 'hidden'; input.name = `form_data[${key}]`; input.value = value.trim(); form.appendChild(input);
                    }
                }
            }
            function handleEnterKey6(event, textarea) { handleEnterKey(event, textarea); }

            document.addEventListener('DOMContentLoaded', function () {
                const forms = document.querySelectorAll('.form-container');

                [1, 2, 3, 4, 5, 6].forEach(fNum => {
                    const form = document.getElementById(`form${fNum}Form`);
                    if (form) {
                        form.addEventListener('submit', function (e) {
                            e.preventDefault();
                            const txt = document.getElementById(`form${fNum}_info`).value;
                            const fnName = fNum === 5 ? 'parseFormData' : (fNum === 6 ? 'parseFormData' : `parseFormData${fNum}`);
                            const formData = window[fnName](txt);
                            if (Object.keys(formData).length === 0) { alert('অনুগ্রহ করে কমপক্ষে একটি তথ্য পূরণ করুন'); return; }
                            this.submit();
                        });
                    }
                });

                function showForm(formId) {
                    hideForm();
                    const form = document.getElementById('form' + formId);
                    if (form) { form.style.display = 'block'; setTimeout(() => form.classList.add('active'), 10); }
                    document.querySelectorAll('.btn-option').forEach(btn => btn.classList.remove('active'));
                    const activeBtn = document.querySelector(`[data-form="${formId}"]`);
                    if (activeBtn) activeBtn.classList.add('active');
                }

                function hideForm() {
                    forms.forEach(form => { form.style.display = 'none'; form.classList.remove('active'); });
                    document.querySelectorAll('.btn-option').forEach(btn => btn.classList.remove('active'));
                }

                document.querySelectorAll('.btn-option').forEach(button => {
                    button.onclick = function () { showForm(this.getAttribute('data-form')); };
                });

                window.showForm = showForm; window.hideForm = hideForm;
            });
        </script>
    @endpush
@endsection