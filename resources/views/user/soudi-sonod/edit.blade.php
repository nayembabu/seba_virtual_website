@extends('user.layouts.app')

@section('title')
    Worker Certificate
@endsection

@section('content')



<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row justify-content-between mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-primary mb-0"> New Worker Certificate
                    </h3>
                    <a href="{{ route('user.soudi-sonod.index') }}" class="btn btn-dark">
                        <i class="fas fa-arrow-left fa-fw"></i> Back
                    </a>
                </div>
                <hr class="border-primary opacity-75 mt-3">
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-left border-danger border-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                    <div>
                        <h4 class="alert-heading mb-1"> New Worker Certificate</h4>
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-times-circle mr-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

       <div class="container">
        <form method="POST" action="{{ route('user.soudi-sonod.update', $workerCertificate->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" value="{{ $workerCertificate->name }}" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nationality</label>
            <input type="text" value="{{ $workerCertificate->nationality }}" name="nationality" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Passport No</label>
            <input type="text" value="{{ $workerCertificate->passport_no }}" name="passport_no" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Certificate No</label>
            <input type="text" value="{{ $workerCertificate->certificate_no }}" name="certificate_no" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Worker No</label>
            <input type="text" value="{{ $workerCertificate->worker_no }}" name="worker_no" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Type</label>
            <input type="text" value="{{ $workerCertificate->type }}" name="type" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Issue Date</label>
            <input type="date" value="{{ $workerCertificate->issue_date }}" name="issue_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Expiry Date</label>
            <input type="date" value="{{ $workerCertificate->expiry_date }}" name="expiry_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    </div>
    </div>
</div>
@endsection


