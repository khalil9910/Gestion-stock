<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);

        $stocks = Stock::query()
            ->with('produit')
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json($stocks);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'integer', 'exists:produits,id', 'unique:stocks,produit_id'],
            'qte_initiale' => ['nullable', 'integer', 'min:0'],
            'qte_reelle' => ['nullable', 'integer', 'min:0'],
        ]);

        $stock = Stock::create([
            'produit_id' => $data['produit_id'],
            'qte_initiale' => (int) ($data['qte_initiale'] ?? 0),
            'qte_reelle' => (int) ($data['qte_reelle'] ?? 0),
            'statut_stock' => 'existant',
        ]);

        $stock->load('produit');

        return response()->json($stock, 201);
    }

    public function show(Stock $stock): JsonResponse
    {
        $stock->load('produit');

        return response()->json($stock);
    }

    public function update(Request $request, Stock $stock): JsonResponse
    {
        $data = $request->validate([
            'qte_initiale' => ['required', 'integer', 'min:0'],
            'qte_reelle' => ['required', 'integer', 'min:0'],
        ]);

        $stock->update($data);
        $stock->load('produit');

        return response()->json($stock);
    }

    public function destroy(Stock $stock): JsonResponse
    {
        $stock->delete();

        return response()->json(null, 204);
    }
}
