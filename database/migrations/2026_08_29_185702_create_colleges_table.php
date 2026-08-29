<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('banner_image')->nullable();
            $table->enum('college_mode', ['regular', 'online', 'both'])->default('regular');
            $table->enum('college_type', ['Govt', 'Private', 'Deemed', 'Autonomous'])->default('Private');
            $table->string('university_name')->nullable();
            
            // Location
            $table->string('state');
            $table->string('city');
            $table->text('address')->nullable();
            
            // Quick Facts
            $table->string('established_year')->nullable();
            $table->string('campus_size')->nullable();
            $table->string('approvals')->nullable();
            $table->string('entrance_exams')->nullable();
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->integer('reviews_count')->default(150);
            
            // Placements
            $table->string('highest_package')->nullable();
            $table->string('average_package')->nullable();
            $table->text('top_recruiters')->nullable();
            
            // Hostels & Facilities
            $table->boolean('has_boys_hostel')->default(false);
            $table->boolean('has_girls_hostel')->default(false);
            $table->json('facilities')->nullable();
            
            // Detailed Sections
            $table->longText('overview')->nullable();
            $table->longText('admission_process')->nullable();
            $table->longText('scholarship_info')->nullable();
            $table->string('sample_certificate_image')->nullable();
            $table->string('brochure_pdf')->nullable();
            
            // FAQs & Highlights
            $table->json('faqs')->nullable();
            $table->json('highlights')->nullable();
            
            // Status Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};