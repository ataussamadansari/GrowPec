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
        if (! Schema::hasTable('website_reviews')) {
            Schema::create('website_reviews', function (Blueprint $table) {
                $table->id();
                $table->string('reviewer_name', 100);
                $table->string('email', 150);
                $table->unsignedTinyInteger('rating');
                $table->string('title', 150)->nullable();
                $table->text('review');
                $table->enum('status', ['pending', 'approved', 'rejected', 'flagged'])->default('pending');
                $table->string('ip_address', 45)->nullable();
                $table->boolean('is_featured')->default(false);
                $table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('moderated_at')->nullable();
                $table->string('moderation_reason', 255)->nullable();
                $table->timestamps();

                $table->index(['status', 'created_at']);
                $table->index('rating');
                $table->index(['status', 'is_featured']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_reviews');
    }
};
