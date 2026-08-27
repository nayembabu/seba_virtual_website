<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Information</title>
</head>
<body>
    <h1>Your Password Reset Information</h1>
    <p>Here are your updated login credentials:</p>
    <p><strong>User ID:</strong> {{ $user->id }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $new_password }}</p>
    <p>Please log in and change your password for security reasons.</p>
</body>
</html>
