@extends('layouts.app')
@section('title', 'Login')
@section('login', 'active')
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* লেআউটের সমস্ত কনফ্লিক্ট আটকানোর জন্য মাস্টার রুলস */
        html, body, .login-page {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100vw !important;
            min-height: 100vh !important;
            overflow-x: hidden !important; /* সাইডের স্ক্রল চিরতরে লক */
            touch-action: pan-y !important; /* জুম ইন-আউট পুরোপুরি বন্ধ */
            box-sizing: border-box !important;
        }

        * {
            box-sizing: border-box !important;
            font-family: 'Inter', sans-serif;
        }

        .login-page {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            position: relative !important;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #16213e 100%) !important;
            padding: 15px !important;
        }

        /* Animated Background Effects */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
            overflow: hidden;
        }

        .gradient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.25;
            animation: float-orb 20s ease-in-out infinite;
        }

        .orb-1 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            top: -100px;
            left: -100px;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            bottom: -80px;
            right: -80px;
            animation-delay: 10s;
        }

        @keyframes float-orb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, 30px) scale(1.05); }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: particle-float 15s linear infinite;
        }

        @keyframes particle-float {
            0% { transform: translateY(100vh) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) translateX(30px); opacity: 0; }
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 25%; animation-delay: 3s; }
        .particle:nth-child(3) { left: 55%; animation-delay: 6s; }
        .particle:nth-child(4) { left: 75%; animation-delay: 2s; }
        .particle:nth-child(5) { left: 90%; animation-delay: 4s; }

        /* মেইন কন্টেইনার ফিক্স (যাতে কোনো অবস্থাতেই স্ক্রিনের বাইরে না যায়) */
        .login-container {
            position: relative !important;
            z-index: 10 !important;
            width: 100% !important;
            max-width: 430px !important; /* কার্ডের সাইজ কিছুটা কমানো হলো মোবাইলের জন্য */
            margin: 0 auto !important;
        }

        .login-card {
            background: rgba(20, 20, 30, 0.9) !important;
            backdrop-filter: blur(30px) !important;
            -webkit-backdrop-filter: blur(30px) !important;
            border-radius: 20px !important;
            padding: 35px 25px !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6) !important;
            width: 100% !important;
        }

        /* Logo Section */
        .logo-section {
            text-align: center !important;
            margin-bottom: 25px !important;
        }

        .logo-wrapper {
            display: inline-block !important;
            margin-bottom: 12px !important;
        }

        .logo-wrapper img {
            width: 100% !important;
            max-width: 200px !important;
            height: auto !important;
            object-fit: contain !important;
        }

        .login-title {
            font-size: 28px !important;
            font-weight: 800 !important;
            color: white !important;
            margin-bottom: 6px !important;
            letter-spacing: -0.5px !important;
        }

        .login-subtitle {
            font-size: 13px !important;
            color: rgba(255, 255, 255, 0.6) !important;
            font-weight: 400 !important;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 18px !important;
        }

        .input-label {
            display: block !important;
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            margin-bottom: 8px !important;
        }

        .input-wrapper {
            position: relative !important;
        }

        .input-icon {
            position: absolute !important;
            left: 16px !important;
            top: 50 !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: rgba(255, 255, 255, 0.35) !important;
            font-size: 15px !important;
            pointer-events: none !important;
        }

        .form-control {
            width: 100% !important;
            background: rgba(255, 255, 255, 0.04) !important;
            border: 2px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 12px !important;
            color: white !important;
            padding: 14px 15px 14px 44px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: #667eea !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15) !important;
            outline: none !important;
        }

        /* Buttons */
        .btn {
            width: 100% !important;
            padding: 14px 20px !important;
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            border: none !important;
            cursor: pointer !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            margin-bottom: 12px !important;
        }

        .btn-success {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
            color: white !important;
        }

        .btn i {
            margin-right: 8px !important;
        }

        .divider {
            display: flex !important;
            align-items: center !important;
            margin: 18px 0 !important;
        }

        .divider::before, .divider::after {
            content: '' !important;
            flex: 1 !important;
            height: 1px !important;
            background: rgba(255, 255, 255, 0.08) !important;
        }

        .divider span {
            padding: 0 12px !important;
            color: rgba(255, 255, 255, 0.4) !important;
            font-size: 11px !important;
            font-weight: 600 !important;
        }

        .forgot-link {
            text-align: center !important;
            margin-top: 15px !important;
        }

        .forgot-link a {
            color: #667eea !important;
            text-decoration: none !important;
            font-size: 13px !important;
            font-weight: 600 !important;
        }

        /* Captcha Fixes */
        .captcha-container {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            border-radius: 10px !important;
            padding: 12px !important;
            margin-bottom: 18px !important;
        }

        .captcha-display {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            margin-bottom: 10px !important;
            padding: 8px !important;
            background: rgba(0, 0, 0, 0.2) !important;
            border-radius: 6px !important;
        }

        .captcha-number {
            font-size: 20px !important;
            font-weight: bold !important;
            padding: 5px 10px !important;
            background: rgba(255, 255, 255, 0.06) !important;
            border-radius: 4px !important;
            min-width: 40px !important;
            text-align: center !important;
            color: #fff !important;
        }

        .captcha-input-group {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .captcha-refresh {
            background: rgba(255, 255, 255, 0.06) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            padding: 11px 12px !important;
            border-radius: 10px !important;
            cursor: pointer !important;
        }

        /* Alert */
        .alert {
            border-radius: 10px !important;
            padding: 10px 12px !important;
            margin-bottom: 15px !important;
            font-size: 13px !important;
            background: rgba(245, 85, 108, 0.15) !important;
            color: #fc8181 !important;
            border: 1px solid rgba(245, 85, 108, 0.2) !important;
        }

        /* Loading */
        .loading-overlay {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: rgba(0, 0, 0, 0.85) !important;
            backdrop-filter: blur(8px) !important;
            display: none;
            justify-content: center !important;
            align-items: center !important;
            z-index: 9999 !important;
        }

        .loading-overlay.active {
            display: flex !important;
        }

        .spinner {
            width: 45px !important;
            height: 45px !important;
            border: 3px solid rgba(255, 255, 255, 0.1) !important;
            border-top-color: #667eea !important;
            border-radius: 50% !important;
            animation: spin 0.8s linear infinite !important;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* নির্দিষ্ট মোবাইল অপ্টিমাইজেশন */
        @media (max-width: 480px) {
            .login-card {
                padding: 25px 15px !important;
                border-radius: 16px !important;
            }
            .login-title {
                font-size: 24px !important;
            }
            .logo-wrapper img {
                max-width: 170px !important;
            }
            .form-control {
                padding: 12px 12px 12px 40px !important;
                font-size: 13px !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="login-page">
        <div class="bg-animation">
            <div class="gradient-orb orb-1"></div>
            <div class="gradient-orb orb-2"></div>
        </div>

        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <div class="login-container">
            <div class="login-card">
                <form method="post" action="{{ route('login.submit') }}" id="loginForm">
                    @csrf

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert">
                                <i class="fas fa-circle-exclamation"></i>
                                <span style="margin-left: 5px;">{{ $error }}</span>
                            </div>
                        @endforeach
                    @endif

                    <div class="logo-section">
                        <div class="logo-wrapper">
                            <img src="{{ asset('assets/uploads/logo/Screenshot_2025-10-18_021531-removebg-preview.png') }}" alt="Logo">
                        </div>
                        <h2 class="login-title">Welcome Back</h2>
                        <p class="login-subtitle">Sign in to continue to your account</p>
                    </div>

                    <div class="form-group">
                        <label class="input-label">Email Address</label>
                        <div class="input-wrapper">
                            <input class="form-control" type="email" name="username" placeholder="Enter your email" required autocomplete="email">
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="input-label">Password</label>
                        <div class="input-wrapper">
                            <input class="form-control" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                            <i class="fas fa-lock input-icon"></i>
                        </div>
                    </div>

                    <div class="captcha-container">
                        <label class="input-label" style="margin-bottom: 6px; color: rgba(255,255,255,0.7);">
                            <i class="fas fa-shield-alt"></i> Please solve the captcha
                        </label>
                        <div class="captcha-display">
                            <span class="captcha-number">{{ $num1 = rand(1, 9) }}</span>
                            <span style="color: #63b3ed; font-weight: bold;">+</span>
                            <span class="captcha-number">{{ $num2 = rand(1, 9) }}</span>
                            <span style="color: #fff;">=</span>
                            <span class="captcha-number">?</span>
                        </div>
                        <div class="captcha-input-group">
                            <input type="hidden" name="num1" value="{{ $num1 ?? '' }}">
                            <input type="hidden" name="num2" value="{{ $num2 ?? '' }}">
                            <div style="flex-grow: 1;">
                                <input class="form-control" type="number" id="captcha" name="captcha" placeholder="Enter sum" required min="0" max="20" style="padding: 11px 15px !important;">
                            </div>
                            <button type="button" class="captcha-refresh" onclick="refreshCaptcha()">
                                <i class="fas fa-redo"></i>
                            </button>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-arrow-right-to-bracket"></i> Sign In
                    </button>

                    @if (get_settings()->register_option == '1')
                        <div class="divider">
                            <span>OR</span>
                        </div>
                        <a class="btn btn-success" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Create New Account
                        </a>
                    @endif

                    <div class="forgot-link">
                        <a href="{{ route('password.request') }}">
                            <i class="fas fa-key"></i> Forgot your password?
                        </a>
                    </div>

                    <div style="margin-top: 20px; text-align: center; background: rgba(37, 211, 102, 0.06); border: 1px dashed #25d366; padding: 10px; border-radius: 8px;">
                        <p style="color: #fff; margin: 0 0 8px 0; font-size: 13px; font-weight: 500;">
                            অ্যাকাউন্ট অ্যাক্টিভ করার জন্য অ্যাডমিনকে নক দিন।
                        </p>
                        <a href="https://wa.me/+919635038840" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; background-color: #25D366; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: bold; box-shadow: 0 4px 10px rgba(37, 211, 102, 0.15);">
                            <i class="fab fa-whatsapp" style="margin-right: 6px; font-size: 16px;"></i> WhatsApp-এ নক দিন
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>
@endsection

@push('script')
    <script>
        function refreshCaptcha() {
            const num1 = Math.floor(Math.random() * 9) + 1;
            const num2 = Math.floor(Math.random() * 9) + 1;
            document.querySelectorAll('.captcha-number')[0].textContent = num1;
            document.querySelectorAll('.captcha-number')[1].textContent = num2;
            document.querySelector('input[name="num1"]').value = num1;
            document.querySelector('input[name="num2"]').value = num2;
            document.getElementById('captcha').value = '';
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').classList.add('active');
        });

        setInterval(refreshCaptcha, 120000);
    </script>
@endpush