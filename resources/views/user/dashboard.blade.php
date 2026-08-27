@extends('user.layouts.app')
@section('title') @lang('Dashboard') @endsection

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endpush

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Baloo+Da+2:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Baloo+Da+2:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap');
*{margin:0;padding:0;box-sizing:border-box;}
body{background:#EEF1F7;font-family:'Noto Sans Bengali','Hind Siliguri','SolaimanLipi',sans-serif;padding:20px;color:#0D1230;}
.mono{font-family:'JetBrains Mono','Noto Sans Bengali',monospace;}
.headline{font-family:'Baloo Da 2','Noto Sans Bengali',sans-serif;}
.banner{
    background:linear-gradient(120deg,#0A0F2C 0%,#182D8A 55%,#2A46C9 100%);
    border-radius:26px;padding:28px 32px;
    display:flex;align-items:center;justify-content:space-between;
    flex-wrap:wrap;gap:24px;
    box-shadow:0 22px 46px -22px rgba(13,18,48,0.32);margin-bottom:24px;
}
.banner-copy{max-width:600px;}
.banner-eyebrow{
    display:inline-flex;align-items:center;gap:7px;
    font-size:11.5px;font-weight:700;letter-spacing:.6px;
    color:#C6D1FF;text-transform:uppercase;margin-bottom:8px;
}
.banner h1{font-family:'Baloo Da 2','Noto Sans Bengali',sans-serif;font-size:26px;font-weight:700;color:#fff;margin-bottom:6px;}
.banner p{color:rgba(233,238,252,0.82);font-size:13.5px;line-height:1.6;margin-bottom:14px;}
.banner-meta{display:flex;gap:18px;flex-wrap:wrap;}
.banner-meta span{
    color:rgba(233,238,252,0.88);font-size:12.5px;
    display:flex;align-items:center;gap:6px;
    background:rgba(255,255,255,.07);padding:5px 11px;
    border-radius:20px;border:1px solid rgba(255,255,255,.09);
}
.mobile-avatar{display:flex;align-items:center;gap:10px;margin-bottom:10px;}
.mobile-avatar-photo{
    width:42px;height:42px;border-radius:50%;background:#EAEEFC;
    display:flex;align-items:center;justify-content:center;
    font-weight:700;font-size:18px;color:#2A46C9;
    border:2px solid #fff;flex-shrink:0;
}
.mobile-avatar-name{color:#fff;font-size:13.5px;font-weight:700;}
.mobile-tier-pill.vip{
    background:linear-gradient(135deg,#C79A4B,#A8823C);color:#fff;
    font-size:9px;font-weight:800;padding:2px 8px;border-radius:20px;letter-spacing:.3px;display:inline-block;
}
.id-badge{flex-shrink:0;}
.id-card{
    background:linear-gradient(160deg,#fff,#EEF2FF);border-radius:18px;
    padding:15px 15px 13px;box-shadow:0 20px 34px -14px rgba(0,0,0,0.5);
    width:190px;transform:rotate(2deg);
}
.id-card-top{display:flex;align-items:center;gap:7px;margin-bottom:10px;}
.id-chip{width:21px;height:16px;border-radius:3px;background:linear-gradient(135deg,#C79A4B,#A8823C);flex-shrink:0;}
.id-card-brand{font-size:9px;font-weight:700;letter-spacing:1px;color:#757CA0;text-transform:uppercase;}
.id-tier.vip{
    margin-left:auto;font-size:8.5px;font-weight:800;padding:3px 9px;border-radius:20px;
    background:linear-gradient(135deg,#C79A4B,#A8823C);color:#fff;white-space:nowrap;
}
.id-photo-wrap{
    width:100%;aspect-ratio:1/1;border-radius:13px;overflow:hidden;background:#EAEEFC;
    display:flex;align-items:center;justify-content:center;
    border:2px solid #fff;box-shadow:0 4px 14px -6px rgba(13,18,48,0.35);
    font-family:'Baloo Da 2','Noto Sans Bengali',sans-serif;font-size:34px;font-weight:700;color:#2A46C9;
}
.id-name{margin-top:9px;font-size:12.5px;font-weight:700;color:#0D1230;text-align:center;}
.id-number{
    font-family:'JetBrains Mono',monospace;font-size:10px;letter-spacing:1px;
    color:#757CA0;text-align:center;border-top:1px dashed #E2E6F2;padding-top:6px;margin-top:5px;
}
.id-verified-pill{
    display:inline-flex;align-items:center;gap:4px;background:#16A76B;color:#fff;
    font-size:9.5px;font-weight:700;padding:4px 8px;border-radius:20px;
    margin-top:6px;box-shadow:0 2px 6px -1px rgba(22,167,107,0.5);
}
.quick-actions{display:flex;gap:10px;overflow-x:auto;padding-bottom:4px;margin-bottom:24px;flex-wrap:wrap;}
.qa-btn{
    display:inline-flex;align-items:center;gap:8px;padding:10px 18px;
    background:#fff;border:1px solid #E2E6F2;border-radius:30px;
    font-size:12.5px;font-weight:700;color:#3B4166;
    text-decoration:none;box-shadow:0 2px 10px -5px rgba(13,18,48,0.10);
    transition:0.2s;white-space:nowrap;
}
.qa-btn.gold{background:linear-gradient(135deg,#C79A4B,#A8823C);color:#fff;border-color:transparent;}
.qa-btn.primary{background:linear-gradient(135deg,#2A46C9,#182D8A);color:#fff;border-color:transparent;}
.qa-btn:hover{transform:translateY(-2px);box-shadow:0 8px 18px -10px rgba(13,18,48,0.2);text-decoration:none;color:#3B4166;}
.qa-btn.gold:hover,.qa-btn.primary:hover{color:#fff;}
.notice-board{
    background:#fff;border:1px solid #E2E6F2;border-radius:20px;
    margin-bottom:28px;overflow:hidden;box-shadow:0 2px 10px -5px rgba(13,18,48,0.10);
}
.notice-head{
    display:flex;align-items:center;justify-content:space-between;
    padding:16px 18px;background:#F5F7FC;border-bottom:1px solid #E2E6F2;flex-wrap:wrap;gap:10px;
}
.notice-head-title{display:flex;align-items:center;gap:11px;}
.notice-head-ico{
    width:37px;height:37px;border-radius:11px;background:#EAEEFC;
    display:flex;align-items:center;justify-content:center;
}
.notice-head-ico i{color:#2A46C9;font-size:16px;}
.notice-head-title h3{font-size:15px;font-weight:700;color:#0D1230;}
.notice-view-all{
    font-size:11.5px;font-weight:700;color:#fff;background:#0D1230;
    padding:6px 13px;border-radius:20px;text-decoration:none;
    display:inline-flex;align-items:center;gap:5px;
}
.notice-view-all:hover{background:#182D8A;color:#fff;text-decoration:none;}
.notice-list{padding:12px;display:flex;flex-direction:column;gap:10px;}
.notice-item{
    display:flex;gap:13px;padding:14px 15px;
    background:#F5F7FC;border:1px solid #E2E6F2;border-radius:15px;
}
.notice-dot{
    width:38px;height:38px;border-radius:11px;background:#D9962E;
    display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px;flex-shrink:0;
}
.notice-dot i{color:#fff;}
.notice-body-text{flex:1;min-width:0;}
.notice-title-row{display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:wrap;}
.notice-title-row strong{font-size:13.5px;color:#0D1230;}
.notice-date{font-size:10.5px;color:#757CA0;font-family:'JetBrains Mono',monospace;}
.notice-desc{font-size:12.5px;color:#3B4166;margin-top:6px;line-height:1.6;}
.notice-empty{text-align:center;padding:32px 10px;color:#757CA0;font-size:13px;}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;}
.stat-card{
    background:#fff;border:1px solid #E2E6F2;border-radius:16px;
    padding:16px 18px;position:relative;overflow:hidden;
}
.stat-card::before{
    content:"";position:absolute;top:0;left:0;width:100%;height:3px;
    background:linear-gradient(115deg,#22D3EE,#8B5CF6 48%,#F472B6 90%);
}
.stat-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:9px;}
.stat-label{font-size:10.5px;color:#757CA0;font-weight:600;letter-spacing:.3px;}
.stat-label i{margin-right:4px;}
.stat-icon{width:32px;height:32px;background:#EAEEFC;border-radius:9px;display:flex;align-items:center;justify-content:center;color:#2A46C9;}
.stat-value{font-family:'JetBrains Mono',monospace;font-size:22px;font-weight:700;color:#0D1230;}
.chart-card{background:#fff;border:1px solid #E2E6F2;border-radius:16px;padding:18px 20px;margin-bottom:28px;}
.chart-card-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;}
.chart-card-head h4{font-size:13px;font-weight:700;color:#0D1230;display:flex;align-items:center;gap:7px;}
.chart-card-head h4 i{color:#2A46C9;}
.chart-empty{text-align:center;color:#757CA0;font-size:12px;padding:18px 0;}
.chart-empty i{font-size:22px;opacity:.35;display:block;margin-bottom:6px;}
.sec-head{display:flex;align-items:center;justify-content:space-between;margin:6px 0 14px;flex-wrap:wrap;gap:10px;}
.sec-title{display:flex;align-items:center;gap:10px;}
.sec-title i.sec-icon{font-size:19px;color:#D9962E;}
.sec-title h3{font-size:16.5px;font-weight:700;color:#0D1230;}
.live-pill{
    font-size:11.5px;color:#182D8A;background:#EAEEFC;
    padding:5px 13px;border-radius:20px;display:inline-flex;align-items:center;gap:6px;font-weight:600;
}
.live-pill i{font-size:7px;color:#2A46C9;animation:pulseDot 1.6s infinite;}
@keyframes pulseDot{0%,100%{opacity:1;}50%{opacity:.3;}}
.service-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:14px;margin-bottom:30px;}
.service-card{
    background:#fff;border:1px solid #E2E6F2;border-radius:16px;
    padding:18px 12px;text-align:center;cursor:pointer;transition:0.2s;
    display:block;text-decoration:none;color:inherit;
}
.service-card:hover{transform:translateY(-3px);box-shadow:0 8px 18px -10px rgba(13,18,48,0.15);border-color:#2A46C9;text-decoration:none;color:inherit;}
.service-icon{
    width:52px;height:52px;background:#EAEEFC;border-radius:15px;
    display:flex;align-items:center;justify-content:center;margin:0 auto 11px;
}
.service-icon i{font-size:22px;color:#2A46C9;}
.service-card.gold .service-icon{background:#FCF1DE;}
.service-card.gold .service-icon i{color:#D9962E;}
.service-title{font-size:12.5px;font-weight:600;color:#3B4166;line-height:1.4;}
.table-wrap{background:#fff;border-radius:16px;border:1px solid #E2E6F2;overflow-x:auto;margin-bottom:28px;}
.data-table{width:100%;border-collapse:collapse;min-width:680px;}
.data-table th{
    background:#F5F7FC;padding:13px 18px;text-align:left;
    font-size:10.5px;font-weight:700;color:#757CA0;
    text-transform:uppercase;letter-spacing:.6px;border-bottom:1px solid #E2E6F2;
}
.data-table td{padding:13px 18px;font-size:13px;border-bottom:1px solid #EEF1F7;color:#3B4166;}
.data-table tr:last-child td{border-bottom:none;}
.badge{
    display:inline-flex;align-items:center;gap:6px;
    padding:5px 12px;border-radius:30px;font-size:10.5px;font-weight:700;
}
.badge-success{background:#E3F7EE;color:#16A76B;}
.badge-warning{background:#FCF1DE;color:#D9962E;}
.badge-info{background:#EAEEFC;color:#2A46C9;}
.badge-danger{background:#FCEAEE;color:#DE3E52;}
.empty-state{text-align:center;padding:32px 10px;color:#C4CAD9;}
.empty-state i{font-size:28px;opacity:.4;display:block;margin-bottom:8px;}
.empty-state span{color:#757CA0;font-size:13px;}
@media(max-width:768px){
    .banner{padding:22px 20px;flex-direction:column;align-items:stretch;}
    .id-badge{align-self:center;}
    .stats-grid{grid-template-columns:1fr 1fr;}
    .service-grid{grid-template-columns:repeat(2,1fr);}
    .data-table{min-width:0;}
    .data-table thead{display:none;}
    .data-table tbody tr{display:block;background:#fff;border:1px solid #E2E6F2;border-radius:15px;padding:10px 14px;margin-bottom:12px;}
    .data-table td{display:flex;align-items:center;justify-content:space-between;padding:8px 2px;border-bottom:1px dashed #E2E6F2;font-size:12.5px;}
    .data-table td:last-child{border-bottom:none;}
    .data-table td::before{content:attr(data-label);font-weight:700;color:#757CA0;font-size:11px;}
}
@media(max-width:480px){
    .stats-grid{grid-template-columns:1fr 1fr;gap:10px;}
    .stat-card{padding:14px;}
    .stat-value{font-size:18px;}
    .quick-actions{flex-wrap:nowrap;}
    .qa-btn{font-size:11px;padding:8px 14px;}
    .banner h1{font-size:20px;}
}
</style>

<div class="banner">
    <div class="banner-copy">
        <div class="mobile-avatar">
            <div class="mobile-avatar-photo">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <div>
                <div class="mobile-avatar-name">{{ Auth::user()->name }}</div>
                <span class="mobile-tier-pill vip"><i class="fas fa-crown"></i> সদস্য</span>
            </div>
        </div>
        <span class="banner-eyebrow"><i class="fas fa-shield-alt"></i> ভেরিফায়েড সার্ভিস পোর্টাল</span>
        <h1 class="headline">স্বাগতম, {{ Auth::user()->name }}</h1>
        <p>আপনার ডিজিটাল সার্ভিস সেন্টার — দ্রুত, নিরাপদ ও নির্ভরযোগ্য</p>
        <div class="banner-meta">
            <span><i class="far fa-calendar-alt"></i> {{ now()->format('l, d F Y') }}</span>
            <span><i class="far fa-clock"></i> <span class="mono" id="liveTime">{{ now()->format('h:i:s A') }}</span></span>
        </div>
    </div>
    <div class="id-badge">
        <div class="id-card">
            <div class="id-card-top">
                <div class="id-chip"></div>
                <span class="id-card-brand">{{ $basic->site_title ?? 'Portal' }} ID</span>
                <span class="id-tier vip"><i class="fas fa-crown"></i> সদস্য</span>
            </div>
            <div class="id-photo-wrap">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <div class="id-name">{{ Auth::user()->name }}</div>
            <div class="id-number">ID: {{ Auth::user()->id }}</div>
            <div style="text-align:center;margin-top:4px;">
                <span class="id-verified-pill"><i class="fas fa-check"></i> Verified</span>
            </div>
        </div>
    </div>
</div>

<div class="quick-actions">
    <a href="{{ route('user.recharge') }}" class="qa-btn gold"><i class="fas fa-plus-circle"></i> রিচার্জ করুন</a>
    <a href="{{ route('user.applications') }}" class="qa-btn primary"><i class="fas fa-file-alt"></i> আমার অর্ডার</a>
    <a href="{{ route('user.server-copy') }}" class="qa-btn"><i class="fas fa-server"></i> সার্ভার কপি</a>
    <a href="{{ route('user.transactions') }}" class="qa-btn"><i class="fas fa-history"></i> লেনদেন</a>
</div>

@php $notices = \App\Models\Notification::where('user_id', Auth::id())->latest()->limit(5)->get(); @endphp
<div class="notice-board">
    <div class="notice-head">
        <div class="notice-head-title">
            <div class="notice-head-ico"><i class="fas fa-bullhorn"></i></div>
            <h3>নোটিশ বোর্ড</h3>
        </div>
        <a href="{{ route('user.notifications') }}" class="notice-view-all">সব দেখুন <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="notice-list">
        @forelse($notices as $notice)
        <div class="notice-item">
            <div class="notice-dot"><i class="fas fa-bullhorn"></i></div>
            <div class="notice-body-text">
                <div class="notice-title-row">
                    <strong>নোটিশ</strong>
                    <span class="notice-date mono">{{ $notice->created_at->format('d M Y') }}</span>
                </div>
                <p class="notice-desc">{{ Str::limit($notice->msg ?? '', 120) }}</p>
            </div>
        </div>
        @empty
        <div class="notice-empty"><i class="fas fa-inbox"></i> কোনো নোটিশ নেই</div>
        @endforelse
    </div>
</div>

@php
    $totalOrders = \App\Models\Application::where('user_id', Auth::id())->count();
    $successOrders = \App\Models\Application::where('user_id', Auth::id())->where('status', '!=', '0')->count();
    $pendingOrders = \App\Models\Application::where('user_id', Auth::id())->where('status', '0')->count();
@endphp
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label"><i class="fas fa-shopping-cart"></i> মোট অর্ডার</span>
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        </div>
        <div class="stat-value mono">{{ $totalOrders }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label"><i class="fas fa-check-circle"></i> সফল অর্ডার</span>
            <div class="stat-icon"><i class="fas fa-trophy"></i></div>
        </div>
        <div class="stat-value mono">{{ $successOrders }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label"><i class="fas fa-clock"></i> অপেক্ষমাণ</span>
            <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
        </div>
        <div class="stat-value mono">{{ $pendingOrders }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label"><i class="fas fa-coins"></i> মোট খরচ</span>
            <div class="stat-icon"><i class="fas fa-wallet"></i></div>
        </div>
        <div class="stat-value mono">৳ ০</div>
    </div>
</div>

<div class="chart-card">
    <div class="chart-card-head">
        <h4><i class="fas fa-chart-simple"></i> সাপ্তাহিক ইউসেজ ট্রেন্ড</h4>
        <span class="mono" style="font-size:11px;color:#757CA0;"></span>
    </div>
    <div class="chart-empty">
        <i class="fas fa-chart-column"></i>
        এই সপ্তাহে এখনো কোনো অর্ডার নেই
    </div>
</div>

<div class="sec-head">
    <div class="sec-title"><i class="fas fa-grip sec-icon"></i><h3>সার্ভিসসমূহ</h3></div>
    <span class="live-pill"><i class="fas fa-circle"></i> ২৪/৭ সক্রিয়</span>
</div>

<div class="service-grid">
    <a href="{{ route('user.server-copy') }}" class="service-card gold">
        <div class="service-icon"><i class="fas fa-server"></i></div>
        <div class="service-title">সার্ভার কপি</div>
    </a>
    <a href="{{ route('user.tin.index') }}" class="service-card">
        <div class="service-icon"><i class="fas fa-file-invoice-dollar"></i></div>
        <div class="service-title">ই-টিন ডাউনলোড</div>
    </a>
    <a href="{{ route('user.nid-card.create', ['type' => 'nid']) }}" class="service-card">
        <div class="service-icon"><i class="fas fa-id-card"></i></div>
        <div class="service-title">এন আইডি মেক</div>
    </a>
    <a href="{{ route('user.nid-card.create', ['type' => 'sign-to-server']) }}" class="service-card">
        <div class="service-icon"><i class="fas fa-pen-nib"></i></div>
        <div class="service-title">সাইন টু সার্ভার</div>
    </a>
    <a href="{{ route('user.nibondon.index') }}" class="service-card">
        <div class="service-icon"><i class="fas fa-baby-carriage"></i></div>
        <div class="service-title">জন্ম নিবন্ধন</div>
    </a>
    <a href="{{ route('user.smartcard.index') }}" class="service-card">
        <div class="service-icon"><i class="fas fa-id-badge"></i></div>
        <div class="service-title">স্মার্ট কার্ড</div>
    </a>
    <a href="{{ route('user.driving-licenses.index') }}" class="service-card">
        <div class="service-icon"><i class="fas fa-car"></i></div>
        <div class="service-title">ড্রাইভিং লাইসেন্স</div>
    </a>
    <a href="{{ route('user.passport.order.index') }}" class="service-card">
        <div class="service-icon"><i class="fas fa-passport"></i></div>
        <div class="service-title">পাসপোর্ট</div>
    </a>
    <a href="{{ route('user.visa-applications.index') }}" class="service-card">
        <div class="service-icon"><i class="fas fa-plane-departure"></i></div>
        <div class="service-title">ভিসা আবেদন</div>
    </a>
    <a href="{{ route('user.land.index') }}" class="service-card">
        <div class="service-icon"><i class="fas fa-map-marked-alt"></i></div>
        <div class="service-title">ভূমি সেবা</div>
    </a>
    <a href="{{ route('user.ssc_certificate.index') }}" class="service-card">
        <div class="service-icon"><i class="fas fa-graduation-cap"></i></div>
        <div class="service-title">শিক্ষা সনদ</div>
    </a>
    <a href="{{ route('user.bmet-update.index') }}" class="service-card">
        <div class="service-icon"><i class="fas fa-briefcase"></i></div>
        <div class="service-title">বিএমইটি</div>
    </a>
</div>

<div class="sec-head">
    <div class="sec-title"><i class="fas fa-history sec-icon"></i><h3>সাম্প্রতিক অর্ডার</h3></div>
</div>

@php $recentOrders = \App\Models\Application::where('user_id', Auth::id())->latest()->limit(10)->get(); @endphp
<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr><th>সার্ভিস</th><th>তথ্য</th><th>স্ট্যাটাস</th><th>সময়</th></tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
            <tr>
                <td data-label="সার্ভিস"><span style="font-weight:600;color:#0D1230;">{{ $order->type ?? 'সার্ভিস' }}</span></td>
                <td data-label="তথ্য">{{ $order->nid ?? $order->phone_number ?? '—' }}</td>
                <td data-label="স্ট্যাটাস">
                    @if($order->status == '0')
                        <span class="badge badge-warning"><i class="fas fa-clock"></i> অপেক্ষমাণ</span>
                    @elseif($order->status == 'success')
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> সফল</span>
                    @elseif(in_array($order->status, ['processing', '1']))
                        <span class="badge badge-info"><i class="fas fa-spinner"></i> প্রসেসিং</span>
                    @elseif(in_array($order->status, ['cancel', 'cancelled']))
                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i> বাতিল</span>
                    @else
                        <span class="badge badge-info">{{ $order->status }}</span>
                    @endif
                </td>
                <td data-label="সময়" style="color:#757CA0;font-size:11.5px;white-space:nowrap;">{{ $order->created_at->format('d M, h:i A') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:32px 10px;color:#C4CAD9;"><i class="fas fa-inbox" style="font-size:28px;opacity:.4;display:block;margin-bottom:8px;"></i><span style="color:#757CA0;font-size:13px;">কোনো অর্ডার নেই</span></td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function updateLiveTime(){
    var n=new Date(),h=n.getHours(),m=n.getMinutes(),s=n.getSeconds();
    var a=h>=12?"PM":"AM";h=h%12||12;
    var e=document.getElementById("liveTime");
    if(e) e.textContent=("0"+h).slice(-2)+":"+("0"+m).slice(-2)+":"+("0"+s).slice(-2)+" "+a;
}
setInterval(updateLiveTime,1000);
updateLiveTime();
</script>
@endsection