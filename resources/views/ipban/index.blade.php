<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Ban Management</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1>IP Ban Management</h1>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h2>Ban an IP</h2>
        <form action="{{ route('ipban.ban') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="ip">IP Address:</label>
                <input type="text" name="ip" class="form-control" required>
                @error('ip')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="duration">Ban Duration (in minutes):</label>
                <input type="number" name="duration" class="form-control" required min="1">
                @error('duration')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-danger">Ban IP</button>
        </form>

        <h2 class="mt-5">Banned IPs</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>IP Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bannedIps as $ip => $value)
                    <tr>
                        <td>{{ $ip }}</td>
                        <td>
                            <form action="{{ route('ipban.unban') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="ip" value="{{ $ip }}">
                                <button type="submit" class="btn btn-success">Unban</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
