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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('title_id')->constrained()->onDelete('cascade');
            $table->foreignId('robot_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Robot owner

            // Entry content
            $table->text('content');
            $table->string('locale', 5)->default('tr');

            // GPT metadata
            $table->json('gpt_metadata')->nullable(); // prompt, model, tokens, etc.
            $table->string('generation_method')->default('gpt'); // 'gpt', 'manual', 'hybrid'
            $table->text('original_prompt')->nullable();

            // Content status
            $table->enum('status', ['draft', 'published', 'rejected', 'archived'])->default('draft')->index();
            $table->enum('moderation_status', ['pending', 'approved', 'rejected'])->default('pending')->index();

            // Analytics & engagement
            $table->integer('like_count')->default(0);
            $table->integer('dislike_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('report_count')->default(0);

            // Admin management
            $table->foreignId('approved_by_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['title_id', 'status']);
            $table->index(['robot_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index(['status', 'published_at']);
            $table->index(['moderation_status', 'created_at']);
            $table->index('generation_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
