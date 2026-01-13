<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Details sortie') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Stock') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="small text-secondary">{{ __('Date') }}</div>
                    <div class="fw-semibold">{{ $sortie->date_sortie?->format('Y-m-d') }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small text-secondary">{{ __('Quantite') }}</div>
                    <div class="fw-semibold">{{ $sortie->qte_sortie }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small text-secondary">{{ __('Produit') }}</div>
                    <div class="fw-semibold">{{ $sortie->produit?->nom }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small text-secondary">{{ __('Client') }}</div>
                    <div class="fw-semibold">{{ $sortie->client?->nom }}</div>
                </div>
                <div class="col-12">
                    <div class="small text-secondary">{{ __('Numero BL') }}</div>
                    <div class="fw-semibold">{{ $sortie->num_bl }}</div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4 flex-wrap">
                <a class="btn btn-theme btn-sm" href="{{ route('stock.sorties.edit', $sortie) }}">
                    <i class="bi bi-pencil-square me-1"></i>{{ __('Modifier') }}
                </a>
                <form class="d-inline" method="POST" action="{{ route('stock.sorties.destroy', $sortie) }}" onsubmit="return confirm('Archiver cette sortie ?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-theme btn-sm" type="submit">
                        <i class="bi bi-archive me-1"></i>{{ __('Archiver') }}
                    </button>
                </form>
                <a class="btn btn-link btn-sm" href="{{ route('stock.sorties.index') }}">{{ __('Retour') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
