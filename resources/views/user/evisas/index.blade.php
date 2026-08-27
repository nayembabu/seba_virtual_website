@extends('user.layouts.app')

@section('title')
    E-Visa Management
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
                        <h5 class="mb-0">E-Visa Management</h5>
                        <a href="{{ route('user.evisas.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Create New E-Visa
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped datatable">
                            <thead>
                                <tr>
                                    <th>Visa ID</th>
                                    <th>E-Visa Number</th>
                                    <th>Full Name</th>
                                    <th>Nationality</th>
                                    <th>Issue Date</th>
                                    <th>Expire Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($visas as $k => $visa)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $visa->evisa_number }}</td>
                                        <td>{{ $visa->full_name }}</td>
                                        <td>{{ $visa->nationality }}</td>
                                        <td>{{ $visa->issue_date->format('Y-m-d') }}</td>
                                        <td>{{ $visa->expire_date->format('Y-m-d') }}</td>
                                        <td>                                            <div class="btn-group">
                                                <a href="{{ route('user.evisas.show', $visa) }}" class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('user.evisas.edit', $visa) }}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{ route('user.evisas.destroy', $visa) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this e-visa?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No e-visas found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

@endsection
