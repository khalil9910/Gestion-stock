<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);

        $produits = Produit::query()
            ->with(['categorie', 'stock'])
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json($produits);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'reference' => ['required', 'string', 'max:255', 'unique:produits,reference'],
            'nom' => ['required', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
            'prix_achat_ht' => ['required', 'numeric', 'min:0'],
            'prix_vente_ht' => ['required', 'numeric', 'min:0'],
            'qte_min' => ['required', 'integer', 'min:0'],
            'etat' => ['required', 'in:existe,supprime'],
        ]);

        $produit = Produit::create($data);
        $produit->load(['categorie', 'stock']);

        return response()->json($produit, 201);
    }

    public function show(Produit $produit): JsonResponse
    {
        $produit->load(['categorie', 'stock', 'entrees', 'sorties']);

        return response()->json($produit);
    }

    public function update(Request $request, Produit $produit): JsonResponse
    {
        $data = $request->validate([
            'reference' => ['required', 'string', 'max:255', 'unique:produits,reference,'.$produit->id],
            'nom' => ['required', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
            'prix_achat_ht' => ['required', 'numeric', 'min:0'],
            'prix_vente_ht' => ['required', 'numeric', 'min:0'],
            'qte_min' => ['required', 'integer', 'min:0'],
            'etat' => ['required', 'in:existe,supprime'],
        ]);

        $produit->update($data);
        $produit->load(['categorie', 'stock']);

        return response()->json($produit);
    }

    public function destroy(Produit $produit): JsonResponse
    {
        $produit->delete();

        return response()->json(null, 204);
    }
}
