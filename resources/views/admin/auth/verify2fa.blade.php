@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Two-Factor Authentication Setup</h2>
    <p>Scan the QR code below with your authenticator app (e.g., Google Authenticator, Authy, etc.)</p>

    @if(session('qr_code'))
        <div>
            <img src="{{ session('qr_code') }}" alt="QR Code" />
            <p>Or enter this secret key: <strong>{{ session('secret') }}</strong></p>
        </div>
    @else
        <div>
            <p>QR code not available. Please try again.</p>
        </div>
    @endif

    <form action="{{ route('admin.postVerify2fa') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="one_time_password">Enter Verification Code:</label>
            <input type="text" class="form-control" id="one_time_password" name="one_time_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
</div>
@endsection
