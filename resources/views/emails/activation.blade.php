<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up Confirmation</title>
</head>
<body>
    <h1>Thanks for signing up!</h1>
    
    <h3>Your info:</h3>
    
    <p>Name: {{ $user->name }}</p>
    <p>E-Mail: {{ $user->email }}</p>
    <p>Password: {{ $password }}</p>
    
    <h3>Please confirm:</h3>
    <p>
        We just need you to <a href='{{ url("register/confirm/{$user->user_activation_token}") }}'>confirm your email address</a> real quick!
    </p>
</body>
</html>
