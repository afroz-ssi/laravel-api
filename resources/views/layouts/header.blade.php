<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        // ==================== Check user is loged in ===================
        let token = localStorage.getItem("access_token");
        let path = window.location.pathname;
        if (token && (path === '/login' || path === '/')) {
            window.open('/profile', '_self');
        } else {
            if (!token && path !== '/login') {
                window.open('/login', '_self');
            }
            // else if (!token && path == '/') {
            //     window.open('/', '_self');
            // }
        }
    </script>
</head>

<body>
