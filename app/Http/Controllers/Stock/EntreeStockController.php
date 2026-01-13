<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\EntreeStock;
use App\Models\Fournisseur;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EntreeStockController extends Controller
{
    public function index(): View
    {
        $entrees = EntreeStock::query()
            ->with(['produit', 'fournisseur'])
            ->orderByDesc('date_entree')
            ->get();

        return view('stock.entrees.index', compact('entrees'));
    }

    public function archive(): View
    {
        $entrees = EntreeStock::query()
            ->with(['produit', 'fournisseur'])
            ->onlyTrashed()
            ->orderByDesc('deleted_at')
            ->get();

        return view('stock.entrees.archive', compact('entrees'));
    }

    public function restore(int $id): RedirectResponse
    {
        $entree = EntreeStock::withTrashed()->findOrFail($id);
        $entree->restore();

        return redirect()->route('stock.entrees.archive');
    }

    public function create(): View
    {
        $produits = Produit::query()->orderBy('nom')->get();
        $fournisseurs = Fournisseur::query()->orderBy('nom')->get();

        return view('stock.entrees.create', compact('produits', 'fournisseurs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'integer', 'exists:produits,id'],
            'fournisseur_id' => ['required', 'integer', 'exists:fournisseurs,id'],
            'qte_entree' => ['required', 'integer', 'min:1'],
            'date_entree' => ['required', 'date'],
            'num_bon_commande' => ['required', 'string', 'max:255'],
        ]);

        EntreeStock::create($data);

        return redirect()->route('stock.entrees.index');
    }

    public function show(EntreeStock $entree): View
    {
        $entree->load(['produit', 'fournisseur']);

        return view('stock.entrees.show', compact('entree'));
    }

    public function edit(EntreeStock $entree): View
    {
        $produits = Produit::query()->orderBy('nom')->get();
        $fournisseurs = Fournisseur::query()->orderBy('nom')->get();

        return view('stock.entrees.edit', compact('entree', 'produits', 'fournisseurs'));
    }

    public function update(Request $request, EntreeStock $entree): RedirectResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'integer', 'exists:produits,id'],
            'fournisseur_id' => ['required', 'integer', 'exists:fournisseurs,id'],
            'qte_entree' => ['required', 'integer', 'min:1'],
            'date_entree' => ['required', 'date'],
            'num_bon_commande' => ['required', 'string', 'max:255'],
        ]);

        $entree->update($data);

        return redirect()->route('stock.entrees.index');
    }

    public function destroy(EntreeStock $entree): RedirectResponse
    {
        $entree->delete();

        return redirect()->route('stock.entrees.index');
    }
}
