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
            $table->boolean('is_recurring')->default(false)->after('status');
            $table->enum('repeat_frequency', ['daily', 'weekly', 'monthly', 'custom'])->nullable()->after('is_recurring');
            $table->integer('repeat_interval')->nullable()->after('repeat_frequency'); // Every X days, weeks, etc.
            $table->json('repeat_days')->nullable()->after('repeat_interval'); // For weekly: [1,3,5] = Mon, Wed, Fri
            $table->date('repeat_until')->nullable()->after('repeat_days');
            $table->foreignId('recurring_parent_id')->nullable()->after('repeat_until')->constrained('todos')->onDelete('cascade');
            $table->timestamp('last_generated_at')->nullable()->after('recurring_parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropForeign(['recurring_parent_id']);
            $table->dropColumn([
                'is_recurring',
                'repeat_frequency',
                'repeat_interval',
                'repeat_days',
                'repeat_until',
                'recurring_parent_id',
                'last_generated_at'
            ]);
        });
    }
}; 