<!DOCTYPE html>
<html lang="bn-BD">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="admin template, angular admin template, bootstrap admin template, modern admin template, modern design admin template, dashboard template, responsive admin template, angular web app, crypto dashboard, bitcoin dashboard">
    <title>সনদ যাচাই</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CRoboto:300,400,500,600,700" media="all">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="/all.min.css" rel="stylesheet" />
    <link href="/themify-icons.css" rel="stylesheet" />
    <link href="/line-awesome.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
    <!-- THEME STYLES-->
    <link href="/app.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/ityped@0.0.10"></script>
    <style>
        body {
            background-color: #eff4ff;
        }
        .box-wrapper {
            flex: 1 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-content {
            max-width: 540px;
            flex-basis: 540px;
            text-align: center;
        }
        .typing {
            position: relative;
        }
        .typing::after {
            content: "|";
            position: absolute;
            right: 0;
            width: 100%;
            color: white;
            background: #1d1f20;
            animation: typing 4s steps(16) forwards, caret 1s infinite;
        }
        @keyframes typing {
            to { width: 0 }
        }
        @keyframes caret {
            50% { color: transparent }
        }
    </style>
</head>

<body>
<div class="page-wrapper">
    <div class="box-wrapper">
        <div class="error-content py-3">
            <h1 class="error-code text-primary font-weight-normal" style="font-size: 50px">সনদ যাচাই</h1>

            <h1 class="error-code text-primary font-weight-normal"><br><span class="ityped"></span></h1>
            <script>
                window.ityped.init(document.querySelector('.ityped'),{
                    strings: ["আপনার নিকট থাকা সনদটি হাতে নিন।", "সনদে দেওয়া ১২/১৭ ডিজিটের নাম্বার নিচের বক্সে লিখুন", "এন্টার বাটনে চাপুন"],
                    loop: true
                })
            </script>
            <div class="mb-5"><a class="btn btn-outline-primary" href="https://upsheba.com.bd"><span class="btn-icon"><i class="material-icons">arrow_back</i>মূল সাইট</span></a></div>
            <form class="input-group-icon input-group-icon-left input-group-lg mb-4" action="{{ route('trade.verify.form') }}" method="POST">
                @csrf
                <span class="input-icon font-16"><i class="fas fa-search"></i></span> <!-- Updated to Font Awesome -->
                <input class="form-control shadow" type="text" maxlength="17" name="track_id" placeholder="সনদ নং">
            </form>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first('track_id') }}
                </div>
            @endif

        </div>
    </div>
</div><!-- BEGIN: Page backdrops-->
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
    <div class="page-preloader">অপেক্ষা করুন</div>
</div><!-- END: Page backdrops-->
<!-- CORE PLUGINS-->
<script src="/jquery.min.js"></script>
<script src="/bootstrap.bundle.min.js"></script>
<!-- CORE SCRIPTS-->
<script src="/app.min.js"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v55bfa2fee65d44688e90c00735ed189a1713218998793" integrity="sha512-FIKRFRxgD20moAo96hkZQy/5QojZDAbyx0mQ17jEGHCJc/vi0G2HXLtofwD7Q3NmivvP9at5EVgbRqOaOQb+Rg==" data-cf-beacon='{"rayId":"87759bc96f2741a4","r":1,"version":"2024.3.0","token":"8e6bfecf7a2c499db2963e9393e02aa2"}' crossorigin="anonymous"></script>
</body>
</html>
