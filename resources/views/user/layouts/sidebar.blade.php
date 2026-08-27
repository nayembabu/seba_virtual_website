<aside class="main-sidebar modern-sidebar elevation-4"><style>
@font-face {
    font-family: 'SolaimanLipi';
    src: url('/fonts/SolaimanLipi.woff2') format('woff2'),
         url('/fonts/SolaimanLipi.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'SolaimanLipi';
    src: url('/fonts/solaimanlipi-bold-v1.0.woff2') format('woff2'),
         url('/fonts/solaimanlipi-bold-v1.0.ttf') format('truetype');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}
.modern-sidebar {
    background: #FFFFFF !important;
    width: 260px;
    min-height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1035;
    transition: transform 0.35s cubic-bezier(0.4,0,0.2,1), box-shadow 0.35s ease;
    box-shadow: 2px 0 12px rgba(0,0,0,0.06);
    border-right: 1px solid #E0E0E0;
}

.modern-sidebar .sidebar { 
    scrollbar-width: thin; 
    scrollbar-color: #E0E0E0 transparent;
    padding-bottom: 80px !important;
    background: #F5F5F5;
}
.modern-sidebar .sidebar::-webkit-scrollbar { width: 4px; }
.modern-sidebar .sidebar::-webkit-scrollbar-track { background: transparent; }
.modern-sidebar .sidebar::-webkit-scrollbar-thumb { background: #E0E0E0; border-radius: 4px; }

.modern-sidebar .brand-link {
    background: #FFFFFF !important;
    border-bottom: 1px solid #E0E0E0;
    padding: 16px 20px !important;
    height: 72px !important;
}

.modern-sidebar .brand-link .brand-text {
    font-size: 20px;
    font-weight: 700;
    color: #1a2332;
}

.modern-sidebar .brand-link .brand-text span {
    color: #0D47A1;
}

.modern-sidebar .brand-link .brand-badge {
    font-size: 9px;
    font-weight: 600;
    background: rgba(13, 71, 161, 0.1);
    color: #0D47A1;
    padding: 2px 10px;
    border-radius: 20px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-left: auto;
    border: 1px solid rgba(13, 71, 161, 0.1);
}

.modern-sidebar .nav-sidebar > .nav-item > .nav-link {
    border-radius: 10px;
    margin: 2px 12px;
    padding: 12px 18px;
    color: #333333;
    font-size: 17px;
    font-weight: 600;
    transition: all 0.2s ease;
    gap: 10px;
}
.modern-sidebar .nav-sidebar > .nav-item > .nav-link:hover {
    background: #F5F5F5;
    color: #333333;
}
.modern-sidebar .nav-sidebar > .nav-item.menu-open > .nav-link,
.modern-sidebar .nav-sidebar > .nav-item > .nav-link.active {
    background: linear-gradient(135deg, #0D47A1 0%, #1A237E 100%);
    color: #FFFFFF;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(13,71,161,0.3);
}
.modern-sidebar .nav-sidebar > .nav-item.menu-open > .nav-link:hover,
.modern-sidebar .nav-sidebar > .nav-item > .nav-link.active:hover {
    background: linear-gradient(135deg, #1A237E 0%, #0D47A1 100%);
}

.modern-sidebar .nav-sidebar .nav-link .nav-icon {
    font-size: 20px;
    width: 30px;
    text-align: center;
    color: #1E88E5;
    flex-shrink: 0;
}
.modern-sidebar .nav-sidebar > .nav-item.menu-open > .nav-link .nav-icon,
.modern-sidebar .nav-sidebar > .nav-item > .nav-link.active .nav-icon {
    color: #FFFFFF;
}
.modern-sidebar .nav-sidebar > .nav-item > .nav-link:hover .nav-icon {
    color: #0D47A1;
}

.modern-sidebar .nav-sidebar .nav-link p {
    margin: 0;
    flex: 1;
    font-size: 17px;
}

.modern-sidebar .nav-sidebar .nav-link .right {
    margin-left: auto;
    transition: transform 0.3s ease;
    font-size: 14px;
    color: #999;
}

.modern-sidebar .nav-item.menu-open .nav-link .right {
    transform: rotate(-90deg);
    color: #fff;
}

.modern-sidebar .nav-treeview {
    background: transparent;
    border-radius: 0;
    margin: 0 12px;
    padding: 4px 0;
    border-left: 2px solid #E0E0E0;
}
.modern-sidebar .nav-treeview .nav-item {
    margin: 0;
}
.modern-sidebar .nav-treeview .nav-link {
    padding: 8px 14px 8px 28px;
    color: #444444;
    font-size: 16px;
    font-weight: 500;
    border-radius: 4px;
    margin: 1px 0;
    transition: all 0.15s ease;
    gap: 8px;
}
.modern-sidebar .nav-treeview .nav-link:hover {
    background: #F5F5F5;
    color: #000000;
}
.modern-sidebar .nav-treeview .nav-link.active {
    background: rgba(13, 71, 161, 0.08);
    color: #0D47A1;
    font-weight: 600;
}
.modern-sidebar .nav-treeview .nav-link .nav-icon {
    font-size: 16px;
    width: 22px;
    color: #777;
}
.modern-sidebar .nav-treeview .nav-link:hover .nav-icon {
    color: #0D47A1;
}
.modern-sidebar .nav-treeview .nav-link p {
    font-size: 16px;
}

.modern-sidebar .nav-header {
    color: #212121;
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 16px 6px !important;
    margin: 4px 8px 2px !important;
    background: transparent;
    border-radius: 0;
    width: auto;
    text-align: left;
    display: block;
}

/* Price Tag */
.modern-sidebar .price-tag {
    font-size: 12px;
    font-weight: 600;
    color: #0D47A1;
    background: rgba(13, 71, 161, 0.08);
    padding: 1px 10px;
    border-radius: 12px;
    margin-left: 6px;
    white-space: nowrap;
}

.modern-sidebar .nav-sidebar > .nav-item.menu-open > .nav-link .price-tag,
.modern-sidebar .nav-sidebar > .nav-item > .nav-link.active .price-tag {
    color: #FFFFFF;
    background: rgba(255,255,255,0.2);
}

/* Badge Off */
.modern-sidebar .badge-off {
    background: #fee2e2;
    color: #dc2626;
    font-size: 10px;
    font-weight: 600;
    padding: 1px 8px;
    border-radius: 10px;
    margin-left: 4px;
    border: 1px solid #fecaca;
    text-transform: uppercase;
    letter-spacing: 0.2px;
}

.modern-sidebar .service-disabled {
    opacity: 0.4;
    pointer-events: none;
    cursor: not-allowed;
}

/* Icon Group Colors */
.modern-sidebar .nav-link .nav-icon.fa-tachometer-alt,
.modern-sidebar .nav-link .nav-icon.fa-home,
.modern-sidebar .nav-link .nav-icon.fa-dashboard,
.modern-sidebar .nav-link .nav-icon.fa-wallet { color: #0D47A1; }

.modern-sidebar .nav-link .nav-icon.fa-id-card,
.modern-sidebar .nav-link .nav-icon.fa-id-card-alt,
.modern-sidebar .nav-link .nav-icon.fa-file-alt,
.modern-sidebar .nav-link .nav-icon.fa-file,
.modern-sidebar .nav-link .nav-icon.fa-copy,
.modern-sidebar .nav-link .nav-icon.fa-plus-circle,
.modern-sidebar .nav-link .nav-icon.fa-globe,
.modern-sidebar .nav-link .nav-icon.fa-sync-alt,
.modern-sidebar .nav-link .nav-icon.fa-server { color: #1E88E5; }

.modern-sidebar .nav-link .nav-icon.fa-archive,
.modern-sidebar .nav-link .nav-icon.fa-folder,
.modern-sidebar .nav-link .nav-icon.fa-folder-open,
.modern-sidebar .nav-link .nav-icon.fa-database,
.modern-sidebar .nav-link .nav-icon.fa-list-ul { color: #FF5722; }

.modern-sidebar .nav-link .nav-icon.fa-car,
.modern-sidebar .nav-link .nav-icon.fa-truck,
.modern-sidebar .nav-link .nav-icon.fa-bus,
.modern-sidebar .nav-link .nav-icon.fa-motorcycle,
.modern-sidebar .nav-link .nav-icon.fa-shuttle-van { color: #E53935; }

.modern-sidebar .nav-link .nav-icon.fa-certificate,
.modern-sidebar .nav-link .nav-icon.fa-award,
.modern-sidebar .nav-link .nav-icon.fa-medal,
.modern-sidebar .nav-link .nav-icon.fa-trophy,
.modern-sidebar .nav-link .nav-icon.fa-baby,
.modern-sidebar .nav-link .nav-icon.fa-briefcase { color: #43A047; }

@media (max-width: 991.98px) {
    .modern-sidebar {
        transform: translateX(-100%);
        box-shadow: none;
    }
    body.sidebar-open .modern-sidebar {
        transform: translateX(0);
        box-shadow: 4px 0 40px rgba(0,0,0,0.15);
    }
}

/* Entry Animation */
@keyframes msFadeIn {
    from { opacity: 0; transform: translateX(-8px); }
    to { opacity: 1; transform: translateX(0); }
}

.modern-sidebar .nav-item {
    animation: msFadeIn 0.2s ease forwards;
    opacity: 0;
}

.modern-sidebar .nav-item:nth-child(1) { animation-delay: 0.02s; }
.modern-sidebar .nav-item:nth-child(2) { animation-delay: 0.04s; }
.modern-sidebar .nav-item:nth-child(3) { animation-delay: 0.06s; }
.modern-sidebar .nav-item:nth-child(4) { animation-delay: 0.08s; }
.modern-sidebar .nav-item:nth-child(5) { animation-delay: 0.10s; }
</style>

    <!-- Brand Logo / Header -->
    <a href="{{route('user.dashboard')}}" class="brand-link bg-white text-start" style="padding-left: 20px;">
        <img src="{{ asset('assets/images/logo.png') }}"
             alt="homepage"
             class="dark-logo" style="height: 48px;"/>
        <span class="brand-badge">v2.0</span>
    </a>

    <!-- Sidebar Scrollable Container -->
    <div class="sidebar">
        <style>
            .main-sidebar {
                font-family: 'SolaimanLipi', 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
                width: 260px;
                min-height: 100vh;
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 1038;
                transition: width 0.3s ease-in-out;
            }
            .brand-link {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 13px 16px;
                text-decoration: none !important;
                font-size: 1.8rem;
                line-height: 1.5;
            }
            .sidebar {
                padding: 12px 0;
                height: calc(100vh - 72px);
                overflow-y: auto;
            }
            .nav-sidebar > .nav-item { position: relative; }
            .nav-sidebar .nav-link { position: relative; display: flex; align-items: center; }
            .nav-sidebar .nav-link p { margin: 0; flex: 1; }
            .nav-sidebar .nav-link .right { margin-left: auto; transition: transform 0.3s; }
            .nav-sidebar .nav-item.menu-open .nav-link .right { transform: rotate(-90deg); }
            .nav-treeview { list-style: none; padding: 0; margin: 0; display: none; }
            .nav-item.menu-open > .nav-treeview { display: block; }
            .nav-treeview .nav-link { padding-left: 40px; }
        </style>

        <!-- Sidebar Menu Elements -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                {{-- ═══════════════════════════════════ --}}
                {{-- GENERAL --}}
                {{-- ═══════════════════════════════════ --}}
                <li class="nav-header">সাধারণ</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                       href="{{ route('user.dashboard') }}">
                        <i class="nav-icon fas fa-home" aria-hidden="true"></i>
                        <p>ড্যাশবোর্ড</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs(['user.ssl-commerz','user.bkash','user.recharge','user.recharge-form','user.transactions']) ? 'active' : '' }}"
                       href="{{ route('user.recharge') }}">
                        <i class="nav-icon fas fa-wallet" aria-hidden="true"></i>
                        <p>রিচার্জ করুন</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs(['user.manual-recharge']) ? 'active' : '' }}"
                       href="{{ route('user.manual-recharge') }}">
                        <i class="nav-icon fas fa-hand-holding-usd text-success" aria-hidden="true"></i>
                        <p>ম্যানুয়্যাল রিচার্জ</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.transactions') ? 'active' : '' }}"
                       href="{{ route('user.transactions') }}">
                        <i class="nav-icon fas fa-list-ul" aria-hidden="true"></i>
                        <p>ট্রানজেকশন হিস্টোরি</p>
                    </a>
                </li>

                {{-- ═══════════════════════════════════ --}}
                {{-- AUTO SERVICE --}}
                {{-- ═══════════════════════════════════ --}}
                <li class="nav-header">অটো সার্ভিস</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.search') ? 'active' : '' }}"
                       href="{{ route('user.search') }}">
                        <i class="nav-icon fas fa-search" aria-hidden="true"></i>
                        <p>অটো সাইন</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs(['user.server-copy','user.server-copy-view']) ? 'active' : '' }}"
                       href="{{ route('user.server-copy') }}">
                        <i class="nav-icon fas fa-server" aria-hidden="true"></i>
                        <p>অটো সার্ভার কপি</p>
                    </a>
                </li>

                {{-- NID Card Make --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.nid-card.create') && request('type') == 'nid' ? 'active' : '' }}"
                       href="{{ route('user.nid-card.create', ['type' => 'nid']) }}">
                        <i class="nav-icon fas fa-id-card" aria-hidden="true"></i>
                        <p>এনআইডি মেক</p>
                    </a>
                </li>

                {{-- Sign to Server --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.nid-card.create') && request('type') == 'sign-to-server' ? 'active' : '' }}"
                       href="{{ route('user.nid-card.create', ['type' => 'sign-to-server']) }}">
                        <i class="nav-icon fas fa-server" aria-hidden="true"></i>
                        <p>সাইন টু সার্ভার</p>
                    </a>
                </li>

                {{-- CDMS to Server --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.nid-card.create') && request('type') == 'cdms' ? 'active' : '' }}"
                       href="{{ route('user.nid-card.create', ['type' => 'cdms']) }}">
                        <i class="nav-icon fas fa-database" aria-hidden="true"></i>
                        <p>CDMS টু সার্ভার</p>
                    </a>
                </li>

                {{-- NID List --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.nid-card.index') ? 'active' : '' }}"
                       href="{{ route('user.nid-card.index') }}">
                        <i class="nav-icon fas fa-list-ul" aria-hidden="true"></i>
                        <p>এনআইডি মেক লিস্ট</p>
                    </a>
                </li>
                {{-- Passport Slip --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('passport.search') ? 'active' : '' }}"
                       href="{{ route('passport.search') }}">
                        <i class="nav-icon fas fa-passport" aria-hidden="true"></i>
                        <p>পাসপোর্ট স্লিপ</p>
                    </a>
                </li>

                {{-- Visa Info --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('visa.search') ? 'active' : '' }}"
                       href="{{ route('visa.search') }}">
                        <i class="nav-icon fas fa-plane" aria-hidden="true"></i>
                        <p>ভিসা ইনফো</p>
                    </a>
                </li>

                {{-- Smart Card Make --}}
                @php $smartcard = getServiceMenu('smartcard'); @endphp
                <li class="nav-item {{ ($smartcard && !$smartcard->status) ? 'service-disabled' : '' }}">
                    <a class="nav-link {{ request()->routeIs('user.smartcard.*') ? 'active' : '' }}"
                       href="{{ ($smartcard && $smartcard->status) ? route('user.smartcard.index') : 'javascript:void(0)' }}">
                        <i class="nav-icon fas fa-id-card-alt" aria-hidden="true"></i>
                        <p>স্মার্ট কার্ড মেক @if($smartcard && !$smartcard->status)<span class="badge-off">বন্ধ</span>@endif</p>
                    </a>
                </li>

                {{-- Auto TIN Service --}}
                @php $tin = getServiceMenu('tin'); @endphp
                <li class="nav-item {{ ($tin && !$tin->status) ? 'service-disabled' : '' }}">
                    <a class="nav-link {{ request()->routeIs('user.tin.*') && !Route::is('user.tin.order.index') ? 'active' : '' }}"
                       href="{{ ($tin && $tin->status) ? route('user.tin.index') : 'javascript:void(0)' }}">
                        <i class="nav-icon fas fa-clipboard-check" aria-hidden="true"></i>
                        <p>অটো টিন ডাউনলোড @if($tin && !$tin->status)<span class="badge-off">বন্ধ</span>@endif</p>
                    </a>
                </li>

                {{-- Birth/Death Registration --}}
                <li class="nav-item {{ request()->routeIs(['user.nibondon.*','user.death_certificate.*']) ? 'menu-open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="nav-icon fas fa-certificate" aria-hidden="true"></i>
                        <p>
                            জন্ম নিবন্ধন মেক
                            <i class="right fas fa-angle-left" aria-hidden="true"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @php $nibondon = getServiceMenu('nibondon'); @endphp
                        <li class="nav-item {{ ($nibondon && !$nibondon->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.nibondon.*') ? 'active' : '' }}"
                               href="{{ ($nibondon && $nibondon->status) ? route('user.nibondon.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-baby" aria-hidden="true"></i>
                                <p>জন্ম নিবন্ধন @if($nibondon && !$nibondon->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $death = getServiceMenu('death_certificate'); @endphp
                        <li class="nav-item {{ ($death && !$death->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.death_certificate.*') ? 'active' : '' }}"
                               href="{{ ($death && $death->status) ? route('user.death_certificate.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-file-alt" aria-hidden="true"></i>
                                <p>মৃত্যু নিবন্ধন @if($death && !$death->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        <li class="nav-item {{ ($nibondon && !$nibondon->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link"
                               href="{{ ($nibondon && $nibondon->status) ? route('user.old-birth') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-archive" aria-hidden="true"></i>
                                <p>পুরাতন নিবন্ধন @if($nibondon && !$nibondon->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ═══════════════════════════════════ --}}
                {{-- ORDER MANAGEMENT --}}
                {{-- ═══════════════════════════════════ --}}
                <li class="nav-header">অর্ডার ম্যানেজমেন্ট</li>

                <li class="nav-item">
                    <a href="{{ route('user.sign.copy.order.index') }}" class="nav-link {{ request()->routeIs('user.sign.copy.order.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-signature" aria-hidden="true"></i>
                        <p>সাইন কপি অর্ডার</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.nid.order.index') }}" class="nav-link {{ request()->routeIs('user.nid.order.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-card" aria-hidden="true"></i>
                        <p>আইডি কার্ড অর্ডার</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.passport.order.index') }}" class="nav-link {{ request()->routeIs('user.passport.order.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-passport" aria-hidden="true"></i>
                        <p>পাসপোর্ট অর্ডার</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.sim.conversion.index') }}" class="nav-link {{ request()->routeIs('user.sim.conversion.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fingerprint" aria-hidden="true"></i>
                        <p>সিম বায়োমেট্রিক অর্ডার</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.sim.network.index') }}" class="nav-link {{ request()->routeIs('user.sim.network.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-signal" aria-hidden="true"></i>
                        <p>সিম নেটওয়ার্ক অর্ডার</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.tin.order.index') }}" class="nav-link {{ request()->routeIs('user.tin.order.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt" aria-hidden="true"></i>
                        <p>টিন অর্ডার</p>
                    </a>
                </li>

                {{-- ═══════════════════════════════════ --}}
                {{-- CLONE SERVICE --}}
                {{-- ═══════════════════════════════════ --}}
                <li class="nav-header">ক্লোন সার্ভিস</li>

                {{-- Land Services --}}
                <li class="nav-item {{ request()->routeIs(['user.land.*']) ? 'menu-open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="nav-icon fas fa-map" aria-hidden="true"></i>
                        <p>
                            ভূমি সেবা
                            <i class="right fas fa-angle-left" aria-hidden="true"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @php $land = getServiceMenu('land'); @endphp
                        <li class="nav-item {{ ($land && !$land->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.land.*') ? 'active' : '' }}"
                               href="{{ ($land && $land->status) ? route('user.land.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-file-alt" aria-hidden="true"></i>
                                <p>ভূমি উন্নয়ন কর @if($land && !$land->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $khatian = getServiceMenu('khatian'); @endphp
                        <li class="nav-item {{ ($khatian && !$khatian->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.khatian.*') ? 'active' : '' }}"
                               href="{{ ($khatian && $khatian->status) ? route('user.khatian.create') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-folder" aria-hidden="true"></i>
                                <p>নামজারি খতিয়ান @if($khatian && !$khatian->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- TIN Services --}}
                <li class="nav-item {{ request()->routeIs(['user.tin.*','user.return.*']) ? 'menu-open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="nav-icon fas fa-receipt" aria-hidden="true"></i>
                        <p>
                            টিন সেবা
                            <i class="right fas fa-angle-left" aria-hidden="true"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ ($tin && !$tin->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link"
                               href="{{ ($tin && $tin->status) ? route('user.tin.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-copy" aria-hidden="true"></i>
                                <p>টিন সার্টিফিকেট ক্লোন @if($tin && !$tin->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $return = getServiceMenu('return'); @endphp
                        <li class="nav-item {{ ($return && !$return->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.return.*') ? 'active' : '' }}"
                               href="{{ ($return && $return->status) ? route('user.return.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-sync-alt" aria-hidden="true"></i>
                                <p>রিটার্ন সাবমিট ক্লোন @if($return && !$return->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Visa Services --}}
                <li class="nav-item {{ request()->routeIs(['user.application-details.*','user.visa-applications.*','user.evisas.*']) ? 'menu-open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="nav-icon fas fa-passport" aria-hidden="true"></i>
                        <p>
                            ভিসা সেবা
                            <i class="right fas fa-angle-left" aria-hidden="true"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @php $apostil = getServiceMenu('application-details'); @endphp
                        <li class="nav-item {{ ($apostil && !$apostil->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.application-details.*') ? 'active' : '' }}"
                               href="{{ ($apostil && $apostil->status) ? route('user.application-details.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-file-alt" aria-hidden="true"></i>
                                <p>অপোস্টিল @if($apostil && !$apostil->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $visa = getServiceMenu('visa-applications'); @endphp
                        <li class="nav-item {{ ($visa && !$visa->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.visa-applications.*') ? 'active' : '' }}"
                               href="{{ ($visa && $visa->status) ? route('user.visa-applications.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-globe" aria-hidden="true"></i>
                                <p>ভিসা আবেদন @if($visa && !$visa->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $evisa = getServiceMenu('evisas'); @endphp
                        <li class="nav-item {{ ($evisa && !$evisa->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.evisas.*') ? 'active' : '' }}"
                               href="{{ ($evisa && $evisa->status) ? route('user.evisas.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-passport" aria-hidden="true"></i>
                                <p>ই-ভিসa  @if($evisa && !$evisa->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Education Certificates --}}
                <li class="nav-item {{ request()->routeIs(['user.ssc_certificate.*']) ? 'menu-open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="nav-icon fas fa-graduation-cap" aria-hidden="true"></i>
                        <p>
                            শিক্ষা সনদ
                            <i class="right fas fa-angle-left" aria-hidden="true"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @php $ssc = getServiceMenu('ssc_certificate'); @endphp
                        <li class="nav-item {{ ($ssc && !$ssc->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.ssc_certificate.*') ? 'active' : '' }}"
                               href="{{ ($ssc && $ssc->status) ? route('user.ssc_certificate.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-certificate" aria-hidden="true"></i>
                                <p>এসএসসি সনদপত্র @if($ssc && !$ssc->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.mark_sheet.index') ? 'active' : '' }}"
                               href="{{ route('user.mark_sheet.index') }}">
                                <i class="nav-icon fas fa-file-alt" aria-hidden="true"></i>
                                <p>মার্কশিট মেক (Mark Sheet)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.cv-maker.index') ? 'active' : '' }}"
                               href="{{ route('user.cv-maker.index') }}">
                                <i class="nav-icon fas fa-file" aria-hidden="true"></i>
                                <p>সিভি মেক (CV Maker)</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- BMET Services --}}
                <li class="nav-item {{ request()->routeIs(['user.bmet-update.*','bmet.*','user.bmet-ec.*','user.soudi-sonod.*']) ? 'menu-open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="nav-icon fas fa-briefcase" aria-hidden="true"></i>
                        <p>
                            বিএমইটি সেবা
                            <i class="right fas fa-angle-left" aria-hidden="true"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @php $bmetUpdate = getServiceMenu('bmet-update'); @endphp
                        <li class="nav-item {{ ($bmetUpdate && !$bmetUpdate->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.bmet-update.*') ? 'active' : '' }}"
                               href="{{ ($bmetUpdate && $bmetUpdate->status) ? route('user.bmet-update.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-id-card" aria-hidden="true"></i>
                                <p>বিএমইটি স্মার্ট কার্ড @if($bmetUpdate && !$bmetUpdate->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        <li class="nav-item {{ ($bmetUpdate && !$bmetUpdate->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link"
                               href="{{ ($bmetUpdate && $bmetUpdate->status) ? route('user.bmet-update.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-sync-alt" aria-hidden="true"></i>
                                <p>বিএমইটি আপডেট @if($bmetUpdate && !$bmetUpdate->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $bmet = getServiceMenu('bmet'); @endphp
                        <li class="nav-item {{ ($bmet && !$bmet->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('bmet.*') ? 'active' : '' }}"
                               href="{{ ($bmet && $bmet->status) ? route('bmet.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-file-alt" aria-hidden="true"></i>
                                <p>বিএমইটি (BMET) @if($bmet && !$bmet->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $bmetEc = getServiceMenu('bmet-ec'); @endphp
                        <li class="nav-item {{ ($bmetEc && !$bmetEc->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.bmet-ec.*') ? 'active' : '' }}"
                               href="{{ ($bmetEc && $bmetEc->status) ? route('user.bmet-ec.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-globe" aria-hidden="true"></i>
                                <p>বিএমইটি ইসি @if($bmetEc && !$bmetEc->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $soudi = getServiceMenu('soudi-sonod'); @endphp
                        <li class="nav-item {{ ($soudi && !$soudi->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.soudi-sonod.*') ? 'active' : '' }}"
                               href="{{ ($soudi && $soudi->status) ? route('user.soudi-sonod.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-certificate" aria-hidden="true"></i>
                                <p>সৌদি সনদ @if($soudi && !$soudi->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Certificates & Licenses --}}
                <li class="nav-item {{ request()->routeIs(['user.driving-licenses.*','user.pdo.*','user.trade.*','user.dncc-trade.*','user.dscc-trade.*','user.certificate.*','user.police.*','user.surokkha.*','user.nagorik-sonod.*','user.uttoradhikarsonod.*','user.golden-card.*']) ? 'menu-open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="nav-icon fas fa-award" aria-hidden="true"></i>
                        <p>
                            সনদপত্র ও লাইসেন্স
                            <i class="right fas fa-angle-left" aria-hidden="true"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @php $driving = getServiceMenu('driving-licenses'); @endphp
                        <li class="nav-item {{ ($driving && !$driving->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.driving-licenses.*') ? 'active' : '' }}"
                               href="{{ ($driving && $driving->status) ? route('user.driving-licenses.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-car" aria-hidden="true"></i>
                                <p>ড্রাইভিং লাইসেন্স @if($driving && !$driving->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $pdo = getServiceMenu('pdo'); @endphp
                        <li class="nav-item {{ ($pdo && !$pdo->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.pdo.*') ? 'active' : '' }}"
                               href="{{ ($pdo && $pdo->status) ? route('user.pdo.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-certificate" aria-hidden="true"></i>
                                <p>ট্রেনিং সার্টিফিকেট @if($pdo && !$pdo->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $trade = getServiceMenu('trade'); @endphp
                        <li class="nav-item {{ ($trade && !$trade->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.trade.*') ? 'active' : '' }}"
                               href="{{ ($trade && $trade->status) ? route('user.trade.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-briefcase" aria-hidden="true"></i>
                                <p>ট্রেড লাইসেন্স @if($trade && !$trade->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.dncc-trade.*') ? 'active' : '' }}"
                               href="{{ route('user.dncc-trade.index') }}">
                                <i class="nav-icon fas fa-building" aria-hidden="true"></i>
                                <p>DNCC ট্রেড লাইসেন্স</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.dscc-trade.*') ? 'active' : '' }}"
                               href="{{ route('user.dscc-trade.index') }}">
                                <i class="nav-icon fas fa-building" aria-hidden="true"></i>
                                <p>DSCC ট্রেড লাইসেন্স</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.certificate.*') ? 'active' : '' }}"
                               href="{{ route('user.certificate.index') }}">
                                <i class="nav-icon fas fa-file-contract" aria-hidden="true"></i>
                                <p>সকল প্রত্যয়ন সনদ</p>
                            </a>
                        </li>
                        @php $police = getServiceMenu('police'); @endphp
                        <li class="nav-item {{ ($police && !$police->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.police.*') ? 'active' : '' }}"
                               href="{{ ($police && $police->status) ? route('user.police.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-shield-alt" aria-hidden="true"></i>
                                <p>পুলিশ ভেরিফিকেশন @if($police && !$police->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $surokkha = getServiceMenu('surokkha'); @endphp
                        <li class="nav-item {{ ($surokkha && !$surokkha->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.surokkha.*') ? 'active' : '' }}"
                               href="{{ ($surokkha && $surokkha->status) ? route('user.surokkha.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-medal" aria-hidden="true"></i>
                                <p>ভ্যাকসিন এন্ট্রি @if($surokkha && !$surokkha->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $nagorik = getServiceMenu('nagorik-sonod'); @endphp
                        <li class="nav-item {{ ($nagorik && !$nagorik->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.nagorik-sonod.*') ? 'active' : '' }}"
                               href="{{ ($nagorik && $nagorik->status) ? route('user.nagorik-sonod.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-file-alt" aria-hidden="true"></i>
                                <p>নাগরিক সনদ @if($nagorik && !$nagorik->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        @php $uttor = getServiceMenu('uttoradhikarsonod'); @endphp
                        <li class="nav-item {{ ($uttor && !$uttor->status) ? 'service-disabled' : '' }}">
                            <a class="nav-link {{ request()->routeIs('user.uttoradhikarsonod.*') ? 'active' : '' }}"
                               href="{{ ($uttor && $uttor->status) ? route('user.uttoradhikarsonod.index') : 'javascript:void(0)' }}">
                                <i class="nav-icon fas fa-file" aria-hidden="true"></i>
                                <p>উত্তরাধিকার সনদ @if($uttor && !$uttor->status)<span class="badge-off">বন্ধ</span>@endif</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs("user.golden-card.*") ? "active" : "" }}" href="{{ route("user.golden-card.index") }}">
                                <i class="nav-icon fas fa-id-card-alt" aria-hidden="true"></i>
                                <p>গোল্ডেন কার্ড</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.electricity_bill.index') ? 'active' : '' }}"
                               href="{{ route('user.electricity_bill.index') }}">
                                <i class="nav-icon fas fa-bolt" aria-hidden="true"></i>
                                <p>বিদ্যুৎ বিল মেক</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.dcr.create') ? 'active' : '' }}"
                               href="{{ route('user.dcr.create') }}">
                                <i class="nav-icon fas fa-file-alt" aria-hidden="true"></i>
                                <p>অনলাইন ডিসিআর মেক</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ═══════════════════════════════════ --}}
                {{-- OTHER --}}
                {{-- ═══════════════════════════════════ --}}
                <li class="nav-header">অন্যান্য</li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.logout') }}">
                        <i class="nav-icon fas fa-sign-out-alt" aria-hidden="true"></i>
                        <p>লগ আউট</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Treeview Toggle
    const treeviewlinks = document.querySelectorAll('.modern-sidebar .nav-sidebar .nav-item > .nav-link');
    treeviewlinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            const parentListItem = this.parentElement;
            const hasTreeview = parentListItem.querySelector('.nav-treeview');

            if (hasTreeview) {
                e.preventDefault();
                const siblings = parentListItem.parentElement.querySelectorAll(':scope > .nav-item.menu-open');
                siblings.forEach(function (sibling) {
                    if (sibling !== parentListItem) {
                        sibling.classList.remove('menu-open');
                    }
                });
                parentListItem.classList.toggle('menu-open');
            }
        });
    });

    // Mobile Toggle
    const body = document.querySelector('body');
    const toggleButtons = document.querySelectorAll('#sidebarToggle, [data-widget="pushmenu"]');

    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            body.classList.toggle('sidebar-open');
        });
    });

    // Close on outside click
    document.addEventListener('click', function(e) {
        if (body.classList.contains('sidebar-open')) {
            const sidebar = document.querySelector('.modern-sidebar');
            const isClickInsideSidebar = sidebar.contains(e.target);
            let isToggleClick = false;
            toggleButtons.forEach(btn => { if(btn.contains(e.target)) isToggleClick = true; });

            if (!isClickInsideSidebar && !isToggleClick) {
                body.classList.remove('sidebar-open');
            }
        }
    });
});
</script>