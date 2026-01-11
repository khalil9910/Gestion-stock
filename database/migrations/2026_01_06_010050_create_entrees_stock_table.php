<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entrees_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits');
            $table->foreignId('fournisseur_id')->constrained('fournisseurs');
            $table->unsignedInteger('qte_entree');
            $table->date('date_entree');
            $table->string('num_bon_commande');
            $table->timestamps();

            $table->index(['produit_id', 'date_entree']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrees_stock');
    }
};
