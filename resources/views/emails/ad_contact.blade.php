<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>You have new message</title>
</head>
<body>
    <h1>You have new message in DClassifieds</h1>
    <p><a href="{{ url('message/view/' . $userMail->mail_hash) }}">Click here to see your message.</a></p>
</body>
</html>
