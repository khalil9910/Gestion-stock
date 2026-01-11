<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class SortieStock extends Model
{
    use HasFactory;

    protected $table = 'sorties_stock';

    protected $fillable = [
        'produit_id',
        'client_id',
        'commande_id',
        'qte_sortie',
        'date_sortie',
        'num_bl',
    ];

    protected $casts = [
        'date_sortie' => 'date',
    ];

    protected static function booted(): void
    {
        static::created(function (self $sortie): void {
            DB::transaction(function () use ($sortie): void {
                $stock = Stock::firstOrCreate(
                    ['produit_id' => $sortie->produit_id],
                    ['qte_initiale' => 0, 'qte_reelle' => 0, 'statut_stock' => 'existant']
                );

                $newQty = (int) $stock->qte_reelle - (int) $sortie->qte_sortie;
                if ($newQty < 0) {
                    throw new \RuntimeException('Stock insuffisant pour cette sortie.');
                }

                $stock->qte_reelle = $newQty;
                $stock->save();
            });
        });

        static::deleted(function (self $sortie): void {
            DB::transaction(function () use ($sortie): void {
                $stock = Stock::where('produit_id', $sortie->produit_id)->first();
                if (! $stock) {
                    return;
                }

                $stock->qte_reelle = (int) $stock->qte_reelle + (int) $sortie->qte_sortie;
                $stock->save();
            });
        });
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
}
