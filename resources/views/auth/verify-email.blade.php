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
                                            <h3 class="text-dark fs-20 fw-medium mb-2">Verify Email</h3>
                                            <p class="text-dark text-capitalize fs-14 mb-0">Please verify your email to continue.</p>
                                        </div>

                                        <div class="text-muted mb-3">
                                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                                        </div>

                                        @if (session('status') == 'verification-link-sent')
                                            <div class="alert alert-success">
                                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                            </div>
                                        @endif

                                        <div class="row g-2 mt-4">
                                            <div class="col-12">
                                                <form method="POST" action="{{ route('verification.send') }}">
                                                    @csrf
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-12">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-light">Log Out</button>
                                                    </div>
                                                </form>
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
