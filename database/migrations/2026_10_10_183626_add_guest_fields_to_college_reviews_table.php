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
        Schema::table('college_reviews', function (Blueprint $table) {
            $table->string('email', 255)->after('reviewer_name');
            $table->string('ip_address', 45)->nullable()->after('review');
            $table->string('status', 20)->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('college_reviews', function (Blueprint $table) {
            $table->boolean('status')->default(true)->change();
            $table->dropColumn(['email', 'ip_address']);
        });
    }
};
