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
        <div class="pageloader">
            <div class="container h-100">
                <div class="row justify-content-center align-items-center text-center h-100">
                    <div class="col-12 mb-auto pt-4"></div>
                    <div class="col-auto">
                        <img src="{{ asset('admin/assets/img/logo-512.png') }}" alt="" class="height-100 mb-3">
                        <p class="h3 mb-0"><span class="text-gradient">GoTRI</span></p>
                        <p class="small text-secondary mb-3"><span class="">Admin Dashboard HTML Template</span></p>
                        <div class="loader6 mb-2 mx-auto" style="border-color: var(--adminuiux-theme-2);"></div>
                    </div>
                    <div class="col-12 mt-auto pb-4">
                        <p class="text-secondary">Petal of flower being ready to <span class="text-gradient">blossom</span>...</p>
                    </div>
                </div>
            </div>
        </div>

        <header class="adminuiux-header inner-page">
            <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-link btn-square sidebar-toggler ms-1" type="button" onclick="initSidebar()">
                        <i class="sidebar-svg" data-feather="menu"></i>
                    </button>

                    <a class="navbar-brand" href="{{ route('dashboard') }}">
                        <img data-bs-img="light" src="{{ asset('admin/assets/img/logo.png') }}" alt="">
                        <img data-bs-img="dark" src="{{ asset('admin/assets/img/logo.png') }}" alt="">
                        <div class="">
                            <span class="h4">Go<span class="fw-bold">TRI</span></span>
                            <p class="company-tagline">Best HTML template</p>
                        </div>
                    </a>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <div class="dropdown">
                            <a class="btn btn-square btn-link dropdown-toggle no-caret" href="#" id="userdropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="avatar avatar-40 rounded-circle bg-theme-1 text-white d-inline-flex align-items-center justify-content-center">
                                    {{ strtoupper(mb_substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown">
                                <div class="px-3 py-2">
                                    <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                    <div class="small text-secondary">{{ Auth::user()->email }}</div>
                                </div>
                                <div><hr class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <span class="avatar avatar-30 rounded-circle me-1"><i class="bi bi-person"></i></span> Profile
                                </a>
                                <div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item theme-red">
                                            <span class="avatar avatar-30 rounded-circle me-1"><i class="bi bi-power"></i></span> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div class="adminuiux-wrap">
            <div class="adminuiux-sidebar shadow-sm">
                <div class="adminuiux-sidebar-inner">
                    <ul class="nav flex-column menu-active-line mt-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('dashboard') }}">
                                <i class="menu-icon bi bi-house-door"></i>
                                <div class="col menu-name">Dashboard</div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('stock.index') }}">
                                <i class="menu-icon bi bi-box"></i>
                                <div class="col align-self-center menu-name">Stock</div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ventes.commandes.index') }}">
                                <i class="menu-icon bi bi-cart"></i>
                                <div class="col align-self-center menu-name">Ventes</div>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                <i class="menu-icon bi bi-download"></i>
                                <div class="col menu-name">Exports</div>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('exports.stock') }}">
                                        <i class="menu-icon bi bi-file-earmark-spreadsheet"></i>
                                        <div class="col align-self-center menu-name">Stock Excel</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('exports.commandes') }}">
                                        <i class="menu-icon bi bi-file-earmark-spreadsheet"></i>
                                        <div class="col align-self-center menu-name">Commandes Excel</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('exports.commande_details') }}">
                                        <i class="menu-icon bi bi-file-earmark-spreadsheet"></i>
                                        <div class="col align-self-center menu-name">Détails Excel</div>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @if (auth()->user()->isAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                    <i class="menu-icon bi bi-gear"></i>
                                    <div class="col menu-name">Admin</div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.categories.index') }}">
                                            <i class="menu-icon bi bi-tags"></i>
                                            <div class="col align-self-center menu-name">Catégories</div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.produits.index') }}">
                                            <i class="menu-icon bi bi-box-seam"></i>
                                            <div class="col align-self-center menu-name">Produits</div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.clients.index') }}">
                                            <i class="menu-icon bi bi-people"></i>
                                            <div class="col align-self-center menu-name">Clients</div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.fournisseurs.index') }}">
                                            <i class="menu-icon bi bi-truck"></i>
                                            <div class="col align-self-center menu-name">Fournisseurs</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <main class="adminuiux-content has-sidebar" onclick="contentClick()">
                @isset($header)
                    <div class="bg-theme-1-subtle py-3">
                        <div class="container">
                            <div class="row gx-3 gx-lg-4 align-items-center page-title">
                                <div class="col col-sm mb-3 mb-sm-0 order-1">
                                    {{ $header }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset

                <div class="container mt-3 mt-lg-4" id="main-content">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <script src="{{ asset('admin/assets/js/core/functions.js') }}"></script>
        <script src="{{ asset('admin/assets/js/core/main.js') }}"></script>
        <script src="{{ asset('admin/assets/js/core/responsive.js') }}"></script>
        <script src="{{ asset('admin/assets/js/core/color-scheme.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (window.feather) {
                    window.feather.replace();
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>
