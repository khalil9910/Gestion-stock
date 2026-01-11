<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produit extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TVA_RATE = 0.20;

    protected $table = 'produits';

    protected $fillable = [
        'reference',
        'nom',
        'image_path',
        'categorie_id',
        'prix_achat_ht',
        'prix_vente_ht',
        'prix_vente_ttc',
        'qte_min',
        'etat',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $produit): void {
            if ($produit->prix_vente_ht !== null) {
                $produit->prix_vente_ttc = round(((float) $produit->prix_vente_ht) * (1 + self::TVA_RATE), 2);
            }
        });

        static::created(function (self $produit): void {
            Stock::firstOrCreate(
                ['produit_id' => $produit->id],
                ['qte_initiale' => 0, 'qte_reelle' => 0, 'statut_stock' => 'existant']
            );
        });
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class, 'produit_id');
    }

    public function entrees(): HasMany
    {
        return $this->hasMany(EntreeStock::class, 'produit_id');
    }

    public function sorties(): HasMany
    {
        return $this->hasMany(SortieStock::class, 'produit_id');
    }

    public function commandeDetails(): HasMany
    {
        return $this->hasMany(CommandeDetail::class, 'produit_id');
    }
}
