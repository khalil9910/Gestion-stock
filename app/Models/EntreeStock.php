<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class EntreeStock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'entrees_stock';

    protected $fillable = [
        'produit_id',
        'fournisseur_id',
        'qte_entree',
        'date_entree',
        'num_bon_commande',
    ];

    protected $casts = [
        'date_entree' => 'date',
    ];

    protected static function booted(): void
    {
        static::created(function (self $entree): void {
            DB::transaction(function () use ($entree): void {
                $stock = Stock::firstOrCreate(
                    ['produit_id' => $entree->produit_id],
                    ['qte_initiale' => 0, 'qte_reelle' => 0, 'statut_stock' => 'existant']
                );

                $stock->qte_reelle = (int) $stock->qte_reelle + (int) $entree->qte_entree;
                $stock->save();
            });
        });

        static::updating(function (self $entree): void {
            DB::transaction(function () use ($entree): void {
                $originalProduitId = (int) $entree->getOriginal('produit_id');
                $originalQte = (int) $entree->getOriginal('qte_entree');

                $newProduitId = (int) $entree->produit_id;
                $newQte = (int) $entree->qte_entree;

                if ($originalProduitId === $newProduitId) {
                    $delta = $newQte - $originalQte;
                    if ($delta === 0) {
                        return;
                    }

                    $stock = Stock::firstOrCreate(
                        ['produit_id' => $newProduitId],
                        ['qte_initiale' => 0, 'qte_reelle' => 0, 'statut_stock' => 'existant']
                    );

                    $stock->qte_reelle = max(0, (int) $stock->qte_reelle + $delta);
                    $stock->save();
                    return;
                }

                $stockOld = Stock::where('produit_id', $originalProduitId)->first();
                if ($stockOld) {
                    $stockOld->qte_reelle = max(0, (int) $stockOld->qte_reelle - $originalQte);
                    $stockOld->save();
                }

                $stockNew = Stock::firstOrCreate(
                    ['produit_id' => $newProduitId],
                    ['qte_initiale' => 0, 'qte_reelle' => 0, 'statut_stock' => 'existant']
                );
                $stockNew->qte_reelle = (int) $stockNew->qte_reelle + $newQte;
                $stockNew->save();
            });
        });

        static::deleted(function (self $entree): void {
            DB::transaction(function () use ($entree): void {
                $stock = Stock::where('produit_id', $entree->produit_id)->first();
                if (! $stock) {
                    return;
                }

                $stock->qte_reelle = max(0, (int) $stock->qte_reelle - (int) $entree->qte_entree);
                $stock->save();
            });
        });

        static::restored(function (self $entree): void {
            DB::transaction(function () use ($entree): void {
                $stock = Stock::firstOrCreate(
                    ['produit_id' => $entree->produit_id],
                    ['qte_initiale' => 0, 'qte_reelle' => 0, 'statut_stock' => 'existant']
                );

                $stock->qte_reelle = (int) $stock->qte_reelle + (int) $entree->qte_entree;
                $stock->save();
            });
        });
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
}
