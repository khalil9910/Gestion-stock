<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommandeDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommandeDetailController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);

        $details = CommandeDetail::query()
            ->with(['commande', 'produit'])
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json($details);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'commande_id' => ['required', 'integer', 'exists:commandes,id'],
            'produit_id' => ['required', 'integer', 'exists:produits,id'],
            'quantite' => ['required', 'integer', 'min:1'],
            'prix_unitaire' => ['required', 'numeric', 'min:0'],
        ]);

        $detail = CommandeDetail::create($data);
        $detail->load(['commande', 'produit']);

        return response()->json($detail, 201);
    }

    public function show(CommandeDetail $commande_detail): JsonResponse
    {
        $commande_detail->load(['commande', 'produit']);

        return response()->json($commande_detail);
    }

    public function update(Request $request, CommandeDetail $commande_detail): JsonResponse
    {
        $data = $request->validate([
            'quantite' => ['required', 'integer', 'min:1'],
            'prix_unitaire' => ['required', 'numeric', 'min:0'],
        ]);

        $commande_detail->update($data);
        $commande_detail->load(['commande', 'produit']);

        return response()->json($commande_detail);
    }

    public function destroy(CommandeDetail $commande_detail): JsonResponse
    {
        $commande_detail->delete();

        return response()->json(null, 204);
    }
}
