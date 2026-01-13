<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Details entree') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Stock') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="small text-secondary">{{ __('Date') }}</div>
                    <div class="fw-semibold">{{ $entree->date_entree?->format('Y-m-d') }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small text-secondary">{{ __('Quantite') }}</div>
                    <div class="fw-semibold">{{ $entree->qte_entree }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small text-secondary">{{ __('Produit') }}</div>
                    <div class="fw-semibold">{{ $entree->produit?->nom }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small text-secondary">{{ __('Fournisseur') }}</div>
                    <div class="fw-semibold">{{ $entree->fournisseur?->nom }}</div>
                </div>
                <div class="col-12">
                    <div class="small text-secondary">{{ __('Numero bon commande') }}</div>
                    <div class="fw-semibold">{{ $entree->num_bon_commande }}</div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4 flex-wrap">
                <a class="btn btn-theme btn-sm" href="{{ route('stock.entrees.edit', $entree) }}">
                    <i class="bi bi-pencil-square me-1"></i>{{ __('Modifier') }}
                </a>
                <form class="d-inline" method="POST" action="{{ route('stock.entrees.destroy', $entree) }}" onsubmit="return confirm('Archiver cette entree ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-theme btn-sm" type="submit">
                        <i class="bi bi-archive me-1"></i>{{ __('Archiver') }}
                    </button>
                </form>
                <a class="btn btn-link btn-sm" href="{{ route('stock.entrees.index') }}">{{ __('Retour') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
