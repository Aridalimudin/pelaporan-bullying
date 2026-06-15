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
        Schema::table('report_follow_ups', function (Blueprint $table) {
            // Drop old foreign key and column
            $table->dropForeign(['discipline_action_id_korban']);
            $table->dropColumn('discipline_action_id_korban');

            // Add new column and foreign key referencing korban_actions
            $table->unsignedBigInteger('korban_action_id')->nullable()->after('discipline_action_id');
            $table->foreign('korban_action_id')
                  ->references('id')
                  ->on('korban_actions')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_follow_ups', function (Blueprint $table) {
            // Drop new foreign key and column
            $table->dropForeign(['korban_action_id']);
            $table->dropColumn('korban_action_id');

            // Recreate old column and foreign key referencing discipline_actions
            $table->foreignId('discipline_action_id_korban')
                  ->nullable()
                  ->after('discipline_action_id')
                  ->constrained('discipline_actions')
                  ->nullOnDelete();
        });
    }
};
