@extends('user.layouts.app')
@section('content')
<div class="container">
    <h1>Create New Ticket</h1>
    
    <form action="{{ route('user.support-tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control" id="subject" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" class="form-control" id="message" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select name="priority" class="form-control" id="priority" required>
                <option value="3">High</option>
                <option value="2">Medium</option>
                <option value="1">Low</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Upload Photo (optional)</label>
            <input type="file" name="photo" class="form-control" id="photo" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Submit Ticket</button>
    </form>
</div>
@endsection

