<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Normalized student location.
            $table->foreignId('state_id')
                ->nullable()
                ->after('state')
                ->constrained('states')
                ->nullOnDelete();

            $table->foreignId('city_id')
                ->nullable()
                ->after('state_id')
                ->constrained('cities')
                ->nullOnDelete();

            // Exact program selected on a college page.
            $table->foreignId('college_course_id')
                ->nullable()
                ->after('college_id')
                ->constrained('college_courses')
                ->nullOnDelete();

            $table->foreignId('specialization_id')
                ->nullable()
                ->after('course_id')
                ->constrained('specializations')
                ->nullOnDelete();

            // CRM fields.
            $table->foreignId('assigned_to')
                ->nullable()
                ->after('status')
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('next_followup_at')
                ->nullable()
                ->after('assigned_to');

            $table->dateTime('contacted_at')
                ->nullable()
                ->after('next_followup_at');

            $table->dateTime('closed_at')
                ->nullable()
                ->after('contacted_at');

            $table->string('preferred_mode')
                ->nullable()
                ->after('source');

            $table->text('message')
                ->nullable()
                ->after('preferred_mode');

            $table->string('utm_source')->nullable()->after('message');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');

            $table->index(['status', 'next_followup_at']);
            $table->index(['college_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropIndex(['status', 'next_followup_at']);
            $table->dropIndex(['college_id', 'course_id']);

            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['college_course_id']);
            $table->dropForeign(['specialization_id']);
            $table->dropForeign(['assigned_to']);

            $table->dropColumn([
                'state_id',
                'city_id',
                'college_course_id',
                'specialization_id',
                'assigned_to',
                'next_followup_at',
                'contacted_at',
                'closed_at',
                'preferred_mode',
                'message',
                'utm_source',
                'utm_medium',
                'utm_campaign',
            ]);
        });
    }
};
