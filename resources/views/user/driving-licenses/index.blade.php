@extends('user.layouts.app')

@section('title')
    Driving License Applications
@endsection

@section('content')
    <div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Driving License Applications</h5>
                <a href="{{ route('user.driving-licenses.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add New Application
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped datatable">
                    <thead class="thead-dark">
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>License No</th>
                        <th>Validity</th>
                        <th>Authority</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($applications as $application)
                        <tr>
                            <td>
                                @if($application->photo)
                                    <img src="{{ asset($application->photo) }}" alt="Photo" width="50">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $application->name }}</td>
                            <td>{{ $application->licenceNo }}</td>
                            <td>{{ $application->validityDate->format('d/m/Y') }}</td>
                            <td>{{ $application->authority }}</td>
                            <td>
                                <a href="{{ route('user.driving-licenses.show', $application) }}"
                                   class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('user.driving-licenses.edit', $application) }}"
                                   class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('user.driving-licenses.destroy', $application) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No applications found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@push('css')
    {{-- Additional CSS here --}}
@endpush

@push('js')
    {{-- Additional JS here --}}
@endpush