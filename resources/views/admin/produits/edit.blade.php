<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Modifier produit') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.produits.update', $produit) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row gx-3">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="reference" name="reference" placeholder="Reference" value="{{ old('reference', $produit->reference) }}" required>
                            <label for="reference">{{ __('Reference') }}</label>
                            @if ($errors->has('reference'))
                                <div class="text-danger small mt-1">{{ $errors->first('reference') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="{{ old('nom', $produit->nom) }}" required>
                            <label for="nom">{{ __('Nom') }}</label>
                            @if ($errors->has('nom'))
                                <div class="text-danger small mt-1">{{ $errors->first('nom') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">{{ __('Image') }}</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    @if ($produit->image_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$produit->image_path) }}" alt="{{ $produit->nom }}" style="height: 48px; width: 48px; object-fit: cover;" class="rounded border">
                        </div>
                    @endif
                    @if ($errors->has('image'))
                        <div class="text-danger small mt-1">{{ $errors->first('image') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <select id="categorie_id" name="categorie_id" class="form-select" required>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('categorie_id', $produit->categorie_id) == $cat->id)>{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                    <label for="categorie_id">{{ __('Categorie') }}</label>
                    @if ($errors->has('categorie_id'))
                        <div class="text-danger small mt-1">{{ $errors->first('categorie_id') }}</div>
                    @endif
                </div>

                <div class="row gx-3">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="number" step="0.01" class="form-control" id="prix_achat_ht" name="prix_achat_ht" placeholder="Prix achat HT" value="{{ old('prix_achat_ht', $produit->prix_achat_ht) }}" required>
                            <label for="prix_achat_ht">{{ __('Prix achat HT') }}</label>
                            @if ($errors->has('prix_achat_ht'))
                                <div class="text-danger small mt-1">{{ $errors->first('prix_achat_ht') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="number" step="0.01" class="form-control" id="prix_vente_ht" name="prix_vente_ht" placeholder="Prix vente HT" value="{{ old('prix_vente_ht', $produit->prix_vente_ht) }}" required>
                            <label for="prix_vente_ht">{{ __('Prix vente HT') }}</label>
                            @if ($errors->has('prix_vente_ht'))
                                <div class="text-danger small mt-1">{{ $errors->first('prix_vente_ht') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row gx-3">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="qte_min" name="qte_min" placeholder="Quantite minimale" value="{{ old('qte_min', $produit->qte_min) }}" required>
                            <label for="qte_min">{{ __('Quantite minimale') }}</label>
                            @if ($errors->has('qte_min'))
                                <div class="text-danger small mt-1">{{ $errors->first('qte_min') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <select id="etat" name="etat" class="form-select" required>
                                <option value="existe" @selected(old('etat', $produit->etat) === 'existe')>{{ __('existe') }}</option>
                                <option value="supprime" @selected(old('etat', $produit->etat) === 'supprime')>{{ __('supprime') }}</option>
                            </select>
                            <label for="etat">{{ __('Etat') }}</label>
                            @if ($errors->has('etat'))
                                <div class="text-danger small mt-1">{{ $errors->first('etat') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-theme" type="submit">{{ __('Mettre a jour') }}</button>
                    <a class="btn btn-link" href="{{ route('admin.produits.index') }}">{{ __('Retour') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
