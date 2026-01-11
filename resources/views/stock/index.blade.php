<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Stock') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Etat du stock') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-header">
            <div class="row gx-3 align-items-center">
                <div class="col">
                    <h5 class="mb-1">{{ __('Etat du stock') }}</h5>
                    <p class="text-secondary small mb-0">{{ __('Quantites disponibles par produit') }}</p>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-outline-theme btn-sm" href="{{ route('exports.stock') }}">
                            <i class="bi bi-file-earmark-spreadsheet me-1"></i>{{ __('Exporter Excel') }}
                        </a>
                        <a class="btn btn-link btn-sm" href="{{ route('stock.entrees.index') }}">{{ __('Entrees') }}</a>
                        <a class="btn btn-link btn-sm" href="{{ route('stock.sorties.index') }}">{{ __('Sorties') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Produit') }}</th>
                            <th>{{ __('Qte reelle') }}</th>
                            <th>{{ __('Qte min') }}</th>
                            <th>{{ __('Statut') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stocks as $stock)
                            <tr>
                                <td>{{ $stock->produit?->nom }}</td>
                                <td>{{ $stock->qte_reelle }}</td>
                                <td>{{ $stock->produit?->qte_min }}</td>
                                <td>{{ $stock->statut_stock }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $stocks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
