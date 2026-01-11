<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Modifier categorie') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Administration') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="{{ old('nom', $category->nom) }}" required>
                    <label for="nom">{{ __('Nom') }}</label>
                    @if ($errors->has('nom'))
                        <div class="text-danger small mt-1">{{ $errors->first('nom') }}</div>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 120px">{{ old('description', $category->description) }}</textarea>
                    <label for="description">{{ __('Description') }}</label>
                    @if ($errors->has('description'))
                        <div class="text-danger small mt-1">{{ $errors->first('description') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">{{ __('Image') }}</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    @if ($category->image_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$category->image_path) }}" alt="{{ $category->nom }}" style="height: 48px; width: 48px; object-fit: cover;" class="rounded border">
                        </div>
                    @endif
                    @if ($errors->has('image'))
                        <div class="text-danger small mt-1">{{ $errors->first('image') }}</div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-theme" type="submit">{{ __('Mettre a jour') }}</button>
                    <a class="btn btn-link" href="{{ route('admin.categories.index') }}">{{ __('Retour') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
