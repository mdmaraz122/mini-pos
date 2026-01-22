<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | Mini POS</title>
    {{--General CSS Files--}}
    <link rel="stylesheet" href="{{ asset('assets/backend/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/bundles/bootstrap-social/bootstrap-social.css') }}">
    {{--Template CSS--}}
    <link rel="stylesheet" href="{{ asset('assets/backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/components.css') }}">
    {{--Custom style CSS--}}
    <link rel="stylesheet" href="{{ asset('assets/backend/css/custom.css') }}">
    <link rel='icon' type="image/png" href='{{ asset('assets/images/favicon.png') }}' />
    {{--Toastify CSS--}}
    <link rel="stylesheet" href="{{ asset('assets/css/toastify.min.css') }}">
</head>
<body id="auth">
<div class="loader"></div>
@yield('content')
{{--General JS Scripts--}}
<script src="{{ asset('assets/backend/js/app.min.js') }}"></script>
{{--Axios--}}
<script src="{{ asset('assets/js/axios.min.js') }}"></script>
{{--Toastify JS--}}
<script src="{{ asset('assets/js/toastify-js.js') }}"></script>
{{--Template JS File--}}
<script src="{{ asset('assets/backend/js/scripts.js') }}"></script>
{{--Custom Config File--}}
<script src="{{ asset('assets/js/custom-config.js') }}"></script>
</body>
</html>
