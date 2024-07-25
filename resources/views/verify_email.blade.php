<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
</head>

<body>
    <h2>{{ $data['body'] }}</h2>
    <h2>
        <a href="{{ $data['url'] }}"
            style="padding:5px; background:yellow; border:2px solid red;font-family:serif;">Verify Email</a>
    </h2>
</body>

</html>
