<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nom')->nullable;
            $table->string('prenom')->nullable;
            $table->string('nom_de_la_societe')->nullable;
            $table->string('code_TVA')->nullable;
            $table->string('adresse')->nullable;
            $table->integer('telephone')->nullable;

            $table->string('Email')->nullable;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
