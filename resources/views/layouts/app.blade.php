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

        <style>
            .btn-theme{
                background-color: var(--bs-primary);
                border-color: var(--bs-primary);
                color: #fff;
            }
            .btn-theme:hover,
            .btn-theme:focus{
                background-color: rgba(var(--bs-primary-rgb), .9);
                border-color: rgba(var(--bs-primary-rgb), .9);
                color: #fff;
            }
            .btn-outline-theme{
                color: var(--bs-primary);
                border-color: var(--bs-primary);
                background-color: transparent;
            }
            .btn-outline-theme:hover,
            .btn-outline-theme:focus{
                color: #fff;
                background-color: var(--bs-primary);
                border-color: var(--bs-primary);
            }
            .theme-red{ color: var(--bs-danger) !important; }
            .text-theme-1{ color: var(--bs-primary) !important; }
            .bg-theme-1-subtle{ background-color: var(--bs-primary-bg-subtle) !important; }
            .text-gradient{
                background: linear-gradient(90deg, var(--bs-primary), var(--bs-info));
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                color: transparent;
            }
            .adminuiux-card{
                border: 0;
                box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
            }
            .avatar{
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .avatar-60{ width: 60px; height: 60px; }
            .avatar-40{ width: 40px; height: 40px; }
            .avatar-30{ width: 30px; height: 30px; }
            .height-160{ height: 160px; }
            .login-box{ width: 100%; }
            .card.theme-blue,
            .adminuiux-card.theme-blue{ border-left: 3px solid var(--bs-info); }
            .card.theme-green,
            .adminuiux-card.theme-green{ border-left: 3px solid var(--bs-success); }
            .card.theme-yellow,
            .adminuiux-card.theme-yellow{ border-left: 3px solid var(--bs-warning); }
            .card.theme-red,
            .adminuiux-card.theme-red{ border-left: 3px solid var(--bs-danger); }
            .bg-theme-2{ background-color: var(--bs-info) !important; }
        </style>
    </head>

    <body data-menu-color="light" data-sidebar="default">
        <div id="app-layout">
            <div class="topbar-custom">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                            <li>
                                <button class="button-toggle-menu nav-link" type="button">
                                    <i data-feather="menu" class="noti-icon"></i>
                                </button>
                            </li>
                        </ul>

                        <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                            <li class="dropdown notification-list topbar-dropdown">
                                <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <div class="avatar avatar-sm rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center">
                                        <span class="fw-semibold text-primary">{{ strtoupper(mb_substr(Auth::user()->name ?? 'U', 0, 1)) }}</span>
                                    </div>
                                    <span class="pro-user-name ms-2">
                                        {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                                    <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">{{ Auth::user()->email }}</h6>
                                    </div>

                                    <a class="dropdown-item notify-item" href="{{ route('profile.edit') }}">
                                        <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                                        <span>Profile</span>
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item notify-item">
                                            <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="app-sidebar-menu">
                <div class="h-100" data-simplebar>
                    <div id="sidebar-menu">
                        <div class="logo-box">
                            <a class="logo logo-light" href="{{ route('dashboard') }}">
                                <span class="logo-sm">
                                    <img src="{{ asset('admin2/assets/images/logo-sm.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('admin2/assets/images/logo-light.png') }}" alt="" height="24">
                                </span>
                            </a>
                            <a class="logo logo-dark" href="{{ route('dashboard') }}">
                                <span class="logo-sm">
                                    <img src="{{ asset('admin2/assets/images/logo-sm.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('admin2/assets/images/logo-dark.png') }}" alt="" height="24">
                                </span>
                            </a>
                        </div>

                        <ul id="side-menu">
                            <li class="menu-title">Menu</li>

                            <li>
                                <a class="tp-link" href="{{ route('dashboard') }}">
                                    <i data-feather="home"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>

                            <li>
                                <a class="tp-link" href="{{ route('stock.index') }}">
                                    <i data-feather="box"></i>
                                    <span> Stock </span>
                                </a>
                            </li>

                            <li>
                                <a class="tp-link" href="{{ route('ventes.commandes.index') }}">
                                    <i data-feather="shopping-cart"></i>
                                    <span> Ventes </span>
                                </a>
                            </li>

                            <li>
                                <a href="#sidebarExports" data-bs-toggle="collapse">
                                    <i data-feather="download"></i>
                                    <span> Exports </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarExports">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a class="tp-link" href="{{ route('exports.stock') }}">Stock Excel</a>
                                        </li>
                                        <li>
                                            <a class="tp-link" href="{{ route('exports.commandes') }}">Commandes Excel</a>
                                        </li>
                                        <li>
                                            <a class="tp-link" href="{{ route('exports.commande_details') }}">Détails Excel</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            @if (auth()->user()->isAdmin())
                                <li>
                                    <a href="#sidebarAdmin" data-bs-toggle="collapse">
                                        <i data-feather="settings"></i>
                                        <span> Admin </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarAdmin">
                                        <ul class="nav-second-level">
                                            <li>
                                                <a class="tp-link" href="{{ route('admin.categories.index') }}">Catégories</a>
                                            </li>
                                            <li>
                                                <a class="tp-link" href="{{ route('admin.produits.index') }}">Produits</a>
                                            </li>
                                            <li>
                                                <a class="tp-link" href="{{ route('admin.clients.index') }}">Clients</a>
                                            </li>
                                            <li>
                                                <a class="tp-link" href="{{ route('admin.fournisseurs.index') }}">Fournisseurs</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        @isset($header)
                            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                                <div class="flex-grow-1">
                                    {{ $header }}
                                </div>
                            </div>
                        @endisset

                        {{ $slot }}
                    </div>
                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col fs-13 text-muted text-center">
                                &copy; {{ date('Y') }} {{ config('app.name', 'Gestion Stock') }}
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

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
