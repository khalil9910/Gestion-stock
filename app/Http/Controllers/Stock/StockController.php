<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(): View
    {
        Stock::syncAllFromMovements();
        $stocks = Stock::query()->with('produit')->orderByDesc('updated_at')->get();

        return view('stock.index', compact('stocks'));
    }
}
