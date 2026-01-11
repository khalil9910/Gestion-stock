<?php

namespace App\Exports;

use App\Models\CommandeDetail;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CommandeDetailsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query(): Builder
    {
        return CommandeDetail::query()
            ->join('commandes', 'commande_details.commande_id', '=', 'commandes.id')
            ->join('clients', 'commandes.client_id', '=', 'clients.id')
            ->join('produits', 'commande_details.produit_id', '=', 'produits.id')
            ->select([
                'commande_details.id',
                'commandes.id as commande_id',
                'commandes.invoice_number',
                'commandes.date_commande',
                'clients.nom as client_nom',
                'produits.reference as produit_reference',
                'produits.nom as produit_nom',
                'commande_details.quantite',
                'commande_details.prix_unitaire',
            ])
            ->orderByDesc('commandes.date_commande');
    }

    public function headings(): array
    {
        return [
            'Commande ID',
            'Facture',
            'Date',
            'Client',
            'Produit ref',
            'Produit',
            'Quantite',
            'Prix unitaire HT',
            'Total HT',
        ];
    }

    /** @param object $row */
    public function map($row): array
    {
        $qte = (int) $row->quantite;
        $prix = (float) $row->prix_unitaire;

        return [
            (int) $row->commande_id,
            $row->invoice_number,
            is_string($row->date_commande) ? $row->date_commande : null,
            $row->client_nom,
            $row->produit_reference,
            $row->produit_nom,
            $qte,
            $prix,
            $qte * $prix,
        ];
    }
}
