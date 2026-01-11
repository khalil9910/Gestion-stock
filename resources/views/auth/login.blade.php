<x-guest-layout>
    <div class="pageloader">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center text-center h-100">
                <div class="col-12 mb-auto pt-4"></div>
                <div class="col-auto">
                    <img src="{{ asset('admin/assets/img/logo-512.png') }}" alt="" class="height-100 mb-3">
                    <p class="h3 mb-0"><span class="text-gradient">Gestion Stock</span></p>
                    <p class="small text-secondary mb-3"><span class="">Application de gestion de stock</span></p>
                    <div class="loader6 mb-2 mx-auto" style="border-color: var(--adminuiux-theme-2);"></div>
                </div>
                <div class="col-12 mt-auto pb-4">
                    <p class="text-secondary">Chargement de <span class="text-gradient">Gestion Stock</span>...</p>
                </div>
            </div>
        </div>
    </div>

    <header class="adminuiux-header">
        <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img data-bs-img="light" src="{{ asset('admin/assets/img/logo.png') }}" alt="">
                    <img data-bs-img="dark" src="{{ asset('admin/assets/img/logo.png') }}" alt="">
                    <div class="d-block ps-2">
                        <span class="h4">Gestion <span class="fw-bold">Stock</span></span>
                        <p class="company-tagline">Suivi • Vente • Facture • Export</p>
                    </div>
                </a>
                <div class="ms-auto"></div>
            </div>
        </nav>
    </header>

    <div class="adminuiux-wrap">
        <main class="adminuiux-content">
            <div class="container-fluid">
                <div class="row minheight-dynamic" style="--mih-dynamic: calc(100vh - 108px - env(safe-area-inset-bottom) - env(safe-area-inset-top))">
                    <div class="col-12 col-md-6 col-xl-6">
                        <div class="row h-100 align-items-center justify-content-center">
                            <div class="col-12 col-sm-8 col-md-11 col-xl-11 col-xxl-10 login-box py-3">
                                <div class="text-center mb-4">
                                    <h2 class="mb-1 text-theme-1">Login</h2>
                                    <p class="text-secondary">Take a deep dive into the new modern era</p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="emailadd" placeholder="Enter email address" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                                        <label for="emailadd">Email Address</label>
                                        @if ($errors->has('email'))
                                            <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <div class="position-relative password-wrapper">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control passwordtoggle" id="passwd" placeholder="Enter your password" name="password" required autocomplete="current-password">
                                            <label for="passwd">Password</label>
                                            @if ($errors->has('password'))
                                                <div class="text-danger small mt-1">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-square btn-link text-theme-1 position-absolute end-0 top-0 mt-2 me-2 viewpasswordtoggle">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                    <div class="row gx-3 align-items-center mb-3">
                                        <div class="col py-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="rememberme" @checked(old('remember'))>
                                                <label class="form-check-label" for="rememberme">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="btn btn-link">Forgot Password?</a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row gx-3 align-items-center mb-4">
                                        <div class="col">
                                            <button type="submit" class="btn btn-lg btn-theme w-100">Login</button>
                                        </div>
                                        <div class="col">
                                            <a href="{{ route('register') }}" class="btn btn-lg btn-link w-100">Signup <i class="bi bi-chevron-right"></i></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 px-0 d-none d-md-block">
                        <div class="swiper h-100 swipernav">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide bg-theme-1 theme-indigo">
                                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute z-index-0 opacity-50">
                                        <img src="{{ asset('admin/assets/img/background-image/backgorund-image-5.jpg') }}" alt="">
                                    </div>
                                    <div class="row gx-0 justify-content-center align-items-center text-center h-100 z-index-1 position-relative">
                                        <div class="col-11 col-md-8 col-lg-7">
                                            <h1 class="display-4 mb-4">Suivi simple et clair</h1>
                                            <p>Centralisez produits, stock, ventes et factures dans une seule application.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide bg-theme-1 theme-blue">
                                    <div class="coverimg h-100 w-100 top-0 start-0 position-absolute z-index-0 opacity-50">
                                        <img src="{{ asset('admin/assets/img/background-image/backgorund-image-10.jpg') }}" alt="">
                                    </div>
                                    <div class="row gx-0 justify-content-center align-items-center text-center h-100 z-index-1 position-relative">
                                        <div class="col-11 col-md-8 col-lg-7">
                                            <h1 class="display-4 mb-4">Gagnez du temps au quotidien</h1>
                                            <p>Exports Excel, impression/PDF et tableaux de bord pour mieux piloter.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
        <script src="{{ asset('admin/assets/js/adminuiux/adminux-auth.js') }}"></script>
    @endpush
</x-guest-layout>
