<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
