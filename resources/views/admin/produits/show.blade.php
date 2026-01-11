<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Produit') }} {{ $produit->reference }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <div class="row gx-3 gx-lg-4">
                <div class="col-12 col-md-4">
                    @if ($produit->image_path)
                        <img src="{{ asset('storage/'.$produit->image_path) }}" alt="{{ $produit->nom }}" class="rounded border" style="width: 100%; max-width: 320px; height: auto; object-fit: cover;">
                    @endif
                </div>

                <div class="col-12 col-md-8 mt-3 mt-md-0">
                    <div class="row gx-3 gx-lg-4">
                        <div class="col-12 col-sm-6">
                            <div class="border rounded p-3">
                                <div class="text-secondary small">{{ __('Nom') }}</div>
                                <div class="fw-semibold">{{ $produit->nom }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <div class="border rounded p-3">
                                <div class="text-secondary small">{{ __('Categorie') }}</div>
                                <div class="fw-semibold">{{ $produit->categorie?->nom }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mt-3">
                            <div class="border rounded p-3">
                                <div class="text-secondary small">{{ __('Stock') }}</div>
                                <div class="fw-semibold">{{ $produit->stock?->qte_reelle ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mt-3">
                            <div class="border rounded p-3">
                                <div class="text-secondary small">{{ __('Etat') }}</div>
                                <div class="fw-semibold">{{ $produit->etat }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border rounded p-3 mt-3">
                <div class="fw-semibold mb-2">{{ __('Prix') }}</div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Prix achat HT') }}</th>
                                <th>{{ __('Prix vente HT') }}</th>
                                <th>{{ __('Prix vente TTC') }}</th>
                                <th class="text-end">{{ __('Qte min') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ number_format((float) $produit->prix_achat_ht, 2) }}</td>
                                <td>{{ number_format((float) $produit->prix_vente_ht, 2) }}</td>
                                <td>{{ number_format((float) $produit->prix_vente_ttc, 2) }}</td>
                                <td class="text-end">{{ $produit->qte_min }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-3">
                <a class="btn btn-link" href="{{ route('admin.produits.index') }}">{{ __('Retour liste') }}</a>
                <a class="btn btn-theme" href="{{ route('admin.produits.edit', $produit) }}">{{ __('Modifier') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
