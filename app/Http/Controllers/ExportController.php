<?php

namespace App\Http\Controllers;

use App\Exports\CommandeDetailsExport;
use App\Exports\CommandesExport;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function stock(): BinaryFileResponse
    {
        return Excel::download(new StockExport(), 'stock.xlsx');
    }

    public function commandes(): BinaryFileResponse
    {
        return Excel::download(new CommandesExport(), 'commandes.xlsx');
    }

    public function commandeDetails(): BinaryFileResponse
    {
        return Excel::download(new CommandeDetailsExport(), 'commande_details.xlsx');
    }
}
