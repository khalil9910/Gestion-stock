<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facture</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        .muted { color: #6b7280; }
        .header { margin-bottom: 18px; }
        .row { width: 100%; }
        .col { display: inline-block; vertical-align: top; }
        .col-left { width: 60%; }
        .col-right { width: 39%; text-align: right; }
        .box { border: 1px solid #e5e7eb; padding: 10px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-top: 1px solid #e5e7eb; padding: 6px 4px; }
        th { text-align: left; border-top: none; }
        .totals { width: 45%; margin-left: auto; }
        .totals td { border-top: none; }
        .totals .line td { border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="row">
            <div class="col col-left">
                <div style="font-size: 16px; font-weight: 700;">Samsung Electronics Co., Ltd (S.A)</div>
                <div class="muted">16677, Corée du Sud</div>
                <div class="muted">+82 31-200-1114</div>
                <div class="muted">SIRET: 124-81-00998</div>
                <div class="muted">TVA: 20%</div>
            </div>
            <div class="col col-right">
                <div class="muted">Facture</div>
                <div style="font-size: 18px; font-weight: 700;">{{ $commande->invoice_number ?? ('#'.$commande->id) }}</div>
                <div class="muted">Date: {{ $commande->date_commande?->format('Y-m-d') }}</div>
                <div class="muted">Statut: {{ $commande->statut }}</div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="muted">Client</div>
        <div style="font-weight: 700;">{{ $commande->client?->nom }}</div>
        @if ($commande->client?->adresse)
            <div class="muted">{{ $commande->client->adresse }}</div>
        @endif
        @if ($commande->client?->telephone)
            <div class="muted">{{ $commande->client->telephone }}</div>
        @endif
        @if ($commande->client?->email)
            <div class="muted">{{ $commande->client->email }}</div>
        @endif
    </div>

    <div class="box">
        <div style="font-weight: 700; margin-bottom: 8px;">Lignes</div>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantite</th>
                    <th>Prix unitaire HT</th>
                    <th>Total HT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commande->details as $detail)
                    <tr>
                        <td>{{ $detail->produit?->nom }}</td>
                        <td>{{ $detail->quantite }}</td>
                        <td>{{ number_format($detail->prix_unitaire, 2) }}</td>
                        <td>{{ number_format($detail->prix_unitaire * $detail->quantite, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <table class="totals">
        <tr>
            <td class="muted">Total HT</td>
            <td style="text-align:right; font-weight:700;">{{ number_format($commande->total_ht, 2) }}</td>
        </tr>
        <tr>
            <td class="muted">TVA (20%)</td>
            <td style="text-align:right; font-weight:700;">{{ number_format($commande->total_ttc - $commande->total_ht, 2) }}</td>
        </tr>
        <tr class="line">
            <td class="muted">Total TTC</td>
            <td style="text-align:right; font-size:14px; font-weight:700;">{{ number_format($commande->total_ttc, 2) }}</td>
        </tr>
    </table>
</body>
</html>
