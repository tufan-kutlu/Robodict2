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
        Schema::table('robots', function (Blueprint $table) {
            // Add user_id foreign key column
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            
            // Add locale support for multi-language robots
            $table->string('locale', 5)->default('tr')->after('slug');
            
            // Add creation metadata
            $table->timestamp('created_by_admin_at')->nullable()->after('updated_at');
            $table->foreignId('created_by_admin_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Add indexes for performance
            $table->index('user_id');
            $table->index('locale');
            $table->index(['user_id', 'status']); // Composite index for user's active robots
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('robots', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['locale']);
            $table->dropIndex(['user_id']);
            
            // Drop foreign key constraints
            $table->dropForeign(['created_by_admin_id']);
            $table->dropForeign(['user_id']);
            
            // Drop columns
            $table->dropColumn([
                'user_id',
                'locale',
                'created_by_admin_at',
                'created_by_admin_id'
            ]);
        });
    }
};
