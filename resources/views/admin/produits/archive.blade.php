<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Archive produits') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-header">
            <div class="row gx-3 align-items-center">
                <div class="col">
                    <h5 class="mb-1">{{ __('Liste') }}</h5>
                    <p class="text-secondary small mb-0">{{ __('Elements archives') }}</p>
                </div>
                <div class="col-auto">
                    <a class="btn btn-link" href="{{ route('admin.produits.index') }}">{{ __('Retour liste') }}</a>
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
                            <th>{{ __('Archive le') }}</th>
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
                                <td>{{ $produit->deleted_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-end">
                                    <form class="d-inline" method="POST" action="{{ route('admin.produits.restore', $produit->id) }}" onsubmit="return confirm('Restaurer ce produit ?');">
                                        @csrf
                                        <button class="btn btn-link btn-sm" type="submit">{{ __('Restore') }}</button>
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
