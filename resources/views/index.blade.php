<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Also want these pretty website previews?" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    {{-- <meta property="og:image" content="" /> --}}

    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <!-- 引入样式 -->

    <title>{{ config('app.name') }}</title>
    <base href="{{url('/')}}">

    <link rel="shortcut icon" href="{{url('favicon.ico')}}" />

<style>
        [v-cloak] { display: none;}
    </style>

</head>

<body>
    <div v-cloak id="app"></div>
</body>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" charset="utf-8" defer></script>

</html>