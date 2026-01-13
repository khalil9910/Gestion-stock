<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gestion de Stock') }}</title>

        <link rel="shortcut icon" href="{{ asset('admin2/assets/images/favicon.ico') }}">
        <link href="{{ asset('admin2/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
        <link href="{{ asset('admin2/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        @stack('styles')
    </head>
    <body class="bg-primary-subtle">
        {{ $slot }}

        <script src="{{ asset('admin2/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/js/app.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (window.feather) {
                    window.feather.replace();
                }

                if (window.Waves) {
                    try {
                        window.Waves.init();
                        window.Waves.attach('.btn', ['waves-light']);
                        window.Waves.attach('.nav-link', ['waves-light']);
                    } catch (e) {
                    }
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>
