@extends('user.layouts.app')
@section('title') নতুন অর্ডার @endsection
@section('content')
<div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
        @endif

        <h5 class="mb-4">নতুন অর্ডার</h5>
        <form method="POST" action="{{ route('user.new-application') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">NID নম্বর <span class="text-danger">*</span></label>
                <input type="text" name="nid" class="form-control" required placeholder="আপনার NID নম্বর লিখুন">
            </div>
            <div class="mb-3">
                <label class="form-label">নাম <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required placeholder="আপনার নাম লিখুন">
            </div>
            <div class="mb-3">
                <label class="form-label">টাইপ <span class="text-danger">*</span></label>
                <select name="type" class="form-control" required>
                    <option value="">-- নির্বাচন করুন --</option>
                    <option value="sign">সাইন</option>
                    <option value="bio">বায়ো</option>
                </select>
            </div>
            <div class="mb-3">
                <strong>চার্জ: ৳{{ number_format($fee ?? 0, 2) }}</strong>
                <br><small class="text-muted">বর্তমান ব্যালেন্স: ৳{{ number_format($user->balance ?? 0, 2) }}</small>
            </div>
            <button type="submit" class="btn btn-primary px-4">অর্ডার তৈরি করুন</button>
            <a href="{{ route('user.applications') }}" class="btn btn-secondary px-4">বাতিল</a>
        </form>
    </div>
</div>
@endsection