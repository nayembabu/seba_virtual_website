@extends('user.layouts.app')

@section('title')
    Create Apostil
@endsection

@section('content')
    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-header">
            <h3 class="card-title">Create New Apostil</h3>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('user.application-details.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @php
                    $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'apostil')->first();
                @endphp

                @if($serviceCharge)
                    <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                            <div>
                                <h6 class="alert-heading mb-1 font-weight-bold">Service Charge</h6>
                                <p class="mb-0 small text-muted">A fee of <span class="font-weight-bold text-danger">{{ number_format($serviceCharge->amount, 2) }}</span> will be deducted for each Apostil creation.</p>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apostil_no">Apostil Number</label>
                            <input type="text" class="form-control" name="apostil_no" id="apostil_no" value="{{ old('apostil_no') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="place">Place</label>
                            <input type="text" class="form-control" name="place" id="place" placeholder="Police station" value="{{ old('place') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="certificate_image">Certificate Image</label>
                            <input type="file" class="form-control" name="certificate_image" id="certificate_image" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
@endsection

@push('css')

@endpush

@push('js')

@endpush
