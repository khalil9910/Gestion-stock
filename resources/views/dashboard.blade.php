<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Dashboard') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Statistiques') }}</p>
        </div>
    </x-slot>

    <div class="row gx-3 gx-lg-4">
        <div class="col-12 col-md-6 col-lg-6 col-xxl-3">
            <div class="card adminuiux-card mb-3 mb-lg-4 theme-blue">
                <div class="card-body">
                    <div class="row gx-3 gx-lg-4 align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-60 h5 bg-theme-1-subtle text-theme-1 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                        <div class="col">
                            <p class="text-secondary small mb-1">{{ __('Produits') }}</p>
                            <h5 class="mb-0">{{ $productsCount }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xxl-3">
            <div class="card adminuiux-card mb-3 mb-lg-4 theme-yellow">
                <div class="card-body">
                    <div class="row gx-3 gx-lg-4 align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-60 h5 bg-theme-1-subtle text-theme-1 theme-yellow rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-boxes"></i>
                            </div>
                        </div>
                        <div class="col">
                            <p class="text-secondary small mb-1">{{ __('Valeur stock (achat HT)') }}</p>
                            <h5 class="mb-0">{{ number_format($stockValue, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xxl-3">
            <div class="card adminuiux-card mb-3 mb-lg-4 theme-green">
                <div class="card-body">
                    <div class="row gx-3 gx-lg-4 align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-60 h5 bg-theme-1-subtle theme-green text-theme-1 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                        </div>
                        <div class="col">
                            <p class="text-secondary small mb-1">{{ __('Benefice total (ventes HT)') }}</p>
                            <h5 class="mb-0">{{ number_format($totalProfit, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xxl-3">
            <div class="card adminuiux-card mb-3 mb-lg-4 theme-red">
                <div class="card-body">
                    <div class="row gx-3 gx-lg-4 align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-60 h5 bg-theme-1-subtle text-theme-1 theme-red rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="col">
                            <p class="text-secondary small mb-1">{{ __('Ruptures / reappro') }}</p>
                            <h5 class="mb-0">{{ $rupturesCount }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gx-3 gx-lg-4">
        <div class="col-12 col-lg-6">
            <div class="card adminuiux-card mb-3 mb-lg-4">
                <div class="card-header">
                    <div class="row gx-3">
                        <div class="col">
                            <h5 class="mb-1">{{ __('Produits les plus vendus') }}</h5>
                            <p class="text-secondary small mb-0">{{ __('Top 5 (quantité)') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="height-160">
                        <canvas id="topVentesChart"></canvas>
                    </div>

                    <div class="mt-3">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('Produit') }}</th>
                                    <th class="text-end">{{ __('Quantite') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topLabels as $i => $label)
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td class="text-end">{{ $topQuantities[$i] ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card adminuiux-card mb-3 mb-lg-4">
                <div class="card-header">
                    <div class="row gx-3">
                        <div class="col">
                            <h5 class="mb-1">{{ __('Evolution mensuelle') }}</h5>
                            <p class="text-secondary small mb-0">{{ __('12 mois: ventes HT/TTC + benefice') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="height-160">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            const topLabels = @json($topLabels);
            const topQuantities = @json($topQuantities);

            const monthlyLabels = @json($monthlyLabels);
            const monthlySalesHt = @json($monthlySalesHt);
            const monthlySalesTtc = @json($monthlySalesTtc);
            const monthlyProfitSeries = @json($monthlyProfitSeries);

            const ctx = document.getElementById('topVentesChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: topLabels,
                        datasets: [{
                            label: 'Quantite vendue',
                            data: topQuantities,
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }

            const monthlyCtx = document.getElementById('monthlyChart');
            if (monthlyCtx) {
                new Chart(monthlyCtx, {
                    type: 'line',
                    data: {
                        labels: monthlyLabels,
                        datasets: [
                            {
                                label: 'Ventes HT',
                                data: monthlySalesHt,
                                borderWidth: 2,
                                tension: 0.2,
                            },
                            {
                                label: 'Ventes TTC',
                                data: monthlySalesTtc,
                                borderWidth: 2,
                                tension: 0.2,
                            },
                            {
                                label: 'Benefice',
                                data: monthlyProfitSeries,
                                borderWidth: 2,
                                tension: 0.2,
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: {
                                beginAtZero: true,
                            }
                        }
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
