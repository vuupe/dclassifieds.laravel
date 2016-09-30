<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('mail_activation.Sign Up Confirmation') }}</title>
</head>
<body>
    <h1>{{ trans('mail_activation.Thanks for signing up!') }}</h1>
    
    <h3>Your info:</h3>
    
    <p>{{ trans('mail_activation.Name') }}: {{ $user->name }}</p>
    <p>{{ trans('mail_activation.E-Mail') }}: {{ $user->email }}</p>
    <p>{{ trans('mail_activation.Password') }}: {{ $password }}</p>
    
    <h3>{{ trans('mail_activation.Please confirm') }}:</h3>
    <p>{{ trans('mail_activation.We just need you to') }} <a href='{{ url("register/confirm/{$user->user_activation_token}") }}'>{{ trans('mail_activation.confirm your email address') }}</a> {{ trans('mail_activation.real quick!') }}</p>
</body>
</html>
