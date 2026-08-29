<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stream_id')->constrained('streams')->onDelete('cascade');
            $table->string('name'); // e.g. BCA, MBA, B.Pharm, D.Pharm, ANM, B.Tech
            $table->string('slug')->unique();
            $table->enum('level', ['UG', 'PG', 'Diploma', 'PhD', 'Certificate'])->default('UG');
            $table->enum('degree_type', ['Degree', 'Diploma', 'Certificate'])->default('Degree');
            $table->string('duration')->default('3 Years'); // 1 Year, 2 Years, 3 Years, 4 Years
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};