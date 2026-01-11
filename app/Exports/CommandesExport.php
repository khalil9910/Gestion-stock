<?php

namespace App\Exports;

use App\Models\Commande;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CommandesExport implements FromQuery, WithHeadings, WithMapping
{
    public function query(): Builder
    {
        return Commande::query()->with('client')->orderByDesc('date_commande');
    }

    public function headings(): array
    {
        return [
            'Facture',
            'Date',
            'Client',
            'Total HT',
            'Total TTC',
            'Statut',
        ];
    }

    /** @param Commande $row */
    public function map($row): array
    {
        return [
            $row->invoice_number,
            $row->date_commande?->format('Y-m-d'),
            $row->client?->nom,
            (float) $row->total_ht,
            (float) $row->total_ttc,
            $row->statut,
        ];
    }
}
