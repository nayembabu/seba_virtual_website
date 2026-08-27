@extends('layouts.admin') {{-- Extend your admin layout --}}

@section('content')
<div class="container">
    <h1 class="mt-4">User Login Logs</h1>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.login.logs') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by email or IP address">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    {{-- Log Table --}}
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Email</th>
                <th>IP Address</th>
                <th>Success</th>
                <th>Login Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ optional($log->user)->email ?? 'N/A' }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->success ? 'Yes' : 'No' }}</td>
                    <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No logs found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination Links --}}
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
@endsection
