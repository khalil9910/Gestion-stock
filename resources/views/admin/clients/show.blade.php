<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Client') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <div class="row gx-3 gx-lg-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="border rounded p-3">
                        <div class="text-secondary small">{{ __('Nom') }}</div>
                        <div class="fw-semibold">{{ $client->nom }}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 mt-3 mt-sm-0">
                    <div class="border rounded p-3">
                        <div class="text-secondary small">{{ __('Type') }}</div>
                        <div class="fw-semibold">{{ $client->type_client }}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 mt-3 mt-lg-0">
                    <div class="border rounded p-3">
                        <div class="text-secondary small">{{ __('Email') }}</div>
                        <div class="fw-semibold">{{ $client->email }}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 mt-3 mt-lg-0">
                    <div class="border rounded p-3">
                        <div class="text-secondary small">{{ __('Telephone') }}</div>
                        <div class="fw-semibold">{{ $client->telephone }}</div>
                    </div>
                </div>
            </div>

            <div class="border rounded p-3 mt-3">
                <div class="text-secondary small">{{ __('Adresse') }}</div>
                <div class="fw-semibold">{{ $client->adresse }}</div>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-3">
                <a class="btn btn-link" href="{{ route('admin.clients.index') }}">{{ __('Retour liste') }}</a>
                <a class="btn btn-theme" href="{{ route('admin.clients.edit', $client) }}">{{ __('Modifier') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
