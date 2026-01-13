<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use App\Mail\CommandeFactureMail;
use App\Models\Client;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Produit;
use App\Models\SortieStock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class CommandeController extends Controller
{
    public function index(): View
    {
        $commandes = Commande::query()
            ->with('client')
            ->orderByDesc('date_commande')
            ->get();

        return view('ventes.commandes.index', compact('commandes'));
    }

    public function create(): View
    {
        $clients = Client::query()->orderBy('nom')->get();
        $produits = Produit::query()->orderBy('nom')->get();

        return view('ventes.commandes.create', compact('clients', 'produits'));
    }

    public function edit(Commande $commande): View
    {
        $commande->load(['client', 'details.produit']);
        $clients = Client::query()->orderBy('nom')->get();
        $produits = Produit::query()->orderBy('nom')->get();

        return view('ventes.commandes.edit', compact('commande', 'clients', 'produits'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'date_commande' => ['required', 'date'],
            'statut' => ['required', 'in:payee,non_payee'],
            'produit_id' => ['required', 'array', 'min:1'],
            'produit_id.*' => ['required', 'integer', 'exists:produits,id'],
            'quantite' => ['required', 'array', 'min:1'],
            'quantite.*' => ['required', 'integer', 'min:1'],
        ]);

        if (count($data['produit_id']) !== count($data['quantite'])) {
            throw ValidationException::withMessages([
                'produit_id' => 'Lignes invalides.',
            ]);
        }

        try {
            $commande = DB::transaction(function () use ($data): Commande {
                $commande = Commande::create([
                    'client_id' => $data['client_id'],
                    'invoice_number' => null,
                    'total_ht' => 0,
                    'total_ttc' => 0,
                    'statut' => $data['statut'],
                    'date_commande' => $data['date_commande'],
                ]);

                $year = date('Y', strtotime((string) $data['date_commande']));
                $commande->invoice_number = sprintf('FAC-%s-%06d', $year, (int) $commande->id);
                $commande->save();

                $totalHt = 0.0;

                foreach ($data['produit_id'] as $i => $produitId) {
                    $qte = (int) $data['quantite'][$i];
                    $produit = Produit::findOrFail($produitId);

                    $prixUnitaire = (float) $produit->prix_vente_ht;
                    $totalHt += $prixUnitaire * $qte;

                    CommandeDetail::create([
                        'commande_id' => $commande->id,
                        'produit_id' => $produit->id,
                        'quantite' => $qte,
                        'prix_unitaire' => $prixUnitaire,
                    ]);

                    SortieStock::create([
                        'produit_id' => $produit->id,
                        'client_id' => $data['client_id'],
                        'commande_id' => $commande->id,
                        'qte_sortie' => $qte,
                        'date_sortie' => $data['date_commande'],
                        'num_bl' => 'CMD-'.$commande->id,
                    ]);
                }

                $commande->total_ht = round($totalHt, 2);
                $commande->total_ttc = round($totalHt * (1 + Produit::TVA_RATE), 2);
                $commande->save();

                return $commande;
            });
        } catch (\RuntimeException $e) {
            throw ValidationException::withMessages([
                'quantite' => $e->getMessage(),
            ]);
        }

        $commande->load(['client', 'details.produit']);
        if ($commande->client?->email) {
            try {
                Mail::to($commande->client->email)->send(new CommandeFactureMail($commande));
            } catch (\Throwable $e) {
            }
        }

        return redirect()->route('ventes.commandes.show', $commande);
    }

    public function update(Request $request, Commande $commande): RedirectResponse
    {
        $data = $request->validate([
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'date_commande' => ['required', 'date'],
            'statut' => ['required', 'in:payee,non_payee'],
            'produit_id' => ['required', 'array', 'min:1'],
            'produit_id.*' => ['required', 'integer', 'exists:produits,id'],
            'quantite' => ['required', 'array', 'min:1'],
            'quantite.*' => ['required', 'integer', 'min:1'],
        ]);

        if (count($data['produit_id']) !== count($data['quantite'])) {
            throw ValidationException::withMessages([
                'produit_id' => 'Lignes invalides.',
            ]);
        }

        try {
            DB::transaction(function () use ($data, $commande): void {
                $commande->load('details');

                $sorties = SortieStock::query()
                    ->where('commande_id', $commande->id)
                    ->get();

                foreach ($sorties as $sortie) {
                    $sortie->delete();
                }

                foreach ($commande->details as $detail) {
                    $detail->delete();
                }

                $commande->client_id = $data['client_id'];
                $commande->statut = $data['statut'];
                $commande->date_commande = $data['date_commande'];

                if (! $commande->invoice_number) {
                    $year = date('Y', strtotime((string) $data['date_commande']));
                    $commande->invoice_number = sprintf('FAC-%s-%06d', $year, (int) $commande->id);
                }

                $commande->save();

                $totalHt = 0.0;

                foreach ($data['produit_id'] as $i => $produitId) {
                    $qte = (int) $data['quantite'][$i];
                    $produit = Produit::findOrFail($produitId);

                    $prixUnitaire = (float) $produit->prix_vente_ht;
                    $totalHt += $prixUnitaire * $qte;

                    CommandeDetail::create([
                        'commande_id' => $commande->id,
                        'produit_id' => $produit->id,
                        'quantite' => $qte,
                        'prix_unitaire' => $prixUnitaire,
                    ]);

                    SortieStock::create([
                        'produit_id' => $produit->id,
                        'client_id' => $data['client_id'],
                        'commande_id' => $commande->id,
                        'qte_sortie' => $qte,
                        'date_sortie' => $data['date_commande'],
                        'num_bl' => 'CMD-'.$commande->id,
                    ]);
                }

                $commande->total_ht = round($totalHt, 2);
                $commande->total_ttc = round($totalHt * (1 + Produit::TVA_RATE), 2);
                $commande->save();
            });
        } catch (\RuntimeException $e) {
            throw ValidationException::withMessages([
                'quantite' => $e->getMessage(),
            ]);
        }

        return redirect()->route('ventes.commandes.show', $commande);
    }

    public function destroy(Commande $commande): RedirectResponse
    {
        DB::transaction(function () use ($commande): void {
            $sorties = SortieStock::query()
                ->where('commande_id', $commande->id)
                ->get();

            foreach ($sorties as $sortie) {
                $sortie->delete();
            }

            $commande->load('details');
            foreach ($commande->details as $detail) {
                $detail->delete();
            }

            $commande->delete();
        });

        return redirect()->route('ventes.commandes.index');
    }

    public function show(Commande $commande): View
    {
        $commande->load(['client', 'details.produit']);

        return view('ventes.commandes.show', compact('commande'));
    }

    public function facture(Commande $commande): View
    {
        $commande->load(['client', 'details.produit']);

        return view('ventes.commandes.facture', compact('commande'));
    }

    public function facturePdf(Commande $commande): Response
    {
        $commande->load(['client', 'details.produit']);

        $pdf = Pdf::loadView('ventes.commandes.facture_pdf', compact('commande'));

        $filename = ($commande->invoice_number ?: ('commande-'.$commande->id)).'.pdf';

        return $pdf->download($filename);
    }

    public function sendInvoice(Commande $commande): RedirectResponse
    {
        $commande->loadMissing(['client', 'details.produit']);

        if (! $commande->client?->email) {
            return back()->withErrors([
                'email' => 'Email du client manquant.',
            ]);
        }

        try {
            Mail::to($commande->client->email)->send(new CommandeFactureMail($commande));
        } catch (\Throwable $e) {
            return back()->withErrors([
                'email' => "Erreur d'envoi email: ".$e->getMessage(),
            ]);
        }

        return back()->with('status', 'Facture envoyée par email.');
    }
}
