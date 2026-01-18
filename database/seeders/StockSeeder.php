<?php

namespace Database\Seeders;

use App\Models\EntreeStock;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $fournisseur = Fournisseur::query()->orderBy('id')->first();
        if (! $fournisseur) {
            return;
        }

        $produits = Produit::query()->orderBy('id')->get();

        DB::transaction(function () use ($produits, $fournisseur): void {
            foreach ($produits as $produit) {
                $ref = is_string($produit->reference) ? $produit->reference : ('PRD-'.$produit->id);

                $qte1 = 0;
                $qte2 = 0;

                if (is_string($produit->reference) && str_starts_with($produit->reference, 'PC-')) {
                    $qte1 = 6;
                    $qte2 = 4;
                } elseif (is_string($produit->reference) && str_starts_with($produit->reference, 'TON-')) {
                    $qte1 = 18;
                    $qte2 = 12;
                } else {
                    $qte1 = 60;
                    $qte2 = 40;
                }

                EntreeStock::create([
                    'produit_id' => $produit->id,
                    'fournisseur_id' => $fournisseur->id,
                    'qte_entree' => $qte1,
                    'date_entree' => now()->subDays(45)->toDateString(),
                    'num_bon_commande' => 'BC-'.$ref.'-001',
                ]);

                EntreeStock::create([
                    'produit_id' => $produit->id,
                    'fournisseur_id' => $fournisseur->id,
                    'qte_entree' => $qte2,
                    'date_entree' => now()->subDays(12)->toDateString(),
                    'num_bon_commande' => 'BC-'.$ref.'-002',
                ]);

                $stock = Stock::where('produit_id', $produit->id)->first();
                if ($stock) {
                    $stock->qte_initiale = (int) $stock->qte_reelle;
                    $stock->save();
                }
            }
        });
    }
}
