@extends('user.layouts.app')

@section('title')
    Return Certificate Generate
@endsection

@section('content')
    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="container-fluid py-3">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="form-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="fw-bold m-0">
                                    <i class="fas fa-file-invoice-dollar text-success"></i>
                                    Return Certificate জেনারেট
                                </h3>
                                <div class="price-badge m-0 shadow-sm">
                                    সার্ভিস ফি: ৳50.00
                                </div>
                            </div>

                            <div class="step-box" id="search-section">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-search"></i> Step 1: Search Taxpayer Data
                                </h5>
                                <p class="text-muted small mb-3">
                                    সঠিক ১২ ডিজিটের TIN নম্বর দিন। ডাটা পাওয়া গেলে আপনার ব্যালেন্স থেকে ৳50 কাটা হবে।
                                </p>
                                <div class="input-group input-group-lg">
                                    <input type="number"
                                           id="search_tin"
                                           class="form-control fw-bold text-center"
                                           placeholder="12 Digit TIN Number"
                                           maxlength="12">
                                    <button class="btn btn-primary px-4 fw-bold"
                                            onclick="fetchTaxpayerData()">
                                        Search & Pay
                                    </button>
                                </div>
                                <div id="search_result" class="mt-3"></div>
                            </div>

                            <div id="remaining-input-section" style="display: none;">
                                <form action="{{ route('user.return.store') }}" method="POST" id="returnForm">
                                    @csrf

                                    @php
                                        $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'return')->first();
                                    @endphp

                                    @if($serviceCharge)
                                        <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                                                <div>
                                                    <h6 class="alert-heading mb-1 font-weight-bold">সার্ভিস চার্জ</h6>
                                                    <p class="mb-0 small text-muted">প্রতিটি রিটার্ন সার্টিফিকেট তৈরির জন্য <span class="font-weight-bold text-danger">{{ number_format($serviceCharge->amount, 2) }}</span> টাকা কাটা হবে।</p>
                                                </div>
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <input type="hidden" name="save_return" value="1">
                                    <input type="hidden" name="tin" id="in_tin">
                                    <input type="hidden" name="name" id="in_name">
                                    <input type="hidden" name="father" id="in_father">
                                    <input type="hidden" name="mother" id="in_mother">
                                    <input type="hidden" name="circle" id="in_circle">
                                    <input type="hidden" name="zone" id="in_zone">
                                    <input type="hidden" name="curr" id="in_curr_addr">
                                    <input type="hidden" name="perm" id="in_perm_addr">

                                    <div class="section-title mt-4">
                                        <i class="fas fa-edit"></i> Step 2: Fill Return Details
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted">
                                                Assessment Year
                                            </label>
                                            <input type="text"
                                                   name="ay"
                                                   class="form-control fw-bold @error('ay') is-invalid @enderror"
                                                   value="{{ old('ay', '2025-2026') }}"
                                                   required>
                                            @error('ay')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted">
                                                NID Number <span class="text-danger">*</span>
                                            </label>
                                            <input type="number"
                                                   name="nid"
                                                   class="form-control fw-bold @error('nid') is-invalid @enderror"
                                                   placeholder="Enter NID Number"
                                                   value="{{ old('nid') }}"
                                                   required>
                                            @error('nid')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted">
                                                Total Income
                                            </label>
                                            <input type="number"
                                                   name="income"
                                                   class="form-control fw-bold @error('income') is-invalid @enderror"
                                                   value="{{ old('income', 0) }}"
                                                   required>
                                            @error('income')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted">
                                                Paid Tax
                                            </label>
                                            <input type="number"
                                                   name="tax"
                                                   class="form-control fw-bold @error('tax') is-invalid @enderror"
                                                   value="{{ old('tax', 0) }}"
                                                   required>
                                            @error('tax')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted">
                                                Return Serial No <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   name="serial"
                                                   class="form-control fw-bold @error('serial') is-invalid @enderror"
                                                   placeholder="Serial No"
                                                   value="{{ old('serial') }}"
                                                   required>
                                            @error('serial')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted">
                                                Submission Date
                                            </label>
                                            <input type="text"
                                                   name="date"
                                                   id="submission_date"
                                                   class="form-control fw-bold @error('date') is-invalid @enderror"
                                                   value="{{ old('date', date('d/m/Y')) }}"
                                                   required>
                                            @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow-sm w-100">
                                            <i class="fas fa-check-circle"></i> Save & Generate Return Documents
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_green.css">
    <style>
        .form-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .step-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            padding: 10px 0;
            border-bottom: 2px solid #3498db;
            margin-bottom: 20px;
        }
        .price-badge {
            background: #28a745;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        .taxpayer-info {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 15px;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Initialize flatpickr
        flatpickr("#submission_date", {
            dateFormat: "d/m/Y",
            allowInput: true,
            defaultDate: "{{ old('date', date('d/m/Y')) }}"
        });

        function fetchTaxpayerData() {
            const tin = $('#search_tin').val();

            if (!tin || tin.length !== 12) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid TIN',
                    text: 'Please enter valid 12 digit TIN number'
                });
                return;
            }

            // Show loader
            Swal.fire({
                title: 'Searching...',
                text: 'Please wait while we fetch taxpayer data',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('user.return.check-tin') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    tin_number: tin
                },
                success: function(response) {
                    Swal.close();

                    if (response.status === 'success') {
                        // Populate hidden fields
                        $('#in_tin').val(response.data.tin_number);
                        $('#in_name').val(response.data.name);
                        $('#in_father').val(response.data.father_name);
                        $('#in_mother').val(response.data.mother_name);
                        $('#in_circle').val(response.data.circle);
                        $('#in_zone').val(response.data.zone);
                        $('#in_curr_addr').val(response.data.current_address);
                        $('#in_perm_addr').val(response.data.permanent_address);

                        // Show taxpayer info
                        let infoHtml = `
                        <div class="taxpayer-info mt-3">
                            <h6 class="fw-bold mb-2"><i class="fas fa-check-circle text-success"></i> Taxpayer Found</h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="fw-bold">Name:</td><td>${response.data.name}</td></tr>
                                <tr><td class="fw-bold">Father:</td><td>${response.data.father_name || 'N/A'}</td></tr>
                                <tr><td class="fw-bold">Circle:</td><td>${response.data.circle || 'N/A'}</td></tr>
                                <tr><td class="fw-bold">Zone:</td><td>${response.data.zone || 'N/A'}</td></tr>
                            </table>
                        </div>
                    `;
                        $('#search_result').html(infoHtml);

                        // Show remaining form
                        $('#remaining-input-section').slideDown();

                        // Update hidden fields with old values if any
                        @if(old('nid'))
                        $('input[name="nid"]').val("{{ old('nid') }}");
                        @endif
                        @if(old('serial'))
                        $('input[name="serial"]').val("{{ old('serial') }}");
                        @endif

                    } else {
                        $('#search_result').html(`
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-circle"></i> ${response.message}
                        </div>
                    `);
                        $('#remaining-input-section').hide();
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.'
                    });
                }
            });
        }

        // Auto-populate if returning from validation error
        @if(old('tin'))
        $(document).ready(function() {
            const oldTin = "{{ old('tin') }}";
            if (oldTin) {
                $('#search_tin').val(oldTin);
                fetchTaxpayerData();
            }
        });
        @endif
    </script>
@endpush