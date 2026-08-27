<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ getFile(config('location.logoIcon.path').'favicon.png')}}">
    <title>@lang($basic->site_title) | @yield('title')</title>
    @stack('style-lib')
    <link href="{{asset('assets/admin/css/bootstrap4-toggle.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/all.min.css')}}"/>
    <link href="{{asset('assets/admin/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/style.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet">
    
    <style>
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
    </style>

    @stack('style')
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

    @include('mod.layouts.header')
    @include('mod.layouts.sidebar')

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

        @yield('content')


        <footer class="footer text-center text-muted">
            {{trans('Copyrights')}} © {{date('Y')}} @lang('All Rights Reserved By') @lang($basic->site_title)
        </footer>

    </div>
</div>



<script src="{{asset('assets/global/js/jquery.min.js') }}"></script>
<script src="{{asset('assets/global/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/global/js/bootstrap.min.js') }}"></script>
@stack('js-lib')

<script src="{{ asset('assets/admin/js/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/app-style-switcher.js') }}"></script>
<script src="{{ asset('assets/admin/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/global/js/notiflix-aio-2.7.0.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/sidebarmenu.js')}}"></script>
<script src="{{ asset('assets/admin/js/select2.min.js')}}"></script>
<script src="{{ asset('assets/admin/js/admin-mart.js')}}"></script>
<script src="{{ asset('assets/admin/js/custom.js')}}"></script>
@include('mod.layouts.notification')
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
@stack('js')
@stack('extra-script')


<script src="https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js"></script>
<script>
let tapp = {{ get_pending_app_count() }};
function check_applications(){
    let url = '{{ route('mod.check-applications') }}';
    let csrf = '{{ csrf_token() }}';
    let sound = '{{ url('assets/admin/noti.mp3') }}';
     $.ajax({
        url: url,
        type: "post",
        data: { _token: csrf },
        success: function (data) {
            if ( data > tapp ){
                $.playSound(sound);
            }
            tapp = data;
            $('#tt').html(data);
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      });
}

var intervalId = window.setInterval(function(){
  check_applications();
}, 3000);
</script>
</body>
</html>
