<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-material-datetimepicker.min.css') }}">
    <script src="https://js.chargebee.com/v2/chargebee.js" data-cb-site="smartchartsfx-test"></script>

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
<div class="wrapper" id="app">
</div>
<script>
  window.ENV = {
    APP_STAGE: '{{ env('APP_STAGE') }}',
    APP_DEBUG: '{{ env('APP_DEBUG') }}',
    APP_URL: '{{ config('app.url') }}',
    APP_NAME: '{{ config('app.name') }}',
    SC_ADMIN_CHARGEBEE_SITE: '{{ config('chargebee.site') }}',
    SC_ADMIN_CHARGEBEE_KEY: '{{ config('chargebee.api_key') }}',
    APP_MARKETING_BASE_URL: '{{ config('app.app_marketing_base_url') }}',
    SESSION_TIMEOUT: '{{ config('app.session_timeout') }}'
  };
</script>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
{{--<script src="{{ asset('js/bootstrap-material-datetimepicker.js')}}"></script>--}}
</body>
</html>

