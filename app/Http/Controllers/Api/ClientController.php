<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);

        $clients = Client::query()
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json($clients);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
            'type_client' => ['required', 'in:Solvable,Non solvable,Litigieux'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $client = Client::create($data);

        return response()->json($client, 201);
    }

    public function show(Client $client): JsonResponse
    {
        $client->load(['commandes', 'sorties']);

        return response()->json($client);
    }

    public function update(Request $request, Client $client): JsonResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
            'type_client' => ['required', 'in:Solvable,Non solvable,Litigieux'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $client->update($data);

        return response()->json($client);
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json(null, 204);
    }
}
