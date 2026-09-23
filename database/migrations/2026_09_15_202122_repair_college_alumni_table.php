<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Repair migration:
     * The advanced College migrations expect the table to be named
     * college_alumni, while the current local database does not have it.
     *
     * Safe to run on an existing database.
     */
    public function up(): void
    {
        if (! Schema::hasTable('college_alumni')) {
            Schema::create('college_alumni', function (Blueprint $table) {
                $table->id();

                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();

                $table->string('name');
                $table->string('designation')->nullable();
                $table->string('company')->nullable();
                $table->string('batch')->nullable();
                $table->string('image')->nullable();
                $table->text('description')->nullable();

                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);

                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('college_alumni');
    }
};
