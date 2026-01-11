<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->decimal('total_ht', 12, 2)->default(0);
            $table->decimal('total_ttc', 12, 2)->default(0);
            $table->enum('statut', ['payee', 'non_payee'])->default('non_payee');
            $table->date('date_commande');
            $table->timestamps();

            $table->index(['client_id', 'date_commande']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
