<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Safely drops obsolete and duplicate child tables.
     */
    public function up(): void
    {
        Schema::dropIfExists('college_course_fees');
        Schema::dropIfExists('college_course_specializations');
        Schema::dropIfExists('college_learning_experiences');
        Schema::dropIfExists('college_comparisons');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('college_course_fees')) {
            Schema::create('college_course_fees', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_course_id')
                    ->constrained('college_courses')
                    ->cascadeOnDelete();
                $table->string('fee_type')->nullable();
                $table->string('label')->nullable();
                $table->decimal('amount', 12, 2)->nullable();
                $table->string('academic_session')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('college_course_specializations')) {
            Schema::create('college_course_specializations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_course_id')
                    ->constrained('college_courses')
                    ->cascadeOnDelete();
                $table->foreignId('specialization_id')
                    ->constrained('specializations')
                    ->cascadeOnDelete();
                $table->decimal('fee_amount', 12, 2)->nullable();
                $table->string('fee_type')->nullable();
                $table->string('eligibility')->nullable();
                $table->unsignedInteger('seats')->nullable();
                $table->string('entrance_exam')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('college_learning_experiences')) {
            Schema::create('college_learning_experiences', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->string('type')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('college_comparisons')) {
            Schema::create('college_comparisons', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->foreignId('compared_college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('title')->nullable();
                $table->json('comparison_data')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }
    }
};
