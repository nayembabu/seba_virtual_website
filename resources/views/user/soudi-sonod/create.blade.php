@extends('user.layouts.app')

@section('title')
    Worker Certificate
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary font-weight-bold">
                            <i class="fas fa-plus-circle mr-2"></i> Create New Worker Certificate
                        </h5>
                        <a href="{{ route('user.soudi-sonod.index') }}" class="btn btn-outline-dark btn-sm px-3">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('user.soudi-sonod.store') }}">
                            @csrf

                            @php
                                $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'soudi-sonod')->first();
                            @endphp

                            @if($serviceCharge)
                                <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                                        <div>
                                            <h6 class="alert-heading mb-1 font-weight-bold">Service Charge</h6>
                                            <p class="mb-0 small text-muted">A fee of <span class="font-weight-bold text-danger">{{ number_format($serviceCharge->amount, 2) }}</span> will be deducted for each Worker Certificate creation.</p>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark">Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter full name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark">Nationality</label>
                                        <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" value="{{ old('nationality') }}" placeholder="e.g. Bangladeshi" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark">Passport No</label>
                                        <input type="text" name="passport_no" class="form-control @error('passport_no') is-invalid @enderror" value="{{ old('passport_no') }}" placeholder="Passport number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark">Certificate No</label>
                                        <input type="text" name="certificate_no" class="form-control @error('certificate_no') is-invalid @enderror" value="{{ old('certificate_no') }}" placeholder="Certificate number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark">Worker No</label>
                                        <input type="text" name="worker_no" class="form-control @error('worker_no') is-invalid @enderror" value="{{ old('worker_no') }}" placeholder="Worker number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark">Type</label>
                                        <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type') }}" placeholder="Type of certificate" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark">Issue Date</label>
                                        <input type="date" name="issue_date" class="form-control @error('issue_date') is-invalid @enderror" value="{{ old('issue_date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-dark">Expiry Date</label>
                                        <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-3">
                                <button type="reset" class="btn btn-light px-4 mr-2">Reset</button>
                                <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                    <i class="fas fa-save mr-1"></i> Save Certificate
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
<style>
    .card { border-radius: 10px; }
    .card-header { border-radius: 10px 10px 0 0 !important; border-bottom: 1px solid #f0f0f0; }
    .form-control { border-radius: 6px; padding: 10px 15px; height: auto; border: 1px solid #e0e0e0; }
    .form-control:focus { box-shadow: 0 0 0 0.2rem rgba(0,123,255,.1); border-color: #80bdff; }
    label { font-size: 13px; margin-bottom: 8px; color: #555; }
    .btn { border-radius: 6px; font-weight: 600; }
</style>
@endpush


