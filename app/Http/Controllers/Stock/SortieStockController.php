<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Produit;
use App\Models\SortieStock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SortieStockController extends Controller
{
    public function index(): View
    {
        $sorties = SortieStock::query()
            ->with(['produit', 'client'])
            ->orderByDesc('date_sortie')
            ->paginate(15);

        return view('stock.sorties.index', compact('sorties'));
    }

    public function create(): View
    {
        $produits = Produit::query()->orderBy('nom')->get();
        $clients = Client::query()->orderBy('nom')->get();

        return view('stock.sorties.create', compact('produits', 'clients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'integer', 'exists:produits,id'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'qte_sortie' => ['required', 'integer', 'min:1'],
            'date_sortie' => ['required', 'date'],
            'num_bl' => ['required', 'string', 'max:255'],
        ]);

        try {
            SortieStock::create($data);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['qte_sortie' => $e->getMessage()])->withInput();
        }

        return redirect()->route('stock.sorties.index');
    }
}
