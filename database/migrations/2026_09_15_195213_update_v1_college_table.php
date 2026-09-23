<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Complete the advanced College / College Course schema.
     *
     * IMPORTANT:
     * The existing 2026_09_15_191011_update_college_table migration
     * creates the 17 advanced child tables, but it does NOT add the
     * advanced columns/FKs required by the College models/controllers.
     *
     * This migration is intentionally safe for an already-running database:
     * every column/table is checked before it is created.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Colleges - advanced fields
        |--------------------------------------------------------------------------
        */
        Schema::table('colleges', function (Blueprint $table) {
            if (! Schema::hasColumn('colleges', 'state_id')) {
                $table->foreignId('state_id')
                    ->nullable()
                    ->after('state');
            }

            if (! Schema::hasColumn('colleges', 'city_id')) {
                $table->foreignId('city_id')
                    ->nullable()
                    ->after('city');
            }

            if (! Schema::hasColumn('colleges', 'short_name')) {
                $table->string('short_name')->nullable()->after('name');
            }

            if (! Schema::hasColumn('colleges', 'website')) {
                $table->string('website')->nullable()->after('university_name');
            }

            if (! Schema::hasColumn('colleges', 'naac_grade')) {
                $table->string('naac_grade')->nullable();
            }

            if (! Schema::hasColumn('colleges', 'ugc_approved')) {
                $table->boolean('ugc_approved')->default(false);
            }

            if (! Schema::hasColumn('colleges', 'nirf_rank')) {
                $table->string('nirf_rank')->nullable();
            }

            if (! Schema::hasColumn('colleges', 'nirf_year')) {
                $table->string('nirf_year')->nullable();
            }

            if (! Schema::hasColumn('colleges', 'seo_title')) {
                $table->string('seo_title')->nullable();
            }

            if (! Schema::hasColumn('colleges', 'seo_description')) {
                $table->text('seo_description')->nullable();
            }
        });

        // Add indexes/FKs separately so this migration remains safe if columns
        // already existed from a partial/manual schema update.
        if (Schema::hasColumn('colleges', 'state_id')) {
            try {
                Schema::table('colleges', function (Blueprint $table) {
                    $table->foreign('state_id')
                        ->references('id')
                        ->on('states')
                        ->nullOnDelete();
                });
            } catch (Throwable $e) {
                // FK may already exist; leave the existing constraint untouched.
            }
        }

        if (Schema::hasColumn('colleges', 'city_id')) {
            try {
                Schema::table('colleges', function (Blueprint $table) {
                    $table->foreign('city_id')
                        ->references('id')
                        ->on('cities')
                        ->nullOnDelete();
                });
            } catch (Throwable $e) {
                // FK may already exist; leave the existing constraint untouched.
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 2. College Courses - advanced fields
        |--------------------------------------------------------------------------
        */
        Schema::table('college_courses', function (Blueprint $table) {
            if (! Schema::hasColumn('college_courses', 'specialization_id')) {
                $table->foreignId('specialization_id')
                    ->nullable()
                    ->after('specialization');
            }

            if (! Schema::hasColumn('college_courses', 'academic_session')) {
                $table->string('academic_session')->nullable();
            }

            if (! Schema::hasColumn('college_courses', 'duration')) {
                $table->string('duration')->nullable();
            }

            if (! Schema::hasColumn('college_courses', 'application_url')) {
                $table->string('application_url')->nullable();
            }

            if (! Schema::hasColumn('college_courses', 'brochure')) {
                $table->string('brochure')->nullable();
            }

            if (! Schema::hasColumn('college_courses', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0);
            }

            if (! Schema::hasColumn('college_courses', 'status')) {
                $table->boolean('status')->default(true);
            }
        });

        if (Schema::hasColumn('college_courses', 'specialization_id')) {
            try {
                Schema::table('college_courses', function (Blueprint $table) {
                    $table->foreign('specialization_id')
                        ->references('id')
                        ->on('specializations')
                        ->nullOnDelete();
                });
            } catch (Throwable $e) {
                // FK may already exist.
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Course Fees
        |--------------------------------------------------------------------------
        |
        | Keeps the existing college_courses.fee_amount field for backwards
        | compatibility while allowing multiple fee records per college course.
        |--------------------------------------------------------------------------
        */
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

                $table->index(
                    ['college_course_id', 'status'],
                    'ccf_course_status_index'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Backfill state_id / city_id from the existing string fields
        |--------------------------------------------------------------------------
        |
        | Existing colleges already store state/city as text. We do not delete
        | those columns; we simply populate the new relational IDs where a
        | matching active record exists.
        |--------------------------------------------------------------------------
        */
        if (
            Schema::hasColumn('colleges', 'state_id') &&
            Schema::hasColumn('colleges', 'city_id') &&
            Schema::hasTable('states') &&
            Schema::hasTable('cities')
        ) {
            DB::statement('
                UPDATE colleges c
                INNER JOIN states s
                    ON LOWER(TRIM(s.name)) = LOWER(TRIM(c.state))
                SET c.state_id = s.id
                WHERE c.state_id IS NULL
            ');

            DB::statement('
                UPDATE colleges c
                INNER JOIN cities ci
                    ON ci.state_id = c.state_id
                    AND LOWER(TRIM(ci.name)) = LOWER(TRIM(c.city))
                SET c.city_id = ci.id
                WHERE c.city_id IS NULL
            ');
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Reverse only what this migration added.
        |--------------------------------------------------------------------------
        */

        if (Schema::hasTable('college_course_fees')) {
            Schema::dropIfExists('college_course_fees');
        }

        if (Schema::hasColumn('college_courses', 'specialization_id')) {
            try {
                Schema::table('college_courses', function (Blueprint $table) {
                    $table->dropForeign(['specialization_id']);
                });
            } catch (Throwable $e) {
                // Constraint may not exist.
            }
        }

        Schema::table('college_courses', function (Blueprint $table) {
            $columns = [];

            foreach ([
                'specialization_id',
                'academic_session',
                'duration',
                'application_url',
                'brochure',
                'sort_order',
                'status',
            ] as $column) {
                if (Schema::hasColumn('college_courses', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns) {
                $table->dropColumn($columns);
            }
        });

        if (Schema::hasColumn('colleges', 'state_id')) {
            try {
                Schema::table('colleges', function (Blueprint $table) {
                    $table->dropForeign(['state_id']);
                });
            } catch (Throwable $e) {
                // Constraint may not exist.
            }
        }

        if (Schema::hasColumn('colleges', 'city_id')) {
            try {
                Schema::table('colleges', function (Blueprint $table) {
                    $table->dropForeign(['city_id']);
                });
            } catch (Throwable $e) {
                // Constraint may not exist.
            }
        }

        Schema::table('colleges', function (Blueprint $table) {
            $columns = [];

            foreach ([
                'state_id',
                'city_id',
                'short_name',
                'website',
                'naac_grade',
                'ugc_approved',
                'nirf_rank',
                'nirf_year',
                'seo_title',
                'seo_description',
            ] as $column) {
                if (Schema::hasColumn('colleges', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
