<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Archive clients') }}</h5>
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
                    <a class="btn btn-link" href="{{ route('admin.clients.index') }}">{{ __('Retour liste') }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Nom') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Telephone') }}</th>
                            <th>{{ __('Adresse') }}</th>
                            <th>{{ __('Archive le') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{ $client->nom }}</td>
                                <td>{{ $client->type_client }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->telephone }}</td>
                                <td>{{ $client->adresse }}</td>
                                <td>{{ $client->deleted_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-end">
                                    <form class="d-inline" method="POST" action="{{ route('admin.clients.restore', $client->id) }}" onsubmit="return confirm('Restaurer ce client ?');">
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
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
