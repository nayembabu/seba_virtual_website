@extends('user.layouts.app')

@section('content')
<div class="container">
    <h1>Support Ticket Details</h1>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $support->subject }}</h5>
            <p class="card-text">{{ $support->msg }}</p>
            <p><strong>Status:</strong> 
                @if ($support->status == 'pending') Pending
                @elseif ($support->status == 'waiting_for_customer_reply') Waiting for Customer's Reply
                @elseif ($support->status == 'closed') Closed
                @elseif ($support->status == 'hold') On Hold
                @elseif ($support->status == 'processing') Processing
                @else Unknown
                @endif
            </p>

            @if ($support->photo)
                <img src="{{ asset('storage/' . $support->photo) }}" alt="Support Photo" class="img-fluid">
            @endif

            <h3>Replies</h3>
            @foreach ($support->replies as $reply)
                <div class="card mb-2">
                    <div class="card-body">
                        <p>{{ $reply->reply }}</p>

                        @if ($reply->photo)
                            <img src="{{ asset('storage/' . $reply->photo) }}" alt="Reply Photo" class="img-fluid">
                        @endif

                        <small class="text-muted">By: {{ $reply->user->name }} on {{ $reply->created_at->format('d M Y H:i') }}</small>
                    </div>
                </div>
            @endforeach

            <h3>Reply to Ticket</h3>
            <form action="{{ route('user.support-tickets.reply', $support->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="reply" class="form-label">Reply</label>
                    <textarea name="reply" class="form-control" id="reply" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Upload Photo (optional)</label>
                    <input type="file" name="photo" class="form-control" id="photo" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Submit Reply</button>
            </form>
        </div>
    </div>
</div>
@endsection
