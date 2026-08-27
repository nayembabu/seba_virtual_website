@extends('user.layouts.app')

@section('title')
    BMET EC List
@endsection

@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">BMET EC List</h5>
                <a href="{{ route('user.bmet-ec.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add New BMET EC
                </a>
            </div>
            <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>EC No</th>
                                    <th>Passport Number</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bmetEcs as $index => $bmetEc)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $bmetEc->ec_no }}</td>
                                        <td>{{ $bmetEc->passport_no }}</td>
                                        <td>{{ $bmetEc->name }}</td>
                                        <td>{{ $bmetEc->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>
                                           
                                            <a href="{{ route('user.bmet-ec.edit', $bmetEc->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ route('user.bmet-ec.print', $bmetEc->id) }}" class="btn btn-success btn-sm">Print</a>
                                            <form action="{{ route('user.bmet-ec.destroy', $bmetEc->id) }}" method="POST" class="d-inline">
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
@endsection
