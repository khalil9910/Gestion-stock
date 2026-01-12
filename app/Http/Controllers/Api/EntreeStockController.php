<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EntreeStock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntreeStockController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);

        $entrees = EntreeStock::query()
            ->with(['produit', 'fournisseur'])
            ->orderByDesc('date_entree')
            ->paginate($perPage);

        return response()->json($entrees);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'integer', 'exists:produits,id'],
            'fournisseur_id' => ['required', 'integer', 'exists:fournisseurs,id'],
            'qte_entree' => ['required', 'integer', 'min:1'],
            'date_entree' => ['required', 'date'],
            'num_bon_commande' => ['required', 'string', 'max:255'],
        ]);

        $entree = DB::transaction(function () use ($data): EntreeStock {
            return EntreeStock::create($data);
        });

        $entree->load(['produit', 'fournisseur']);

        return response()->json($entree, 201);
    }

    public function show(EntreeStock $entrees_stock): JsonResponse
    {
        $entrees_stock->load(['produit', 'fournisseur']);

        return response()->json($entrees_stock);
    }

    public function update(Request $request, EntreeStock $entrees_stock): JsonResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'integer', 'exists:produits,id'],
            'fournisseur_id' => ['required', 'integer', 'exists:fournisseurs,id'],
            'qte_entree' => ['required', 'integer', 'min:1'],
            'date_entree' => ['required', 'date'],
            'num_bon_commande' => ['required', 'string', 'max:255'],
        ]);

        $updated = DB::transaction(function () use ($entrees_stock, $data): EntreeStock {
            // We must rollback old impact on stock, then apply new impact.
            // Eloquent events (deleted/created) already handle stock updates.
            // So we delete and recreate for consistency.
            $old = $entrees_stock->replicate();

            $entrees_stock->delete();

            return EntreeStock::create($data);
        });

        $updated->load(['produit', 'fournisseur']);

        return response()->json($updated);
    }

    public function destroy(EntreeStock $entrees_stock): JsonResponse
    {
        DB::transaction(function () use ($entrees_stock): void {
            $entrees_stock->delete();
        });

        return response()->json(null, 204);
    }
}
