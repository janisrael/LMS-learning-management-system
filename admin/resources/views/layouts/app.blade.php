<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        div#app {
            background: #f4f6f9 !important;
        }
        .content-wrapper {
            background-color: transparent !important;
            /*min-height: none !important;*/
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div id="app" class="wrapper">
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
