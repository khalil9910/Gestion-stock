<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Archive sorties') }}</h5>
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
                    <h5 class="mb-1">{{ __('Liste') }}</h5>
                    <p class="text-secondary small mb-0">{{ __('Elements archives') }}</p>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-link btn-sm" href="{{ route('stock.sorties.index') }}">{{ __('Retour liste') }}</a>
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
                            <th>{{ __('Client') }}</th>
                            <th>{{ __('Quantite') }}</th>
                            <th>{{ __('BL') }}</th>
                            <th>{{ __('Archive le') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sorties as $sortie)
                            <tr>
                                <td>{{ $sortie->date_sortie?->format('Y-m-d') }}</td>
                                <td>{{ $sortie->produit?->nom }}</td>
                                <td>{{ $sortie->client?->nom }}</td>
                                <td>{{ $sortie->qte_sortie }}</td>
                                <td>{{ $sortie->num_bl }}</td>
                                <td>{{ $sortie->deleted_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-end">
                                    <form class="d-inline" method="POST" action="{{ route('stock.sorties.restore', $sortie->id) }}" onsubmit="return confirm('Restaurer cette sortie ?');">
                                        @csrf
                                        <button class="btn btn-link btn-sm" type="submit">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>{{ __('Restore') }}
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
                    order: [[5, 'desc']],
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
