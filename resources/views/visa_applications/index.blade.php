@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>My Visa Applications</h4>
                    <a href="{{ route('visa-applications.create') }}" class="btn btn-primary">Create New Application</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(count($visaApplications) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
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
                                                <a href="{{ route('visa-applications.show', $application->id) }}" class="btn btn-info btn-sm">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $visaApplications->links() }}
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