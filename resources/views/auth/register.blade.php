<x-guest-layout>
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

    <header class="adminuiux-header">
        <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img data-bs-img="light" src="{{ asset('admin/assets/img/logo.png') }}" alt="">
                    <img data-bs-img="dark" src="{{ asset('admin/assets/img/logo.png') }}" alt="">
                    <div class="d-block ps-2">
                        <span class="h4">Go<span class="fw-bold">TRI</span></span>
                        <p class="company-tagline">Best HTML template</p>
                    </div>
                </a>
                <div class="ms-auto"></div>
            </div>
        </nav>
    </header>

    <div class="adminuiux-wrap">
        <main class="adminuiux-content">
            <div class="container-fluid">
                <div class="row justify-content-center minheight-dynamic" style="--mih-dynamic: calc(100vh - 108px - env(safe-area-inset-bottom) - env(safe-area-inset-top))">
                    <div class="col-12 col-md-8 col-xl-6">
                        <div class="row h-100 align-items-center justify-content-center">
                            <div class="col-12 col-sm-8 col-md-11 col-xl-11 col-xxl-10 login-box py-3">
                                <div class="text-center mb-3 mb-lg-4">
                                    <h1 class="mb-1 text-theme-1">Let's get started&#128077;</h1>
                                    <p class="text-secondary">Provide your few details</p>
                                </div>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                                        <label for="name">Name</label>
                                        @if ($errors->has('name'))
                                            <div class="text-danger small mt-1">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="emailadd" placeholder="Enter email address" name="email" value="{{ old('email') }}" required autocomplete="username">
                                        <label for="emailadd">Email Address</label>
                                        @if ($errors->has('email'))
                                            <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <div class="position-relative">
                                        <div class="form-floating mb-2 mb-lg-3">
                                            <input type="password" class="form-control" id="checkstrength" placeholder="Enter your password" name="password" required autocomplete="new-password">
                                            <label for="checkstrength">Password</label>
                                            @if ($errors->has('password'))
                                                <div class="text-danger small mt-1">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-square btn-link text-theme-1 position-absolute end-0 top-0 mt-2 me-2">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                    <div class="position-relative">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="passwd" placeholder="Confirm your password" name="password_confirmation" required autocomplete="new-password">
                                            <label for="passwd">Confirm Password</label>
                                            @if ($errors->has('password_confirmation'))
                                                <div class="text-danger small mt-1">{{ $errors->first('password_confirmation') }}</div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-square btn-link text-theme-1 position-absolute end-0 top-0 mt-2 me-2">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                    <button type="submit" class="btn btn-lg btn-theme w-100 mb-4">Sign up</button>

                                    <div class="text-center">
                                        Already have account? <a href="{{ route('login') }}" class="">Login</a> here.
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
                                            <h1 class="display-4 mb-4">Easy, Unique and Creative multipurpose template</h1>
                                            <p>GoTRI is very unique and flexible with large number of customized components.</p>
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
