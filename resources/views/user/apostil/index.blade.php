@extends('user.layouts.app')

@section('title')
    Apostil Records
@endsection

@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Apostil Records</h5>
                <a href="{{ route('user.application-details.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Create New Apostil
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped datatable">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Apostil No.</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($apostils as $apostil)
                            <tr>
                                <td>{{ $apostil->id }}</td>
                                <td>{{ $apostil->apostil_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($apostil->date)->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('user.application-details.show', $apostil->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('user.application-details.edit', $apostil->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('user.application-details.destroy', $apostil->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No apostil records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
