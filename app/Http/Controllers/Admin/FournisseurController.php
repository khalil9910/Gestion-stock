<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FournisseurController extends Controller
{
    public function index(): View
    {
        $fournisseurs = Fournisseur::query()->orderBy('nom')->paginate(15);

        return view('admin.fournisseurs.index', compact('fournisseurs'));
    }

    public function create(): View
    {
        return view('admin.fournisseurs.create');
    }

    public function show(Fournisseur $fournisseur): View
    {
        return view('admin.fournisseurs.show', compact('fournisseur'));
    }

    public function archive(): View
    {
        $fournisseurs = Fournisseur::onlyTrashed()->orderByDesc('deleted_at')->paginate(15);

        return view('admin.fournisseurs.archive', compact('fournisseurs'));
    }

    public function restore(int $id): RedirectResponse
    {
        $fournisseur = Fournisseur::withTrashed()->findOrFail($id);
        $fournisseur->restore();

        return redirect()->route('admin.fournisseurs.archive');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'site' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:50'],
            'mode_paiement' => ['required', 'in:cheque,virement'],
        ]);

        Fournisseur::create($data);

        return redirect()->route('admin.fournisseurs.index');
    }

    public function edit(Fournisseur $fournisseur): View
    {
        return view('admin.fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur): RedirectResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'site' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:50'],
            'mode_paiement' => ['required', 'in:cheque,virement'],
        ]);

        $fournisseur->update($data);

        return redirect()->route('admin.fournisseurs.index');
    }

    public function destroy(Fournisseur $fournisseur): RedirectResponse
    {
        $fournisseur->delete();

        return redirect()->route('admin.fournisseurs.index');
    }
}
