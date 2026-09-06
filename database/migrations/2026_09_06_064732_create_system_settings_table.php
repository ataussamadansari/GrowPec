<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->index(); // e.g. theme.primary_color, api.fcm_key
            $table->longText('value')->nullable();
            $table->string('group')->default('general'); // general, theme, features, apis
            $table->string('type')->default('string');   // string, boolean, text, image, json
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};