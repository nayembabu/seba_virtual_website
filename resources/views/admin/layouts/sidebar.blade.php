
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('admin.dashboard') }}" class="logo-link">
            <i class="fas fa-cube logo-icon"></i>
            <span class="logo-text">Admin Panel</span>
        </a>
        <button class="sidebar-close-btn d-lg-none" onclick="closeMobileSidebar()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(optional(Auth::guard('admin')->user())->name ?? 'Admin') }}&background=1e40af&color=fff&size=40" alt="Admin">
        </div>
        <div class="user-info">
            <div class="user-name">{{ optional(Auth::guard('admin')->user())->name ?? 'Admin' }}</div>
            <div class="user-role">Administrator</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                    <i class="nav-icon fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-header"><span>Orders Management</span></li>

            <li class="nav-item">
                <a href="{{ route('admin.sign-copy-orders.index') }}" class="nav-link {{ request()->routeIs('admin.sign-copy-orders.*') ? 'active' : '' }}" data-tooltip="Sign Copy Orders">
                    <i class="nav-icon fas fa-file-signature"></i>
                    <span class="nav-text">Sign Copy Orders</span>
                    @php $pendingCount = \App\Models\SignCopyOrder::where('status', 0)->count(); @endphp
                    @if($pendingCount > 0)<span class="nav-badge">{{ $pendingCount }}</span>@endif
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.id-card-orders.index') }}" class="nav-link {{ request()->routeIs('admin.id-card-orders.*') ? 'active' : '' }}" data-tooltip="ID Card Orders">
                    <i class="nav-icon fas fa-id-card"></i>
                    <span class="nav-text">ID Card Orders</span>
                    @php $idCardPendingCount = \App\Models\NidOrder::where('status', 0)->count(); @endphp
                    @if($idCardPendingCount > 0)<span class="nav-badge">{{ $idCardPendingCount }}</span>@endif
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.passport-orders.index') }}" class="nav-link {{ request()->routeIs('admin.passport-orders.*') ? 'active' : '' }}" data-tooltip="Passport Orders">
                    <i class="nav-icon fas fa-passport"></i>
                    <span class="nav-text">Passport Orders</span>
                    @php $passportPendingCount = \App\Models\PassportOrder::where('status', 0)->count(); @endphp
                    @if($passportPendingCount > 0)<span class="nav-badge">{{ $passportPendingCount }}</span>@endif
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.sim-conversions.index') }}" class="nav-link {{ request()->routeIs('admin.sim-conversions.*') ? 'active' : '' }}" data-tooltip="SIM Biometric">
                    <i class="nav-icon fas fa-sim-card"></i>
                    <span class="nav-text">SIM Biometric Orders</span>
                    @php $simPendingCount = \App\Models\SimConversion::where('status', 0)->count(); @endphp
                    @if($simPendingCount > 0)<span class="nav-badge">{{ $simPendingCount }}</span>@endif
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.sim-network-orders.index') }}" class="nav-link {{ request()->routeIs('admin.sim-network-orders.*') ? 'active' : '' }}" data-tooltip="SIM Network">
                    <i class="nav-icon fas fa-network-wired"></i>
                    <span class="nav-text">SIM Network Orders</span>
                    @php $simNetworkPendingCount = \App\Models\SimNetworkOrder::where('status', 0)->count(); @endphp
                    @if($simNetworkPendingCount > 0)<span class="nav-badge">{{ $simNetworkPendingCount }}</span>@endif
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.tin-orders.index') }}" class="nav-link {{ request()->routeIs('admin.tin-orders.*') ? 'active' : '' }}" data-tooltip="TIN Orders">
                    <i class="nav-icon fas fa-file-invoice"></i>
                    <span class="nav-text">TIN Orders</span>
                    @php $tinPendingCount = \App\Models\TinOrder::where('status', 0)->count(); @endphp
                    @if($tinPendingCount > 0)<span class="nav-badge">{{ $tinPendingCount }}</span>@endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.manual-recharges') }}" class="nav-link {{ request()->routeIs('admin.manual-recharges') ? 'active' : '' }}" data-tooltip="Manual Recharges">
                    <i class="nav-icon fas fa-hand-holding-usd"></i>
                    <span class="nav-text">Manual Recharges</span>
                    @php $pendingRechargeCount = \App\Models\Recharge::whereIn('gateway_id', ['bKash','Nagad','Rocket'])->where('status', 'pending')->count(); @endphp
                    @if($pendingRechargeCount > 0)<span class="nav-badge">{{ $pendingRechargeCount }}</span>@endif
                </a>
            </li>

            <li class="nav-header"><span>System Management</span></li>

            <li class="nav-item">
                <a href="{{ route('admin.service-charges.index') }}" class="nav-link {{ request()->routeIs('admin.service-charges.*') ? 'active' : '' }}" data-tooltip="Service Charges">
                    <i class="nav-icon fas fa-dollar-sign"></i>
                    <span class="nav-text">Service Charges</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.order-charges.index') }}" class="nav-link {{ request()->routeIs('admin.order-charges.*') ? 'active' : '' }}" data-tooltip="Service Charges">
                    <i class="nav-icon fas fa-file-invoice-dollar"></i>
                    <span class="nav-text">Order Charges</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.promo-codes.index') }}" class="nav-link {{ request()->routeIs('admin.promo-codes.*') ? 'active' : '' }}" data-tooltip="Promo Codes">
                    <i class="nav-icon fas fa-tags"></i>
                    <span class="nav-text">Promo Codes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.gateways') }}" class="nav-link {{ request()->routeIs('admin.gateways') || request()->routeIs('admin.add-gateway') || request()->routeIs('admin.edit-gateway') ? 'active' : '' }}" data-tooltip="Gateways">
                    <i class="nav-icon fas fa-credit-card"></i>
                    <span class="nav-text">Gateways</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-tooltip="Users">
                    <i class="nav-icon fas fa-users"></i>
                    <span class="nav-text">Users</span>
                </a>
            </li>
                </a>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" data-tooltip="Settings">
                    <i class="nav-icon fas fa-cog"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}" data-tooltip="My Profile">
                    <i class="nav-icon fas fa-user"></i>
                    <span class="nav-text">My Profile</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 260px;
        background: #1e293b;
        z-index: 1040;
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        overflow-y: scroll;
    }

    /* ΓöÇΓöÇ Desktop collapsed ΓöÇΓöÇ */
    .sidebar.collapsed {
        width: 68px;
    }
    .sidebar.collapsed .logo-text,
    .sidebar.collapsed .user-info,
    .sidebar.collapsed .nav-text,
    .sidebar.collapsed .nav-badge,
    .sidebar.collapsed .nav-header span {
        opacity: 0;
        pointer-events: none;
        width: 0;
        overflow: hidden;
        white-space: nowrap;
    }
    .sidebar.collapsed .nav-header {
        border-top: 1px solid rgba(255,255,255,0.08);
        padding: 0.4rem 0;
        margin: 0.2rem 0;
    }
    .sidebar.collapsed .nav-link {
        justify-content: center;
        padding: 0.75rem 0;
    }
    .sidebar.collapsed .nav-icon {
        margin: 0 20px;
        font-size: 1.15rem;
    }
    .sidebar.collapsed .user-avatar {
        margin-right: 0;
    }
    .sidebar.collapsed .sidebar-user {
        justify-content: center;
        padding: 1rem 0;
    }
    .sidebar.collapsed .logo-link {
        justify-content: center;
    }
    .sidebar.collapsed .logo-icon {
        margin-right: 0;
    }
    /* Tooltip on collapsed icons */
    .sidebar.collapsed .nav-link {
        position: relative;
    }
    .sidebar.collapsed .nav-link::after {
        content: attr(data-tooltip);
        position: absolute;
        left: 68px;
        top: 50%;
        transform: translateY(-50%);
        background: #0f172a;
        color: #e2e8f0;
        font-size: 0.78rem;
        white-space: nowrap;
        padding: 0.35rem 0.65rem;
        border-radius: 0.375rem;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.15s;
        z-index: 9999;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    .sidebar.collapsed .nav-link:hover::after {
        opacity: 1;
    }

    /* ΓöÇΓöÇ Sidebar header ΓöÇΓöÇ */
    .sidebar-logo {
        padding: 1.1rem 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    .logo-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #fff;
        font-weight: 600;
        font-size: 1.05rem;
        overflow: hidden;
        white-space: nowrap;
    }
    .logo-icon {
        font-size: 1.35rem;
        color: #3b82f6;
        flex-shrink: 0;
    }
    .logo-text {
        margin-left: 0.65rem;
        transition: opacity 0.25s, width 0.25s;
    }
    .sidebar-close-btn {
        background: transparent;
        border: none;
        color: #94a3b8;
        font-size: 1rem;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        line-height: 1;
    }
    .sidebar-close-btn:hover { color: #fff; }

    /* ΓöÇΓöÇ User ΓöÇΓöÇ */
    .sidebar-user {
        padding: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        display: flex;
        align-items: center;
        flex-shrink: 0;
        overflow: hidden;
        transition: padding 0.3s;
    }
    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        margin-right: 0.65rem;
        transition: margin 0.3s;
    }
    .user-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .user-info { overflow: hidden; white-space: nowrap; transition: opacity 0.25s, width 0.25s; }
    .user-name { color: #fff; font-weight: 600; font-size: 0.875rem; }
    .user-role { color: #94a3b8; font-size: 0.75rem; }

    /* ΓöÇΓöÇ Nav ΓöÇΓöÇ */
    .sidebar-nav { flex: 1; overflow-y: auto; overflow-x: hidden; padding: 0.75rem 0; }
    .sidebar-nav::-webkit-scrollbar { width: 4px; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
    .nav-list { list-style: none; padding: 0; margin: 0; }
    .nav-header {
        padding: 0.5rem 1rem 0.25rem;
        color: #64748b;
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.06em;
        overflow: hidden;
        white-space: nowrap;
        transition: padding 0.3s;
    }
    .nav-item { margin-bottom: 2px; }
    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.65rem 1rem;
        color: #cbd5e1;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        white-space: nowrap;
        overflow: hidden;
    }
    .nav-link:hover { background: rgba(59,130,246,0.1); color: #fff; }
    .nav-link.active {
        background: rgba(59,130,246,0.15);
        color: #3b82f6;
        box-shadow: inset 3px 0 0 #3b82f6;
    }
    .nav-icon {
        width: 20px;
        text-align: center;
        font-size: 0.95rem;
        flex-shrink: 0;
        margin-right: 0.7rem;
        transition: margin 0.3s;
    }
    .nav-text { flex: 1; font-size: 0.875rem; transition: opacity 0.25s; }
    .nav-badge {
        background: #ef4444;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 1px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
        flex-shrink: 0;
    }

    /* ΓöÇΓöÇ Mobile overlay ΓöÇΓöÇ */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1039;
    }

    /* ΓöÇΓöÇ Mobile breakpoint ΓöÇΓöÇ */
    @media (max-width: 1024px) {
        .sidebar {
            width: 260px !important; /* never icon-only on mobile */
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        .sidebar.mobile-open {
            transform: translateX(0);
        }
        .sidebar-overlay.active {
            display: block;
        }
    }
</style>

<script>
    (function () {
        var sidebar  = document.getElementById('sidebar');
        var overlay  = document.getElementById('sidebarOverlay');
        var body     = document.body;

        function isMobile() { return window.innerWidth <= 1024; }

        /* Called by the header toggle button */
        window.toggleAdminSidebar = function () {
            if (isMobile()) {
                var open = sidebar.classList.toggle('mobile-open');
                overlay.classList.toggle('active', open);
                body.classList.toggle('sidebar-open', open);
            } else {
                var collapsed = sidebar.classList.toggle('collapsed');
                var main = document.querySelector('.main-content');
                if (main) main.classList.toggle('sidebar-collapsed', collapsed);
            }
        };

        function closeMobile() {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            body.classList.remove('sidebar-open');
        }
        window.closeMobileSidebar = closeMobile;

        overlay.addEventListener('click', closeMobile);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMobile();
        });

        /* Reset state on resize so classes don't bleed across breakpoints */
        window.addEventListener('resize', function () {
            if (!isMobile()) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                body.classList.remove('sidebar-open');
            } else {
                sidebar.classList.remove('collapsed');
                var main = document.querySelector('.main-content');
                if (main) main.classList.remove('sidebar-collapsed');
            }
        });
    })();
</script>[?9001l[?1004l
