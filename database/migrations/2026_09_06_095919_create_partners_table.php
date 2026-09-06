<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // University / Partner Name
            $table->string('logo')->nullable();   // Logo image path
            $table->integer('sort_order')->default(0); // Ordering index
            $table->boolean('status')->default(true);  // Active / Inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};