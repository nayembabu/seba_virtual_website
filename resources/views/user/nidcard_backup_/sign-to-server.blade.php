@extends('user.layouts.app')
@section('title')
    সাইন টু সার্ভার
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">এনআইডি — sign-to-server</h4>
                <a href="{{ route('user.nid-card.index') }}" class="btn btn-outline-secondary btn-sm">তালিকা</a>
            </div>
            @include('user.nidcard.partials.sign-form-wizard', ['formType' => \App\Models\Nid::TYPE_SIGN_TO_SERVER])
        </div>
    </div>
@endsection
