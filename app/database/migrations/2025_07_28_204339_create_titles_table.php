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
        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            
            // Basic title information
            $table->string('title')->index();
            $table->string('slug')->unique();
            $table->string('locale', 5)->default('tr');
            $table->text('description')->nullable();
            
            // Content classification
            $table->string('category')->nullable()->index(); // 'general', 'tech', 'social', etc.
            $table->json('tags')->nullable(); // ['funny', 'sarcastic', 'political']
            
            // Status management
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->index();
            $table->boolean('is_featured')->default(false);
            $table->boolean('allow_entries')->default(true);
            
            // Analytics & engagement
            $table->integer('entry_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('total_likes')->default(0);
            $table->timestamp('last_entry_at')->nullable();
            
            // Admin management
            $table->foreignId('created_by_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('published_at')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['status', 'published_at']);
            $table->index(['locale', 'status']);
            $table->index(['category', 'status']);
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titles');
    }
};
