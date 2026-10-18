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
        Schema::table('colleges', function (Blueprint $table) {
            if (! Schema::hasColumn('colleges', 'institution_category')) {
                $table->string('institution_category', 50)->default('University')->after('college_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            if (Schema::hasColumn('colleges', 'institution_category')) {
                $table->dropColumn('institution_category');
            }
        });
    }
};
