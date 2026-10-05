<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. College Course Specializations
        |--------------------------------------------------------------------------
        | Keeps college-specific specialization mapping separate from the
        | existing college_courses.specialization text field.
        */
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
                $table->enum('fee_type', ['per_year', 'per_semester', 'total_course'])
                    ->nullable();
                $table->string('eligibility')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->unique(
                    ['college_course_id', 'specialization_id'],
                    'ccs_course_specialization_unique'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 2. College Highlights
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_highlights')) {
            Schema::create('college_highlights', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 3. College Admission Sections
        |--------------------------------------------------------------------------
        | Supports sections such as:
        | Admission Process, How to Apply, Documents Required,
        | Admission Steps, Important Dates, etc.
        */
        if (! Schema::hasTable('college_admission_sections')) {
            Schema::create('college_admission_sections', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('section_key')->nullable();
                $table->string('title');
                $table->longText('content')->nullable();
                $table->json('items')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 4. College Scholarships
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_scholarships')) {
            Schema::create('college_scholarships', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('name');
                $table->string('eligibility')->nullable();
                $table->string('criteria')->nullable();
                $table->decimal('amount', 12, 2)->nullable();
                $table->string('amount_label')->nullable();
                $table->string('percentage')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 5. College Accreditations / Approvals / Rankings
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_accreditations')) {
            Schema::create('college_accreditations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('authority')->nullable();
                $table->string('accreditation')->nullable();
                $table->string('grade')->nullable();
                $table->string('rank')->nullable();
                $table->string('year')->nullable();
                $table->text('description')->nullable();
                $table->string('certificate_image')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 6. College Placement Statistics
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_placement_stats')) {
            Schema::create('college_placement_stats', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('label');
                $table->string('value');
                $table->string('year')->nullable();
                $table->string('course')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 7. College Recruiters
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_recruiters')) {
            Schema::create('college_recruiters', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('name');
                $table->string('logo')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 8. College Career Outcomes
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_career_outcomes')) {
            Schema::create('college_career_outcomes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('career_role')->nullable();
                $table->string('industry')->nullable();
                $table->string('average_salary')->nullable();
                $table->string('salary_range')->nullable();
                $table->string('job_scope')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 9. College Facilities
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_facilities')) {
            Schema::create('college_facilities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('name');
                $table->string('icon')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 10. College Learning Experience / LMS
        |--------------------------------------------------------------------------
        */
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

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 11. College Loan / EMI Options
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_loan_options')) {
            Schema::create('college_loan_options', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('provider')->nullable();
                $table->string('loan_type')->nullable();
                $table->decimal('amount', 14, 2)->nullable();
                $table->string('interest_rate')->nullable();
                $table->string('tenure')->nullable();
                $table->string('emi_from')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 12. College FAQs
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_faqs')) {
            Schema::create('college_faqs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('question');
                $table->longText('answer');
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 13. College Gallery
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_gallery')) {
            Schema::create('college_gallery', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('title')->nullable();
                $table->string('image');
                $table->string('category')->nullable();
                $table->text('alt_text')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 14. College Documents
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_documents')) {
            Schema::create('college_documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->string('title');
                $table->string('document_type')->nullable();
                $table->string('file_path');
                $table->string('file_name')->nullable();
                $table->string('mime_type')->nullable();
                $table->unsignedBigInteger('file_size')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 15. College Alumni
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | 16. College Reviews
        |--------------------------------------------------------------------------
        */
        if (! Schema::hasTable('college_reviews')) {
            Schema::create('college_reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('college_id')
                    ->constrained('colleges')
                    ->cascadeOnDelete();
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
                $table->string('reviewer_name');
                $table->string('course')->nullable();
                $table->unsignedTinyInteger('rating');
                $table->text('review');
                $table->boolean('is_verified')->default(false);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['college_id', 'status']);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 17. College Comparisons
        |--------------------------------------------------------------------------
        | Stores reusable comparison records between two colleges.
        */
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

                $table->unique(
                    ['college_id', 'compared_college_id'],
                    'college_comparison_unique'
                );
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('college_comparisons');
        Schema::dropIfExists('college_reviews');
        Schema::dropIfExists('college_alumni');
        Schema::dropIfExists('college_documents');
        Schema::dropIfExists('college_gallery');
        Schema::dropIfExists('college_faqs');
        Schema::dropIfExists('college_loan_options');
        Schema::dropIfExists('college_learning_experiences');
        Schema::dropIfExists('college_facilities');
        Schema::dropIfExists('college_career_outcomes');
        Schema::dropIfExists('college_recruiters');
        Schema::dropIfExists('college_placement_stats');
        Schema::dropIfExists('college_accreditations');
        Schema::dropIfExists('college_scholarships');
        Schema::dropIfExists('college_admission_sections');
        Schema::dropIfExists('college_highlights');
        Schema::dropIfExists('college_course_specializations');
    }
};
