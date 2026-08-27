@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Welcome back, Admin')

@section('content')
<div class="row g-4">
    <!-- Quick Stats -->
    <div class="col-lg col-md-6">
        <div class="stat-card stat-card-primary">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ App\Models\User::count() }}</div>
                <div class="stat-label">Users</div>
            </div>
        </div>
    </div>

    <div class="col-lg col-md-6">
        <div class="stat-card stat-card-success">
            <div class="stat-icon">
                <i class="fas fa-file-signature"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ App\Models\SignCopyOrder::count() }}</div>
                <div class="stat-label">Sign Orders</div>
            </div>
        </div>
    </div>

    <div class="col-lg col-md-6">
        <div class="stat-card stat-card-warning">
            <div class="stat-icon">
                <i class="fas fa-id-card"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ App\Models\NidOrder::count() }}</div>
                <div class="stat-label">ID Cards</div>
            </div>
        </div>
    </div>

    <div class="col-lg col-md-6">
        <div class="stat-card stat-card-danger">
            <div class="stat-icon">
                <i class="fas fa-passport"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ App\Models\PassportOrder::count() }}</div>
                <div class="stat-label">Passports</div>
            </div>
        </div>
    </div>

    <div class="col-lg col-md-6">
        <div class="stat-card stat-card-info">
            <div class="stat-icon">
                <i class="fas fa-coins"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $today_recharge_amount ?? 0 }} ৳</div>
                <div class="stat-label">Today Recharges ({{ $today_recharge_count ?? 0 }})</div>
            </div>
        </div>
    </div>

    <!-- Pending Orders Alert -->
    <div class="col-12">
        <div class="alert alert-warning d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle me-3"></i>
            <div>
                <strong>Pending Orders:</strong>
                <span class="badge bg-danger ms-2">{{ App\Models\SignCopyOrder::where('status', 0)->count() }}</span> Sign,
                <span class="badge bg-danger ms-1">{{ App\Models\NidOrder::where('status', 0)->count() }}</span> ID Card,
                <span class="badge bg-danger ms-1">{{ App\Models\PassportOrder::where('status', 0)->count() }}</span> Passport,
                <span class="badge bg-danger ms-1">{{ App\Models\SimConversion::where('status', 0)->count() }}</span> SIM,
                <span class="badge bg-danger ms-1">{{ App\Models\TinOrder::where('status', 0)->count() }}</span> TIN
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt text-primary me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <a href="{{ route('admin.service-charges.index') }}" class="btn-action">
                            <i class="fas fa-dollar-sign"></i>
                            Service Charges
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('admin.settings.index') }}" class="btn-action">
                            <i class="fas fa-cog"></i>
                            Settings
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('admin.supports') }}" class="btn-action">
                            <i class="fas fa-headset"></i>
                            Support
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('admin.profile.edit') }}" class="btn-action">
                            <i class="fas fa-user"></i>
                            Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Management Links -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clipboard-list text-info me-2"></i>Order Management</h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-2 col-4">
                        <a href="{{ route('admin.sign-copy-orders.index') }}" class="order-link">
                            <i class="fas fa-file-signature"></i>
                            <span>Sign Copy</span>
                            @if(App\Models\SignCopyOrder::where('status', 0)->count() > 0)
                                <span class="badge bg-danger">{{ App\Models\SignCopyOrder::where('status', 0)->count() }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="col-md-2 col-4">
                        <a href="{{ route('admin.id-card-orders.index') }}" class="order-link">
                            <i class="fas fa-id-card"></i>
                            <span>ID Cards</span>
                            @if(App\Models\NidOrder::where('status', 0)->count() > 0)
                                <span class="badge bg-danger">{{ App\Models\NidOrder::where('status', 0)->count() }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="col-md-2 col-4">
                        <a href="{{ route('admin.passport-orders.index') }}" class="order-link">
                            <i class="fas fa-passport"></i>
                            <span>Passports</span>
                            @if(App\Models\PassportOrder::where('status', 0)->count() > 0)
                                <span class="badge bg-danger">{{ App\Models\PassportOrder::where('status', 0)->count() }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="col-md-2 col-4">
                        <a href="{{ route('admin.sim-conversions.index') }}" class="order-link">
                            <i class="fas fa-sim-card"></i>
                            <span>SIM Bio</span>
                            @if(App\Models\SimConversion::where('status', 0)->count() > 0)
                                <span class="badge bg-danger">{{ App\Models\SimConversion::where('status', 0)->count() }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="col-md-2 col-4">
                        <a href="{{ route('admin.sim-network-orders.index') }}" class="order-link">
                            <i class="fas fa-network-wired"></i>
                            <span>SIM Network</span>
                            @if(App\Models\SimNetworkOrder::where('status', 0)->count() > 0)
                                <span class="badge bg-danger">{{ App\Models\SimNetworkOrder::where('status', 0)->count() }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="col-md-2 col-4">
                        <a href="{{ route('admin.tin-orders.index') }}" class="order-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>TIN Orders</span>
                            @if(App\Models\TinOrder::where('status', 0)->count() > 0)
                                <span class="badge bg-danger">{{ App\Models\TinOrder::where('status', 0)->count() }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    /* Stat Cards */
    .stat-card {
        border: none;
        border-radius: 0.75rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        flex-shrink: 0;
    }
    
    .stat-content {
        flex: 1;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.875rem;
        font-weight: 500;
        opacity: 0.8;
    }
    
    /* Stat Card Colors */
    .stat-card-primary { background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); }
    .stat-card-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .stat-card-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .stat-card-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    .stat-card-info { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
    
    /* Action Buttons */
    .btn-action {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        text-decoration: none;
        color: #374151;
        transition: all 0.2s ease;
        background: #fff;
        font-weight: 500;
        text-align: center;
        justify-content: center;
    }
    
    .btn-action:hover {
        border-color: var(--primary-color);
        background: var(--primary-color);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }
    
    .btn-action i {
        font-size: 1.25rem;
    }
    
    /* Order Links */
    .order-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        text-decoration: none;
        color: #374151;
        transition: all 0.2s ease;
        background: #fff;
        position: relative;
    }
    
    .order-link:hover {
        border-color: var(--primary-color);
        background: #f8fafc;
        color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .order-link i {
        font-size: 1.5rem;
    }
    
    .order-link span {
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .order-link .badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        font-size: 0.625rem;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .stat-card {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .btn-action,
        .order-link {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
    }
</style>
@endpush
