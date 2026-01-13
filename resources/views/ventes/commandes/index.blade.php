<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Commandes clients') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Ventes / Commandes') }}</p>
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
                    <h5 class="mb-1">{{ __('Liste') }}</h5>
                    <p class="text-secondary small mb-0">{{ __('Suivi des commandes clients') }}</p>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-outline-theme btn-sm" href="{{ route('exports.commandes') }}">
                            <i class="bi bi-file-earmark-spreadsheet me-1"></i>{{ __('Exporter Excel') }}
                        </a>
                        <a class="btn btn-outline-theme btn-sm" href="{{ route('exports.commande_details') }}">
                            <i class="bi bi-file-earmark-spreadsheet me-1"></i>{{ __('Exporter details Excel') }}
                        </a>
                        <a class="btn btn-theme btn-sm" href="{{ route('ventes.commandes.create') }}">
                            <i class="bi bi-plus-lg me-1"></i>{{ __('Nouvelle commande') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-sm align-middle mb-0 dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>{{ __('Facture') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Client') }}</th>
                            <th>{{ __('Total HT') }}</th>
                            <th>{{ __('Total TTC') }}</th>
                            <th>{{ __('Statut') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commandes as $commande)
                            <tr>
                                <td>{{ $commande->invoice_number ?? ('#'.$commande->id) }}</td>
                                <td>{{ $commande->date_commande?->format('Y-m-d') }}</td>
                                <td>{{ $commande->client?->nom }}</td>
                                <td>{{ number_format($commande->total_ht, 2) }}</td>
                                <td>{{ number_format($commande->total_ttc, 2) }}</td>
                                <td>{{ $commande->statut }}</td>
                                <td class="text-end">
                                    <a class="btn btn-link btn-sm" href="{{ route('ventes.commandes.show', $commande) }}">{{ __('Voir') }}</a>
                                    <a class="btn btn-link btn-sm" href="{{ route('ventes.commandes.edit', $commande) }}">{{ __('Modifier') }}</a>
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
                    order: [[1, 'desc']],
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
