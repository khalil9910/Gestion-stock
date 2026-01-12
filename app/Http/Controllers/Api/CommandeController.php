<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CommandeFactureMail;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Produit;
use App\Models\SortieStock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class CommandeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 15);

        $commandes = Commande::query()
            ->with(['client', 'details.produit'])
            ->orderByDesc('date_commande')
            ->paginate($perPage);

        return response()->json($commandes);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'date_commande' => ['required', 'date'],
            'statut' => ['required', 'in:payee,non_payee'],
            'lignes' => ['required', 'array', 'min:1'],
            'lignes.*.produit_id' => ['required', 'integer', 'exists:produits,id'],
            'lignes.*.quantite' => ['required', 'integer', 'min:1'],
        ]);

        // prevent duplicate produit_id lines
        $produitIds = array_map(fn ($l) => (int) ($l['produit_id'] ?? 0), $data['lignes']);
        if (count($produitIds) !== count(array_unique($produitIds))) {
            throw ValidationException::withMessages([
                'lignes' => 'Chaque produit doit apparaitre une seule fois dans la commande.',
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

                foreach ($data['lignes'] as $ligne) {
                    $qte = (int) $ligne['quantite'];
                    $produit = Produit::findOrFail((int) $ligne['produit_id']);

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
                'lignes' => $e->getMessage(),
            ]);
        }

        $commande->load(['client', 'details.produit']);

        return response()->json($commande, 201);
    }

    public function show(Commande $commande): JsonResponse
    {
        $commande->load(['client', 'details.produit']);

        return response()->json($commande);
    }

    public function update(Request $request, Commande $commande): JsonResponse
    {
        $data = $request->validate([
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'date_commande' => ['required', 'date'],
            'statut' => ['required', 'in:payee,non_payee'],
            'lignes' => ['required', 'array', 'min:1'],
            'lignes.*.produit_id' => ['required', 'integer', 'exists:produits,id'],
            'lignes.*.quantite' => ['required', 'integer', 'min:1'],
        ]);

        $produitIds = array_map(fn ($l) => (int) ($l['produit_id'] ?? 0), $data['lignes']);
        if (count($produitIds) !== count(array_unique($produitIds))) {
            throw ValidationException::withMessages([
                'lignes' => 'Chaque produit doit apparaitre une seule fois dans la commande.',
            ]);
        }

        try {
            DB::transaction(function () use ($data, $commande): void {
                // Revert stock by deleting related sorties
                $sorties = SortieStock::query()->where('commande_id', $commande->id)->get();
                foreach ($sorties as $sortie) {
                    $sortie->delete();
                }

                // Delete old details
                $commande->load('details');
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

                foreach ($data['lignes'] as $ligne) {
                    $qte = (int) $ligne['quantite'];
                    $produit = Produit::findOrFail((int) $ligne['produit_id']);

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
                'lignes' => $e->getMessage(),
            ]);
        }

        $commande->load(['client', 'details.produit']);

        return response()->json($commande);
    }

    public function destroy(Commande $commande): JsonResponse
    {
        DB::transaction(function () use ($commande): void {
            $sorties = SortieStock::query()->where('commande_id', $commande->id)->get();
            foreach ($sorties as $sortie) {
                $sortie->delete();
            }

            $commande->load('details');
            foreach ($commande->details as $detail) {
                $detail->delete();
            }

            $commande->delete();
        });

        return response()->json(null, 204);
    }

    public function sendInvoice(Commande $commande): JsonResponse
    {
        $commande->loadMissing(['client', 'details.produit']);

        $email = $commande->client?->email;
        if (! $email) {
            return response()->json([
                'message' => 'Client email is missing for this commande.',
            ], 422);
        }

        try {
            Mail::to($email)->send(new CommandeFactureMail($commande));
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to send invoice email.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Invoice email sent successfully.',
            'to' => $email,
            'commande_id' => $commande->id,
            'invoice_number' => $commande->invoice_number,
        ]);
    }
}
