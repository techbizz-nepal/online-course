<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->

        <title>@yield('title', 'Knowledge Empowers you')</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        @yield('metaTags')

        <!-- <link rel="preconnect" href="https://fonts.gstatic.com"> -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap"
              rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('assets/images/fav-icon.png') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flatpicker.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom-style.css') }}">
        @stack('css')
    </head>
    <body>
        @include('includes.header')
        @yield('content')
        @include('includes.footer')
        <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/stellarnav.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.matchHeight-min.js') }}"></script>
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/flatpicker.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        @stack('js')
    </body>
</html>
