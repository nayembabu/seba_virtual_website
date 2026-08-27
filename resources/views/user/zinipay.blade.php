@extends('user.layouts.app')

@section('title')
    @lang('Recharge via ZiniPay')
@endsection

@section('content')
    <style>
        .zinipay-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            margin: 0 auto;
        }

        .zinipay-logo-wrapper {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .zinipay-logo-wrapper img {
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
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
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="icon-user"></i> @lang('Recharge via ZiniPay')</h4>

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif

                        <div class="zinipay-section">
                            <div class="zinipay-logo-wrapper">
                                <a href="{{ route('user.zinipay') }}">
                                    <img src="https://zinipay.com/zini-pay-logo-new.jpg" alt="ZiniPay" />
                                </a>
                            </div>

                            <form action="{{ route('user.zinipay') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="amount">@lang('Amount')</label>
                                    <input type="number" id="amount" name="amount" class="form-control" placeholder="@lang('Enter amount')" required />
                                </div>

                                <button type="submit" class="btn btn-submit">@lang('Pay with ZiniPay')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
