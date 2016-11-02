<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ trans('contact.New Contact Us Requiest') }}</title>
</head>
<body>
    <h1>{{ trans('contact.New Contact Us Requiest') }}</h1>
    <p><strong>{{ trans('contact.Name') }}:</strong> {{ $params['contact_name'] }}</p>
    <p><strong>{{ trans('contact.E-Mail') }}:</strong> {{ $params['contact_mail'] }}</p>
    <p><strong>{{ trans('contact.Message') }}:</strong> {!! nl2br(strip_tags($params['contact_message'])) !!} </p>
</body>
</html>
