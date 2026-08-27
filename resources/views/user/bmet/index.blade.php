@extends('user.layouts.app')

@section('title')
    BMET Smart Card List
@endsection

@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">BMET Smart Card List</h3>
                </div>
                <div class="card-header d-flex justify-content-end">
                    <a href="{{ route('bmet.create') }}" class="btn btn-primary">Add New BMET Card</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Passport Number</th>
                                    <th>BMET Number</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bmetCards as $index => $bmet)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $bmet->passport_no }}</td>
                                        <td>{{ $bmet->bmet_no }}</td>
                                        <td>{{ $bmet->name }}</td>
                                        <td>{{ $bmet->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('bmet.show', $bmet->id) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('bmet.edit', $bmet->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('bmet.destroy', $bmet->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
