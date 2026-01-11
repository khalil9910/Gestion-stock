<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Ajouter client') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.clients.store') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="{{ old('nom') }}" required>
                    <label for="nom">{{ __('Nom') }}</label>
                    @if ($errors->has('nom'))
                        <div class="text-danger small mt-1">{{ $errors->first('nom') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse" value="{{ old('adresse') }}">
                    <label for="adresse">{{ __('Adresse') }}</label>
                    @if ($errors->has('adresse'))
                        <div class="text-danger small mt-1">{{ $errors->first('adresse') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Telephone" value="{{ old('telephone') }}">
                    <label for="telephone">{{ __('Telephone') }}</label>
                    @if ($errors->has('telephone'))
                        <div class="text-danger small mt-1">{{ $errors->first('telephone') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <select id="type_client" name="type_client" class="form-select" required>
                        <option value="Solvable" @selected(old('type_client') === 'Solvable')>{{ __('Solvable') }}</option>
                        <option value="Non solvable" @selected(old('type_client') === 'Non solvable')>{{ __('Non solvable') }}</option>
                        <option value="Litigieux" @selected(old('type_client') === 'Litigieux')>{{ __('Litigieux') }}</option>
                    </select>
                    <label for="type_client">{{ __('Type client') }}</label>
                    @if ($errors->has('type_client'))
                        <div class="text-danger small mt-1">{{ $errors->first('type_client') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    <label for="email">{{ __('Email') }}</label>
                    @if ($errors->has('email'))
                        <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-theme" type="submit">{{ __('Enregistrer') }}</button>
                    <a class="btn btn-link" href="{{ route('admin.clients.index') }}">{{ __('Retour') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
