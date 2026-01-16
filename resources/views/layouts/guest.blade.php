<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('meta-desc')" />
    <meta name="og:description" content="@yield('og-desc')" />
    <meta name="og:title" content="@yield('og-title')" />
    <meta name="og:type" content="@yield('og-type')" />
    <meta name="og:image"
        content="https://git.n2rtechnologies.com/uploads/-/system/user/avatar/5/avatar.png?width=192" />
    <meta property="og:url" content="{{ Request::url() }}">
    <meta name="keywords" content="@yield('meta-keywords')" />
    <meta name="twitter:card" content="@yield('og-desc')">
    <meta name="twitter:title" content="@yield('og-title')">
    <meta name="twitter:description" content="@yield('og-desc')">
    <meta name="twitter:image"
        content="https://git.n2rtechnologies.com/uploads/-/system/user/avatar/5/avatar.png?width=192">
    <!-- optional ones -->
    <meta name="twitter:url" content="{{ Request::url() }}">
    <meta content="Hyper" name="author" />
    <link rel="canonical" href="{{ Request::url() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-dark.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    @yield('head')

</head>

<body class="loading" data-layout-config='{"darkMode":false}'>
    @include('guest.includes.navbar')
    @yield('content')
    @include('guest.includes.footer')
    @include('guest.includes.script')
</body>

</html>
