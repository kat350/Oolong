<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('taches', 'completee')) return;
        Schema::table('taches', function (Blueprint $table) {
            $table->boolean('completee')->default(false)->after('start_date');
        });
    }

    public function down(): void
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->dropColumn('completee');
        });
    }
};