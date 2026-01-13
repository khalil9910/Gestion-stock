<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Modifier sortie') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Stock') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <form method="POST" action="{{ route('stock.sorties.update', $sortie) }}">
                @csrf
                @method('PUT')

                <div class="form-floating mb-3">
                    <select id="produit_id" name="produit_id" class="form-select" required>
                        <option value="">--</option>
                        @foreach ($produits as $produit)
                            <option value="{{ $produit->id }}" @selected(old('produit_id', $sortie->produit_id) == $produit->id)>{{ $produit->nom }}</option>
                        @endforeach
                    </select>
                    <label for="produit_id">{{ __('Produit') }}</label>
                    @if ($errors->has('produit_id'))
                        <div class="text-danger small mt-1">{{ $errors->first('produit_id') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <select id="client_id" name="client_id" class="form-select" required>
                        <option value="">--</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" @selected(old('client_id', $sortie->client_id) == $client->id)>{{ $client->nom }}</option>
                        @endforeach
                    </select>
                    <label for="client_id">{{ __('Client') }}</label>
                    @if ($errors->has('client_id'))
                        <div class="text-danger small mt-1">{{ $errors->first('client_id') }}</div>
                    @endif
                </div>

                <div class="row gx-3">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="qte_sortie" name="qte_sortie" placeholder="Quantite" value="{{ old('qte_sortie', $sortie->qte_sortie) }}" required>
                            <label for="qte_sortie">{{ __('Quantite') }}</label>
                            @if ($errors->has('qte_sortie'))
                                <div class="text-danger small mt-1">{{ $errors->first('qte_sortie') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="date_sortie" name="date_sortie" placeholder="Date" value="{{ old('date_sortie', $sortie->date_sortie?->format('Y-m-d')) }}" required>
                            <label for="date_sortie">{{ __('Date') }}</label>
                            @if ($errors->has('date_sortie'))
                                <div class="text-danger small mt-1">{{ $errors->first('date_sortie') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="num_bl" name="num_bl" placeholder="Numero BL" value="{{ old('num_bl', $sortie->num_bl) }}" required>
                    <label for="num_bl">{{ __('Numero BL') }}</label>
                    @if ($errors->has('num_bl'))
                        <div class="text-danger small mt-1">{{ $errors->first('num_bl') }}</div>
                    @endif
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-theme btn-sm" type="submit">
                        <i class="bi bi-check2-circle me-1"></i>{{ __('Enregistrer') }}
                    </button>
                    <a class="btn btn-link btn-sm" href="{{ route('stock.sorties.index') }}">{{ __('Retour') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
