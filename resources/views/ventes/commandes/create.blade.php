<x-app-layout>
    <x-slot name="header">
        <div>
            <h5 class="mb-1">{{ __('Nouvelle commande') }}</h5>
            <p class="text-secondary small mb-0">{{ __('Ventes / Commandes') }}</p>
        </div>
    </x-slot>

    <div class="card adminuiux-card mb-3 mb-lg-4">
        <div class="card-body">
            <form method="POST" action="{{ route('ventes.commandes.store') }}">
                @csrf

                <div class="row gx-3">
                    <div class="col-12 col-md-4">
                        <div class="form-floating mb-3">
                            <select id="client_id" name="client_id" class="form-select" required>
                                <option value="">--</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->nom }}</option>
                                @endforeach
                            </select>
                            <label for="client_id">{{ __('Client') }}</label>
                            @if ($errors->has('client_id'))
                                <div class="text-danger small mt-1">{{ $errors->first('client_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input id="date_commande" name="date_commande" type="date" class="form-control" value="{{ old('date_commande') }}" required />
                            <label for="date_commande">{{ __('Date commande') }}</label>
                            @if ($errors->has('date_commande'))
                                <div class="text-danger small mt-1">{{ $errors->first('date_commande') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-floating mb-3">
                            <select id="statut" name="statut" class="form-select" required>
                                <option value="non_payee" @selected(old('statut') === 'non_payee')>{{ __('non_payee') }}</option>
                                <option value="payee" @selected(old('statut') === 'payee')>{{ __('payee') }}</option>
                            </select>
                            <label for="statut">{{ __('Statut') }}</label>
                            @if ($errors->has('statut'))
                                <div class="text-danger small mt-1">{{ $errors->first('statut') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card adminuiux-card mb-3">
                    <div class="card-header">
                        <div class="row gx-3 align-items-center">
                            <div class="col">
                                <h5 class="mb-0">{{ __('Lignes commande') }}</h5>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-outline-theme btn-sm" onclick="addRow()">
                                    <i class="bi bi-plus-lg me-1"></i>{{ __('Ajouter une ligne') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0" id="linesTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Produit') }}</th>
                                        <th style="width: 160px">{{ __('Quantite') }}</th>
                                        <th class="text-end" style="width: 140px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="produit_id[]" class="form-select" required>
                                                <option value="">--</option>
                                                @foreach ($produits as $produit)
                                                    <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input name="quantite[]" type="number" min="1" class="form-control" required />
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-link btn-sm theme-red" onclick="removeRow(this)">{{ __('Supprimer') }}</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @if ($errors->has('produit_id'))
                            <div class="text-danger small mt-2">{{ $errors->first('produit_id') }}</div>
                        @endif
                        @if ($errors->has('quantite'))
                            <div class="text-danger small mt-2">{{ $errors->first('quantite') }}</div>
                        @endif
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-theme" type="submit">{{ __('Enregistrer') }}</button>
                    <a class="btn btn-link" href="{{ route('ventes.commandes.index') }}">{{ __('Retour') }}</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function addRow() {
                const table = document.getElementById('linesTable').getElementsByTagName('tbody')[0];
                const row = table.rows[0].cloneNode(true);

                row.querySelectorAll('select, input').forEach(el => {
                    el.value = '';
                });

                table.appendChild(row);
            }

            function removeRow(btn) {
                const tbody = document.getElementById('linesTable').getElementsByTagName('tbody')[0];
                if (tbody.rows.length <= 1) {
                    return;
                }
                btn.closest('tr').remove();
            }
        </script>
    @endpush
</x-app-layout>
