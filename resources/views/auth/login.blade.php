@extends('layouts.auth')

@section('content')
<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
    <div class="login-wrapper-header">
        {{--        <h1 class="login100-form-title p-b-32">--}}
        {{--            {{ __('SC2 Admin Login') }}--}}
        {{--        </h1>--}}
        <span class="logo-lg">
        <span class="brand-text font-weight-light" style="font-family: 'Nunito', sans-serif;"><span style="font-weight: 600; padding-left: 5px; color: #a5e054;">
                E-LEARNING</span>
            <span style="color: #fff;">ADMIN</span>
        </span>
        </span>
    </div>
    <div class="login-body">
    @include('components.form_error')
    <form class="login100-form validate-form flex-sb flex-w" method="POST" action="{{ route('login') }}">
        @csrf

        <span class="txt1 p-b-11">
            {{ __('Username') }}
        </span>
        <div class="wrap-input100 validate-input m-b-36" data-validate = "Username is required">
            <input class="input100" type="text" name="username" value="{{ old('username') }}" required autofocus>
            <span class="focus-input100"></span>
        </div>

        <span class="txt1 p-b-11">
            {{ __('Password') }}
        </span>
        <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
            <span class="btn-show-pass">
                <i class="fa fa-eye"></i>
            </span>
            <input class="input100" type="password" name="password" required >
            <span class="focus-input100"></span>
        </div>

        <div class="flex-sb-m w-full p-b-48">
            <div class="contact100-form-checkbox">
                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me" {{ old('remember') ? 'checked' : '' }}>
                <label class="label-checkbox100" for="ckb1">
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>

        <div class="container-login100-form-btn">
            <button class="login100-form-btn">
                {{ __('Login') }}
            </button>
        </div>

    </form>
    </div>
</div>
@endsection
