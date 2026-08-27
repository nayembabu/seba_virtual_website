@extends('user.layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">আইডি পাস সেট</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="fw-bold"><i class="fas fa-user-lock"></i> NID ইউজার পাসওয়ার্ড সেট করুন</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info py-2 small">
                            <i class="fas fa-wallet me-1"></i> চার্জ: ৳50.00
                        </div>
                        <form method="POST" action="{{ route('user.nid-pass') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">NID নম্বর <span class="text-danger">*</span></label>
                                <input type="text" name="nid_number" class="form-control" placeholder="NID নম্বর দিন" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">জন্ম তারিখ <span class="text-danger">*</span></label>
                                <input type="date" name="date_of_birth" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">পছন্দমত পাসওয়ার্ড <span class="text-danger">*</span></label>
                                <input type="text" name="password" class="form-control" placeholder="নতুন পাসওয়ার্ড দিন" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">পেমেন্ট করুন এবং ওটিপি পাঠান</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="fw-bold"><i class="fas fa-history"></i> সাম্প্রতিক অর্ডার</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-center text-muted">কোনো অর্ডার পাওয়া যায়নি।</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
