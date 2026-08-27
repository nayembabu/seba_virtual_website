@extends('layouts.app')

@section('title','এডমিন এর সাথে যোগাযোগ করুন।')
@section('content')
    <!-- not found -->
    <section class="not-found">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col">
                    <div class="text-box text-center">
                        
                        <h1>{{trans('Forbidden')}}</h1>
                        <p>{{trans("You don't have permission to access ‘/’ on this server")}}</p>
                        <a href="{{url('/')}}" class="btn-custom text-white line-h22">@lang('Back To Home')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

