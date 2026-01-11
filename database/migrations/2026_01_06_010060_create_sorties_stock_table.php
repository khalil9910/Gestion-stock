<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sorties_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits');
            $table->foreignId('client_id')->constrained('clients');
            $table->unsignedInteger('qte_sortie');
            $table->date('date_sortie');
            $table->string('num_bl');
            $table->timestamps();

            $table->index(['produit_id', 'date_sortie']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sorties_stock');
    }
};
