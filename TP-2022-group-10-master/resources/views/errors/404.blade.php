<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 | StasyMgt HR</title>
    <link href="https://fonts.googleapis.com/css?family=Kanit:200" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ asset('vendor/error-404-19/css/font-awesome.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('vendor/error-404-19/css/style.css') }}" />
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="notfound">
    <div class="notfound">
        <div class="notfound-404">
            <h1>404</h1>
        </div>
        <h2>Oops! Nothing was found</h2>
        <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="{{ route('entry-selector') }}">Return to homepage</a></p>
    </div>
</div>
</body>
</html>
