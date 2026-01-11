<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->cascadeOnDelete();
            $table->unsignedInteger('qte_initiale')->default(0);
            $table->unsignedInteger('qte_reelle')->default(0);
            $table->enum('statut_stock', ['existant', 'reapprovisionnement'])->default('existant');
            $table->timestamps();

            $table->unique('produit_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
