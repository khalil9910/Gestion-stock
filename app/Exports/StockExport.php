<?php

namespace App\Exports;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockExport implements FromQuery, WithHeadings, WithMapping
{
    public function query(): Builder
    {
        return Stock::query()->with('produit')->orderBy('produit_id');
    }

    public function headings(): array
    {
        return [
            'Produit',
            'Qte reelle',
            'Qte min',
            'Statut',
            'Prix achat HT',
            'Prix vente HT',
            'Valeur stock (achat HT)',
        ];
    }

    /** @param Stock $row */
    public function map($row): array
    {
        $prixAchat = (float) ($row->produit?->prix_achat_ht ?? 0);
        $prixVente = (float) ($row->produit?->prix_vente_ht ?? 0);
        $qte = (int) $row->qte_reelle;

        return [
            $row->produit?->nom,
            $qte,
            (int) ($row->produit?->qte_min ?? 0),
            $row->statut_stock,
            $prixAchat,
            $prixVente,
            $qte * $prixAchat,
        ];
    }
}
