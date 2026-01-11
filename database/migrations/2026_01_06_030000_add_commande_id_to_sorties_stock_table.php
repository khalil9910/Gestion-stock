<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sorties_stock', function (Blueprint $table) {
            $table->foreignId('commande_id')
                ->nullable()
                ->after('client_id')
                ->constrained('commandes')
                ->nullOnDelete();

            $table->index(['commande_id']);
        });

        $sorties = DB::table('sorties_stock')->select(['id', 'num_bl'])->orderBy('id')->get();

        foreach ($sorties as $sortie) {
            if (! is_string($sortie->num_bl)) {
                continue;
            }

            if (preg_match('/^CMD-(\d+)$/', $sortie->num_bl, $m)) {
                $commandeId = (int) $m[1];

                $exists = DB::table('commandes')->where('id', $commandeId)->exists();
                if (! $exists) {
                    continue;
                }

                DB::table('sorties_stock')
                    ->where('id', $sortie->id)
                    ->update(['commande_id' => $commandeId]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('sorties_stock', function (Blueprint $table) {
            $table->dropForeign(['commande_id']);
            $table->dropIndex(['commande_id']);
            $table->dropColumn('commande_id');
        });
    }
};
