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
                                            <a class="auth-logo d-inline-flex align-items-center gap-2" href="{{ url('/') }}">
                                                <img src="{{ asset('admin2/assets/images/gestion-stock.png') }}" alt="Gestion Stock" class="mx-auto" height="48" />
                                                <span class="gs-brand-text">{{ config('app.name', 'Gestion de Stock') }}</span>
                                            </a>
                                        </div>

                                        <div class="auth-title-section mb-3 text-center">
                                            <h3 class="text-dark fs-20 fw-medium mb-2">Reset Password</h3>
                                            <p class="text-dark text-capitalize fs-14 mb-0">Choose a new password.</p>
                                        </div>

                                        <div class="pt-0">
                                            <form method="POST" action="{{ route('password.store') }}" class="my-4">
                                                @csrf

                                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                                <div class="form-group mb-3">
                                                    <label for="emailaddress" class="form-label">Email address</label>
                                                    <input class="form-control" type="email" id="emailaddress" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="Enter your email">
                                                    @if ($errors->has('email'))
                                                        <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                                                    @endif
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input class="form-control" type="password" id="password" name="password" required autocomplete="new-password" placeholder="Enter your password">
                                                    @if ($errors->has('password'))
                                                        <div class="text-danger small mt-1">{{ $errors->first('password') }}</div>
                                                    @endif
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                                                    @if ($errors->has('password_confirmation'))
                                                        <div class="text-danger small mt-1">{{ $errors->first('password_confirmation') }}</div>
                                                    @endif
                                                </div>

                                                <div class="form-group mb-0 row">
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button class="btn btn-primary" type="submit">Reset Password</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
