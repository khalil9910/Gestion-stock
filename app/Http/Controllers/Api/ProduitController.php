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
        $produits = Produit::query()
            ->with(['categorie', 'stock'])
            ->orderBy('nom')
            ->get();

        return response()->json([
            'data' => $produits,
        ]);
    }
}
