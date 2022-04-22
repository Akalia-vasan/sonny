<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ __('setting.AppTitle') }}</title>
        <link type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" rel="icon">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">

    </head>

    <body>

        @yield('content')

        <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>

    </body>

</html>
