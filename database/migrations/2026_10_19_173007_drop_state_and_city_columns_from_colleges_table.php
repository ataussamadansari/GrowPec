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
            if (Schema::hasColumn('colleges', 'state')) {
                $table->dropColumn('state');
            }
            if (Schema::hasColumn('colleges', 'city')) {
                $table->dropColumn('city');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->string('state')->nullable();
            $table->string('city')->nullable();
        });
    }
};
