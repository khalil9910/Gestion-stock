<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Sorties stock') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Stock') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-header">
            <div class="row gx-3 align-items-center">
                <div class="col">
                    <h5 class="mb-1">{{ __('Historique') }}</h5>
                    <p class="text-secondary small mb-0">{{ __('Mouvements de sortie') }}</p>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-theme btn-sm" href="{{ route('stock.sorties.create') }}">
                            <i class="bi bi-plus-lg me-1"></i>{{ __('Ajouter') }}
                        </a>
                        <a class="btn btn-link btn-sm" href="{{ route('stock.index') }}">{{ __('Retour stock') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Produit') }}</th>
                            <th>{{ __('Client') }}</th>
                            <th>{{ __('Quantite') }}</th>
                            <th>{{ __('BL') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sorties as $sortie)
                            <tr>
                                <td>{{ $sortie->date_sortie?->format('Y-m-d') }}</td>
                                <td>{{ $sortie->produit?->nom }}</td>
                                <td>{{ $sortie->client?->nom }}</td>
                                <td>{{ $sortie->qte_sortie }}</td>
                                <td>{{ $sortie->num_bl }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $sorties->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
