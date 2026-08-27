@extends('manager.layouts.app')

@section('content')
<div class="container">
    <h1>Support Ticket Details</h1>

    <p><strong>Subject:</strong> {{ $support->subject }}</p>
    <p><strong>Message:</strong> {{ $support->msg }}</p>
    <p><strong>Status:</strong> {{ ucfirst($support->status) }}</p>

    @if ($support->photo)
        <p><strong>Photo:</strong> <img src="{{ asset('storage/' . $support->photo) }}" alt="Support Photo" width="200"></p>
    @endif

    <!-- Replies Section -->
    <h3>Replies</h3>
    @forelse ($support->replies as $reply)
        <div class="card mb-2">
            <div class="card-body">
                <p>{{ $reply->reply }}</p>
                @if ($reply->photo)
                    <img src="{{ asset('storage/' . $reply->photo) }}" alt="Reply Photo" class="img-fluid">
                @endif
                <small class="text-muted">
                    By: {{ $reply->user->name }} 
                    on {{ $reply->created_at->format('d M Y H:i') }}
                </small>
            </div>
        </div>
    @empty
        <p>No replies yet.</p>
    @endforelse

    <!-- Reply Form -->
    <form action="{{ route('admin.reply-to-support', $support->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="reply">Reply</label>
            <textarea id="reply" name="reply" class="form-control" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="photo">Upload Photo (optional)</label>
            <input type="file" name="photo" class="form-control" id="photo">
        </div>
        <button type="submit" class="btn btn-primary">Submit Reply</button>
    </form>

    <!-- Update Status Form -->
    <form action="{{ route('admin.update-support-status', $support->id) }}" method="POST" style="margin-top: 10px;">
        @csrf
        <div class="form-group">
            <label for="status">Update Status</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" {{ $support->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="waiting_for_customer_reply" {{ $support->status == 'waiting_for_customer_reply' ? 'selected' : '' }}>Waiting for Customer's Reply</option>
                <option value="closed" {{ $support->status == 'closed' ? 'selected' : '' }}>Closed</option>
                <option value="hold" {{ $support->status == 'hold' ? 'selected' : '' }}>Hold</option>
                <option value="processing" {{ $support->status == 'processing' ? 'selected' : '' }}>Processing</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Update Status</button>
    </form>

    <!-- Mark as Solved Form -->
    <form action="{{ route('admin.mark-support-solved', $support->id) }}" method="POST" style="margin-top: 10px;">
        @csrf
        <button type="submit" class="btn btn-success">Mark as Solved</button>
    </form>
</div>
@endsection
