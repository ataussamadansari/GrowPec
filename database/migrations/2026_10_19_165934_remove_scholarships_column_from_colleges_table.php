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
        if (Schema::hasColumn('colleges', 'scholarships')) {
            Schema::table('colleges', function (Blueprint $table) {
                $table->dropColumn('scholarships');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('colleges', 'scholarships')) {
            Schema::table('colleges', function (Blueprint $table) {
                $table->longText('scholarships')->nullable();
            });
        }
    }
};
