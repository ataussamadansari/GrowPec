<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Normalize the college schema:
 *
 * 1. Change college_mode enum from ('regular','online','both')
 *    to ('regular','online') — any 'both' rows become 'regular'.
 * 2. Ensure college_courses has all required columns and relations.
 * 3. Add missing indexes where safe.
 */
return new class extends Migration
{
    public function up(): void
    {
        /*
        |----------------------------------------------------------------------
        | 1. Migrate 'both' → 'regular' before touching the enum
        |----------------------------------------------------------------------
        */
        DB::statement("UPDATE colleges SET college_mode = 'regular' WHERE college_mode = 'both'");

        /*
        |----------------------------------------------------------------------
        | 2. Re-create the enum without 'both'
        |    MySQL allows ALTER COLUMN MODIFY for enum changes.
        |----------------------------------------------------------------------
        */
        DB::statement("ALTER TABLE colleges MODIFY COLUMN college_mode ENUM('regular','online') NOT NULL DEFAULT 'regular'");

        /*
        |----------------------------------------------------------------------
        | 3. college_courses – add missing columns
        |----------------------------------------------------------------------
        */
        Schema::table('college_courses', function (Blueprint $table) {
            if (! Schema::hasColumn('college_courses', 'seats')) {
                $table->unsignedInteger('seats')->nullable()->after('eligibility');
            }
            if (! Schema::hasColumn('college_courses', 'entrance_exam')) {
                $table->string('entrance_exam')->nullable()->after('seats');
            }
        });

        /*
        |----------------------------------------------------------------------
        | 4. college_course_specializations – ensure all needed columns exist
        |    (table was created in 2026_09_15_191011 migration)
        |----------------------------------------------------------------------
        */
        if (Schema::hasTable('college_course_specializations')) {
            Schema::table('college_course_specializations', function (Blueprint $table) {
                if (! Schema::hasColumn('college_course_specializations', 'seats')) {
                    $table->unsignedInteger('seats')->nullable();
                }
                if (! Schema::hasColumn('college_course_specializations', 'entrance_exam')) {
                    $table->string('entrance_exam')->nullable();
                }
                if (! Schema::hasColumn('college_course_specializations', 'sort_order')) {
                    $table->unsignedInteger('sort_order')->default(0);
                }
            });
        }

        /*
        |----------------------------------------------------------------------
        | 5. college_highlights – ensure icon column exists
        |----------------------------------------------------------------------
        */
        if (Schema::hasTable('college_highlights')) {
            Schema::table('college_highlights', function (Blueprint $table) {
                if (! Schema::hasColumn('college_highlights', 'value')) {
                    $table->string('value')->nullable()->after('title');
                }
            });
        }

        /*
        |----------------------------------------------------------------------
        | 6. college_placement_stats – ensure placement_type column
        |----------------------------------------------------------------------
        */
        if (Schema::hasTable('college_placement_stats')) {
            Schema::table('college_placement_stats', function (Blueprint $table) {
                if (! Schema::hasColumn('college_placement_stats', 'placement_percentage')) {
                    $table->string('placement_percentage')->nullable()->after('value');
                }
            });
        }
    }

    public function down(): void
    {
        // Revert enum back to original (includes 'both')
        DB::statement("ALTER TABLE colleges MODIFY COLUMN college_mode ENUM('regular','online','both') NOT NULL DEFAULT 'regular'");

        Schema::table('college_courses', function (Blueprint $table) {
            $cols = [];
            foreach (['seats', 'entrance_exam'] as $col) {
                if (Schema::hasColumn('college_courses', $col)) {
                    $cols[] = $col;
                }
            }
            if ($cols) {
                $table->dropColumn($cols);
            }
        });

        if (Schema::hasTable('college_course_specializations')) {
            Schema::table('college_course_specializations', function (Blueprint $table) {
                $cols = [];
                foreach (['seats', 'entrance_exam', 'sort_order'] as $col) {
                    if (Schema::hasColumn('college_course_specializations', $col)) {
                        $cols[] = $col;
                    }
                }
                if ($cols) {
                    $table->dropColumn($cols);
                }
            });
        }

        if (Schema::hasTable('college_highlights')) {
            Schema::table('college_highlights', function (Blueprint $table) {
                if (Schema::hasColumn('college_highlights', 'value')) {
                    $table->dropColumn('value');
                }
            });
        }

        if (Schema::hasTable('college_placement_stats')) {
            Schema::table('college_placement_stats', function (Blueprint $table) {
                if (Schema::hasColumn('college_placement_stats', 'placement_percentage')) {
                    $table->dropColumn('placement_percentage');
                }
            });
        }
    }
};
