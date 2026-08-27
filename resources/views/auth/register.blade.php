@extends('layouts.app')
@section('title', 'Register')
@section('register', 'active')
@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .register-page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e1e2e 0%, #2d1b3d 50%, #1a1a2e 100%);
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }

        .register-page::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            top: -150px;
            right: -150px;
            animation: float 8s ease-in-out infinite;
        }

        .register-page::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            50% {
                transform: translate(30px, 30px) scale(1.1);
            }
        }

        .register-container {
            background: rgba(30, 30, 46, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            z-index: 1;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            width: 180px;
            height: auto;
            margin-bottom: 20px;
        }

        .register-header h2 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            text-align: center;
        }

        .register-header p {
            color: #9ca3af;
            font-size: 14px;
            text-align: center;
            margin-bottom: 30px;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }

        .step-indicator-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .step-indicator-item.active .step-number {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            border-color: #7c3aed;
            color: #ffffff;
            box-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
        }

        .step-indicator-item.completed .step-number {
            background: #10b981;
            border-color: #10b981;
            color: #ffffff;
        }

        .step-label {
            color: #6b7280;
            font-size: 11px;
            text-align: center;
        }

        .step-indicator-item.active .step-label {
            color: #a855f7;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #d1d5db;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-group label .req {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
        }



        .form-control:focus {
            outline: none;
            border-color: #7c3aed;
            background: rgba(235, 235, 235, 0.05);
            color: #ffffff;
        }

        .form-control::placeholder {
            color: #6b7280;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.05);
        }
        .form-control select,
        select.form-control {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            cursor: pointer;
        }

        .form-control option {
            background: #1e1e2e;
            color: #ffffff;
            padding: 10px;
        }

        .form-control option:hover,
        .form-control option:checked {
            background: #7c3aed;
            color: #ffffff;
        }
        .invalid-feedback {
            color: #fca5a5;
            font-size: 12px;
            margin-top: 6px;
        }

        .step {
            display: none;
            animation: fadeIn 0.4s ease;
        }

        .step.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-nav {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .step-nav button {
            flex: 1;
            padding: 14px 24px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-prev {
            background: rgba(255, 255, 255, 0.05);
            color: #9ca3af;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-prev:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-next, .btn-submit {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            color: #ffffff;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-next::before, .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-next:hover::before, .btn-submit:hover::before {
            left: 100%;
        }

        .btn-next:hover, .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(124, 58, 237, 0.4);
        }

        .btn-submit {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(124, 58, 237, 0.3);
            }
            50% {
                box-shadow: 0 0 30px rgba(124, 58, 237, 0.6);
            }
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .login-link p {
            color: #9ca3af;
            font-size: 14px;
        }

        .login-link a {
            color: #a855f7;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #7c3aed;
            text-decoration: underline;
        }

        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .preloader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-top: 4px solid #7c3aed;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 600px) {
            .register-container {
                padding: 30px 20px;
            }

            .register-header h2 {
                font-size: 24px;
            }

            .step-label {
                font-size: 10px;
            }

            .step-nav {
                flex-direction: column;
            }

            .btn-prev {
                order: 2;
            }
        }
    </style>

    <section class="register-page">
        <div class="register-container">
            <div class="logo-container">
                <img src="{{ asset('assets/uploads/logo/Screenshot_2025-10-18_021531-removebg-preview.png') }}" alt="Logo">
            </div>

            <div class="register-header">
                <h2>Create New Account</h2>
                <p>Sign up to get started with your account</p>
            </div>

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step-indicator-item active" data-step="1">
                    <div class="step-number">1</div>
                    <span class="step-label">Personal</span>
                </div>
                <div class="step-indicator-item" data-step="2">
                    <div class="step-number">2</div>
                    <span class="step-label">Account</span>
                </div>
                <div class="step-indicator-item" data-step="3">
                    <div class="step-number">3</div>
                    <span class="step-label">Details</span>
                </div>
                <div class="step-indicator-item" data-step="4">
                    <div class="step-number">4</div>
                    <span class="step-label">Finish</span>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form id="registerForm" action="{{ route('register.submit') }}" method="post" enctype="multipart/form-data">
                @csrf

                <!-- Step 1: Personal Information -->
                <div class="step active" id="step-1">
                    <div class="form-group">
                        <label>Full Name <span class="req">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your full name" required />
                    </div>
                    <div class="form-group">
                        <label>Phone Number <span class="req">*</span></label>
                        <input type="tel" name="phone" class="form-control" placeholder="Enter your phone number" required />
                    </div>
                </div>

                <!-- Step 2: Account Information -->
                <div class="step" id="step-2">
                    <div class="form-group">
                        <label>Email Address <span class="req">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required />
                    </div>
                    <div class="form-group">
                        <label>Password <span class="req">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" minlength="6" required />
                    </div>
                </div>

                <!-- Step 3: Additional Information -->
                <div class="step" id="step-3">
                    <div class="form-group">
                        <label>Gender <span class="req">*</span></label>
                        <select name="gender" class="form-control" required>
                            <option value="">Select your gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control" />
                    </div>
                </div>

                <!-- Step 4: National ID and Promo Code -->
                <div class="step" id="step-4">
                    <div class="form-group">
                        <label>National ID</label>
                        <input type="text" name="nid" class="form-control" placeholder="Enter your national ID (optional)" />
                    </div>
                    <div class="form-group">
                        <label>Promo Code</label>
                        <input type="text" name="promo" class="form-control" placeholder="Enter promo code (optional)" />
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="step-nav">
                    <button type="button" class="btn-prev" onclick="prevStep()" style="display: none;">Previous</button>
                    <button type="button" class="btn-next" onclick="nextStep()">Next</button>
                    <button type="submit" class="btn-submit" style="display: none;">Create Account</button>
                </div>
            </form>

            <div class="login-link">
                <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
            </div>
        </div>
    </section>

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-spinner"></div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function updateStepIndicator(step) {
            document.querySelectorAll('.step-indicator-item').forEach((item, index) => {
                const stepNum = index + 1;
                if (stepNum < step) {
                    item.classList.add('completed');
                    item.classList.remove('active');
                } else if (stepNum === step) {
                    item.classList.add('active');
                    item.classList.remove('completed');
                } else {
                    item.classList.remove('active', 'completed');
                }
            });
        }

        function showStep(step) {
            document.querySelectorAll('.step').forEach((stepEl, index) => {
                if (index + 1 === step) {
                    stepEl.classList.add('active');
                } else {
                    stepEl.classList.remove('active');
                }
            });

            document.querySelector('.btn-prev').style.display = step > 1 ? 'block' : 'none';
            document.querySelector('.btn-next').style.display = step < totalSteps ? 'block' : 'none';
            document.querySelector('.btn-submit').style.display = step === totalSteps ? 'block' : 'none';

            updateStepIndicator(step);
        }

        function validateStep(step) {
            const currentStepEl = document.getElementById(`step-${step}`);
            const inputs = currentStepEl.querySelectorAll('input[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                // Remove previous error messages
                const existingFeedback = input.parentNode.querySelector('.invalid-feedback');
                if (existingFeedback) {
                    existingFeedback.remove();
                }

                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'This field is required';
                    input.parentNode.appendChild(feedback);
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            return isValid;
        }

        function nextStep() {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (validateStep(currentStep)) {
                document.querySelector('.preloader').style.display = 'flex';
                this.submit();
            }
        });

        // Hide preloader on page load
        window.addEventListener('load', function () {
            document.querySelector('.preloader').style.display = 'none';
        });

        // Initialize the form with step 1
        showStep(currentStep);

        // Add input event listeners to remove error state when user types
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.remove();
                }
            });
        });
    </script>
@endsection