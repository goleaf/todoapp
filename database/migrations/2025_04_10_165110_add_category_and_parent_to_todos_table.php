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
        Schema::table('todos', function (Blueprint $table) {
            // Add category_id (nullable, foreign key)
            $table->foreignId('category_id')->nullable()->after('user_id')->constrained()->onDelete('set null');

            // Add parent_id for subtasks (nullable, self-referencing foreign key)
            $table->foreignId('parent_id')->nullable()->after('category_id')->constrained('todos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            // Drop foreign keys before columns
            $table->dropForeign(['category_id']);
            $table->dropForeign(['parent_id']);
            $table->dropColumn('category_id');
            $table->dropColumn('parent_id');
        });
    }
};
