<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('mail_ad_edit.ad_edited', ['ad_id' => $ad->ad_id]) }}</title>
</head>
<body>
    <h1>{{ trans('mail_ad_edit.ad_edited_title', ['ad_title' => $ad->ad_title]) }}</h1>
    <p><a href="{{ url(str_slug($ad->ad_title) . '-' . 'ad' . $ad->ad_id . '.html') }}">{{ trans('mail_ad_edit.Click here to view your ad.') }}</a></p>
</body>
</html>
