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
        Schema::table('users', function (Blueprint $table) {
            // Locale support for multi-language
            $table->string('locale', 5)->default('tr')->after('email');

            // Plan type for freemium model
            $table->enum('plan_type', ['free', 'pro'])->default('free')->after('locale');

            // Robot creation limits based on plan
            $table->integer('robot_limit')->default(5)->after('plan_type');

            // Admin role flag
            $table->boolean('is_admin')->default(false)->after('robot_limit');

            // User status
            $table->boolean('is_active')->default(true)->after('is_admin');

            // Index for performance
            $table->index(['locale', 'plan_type']);
            $table->index('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['locale', 'plan_type']);
            $table->dropIndex(['is_admin']);

            // Drop columns
            $table->dropColumn([
                'locale',
                'plan_type',
                'robot_limit',
                'is_admin',
                'is_active'
            ]);
        });
    }
};
