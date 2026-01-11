<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'nom',
        'adresse',
        'telephone',
        'type_client',
        'email',
    ];

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class, 'client_id');
    }

    public function sorties(): HasMany
    {
        return $this->hasMany(SortieStock::class, 'client_id');
    }
}
