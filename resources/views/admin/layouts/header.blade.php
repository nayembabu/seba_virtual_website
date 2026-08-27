<!-- Top Navigation Bar -->
<header class="top-navbar">
    <div class="navbar-left">
        <button type="button" class="sidebar-toggle" onclick="toggleAdminSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="navbar-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>
    </div>

    <div class="navbar-center">
        <h4 class="page-title mb-0">@yield('page_title', 'Admin Dashboard')</h4>
        @if(trim($__env->yieldContent('page_subtitle')))
            <small class="page-subtitle text-muted">{{ $__env->yieldContent('page_subtitle') }}</small>
        @endif
    </div>

    <div class="navbar-right">
        <!-- Search -->
        <div class="navbar-search d-none d-lg-flex">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search...">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Notifications -->
        <div class="navbar-notifications dropdown">
            <button class="btn btn-icon dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">Notifications</h6></li>
                <li><a class="dropdown-item" href="#">
                    <i class="fas fa-exclamation-circle text-warning me-2"></i>
                    5 pending orders
                </a></li>
                <li><a class="dropdown-item" href="#">
                    <i class="fas fa-user-plus text-success me-2"></i>
                    New user registered
                </a></li>
                <li><a class="dropdown-item" href="#">
                    <i class="fas fa-headset text-info me-2"></i>
                    New support ticket
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
            </ul>
        </div>

        <!-- User Menu -->
        <div class="navbar-user dropdown">
            <button class="btn btn-icon dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                <div class="user-avatar-small">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(optional(Auth::guard('admin')->user())->name ?? 'Admin') }}&background=1e40af&color=fff&size=32" alt="Admin">
                </div>
                <span class="user-name-small d-none d-md-inline">{{ Str::limit(optional(Auth::guard('admin')->user())->name ?? 'Admin', 15) }}</span>
                <i class="fas fa-chevron-down ms-2"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">{{ optional(Auth::guard('admin')->user())->name ?? 'Admin' }}</h6></li>
                <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                    <i class="fas fa-user me-2"></i> Profile
                </a></li>
                <li><a class="dropdown-item" href="#">
                    <i class="fas fa-cog me-2"></i> Settings
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

<style>
/* Header Styles */
.top-navbar {
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    padding: 0.75rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 1030;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.navbar-left {
    display: flex;
    align-items: center;
    flex: 1;
}

.sidebar-toggle {
    background: #3b82f6;
    color: #fff;
    border: none;
    padding: 0.5rem 0.625rem;
    border-radius: 0.5rem;
    cursor: pointer;
    margin-right: 1rem;
    transition: all 0.2s;
}

.sidebar-toggle:hover {
    background: #2563eb;
}

.navbar-breadcrumb .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.navbar-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #9ca3af;
}

.navbar-center {
    text-align: center;
    flex: 1;
}

.page-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
}

.page-subtitle {
    font-size: 0.875rem;
}

.navbar-right {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
    justify-content: flex-end;
}

.navbar-search {
    max-width: 300px;
}

.navbar-search .form-control {
    border-right: none;
}

.navbar-search .btn {
    border-left: none;
    border-color: #d1d5db;
}

.navbar-notifications,
.navbar-user {
    position: relative;
}

.btn-icon {
    background: transparent;
    border: 1px solid #e5e7eb;
    padding: 0.5rem;
    border-radius: 0.5rem;
    position: relative;
    transition: all 0.2s;
}

.btn-icon:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}

.notification-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: #ef4444;
    color: #fff;
    font-size: 0.625rem;
    font-weight: 600;
    padding: 0.125rem 0.25rem;
    border-radius: 10px;
    min-width: 16px;
    text-align: center;
}

.user-avatar-small {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 0.5rem;
}

.user-avatar-small img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-name-small {
    font-size: 0.875rem;
    font-weight: 500;
}

.dropdown-menu {
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    padding: 0.5rem;
}

.dropdown-header {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.dropdown-item:hover {
    background: #f3f4f6;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .top-navbar {
        padding: 0.75rem 1rem;
        flex-wrap: wrap;
    }
    
    .navbar-left {
        order: 1;
        flex: 0 0 auto;
    }
    
    .navbar-center {
        order: 3;
        flex: 0 0 100%;
        text-align: left;
        margin-top: 0.5rem;
    }
    
    .navbar-right {
        order: 2;
        flex: 0 0 auto;
    }
    
    .page-title {
        font-size: 1.125rem;
    }
}

@media (max-width: 576px) {
    .navbar-search {
        display: none !important;
    }
    
    .user-name-small {
        display: none !important;
    }
}
</style>
