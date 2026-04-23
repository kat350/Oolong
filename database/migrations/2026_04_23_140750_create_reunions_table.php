<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // up() = ce qu'on fait quand on lance la migration
    public function up(): void
    {
        Schema::create('reunions', function (Blueprint $table) {
            $table->id();                          // colonne id auto-incrémentée
            $table->string('titre');               // texte court
            $table->text('description')->nullable(); // texte long, optionnel
            $table->date('date_reunion');          // format YYYY-MM-DD
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
            $table->timestamps();                  // created_at + updated_at auto
        });
    }

    // down() = ce qu'on fait si on veut ANNULER la migration
    public function down(): void
    {
        Schema::dropIfExists('reunions');
    }
};