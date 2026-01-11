<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('nom');
            $table->foreignId('categorie_id')->constrained('categories');
            $table->decimal('prix_achat_ht', 10, 2);
            $table->decimal('prix_vente_ht', 10, 2);
            $table->decimal('prix_vente_ttc', 10, 2);
            $table->unsignedInteger('qte_min')->default(0);
            $table->enum('etat', ['existe', 'supprime'])->default('existe');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
