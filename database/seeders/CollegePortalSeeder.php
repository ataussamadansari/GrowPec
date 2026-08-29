<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stream;
use App\Models\Course;
use App\Models\College;
use App\Models\CollegeCourse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CollegePortalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Super Admin
        User::updateOrCreate(
            ['email' => 'admin@growpec.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'phone' => '9999999999'
            ]
        );

        // 2. Create Streams
        $mgmt = Stream::create(['name' => 'Management', 'slug' => 'management']);
        $engg = Stream::create(['name' => 'Engineering', 'slug' => 'engineering']);
        $pharma = Stream::create(['name' => 'Pharmacy & Medical', 'slug' => 'pharmacy-medical']);
        $it = Stream::create(['name' => 'Computer Applications / IT', 'slug' => 'it-computer']);

        // 3. Create Courses
        $bca = Course::create(['stream_id' => $it->id, 'name' => 'BCA', 'slug' => 'bca', 'level' => 'UG', 'degree_type' => 'Degree', 'duration' => '3 Years']);
        $mca = Course::create(['stream_id' => $it->id, 'name' => 'MCA', 'slug' => 'mca', 'level' => 'PG', 'degree_type' => 'Degree', 'duration' => '2 Years']);
        $mba = Course::create(['stream_id' => $mgmt->id, 'name' => 'MBA', 'slug' => 'mba', 'level' => 'PG', 'degree_type' => 'Degree', 'duration' => '2 Years']);
        $btech = Course::create(['stream_id' => $engg->id, 'name' => 'B.Tech', 'slug' => 'btech', 'level' => 'UG', 'degree_type' => 'Degree', 'duration' => '4 Years']);
        $dpharm = Course::create(['stream_id' => $pharma->id, 'name' => 'D.Pharm', 'slug' => 'dpharm', 'level' => 'Diploma', 'degree_type' => 'Diploma', 'duration' => '2 Years']);
        $bpharm = Course::create(['stream_id' => $pharma->id, 'name' => 'B.Pharm', 'slug' => 'bpharm', 'level' => 'UG', 'degree_type' => 'Degree', 'duration' => '4 Years']);

        // 4. Create Sample Colleges
        $amity = College::create([
            'name' => 'Amity University',
            'slug' => 'amity-university-lucknow',
            'college_mode' => 'regular',
            'college_type' => 'Private',
            'university_name' => 'Amity University Uttar Pradesh',
            'state' => 'Uttar Pradesh',
            'city' => 'Lucknow',
            'address' => 'Malhaur, Gomti Nagar Extension, Lucknow',
            'established_year' => '2004',
            'approvals' => 'UGC, AICTE, NAAC A+',
            'has_boys_hostel' => true,
            'has_girls_hostel' => true,
            'is_featured' => true,
            'overview' => 'Amity University Lucknow Campus is a constituent unit of Amity University Uttar Pradesh.'
        ]);

        $atlas = College::create([
            'name' => 'ATLAS SkillTech University Online',
            'slug' => 'atlas-skilltech-university-online',
            'college_mode' => 'online',
            'college_type' => 'Private',
            'university_name' => 'ATLAS SkillTech University',
            'state' => 'Maharashtra',
            'city' => 'Mumbai',
            'established_year' => '2021',
            'approvals' => 'UGC, DEB, AICTE',
            'is_featured' => true,
            'overview' => 'India\'s leading futuristic digital learning university.'
        ]);

        // 5. Attach Courses & Fees
        CollegeCourse::create(['college_id' => $amity->id, 'course_id' => $bca->id, 'fee_amount' => 110000, 'fee_type' => 'per_year', 'eligibility' => '10+2 with 50%']);
        CollegeCourse::create(['college_id' => $amity->id, 'course_id' => $mba->id, 'fee_amount' => 240000, 'fee_type' => 'per_year', 'eligibility' => 'Graduation with 50%']);
        CollegeCourse::create(['college_id' => $amity->id, 'course_id' => $btech->id, 'fee_amount' => 190000, 'fee_type' => 'per_year', 'eligibility' => '10+2 PCM with 60%']);

        CollegeCourse::create(['college_id' => $atlas->id, 'course_id' => $mba->id, 'fee_amount' => 95000, 'fee_type' => 'per_year', 'eligibility' => 'Graduation Any Stream']);
        CollegeCourse::create(['college_id' => $atlas->id, 'course_id' => $bca->id, 'fee_amount' => 60000, 'fee_type' => 'per_year', 'eligibility' => '10+2 Any Stream']);
    }
}