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
            $colsToDrop = [];
            foreach (['faqs', 'facilities', 'highlights', 'top_recruiters'] as $col) {
                if (Schema::hasColumn('colleges', $col)) {
                    $colsToDrop[] = $col;
                }
            }
            if (! empty($colsToDrop)) {
                $table->dropColumn($colsToDrop);
            }
        });

        Schema::dropIfExists('college_alumni');
        Schema::dropIfExists('college_documents');
        Schema::dropIfExists('college_loan_options');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            if (! Schema::hasColumn('colleges', 'faqs')) {
                $table->json('faqs')->nullable();
            }
            if (! Schema::hasColumn('colleges', 'facilities')) {
                $table->json('facilities')->nullable();
            }
            if (! Schema::hasColumn('colleges', 'highlights')) {
                $table->json('highlights')->nullable();
            }
            if (! Schema::hasColumn('colleges', 'top_recruiters')) {
                $table->text('top_recruiters')->nullable();
            }
        });
    }
};
