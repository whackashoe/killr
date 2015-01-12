<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        <title>killr.io</title>

        <link href="{{ asset('build/styles.css') }}" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        @yield('style')
    </head>
    <body>
        <menu id="mainmenu">
            <div id="linepadder"></div>
            <a href="{{ url('/') }}"><button id="logo">killr.io</button></a>
            @yield('menu_items')
            <a href="{{ url('terms') }}"><button id="terms">terms</button></a>
            <a href="{{ url('about') }}"><button id="about">about</button></a>
        </menu>
        @yield('content')

        <script src="{{ asset('build/scripts.min.js') }}"></script>
    </body>
</html>
