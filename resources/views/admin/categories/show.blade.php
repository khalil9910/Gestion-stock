<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Categorie') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <div class="row gx-3 gx-lg-4">
                <div class="col-12 col-md-4">
                    @if ($category->image_path)
                        <img src="{{ asset('storage/'.$category->image_path) }}" alt="{{ $category->nom }}" class="rounded border" style="width: 100%; max-width: 320px; height: auto; object-fit: cover;">
                    @endif
                </div>

                <div class="col-12 col-md-8 mt-3 mt-md-0">
                    <div class="border rounded p-3">
                        <div class="text-secondary small">{{ __('Nom') }}</div>
                        <div class="fw-semibold">{{ $category->nom }}</div>
                    </div>

                    <div class="border rounded p-3 mt-3">
                        <div class="text-secondary small">{{ __('Description') }}</div>
                        <div class="fw-semibold">{{ $category->description }}</div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-3">
                <a class="btn btn-link" href="{{ route('admin.categories.index') }}">{{ __('Retour liste') }}</a>
                <a class="btn btn-theme" href="{{ route('admin.categories.edit', $category) }}">{{ __('Modifier') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
