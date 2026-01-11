<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fournisseur extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'fournisseurs';

    protected $fillable = [
        'nom',
        'site',
        'telephone',
        'mode_paiement',
    ];

    public function entrees(): HasMany
    {
        return $this->hasMany(EntreeStock::class, 'fournisseur_id');
    }
}
