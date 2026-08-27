@extends('layouts.app')

@section('content')
<div class="container">
    <h1>About Us - Grameen Tech Solution</h1>
    <p>We are Grameen Tech Solution, an IT company specializing in providing Uninterruptible Power Supply (UPS) services. Established with the aim of delivering reliable power solutions, we ensure seamless operations for businesses and organizations across various sectors.</p>

    <p>As a subsidiary of Grameen Tech Solution, we inherit the legacy of excellence and commitment to quality. Our team comprises dedicated professionals with extensive expertise in power management systems, ensuring that our clients receive top-notch services tailored to their specific needs.</p>

    <p>At Grameen Tech Solution, we prioritize customer satisfaction and strive to exceed expectations with our innovative solutions and unparalleled support. Whether it's ensuring continuous power supply, implementing efficient energy management strategies, or providing prompt technical assistance, we are dedicated to empowering businesses and organizations to thrive in a dynamic environment.</p>

    <p>Our relentless pursuit of excellence, coupled with our customer-centric approach, sets us apart as a trusted partner for all your power supply needs. Join hands with Grameen Tech Solution and experience the difference!</p>
</div>
@endsection 

@push('style')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }

        p {
            line-height: 1.6;
            text-align: justify;
            margin-bottom: 20px;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: relative; /* Changed from fixed to relative */
            bottom: 0;
            width: 100%;
            margin-top: 40px; /* Adds space between content and footer */
        }

        footer p {
            margin: 0;
        }
    </style>
@endpush
