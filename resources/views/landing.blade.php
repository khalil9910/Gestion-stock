<x-guest-layout>
    <style>
        @keyframes gs-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes gs-glow {
            0%, 100% { opacity: .25; }
            50% { opacity: .55; }
        }
        .gs-float { animation: gs-float 6s ease-in-out infinite; }
        .gs-glow { animation: gs-glow 4.5s ease-in-out infinite; }
        .gs-reveal { opacity: 0; transform: translateY(14px); transition: opacity .7s ease, transform .7s ease; }
        .gs-reveal.is-visible { opacity: 1; transform: translateY(0); }
    </style>

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

                <div class="ms-auto d-flex align-items-center gap-2">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-theme">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-link">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-theme">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <div class="adminuiux-wrap">
        <main class="adminuiux-content">
            <div class="container-fluid">
                <div class="row minheight-dynamic align-items-center" style="--mih-dynamic: calc(100vh - 108px - env(safe-area-inset-bottom) - env(safe-area-inset-top))">
                    <div class="col-12 col-lg-6 py-4 py-lg-5">
                        <div class="gs-reveal">
                            <span class="badge text-bg-light text-theme-1 border">Application de gestion de stock</span>
                        </div>

                        <h1 class="display-5 fw-bold mt-3 gs-reveal">
                            Gérez votre stock et vos ventes
                            <span class="text-gradient">sans erreurs</span>
                        </h1>

                        <p class="text-secondary fs-5 mt-3 gs-reveal">
                            Catégories, produits, entrées/sorties, commandes clients, factures PDF, exports Excel.
                        </p>

                        <div class="d-flex flex-column flex-sm-row gap-2 mt-4 gs-reveal">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-lg btn-theme">Accéder au Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-lg btn-theme">Se connecter</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-lg btn-outline-primary">Créer un compte</a>
                                    @endif
                                @endauth
                            @endif
                        </div>

                        <div class="row g-3 mt-4">
                            <div class="col-12 col-sm-6 gs-reveal">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="avatar avatar-40 rounded-circle bg-theme-1 text-white d-inline-flex align-items-center justify-content-center">
                                                <i class="bi bi-box-seam"></i>
                                            </span>
                                            <div>
                                                <div class="fw-semibold">Produits & catégories</div>
                                                <div class="small text-secondary">Prix HT/TTC, seuil minimum</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 gs-reveal">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="avatar avatar-40 rounded-circle bg-theme-2 text-white d-inline-flex align-items-center justify-content-center">
                                                <i class="bi bi-graph-up"></i>
                                            </span>
                                            <div>
                                                <div class="fw-semibold">Stock en temps réel</div>
                                                <div class="small text-secondary">Entrées / sorties synchronisées</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 gs-reveal">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="avatar avatar-40 rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center">
                                                <i class="bi bi-receipt"></i>
                                            </span>
                                            <div>
                                                <div class="fw-semibold">Factures</div>
                                                <div class="small text-secondary">Impression + PDF</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 gs-reveal">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="avatar avatar-40 rounded-circle bg-warning text-white d-inline-flex align-items-center justify-content-center">
                                                <i class="bi bi-file-earmark-spreadsheet"></i>
                                            </span>
                                            <div>
                                                <div class="fw-semibold">Exports</div>
                                                <div class="small text-secondary">Excel (stock, commandes)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 py-4 py-lg-5">
                        <div class="position-relative overflow-hidden rounded-4 shadow-sm gs-float">
                            <div class="coverimg h-100 w-100 top-0 start-0 position-absolute z-index-0 opacity-50">
                                <img src="{{ asset('admin/assets/img/background-image/backgorund-image-10.jpg') }}" alt="">
                            </div>
                            <div class="position-absolute top-0 start-0 w-100 h-100 gs-glow" style="background: radial-gradient(circle at 20% 20%, rgba(107, 65, 210, .45), transparent 55%), radial-gradient(circle at 90% 60%, rgba(243, 30, 135, .25), transparent 55%);"></div>

                            <div class="position-relative p-4 p-lg-5 z-index-1">
                                <div class="d-flex align-items-center justify-content-between gs-reveal">
                                    <div>
                                        <div class="small text-white-50">Aperçu</div>
                                        <div class="h4 text-white mb-0">Dashboard</div>
                                    </div>
                                    <span class="badge text-bg-success">Online</span>
                                </div>

                                <div class="row g-3 mt-3">
                                    <div class="col-12 gs-reveal">
                                        <div class="card border-0 bg-white bg-opacity-10 text-white">
                                            <div class="card-body">
                                                <div class="small text-white-50">Objectif</div>
                                                <div class="h5 mb-0">Tout centraliser: Stock • Ventes • Factures</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 gs-reveal">
                                        <div class="card border-0 bg-white bg-opacity-10 text-white">
                                            <div class="card-body">
                                                <div class="small text-white-50">Produits</div>
                                                <div class="h4 mb-0">—</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 gs-reveal">
                                        <div class="card border-0 bg-white bg-opacity-10 text-white">
                                            <div class="card-body">
                                                <div class="small text-white-50">Alertes</div>
                                                <div class="h4 mb-0">—</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="py-4 text-center text-secondary small">
                    &copy; {{ date('Y') }} Gestion Stock
                </footer>
            </div>
        </main>
    </div>

    @push('scripts')
        <script>
            const els = document.querySelectorAll('.gs-reveal');
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('is-visible');
                        io.unobserve(e.target);
                    }
                });
            }, { threshold: 0.12 });
            els.forEach(el => io.observe(el));
        </script>
    @endpush
</x-guest-layout>
