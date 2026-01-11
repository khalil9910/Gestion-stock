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
                                <div class="text-center mb-4">
                                    <h2 class="mb-1 text-theme-1">Forgot Password</h2>
                                    <p class="text-secondary">Enter your email to receive a reset link</p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="emailadd" placeholder="Enter email address" name="email" value="{{ old('email') }}" required autofocus>
                                        <label for="emailadd">Email Address</label>
                                        @if ($errors->has('email'))
                                            <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>

                                    <div class="row gx-3 align-items-center mb-3">
                                        <div class="col">
                                            <button type="submit" class="btn btn-lg btn-theme w-100">Email Password Reset Link</button>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <a href="{{ route('login') }}" class="btn btn-link">Back to login</a>
                                    </div>
                                </form>
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
