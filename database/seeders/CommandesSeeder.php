<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Commande;
use App\Models\CommandeDetail;
use App\Models\Produit;
use App\Models\SortieStock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommandesSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::query()->orderBy('id')->get();
        $produits = Produit::query()->orderBy('id')->get();

        if ($clients->isEmpty() || $produits->isEmpty()) {
            return;
        }

        $dates = [
            now()->subDays(18)->toDateString(),
            now()->subDays(9)->toDateString(),
            now()->subDays(3)->toDateString(),
        ];

        $clientIndex = 0;

        foreach ($dates as $dateCommande) {
            $client = $clients[$clientIndex % $clients->count()];
            $clientIndex++;

            $lignes = [];

            foreach ($produits->shuffle()->take(3) as $produit) {
                $qty = 1;

                if (is_string($produit->reference) && str_starts_with($produit->reference, 'PC-')) {
                    $qty = 1;
                } elseif (is_string($produit->reference) && (str_starts_with($produit->reference, 'MOU-') || str_starts_with($produit->reference, 'CLA-'))) {
                    $qty = 5;
                } elseif (is_string($produit->reference) && str_starts_with($produit->reference, 'PAP-')) {
                    $qty = 10;
                } else {
                    $qty = 3;
                }

                $lignes[] = [
                    'produit' => $produit,
                    'quantite' => $qty,
                ];
            }

            try {
                DB::transaction(function () use ($client, $dateCommande, $lignes): void {
                    $commande = Commande::create([
                        'client_id' => $client->id,
                        'invoice_number' => null,
                        'total_ht' => 0,
                        'total_ttc' => 0,
                        'statut' => 'non_payee',
                        'date_commande' => $dateCommande,
                    ]);

                    $year = date('Y', strtotime((string) $dateCommande));
                    $commande->invoice_number = sprintf('FAC-%s-%06d', $year, (int) $commande->id);
                    $commande->save();

                    $totalHt = 0.0;

                    foreach ($lignes as $ligne) {
                        $produit = $ligne['produit'];
                        $qte = (int) $ligne['quantite'];

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
                            'client_id' => $client->id,
                            'commande_id' => $commande->id,
                            'qte_sortie' => $qte,
                            'date_sortie' => $dateCommande,
                            'num_bl' => 'CMD-'.$commande->id,
                        ]);
                    }

                    $commande->total_ht = round($totalHt, 2);
                    $commande->total_ttc = round($totalHt * (1 + Produit::TVA_RATE), 2);
                    $commande->save();
                });
            } catch (\RuntimeException $e) {
            }
        }
    }
}
