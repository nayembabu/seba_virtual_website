@extends('layouts.app')
@section('title','Register Fee Payment')
@section('register','active')
@section('content')
    <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Register Fee Payment </h2>
                </div>
                <form method="post" action="">
                    
                    <div class="info" style="padding:4px;border:1px solid purple">
                        
                       <h4>Your Information</h4> 
                       Name : <b> {{ $user->name }} </b> <br/>
                       Email : <b> {{ $user->email }} </b> <br/>
                       Phone : <b> {{ $user->phone }} </b> <br/>
                       Gender : <b> {{ $user->gender }} </b> <br/>
                       Date of Birth : <b> {{ $user->dob }} </b> <br/>
                       NID : <b> {{ $user->nid }} </b> <br/>
                       
                    </div>
                    
                    
                    @csrf
                    
                     @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="alert alert-danger">{{ $error }}</div>
     @endforeach
     @endif 
                    <p class="text-center">Register fee is {{ get_settings()->register_fee }}TK . Click "Pay Now" button and you will be redirected to payment.</p>
                    
                    <button class="btn btn-success btn-block" type="submit">Pay Now</button>
                    
                    <a class="btn btn-danger btn-block" href="{{ route('register') }}">Cancel</a>
                   
                    </form>
            </div>
        </section>
@endsection

@push('style')

@endpush
