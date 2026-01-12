<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);

        $categories = Categorie::query()
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json($categories);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:255'],
        ]);

        $categorie = Categorie::create($data);

        return response()->json($categorie, 201);
    }

    public function show(Categorie $category): JsonResponse
    {
        $category->load('produits');

        return response()->json($category);
    }

    public function update(Request $request, Categorie $category): JsonResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:255'],
        ]);

        $category->update($data);

        return response()->json($category);
    }

    public function destroy(Categorie $category): JsonResponse
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
