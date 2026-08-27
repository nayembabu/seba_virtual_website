@extends('user.layouts.app')

@section('title')
   LSG PAYMENT
@endsection

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Result</title>
</head>
<body>
    <div style="text-align: center;">
        <p style="font-size: 18px; font-weight: bold;">Application ID is:</p>
        <p style="font-size: 24px; color: #007bff;" id="application-id">{{ $applicationId }}</p>
        <button onclick="copyToClipboard('{{ $applicationId }}')" style="margin-top: 10px; padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
            Copy ID
        </button>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Application ID copied to clipboard!');
            }).catch(err => {
                alert('Failed to copy text. Please try again.');
            });
        }
    </script>
</body>
</html>
@endsection
