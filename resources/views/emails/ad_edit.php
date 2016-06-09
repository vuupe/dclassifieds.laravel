<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ad #<?=$ad->ad_id?> Edited</title>
</head>
<body>
    <h1>Your ad "<?=$ad->ad_title?>" was edited!</h1>

    <p>
        <a href="<?=url(str_slug($ad->ad_title) . '-' . 'ad' . $ad->ad_id . '.html')?>">Click here to view your ad.</a>
    </p>
</body>
</html>
