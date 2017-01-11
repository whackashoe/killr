<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description')">
        <meta name="author" content="IcosaDev">
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        <title>@yield ('title')</title>

        <link href="{{ asset('build/styles.css?id=1020') }}" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-42844259-4', 'auto');
        ga('send', 'pageview');
        </script>
    </head>
    <body>
        <menu id="mainmenu">
            <div id="linepadder"></div>
            <a href="{{ url('/') }}"><button id="logo">@yield ('menu_title', 'killr.io')</button></a>
            @yield ('menu_items')
        </menu>
        @yield ('content')

        <footer>
            <ul>
                <li><a href="/about">about</a></li>
                <li><a href="/terms">terms</a></li>
                <li><a href="https://github.com/whackashoe/killr-cmdline">cmdline</a></li>
                <li><a href="https://github.com/whackashoe/killr">source code</a></li>
            </ul>
        </footer>

        <script src="{{ asset('build/scripts.min.js?id=1020') }}"></script>
        @yield ('scripts')
    </body>
</html>
