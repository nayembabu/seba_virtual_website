@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Support Tickets</h1>

    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>User</th>
                <th>Message</th>
                <th>Reply</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($supports as $support)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $support->user->name }}</td>
                    <td>{{ $support->msg }}</td>
                    <td>{{ $support->reply }}</td>
                    <td>{{ ucfirst($support->status) }}</td>
                    <td>{{ $support->created_at->format('d F Y') }}</td>
                    <td>
                        <a href="{{ route('admin.support-detail', $support->id) }}" class="btn btn-info">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $supports->links() }}
</div>
@endsection
