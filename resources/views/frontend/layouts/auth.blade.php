<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('page-title') | {{ Setting::get('app_name') }}</title>

    @yield('before-styles-end')
        {!! Html::style(elixir('css/dashboard.css')) !!}
    @yield('after-styles-end')
</head>
<body class="hold-transition login-page">
    @include('partials/messages')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ url('assets/img/easyadmin-logo.png') }}" alt="{{ Setting::get('app_name') }}">
        </div>

        <div class="login-box-body">
        @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    @yield('before-scripts-end')
    {!! Html::script(elixir('js/dashboard.js')) !!}
    {!! Html::script('vendor/jsvalidation/js/jsvalidation.js') !!}
    @yield('after-scripts-end')
</body>
</html>
