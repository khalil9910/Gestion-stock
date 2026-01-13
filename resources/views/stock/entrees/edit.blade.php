<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Modifier entree') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Stock') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <form method="POST" action="{{ route('stock.entrees.update', $entree) }}">
                @csrf
                @method('PUT')

                <div class="form-floating mb-3">
                    <select id="produit_id" name="produit_id" class="form-select" required>
                        <option value="">--</option>
                        @foreach ($produits as $produit)
                            <option value="{{ $produit->id }}" @selected(old('produit_id', $entree->produit_id) == $produit->id)>{{ $produit->nom }}</option>
                        @endforeach
                    </select>
                    <label for="produit_id">{{ __('Produit') }}</label>
                    @if ($errors->has('produit_id'))
                        <div class="text-danger small mt-1">{{ $errors->first('produit_id') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <select id="fournisseur_id" name="fournisseur_id" class="form-select" required>
                        <option value="">--</option>
                        @foreach ($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id }}" @selected(old('fournisseur_id', $entree->fournisseur_id) == $fournisseur->id)>{{ $fournisseur->nom }}</option>
                        @endforeach
                    </select>
                    <label for="fournisseur_id">{{ __('Fournisseur') }}</label>
                    @if ($errors->has('fournisseur_id'))
                        <div class="text-danger small mt-1">{{ $errors->first('fournisseur_id') }}</div>
                    @endif
                </div>

                <div class="row gx-3">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="qte_entree" name="qte_entree" placeholder="Quantite" value="{{ old('qte_entree', $entree->qte_entree) }}" required>
                            <label for="qte_entree">{{ __('Quantite') }}</label>
                            @if ($errors->has('qte_entree'))
                                <div class="text-danger small mt-1">{{ $errors->first('qte_entree') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="date_entree" name="date_entree" placeholder="Date" value="{{ old('date_entree', $entree->date_entree?->format('Y-m-d')) }}" required>
                            <label for="date_entree">{{ __('Date') }}</label>
                            @if ($errors->has('date_entree'))
                                <div class="text-danger small mt-1">{{ $errors->first('date_entree') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="num_bon_commande" name="num_bon_commande" placeholder="Numero bon commande" value="{{ old('num_bon_commande', $entree->num_bon_commande) }}" required>
                    <label for="num_bon_commande">{{ __('Numero bon commande') }}</label>
                    @if ($errors->has('num_bon_commande'))
                        <div class="text-danger small mt-1">{{ $errors->first('num_bon_commande') }}</div>
                    @endif
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-theme btn-sm" type="submit">
                        <i class="bi bi-check2-circle me-1"></i>{{ __('Enregistrer') }}
                    </button>
                    <a class="btn btn-link btn-sm" href="{{ route('stock.entrees.index') }}">{{ __('Retour') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
