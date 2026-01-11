<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Commande') }} {{ $commande->invoice_number ?? ('#'.$commande->id) }}</h5>
            <p class="text-secondary small mb-0">{{ __('Ventes') }}</p>
        </div>
    </x-slot>

    <div class="row gx-3 gx-lg-4">
        <div class="col-12">
            <div class="card adminuiux-card mb-3 mb-lg-4">
                <div class="card-body">
                    <div class="row gx-3 gx-lg-4">
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="border rounded p-3">
                                <div class="text-secondary small">{{ __('Client') }}</div>
                                <div class="fw-semibold">{{ $commande->client?->nom }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 mt-3 mt-sm-0">
                            <div class="border rounded p-3">
                                <div class="text-secondary small">{{ __('Facture') }}</div>
                                <div class="fw-semibold">{{ $commande->invoice_number ?? ('#'.$commande->id) }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2 mt-3 mt-lg-0">
                            <div class="border rounded p-3">
                                <div class="text-secondary small">{{ __('Date') }}</div>
                                <div class="fw-semibold">{{ $commande->date_commande?->format('Y-m-d') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-2 mt-3 mt-lg-0">
                            <div class="border rounded p-3">
                                <div class="text-secondary small">{{ __('Total HT') }}</div>
                                <div class="fw-semibold">{{ number_format($commande->total_ht, 2) }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2 mt-3 mt-lg-0">
                            <div class="border rounded p-3">
                                <div class="text-secondary small">{{ __('Total TTC') }}</div>
                                <div class="fw-semibold">{{ number_format($commande->total_ttc, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded p-3 mt-3">
                        <div class="fw-semibold mb-2">{{ __('Details') }}</div>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Produit') }}</th>
                                        <th class="text-end">{{ __('Quantite') }}</th>
                                        <th class="text-end">{{ __('Prix unitaire HT') }}</th>
                                        <th class="text-end">{{ __('Total HT') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($commande->details as $detail)
                                        <tr>
                                            <td>{{ $detail->produit?->nom }}</td>
                                            <td class="text-end">{{ $detail->quantite }}</td>
                                            <td class="text-end">{{ number_format($detail->prix_unitaire, 2) }}</td>
                                            <td class="text-end">{{ number_format($detail->prix_unitaire * $detail->quantite, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a class="btn btn-link" href="{{ route('ventes.commandes.index') }}">{{ __('Retour liste') }}</a>
                        <a class="btn btn-outline-theme" href="{{ route('ventes.commandes.facture', $commande) }}">{{ __('Facture') }}</a>
                        <a class="btn btn-theme" href="{{ route('ventes.commandes.edit', $commande) }}">{{ __('Modifier') }}</a>
                        <form method="POST" action="{{ route('ventes.commandes.destroy', $commande) }}" onsubmit="return confirm('Supprimer cette commande ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">{{ __('Supprimer') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
