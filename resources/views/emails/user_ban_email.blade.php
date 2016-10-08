<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ trans('mail_user_ban_email.You are banned') }}</title>
</head>
<body>
    <h1>{{ trans('mail_user_ban_email.You are banned') }}</h1>
    <p>{{ trans('mail_user_ban_email.Ban Reason') }}: {{ $data['ban_reason'] }}</p>
</body>
</html>
