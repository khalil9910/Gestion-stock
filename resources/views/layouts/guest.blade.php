<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('admin/assets/img/favicon.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&amp;family=Roboto:ital,wdth,wght@0,75..100,100..900;1,75..100,100..900&amp;display=swap" rel="stylesheet">
        <style>
            :root {
                --adminuiux-content-font: "Roboto", sans-serif;
                --adminuiux-content-font-weight: 400;
                --adminuiux-title-font: "Inter", sans-serif;
                --adminuiux-title-font-weight: 500;
            }
        </style>

        <script defer src="{{ asset('admin/assets/js/appaebc.js') }}"></script>
        <script defer src="{{ asset('admin/assets/js/thirdpartyaebc.js') }}"></script>
        <link href="{{ asset('admin/assets/css/appaebc.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
    <body class="main-bg main-bg-opac adminuiux-header-standard adminuiux-sidebar-standard bg-default adminuiux-header-fill-white adminuiux-sidebar-fill-theme scrollup theme-purple" data-theme="theme-purple" data-sidebarfill="adminuiux-sidebar-fill-theme" data-sidebarlayout="adminuiux-sidebar-standard" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0" data-headerlayout="adminuiux-header-standard" data-bggradient="bg-default" data-headerfill="adminuiux-header-fill-white">
        {{ $slot }}

        <script src="{{ asset('admin/assets/js/core/functions.js') }}"></script>
        <script src="{{ asset('admin/assets/js/core/main.js') }}"></script>
        <script src="{{ asset('admin/assets/js/core/responsive.js') }}"></script>
        <script src="{{ asset('admin/assets/js/core/color-scheme.js') }}"></script>

        @stack('scripts')
    </body>
</html>
