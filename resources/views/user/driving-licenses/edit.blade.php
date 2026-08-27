@extends('user.layouts.app')

@section('title')
    Edit Driving License Application
@endsection

@section('content')
    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-header">
            <h3 class="card-title">Edit License Application</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.driving-licenses.update', $application) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                        @if($application->photo)
                            <small>Current: <img src="{{ asset('storage/' . $application->photo) }}" alt="Photo" width="60"></small>
                        @endif
                        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="sign" class="form-label">Signature</label>
                        <input type="file" name="sign" id="sign" class="form-control @error('sign') is-invalid @enderror" accept="image/*">
                        @if($application->sign)
                            <small>Current: <img src="{{ asset('storage/' . $application->sign) }}" alt="Sign" width="60"></small>
                        @endif
                        @error('sign')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Repeat all the same fields as create, but with old() fallback to $application values -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name (English)</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $application->name) }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob', $application->dob->format('Y-m-d')) }}">
                        @error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="bloodGroup" class="form-label">Blood Group</label>
                        <input type="text" name="bloodGroup" id="bloodGroup" class="form-control @error('bloodGroup') is-invalid @enderror" value="{{ old('bloodGroup', $application->bloodGroup) }}">
                        @error('bloodGroup')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="fatherOrHusband" class="form-label">Father/Husband Name</label>
                        <input type="text" name="fatherOrHusband" id="fatherOrHusband" class="form-control @error('fatherOrHusband') is-invalid @enderror" value="{{ old('fatherOrHusband', $application->fatherOrHusband) }}">
                        @error('fatherOrHusband')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="licenceNo" class="form-label">License Number</label>
                        <input type="text" name="licenceNo" id="licenceNo" class="form-control @error('licenceNo') is-invalid @enderror" value="{{ old('licenceNo', $application->licenceNo) }}">
                        @error('licenceNo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Permanent Address</label>
                    <textarea name="address" id="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address', $application->address) }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="authority" class="form-label">Issuing Authority</label>
                        <input type="text" name="authority" id="authority" class="form-control @error('authority') is-invalid @enderror" value="{{ old('authority', $application->authority) }}">
                        @error('authority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="refNo" class="form-label">Reference Number</label>
                        <input type="text" name="refNo" id="refNo" class="form-control @error('refNo') is-invalid @enderror" value="{{ old('refNo', $application->refNo) }}">
                        @error('refNo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="issuDate" class="form-label">Issue Date</label>
                        <input type="date" name="issuDate" id="issuDate" class="form-control @error('issuDate') is-invalid @enderror" value="{{ old('issuDate', $application->issuDate->format('Y-m-d')) }}">
                        @error('issuDate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="firstIssuDate" class="form-label">First Issue Date</label>
                        <input type="date" name="firstIssuDate" id="firstIssuDate" class="form-control @error('firstIssuDate') is-invalid @enderror" value="{{ old('firstIssuDate', $application->firstIssuDate->format('Y-m-d')) }}">
                        @error('firstIssuDate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="validityDate" class="form-label">Validity Expiry Date</label>
                        <input type="date" name="validityDate" id="validityDate" class="form-control @error('validityDate') is-invalid @enderror" value="{{ old('validityDate', $application->validityDate->format('Y-m-d')) }}">
                        @error('validityDate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="drivingClass" class="form-label">Driving Class(es)</label>
                    <input type="text" name="drivingClass" id="drivingClass" class="form-control @error('drivingClass') is-invalid @enderror" value="{{ old('drivingClass', $application->drivingClass) }}">
                    @error('drivingClass')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Application</button>
                <a href="{{ route('user.driving-licenses.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush