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
            ->get();

        return view('stock.sorties.index', compact('sorties'));
    }

    public function archive(): View
    {
        $sorties = SortieStock::query()
            ->with(['produit', 'client'])
            ->onlyTrashed()
            ->orderByDesc('deleted_at')
            ->get();

        return view('stock.sorties.archive', compact('sorties'));
    }

    public function restore(int $id): RedirectResponse
    {
        $sortie = SortieStock::withTrashed()->findOrFail($id);

        try {
            $sortie->restore();
        } catch (\RuntimeException $e) {
            return back()->withErrors(['qte_sortie' => $e->getMessage()]);
        }

        return redirect()->route('stock.sorties.archive');
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

    public function show(SortieStock $sortie): View
    {
        $sortie->load(['produit', 'client']);

        return view('stock.sorties.show', compact('sortie'));
    }

    public function edit(SortieStock $sortie): View
    {
        $produits = Produit::query()->orderBy('nom')->get();
        $clients = Client::query()->orderBy('nom')->get();

        return view('stock.sorties.edit', compact('sortie', 'produits', 'clients'));
    }

    public function update(Request $request, SortieStock $sortie): RedirectResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'integer', 'exists:produits,id'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'qte_sortie' => ['required', 'integer', 'min:1'],
            'date_sortie' => ['required', 'date'],
            'num_bl' => ['required', 'string', 'max:255'],
        ]);

        try {
            $sortie->update($data);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['qte_sortie' => $e->getMessage()])->withInput();
        }

        return redirect()->route('stock.sorties.index');
    }

    public function destroy(SortieStock $sortie): RedirectResponse
    {
        $sortie->delete();

        return redirect()->route('stock.sorties.index');
    }
}
