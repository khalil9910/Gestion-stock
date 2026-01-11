<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Facture') }} {{ $commande->invoice_number ?? ('#'.$commande->id) }}</h5>
            <p class="text-secondary small mb-0">{{ __('Ventes') }}</p>
        </div>
    </x-slot>

    <div class="row gx-3 gx-lg-4">
        <div class="col-12 col-xl-10">
            <div class="card adminuiux-card mb-3 mb-lg-4">
                <div class="card-body">
                    <div class="row gx-3 gx-lg-4 align-items-start">
                        <div class="col-12 col-md">
                            <div class="fw-semibold">Samsung Electronics Co., Ltd (S.A)</div>
                            <div class="text-secondary small">16677, Corée du Sud</div>
                            <div class="text-secondary small">+82 31-200-1114</div>
                            <div class="text-secondary small">SIRET: 124-81-00998</div>
                            <div class="text-secondary small">TVA: 20%</div>
                        </div>

                        <div class="col-12 col-md-auto text-md-end mt-3 mt-md-0">
                            <div class="text-secondary small">{{ __('Facture') }}</div>
                            <div class="h5 mb-1">{{ $commande->invoice_number ?? ('#'.$commande->id) }}</div>
                            <div class="text-secondary small">{{ __('Date') }}: {{ $commande->date_commande?->format('Y-m-d') }}</div>
                            <div class="text-secondary small">{{ __('Statut') }}: {{ $commande->statut }}</div>
                        </div>
                    </div>

                    <hr>

                    <div class="row gx-3 gx-lg-4">
                        <div class="col-12 col-lg-6">
                            <div class="border rounded p-3">
                                <div class="text-secondary small">{{ __('Client') }}</div>
                                <div class="fw-semibold">{{ $commande->client?->nom }}</div>
                                @if ($commande->client?->adresse)
                                    <div class="text-secondary small">{{ $commande->client->adresse }}</div>
                                @endif
                                @if ($commande->client?->telephone)
                                    <div class="text-secondary small">{{ $commande->client->telephone }}</div>
                                @endif
                                @if ($commande->client?->email)
                                    <div class="text-secondary small">{{ $commande->client->email }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 border rounded p-3">
                        <div class="fw-semibold mb-2">{{ __('Lignes') }}</div>

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

                    <div class="row gx-3 gx-lg-4 justify-content-end mt-3">
                        <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                            <div class="border rounded p-3">
                                <div class="d-flex justify-content-between">
                                    <div class="text-secondary small">{{ __('Total HT') }}</div>
                                    <div class="fw-semibold">{{ number_format($commande->total_ht, 2) }}</div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <div class="text-secondary small">{{ __('TVA (20%)') }}</div>
                                    <div class="fw-semibold">{{ number_format($commande->total_ttc - $commande->total_ht, 2) }}</div>
                                </div>
                                <div class="border-top pt-2 mt-2 d-flex justify-content-between">
                                    <div class="text-secondary small">{{ __('Total TTC') }}</div>
                                    <div class="h5 mb-0">{{ number_format($commande->total_ttc, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <button type="button" class="btn btn-theme" onclick="window.print()">{{ __('Imprimer') }}</button>
                        <a class="btn btn-outline-theme" href="{{ route('ventes.commandes.facture.pdf', $commande) }}">{{ __('Télécharger PDF') }}</a>
                        <a class="btn btn-link" href="{{ route('ventes.commandes.show', $commande) }}">{{ __('Retour commande') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
