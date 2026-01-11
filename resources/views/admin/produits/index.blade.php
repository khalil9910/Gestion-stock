<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Produits') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-header">
            <div class="row gx-3 align-items-center">
                <div class="col">
                    <h5 class="mb-1">{{ __('Liste') }}</h5>
                    <p class="text-secondary small mb-0">{{ __('Gestion des produits') }}</p>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-outline-theme btn-sm" href="{{ route('admin.produits.archive') }}">{{ __('Archive') }}</a>
                        <a class="btn btn-theme btn-sm" href="{{ route('admin.produits.create') }}">
                            <i class="bi bi-plus-lg me-1"></i>{{ __('Ajouter') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px">{{ __('Image') }}</th>
                            <th>{{ __('Reference') }}</th>
                            <th>{{ __('Nom') }}</th>
                            <th>{{ __('Categorie') }}</th>
                            <th class="text-end">{{ __('Stock') }}</th>
                            <th>{{ __('Prix vente TTC') }}</th>
                            <th>{{ __('Etat') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produits as $produit)
                            <tr>
                                <td>
                                    @if ($produit->image_path)
                                        <img src="{{ asset('storage/'.$produit->image_path) }}" alt="{{ $produit->nom }}" style="height: 40px; width: 40px; object-fit: cover;" class="rounded border">
                                    @endif
                                </td>
                                <td>{{ $produit->reference }}</td>
                                <td>{{ $produit->nom }}</td>
                                <td>{{ $produit->categorie?->nom }}</td>
                                <td class="text-end">{{ $produit->stock?->qte_reelle ?? 0 }}</td>
                                <td>{{ number_format($produit->prix_vente_ttc, 2) }}</td>
                                <td>{{ $produit->etat }}</td>
                                <td class="text-end">
                                    <a class="btn btn-link btn-sm" href="{{ route('admin.produits.show', $produit) }}">{{ __('Voir') }}</a>
                                    <a class="btn btn-link btn-sm" href="{{ route('admin.produits.edit', $produit) }}">{{ __('Modifier') }}</a>
                                    <form class="d-inline" method="POST" action="{{ route('admin.produits.destroy', $produit) }}" onsubmit="return confirm('Archiver ce produit ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-link btn-sm theme-red" type="submit">{{ __('Archiver') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $produits->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
