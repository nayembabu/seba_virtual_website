<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <title>@lang($basic->site_title) | @yield('title')</title>
    @stack('style-lib')
    <link href="{{asset('assets/admin/css/bootstrap4-toggle.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/all.min.css')}}"/>
    <link href="{{asset('assets/admin/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/style.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Baloo+Da+2:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('assets/favicon.png') }}" type="image/png">

    <style>
    :root {
        --primary: #2F57C7;
        --primary-hover: #2349B8;
        --primary-light: #4F7EFF;
        --bg: #F5F9FF;
        --card: #FFFFFF;
        --text: #1F2937;
        --text-light: #6B7280;
        --border: #E5E7EB;
        --hover: #EEF4FF;
        --success: #22C55E;
        --warning: #F59E0B;
        --danger: #EF4444;
    }

    body {
        font-family: 'SolaimanLipi', 'NotoSansBengali', sans-serif;
        padding-top: 12px;
        background: var(--bg);
    }

    .page-wrapper { padding-top: 0 !important; margin-top: 0 !important; }
.page-wrapper .page-breadcrumb {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 12px;
        margin: 0 16px;
        padding: 8px 18px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.04);
    }

    .page-wrapper .container-fluid {
        padding-top: 0 !important;
    }

    .card {
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }

    .table thead th {
        background: var(--hover);
    }

    .btn-primary {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
    }
    .btn-primary:hover {
        background: var(--primary-hover) !important;
        border-color: var(--primary-hover) !important;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
    }
    .pagination .page-link {
        color: var(--primary);
    }
    a { color: var(--primary); }
    a:hover { color: var(--primary-hover); }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid var(--theme-border);
        border-radius: 8px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--theme-primary) !important;
        color: #fff !important;
        border-color: var(--theme-primary) !important;
    }

    .bn-layout, .bn-layout a, .bn-layout button, .bn-layout table{
        font-family: 'SolaimanLipi' !important;
    }
        @media only screen and (max-width: 767px) {
            .np{
                display:none;
            }
            .sp{
                display:block! important;
                position: absolute;
                line-height: 21px;
                font-size: 14px;
                left: 40%;
                top: 75px;
            }
        }
        
       @media only screen and (min-width: 992px) {
           .m-profile{
               display:none;
           }
       }
        .sidebar-nav #sidebarnav .sidebar-item .sidebar-link .hide-menu{
                overflow:initial;
            }

    .whatsapp-fixed-button {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 1000;
        background: #25D366;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 18px rgba(37, 211, 102, 0.4);
        transition: all 0.3s ease;
    }
    .whatsapp-fixed-button:hover {
        transform: scale(1.15);
        box-shadow: 0 8px 24px rgba(37, 211, 102, 0.6);
        background: #1ebe5b;
    }

    /* Global form and text size adjustments */
    body, p, label, .form-control, .form-group, .input-group-text, .btn, .card-title, .card-header, .page-title, .breadcrumb-item {
        font-size: 0.875rem; /* Smaller base font size */
    }

    h1, h2, h3, h4, h5, h6 {
        font-size: 1.125rem; /* Slightly larger than base, but smaller than default H tags */
        margin-bottom: 0.5rem;
    }


    h4, h5, h6 {
        font-size: 0.9rem; /* Slightly larger than base, but smaller than default H tags */
        margin-bottom: 0.5rem;
    }

    .form-control {
        height: calc(1.9rem + 2px); /* Smaller height for form fields */
        padding: 0.375rem 0.75rem; /* Adjust padding */
    }

    .form-group {
        margin-bottom: 0.75rem; /* Reduced space between form groups */
    }

    /* Adjustments for a more compact "tablar dashboard design" */
    .page-wrapper {
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .page-wrapper .container-fluid {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .card {
        margin-bottom: 15px; /* Smaller margin between cards */
    }

    .table th, .table td {
        padding: 0.5rem; /* Compact table cells */
    }

    /* Specific adjustments for input groups if present */
    .input-group-text {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    </style>

    @stack("style")
    @stack("css")
</head>
<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

    @include('user.layouts.header')
    @include('user.layouts.sidebar')

    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">@yield('title')</h4>

                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item text-muted active" aria-current="page">@lang('Dashboard')</li>
                                <li class="breadcrumb-item text-muted" aria-current="page">@yield('title')</li>
                            </ol>
                        </nav>
                    </div>

                </div>

            </div>
        </div>
        
        @yield("content")
    </div>
        @php
            $whatsapp = App\Models\Setting::where("name", "whatsapp_number")->first();
            $whatsappNumber = $whatsapp ? $whatsapp->value : "";
        @endphp

        @if($whatsappNumber)
            <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="whatsapp-fixed-button" title="Chat on WhatsApp">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width:28px; height:28px; fill:#ffffff;">
                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                </svg>
            </a>
        @endif


    <footer class="footer text-center text-muted">
        {{trans('Copyrights')}} © {{date('Y')}} @lang('All Rights Reserved By') @lang($basic->site_title)
    </footer>
</div>


<!-- Core JS Files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>


<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<!-- Responsive -->
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<!-- Additional Plugins -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/admin/js/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/global/js/notiflix-aio-2.7.0.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/sidebarmenu.js')}}"></script>
<script src="{{ asset('assets/admin/js/select2.min.js')}}"></script>



<!-- Custom Scripts -->
<script src="{{ asset('assets/admin/js/app-style-switcher.js') }}"></script>
<script src="{{ asset('assets/admin/js/admin-mart.js')}}"></script>
<script src="{{ asset('assets/admin/js/custom.js')}}"></script>

<!-- Additional Libraries -->
@stack('js-lib')
@include('user.layouts.notification')
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>

<!-- Stack Additional Scripts -->
@stack('js')
@stack('extra-script')

<script>
$(document).ready(function() {
    // Initialize Bootstrap tooltips
    // $('[data-toggle="tooltip"]').tooltip();
    $('table.table').each(function() { if (!$(this).hasClass('datatable') && !$(this).hasClass('no-datatable')) { $(this).addClass('datatable'); } });
    
    // Initialize Bootstrap popovers
    $('[data-toggle="popover"]').popover();

    $('.datatable').each(function() {
        const $table = $(this);
        const hasHead = $table.find('thead th').length > 0;
        const hasBody = $table.find('tbody tr').length > 0;

        // Skip malformed tables to avoid _DT_CellIndex runtime crash.
        if (!hasHead || !hasBody) {
            return;
        }

        if ($.fn.DataTable.isDataTable(this)) {
            $table.DataTable().destroy();
        }

        try {
            $table.DataTable({
                responsive: true,
                autoWidth: true,
                pageLength: 25,
                order: [[0, 'asc']]
            });
        } catch (e) {
            console.warn('DataTable init skipped for one table:', e);
        }
    });

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert:not(.alert-info)').fadeOut('slow');
        }, 5000);
    });
</script>


</body>
</html>
