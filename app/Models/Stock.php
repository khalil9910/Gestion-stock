<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $fillable = [
        'produit_id',
        'qte_initiale',
        'qte_reelle',
        'statut_stock',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $stock): void {
            if ($stock->relationLoaded('produit')) {
                $produit = $stock->getRelation('produit');
            } else {
                $produit = $stock->produit()->first();
            }

            if ($produit) {
                $stock->statut_stock = $stock->qte_reelle <= (int) $produit->qte_min
                    ? 'reapprovisionnement'
                    : 'existant';
            }
        });
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public static function syncAllFromMovements(): void
    {
        $produitIds = DB::table('produits')
            ->whereNull('deleted_at')
            ->where('etat', 'existe')
            ->pluck('id');

        foreach ($produitIds as $produitId) {
            $pid = (int) $produitId;

            $entrees = (int) DB::table('entrees_stock')
                ->whereNull('deleted_at')
                ->where('produit_id', $pid)
                ->sum('qte_entree');

            $sorties = (int) DB::table('sorties_stock')
                ->whereNull('deleted_at')
                ->where('produit_id', $pid)
                ->sum('qte_sortie');

            $qteReelle = max(0, $entrees - $sorties);

            $stock = self::firstOrCreate(
                ['produit_id' => $pid],
                ['qte_initiale' => 0, 'qte_reelle' => 0, 'statut_stock' => 'existant']
            );

            $stock->qte_reelle = $qteReelle;
            if ((int) $stock->qte_initiale === 0 && $qteReelle > 0) {
                $stock->qte_initiale = $qteReelle;
            }
            $stock->save();
        }
    }
}
