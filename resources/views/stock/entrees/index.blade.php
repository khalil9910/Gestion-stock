<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Entrees stock') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Stock') }}</p>
        </div>
    </x-slot>

    @push('styles')
        <link href="{{ asset('admin2/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin2/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin2/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-header">
            <div class="row gx-3 align-items-center">
                <div class="col">
                    <h5 class="mb-1">{{ __('Historique') }}</h5>
                    <p class="text-secondary small mb-0">{{ __('Mouvements d\'entree') }}</p>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-outline-theme btn-sm" href="{{ route('stock.entrees.archive') }}">
                            <i class="bi bi-archive me-1"></i>{{ __('Archive') }}
                        </a>
                        <a class="btn btn-theme btn-sm" href="{{ route('stock.entrees.create') }}">
                            <i class="bi bi-plus-lg me-1"></i>{{ __('Ajouter') }}
                        </a>
                        <a class="btn btn-link btn-sm" href="{{ route('stock.index') }}">{{ __('Retour stock') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-sm align-middle mb-0 dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Produit') }}</th>
                            <th>{{ __('Fournisseur') }}</th>
                            <th>{{ __('Quantite') }}</th>
                            <th>{{ __('Bon commande') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entrees as $entree)
                            <tr>
                                <td>{{ $entree->date_entree?->format('Y-m-d') }}</td>
                                <td>{{ $entree->produit?->nom }}</td>
                                <td>{{ $entree->fournisseur?->nom }}</td>
                                <td>{{ $entree->qte_entree }}</td>
                                <td>{{ $entree->num_bon_commande }}</td>
                                <td class="text-end">
                                    <a class="btn btn-link btn-sm" href="{{ route('stock.entrees.show', $entree) }}">
                                        <i class="bi bi-eye me-1"></i>{{ __('Voir') }}
                                    </a>
                                    <a class="btn btn-link btn-sm" href="{{ route('stock.entrees.edit', $entree) }}">
                                        <i class="bi bi-pencil-square me-1"></i>{{ __('Modifier') }}
                                    </a>
                                    <form class="d-inline" method="POST" action="{{ route('stock.entrees.destroy', $entree) }}" onsubmit="return confirm('Archiver cette entree ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-link btn-sm theme-red" type="submit">
                                            <i class="bi bi-archive me-1"></i>{{ __('Archiver') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin2/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('admin2/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const table = $('#datatable-buttons');
                if (!table.length) return;

                const dt = table.DataTable({
                    responsive: true,
                    pageLength: 10,
                    lengthChange: true,
                    order: [[0, 'desc']],
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                        "<'row'<'col-sm-12 col-md-6'B>>",
                    buttons: ['copy', 'print'],
                });

                dt.buttons().container().addClass('mt-2');
            });
        </script>
    @endpush
</x-app-layout>
