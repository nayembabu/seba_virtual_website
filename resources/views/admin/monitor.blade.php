@extends('admin.layouts.app')
@section('title')

@endsection
@section('content')
<div class="container">
    <h1>Monitoring System</h1>
    
    <div class="row">
        <div class="col-md-6">
            {{-- Show section for users with Balance but No Recharge History --}}
            @if($users->count() > 0)
            <h2>Users with Balance but No Recharge History</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Balance</th>
                        <th>Email/Username</th> {{-- Assuming you want to show email/username --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->balance }}</td>
                        <td>{{ $user->email }}</td> {{-- Change to username if you prefer --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Pagination links --}}
            {{ $users->links() }}
            @else
            <p>No users with balance but no recharge history found.</p>
            @endif
        </div>
        <div class="col-md-6">
            {{-- Show section for users with same IP Address --}}
            @if($loginLogs->count() > 0)
            <h2>Users with Same IP Address</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loginLogs as $log)
                    <tr>
                        <td>{{ $log->user_id }}</td>
                        <td>{{ $log->ip_address }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Pagination links --}}
            {{ $loginLogs->links() }}
            @else
            <p>No users with the same IP address found.</p>
            @endif
        </div>
    </div>
</div>



@endsection