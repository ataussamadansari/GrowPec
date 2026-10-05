<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class OnlineUniversitySeeder extends Seeder
{
    /** @var array<string, int> */
    private array $courseIds = [];

    /** @var array<string, int> */
    private array $specializationIds = [];

    public function run(): void
    {
        DB::transaction(function () {
            $this->seedAcademicPrerequisites();
            $this->seedOnlineColleges();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | 1. Dynamic Creation of All Streams, Courses & Specializations
    |--------------------------------------------------------------------------
    */
    private function seedAcademicPrerequisites(): void
    {
        $now = now();

        $streams = [
            'management' => ['name' => 'Management',                   'icon' => 'bi-briefcase'],
            'it' => ['name' => 'Computer Applications & IT',   'icon' => 'bi-laptop'],
            'commerce' => ['name' => 'Commerce & Finance',           'icon' => 'bi-currency-rupee'],
            'arts' => ['name' => 'Arts & Humanities',            'icon' => 'bi-book'],
            'science' => ['name' => 'Science',                      'icon' => 'bi-flask'],
            'media-journalism' => ['name' => 'Media & Mass Communication',   'icon' => 'bi-camera-reels'],
            'library-sciences' => ['name' => 'Library & Information Science', 'icon' => 'bi-collection'],
        ];

        $streamIds = [];
        foreach ($streams as $slug => $s) {
            DB::table('streams')->updateOrInsert(
                ['slug' => $slug],
                ['name' => $s['name'], 'icon' => $s['icon'], 'created_at' => $now, 'updated_at' => $now]
            );
            $streamIds[$slug] = (int) DB::table('streams')->where('slug', $slug)->value('id');
        }

        $courses = [
            'mba' => ['stream' => 'management',       'name' => 'MBA',                                     'level' => 'PG', 'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bba' => ['stream' => 'management',       'name' => 'BBA',                                     'level' => 'UG', 'degree_type' => 'Degree',  'duration' => '3 Years'],
            'mca' => ['stream' => 'it',               'name' => 'MCA',                                     'level' => 'PG', 'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bca' => ['stream' => 'it',               'name' => 'BCA',                                     'level' => 'UG', 'degree_type' => 'Degree',  'duration' => '3 Years'],
            'bsc-it' => ['stream' => 'it',               'name' => 'B.Sc. IT',                                'level' => 'UG', 'degree_type' => 'Degree',  'duration' => '3 Years'],
            'msc-it' => ['stream' => 'it',               'name' => 'M.Sc. IT',                                'level' => 'PG', 'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bcom' => ['stream' => 'commerce',         'name' => 'B.Com',                                   'level' => 'UG', 'degree_type' => 'Degree',  'duration' => '3 Years'],
            'bcom-hons' => ['stream' => 'commerce',         'name' => 'B.Com (Hons.)',                           'level' => 'UG', 'degree_type' => 'Degree',  'duration' => '3 Years'],
            'mcom' => ['stream' => 'commerce',         'name' => 'M.Com',                                   'level' => 'PG', 'degree_type' => 'Degree',  'duration' => '2 Years'],
            'ba' => ['stream' => 'arts',             'name' => 'B.A.',                                    'level' => 'UG', 'degree_type' => 'Degree',  'duration' => '3 Years'],
            'ma' => ['stream' => 'arts',             'name' => 'M.A.',                                    'level' => 'PG', 'degree_type' => 'Degree',  'duration' => '2 Years'],
            'ba-jmc' => ['stream' => 'media-journalism', 'name' => 'B.A. (Journalism & Mass Communication)',  'level' => 'UG', 'degree_type' => 'Degree',  'duration' => '3 Years'],
            'ma-jmc' => ['stream' => 'media-journalism', 'name' => 'M.A. (Journalism & Mass Communication)',  'level' => 'PG', 'degree_type' => 'Degree',  'duration' => '2 Years'],
            'msc-maths' => ['stream' => 'science',          'name' => 'M.Sc. (Mathematics)',                     'level' => 'PG', 'degree_type' => 'Degree',  'duration' => '2 Years'],
            'blis' => ['stream' => 'library-sciences', 'name' => 'BLIS (Library & Information Science)',    'level' => 'UG', 'degree_type' => 'Degree',  'duration' => '1 Year'],
            'mlis' => ['stream' => 'library-sciences', 'name' => 'MLIS (Library & Information Science)',    'level' => 'PG', 'degree_type' => 'Degree',  'duration' => '1 Year'],
        ];

        foreach ($courses as $slug => $c) {
            DB::table('courses')->updateOrInsert(
                ['slug' => $slug],
                [
                    'stream_id' => $streamIds[$c['stream']],
                    'name' => $c['name'],
                    'level' => $c['level'],
                    'degree_type' => $c['degree_type'],
                    'duration' => $c['duration'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
            $this->courseIds[$slug] = (int) DB::table('courses')->where('slug', $slug)->value('id');
        }

        $specializations = [
            'mba' => [
                'Marketing Management', 'Financial Management', 'Human Resource Management',
                'Business Analytics', 'Data Science', 'Operations & Supply Chain Management',
                'International Business', 'Information Technology', 'Digital Marketing',
                'Hospital & Healthcare Management', 'Banking & Financial Services',
                'Project Management', 'Retail Management', 'FinTech', 'Agri-Business Management',
                'General Management',
            ],
            'bba' => [
                'General Management', 'Marketing', 'Finance', 'Human Resources',
                'Digital Business & E-Commerce', 'Data Science & Analytics',
                'International Business', 'Banking & Insurance',
            ],
            'mca' => [
                'Artificial Intelligence & Machine Learning', 'Cloud Computing & DevOps',
                'Data Science & Analytics', 'Cyber Security', 'Full Stack Development',
                'Software Engineering', 'General Computer Applications',
            ],
            'bca' => [
                'Data Science', 'Cloud & Security', 'Web & Mobile App Development',
                'Software Engineering', 'General Computer Applications',
            ],
            'bcom' => [
                'Accounting & Finance', 'Banking & Insurance', 'E-Commerce', 'Corporate Accounting',
            ],
            'bcom-hons' => [
                'International Finance & Accounting', 'Corporate Governance', 'Financial Analysis',
            ],
            'mcom' => [
                'Financial Management', 'Corporate Accounting', 'International Finance',
            ],
            'ba' => [
                'English', 'Economics', 'Political Science', 'History', 'Sociology',
                'Public Administration', 'Psychology',
            ],
            'ma' => [
                'English Literature', 'Economics', 'Political Science', 'History',
                'Sociology', 'Public Policy', 'Urdu', 'Hindi',
            ],
            'ba-jmc' => [
                'Electronic & Print Media', 'Digital Journalism',
            ],
            'ma-jmc' => [
                'Broadcast & Digital Media', 'Strategic Communications',
            ],
            'msc-maths' => [
                'Pure & Applied Mathematics',
            ],
            'bsc-it' => [
                'Information Systems', 'Database Administration',
            ],
            'msc-it' => [
                'Advanced Software Systems', 'Information Networks',
            ],
            'blis' => [
                'Library Cataloging & Digital Management',
            ],
            'mlis' => [
                'Advanced Library Informatics',
            ],
        ];

        foreach ($specializations as $courseSlug => $names) {
            $courseId = $this->courseIds[$courseSlug] ?? null;
            if (! $courseId) {
                continue;
            }
            foreach ($names as $name) {
                $slug = Str::slug($courseSlug.'-'.$name);
                DB::table('specializations')->updateOrInsert(
                    ['course_id' => $courseId, 'slug' => $slug],
                    ['name' => $name, 'status' => true, 'created_at' => $now, 'updated_at' => $now]
                );
                $this->specializationIds[$courseSlug.'|'.$name] =
                    (int) DB::table('specializations')
                        ->where('course_id', $courseId)
                        ->where('slug', $slug)
                        ->value('id');
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Seed Online Colleges and Map Authentic Course Offerings
    |--------------------------------------------------------------------------
    */
    private function seedOnlineColleges(): void
    {
        $now = now();

        foreach ($this->onlineUniversityDefinitions() as $def) {
            $stateId = (int) DB::table('states')->where('name', $def['state'])->value('id');
            if (! $stateId) {
                $stateId = (int) DB::table('states')->insertGetId([
                    'name' => $def['state'],
                    'slug' => Str::slug($def['state']),
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $cityId = (int) DB::table('cities')->where('state_id', $stateId)->where('name', $def['city'])->value('id');
            if (! $cityId) {
                $cityId = (int) DB::table('cities')->insertGetId([
                    'state_id' => $stateId,
                    'name' => $def['city'],
                    'slug' => Str::slug($def['city']),
                    'is_popular' => in_array($def['city'], ['New Delhi', 'Bangalore', 'Hyderabad', 'Mumbai', 'Kolkata', 'Lucknow']),
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $existing = DB::table('colleges')->where('slug', $def['slug'])->first();
            $payload = array_merge($this->basePayload($def, $stateId, $cityId), ['updated_at' => $now]);

            if ($existing) {
                $collegeId = $existing->id;
                DB::table('colleges')->where('id', $collegeId)->update($payload);
                $this->cleanExistingChildData($collegeId);
            } else {
                $payload['created_at'] = $now;
                $collegeId = (int) DB::table('colleges')->insertGetId($payload);
            }

            $this->insertCourses($collegeId, $def['courses']);
            $this->insertHighlights($collegeId, $def['highlights']);
            $this->insertAccreditations($collegeId, $def['accreditations']);
            $this->insertAdmissionSections($collegeId, $def['admission_sections']);
            $this->insertScholarships($collegeId, $def['scholarships']);
            $this->insertPlacementStats($collegeId, $def['placement_stats'], $def['recruiters']);
            $this->insertCareerOutcomes($collegeId, $def['career_outcomes']);
            $this->insertFacilities($collegeId, $def['facilities']);
            $this->insertFaqs($collegeId, $def['faqs']);
            $this->insertQuickFacts($collegeId, $def);
        }
    }

    private function cleanExistingChildData(int $collegeId): void
    {
        $tables = [
            'college_course_specializations', 'college_course_fees', 'college_courses',
            'college_highlights', 'college_accreditations', 'college_admission_sections',
            'college_scholarships', 'college_placement_stats', 'college_recruiters',
            'college_career_outcomes', 'college_facilities', 'college_learning_experiences',
            'college_loan_options', 'college_faqs', 'college_quick_facts',
        ];

        foreach ($tables as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }
            if ($table === 'college_course_specializations' || $table === 'college_course_fees') {
                $ccIds = DB::table('college_courses')->where('college_id', $collegeId)->pluck('id');
                if ($ccIds->isNotEmpty()) {
                    DB::table($table)->whereIn('college_course_id', $ccIds)->delete();
                }
            } else {
                DB::table($table)->where('college_id', $collegeId)->delete();
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Authentic Real-World Details for the 19 Universities
    |--------------------------------------------------------------------------
    */
    private function onlineUniversityDefinitions(): array
    {
        return [
            /* 1. LPU Online */
            [
                'name' => 'Lovely Professional University Online',
                'short_name' => 'LPU Online',
                'slug' => 'lpu-online',
                'type' => 'Private',
                'university' => 'Lovely Professional University',
                'website' => 'https://www.lpuonline.com',
                'state' => 'Punjab',
                'city' => 'Phagwara',
                'address' => 'Jalandhar - Delhi G.T. Road, Phagwara, Punjab - 144411',
                'year' => '2005',
                'campus' => 'LPU e-Connect Learning Management System',
                'approvals' => 'UGC-DEB | AICTE | NAAC A++ | NIRF #27',
                'naac_grade' => 'A++',
                'ugc_approved' => true,
                'nirf_rank' => '27',
                'nirf_year' => '2024',
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.8,
                'reviews_count' => 860,
                'highest' => '54.75 LPA',
                'average' => '7.2 LPA',
                'top_recruiters' => 'Amazon, Google, Microsoft, Cognizant, Capgemini, TCS, Infosys',
                'overview' => 'Lovely Professional University Online is NAAC A++ accredited and UGC-DEB entitled to offer fully recognized online degree programs. LPU Online combines cutting-edge curriculum on the LPU e-Connect portal with live masterclasses, recorded lectures, and placement assistance from 2000+ recruitment partners.',
                'scholarship_info' => 'Defence personnel concessions (20%), merit fee waivers, and PWD benefits. No-cost EMI starting from ₹4,500/month.',
                'is_featured' => true,
                'courses' => [
                    ['slug' => 'mba',       'spec' => 'Marketing Management',                       'fee' => 76000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Financial Management',                       'fee' => 76000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Human Resource Management',                  'fee' => 76000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Data Science',                               'fee' => 84000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Operations & Supply Chain Management',       'fee' => 76000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 64000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. Computer Science / Maths at 10+2',       'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Cloud Computing & DevOps',                   'fee' => 64000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. Computer Science / Maths at 10+2',       'duration' => '2 Years'],
                    ['slug' => 'bca',       'spec' => 'Data Science',                               'fee' => 52000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream with min 50% aggregate',          'duration' => '3 Years'],
                    ['slug' => 'bba',       'spec' => 'Marketing',                                  'fee' => 48000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream with min 50% aggregate',          'duration' => '3 Years'],
                    ['slug' => 'bcom',      'spec' => 'Accounting & Finance',                       'fee' => 38000, 'type' => 'per_year', 'eligibility' => '10+2 in Commerce or Allied Stream with 50%',         'duration' => '3 Years'],
                    ['slug' => 'mcom',      'spec' => 'Financial Management',                       'fee' => 42000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA / Allied Commerce degree',              'duration' => '2 Years'],
                    ['slug' => 'ba',        'spec' => 'English',                                    'fee' => 32000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream',                                  'duration' => '3 Years'],
                    ['slug' => 'ma',        'spec' => 'English Literature',                         'fee' => 36000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline',                'duration' => '2 Years'],
                    ['slug' => 'msc-maths', 'spec' => 'Pure & Applied Mathematics',                 'fee' => 40000, 'type' => 'per_year', 'eligibility' => 'B.Sc. with Mathematics as a subject',                 'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A++ Accredited University', 'value' => 'Highest Rating (3.68 Score)', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Entitled Degree Programs', 'value' => '100% Equivalent to Regular', 'icon' => 'bi-shield-check'],
                    ['title' => 'Ranked #27 in NIRF 2024', 'value' => 'Top Universities in India', 'icon' => 'bi-award-fill'],
                    ['title' => 'LPU e-Connect Digital Platform', 'value' => 'Accessible 24/7 on Web & Mobile', 'icon' => 'bi-laptop'],
                    ['title' => '54.75 LPA Highest Placement Package', 'value' => '2000+ Recruitment Partners', 'icon' => 'bi-briefcase-fill'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Higher Education', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council', 'grade' => 'A++', 'rank' => null, 'year' => '2023'],
                    ['authority' => 'NIRF', 'accreditation' => 'Ministry of Education Government of India', 'grade' => null, 'rank' => '27', 'year' => '2024'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Requirements', 'content' => '10+2 for UG programs and Graduation with min 50% for PG courses.', 'items' => ['10+2 from recognized board', 'Graduation in any stream for PG', 'No entrance exam required']],
                    ['key' => 'how_to_apply', 'title' => 'How to Apply', 'content' => 'Simple digital admission via GrowPec.', 'items' => ['Fill inquiry form', 'Counselor consultation', 'Upload KYC and marksheets', 'Pay fee online & get student portal ID']],
                    ['key' => 'documents', 'title' => 'Documents Required', 'content' => 'Digital self-attested copies.', 'items' => ['10th & 12th certificates', 'Graduation marksheets (for PG)', 'Aadhaar Card', 'Passport size photo']],
                ],
                'scholarships' => [
                    ['name' => 'Defence Personnel Concession', 'eligibility' => 'Serving and retired defence personnel', 'criteria' => 'Armed Forces', 'amount' => null, 'label' => '20% Tuition Fee Waiver', 'pct' => '20%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '54.75 LPA', 'year' => '2024', 'course' => 'Tech & Management'],
                    ['label' => 'Average Package', 'value' => '7.2 LPA', 'year' => '2024', 'course' => 'Overall Batch'],
                ],
                'recruiters' => ['Amazon', 'Google', 'Microsoft', 'Cognizant', 'Capgemini', 'TCS', 'Infosys'],
                'career_outcomes' => [
                    ['role' => 'Business Analyst', 'industry' => 'IT & Consulting', 'avg_salary' => '6.5 - 12 LPA', 'range' => '5 - 20 LPA'],
                    ['role' => 'Data Scientist', 'industry' => 'Analytics & IT', 'avg_salary' => '8 - 16 LPA', 'range' => '6 - 28 LPA'],
                ],
                'facilities' => [
                    ['name' => 'LPU e-Connect Learning Management System', 'icon' => 'bi-laptop'],
                    ['name' => 'Live Interactive Masterclasses', 'icon' => 'bi-camera-video'],
                    ['name' => 'Proctored Online Semester Exams', 'icon' => 'bi-shield-check'],
                ],
                'faqs' => [
                    ['q' => 'Is LPU Online degree valid for government exams and UPSC?', 'a' => 'Yes. As per UGC regulations, online degrees from UGC-DEB entitled universities are equivalent to campus degrees for all government examinations, corporate jobs, and higher studies.'],
                ],
            ],

            /* 2. Chandigarh University Online (CU Online) */
            [
                'name' => 'Chandigarh University Online',
                'short_name' => 'CU Online',
                'slug' => 'chandigarh-university-online',
                'type' => 'Private',
                'university' => 'Chandigarh University',
                'website' => 'https://www.onlinecu.in',
                'state' => 'Punjab',
                'city' => 'Mohali',
                'address' => 'NH-95, Chandigarh-Ludhiana Highway, Mohali, Punjab - 140413',
                'year' => '2012',
                'campus' => 'Blackboard Ultra Digital Learning Platform',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+ | QS World Ranked',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => '32',
                'nirf_year' => '2024',
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.7,
                'reviews_count' => 790,
                'highest' => '42 LPA',
                'average' => '6.8 LPA',
                'top_recruiters' => 'Google, Microsoft, IBM, Deloitte, Cognizant, Accenture, Wipro',
                'overview' => 'Chandigarh University Online delivers high-calibre UGC-DEB recognized degree programs with NAAC A+ accreditation. Enriched with Harvard Business Publishing case studies and Blackboard Ultra LMS, CU Online provides career-accelerating programs with placement support across 700+ leading multinational companies.',
                'scholarship_info' => 'Early bird fee waivers, defence concessions, and corporate fee benefits. Flexible monthly EMI starting from ₹4,000/month.',
                'is_featured' => true,
                'courses' => [
                    ['slug' => 'mba',     'spec' => 'Marketing Management',                 'fee' => 75000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50% in any discipline', 'duration' => '2 Years'],
                    ['slug' => 'mba',     'spec' => 'Financial Management',                 'fee' => 75000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50% in any discipline', 'duration' => '2 Years'],
                    ['slug' => 'mba',     'spec' => 'Human Resource Management',            'fee' => 75000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50% in any discipline', 'duration' => '2 Years'],
                    ['slug' => 'mba',     'spec' => 'Business Analytics',                  'fee' => 85000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50% in any discipline', 'duration' => '2 Years'],
                    ['slug' => 'mba',     'spec' => 'International Business',              'fee' => 75000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50% in any discipline', 'duration' => '2 Years'],
                    ['slug' => 'mca',     'spec' => 'Cloud Computing & DevOps',             'fee' => 65000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Mathematics',         'duration' => '2 Years'],
                    ['slug' => 'mca',     'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 68000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Mathematics',  'duration' => '2 Years'],
                    ['slug' => 'bca',     'spec' => 'Software Engineering',                'fee' => 52000, 'type' => 'per_year', 'eligibility' => '10+2 with min 50% in any stream',           'duration' => '3 Years'],
                    ['slug' => 'bba',     'spec' => 'General Management',                  'fee' => 52000, 'type' => 'per_year', 'eligibility' => '10+2 with min 50% in any stream',           'duration' => '3 Years'],
                    ['slug' => 'bcom',    'spec' => 'Corporate Accounting',                'fee' => 45000, 'type' => 'per_year', 'eligibility' => '10+2 with min 50% aggregate',              'duration' => '3 Years'],
                    ['slug' => 'mcom',    'spec' => 'International Finance',               'fee' => 48000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA with min 50% aggregate',       'duration' => '2 Years'],
                    ['slug' => 'ma-jmc',  'spec' => 'Broadcast & Digital Media',           'fee' => 50000, 'type' => 'per_year', 'eligibility' => 'Graduation in any discipline',             'duration' => '2 Years'],
                    ['slug' => 'ma',      'spec' => 'English Literature',                   'fee' => 40000, 'type' => 'per_year', 'eligibility' => 'Graduation in any discipline',             'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A+ Accredited Grade', 'value' => 'Global Quality Benchmark', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'NIRF Rank #32 in India', 'value' => 'Top Universities Category', 'icon' => 'bi-award-fill'],
                    ['title' => 'Harvard Business Publishing Integration', 'value' => 'Simulations & Case Studies', 'icon' => 'bi-book-half'],
                    ['title' => 'Blackboard Ultra LMS Platform', 'value' => 'Global Leading Learning System', 'icon' => 'bi-display'],
                    ['title' => '42 LPA Highest Package', 'value' => '700+ Global Multinational Recruiters', 'icon' => 'bi-briefcase-fill'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Degree Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Grade A+ Accredited', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                    ['authority' => 'NIRF', 'accreditation' => 'National Institutional Ranking Framework', 'grade' => null, 'rank' => '32', 'year' => '2024'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility', 'content' => 'Graduation with min 50% for PG; 10+2 with 50% for UG.', 'items' => ['10+2 passed from recognized board', 'Bachelor’s degree for PG']],
                    ['key' => 'how_to_apply', 'title' => 'Admission Guide', 'content' => 'Apply online via GrowPec.', 'items' => ['Submit application', 'Verify documents', 'Pay fee online']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Digital self-attested documents.', 'items' => ['10th/12th/Graduation certificates', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Armed Forces Concession', 'eligibility' => 'Wards and spouses of armed forces personnel', 'criteria' => 'Defence Service', 'amount' => null, 'label' => '15% Concession', 'pct' => '15%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '42 LPA', 'year' => '2024', 'course' => 'B.Tech / MBA'],
                    ['label' => 'Average Package', 'value' => '6.8 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Google', 'Microsoft', 'IBM', 'Deloitte', 'Cognizant', 'Accenture', 'Wipro', 'Capgemini'],
                'career_outcomes' => [
                    ['role' => 'Cloud Solutions Architect', 'industry' => 'Cloud & IT Services', 'avg_salary' => '7 - 15 LPA', 'range' => '5 - 24 LPA'],
                ],
                'facilities' => [
                    ['name' => 'Blackboard Ultra LMS', 'icon' => 'bi-laptop'],
                    ['name' => 'Interactive Live Classes', 'icon' => 'bi-camera-video'],
                ],
                'faqs' => [
                    ['q' => 'How are examinations conducted at Chandigarh University Online?', 'a' => 'Examinations are conducted 100% online in AI-proctored mode, allowing students to take tests comfortably from home.'],
                ],
            ],

            /* 3. Manipal University Jaipur Online (MUJ Online) */
            [
                'name' => 'Manipal University Jaipur Online',
                'short_name' => 'MUJ Online',
                'slug' => 'manipal-university-jaipur-online',
                'type' => 'Private',
                'university' => 'Manipal University Jaipur',
                'website' => 'https://www.onlinemanipal.com',
                'state' => 'Rajasthan',
                'city' => 'Jaipur',
                'address' => 'Dehmi Kalan, Jaipur-Ajmer Expressway, Jaipur, Rajasthan - 303007',
                'year' => '2011',
                'campus' => 'Online Manipal Cloud LMS with Free Coursera Access',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+ | WES Recognized',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => '64',
                'nirf_year' => '2024',
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.8,
                'reviews_count' => 920,
                'highest' => '30 LPA',
                'average' => '7.5 LPA',
                'top_recruiters' => 'Accenture, Deloitte, KPMG, EY, Amazon, Microsoft, Genpact, Infosys',
                'overview' => 'Manipal University Jaipur Online (Online Manipal) represents the 70-year legacy of Manipal Education in digital higher learning. NAAC A+ accredited and UGC-DEB approved, MUJ Online offers top-tier online MBA, MCA, BBA, and BCA programs integrated with complimentary Coursera certification access, expert faculty, and placement drives.',
                'scholarship_info' => 'Defence personnel concessions (20%), Divyang scholarship, and alumni benefits. Flexible no-cost EMI options available.',
                'is_featured' => true,
                'courses' => [
                    ['slug' => 'mba',     'spec' => 'Financial Management',                       'fee' => 87500, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with min 50% marks', 'duration' => '2 Years'],
                    ['slug' => 'mba',     'spec' => 'Marketing Management',                       'fee' => 87500, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with min 50% marks', 'duration' => '2 Years'],
                    ['slug' => 'mba',     'spec' => 'Human Resource Management',                  'fee' => 87500, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with min 50% marks', 'duration' => '2 Years'],
                    ['slug' => 'mba',     'spec' => 'Business Analytics',                         'fee' => 87500, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with min 50% marks', 'duration' => '2 Years'],
                    ['slug' => 'mba',     'spec' => 'Banking & Financial Services',               'fee' => 87500, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with min 50% marks', 'duration' => '2 Years'],
                    ['slug' => 'mba',     'spec' => 'IT & FinTech',                               'fee' => 87500, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with min 50% marks', 'duration' => '2 Years'],
                    ['slug' => 'mca',     'spec' => 'Cloud Computing & DevOps',                   'fee' => 75000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. Computer Science or Maths', 'duration' => '2 Years'],
                    ['slug' => 'mca',     'spec' => 'Data Science & Analytics',                   'fee' => 75000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. Computer Science or Maths', 'duration' => '2 Years'],
                    ['slug' => 'bba',     'spec' => 'General Management',                         'fee' => 45000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (min 50%)',   'duration' => '3 Years'],
                    ['slug' => 'bca',     'spec' => 'Software Engineering',                       'fee' => 45000, 'type' => 'per_year', 'eligibility' => '10+2 with min 50% aggregate',          'duration' => '3 Years'],
                    ['slug' => 'bcom',    'spec' => 'Accounting & Finance',                       'fee' => 33000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream (min 50%)',          'duration' => '3 Years'],
                    ['slug' => 'mcom',    'spec' => 'Financial Management',                       'fee' => 38000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA from recognized university', 'duration' => '2 Years'],
                    ['slug' => 'ma-jmc',  'spec' => 'Digital Journalism',                         'fee' => 55000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline',   'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => '70+ Years of Academic Excellence', 'value' => 'Renowned Manipal Brand', 'icon' => 'bi-award-fill'],
                    ['title' => 'NAAC A+ Accreditation (3.28 CGPA)', 'value' => 'High Quality Standards', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'Complimentary Coursera Access', 'value' => '4,000+ Courses & Certifications', 'icon' => 'bi-mortarboard-fill'],
                    ['title' => 'WES & ICAS Recognized Worldwide', 'value' => 'Eligible for US & Canada Evaluation', 'icon' => 'bi-globe'],
                    ['title' => '30 LPA Highest Placement Package', 'value' => 'Manipal Placement Drives', 'icon' => 'bi-briefcase-fill'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Education Degrees', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Grade A+ Accredited', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                    ['authority' => 'NIRF', 'accreditation' => 'Ranked #64 in India (University Category)', 'grade' => null, 'rank' => '64', 'year' => '2024'],
                    ['authority' => 'WES', 'accreditation' => 'World Education Services Recognized', 'grade' => null, 'rank' => null, 'year' => '2025'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Requirements', 'content' => '10+2 with 50% for UG; Bachelor’s degree with 50% for PG.', 'items' => ['10+2 or equivalent', 'Graduation degree (for PG)']],
                    ['key' => 'how_to_apply', 'title' => 'Admission Steps', 'content' => 'Seamless digital admission process through GrowPec.', 'items' => ['Fill application', 'Counseling verification', 'Fee payment & student activation']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Scanned copies of academic records and government ID.', 'items' => ['10th/12th/Graduation certificates', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Defence Personnel Concession', 'eligibility' => 'Serving and retired military personnel', 'criteria' => 'Armed Forces', 'amount' => null, 'label' => '20% Tuition Fee Waiver', 'pct' => '20%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '30 LPA', 'year' => '2024', 'course' => 'MBA / MCA'],
                    ['label' => 'Average Package', 'value' => '7.5 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Accenture', 'Deloitte', 'KPMG', 'EY', 'Amazon', 'Microsoft', 'Genpact', 'Infosys'],
                'career_outcomes' => [
                    ['role' => 'Financial Analyst', 'industry' => 'BFSI & Fintech', 'avg_salary' => '7 - 14 LPA', 'range' => '5 - 22 LPA'],
                ],
                'facilities' => [
                    ['name' => 'Cloud LMS & Mobile App', 'icon' => 'bi-laptop'],
                    ['name' => 'Free Coursera Enterprise Access', 'icon' => 'bi-globe2'],
                    ['name' => 'Weekend Live Classes', 'icon' => 'bi-camera-video'],
                ],
                'faqs' => [
                    ['q' => 'Is Manipal University Jaipur Online degree accepted for WES Canada evaluation?', 'a' => 'Yes. Manipal University Jaipur is approved by UGC-DEB and recognized by WES (World Education Services), making it 100% valid for Canadian PR and educational assessments.'],
                ],
            ],

            /* 4. Jain University Online (JAIN Online) */
            [
                'name' => 'Jain University Online',
                'short_name' => 'JAIN Online',
                'slug' => 'jain-university-online',
                'type' => 'Deemed',
                'university' => 'JAIN (Deemed-to-be University)',
                'website' => 'https://onlinejain.com',
                'state' => 'Karnataka',
                'city' => 'Bengaluru',
                'address' => '#44/4, District Fund Road, Jayanagar 9th Block, Bengaluru, Karnataka - 560069',
                'year' => '1990',
                'campus' => 'JAIN Online LMS with AI Learning Assistant',
                'approvals' => 'UGC-DEB | AICTE | NAAC A++ | KSURF Ranked',
                'naac_grade' => 'A++',
                'ugc_approved' => true,
                'nirf_rank' => '65',
                'nirf_year' => '2024',
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.7,
                'reviews_count' => 710,
                'highest' => '28 LPA',
                'average' => '6.5 LPA',
                'top_recruiters' => 'Google, PayPal, Flipkart, Infosys, Morgan Stanley, Ernst & Young, Amazon',
                'overview' => 'JAIN Online from JAIN (Deemed-to-be University) Bengaluru holds the prestigious NAAC A++ accreditation. Renowned for over 70+ cutting-edge specializations across FinTech, Data Science, AI, and Digital Business, JAIN Online pairs academic excellence with its ConnectToWork corporate placement network.',
                'scholarship_info' => 'Corporate discounts, defence personnel benefits, and merit fee concessions. Easy monthly EMI starting from ₹4,000/month.',
                'is_featured' => true,
                'courses' => [
                    ['slug' => 'mba',       'spec' => 'Data Science',                               'fee' => 80000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50% in any field',       'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Digital Marketing',                          'fee' => 80000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50% in any field',       'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'FinTech',                                    'fee' => 85000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50% in any field',       'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Financial Management',                       'fee' => 80000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50% in any field',       'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Human Resource Management',                  'fee' => 80000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50% in any field',       'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Cyber Security',                             'fee' => 70000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Mathematics',         'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Full Stack Development',                     'fee' => 70000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Mathematics',         'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 72000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Mathematics',         'duration' => '2 Years'],
                    ['slug' => 'bca',       'spec' => 'Data Science',                               'fee' => 55000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (min 50%)',        'duration' => '3 Years'],
                    ['slug' => 'bca',       'spec' => 'Cloud & Security',                           'fee' => 55000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (min 50%)',        'duration' => '3 Years'],
                    ['slug' => 'bba',       'spec' => 'Digital Business & E-Commerce',              'fee' => 55000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (min 50%)',        'duration' => '3 Years'],
                    ['slug' => 'bba',       'spec' => 'Data Science & Analytics',                   'fee' => 58000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (min 50%)',        'duration' => '3 Years'],
                    ['slug' => 'bcom-hons', 'spec' => 'International Finance & Accounting',          'fee' => 45000, 'type' => 'per_year', 'eligibility' => '10+2 Commerce or relevant stream',           'duration' => '3 Years'],
                    ['slug' => 'mcom',      'spec' => 'Financial Management',                       'fee' => 45000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA from recognized university',     'duration' => '2 Years'],
                    ['slug' => 'ma',        'spec' => 'Economics',                                  'fee' => 42000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline',        'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A++ Accredited Grade', 'value' => 'Highest Rating Tier in India', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'Bengaluru Tech Capital Advantage', 'value' => 'Direct Startup & Corporate Connect', 'icon' => 'bi-geo-alt-fill'],
                    ['title' => '70+ Next-Gen Specializations', 'value' => 'FinTech, AI, Cloud, Digital Marketing', 'icon' => 'bi-cpu-fill'],
                    ['title' => 'ConnectToWork Career Fair Network', 'value' => 'Placement Assurance Assistance', 'icon' => 'bi-briefcase-fill'],
                    ['title' => '28 LPA Highest CTC', 'value' => 'Top Tech Giants Hiring', 'icon' => 'bi-cash-coin'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Degree Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Grade A++ (Highest Rating)', 'grade' => 'A++', 'rank' => null, 'year' => '2022'],
                    ['authority' => 'NIRF', 'accreditation' => 'Ranked #65 in India (University Category)', 'grade' => null, 'rank' => '65', 'year' => '2024'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Admissions Eligibility', 'content' => 'UG: 10+2 with 50%. PG: 3-year bachelor\'s with 50%.', 'items' => ['10+2 marksheet', 'Undergraduate degree certificate for PG']],
                    ['key' => 'how_to_apply', 'title' => 'Online Admission Guide', 'content' => 'Apply online through GrowPec for immediate document assessment.', 'items' => ['Fill registration form', 'Upload certificates', 'Pay fee online']],
                    ['key' => 'documents', 'title' => 'Required Documents', 'content' => 'Academic records and Government ID.', 'items' => ['10th and 12th marksheet', 'Graduation marksheet (for PG)', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Corporate Partner Discount', 'eligibility' => 'Employees of partner corporate firms', 'criteria' => 'Corporate Network', 'amount' => null, 'label' => '10% Tuition Concession', 'pct' => '10%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '28 LPA', 'year' => '2024', 'course' => 'MBA / MCA'],
                    ['label' => 'Average Package', 'value' => '6.5 LPA', 'year' => '2024', 'course' => 'All Programs'],
                ],
                'recruiters' => ['Google', 'PayPal', 'Flipkart', 'Infosys', 'Morgan Stanley', 'Ernst & Young', 'Amazon'],
                'career_outcomes' => [
                    ['role' => 'Data Analyst', 'industry' => 'Analytics & IT', 'avg_salary' => '6 - 12 LPA', 'range' => '4.5 - 18 LPA'],
                ],
                'facilities' => [
                    ['name' => 'AI-Enabled Digital LMS', 'icon' => 'bi-laptop'],
                    ['name' => 'Weekend Live Masterclasses', 'icon' => 'bi-camera-video'],
                ],
                'faqs' => [
                    ['q' => 'What is the specialization variety at JAIN Online?', 'a' => 'JAIN Online offers more than 70+ in-demand specializations, including FinTech, Digital Business, AI, Cloud Computing, and Investment Banking.'],
                ],
            ],

            /* 5. Dr. D.Y. Patil Vidyapeeth Online (DY Patil Online) */
            [
                'name' => 'Dr. D.Y. Patil Vidyapeeth Online (DPU COL)',
                'short_name' => 'DY Patil Online',
                'slug' => 'dy-patil-university-online',
                'type' => 'Deemed',
                'university' => 'Dr. D.Y. Patil Vidyapeeth, Pune',
                'website' => 'https://www.dpuonline.com',
                'state' => 'Maharashtra',
                'city' => 'Pune',
                'address' => 'Sant Tukaram Nagar, Pimpri, Pune, Maharashtra - 411018',
                'year' => '2003',
                'campus' => 'DPU Centre for Online Learning (COL) Virtual Campus',
                'approvals' => 'UGC-DEB | AICTE | NAAC A++ | Category-I University',
                'naac_grade' => 'A++',
                'ugc_approved' => true,
                'nirf_rank' => '44',
                'nirf_year' => '2024',
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.6,
                'reviews_count' => 540,
                'highest' => '18 LPA',
                'average' => '6.0 LPA',
                'top_recruiters' => 'Bajaj Finserv, HDFC Bank, ICICI Bank, Tech Mahindra, Capgemini, Kotak Mahindra',
                'overview' => 'Dr. D. Y. Patil Vidyapeeth Centre for Online Learning (DPU-COL) Pune is a Category-1 Deemed University holding NAAC A++ accreditation. Highly acclaimed for Healthcare Management, Hospital Administration, and traditional MBA/BBA programs, DPU COL provides corporate executive education with flexible proctored examinations.',
                'scholarship_info' => 'Special concessions for healthcare workers, defence personnel, and female learners. EMI options starting at ₹3,500/month.',
                'is_featured' => false,
                'courses' => [
                    ['slug' => 'mba', 'spec' => 'Hospital & Healthcare Management',     'fee' => 70000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any field with 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba', 'spec' => 'Financial Management',                 'fee' => 70000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any field with 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba', 'spec' => 'Marketing Management',                 'fee' => 70000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any field with 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba', 'spec' => 'Human Resource Management',            'fee' => 70000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any field with 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba', 'spec' => 'Agri-Business Management',             'fee' => 70000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any field with 50%', 'duration' => '2 Years'],
                    ['slug' => 'bba', 'spec' => 'General Management',                   'fee' => 45000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (45%)',          'duration' => '3 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A++ Accredited University', 'value' => 'Highest National Grade', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC Category-1 Graded Status', 'value' => 'Top Autonomous Tier', 'icon' => 'bi-shield-check'],
                    ['title' => 'Leader in Hospital & Healthcare MBA', 'value' => 'Direct Industry Relevance', 'icon' => 'bi-hospital-fill'],
                    ['title' => 'Flexible Online Proctored Exams', 'value' => 'From Home Comfort', 'icon' => 'bi-display'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Distance and Online Education', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Grade A++ (3.64 CGPA)', 'grade' => 'A++', 'rank' => null, 'year' => '2022'],
                    ['authority' => 'NIRF', 'accreditation' => 'Ranked #44 (University Category)', 'grade' => null, 'rank' => '44', 'year' => '2024'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Conditions', 'content' => 'Graduation with min 50% for MBA; 10+2 with 45% for BBA.', 'items' => ['Graduation in any discipline', 'No entrance exam needed']],
                    ['key' => 'how_to_apply', 'title' => 'Admission Process', 'content' => 'Online application facilitated by GrowPec.', 'items' => ['Submit online application', 'Document check', 'Course fee payment']],
                    ['key' => 'documents', 'title' => 'Document List', 'content' => 'KYC and academic marksheets required.', 'items' => ['10th and 12th certificate', 'Degree certificates', 'Government ID proof']],
                ],
                'scholarships' => [
                    ['name' => 'Healthcare Worker Privilege', 'eligibility' => 'Working doctors, nurses, hospital staff', 'criteria' => 'Healthcare Service', 'amount' => null, 'label' => '15% Tuition Concession', 'pct' => '15%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '18 LPA', 'year' => '2024', 'course' => 'MBA'],
                    ['label' => 'Average Package', 'value' => '6.0 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Bajaj Finserv', 'HDFC Bank', 'ICICI Bank', 'Tech Mahindra', 'Capgemini', 'Kotak Mahindra'],
                'career_outcomes' => [
                    ['role' => 'Healthcare Administrator', 'industry' => 'Hospitals & Healthcare', 'avg_salary' => '6 - 12 LPA', 'range' => '4.5 - 18 LPA'],
                ],
                'facilities' => [
                    ['name' => 'DPU e-Portal Learning System', 'icon' => 'bi-laptop'],
                    ['name' => 'Live Faculty Mentoring', 'icon' => 'bi-camera-video'],
                ],
                'faqs' => [
                    ['q' => 'Is Healthcare Management MBA popular at DY Patil?', 'a' => 'Yes. D.Y. Patil Vidyapeeth has prestigious medical institutions, making its Online Healthcare & Hospital Management MBA highly sought after across corporate hospital chains.'],
                ],
            ],

            /* 6. Uttaranchal University Online */
            [
                'name' => 'Uttaranchal University Online',
                'short_name' => 'UU Online',
                'slug' => 'uttaranchal-university-online',
                'type' => 'Private',
                'university' => 'Uttaranchal University',
                'website' => 'https://onlineuu.in',
                'state' => 'Uttarakhand',
                'city' => 'Dehradun',
                'address' => 'Arcadia Grant, Chandanwari, Prem Nagar, Dehradun, Uttarakhand - 248007',
                'year' => '2013',
                'campus' => 'Online Directorate of Education, Dehradun',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => '101-150 Band',
                'nirf_year' => '2024',
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.5,
                'reviews_count' => 400,
                'highest' => '22 LPA',
                'average' => '5.5 LPA',
                'top_recruiters' => 'Infosys, HCL, Mindtree, Deloitte, Tommy Hilfiger, Trident Group',
                'overview' => 'Uttaranchal University Online Dehradun holds NAAC A+ accreditation and UGC-DEB recognition. Offering affordable tuition fees, practical project work, interactive faculty webinars, and flexible exams, it is ideal for students seeking quality degrees on a friendly budget.',
                'scholarship_info' => 'Uttarakhand domicile concession, Defence benefits, and merit discounts. Installment plans available.',
                'is_featured' => false,
                'courses' => [
                    ['slug' => 'mba',  'spec' => 'Marketing Management',                       'fee' => 45000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with min 50%',   'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Financial Management',                       'fee' => 45000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with min 50%',   'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Human Resource Management',                  'fee' => 45000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with min 50%',   'duration' => '2 Years'],
                    ['slug' => 'mca',  'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 40000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Maths',       'duration' => '2 Years'],
                    ['slug' => 'bba',  'spec' => 'General Management',                         'fee' => 30000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (45%)', 'duration' => '3 Years'],
                    ['slug' => 'bca',  'spec' => 'General Computer Applications',              'fee' => 30000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (45%)', 'duration' => '3 Years'],
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',                       'fee' => 24000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',        'duration' => '3 Years'],
                    ['slug' => 'ba',   'spec' => 'English',                                    'fee' => 18000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream',                 'duration' => '3 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A+ Accredited University', 'value' => 'High Quality Benchmark', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Entitled Degree Programs', 'value' => '100% Legally Recognized', 'icon' => 'bi-shield-check'],
                    ['title' => 'Most Affordable Online Fee Structure', 'value' => 'Starting ₹18,000/Year', 'icon' => 'bi-currency-rupee'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Degree Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with A+ Grade', 'grade' => 'A+', 'rank' => null, 'year' => '2022'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Criteria', 'content' => '10+2 for UG; Bachelor’s degree for PG from a recognized board/university.', 'items' => ['10+2 or equivalent', 'Graduation degree (for PG)']],
                    ['key' => 'how_to_apply', 'title' => 'Application Flow', 'content' => 'Complete enrollment in less than 15 minutes online.', 'items' => ['Apply via GrowPec', 'Upload certificates', 'Pay admission fee']],
                    ['key' => 'documents', 'title' => 'Required Documents', 'content' => 'Standard educational certificates & Government ID.', 'items' => ['10th/12th certificate', 'Graduation marksheet (for PG)', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Uttarakhand Domicile Discount', 'eligibility' => 'Residents of Uttarakhand State', 'criteria' => 'State Domicile', 'amount' => null, 'label' => '10% Fee Rebate', 'pct' => '10%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '22 LPA', 'year' => '2024', 'course' => 'Campus & Online'],
                    ['label' => 'Average Package', 'value' => '5.5 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Infosys', 'HCL', 'Mindtree', 'Deloitte', 'Tommy Hilfiger', 'Trident Group'],
                'career_outcomes' => [
                    ['role' => 'Executive Associate', 'industry' => 'Corporate Services', 'avg_salary' => '4 - 8 LPA', 'range' => '3.5 - 12 LPA'],
                ],
                'facilities' => [
                    ['name' => 'Interactive Digital LMS', 'icon' => 'bi-laptop'],
                    ['name' => 'Weekly Live Classes & Doubt Clearing', 'icon' => 'bi-camera-video'],
                ],
                'faqs' => [
                    ['q' => 'What is the fee for MBA at Uttaranchal University Online?', 'a' => 'The MBA program fee is approximately ₹45,000 per year, making it one of the most budget-friendly NAAC A+ online MBA degrees in India.'],
                ],
            ],

            /* 7. Suresh Gyan Vihar University Online (SGVU) */
            [
                'name' => 'Suresh Gyan Vihar University Online',
                'short_name' => 'SGVU Online',
                'slug' => 'suresh-gyan-vihar-university-online',
                'type' => 'Private',
                'university' => 'Suresh Gyan Vihar University',
                'website' => 'https://www.sgvu.edu.in',
                'state' => 'Rajasthan',
                'city' => 'Jaipur',
                'address' => 'Mahal, Jagatpura, Jaipur, Rajasthan - 302017',
                'year' => '2008',
                'campus' => 'Centre for Distance & Online Education (CDOE), Jaipur',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => null,
                'nirf_year' => null,
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.4,
                'reviews_count' => 360,
                'highest' => '15 LPA',
                'average' => '4.8 LPA',
                'top_recruiters' => 'Genpact, ICICI Prudential, Teleperformance, Wipro, Reliance Retail',
                'overview' => 'SGVU CDOE is Rajasthan\'s pioneering NAAC A+ accredited university for distance and online education. Known for career-oriented management and computer science programs with comprehensive study material and industry-aligned LMS portal.',
                'scholarship_info' => 'Early enrollment concessions and corporate group discounts available.',
                'is_featured' => false,
                'courses' => [
                    ['slug' => 'mba',  'spec' => 'Marketing Management',                 'fee' => 36000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',            'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Financial Management',                 'fee' => 36000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',            'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Human Resource Management',            'fee' => 36000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',            'duration' => '2 Years'],
                    ['slug' => 'mca',  'spec' => 'Software Engineering',                 'fee' => 32000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. IT with Maths',           'duration' => '2 Years'],
                    ['slug' => 'bba',  'spec' => 'General Management',                   'fee' => 24000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                    ['slug' => 'bca',  'spec' => 'General Computer Applications',         'fee' => 24000, 'type' => 'per_year', 'eligibility' => '10+2 with Maths or Computer',         'duration' => '3 Years'],
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',                 'fee' => 18000, 'type' => 'per_year', 'eligibility' => '10+2 Commerce or any stream',          'duration' => '3 Years'],
                    ['slug' => 'mcom', 'spec' => 'Financial Management',                 'fee' => 22000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA from recognized university', 'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'Rajasthan\'s 1st NAAC A+ Private University', 'value' => 'Top Quality Assurance', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Approved Degree Programs', 'value' => 'Globally Valid', 'icon' => 'bi-shield-check'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled Online/Distance University', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Requirements', 'content' => '10+2 for UG; Graduation for PG from an authorized institution.', 'items' => ['10+2 or equivalent', 'Undergraduate degree for PG']],
                    ['key' => 'how_to_apply', 'title' => 'Application Flow', 'content' => 'Submit enquiry on GrowPec, get verified, and receive enrollment.', 'items' => ['Fill form', 'Submit documents', 'Pay fee online']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Identification and previous school records.', 'items' => ['10th/12th/Graduation marksheets', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Corporate Sponsor Concession', 'eligibility' => 'Students sponsored by companies', 'criteria' => 'Corporate Scheme', 'amount' => null, 'label' => '10% Rebate', 'pct' => '10%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '15 LPA', 'year' => '2024', 'course' => 'MBA'],
                    ['label' => 'Average Package', 'value' => '4.8 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Genpact', 'ICICI Prudential', 'Teleperformance', 'Wipro', 'Reliance Retail'],
                'career_outcomes' => [
                    ['role' => 'Operations Team Lead', 'industry' => 'Operations & Retail', 'avg_salary' => '4.5 - 9 LPA', 'range' => '3.5 - 12 LPA'],
                ],
                'facilities' => [
                    ['name' => 'Digital Student LMS', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Can working professionals from other states join SGVU Online?', 'a' => 'Yes. Since the entire learning and examination workflow is digital, students from any Indian state or international location can easily enroll and graduate.'],
                ],
            ],

            /* 8. Vivekananda Global University Online (VGU) */
            [
                'name' => 'Vivekananda Global University Online',
                'short_name' => 'VGU Online',
                'slug' => 'vivekananda-global-university-online',
                'type' => 'Private',
                'university' => 'Vivekananda Global University',
                'website' => 'https://vguonline.com',
                'state' => 'Rajasthan',
                'city' => 'Jaipur',
                'address' => 'Sector 36, NRI Road, Jagatpura, Jaipur, Rajasthan - 303012',
                'year' => '2012',
                'campus' => 'VGU Digital Campus, Jaipur',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => null,
                'nirf_year' => null,
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.5,
                'reviews_count' => 330,
                'highest' => '18 LPA',
                'average' => '5.2 LPA',
                'top_recruiters' => 'Samsung, TCS, BYJU\'S, Vivo, Pine Labs, Paytm, Tech Mahindra',
                'overview' => 'Vivekananda Global University Online (VGU Online) Jaipur is NAAC A+ accredited and approved by UGC-DEB. Emphasizing entrepreneurial mindset, practical corporate exposure, and industry certifications, VGU Online provides interactive LMS features and flexible exam schedules.',
                'scholarship_info' => 'Merit and sports scholarship policies applicable. Easy EMI starting from ₹3,800/month.',
                'is_featured' => false,
                'courses' => [
                    ['slug' => 'mba',       'spec' => 'Agri-Business Management',                   'fee' => 44000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Financial Management',                       'fee' => 44000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Marketing Management',                       'fee' => 44000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 38000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. with Maths',  'duration' => '2 Years'],
                    ['slug' => 'bba',       'spec' => 'Marketing',                                  'fee' => 28000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board', 'duration' => '3 Years'],
                    ['slug' => 'bca',       'spec' => 'Software Engineering',                       'fee' => 28000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board', 'duration' => '3 Years'],
                    ['slug' => 'bcom',      'spec' => 'Accounting & Finance',                       'fee' => 22000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board', 'duration' => '3 Years'],
                    ['slug' => 'msc-maths', 'spec' => 'Pure & Applied Mathematics',                 'fee' => 28000, 'type' => 'per_year', 'eligibility' => 'B.Sc. with Mathematics',   'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A+ Accreditation', 'value' => 'High Grade Quality', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Entitled Degree Programs', 'value' => 'Valid for all Govt & MNC jobs', 'icon' => 'bi-shield-check'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Education Degrees', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2022'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Admission Rules', 'content' => '10+2 for UG; Bachelor’s degree for PG from a recognized board/university.', 'items' => ['10+2 or equivalent', 'Graduation degree (for PG)']],
                    ['key' => 'how_to_apply', 'title' => 'How to Enroll', 'content' => 'Guided admission support on GrowPec.', 'items' => ['Submit form', 'Verification', 'Fee payment']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Academic records and identity documents.', 'items' => ['10th/12th/Graduation certificates', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Merit Excellence Award', 'eligibility' => '80%+ in previous degree', 'criteria' => 'Academic Merit', 'amount' => null, 'label' => '15% Waiver', 'pct' => '15%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '18 LPA', 'year' => '2024', 'course' => 'MBA / MCA'],
                    ['label' => 'Average Package', 'value' => '5.2 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Samsung', 'TCS', 'BYJU\'S', 'Vivo', 'Pine Labs', 'Paytm', 'Tech Mahindra'],
                'career_outcomes' => [
                    ['role' => 'Project Associate', 'industry' => 'Corporate IT', 'avg_salary' => '5 - 10 LPA', 'range' => '4 - 15 LPA'],
                ],
                'facilities' => [
                    ['name' => 'VGU Online LMS Portal', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Is VGU Online degree valid for higher education abroad?', 'a' => 'Yes. VGU is recognized by UGC under Section 2(f) and holds NAAC A+ accreditation, satisfying international equivalency criteria.'],
                ],
            ],

            /* 9. Jaipur National University (JNU) */
            [
                'name' => 'Jaipur National University Online & Distance',
                'short_name' => 'JNU Jaipur Online',
                'slug' => 'jaipur-national-university-online',
                'type' => 'Private',
                'university' => 'Jaipur National University',
                'website' => 'https://www.jnujaipur.ac.in',
                'state' => 'Rajasthan',
                'city' => 'Jaipur',
                'address' => 'Jaipur-Agra Bypass, Jagatpura, Jaipur, Rajasthan - 302017',
                'year' => '2007',
                'campus' => 'School of Distance Education and Learning (SODEL), Jaipur',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => null,
                'nirf_year' => null,
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.4,
                'reviews_count' => 440,
                'highest' => '16 LPA',
                'average' => '4.9 LPA',
                'top_recruiters' => 'Infosys, Capgemini, IBM, Fortis, HDFC, Oberoi Hotels',
                'overview' => 'Jaipur National University SODEL is one of Rajasthan\'s premier institutions for distance and online learning. With UGC-DEB recognition and NAAC A+ accreditation, it offers versatile programs designed for both working executives and fresh students.',
                'scholarship_info' => 'Concessions for alumni and female learners. Installment facilities available.',
                'is_featured' => false,
                'courses' => [
                    ['slug' => 'mba',  'spec' => 'Marketing Management',                 'fee' => 35000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',            'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Financial Management',                 'fee' => 35000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',            'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Human Resource Management',            'fee' => 35000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',            'duration' => '2 Years'],
                    ['slug' => 'mca',  'spec' => 'Software Engineering',                 'fee' => 30000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. with Maths',              'duration' => '2 Years'],
                    ['slug' => 'bba',  'spec' => 'General Management',                   'fee' => 22000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                    ['slug' => 'bca',  'spec' => 'General Computer Applications',         'fee' => 22000, 'type' => 'per_year', 'eligibility' => '10+2 with Maths or Computer',         'duration' => '3 Years'],
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',                 'fee' => 16000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                    ['slug' => 'mcom', 'spec' => 'Financial Management',                 'fee' => 20000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA from recognized university', 'duration' => '2 Years'],
                    ['slug' => 'ba',   'spec' => 'English',                              'fee' => 14000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream',                  'duration' => '3 Years'],
                    ['slug' => 'ma',   'spec' => 'English Literature',                   'fee' => 16000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any stream',      'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A+ Accredited University', 'value' => 'Excellence in Education', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Entitled Higher Education', 'value' => 'Government & MNC Accepted', 'icon' => 'bi-shield-check'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Distance and Online Education', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Basic Eligibility', 'content' => '10+2 for UG; 3-year Bachelor’s for PG courses.', 'items' => ['10+2 from recognized board', 'Undergraduate degree for PG']],
                    ['key' => 'how_to_apply', 'title' => 'How to Apply', 'content' => 'Enquire via GrowPec for full support.', 'items' => ['Fill application', 'Verify certificates', 'Pay fee']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Marksheets and identification.', 'items' => ['10th/12th/Graduation records', 'ID proof']],
                ],
                'scholarships' => [
                    ['name' => 'Women Empowerment Concession', 'eligibility' => 'All female applicants', 'criteria' => 'Social Welfare', 'amount' => null, 'label' => '10% Fee Rebate', 'pct' => '10%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '16 LPA', 'year' => '2024', 'course' => 'MBA / MCA'],
                    ['label' => 'Average Package', 'value' => '4.9 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Infosys', 'Capgemini', 'IBM', 'Fortis', 'HDFC', 'Oberoi Hotels'],
                'career_outcomes' => [
                    ['role' => 'Business Coordinator', 'industry' => 'Corporate Management', 'avg_salary' => '4 - 8 LPA', 'range' => '3.5 - 12 LPA'],
                ],
                'facilities' => [
                    ['name' => 'JNU SODEL Learning Management System', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Does JNU Jaipur provide printed study material?', 'a' => 'Yes. Students have the option to receive physical self-learning material (SLM) delivered right to their home address alongside complete portal access.'],
                ],
            ],

            /* 10. GLA University Online */
            [
                'name' => 'GLA University Online',
                'short_name' => 'GLA Online',
                'slug' => 'gla-university-online',
                'type' => 'Private',
                'university' => 'GLA University, Mathura',
                'website' => 'https://glaonline.com',
                'state' => 'Uttar Pradesh',
                'city' => 'Mathura',
                'address' => '17 Km Stone, NH-2, Mathura-Delhi Road, Mathura, UP - 281406',
                'year' => '2010',
                'campus' => 'GLA Online Digital Campus, Mathura',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+ | NIRF Ranked',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => '53',
                'nirf_year' => '2024',
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.6,
                'reviews_count' => 480,
                'highest' => '25 LPA',
                'average' => '6.2 LPA',
                'top_recruiters' => 'Accenture, Capgemini, TCS, Wipro, Microsoft, Tech Mahindra',
                'overview' => 'GLA University Online Mathura is NAAC A+ accredited and approved by UGC-DEB. Leveraging engineering and management frameworks, GLA Online features AI-assisted curriculum delivery, recorded micro-modules, real-time doubt solving, and widespread corporate placement tie-ups.',
                'scholarship_info' => 'Alumni rebates, Defence personnel concessions, and early bird discounts. No-cost EMI starting from ₹4,000/month.',
                'is_featured' => true,
                'courses' => [
                    ['slug' => 'mba',       'spec' => 'Marketing Management',                       'fee' => 45000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Financial Management',                       'fee' => 45000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Human Resource Management',                  'fee' => 45000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Banking & Financial Services',               'fee' => 45000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%', 'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Cloud Computing & DevOps',                   'fee' => 40000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. with Maths',   'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 42000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. with Maths',   'duration' => '2 Years'],
                    ['slug' => 'bba',       'spec' => 'General Management',                         'fee' => 30000, 'type' => 'per_year', 'eligibility' => '10+2 with min 50%',        'duration' => '3 Years'],
                    ['slug' => 'bca',       'spec' => 'Software Engineering',                       'fee' => 30000, 'type' => 'per_year', 'eligibility' => '10+2 with min 50%',        'duration' => '3 Years'],
                    ['slug' => 'bcom-hons', 'spec' => 'Accounting & Finance',                       'fee' => 24000, 'type' => 'per_year', 'eligibility' => '10+2 with min 50%',        'duration' => '3 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A+ Accreditation (3.46 Score)', 'value' => 'Premier Quality Standing', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Entitled Online Programs', 'value' => 'Recognized Nationwide', 'icon' => 'bi-shield-check'],
                    ['title' => '25 LPA Highest Placement Package', 'value' => '500+ Corporate Recruiters', 'icon' => 'bi-briefcase-fill'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Education Degrees', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                    ['authority' => 'NIRF', 'accreditation' => 'Ranked #53 in India', 'grade' => null, 'rank' => '53', 'year' => '2024'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility', 'content' => 'Graduation with min 50% for MBA/MCA; 10+2 with 50% for BBA/BCA.', 'items' => ['10+2 from recognized board', 'Bachelor’s degree for PG']],
                    ['key' => 'how_to_apply', 'title' => 'Admission Steps', 'content' => 'Easy online application via GrowPec.', 'items' => ['Form submission', 'Verification', 'Fee payment']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Academic records and identity documents.', 'items' => ['10th/12th/Graduation certificates', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Defence Wards Concession', 'eligibility' => 'Wards of armed forces personnel', 'criteria' => 'Armed Forces', 'amount' => null, 'label' => '15% Tuition Concession', 'pct' => '15%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '25 LPA', 'year' => '2024', 'course' => 'MBA / MCA'],
                    ['label' => 'Average Package', 'value' => '6.2 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Accenture', 'Capgemini', 'TCS', 'Wipro', 'Microsoft', 'Tech Mahindra'],
                'career_outcomes' => [
                    ['role' => 'IT Project Consultant', 'industry' => 'IT & Software', 'avg_salary' => '6 - 12 LPA', 'range' => '4.5 - 18 LPA'],
                ],
                'facilities' => [
                    ['name' => 'GLA Online Portal', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'How are project evaluations handled at GLA Online?', 'a' => 'Project evaluations and capstone assignments are submitted through the GLA Online LMS, followed by online evaluation with industry mentors.'],
                ],
            ],

            /* 11. Mangalayatan University Online */
            [
                'name' => 'Mangalayatan University Online',
                'short_name' => 'Mangalayatan Online',
                'slug' => 'mangalayatan-university-online',
                'type' => 'Private',
                'university' => 'Mangalayatan University, Aligarh',
                'website' => 'https://www.mangalayatan.in',
                'state' => 'Uttar Pradesh',
                'city' => 'Aligarh',
                'address' => '33rd Milestone, Aligarh-Mathura Highway, Beswan, Aligarh, UP - 202145',
                'year' => '2006',
                'campus' => 'Directorate of Distance & Online Education, Aligarh',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => null,
                'nirf_year' => null,
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.3,
                'reviews_count' => 320,
                'highest' => '12 LPA',
                'average' => '4.5 LPA',
                'top_recruiters' => 'Infosys, HCL, Radisson, Capgemini, Abbott, Tech Mahindra',
                'overview' => 'Mangalayatan University Directorate of Online Education is NAAC A+ accredited and recognized by UGC-DEB. Aiming to provide high-quality, inclusive, and affordable education, it delivers practical management, IT, arts, and commerce degree programs with flexible payment options.',
                'scholarship_info' => 'Early enrollment fee waivers and rural empowerment concessions.',
                'is_featured' => false,
                'courses' => [
                    ['slug' => 'mba',       'spec' => 'Marketing Management',                 'fee' => 33000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 45%',            'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Financial Management',                 'fee' => 33000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 45%',            'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Human Resource Management',            'fee' => 33000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 45%',            'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Software Engineering',                 'fee' => 28000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Maths',         'duration' => '2 Years'],
                    ['slug' => 'bba',       'spec' => 'General Management',                   'fee' => 21000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                    ['slug' => 'bca',       'spec' => 'General Computer Applications',         'fee' => 21000, 'type' => 'per_year', 'eligibility' => '10+2 with Maths or Computer',         'duration' => '3 Years'],
                    ['slug' => 'bcom',      'spec' => 'Accounting & Finance',                 'fee' => 15000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                    ['slug' => 'mcom',      'spec' => 'Financial Management',                 'fee' => 18000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA from recognized university', 'duration' => '2 Years'],
                    ['slug' => 'ba',        'spec' => 'Political Science',                    'fee' => 12000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream',                  'duration' => '3 Years'],
                    ['slug' => 'ma',        'spec' => 'Political Science',                    'fee' => 14000, 'type' => 'per_year', 'eligibility' => 'Graduation in any stream',             'duration' => '2 Years'],
                    ['slug' => 'msc-maths', 'spec' => 'Pure & Applied Mathematics',           'fee' => 20000, 'type' => 'per_year', 'eligibility' => 'B.Sc. with Mathematics',               'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A+ Accredited University', 'value' => 'Official Quality Mark', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Entitled Online Degrees', 'value' => 'Govt Job & Higher Study Valid', 'icon' => 'bi-shield-check'],
                    ['title' => 'Budget Friendly Tuition Fee', 'value' => 'Starting ₹12,000/Year', 'icon' => 'bi-currency-rupee'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Education', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Conditions', 'content' => '10+2 for UG; Bachelor’s degree for PG from a recognized board/university.', 'items' => ['10+2 or equivalent', 'Graduation degree (for PG)']],
                    ['key' => 'how_to_apply', 'title' => 'Enrollment Process', 'content' => 'Apply online via GrowPec.', 'items' => ['Fill application', 'Verify certificates', 'Pay fee']],
                    ['key' => 'documents', 'title' => 'Required Documents', 'content' => 'Marksheets and identification.', 'items' => ['10th/12th/Graduation records', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Rural Student Concession', 'eligibility' => 'Candidates from rural areas', 'criteria' => 'Social Welfare', 'amount' => null, 'label' => '10% Fee Concession', 'pct' => '10%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '12 LPA', 'year' => '2024', 'course' => 'MBA'],
                    ['label' => 'Average Package', 'value' => '4.5 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Infosys', 'HCL', 'Radisson', 'Capgemini', 'Abbott', 'Tech Mahindra'],
                'career_outcomes' => [
                    ['role' => 'Operations Associate', 'industry' => 'Corporate Management', 'avg_salary' => '4 - 7 LPA', 'range' => '3 - 10 LPA'],
                ],
                'facilities' => [
                    ['name' => 'Mangalayatan Online LMS', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Is Mangalayatan University Online recognized by UGC?', 'a' => 'Yes. Mangalayatan University is recognized by the UGC and entitled by the Distance Education Bureau (DEB) for online degree programs.'],
                ],
            ],

            /* 12. Swami Vivekanand Subharti University (Subharti Online) */
            [
                'name' => 'Swami Vivekanand Subharti University Online & Distance',
                'short_name' => 'Subharti Online',
                'slug' => 'swami-vivekanand-subharti-university-online',
                'type' => 'Private',
                'university' => 'Swami Vivekanand Subharti University',
                'website' => 'https://subhartidde.com',
                'state' => 'Uttar Pradesh',
                'city' => 'Meerut',
                'address' => 'Subhartipuram, NH-58, Delhi-Haridwar Bypass Road, Meerut, UP - 250005',
                'year' => '2008',
                'campus' => 'Directorate of Distance Education (DDE), Meerut',
                'approvals' => 'UGC-DEB | AICTE | NAAC A',
                'naac_grade' => 'A',
                'ugc_approved' => true,
                'nirf_rank' => null,
                'nirf_year' => null,
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.4,
                'reviews_count' => 530,
                'highest' => '14 LPA',
                'average' => '4.6 LPA',
                'top_recruiters' => 'Fortis, Wipro, HCL, Reliance, Tech Mahindra, Axis Bank',
                'overview' => 'Swami Vivekanand Subharti University Directorate of Distance Education (DDE) Meerut is one of North India\'s most prominent distance and online education providers. NAAC \'A\' accredited and recognized by UGC-DEB, it offers extensive pan-India network support, economical fees, and verified credentials.',
                'scholarship_info' => 'Defence and police personnel fee concessions, alumni benefits, and special social category rebates.',
                'is_featured' => false,
                'courses' => [
                    ['slug' => 'mba',  'spec' => 'Marketing Management',                 'fee' => 28000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with 45%',         'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Financial Management',                 'fee' => 28000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with 45%',         'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Human Resource Management',            'fee' => 28000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with 45%',         'duration' => '2 Years'],
                    ['slug' => 'mca',  'spec' => 'Software Engineering',                 'fee' => 24000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Maths',          'duration' => '2 Years'],
                    ['slug' => 'bba',  'spec' => 'General Management',                   'fee' => 18000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                    ['slug' => 'bca',  'spec' => 'General Computer Applications',         'fee' => 18000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',                 'fee' => 14000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                    ['slug' => 'mcom', 'spec' => 'Corporate Accounting',                 'fee' => 16000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA from recognized university', 'duration' => '2 Years'],
                    ['slug' => 'ba',   'spec' => 'Sociology',                            'fee' => 10000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream',                  'duration' => '3 Years'],
                    ['slug' => 'ma',   'spec' => 'Sociology',                            'fee' => 12000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any stream',      'duration' => '2 Years'],
                    ['slug' => 'blis', 'spec' => 'Library Cataloging & Digital Management', 'fee' => 16000, 'type' => 'per_year', 'eligibility' => 'Graduation in any discipline',              'duration' => '1 Year'],
                    ['slug' => 'mlis', 'spec' => 'Advanced Library Informatics',          'fee' => 18000, 'type' => 'per_year', 'eligibility' => 'BLIS from recognized university',       'duration' => '1 Year'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A Grade Accredited', 'value' => 'Established Quality University', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Approved Higher Education', 'value' => 'Govt Job Recognized', 'icon' => 'bi-shield-check'],
                    ['title' => 'Highly Economical Fees', 'value' => 'Starting ₹10,000/Year', 'icon' => 'bi-currency-rupee'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Approved Distance Education Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade A', 'grade' => 'A', 'rank' => null, 'year' => '2022'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Requirements', 'content' => '10+2 for UG; Graduation for PG from an authorized institution.', 'items' => ['10+2 or equivalent', 'Undergraduate degree for PG']],
                    ['key' => 'how_to_apply', 'title' => 'Application Steps', 'content' => 'Complete enrollment assisted by GrowPec counsellors.', 'items' => ['Fill application', 'Submit KYC & Marksheets', 'Pay tuition fee']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Identification and previous school records.', 'items' => ['10th/12th/Graduation marksheets', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Defence & Police Personnel Discount', 'eligibility' => 'Serving and retired police/military personnel', 'criteria' => 'Public Service', 'amount' => null, 'label' => '15% Concession', 'pct' => '15%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '14 LPA', 'year' => '2024', 'course' => 'MBA'],
                    ['label' => 'Average Package', 'value' => '4.6 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Fortis', 'Wipro', 'HCL', 'Reliance', 'Tech Mahindra', 'Axis Bank'],
                'career_outcomes' => [
                    ['role' => 'Information Specialist', 'industry' => 'Corporate & Research', 'avg_salary' => '4 - 7 LPA', 'range' => '3 - 10 LPA'],
                ],
                'facilities' => [
                    ['name' => 'Subharti DDE Learning Portal', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Is Subharti University distance degree approved for government examinations?', 'a' => 'Yes. Subharti DDE degrees are approved by UGC-DEB and are completely valid for all state and central government examinations.'],
                ],
            ],

            /* 13. Shobhit University Online */
            [
                'name' => 'Shobhit University Online',
                'short_name' => 'Shobhit Online',
                'slug' => 'shobhit-university-online',
                'type' => 'Deemed',
                'university' => 'Shobhit Institute of Engineering & Technology (Deemed-to-be University)',
                'website' => 'https://www.shobhituniversity.ac.in',
                'state' => 'Uttar Pradesh',
                'city' => 'Meerut',
                'address' => 'Modipuram, Meerut, Uttar Pradesh - 250110',
                'year' => '2006',
                'campus' => 'Centre for Distance & Online Learning, Meerut',
                'approvals' => 'UGC-DEB | AICTE | NAAC \'A\' Grade',
                'naac_grade' => 'A',
                'ugc_approved' => true,
                'nirf_rank' => null,
                'nirf_year' => null,
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.3,
                'reviews_count' => 290,
                'highest' => '15 LPA',
                'average' => '4.8 LPA',
                'top_recruiters' => 'Apollo, Cognizant, IBM, L&T Infotech, Tech Mahindra, Wipro',
                'overview' => 'Shobhit University Online Education wing provides career-oriented education accredited with NAAC \'A\' Grade and recognized by UGC-DEB. Programs emphasize industry-ready competencies, flexible evaluations, and corporate skill enhancements.',
                'scholarship_info' => 'Academic merit scholarships and corporate alumni concessions.',
                'is_featured' => false,
                'courses' => [
                    ['slug' => 'mba',  'spec' => 'Marketing Management',                 'fee' => 35000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with 45%',         'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Financial Management',                 'fee' => 35000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with 45%',         'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Human Resource Management',            'fee' => 35000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree with 45%',         'duration' => '2 Years'],
                    ['slug' => 'mca',  'spec' => 'Software Engineering',                 'fee' => 30000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Maths',          'duration' => '2 Years'],
                    ['slug' => 'bba',  'spec' => 'General Management',                   'fee' => 22000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                    ['slug' => 'bca',  'spec' => 'General Computer Applications',         'fee' => 22000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',                 'fee' => 16000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',           'duration' => '3 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A Grade Deemed University', 'value' => 'High National Standing', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Entitled Higher Education', 'value' => 'Valid for all Govt & MNC jobs', 'icon' => 'bi-shield-check'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Education Degrees', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade A', 'grade' => 'A', 'rank' => null, 'year' => '2022'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Requirements', 'content' => '10+2 for UG; Graduation for PG from an authorized institution.', 'items' => ['10+2 or equivalent', 'Undergraduate degree for PG']],
                    ['key' => 'how_to_apply', 'title' => 'How to Enroll', 'content' => 'Online enrollment assisted by GrowPec.', 'items' => ['Submit form', 'Verification', 'Fee payment']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Identification and previous school records.', 'items' => ['10th/12th/Graduation marksheets', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Merit Scholarship', 'eligibility' => '75%+ in qualifying exam', 'criteria' => 'Academic Merit', 'amount' => null, 'label' => '10% Fee Waiver', 'pct' => '10%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '15 LPA', 'year' => '2024', 'course' => 'MBA / MCA'],
                    ['label' => 'Average Package', 'value' => '4.8 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Apollo', 'Cognizant', 'IBM', 'L&T Infotech', 'Tech Mahindra', 'Wipro'],
                'career_outcomes' => [
                    ['role' => 'Business Executive', 'industry' => 'Corporate Services', 'avg_salary' => '4 - 8 LPA', 'range' => '3.5 - 12 LPA'],
                ],
                'facilities' => [
                    ['name' => 'Shobhit Digital LMS', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Is Shobhit University a Deemed University?', 'a' => 'Yes. Shobhit Institute of Engineering & Technology was granted Deemed-to-be University status under Section 3 of the UGC Act 1956.'],
                ],
            ],

            /* 14. Aligarh Muslim University Online (AMU CDOE) */
            [
                'name' => 'Aligarh Muslim University Online (AMU CDOE)',
                'short_name' => 'AMU Online',
                'slug' => 'aligarh-muslim-university-online',
                'type' => 'Govt',
                'university' => 'Aligarh Muslim University (Central University)',
                'website' => 'https://amuonline.in',
                'state' => 'Uttar Pradesh',
                'city' => 'Aligarh',
                'address' => 'Centre for Distance and Online Education, Aligarh, Uttar Pradesh - 202002',
                'year' => '1920',
                'campus' => 'Centre for Distance and Online Education (CDOE), AMU',
                'approvals' => 'Central University | UGC-DEB | NAAC A+ | NIRF #9',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => '9',
                'nirf_year' => '2024',
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.9,
                'reviews_count' => 910,
                'highest' => '20 LPA',
                'average' => '6.0 LPA',
                'top_recruiters' => 'Wipro, TCS, Genpact, ICICI Bank, Tata Motors, L&T, HDFC Bank',
                'overview' => 'Aligarh Muslim University (AMU), established in 1920, is an Institution of National Importance and a premier Central University of India ranked #9 in NIRF 2024. Its Centre for Distance and Online Education (CDOE) provides globally recognized, UGC-DEB approved undergraduate and postgraduate programs at highly economical government fee structures.',
                'scholarship_info' => 'Highly subsidized government fee structure. Concessions for economically weaker sections (EWS) as per central government norms.',
                'is_featured' => true,
                'courses' => [
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',                 'fee' => 12000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (45%)',             'duration' => '3 Years'],
                    ['slug' => 'mcom', 'spec' => 'Financial Management',                 'fee' => 15000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA with min 45%',                      'duration' => '2 Years'],
                    ['slug' => 'ba',   'spec' => 'Economics',                            'fee' => 10500, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',                  'duration' => '3 Years'],
                    ['slug' => 'ba',   'spec' => 'History',                              'fee' => 10500, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',                  'duration' => '3 Years'],
                    ['slug' => 'ma',   'spec' => 'English Literature',                   'fee' => 13000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline',          'duration' => '2 Years'],
                    ['slug' => 'ma',   'spec' => 'Political Science',                    'fee' => 13000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline',          'duration' => '2 Years'],
                    ['slug' => 'ma',   'spec' => 'Economics',                            'fee' => 13000, 'type' => 'per_year', 'eligibility' => 'Bachelor\'s degree in any discipline',          'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'General Management',                   'fee' => 30000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',                      'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'NIRF Rank #9 Central University', 'value' => 'Institution of National Importance', 'icon' => 'bi-award-fill'],
                    ['title' => 'NAAC A+ Accredited Grade', 'value' => 'Prestigious Heritage Legacy', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Approved Online Programs', 'value' => 'Valid Globally & for Govt Jobs', 'icon' => 'bi-shield-check'],
                    ['title' => 'Subsidized Government Fees', 'value' => 'Most Affordable in India', 'icon' => 'bi-currency-rupee'],
                ],
                'accreditations' => [
                    ['authority' => 'Central University', 'accreditation' => 'Enacted by Act of Parliament', 'grade' => null, 'rank' => null, 'year' => '1920'],
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Distance and Online Education', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                    ['authority' => 'NIRF', 'accreditation' => 'Top 10 Universities of India', 'grade' => null, 'rank' => '9', 'year' => '2024'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Criteria', 'content' => '10+2 from recognized board for UG; Bachelor’s degree for PG from any recognized university.', 'items' => ['10+2 from CBSE/State Board/Equivalent', 'Bachelor’s degree for PG']],
                    ['key' => 'how_to_apply', 'title' => 'How to Register', 'content' => 'Apply online through GrowPec portal with assisted documentation.', 'items' => ['Fill admission application', 'Upload verified documents', 'Pay government fee online']],
                    ['key' => 'documents', 'title' => 'Document Checklist', 'content' => 'Academic records and Government Photo ID.', 'items' => ['10th and 12th marksheet', 'Graduation certificate (for PG)', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Central Govt EWS Concession', 'eligibility' => 'Economically Weaker Section candidates', 'criteria' => 'Income Certificate', 'amount' => null, 'label' => 'Subsidized Government Fees', 'pct' => null],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '20 LPA', 'year' => '2024', 'course' => 'AMU Overall'],
                    ['label' => 'Average Package', 'value' => '6.0 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Wipro', 'TCS', 'Genpact', 'ICICI Bank', 'Tata Motors', 'L&T', 'HDFC Bank'],
                'career_outcomes' => [
                    ['role' => 'Research & Public Policy Analyst', 'industry' => 'Public Sector & Corporate', 'avg_salary' => '5 - 10 LPA', 'range' => '4 - 16 LPA'],
                ],
                'facilities' => [
                    ['name' => 'AMU Online CDOE Learning Platform', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Is AMU Online a Government Central University?', 'a' => 'Yes. Aligarh Muslim University (AMU) is a premier Central University established by an Act of Parliament and is directly funded by the Ministry of Education, Government of India.'],
                ],
            ],

            /* 15. IIMT University, Meerut */
            [
                'name' => 'IIMT University Online, Meerut',
                'short_name' => 'IIMT Online',
                'slug' => 'iimt-university-meerut-online',
                'type' => 'Private',
                'university' => 'IIMT University, Meerut',
                'website' => 'https://iimtu.edu.in',
                'state' => 'Uttar Pradesh',
                'city' => 'Meerut',
                'address' => 'O-Pocket, Ganga Nagar, Meerut, Uttar Pradesh - 250001',
                'year' => '2016',
                'campus' => 'IIMT Online Directorate, Meerut',
                'approvals' => 'UGC-DEB | AICTE | NAAC B++',
                'naac_grade' => 'B++',
                'ugc_approved' => true,
                'nirf_rank' => null,
                'nirf_year' => null,
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.3,
                'reviews_count' => 300,
                'highest' => '12 LPA',
                'average' => '4.2 LPA',
                'top_recruiters' => 'Paytm, Wipro, Infosys, Tech Mahindra, JustDial, Capgemini',
                'overview' => 'IIMT University Online Meerut provides accessible and flexible undergraduate and postgraduate online degree programs. Focused on career transition, skill development, and executive flexibility, it features weekend live lectures and self-paced digital learning materials.',
                'scholarship_info' => 'Merit and regional domicile fee concessions available.',
                'is_featured' => false,
                'courses' => [
                    ['slug' => 'mba',  'spec' => 'Marketing Management',                 'fee' => 32000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 45%',    'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Financial Management',                 'fee' => 32000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 45%',    'duration' => '2 Years'],
                    ['slug' => 'mca',  'spec' => 'Software Engineering',                 'fee' => 28000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Maths', 'duration' => '2 Years'],
                    ['slug' => 'bba',  'spec' => 'General Management',                   'fee' => 20000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',  'duration' => '3 Years'],
                    ['slug' => 'bca',  'spec' => 'General Computer Applications',         'fee' => 20000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',  'duration' => '3 Years'],
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',                 'fee' => 15000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',  'duration' => '3 Years'],
                    ['slug' => 'ba',   'spec' => 'History',                              'fee' => 12000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream',         'duration' => '3 Years'],
                ],
                'highlights' => [
                    ['title' => 'UGC-DEB Approved Degree Courses', 'value' => 'Legally Valid for Higher Studies & Jobs', 'icon' => 'bi-shield-check'],
                    ['title' => 'Economical Fee Structure', 'value' => 'Starting ₹12,000/Year', 'icon' => 'bi-currency-rupee'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Approved Online Degrees', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade B++', 'grade' => 'B++', 'rank' => null, 'year' => '2023'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility', 'content' => '10+2 for UG; Graduation for PG from an authorized institution.', 'items' => ['10+2 or equivalent', 'Undergraduate degree for PG']],
                    ['key' => 'how_to_apply', 'title' => 'Admission Guide', 'content' => 'Direct online admission through GrowPec.', 'items' => ['Fill form', 'Document submission', 'Fee payment']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Identification and previous school records.', 'items' => ['10th/12th/Graduation marksheets', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Merit Scholarship', 'eligibility' => '70%+ in previous degree', 'criteria' => 'Academic Merit', 'amount' => null, 'label' => '10% Fee Waiver', 'pct' => '10%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '12 LPA', 'year' => '2024', 'course' => 'MBA'],
                    ['label' => 'Average Package', 'value' => '4.2 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Paytm', 'Wipro', 'Infosys', 'Tech Mahindra', 'JustDial', 'Capgemini'],
                'career_outcomes' => [
                    ['role' => 'Operations Associate', 'industry' => 'Corporate Management', 'avg_salary' => '4 - 7 LPA', 'range' => '3 - 10 LPA'],
                ],
                'facilities' => [
                    ['name' => 'IIMT Online Learning Portal', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Is IIMT University degree valid across India?', 'a' => 'Yes. As a UGC-recognized university entitled by UGC-DEB, its degrees are valid across all private and public sector jobs throughout India.'],
                ],
            ],

            /* 16. Amity University Online, Noida */
            [
                'name' => 'Amity University Online, Noida',
                'short_name' => 'Amity Online',
                'slug' => 'amity-university-online',
                'type' => 'Private',
                'university' => 'Amity University Uttar Pradesh',
                'website' => 'https://www.amityonline.com',
                'state' => 'Uttar Pradesh',
                'city' => 'Noida',
                'address' => 'Amity University, Sector 125, Noida, Uttar Pradesh - 201313',
                'year' => '2005',
                'campus' => 'Amity Online Digital Campus, Sector 125, Noida',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+ | WES Accredited | QS Ranked',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => '35',
                'nirf_year' => '2024',
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.8,
                'reviews_count' => 995,
                'highest' => '25 LPA',
                'average' => '6.5 LPA',
                'top_recruiters' => 'Amazon, Google, Deloitte, IBM, Infosys, Accenture, American Express',
                'overview' => 'Amity University Online is India\'s pioneer in digital higher education and the first to receive UGC approval for online degree courses. Featuring NAAC A+ accreditation, global WES acceptance, and its AI-driven LMS (Amigo), Amity Online offers career-focused degrees with real-world case studies and global placement fairs.',
                'scholarship_info' => 'Early bird discount up to 20% on first-semester fee, merit scholarships, and defence benefits. Flexible 0% interest EMI options.',
                'is_featured' => true,
                'courses' => [
                    ['slug' => 'mba',       'spec' => 'Marketing Management',                       'fee' => 85000, 'type' => 'per_year', 'eligibility' => 'Any graduation from recognized university', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Financial Management',                       'fee' => 85000, 'type' => 'per_year', 'eligibility' => 'Any graduation from recognized university', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Human Resource Management',                  'fee' => 85000, 'type' => 'per_year', 'eligibility' => 'Any graduation from recognized university', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Business Analytics',                         'fee' => 95000, 'type' => 'per_year', 'eligibility' => 'Any graduation from recognized university', 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Digital Marketing',                          'fee' => 90000, 'type' => 'per_year', 'eligibility' => 'Any graduation from recognized university', 'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 75000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Maths',             'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Cloud Computing & DevOps',                   'fee' => 75000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Maths',             'duration' => '2 Years'],
                    ['slug' => 'bca',       'spec' => 'Software Engineering',                       'fee' => 55000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (45%)',        'duration' => '3 Years'],
                    ['slug' => 'bba',       'spec' => 'Marketing',                                  'fee' => 50000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (45%)',        'duration' => '3 Years'],
                    ['slug' => 'bcom-hons', 'spec' => 'Corporate Accounting',                       'fee' => 45000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream (45%)',               'duration' => '3 Years'],
                    ['slug' => 'mcom',      'spec' => 'Financial Management',                       'fee' => 50000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA from recognized university',     'duration' => '2 Years'],
                    ['slug' => 'ba-jmc',    'spec' => 'Electronic & Print Media',                   'fee' => 48000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream (45%)',               'duration' => '3 Years'],
                    ['slug' => 'ma-jmc',    'spec' => 'Strategic Communications',                   'fee' => 55000, 'type' => 'per_year', 'eligibility' => 'Graduation in any stream',                 'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'India\'s 1st UGC Recognized Online University', 'value' => 'Pioneer in EdTech Higher Education', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'NAAC A+ Accreditation & QS Asia Ranked', 'value' => 'Top 3% Global Universities', 'icon' => 'bi-award-fill'],
                    ['title' => 'AI-Powered LMS (Amigo)', 'value' => 'Micro-learning, Quizzes & Mentorship', 'icon' => 'bi-laptop'],
                    ['title' => 'WES & QS Recognized Worldwide', 'value' => 'Valid for Overseas Work & Study', 'icon' => 'bi-globe'],
                    ['title' => '25 LPA Highest Placement Package', 'value' => 'Virtual Job Fairs & 300+ Recruiters', 'icon' => 'bi-briefcase-fill'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for 100% Online Degrees', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                    ['authority' => 'NIRF', 'accreditation' => 'Ranked #35 in India (University Category)', 'grade' => null, 'rank' => '35', 'year' => '2024'],
                    ['authority' => 'WES', 'accreditation' => 'World Education Services Recognized (USA/Canada)', 'grade' => null, 'rank' => null, 'year' => '2025'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Guidelines', 'content' => '10+2 with min 45% for UG; Bachelor’s degree in any discipline with min 45% for PG.', 'items' => ['10+2 certificate from recognized board', 'Graduation from UGC-recognized university', 'No entrance exam needed']],
                    ['key' => 'how_to_apply', 'title' => 'Admission Steps', 'content' => 'Fast online registration through GrowPec.', 'items' => ['Complete enquiry form', 'Free counselling call', 'Submit documentation', 'Fee payment & immediate portal access']],
                    ['key' => 'documents', 'title' => 'Checklist of Documents', 'content' => 'Digital self-attested copies.', 'items' => ['10th and 12th marksheets', 'Graduation certificates (for PG)', 'Aadhaar Card / Passport', 'Recent photo']],
                ],
                'scholarships' => [
                    ['name' => 'Early Bird Enrollment Waiver', 'eligibility' => 'Students enrolling in initial batch', 'criteria' => 'Early Admission', 'amount' => null, 'label' => '20% First-Semester Waiver', 'pct' => '20%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '25 LPA', 'year' => '2024', 'course' => 'MBA / MCA'],
                    ['label' => 'Average Package', 'value' => '6.5 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Amazon', 'Google', 'Deloitte', 'IBM', 'Infosys', 'Accenture', 'American Express'],
                'career_outcomes' => [
                    ['role' => 'Strategy Consultant', 'industry' => 'Consulting & IT', 'avg_salary' => '7 - 14 LPA', 'range' => '5 - 20 LPA'],
                ],
                'facilities' => [
                    ['name' => 'Amity Amigo AI-Enabled LMS', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Is Amity Online degree recognized by WES for Canadian immigration?', 'a' => 'Yes! Amity University degrees are recognized by WES (World Education Services) and ICAS, making them completely eligible for foreign visa assessments and PR processes.'],
                ],
            ],

            /* 17. Graphic Era University (GEU Online) */
            [
                'name' => 'Graphic Era University Online (GEU Online)',
                'short_name' => 'GEU Online',
                'slug' => 'graphic-era-university-online',
                'type' => 'Deemed',
                'university' => 'Graphic Era (Deemed to be University), Dehradun',
                'website' => 'https://onlinegeu.in',
                'state' => 'Uttarakhand',
                'city' => 'Dehradun',
                'address' => '566/6, Bell Road, Clement Town, Dehradun, Uttarakhand - 248002',
                'year' => '1993',
                'campus' => 'Centre for Distance & Online Learning, Dehradun',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+ | NIRF #52',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => '52',
                'nirf_year' => '2024',
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.7,
                'reviews_count' => 490,
                'highest' => '32 LPA',
                'average' => '7.0 LPA',
                'top_recruiters' => 'Adobe, Amazon, Google, Microsoft, Samsung, Zscaler, TCS',
                'overview' => 'Graphic Era (Deemed to be University) Online Dehradun brings 30+ years of academic excellence into modern digital education. Ranked #52 in NIRF 2024 with NAAC A+ accreditation, GEU Online offers tech and management degrees featuring intensive live interactions, mentorship from industry veterans, and top placement records.',
                'scholarship_info' => 'Himalayan state domicile concession, Defence personnel benefits, and merit scholarships. No-cost EMI starting from ₹4,500/month.',
                'is_featured' => true,
                'courses' => [
                    ['slug' => 'mba',       'spec' => 'Marketing Management',                       'fee' => 60000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',                 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Financial Management',                       'fee' => 60000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',                 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Human Resource Management',                  'fee' => 60000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',                 'duration' => '2 Years'],
                    ['slug' => 'mba',       'spec' => 'Operations & Supply Chain Management',       'fee' => 60000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',                 'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 55000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. IT with Maths',               'duration' => '2 Years'],
                    ['slug' => 'mca',       'spec' => 'Cloud Computing & DevOps',                   'fee' => 55000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. IT with Maths',               'duration' => '2 Years'],
                    ['slug' => 'bba',       'spec' => 'General Management',                         'fee' => 38000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (50%)',         'duration' => '3 Years'],
                    ['slug' => 'bca',       'spec' => 'Data Science',                               'fee' => 38000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (50%)',         'duration' => '3 Years'],
                    ['slug' => 'bcom-hons', 'spec' => 'Corporate Accounting',                       'fee' => 28000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',                'duration' => '3 Years'],
                    ['slug' => 'mcom',      'spec' => 'Financial Management',                       'fee' => 32000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA from recognized university',     'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'NIRF Rank #52 in India', 'value' => 'Premier Deemed University', 'icon' => 'bi-award-fill'],
                    ['title' => 'NAAC A+ Accredited Quality', 'value' => 'Highest Standards', 'icon' => 'bi-patch-check-fill'],
                    ['title' => '32 LPA Highest Package', 'value' => 'Global Tech Titans Hiring', 'icon' => 'bi-briefcase-fill'],
                    ['title' => 'UGC-DEB Entitled Online Degrees', 'value' => 'Completely Valid Worldwide', 'icon' => 'bi-shield-check'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Degree Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                    ['authority' => 'NIRF', 'accreditation' => 'National Institutional Ranking Framework', 'grade' => null, 'rank' => '52', 'year' => '2024'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility', 'content' => 'Graduation with min 50% for PG; 10+2 with 50% for UG.', 'items' => ['10+2 from recognized board', 'Undergraduate degree for PG']],
                    ['key' => 'how_to_apply', 'title' => 'How to Enroll', 'content' => 'Apply online with GrowPec support.', 'items' => ['Submit form', 'Verification', 'Fee payment']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Marksheets and identification.', 'items' => ['10th/12th/Graduation certificates', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Uttarakhand / Hill Domicile Waiver', 'eligibility' => 'Residents of Uttarakhand / Hilly States', 'criteria' => 'Domicile', 'amount' => null, 'label' => '10% Tuition Concession', 'pct' => '10%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '32 LPA', 'year' => '2024', 'course' => 'Tech & Management'],
                    ['label' => 'Average Package', 'value' => '7.0 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Adobe', 'Amazon', 'Google', 'Microsoft', 'Samsung', 'Zscaler', 'TCS'],
                'career_outcomes' => [
                    ['role' => 'Senior Software Engineer', 'industry' => 'IT & Product Development', 'avg_salary' => '7.5 - 15 LPA', 'range' => '5 - 25 LPA'],
                ],
                'facilities' => [
                    ['name' => 'GEU Digital Portal', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Is Graphic Era University Online degree valid for higher studies?', 'a' => 'Yes. Graphic Era (Deemed to be University) is recognized by UGC under Section 3 of UGC Act 1956 and entitled by UGC-DEB, ensuring full validity for Master’s, Ph.D., and government employment.'],
                ],
            ],

            /* 18. Noida International University (NIU Online) */
            [
                'name' => 'Noida International University Online (NIU Online)',
                'short_name' => 'NIU Online',
                'slug' => 'noida-international-university-online',
                'type' => 'Private',
                'university' => 'Noida International University',
                'website' => 'https://niu.edu.in',
                'state' => 'Uttar Pradesh',
                'city' => 'Noida',
                'address' => 'Plot 1, Sector 17-A, Yamuna Expressway, Gautam Budh Nagar, UP - 203201',
                'year' => '2010',
                'campus' => 'NIU Centre for Distance and Online Education',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => null,
                'nirf_year' => null,
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.5,
                'reviews_count' => 350,
                'highest' => '18 LPA',
                'average' => '5.0 LPA',
                'top_recruiters' => 'HCL, Tech Mahindra, BYJU\'S, Cognizant, Wipro, Genpact',
                'overview' => 'Noida International University Online (NIU Online) is NAAC A+ accredited and recognized by UGC-DEB. Strategically positioned along the Yamuna Expressway in the National Capital Region (NCR), it provides contemporary management, IT, and commerce degree programs with flexible learning, global curriculum modules, and interactive faculty sessions.',
                'scholarship_info' => 'Women empowerment concessions and early bird enrollment rebates.',
                'is_featured' => false,
                'courses' => [
                    ['slug' => 'mba',  'spec' => 'Marketing Management',                 'fee' => 42000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 45%',    'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Financial Management',                 'fee' => 42000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 45%',    'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Human Resource Management',            'fee' => 42000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 45%',    'duration' => '2 Years'],
                    ['slug' => 'mca',  'spec' => 'Software Engineering',                 'fee' => 38000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. with Maths',      'duration' => '2 Years'],
                    ['slug' => 'bba',  'spec' => 'General Management',                   'fee' => 26000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',  'duration' => '3 Years'],
                    ['slug' => 'bca',  'spec' => 'General Computer Applications',         'fee' => 26000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',  'duration' => '3 Years'],
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',                 'fee' => 20000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',  'duration' => '3 Years'],
                    ['slug' => 'ba',   'spec' => 'English',                              'fee' => 16000, 'type' => 'per_year', 'eligibility' => '10+2 in any stream',         'duration' => '3 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A+ Accredited University', 'value' => 'High Educational Standing', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'UGC-DEB Approved Degree Programs', 'value' => 'Legally Valid for Govt & Private Jobs', 'icon' => 'bi-shield-check'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Education', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Criteria', 'content' => '10+2 for UG; Graduation for PG from a recognized board/university.', 'items' => ['10+2 or equivalent', 'Graduation degree (for PG)']],
                    ['key' => 'how_to_apply', 'title' => 'Enrollment Steps', 'content' => 'Apply online through GrowPec portal.', 'items' => ['Submit form', 'Verification', 'Fee payment']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Academic records and identification.', 'items' => ['10th/12th/Graduation certificates', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Girl Child Empowerment Scholarship', 'eligibility' => 'All female candidates', 'criteria' => 'Social Welfare', 'amount' => null, 'label' => '10% Fee Waiver', 'pct' => '10%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '18 LPA', 'year' => '2024', 'course' => 'MBA / MCA'],
                    ['label' => 'Average Package', 'value' => '5.0 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['HCL', 'Tech Mahindra', 'BYJU\'S', 'Cognizant', 'Wipro', 'Genpact'],
                'career_outcomes' => [
                    ['role' => 'Business Operations Associate', 'industry' => 'Corporate Management', 'avg_salary' => '4.5 - 8 LPA', 'range' => '3.5 - 12 LPA'],
                ],
                'facilities' => [
                    ['name' => 'NIU Online LMS Portal', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Where is Noida International University located?', 'a' => 'NIU is located on the Yamuna Expressway in Greater Noida, Gautam Budh Nagar, UP.'],
                ],
            ],

            /* 19. SGT University Online, Gurugram */
            [
                'name' => 'SGT University Online, Gurugram',
                'short_name' => 'SGT Online',
                'slug' => 'sgt-university-online',
                'type' => 'Private',
                'university' => 'Shree Guru Gobind Singh Tricentenary University, Gurugram',
                'website' => 'https://sgtuniversity.ac.in',
                'state' => 'Haryana',
                'city' => 'Gurugram',
                'address' => 'Chandu-Budhera, Gurugram-Badli Road, Gurugram, Haryana - 122505',
                'year' => '2013',
                'campus' => 'SGT Online Centre Virtual Campus, Gurugram',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+',
                'naac_grade' => 'A+',
                'ugc_approved' => true,
                'nirf_rank' => null,
                'nirf_year' => null,
                'entrance_exams' => 'Direct Admission / Merit Based',
                'rating' => 4.6,
                'reviews_count' => 420,
                'highest' => '18 LPA',
                'average' => '5.5 LPA',
                'top_recruiters' => 'Deloitte, Infosys, Tech Mahindra, Fortis, Max Healthcare, Radisson',
                'overview' => 'SGT University Online Gurugram (NAAC A+) delivers career-focused online higher education situated right at the heart of Millennium City\'s corporate hub. Offering flexible online MBA, MCA, BBA, and BCA degrees, SGT Online features live interaction with corporate CXOs, hands-on business simulations, and placement drives across Gurugram and Delhi NCR.',
                'scholarship_info' => 'Haryana domicile concession and corporate executive fee waivers. No-cost EMI starting from ₹4,000/month.',
                'is_featured' => true,
                'courses' => [
                    ['slug' => 'mba',  'spec' => 'Marketing Management',                 'fee' => 50000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',            'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Financial Management',                 'fee' => 50000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',            'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Human Resource Management',            'fee' => 50000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',            'duration' => '2 Years'],
                    ['slug' => 'mba',  'spec' => 'Hospital & Healthcare Management',     'fee' => 55000, 'type' => 'per_year', 'eligibility' => 'Graduation with min 50%',            'duration' => '2 Years'],
                    ['slug' => 'mca',  'spec' => 'Cloud Computing & DevOps',             'fee' => 44000, 'type' => 'per_year', 'eligibility' => 'BCA / Graduation with Maths',         'duration' => '2 Years'],
                    ['slug' => 'bba',  'spec' => 'General Management',                   'fee' => 32000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (45%)',    'duration' => '3 Years'],
                    ['slug' => 'bca',  'spec' => 'Software Engineering',                 'fee' => 32000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board (45%)',    'duration' => '3 Years'],
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',                 'fee' => 24000, 'type' => 'per_year', 'eligibility' => '10+2 from recognized board',          'duration' => '3 Years'],
                    ['slug' => 'mcom', 'spec' => 'Financial Management',                 'fee' => 28000, 'type' => 'per_year', 'eligibility' => 'B.Com / BBA from recognized university', 'duration' => '2 Years'],
                ],
                'highlights' => [
                    ['title' => 'NAAC A+ Accredited University', 'value' => 'Excellence in Higher Education', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'Corporate Hub Gurugram Advantage', 'value' => 'Direct Access to 500+ MNCs', 'icon' => 'bi-building-fill'],
                    ['title' => 'UGC-DEB Entitled Online Degrees', 'value' => 'Valid for all Central/State Govt Jobs', 'icon' => 'bi-shield-check'],
                ],
                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online Education Degrees', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'Accredited with Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                ],
                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Requirements', 'content' => '10+2 for UG programs; 3-year Bachelor’s for PG courses from a recognized university.', 'items' => ['10+2 from recognized board', 'Undergraduate degree for PG']],
                    ['key' => 'how_to_apply', 'title' => 'How to Register', 'content' => 'Apply online via GrowPec with step-by-step guidance.', 'items' => ['Fill form', 'Document verification', 'Fee payment']],
                    ['key' => 'documents', 'title' => 'Documents Checklist', 'content' => 'Academic records and identification.', 'items' => ['10th/12th/Graduation certificates', 'Aadhaar Card']],
                ],
                'scholarships' => [
                    ['name' => 'Haryana Domicile Rebate', 'eligibility' => 'Residents of Haryana state', 'criteria' => 'State Domicile', 'amount' => null, 'label' => '10% Fee Concession', 'pct' => '10%'],
                ],
                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '18 LPA', 'year' => '2024', 'course' => 'MBA / MCA'],
                    ['label' => 'Average Package', 'value' => '5.5 LPA', 'year' => '2024', 'course' => 'Overall'],
                ],
                'recruiters' => ['Deloitte', 'Infosys', 'Tech Mahindra', 'Fortis', 'Max Healthcare', 'Radisson'],
                'career_outcomes' => [
                    ['role' => 'Business Analyst', 'industry' => 'Corporate Management', 'avg_salary' => '5 - 10 LPA', 'range' => '4 - 15 LPA'],
                ],
                'facilities' => [
                    ['name' => 'SGT Digital Learning Portal', 'icon' => 'bi-laptop'],
                ],
                'faqs' => [
                    ['q' => 'Is SGT University Gurugram degree recognized for overseas employment?', 'a' => 'Yes. SGT University is UGC recognized and NAAC A+ accredited, meeting international criteria for higher education and foreign job credentials.'],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 4. Database Inserters with Full Relational & Streamlining Support
    |--------------------------------------------------------------------------
    */
    private function insertCourses(int $collegeId, array $courses): void
    {
        $now = now();
        $hasCcsTable = Schema::hasTable('college_course_specializations');
        $hasCcfTable = Schema::hasTable('college_course_fees');

        foreach ($courses as $i => $c) {
            $courseId = $this->courseIds[$c['slug']] ?? null;
            if (! $courseId) {
                continue;
            }
            $specId = ($c['spec'] && isset($this->specializationIds[$c['slug'].'|'.$c['spec']]))
                ? $this->specializationIds[$c['slug'].'|'.$c['spec']]
                : null;

            $courseName = DB::table('courses')->where('id', $courseId)->value('name');

            $ccPayload = [
                'college_id' => $collegeId,
                'course_id' => $courseId,
                'specialization' => $c['spec'],
                'specialization_id' => $specId,
                'fee_amount' => $c['fee'],
                'fee_type' => $c['type'],
                'eligibility' => $c['eligibility'],
                'seats' => null,
                'entrance_exam' => 'Direct Admission / Merit Based',
                'academic_session' => '2025-26',
                'duration' => $c['duration'] ?? '2 Years',
                'sort_order' => $i,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (Schema::hasColumn('college_courses', 'course_name')) {
                $ccPayload['course_name'] = $courseName;
            }

            if (Schema::hasColumn('college_courses', 'specializations')) {
                $ccPayload['specializations'] = json_encode([
                    [
                        'name' => $c['spec'],
                        'fee_amount' => $c['fee'],
                        'fee_type' => $c['type'],
                        'eligibility' => $c['eligibility'],
                        'duration' => $c['duration'] ?? '2 Years',
                    ],
                ]);
            }

            $ccId = DB::table('college_courses')->insertGetId($ccPayload);

            if ($hasCcsTable && $specId) {
                DB::table('college_course_specializations')->insert([
                    'college_course_id' => $ccId,
                    'specialization_id' => $specId,
                    'fee_amount' => $c['fee'],
                    'fee_type' => $c['type'],
                    'eligibility' => $c['eligibility'],
                    'seats' => null,
                    'entrance_exam' => 'Direct Admission / Merit Based',
                    'sort_order' => $i,
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            if ($hasCcfTable) {
                DB::table('college_course_fees')->insert([
                    'college_course_id' => $ccId,
                    'fee_type' => $c['type'],
                    'label' => 'Annual Tuition Fee',
                    'amount' => $c['fee'],
                    'academic_session' => '2025-26',
                    'description' => 'Includes Online Examination & LMS Access',
                    'sort_order' => 0,
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    private function insertHighlights(int $collegeId, array $items): void
    {
        $now = now();
        if (! Schema::hasTable('college_highlights')) {
            return;
        }
        foreach ($items as $i => $h) {
            DB::table('college_highlights')->insert([
                'college_id' => $collegeId,
                'title' => $h['title'],
                'value' => $h['value'] ?? null,
                'description' => $h['description'] ?? null,
                'icon' => $h['icon'] ?? 'bi-check-circle-fill',
                'sort_order' => $i,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function insertAccreditations(int $collegeId, array $items): void
    {
        $now = now();
        if (! Schema::hasTable('college_accreditations')) {
            return;
        }
        foreach ($items as $i => $a) {
            DB::table('college_accreditations')->insert([
                'college_id' => $collegeId,
                'authority' => $a['authority'],
                'accreditation' => $a['accreditation'],
                'grade' => $a['grade'] ?? null,
                'rank' => $a['rank'] ?? null,
                'year' => $a['year'] ?? null,
                'description' => null,
                'certificate_image' => null,
                'sort_order' => $i,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function insertAdmissionSections(int $collegeId, array $sections): void
    {
        $now = now();
        if (! Schema::hasTable('college_admission_sections')) {
            return;
        }
        foreach ($sections as $i => $s) {
            DB::table('college_admission_sections')->insert([
                'college_id' => $collegeId,
                'section_key' => $s['key'],
                'title' => $s['title'],
                'content' => $s['content'] ?? null,
                'items' => ! empty($s['items']) ? json_encode($s['items']) : null,
                'sort_order' => $i,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function insertScholarships(int $collegeId, array $items): void
    {
        $now = now();
        if (! Schema::hasTable('college_scholarships')) {
            return;
        }
        foreach ($items as $i => $s) {
            DB::table('college_scholarships')->insert([
                'college_id' => $collegeId,
                'name' => $s['name'],
                'eligibility' => $s['eligibility'] ?? null,
                'criteria' => $s['criteria'] ?? null,
                'amount' => $s['amount'] ?? null,
                'amount_label' => $s['label'] ?? null,
                'percentage' => $s['pct'] ?? null,
                'description' => $s['description'] ?? null,
                'sort_order' => $i,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function insertPlacementStats(int $collegeId, array $stats, array $recruiters): void
    {
        $now = now();
        if (Schema::hasTable('college_placement_stats')) {
            foreach ($stats as $i => $s) {
                DB::table('college_placement_stats')->insert([
                    'college_id' => $collegeId,
                    'label' => $s['label'],
                    'value' => $s['value'],
                    'placement_percentage' => null,
                    'year' => $s['year'] ?? null,
                    'course' => $s['course'] ?? null,
                    'description' => null,
                    'sort_order' => $i,
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
        if (Schema::hasTable('college_recruiters')) {
            foreach ($recruiters as $i => $name) {
                DB::table('college_recruiters')->insert([
                    'college_id' => $collegeId,
                    'name' => $name,
                    'logo' => null,
                    'description' => null,
                    'sort_order' => $i,
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    private function insertCareerOutcomes(int $collegeId, array $items): void
    {
        $now = now();
        if (! Schema::hasTable('college_career_outcomes')) {
            return;
        }
        foreach ($items as $i => $c) {
            DB::table('college_career_outcomes')->insert([
                'college_id' => $collegeId,
                'career_role' => $c['role'],
                'industry' => $c['industry'],
                'average_salary' => $c['avg_salary'],
                'salary_range' => $c['range'] ?? null,
                'job_scope' => null,
                'description' => null,
                'sort_order' => $i,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function insertFacilities(int $collegeId, array $items): void
    {
        $now = now();
        if (! Schema::hasTable('college_facilities')) {
            return;
        }
        foreach ($items as $i => $f) {
            DB::table('college_facilities')->insert([
                'college_id' => $collegeId,
                'name' => $f['name'],
                'icon' => $f['icon'] ?? 'bi-laptop',
                'description' => null,
                'image' => null,
                'sort_order' => $i,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function insertFaqs(int $collegeId, array $items): void
    {
        $now = now();
        if (! Schema::hasTable('college_faqs')) {
            return;
        }
        foreach ($items as $i => $f) {
            DB::table('college_faqs')->insert([
                'college_id' => $collegeId,
                'question' => $f['q'],
                'answer' => $f['a'],
                'sort_order' => $i,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function insertQuickFacts(int $collegeId, array $def): void
    {
        $now = now();
        if (! Schema::hasTable('college_quick_facts')) {
            return;
        }

        $facts = [
            ['parameter' => 'Type of University',    'value' => $def['type'].' University',                     'icon' => 'building'],
            ['parameter' => 'Year of Establishment', 'value' => (string) $def['year'],                            'icon' => 'calendar'],
            ['parameter' => 'Approvals & Statutory', 'value' => $def['approvals'],                                 'icon' => 'shield-check'],
            ['parameter' => 'NAAC Grade',            'value' => 'Grade '.($def['naac_grade'] ?? 'A'),           'icon' => 'patch-check-fill'],
            ['parameter' => 'Mode of Education',     'value' => '100% Online (LMS + Live & Recorded Lectures)',  'icon' => 'laptop'],
            ['parameter' => 'Examination Mode',      'value' => 'Online Proctored Semester Examinations',         'icon' => 'display'],
            ['parameter' => 'Highest Package',       'value' => $def['highest'],                                  'icon' => 'briefcase'],
            ['parameter' => 'Average Package',       'value' => $def['average'],                                  'icon' => 'cash-coin'],
            ['parameter' => 'No-Cost EMI',           'value' => 'Available (Starting ₹3,500 - ₹4,500/Month)',     'icon' => 'credit-card-2-front'],
            ['parameter' => 'Campus / Location',     'value' => $def['city'].', '.$def['state'],              'icon' => 'geo-alt'],
        ];

        foreach ($facts as $idx => $fact) {
            DB::table('college_quick_facts')->insert([
                'college_id' => $collegeId,
                'parameter' => $fact['parameter'],
                'value' => $fact['value'],
                'icon' => $fact['icon'],
                'sort_order' => $idx + 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function basePayload(array $d, int $stateId, int $cityId): array
    {
        $fees = array_column($d['courses'], 'fee');
        $minFee = ! empty($fees) ? min($fees) : 25000;
        $maxFee = ! empty($fees) ? max($fees) : 85000;

        $payload = [
            'name' => $d['name'],
            'short_name' => $d['short_name'],
            'slug' => $d['slug'],
            'logo' => null, // Image manual upload by user
            'banner_image' => null, // Image manual upload by user
            'college_mode' => 'online',
            'college_type' => $d['type'],
            'university_name' => $d['university'],
            'website' => $d['website'],
            'state' => $d['state'],
            'state_id' => $stateId ?: null,
            'city' => $d['city'],
            'city_id' => $cityId ?: null,
            'address' => $d['address'],
            'established_year' => $d['year'],
            'campus_size' => $d['campus'],
            'approvals' => $d['approvals'],
            'naac_grade' => $d['naac_grade'],
            'ugc_approved' => $d['ugc_approved'],
            'nirf_rank' => $d['nirf_rank'] ?? null,
            'nirf_year' => $d['nirf_year'] ?? null,
            'entrance_exams' => $d['entrance_exams'] ?? 'Direct Admission / Merit Based',
            'rating' => $d['rating'],
            'reviews_count' => $d['reviews_count'],
            'highest_package' => $d['highest'],
            'average_package' => $d['average'],
            'top_recruiters' => $d['top_recruiters'],
            'has_boys_hostel' => false,
            'has_girls_hostel' => false,
            'overview' => $d['overview'],
            'admission_process' => null,
            'scholarship_info' => $d['scholarship_info'],
            'sample_certificate_image' => null,
            'brochure_pdf' => null,
            'is_featured' => $d['is_featured'] ?? false,
            'status' => true,
            'seo_title' => $d['name'].' — Online Degree Admission, Fees, Courses & Placements | GrowPec',
            'seo_description' => 'Explore '.$d['name'].' online degree courses, fee structure, UGC-DEB approvals, admission process, scholarships, and placements on GrowPec.',
        ];

        if (Schema::hasColumn('colleges', 'exam_mode')) {
            $payload['exam_mode'] = 'Online Proctored Semester Examinations';
        }
        if (Schema::hasColumn('colleges', 'learning_mode')) {
            $payload['learning_mode'] = '100% Online + Live Interactive Classes + LMS Portal';
        }
        if (Schema::hasColumn('colleges', 'emi_available')) {
            $payload['emi_available'] = true;
        }
        if (Schema::hasColumn('colleges', 'emi_starts_at')) {
            $payload['emi_starts_at'] = 3999.00;
        }
        if (Schema::hasColumn('colleges', 'min_fees')) {
            $payload['min_fees'] = $minFee;
        }
        if (Schema::hasColumn('colleges', 'max_fees')) {
            $payload['max_fees'] = $maxFee;
        }
        if (Schema::hasColumn('colleges', 'facilities')) {
            $payload['facilities'] = json_encode(array_column($d['facilities'], 'name'));
        }
        if (Schema::hasColumn('colleges', 'highlights')) {
            $payload['highlights'] = json_encode($d['highlights']);
        }
        if (Schema::hasColumn('colleges', 'faqs')) {
            $payload['faqs'] = json_encode($d['faqs']);
        }

        return $payload;
    }
}
