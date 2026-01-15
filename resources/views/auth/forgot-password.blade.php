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
                                            <h3 class="text-dark fs-20 fw-medium mb-2">Recover Password</h3>
                                            <p class="text-dark text-capitalize fs-14 mb-0">Enter your email to receive a reset link.</p>
                                        </div>

                                        @if (session('status'))
                                            <div class="alert alert-success">{{ session('status') }}</div>
                                        @endif

                                        <div class="pt-0">
                                            <form method="POST" action="{{ route('password.email') }}" class="my-4">
                                                @csrf

                                                <div class="form-group mb-3">
                                                    <label for="emailaddress" class="form-label">Email address</label>
                                                    <input class="form-control" type="email" id="emailaddress" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                                                    @if ($errors->has('email'))
                                                        <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                                                    @endif
                                                </div>

                                                <div class="form-group mb-0 row">
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button class="btn btn-primary" type="submit">Recover Password</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="text-center text-muted">
                                                <p class="mb-0">Change your mind ?<a class="text-primary ms-2 fw-medium" href="{{ route('login') }}">Back to Login</a></p>
                                            </div>
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
