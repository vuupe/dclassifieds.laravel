<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ trans('mail_ad_contact.You have new message') }}</title>
</head>
<body>
    <h1>{{ trans('mail_ad_contact.You have new message') }}</h1>
    <p><a href="{{ route('mailview', ['hash' => $userMail->mail_hash, 'user_id_from' => $userMail->user_id_from, 'mail_id' => $userMail->ad_id]) }}">{{ trans('mail_ad_contact.Click here to see your message.') }}</a></p>
</body>
</html>
