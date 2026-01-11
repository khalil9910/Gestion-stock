<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::query()->orderBy('nom')->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('admin.clients.create');
    }

    public function show(Client $client): View
    {
        return view('admin.clients.show', compact('client'));
    }

    public function archive(): View
    {
        $clients = Client::onlyTrashed()->orderByDesc('deleted_at')->paginate(15);

        return view('admin.clients.archive', compact('clients'));
    }

    public function restore(int $id): RedirectResponse
    {
        $client = Client::withTrashed()->findOrFail($id);
        $client->restore();

        return redirect()->route('admin.clients.archive');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(
            [
                'nom' => ['required', 'string', 'max:255'],
                'adresse' => ['nullable', 'string', 'max:255'],
                'telephone' => ['nullable', 'string', 'max:50'],
                'type_client' => ['required', 'in:Solvable,Non solvable,Litigieux'],
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
            ],
            [
                'email.required' => 'Email obligatoire.',
                'email.email' => 'Email invalide.',
            ]
        );

        Client::create($data);

        return redirect()->route('admin.clients.index');
    }

    public function edit(Client $client): View
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $data = $request->validate(
            [
                'nom' => ['required', 'string', 'max:255'],
                'adresse' => ['nullable', 'string', 'max:255'],
                'telephone' => ['nullable', 'string', 'max:50'],
                'type_client' => ['required', 'in:Solvable,Non solvable,Litigieux'],
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
            ],
            [
                'email.required' => 'Email obligatoire.',
                'email.email' => 'Email invalide.',
            ]
        );

        $client->update($data);

        return redirect()->route('admin.clients.index');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('admin.clients.index');
    }
}
