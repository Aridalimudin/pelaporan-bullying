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
        Schema::table('discipline_actions', function (Blueprint $table) {
            $table->unsignedSmallInteger('bobot')->default(1)->after('level');
        });
    }

    public function down(): void
    {
        Schema::table('discipline_actions', function (Blueprint $table) {
            $table->dropColumn('bobot');
        });
    }
};
