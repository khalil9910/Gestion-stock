<x-guest-layout>
    <div class="account-page">
        <div class="container-fluid p-0">
            <div class="row align-items-center g-0">
                <div class="col-xl-5">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="card p-3 mb-0">
                                <div class="card-body">
                                    <div class="mb-0 border-0 p-md-5 p-lg-0 p-4">
                                        <div class="mb-4 p-0 text-center">
                                            <a class="auth-logo" href="{{ url('/') }}">
                                                <img src="{{ asset('admin2/assets/images/logo-dark.png') }}" alt="logo" class="mx-auto" height="28" />
                                            </a>
                                        </div>

                                        <div class="auth-title-section mb-3 text-center">
                                            <h3 class="text-dark fs-20 fw-medium mb-2">Welcome back</h3>
                                            <p class="text-dark text-capitalize fs-14 mb-0">Sign in to continue to {{ config('app.name', 'Gestion Stock') }}.</p>
                                        </div>

                                        @if (session('status'))
                                            <div class="alert alert-success">{{ session('status') }}</div>
                                        @endif

                                        <div class="pt-0">
                                            <form method="POST" action="{{ route('login') }}" class="my-4">
                                                @csrf

                                                <div class="form-group mb-3">
                                                    <label for="emailaddress" class="form-label">Email address</label>
                                                    <input class="form-control" type="email" id="emailaddress" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter your email">
                                                    @if ($errors->has('email'))
                                                        <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                                                    @endif
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input class="form-control" type="password" id="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                                                    @if ($errors->has('password'))
                                                        <div class="text-danger small mt-1">{{ $errors->first('password') }}</div>
                                                    @endif
                                                </div>

                                                <div class="form-group d-flex mb-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" name="remember" id="checkbox-signin" @checked(old('remember'))>
                                                            <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 text-end">
                                                        @if (Route::has('password.request'))
                                                            <a class="text-muted fs-14" href="{{ route('password.request') }}">Forgot password?</a>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0 row">
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button class="btn btn-primary" type="submit">Log In</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            @if (Route::has('register'))
                                                <div class="text-center text-muted mb-4">
                                                    <p class="mb-0">Don't have an account ?<a class="text-primary ms-2 fw-medium" href="{{ route('register') }}">Sign up</a></p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7">
                    <div class="account-page-bg p-md-5 p-4">
                        <div class="text-center">
                            <div class="auth-image">
                                <img src="{{ asset('admin2/assets/images/auth-images.svg') }}" class="mx-auto img-fluid" alt="images">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
