<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('banners');
        
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Optional banner label
            $table->string('image');             // Banner image path
            $table->integer('sort_order')->default(0); // Index / ordering
            $table->boolean('status')->default(true);  // Active / Inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};