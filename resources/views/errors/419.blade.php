@extends('layouts.app')

@section('title', '419')
@section('content')
    <!-- Not Found Section -->
    <section class="not-found" style="min-height: 100vh; display: flex; justify-content: center; align-items: center; background-color: #f0f0f0;">
        <div class="container text-center">
            <div class="text-box">
                <!-- Animated 419 Text -->
                <h1 class="animated-text">@lang('419')</h1>
                <!-- Animated Paragraph -->
                <p class="animated-paragraph">@lang('Sorry, your session has expired, Please Login Again')</p>
                <!-- Bengali Message -->
                <p class="animated-paragraph-bn">আপনি লগআউট হয়ে গেছেন। দয়া করে পুনরায় লগইন করুন।</p>
                <!-- Back to Home Button -->
                <a href="{{ url('/') }}" class="btn-custom text-white animated-button">@lang('Back To Home')</a>
            </div>
        </div>
    </section>

@endsection

@section('styles')
    <style>
        /* Body background setup */
        body {
            background-color: #2c3e50;
            font-family: 'Roboto', sans-serif;
        }

        /* Center the content and set up the text-box design */
        .not-found {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .text-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        /* Animated text styles */
        .animated-text {
            font-size: 80px;
            font-weight: 700;
            color: #e74c3c;
            animation: fadeInZoom 1s ease-in-out forwards;
            opacity: 0;
        }

        .animated-paragraph,
        .animated-paragraph-bn {
            font-size: 18px;
            color: #34495e;
            margin-top: 20px;
            opacity: 0;
            animation: fadeInUp 1.5s ease-in-out forwards;
        }

        /* Button styles with animation */
        .btn-custom {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 25px;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 18px;
            transition: background-color 0.3s, transform 0.3s;
            opacity: 0;
            animation: fadeInUp 2s ease-in-out forwards;
        }

        .btn-custom:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        /* Keyframe animations */
        @keyframes fadeInZoom {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
