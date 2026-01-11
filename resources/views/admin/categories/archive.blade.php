<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Archive categories') }}</h5>
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
                    <a class="btn btn-link" href="{{ route('admin.categories.index') }}">{{ __('Retour liste') }}</a>
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
                            <th>{{ __('Archive le') }}</th>
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
                                <td>{{ $category->deleted_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-end">
                                    <form class="d-inline" method="POST" action="{{ route('admin.categories.restore', $category->id) }}" onsubmit="return confirm('Restaurer cette categorie ?');">
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
