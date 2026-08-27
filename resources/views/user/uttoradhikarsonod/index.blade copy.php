@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="float-left">Uttoradhikar Certificates</h4>
                    <a href="{{ route('user.uttoradhikar-sonod.create') }}" class="btn btn-primary float-right">Create New Certificate</a>
                </div>

                <div class="card-body">
                    @if($certificates->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Certificate Number</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($certificates as $certificate)
                                        <tr>
                                            <td>{{ $certificate->certificate_number }}</td>
                                            <td>{{ $certificate->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('user.uttoradhikar-sonod.show', $certificate->id) }}" class="btn btn-info btn-sm">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $certificates->links() }}
                    @else
                        <p class="text-center">No certificates found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
