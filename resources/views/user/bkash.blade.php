@extends('user.layouts.app')

@section('title')
    @lang('Recharge via bkash')
@endsection

@section('content')
    <style>
        .bkash-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            margin: 0 auto;
        }

        .bkash-logo-wrapper {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .bkash-logo-wrapper img {
            width: 80px;
            height: auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #218838;
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 5px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .card-title {
            color: #333;
            font-size: 18px;
        }

        @media (max-width: 576px) {
            .bkash-section {
                padding: 20px;
            }

            .bkash-logo-wrapper img {
                width: 60px;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="icon-user"></i> @lang('Recharge via bkash')</h4>

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif

                        <div class="bkash-section">
                            <div class="bkash-logo-wrapper">
                                <a href="{{ route('user.bkash') }}">
                                    <img src="https://freelogopng.com/images/all_img/1656227753bkash-logo-png-download.png" alt="bKash" />
                                </a>
                            </div>

                            <form action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount" required />
                                </div>

                                <button type="submit" class="btn btn-submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
@endpush