@extends('user.layouts.app')

@section('title')
    Create Driving License Application
@endsection

@section('content')
    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-header">
            <h3 class="card-title">New License Application</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.driving-licenses.store') }}" enctype="multipart/form-data">
                @csrf

                @php
                    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'driving-licenses')->first();
                @endphp

                @if($serviceCharge)
                    <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                            <div>
                                <h6 class="alert-heading mb-1 font-weight-bold">Service Charge</h6>
                                <p class="mb-0 small text-muted">A fee of <span class="font-weight-bold text-danger">{{ number_format($serviceCharge->amount, 2) }}</span> will be deducted for each Driving License Application.</p>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="sign" class="form-label">Signature</label>
                        <input type="file" name="sign" id="sign" class="form-control @error('sign') is-invalid @enderror" accept="image/*">
                        @error('sign')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name (English)</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}">
                        @error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="bloodGroup" class="form-label">Blood Group</label>
                        <input type="text" name="bloodGroup" id="bloodGroup" class="form-control @error('bloodGroup') is-invalid @enderror" value="{{ old('bloodGroup') }}" placeholder="e.g., A+">
                        @error('bloodGroup')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="fatherOrHusband" class="form-label">Father/Husband Name</label>
                        <input type="text" name="fatherOrHusband" id="fatherOrHusband" class="form-control @error('fatherOrHusband') is-invalid @enderror" value="{{ old('fatherOrHusband') }}">
                        @error('fatherOrHusband')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="licenceNo" class="form-label">License Number</label>
                        <input type="text" name="licenceNo" id="licenceNo" class="form-control @error('licenceNo') is-invalid @enderror" value="{{ old('licenceNo') }}">
                        @error('licenceNo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Permanent Address</label>
                    <textarea name="address" id="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="authority" class="form-label">Issuing Authority</label>
                        <input type="text" name="authority" id="authority" class="form-control @error('authority') is-invalid @enderror" value="{{ old('authority') }}">
                        @error('authority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="refNo" class="form-label">Reference Number</label>
                        <input type="text" name="refNo" id="refNo" class="form-control @error('refNo') is-invalid @enderror" value="{{ old('refNo') }}">
                        @error('refNo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="issuDate" class="form-label">Issue Date</label>
                        <input type="date" name="issuDate" id="issuDate" class="form-control @error('issuDate') is-invalid @enderror" value="{{ old('issuDate') }}">
                        @error('issuDate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="firstIssuDate" class="form-label">First Issue Date</label>
                        <input type="date" name="firstIssuDate" id="firstIssuDate" class="form-control @error('firstIssuDate') is-invalid @enderror" value="{{ old('firstIssuDate') }}">
                        @error('firstIssuDate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="validityDate" class="form-label">Validity Expiry Date</label>
                        <input type="date" name="validityDate" id="validityDate" class="form-control @error('validityDate') is-invalid @enderror" value="{{ old('validityDate') }}">
                        @error('validityDate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="drivingClass" class="form-label">Driving Class(es)</label>
                    <input type="text" name="drivingClass" id="drivingClass" class="form-control @error('drivingClass') is-invalid @enderror" value="{{ old('drivingClass') }}" placeholder="e.g., A, B, C">
                    @error('drivingClass')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Application</button>
                <a href="{{ route('user.driving-licenses.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush