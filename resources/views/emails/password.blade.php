<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('mail_password.Password Reset') }}</title>
</head>
<body>
    <p>{{ trans('mail_password.Click here to reset your password') }}: {{ url('reset/'. $token) }}</p>
</body>
</html>