@extends('user.layouts.app')
@section('title')
    এনআইডি সম্পাদনা
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">সম্পাদনা ({{ $nid->type }})</h4>
                <a href="{{ route('user.nid-card.index') }}" class="btn btn-outline-secondary btn-sm">তালিকা</a>
            </div>
            @include('user.nidcard.partials.nid-card-form-wizard', ['formType' => $nid->type, 'nid' => $nid])
        </div>
    </div>
@endsection
