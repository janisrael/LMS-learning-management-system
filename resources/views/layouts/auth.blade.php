<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/auth/util.css">
	<link rel="stylesheet" type="text/css" href="css/auth/main.css">

<style>
		div#app {
			background: #f4f6f9 !important;
		}
		.content-wrapper {
				background-color: transparent !important;
				/*min-height: none !important;*/
		}
	.login-wrapper-header {
		background-image: none;
		background-color:transparent;
		padding: 30px;
		border-top-left-radius: 10px;
		border-top-right-radius: 10px;
		font-size: 1.3rem;
		text-align: center;
	}
	.wrap-login100 {
		padding: 0px !important;
		background-color:transparent !important;
	}

	.login100-form-btn {
    font-family: Raleway;
    font-weight: 700;
    font-size: 16px;
    color: #161742 !important;
    line-height: 1.2;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 20px;
    min-width: 150px;
    height: 55px;
    background-color: rgb(255 255 255 / 85%) !important;
    border-radius: 2px !important;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    -moz-transition: all 0.4s;
    transition: all 0.4s;
}
.container-login100 {
			background-image: url('../../img/bg.svg?v=1620469277'), linear-gradient( 141deg, #1781d0 0%, #1f81b6 51%, #2d7cb0 100%) !important;
			background-size: cover;
    }
	}
	.login-body {
		padding:40px;
	}
	.font-weight-light {
		font-weight: 300 !important;
	}
	.txt1 {
    font-family: Raleway;
    font-size: 13px;
    color: #95aadf !important;
    font-weight: 100 !important;
    line-height: 1.4;
    text-transform: uppercase;
}
	.logo-lg {
		color: #a5e054;
	}
</style>
</head>
<body>
	<div id="app">
		<div class="limiter">
			<div class="container-login100">
				@yield('content')
			</div>
		</div>
	</div>

{{--    <script src="{{ asset('js/app.js') }}"></script>--}}
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/auth/main.js"></script>

</body>
</html>
