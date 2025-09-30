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
        Schema::create('gestion_machines', function (Blueprint $table) {
            $table->id();
            $table->string('reference','50')->nullable();
            $table->string('titre','50')->nullable();
            $table->string('description','255')->nullable();
            $table->string('image1','255')->nullable();
         
            $table->float('prix');
            $table->integer('qte')->nullable();
            $table->unsignedBigInteger('marque_id');
            $table->foreign('marque_id')->references('id')->on('marque_machines')->onDelete('cascade');
            $table->unsignedBigInteger('model_id');
            $table->foreign('model_id')->references('id')->on('model_machines')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_machines');
    }
};
