<x-guest-layout>
    @push('styles')
        <style>
            .gs-reveal{ opacity: 0; transform: translateY(14px); transition: opacity .8s ease, transform .8s ease; }
            .gs-reveal.is-visible{ opacity: 1; transform: translateY(0); }

            .gs-hero{
                position: relative;
                overflow: hidden;
                border-radius: 1.25rem;
                background: radial-gradient(1200px 600px at 10% 10%, rgba(13,110,253,.20), transparent 60%),
                    radial-gradient(900px 500px at 90% 35%, rgba(25,135,84,.14), transparent 55%),
                    linear-gradient(135deg, rgba(255,255,255,.85), rgba(255,255,255,.60));
                backdrop-filter: blur(10px);
                border: 1px solid rgba(0,0,0,.06);
            }

            .gs-blob{
                position: absolute;
                width: 420px;
                height: 420px;
                border-radius: 999px;
                filter: blur(40px);
                opacity: .55;
                pointer-events: none;
                transform: translate3d(0,0,0);
            }

            .gs-blob-1{ left: -160px; top: -180px; background: rgba(13,110,253,.35); animation: gs-blob 18s ease-in-out infinite; }
            .gs-blob-2{ right: -180px; top: -120px; background: rgba(111,66,193,.28); animation: gs-blob 22s ease-in-out infinite reverse; }
            .gs-blob-3{ left: 15%; bottom: -220px; background: rgba(25,135,84,.20); animation: gs-blob 26s ease-in-out infinite; }

            @keyframes gs-blob{
                0%{ transform: translate3d(0,0,0) scale(1); }
                33%{ transform: translate3d(35px, -25px, 0) scale(1.08); }
                66%{ transform: translate3d(-25px, 30px, 0) scale(.95); }
                100%{ transform: translate3d(0,0,0) scale(1); }
            }

            .gs-float{ animation: gs-float 7s ease-in-out infinite; }
            @keyframes gs-float{
                0%, 100%{ transform: translateY(0); }
                50%{ transform: translateY(-10px); }
            }

            .gs-card{
                border: 1px solid rgba(0,0,0,.06);
                box-shadow: 0 .125rem .25rem rgba(0,0,0,.06);
                transition: transform .25s ease, box-shadow .25s ease;
            }
            .gs-card:hover{
                transform: translateY(-4px);
                box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.10);
            }

            .gs-icon{
                width: 44px;
                height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                background: rgba(13,110,253,.12);
                color: #0d6efd;
            }

            .gs-metric{
                border: 1px solid rgba(0,0,0,.06);
                background: rgba(255,255,255,.75);
                border-radius: 1rem;
            }

            .gs-shot{
                border-radius: 1.25rem;
                border: 1px solid rgba(0,0,0,.08);
                box-shadow: 0 1.25rem 2.5rem rgba(0,0,0,.12);
                background: linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.70));
                will-change: transform;
                transform: translate3d(0,0,0);
            }

            .gs-brand-text{
                font-weight: 700;
                letter-spacing: .2px;
                background: linear-gradient(90deg, #0d6efd, #20c997, #0d6efd);
                background-size: 220% 100%;
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                animation: gs-brand 3.6s ease-in-out infinite;
            }

            @keyframes gs-brand{
                0%{ background-position: 0% 50%; }
                50%{ background-position: 100% 50%; }
                100%{ background-position: 0% 50%; }
            }
        </style>
    @endpush

    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <img src="{{ asset('admin2/assets/images/gestion-stock.png') }}" alt="Gestion Stock" height="28" />
                <span class="gs-brand-text">Gestion de Stock</span>
            </a>

            <div class="ms-auto d-flex align-items-center gap-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-success">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <div class="container py-4 py-lg-5">
        <div class="gs-hero p-4 p-lg-5 mb-4 mb-lg-5" id="gsHero">
            <div class="gs-blob gs-blob-1"></div>
            <div class="gs-blob gs-blob-2"></div>
            <div class="gs-blob gs-blob-3"></div>

            <div class="row align-items-center position-relative" style="z-index: 1;">
                <div class="col-12 col-lg-6">
                    <span class="badge bg-primary-subtle text-primary mb-3 gs-reveal">Gestion Stock • Ventes • Factures • Exports</span>
                    <h1 class="display-5 fw-bold text-dark mb-3 gs-reveal">Votre gestion de stock en temps réel, claire et rapide</h1>
                    <p class="text-muted fs-5 mb-4 gs-reveal">Un espace moderne pour suivre vos produits, gérer les entrées/sorties, enregistrer les commandes et générer vos factures et exports.</p>

                    <div class="row g-3 mb-4 gs-reveal">
                        <div class="col-12 col-sm-6">
                            <div class="d-flex gap-2 align-items-start">
                                <span class="gs-icon"><i class="bi bi-box-seam"></i></span>
                                <div>
                                    <div class="fw-semibold text-dark">Stock & alertes</div>
                                    <div class="text-muted small">Ruptures, seuils minimum, statut produit</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="d-flex gap-2 align-items-start">
                                <span class="gs-icon" style="background: rgba(25,135,84,.12); color:#198754;"><i class="bi bi-receipt"></i></span>
                                <div>
                                    <div class="fw-semibold text-dark">Commandes & factures</div>
                                    <div class="text-muted small">Suivi client, PDF, numéros de facture</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-2 gs-reveal">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">Accéder au Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Se connecter</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Créer un compte</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>

                <div class="col-12 col-lg-6 mt-4 mt-lg-0">
                    <div class="gs-shot p-3 p-lg-4 gs-reveal gs-float" id="gsParallax">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success-subtle text-success">Online</span>
                                <span class="text-muted small">Aperçu interface</span>
                            </div>
                            <div class="text-muted small">{{ config('app.name', 'Gestion de Stock') }}</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="gs-metric p-3">
                                    <div class="text-muted small">Modules</div>
                                    <div class="fs-3 fw-bold text-dark"><span class="gs-counter" data-count="6">0</span>+</div>
                                    <div class="text-muted small">Stock • Ventes • Exports</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="gs-metric p-3">
                                    <div class="text-muted small">Tables interactives</div>
                                    <div class="fs-3 fw-bold text-dark"><span class="gs-counter" data-count="8">0</span>+</div>
                                    <div class="text-muted small">Recherche & tri</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="gs-metric p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">Statistiques</div>
                                            <div class="fw-semibold text-dark">Charts animés</div>
                                        </div>
                                        <span class="gs-icon" style="background: rgba(111,66,193,.12); color:#6f42c1;"><i class="bi bi-graph-up"></i></span>
                                    </div>
                                    <div class="mt-3" style="height: 120px; border-radius: .75rem; background: linear-gradient(90deg, rgba(13,110,253,.15), rgba(25,135,84,.12));"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 g-lg-4 mb-4 mb-lg-5">
            <div class="col-12 col-lg-4">
                <div class="card gs-card h-100 gs-reveal">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <span class="gs-icon"><i class="bi bi-lightning-charge"></i></span>
                            <span class="badge bg-primary-subtle text-primary">Rapide</span>
                        </div>
                        <h5 class="text-dark">Interface moderne</h5>
                        <p class="text-muted mb-0">UI Admin2 cohérente, buttons animés, tables interactives, et pages claires pour chaque module.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card gs-card h-100 gs-reveal">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <span class="gs-icon" style="background: rgba(25,135,84,.12); color:#198754;"><i class="bi bi-shield-check"></i></span>
                            <span class="badge bg-success-subtle text-success">Fiable</span>
                        </div>
                        <h5 class="text-dark">Données centralisées</h5>
                        <p class="text-muted mb-0">Produits, catégories, clients, fournisseurs et commandes : tout est organisé dans un seul back-office.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card gs-card h-100 gs-reveal">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <span class="gs-icon" style="background: rgba(255,193,7,.18); color:#b58100;"><i class="bi bi-file-earmark-spreadsheet"></i></span>
                            <span class="badge bg-warning-subtle text-warning">Exports</span>
                        </div>
                        <h5 class="text-dark">Exports & factures</h5>
                        <p class="text-muted mb-0">Exports Excel et factures PDF pour gagner du temps, avec une présentation propre et professionnelle.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center g-4 g-lg-5 mb-4 mb-lg-5">
            <div class="col-12 col-lg-6">
                <div class="gs-reveal">
                    <h2 class="fw-bold text-dark mb-3">Présentation</h2>
                    <div class="text-muted mb-4">Un workflow simple: vous créez vos données, vous gérez vos mouvements, et vous suivez tout depuis le dashboard.</div>

                    <div class="d-flex gap-3 mb-3">
                        <span class="gs-icon"><i class="bi bi-1-circle"></i></span>
                        <div>
                            <div class="fw-semibold text-dark">Ajoutez vos produits</div>
                            <div class="text-muted small">Catégories, prix, seuil minimum, image…</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <span class="gs-icon" style="background: rgba(25,135,84,.12); color:#198754;"><i class="bi bi-2-circle"></i></span>
                        <div>
                            <div class="fw-semibold text-dark">Enregistrez entrées/sorties</div>
                            <div class="text-muted small">Mouvements stock, BL/bon de commande, clients & fournisseurs</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <span class="gs-icon" style="background: rgba(111,66,193,.12); color:#6f42c1;"><i class="bi bi-3-circle"></i></span>
                        <div>
                            <div class="fw-semibold text-dark">Commandes & suivi</div>
                            <div class="text-muted small">Factures, statut payé/non payé, statistiques et top produits</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card gs-card gs-reveal">
                    <div class="card-body p-4 p-lg-5">
                        <h4 class="text-dark fw-bold mb-2">Prêt à démarrer ?</h4>
                        <div class="text-muted mb-4">Connectez-vous pour accéder au dashboard et commencer à gérer votre stock.</div>

                        <div class="d-flex flex-column flex-sm-row gap-2">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">Ouvrir le Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Register</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 g-lg-4 mb-4 mb-lg-5">
            <div class="col-12 col-md-4">
                <div class="gs-metric p-4 gs-reveal">
                    <div class="text-muted small">Temps gagné</div>
                    <div class="display-6 fw-bold text-dark"><span class="gs-counter" data-count="35">0</span>%</div>
                    <div class="text-muted small">Automatisation des calculs & exports</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="gs-metric p-4 gs-reveal">
                    <div class="text-muted small">Modules</div>
                    <div class="display-6 fw-bold text-dark"><span class="gs-counter" data-count="10">0</span>+</div>
                    <div class="text-muted small">Stock, ventes, clients, fournisseurs</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="gs-metric p-4 gs-reveal">
                    <div class="text-muted small">Tableaux</div>
                    <div class="display-6 fw-bold text-dark"><span class="gs-counter" data-count="12">0</span>+</div>
                    <div class="text-muted small">Recherche, tri, impression</div>
                </div>
            </div>
        </div>

        <div class="row g-3 g-lg-4 mb-4 mb-lg-5">
            <div class="col-12">
                <div class="card gs-card gs-reveal">
                    <div class="card-body p-4 p-lg-5">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-6">
                                <h2 class="fw-bold text-dark mb-3">Modules principaux</h2>
                                <div class="text-muted mb-4">Tout ce dont vous avez besoin pour une gestion complète.</div>

                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <div class="d-flex gap-2">
                                            <span class="gs-icon"><i class="bi bi-tags"></i></span>
                                            <div>
                                                <div class="fw-semibold text-dark">Catégories</div>
                                                <div class="text-muted small">Organisation rapide</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="d-flex gap-2">
                                            <span class="gs-icon"><i class="bi bi-box"></i></span>
                                            <div>
                                                <div class="fw-semibold text-dark">Produits</div>
                                                <div class="text-muted small">Prix, image, statut</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="d-flex gap-2">
                                            <span class="gs-icon" style="background: rgba(25,135,84,.12); color:#198754;"><i class="bi bi-arrow-down-up"></i></span>
                                            <div>
                                                <div class="fw-semibold text-dark">Entrées/Sorties</div>
                                                <div class="text-muted small">Historique complet</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="d-flex gap-2">
                                            <span class="gs-icon" style="background: rgba(111,66,193,.12); color:#6f42c1;"><i class="bi bi-cart-check"></i></span>
                                            <div>
                                                <div class="fw-semibold text-dark">Commandes</div>
                                                <div class="text-muted small">Statut & factures</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="d-flex gap-2">
                                            <span class="gs-icon" style="background: rgba(255,193,7,.18); color:#b58100;"><i class="bi bi-people"></i></span>
                                            <div>
                                                <div class="fw-semibold text-dark">Clients</div>
                                                <div class="text-muted small">Suivi & emails</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="d-flex gap-2">
                                            <span class="gs-icon" style="background: rgba(0,0,0,.06); color:#111;"><i class="bi bi-truck"></i></span>
                                            <div>
                                                <div class="fw-semibold text-dark">Fournisseurs</div>
                                                <div class="text-muted small">Contacts & paiements</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-4 mt-lg-0">
                                <div class="gs-metric p-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted small">UI</div>
                                            <div class="fw-semibold text-dark">Animations & composants Admin2</div>
                                        </div>
                                        <span class="gs-icon"><i class="bi bi-magic"></i></span>
                                    </div>
                                    <div class="mt-3" style="height: 180px; border-radius: 1rem; background: radial-gradient(600px 200px at 20% 30%, rgba(13,110,253,.18), transparent 55%), radial-gradient(600px 200px at 80% 60%, rgba(25,135,84,.14), transparent 55%), rgba(255,255,255,.55);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 g-lg-4 mb-4 mb-lg-5">
            <div class="col-12">
                <div class="card gs-card gs-reveal">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="fw-bold text-dark mb-3">FAQ</h2>
                        <div class="text-muted mb-4">Questions fréquentes sur la plateforme.</div>

                        <div class="accordion" id="gsFaq">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOneCollapse" aria-expanded="true" aria-controls="faqOneCollapse">
                                        Est-ce que je peux exporter mes données ?
                                    </button>
                                </h2>
                                <div id="faqOneCollapse" class="accordion-collapse collapse show" aria-labelledby="faqOne" data-bs-parent="#gsFaq">
                                    <div class="accordion-body text-muted">Oui, vous avez des exports Excel pour stock, commandes et détails selon les pages.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwoCollapse" aria-expanded="false" aria-controls="faqTwoCollapse">
                                        Les tableaux sont-ils interactifs ?
                                    </button>
                                </h2>
                                <div id="faqTwoCollapse" class="accordion-collapse collapse" aria-labelledby="faqTwo" data-bs-parent="#gsFaq">
                                    <div class="accordion-body text-muted">Oui, toutes les pages de liste utilisent DataTables (recherche, tri, pagination, impression).</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThreeCollapse" aria-expanded="false" aria-controls="faqThreeCollapse">
                                        Est-ce que le dashboard est animé ?
                                    </button>
                                </h2>
                                <div id="faqThreeCollapse" class="accordion-collapse collapse" aria-labelledby="faqThree" data-bs-parent="#gsFaq">
                                    <div class="accordion-body text-muted">Oui, les charts sont en ApexCharts avec animations.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="py-4 text-center text-muted small">&copy; {{ date('Y') }} {{ config('app.name', 'Gestion de Stock') }}</footer>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const els = document.querySelectorAll('.gs-reveal');
                const io = new IntersectionObserver((entries) => {
                    entries.forEach((e) => {
                        if (e.isIntersecting) {
                            e.target.classList.add('is-visible');
                            io.unobserve(e.target);
                        }
                    });
                }, { threshold: 0.12 });
                els.forEach((el) => io.observe(el));

                const hero = document.getElementById('gsHero');
                const parallax = document.getElementById('gsParallax');

                if (hero && parallax) {
                    hero.addEventListener('mousemove', (e) => {
                        const r = hero.getBoundingClientRect();
                        const x = (e.clientX - r.left) / r.width - 0.5;
                        const y = (e.clientY - r.top) / r.height - 0.5;
                        parallax.style.transform = `translate3d(${x * 10}px, ${y * 8}px, 0)`;
                    });

                    hero.addEventListener('mouseleave', () => {
                        parallax.style.transform = 'translate3d(0,0,0)';
                    });
                }

                const counters = document.querySelectorAll('.gs-counter');
                if (counters.length && window.jQuery && window.jQuery.fn && window.jQuery.fn.counterUp) {
                    window.jQuery(counters).counterUp({ delay: 12, time: 900 });
                } else {
                    counters.forEach((el) => {
                        const target = Number(el.getAttribute('data-count') || '0');
                        let current = 0;
                        const step = Math.max(1, Math.round(target / 30));
                        const tick = () => {
                            current = Math.min(target, current + step);
                            el.textContent = String(current);
                            if (current < target) {
                                window.requestAnimationFrame(tick);
                            }
                        };
                        tick();
                    });
                }
            });
        </script>
    @endpush
</x-guest-layout>
