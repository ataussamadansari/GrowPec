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
        $deadColumns = [
            'placement_details',
            'learning_details',
            'degree_details',
            'fee_emi_plans',
            'campus_facilities',
            'rankings',
        ];

        Schema::table('colleges', function (Blueprint $table) use ($deadColumns) {
            foreach ($deadColumns as $column) {
                if (Schema::hasColumn('colleges', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->longText('placement_details')->nullable();
            $table->longText('learning_details')->nullable();
            $table->longText('degree_details')->nullable();
            $table->longText('fee_emi_plans')->nullable();
            $table->longText('campus_facilities')->nullable();
            $table->longText('rankings')->nullable();
        });
    }
};
