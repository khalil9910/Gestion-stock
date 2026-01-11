<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Categories') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-header">
            <div class="row gx-3 align-items-center">
                <div class="col">
                    <h5 class="mb-1">{{ __('Liste') }}</h5>
                    <p class="text-secondary small mb-0">{{ __('Gestion des categories') }}</p>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-outline-theme btn-sm" href="{{ route('admin.categories.archive') }}">{{ __('Archive') }}</a>
                        <a class="btn btn-theme btn-sm" href="{{ route('admin.categories.create') }}">
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
                            <th>{{ __('Nom') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    @if ($category->image_path)
                                        <img src="{{ asset('storage/'.$category->image_path) }}" alt="{{ $category->nom }}" style="height: 40px; width: 40px; object-fit: cover;" class="rounded border">
                                    @endif
                                </td>
                                <td>{{ $category->nom }}</td>
                                <td>{{ $category->description }}</td>
                                <td class="text-end">
                                    <a class="btn btn-link btn-sm" href="{{ route('admin.categories.show', $category) }}">{{ __('Voir') }}</a>
                                    <a class="btn btn-link btn-sm" href="{{ route('admin.categories.edit', $category) }}">{{ __('Modifier') }}</a>
                                    <form class="d-inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Archiver cette categorie ?');">
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
