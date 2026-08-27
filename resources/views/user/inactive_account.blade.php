@extends('layouts.app')
@section('title')
    Verification
@endsection
@section('content')
    <style>
        .inactive-container {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 2rem;
        }
        .inactive-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            background: #ffffff;
        }
        .inactive-card .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            padding: 1.5rem;
            text-align: center;
            letter-spacing: 0.5px;
            border-bottom: none;
        }
        .inactive-card .card-body {
            padding: 3rem 2rem;
            text-align: center;
            color: #4a5568;
        }
        .inactive-card .card-body p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }
        .inactive-card .card-body p:first-child {
            font-weight: 500;
            color: #2d3748;
        }
        .whatsapp-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #25D366;
            color: white;
            text-decoration: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 1rem;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
        }
        .whatsapp-link:hover {
            background: #1ebe5b;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.5);
            color: white;
            text-decoration: none;
        }
        .whatsapp-link svg {
            width: 28px;
            height: 28px;
            fill: white;
            transition: transform 0.3s ease;
        }
        .whatsapp-link:hover svg {
            transform: scale(1.1);
        }
        .alt-message {
            font-style: italic;
            color: #a0aec0;
            font-size: 0.95rem;
        }
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .inactive-card .card-body {
                padding: 2rem 1.5rem;
            }
            .inactive-card .card-header {
                font-size: 1.3rem;
                padding: 1.2rem;
            }
        }
    </style>

    <div class="inactive-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card inactive-card">
                        <div class="card-header">
                            <i class="fas fa-user-lock me-2"></i> Account Inactive
                        </div>
                        <div class="card-body">
                            <p>Your account is currently inactive. To access the full site, please contact the administrator.</p>
                            <p>You can reach us quickly via WhatsApp:</p>

                            @if($whatsappNumber)
                                <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="whatsapp-link">
                                    <!-- WhatsApp SVG icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                                    </svg>
                                    Chat on WhatsApp
                                </a>
                            @else
                                <p class="alt-message">WhatsApp contact not available. Please reach out to the administrator through other means.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection