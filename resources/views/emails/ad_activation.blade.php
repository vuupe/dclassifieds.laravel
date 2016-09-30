<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ad #{{ $ad->ad_id }} {{ trans('mail_ad_activation.Activation') }}</title>
</head>
<body>
    <h1>{{ trans('mail_ad_activation.Thanks for publishing your ad') }} "{{ $ad->ad_title }}"!</h1>
    <p>{{ trans('mail_ad_activation.We just need you to') }} <a href='{{ url("publish/activate/{$ad->code}") }}'>{{ trans('mail_ad_activation.activate your ad') }}</a> {{ trans('mail_ad_activation.real quick!') }}</p>
</body>
</html>
