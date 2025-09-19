<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', settings('shop.site_name'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    @include('partials.header')

    <div class="container">
        @yield('content')
    </div>

    @include('partials.footer')

    @livewireScriptConfig
    @stack('scripts')
</body>

</html>
