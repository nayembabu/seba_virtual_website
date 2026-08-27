@extends('user.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(count($visaApplications) > 0)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">My Visa Applications</h5>
                            <a href="{{ route('user.visa-applications.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Create New Application
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Visa Number</th>
                                        <th>Full Name</th>
                                        <th>Visa Type</th>
                                        <th>Issue Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($visaApplications as $application)
                                        <tr>
                                            <td>{{ $application->id }}</td>
                                            <td>{{ $application->visa_number }}</td>
                                            <td>{{ $application->full_name }}</td>
                                            <td>{{ $application->visa_type }}</td>
                                            <td>{{ date('d M, Y', strtotime($application->visa_issue_date)) }}</td>
                                            <td>
                                                <a href="{{ route('user.visa-applications.show', $application->id) }}" class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('user.visa-applications.edit', $application->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('user.visa-applications.destroy', $application->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    @else
                        <div class="alert alert-info">
                            You don't have any visa applications yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
