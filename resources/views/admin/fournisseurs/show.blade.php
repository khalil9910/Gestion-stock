<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Fournisseur') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <div class="row gx-3 gx-lg-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="border rounded p-3">
                        <div class="text-secondary small">{{ __('Nom') }}</div>
                        <div class="fw-semibold">{{ $fournisseur->nom }}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 mt-3 mt-sm-0">
                    <div class="border rounded p-3">
                        <div class="text-secondary small">{{ __('Site') }}</div>
                        <div class="fw-semibold">{{ $fournisseur->site }}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 mt-3 mt-lg-0">
                    <div class="border rounded p-3">
                        <div class="text-secondary small">{{ __('Telephone') }}</div>
                        <div class="fw-semibold">{{ $fournisseur->telephone }}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 mt-3 mt-lg-0">
                    <div class="border rounded p-3">
                        <div class="text-secondary small">{{ __('Mode paiement') }}</div>
                        <div class="fw-semibold">{{ $fournisseur->mode_paiement }}</div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-3">
                <a class="btn btn-link" href="{{ route('admin.fournisseurs.index') }}">{{ __('Retour liste') }}</a>
                <a class="btn btn-theme" href="{{ route('admin.fournisseurs.edit', $fournisseur) }}">{{ __('Modifier') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
