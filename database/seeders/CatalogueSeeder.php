<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Produit;
use Illuminate\Database\Seeder;

class CatalogueSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nom' => 'Informatique', 'description' => 'Matériel informatique et accessoires', 'image_path' => null],
            ['nom' => 'Bureautique', 'description' => 'Fournitures et consommables', 'image_path' => null],
            ['nom' => 'Réseau', 'description' => 'Équipements réseau', 'image_path' => null],
        ];

        $categorieMap = [];
        foreach ($categories as $c) {
            $categorie = Categorie::withTrashed()->updateOrCreate(
                ['nom' => $c['nom']],
                ['description' => $c['description'], 'image_path' => $c['image_path']]
            );

            if ($categorie->trashed()) {
                $categorie->restore();
            }
            $categorieMap[$c['nom']] = $categorie;
        }

        $fournisseurs = [
            ['nom' => 'Atlas Distribution', 'site' => 'https://atlas-distribution.ma', 'telephone' => '0522000001', 'mode_paiement' => 'virement'],
            ['nom' => 'Maroc Supplies', 'site' => 'https://maroc-supplies.ma', 'telephone' => '0522000002', 'mode_paiement' => 'cheque'],
        ];

        foreach ($fournisseurs as $f) {
            $fournisseur = Fournisseur::withTrashed()->updateOrCreate(
                ['nom' => $f['nom']],
                ['site' => $f['site'], 'telephone' => $f['telephone'], 'mode_paiement' => $f['mode_paiement']]
            );

            if ($fournisseur->trashed()) {
                $fournisseur->restore();
            }
        }

        $produits = [
            [
                'reference' => 'PC-HP-15-001',
                'nom' => 'PC Portable HP 15" i5 8Go/512Go',
                'categorie' => 'Informatique',
                'prix_achat_ht' => 5200.00,
                'prix_vente_ht' => 6200.00,
                'qte_min' => 2,
                'etat' => 'existe',
                'image_path' => null,
            ],
            [
                'reference' => 'MOU-LOGI-M185',
                'nom' => 'Souris Logitech M185',
                'categorie' => 'Informatique',
                'prix_achat_ht' => 65.00,
                'prix_vente_ht' => 99.00,
                'qte_min' => 10,
                'etat' => 'existe',
                'image_path' => null,
            ],
            [
                'reference' => 'CLA-K120',
                'nom' => 'Clavier Logitech K120',
                'categorie' => 'Informatique',
                'prix_achat_ht' => 85.00,
                'prix_vente_ht' => 125.00,
                'qte_min' => 8,
                'etat' => 'existe',
                'image_path' => null,
            ],
            [
                'reference' => 'PAP-A4-80G',
                'nom' => 'Ramette Papier A4 80g (500 feuilles)',
                'categorie' => 'Bureautique',
                'prix_achat_ht' => 34.00,
                'prix_vente_ht' => 48.00,
                'qte_min' => 20,
                'etat' => 'existe',
                'image_path' => null,
            ],
            [
                'reference' => 'TON-HP-12A',
                'nom' => 'Toner HP 12A (Q2612A) compatible',
                'categorie' => 'Bureautique',
                'prix_achat_ht' => 95.00,
                'prix_vente_ht' => 140.00,
                'qte_min' => 6,
                'etat' => 'existe',
                'image_path' => null,
            ],
            [
                'reference' => 'SW-TP-LS1005',
                'nom' => 'Switch TP-Link LS1005 5 ports',
                'categorie' => 'Réseau',
                'prix_achat_ht' => 70.00,
                'prix_vente_ht' => 110.00,
                'qte_min' => 5,
                'etat' => 'existe',
                'image_path' => null,
            ],
            [
                'reference' => 'CAB-RJ45-10M',
                'nom' => 'Câble RJ45 Cat6 10m',
                'categorie' => 'Réseau',
                'prix_achat_ht' => 25.00,
                'prix_vente_ht' => 39.00,
                'qte_min' => 15,
                'etat' => 'existe',
                'image_path' => null,
            ],
        ];

        foreach ($produits as $p) {
            $categorie = $categorieMap[$p['categorie']];

            $prixVenteHt = (float) $p['prix_vente_ht'];
            $prixVenteTtc = round($prixVenteHt * (1 + Produit::TVA_RATE), 2);

            $produit = Produit::withTrashed()->updateOrCreate(
                ['reference' => $p['reference']],
                [
                    'nom' => $p['nom'],
                    'image_path' => $p['image_path'],
                    'categorie_id' => $categorie->id,
                    'prix_achat_ht' => $p['prix_achat_ht'],
                    'prix_vente_ht' => $prixVenteHt,
                    'prix_vente_ttc' => $prixVenteTtc,
                    'qte_min' => $p['qte_min'],
                    'etat' => $p['etat'],
                ]
            );

            if ($produit->trashed()) {
                $produit->restore();
            }
        }
    }
}
