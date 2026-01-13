<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Dashboard') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Statistiques') }}</p>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-12 col-xl-7">
            <div class="card mb-3 mb-xl-4">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title text-black mb-0">Sales Report</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div id="sales-overview" class="apex-charts"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-5">
            <div class="row g-3">
                <div class="col-md-6 col-xl-6">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="p-2 border border-primary border-opacity-10 bg-primary-subtle rounded-pill me-2">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                        <i class="bi bi-receipt text-white"></i>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15">Total Orders</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-black me-3">{{ number_format($ordersTotal) }}</h3>
                                <div class="text-end">
                                    <span class="{{ $ordersTrendPct >= 0 ? 'text-primary' : 'text-danger' }} fs-14">
                                        <i class="bi {{ $ordersTrendPct >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                        {{ number_format($ordersTrendPct, 1) }}%
                                    </span>
                                    <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                </div>
                            </div>

                            <div class="mt-2" style="height: 44px;">
                                <div id="orders-spark" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-6">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="p-2 border border-secondary border-opacity-10 bg-secondary-subtle rounded-pill me-2">
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                        <i class="bi bi-calendar2-week text-white"></i>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15">Monthly Orders</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-black me-3">{{ number_format($ordersMonthly) }}</h3>
                                <div class="text-center" style="width: 70px; height: 44px;">
                                    <div id="monthly-orders-radial" class="apex-charts"></div>
                                </div>
                            </div>
                            <p class="text-dark fs-13 mb-0">This month</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-6">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="p-2 border border-danger border-opacity-10 bg-danger-subtle rounded-pill me-2">
                                    <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                        <i class="bi bi-currency-dollar text-white"></i>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15">Monthly Revenue</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-black me-3">{{ number_format($revenueMonthlyTtc, 2) }}</h3>
                                <div class="text-end">
                                    <span class="{{ $revenueTrendPct >= 0 ? 'text-primary' : 'text-danger' }} fs-14">
                                        <i class="bi {{ $revenueTrendPct >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                        {{ number_format($revenueTrendPct, 1) }}%
                                    </span>
                                    <p class="text-dark fs-13 mb-0">Last 7 days</p>
                                </div>
                            </div>

                            <div class="mt-2" style="height: 44px;">
                                <div id="revenue-spark" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-6">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="p-2 border border-warning border-opacity-10 bg-warning-subtle rounded-pill me-2">
                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                        <i class="bi bi-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <p class="mb-0 text-dark fs-15">Out of Stock</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 fs-22 text-black me-3">{{ number_format($rupturesCount) }} Items</h3>
                                <div class="text-center" style="width: 70px; height: 44px;">
                                    <div id="outofstock-radial" class="apex-charts"></div>
                                </div>
                            </div>
                            <p class="text-dark fs-13 mb-0">Current</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xl-7">
            <div class="card mb-3 mb-xl-4">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title text-black mb-0">Top Products</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-5">
                            <div style="height: 220px;">
                                <div id="topVentesChart" class="apex-charts"></div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-7 mt-3 mt-lg-0">
                            <div class="table-responsive">
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
            </div>
        </div>

        <div class="col-md-12 col-xl-5">
            <div class="card mb-3 mb-xl-4">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title text-black mb-0">Sales Radar</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div id="sales-radar" class="apex-charts"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin2/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script>
            const ordersSparkLabels = @json($ordersSparkLabels);
            const ordersSparkSeries = @json($ordersSparkSeries);
            const revenueSparkSeries = @json($revenueSparkSeries);
            const ordersMonthlyPct = @json($ordersMonthlyPct);
            const outOfStockPct = @json($outOfStockPct);

            const topLabels = @json($topLabels);
            const topQuantities = @json($topQuantities);

            const monthlyLabels = @json($monthlyLabels);
            const monthlySalesHt = @json($monthlySalesHt);
            const monthlySalesTtc = @json($monthlySalesTtc);
            const monthlyProfitSeries = @json($monthlyProfitSeries);

            const radarLabels = @json($radarLabels);
            const radarSales = @json($radarSales);
            const radarProfit = @json($radarProfit);

            const salesEl = document.querySelector('#sales-overview');
            if (salesEl && window.ApexCharts) {
                const salesChart = new ApexCharts(salesEl, {
                    chart: { type: 'bar', height: 320, toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout', speed: 650 } },
                    series: [{ name: 'Ventes TTC', data: monthlySalesTtc }],
                    xaxis: { categories: monthlyLabels },
                    plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
                    grid: { strokeDashArray: 4 },
                    colors: ['#0d6efd'],
                    dataLabels: { enabled: false },
                    tooltip: { y: { formatter: (v) => `${Number(v).toFixed(2)}` } },
                });
                salesChart.render();
            }

            const sparkBase = {
                chart: { type: 'bar', height: 44, sparkline: { enabled: true }, animations: { enabled: true, easing: 'easeinout', speed: 650 } },
                plotOptions: { bar: { borderRadius: 3, columnWidth: '55%' } },
                dataLabels: { enabled: false },
                tooltip: { enabled: false },
            };

            const ordersSparkEl = document.querySelector('#orders-spark');
            if (ordersSparkEl && window.ApexCharts) {
                new ApexCharts(ordersSparkEl, {
                    ...sparkBase,
                    series: [{ name: 'Orders', data: ordersSparkSeries }],
                    colors: ['#0d6efd'],
                }).render();
            }

            const revenueSparkEl = document.querySelector('#revenue-spark');
            if (revenueSparkEl && window.ApexCharts) {
                new ApexCharts(revenueSparkEl, {
                    ...sparkBase,
                    series: [{ name: 'Revenue', data: revenueSparkSeries }],
                    colors: ['#dc3545'],
                }).render();
            }

            const monthlyOrdersRadialEl = document.querySelector('#monthly-orders-radial');
            if (monthlyOrdersRadialEl && window.ApexCharts) {
                new ApexCharts(monthlyOrdersRadialEl, {
                    chart: { type: 'radialBar', height: 44, sparkline: { enabled: true }, animations: { enabled: true, easing: 'easeinout', speed: 650 } },
                    series: [Number(ordersMonthlyPct || 0)],
                    colors: ['#6c757d'],
                    plotOptions: {
                        radialBar: {
                            hollow: { size: '55%' },
                            dataLabels: { show: false },
                            track: { background: 'rgba(0,0,0,.06)' },
                        },
                    },
                    stroke: { lineCap: 'round' },
                }).render();
            }

            const outOfStockRadialEl = document.querySelector('#outofstock-radial');
            if (outOfStockRadialEl && window.ApexCharts) {
                new ApexCharts(outOfStockRadialEl, {
                    chart: { type: 'radialBar', height: 44, sparkline: { enabled: true }, animations: { enabled: true, easing: 'easeinout', speed: 650 } },
                    series: [Number(outOfStockPct || 0)],
                    colors: ['#f59f00'],
                    plotOptions: {
                        radialBar: {
                            hollow: { size: '55%' },
                            dataLabels: { show: false },
                            track: { background: 'rgba(0,0,0,.06)' },
                        },
                    },
                    stroke: { lineCap: 'round' },
                }).render();
            }

            const topEl = document.querySelector('#topVentesChart');
            if (topEl && window.ApexCharts) {
                const topChart = new ApexCharts(topEl, {
                    chart: {
                        type: 'bar',
                        height: 220,
                        toolbar: { show: false },
                        animations: { enabled: true, easing: 'easeinout', speed: 650 },
                    },
                    series: [{ name: 'Quantite vendue', data: topQuantities }],
                    xaxis: { categories: topLabels, labels: { rotate: -25 } },
                    yaxis: { labels: { formatter: (v) => Math.round(v) } },
                    grid: { strokeDashArray: 4 },
                    plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
                    colors: ['#0d6efd'],
                    dataLabels: { enabled: false },
                    tooltip: { y: { formatter: (v) => `${Math.round(v)}` } },
                });
                topChart.render();
            }

            const radarEl = document.querySelector('#sales-radar');
            if (radarEl && window.ApexCharts) {
                const radarChart = new ApexCharts(radarEl, {
                    chart: { type: 'radar', height: 320, toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout', speed: 650 } },
                    series: [
                        { name: 'Ventes HT', data: radarSales },
                        { name: 'Benefice', data: radarProfit },
                    ],
                    labels: radarLabels,
                    stroke: { width: 2 },
                    fill: { opacity: 0.18 },
                    colors: ['#0d6efd', '#198754'],
                    markers: { size: 3 },
                    yaxis: { labels: { formatter: (v) => Number(v).toFixed(0) } },
                });
                radarChart.render();
            }
        </script>
    @endpush
</x-app-layout>
