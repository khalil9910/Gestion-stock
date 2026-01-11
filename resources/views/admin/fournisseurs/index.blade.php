<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Fournisseurs') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-header">
            <div class="row gx-3 align-items-center">
                <div class="col">
                    <h5 class="mb-1">{{ __('Liste') }}</h5>
                    <p class="text-secondary small mb-0">{{ __('Gestion des fournisseurs') }}</p>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-outline-theme btn-sm" href="{{ route('admin.fournisseurs.archive') }}">{{ __('Archive') }}</a>
                        <a class="btn btn-theme btn-sm" href="{{ route('admin.fournisseurs.create') }}">
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
                            <th>{{ __('Nom') }}</th>
                            <th>{{ __('Site') }}</th>
                            <th>{{ __('Telephone') }}</th>
                            <th>{{ __('Mode paiement') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fournisseurs as $fournisseur)
                            <tr>
                                <td>{{ $fournisseur->nom }}</td>
                                <td>{{ $fournisseur->site }}</td>
                                <td>{{ $fournisseur->telephone }}</td>
                                <td>{{ $fournisseur->mode_paiement }}</td>
                                <td class="text-end">
                                    <a class="btn btn-link btn-sm" href="{{ route('admin.fournisseurs.show', $fournisseur) }}">{{ __('Voir') }}</a>
                                    <a class="btn btn-link btn-sm" href="{{ route('admin.fournisseurs.edit', $fournisseur) }}">{{ __('Modifier') }}</a>
                                    <form class="d-inline" method="POST" action="{{ route('admin.fournisseurs.destroy', $fournisseur) }}" onsubmit="return confirm('Archiver ce fournisseur ?');">
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
                {{ $fournisseurs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
