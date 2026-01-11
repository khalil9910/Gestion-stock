<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Gestion Stock') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes floaty { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes glow { 0%, 100% { opacity: .35; } 50% { opacity: .65; } }
        .floaty { animation: floaty 6s ease-in-out infinite; }
        .glow { animation: glow 5s ease-in-out infinite; }
        .reveal { opacity: 0; transform: translateY(14px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute -top-20 -left-24 h-72 w-72 rounded-full bg-indigo-500/40 blur-3xl glow"></div>
            <div class="absolute top-40 -right-24 h-72 w-72 rounded-full bg-fuchsia-500/30 blur-3xl glow"></div>
            <div class="absolute -bottom-28 left-1/3 h-80 w-80 rounded-full bg-cyan-400/25 blur-3xl glow"></div>
        </div>

        <header class="relative z-10 max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white/10 border border-white/10 flex items-center justify-center">
                    <span class="text-lg font-bold">GS</span>
                </div>
                <div>
                    <div class="text-sm text-white/70">Samsung Electronics Co., Ltd</div>
                    <div class="text-base font-semibold">Gestion de Stock</div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-lg bg-white text-slate-900 font-medium hover:bg-white/90 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-white/10 border border-white/10 hover:bg-white/15 transition">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-white text-slate-900 font-medium hover:bg-white/90 transition">Créer un compte</a>
                        @endif
                    @endauth
                @endif
            </div>
        </header>

        <main class="relative z-10">
            <section class="max-w-7xl mx-auto px-6 pt-10 pb-16">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 text-xs text-white/80 reveal">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            <span>Application prête: Stock • Ventes • Factures • Exports</span>
                        </div>

                        <h1 class="mt-6 text-4xl sm:text-5xl font-bold leading-tight reveal">
                            Gérez votre stock et vos ventes
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 to-fuchsia-300">sans erreur</span>
                        </h1>

                        <p class="mt-5 text-white/70 text-lg reveal">
                            Suivi des entrées/sorties, commandes clients, factures imprimables/PDF, exports Excel et statistiques.
                        </p>

                        <div class="mt-8 flex flex-col sm:flex-row gap-3 reveal">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-3 rounded-xl bg-white text-slate-900 font-semibold hover:bg-white/90 transition">Accéder au Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-3 rounded-xl bg-white text-slate-900 font-semibold hover:bg-white/90 transition">Se connecter</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-white/10 border border-white/10 hover:bg-white/15 transition">Créer un compte</a>
                                @endif
                            @endauth
                        </div>

                        <div class="mt-10 grid grid-cols-2 gap-4 text-sm text-white/70">
                            <div class="reveal">
                                <div class="font-semibold text-white">TVA & TTC</div>
                                <div>Calcul automatique des totaux</div>
                            </div>
                            <div class="reveal">
                                <div class="font-semibold text-white">Stock réel</div>
                                <div>Entrées / sorties synchronisées</div>
                            </div>
                            <div class="reveal">
                                <div class="font-semibold text-white">Facture</div>
                                <div>Impression + PDF</div>
                            </div>
                            <div class="reveal">
                                <div class="font-semibold text-white">Export</div>
                                <div>Excel (stock / commandes)</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -inset-3 rounded-3xl bg-gradient-to-r from-indigo-500/20 to-fuchsia-500/20 blur-2xl"></div>
                        <div class="relative rounded-3xl border border-white/10 bg-white/5 p-6 floaty">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-white/70">Aperçu</div>
                                <div class="text-xs px-2 py-1 rounded-full bg-emerald-500/15 text-emerald-200 border border-emerald-400/20">Online</div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 gap-4">
                                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                    <div class="text-xs text-white/60">Valeur stock</div>
                                    <div class="mt-2 text-2xl font-semibold">{{ number_format(($stockValue ?? 0), 2) }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                        <div class="text-xs text-white/60">Produits</div>
                                        <div class="mt-2 text-xl font-semibold">{{ $productsCount ?? 0 }}</div>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                        <div class="text-xs text-white/60">Ruptures</div>
                                        <div class="mt-2 text-xl font-semibold">{{ $rupturesCount ?? 0 }}</div>
                                    </div>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                    <div class="text-xs text-white/60">Dernière action</div>
                                    <div class="mt-2 text-sm text-white/80">Commandes, factures, exports — tout est centralisé</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="max-w-7xl mx-auto px-6 pb-16">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6 reveal">
                        <div class="text-lg font-semibold">Gestion produits</div>
                        <div class="mt-2 text-white/70">Catégories, produits, seuil minimum, prix HT/TTC.</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6 reveal">
                        <div class="text-lg font-semibold">Stock & mouvements</div>
                        <div class="mt-2 text-white/70">Entrées fournisseurs, sorties clients, mise à jour automatique du stock.</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6 reveal">
                        <div class="text-lg font-semibold">Ventes & facturation</div>
                        <div class="mt-2 text-white/70">Commandes, numérotation facture, PDF et exports.</div>
                    </div>
                </div>
            </section>

            <footer class="max-w-7xl mx-auto px-6 pb-10 text-sm text-white/50">
                <div class="flex flex-col sm:flex-row gap-3 items-center justify-between border-t border-white/10 pt-6">
                    <div>© {{ date('Y') }} Gestion Stock</div>
                    <div class="flex gap-4">
                        <a class="hover:text-white transition" href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                            <a class="hover:text-white transition" href="{{ route('register') }}">Register</a>
                        @endif
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <script>
        const els = document.querySelectorAll('.reveal');
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
</body>
</html>
