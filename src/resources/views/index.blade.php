<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

        <title>Blog.ly</title>
    </head>
    <body>
        <div id="app" loggedin="{{ \Auth::check() }}">
            @include('routes')

            <vue-app></vue-app>
        </div>

    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
