@extends('mod.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="dashboard-content">
        <h2 class="page-title">{{ __('Moderator Dashboard') }}</h2>

        <div class="row mt-4">
            <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title">Pending Applications</h5>
                                <h2 class="mb-0">{{ $a ?? 0 }}</h2>
                            </div>
                            <div class="icon-box bg-primary text-white">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title">Delivered Applications</h5>
                                <h2 class="mb-0">{{ $d ?? 0 }}</h2>
                            </div>
                            <div class="icon-box bg-success text-white">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title">Today's Deliveries</h5>
                                <h2 class="mb-0">{{ $today_delivery ?? 0 }}</h2>
                            </div>
                            <div class="icon-box bg-info text-white">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('mod.applications') }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-list-alt mr-2"></i> View Applications
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('mod.my-applications') }}" class="btn btn-info btn-block">
                                    <i class="fas fa-tasks mr-2"></i> My Applications
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('mod.profile') }}" class="btn btn-secondary btn-block">
                                    <i class="fas fa-user-cog mr-2"></i> Profile Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content-wrapper {
    padding: 20px;
    background: #f8f9fa;
    min-height: 100vh;
}

.card {
    border: none;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.icon-box {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.btn-block {
    padding: 12px;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-block i {
    margin-right: 8px;
}

.page-title {
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
}

.card-title {
    color: #666;
    font-size: 14px;
    margin-bottom: 8px;
}

h2.mb-0 {
    font-size: 28px;
    font-weight: 600;
    color: #333;
}
</style>
@endsection