@extends('user.layouts.app')
@section('content')
<div class="container">
    <h1>My Support Tickets</h1>

    <a href="{{ route('user.support-tickets.create') }}" class="btn btn-primary mb-3">Create New Ticket</a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supports as $support)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $support->subject }}</td>
                    <td>
                       @if ($support->status == 'pending') Pending
                @elseif ($support->status == 'waiting_for_customer_reply') Waiting for Customer's Reply
                @elseif ($support->status == 'closed') Closed
                @elseif ($support->status == 'hold') On Hold
                @elseif ($support->status == 'processing') Processing
                @else Unknown
                @endif
                    </td>
                    <td>{{ $support->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('user.support-tickets.show', $support->id) }}" class="btn btn-primary">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No support tickets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
