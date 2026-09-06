<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stream;
use App\Models\Course;
use App\Models\College;
use App\Models\CollegeCourse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CollegePortalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or Update Super Admin
        User::updateOrCreate(
            ['email' => 'admin@growpec.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password123'),
                'role'     => 'super_admin',
                'phone'    => '9999999999'
            ]
        );

        // 2. Streams (firstOrCreate se duplicate error nahi aayega)
        $mgmt = Stream::firstOrCreate(
            ['slug' => 'management'],
            ['name' => 'Management', 'icon' => 'bi-briefcase']
        );

        $engg = Stream::firstOrCreate(
            ['slug' => 'engineering'],
            ['name' => 'Engineering', 'icon' => 'bi-gear']
        );

        $pharma = Stream::firstOrCreate(
            ['slug' => 'pharmacy-medical'],
            ['name' => 'Pharmacy & Medical', 'icon' => 'bi-capsule']
        );

        $it = Stream::firstOrCreate(
            ['slug' => 'it-computer'],
            ['name' => 'Computer Applications / IT', 'icon' => 'bi-laptop']
        );

        // 3. Courses
        $bca = Course::firstOrCreate(
            ['slug' => 'bca'],
            ['stream_id' => $it->id, 'name' => 'BCA', 'level' => 'UG', 'degree_type' => 'Degree', 'duration' => '3 Years']
        );

        $mca = Course::firstOrCreate(
            ['slug' => 'mca'],
            ['stream_id' => $it->id, 'name' => 'MCA', 'level' => 'PG', 'degree_type' => 'Degree', 'duration' => '2 Years']
        );

        $mba = Course::firstOrCreate(
            ['slug' => 'mba'],
            ['stream_id' => $mgmt->id, 'name' => 'MBA', 'level' => 'PG', 'degree_type' => 'Degree', 'duration' => '2 Years']
        );

        $btech = Course::firstOrCreate(
            ['slug' => 'btech'],
            ['stream_id' => $engg->id, 'name' => 'B.Tech', 'level' => 'UG', 'degree_type' => 'Degree', 'duration' => '4 Years']
        );

        $dpharm = Course::firstOrCreate(
            ['slug' => 'dpharm'],
            ['stream_id' => $pharma->id, 'name' => 'D.Pharm', 'level' => 'Diploma', 'degree_type' => 'Diploma', 'duration' => '2 Years']
        );

        $bpharm = Course::firstOrCreate(
            ['slug' => 'bpharm'],
            ['stream_id' => $pharma->id, 'name' => 'B.Pharm', 'level' => 'UG', 'degree_type' => 'Degree', 'duration' => '4 Years']
        );

        // 4. Colleges
        $amity = College::firstOrCreate(
            ['slug' => 'amity-university-lucknow'],
            [
                'name'             => 'Amity University',
                'college_mode'     => 'regular',
                'college_type'     => 'Private',
                'university_name'  => 'Amity University Uttar Pradesh',
                'state'            => 'Uttar Pradesh',
                'city'             => 'Lucknow',
                'address'          => 'Malhaur, Gomti Nagar Extension, Lucknow',
                'established_year' => '2004',
                'approvals'        => 'UGC, AICTE, NAAC A+',
                'highest_package'  => '24.0 LPA',
                'average_package'  => '6.5 LPA',
                'top_recruiters'   => 'Amazon, TCS, Infosys, Wipro, Deloitte',
                'has_boys_hostel'  => true,
                'has_girls_hostel' => true,
                'is_featured'      => true,
                'status'           => true,
                'overview'         => 'Amity University Lucknow Campus is a constituent unit of Amity University Uttar Pradesh.',
                'highlights'       => [
                    '100% Placement & Interview Training Assistance',
                    'UGC, AICTE & NAAC A+ Accredited',
                    'Flexible No-Cost EMI & Scholarships Available'
                ],
                'faqs'             => [
                    ['question' => 'Is this degree recognized?', 'answer' => 'Yes, all degrees hold complete government and UGC approvals.'],
                    ['question' => 'How can I apply?', 'answer' => 'Submit your details via the admission form on the right.']
                ]
            ]
        );

        $atlas = College::firstOrCreate(
            ['slug' => 'atlas-skilltech-university-online'],
            [
                'name'             => 'ATLAS SkillTech University Online',
                'college_mode'     => 'online',
                'college_type'     => 'Private',
                'university_name'  => 'ATLAS SkillTech University',
                'state'            => 'Maharashtra',
                'city'             => 'Mumbai',
                'established_year' => '2021',
                'approvals'        => 'UGC, DEB, AICTE',
                'highest_package'  => '18.0 LPA',
                'average_package'  => '5.5 LPA',
                'top_recruiters'   => 'TCS, Infosys, HCL, Accenture',
                'has_boys_hostel'  => false,
                'has_girls_hostel' => false,
                'is_featured'      => true,
                'status'           => true,
                'overview'         => 'India\'s leading futuristic digital learning university offering UGC-DEB approved online degrees.',
                'highlights'       => [
                    '100% Online Recorded & Live Classes',
                    'UGC-DEB Approved Degree with Worldwide Validity',
                    'Dedicated Career Placement Cell'
                ],
                'faqs'             => [
                    ['question' => 'Are online exams conducted?', 'answer' => 'Yes, examinations are conducted completely online from anywhere.']
                ]
            ]
        );

        // 5. College Courses Linkage
        CollegeCourse::firstOrCreate(
            ['college_id' => $amity->id, 'course_id' => $bca->id],
            ['fee_amount' => 110000, 'fee_type' => 'per_year', 'eligibility' => '10+2 with 50%', 'specialization' => 'Cloud Computing & AI']
        );

        CollegeCourse::firstOrCreate(
            ['college_id' => $amity->id, 'course_id' => $mba->id],
            ['fee_amount' => 240000, 'fee_type' => 'per_year', 'eligibility' => 'Graduation with 50%', 'specialization' => 'Marketing & Finance']
        );

        CollegeCourse::firstOrCreate(
            ['college_id' => $amity->id, 'course_id' => $btech->id],
            ['fee_amount' => 190000, 'fee_type' => 'per_year', 'eligibility' => '10+2 PCM with 60%', 'specialization' => 'Computer Science']
        );

        CollegeCourse::firstOrCreate(
            ['college_id' => $atlas->id, 'course_id' => $mba->id],
            ['fee_amount' => 95000, 'fee_type' => 'per_year', 'eligibility' => 'Graduation Any Stream', 'specialization' => 'Digital Business']
        );

        CollegeCourse::firstOrCreate(
            ['college_id' => $atlas->id, 'course_id' => $bca->id],
            ['fee_amount' => 60000, 'fee_type' => 'per_year', 'eligibility' => '10+2 Any Stream', 'specialization' => 'Software Development']
        );
    }
}