@extends('user.layouts.app')
@section('title',trans('New Application'))

@section('dashboard','active')

@section('content')
<div class="container">
    <h2>Payment Form</h2>

    <!-- Display success or error messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{ route('user.payment') }}" method="POST">
    @csrf
    <label for="holding_id">Holding ID</label>
    <input type="number" name="holding_id" id="holding_id" required>
    
    <label for="amount">Amount</label>
    <input type="number" name="amount" id="amount" required>
    
    <button type="submit">Submit Payment</button>

    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>

@endsection

@push('script')
   