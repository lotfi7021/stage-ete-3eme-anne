<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Index manquants sur les colonnes utilisées par les jointures,
     * les filtres (where/orderBy) et la connexion (admins.login).
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->unique('login');
            $table->index(['role', 'status']);
        });

        Schema::table('commande__m_s', function (Blueprint $table) {
            $table->index('id_client');
            $table->index('id_livreur');
            $table->index('ref_commande');
            $table->index('etat');
        });

        Schema::table('detail_commande_m_s', function (Blueprint $table) {
            $table->index('ref_commande');
            $table->index('id_produit');
        });

        Schema::table('stock_machines', function (Blueprint $table) {
            $table->unique('id_produit');
        });

        Schema::table('supports', function (Blueprint $table) {
            $table->index('id_client');
        });
    }

    public function down(): void
    {
        Schema::table('supports', function (Blueprint $table) {
            $table->dropIndex(['id_client']);
        });

        Schema::table('stock_machines', function (Blueprint $table) {
            $table->dropUnique(['id_produit']);
        });

        Schema::table('detail_commande_m_s', function (Blueprint $table) {
            $table->dropIndex(['id_produit']);
            $table->dropIndex(['ref_commande']);
        });

        Schema::table('commande__m_s', function (Blueprint $table) {
            $table->dropIndex(['etat']);
            $table->dropIndex(['ref_commande']);
            $table->dropIndex(['id_livreur']);
            $table->dropIndex(['id_client']);
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropIndex(['role', 'status']);
            $table->dropUnique(['login']);
        });
    }
};
