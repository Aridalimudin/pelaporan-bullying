<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discipline_actions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('level', ['Ringan', 'Sedang', 'Berat']);
            $table->string('duration')->nullable();
            $table->string('executor')->nullable();
            $table->text('description')->nullable();
            $table->text('condition')->nullable();
            $table->enum('parent_involvement', ['tidak', 'ya', 'opsional'])->default('tidak');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discipline_actions');
    }
};