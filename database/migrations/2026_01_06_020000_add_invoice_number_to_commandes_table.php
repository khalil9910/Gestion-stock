<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->unique()->after('id');
        });

        $commandes = DB::table('commandes')->select(['id', 'date_commande'])->orderBy('id')->get();

        foreach ($commandes as $commande) {
            $year = $commande->date_commande ? date('Y', strtotime((string) $commande->date_commande)) : date('Y');
            $number = sprintf('FAC-%s-%06d', $year, (int) $commande->id);

            DB::table('commandes')
                ->where('id', $commande->id)
                ->update(['invoice_number' => $number]);
        }
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropUnique(['invoice_number']);
            $table->dropColumn('invoice_number');
        });
    }
};
