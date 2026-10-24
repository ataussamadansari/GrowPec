<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MeerutCollegesSeeder extends Seeder
{
    /** @var array<string, int> */
    private array $courseIds = [];

    /** @var array<string, int> */
    private array $specializationIds = [];

    public function run(): void
    {
        // 1. Load academic prerequisite mappings
        $this->loadAcademicMappings();

        // 2. Seed all 6 Meerut colleges inside a transaction
        DB::transaction(function () {
            $this->seedCollegesInSequence();
        });
    }

    /**
     * Load Course and Specialization IDs from the database
     */
    private function loadAcademicMappings(): void
    {
        $this->courseIds = DB::table('courses')
            ->pluck('id', 'slug')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        $specs = DB::table('specializations')
            ->join('courses', 'specializations.course_id', '=', 'courses.id')
            ->select('specializations.id', 'specializations.name', 'courses.slug as course_slug')
            ->get();

        foreach ($specs as $sp) {
            $this->specializationIds[$sp->course_slug.'|'.$sp->name] = (int) $sp->id;
        }
    }

    /**
     * Seed the 6 requested Meerut colleges strictly in sequence:
     * 1. Forte Institute of Technology, Meerut
     * 2. ABSS Institute of Technology (ABSSIT / ABESIT Meerut)
     * 3. Dewan V.S. Group of Institutions (Dewan College Meerut)
     * 4. Meerut Institute of Engineering and Technology (MIET Meerut)
     * 5. Bharat Institute of Technology (BIT Meerut)
     * 6. Translam Institute of Technology and Management (TITM Meerut)
     */
    private function seedCollegesInSequence(): void
    {
        $colleges = [
            $this->forteInstituteOfTechnology(),
            $this->abssitCollegeMeerut(),
            $this->dewanCollegeMeerut(),
            $this->mietCollegeMeerut(),
            $this->bitCollegeMeerut(),
            $this->translamInstituteMeerut(),
        ];

        foreach ($colleges as $def) {
            $this->seedSingleCollege($def);
        }
    }

    /* ══════════════════════════════════════════════════════════════════════════
     * 1. Forte Institute of Technology, Meerut
     * ══════════════════════════════════════════════════════════════════════════ */
    private function forteInstituteOfTechnology(): array
    {
        return [
            'name' => 'Forte Institute of Technology',
            'short_name' => 'FIT Meerut',
            'slug' => 'forte-institute-of-technology-meerut',
            'logo' => null,
            'banner_image' => null,
            'type' => 'Private',
            'institution_category' => 'College',
            'university' => 'Dr. A.P.J. Abdul Kalam Technical University (AKTU) & CCS University',
            'website' => 'https://www.forte.ac.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => 'Green Park, Kaseru Buxar, Mawana Road, Meerut, Uttar Pradesh - 250001',
            'year' => '1998',
            'campus' => '10+ Acres Green Campus on Mawana Road',
            'approvals' => 'AICTE, NCTE, UGC Recognized',
            'naac_grade' => 'B+',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'CUET-UG, CUET-PG, UP B.Ed JEE, 10+2 Merit',
            'rating' => 4.2,
            'reviews_count' => 280,
            'highest' => '₹10.00 LPA',
            'average' => '₹3.50 LPA',
            'top_recruiters' => 'Wipro, Infosys, Tech Mahindra, Genpact, ICICI Bank, HDFC Bank, Concentrix, Paytm',
            'is_featured' => true,
            'overview' => 'Forte Institute of Technology (FIT), established in 1998 at Green Park, Mawana Road, Meerut, is a premier institution offering professional education in Management, Information Technology, Commerce, and Teacher Education. Affiliated with Dr. A.P.J. Abdul Kalam Technical University (AKTU) for postgraduate professional programs and Chaudhary Charan Singh University (CCSU) for undergraduate degrees, and approved by AICTE and NCTE, FIT provides state-of-the-art computer labs, comprehensive digital libraries, industry-oriented training modules, and dedicated career placement support.',
            'scholarship_info' => 'Government scholarships under UP State Post-Matric schemes along with merit concessions for qualifying examination toppers and special tuition fee concessions for girl students.',

            'courses' => [
                [
                    'slug' => 'bca',
                    'spec' => 'Computer Applications & Web Development',
                    'fee' => 42000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => '10+2 Merit / CUET-UG',
                    'eligibility' => '10+2 in any stream with Mathematics as a compulsory subject with min 45% marks',
                    'sem_fee' => 21000.00,
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Business Administration & Marketing',
                    'fee' => 38000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => '10+2 Merit / CUET-UG',
                    'eligibility' => '10+2 in any discipline from a recognized board with minimum 45% aggregate',
                    'sem_fee' => 19000.00,
                ],
                [
                    'slug' => 'bcom',
                    'spec' => 'Financial Accounting & Banking',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => '10+2 Merit',
                    'eligibility' => '10+2 Commerce or Science with minimum 40% aggregate marks',
                    'sem_fee' => 11000.00,
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Cloud Computing & Software Engineering',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / Graduation Merit',
                    'eligibility' => 'BCA / B.Sc (Computer Science) / B.Sc (IT) or Graduation with Maths at 10+2 with min 50% marks',
                    'sem_fee' => 30000.00,
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing & Human Resource Management',
                    'fee' => 65000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / CAT / MAT / Graduation Merit',
                    'eligibility' => 'Bachelor degree in any stream with minimum 50% marks (45% for SC/ST)',
                    'sem_fee' => 32500.00,
                ],
                [
                    'slug' => 'bed',
                    'spec' => 'Teacher Education & Pedagogy',
                    'fee' => 51250.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'UP B.Ed Joint Entrance Examination (JEE)',
                    'eligibility' => 'Graduation or Post-Graduation with minimum 50% aggregate marks (NCTE Approved)',
                    'sem_fee' => 25625.00,
                ],
            ],

            'highlights' => [
                ['title' => '26+ Years of Excellence', 'value' => 'Pioneering technical and management education in Meerut since 1998', 'icon' => 'bi-award-fill'],
                ['title' => 'Dual University Affiliation', 'value' => 'Affiliated with AKTU Lucknow and CCS University Meerut', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'Active Placement Cell', 'value' => 'Consistent on-campus placement drives with leading MNCs and banks', 'icon' => 'bi-briefcase-fill'],
                ['title' => 'Modern Infrastructure', 'value' => 'High-speed Wi-Fi campus with advanced AC computer labs and library', 'icon' => 'bi-laptop'],
            ],

            'facilities' => [
                ['name' => 'High-Speed Computer & AI Labs', 'icon' => 'bi-laptop'],
                ['name' => 'Central Multi-Volume Digital Library', 'icon' => 'bi-book'],
                ['name' => 'Air-Conditioned Seminar & Conference Halls', 'icon' => 'bi-building'],
                ['name' => 'Cafeteria & Student Recreation Zone', 'icon' => 'bi-cup-hot'],
                ['name' => 'Sports Facilities (Cricket, Volleyball, Badminton)', 'icon' => 'bi-trophy'],
                ['name' => 'Fleet of College Buses Across Meerut NCR', 'icon' => 'bi-bus-front'],
            ],

            'faqs' => [
                ['q' => 'Where is Forte Institute of Technology located?', 'a' => 'Forte Institute of Technology is situated at Green Park, Kaseru Buxar on Mawana Road, Meerut, Uttar Pradesh - 250001.'],
                ['q' => 'Which universities is Forte Institute affiliated with?', 'a' => 'The institute is affiliated with Dr. A.P.J. Abdul Kalam Technical University (AKTU), Lucknow for MBA and MCA programs, and with Chaudhary Charan Singh University (CCSU), Meerut for BCA, BBA, B.Com, and B.Ed programs.'],
                ['q' => 'What is the fee structure for BCA and BBA at Forte Institute?', 'a' => 'The annual tuition fee is approximately ₹42,000 per year for BCA and ₹38,000 per year for BBA, making it one of the most cost-effective professional education centers in Meerut.'],
                ['q' => 'What is the highest package at Forte Institute of Technology?', 'a' => 'The highest salary package offered during recent campus placement drives reached ₹10.00 LPA, with average packages ranging around ₹3.50 LPA.'],
                ['q' => 'Does Forte Institute offer transport facilities?', 'a' => 'Yes, Forte Institute provides dedicated bus and transport services connecting all major nodes of Meerut city, Modinagar, Mawana, and surrounding NCR areas.'],
            ],

            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹10.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹3.50 LPA', 'year' => '2024'],
                ['label' => 'Placement Rate',  'value' => '80%',        'year' => '2024'],
            ],

            'recruiters' => [
                'Wipro', 'Infosys', 'Tech Mahindra', 'Genpact', 'ICICI Bank', 'HDFC Bank', 'Concentrix', 'Paytm',
            ],

            'scholarships' => [
                [
                    'name' => 'UP Government Post-Matric Scholarship',
                    'eligibility' => 'Eligible SC/ST/OBC and General EWS students of Uttar Pradesh',
                    'criteria' => 'Family annual income criteria as prescribed by UP Social Welfare Department',
                    'amount' => null,
                    'amount_label' => 'Full/Partial Tuition Fee Reimbursement',
                    'percentage' => 'Up to 100%',
                    'description' => 'Direct benefit transfer fee reimbursement managed by the Government of Uttar Pradesh.',
                ],
                [
                    'name' => 'Academic Merit Concession',
                    'eligibility' => 'Candidates with 80%+ marks in qualifying 10+2 or Graduation examinations',
                    'criteria' => 'Board/University marks verification',
                    'amount' => null,
                    'amount_label' => '15% - 25% Tuition Fee Waiver',
                    'percentage' => 'Up to 25%',
                    'description' => 'Merit incentive granted by the Forte Educational Trust to encourage academic achievers.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Admission Process at Forte Institute of Technology',
                    'content' => 'Admissions are conducted through merit in qualifying examinations as well as state entrance test counseling.',
                    'items' => [
                        'Step 1: Obtain the application form from the college campus at Mawana Road or apply online at forte.ac.in.',
                        'Step 2: Submit attested copies of 10th, 12th, or graduation marksheets and entrance exam scorecards.',
                        'Step 3: Verification of documents and personal counseling with faculty advisors.',
                        'Step 4: Deposit the prescribed admission and enrollment fee to confirm seat allocation.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Required Documents for Admission',
                    'content' => 'Students must present original and self-attested photocopies of the following documents:',
                    'items' => [
                        'Class 10th High School Marksheet and Passing Certificate',
                        'Class 12th Intermediate Marksheet and Passing Certificate',
                        'Graduation Marksheets and Degree Certificate (for MBA, MCA, B.Ed)',
                        'Transfer Certificate (TC) and Migration Certificate (Original)',
                        'Character Certificate issued by the last attended institution',
                        'Aadhaar Card and 5 recent passport-size photographs',
                    ],
                ],
            ],
        ];
    }

    /* ══════════════════════════════════════════════════════════════════════════
     * 2. ABSS Institute of Technology (ABSSIT / ABESIT Meerut), Meerut
     * ══════════════════════════════════════════════════════════════════════════ */
    private function abssitCollegeMeerut(): array
    {
        return [
            'name' => 'ABSS Institute of Technology',
            'short_name' => 'ABSSIT / ABESIT Meerut',
            'slug' => 'abss-institute-of-technology-meerut',
            'logo' => null,
            'banner_image' => null,
            'type' => 'Private',
            'institution_category' => 'College',
            'university' => 'Dr. A.P.J. Abdul Kalam Technical University (AKTU) & BTE Lucknow',
            'website' => 'https://abss.edu.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => 'Mawana Road, Opposite Idea Technology Centre, Meerut, Uttar Pradesh - 250001',
            'year' => '2007',
            'campus' => '15+ Acres Advanced Technical Campus',
            'approvals' => 'AICTE, PCI, BTE Lucknow, AKTU Affiliated',
            'naac_grade' => 'B',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'JEE Main, CUET-UG, JEECUP, 10+2 PCM/PCB Merit',
            'rating' => 4.1,
            'reviews_count' => 320,
            'highest' => '₹12.00 LPA',
            'average' => '₹3.80 LPA',
            'top_recruiters' => 'TCS, Infosys, Wipro, Capgemini, HCL Technologies, Paytm, Micromax, Glenmark, Mankind Pharma',
            'is_featured' => true,
            'overview' => 'ABSS Institute of Technology (ABSSIT), established in 2007 on Mawana Road, Meerut, is a renowned multidisciplinary engineering, pharmacy, and management college in Western Uttar Pradesh. Popularly referred to by local students and educational counselors as ABSSIT / ABESIT Meerut, the institute is approved by the All India Council for Technical Education (AICTE) and Pharmacy Council of India (PCI), and affiliated with Dr. A.P.J. Abdul Kalam Technical University (AKTU) and the Board of Technical Education (BTE) Lucknow. Offering industry-aligned programs in B.Tech, B.Pharm, D.Pharm, Polytechnic, MBA, and MCA, ABSSIT features modern laboratories, dynamic robotics workshops, and dedicated career placement training.',
            'scholarship_info' => 'Full scholarship support under UP Government fee reimbursement schemes, plus academic merit waivers for high scorers in JEE Main and UP Board examinations.',

            'courses' => [
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 75000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics and Chemistry/CS with min 45% aggregate marks',
                    'sem_fee' => 37500.00,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Mechanical Engineering',
                    'fee' => 70000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics with min 45% marks',
                    'sem_fee' => 35000.00,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Civil Engineering',
                    'fee' => 70000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics and Chemistry with min 45% marks',
                    'sem_fee' => 35000.00,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Electronics & Communication Engineering',
                    'fee' => 70000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics with min 45% marks',
                    'sem_fee' => 35000.00,
                ],
                [
                    'slug' => 'bpharma',
                    'spec' => 'Pharmaceutical Sciences & Practice',
                    'fee' => 70000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 100,
                    'exam' => 'CUET-UG / 10+2 PCB/PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Maths with minimum 50% aggregate (PCI Approved)',
                    'sem_fee' => 35000.00,
                ],
                [
                    'slug' => 'dpharma',
                    'spec' => 'Diploma in Pharmacy',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'JEECUP / 10+2 Science Merit',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Maths with min 45% aggregate marks',
                    'sem_fee' => 25000.00,
                ],
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Mechanical Engineering (Production)',
                    'fee' => 35000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'JEECUP / 10th Merit',
                    'eligibility' => 'Class 10th pass with Science and Mathematics with min 35% marks',
                    'sem_fee' => 17500.00,
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource, Marketing & Finance',
                    'fee' => 65000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / CAT / MAT / Graduation Merit',
                    'eligibility' => 'Graduation in any discipline with minimum 50% aggregate marks',
                    'sem_fee' => 32500.00,
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Full Stack & Database Applications',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / Graduation Merit',
                    'eligibility' => 'BCA / B.Sc Computer Science or Graduation with Mathematics with min 50% marks',
                    'sem_fee' => 30000.00,
                ],
            ],

            'highlights' => [
                ['title' => 'AICTE & PCI Approved', 'value' => 'Recognized by apex regulatory councils for Engineering & Pharmacy', 'icon' => 'bi-shield-check'],
                ['title' => 'Integrated Pharmacy & Tech', 'value' => 'Comprehensive research labs for formulation, pharmacology and engineering', 'icon' => 'bi-capsule'],
                ['title' => 'Industrial Partnerships', 'value' => 'Tie-ups with leading manufacturing and IT industries across NCR', 'icon' => 'bi-gear-wide-connected'],
                ['title' => 'Strong Placement Records', 'value' => 'Recruitment drives with top companies offering packages up to ₹12 LPA', 'icon' => 'bi-briefcase-fill'],
            ],

            'facilities' => [
                ['name' => 'PCI-Standard Pharmaceutical Laboratories', 'icon' => 'bi-capsule'],
                ['name' => 'High-Performance Computing & Coding Labs', 'icon' => 'bi-laptop'],
                ['name' => 'Mechanical & Civil Engineering Workshops', 'icon' => 'bi-tools'],
                ['name' => 'Central Air-Cooled Library & Reading Hall', 'icon' => 'bi-book'],
                ['name' => 'Hostel Accommodation for Boys and Girls', 'icon' => 'bi-house-door'],
                ['name' => 'Cricket & Football Grounds, Indoor Sports', 'icon' => 'bi-trophy'],
            ],

            'faqs' => [
                ['q' => 'Where is ABSS Institute of Technology located?', 'a' => 'ABSSIT is located on Mawana Road, Opposite Idea Technology Centre, Meerut, Uttar Pradesh - 250001.'],
                ['q' => 'Why is this college sometimes referred to as ABESIT Meerut?', 'a' => 'Local students and education consultants in Western UP frequently use the acronyms ABSSIT and ABESIT Meerut interchangeably to refer to this premier Mawana Road technical college.'],
                ['q' => 'Is the Pharmacy college at ABSS approved by PCI?', 'a' => 'Yes, both the B.Pharm and D.Pharm courses at ABSS Institute of Technology are approved by the Pharmacy Council of India (PCI) and affiliated with AKTU Lucknow.'],
                ['q' => 'What is the B.Tech fee at ABSS Institute of Technology?', 'a' => 'The tuition fee for B.Tech programs is approximately ₹75,000 per year, which is regulated in accordance with the Uttar Pradesh Fee Fixation Committee.'],
                ['q' => 'What are the top recruiting companies at ABSSIT?', 'a' => 'Prominent recruiters include TCS, Infosys, Wipro, Capgemini, HCL Technologies, Paytm, Micromax, Glenmark, and Mankind Pharma.'],
            ],

            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹12.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹3.80 LPA', 'year' => '2024'],
                ['label' => 'Placement Rate',  'value' => '82%',        'year' => '2024'],
            ],

            'recruiters' => [
                'TCS', 'Infosys', 'Wipro', 'Capgemini', 'HCL Technologies', 'Paytm', 'Micromax', 'Glenmark', 'Mankind Pharma',
            ],

            'scholarships' => [
                [
                    'name' => 'UP Social Welfare Post-Matric Scholarship',
                    'eligibility' => 'SC, ST, OBC and EWS students of Uttar Pradesh',
                    'criteria' => 'Family income less than ₹2.0 - ₹2.5 Lakhs per annum as per government rules',
                    'amount' => null,
                    'amount_label' => 'Full/Partial Tuition Fee Waiver',
                    'percentage' => 'Up to 100%',
                    'description' => 'Government of Uttar Pradesh scholarship program disbursed through direct student bank accounts.',
                ],
                [
                    'name' => 'Merit Entrance Scholarship',
                    'eligibility' => 'Students scoring 80+ percentile in JEE Main or 85%+ in 10+2 Board exams',
                    'criteria' => 'Entrance scorecard / Board verification',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Institutional merit incentive supporting outstanding technical aspirants.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Admission Process at ABSS Institute of Technology',
                    'content' => 'Admissions are made via UPTAC / JEE Main counseling ranks as well as direct institutional quota on merit.',
                    'items' => [
                        'Step 1: Fill out the application form online at abss.edu.in or visit the admissions office on Mawana Road.',
                        'Step 2: Submit 10th and 12th / Diploma / Graduation marksheets and relevant entrance exam scorecards.',
                        'Step 3: Document verification and academic counseling with department heads.',
                        'Step 4: Deposit confirmation fees and complete enrollment formalities.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Required Documents for Admission',
                    'content' => 'Candidates must bring the following documents at the time of admission:',
                    'items' => [
                        'Class 10th Marksheet and Passing Certificate',
                        'Class 12th Marksheet and Passing Certificate (or Diploma Certificate for Lateral Entry)',
                        'Graduation Marksheets (for MBA and MCA applicants)',
                        'Entrance Exam Scorecard (JEE Main, CUET, JEECUP)',
                        'Transfer Certificate (TC) & Migration Certificate (Original)',
                        'Domicile & Category / Income Certificate (for scholarship applicants)',
                        'Aadhaar Card and 6 recent passport-size photographs',
                    ],
                ],
            ],
        ];
    }

    /* ══════════════════════════════════════════════════════════════════════════
     * 3. Dewan V.S. Group of Institutions (Dewan College Meerut)
     * ══════════════════════════════════════════════════════════════════════════ */
    private function dewanCollegeMeerut(): array
    {
        return [
            'name' => 'Dewan V.S. Group of Institutions',
            'short_name' => 'Dewan College Meerut',
            'slug' => 'dewan-vs-group-of-institutions-meerut',
            'logo' => null,
            'banner_image' => null,
            'type' => 'Private',
            'institution_category' => 'College',
            'university' => 'Dr. A.P.J. Abdul Kalam Technical University (AKTU) & CCS University',
            'website' => 'https://dewaninstitutes.com',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => 'NH-58, Delhi-Mussoorie By-Pass Road, Partapur, Meerut, Uttar Pradesh - 250103',
            'year' => '1996',
            'campus' => '25+ Acres Green Campus on Delhi-Dehradun Highway',
            'approvals' => 'AICTE, BCI, NCTE, UGC, AKTU & CCSU Affiliated',
            'naac_grade' => 'B+',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'JEE Main, CUET-UG, CUET-PG, CAT, MAT, CLAT, 10+2 Merit',
            'rating' => 4.4,
            'reviews_count' => 680,
            'highest' => '₹15.00 LPA',
            'average' => '₹4.20 LPA',
            'top_recruiters' => 'Amazon, TCS, Wipro, Genpact, Tech Mahindra, Radisson, Taj Group, Oberoi Hotels, Tommy Hilfiger, Kotak Mahindra Bank',
            'is_featured' => true,
            'overview' => 'Dewan V.S. Group of Institutions (DVSGI), established in 1996 at Partapur on the NH-58 Delhi-Dehradun bypass road in Meerut, is one of Western Uttar Pradesh\'s premier educational conglomerates. Spanning over 25 lush green acres, the group comprises Dewan V.S. Institute of Engineering & Technology, Dewan Institute of Management Studies, Dewan Law College, and Dewan Institute of Hotel Management. Offering comprehensive programs in B.Tech, BCA, BBA, MBA, PGDM, Hotel Management (BHMCT), Law (BA LLB, LLB), and B.Ed, DVSGI combines rigorous academic curricula with industry-driven corporate certifications.',
            'scholarship_info' => 'Comprehensive scholarships under UP Government schemes plus merit-based fee concessions for top percentiles in CUET, JEE Main, and qualifying board exams.',

            'courses' => [
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 70000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate marks',
                    'sem_fee' => 35000.00,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 75000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics & Mathematics with min 45% marks',
                    'sem_fee' => 37500.00,
                ],
                [
                    'slug' => 'bca',
                    'spec' => 'Computer Applications & Cloud Technologies',
                    'fee' => 52000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 in any stream with Mathematics with min 45% aggregate',
                    'sem_fee' => 26000.00,
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Business Administration & E-Commerce',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 180,
                    'exam' => 'CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 in any stream from a recognized board with min 45% marks',
                    'sem_fee' => 25000.00,
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing, Finance & International Business',
                    'fee' => 90000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Graduation Merit',
                    'eligibility' => 'Graduation in any stream with minimum 50% marks',
                    'sem_fee' => 45000.00,
                ],
                [
                    'slug' => 'pgdm',
                    'spec' => 'Post Graduate Diploma in Management (Dual Spec)',
                    'fee' => 250000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CAT / MAT / XAT / Graduation Merit & Interview',
                    'eligibility' => 'Bachelor degree with min 50% marks; includes corporate international study immersion',
                    'sem_fee' => 125000.00,
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Software Engineering & Data Science',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / Graduation Merit',
                    'eligibility' => 'BCA / B.Sc Computer Science or equivalent with min 50% marks',
                    'sem_fee' => 40000.00,
                ],
                [
                    'slug' => 'bhmct',
                    'spec' => 'Hotel Management & Catering Technology',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => '10+2 Merit / Entrance Test',
                    'eligibility' => '10+2 in any stream with minimum 45% aggregate marks',
                    'sem_fee' => 30000.00,
                ],
                [
                    'slug' => 'ba-llb',
                    'spec' => 'Integrated Corporate & Constitutional Law',
                    'fee' => 45000.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 120,
                    'exam' => 'CLAT / CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 in any discipline with min 45% marks (40% for SC/ST) (BCI Approved)',
                    'sem_fee' => 22500.00,
                ],
                [
                    'slug' => 'llb',
                    'spec' => 'Bachelor of Laws (3-Year Professional)',
                    'fee' => 35000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'Graduation Merit',
                    'eligibility' => 'Graduation in any stream with min 45% marks (BCI Approved)',
                    'sem_fee' => 17500.00,
                ],
                [
                    'slug' => 'bed',
                    'spec' => 'Teacher Education & Pedagogy',
                    'fee' => 51250.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'UP B.Ed JEE Entrance Exam',
                    'eligibility' => 'Graduation with min 50% marks (NCTE Approved)',
                    'sem_fee' => 25625.00,
                ],
            ],

            'highlights' => [
                ['title' => '28+ Years Legacy', 'value' => 'Established in 1996 with over 20,000 successful alumni', 'icon' => 'bi-award-fill'],
                ['title' => '25-Acre Smart Campus', 'value' => 'Strategically located on NH-58 Delhi-Dehradun expressway', 'icon' => 'bi-geo-alt-fill'],
                ['title' => 'Multi-Disciplinary Group', 'value' => 'Institutes covering Engineering, Management, Hotel Management & Law', 'icon' => 'bi-book-half'],
                ['title' => 'Global Corporate Connect', 'value' => 'Placements with top MNCs and international 5-star hospitality chains', 'icon' => 'bi-globe'],
            ],

            'facilities' => [
                ['name' => 'High-Performance Computing & AI Labs', 'icon' => 'bi-laptop'],
                ['name' => 'Model Moot Court & Legal Aid Clinic', 'icon' => 'bi-bank'],
                ['name' => 'Commercial Kitchens, Bakery & Training Restaurant', 'icon' => 'bi-cup-hot'],
                ['name' => 'Central Air-Cooled Multi-Tier Library', 'icon' => 'bi-book'],
                ['name' => 'Air-Conditioned Boys & Girls Hostels on Campus', 'icon' => 'bi-house-door'],
                ['name' => 'Expansive Sports Complex & Gymnasium', 'icon' => 'bi-trophy'],
            ],

            'faqs' => [
                ['q' => 'Where is Dewan V.S. Group of Institutions situated?', 'a' => 'DVSGI is located on NH-58, Delhi-Mussoorie By-Pass Road, Partapur, Meerut, Uttar Pradesh - 250103, easily accessible via Delhi-Meerut Expressway and Rapid Rail (RRTS).'],
                ['q' => 'What institutions operate under the Dewan Group?', 'a' => 'The group comprises Dewan V.S. Institute of Engineering & Technology, Dewan Institute of Management Studies, Dewan Law College, and Dewan Institute of Hotel Management.'],
                ['q' => 'Is Dewan Law College approved by the Bar Council of India?', 'a' => 'Yes, Dewan Law College is approved by the Bar Council of India (BCI) and affiliated with Chaudhary Charan Singh University (CCSU), Meerut for BA LLB and LLB.'],
                ['q' => 'What is the highest placement package achieved at Dewan College?', 'a' => 'Students have secured packages reaching up to ₹15.00 LPA in top MNCs, with hotel management students regularly recruited by the Taj Group, Radisson, and Oberoi Hotels.'],
                ['q' => 'Does the campus provide hostel facilities?', 'a' => 'Yes, DVSGI offers safe and fully furnished air-cooled hostel facilities for both boys and girls within the gated campus with 24/7 security and high-speed Wi-Fi.'],
            ],

            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹15.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹4.20 LPA', 'year' => '2024'],
                ['label' => 'Placement Rate',  'value' => '85%',        'year' => '2024'],
            ],

            'recruiters' => [
                'Amazon', 'TCS', 'Wipro', 'Genpact', 'Tech Mahindra', 'Radisson', 'Taj Group', 'Oberoi Hotels', 'Tommy Hilfiger', 'Kotak Mahindra Bank',
            ],

            'scholarships' => [
                [
                    'name' => 'Merit Scholarship on Board Marks',
                    'eligibility' => 'Students securing 85%+ in Class 12th or qualifying degree',
                    'criteria' => 'Academic marksheet verification',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Tuition scholarship offered to encourage academically talented students.',
                ],
                [
                    'name' => 'UP Post-Matric Fee Reimbursement',
                    'eligibility' => 'Eligible UP domicile reserved category and EWS candidates',
                    'criteria' => 'Income & category certificate as per UP government norms',
                    'amount' => null,
                    'amount_label' => 'Full/Partial Tuition Fee Reimbursement',
                    'percentage' => 'Up to 100%',
                    'description' => 'Direct benefit state scholarship scheme.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Admission Process at Dewan V.S. Group of Institutions',
                    'content' => 'Admissions are conducted through national entrance test ranks, state counseling rounds, and direct merit allocation.',
                    'items' => [
                        'Step 1: Apply online through dewaninstitutes.com or collect the form from the Partapur campus admissions cell.',
                        'Step 2: Submit academic records, entrance exam scores (JEE Main, CUET, CLAT, CAT/MAT) and identification documents.',
                        'Step 3: Document verification and counseling session with the faculty admissions board.',
                        'Step 4: Remit the admission fee and complete registration.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Required Documents for Admission',
                    'content' => 'Please bring the following original documents along with 2 sets of photocopies:',
                    'items' => [
                        'Class 10th Marksheet & Passing Certificate',
                        'Class 12th Marksheet & Passing Certificate',
                        'Graduation Marksheet & Provisional Degree (for PG courses)',
                        'Entrance Exam Scorecard (CUET, JEE Main, CLAT, CAT)',
                        'Transfer Certificate & Migration Certificate (Original)',
                        'Character Certificate from previous institution',
                        'Aadhaar Card and 6 recent passport-size photographs',
                    ],
                ],
            ],
        ];
    }

    /* ══════════════════════════════════════════════════════════════════════════
     * 4. Meerut Institute of Engineering and Technology (MIET), Meerut
     * ══════════════════════════════════════════════════════════════════════════ */
    private function mietCollegeMeerut(): array
    {
        return [
            'name' => 'Meerut Institute of Engineering and Technology',
            'short_name' => 'MIET Meerut',
            'slug' => 'meerut-institute-of-engineering-and-technology-miet',
            'logo' => null,
            'banner_image' => null,
            'type' => 'Private',
            'institution_category' => 'College',
            'university' => 'Dr. A.P.J. Abdul Kalam Technical University (AKTU)',
            'website' => 'https://miet.ac.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => 'NH-58, Bypass Road, Baghpat Crossing, Meerut, Uttar Pradesh - 250005',
            'year' => '1997',
            'campus' => '25+ Acres State-of-the-Art Technical Campus',
            'approvals' => 'AICTE, NBA Accredited Programs, NAAC B++, PCI Approved',
            'naac_grade' => 'B++',
            'ugc_approved' => true,
            'nirf_rank' => 'Top 250 Engineering',
            'nirf_year' => '2024',
            'entrance_exams' => 'JEE Main, CUET-UG, CUET-PG, GPAT, GATE, 10+2 PCM Merit',
            'rating' => 4.6,
            'reviews_count' => 1420,
            'highest' => '₹33.00 LPA',
            'average' => '₹4.50 LPA',
            'top_recruiters' => 'Amazon, Adobe, TCS, Infosys, Wipro, Cognizant, HCL Technologies, Tech Mahindra, Capgemini, IBM, Zscaler, Torrent Pharma',
            'is_featured' => true,
            'overview' => 'Meerut Institute of Engineering and Technology (MIET), established in 1997, is recognized as the flagship and premier engineering and pharmacy institution of Western Uttar Pradesh. Strategically located on NH-58 at the Baghpat Crossing in Meerut, MIET is approved by AICTE and PCI, affiliated with Dr. A.P.J. Abdul Kalam Technical University (AKTU), and holds NAAC Accreditation along with NBA-accredited core departments. Renowned for its stellar placement track record with packages reaching ₹33 LPA and consistent mass recruitments by IT leaders like TCS, Infosys, and Cognizant, MIET features cutting-edge research centers, an IBM Software Center of Excellence, and vibrant student incubation centers.',
            'scholarship_info' => 'Generous institutional scholarships for high rankers in JEE Main (up to 100% tuition waiver) and full facilitation of UP State Post-Matric scholarships.',

            'courses' => [
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 123013.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 240,
                    'exam' => 'JEE Main / UPTAC Counseling / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry with min 45% marks (NBA Accredited Program)',
                    'sem_fee' => 61506.50,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Artificial Intelligence & Data Science',
                    'fee' => 123013.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / UPTAC / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics with min 45% aggregate marks',
                    'sem_fee' => 61506.50,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering (AIML)',
                    'fee' => 123013.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics with min 45% marks',
                    'sem_fee' => 61506.50,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Information Technology',
                    'fee' => 123013.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics with min 45% marks',
                    'sem_fee' => 61506.50,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Electronics & Communication Engineering',
                    'fee' => 123013.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics with min 45% marks',
                    'sem_fee' => 61506.50,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Biotechnology',
                    'fee' => 123013.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / 10+2 PCB/PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Maths with min 45% marks',
                    'sem_fee' => 61506.50,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Mechanical Engineering',
                    'fee' => 123013.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics with min 45% marks',
                    'sem_fee' => 61506.50,
                ],
                [
                    'slug' => 'bpharma',
                    'spec' => 'Pharmaceutical Chemistry & Pharmaceutics',
                    'fee' => 120000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 100,
                    'exam' => 'CUET-UG / 10+2 PCB/PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Maths with min 50% marks (PCI & NBA Accredited)',
                    'sem_fee' => 60000.00,
                ],
                [
                    'slug' => 'mtech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 18,
                    'exam' => 'GATE / CUET-PG / B.Tech Merit',
                    'eligibility' => 'B.Tech/B.E in relevant branch with min 50% aggregate marks',
                    'sem_fee' => 42500.00,
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing, Finance & Operations',
                    'fee' => 115000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 180,
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Graduation Merit',
                    'eligibility' => 'Bachelor degree in any stream with minimum 50% marks',
                    'sem_fee' => 57500.00,
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Cloud Computing & Artificial Intelligence',
                    'fee' => 105000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'CUET-PG / Graduation Merit',
                    'eligibility' => 'BCA / B.Sc Computer Science or Graduation with Mathematics with min 50% marks',
                    'sem_fee' => 52500.00,
                ],
            ],

            'highlights' => [
                ['title' => 'Top Engineering College in Meerut', 'value' => 'Flagship technical college in NCR with 27+ years history', 'icon' => 'bi-star-fill'],
                ['title' => 'NBA & NAAC B++ Accredited', 'value' => 'Quality certified programs in CSE, IT, ECE, and Pharmacy', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'Highest Package ₹33 LPA', 'value' => 'Record placement packages with tech multinationals and global giants', 'icon' => 'bi-cash-coin'],
                ['title' => 'IBM Center of Excellence', 'value' => 'Dedicated cloud computing, big data and artificial intelligence research labs', 'icon' => 'bi-cpu-fill'],
            ],

            'facilities' => [
                ['name' => 'IBM Software Center of Excellence & AI Hub', 'icon' => 'bi-cpu'],
                ['name' => 'High-Performance Supercomputing Labs', 'icon' => 'bi-laptop'],
                ['name' => 'Central Multi-Floor Digital Library & E-Resource Cell', 'icon' => 'bi-book'],
                ['name' => 'State-of-the-Art Formulation & Biotechnology Labs', 'icon' => 'bi-capsule'],
                ['name' => 'Modern Air-Cooled Hostels with Wi-Fi & Gym', 'icon' => 'bi-house-door'],
                ['name' => 'Full-Fledged Sports Complex & Cricket Ground', 'icon' => 'bi-trophy'],
            ],

            'faqs' => [
                ['q' => 'Where is MIET Meerut located?', 'a' => 'MIET is located on NH-58, Bypass Road at Baghpat Crossing, Meerut, Uttar Pradesh - 250005, right on the Delhi-Dehradun Highway.'],
                ['q' => 'What is the highest package at MIET Meerut?', 'a' => 'MIET students have achieved highest salary packages of up to ₹33.00 LPA in recent campus placement drives, with average packages consistently around ₹4.50 LPA to ₹5.50 LPA.'],
                ['q' => 'Which engineering branches are NBA accredited at MIET?', 'a' => 'Core programs including Computer Science & Engineering, Electronics & Communication Engineering, and B.Pharmacy hold coveted National Board of Accreditation (NBA) accreditation.'],
                ['q' => 'What is the B.Tech fee at MIET Meerut?', 'a' => 'The first-year total B.Tech fee is approximately ₹1,23,013 (including tuition, book bank, student development and activity charges), as approved by AKTU and state authorities.'],
                ['q' => 'How can I get admission to B.Tech at MIET?', 'a' => 'Admissions are conducted primarily through JEE Main ranks via UPTAC (AKTU) counseling, with a portion of seats allocated through direct merit counseling for qualified candidates.'],
            ],

            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹33.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹4.50 LPA',  'year' => '2024'],
                ['label' => 'Placement Rate',  'value' => '90%',        'year' => '2024'],
            ],

            'recruiters' => [
                'Amazon', 'Adobe', 'TCS', 'Infosys', 'Wipro', 'Cognizant', 'HCL Technologies', 'Tech Mahindra', 'Capgemini', 'IBM', 'Zscaler', 'Torrent Pharma',
            ],

            'scholarships' => [
                [
                    'name' => 'Chairman Merit Scholarship for JEE Main',
                    'eligibility' => 'Students securing top ranks in JEE Main or 90%+ in 10+2 PCM',
                    'criteria' => 'Scorecard verification during admission counseling',
                    'amount' => null,
                    'amount_label' => 'Up to 50% Tuition Fee Waiver',
                    'percentage' => 'Up to 50%',
                    'description' => 'Prestige scholarship awarded to meritorious engineering aspirants.',
                ],
                [
                    'name' => 'UP Post-Matric Fee Reimbursement Scheme',
                    'eligibility' => 'Eligible SC/ST/OBC and General EWS students domiciled in Uttar Pradesh',
                    'criteria' => 'Family income verification as per UP Social Welfare Department',
                    'amount' => null,
                    'amount_label' => 'Full/Partial Tuition Fee Reimbursement',
                    'percentage' => 'Up to 100%',
                    'description' => 'State government scholarship deposited directly to student bank accounts.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Admission Process at MIET Meerut',
                    'content' => 'Admissions are regulated through UPTAC (Dr. APJ Abdul Kalam Technical University) counseling and institutional merit seats.',
                    'items' => [
                        'Step 1: Register for UPTAC counseling using your JEE Main rank or CUET score.',
                        'Step 2: Choose MIET Meerut (College Code: 068) as your preferred choice in choice filling.',
                        'Step 3: Upon seat allotment, report to the MIET campus on NH-58 Baghpat Crossing for document verification.',
                        'Step 4: Deposit the prescribed semester fees to confirm admission.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Required Documents for Admission',
                    'content' => 'Submit original and photocopies of the following credentials:',
                    'items' => [
                        'Class 10th Marksheet and Certificate',
                        'Class 12th Marksheet and Certificate',
                        'JEE Main / CUET-UG / CUET-PG / GPAT Allotment Letter & Scorecard',
                        'Transfer Certificate & Migration Certificate (Original)',
                        'Character Certificate and Medical Fitness Certificate',
                        'Category / Income Certificate (for reservation / fee reimbursement)',
                        'Aadhaar Card and 6 colored passport-size photographs',
                    ],
                ],
            ],
        ];
    }

    /* ══════════════════════════════════════════════════════════════════════════
     * 5. Bharat Institute of Technology (BIT), Meerut
     * ══════════════════════════════════════════════════════════════════════════ */
    private function bitCollegeMeerut(): array
    {
        return [
            'name' => 'Bharat Institute of Technology',
            'short_name' => 'BIT Meerut',
            'slug' => 'bharat-institute-of-technology-bit-meerut',
            'logo' => null,
            'banner_image' => null,
            'type' => 'Private',
            'institution_category' => 'College',
            'university' => 'Dr. A.P.J. Abdul Kalam Technical University (AKTU) & CCS University',
            'website' => 'https://bitmeerut.edu.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => 'NH-58, Bypass Road, Partapur, Meerut, Uttar Pradesh - 250103',
            'year' => '2001',
            'campus' => '18+ Acres Well-Equipped Campus on Delhi-Meerut Highway',
            'approvals' => 'AICTE, PCI, BTE Lucknow, AKTU & CCSU Affiliated',
            'naac_grade' => 'B',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'JEE Main, CUET-UG, CUET-PG, JEECUP, 10+2 Merit',
            'rating' => 4.3,
            'reviews_count' => 510,
            'highest' => '₹25.00 LPA',
            'average' => '₹3.80 LPA',
            'top_recruiters' => 'TCS, Infosys, Wipro, Capgemini, HCL Technologies, Adobe, HSBC, Dabur, Tech Mahindra, Cipla, Sun Pharma',
            'is_featured' => true,
            'overview' => 'Bharat Institute of Technology (BIT), established in 2001 at Partapur on NH-58 in Meerut, is a renowned multi-disciplinary engineering, pharmacy, and management college in NCR. Operating under the visionary management of prominent educationists, BIT offers AICTE and PCI-approved programs affiliated with Dr. A.P.J. Abdul Kalam Technical University (AKTU) and Chaudhary Charan Singh University (CCSU). The campus features state-of-the-art computer labs, high-tech pharmacy formulation labs, dedicated sports arenas, separate residential hostels, and an active training and placement cell that has placed over 10,000 alumni in top Indian and multinational firms.',
            'scholarship_info' => 'Government scholarship support under UP Post-Matric schemes, special fee waivers under the Beti Bachao Beti Padhao initiative, and PCM merit concessions.',

            'courses' => [
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry with min 45% aggregate marks',
                    'sem_fee' => 42500.00,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Information Technology',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics & Mathematics with min 45% marks',
                    'sem_fee' => 40000.00,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Electronics & Communication Engineering',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics & Mathematics with min 45% marks',
                    'sem_fee' => 40000.00,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Mechanical Engineering',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics & Mathematics with min 45% marks',
                    'sem_fee' => 40000.00,
                ],
                [
                    'slug' => 'bpharma',
                    'spec' => 'Pharmaceutics & Pharmaceutical Chemistry',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 100,
                    'exam' => 'CUET-UG / 10+2 PCB/PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Maths with min 50% marks (PCI Approved)',
                    'sem_fee' => 42500.00,
                ],
                [
                    'slug' => 'dpharma',
                    'spec' => 'Diploma in Pharmacy Practice',
                    'fee' => 55000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'JEECUP / 10+2 Science Merit',
                    'eligibility' => '10+2 with PCB/PCM with min 45% marks',
                    'sem_fee' => 27500.00,
                ],
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Mechanical & Civil Engineering',
                    'fee' => 35000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'JEECUP / 10th Merit',
                    'eligibility' => '10th pass with Science & Maths with min 35% marks',
                    'sem_fee' => 17500.00,
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing, Finance & Human Resource',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'CAT / MAT / CUET-PG / Graduation Merit',
                    'eligibility' => 'Bachelor degree in any discipline with min 50% marks',
                    'sem_fee' => 40000.00,
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Advanced Software Architecture',
                    'fee' => 75000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / Graduation Merit',
                    'eligibility' => 'BCA / B.Sc CS with min 50% marks',
                    'sem_fee' => 37500.00,
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Business Administration',
                    'fee' => 40000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => '10+2 Merit',
                    'eligibility' => '10+2 in any stream with min 45% marks',
                    'sem_fee' => 20000.00,
                ],
                [
                    'slug' => 'bca',
                    'spec' => 'Computer Applications',
                    'fee' => 42000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => '10+2 Merit',
                    'eligibility' => '10+2 with Maths with min 45% marks',
                    'sem_fee' => 21000.00,
                ],
            ],

            'highlights' => [
                ['title' => '23+ Years of Quality Education', 'value' => 'Established in 2001 with modern campus on Delhi-Meerut Highway', 'icon' => 'bi-award-fill'],
                ['title' => 'PCI & AICTE Approved', 'value' => 'Comprehensive Pharmacy and Engineering departments with modern equipment', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'Highest Package ₹25 LPA', 'value' => 'Stellar placement track record with top multinational IT and pharma firms', 'icon' => 'bi-cash-coin'],
                ['title' => 'Dedicated Girls Incentive', 'value' => 'Special tuition scholarships under Beti Bachao Beti Padhao initiative', 'icon' => 'bi-heart-fill'],
            ],

            'facilities' => [
                ['name' => 'High-Speed Computer & AI Labs', 'icon' => 'bi-laptop'],
                ['name' => 'Advanced Pharmacy Formulation & Analysis Labs', 'icon' => 'bi-capsule'],
                ['name' => 'Central Digital Library with DELNET E-Journals', 'icon' => 'bi-book'],
                ['name' => 'Air-Conditioned Conference & Seminar Rooms', 'icon' => 'bi-building'],
                ['name' => 'Separate Boys and Girls Residential Hostels', 'icon' => 'bi-house-door'],
                ['name' => 'Outdoor Sports Complex (Cricket, Basketball, Volleyball)', 'icon' => 'bi-trophy'],
            ],

            'faqs' => [
                ['q' => 'Where is Bharat Institute of Technology (BIT) situated?', 'a' => 'BIT Meerut is situated on NH-58, Bypass Road, Partapur, Meerut, Uttar Pradesh - 250103, very close to the Partapur RRTS and Expressway interchange.'],
                ['q' => 'What is the highest package at BIT Meerut?', 'a' => 'The highest domestic package offered at BIT Meerut has reached ₹25.00 LPA, with previous international records touching ₹36.00 LPA in IT drives.'],
                ['q' => 'Is BIT Meerut approved by PCI for Pharmacy?', 'a' => 'Yes, both B.Pharm and D.Pharm courses at BIT are approved by the Pharmacy Council of India (PCI) and affiliated with AKTU / BTE Lucknow.'],
                ['q' => 'What is the B.Tech fee at BIT Meerut?', 'a' => 'The annual tuition fee for B.Tech is approximately ₹80,000 to ₹85,000 per year, following the official state fee regulatory committee guidelines.'],
                ['q' => 'Does BIT Meerut offer special scholarships for female candidates?', 'a' => 'Yes, BIT Meerut provides dedicated fee concessions under the Beti Bachao Beti Padhao scheme for meritorious female students.'],
            ],

            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹25.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹3.80 LPA', 'year' => '2024'],
                ['label' => 'Placement Rate',  'value' => '84%',        'year' => '2024'],
            ],

            'recruiters' => [
                'TCS', 'Infosys', 'Wipro', 'Capgemini', 'HCL Technologies', 'Adobe', 'HSBC', 'Dabur', 'Tech Mahindra', 'Cipla', 'Sun Pharma',
            ],

            'scholarships' => [
                [
                    'name' => 'Beti Bachao Beti Padhao Concession',
                    'eligibility' => 'All female candidates admitted to degree programs',
                    'criteria' => 'Female applicant verification',
                    'amount' => null,
                    'amount_label' => 'Special Tuition Fee Waiver',
                    'percentage' => '15% - 25%',
                    'description' => 'Dedicated financial incentive to promote technical education among women.',
                ],
                [
                    'name' => 'UP Post-Matric Scholarship Scheme',
                    'eligibility' => 'Eligible SC/ST/OBC and General EWS students of Uttar Pradesh',
                    'criteria' => 'Family income guidelines prescribed by UP government',
                    'amount' => null,
                    'amount_label' => 'Full/Partial Tuition Fee Reimbursement',
                    'percentage' => 'Up to 100%',
                    'description' => 'Government scholarship scheme directly credited to student accounts.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Admission Process at Bharat Institute of Technology',
                    'content' => 'Admissions are conducted through state entrance counseling as well as merit-based institutional seats.',
                    'items' => [
                        'Step 1: Fill out the application form online at bitmeerut.edu.in or visit the Partapur campus.',
                        'Step 2: Submit academic records (10th, 12th, or Graduation) and entrance exam scorecards (JEE Main, CUET, JEECUP).',
                        'Step 3: Verification of documents by the admission committee and allotment of branch.',
                        'Step 4: Deposit the semester fee to confirm admission.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Required Documents for Admission',
                    'content' => 'The following documents must be submitted during admission verification:',
                    'items' => [
                        'Class 10th Marksheet & Passing Certificate',
                        'Class 12th Marksheet & Passing Certificate',
                        'Entrance Exam Scorecard (JEE Main, CUET, JEECUP)',
                        'Transfer Certificate & Migration Certificate (Original)',
                        'Character Certificate issued by previous institution',
                        'Category & Domicile Certificate (if applicable)',
                        'Aadhaar Card and 6 recent passport-size photographs',
                    ],
                ],
            ],
        ];
    }

    /* ══════════════════════════════════════════════════════════════════════════
     * 6. Translam Institute of Technology and Management (TITM), Meerut
     * ══════════════════════════════════════════════════════════════════════════ */
    private function translamInstituteMeerut(): array
    {
        return [
            'name' => 'Translam Institute of Technology and Management',
            'short_name' => 'TITM Meerut',
            'slug' => 'translam-institute-of-technology-and-management-meerut',
            'logo' => null,
            'banner_image' => null,
            'type' => 'Private',
            'institution_category' => 'College',
            'university' => 'Dr. A.P.J. Abdul Kalam Technical University (AKTU) & BTE Lucknow',
            'website' => 'https://translam.com',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => 'NH-34, Mawana Road, Meerut, Uttar Pradesh - 250001',
            'year' => '1987',
            'campus' => '26+ Acres Comprehensive Educational Complex on Mawana Road',
            'approvals' => 'AICTE Approved, Affiliated with AKTU & BTE Lucknow',
            'naac_grade' => 'B',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'JEE Main, CUET-UG, JEECUP, 10+2 PCM Merit',
            'rating' => 4.0,
            'reviews_count' => 210,
            'highest' => '₹8.50 LPA',
            'average' => '₹3.20 LPA',
            'top_recruiters' => 'Genpact, Tech Mahindra, HCL Technologies, Paytm, Micromax, Mahindra & Mahindra, Havells, Mother Dairy',
            'is_featured' => true,
            'overview' => 'Translam Institute of Technology and Management (TITM), located on Mawana Road (NH-34) in Meerut, is part of the esteemed Translam Group which has pioneered education in Western Uttar Pradesh since 1987. Approved by AICTE and affiliated with Dr. A.P.J. Abdul Kalam Technical University (AKTU) and the Board of Technical Education (BTE) Lucknow, TITM provides affordable, industry-focused technical education in Engineering, Management, and Polytechnic Diplomas. The campus boasts modern engineering workshops, computer labs, library resources, and dedicated placement support.',
            'scholarship_info' => 'Full access to UP State Government fee reimbursement scholarships and merit-based concessions for regional students.',

            'courses' => [
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 65000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry with min 45% aggregate marks',
                    'sem_fee' => 32500.00,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Mechanical Engineering',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics & Mathematics with min 45% marks',
                    'sem_fee' => 30000.00,
                ],
                [
                    'slug' => 'btech',
                    'spec' => 'Civil Engineering',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics & Mathematics with min 45% marks',
                    'sem_fee' => 30000.00,
                ],
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Diploma in Mechanical Engineering',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'JEECUP / 10th Merit',
                    'eligibility' => '10th pass with Science & Maths with min 35% marks',
                    'sem_fee' => 16000.00,
                ],
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Diploma in Civil Engineering',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'JEECUP / 10th Merit',
                    'eligibility' => '10th pass with Science & Maths with min 35% marks',
                    'sem_fee' => 16000.00,
                ],
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Diploma in Electrical Engineering',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'JEECUP / 10th Merit',
                    'eligibility' => '10th pass with Science & Maths with min 35% marks',
                    'sem_fee' => 16000.00,
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing & Human Resource Management',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CAT / MAT / CUET-PG / Graduation Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate marks',
                    'sem_fee' => 30000.00,
                ],
            ],

            'highlights' => [
                ['title' => 'Established Since 1987', 'value' => 'Longstanding academic heritage in Western Uttar Pradesh', 'icon' => 'bi-award-fill'],
                ['title' => 'Affordable Fee Structure', 'value' => 'Cost-effective professional degrees with installment options', 'icon' => 'bi-cash-coin'],
                ['title' => 'AICTE & BTE Approved', 'value' => 'Fully approved engineering degree and polytechnic diploma programs', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'Sprawling 26-Acre Campus', 'value' => 'Expansive lush green campus on Mawana Road Meerut', 'icon' => 'bi-geo-alt-fill'],
            ],

            'facilities' => [
                ['name' => 'Computer Application & Programming Labs', 'icon' => 'bi-laptop'],
                ['name' => 'Mechanical & Civil Engineering Workshops', 'icon' => 'bi-tools'],
                ['name' => 'Central Library with Digital Reference Section', 'icon' => 'bi-book'],
                ['name' => 'Auditorium & Seminar Hall for Events', 'icon' => 'bi-building'],
                ['name' => 'Hostel Facility with Mess Services', 'icon' => 'bi-house-door'],
                ['name' => 'Playgrounds for Outdoor Sports (Cricket, Volleyball)', 'icon' => 'bi-trophy'],
            ],

            'faqs' => [
                ['q' => 'Where is Translam Institute of Technology and Management located?', 'a' => 'TITM is located on NH-34, Mawana Road, Meerut, Uttar Pradesh - 250001.'],
                ['q' => 'Which courses are offered at Translam Institute?', 'a' => 'TITM offers B.Tech (Computer Science, Mechanical, Civil), MBA, and Polytechnic Diplomas in Mechanical, Civil, and Electrical Engineering.'],
                ['q' => 'Is Translam Institute approved by AICTE?', 'a' => 'Yes, Translam Institute of Technology and Management is approved by AICTE New Delhi and affiliated with AKTU Lucknow and BTE Lucknow.'],
                ['q' => 'What is the fee for Polytechnic Diplomas at Translam?', 'a' => 'The tuition fee for Polytechnic Diploma courses is approximately ₹32,000 per year, conforming to the UP Board of Technical Education norms.'],
                ['q' => 'Are hostel facilities available at Translam?', 'a' => 'Yes, Translam provides residential hostel facilities with mess, Wi-Fi, and 24/7 security for outstation students.'],
            ],

            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹8.50 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹3.20 LPA', 'year' => '2024'],
                ['label' => 'Placement Rate',  'value' => '78%',       'year' => '2024'],
            ],

            'recruiters' => [
                'Genpact', 'Tech Mahindra', 'HCL Technologies', 'Paytm', 'Micromax', 'Mahindra & Mahindra', 'Havells', 'Mother Dairy',
            ],

            'scholarships' => [
                [
                    'name' => 'UP State Social Welfare Fee Reimbursement',
                    'eligibility' => 'Eligible SC/ST/OBC and General EWS students of Uttar Pradesh',
                    'criteria' => 'Family income guidelines as prescribed by the UP Government',
                    'amount' => null,
                    'amount_label' => 'Full/Partial Tuition Fee Waiver',
                    'percentage' => 'Up to 100%',
                    'description' => 'Direct scholarship transfer scheme provided by the state government.',
                ],
                [
                    'name' => 'Merit & Regional Concession',
                    'eligibility' => 'Students scoring 75%+ in 10th or 12th board exams',
                    'criteria' => 'Marksheet verification during admission',
                    'amount' => null,
                    'amount_label' => '10% - 20% Tuition Fee Waiver',
                    'percentage' => 'Up to 20%',
                    'description' => 'Tuition incentive granted by the Translam Educational Trust.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Admission Process at Translam Institute of Technology',
                    'content' => 'Admissions are conducted through state entrance exams (JEE Main, JEECUP, CUET) and direct merit allocation.',
                    'items' => [
                        'Step 1: Obtain the admission form from the Mawana Road campus or online via translam.com.',
                        'Step 2: Submit academic records and entrance examination scorecards.',
                        'Step 3: Document verification and counseling with admission officers.',
                        'Step 4: Deposit confirmation fees and complete enrollment.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Required Documents for Admission',
                    'content' => 'Submit original and photocopies of the following credentials:',
                    'items' => [
                        'Class 10th Marksheet and Passing Certificate',
                        'Class 12th Marksheet and Passing Certificate (for B.Tech / MBA)',
                        'Entrance Exam Scorecard (JEECUP, JEE Main, CUET)',
                        'Transfer Certificate & Migration Certificate',
                        'Character Certificate from previous institution',
                        'Aadhaar Card and 5 recent passport-size photographs',
                    ],
                ],
            ],
        ];
    }

    /* ══════════════════════════════════════════════════════════════════════════
     * DATABASE SEEDING ENGINE & INSERTION HELPERS
     * ══════════════════════════════════════════════════════════════════════════ */

    /**
     * Seed a single college with all relational child tables
     */
    private function seedSingleCollege(array $def): void
    {
        $now = now();

        // 1. Ensure State and City exist in DB
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
                'is_popular' => true,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 2. Prepare College Base Payload
        $payload = $this->buildBasePayload($def, $stateId, $cityId);
        $payload['updated_at'] = $now;

        $existing = DB::table('colleges')->where('slug', $def['slug'])->first();
        if ($existing) {
            $collegeId = (int) $existing->id;
            DB::table('colleges')->where('id', $collegeId)->update($payload);
            $this->cleanCollegeChildData($collegeId);
        } else {
            $payload['created_at'] = $now;
            $collegeId = (int) DB::table('colleges')->insertGetId($payload);
        }

        // 3. Insert Relational Child Data
        $this->insertCollegeCourses($collegeId, $def['courses']);
        $this->insertCollegeHighlights($collegeId, $def['highlights'] ?? []);
        $this->insertCollegeFacilities($collegeId, $def['facilities'] ?? []);
        $this->insertCollegeFaqs($collegeId, $def['faqs'] ?? []);
        $this->insertCollegePlacementStats($collegeId, $def['placement_stats'] ?? []);
        $this->insertCollegeRecruiters($collegeId, $def['recruiters'] ?? []);
        $this->insertCollegeScholarships($collegeId, $def['scholarships'] ?? []);
        $this->insertCollegeAdmissionSections($collegeId, $def['admission_sections'] ?? []);
        $this->insertCollegeQuickFacts($collegeId, $def);
    }

    /**
     * Clean old child records for an existing college
     */
    private function cleanCollegeChildData(int $collegeId): void
    {
        $tables = [
            'college_courses',
            'college_highlights',
            'college_facilities',
            'college_faqs',
            'college_placement_stats',
            'college_recruiters',
            'college_scholarships',
            'college_admission_sections',
            'college_quick_facts',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->where('college_id', $collegeId)->delete();
            }
        }
    }

    /**
     * Insert courses, specializations, and fee details
     */
    private function insertCollegeCourses(int $collegeId, array $courses): void
    {
        $now = now();

        foreach ($courses as $idx => $c) {
            $courseId = $this->courseIds[$c['slug']] ?? null;
            if (! $courseId) {
                // If course does not exist, fetch by slug or skip
                $courseId = DB::table('courses')->where('slug', $c['slug'])->value('id');
                if (! $courseId) {
                    continue;
                }
                $this->courseIds[$c['slug']] = (int) $courseId;
            }

            $specKey = $c['slug'].'|'.$c['spec'];
            $specId = $this->specializationIds[$specKey] ?? null;

            if (! $specId && Schema::hasTable('specializations')) {
                $existingSpec = DB::table('specializations')
                    ->where('course_id', $courseId)
                    ->where('name', $c['spec'])
                    ->first();

                if ($existingSpec) {
                    $specId = (int) $existingSpec->id;
                } else {
                    $specId = (int) DB::table('specializations')->insertGetId([
                        'course_id' => $courseId,
                        'name' => $c['spec'],
                        'slug' => Str::slug($c['spec']).'-'.uniqid(),
                        'status' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
                $this->specializationIds[$specKey] = $specId;
            }

            DB::table('college_courses')->insert([
                'college_id' => $collegeId,
                'course_id' => $courseId,
                'specialization' => $c['spec'],
                'specialization_id' => $specId,
                'fee_amount' => $c['fee'],
                'fee_type' => $c['type'] ?? 'per_year',
                'eligibility' => $c['eligibility'],
                'academic_session' => '2025-2026',
                'duration' => $c['duration'] ?? '3 Years',
                'seats' => $c['seats'] ?? 60,
                'entrance_exam' => $c['exam'] ?? 'Merit / Entrance Test',
                'application_url' => null,
                'brochure' => null,
                'sort_order' => $idx + 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Insert highlights
     */
    private function insertCollegeHighlights(int $collegeId, array $items): void
    {
        if (! Schema::hasTable('college_highlights')) {
            return;
        }

        $now = now();
        foreach ($items as $i => $h) {
            DB::table('college_highlights')->insert([
                'college_id' => $collegeId,
                'title' => $h['title'],
                'value' => $h['value'],
                'icon' => $h['icon'] ?? 'bi-patch-check-fill',
                'sort_order' => $i + 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Insert facilities
     */
    private function insertCollegeFacilities(int $collegeId, array $items): void
    {
        if (! Schema::hasTable('college_facilities')) {
            return;
        }

        $now = now();
        foreach ($items as $i => $f) {
            DB::table('college_facilities')->insert([
                'college_id' => $collegeId,
                'name' => $f['name'],
                'icon' => $f['icon'] ?? 'bi-building',
                'sort_order' => $i + 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Insert FAQs
     */
    private function insertCollegeFaqs(int $collegeId, array $items): void
    {
        if (! Schema::hasTable('college_faqs')) {
            return;
        }

        $now = now();
        foreach ($items as $i => $f) {
            DB::table('college_faqs')->insert([
                'college_id' => $collegeId,
                'question' => $f['q'],
                'answer' => $f['a'],
                'sort_order' => $i + 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Insert placement stats
     */
    private function insertCollegePlacementStats(int $collegeId, array $items): void
    {
        if (! Schema::hasTable('college_placement_stats')) {
            return;
        }

        $now = now();
        foreach ($items as $i => $stat) {
            DB::table('college_placement_stats')->insert([
                'college_id' => $collegeId,
                'label' => $stat['label'],
                'value' => $stat['value'],
                'year' => $stat['year'] ?? '2024',
                'course' => null,
                'description' => null,
                'sort_order' => $i + 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Insert recruiters
     */
    private function insertCollegeRecruiters(int $collegeId, array $names): void
    {
        if (! Schema::hasTable('college_recruiters')) {
            return;
        }

        $now = now();
        foreach ($names as $i => $name) {
            DB::table('college_recruiters')->insert([
                'college_id' => $collegeId,
                'name' => $name,
                'logo' => null,
                'description' => $name.' recruitment drive.',
                'sort_order' => $i + 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Insert scholarships
     */
    private function insertCollegeScholarships(int $collegeId, array $items): void
    {
        if (! Schema::hasTable('college_scholarships')) {
            return;
        }

        $now = now();
        foreach ($items as $i => $s) {
            DB::table('college_scholarships')->insert([
                'college_id' => $collegeId,
                'name' => $s['name'],
                'eligibility' => $s['eligibility'] ?? ($s['criteria'] ?? 'Merit / Category criteria'),
                'criteria' => $s['criteria'] ?? null,
                'amount' => $s['amount'] ?? null,
                'amount_label' => $s['amount_label'] ?? ($s['amount'] ?? null),
                'percentage' => $s['percentage'] ?? null,
                'description' => $s['description'] ?? ($s['criteria'] ?? null),
                'sort_order' => $i + 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Insert admission sections
     */
    private function insertCollegeAdmissionSections(int $collegeId, array $items): void
    {
        if (! Schema::hasTable('college_admission_sections')) {
            return;
        }

        $now = now();
        foreach ($items as $i => $sec) {
            DB::table('college_admission_sections')->insert([
                'college_id' => $collegeId,
                'section_key' => $sec['section_key'],
                'title' => $sec['title'],
                'content' => $sec['content'],
                'items' => json_encode($sec['items']),
                'sort_order' => $i + 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Insert quick facts
     */
    private function insertCollegeQuickFacts(int $collegeId, array $def): void
    {
        if (! Schema::hasTable('college_quick_facts')) {
            return;
        }

        $now = now();
        $facts = [
            ['parameter' => 'Type of Institution',    'value' => $def['type'].' College / Institute',       'icon' => 'building'],
            ['parameter' => 'Year of Establishment', 'value' => (string) $def['year'],                      'icon' => 'calendar'],
            ['parameter' => 'Statutory Approvals',   'value' => $def['approvals'],                           'icon' => 'shield-check'],
            ['parameter' => 'NAAC Grade',            'value' => 'Grade '.($def['naac_grade'] ?? 'B+'),     'icon' => 'patch-check-fill'],
            ['parameter' => 'Mode of Education',     'value' => 'Regular Full-Time Campus Degree',           'icon' => 'mortarboard'],
            ['parameter' => 'Campus Area',           'value' => $def['campus'],                              'icon' => 'geo-alt'],
            ['parameter' => 'Highest Package',       'value' => $def['highest'],                            'icon' => 'briefcase'],
            ['parameter' => 'Average Package',       'value' => $def['average'],                            'icon' => 'cash-coin'],
            ['parameter' => 'Hostel Facility',       'value' => 'Separate Boys & Girls Hostels Available',   'icon' => 'house'],
            ['parameter' => 'Location',              'value' => $def['city'].', '.$def['state'],            'icon' => 'pin-map'],
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

    /**
     * Build base college payload
     */
    private function buildBasePayload(array $d, int $stateId, int $cityId): array
    {
        $fees = array_column($d['courses'], 'fee');
        $minFee = ! empty($fees) ? min($fees) : 40000;
        $maxFee = ! empty($fees) ? max($fees) : 150000;

        $payload = [
            'name' => $d['name'],
            'short_name' => $d['short_name'],
            'slug' => $d['slug'],
            'logo' => $d['logo'] ?? null,
            'banner_image' => $d['banner_image'] ?? null,
            'college_mode' => 'regular',
            'college_type' => 'Private',
            'institution_category' => $d['institution_category'] ?? 'College',
            'university_name' => $d['university'],
            'website' => $d['website'],
            'state_id' => $stateId ?: null,
            'city_id' => $cityId ?: null,
            'address' => $d['address'],
            'established_year' => $d['year'],
            'campus_size' => $d['campus'],
            'approvals' => $d['approvals'],
            'naac_grade' => $d['naac_grade'],
            'ugc_approved' => $d['ugc_approved'],
            'nirf_rank' => $d['nirf_rank'] ?? null,
            'nirf_year' => $d['nirf_year'] ?? null,
            'entrance_exams' => $d['entrance_exams'] ?? 'JEE Main / CUET / Merit',
            'rating' => $d['rating'],
            'reviews_count' => $d['reviews_count'],
            'highest_package' => $d['highest'],
            'average_package' => $d['average'],
            'has_boys_hostel' => true,
            'has_girls_hostel' => true,
            'overview' => $d['overview'],
            'admission_process' => null,
            'scholarship_info' => $d['scholarship_info'],
            'sample_certificate_image' => null,
            'brochure_pdf' => null,
            'is_featured' => $d['is_featured'] ?? false,
            'status' => true,
            'seo_title' => $d['name'].' — Admission, Courses, Fees, Cutoff & Placements | GrowPec',
            'seo_description' => 'Get authentic admission details, fees, courses, ranking, scholarships, and placements for '.$d['name'].' on GrowPec.',
        ];

        if (Schema::hasColumn('colleges', 'exam_mode')) {
            $payload['exam_mode'] = 'Offline Semester Examinations';
        }
        if (Schema::hasColumn('colleges', 'learning_mode')) {
            $payload['learning_mode'] = 'Full-Time On-Campus Regular Degree';
        }
        if (Schema::hasColumn('colleges', 'emi_available')) {
            $payload['emi_available'] = true;
        }
        if (Schema::hasColumn('colleges', 'emi_starts_at')) {
            $payload['emi_starts_at'] = 6500.00;
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

        return $payload;
    }
}
