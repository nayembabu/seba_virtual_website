@extends('user.layouts.app')

@section('title')
   LSG PAYMENT
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <center>
                        <h3 class="text-info">
                            Charge: 400
                        </h3>
                    </center>
                    <div class="container mt-5">
                        <h2>Payment Request Form</h2>
                        <form action="{{ route('payment-request.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="holding_id" class="form-label">Application ID</label>
                                <input type="number" class="form-control" id="holding_id" name="holding_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="amount1" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amount1" name="amount1" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        @if (session('status'))
                            <div class="alert alert-info mt-3">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert-info {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
