<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('college_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->constrained('colleges')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('specialization')->nullable(); // e.g. Cloud Computing, Finance, General
            $table->decimal('fee_amount', 10, 2); // e.g. 75000.00
            $table->enum('fee_type', ['per_year', 'per_semester', 'total_course'])->default('per_year');
            $table->string('eligibility')->nullable(); // e.g. 10+2 with 50%
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('college_courses');
    }
};