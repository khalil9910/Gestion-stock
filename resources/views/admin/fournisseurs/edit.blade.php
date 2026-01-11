<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Modifier fournisseur') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.fournisseurs.update', $fournisseur) }}">
                @csrf
                @method('PUT')

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="{{ old('nom', $fournisseur->nom) }}" required>
                    <label for="nom">{{ __('Nom') }}</label>
                    @if ($errors->has('nom'))
                        <div class="text-danger small mt-1">{{ $errors->first('nom') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="site" name="site" placeholder="Site" value="{{ old('site', $fournisseur->site) }}">
                    <label for="site">{{ __('Site') }}</label>
                    @if ($errors->has('site'))
                        <div class="text-danger small mt-1">{{ $errors->first('site') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Telephone" value="{{ old('telephone', $fournisseur->telephone) }}">
                    <label for="telephone">{{ __('Telephone') }}</label>
                    @if ($errors->has('telephone'))
                        <div class="text-danger small mt-1">{{ $errors->first('telephone') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <select id="mode_paiement" name="mode_paiement" class="form-select" required>
                        <option value="cheque" @selected(old('mode_paiement', $fournisseur->mode_paiement) === 'cheque')>{{ __('cheque') }}</option>
                        <option value="virement" @selected(old('mode_paiement', $fournisseur->mode_paiement) === 'virement')>{{ __('virement') }}</option>
                    </select>
                    <label for="mode_paiement">{{ __('Mode paiement') }}</label>
                    @if ($errors->has('mode_paiement'))
                        <div class="text-danger small mt-1">{{ $errors->first('mode_paiement') }}</div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-theme" type="submit">{{ __('Mettre a jour') }}</button>
                    <a class="btn btn-link" href="{{ route('admin.fournisseurs.index') }}">{{ __('Retour') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
