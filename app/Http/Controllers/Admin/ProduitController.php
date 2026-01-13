<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProduitController extends Controller
{
    public function index(): View
    {
        $produits = Produit::query()->with(['categorie', 'stock'])->orderBy('nom')->get();

        return view('admin.produits.index', compact('produits'));
    }

    public function create(): View
    {
        $categories = Categorie::query()->orderBy('nom')->get();

        return view('admin.produits.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'reference' => ['required', 'string', 'max:255', 'unique:produits,reference'],
            'nom' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
            'prix_achat_ht' => ['required', 'numeric', 'min:0'],
            'prix_vente_ht' => ['required', 'numeric', 'min:0'],
            'qte_min' => ['required', 'integer', 'min:0'],
            'etat' => ['required', 'in:existe,supprime'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($data);

        return redirect()->route('admin.produits.index');
    }

    public function show(Produit $produit): View
    {
        $produit->load(['categorie', 'stock']);

        return view('admin.produits.show', compact('produit'));
    }

    public function archive(): View
    {
        $produits = Produit::query()
            ->with(['categorie', 'stock'])
            ->onlyTrashed()
            ->orderByDesc('deleted_at')
            ->get();

        return view('admin.produits.archive', compact('produits'));
    }

    public function restore(int $id): RedirectResponse
    {
        $produit = Produit::withTrashed()->findOrFail($id);
        $produit->restore();

        return redirect()->route('admin.produits.archive');
    }

    public function edit(Produit $produit): View
    {
        $categories = Categorie::query()->orderBy('nom')->get();

        return view('admin.produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit): RedirectResponse
    {
        $data = $request->validate([
            'reference' => ['required', 'string', 'max:255', 'unique:produits,reference,'.$produit->id],
            'nom' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
            'prix_achat_ht' => ['required', 'numeric', 'min:0'],
            'prix_vente_ht' => ['required', 'numeric', 'min:0'],
            'qte_min' => ['required', 'integer', 'min:0'],
            'etat' => ['required', 'in:existe,supprime'],
        ]);

        if ($request->hasFile('image')) {
            $newPath = $request->file('image')->store('produits', 'public');

            if ($produit->image_path) {
                Storage::disk('public')->delete($produit->image_path);
            }

            $data['image_path'] = $newPath;
        }

        $produit->update($data);

        return redirect()->route('admin.produits.index');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        $produit->delete();

        return redirect()->route('admin.produits.index');
    }
}
