<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ad #<?=$ad->ad_id?> Actiontion</title>
</head>
<body>
    <h1>Thanks for publishing your ad "<?=$ad->ad_title?>"!</h1>

    <p>
        We just need you to <a href='{{ url("publish/activate/{$ad->code}") }}'>activate your ad</a> real quick!
    </p>
</body>
</html>
