<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class EntreeStock extends Model
{
    use HasFactory;

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
