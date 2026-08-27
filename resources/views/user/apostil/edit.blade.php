@extends('user.layouts.app')

@section('title')
    Edit Apostil: {{ $apostil->apostil_no }}
@endsection

@section('content')
    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-header">
            <h3 class="card-title">Edit Apostil Record</h3>
        </div>
        <div class="card-body">

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

            <form action="{{ route('user.application-details.update', $apostil->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" name="date" id="date" value="{{ old('date', $apostil->date) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apostil_no">Apostil Number</label>
                            <input type="text" class="form-control" name="apostil_no" id="apostil_no" value="{{ old('apostil_no', $apostil->apostil_no) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="place">Place</label>
                            <input type="text" class="form-control" name="place" id="place" value="{{ old('place', $apostil->place) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="certificate_image">Certificate Image <small class="text-muted">(leave blank to keep current image)</small></label>
                            @if ($apostil->certificate_image)
                                <p class="mb-1">Current Image:</p>
                                <img src="{{ asset('storage/uploads/' . $apostil->certificate_image) }}" alt="Current Certificate Image" class="img-thumbnail mb-2" style="max-width: 200px;">
                            @endif
                            <input type="file" class="form-control" name="certificate_image" id="certificate_image">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Apostil</button>
                <a href="{{ route('user.application-details.index') }}" class="btn btn-secondary ml-2">Cancel</a>
            </form>

        </div>
    </div>
@endsection

@push('css')

@endpush

@push('js')

@endpush
