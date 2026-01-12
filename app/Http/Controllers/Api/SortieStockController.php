<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SortieStock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SortieStockController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);

        $sorties = SortieStock::query()
            ->with(['produit', 'client', 'commande'])
            ->orderByDesc('date_sortie')
            ->paginate($perPage);

        return response()->json($sorties);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'integer', 'exists:produits,id'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'commande_id' => ['nullable', 'integer', 'exists:commandes,id'],
            'qte_sortie' => ['required', 'integer', 'min:1'],
            'date_sortie' => ['required', 'date'],
            'num_bl' => ['required', 'string', 'max:255'],
        ]);

        try {
            $sortie = DB::transaction(function () use ($data): SortieStock {
                return SortieStock::create($data);
            });
        } catch (\RuntimeException $e) {
            throw ValidationException::withMessages([
                'qte_sortie' => $e->getMessage(),
            ]);
        }

        $sortie->load(['produit', 'client', 'commande']);

        return response()->json($sortie, 201);
    }

    public function show(SortieStock $sorties_stock): JsonResponse
    {
        $sorties_stock->load(['produit', 'client', 'commande']);

        return response()->json($sorties_stock);
    }

    public function update(Request $request, SortieStock $sorties_stock): JsonResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'integer', 'exists:produits,id'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'commande_id' => ['nullable', 'integer', 'exists:commandes,id'],
            'qte_sortie' => ['required', 'integer', 'min:1'],
            'date_sortie' => ['required', 'date'],
            'num_bl' => ['required', 'string', 'max:255'],
        ]);

        try {
            $updated = DB::transaction(function () use ($sorties_stock, $data): SortieStock {
                // Same strategy as entree: delete and recreate so stock adjustments remain correct.
                $sorties_stock->delete();

                return SortieStock::create($data);
            });
        } catch (\RuntimeException $e) {
            throw ValidationException::withMessages([
                'qte_sortie' => $e->getMessage(),
            ]);
        }

        $updated->load(['produit', 'client', 'commande']);

        return response()->json($updated);
    }

    public function destroy(SortieStock $sorties_stock): JsonResponse
    {
        DB::transaction(function () use ($sorties_stock): void {
            $sorties_stock->delete();
        });

        return response()->json(null, 204);
    }
}
