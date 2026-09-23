<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CollegeSeeder extends Seeder
{
    /** @var array<string, int> */
    private array $courseIds = [];

    /** @var array<string, int> */
    private array $specializationIds = [];

    public function run(): void
    {
        DB::transaction(function () {
            $this->seedAcademicData();
            $this->seedColleges();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | 1. Streams · Courses · Specializations
    |--------------------------------------------------------------------------
    */
    private function seedAcademicData(): void
    {
        $now = now();

        $streams = [
            'management' => ['name' => 'Management',                  'icon' => 'bi-briefcase'],
            'engineering' => ['name' => 'Engineering & Technology',    'icon' => 'bi-gear'],
            'it' => ['name' => 'Computer Applications & IT',  'icon' => 'bi-laptop'],
            'science' => ['name' => 'Science',                     'icon' => 'bi-flask'],
            'commerce' => ['name' => 'Commerce & Finance',          'icon' => 'bi-currency-rupee'],
            'arts' => ['name' => 'Arts & Humanities',           'icon' => 'bi-book'],
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
            'bca' => ['stream' => 'it',          'name' => 'BCA',                'level' => 'UG',   'degree_type' => 'Degree',  'duration' => '3 Years'],
            'mca' => ['stream' => 'it',          'name' => 'MCA',                'level' => 'PG',   'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bsc-it' => ['stream' => 'it',          'name' => 'B.Sc. IT',           'level' => 'UG',   'degree_type' => 'Degree',  'duration' => '3 Years'],
            'mba' => ['stream' => 'management',  'name' => 'MBA',                'level' => 'PG',   'degree_type' => 'Degree',  'duration' => '2 Years'],
            'pgdm' => ['stream' => 'management',  'name' => 'PGDM',               'level' => 'PG',   'degree_type' => 'Diploma', 'duration' => '2 Years'],
            'bba' => ['stream' => 'management',  'name' => 'BBA',                'level' => 'UG',   'degree_type' => 'Degree',  'duration' => '3 Years'],
            'btech' => ['stream' => 'engineering', 'name' => 'B.Tech',             'level' => 'UG',   'degree_type' => 'Degree',  'duration' => '4 Years'],
            'mtech' => ['stream' => 'engineering', 'name' => 'M.Tech',             'level' => 'PG',   'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bcom' => ['stream' => 'commerce',    'name' => 'B.Com',              'level' => 'UG',   'degree_type' => 'Degree',  'duration' => '3 Years'],
            'mcom' => ['stream' => 'commerce',    'name' => 'M.Com',              'level' => 'PG',   'degree_type' => 'Degree',  'duration' => '2 Years'],
            'ba' => ['stream' => 'arts',        'name' => 'B.A.',               'level' => 'UG',   'degree_type' => 'Degree',  'duration' => '3 Years'],
            'ma' => ['stream' => 'arts',        'name' => 'M.A.',               'level' => 'PG',   'degree_type' => 'Degree',  'duration' => '2 Years'],
            'phd' => ['stream' => 'management',  'name' => 'Ph.D. (Management)', 'level' => 'PhD',  'degree_type' => 'Degree',  'duration' => '3-5 Years'],
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
            'bca' => ['Software Development', 'Cloud Computing', 'Data Science', 'Cyber Security', 'Mobile Application Development', 'Web Development'],
            'mca' => ['Artificial Intelligence', 'Machine Learning', 'Data Analytics', 'Software Engineering', 'Cloud & DevOps'],
            'mba' => ['Marketing', 'Finance', 'Human Resource Management', 'Business Analytics', 'Operations Management', 'International Business', 'Digital Marketing', 'Supply Chain Management', 'Entrepreneurship', 'Healthcare Management', 'Banking & Finance'],
            'pgdm' => ['Marketing Management', 'Financial Management', 'HR Management', 'Operations & Supply Chain', 'Business Analytics'],
            'bba' => ['Marketing', 'Finance', 'Human Resources', 'International Business', 'Entrepreneurship'],
            'btech' => ['Computer Science & Engineering', 'Electronics & Communication Engineering', 'Mechanical Engineering', 'Civil Engineering', 'Electrical Engineering', 'Artificial Intelligence & Machine Learning', 'Data Science', 'Information Technology', 'Cyber Security'],
            'mtech' => ['Computer Science & Engineering', 'VLSI Design', 'Structural Engineering', 'Power Systems'],
            'bcom' => ['Accounting & Finance', 'Banking & Insurance', 'Taxation', 'E-Commerce'],
            'ba' => ['English', 'Economics', 'Political Science', 'Sociology', 'Psychology', 'History'],
            'ma' => ['English Literature', 'Economics', 'Sociology', 'Psychology'],
        ];

        foreach ($specializations as $courseSlug => $names) {
            $courseId = $this->courseIds[$courseSlug];
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
    | 2. Colleges
    |--------------------------------------------------------------------------
    */
    private function seedColleges(): void
    {
        foreach ($this->collegeDefinitions() as $def) {
            $stateId = (int) DB::table('states')->where('name', $def['state'])->value('id');
            $cityId = (int) DB::table('cities')->where('state_id', $stateId)->where('name', $def['city'])->value('id');
            $collegeId = DB::table('colleges')->insertGetId(
                array_merge($this->basePayload($def, $stateId, $cityId), ['created_at' => now(), 'updated_at' => now()])
            );

            $this->insertCourses($collegeId, $def['courses']);
            $this->insertHighlights($collegeId, $def['highlights']);
            $this->insertAccreditations($collegeId, $def['accreditations']);
            $this->insertAdmissionSections($collegeId, $def['admission_sections']);
            $this->insertScholarships($collegeId, $def['scholarships']);
            $this->insertPlacementStats($collegeId, $def['placement_stats'], $def['recruiters']);
            $this->insertCareerOutcomes($collegeId, $def['career_outcomes']);
            $this->insertFacilities($collegeId, $def['facilities']);
            $this->insertFaqs($collegeId, $def['faqs']);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 3. College Definitions — 4 Regular + 2 Online
    |--------------------------------------------------------------------------
    */
    private function collegeDefinitions(): array
    {
        return [

            /* ── REGULAR 1 ── Amity University Lucknow ──────────────────── */
            [
                'name' => 'Amity University Lucknow', 'short_name' => 'Amity Lucknow',
                'slug' => 'amity-university-lucknow', 'mode' => 'regular', 'type' => 'Private',
                'university' => 'Amity University Uttar Pradesh', 'website' => 'https://www.amity.edu/lucknow',
                'state' => 'Uttar Pradesh', 'city' => 'Lucknow',
                'address' => 'Malhaur, Gomti Nagar Extension, Lucknow, UP - 226028',
                'year' => '2004', 'campus' => '24 Acres',
                'approvals' => 'UGC | AICTE | NAAC A+', 'naac_grade' => 'A+',
                'ugc_approved' => true, 'nirf_rank' => '62', 'nirf_year' => '2024',
                'entrance_exams' => 'CAT, MAT, CUET, University Entrance Test',
                'rating' => 4.8, 'reviews_count' => 420,
                'highest' => '24 LPA', 'average' => '6.5 LPA',
                'top_recruiters' => 'Amazon, TCS, Infosys, Wipro, Deloitte, Capgemini',
                'overview' => 'Amity University Lucknow is a leading private university offering industry-aligned UG and PG programmes in management, engineering, technology and commerce. Established in 2004 on a 24-acre campus in Gomti Nagar Extension, the university is NAAC A+ accredited, features state-of-the-art labs, digital library, sports facilities and a dedicated career development centre.',
                'scholarship_info' => 'Merit scholarships up to 30% fee waiver, sports scholarships, and education loan tie-ups with SBI, HDFC Credila.',
                'is_featured' => true, 'hostel_boys' => true, 'hostel_girls' => true,

                'courses' => [
                    ['slug' => 'btech', 'spec' => 'Computer Science & Engineering',             'fee' => 190000, 'type' => 'per_year', 'eligibility' => '10+2 PCM min. 60%',   'seats' => 120, 'session' => '2025-26', 'entrance' => 'JEE Main / University Entrance'],
                    ['slug' => 'btech', 'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 195000, 'type' => 'per_year', 'eligibility' => '10+2 PCM min. 60%',   'seats' => 60,  'session' => '2025-26', 'entrance' => 'JEE Main / University Entrance'],
                    ['slug' => 'mba',   'spec' => 'Business Analytics',                         'fee' => 240000, 'type' => 'per_year', 'eligibility' => 'Graduation min. 50%', 'seats' => 60,  'session' => '2025-26', 'entrance' => 'CAT / MAT / University Test'],
                    ['slug' => 'mba',   'spec' => 'Marketing',                                  'fee' => 240000, 'type' => 'per_year', 'eligibility' => 'Graduation min. 50%', 'seats' => 60,  'session' => '2025-26', 'entrance' => 'CAT / MAT / University Test'],
                    ['slug' => 'bca',   'spec' => 'Software Development',                       'fee' => 110000, 'type' => 'per_year', 'eligibility' => '10+2 min. 50%',       'seats' => 60,  'session' => '2025-26', 'entrance' => 'CUET / University Entrance'],
                ],

                'highlights' => [
                    ['title' => 'NAAC A+ Accredited University',           'value' => 'Highest Grade',          'icon' => 'bi-patch-check-fill'],
                    ['title' => '24 LPA Highest Package (2024)',           'value' => 'B.Tech CSE Batch',       'icon' => 'bi-briefcase-fill'],
                    ['title' => '200+ Recruiting Companies',               'value' => 'Annual Placement Drive', 'icon' => 'bi-building-fill'],
                    ['title' => 'State-of-the-Art Research Labs',          'value' => '30+ Specialized Labs',   'icon' => 'bi-flask-fill'],
                    ['title' => 'Fully Residential Campus',                'value' => 'Boys & Girls Hostel',    'icon' => 'bi-house-fill'],
                    ['title' => 'International Exchange Programmes',       'value' => '15+ Countries',          'icon' => 'bi-globe2'],
                    ['title' => 'Industry Connect & Live Projects',        'value' => 'Every Semester',         'icon' => 'bi-people-fill'],
                    ['title' => 'Career Development Centre',               'value' => 'Round-the-Year Support', 'icon' => 'bi-person-workspace'],
                ],

                'accreditations' => [
                    ['authority' => 'UGC',  'accreditation' => 'Recognized — Section 2(f) & 12(B)',             'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'AICTE', 'accreditation' => 'Approved — Technical & Management Programmes',  'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council', 'grade' => 'A+', 'rank' => null, 'year' => '2022'],
                    ['authority' => 'NIRF', 'accreditation' => 'National Institutional Ranking Framework',      'grade' => null, 'rank' => '62', 'year' => '2024'],
                ],

                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Criteria',
                        'content' => 'UG: 10+2 with min. 50–60%. PG: Graduation with min. 50%.',
                        'items' => ['10+2 from recognized board (UG)', 'Graduation in relevant discipline (PG)', 'Valid entrance score (CAT/MAT/JEE/CUET)', 'No age bar for most programmes']],
                    ['key' => 'how_to_apply', 'title' => 'How to Apply',
                        'content' => 'Apply through GrowPec for free counselling and guided admission.',
                        'items' => ['Fill GrowPec enquiry form', 'Get counselling call from our expert', 'Submit application to university', 'Upload documents online', 'Pay admission fee and confirm seat']],
                    ['key' => 'documents', 'title' => 'Documents Required',
                        'content' => 'Keep originals and photocopies ready at the time of admission.',
                        'items' => ['10th marksheet & certificate', '12th marksheet & certificate', 'Graduation marksheets (for PG)', 'Transfer certificate', 'Character certificate', 'Passport-size photographs (6)', 'Aadhaar / valid photo ID', 'Caste certificate (if applicable)']],
                ],

                'scholarships' => [
                    ['name' => 'Amity Merit Scholarship',        'eligibility' => '90%+ in qualifying exam',     'criteria' => 'Academic Merit',     'amount' => null,    'label' => 'Up to 30% Fee Waiver',   'pct' => '30%'],
                    ['name' => 'Sports Excellence Scholarship',  'eligibility' => 'National/State sportsperson', 'criteria' => 'Sports Achievement', 'amount' => null,    'label' => 'Up to 20% Fee Waiver',   'pct' => '20%'],
                    ['name' => 'Defence Ward Scholarship',       'eligibility' => 'Ward of Defence Personnel',   'criteria' => 'Special Category',   'amount' => null,    'label' => 'As per govt. norms',     'pct' => null],
                    ['name' => 'SBI Education Loan Tie-Up',      'eligibility' => 'All enrolled students',       'criteria' => 'Loan Facility',      'amount' => 1500000, 'label' => 'Up to ₹15 Lakhs',      'pct' => null],
                ],

                'placement_stats' => [
                    ['label' => 'Highest Package',   'value' => '24 LPA',  'year' => '2024', 'course' => 'B.Tech CSE'],
                    ['label' => 'Average Package',   'value' => '6.5 LPA', 'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Companies Visited', 'value' => '200+',    'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Placement Rate',    'value' => '85%',     'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Median Package',    'value' => '5.2 LPA', 'year' => '2024', 'course' => 'MBA'],
                ],

                'recruiters' => ['Amazon', 'TCS', 'Infosys', 'Wipro', 'Deloitte', 'Capgemini', 'Cognizant', 'Accenture', 'IBM', 'Tech Mahindra'],

                'career_outcomes' => [
                    ['role' => 'Software Engineer',  'industry' => 'IT / Technology',       'avg_salary' => '5–10 LPA',  'range' => '4–20 LPA'],
                    ['role' => 'Business Analyst',   'industry' => 'Consulting / Business', 'avg_salary' => '6–12 LPA',  'range' => '5–18 LPA'],
                    ['role' => 'Data Scientist',     'industry' => 'Analytics / AI',        'avg_salary' => '7–14 LPA',  'range' => '5–22 LPA'],
                    ['role' => 'Marketing Manager',  'industry' => 'FMCG / E-commerce',     'avg_salary' => '5–9 LPA',   'range' => '4–15 LPA'],
                    ['role' => 'Finance Analyst',    'industry' => 'Banking / BFSI',        'avg_salary' => '5–10 LPA',  'range' => '4–14 LPA'],
                ],

                'facilities' => [
                    ['name' => 'High-Speed Campus Wi-Fi',       'icon' => 'bi-wifi'],
                    ['name' => 'Digital Library & e-Resources', 'icon' => 'bi-book'],
                    ['name' => 'Boys Hostel',                   'icon' => 'bi-house'],
                    ['name' => 'Girls Hostel',                  'icon' => 'bi-house-heart'],
                    ['name' => 'Modern Cafeteria',              'icon' => 'bi-cup-hot'],
                    ['name' => 'Sports & Fitness Centre',       'icon' => 'bi-trophy'],
                    ['name' => 'Medical Centre',                'icon' => 'bi-hospital'],
                    ['name' => 'Innovation & Research Labs',    'icon' => 'bi-flask'],
                    ['name' => 'Career Development Centre',     'icon' => 'bi-person-workspace'],
                    ['name' => 'Auditorium',                    'icon' => 'bi-mic'],
                ],

                'faqs' => [
                    ['q' => 'Is Amity University Lucknow UGC approved?',              'a' => 'Yes, Amity University Lucknow is UGC recognized under Section 2(f) and 12(B), and NAAC A+ accredited.'],
                    ['q' => 'What is the B.Tech fee at Amity Lucknow?',              'a' => 'B.Tech fees are approximately ₹1,90,000 per year. Merit scholarships of up to 30% are available.'],
                    ['q' => 'Are hostel facilities available?',                       'a' => 'Yes, separate fully-furnished hostels for boys and girls are available on campus.'],
                    ['q' => 'What entrance exams are accepted for MBA?',             'a' => 'CAT, MAT, CMAT, ATMA and the University\'s own entrance test are accepted for MBA admission.'],
                    ['q' => 'How can I apply to Amity University Lucknow?',          'a' => 'Fill the GrowPec enquiry form. Our counsellors will guide you through the complete admission process at no extra cost.'],
                    ['q' => 'What is the placement record of Amity Lucknow?',        'a' => 'Amity Lucknow achieved 85% placement in 2024 with 200+ companies. Highest package was 24 LPA.'],
                ],
            ],

            /* ── REGULAR 2 ── Manipal University Jaipur ─────────────────── */
            [
                'name' => 'Manipal University Jaipur', 'short_name' => 'MUJ',
                'slug' => 'manipal-university-jaipur', 'mode' => 'regular', 'type' => 'Private',
                'university' => 'Manipal University Jaipur', 'website' => 'https://jaipur.manipal.edu',
                'state' => 'Rajasthan', 'city' => 'Jaipur',
                'address' => 'Dehmi Kalan, Near GVK Toll Plaza, Jaipur-Ajmer Expressway, Jaipur - 303007',
                'year' => '2011', 'campus' => '122 Acres',
                'approvals' => 'UGC | AICTE | NAAC A+', 'naac_grade' => 'A+',
                'ugc_approved' => true, 'nirf_rank' => '51', 'nirf_year' => '2024',
                'entrance_exams' => 'JEE Main, MU OET, CUET',
                'rating' => 4.7, 'reviews_count' => 385,
                'highest' => '30 LPA', 'average' => '7.2 LPA',
                'top_recruiters' => 'Microsoft, Capgemini, Deloitte, Cognizant, Adobe, Oracle',
                'overview' => 'Manipal University Jaipur (MUJ) is a world-class private university spread over 122 acres near Jaipur, Rajasthan. Established in 2011 under the Manipal Education Group, MUJ offers 200+ programmes across 19 schools. NAAC A+ accredited, the university features industry-integrated curricula, Centres of Excellence in AI, IoT and Robotics, and consistently delivers top placement packages.',
                'scholarship_info' => 'MUJ Entrance Scholarship up to 100% fee waiver in first year based on MU OET score. Academic excellence scholarships in subsequent years. Sports and differently-abled student concessions also available.',
                'is_featured' => true, 'hostel_boys' => true, 'hostel_girls' => true,

                'courses' => [
                    ['slug' => 'btech', 'spec' => 'Computer Science & Engineering',             'fee' => 210000, 'type' => 'per_year', 'eligibility' => '10+2 PCM min. 60%',       'seats' => 180, 'session' => '2025-26', 'entrance' => 'JEE Main / MU OET'],
                    ['slug' => 'btech', 'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 215000, 'type' => 'per_year', 'eligibility' => '10+2 PCM min. 60%',       'seats' => 90,  'session' => '2025-26', 'entrance' => 'JEE Main / MU OET'],
                    ['slug' => 'btech', 'spec' => 'Data Science',                               'fee' => 215000, 'type' => 'per_year', 'eligibility' => '10+2 PCM min. 60%',       'seats' => 90,  'session' => '2025-26', 'entrance' => 'JEE Main / MU OET'],
                    ['slug' => 'mba',   'spec' => 'Finance',                                    'fee' => 260000, 'type' => 'per_year', 'eligibility' => 'Graduation min. 50%',     'seats' => 60,  'session' => '2025-26', 'entrance' => 'CAT / MAT / MU OET'],
                    ['slug' => 'mba',   'spec' => 'Marketing',                                  'fee' => 260000, 'type' => 'per_year', 'eligibility' => 'Graduation min. 50%',     'seats' => 60,  'session' => '2025-26', 'entrance' => 'CAT / MAT / MU OET'],
                    ['slug' => 'mca',   'spec' => 'Artificial Intelligence',                    'fee' => 175000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. IT min. 50%', 'seats' => 60,  'session' => '2025-26', 'entrance' => 'CUET / University Entrance'],
                ],

                'highlights' => [
                    ['title' => 'NAAC A+ — NIRF Ranked #51 (2024)',           'value' => 'University Category',  'icon' => 'bi-award-fill'],
                    ['title' => '30 LPA Highest Package',                      'value' => '2024 Batch',           'icon' => 'bi-cash-coin'],
                    ['title' => '19 Schools on Single Campus',                 'value' => '200+ Programmes',      'icon' => 'bi-building-fill'],
                    ['title' => 'Centre of Excellence — AI, IoT & Robotics',   'value' => 'Industry Partnership', 'icon' => 'bi-cpu-fill'],
                    ['title' => '100% Placement Assistance',                   'value' => 'Round-the-Year CDC',   'icon' => 'bi-briefcase-fill'],
                    ['title' => 'International Exchange — Manipal Global Network', 'value' => '25+ Countries',    'icon' => 'bi-globe2'],
                    ['title' => 'NCAA-Standard Sports Infrastructure',         'value' => 'Multi-Sport Campus',   'icon' => 'bi-trophy-fill'],
                    ['title' => 'Residential Campus — Boys & Girls Hostels',   'value' => 'On-Campus Living',     'icon' => 'bi-house-fill'],
                ],

                'accreditations' => [
                    ['authority' => 'UGC',   'accreditation' => 'Recognized — Section 2(f) & 12(B)',            'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'AICTE', 'accreditation' => 'Approved — Technical & Management Programmes', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC',  'accreditation' => 'National Assessment & Accreditation Council',  'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                    ['authority' => 'NIRF',  'accreditation' => 'National Institutional Ranking Framework',     'grade' => null, 'rank' => '51', 'year' => '2024'],
                ],

                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Criteria',
                        'content' => 'B.Tech: 10+2 PCM with min. 60%. MBA: Any graduation with 50%. MCA: BCA/B.Sc. IT with 50%.',
                        'items' => ['10+2 with min. 60% for B.Tech', 'Graduation 50% for MBA/MCA', 'Valid JEE/CAT/MAT/MU OET score', 'No upper age limit']],
                    ['key' => 'how_to_apply', 'title' => 'Admission Steps',
                        'content' => 'Apply online through GrowPec for free counselling and guided admission.',
                        'items' => ['Submit GrowPec enquiry', 'Receive expert counselling call', 'Fill university application', 'Appear for MU OET (if required)', 'Upload documents & pay fees']],
                    ['key' => 'documents', 'title' => 'Documents Required',
                        'content' => '',
                        'items' => ['10th & 12th marksheets', 'Graduation marksheets (PG)', 'Transfer & Migration certificate', 'Passport photos (6)', 'Aadhaar / ID Proof', 'Entrance score card', 'Caste certificate (if applicable)']],
                ],

                'scholarships' => [
                    ['name' => 'MU OET Entrance Scholarship',     'eligibility' => 'Top MU OET scorers',      'criteria' => 'Entrance Merit', 'amount' => null,    'label' => 'Up to 100% 1st Year Fee', 'pct' => '100%'],
                    ['name' => 'Academic Excellence Scholarship', 'eligibility' => 'CGPA ≥ 9.0 each year',   'criteria' => 'Annual Merit',   'amount' => null,    'label' => '25% subsequent year',     'pct' => '25%'],
                    ['name' => 'Sports Scholarship',              'eligibility' => 'National sports achiever', 'criteria' => 'Sports',         'amount' => null,    'label' => 'Up to 50% waiver',        'pct' => '50%'],
                    ['name' => 'HDFC Credila Education Loan',     'eligibility' => 'All admitted students',   'criteria' => 'Loan Tie-up',    'amount' => 2000000, 'label' => 'Up to ₹20 Lakhs',        'pct' => null],
                ],

                'placement_stats' => [
                    ['label' => 'Highest Package',   'value' => '30 LPA',  'year' => '2024', 'course' => 'B.Tech CSE'],
                    ['label' => 'Average Package',   'value' => '7.2 LPA', 'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Median Package',    'value' => '5.8 LPA', 'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Companies Visited', 'value' => '300+',    'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Placement Rate',    'value' => '90%',     'year' => '2024', 'course' => 'Overall'],
                ],

                'recruiters' => ['Microsoft', 'Capgemini', 'Deloitte', 'Cognizant', 'Adobe', 'Oracle', 'TCS', 'Infosys', 'Wipro', 'Samsung', 'Bosch', 'L&T'],

                'career_outcomes' => [
                    ['role' => 'Software Developer', 'industry' => 'IT / Software',      'avg_salary' => '6–12 LPA',  'range' => '4–24 LPA'],
                    ['role' => 'Data Analyst',       'industry' => 'Analytics / BFSI',   'avg_salary' => '6–13 LPA',  'range' => '5–20 LPA'],
                    ['role' => 'Product Manager',    'industry' => 'Tech / E-Commerce',  'avg_salary' => '10–18 LPA', 'range' => '8–28 LPA'],
                    ['role' => 'Investment Banker',  'industry' => 'Banking & Finance',  'avg_salary' => '8–15 LPA',  'range' => '6–25 LPA'],
                    ['role' => 'AI/ML Engineer',     'industry' => 'AI / Deep Tech',     'avg_salary' => '8–16 LPA',  'range' => '6–26 LPA'],
                ],

                'facilities' => [
                    ['name' => 'Campus-Wide Wi-Fi',               'icon' => 'bi-wifi'],
                    ['name' => 'Central Library (2 Lakh+ Books)', 'icon' => 'bi-book'],
                    ['name' => 'Boys Hostel (8 Blocks)',          'icon' => 'bi-house'],
                    ['name' => 'Girls Hostel (4 Blocks)',         'icon' => 'bi-house-heart'],
                    ['name' => 'Olympic-Size Swimming Pool',      'icon' => 'bi-water'],
                    ['name' => 'Multi-Cuisine Food Court',        'icon' => 'bi-cup-hot'],
                    ['name' => 'Health & Medical Centre',         'icon' => 'bi-hospital'],
                    ['name' => 'Innovation & Incubation Centre',  'icon' => 'bi-lightbulb'],
                    ['name' => 'Cricket Ground & Football Field', 'icon' => 'bi-dribbble'],
                    ['name' => 'Gymnasium & Fitness Centre',      'icon' => 'bi-activity'],
                ],

                'faqs' => [
                    ['q' => 'What is NAAC grade of MUJ?',              'a' => 'MUJ is NAAC A+ accredited and ranked #51 in NIRF University Rankings 2024.'],
                    ['q' => 'What is the B.Tech fee at MUJ?',          'a' => 'B.Tech fees are approximately ₹2,10,000 per year. Merit scholarships can reduce fees by up to 100% in the first year.'],
                    ['q' => 'Does MUJ provide hostel facilities?',     'a' => 'Yes, MUJ has 8 boys hostel blocks and 4 girls hostel blocks with all modern amenities.'],
                    ['q' => 'What entrance exams does MUJ accept?',    'a' => 'MUJ accepts JEE Main, MU OET, CUET for B.Tech; CAT, MAT, CMAT for MBA.'],
                    ['q' => 'How is placement at MUJ?',                'a' => 'MUJ has a 90% placement rate with 300+ companies. Highest package in 2024 was 30 LPA.'],
                ],
            ],

            /* ── REGULAR 3 ── Lovely Professional University ─────────────── */
            [
                'name' => 'Lovely Professional University', 'short_name' => 'LPU',
                'slug' => 'lovely-professional-university', 'mode' => 'regular', 'type' => 'Private',
                'university' => 'Lovely Professional University', 'website' => 'https://www.lpu.in',
                'state' => 'Punjab', 'city' => 'Phagwara',
                'address' => 'Lovely Professional University, Phagwara, Punjab - 144402',
                'year' => '2005', 'campus' => '600 Acres (India\'s Largest Single-Campus University)',
                'approvals' => 'UGC | AICTE | NAAC A++ | NIRF Top 50', 'naac_grade' => 'A++',
                'ugc_approved' => true, 'nirf_rank' => '37', 'nirf_year' => '2024',
                'entrance_exams' => 'LPUNEST, JEE Main, CAT, MAT, CUET',
                'rating' => 4.6, 'reviews_count' => 920,
                'highest' => '52 LPA', 'average' => '6.8 LPA',
                'top_recruiters' => 'Google, Microsoft, Amazon, TCS, Wipro, Infosys',
                'overview' => 'Lovely Professional University (LPU) is India\'s largest single-campus private university, spread over 600 acres in Phagwara, Punjab. Established in 2005, LPU is NAAC A++ accredited and ranked #37 in NIRF 2024. With 30,000+ students from 50+ countries, 400+ programmes, and exceptional placement records including Google, Microsoft and Amazon offers, LPU offers an unparalleled residential university experience.',
                'scholarship_info' => 'LPUNEST Scholarship offers up to 100% tuition fee waiver to top performers. Athletic, cultural and academic merit scholarships also available.',
                'is_featured' => true, 'hostel_boys' => true, 'hostel_girls' => true,

                'courses' => [
                    ['slug' => 'btech', 'spec' => 'Computer Science & Engineering',             'fee' => 160000, 'type' => 'per_year', 'eligibility' => '10+2 PCM min. 60%',   'seats' => 480, 'session' => '2025-26', 'entrance' => 'JEE Main / LPUNEST'],
                    ['slug' => 'btech', 'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 165000, 'type' => 'per_year', 'eligibility' => '10+2 PCM min. 60%',   'seats' => 240, 'session' => '2025-26', 'entrance' => 'JEE Main / LPUNEST'],
                    ['slug' => 'bca',   'spec' => 'Cloud Computing',                            'fee' => 90000, 'type' => 'per_year', 'eligibility' => '10+2 any stream 50%', 'seats' => 120, 'session' => '2025-26', 'entrance' => 'CUET / LPUNEST'],
                    ['slug' => 'bca',   'spec' => 'Data Science',                               'fee' => 90000, 'type' => 'per_year', 'eligibility' => '10+2 any stream 50%', 'seats' => 120, 'session' => '2025-26', 'entrance' => 'CUET / LPUNEST'],
                    ['slug' => 'mba',   'spec' => 'Marketing',                                  'fee' => 175000, 'type' => 'per_year', 'eligibility' => 'Graduation min. 50%', 'seats' => 120, 'session' => '2025-26', 'entrance' => 'CAT / MAT / LPUNEST'],
                    ['slug' => 'mba',   'spec' => 'Human Resource Management',                  'fee' => 175000, 'type' => 'per_year', 'eligibility' => 'Graduation min. 50%', 'seats' => 60,  'session' => '2025-26', 'entrance' => 'CAT / MAT / LPUNEST'],
                ],

                'highlights' => [
                    ['title' => 'NAAC A++ — India\'s Highest Accreditation',  'value' => 'Select Indian Universities', 'icon' => 'bi-patch-check-fill'],
                    ['title' => '52 LPA Highest Package — Google PPO',        'value' => '2024 Batch',                 'icon' => 'bi-cash-coin'],
                    ['title' => '600 Acre Campus — Largest in India',         'value' => 'Fully Residential',          'icon' => 'bi-geo-fill'],
                    ['title' => 'Students from 50+ Countries',                'value' => 'True International Campus',  'icon' => 'bi-globe2'],
                    ['title' => '800+ Placement Companies Annually',          'value' => '30,000+ Offers',             'icon' => 'bi-briefcase-fill'],
                    ['title' => 'Olympic-Level Sports Infrastructure',        'value' => 'Cricket, Football & More',   'icon' => 'bi-trophy-fill'],
                    ['title' => 'QS World University Rankings Top 1000',      'value' => '2025',                       'icon' => 'bi-award-fill'],
                    ['title' => 'Industry-Integrated Curriculum',             'value' => 'Live Projects Every Sem.',   'icon' => 'bi-diagram-3-fill'],
                ],

                'accreditations' => [
                    ['authority' => 'UGC',   'accreditation' => 'Recognized — Section 2(f) & 12(B)',            'grade' => null,  'rank' => null,       'year' => '2026'],
                    ['authority' => 'AICTE', 'accreditation' => 'Approved — Technical & Management Programmes', 'grade' => null,  'rank' => null,       'year' => '2026'],
                    ['authority' => 'NAAC',  'accreditation' => 'National Assessment & Accreditation Council',  'grade' => 'A++', 'rank' => null,       'year' => '2022'],
                    ['authority' => 'NIRF',  'accreditation' => 'National Institutional Ranking Framework',     'grade' => null,  'rank' => '37',       'year' => '2024'],
                    ['authority' => 'QS',    'accreditation' => 'QS World University Rankings',                 'grade' => null,  'rank' => '801-1000', 'year' => '2025'],
                ],

                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility',
                        'content' => 'B.Tech: 10+2 PCM 60%. MBA: Any graduation 50%. BCA: 10+2 any stream 50%.',
                        'items' => ['10+2 with PCM for B.Tech', 'Any graduation for MBA', '10+2 any stream for BCA', 'LPUNEST / JEE / CAT score preferred']],
                    ['key' => 'how_to_apply', 'title' => 'How to Apply',
                        'content' => 'Applications via LPUNEST portal or through GrowPec counselling.',
                        'items' => ['Fill GrowPec enquiry', 'Register for LPUNEST (free)', 'Submit marks/score', 'Receive admission letter', 'Pay fees & confirm enrollment']],
                    ['key' => 'documents', 'title' => 'Documents Required', 'content' => '',
                        'items' => ['10th & 12th marksheets', 'Graduation docs (PG)', 'Transfer / Migration cert.', 'Aadhaar / ID proof', '6 passport photos', 'Caste cert. (if applicable)']],
                ],

                'scholarships' => [
                    ['name' => 'LPUNEST Scholarship',          'eligibility' => 'Top LPUNEST scorers',  'criteria' => 'Entrance Score', 'amount' => null,    'label' => 'Up to 100% tuition waiver', 'pct' => '100%'],
                    ['name' => 'Sports Scholarship',           'eligibility' => 'National sportsperson', 'criteria' => 'Sports',         'amount' => null,    'label' => 'Up to 100% waiver',         'pct' => '100%'],
                    ['name' => 'Academic Merit Scholarship',   'eligibility' => 'CGPA ≥ 8.5 annually', 'criteria' => 'Annual CGPA',    'amount' => null,    'label' => '30% annual fee waiver',     'pct' => '30%'],
                    ['name' => 'SBI / Axis Education Loan',   'eligibility' => 'All admitted',         'criteria' => 'Loan Tie-up',    'amount' => 2000000, 'label' => 'Up to ₹20 Lakhs',          'pct' => null],
                ],

                'placement_stats' => [
                    ['label' => 'Highest Package',   'value' => '52 LPA',  'year' => '2024', 'course' => 'B.Tech CSE (Google PPO)'],
                    ['label' => 'Average Package',   'value' => '6.8 LPA', 'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Companies Visited', 'value' => '800+',    'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Total Offers',      'value' => '30,000+', 'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Placement Rate',    'value' => '87%',     'year' => '2024', 'course' => 'Overall'],
                ],

                'recruiters' => ['Google', 'Microsoft', 'Amazon', 'TCS', 'Wipro', 'Infosys', 'Cognizant', 'Accenture', 'HCL', 'IBM', 'Adobe', 'Deloitte'],

                'career_outcomes' => [
                    ['role' => 'Software Engineer',  'industry' => 'IT / Product',      'avg_salary' => '6–14 LPA', 'range' => '4–52 LPA'],
                    ['role' => 'Data Scientist',     'industry' => 'Analytics / AI',    'avg_salary' => '8–16 LPA', 'range' => '6–28 LPA'],
                    ['role' => 'Cloud Architect',    'industry' => 'Cloud / DevOps',    'avg_salary' => '9–18 LPA', 'range' => '7–30 LPA'],
                    ['role' => 'HR Manager',         'industry' => 'Corporate / HR',    'avg_salary' => '5–10 LPA', 'range' => '4–16 LPA'],
                    ['role' => 'Marketing Analyst',  'industry' => 'FMCG / E-Commerce', 'avg_salary' => '5–9 LPA',  'range' => '4–14 LPA'],
                ],

                'facilities' => [
                    ['name' => 'Campus Wi-Fi (600 Acres)',         'icon' => 'bi-wifi'],
                    ['name' => 'Central Library (3 Lakh+ Books)', 'icon' => 'bi-book'],
                    ['name' => 'Boys Hostel (40+ Blocks)',         'icon' => 'bi-house'],
                    ['name' => 'Girls Hostel (20+ Blocks)',        'icon' => 'bi-house-heart'],
                    ['name' => 'Olympic Sports Complex',           'icon' => 'bi-trophy'],
                    ['name' => '15+ Cafeterias & Food Courts',     'icon' => 'bi-cup-hot'],
                    ['name' => 'Super Speciality Hospital',        'icon' => 'bi-hospital'],
                    ['name' => 'LPU Incubation Centre',            'icon' => 'bi-lightbulb'],
                    ['name' => 'International Students Centre',    'icon' => 'bi-globe2'],
                    ['name' => 'Multiplex Cinema & Auditorium',    'icon' => 'bi-film'],
                ],

                'faqs' => [
                    ['q' => 'What is NAAC grade of LPU?',            'a' => 'LPU is NAAC A++ accredited — the highest grade in India — and ranked #37 in NIRF University Rankings 2024.'],
                    ['q' => 'What is the highest placement at LPU?', 'a' => 'The highest package at LPU in 2024 was 52 LPA (Google PPO from B.Tech CSE). Over 30,000 placement offers were extended.'],
                    ['q' => 'How big is LPU campus?',                'a' => 'LPU\'s campus is 600 acres — the largest single-campus university in India with 40+ boys hostel and 20+ girls hostel blocks.'],
                    ['q' => 'Does LPU accept JEE scores?',           'a' => 'Yes, LPU accepts JEE Main for B.Tech admissions. LPUNEST (free entrance test) is also accepted.'],
                    ['q' => 'Are scholarships available at LPU?',    'a' => 'Yes, LPUNEST toppers can get up to 100% tuition fee waiver. Sports and academic merit scholarships are also offered.'],
                ],
            ],

            /* ── REGULAR 4 ── Chandigarh University ─────────────────────── */
            [
                'name' => 'Chandigarh University', 'short_name' => 'CU',
                'slug' => 'chandigarh-university', 'mode' => 'regular', 'type' => 'Private',
                'university' => 'Chandigarh University', 'website' => 'https://www.cuchd.in',
                'state' => 'Punjab', 'city' => 'Mohali',
                'address' => 'NH-95, Chandigarh-Ludhiana Highway, Mohali, Punjab - 140413',
                'year' => '2012', 'campus' => '200 Acres',
                'approvals' => 'UGC | AICTE | NAAC A+ | QS Top 1000', 'naac_grade' => 'A+',
                'ugc_approved' => true, 'nirf_rank' => '28', 'nirf_year' => '2024',
                'entrance_exams' => 'CUCET, JEE Main, CAT, MAT, CUET',
                'rating' => 4.7, 'reviews_count' => 756,
                'highest' => '36 LPA', 'average' => '7.5 LPA',
                'top_recruiters' => 'Amazon, IBM, Cognizant, Capgemini, Infosys, TCS, HCL',
                'overview' => 'Chandigarh University (CU) is a NAAC A+ accredited private university located on NH-95 near Mohali, Punjab. Ranked #28 in NIRF 2024, CU is known for industry-integrated programmes, cutting-edge research and one of the best placement ecosystems in North India. The 200-acre campus houses 30,000+ students with 50+ research centres.',
                'scholarship_info' => 'CUCET-based scholarships up to 100% fee waiver. Academic performance scholarships, EWS scholarships, and sports merit concessions available.',
                'is_featured' => true, 'hostel_boys' => true, 'hostel_girls' => true,

                'courses' => [
                    ['slug' => 'btech', 'spec' => 'Computer Science & Engineering',             'fee' => 175000, 'type' => 'per_year', 'eligibility' => '10+2 PCM min. 60%',   'seats' => 300, 'session' => '2025-26', 'entrance' => 'JEE Main / CUCET'],
                    ['slug' => 'btech', 'spec' => 'Artificial Intelligence & Machine Learning', 'fee' => 180000, 'type' => 'per_year', 'eligibility' => '10+2 PCM min. 60%',   'seats' => 120, 'session' => '2025-26', 'entrance' => 'JEE Main / CUCET'],
                    ['slug' => 'mba',   'spec' => 'Marketing',                                  'fee' => 145000, 'type' => 'per_year', 'eligibility' => 'Graduation min. 50%', 'seats' => 120, 'session' => '2025-26', 'entrance' => 'CAT / MAT / CUCET'],
                    ['slug' => 'mba',   'spec' => 'Business Analytics',                         'fee' => 145000, 'type' => 'per_year', 'eligibility' => 'Graduation min. 50%', 'seats' => 60,  'session' => '2025-26', 'entrance' => 'CAT / MAT / CUCET'],
                    ['slug' => 'bca',   'spec' => 'Data Science',                               'fee' => 85000, 'type' => 'per_year', 'eligibility' => '10+2 any stream 50%', 'seats' => 120, 'session' => '2025-26', 'entrance' => 'CUET / CUCET'],
                    ['slug' => 'mca',   'spec' => 'Cloud & DevOps',                             'fee' => 140000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. IT 50%',  'seats' => 60,  'session' => '2025-26', 'entrance' => 'CUET / CUCET'],
                ],

                'highlights' => [
                    ['title' => 'NIRF Rank #28 — Top Indian Universities 2024', 'value' => 'University Category',      'icon' => 'bi-award-fill'],
                    ['title' => '36 LPA Highest Package',                       'value' => '2024 Placement',           'icon' => 'bi-cash-coin'],
                    ['title' => '50+ Research Centres & Innovation Labs',       'value' => 'Industry Partnered',       'icon' => 'bi-flask-fill'],
                    ['title' => '700+ Placement Visiting Companies',            'value' => 'Annual Drives',            'icon' => 'bi-briefcase-fill'],
                    ['title' => 'QS World Rankings — Top 1000',                 'value' => '2025 Edition',             'icon' => 'bi-globe2'],
                    ['title' => 'Fully Residential 200-Acre Campus',            'value' => 'Boys & Girls Hostels',     'icon' => 'bi-house-fill'],
                    ['title' => 'International Exchange — 25 Countries',        'value' => 'Semester Abroad Options',  'icon' => 'bi-airplane'],
                    ['title' => 'UGC / AICTE / NAAC A+ Approved',              'value' => 'Valid for all Govt. Jobs', 'icon' => 'bi-patch-check-fill'],
                ],

                'accreditations' => [
                    ['authority' => 'UGC',   'accreditation' => 'Recognized University',                    'grade' => null, 'rank' => null,       'year' => '2026'],
                    ['authority' => 'AICTE', 'accreditation' => 'Technical & Management Programmes',        'grade' => null, 'rank' => null,       'year' => '2026'],
                    ['authority' => 'NAAC',  'accreditation' => 'National Assessment & Accreditation',      'grade' => 'A+', 'rank' => null,       'year' => '2023'],
                    ['authority' => 'NIRF',  'accreditation' => 'NIRF University Ranking',                  'grade' => null, 'rank' => '28',       'year' => '2024'],
                    ['authority' => 'QS',    'accreditation' => 'QS World University Rankings',             'grade' => null, 'rank' => '801-1000', 'year' => '2025'],
                ],

                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility',
                        'content' => 'B.Tech: 10+2 PCM 60%. MBA: Any graduation 50%. BCA/MCA: 10+2/graduation 50%.',
                        'items' => ['10+2 PCM for B.Tech', 'Graduation for MBA / MCA', 'CUCET / JEE / CAT score accepted', 'No age bar']],
                    ['key' => 'how_to_apply', 'title' => 'How to Apply',
                        'content' => 'Apply through GrowPec for free counselling and guided CU admission.',
                        'items' => ['Fill GrowPec form', 'Get counselling call', 'Register at CU portal', 'Appear for CUCET (optional)', 'Submit docs & pay fees']],
                    ['key' => 'documents', 'title' => 'Documents Required', 'content' => '',
                        'items' => ['10th & 12th marksheets', 'Graduation docs (for PG)', 'ID proof (Aadhaar / Passport)', 'Transfer / Migration cert.', '6 passport-size photos', 'Entrance score card', 'Caste cert. (if applicable)']],
                ],

                'scholarships' => [
                    ['name' => 'CUCET Performance Scholarship', 'eligibility' => 'Top CUCET scorers',   'criteria' => 'Entrance', 'amount' => null,    'label' => 'Up to 100% waiver', 'pct' => '100%'],
                    ['name' => 'Merit Scholarship',             'eligibility' => '90%+ in 12th / Grad', 'criteria' => 'Merit',    'amount' => null,    'label' => 'Up to 50% waiver',  'pct' => '50%'],
                    ['name' => 'EWS / Special Category',        'eligibility' => 'As per govt. norms',  'criteria' => 'Category', 'amount' => null,    'label' => 'As applicable',     'pct' => null],
                    ['name' => 'PNB / SBI Education Loan',      'eligibility' => 'All admitted',         'criteria' => 'Loan',     'amount' => 1500000, 'label' => 'Up to ₹15 Lakhs',  'pct' => null],
                ],

                'placement_stats' => [
                    ['label' => 'Highest Package',          'value' => '36 LPA',  'year' => '2024', 'course' => 'B.Tech CSE'],
                    ['label' => 'Average Package',          'value' => '7.5 LPA', 'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Companies Visited',        'value' => '700+',    'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Placement Rate',           'value' => '90%',     'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'International Placements', 'value' => '500+',    'year' => '2024', 'course' => 'Overall'],
                ],

                'recruiters' => ['Amazon', 'IBM', 'Cognizant', 'Capgemini', 'Infosys', 'TCS', 'HCL', 'Accenture', 'Wipro', 'Tech Mahindra', 'Deloitte', 'Bosch'],

                'career_outcomes' => [
                    ['role' => 'Software Developer', 'industry' => 'IT / Technology',   'avg_salary' => '6–12 LPA', 'range' => '4–30 LPA'],
                    ['role' => 'Cloud Engineer',     'industry' => 'Cloud / DevOps',     'avg_salary' => '7–14 LPA', 'range' => '5–25 LPA'],
                    ['role' => 'Business Analyst',   'industry' => 'Consulting',         'avg_salary' => '6–11 LPA', 'range' => '5–18 LPA'],
                    ['role' => 'Digital Marketer',   'industry' => 'E-commerce / FMCG', 'avg_salary' => '5–9 LPA',  'range' => '4–15 LPA'],
                    ['role' => 'Data Analyst',       'industry' => 'Analytics / BFSI',  'avg_salary' => '6–12 LPA', 'range' => '5–20 LPA'],
                ],

                'facilities' => [
                    ['name' => 'Campus-Wide Wi-Fi',           'icon' => 'bi-wifi'],
                    ['name' => 'Central Library',             'icon' => 'bi-book'],
                    ['name' => 'Boys Hostel',                 'icon' => 'bi-house'],
                    ['name' => 'Girls Hostel',                'icon' => 'bi-house-heart'],
                    ['name' => 'Food Courts (Multi-Cuisine)', 'icon' => 'bi-cup-hot'],
                    ['name' => 'Sports Complex',              'icon' => 'bi-trophy'],
                    ['name' => 'Medical Centre',              'icon' => 'bi-hospital'],
                    ['name' => 'Research & Innovation Labs',  'icon' => 'bi-flask'],
                    ['name' => 'Auditorium & Cultural Centre', 'icon' => 'bi-mic'],
                    ['name' => 'Career Development Centre',   'icon' => 'bi-person-workspace'],
                ],

                'faqs' => [
                    ['q' => 'What is Chandigarh University NIRF Rank?',     'a' => 'CU is ranked #28 in NIRF University Rankings 2024 and is NAAC A+ accredited.'],
                    ['q' => 'What is the fee for B.Tech at CU?',            'a' => 'B.Tech CSE fees are approximately ₹1,75,000 per year. Scholarship of up to 100% available through CUCET.'],
                    ['q' => 'How many companies visit CU for placements?',  'a' => '700+ companies visited in 2024. Placement rate was 90% with highest package of 36 LPA.'],
                    ['q' => 'Is CU degree valid for government jobs?',      'a' => 'Yes, CU is UGC recognized and AICTE approved. All degrees are valid for government jobs and competitive exams.'],
                    ['q' => 'Does CU have hostel facilities?',              'a' => 'Yes, separate fully-furnished hostel blocks for boys and girls are available on the 200-acre campus.'],
                ],
            ],

            /* ── ONLINE 1 ── Amity University Online ────────────────────── */
            [
                'name' => 'Amity University Online', 'short_name' => 'Amity Online',
                'slug' => 'amity-university-online', 'mode' => 'online', 'type' => 'Private',
                'university' => 'Amity University', 'website' => 'https://www.amityonline.com',
                'state' => 'Uttar Pradesh', 'city' => 'Noida',
                'address' => 'Amity University, Sector 125, Noida, Uttar Pradesh - 201313',
                'year' => '2016', 'campus' => 'Online / Digital Campus',
                'approvals' => 'UGC-DEB | AICTE | NAAC A+', 'naac_grade' => 'A+',
                'ugc_approved' => true, 'nirf_rank' => null, 'nirf_year' => null,
                'entrance_exams' => 'No Entrance Test Required',
                'rating' => 4.7, 'reviews_count' => 650,
                'highest' => '20 LPA', 'average' => '5.8 LPA',
                'top_recruiters' => 'TCS, Infosys, Wipro, Deloitte, Cognizant, HCL',
                'overview' => 'Amity University Online is one of India\'s most trusted UGC-DEB approved online universities. Offering 100% online MBA, BBA, BCA, MCA, B.Com, M.Com and more, with NAAC A+ accreditation, live interactive sessions, recorded lectures, industry mentorship and dedicated career support. Degrees are fully equivalent to regular programmes and recognized for jobs, competitive exams and higher studies.',
                'scholarship_info' => 'Early bird scholarship up to 20% on first-semester fee. Merit scholarships based on qualifying exam. Special concessions for working professionals and government employees.',
                'is_featured' => true, 'hostel_boys' => false, 'hostel_girls' => false,

                'courses' => [
                    ['slug' => 'mba',  'spec' => 'Marketing',                 'fee' => 85000, 'type' => 'per_year', 'eligibility' => 'Any graduation',            'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'mba',  'spec' => 'Finance',                   'fee' => 85000, 'type' => 'per_year', 'eligibility' => 'Any graduation',            'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'mba',  'spec' => 'Human Resource Management', 'fee' => 85000, 'type' => 'per_year', 'eligibility' => 'Any graduation',            'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'mba',  'spec' => 'Business Analytics',        'fee' => 95000, 'type' => 'per_year', 'eligibility' => 'Any graduation',            'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'bca',  'spec' => 'Software Development',      'fee' => 55000, 'type' => 'per_year', 'eligibility' => '10+2 any stream 45%',       'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'bba',  'spec' => 'Marketing',                 'fee' => 50000, 'type' => 'per_year', 'eligibility' => '10+2 any stream 45%',       'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'mca',  'spec' => 'Artificial Intelligence',   'fee' => 75000, 'type' => 'per_year', 'eligibility' => 'BCA / B.Sc. IT / any grad', 'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',      'fee' => 45000, 'type' => 'per_year', 'eligibility' => '10+2 any stream 45%',       'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                ],

                'highlights' => [
                    ['title' => 'UGC-DEB Approved — 100% Online Degree',              'value' => 'Legally Equivalent to Regular', 'icon' => 'bi-patch-check-fill'],
                    ['title' => 'NAAC A+ Accredited Parent University',               'value' => 'Amity University',              'icon' => 'bi-award-fill'],
                    ['title' => 'Live + Recorded Interactive Sessions',               'value' => 'Flex Learning',                 'icon' => 'bi-camera-video-fill'],
                    ['title' => 'Industry Mentors & Guest Lectures',                  'value' => 'Every Semester',                'icon' => 'bi-person-video3'],
                    ['title' => 'Online Career Support — Resume & Mock Interviews',   'value' => 'Dedicated Online CDC',          'icon' => 'bi-briefcase-fill'],
                    ['title' => 'No-Cost EMI Available',                              'value' => '₹0 Cost EMI Options',          'icon' => 'bi-cash-coin'],
                    ['title' => 'Degree Valid for Govt. Jobs & Higher Studies',       'value' => 'UGC-DEB Recognized',           'icon' => 'bi-shield-check'],
                    ['title' => 'Learn Anywhere — Mobile & Laptop Friendly',         'value' => 'Advanced LMS Portal',          'icon' => 'bi-phone-fill'],
                ],

                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Distance Education Bureau — Online Programmes Approved', 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'UGC',     'accreditation' => 'University Grants Commission — Recognized',              'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'AICTE',   'accreditation' => 'Technical & Management Online Programmes Approved',      'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC',    'accreditation' => 'Parent University — Amity University',                   'grade' => 'A+', 'rank' => null, 'year' => '2022'],
                ],

                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility',
                        'content' => 'UG: 10+2 from any recognized board. PG: Graduation from any recognized university. No entrance test.',
                        'items' => ['10+2 (any stream) for UG programmes', 'Any graduation for PG/MBA/MCA', 'Min. 45% marks', 'No age bar', 'No entrance exam required']],
                    ['key' => 'how_to_apply', 'title' => 'How to Apply — 3 Easy Steps',
                        'content' => 'Admission to Amity Online is 100% online and paperless.',
                        'items' => ['Step 1: Fill GrowPec enquiry for free counselling', 'Step 2: Register on Amity Online portal & upload documents', 'Step 3: Pay fee via UPI / Net Banking / EMI — get LMS access in 48 hrs']],
                    ['key' => 'documents', 'title' => 'Documents Required (Soft Copies)', 'content' => '',
                        'items' => ['10th marksheet', '12th marksheet', 'Graduation marksheets (for PG)', 'Aadhaar card / Passport', '1 passport-size photo (digital)', 'Work experience docs (if applicable)']],
                ],

                'scholarships' => [
                    ['name' => 'Early Bird Discount',             'eligibility' => 'Apply within 2 weeks of window', 'criteria' => 'Early Enrollment',  'amount' => null, 'label' => '20% on 1st Semester', 'pct' => '20%'],
                    ['name' => 'Merit Scholarship',               'eligibility' => '70%+ in qualifying exam',        'criteria' => 'Academic Merit',     'amount' => null, 'label' => 'Up to 15% waiver',    'pct' => '15%'],
                    ['name' => 'Working Professional Concession', 'eligibility' => '2+ years work experience',       'criteria' => 'Professional',       'amount' => null, 'label' => 'Special pricing',     'pct' => null],
                    ['name' => 'No-Cost EMI Option',              'eligibility' => 'All admitted students',          'criteria' => 'Flexible Pay',       'amount' => null, 'label' => '0% EMI 3–12 months',  'pct' => null],
                ],

                'placement_stats' => [
                    ['label' => 'Highest Package',    'value' => '20 LPA',  'year' => '2024', 'course' => 'MBA'],
                    ['label' => 'Average Package',    'value' => '5.8 LPA', 'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Students Placed',    'value' => '78%',     'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Hiring Partners',    'value' => '100+',    'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Career Transitions', 'value' => '3,000+',  'year' => '2024', 'course' => 'Working Professionals'],
                ],

                'recruiters' => ['TCS', 'Infosys', 'Wipro', 'Deloitte', 'Cognizant', 'HCL', 'Capgemini', 'EY', 'Accenture', 'IBM'],

                'career_outcomes' => [
                    ['role' => 'Marketing Manager',       'industry' => 'FMCG / E-Commerce',  'avg_salary' => '5–9 LPA',  'range' => '3.5–16 LPA'],
                    ['role' => 'Finance Analyst',         'industry' => 'Banking / BFSI',      'avg_salary' => '5–10 LPA', 'range' => '3.5–18 LPA'],
                    ['role' => 'Software Developer',      'industry' => 'IT / Startups',       'avg_salary' => '5–10 LPA', 'range' => '3–18 LPA'],
                    ['role' => 'HR Business Partner',     'industry' => 'Corporate / IT',      'avg_salary' => '4–8 LPA',  'range' => '3–14 LPA'],
                    ['role' => 'E-Commerce Analyst',      'industry' => 'Retail / E-Commerce', 'avg_salary' => '4–7 LPA',  'range' => '3–12 LPA'],
                ],

                'facilities' => [
                    ['name' => 'Advanced LMS Portal',                'icon' => 'bi-laptop'],
                    ['name' => 'Live & Recorded Video Lectures',     'icon' => 'bi-camera-video'],
                    ['name' => 'Digital Library & E-Books',          'icon' => 'bi-book'],
                    ['name' => 'Discussion Forums & Peer Learning',  'icon' => 'bi-chat-dots'],
                    ['name' => 'Online Career Services & Placement', 'icon' => 'bi-briefcase'],
                    ['name' => 'Industry Webinars & Guest Lectures', 'icon' => 'bi-person-video'],
                    ['name' => '24/7 Academic Support',              'icon' => 'bi-headset'],
                    ['name' => 'Flexible EMI Payment Options',       'icon' => 'bi-cash-coin'],
                ],

                'faqs' => [
                    ['q' => 'Is Amity Online degree valid for government jobs?',  'a' => 'Yes, Amity University Online is UGC-DEB approved. Degrees are equivalent to regular degrees and valid for all government jobs, competitive exams and higher studies.'],
                    ['q' => 'Is there any entrance exam for Amity Online?',       'a' => 'No entrance exam is required. Admission is based on qualifying exam percentage.'],
                    ['q' => 'What is the fee for online MBA at Amity?',           'a' => 'Online MBA costs approximately ₹85,000 per year (₹1,70,000 total). No-cost EMI options are available.'],
                    ['q' => 'How are classes conducted?',                         'a' => 'Via a dedicated LMS portal with live sessions (also recorded for later viewing), assignments, and online exams.'],
                    ['q' => 'Does Amity Online provide placement assistance?',    'a' => 'Yes, there is a dedicated Online CDC with resume building, mock interviews and placement drives with 100+ hiring partners.'],
                ],
            ],

            /* ── ONLINE 2 ── NMIMS Global Access Online ──────────────────── */
            [
                'name' => 'NMIMS Global Access School for Continuing Education', 'short_name' => 'NMIMS Online',
                'slug' => 'nmims-global-access-online', 'mode' => 'online', 'type' => 'Deemed',
                'university' => 'SVKM\'s NMIMS (Deemed-to-be University)', 'website' => 'https://www.nmimsglobalaccess.com',
                'state' => 'Maharashtra', 'city' => 'Mumbai',
                'address' => 'V. L. Mehta Road, Vile Parle (W), Mumbai - 400056',
                'year' => '2014', 'campus' => 'Online / Distance Learning Campus',
                'approvals' => 'UGC-DEB | AICTE | NAAC A | WES Recognized', 'naac_grade' => 'A',
                'ugc_approved' => true, 'nirf_rank' => null, 'nirf_year' => null,
                'entrance_exams' => 'No Entrance Test — Direct Admission',
                'rating' => 4.6, 'reviews_count' => 580,
                'highest' => '22 LPA', 'average' => '6.2 LPA',
                'top_recruiters' => 'McKinsey, Goldman Sachs, Deloitte, EY, Amazon, HDFC Bank',
                'overview' => 'NMIMS Global Access School for Continuing Education (NGA-SCE) is the distance and online learning arm of SVKM\'s NMIMS — one of India\'s most prestigious deemed universities. UGC-DEB approved and NAAC A accredited, NGA-SCE offers online MBA, BBA, BCA, B.Com, PGDM and more. WES-recognized degrees are accepted internationally. With 60,000+ alumni at McKinsey, Goldman Sachs and leading corporates, NGA-SCE carries the NMIMS brand advantage.',
                'scholarship_info' => 'Early-application fee waivers, defence personnel discounts, and no-cost EMI up to 12 months. Tie-up with HDFC Credila for education loans.',
                'is_featured' => true, 'hostel_boys' => false, 'hostel_girls' => false,

                'courses' => [
                    ['slug' => 'mba',  'spec' => 'Marketing',              'fee' => 95000, 'type' => 'per_year', 'eligibility' => 'Any graduation min. 45%', 'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'mba',  'spec' => 'Finance',                'fee' => 95000, 'type' => 'per_year', 'eligibility' => 'Any graduation min. 45%', 'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'mba',  'spec' => 'Banking & Finance',      'fee' => 100000, 'type' => 'per_year', 'eligibility' => 'Any graduation min. 45%', 'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'mba',  'spec' => 'Operations Management',  'fee' => 95000, 'type' => 'per_year', 'eligibility' => 'Any graduation min. 45%', 'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'bba',  'spec' => 'Finance',                'fee' => 55000, 'type' => 'per_year', 'eligibility' => '10+2 any stream 45%',    'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'bca',  'spec' => 'Software Development',   'fee' => 50000, 'type' => 'per_year', 'eligibility' => '10+2 any stream 45%',    'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'bcom', 'spec' => 'Accounting & Finance',   'fee' => 45000, 'type' => 'per_year', 'eligibility' => '10+2 Commerce 45%',      'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                    ['slug' => 'pgdm', 'spec' => 'Marketing Management',   'fee' => 110000, 'type' => 'per_year', 'eligibility' => 'Any graduation min. 50%', 'seats' => null, 'session' => '2025-26', 'entrance' => 'No Entrance Test'],
                ],

                'highlights' => [
                    ['title' => 'NMIMS Brand — Top-10 MBA School India',          'value' => 'SVKM\'s NMIMS',                 'icon' => 'bi-award-fill'],
                    ['title' => 'WES Recognized — Degrees Valid Internationally', 'value' => 'USA, Canada, UK & More',         'icon' => 'bi-globe2'],
                    ['title' => 'UGC-DEB Approved Online Programmes',             'value' => 'Equivalent to Regular Degree',  'icon' => 'bi-patch-check-fill'],
                    ['title' => '60,000+ Strong Alumni Network',                  'value' => 'McKinsey, Goldman, EY, Amazon', 'icon' => 'bi-people-fill'],
                    ['title' => 'Live Sessions + 1-on-1 Industry Mentorship',     'value' => 'Weekly Live Classes',           'icon' => 'bi-camera-video-fill'],
                    ['title' => 'No Entrance Exam — Direct Admission',            'value' => 'Rolling Admissions',            'icon' => 'bi-door-open-fill'],
                    ['title' => 'Dedicated Online Placement Cell',                'value' => '100+ Hiring Partners',          'icon' => 'bi-briefcase-fill'],
                    ['title' => 'Flexible EMI — ₹0 Cost, 3–12 Months',          'value' => 'All Major Banks',               'icon' => 'bi-cash-coin'],
                ],

                'accreditations' => [
                    ['authority' => 'UGC-DEB', 'accreditation' => 'Online & Distance Programmes — Approved',          'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'UGC',     'accreditation' => 'Deemed University — Recognized',                   'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'AICTE',   'accreditation' => 'Management Programmes — Approved',                 'grade' => null, 'rank' => null, 'year' => '2026'],
                    ['authority' => 'NAAC',    'accreditation' => 'SVKM\'s NMIMS — National Accreditation',          'grade' => 'A',  'rank' => null, 'year' => '2023'],
                    ['authority' => 'WES',     'accreditation' => 'World Education Services — International Recognition', 'grade' => null, 'rank' => null, 'year' => '2026'],
                ],

                'admission_sections' => [
                    ['key' => 'eligibility', 'title' => 'Eligibility Criteria',
                        'content' => 'Simple eligibility — no entrance test required for any programme.',
                        'items' => ['10+2 any stream (min. 45%) for UG', 'Any graduation (min. 45%) for PG/MBA/PGDM', 'Working professionals with experience eligible', 'No entrance exam required', 'Relaxation for reserved categories']],
                    ['key' => 'how_to_apply', 'title' => 'Apply in 4 Easy Steps', 'content' => '',
                        'items' => ['Step 1: Fill GrowPec enquiry for free expert guidance', 'Step 2: Choose programme with our counsellor', 'Step 3: Register on NGA-SCE portal & upload soft copies', 'Step 4: Pay fee online / select EMI — admission confirmed in 48 hrs']],
                    ['key' => 'documents', 'title' => 'Documents (Soft Copy Only)', 'content' => '',
                        'items' => ['10th certificate & marksheet', '12th certificate & marksheet', 'Graduation certificates (for PG)', 'Aadhaar Card / Passport', 'Passport-size photo', 'Work experience certificate (if applicable)']],
                ],

                'scholarships' => [
                    ['name' => 'Early Enrollment Discount',   'eligibility' => 'First 2 weeks of window', 'criteria' => 'Early Apply',  'amount' => null,    'label' => '15% on 1st Semester',   'pct' => '15%'],
                    ['name' => 'Defence / Ex-Servicemen',     'eligibility' => 'Defence personnel ward',  'criteria' => 'Category',     'amount' => null,    'label' => 'Special pricing',       'pct' => null],
                    ['name' => 'No-Cost EMI',                 'eligibility' => 'All admitted students',   'criteria' => 'Flexible Pay', 'amount' => null,    'label' => '0% EMI 3–12 months',    'pct' => null],
                    ['name' => 'HDFC Credila Education Loan', 'eligibility' => 'Eligible applicants',     'criteria' => 'Loan Tie-up',  'amount' => 1500000, 'label' => 'Up to ₹15 Lakhs',      'pct' => null],
                ],

                'placement_stats' => [
                    ['label' => 'Highest Package', 'value' => '22 LPA',  'year' => '2024', 'course' => 'MBA'],
                    ['label' => 'Average Package', 'value' => '6.2 LPA', 'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Placement Rate',  'value' => '80%',     'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Hiring Partners', 'value' => '100+',    'year' => '2024', 'course' => 'Overall'],
                    ['label' => 'Alumni Network',  'value' => '60,000+', 'year' => '2024', 'course' => 'NMIMS Brand'],
                ],

                'recruiters' => ['McKinsey & Company', 'Goldman Sachs', 'Deloitte', 'EY', 'Amazon', 'HDFC Bank', 'ICICI Bank', 'Kotak Mahindra', 'TCS', 'Infosys'],

                'career_outcomes' => [
                    ['role' => 'Brand Manager',           'industry' => 'FMCG / Retail',       'avg_salary' => '7–14 LPA',  'range' => '5–20 LPA'],
                    ['role' => 'Investment Analyst',      'industry' => 'Banking / Finance',    'avg_salary' => '8–16 LPA',  'range' => '6–22 LPA'],
                    ['role' => 'Operations Manager',      'industry' => 'Supply Chain / Ops',   'avg_salary' => '7–13 LPA',  'range' => '5–18 LPA'],
                    ['role' => 'HR Generalist',           'industry' => 'IT / Corporate',       'avg_salary' => '5–9 LPA',   'range' => '4–14 LPA'],
                    ['role' => 'Fintech Product Manager', 'industry' => 'Fintech / BFSI',       'avg_salary' => '10–18 LPA', 'range' => '7–25 LPA'],
                ],

                'facilities' => [
                    ['name' => 'NMIMS Digital Campus LMS',         'icon' => 'bi-laptop'],
                    ['name' => 'Live Interactive Webinars',        'icon' => 'bi-camera-video'],
                    ['name' => 'Digital Library Access',           'icon' => 'bi-book'],
                    ['name' => 'Industry Mentor Programme',        'icon' => 'bi-person-video3'],
                    ['name' => 'Online Placement Drives',          'icon' => 'bi-briefcase'],
                    ['name' => 'NMIMS Alumni Network Access',      'icon' => 'bi-people'],
                    ['name' => '0% EMI Payment Gateway',          'icon' => 'bi-cash-coin'],
                    ['name' => '24/7 Student Support Helpdesk',   'icon' => 'bi-headset'],
                ],

                'faqs' => [
                    ['q' => 'Is NMIMS Online degree UGC approved?',     'a' => 'Yes, NGA-SCE is UGC-DEB approved and NAAC A accredited. Degrees are equivalent to regular programmes and WES recognized internationally.'],
                    ['q' => 'What is the fee for online MBA at NMIMS?', 'a' => 'Online MBA costs approximately ₹95,000 per year (₹1,90,000 total). 0% EMI options available.'],
                    ['q' => 'Is NMIMS Online degree valid abroad?',     'a' => 'Yes, NMIMS Online degrees are WES recognized and accepted in the USA, Canada, UK and other countries.'],
                    ['q' => 'Do I need an entrance exam?',              'a' => 'No entrance exam is required. Admission is direct based on qualifying exam marks.'],
                    ['q' => 'What is the NMIMS alumni network like?',   'a' => 'NMIMS has 60,000+ alumni at McKinsey, Goldman Sachs, EY, Amazon and leading Indian corporations.'],
                    ['q' => 'How are online classes conducted?',        'a' => 'Via the NMIMS digital LMS with live weekly webinars (recorded for later), assignments and online proctored exams.'],
                ],
            ],

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Child Table Inserters
    |--------------------------------------------------------------------------
    */

    private function insertCourses(int $collegeId, array $courses): void
    {
        $now = now();
        foreach ($courses as $i => $c) {
            $courseId = $this->courseIds[$c['slug']] ?? null;
            if (! $courseId) {
                continue;
            }
            $specId = ($c['spec'] && isset($this->specializationIds[$c['slug'].'|'.$c['spec']]))
                ? $this->specializationIds[$c['slug'].'|'.$c['spec']]
                : null;

            $ccId = DB::table('college_courses')->insertGetId([
                'college_id' => $collegeId,
                'course_id' => $courseId,
                'specialization' => $c['spec'],
                'specialization_id' => $specId,
                'fee_amount' => $c['fee'],
                'fee_type' => $c['type'],
                'eligibility' => $c['eligibility'],
                'seats' => $c['seats'] ?? null,
                'entrance_exam' => $c['entrance'] ?? null,
                'academic_session' => $c['session'] ?? '2025-26',
                'duration' => null,
                'sort_order' => $i,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if ($specId) {
                DB::table('college_course_specializations')->insert([
                    'college_course_id' => $ccId,
                    'specialization_id' => $specId,
                    'fee_amount' => $c['fee'],
                    'fee_type' => $c['type'],
                    'eligibility' => $c['eligibility'],
                    'seats' => $c['seats'] ?? null,
                    'entrance_exam' => $c['entrance'] ?? null,
                    'sort_order' => $i,
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('college_course_fees')->insert([
                'college_course_id' => $ccId,
                'fee_type' => $c['type'],
                'label' => 'Tuition Fee',
                'amount' => $c['fee'],
                'academic_session' => $c['session'] ?? '2025-26',
                'description' => null,
                'sort_order' => 0,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function insertHighlights(int $collegeId, array $items): void
    {
        $now = now();
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

    private function insertCareerOutcomes(int $collegeId, array $items): void
    {
        $now = now();
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
        foreach ($items as $i => $f) {
            DB::table('college_facilities')->insert([
                'college_id' => $collegeId,
                'name' => $f['name'],
                'icon' => $f['icon'] ?? null,
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

    private function basePayload(array $d, int $stateId, int $cityId): array
    {
        return [
            'name' => $d['name'],
            'short_name' => $d['short_name'],
            'slug' => $d['slug'],
            'logo' => null,
            'banner_image' => null,
            'college_mode' => $d['mode'],
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
            'nirf_rank' => $d['nirf_rank'],
            'nirf_year' => $d['nirf_year'],
            'entrance_exams' => $d['entrance_exams'],
            'rating' => $d['rating'],
            'reviews_count' => $d['reviews_count'],
            'highest_package' => $d['highest'],
            'average_package' => $d['average'],
            'top_recruiters' => $d['top_recruiters'],
            'has_boys_hostel' => $d['hostel_boys'],
            'has_girls_hostel' => $d['hostel_girls'],
            'facilities' => null,
            'overview' => $d['overview'],
            'admission_process' => null,
            'scholarship_info' => $d['scholarship_info'],
            'sample_certificate_image' => null,
            'brochure_pdf' => null,
            'faqs' => null,
            'highlights' => null,
            'is_featured' => $d['is_featured'],
            'status' => true,
            'seo_title' => $d['name'].' — Courses, Fees, Admission & Placements | GrowPec',
            'seo_description' => 'Explore '.$d['name'].' courses, fees, admission process, scholarships, placements and campus details on GrowPec.',
        ];
    }
}
