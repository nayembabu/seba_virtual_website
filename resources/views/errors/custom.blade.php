<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Error</title>
    <style>
        body { margin: 0; padding: 0; width: 100vw; height: 100vh; background-color: #f0f2f5; display: flex; flex-direction: column; justify-content: center; align-items: center; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; color: #333; }
        .container { text-align: center; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { font-size: 24px; color: #dc3545; margin-bottom: 10px; }
        p { font-size: 16px; margin-bottom: 20px; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>An Error Occurred</h1>
        @if(isset($exception) && $exception->getMessage())
            <p>{{ $exception->getMessage() }}</p>
            <p>{{ $exception->getFile() }}</p>
            <p>{{ $exception->getLine() }}</p>
        @else
            <p>Sorry, something went wrong with the application.</p>
        @endif
        <p>Please try again later or contact support if the issue persists.</p>
        <a href="{{ url('/') }}">Go to Homepage</a>
    </div>
</body>
</html>
