<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class StreamCourseSpecializationSeeder extends Seeder
{
    /** @var array<string, int> */
    public array $streamIds = [];

    /** @var array<string, int> */
    public array $courseIds = [];

    /** @var array<string, int> */
    public array $specializationIds = [];

    public function run(): void
    {
        $this->truncateTables();
        $this->seedStreams();
        $this->seedCourses();
        $this->seedSpecializations();
    }

    /**
     * Clear all college child tables, colleges, and academic prerequisites
     */
    private function truncateTables(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = [
            'college_course_specializations',
            'college_course_fees',
            'college_courses',
            'college_highlights',
            'college_facilities',
            'college_faqs',
            'college_quick_facts',
            'college_placement_stats',
            'college_recruiters',
            'college_reviews',
            'college_scholarships',
            'college_gallery',
            'college_documents',
            'college_alumni',
            'college_accreditations',
            'college_admission_sections',
            'college_career_outcomes',
            'college_comparisons',
            'college_learning_experiences',
            'college_loan_options',
            'colleges',
            'specializations',
            'courses',
            'streams',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * 1. Seed All Academic Disciplines & Streams
     */
    private function seedStreams(): void
    {
        $now = now();

        $streams = [
            'management' => ['name' => 'Management & Business Studies',               'icon' => 'bi-briefcase'],
            'engineering' => ['name' => 'Engineering & Technology',                    'icon' => 'bi-gear-wide-connected'],
            'it' => ['name' => 'Computer Applications & IT',                 'icon' => 'bi-laptop'],
            'pharmacy' => ['name' => 'Pharmacy & Pharmaceutical Sciences',          'icon' => 'bi-capsule'],
            'law' => ['name' => 'Law & Legal Studies',                         'icon' => 'bi-hammer'],
            'medical' => ['name' => 'Medical & Health Sciences',                   'icon' => 'bi-hospital'],
            'nursing' => ['name' => 'Nursing & Patient Care',                      'icon' => 'bi-heart-pulse'],
            'paramedical' => ['name' => 'Paramedical & Allied Health',                 'icon' => 'bi-bandaid'],
            'science' => ['name' => 'Science & Mathematics',                       'icon' => 'bi-flask'],
            'commerce' => ['name' => 'Commerce & Finance',                          'icon' => 'bi-currency-rupee'],
            'arts' => ['name' => 'Arts, Humanities & Social Sciences',          'icon' => 'bi-book'],
            'media-journalism' => ['name' => 'Media & Mass Communication',                  'icon' => 'bi-camera-reels'],
            'education' => ['name' => 'Education & Teaching',                        'icon' => 'bi-mortarboard'],
            'design-architecture' => ['name' => 'Design, Architecture & Planning',             'icon' => 'bi-palette'],
            'agriculture' => ['name' => 'Agriculture & Allied Sciences',               'icon' => 'bi-tree'],
            'hotel-management' => ['name' => 'Hotel Management, Tourism & Hospitality',     'icon' => 'bi-cup-hot'],
            'library-sciences' => ['name' => 'Library & Information Science',               'icon' => 'bi-collection'],
        ];

        foreach ($streams as $slug => $s) {
            DB::table('streams')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => $s['name'],
                    'icon' => $s['icon'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $this->streamIds[$slug] = (int) DB::table('streams')->where('slug', $slug)->value('id');
        }
    }

    /**
     * 2. Seed All Standard Undergraduate, Postgraduate & Diploma Courses
     */
    private function seedCourses(): void
    {
        $now = now();

        $courses = [
            // Engineering & Technology
            'btech' => ['stream' => 'engineering',         'name' => 'B.Tech',                                     'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '4 Years'],
            'mtech' => ['stream' => 'engineering',         'name' => 'M.Tech',                                     'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'polytechnic' => ['stream' => 'engineering',         'name' => 'Diploma in Engineering (Polytechnic)',       'level' => 'Diploma', 'degree_type' => 'Diploma', 'duration' => '3 Years'],

            // Management & Business Studies
            'mba' => ['stream' => 'management',          'name' => 'MBA',                                        'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bba' => ['stream' => 'management',          'name' => 'BBA',                                        'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'pgdm' => ['stream' => 'management',          'name' => 'PGDM',                                       'level' => 'PG',      'degree_type' => 'Diploma', 'duration' => '2 Years'],
            'executive-mba' => ['stream' => 'management',          'name' => 'Executive MBA',                              'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '1 Year'],

            // Computer Applications & IT
            'bca' => ['stream' => 'it',                  'name' => 'BCA',                                        'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'mca' => ['stream' => 'it',                  'name' => 'MCA',                                        'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bsc-it' => ['stream' => 'it',                  'name' => 'B.Sc. IT',                                   'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'bsc-cs' => ['stream' => 'it',                  'name' => 'B.Sc. Computer Science',                      'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'msc-it' => ['stream' => 'it',                  'name' => 'M.Sc. IT',                                   'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'msc-cs' => ['stream' => 'it',                  'name' => 'M.Sc. Computer Science',                     'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],

            // Pharmacy
            'bpharma' => ['stream' => 'pharmacy',            'name' => 'B.Pharm',                                    'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '4 Years'],
            'dpharma' => ['stream' => 'pharmacy',            'name' => 'D.Pharm',                                    'level' => 'Diploma', 'degree_type' => 'Diploma', 'duration' => '2 Years'],
            'mpharma' => ['stream' => 'pharmacy',            'name' => 'M.Pharm',                                    'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'pharm-d' => ['stream' => 'pharmacy',            'name' => 'Pharm.D',                                    'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '6 Years'],

            // Law & Legal Studies
            'ba-llb' => ['stream' => 'law',                 'name' => 'B.A. LL.B (Hons)',                           'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '5 Years'],
            'bba-llb' => ['stream' => 'law',                 'name' => 'BBA LL.B (Hons)',                            'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '5 Years'],
            'bcom-llb' => ['stream' => 'law',                 'name' => 'B.Com LL.B (Hons)',                          'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '5 Years'],
            'llb' => ['stream' => 'law',                 'name' => 'LL.B',                                       'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'llm' => ['stream' => 'law',                 'name' => 'LL.M',                                       'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '1 Year'],

            // Medical & Dental
            'mbbs' => ['stream' => 'medical',             'name' => 'MBBS',                                       'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '5.5 Years'],
            'bds' => ['stream' => 'medical',             'name' => 'BDS',                                        'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '5 Years'],
            'md' => ['stream' => 'medical',             'name' => 'MD',                                         'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'ms' => ['stream' => 'medical',             'name' => 'MS',                                         'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'mds' => ['stream' => 'medical',             'name' => 'MDS',                                        'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '3 Years'],

            // Nursing
            'bsc-nursing' => ['stream' => 'nursing',             'name' => 'B.Sc. Nursing',                              'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '4 Years'],
            'post-basic-bsc-nursing' => ['stream' => 'nursing',             'name' => 'Post Basic B.Sc. Nursing',                   'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'gnm' => ['stream' => 'nursing',             'name' => 'GNM (General Nursing & Midwifery)',           'level' => 'Diploma', 'degree_type' => 'Diploma', 'duration' => '3 Years'],
            'anm' => ['stream' => 'nursing',             'name' => 'ANM (Auxiliary Nursing Midwifery)',           'level' => 'Diploma', 'degree_type' => 'Diploma', 'duration' => '2 Years'],
            'msc-nursing' => ['stream' => 'nursing',             'name' => 'M.Sc. Nursing',                              'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],

            // Paramedical & Allied Health
            'bpt' => ['stream' => 'paramedical',         'name' => 'BPT (Physiotherapy)',                        'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '4.5 Years'],
            'mpt' => ['stream' => 'paramedical',         'name' => 'MPT (Physiotherapy)',                        'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bmlt' => ['stream' => 'paramedical',         'name' => 'BMLT (Medical Lab Technology)',               'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'dmlt' => ['stream' => 'paramedical',         'name' => 'DMLT (Medical Lab Technology)',               'level' => 'Diploma', 'degree_type' => 'Diploma', 'duration' => '2 Years'],
            'b-optom' => ['stream' => 'paramedical',         'name' => 'Bachelor of Optometry (B.Optom)',             'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '4 Years'],
            'bmrit' => ['stream' => 'paramedical',         'name' => 'B.Sc. Medical Radio Imaging (BMRIT)',         'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'bott' => ['stream' => 'paramedical',         'name' => 'B.Sc. Operation Theatre Technology (B.Sc OTT)', 'level' => 'UG',     'degree_type' => 'Degree',  'duration' => '3 Years'],

            // Science & Research
            'bsc' => ['stream' => 'science',             'name' => 'B.Sc.',                                      'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'msc' => ['stream' => 'science',             'name' => 'M.Sc.',                                      'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bsc-biotech' => ['stream' => 'science',             'name' => 'B.Sc. Biotechnology',                        'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'msc-biotech' => ['stream' => 'science',             'name' => 'M.Sc. Biotechnology',                        'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bsc-microbio' => ['stream' => 'science',             'name' => 'B.Sc. Microbiology',                         'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'msc-microbio' => ['stream' => 'science',             'name' => 'M.Sc. Microbiology',                         'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bsc-forensic' => ['stream' => 'science',             'name' => 'B.Sc. Forensic Science',                     'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],

            // Commerce & Finance
            'bcom' => ['stream' => 'commerce',            'name' => 'B.Com',                                      'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'bcom-hons' => ['stream' => 'commerce',            'name' => 'B.Com (Hons.)',                              'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'mcom' => ['stream' => 'commerce',            'name' => 'M.Com',                                      'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],

            // Arts & Humanities
            'ba' => ['stream' => 'arts',                'name' => 'B.A.',                                       'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'ba-hons' => ['stream' => 'arts',                'name' => 'B.A. (Hons.)',                              'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'ma' => ['stream' => 'arts',                'name' => 'M.A.',                                       'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'bsw' => ['stream' => 'arts',                'name' => 'BSW (Social Work)',                          'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'msw' => ['stream' => 'arts',                'name' => 'MSW (Social Work)',                          'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],

            // Media & Mass Communication
            'ba-jmc' => ['stream' => 'media-journalism',    'name' => 'B.A. (Journalism & Mass Communication)',     'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'ma-jmc' => ['stream' => 'media-journalism',    'name' => 'M.A. (Journalism & Mass Communication)',     'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],

            // Education & Teaching
            'bed' => ['stream' => 'education',           'name' => 'B.Ed',                                       'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'med' => ['stream' => 'education',           'name' => 'M.Ed',                                       'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'deled' => ['stream' => 'education',           'name' => 'D.El.Ed (BTC)',                              'level' => 'Diploma', 'degree_type' => 'Diploma', 'duration' => '2 Years'],
            'integrated-bed' => ['stream' => 'education',           'name' => 'Integrated B.A. B.Ed / B.Sc. B.Ed',         'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '4 Years'],

            // Design & Architecture
            'bdes' => ['stream' => 'design-architecture', 'name' => 'B.Des',                                      'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '4 Years'],
            'mdes' => ['stream' => 'design-architecture', 'name' => 'M.Des',                                      'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],
            'barch' => ['stream' => 'design-architecture', 'name' => 'B.Arch',                                     'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '5 Years'],
            'bfa' => ['stream' => 'design-architecture', 'name' => 'BFA (Fine Arts)',                            'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '4 Years'],

            // Agriculture & Allied Sciences
            'bsc-agri' => ['stream' => 'agriculture',         'name' => 'B.Sc. (Hons) Agriculture',                   'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '4 Years'],
            'msc-agri' => ['stream' => 'agriculture',         'name' => 'M.Sc. Agriculture',                          'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '2 Years'],

            // Hotel Management & Tourism
            'bhm' => ['stream' => 'hotel-management',    'name' => 'BHM (Hotel Management)',                     'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '3 Years'],
            'bhmct' => ['stream' => 'hotel-management',    'name' => 'BHMCT (Hotel Management & Catering Tech)',   'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '4 Years'],
            'dhm' => ['stream' => 'hotel-management',    'name' => 'Diploma in Hotel Management',                'level' => 'Diploma', 'degree_type' => 'Diploma', 'duration' => '1 Year'],

            // Library & Information Science
            'blis' => ['stream' => 'library-sciences',    'name' => 'BLIS (Library & Information Science)',       'level' => 'UG',      'degree_type' => 'Degree',  'duration' => '1 Year'],
            'mlis' => ['stream' => 'library-sciences',    'name' => 'MLIS (Library & Information Science)',       'level' => 'PG',      'degree_type' => 'Degree',  'duration' => '1 Year'],

            // Doctorate / Doctoral Research
            'phd' => ['stream' => 'engineering',         'name' => 'Ph.D.',                                      'level' => 'PhD',     'degree_type' => 'Degree',  'duration' => '3 Years'],
        ];

        foreach ($courses as $slug => $c) {
            $streamId = $this->streamIds[$c['stream']] ?? null;
            if (! $streamId) {
                continue;
            }

            DB::table('courses')->updateOrInsert(
                ['slug' => $slug],
                [
                    'stream_id' => $streamId,
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
    }

    /**
     * 3. Seed Comprehensive Specializations for Each Degree
     */
    private function seedSpecializations(): void
    {
        $now = now();

        $specializations = [
            'btech' => [
                'Computer Science & Engineering',
                'Artificial Intelligence & Machine Learning',
                'Data Science',
                'Cyber Security',
                'Cloud Computing & DevOps',
                'Internet of Things (IoT)',
                'Information Technology',
                'Mechanical Engineering',
                'Civil Engineering',
                'Electronics & Communication Engineering',
                'Electrical & Electronics Engineering',
                'Biotechnology Engineering',
                'Aerospace Engineering',
                'Robotics & Automation',
                'Automobile Engineering',
                'Mechatronics',
                'Petroleum Engineering',
                'Chemical Engineering',
            ],
            'mtech' => [
                'Computer Science & Engineering',
                'Artificial Intelligence',
                'VLSI Design & Embedded Systems',
                'Structural Engineering',
                'Thermal Engineering',
                'Biotechnology',
                'Environmental Engineering',
            ],
            'polytechnic' => [
                'Computer Science & Engineering',
                'Mechanical Engineering (Production)',
                'Mechanical Engineering (Automobile)',
                'Civil Engineering',
                'Electrical Engineering',
                'Electronics Engineering',
            ],
            'mba' => [
                'Marketing Management',
                'Financial Management',
                'Human Resource Management',
                'Business Analytics & Big Data',
                'Information Technology Management',
                'International Business',
                'Operations & Supply Chain Management',
                'Hospital & Healthcare Management',
                'Digital Marketing',
                'Agri-Business Management',
                'Banking & Financial Services',
                'FinTech',
                'Entrepreneurship & Family Business',
            ],
            'bba' => [
                'General Management',
                'Marketing Management',
                'Financial Management',
                'Human Resource Management',
                'Banking & Insurance',
                'Digital Marketing',
                'Business Analytics',
                'International Business',
                'Entrepreneurship',
                'Family Business Management',
            ],
            'pgdm' => [
                'Marketing & Sales',
                'Finance & Banking',
                'Human Resource Management',
                'Business Analytics',
                'Operations & Logistics',
            ],
            'bca' => [
                'General BCA / Core Computing',
                'Artificial Intelligence & Machine Learning',
                'Data Science & Analytics',
                'Cloud Computing & DevOps',
                'Cyber Security',
                'Full Stack Web Development',
                'Mobile Application Development',
            ],
            'mca' => [
                'General MCA / Software Engineering',
                'Artificial Intelligence & Machine Learning',
                'Cloud Computing & DevOps',
                'Data Science & Big Data Analytics',
                'Cyber Security & Information Assurance',
            ],
            'bsc-it' => [
                'Information Technology & Software Development',
                'Cloud Infrastructure & Networking',
                'Data Management & Analytics',
            ],
            'bsc-cs' => [
                'Computer Science & Systems',
                'Data Structures & Algorithmics',
            ],
            'msc-it' => [
                'Advanced Software Systems',
                'Network Security & Administration',
            ],
            'bpharma' => [
                'General Pharmacy Practice',
                'Pharmaceutics',
                'Pharmacology',
                'Industrial Pharmacy',
            ],
            'dpharma' => [
                'Diploma in Pharmacy Practice',
            ],
            'mpharma' => [
                'Pharmaceutics',
                'Pharmacology',
                'Pharmaceutical Chemistry',
                'Quality Assurance & Regulatory Affairs',
                'Pharmacognosy',
            ],
            'pharm-d' => [
                'Clinical Pharmacy & Patient Care',
            ],
            'ba-llb' => [
                'Integrated Corporate & Criminal Law',
                'Constitutional & Administrative Law',
                'Intellectual Property Rights',
                'Cyber Law & Human Rights',
            ],
            'bba-llb' => [
                'Corporate & Commercial Law',
                'Banking, Finance & Investment Law',
                'International Trade & Business Law',
            ],
            'bcom-llb' => [
                'Taxation & Corporate Law',
                'Commercial Arbitration',
            ],
            'llb' => [
                'General Law & Litigation',
                'Criminal & Civil Law Practice',
                'Constitutional Law',
            ],
            'llm' => [
                'Corporate & Commercial Law',
                'Criminal & Security Law',
                'Constitutional & Administrative Law',
                'Intellectual Property Law',
            ],
            'mbbs' => [
                'Medicine & Surgery (MBBS)',
            ],
            'bds' => [
                'Dental Surgery & Oral Health (BDS)',
            ],
            'mds' => [
                'Orthodontics',
                'Conservative Dentistry & Endodontics',
                'Oral & Maxillofacial Surgery',
                'Periodontology',
                'Prosthodontics',
            ],
            'bsc-nursing' => [
                'Clinical Nursing & Patient Care',
                'Critical Care & Emergency Nursing',
            ],
            'post-basic-bsc-nursing' => [
                'Advanced Clinical Nursing Practice',
            ],
            'gnm' => [
                'General Nursing & Midwifery Practice',
            ],
            'anm' => [
                'Community Health & Maternal Child Care',
            ],
            'msc-nursing' => [
                'Medical Surgical Nursing',
                'Obstetric & Gynaecological Nursing',
                'Community Health Nursing',
                'Paediatric Nursing',
                'Psychiatric Nursing',
            ],
            'bpt' => [
                'Physiotherapy & Rehabilitation',
                'Orthopaedic Physiotherapy',
                'Neurological Physiotherapy',
                'Sports Physiotherapy',
                'Cardiopulmonary Physiotherapy',
            ],
            'mpt' => [
                'Neurology',
                'Orthopaedics',
                'Sports Medicine',
                'Cardiopulmonary',
            ],
            'bmlt' => [
                'Clinical Biochemistry & Microbiology',
                'Haematology & Blood Banking',
                'Histopathology & Cytology',
            ],
            'dmlt' => [
                'General Medical Laboratory Technology',
            ],
            'b-optom' => [
                'Clinical Optometry & Vision Science',
            ],
            'bmrit' => [
                'Radiography, CT Scan & MRI Techniques',
            ],
            'bott' => [
                'Surgical Assistance & Anaesthesia Tech',
            ],
            'bsc' => [
                'Physics, Chemistry & Mathematics (PCM)',
                'Physics, Chemistry & Biology (PCB)',
                'Computer Science & Statistics',
                'Home Science',
                'Geology',
            ],
            'msc' => [
                'Physics',
                'Chemistry (Organic / Analytical)',
                'Mathematics',
                'Zoology',
                'Botany',
                'Environmental Science',
                'Statistics',
                'Data Science',
            ],
            'bsc-biotech' => [
                'Biotechnology & Genetic Engineering',
                'Plant & Animal Tissue Culture',
            ],
            'msc-biotech' => [
                'Molecular Biology & Genetic Engineering',
                'Industrial & Food Biotechnology',
            ],
            'bsc-microbio' => [
                'Clinical & Applied Microbiology',
                'Immunology & Virological Sciences',
            ],
            'msc-microbio' => [
                'Medical Microbiology',
                'Food & Industrial Microbiology',
            ],
            'bsc-forensic' => [
                'Crime Scene Investigation & Forensic Ballistics',
                'Forensic Toxicology & Cyber Forensics',
            ],
            'bcom' => [
                'Banking & Financial Services',
                'Corporate Accounting & Taxation',
                'Computer Applications in Business',
            ],
            'bcom-hons' => [
                'Accounting & Finance (Hons)',
                'Banking & Insurance',
                'Financial Markets & Investment',
                'International Accounting & ACCA',
            ],
            'mcom' => [
                'Advanced Financial Accounting',
                'Banking & Financial Management',
                'Taxation & Corporate Governance',
            ],
            'ba' => [
                'English Literature',
                'Economics',
                'Political Science',
                'History',
                'Sociology',
                'Psychology',
                'Hindi Literature',
            ],
            'ba-hons' => [
                'English (Hons)',
                'Economics (Hons)',
                'Political Science (Hons)',
                'Psychology (Hons)',
            ],
            'ma' => [
                'English Literature',
                'Economics',
                'Political Science',
                'History',
                'Sociology',
                'Clinical Psychology',
                'Education',
            ],
            'bsw' => [
                'Community Development & Social Action',
            ],
            'msw' => [
                'Medical & Psychiatric Social Work',
                'Human Resource Management & Labour Welfare',
                'Rural & Urban Community Development',
            ],
            'ba-jmc' => [
                'Journalism & News Anchoring',
                'Television & Radio Production',
                'Advertising & Public Relations',
                'Digital Media, VFX & Content Creation',
            ],
            'ma-jmc' => [
                'Broadcast Journalism',
                'Corporate Communication & PR',
                'Digital Media & New Trends',
            ],
            'bed' => [
                'Secondary School Teacher Education',
                'Science & Mathematics Pedagogy',
                'Languages & Social Sciences Pedagogy',
            ],
            'med' => [
                'Educational Leadership & Administration',
                'Curriculum & Pedagogical Studies',
            ],
            'deled' => [
                'Elementary Primary Teacher Education',
            ],
            'bdes' => [
                'Graphic & Communication Design',
                'UX/UI & Digital Product Design',
                'Fashion & Textile Design',
                'Interior & Spatial Design',
                'Animation & Visual Effects (VFX)',
                'Game Design',
            ],
            'mdes' => [
                'Industrial & Product Design',
                'User Experience & Interaction Design',
            ],
            'barch' => [
                'Architecture & Sustainable Built Environment',
                'Urban Design & Housing',
            ],
            'bfa' => [
                'Painting & Applied Art',
                'Sculpture & Digital Arts',
            ],
            'bsc-agri' => [
                'Agronomy & Organic Farming',
                'Horticulture & Crop Production',
                'Plant Breeding & Genetics',
                'Soil Science & Agricultural Chemistry',
                'Agricultural Economics & Extension',
            ],
            'msc-agri' => [
                'Agronomy',
                'Horticulture (Floriculture / Pomology)',
                'Genetics & Plant Breeding',
                'Soil Science',
            ],
            'bhm' => [
                'Food & Beverage Service',
                'Culinary Arts & Food Production',
                'Front Office Management',
                'Accommodation & Housekeeping Management',
            ],
            'bhmct' => [
                'Hospitality & Tourism Administration',
                'Culinary Arts & Bakery Management',
            ],
            'dhm' => [
                'Food Production & Bakery',
                'Hospitality Operations',
            ],
            'blis' => [
                'Library Cataloguing & Classification',
                'Digital Library Systems & Information Retrieval',
            ],
            'mlis' => [
                'Knowledge Management & Digital Archiving',
            ],
            'phd' => [
                'Computer Science & Engineering',
                'Management Studies',
                'Pharmaceutical Sciences',
                'Biotechnology',
                'Commerce & Economics',
                'Mechanical Engineering',
                'Civil Engineering',
                'Law & Legal Studies',
                'English & Humanities',
                'Physics, Chemistry & Mathematics',
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
                    [
                        'name' => $name,
                        'status' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                $this->specializationIds[$courseSlug.'|'.$name] =
                    (int) DB::table('specializations')
                        ->where('course_id', $courseId)
                        ->where('slug', $slug)
                        ->value('id');
            }
        }
    }
}
