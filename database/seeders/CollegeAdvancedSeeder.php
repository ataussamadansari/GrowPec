<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CollegeAdvancedSeeder extends Seeder
{
    /**
     * GrowPEC demo college seeder.
     *
     * This seeder:
     * 1. Converts existing basic college records (matching these slugs) into advanced records.
     * 2. Creates 5 complete college records.
     * 3. Creates course + specialization mappings.
     * 4. Populates all advanced college-detail sections.
     *
     * NOTE:
     * This seeder is designed to run on the existing GrowPEC database.
     * It updates matching basic colleges in-place and adds advanced child data;
     * it does not require dropping the existing basic college table/data.
     *
     * This is DEMO/TEST content for UI development.
     * Placement, ranking, fee and salary figures should be replaced
     * with verified institutional data before production publishing.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $now = now();

            $this->seedBaseAcademicData($now);

            $colleges = [
                [
                    'name' => 'Amity University Lucknow',
                    'short_name' => 'Amity Lucknow',
                    'slug' => 'amity-university-lucknow',
                    'mode' => 'regular',
                    'type' => 'Private',
                    'university' => 'Amity University Uttar Pradesh',
                    'state' => 'Uttar Pradesh',
                    'city' => 'Lucknow',
                    'address' => 'Malhaur, Gomti Nagar Extension, Lucknow',
                    'year' => '2004',
                    'campus' => '24 Acres',
                    'approvals' => 'UGC, AICTE, NAAC',
                    'naac' => 'A+',
                    'nirf' => 'Top ranked private university category',
                    'entrance' => 'CAT, MAT, CUET, University Entrance',
                    'rating' => 4.8,
                    'reviews' => 420,
                    'highest' => '24 LPA',
                    'average' => '6.5 LPA',
                    'recruiters' => ['Amazon', 'TCS', 'Infosys', 'Wipro', 'Deloitte'],
                    'overview' => 'Amity University Lucknow is a multi-disciplinary private university campus offering undergraduate and postgraduate programmes across management, engineering and computing.',
                    'featured' => true,
                    'hostel_boys' => true,
                    'hostel_girls' => true,
                    'courses' => [
                        ['course' => 'BCA', 'specialization' => 'Software Development', 'fee' => 110000, 'eligibility' => '10+2 with minimum 50%', 'duration' => '3 Years'],
                        ['course' => 'MBA', 'specialization' => 'Business Analytics', 'fee' => 240000, 'eligibility' => 'Graduation with minimum 50%', 'duration' => '2 Years'],
                        ['course' => 'B.Tech', 'specialization' => 'Computer Science & Engineering', 'fee' => 190000, 'eligibility' => '10+2 PCM with minimum 60%', 'duration' => '4 Years'],
                    ],
                ],
                [
                    'name' => 'ATLAS SkillTech University Online',
                    'short_name' => 'ATLAS Online',
                    'slug' => 'atlas-skilltech-university-online',
                    'mode' => 'online',
                    'type' => 'Private',
                    'university' => 'ATLAS SkillTech University',
                    'state' => 'Maharashtra',
                    'city' => 'Mumbai',
                    'address' => 'Mumbai, Maharashtra',
                    'year' => '2021',
                    'campus' => 'Online / Digital Campus',
                    'approvals' => 'UGC, DEB, AICTE',
                    'naac' => null,
                    'nirf' => null,
                    'entrance' => 'University Admission Process',
                    'rating' => 4.6,
                    'reviews' => 310,
                    'highest' => '18 LPA',
                    'average' => '5.5 LPA',
                    'recruiters' => ['TCS', 'Infosys', 'HCL', 'Accenture'],
                    'overview' => 'ATLAS SkillTech University Online is positioned as a digital-first learning platform with online programmes, live sessions, recorded learning and career support.',
                    'featured' => true,
                    'hostel_boys' => false,
                    'hostel_girls' => false,
                    'courses' => [
                        ['course' => 'MBA', 'specialization' => 'Digital Business', 'fee' => 95000, 'eligibility' => 'Graduation in any stream', 'duration' => '2 Years'],
                        ['course' => 'BCA', 'specialization' => 'Software Development', 'fee' => 60000, 'eligibility' => '10+2 in any stream', 'duration' => '3 Years'],
                    ],
                ],
                [
                    'name' => 'Manipal University Jaipur',
                    'short_name' => 'MUJ',
                    'slug' => 'manipal-university-jaipur',
                    'mode' => 'regular',
                    'type' => 'Private',
                    'university' => 'Manipal University Jaipur',
                    'state' => 'Rajasthan',
                    'city' => 'Jaipur',
                    'address' => 'Jaipur, Rajasthan',
                    'year' => '2011',
                    'campus' => '120 Acres',
                    'approvals' => 'UGC, AICTE, NAAC',
                    'naac' => 'A+',
                    'nirf' => 'Demo ranking data',
                    'entrance' => 'JEE Main, University Entrance',
                    'rating' => 4.7,
                    'reviews' => 365,
                    'highest' => '30 LPA',
                    'average' => '7.2 LPA',
                    'recruiters' => ['Microsoft', 'Capgemini', 'Deloitte', 'Cognizant'],
                    'overview' => 'A demo advanced college record for testing GrowPEC course discovery, admissions, placements, facilities and review sections.',
                    'featured' => true,
                    'hostel_boys' => true,
                    'hostel_girls' => true,
                    'courses' => [
                        ['course' => 'B.Tech', 'specialization' => 'Computer Science & Engineering', 'fee' => 210000, 'eligibility' => '10+2 PCM with minimum 60%', 'duration' => '4 Years'],
                        ['course' => 'MBA', 'specialization' => 'Finance', 'fee' => 260000, 'eligibility' => 'Graduation with minimum 50%', 'duration' => '2 Years'],
                    ],
                ],
                [
                    'name' => 'Lovely Professional University',
                    'short_name' => 'LPU',
                    'slug' => 'lovely-professional-university',
                    'mode' => 'regular',
                    'type' => 'Private',
                    'university' => 'Lovely Professional University',
                    'state' => 'Punjab',
                    'city' => 'Phagwara',
                    'address' => 'Phagwara, Punjab',
                    'year' => '2005',
                    'campus' => 'Large Residential Campus',
                    'approvals' => 'UGC, AICTE, NAAC',
                    'naac' => 'A++',
                    'nirf' => 'Demo ranking data',
                    'entrance' => 'CUET, University Entrance',
                    'rating' => 4.5,
                    'reviews' => 510,
                    'highest' => '28 LPA',
                    'average' => '6.8 LPA',
                    'recruiters' => ['Cognizant', 'TCS', 'Wipro', 'Tech Mahindra'],
                    'overview' => 'A demo advanced college record designed to exercise the full GrowPEC college detail architecture including academics, scholarships, placements and career outcomes.',
                    'featured' => false,
                    'hostel_boys' => true,
                    'hostel_girls' => true,
                    'courses' => [
                        ['course' => 'BCA', 'specialization' => 'Cloud Computing', 'fee' => 90000, 'eligibility' => '10+2 with minimum 50%', 'duration' => '3 Years'],
                        ['course' => 'B.Tech', 'specialization' => 'Computer Science & Engineering', 'fee' => 160000, 'eligibility' => '10+2 PCM', 'duration' => '4 Years'],
                    ],
                ],
                [
                    'name' => 'Chandigarh University',
                    'short_name' => 'CU',
                    'slug' => 'chandigarh-university',
                    'mode' => 'both',
                    'type' => 'Private',
                    'university' => 'Chandigarh University',
                    'state' => 'Punjab',
                    'city' => 'Mohali',
                    'address' => 'Mohali, Punjab',
                    'year' => '2012',
                    'campus' => '200+ Acres',
                    'approvals' => 'UGC, AICTE, NAAC',
                    'naac' => 'A+',
                    'nirf' => 'Demo ranking data',
                    'entrance' => 'CUCET, CU Entrance',
                    'rating' => 4.6,
                    'reviews' => 455,
                    'highest' => '36 LPA',
                    'average' => '7.5 LPA',
                    'recruiters' => ['Amazon', 'IBM', 'Cognizant', 'Capgemini'],
                    'overview' => 'A demo regular and online university record with structured content for every major GrowPEC college-detail section.',
                    'featured' => true,
                    'hostel_boys' => true,
                    'hostel_girls' => true,
                    'courses' => [
                        ['course' => 'B.Tech', 'specialization' => 'Artificial Intelligence & Machine Learning', 'fee' => 175000, 'eligibility' => '10+2 PCM', 'duration' => '4 Years'],
                        ['course' => 'MBA', 'specialization' => 'Marketing', 'fee' => 145000, 'eligibility' => 'Graduation with minimum 50%', 'duration' => '2 Years'],
                        ['course' => 'BCA', 'specialization' => 'Data Science', 'fee' => 85000, 'eligibility' => '10+2', 'duration' => '3 Years'],
                    ],
                ],
            ];

            $collegeIds = [];

            foreach ($colleges as $index => $data) {
                $stateId = $this->stateId($data['state'], $now);
                $cityId = $this->cityId($stateId, $data['city'], $now);

                $existingCollege = DB::table('colleges')
                    ->where('slug', $data['slug'])
                    ->first();

                $collegeId = $existingCollege ? (int) $existingCollege->id : null;

                $payload = [
                    'name' => $data['name'],
                    'short_name' => $data['short_name'],
                    'slug' => $data['slug'],
                    'logo' => $existingCollege->logo ?? null,
                    'banner_image' => $existingCollege->banner_image ?? null,
                    'college_mode' => $data['mode'],
                    'college_type' => $data['type'],
                    'university_name' => $data['university'],
                    'state' => $data['state'],
                    'city' => $data['city'],
                    'state_id' => $stateId,
                    'city_id' => $cityId,
                    'address' => $data['address'],
                    'established_year' => $data['year'],
                    'campus_size' => $data['campus'],
                    'approvals' => $data['approvals'],
                    'entrance_exams' => $data['entrance'],
                    'rating' => $data['rating'],
                    'reviews_count' => $data['reviews'],
                    'highest_package' => $data['highest'],
                    'average_package' => $data['average'],
                    'top_recruiters' => implode(', ', $data['recruiters']),
                    'has_boys_hostel' => $data['hostel_boys'],
                    'has_girls_hostel' => $data['hostel_girls'],
                    'facilities' => json_encode([
                        'High-Speed Wi-Fi',
                        'Digital Library',
                        'Smart Classrooms',
                        'Cafeteria',
                        'Sports & Fitness',
                        'Career Development Centre',
                    ]),
                    'overview' => $data['overview'],
                    'admission_process' => '<ol><li>Choose your programme.</li><li>Submit the enquiry/application form.</li><li>Upload required documents.</li><li>Complete fee payment and enrollment.</li></ol>',
                    'scholarship_info' => 'Merit scholarships, need-based support and selected education-loan/EMI options may be available. Verify current eligibility with the institution.',
                    'sample_certificate_image' => $existingCollege->sample_certificate_image ?? null,
                    'brochure_pdf' => $existingCollege->brochure_pdf ?? null,
                    'faqs' => json_encode([
                        ['question' => 'How can I apply?', 'answer' => 'Submit the GrowPEC enquiry form and the admission team can guide you through the next steps.'],
                        ['question' => 'Are scholarships available?', 'answer' => 'Scholarship options depend on programme, merit and current institutional policy.'],
                    ]),
                    'highlights' => json_encode([
                        'Structured course and fee information',
                        'Admission guidance and counselling support',
                        'Scholarships and education-loan information',
                        'Placement and career-support information',
                    ]),
                    'is_featured' => $data['featured'],
                    'status' => true,
                    'website' => null,
                    'naac_grade' => $data['naac'],
                    'ugc_approved' => true,
                    'nirf_rank' => $data['nirf'],
                    'nirf_year' => '2026',
                    'seo_title' => $data['name'].' – Courses, Fees, Admission & Placements | GrowPEC',
                    'seo_description' => 'Explore courses, fees, admission process, scholarships, placements, facilities, reviews and career information for '.$data['name'].' on GrowPEC.',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                if ($collegeId) {
                    DB::table('colleges')
                        ->where('id', $collegeId)
                        ->update($payload);
                } else {
                    $collegeId = DB::table('colleges')->insertGetId($payload);
                }

                $collegeIds[] = $collegeId;

                $this->seedCollegeContent($collegeId, $data, $index, $now);
            }

            $this->seedComparisons($collegeIds, $now);
        });
    }

    private function seedBaseAcademicData($now): void
    {
        $streams = [
            ['name' => 'Management', 'slug' => 'management', 'icon' => 'bi-briefcase'],
            ['name' => 'Engineering', 'slug' => 'engineering', 'icon' => 'bi-gear'],
            ['name' => 'Computer Applications / IT', 'slug' => 'it-computer', 'icon' => 'bi-laptop'],
        ];

        foreach ($streams as $stream) {
            DB::table('streams')->updateOrInsert(
                ['slug' => $stream['slug']],
                $stream + ['created_at' => $now, 'updated_at' => $now]
            );
        }

        $streamIds = DB::table('streams')
            ->whereIn('slug', array_column($streams, 'slug'))
            ->pluck('id', 'slug');

        $courses = [
            ['name' => 'BCA', 'slug' => 'bca', 'stream' => 'it-computer', 'level' => 'UG', 'degree_type' => 'Degree', 'duration' => '3 Years'],
            ['name' => 'MCA', 'slug' => 'mca', 'stream' => 'it-computer', 'level' => 'PG', 'degree_type' => 'Degree', 'duration' => '2 Years'],
            ['name' => 'MBA', 'slug' => 'mba', 'stream' => 'management', 'level' => 'PG', 'degree_type' => 'Degree', 'duration' => '2 Years'],
            ['name' => 'B.Tech', 'slug' => 'btech', 'stream' => 'engineering', 'level' => 'UG', 'degree_type' => 'Degree', 'duration' => '4 Years'],
        ];

        foreach ($courses as $course) {
            $streamId = $streamIds[$course['stream']];

            DB::table('courses')->updateOrInsert(
                ['slug' => $course['slug']],
                [
                    'stream_id' => $streamId,
                    'name' => $course['name'],
                    'level' => $course['level'],
                    'degree_type' => $course['degree_type'],
                    'duration' => $course['duration'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $courseIds = DB::table('courses')
            ->whereIn('slug', array_column($courses, 'slug'))
            ->pluck('id', 'slug');

        $specializations = [
            ['course' => 'bca', 'name' => 'Software Development'],
            ['course' => 'bca', 'name' => 'Cloud Computing'],
            ['course' => 'bca', 'name' => 'Data Science'],
            ['course' => 'mca', 'name' => 'Artificial Intelligence'],
            ['course' => 'mba', 'name' => 'Business Analytics'],
            ['course' => 'mba', 'name' => 'Finance'],
            ['course' => 'mba', 'name' => 'Marketing'],
            ['course' => 'mba', 'name' => 'Digital Business'],
            ['course' => 'btech', 'name' => 'Computer Science & Engineering'],
            ['course' => 'btech', 'name' => 'Artificial Intelligence & Machine Learning'],
        ];

        foreach ($specializations as $specialization) {
            $courseId = $courseIds[$specialization['course']];
            $slug = Str::slug($specialization['course'].'-'.$specialization['name']);

            DB::table('specializations')->updateOrInsert(
                ['course_id' => $courseId, 'slug' => $slug],
                [
                    'name' => $specialization['name'],
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    private function stateId(string $name, $now): int
    {
        $slug = Str::slug($name);

        DB::table('states')->updateOrInsert(
            ['slug' => $slug],
            [
                'name' => $name,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        return (int) DB::table('states')->where('slug', $slug)->value('id');
    }

    private function cityId(int $stateId, string $name, $now): int
    {
        $slug = Str::slug($name);

        DB::table('cities')->updateOrInsert(
            ['state_id' => $stateId, 'slug' => $slug],
            [
                'name' => $name,
                'is_popular' => true,
                'status' => true,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        return (int) DB::table('cities')
            ->where('state_id', $stateId)
            ->where('slug', $slug)
            ->value('id');
    }

    private function seedCollegeContent(int $collegeId, array $data, int $index, $now): void
    {
        /*
         * Re-running this seeder should refresh demo content instead of
         * duplicating child rows.
         */
        /*
         * IMPORTANT:
         * college_course_specializations and college_course_fees are children
         * of college_courses, so they do NOT have college_id.
         * They must be deleted through college_course_id.
         */
        $collegeCourseIds = DB::table('college_courses')
            ->where('college_id', $collegeId)
            ->pluck('id');

        if ($collegeCourseIds->isNotEmpty()) {
            DB::table('college_course_specializations')
                ->whereIn('college_course_id', $collegeCourseIds)
                ->delete();

            DB::table('college_course_fees')
                ->whereIn('college_course_id', $collegeCourseIds)
                ->delete();
        }

        $childTables = [
            'college_highlights',
            'college_admission_sections',
            'college_scholarships',
            'college_accreditations',
            'college_placement_stats',
            'college_recruiters',
            'college_career_outcomes',
            'college_facilities',
            'college_learning_experiences',
            'college_loan_options',
            'college_faqs',
            'college_gallery',
            'college_documents',
            'college_alumni',
            'college_reviews',
            'college_comparisons',
        ];

        foreach ($childTables as $table) {
            DB::table($table)->where('college_id', $collegeId)->delete();
        }

        DB::table('college_courses')->where('college_id', $collegeId)->delete();

        $courseIds = DB::table('courses')->pluck('id', 'slug');
        $specializationRows = DB::table('specializations')
            ->get()
            ->keyBy(function ($row) {
                return $row->course_id.'|'.Str::slug($row->name);
            });

        foreach ($data['courses'] as $sort => $course) {
            $courseSlug = Str::slug($course['course']);
            $courseId = (int) $courseIds[$courseSlug];

            $specialization = DB::table('specializations')
                ->where('course_id', $courseId)
                ->where('name', $course['specialization'])
                ->first();

            $collegeCourseId = DB::table('college_courses')->insertGetId([
                'college_id' => $collegeId,
                'course_id' => $courseId,
                'specialization' => $course['specialization'],
                'specialization_id' => $specialization?->id,
                'fee_amount' => $course['fee'],
                'fee_type' => 'per_year',
                'eligibility' => $course['eligibility'],
                'academic_session' => '2026-27',
                'duration' => $course['duration'],
                'application_url' => '/contact',
                'brochure' => null,
                'sort_order' => $sort,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if ($specialization) {
                DB::table('college_course_specializations')->insert([
                    'college_course_id' => $collegeCourseId,
                    'specialization_id' => $specialization->id,
                    'fee_amount' => $course['fee'],
                    'fee_type' => 'per_year',
                    'eligibility' => $course['eligibility'],
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('college_course_fees')->insert([
                'college_course_id' => $collegeCourseId,
                'fee_type' => 'per_year',
                'label' => 'Tuition Fee',
                'amount' => $course['fee'],
                'academic_session' => '2026-27',
                'description' => 'Demo fee record for development/testing.',
                'sort_order' => 0,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->insertMany('college_highlights', $collegeId, [
            ['title' => 'Verified-style College Profile', 'description' => 'Structured college information is available across academics, admissions and career sections.', 'icon' => 'bi-patch-check'],
            ['title' => 'Multiple Course Options', 'description' => 'Course, specialization, eligibility, duration and fee information is structured for discovery.', 'icon' => 'bi-mortarboard'],
            ['title' => 'Career Support', 'description' => 'Placement, recruiter and career-outcome blocks are available on the college profile.', 'icon' => 'bi-briefcase'],
            ['title' => 'Scholarship & EMI Information', 'description' => 'Financial-support content can be presented directly on the college page.', 'icon' => 'bi-cash-coin'],
        ], $now);

        $this->insertMany('college_admission_sections', $collegeId, [
            [
                'section_key' => 'how_to_apply',
                'title' => 'How to Apply',
                'content' => 'Choose a programme, submit the enquiry/application form, complete document verification and follow the institution-specific admission instructions.',
                'items' => json_encode(['Choose course', 'Submit application', 'Upload documents', 'Complete verification', 'Confirm enrollment']),
            ],
            [
                'section_key' => 'documents',
                'title' => 'Documents Required',
                'content' => 'Typical documents may include academic marksheets, identity proof, photographs and category documents where applicable.',
                'items' => json_encode(['10th marksheet', '12th marksheet', 'Graduation documents where applicable', 'Identity proof', 'Photographs']),
            ],
            [
                'section_key' => 'verification',
                'title' => 'Application Verification',
                'content' => 'Admission teams may verify submitted documents before confirming eligibility and enrollment.',
                'items' => json_encode(['Eligibility check', 'Document verification', 'Fee confirmation']),
            ],
        ], $now);

        $this->insertMany('college_scholarships', $collegeId, [
            ['name' => 'Merit Scholarship', 'eligibility' => 'Academic merit', 'criteria' => 'As per current institutional policy', 'amount' => null, 'amount_label' => 'Varies', 'percentage' => 'Up to 25%', 'description' => 'Demo scholarship entry for UI testing.'],
            ['name' => 'Early Application Support', 'eligibility' => 'Eligible applicants', 'criteria' => 'Subject to current policy', 'amount' => null, 'amount_label' => 'Varies', 'percentage' => null, 'description' => 'Demo financial-support entry.'],
        ], $now);

        $this->insertMany('college_accreditations', $collegeId, [
            ['authority' => 'UGC', 'accreditation' => 'UGC Recognition', 'grade' => null, 'rank' => null, 'year' => '2026', 'description' => 'Demo accreditation information; verify with the institution before publication.', 'certificate_image' => null],
            ['authority' => 'NAAC', 'accreditation' => 'NAAC Accreditation', 'grade' => $data['naac'], 'rank' => null, 'year' => '2026', 'description' => 'Demo accreditation entry.', 'certificate_image' => null],
            ['authority' => 'NIRF', 'accreditation' => 'Ranking Information', 'grade' => null, 'rank' => $data['nirf'], 'year' => '2026', 'description' => 'Demo ranking entry for development/testing.', 'certificate_image' => null],
        ], $now);

        $this->insertMany('college_placement_stats', $collegeId, [
            ['label' => 'Highest Package', 'value' => $data['highest'], 'year' => '2026', 'course' => 'Overall', 'description' => 'Demo placement statistic.'],
            ['label' => 'Average Package', 'value' => $data['average'], 'year' => '2026', 'course' => 'Overall', 'description' => 'Demo placement statistic.'],
            ['label' => 'Recruiting Partners', 'value' => (string) count($data['recruiters']), 'year' => '2026', 'course' => 'Overall', 'description' => 'Demo recruiter count.'],
        ], $now);

        $this->insertMany('college_recruiters', $collegeId, array_map(
            fn ($name) => ['name' => $name, 'logo' => null, 'description' => 'Demo recruiter entry.'],
            $data['recruiters']
        ), $now);

        $this->insertMany('college_career_outcomes', $collegeId, [
            ['career_role' => 'Software Developer', 'industry' => 'IT / Technology', 'average_salary' => $data['average'], 'salary_range' => '4–12 LPA', 'job_scope' => 'Software development, testing and product engineering', 'description' => 'Demo career-outcome entry.'],
            ['career_role' => 'Business Analyst', 'industry' => 'Consulting / Business', 'average_salary' => $data['average'], 'salary_range' => '5–14 LPA', 'job_scope' => 'Business analysis, operations and consulting', 'description' => 'Demo career-outcome entry.'],
            ['career_role' => 'Data / Analytics Professional', 'industry' => 'Technology / Analytics', 'average_salary' => $data['average'], 'salary_range' => '5–16 LPA', 'job_scope' => 'Data analysis, reporting and analytics', 'description' => 'Demo career-outcome entry.'],
        ], $now);

        $this->insertMany('college_facilities', $collegeId, [
            ['name' => 'Digital Library', 'icon' => 'bi-book', 'description' => 'Digital and academic learning resources.', 'image' => null],
            ['name' => 'Smart Classrooms', 'icon' => 'bi-display', 'description' => 'Technology-enabled learning spaces.', 'image' => null],
            ['name' => 'Campus Wi-Fi', 'icon' => 'bi-wifi', 'description' => 'High-speed connectivity across learning areas.', 'image' => null],
            ['name' => 'Cafeteria', 'icon' => 'bi-cup-hot', 'description' => 'Student dining and refreshment facility.', 'image' => null],
            ['name' => 'Sports & Fitness', 'icon' => 'bi-trophy', 'description' => 'Sports and fitness facilities.', 'image' => null],
            ['name' => 'Career Development Centre', 'icon' => 'bi-person-workspace', 'description' => 'Career guidance and placement support.', 'image' => null],
        ], $now);

        $this->insertMany('college_learning_experiences', $collegeId, [
            ['title' => 'Live & Recorded Learning', 'description' => 'Learning can combine live sessions with recorded resources.', 'icon' => 'bi-camera-video', 'type' => $data['mode'] === 'online' ? 'Online' : 'Hybrid'],
            ['title' => 'LMS Resources', 'description' => 'Structured digital resources can be organized through the learning platform.', 'icon' => 'bi-laptop', 'type' => 'LMS'],
            ['title' => 'Mentor Support', 'description' => 'Academic and career guidance content can be highlighted here.', 'icon' => 'bi-people', 'type' => 'Mentoring'],
        ], $now);

        $this->insertMany('college_loan_options', $collegeId, [
            ['provider' => 'Education Loan Partner', 'loan_type' => 'Education Loan', 'amount' => 500000, 'interest_rate' => 'As per lender policy', 'tenure' => 'Up to 10 years', 'emi_from' => 'Contact lender', 'description' => 'Demo education-loan option. Verify lender terms before publishing.'],
            ['provider' => 'Bank / NBFC', 'loan_type' => 'Tuition Financing', 'amount' => 1000000, 'interest_rate' => 'As per lender policy', 'tenure' => 'Up to 10 years', 'emi_from' => 'Contact lender', 'description' => 'Demo financing option.'],
        ], $now);

        $this->insertMany('college_faqs', $collegeId, [
            ['question' => 'What courses are available?', 'answer' => 'The college profile lists available courses, specializations, eligibility, duration and fee information.'],
            ['question' => 'How do I apply?', 'answer' => 'Submit the GrowPEC enquiry form or follow the institution-specific application process.'],
            ['question' => 'Are scholarships available?', 'answer' => 'Scholarship availability depends on the programme and current institutional policy.'],
            ['question' => 'Can I compare this college with another college?', 'answer' => 'Yes. GrowPEC can present structured comparison information where comparison records are available.'],
        ], $now);

        $this->insertMany('college_gallery', $collegeId, [
            ['title' => 'Campus Overview', 'image' => 'assets/growpec.png', 'category' => 'Campus', 'alt_text' => $data['name'].' campus'],
            ['title' => 'Learning Environment', 'image' => 'assets/growpec.png', 'category' => 'Academics', 'alt_text' => $data['name'].' learning environment'],
            ['title' => 'Student Facilities', 'image' => 'assets/growpec.png', 'category' => 'Facilities', 'alt_text' => $data['name'].' student facilities'],
        ], $now);

        /*
         * college_documents.file_path is NOT NULL in the database.
         * Do not create fake document rows with NULL file_path.
         *
         * If an existing/basic college already has a brochure or certificate
         * path, convert that file into the advanced document records.
         * Otherwise simply skip the document row; the admin can upload it later.
         */
        $collegeMedia = DB::table('colleges')
            ->where('id', $collegeId)
            ->first();

        $documentRows = [];

        if (! empty($collegeMedia->brochure_pdf)) {
            $documentRows[] = [
                'title' => 'College Brochure',
                'document_type' => 'brochure',
                'file_path' => $collegeMedia->brochure_pdf,
                'file_name' => basename($collegeMedia->brochure_pdf),
                'mime_type' => null,
                'file_size' => null,
            ];
        }

        if (! empty($collegeMedia->sample_certificate_image)) {
            $documentRows[] = [
                'title' => 'Sample Degree / Certificate',
                'document_type' => 'certificate',
                'file_path' => $collegeMedia->sample_certificate_image,
                'file_name' => basename($collegeMedia->sample_certificate_image),
                'mime_type' => null,
                'file_size' => null,
            ];
        }

        if (! empty($documentRows)) {
            $this->insertMany('college_documents', $collegeId, $documentRows, $now);
        }

        $this->insertMany('college_alumni', $collegeId, [
            ['name' => 'Aarav Sharma', 'designation' => 'Software Engineer', 'company' => $data['recruiters'][0] ?? 'Technology Company', 'batch' => '2022', 'image' => null, 'description' => 'Demo alumni profile for testing the alumni section.'],
            ['name' => 'Sara Khan', 'designation' => 'Business Analyst', 'company' => $data['recruiters'][1] ?? 'Consulting Company', 'batch' => '2023', 'image' => null, 'description' => 'Demo alumni profile for testing the alumni section.'],
        ], $now);

        /*
         * college_reviews does NOT have sort_order in the existing schema.
         * Do not use the generic insertMany() helper here because that helper
         * adds sort_order automatically.
         */
        foreach ([
            ['user_id' => null, 'reviewer_name' => 'Rahul Verma', 'course' => $data['courses'][0]['course'], 'rating' => 5, 'review' => 'Demo student review used for testing the rating and reviews section.', 'is_verified' => true],
            ['user_id' => null, 'reviewer_name' => 'Priya Singh', 'course' => $data['courses'][0]['course'], 'rating' => 4, 'review' => 'Demo alumni review used for UI testing.', 'is_verified' => true],
            ['user_id' => null, 'reviewer_name' => 'Mohit Kumar', 'course' => $data['courses'][0]['course'], 'rating' => 5, 'review' => 'Demo review entry for development.', 'is_verified' => false],
        ] as $review) {
            $review['college_id'] = $collegeId;
            $review['status'] = true;
            $review['created_at'] = $now;
            $review['updated_at'] = $now;

            DB::table('college_reviews')->insert($review);
        }
    }

    private function insertMany(string $table, int $collegeId, array $rows, $now): void
    {
        foreach ($rows as $index => $row) {
            $row['college_id'] = $collegeId;
            $row['sort_order'] = $index;
            $row['status'] = true;
            $row['created_at'] = $now;
            $row['updated_at'] = $now;

            DB::table($table)->insert($row);
        }
    }

    private function seedComparisons(array $collegeIds, $now): void
    {
        foreach ($collegeIds as $index => $collegeId) {
            $comparedCollegeId = $collegeIds[($index + 1) % count($collegeIds)];

            DB::table('college_comparisons')->insert([
                'college_id' => $collegeId,
                'compared_college_id' => $comparedCollegeId,
                'title' => 'College Comparison',
                'comparison_data' => json_encode([
                    'fees' => 'Compare programme-wise fees',
                    'duration' => 'Compare programme duration',
                    'mode' => 'Compare regular / online availability',
                    'placements' => 'Compare placement information',
                    'facilities' => 'Compare campus and learning facilities',
                ]),
                'sort_order' => 0,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
