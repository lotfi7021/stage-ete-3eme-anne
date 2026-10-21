<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('clients');
        Schema::dropIfExists('livreurs');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('users');
    }

    public function down(): void
    {
        // Suppression volontaire de tables inutilisées : pas de restauration.
    }
};
