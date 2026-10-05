<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class RegularCollegeSeeder extends Seeder
{
    /** @var array<string, int> */
    private array $courseIds = [];

    /** @var array<string, int> */
    private array $specializationIds = [];

    public function run(): void
    {
        // 1. Load academic prerequisite mappings populated by StreamCourseSpecializationSeeder
        $this->loadAcademicMappings();

        // 2. Seed colleges in strict user-defined sequence
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
     * Seed all regular colleges strictly in sequence
     */
    private function seedCollegesInSequence(): void
    {
        foreach ($this->collegeList() as $def) {
            $this->seedSingleCollege($def);
        }
    }

    /**
     * College definitions list (strictly in sequence):
     * 1. Graphic Era (Dehradun)
     * [Next colleges will be added here step-by-step]
     *
     * @return array<int, array<string, mixed>>
     */
    private function collegeList(): array
    {
        return [
            $this->graphicEraCollege(),
            $this->iimtCollege(),
            $this->bennettCollege(),
            $this->metroCollege(),
            $this->knModiCollege(),
            $this->galgotiasCollege(),
            $this->tmuCollege(),
            $this->amrapaliCollege(),
        ];
    }

    /**
     * 1. Graphic Era (Deemed to be University) – Dehradun, Uttarakhand
     *
     * @return array<string, mixed>
     */
    private function graphicEraCollege(): array
    {
        return [
            'name' => 'Graphic Era (Deemed to be University)',
            'short_name' => 'Graphic Era Dehradun',
            'slug' => 'graphic-era-deemed-to-be-university-dehradun',
            'type' => 'Deemed',
            'university' => 'Graphic Era (Deemed to be University)',
            'website' => 'https://geu.ac.in',
            'state' => 'Uttarakhand',
            'city' => 'Dehradun',
            'address' => '566/6, Bell Road, Society Area, Clement Town, Dehradun, Uttarakhand - 248002',
            'year' => '1993',
            'campus' => '30+ Acres Scenic Foothill Campus',
            'approvals' => 'UGC, AICTE, NAAC A+ (3.23 CGPA), NBA, AIU',
            'naac_grade' => 'A+',
            'ugc_approved' => true,
            'nirf_rank' => '52',
            'nirf_year' => '2024',
            'entrance_exams' => 'JEE Main, CUET-UG, CUET-PG, CAT, MAT, GATE, Merit-Based',
            'rating' => 4.8,
            'reviews_count' => 1280,
            'highest' => '₹84.88 LPA (International) / ₹54.03 LPA (Domestic)',
            'average' => '₹7.50 LPA',
            'top_recruiters' => 'Google, Microsoft, Amazon, Adobe, Zscaler, Cisco, Intel, Walmart, Morgan Stanley, HSBC, Deloitte, Ernst & Young, KPMG, PwC, Infosys, TCS, Wipro, Capgemini, L&T, HDFC Bank',
            'is_featured' => true,
            'overview' => 'Graphic Era (Deemed to be University), located in Clement Town, Dehradun, is one of India\'s premier multidisciplinary institutions, accredited with NAAC Grade \'A+\' (3.23 CGPA) and consistently ranked among the top 55 universities nationally by NIRF. Established in 1993 as Graphic Era Institute of Technology (GEIT) and conferred Deemed University status in 2008 under Section 3 of the UGC Act 1956, the university is acclaimed for its state-of-the-art research ecosystems, high-performance computing labs, illustrious industry tie-ups, and stellar placement track record with record international offers reaching ₹84.88 LPA. The campus sprawls across 30+ picturesque acres in the foothills of the Himalayas, offering world-class residential amenities, cutting-edge experiential learning, over 100 patents filed, and dedicated incubation centers empowering thousands of aspiring engineers, managers, researchers, and healthcare professionals.',
            'scholarship_info' => 'Graphic Era University awards generous merit scholarships up to ₹75,000 per semester based on Class 12th PCM aggregate, JEE Main percentile (>=85%ile), or CUET NTA score. An additional 10% scholarship is granted on net tuition fees for all female candidates across all programs under the Beti Bachao Beti Padhao initiative. Wards of Defence personnel receive a 5% tuition waiver, while Graphic Era alumni qualify for post-graduate concessions up to ₹64,000 per semester.',

            // Authentic Programs with real fee structures
            'courses' => [
                // 1. B.Tech Computer Science & Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 427600.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 480,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 60% aggregate',
                    'sem_fee' => 213800.00,
                ],
                // 2. B.Tech CSE (AI & ML)
                [
                    'slug' => 'btech',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 427600.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 180,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 60% aggregate',
                    'sem_fee' => 213800.00,
                ],
                // 3. B.Tech CSE (Data Science)
                [
                    'slug' => 'btech',
                    'spec' => 'Data Science',
                    'fee' => 427600.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 60% aggregate',
                    'sem_fee' => 213800.00,
                ],
                // 4. B.Tech CSE (Cyber Security)
                [
                    'slug' => 'btech',
                    'spec' => 'Cyber Security',
                    'fee' => 427600.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 60% aggregate',
                    'sem_fee' => 213800.00,
                ],
                // 5. B.Tech Aerospace Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Aerospace Engineering',
                    'fee' => 321710.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics min 60% aggregate',
                    'sem_fee' => 160855.00,
                ],
                // 6. B.Tech Biotechnology Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Biotechnology Engineering',
                    'fee' => 345082.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET / 10+2 PCM/PCB Merit',
                    'eligibility' => '10+2 with Physics, Mathematics/Biology & Chemistry min 60% aggregate',
                    'sem_fee' => 172541.00,
                ],
                // 7. B.Tech Mechanical Engineering (Robotics & Automation)
                [
                    'slug' => 'btech',
                    'spec' => 'Robotics & Automation',
                    'fee' => 337365.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics min 60% aggregate',
                    'sem_fee' => 168682.50,
                ],
                // 8. B.Tech Civil Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Civil Engineering',
                    'fee' => 337365.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics min 60% aggregate',
                    'sem_fee' => 168682.50,
                ],
                // 9. B.Tech Electronics & Communication Engineering (VLSI)
                [
                    'slug' => 'btech',
                    'spec' => 'Electronics & Communication Engineering',
                    'fee' => 321710.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics min 60% aggregate',
                    'sem_fee' => 160855.00,
                ],
                // 10. M.Tech Computer Science & Engineering
                [
                    'slug' => 'mtech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 158000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 30,
                    'exam' => 'GATE / CUET-PG / Merit',
                    'eligibility' => 'B.Tech / B.E. in CSE / IT / MCA with min 55% marks or equivalent CGPA',
                    'sem_fee' => 79000.00,
                ],
                // 11. MBA (Master of Business Administration)
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 427400.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 240,
                    'exam' => 'CAT / MAT / CMAT / XAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate (45% for SC/ST)',
                    'sem_fee' => 213700.00,
                ],
                // 12. MBA Business Analytics & Big Data
                [
                    'slug' => 'mba',
                    'spec' => 'Business Analytics & Big Data',
                    'fee' => 427400.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CAT / MAT / CMAT / XAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate with Mathematics/Stats',
                    'sem_fee' => 213700.00,
                ],
                // 13. MBA Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 427400.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CAT / MAT / CMAT / XAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate',
                    'sem_fee' => 213700.00,
                ],
                // 14. BBA (Bachelor of Business Administration)
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 193200.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 in any stream with min 50% aggregate marks',
                    'sem_fee' => 96600.00,
                ],
                // 15. BBA Business Analytics (Industry Partner Grant Thornton)
                [
                    'slug' => 'bba',
                    'spec' => 'Business Analytics',
                    'fee' => 193200.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 in any stream with min 50% aggregate marks',
                    'sem_fee' => 96600.00,
                ],
                // 16. BCA (Bachelor of Computer Applications)
                [
                    'slug' => 'bca',
                    'spec' => 'General BCA / Core Computing',
                    'fee' => 141015.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 240,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 with Mathematics/Computer Science/IT with min 50% marks',
                    'sem_fee' => 70507.50,
                ],
                // 17. BCA Cyber Security
                [
                    'slug' => 'bca',
                    'spec' => 'Cyber Security',
                    'fee' => 152040.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 with Mathematics/Computer Science/IT with min 50% marks',
                    'sem_fee' => 76020.00,
                ],
                // 18. MCA (Master of Computer Applications)
                [
                    'slug' => 'mca',
                    'spec' => 'General MCA / Software Engineering',
                    'fee' => 176300.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'CUET-PG / Merit-Based',
                    'eligibility' => 'BCA / B.Sc (IT/CS) / B.Tech or Bachelor degree with Mathematics at 10+2/Graduation min 50%',
                    'sem_fee' => 88150.00,
                ],
                // 19. MCA in AI & Data Science
                [
                    'slug' => 'mca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 195400.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / Merit-Based',
                    'eligibility' => 'BCA / B.Sc (IT/CS) or Bachelor degree with Mathematics with min 50%',
                    'sem_fee' => 97700.00,
                ],
                // 20. B.Sc. Nursing
                [
                    'slug' => 'bsc-nursing',
                    'spec' => 'Clinical Nursing & Patient Care',
                    'fee' => 286980.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'NEET / University Entrance Test',
                    'eligibility' => '10+2 with Physics, Chemistry, Biology & English min 45% aggregate (40% for SC/ST)',
                    'sem_fee' => 143490.00,
                ],
                // 21. BPT (Bachelor of Physiotherapy)
                [
                    'slug' => 'bpt',
                    'spec' => 'Physiotherapy & Rehabilitation',
                    'fee' => 143105.00,
                    'type' => 'per_year',
                    'duration' => '4.5 Years',
                    'seats' => 60,
                    'exam' => 'CUET / 10+2 PCB Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology with min 50% marks',
                    'sem_fee' => 71552.25,
                ],
                // 22. BMLT (Medical Laboratory Technology)
                [
                    'slug' => 'bmlt',
                    'spec' => 'Clinical Biochemistry & Microbiology',
                    'fee' => 129990.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET / 10+2 PCB Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology with min 50% aggregate marks',
                    'sem_fee' => 64995.00,
                ],
                // 23. BMRIT (Medical Radio Imaging Technology)
                [
                    'slug' => 'bmrit',
                    'spec' => 'Radiography, CT Scan & MRI Techniques',
                    'fee' => 129990.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET / 10+2 PCB Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology with min 50% aggregate marks',
                    'sem_fee' => 64995.00,
                ],
                // 24. B.Sc. (Hons) Agriculture
                [
                    'slug' => 'bsc-agri',
                    'spec' => 'Agronomy & Crop Science',
                    'fee' => 150381.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'CUET-UG / ICAR / Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Mathematics/Agriculture with min 50%',
                    'sem_fee' => 75190.50,
                ],
                // 25. BHM (Bachelor of Hotel Management)
                [
                    'slug' => 'bhm',
                    'spec' => 'Food & Beverage Service',
                    'fee' => 178605.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 90,
                    'exam' => 'NCHMCT JEE / CUET / Merit',
                    'eligibility' => '10+2 in any stream with English as a compulsory subject with min 50%',
                    'sem_fee' => 89302.50,
                ],
                // 26. B.Com (Hons.)
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'Accounting & Finance (Hons)',
                    'fee' => 166588.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 180,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 with Commerce / Mathematics with min 50% marks',
                    'sem_fee' => 83294.00,
                ],
                // 27. B.A. LL.B (Hons)
                [
                    'slug' => 'ba-llb',
                    'spec' => 'Integrated Corporate & Criminal Law',
                    'fee' => 496042.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 120,
                    'exam' => 'CLAT / LSAT India / CUET / Merit',
                    'eligibility' => '10+2 in any stream with min 45% aggregate marks (40% for SC/ST)',
                    'sem_fee' => 248021.00,
                ],
                // 28. BBA LL.B (Hons)
                [
                    'slug' => 'bba-llb',
                    'spec' => 'Corporate & Commercial Law',
                    'fee' => 496042.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 120,
                    'exam' => 'CLAT / LSAT India / CUET / Merit',
                    'eligibility' => '10+2 in any stream with min 45% aggregate marks (40% for SC/ST)',
                    'sem_fee' => 248021.00,
                ],
                // 29. LL.B (Bachelor of Laws)
                [
                    'slug' => 'llb',
                    'spec' => 'General Law & Litigation',
                    'fee' => 489616.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / Law Entrance / Merit',
                    'eligibility' => 'Graduation in any discipline with min 45% marks (40% for SC/ST)',
                    'sem_fee' => 244808.00,
                ],
                // 30. LL.M
                [
                    'slug' => 'llm',
                    'spec' => 'Corporate & Commercial Law',
                    'fee' => 227400.00,
                    'type' => 'per_year',
                    'duration' => '1 Year',
                    'seats' => 30,
                    'exam' => 'CLAT-PG / CUET-PG / Merit',
                    'eligibility' => 'LL.B or 5-year integrated law degree with min 50% marks',
                    'sem_fee' => 113700.00,
                ],
                // 31. B.Des (User Experience & Interaction Design)
                [
                    'slug' => 'bdes',
                    'spec' => 'UX/UI & Digital Product Design',
                    'fee' => 210000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'UCEED / NID DAT / GEU Design Aptitude Test',
                    'eligibility' => '10+2 in any stream with min 50% aggregate marks',
                    'sem_fee' => 105000.00,
                ],
                // 32. B.Sc. Biotechnology
                [
                    'slug' => 'bsc-biotech',
                    'spec' => 'Biotechnology & Genetic Engineering',
                    'fee' => 134174.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / 10+2 PCB Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Mathematics min 50% marks',
                    'sem_fee' => 67087.00,
                ],
                // 33. B.Sc. Forensic Science
                [
                    'slug' => 'bsc-forensic',
                    'spec' => 'Crime Scene Investigation & Forensic Ballistics',
                    'fee' => 134174.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / 10+2 PCB Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Mathematics min 50% marks',
                    'sem_fee' => 67087.00,
                ],
                // 34. M.Sc. Biotechnology
                [
                    'slug' => 'msc-biotech',
                    'spec' => 'Molecular Biology & Genetic Engineering',
                    'fee' => 113300.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 30,
                    'exam' => 'CUET-PG / Merit-Based',
                    'eligibility' => 'B.Sc in Biotechnology / Microbiology / Life Sciences with min 50%',
                    'sem_fee' => 56650.00,
                ],
                // 35. B.A. (Hons) Psychology
                [
                    'slug' => 'ba-hons',
                    'spec' => 'Psychology (Hons)',
                    'fee' => 113300.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 in any stream with min 50% marks',
                    'sem_fee' => 56650.00,
                ],
                // 36. Ph.D.
                [
                    'slug' => 'phd',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 120000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 20,
                    'exam' => 'UGC-NET / CSIR-NET / GATE / GEU Research Entrance Test (RET)',
                    'eligibility' => 'Master\'s Degree in relevant discipline with min 55% aggregate marks',
                    'sem_fee' => 60000.00,
                ],
            ],

            // Highlights
            'highlights' => [
                ['title' => 'NIRF 2024 Ranking',               'value' => 'Ranked #52 Top Universities in India',      'icon' => 'bi-award-fill'],
                ['title' => 'NAAC Grade A+ Accreditation',      'value' => 'Accredited with 3.23 CGPA Score',           'icon' => 'bi-patch-check-fill'],
                ['title' => 'Stellar Record Placements',       'value' => '₹84.88 LPA Highest International Package',  'icon' => 'bi-briefcase-fill'],
                ['title' => 'Domestic Peak Package',           'value' => '₹54.03 LPA Domestic Highest Offer',         'icon' => 'bi-currency-rupee'],
                ['title' => 'Average B.Tech Placement',         'value' => '₹7.50 LPA to ₹9.20 LPA Average Package',    'icon' => 'bi-graph-up-arrow'],
                ['title' => 'Himalayan Foothills Campus',       'value' => '30+ Acres High-Tech Wi-Fi Campus',          'icon' => 'bi-tree-fill'],
                ['title' => 'Patents & Global Research',        'value' => '100+ Patents & Research Publications',      'icon' => 'bi-lightbulb-fill'],
                ['title' => 'Female Scholarship Concession',    'value' => '10% Additional Waiver on Net Tuition Fee',  'icon' => 'bi-heart-fill'],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'High-Performance Supercomputing & AI Labs',    'icon' => 'bi-cpu'],
                ['name' => 'Smart Audio-Visual Air-Conditioned Classrooms', 'icon' => 'bi-display'],
                ['name' => 'Central Digital Library (1.5 Lakh+ Books)',     'icon' => 'bi-book-half'],
                ['name' => 'Separate AC & Non-AC Boys & Girls Hostels',     'icon' => 'bi-houses'],
                ['name' => '24x7 Multi-Specialty Health Centre & Ambulance', 'icon' => 'bi-hospital'],
                ['name' => 'Indoor & Outdoor Sports Arena & Gymnasium',     'icon' => 'bi-trophy'],
                ['name' => 'Multi-Cuisine Hygienic Cafeterias',             'icon' => 'bi-cup-hot'],
                ['name' => 'Moot Court Hall & Legal Aid Clinic',            'icon' => 'bi-hammer'],
                ['name' => 'Commercial Training Kitchens & Bakery Labs',    'icon' => 'bi-egg-fried'],
                ['name' => 'Air-Conditioned University Transport Fleet',    'icon' => 'bi-bus-front'],
            ],

            // FAQs
            'faqs' => [
                [
                    'q' => 'Is Graphic Era a Deemed to be University or State Private University?',
                    'a' => 'Graphic Era is a Deemed to be University, conferred status under Section 3 of the UGC Act 1956 by the Ministry of Education (MHRD), Government of India in 2008. It is accredited with NAAC Grade A+ (3.23 CGPA).',
                ],
                [
                    'q' => 'What is the highest and average package at Graphic Era?',
                    'a' => 'Graphic Era boasts an outstanding placement track record. The highest international package is ₹84.88 LPA, while the highest domestic package is ₹54.03 LPA. The overall university average package stands at ₹7.50 LPA, with B.Tech CSE averaging ₹9.20 LPA.',
                ],
                [
                    'q' => 'What scholarships are available at Graphic Era for students?',
                    'a' => 'Merit scholarships up to ₹75,000 per semester are awarded based on 12th PCM aggregate, JEE Main percentile (>=85%ile), or CUET scores. All female candidates receive an additional 10% waiver on net tuition fees, while defence personnel wards receive a 5% concession.',
                ],
                [
                    'q' => 'What is the admission procedure for B.Tech CSE at Graphic Era?',
                    'a' => 'Candidates must have passed 10+2 with Physics, Mathematics, and Chemistry/CS with at least 60% aggregate. Admissions are granted on the basis of JEE Main percentile, CUET scores, or 10+2 PCM merit through university counseling.',
                ],
                [
                    'q' => 'Are hostel facilities available on the Graphic Era Dehradun campus?',
                    'a' => 'Yes, Graphic Era provides fully furnished, secure, and separate AC and Non-AC hostel accommodation for both male and female students with 24x7 Wi-Fi, nutritious mess facilities, power backup, laundry, and round-the-clock medical care.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest International Package', 'value' => '₹84.88 LPA', 'year' => '2024'],
                ['label' => 'Highest Domestic Package',      'value' => '₹54.03 LPA', 'year' => '2024'],
                ['label' => 'Average B.Tech Package',        'value' => '₹9.20 LPA',  'year' => '2024'],
                ['label' => 'Average University Package',    'value' => '₹7.50 LPA',  'year' => '2024'],
                ['label' => 'Placement Percentage',          'value' => '95.8%',      'year' => '2024'],
                ['label' => 'Total Recruiter Companies',     'value' => '320+',       'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'Google', 'Microsoft', 'Amazon', 'Adobe', 'Zscaler', 'Cisco',
                'Intel', 'Walmart', 'Morgan Stanley', 'HSBC', 'Deloitte',
                'Ernst & Young', 'KPMG', 'PwC', 'Infosys', 'TCS', 'Wipro',
                'Capgemini', 'L&T', 'HDFC Bank',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Merit Scholarship on Academic Performance',
                    'eligibility' => '>=95% in 12th PCM OR >=99%ile in JEE Main / CUET Score >=237.5',
                    'criteria' => 'Merit-Based on qualifying examination score',
                    'amount' => 75000.00,
                    'amount_label' => '₹75,000 per Semester',
                    'percentage' => 'Up to 35%',
                    'description' => 'Awarded to top rankers on first-come-first-serve basis across 25% of allotted seats.',
                ],
                [
                    'name' => 'Beti Bachao Beti Padhao Female Scholarship',
                    'eligibility' => 'All female applicants admitted across any undergraduate or postgraduate program',
                    'criteria' => 'Gender-based scholarship for girl candidates',
                    'amount' => null,
                    'amount_label' => '10% Additional Waiver',
                    'percentage' => '10%',
                    'description' => '10% additional waiver on net tuition fee applicable across all semesters for female candidates.',
                ],
                [
                    'name' => 'Wards of Defence Personnel Scholarship',
                    'eligibility' => 'Wards of serving or retired Indian Armed Forces & Paramilitary personnel',
                    'criteria' => 'Defence service verification document',
                    'amount' => null,
                    'amount_label' => '5% Net Tuition Concession',
                    'percentage' => '5%',
                    'description' => '5% special scholarship granted on net tuition fees as tribute to national defence forces.',
                ],
                [
                    'name' => 'Graphic Era Alumni Continuing Concession',
                    'eligibility' => 'Graphic Era alumni pursuing Masters or Ph.D. degrees',
                    'criteria' => 'Valid GEU degree certificate and enrollment record',
                    'amount' => 64000.00,
                    'amount_label' => 'Up to ₹64,000 per Semester',
                    'percentage' => 'Up to 30%',
                    'description' => 'Dedicated scholarship for GEU graduates continuing higher education at their alma mater.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Admission Process',
                    'content' => 'Admissions to Graphic Era (Deemed to be University) are conducted through a transparent and merit-driven online application process.',
                    'items' => [
                        'Step 1: Fill out the online application form on the official university portal (geu.ac.in).',
                        'Step 2: Upload academic transcripts, photo identification, and relevant entrance exam scorecards (JEE Main / CUET / CAT / GATE).',
                        'Step 3: Review and pay the registration and processing fee through the secure online payment gateway.',
                        'Step 4: Participate in university counseling sessions and receive program allotment based on merit.',
                        'Step 5: Complete document verification, submit initial fee installment, and confirm admission.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required at Counseling',
                    'content' => 'Applicants must bring original copies and photocopies of the following credentials during physical verification:',
                    'items' => [
                        'Class 10th Marksheet and Passing Certificate (Date of Birth proof)',
                        'Class 12th Marksheet and Passing Certificate',
                        'Graduation Marksheets and Provisional Degree (for PG applicants)',
                        'Entrance Exam Scorecard (JEE Main / CUET / CAT / MAT / GATE / CLAT)',
                        'Transfer Certificate (TC) & Migration Certificate from last attended institution',
                        'Category / Caste Certificate (SC/ST/OBC/EWS) if applicable',
                        'Character Certificate issued by the Head of the previous institution',
                        'Passport size colored photographs (6 copies) and Government ID (Aadhaar Card)',
                    ],
                ],
            ],
        ];
    }

    /**
     * 2. IIMT University – Meerut, Uttar Pradesh
     *
     * @return array<string, mixed>
     */
    private function iimtCollege(): array
    {
        return [
            'name' => 'IIMT University',
            'short_name' => 'IIMT Meerut',
            'slug' => 'iimt-university-meerut',
            'type' => 'Private',
            'university' => 'IIMT University',
            'website' => 'https://www.iimtu.edu.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => '\'O\' Pocket, Ganga Nagar Colony, Mawana Road, Meerut, Uttar Pradesh - 250001',
            'year' => '2016',
            'campus' => '100+ Acres State-of-the-Art Green Campus',
            'approvals' => 'UGC (2f), AICTE, PCI, BCI, NCTE, INC, UP State Medical Faculty',
            'naac_grade' => 'B++',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'CUET-UG, CUET-PG, JEE Main, NEET, CAT, MAT, IIMTU-ET, Merit-Based',
            'rating' => 4.5,
            'reviews_count' => 890,
            'highest' => '₹33.50 LPA',
            'average' => '₹4.80 LPA',
            'top_recruiters' => 'Infosys, TCS, Wipro, Cognizant, Amazon, Paytm, Tech Mahindra, IBM, HCL, Concentrix, Tommy Hilfiger, HDFC Bank, Axis Bank',
            'is_featured' => true,
            'overview' => 'IIMT University, situated across an expansive 100+ acre lush green campus in Ganga Nagar, Meerut, is a renowned multi-faculty state private university established under UP State Act No. 32 of 2016 and recognized by the UGC under Section 2(f). Backed by the IIMT Group\'s illustrious 30-year educational legacy founded in 1994, the university offers over 140 comprehensive undergraduate, postgraduate, diploma, and doctoral programs across Engineering, Management, Pharmacy, Allied Medical Sciences, Law, Agriculture, Education, and Humanities. Notably, the campus houses the 800+ bed NABH-accredited IIMT Life Line Multi-Specialty Hospital, serving as an intensive clinical training facility for medical and nursing students. With state-of-the-art incubation cells, a modern central library with DELNET access, specialized robotics and AI centers, Olympic-standard sports arenas including an indoor shooting range, and an active Corporate Resource Centre driving over 300 recruitment drives annually with packages reaching ₹33.50 LPA, IIMT University stands as an educational landmark in Western Uttar Pradesh and Delhi-NCR.',
            'scholarship_info' => 'IIMT University extends extensive scholarship benefits including Merit Scholarships up to ₹50,000 for top scorers in qualifying examinations, Sports Scholarships for national and state level athletes, Defence Personnel Concessions of 5% on tuition fees, and complete facilitation for the Bihar Student Credit Card (MNSSBY) scheme and Uttar Pradesh Post-Matric Government Scholarships.',

            'courses' => [
                // 1. B.Tech CSE
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 135000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 300,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate (40% for SC/ST)',
                    'sem_fee' => 67500.00,
                ],
                // 2. B.Tech AI & ML
                [
                    'slug' => 'btech',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 135000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate (40% for SC/ST)',
                    'sem_fee' => 67500.00,
                ],
                // 3. B.Tech Cyber Security
                [
                    'slug' => 'btech',
                    'spec' => 'Cyber Security',
                    'fee' => 135000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate',
                    'sem_fee' => 67500.00,
                ],
                // 4. B.Tech Mechanical Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Mechanical Engineering',
                    'fee' => 85550.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 45% aggregate',
                    'sem_fee' => 42775.00,
                ],
                // 5. B.Tech Civil Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Civil Engineering',
                    'fee' => 85550.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 45% aggregate',
                    'sem_fee' => 42775.00,
                ],
                // 6. B.Tech Electrical & Electronics Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Electrical & Electronics Engineering',
                    'fee' => 85550.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 45% aggregate',
                    'sem_fee' => 42775.00,
                ],
                // 7. Polytechnic Diploma in Engineering
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Mechanical Engineering (Production)',
                    'fee' => 53550.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'JEECUP / 10th Board Merit',
                    'eligibility' => 'Class 10th Pass with Science and Mathematics min 35% marks',
                    'sem_fee' => 26775.00,
                ],
                // 8. Polytechnic Diploma in Civil Engineering
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Civil Engineering',
                    'fee' => 53550.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'JEECUP / 10th Board Merit',
                    'eligibility' => 'Class 10th Pass with Science and Mathematics min 35% marks',
                    'sem_fee' => 26775.00,
                ],
                // 9. M.Tech Computer Science & Engineering
                [
                    'slug' => 'mtech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 90000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 30,
                    'exam' => 'GATE / CUET-PG / Merit',
                    'eligibility' => 'B.Tech / B.E. in CSE / IT or MCA with min 50% marks',
                    'sem_fee' => 45000.00,
                ],
                // 10. MBA (Dual Specialization)
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 110000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 180,
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 45% aggregate marks (40% for SC/ST)',
                    'sem_fee' => 55000.00,
                ],
                // 11. MBA Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 110000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 45% aggregate marks',
                    'sem_fee' => 55000.00,
                ],
                // 12. BBA (Bachelor of Business Administration)
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 84550.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 240,
                    'exam' => 'CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 in any discipline with min 45% marks',
                    'sem_fee' => 42275.00,
                ],
                // 13. BCA (Bachelor of Computer Applications)
                [
                    'slug' => 'bca',
                    'spec' => 'General BCA / Core Computing',
                    'fee' => 89550.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 240,
                    'exam' => 'CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 with Mathematics or Computer Science / IT with min 45% marks',
                    'sem_fee' => 44775.00,
                ],
                // 14. MCA (Master of Computer Applications)
                [
                    'slug' => 'mca',
                    'spec' => 'General MCA / Software Engineering',
                    'fee' => 95000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / Merit',
                    'eligibility' => 'BCA / B.Sc (CS/IT) or Graduate with Maths at 10+2 level min 50%',
                    'sem_fee' => 47500.00,
                ],
                // 15. B.Pharm (Bachelor of Pharmacy)
                [
                    'slug' => 'bpharma',
                    'spec' => 'General Pharmacy Practice',
                    'fee' => 139000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 100,
                    'exam' => 'CUET-UG / 10+2 PCB/PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Mathematics min 45% aggregate',
                    'sem_fee' => 69500.00,
                ],
                // 16. D.Pharm (Diploma in Pharmacy)
                [
                    'slug' => 'dpharma',
                    'spec' => 'Diploma in Pharmacy Practice',
                    'fee' => 95000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'JEECUP / 10+2 PCB/PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Mathematics min 45% aggregate',
                    'sem_fee' => 47500.00,
                ],
                // 17. M.Pharm (Pharmaceutics)
                [
                    'slug' => 'mpharma',
                    'spec' => 'Pharmaceutics',
                    'fee' => 110000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 18,
                    'exam' => 'GPAT / CUET-PG / Merit',
                    'eligibility' => 'B.Pharm degree from a PCI-approved institution with min 55% marks',
                    'sem_fee' => 55000.00,
                ],
                // 18. B.Sc. Nursing
                [
                    'slug' => 'bsc-nursing',
                    'spec' => 'Clinical Nursing & Patient Care',
                    'fee' => 140000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'NEET / ABVMU UP State Common Nursing Entrance',
                    'eligibility' => '10+2 with Physics, Chemistry, Biology & English with min 45% aggregate',
                    'sem_fee' => 70000.00,
                ],
                // 19. GNM (General Nursing & Midwifery)
                [
                    'slug' => 'gnm',
                    'spec' => 'General Nursing & Midwifery Practice',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => '10+2 Board Merit',
                    'eligibility' => '10+2 with English and min 40% aggregate marks',
                    'sem_fee' => 42500.00,
                ],
                // 20. ANM
                [
                    'slug' => 'anm',
                    'spec' => 'Community Health & Maternal Child Care',
                    'fee' => 65000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 40,
                    'exam' => '10+2 Board Merit',
                    'eligibility' => '10+2 in any stream from recognized board with min 40% marks',
                    'sem_fee' => 32500.00,
                ],
                // 21. BPT (Physiotherapy)
                [
                    'slug' => 'bpt',
                    'spec' => 'Physiotherapy & Rehabilitation',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'duration' => '4.5 Years',
                    'seats' => 60,
                    'exam' => '10+2 PCB Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology with min 50% marks',
                    'sem_fee' => 42500.00,
                ],
                // 22. BMLT (Medical Lab Technology)
                [
                    'slug' => 'bmlt',
                    'spec' => 'Clinical Biochemistry & Microbiology',
                    'fee' => 75000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => '10+2 PCB Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology with min 50% marks',
                    'sem_fee' => 37500.00,
                ],
                // 23. B.Sc. (Hons) Agriculture
                [
                    'slug' => 'bsc-agri',
                    'spec' => 'Agronomy & Crop Science',
                    'fee' => 75000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'CUET-UG / 10+2 Science/Agri Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Maths/Agriculture min 45%',
                    'sem_fee' => 37500.00,
                ],
                // 24. B.A. LL.B (Hons)
                [
                    'slug' => 'ba-llb',
                    'spec' => 'Integrated Corporate & Criminal Law',
                    'fee' => 75000.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 120,
                    'exam' => 'CLAT / CUET / 10+2 Merit',
                    'eligibility' => '10+2 in any stream with min 45% aggregate marks (40% for SC/ST)',
                    'sem_fee' => 37500.00,
                ],
                // 25. BBA LL.B (Hons)
                [
                    'slug' => 'bba-llb',
                    'spec' => 'Corporate & Commercial Law',
                    'fee' => 75000.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 60,
                    'exam' => 'CLAT / CUET / 10+2 Merit',
                    'eligibility' => '10+2 in any stream with min 45% aggregate marks (40% for SC/ST)',
                    'sem_fee' => 37500.00,
                ],
                // 26. LL.B (Bachelor of Laws)
                [
                    'slug' => 'llb',
                    'spec' => 'General Law & Litigation',
                    'fee' => 60550.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'Graduation Merit',
                    'eligibility' => 'Graduation in any discipline with min 45% aggregate marks (40% for SC/ST)',
                    'sem_fee' => 30275.00,
                ],
                // 27. LL.M
                [
                    'slug' => 'llm',
                    'spec' => 'Corporate & Commercial Law',
                    'fee' => 65000.00,
                    'type' => 'per_year',
                    'duration' => '1 Year',
                    'seats' => 30,
                    'exam' => 'CLAT-PG / CUET-PG / Merit',
                    'eligibility' => 'LL.B or 5-Year Integrated Law Degree with min 50% marks',
                    'sem_fee' => 32500.00,
                ],
                // 28. B.Ed (Bachelor of Education)
                [
                    'slug' => 'bed',
                    'spec' => 'Secondary School Teacher Education',
                    'fee' => 55000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'UP B.Ed JEE / Merit',
                    'eligibility' => 'Graduation or Post Graduation in any stream with min 50% marks',
                    'sem_fee' => 27500.00,
                ],
                // 29. D.El.Ed (BTC)
                [
                    'slug' => 'deled',
                    'spec' => 'Elementary Primary Teacher Education',
                    'fee' => 45000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 50,
                    'exam' => 'State Counseling / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% marks',
                    'sem_fee' => 22500.00,
                ],
                // 30. B.Com (Hons.)
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'Accounting & Finance (Hons)',
                    'fee' => 55000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => '10+2 Commerce/Maths Merit',
                    'eligibility' => '10+2 with Commerce or Mathematics with min 45% marks',
                    'sem_fee' => 27500.00,
                ],
                // 31. BHM (Hotel Management)
                [
                    'slug' => 'bhm',
                    'spec' => 'Food & Beverage Service',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => '10+2 Merit',
                    'eligibility' => '10+2 in any stream with English as compulsory subject with min 45%',
                    'sem_fee' => 40000.00,
                ],
                // 32. B.A. (Journalism & Mass Comm)
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Journalism & News Anchoring',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => '10+2 Merit',
                    'eligibility' => '10+2 in any stream with min 45% marks',
                    'sem_fee' => 30000.00,
                ],
                // 33. B.Sc. Biotechnology
                [
                    'slug' => 'bsc-biotech',
                    'spec' => 'Biotechnology & Genetic Engineering',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => '10+2 PCB Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Maths with min 45% marks',
                    'sem_fee' => 25000.00,
                ],
                // 34. M.Sc. Biotechnology
                [
                    'slug' => 'msc-biotech',
                    'spec' => 'Molecular Biology & Genetic Engineering',
                    'fee' => 55000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 30,
                    'exam' => 'Graduation Merit',
                    'eligibility' => 'B.Sc in Biotechnology / Life Sciences with min 50% marks',
                    'sem_fee' => 27500.00,
                ],
                // 35. Ph.D.
                [
                    'slug' => 'phd',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 100000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 20,
                    'exam' => 'UGC-NET / CSIR-NET / IIMTU RET',
                    'eligibility' => 'Master\'s Degree in relevant field with min 55% aggregate marks',
                    'sem_fee' => 50000.00,
                ],
            ],

            'highlights' => [
                ['title' => '100+ Acre Mega Campus',          'value' => 'State-of-the-Art Wi-Fi Enabled Campus',      'icon' => 'bi-building-fill'],
                ['title' => 'In-House 800+ Bed Hospital',      'value' => 'NABH Accredited IIMT Life Line Hospital',    'icon' => 'bi-hospital-fill'],
                ['title' => 'Peak Placement Package',          'value' => '₹33.50 LPA Highest Placement Record',       'icon' => 'bi-trophy-fill'],
                ['title' => 'Statutory Approvals',             'value' => 'UGC, AICTE, PCI, BCI, NCTE, INC Approved',   'icon' => 'bi-shield-check'],
                ['title' => 'Industry Recruiters',             'value' => '300+ Corporates Visiting Annually',          'icon' => 'bi-briefcase-fill'],
                ['title' => 'Olympic Standard Sports',         'value' => '10-Meter Shooting Range & Cricket Arena',   'icon' => 'bi-bullseye'],
                ['title' => 'Bihar Student Credit Card',       'value' => 'Full Support for MNSSBY Scheme',             'icon' => 'bi-credit-card-2-front-fill'],
                ['title' => 'Incubation & Startup Hub',        'value' => 'MSME & UP Govt Recognized Startup Center',   'icon' => 'bi-rocket-takeoff-fill'],
            ],

            'facilities' => [
                ['name' => '800+ Bed IIMT Life Line Multi-Specialty Hospital', 'icon' => 'bi-hospital'],
                ['name' => 'Interactive Smart Classrooms with Audio-Visual Aid', 'icon' => 'bi-display'],
                ['name' => 'Advanced Robotics, AI & Cloud Computing Labs',       'icon' => 'bi-cpu'],
                ['name' => 'Central Air-Conditioned Library with DELNET Access',  'icon' => 'bi-book-half'],
                ['name' => 'Moot Court Hall for Clinical Legal Practice',        'icon' => 'bi-hammer'],
                ['name' => 'Separate Boys & Girls AC and Non-AC Hostels',         'icon' => 'bi-houses'],
                ['name' => 'Olympic Standard 10M Indoor Shooting Range',         'icon' => 'bi-bullseye'],
                ['name' => 'Full-Sized Cricket Stadium & Sports Complex',         'icon' => 'bi-trophy'],
                ['name' => 'Multi-Cuisine Cafeterias & Food Courts',             'icon' => 'bi-cup-hot'],
                ['name' => 'Comprehensive Fleet of University AC Buses',         'icon' => 'bi-bus-front'],
            ],

            'faqs' => [
                [
                    'q' => 'Is IIMT University recognized and approved by UGC and statutory bodies?',
                    'a' => 'Yes, IIMT University is a recognized state private university established under Uttar Pradesh Act No. 32 of 2016 and approved by the UGC under Section 2(f). It holds approvals from AICTE, PCI (Pharmacy), BCI (Law), NCTE (Education), INC (Nursing), and the UP State Medical Faculty.',
                ],
                [
                    'q' => 'What is the highest and average salary package offered at IIMT University?',
                    'a' => 'IIMT University students have secured highest packages up to ₹33.50 LPA, with average packages ranging between ₹4.50 LPA and ₹5.20 LPA across engineering, management, and pharmacy programs.',
                ],
                [
                    'q' => 'Does IIMT University provide practical hospital training for medical & nursing students?',
                    'a' => 'Yes, IIMT University has its own 800+ bed NABH-accredited multi-specialty teaching hospital, IIMT Life Line Hospital, on campus, providing hands-on clinical and internship exposure to nursing, pharmacy, and paramedical students.',
                ],
                [
                    'q' => 'Can students from Bihar and other states avail government scholarships at IIMT?',
                    'a' => 'Yes, IIMT University completely facilitates admissions under the Bihar Student Credit Card (MNSSBY) scheme and assists eligible UP and outstation students in securing government post-matric scholarships.',
                ],
                [
                    'q' => 'What are the hostel accommodations and mess charges at IIMT University Meerut?',
                    'a' => 'The university provides comfortable, secure, separate hostels for boys and girls with options of AC and non-AC rooms, Wi-Fi connectivity, hygienic multi-cuisine mess food, sports, gym, and 24x7 security.',
                ],
            ],

            'placement_stats' => [
                ['label' => 'Highest Package',            'value' => '₹33.50 LPA', 'year' => '2024'],
                ['label' => 'Average B.Tech CSE Package', 'value' => '₹5.50 LPA',  'year' => '2024'],
                ['label' => 'Average University Package', 'value' => '₹4.80 LPA',  'year' => '2024'],
                ['label' => 'Total Recruiters',           'value' => '300+',       'year' => '2024'],
                ['label' => 'Placement Percentage',       'value' => '90%+',       'year' => '2024'],
            ],

            'recruiters' => [
                'Infosys', 'TCS', 'Wipro', 'Cognizant', 'Amazon', 'Paytm',
                'Tech Mahindra', 'IBM', 'HCL', 'Concentrix', 'Tommy Hilfiger',
                'HDFC Bank', 'Axis Bank', 'L&T Infotech', 'Collabera',
            ],

            'scholarships' => [
                [
                    'name' => 'Merit Scholarship on Qualifying Marks',
                    'eligibility' => '>=90% in 10+2 / Qualifying Board Examination',
                    'criteria' => 'Merit percentage in qualifying board or entrance test',
                    'amount' => 50000.00,
                    'amount_label' => 'Up to ₹50,000 Tuition Waiver',
                    'percentage' => 'Up to 50%',
                    'description' => 'Concession provided on annual tuition fee for top academic performers.',
                ],
                [
                    'name' => 'Sports Excellence Scholarship',
                    'eligibility' => 'National and State Level sports medalists / participants',
                    'criteria' => 'Valid sports federation certification',
                    'amount' => null,
                    'amount_label' => 'Up to 50% Concession',
                    'percentage' => 'Up to 50%',
                    'description' => 'Promotes aspiring athletes across shooting, cricket, basketball, and athletics.',
                ],
                [
                    'name' => 'Defence & Police Personnel Wards Scholarship',
                    'eligibility' => 'Children of serving / retired armed forces and police personnel',
                    'criteria' => 'Defence ID verification',
                    'amount' => null,
                    'amount_label' => '5% Tuition Waiver',
                    'percentage' => '5%',
                    'description' => 'Honorary scholarship to support families of national defence forces.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Admission Process',
                    'content' => 'Admissions to IIMT University are straightforward, conducted online and offline via the central admissions office.',
                    'items' => [
                        'Step 1: Register on the university portal (www.iimtu.edu.in) or visit the university admission cell at Ganga Nagar, Meerut.',
                        'Step 2: Submit the application form along with academic credentials and required entrance test scores (JEE/NEET/CUET/IIMTU-ET).',
                        'Step 3: Document verification and counseling session by academic advisors.',
                        'Step 4: Issuance of admission offer letter and fee installment payment confirmation.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required at the Time of Admission',
                    'content' => 'Candidates must present original copies and photocopies of the following documents:',
                    'items' => [
                        '10th Marksheet and Passing Certificate',
                        '12th Marksheet and Passing Certificate',
                        'Graduation Marksheets and Degree Certificate (for PG courses)',
                        'Relevant Entrance Exam Scorecard (JEE Main / CUET / NEET / GPAT)',
                        'Transfer Certificate (TC) and Migration Certificate',
                        'Character Certificate from Head of previous institution',
                        'Caste / Category Certificate (if applying under SC/ST/OBC quota)',
                        'Aadhaar Card and 6 recent passport-size photographs',
                    ],
                ],
            ],
        ];
    }

    /**
     * 3. Bennett University (The Times Group) – Greater Noida, Uttar Pradesh
     *
     * @return array<string, mixed>
     */
    private function bennettCollege(): array
    {
        return [
            'name' => 'Bennett University',
            'short_name' => 'Bennett University Greater Noida',
            'slug' => 'bennett-university-greater-noida',
            'type' => 'Private',
            'university' => 'Bennett University',
            'website' => 'https://www.bennett.edu.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Greater Noida',
            'address' => 'Plot Nos 8-11, TechZone II, Greater Noida, Gautam Buddha Nagar, Uttar Pradesh - 201310',
            'year' => '2016',
            'campus' => '68 Acres World-Class High-Tech Campus',
            'approvals' => 'UGC, AICTE, BCI (Bar Council of India)',
            'naac_grade' => 'A',
            'ugc_approved' => true,
            'nirf_rank' => 'Top 50 Emerging Universities',
            'nirf_year' => '2024',
            'entrance_exams' => 'JEE Main, SAT, CUET-UG, CUET-PG, CAT, XAT, NMAT, CLAT, LSAT India, Merit-Based',
            'rating' => 4.7,
            'reviews_count' => 940,
            'highest' => '₹1.37 Crore (International) / ₹57.00 LPA (Domestic)',
            'average' => '₹11.10 LPA (B.Tech CSE) / ₹7.99 LPA (University Overall)',
            'top_recruiters' => 'Microsoft, Google, Amazon, Adobe, Meta, Cisco, Intel, Goldman Sachs, Deloitte, Morgan Stanley, HSBC, Media.net, Zomato, Swiggy, Capgemini, Cognizant, Times Internet, Wipro, TCS',
            'is_featured' => true,
            'overview' => 'Bennett University, established in 2016 by The Times Group (Bennett, Coleman & Co. Ltd.) under Uttar Pradesh Act No. 24 of 2016 and recognized by the UGC, is an elite private multidisciplinary university situated across a sprawling 68-acre state-of-the-art campus in TechZone II, Greater Noida. Renowned for its global curriculum designed in academic partnership with prestigious Ivy-League and world-class institutions like Georgia Tech (USA), Babson College (USA), Cornell Law School, and University of Missouri, Bennett University provides high-impact education across Engineering & Applied Sciences, Management, Law, Artificial Intelligence, Media & Liberal Arts, and Design. The university has set exceptional benchmarks in campus placements, clocking a highest international package of ₹1.37 Crore and domestic offers of ₹57 LPA, while boasting an enviable average CTC of ₹11.10 LPA for B.Tech Computer Science graduates. With supercomputing facilities, Apple iMac multimedia labs, international moot court arenas, CXO mentorship from Times Group leaders, and vibrant residential hostels, Bennett University offers an Ivy-League standard educational ecosystem in the Delhi-NCR region.',
            'scholarship_info' => 'Bennett University awards merit scholarships with up to 100% tuition fee waiver based on Class 12 board aggregate or JEE Main percentile (>=95%ile). Scholarships of up to 75% are available for CAT/XAT/NMAT toppers in MBA, and CLAT/LSAT scores in Law. An additional 10% tuition fee concession is extended to a single girl child, while wards of defence personnel receive a 5% waiver across all academic sessions.',

            'courses' => [
                // 1. B.Tech Computer Science & Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 395000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 480,
                    'exam' => 'JEE Main / SAT / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics as compulsory subjects with min 60% aggregate marks',
                    'sem_fee' => 197500.00,
                ],
                // 2. B.Tech CSE (AI & Machine Learning)
                [
                    'slug' => 'btech',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 395000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 180,
                    'exam' => 'JEE Main / SAT / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics with min 60% aggregate marks',
                    'sem_fee' => 197500.00,
                ],
                // 3. B.Tech CSE (Data Science)
                [
                    'slug' => 'btech',
                    'spec' => 'Data Science',
                    'fee' => 395000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / SAT / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics with min 60% aggregate marks',
                    'sem_fee' => 197500.00,
                ],
                // 4. B.Tech CSE (Cyber Security)
                [
                    'slug' => 'btech',
                    'spec' => 'Cyber Security',
                    'fee' => 395000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / SAT / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics and Mathematics with min 60% aggregate marks',
                    'sem_fee' => 197500.00,
                ],
                // 5. B.Tech Electronics & Communication Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Electronics & Communication Engineering',
                    'fee' => 360000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / SAT / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 60% aggregate',
                    'sem_fee' => 180000.00,
                ],
                // 6. B.Tech Biotechnology Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Biotechnology Engineering',
                    'fee' => 360000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / NEET / 10+2 PCM/PCB Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Mathematics with min 60% aggregate',
                    'sem_fee' => 180000.00,
                ],
                // 7. B.Tech Mechanical Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Mechanical Engineering',
                    'fee' => 350000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 60% aggregate',
                    'sem_fee' => 175000.00,
                ],
                // 8. M.Tech Computer Science & Engineering
                [
                    'slug' => 'mtech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 150000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 30,
                    'exam' => 'GATE / CUET-PG / Merit',
                    'eligibility' => 'B.Tech / B.E. in CSE / IT / MCA with min 50% aggregate marks',
                    'sem_fee' => 75000.00,
                ],
                // 9. MBA (Master of Business Administration)
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 625000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 180,
                    'exam' => 'CAT / XAT / NMAT / MAT / CMAT / GMAT / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate marks',
                    'sem_fee' => 312500.00,
                ],
                // 10. MBA Business Analytics & Big Data
                [
                    'slug' => 'mba',
                    'spec' => 'Business Analytics & Big Data',
                    'fee' => 625000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CAT / XAT / NMAT / GMAT / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% marks',
                    'sem_fee' => 312500.00,
                ],
                // 11. BBA (Bachelor of Business Administration)
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 295000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 240,
                    'exam' => 'SAT / CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 in any stream from a recognized board with min 60% aggregate marks',
                    'sem_fee' => 147500.00,
                ],
                // 12. BBA Business Analytics
                [
                    'slug' => 'bba',
                    'spec' => 'Business Analytics',
                    'fee' => 295000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'SAT / CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 in any stream with min 60% aggregate marks',
                    'sem_fee' => 147500.00,
                ],
                // 13. BCA (Bachelor of Computer Applications)
                [
                    'slug' => 'bca',
                    'spec' => 'General BCA / Core Computing',
                    'fee' => 185000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 180,
                    'exam' => 'CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 with Mathematics/Computer Science/IT with min 50% marks',
                    'sem_fee' => 92500.00,
                ],
                // 14. BCA AI & Data Science
                [
                    'slug' => 'bca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 195000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 with Mathematics/Computer Science/IT with min 50% marks',
                    'sem_fee' => 97500.00,
                ],
                // 15. MCA (Master of Computer Applications)
                [
                    'slug' => 'mca',
                    'spec' => 'General MCA / Software Engineering',
                    'fee' => 210000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / Merit',
                    'eligibility' => 'BCA / B.Sc (CS/IT) or Graduate with Maths min 50% marks',
                    'sem_fee' => 105000.00,
                ],
                // 16. B.A. LL.B (Hons)
                [
                    'slug' => 'ba-llb',
                    'spec' => 'Integrated Corporate & Criminal Law',
                    'fee' => 340000.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 120,
                    'exam' => 'CLAT / LSAT India / CUET / 10+2 Merit',
                    'eligibility' => '10+2 in any stream from recognized board with min 60% aggregate marks',
                    'sem_fee' => 170000.00,
                ],
                // 17. BBA LL.B (Hons)
                [
                    'slug' => 'bba-llb',
                    'spec' => 'Corporate & Commercial Law',
                    'fee' => 340000.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 120,
                    'exam' => 'CLAT / LSAT India / CUET / 10+2 Merit',
                    'eligibility' => '10+2 in any stream with min 60% aggregate marks',
                    'sem_fee' => 170000.00,
                ],
                // 18. LL.M
                [
                    'slug' => 'llm',
                    'spec' => 'Corporate & Commercial Law',
                    'fee' => 195000.00,
                    'type' => 'per_year',
                    'duration' => '1 Year',
                    'seats' => 30,
                    'exam' => 'CLAT-PG / LSAT India / CUET-PG / Merit',
                    'eligibility' => 'LL.B or equivalent degree from BCI-recognized university with min 50% marks',
                    'sem_fee' => 97500.00,
                ],
                // 19. B.A. (Journalism & Mass Communication)
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Journalism & News Anchoring',
                    'fee' => 315000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 in any stream with min 50% aggregate marks',
                    'sem_fee' => 157500.00,
                ],
                // 20. M.A. (Journalism & Mass Communication)
                [
                    'slug' => 'ma-jmc',
                    'spec' => 'Broadcast Journalism',
                    'fee' => 275000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 30,
                    'exam' => 'Graduation Merit',
                    'eligibility' => 'Graduation in any stream with min 50% aggregate marks',
                    'sem_fee' => 137500.00,
                ],
                // 21. B.Des (Design)
                [
                    'slug' => 'bdes',
                    'spec' => 'UX/UI & Digital Product Design',
                    'fee' => 395000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'UCEED / NID DAT / BU Design Aptitude Test',
                    'eligibility' => '10+2 in any stream with min 50% aggregate marks',
                    'sem_fee' => 197500.00,
                ],
                // 22. B.A. (Hons) Psychology
                [
                    'slug' => 'ba-hons',
                    'spec' => 'Psychology (Hons)',
                    'fee' => 295000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / 10+2 Merit',
                    'eligibility' => '10+2 in any stream from recognized board with min 50% marks',
                    'sem_fee' => 147500.00,
                ],
                // 23. Ph.D.
                [
                    'slug' => 'phd',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 120000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 20,
                    'exam' => 'UGC-NET / CSIR-NET / GATE / BU RET',
                    'eligibility' => 'Master\'s Degree in relevant field with min 55% marks or equivalent CGPA',
                    'sem_fee' => 60000.00,
                ],
            ],

            'highlights' => [
                ['title' => 'Backed by The Times Group',       'value' => 'Bennett, Coleman & Co. Ltd. Legacy',        'icon' => 'bi-newspaper'],
                ['title' => 'Record International Package',    'value' => '₹1.37 Crore International Highest CTC',      'icon' => 'bi-globe-americas'],
                ['title' => 'Domestic Peak Placement',        'value' => '₹57.00 LPA Domestic Highest Package',        'icon' => 'bi-trophy-fill'],
                ['title' => 'Average B.Tech Placement',        'value' => '₹11.10 LPA Average B.Tech CSE CTC',          'icon' => 'bi-graph-up-arrow'],
                ['title' => 'Global Academic Partnerships',   'value' => 'Georgia Tech, Babson & Cornell Law Linkages', 'icon' => 'bi-mortarboard-fill'],
                ['title' => '68-Acre World-Class Campus',     'value' => 'RSP Singapore Designed Hi-Tech Hub',         'icon' => 'bi-building-fill'],
                ['title' => 'Supercomputing & AI Lab',        'value' => 'NVIDIA DGX GPU AI Research Cluster',         'icon' => 'bi-cpu-fill'],
                ['title' => 'Times CXO Mentorship',           'value' => 'Direct Industry Mentoring & Media Access',   'icon' => 'bi-people-fill'],
            ],

            'facilities' => [
                ['name' => 'NVIDIA Supercomputing & GPU Deep Learning Center',  'icon' => 'bi-cpu'],
                ['name' => 'Smart Interactive Harvard-Style Lecture Theatres',  'icon' => 'bi-display'],
                ['name' => 'Apple Mac Multimedia & Digital TV Production Studio', 'icon' => 'bi-camera-reels'],
                ['name' => 'High-Court Standard Moot Court & Legal Research Lab', 'icon' => 'bi-hammer'],
                ['name' => 'Central Digital Library with Bloomberg Terminals',   'icon' => 'bi-book-half'],
                ['name' => 'Air-Conditioned Premium Hostels with En-Suite Baths', 'icon' => 'bi-houses'],
                ['name' => 'Olympic-Size Swimming Pool & Indoor Sports Complex', 'icon' => 'bi-trophy'],
                ['name' => 'Multi-Cuisine Cafeterias, Subway & Starbucks Kiosks', 'icon' => 'bi-cup-hot'],
                ['name' => '24x7 In-Campus Medical Hospital & Emergency Care',   'icon' => 'bi-hospital'],
                ['name' => 'Incubation Hub powered by Bennett Hatchery',        'icon' => 'bi-rocket-takeoff'],
            ],

            'faqs' => [
                [
                    'q' => 'Who founded Bennett University and what are its statutory recognitions?',
                    'a' => 'Bennett University was founded by The Times Group (Bennett, Coleman & Co. Ltd.) in 2016 through Uttar Pradesh Act No. 24 of 2016. It is fully recognized by the UGC under Section 2(f) and holds approvals from AICTE and the Bar Council of India (BCI).',
                ],
                [
                    'q' => 'What is the highest and average package offered at Bennett University?',
                    'a' => 'Bennett University holds an extraordinary placement record with a highest international package of ₹1.37 Crore and a domestic highest package of ₹57 LPA. The average salary package for B.Tech CSE stands at ₹11.10 LPA, while the overall university average is ₹7.99 LPA.',
                ],
                [
                    'q' => 'What international collaborations does Bennett University offer to students?',
                    'a' => 'Bennett University collaborates with top global institutions including Georgia Institute of Technology (USA) for Computer Science, Babson College (USA) for Entrepreneurship, Cornell Law School (USA) for Law, and the University of Missouri for Media Studies.',
                ],
                [
                    'q' => 'What are the scholarship criteria at Bennett University?',
                    'a' => 'Bennett University offers merit scholarships with up to 100% tuition fee waiver based on Class 12 board marks or JEE Main percentiles (>=95%ile). There is also a 10% concession for single girl children and a 5% waiver for wards of defence personnel.',
                ],
                [
                    'q' => 'Are hostel facilities mandatory at Bennett University Greater Noida?',
                    'a' => 'Bennett University is primarily a fully residential campus offering world-class air-conditioned hostels with twin and triple occupancy, modern amenities, Wi-Fi, laundry, nutritious dining, gym, and 24x7 security.',
                ],
            ],

            'placement_stats' => [
                ['label' => 'Highest International Package', 'value' => '₹1.37 Crore', 'year' => '2024'],
                ['label' => 'Highest Domestic Package',      'value' => '₹57.00 LPA',  'year' => '2024'],
                ['label' => 'Average B.Tech CSE Package',    'value' => '₹11.10 LPA',  'year' => '2024'],
                ['label' => 'Overall University Average',    'value' => '₹7.99 LPA',   'year' => '2024'],
                ['label' => 'Total Recruiter Companies',     'value' => '350+',        'year' => '2024'],
                ['label' => 'Placement Percentage',          'value' => '96%+',        'year' => '2024'],
            ],

            'recruiters' => [
                'Microsoft', 'Google', 'Amazon', 'Adobe', 'Meta', 'Cisco',
                'Intel', 'Goldman Sachs', 'Deloitte', 'Morgan Stanley', 'HSBC',
                'Media.net', 'Zomato', 'Swiggy', 'Capgemini', 'Cognizant',
                'Times Internet', 'Wipro', 'TCS',
            ],

            'scholarships' => [
                [
                    'name' => 'Academic Merit Scholarship (B.Tech / UG)',
                    'eligibility' => '>=95% in 12th Board OR >=95%ile in JEE Main / SAT >=1400',
                    'criteria' => 'Merit score in qualifying entrance exam or 12th boards',
                    'amount' => null,
                    'amount_label' => 'Up to 100% Tuition Waiver',
                    'percentage' => 'Up to 100%',
                    'description' => 'Premier scholarship covering up to 100% first-year tuition fee for exceptional achievers.',
                ],
                [
                    'name' => 'Single Girl Child Tuition Concession',
                    'eligibility' => 'Single girl child of the family admitted to any program',
                    'criteria' => 'Affidavit of single girl child status',
                    'amount' => null,
                    'amount_label' => '10% Additional Waiver',
                    'percentage' => '10%',
                    'description' => 'Special 10% fee waiver granted under Times Group women empowerment initiative.',
                ],
                [
                    'name' => 'Wards of Defence Personnel Scholarship',
                    'eligibility' => 'Children of serving / retired Indian Armed Forces personnel',
                    'criteria' => 'Service identity document verification',
                    'amount' => null,
                    'amount_label' => '5% Tuition Waiver',
                    'percentage' => '5%',
                    'description' => '5% annual tuition fee concession honoring national defence personnel.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Admission Process',
                    'content' => 'Admissions to Bennett University are conducted completely online via their centralized application portal.',
                    'items' => [
                        'Step 1: Complete online registration on the official admission portal (www.bennett.edu.in).',
                        'Step 2: Enter personal, academic, and competitive exam details (JEE Main / SAT / NEET / CAT / CLAT).',
                        'Step 3: Pay the application fee and submit verified digital transcripts.',
                        'Step 4: Receive provisional admission offer based on declared cutoffs and merit criteria.',
                        'Step 5: Pay the admission fee installment to block the seat and complete document verification.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required at Admission Verification',
                    'content' => 'Candidates must upload and present the following verified credentials:',
                    'items' => [
                        'Class 10th Marksheet & Passing Certificate',
                        'Class 12th Marksheet & Passing Certificate',
                        'Graduation Marksheets & Degree (for MBA / MCA / LLM / PhD applicants)',
                        'Scorecard of Competitive Exam (JEE Main / SAT / CLAT / CAT / NMAT)',
                        'Transfer / Migration Certificate from last attended institution',
                        'Aadhaar Card or Valid Government ID proof',
                        'Passport size photographs and digital signature',
                    ],
                ],
            ],
        ];
    }

    /**
     * 4. Metro University – Greater Noida, Uttar Pradesh
     *
     * @return array<string, mixed>
     */
    private function metroCollege(): array
    {
        return [
            'name' => 'Metro University',
            'short_name' => 'Metro University Greater Noida',
            'slug' => 'metro-university-greater-noida',
            'type' => 'Private',
            'university' => 'Metro University',
            'website' => 'https://metrouniversity.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Greater Noida',
            'address' => '12 A & 12 B, Techzone-IV, Greater Noida, Uttar Pradesh - 201318',
            'year' => '2026',
            'campus' => '25+ Acres Modern Hi-Tech Campus',
            'approvals' => 'UGC, Govt of Uttar Pradesh, PCI, INC, UP State Medical Faculty',
            'naac_grade' => null,
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'JEE Main, CUET-UG, CUET-PG, CAT, MAT, MUET, Merit-Based',
            'rating' => 4.5,
            'reviews_count' => 680,
            'highest' => '18.00 LPA',
            'average' => '5.20 LPA',
            'top_recruiters' => 'Metro Hospitals & Heart Institute, Apollo Hospitals, Fortis Healthcare, Max Healthcare, Infosys, Wipro, TCS, HCL Technologies, Cognizant, Tech Mahindra, ICICI Bank, HDFC Bank, Sun Pharma, Cipla, Mankind Pharma, Dr. Reddy\'s Laboratories',
            'is_featured' => true,

            'overview' => 'Metro University, located in Greater Noida, Uttar Pradesh, is a multidisciplinary private university established under the Uttar Pradesh Private Universities Act. Spearheaded by the renowned Metro Group (founded by Padma Vibhushan cardiologist Dr. Purshotam Lal), the university builds upon the distinguished legacy of the Metro Group of Hospitals and the Metro College of Health Sciences & Research. The university combines cutting-edge technical education in Engineering, AI, and Computing with premier clinical and healthcare training in Nursing, Pharmacy, and Allied Health Sciences. With ultra-modern laboratories, industry partnerships, hands-on clinical exposure in its own 1,000+ bed hospital network, and dedicated placement support, Metro University is committed to fostering academic excellence, research innovation, and career success.',

            'scholarship_info' => 'Metro University provides generous merit and welfare scholarships: (1) Metro Academic Excellence Scholarship offering up to 50% tuition waiver for high scorers in qualifying exams; (2) Healthcare Frontline & Corona Warriors Ward Scholarship with a 20% concession; (3) Sports & Cultural Champions Concession offering up to 25% waiver; (4) Girl Child Empowerment Scholarship granting a 15% annual tuition fee discount.',

            'highlights' => [
                ['title' => 'Healthcare Legacy', 'value' => 'Backed by Metro Group of Hospitals (Padma Vibhushan Dr. Purshotam Lal)', 'icon' => 'bi-heart-pulse-fill'],
                ['title' => 'Hospital Affiliation', 'value' => '1,000+ Bed Multi-Super Speciality Hospital Network for Clinical Training', 'icon' => 'bi-hospital-fill'],
                ['title' => 'Statutory Approvals', 'value' => 'Recognized by UGC, UP Govt, PCI, INC & UP State Medical Faculty', 'icon' => 'bi-shield-check'],
                ['title' => 'Strategic NCR Location', 'value' => 'Techzone-IV & Knowledge Park III, Greater Noida', 'icon' => 'bi-geo-alt-fill'],
                ['title' => 'Placement Track Record', 'value' => 'Highest ₹18 LPA | Average ₹5.20 LPA across Healthcare & IT', 'icon' => 'bi-briefcase-fill'],
                ['title' => 'Industry Curriculum', 'value' => 'Collaborative Labs with Leading Healthcare & Tech Giants', 'icon' => 'bi-laptop'],
                ['title' => 'Allied Health Leadership', 'value' => 'Premier Hub for B.Pharm, D.Pharm, B.Sc Nursing, GNM & BPT', 'icon' => 'bi-capsule'],
                ['title' => 'Merit Scholarships', 'value' => 'Up to 50% Tuition Fee Concessions for Deserving Students', 'icon' => 'bi-award-fill'],
            ],

            'facilities' => [
                ['name' => '1000+ Bed Hospital Affiliation', 'icon' => 'bi-hospital'],
                ['name' => 'AI, Robotics & Computing Labs', 'icon' => 'bi-cpu'],
                ['name' => 'Central Digital Library & Research Center', 'icon' => 'bi-book'],
                ['name' => 'Pharmaceutical & Pharmacognosy Labs', 'icon' => 'bi-capsule'],
                ['name' => 'AC Lecture Theatres & Smart Classrooms', 'icon' => 'bi-display'],
                ['name' => 'Separate Hostels for Boys & Girls', 'icon' => 'bi-building'],
                ['name' => 'Multi-Cuisine Cafeteria & Food Court', 'icon' => 'bi-cup-hot'],
                ['name' => 'Sports Complex & Gymnasium', 'icon' => 'bi-trophy'],
                ['name' => 'High-Speed Wi-Fi Campus', 'icon' => 'bi-wifi'],
                ['name' => '24x7 Campus Security & CCTV', 'icon' => 'bi-shield-lock'],
            ],

            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹18,00,000 / Per Annum', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹5,20,000 / Per Annum', 'year' => '2024'],
                ['label' => 'Median Package', 'value' => '₹4,80,000 / Per Annum', 'year' => '2024'],
                ['label' => 'Placement Rate', 'value' => '88% Across Professional Programs', 'year' => '2024'],
                ['label' => 'Partner Hospitals & Corporates', 'value' => '120+ Healthcare & Tech Recruiters', 'year' => '2024'],
                ['label' => 'Network Hospitals', 'value' => '12+ Metro Super Speciality Hospitals in Delhi NCR', 'year' => '2024'],
            ],

            'recruiters' => [
                'Metro Hospitals & Heart Institute', 'Apollo Hospitals', 'Fortis Healthcare', 'Max Healthcare',
                'Medanta The Medicity', 'Jaypee Hospital', 'Kailash Hospital', 'Sun Pharma',
                'Cipla', 'Mankind Pharma', 'Dr. Reddy\'s Laboratories', 'Lupin',
                'Infosys', 'TCS', 'Wipro', 'HCL Technologies',
                'Cognizant', 'Tech Mahindra', 'ICICI Bank', 'HDFC Bank',
            ],

            'scholarships' => [
                [
                    'name' => 'Metro Merit Excellence Scholarship',
                    'eligibility' => '>=90% in 12th Board examinations or high percentile in MUET/JEE/CUET',
                    'criteria' => 'Academic merit in qualifying board and entrance examinations',
                    'amount' => null,
                    'amount_label' => 'Up to 50% Tuition Waiver',
                    'percentage' => 'Up to 50%',
                    'description' => 'Awarded to students scoring 90% and above aggregate in Class 12th or equivalent qualifying board examinations.',
                ],
                [
                    'name' => 'Healthcare Frontline & Corona Warriors Ward Scholarship',
                    'eligibility' => 'Wards of registered healthcare professionals, doctors, nurses, and paramedical staff',
                    'criteria' => 'Proof of employment in registered hospital/healthcare sector',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Dedicated welfare scholarship honoring children of doctors, nurses, paramedics, and healthcare workers.',
                ],
                [
                    'name' => 'Girl Child Empowerment Scholarship',
                    'eligibility' => 'Female candidates applying for any undergraduate or postgraduate degree program',
                    'criteria' => 'Merit and enrollment confirmation',
                    'amount' => null,
                    'amount_label' => '15% Annual Tuition Waiver',
                    'percentage' => '15%',
                    'description' => 'Offered to female candidates across undergraduate and postgraduate technical and allied health programs.',
                ],
                [
                    'name' => 'Sports & Cultural Champions Award',
                    'eligibility' => 'State or National level medal winners / participants in recognized federations',
                    'criteria' => 'Sports quota trial and certificate verification',
                    'amount' => null,
                    'amount_label' => 'Up to 25% Tuition Waiver',
                    'percentage' => 'Up to 25%',
                    'description' => 'Granted to national and state medal winners in recognized sports competitions and cultural events.',
                ],
            ],

            'faqs' => [
                [
                    'q' => 'Is Metro University recognized by UGC and state authorities?',
                    'a' => 'Yes, Metro University is established under the Uttar Pradesh Private Universities Act and recognized by the University Grants Commission (UGC). Its healthcare and pharmacy programs are approved by the Pharmacy Council of India (PCI), Indian Nursing Council (INC), and UP State Medical Faculty.',
                ],
                [
                    'q' => 'What is the clinical training advantage at Metro University?',
                    'a' => 'Students benefit from direct, hands-on clinical rotations and internships across the Metro Group of Hospitals network, featuring over 1,000+ beds and cutting-edge super-speciality departments across Delhi NCR.',
                ],
                [
                    'q' => 'What courses are offered at Metro University?',
                    'a' => 'Metro University offers comprehensive programs across Engineering (B.Tech in CSE, AI & ML, Cyber Security, Data Science), Management (BBA, MBA), Computer Applications (BCA, MCA), Commerce (B.Com Hons), Media (BA-JMC, MA-JMC), and Healthcare (B.Pharm, D.Pharm, B.Sc Nursing, GNM, ANM, BPT, BMLT).',
                ],
                [
                    'q' => 'What are the highest and average placement packages?',
                    'a' => 'The highest recorded package is ₹18 LPA, with an overall average package of ₹5.20 LPA across healthcare, pharmaceutical, IT, and corporate management recruitment drives.',
                ],
                [
                    'q' => 'What is the admission procedure for Metro University?',
                    'a' => 'Admissions are conducted through national entrance tests (JEE Main, CUET, CAT, MAT) or the Metro University Entrance Test (MUET) and qualifying examination merit, followed by counseling and document verification.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Admission Process',
                    'content' => 'Admissions at Metro University are conducted through online and on-campus counseling channels.',
                    'items' => [
                        'Step 1: Visit the official portal (www.metrouniversity.in) or visit the Greater Noida campus admissions office.',
                        'Step 2: Fill out the application form with personal, educational, and qualifying entrance exam details (JEE / CUET / MUET / Merit).',
                        'Step 3: Upload or present original academic transcripts and identity documentation.',
                        'Step 4: Attend the counseling and personal interview session (if applicable for professional/healthcare programs).',
                        'Step 5: Receive the provisional admission letter, submit the first installment fee, and confirm your seat.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required at Admission Verification',
                    'content' => 'Candidates must present original and self-attested photocopies of the following credentials:',
                    'items' => [
                        'Class 10th Marksheet & Certificate (proof of date of birth)',
                        'Class 12th Marksheet & Passing Certificate',
                        'Graduation Marksheets & Degree Certificate (for PG applicants)',
                        'Entrance Exam Scorecard (JEE Main / CUET / CAT / MAT / MUET)',
                        'Transfer Certificate (TC) & Migration Certificate',
                        'Character Certificate from Head of Institution last attended',
                        'Aadhaar Card or Government Photo Identity Card',
                        'Medical Fitness Certificate from registered practitioner',
                        'Recent passport size photographs (6 copies)',
                    ],
                ],
            ],

            'courses' => [
                // 1. B.Tech Computer Science & Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 165100,
                    'sem_fee' => 82550,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 60% aggregate; valid JEE Main / CUET / MUET score.',
                    'exam' => 'JEE Main / CUET / MUET / Merit',
                    'seats' => 120,
                ],
                // 2. B.Tech Artificial Intelligence & Machine Learning
                [
                    'slug' => 'btech',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 165100,
                    'sem_fee' => 82550,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 60% aggregate; valid JEE Main / CUET / MUET score.',
                    'exam' => 'JEE Main / CUET / MUET / Merit',
                    'seats' => 60,
                ],
                // 3. B.Tech Data Science
                [
                    'slug' => 'btech',
                    'spec' => 'Data Science',
                    'fee' => 165100,
                    'sem_fee' => 82550,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 60% aggregate; valid JEE Main / CUET / MUET score.',
                    'exam' => 'JEE Main / CUET / MUET / Merit',
                    'seats' => 60,
                ],
                // 4. B.Tech Cyber Security
                [
                    'slug' => 'btech',
                    'spec' => 'Cyber Security',
                    'fee' => 165100,
                    'sem_fee' => 82550,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 60% aggregate; valid JEE Main / CUET / MUET score.',
                    'exam' => 'JEE Main / CUET / MUET / Merit',
                    'seats' => 60,
                ],
                // 5. BCA
                [
                    'slug' => 'bca',
                    'spec' => 'General BCA / Core Computing',
                    'fee' => 105200,
                    'sem_fee' => 52600,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream with Mathematics or Computer Science as a subject with min 55% aggregate.',
                    'exam' => 'CUET / MUET / Merit',
                    'seats' => 60,
                ],
                // 6. BCA - AI & ML
                [
                    'slug' => 'bca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 105200,
                    'sem_fee' => 52600,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 with Mathematics/CS with min 55% aggregate.',
                    'exam' => 'CUET / MUET / Merit',
                    'seats' => 60,
                ],
                // 7. MCA
                [
                    'slug' => 'mca',
                    'spec' => 'General MCA / Software Engineering',
                    'fee' => 113550,
                    'sem_fee' => 56775,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'BCA / B.Sc. (CS/IT) / B.Com / B.A. with Mathematics at 10+2 or Graduation level with min 50% aggregate.',
                    'exam' => 'CUET-PG / MUET / Merit',
                    'seats' => 60,
                ],
                // 8. BBA
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 115200,
                    'sem_fee' => 57600,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream from a recognized board with min 50% aggregate.',
                    'exam' => 'CUET / MUET / Merit',
                    'seats' => 120,
                ],
                // 9. BBA - Marketing Management
                [
                    'slug' => 'bba',
                    'spec' => 'Marketing Management',
                    'fee' => 115200,
                    'sem_fee' => 57600,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream with min 50% aggregate.',
                    'exam' => 'CUET / MUET / Merit',
                    'seats' => 60,
                ],
                // 10. MBA - Hospital & Healthcare Management
                [
                    'slug' => 'mba',
                    'spec' => 'Hospital & Healthcare Management',
                    'fee' => 168550,
                    'sem_fee' => 84275,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'Graduation in any discipline / MBBS / BDS / B.Pharm / B.Sc. Nursing with min 50% aggregate.',
                    'exam' => 'CAT / MAT / CMAT / MUET / Merit',
                    'seats' => 60,
                ],
                // 11. MBA - Marketing
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 168550,
                    'sem_fee' => 84275,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'Graduation in any stream with min 50% aggregate.',
                    'exam' => 'CAT / MAT / CMAT / MUET / Merit',
                    'seats' => 60,
                ],
                // 12. B.Com (Hons.)
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'Accounting & Finance (Hons)',
                    'fee' => 100200,
                    'sem_fee' => 50100,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in Commerce/Science stream with min 50% aggregate.',
                    'exam' => 'CUET / MUET / Merit',
                    'seats' => 60,
                ],
                // 13. B.A. (Journalism & Mass Communication)
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Digital Media, VFX & Content Creation',
                    'fee' => 82366,
                    'sem_fee' => 41183,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream from a recognized board with min 45% aggregate.',
                    'exam' => 'CUET / MUET / Merit',
                    'seats' => 60,
                ],
                // 14. M.A. (Journalism & Mass Communication)
                [
                    'slug' => 'ma-jmc',
                    'spec' => 'Digital Media & New Trends',
                    'fee' => 90000,
                    'sem_fee' => 45000,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'Bachelor degree in any discipline with min 45% aggregate.',
                    'exam' => 'CUET-PG / MUET / Merit',
                    'seats' => 40,
                ],
                // 15. B.Pharm (Bachelor of Pharmacy)
                [
                    'slug' => 'bpharma',
                    'spec' => 'General Pharmacy Practice',
                    'fee' => 80500,
                    'sem_fee' => 40250,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Mathematics with min 50% aggregate; approved by PCI.',
                    'exam' => 'CUET / State Entrance / Merit',
                    'seats' => 100,
                ],
                // 16. D.Pharm (Diploma in Pharmacy)
                [
                    'slug' => 'dpharma',
                    'spec' => 'Diploma in Pharmacy Practice',
                    'fee' => 65000,
                    'sem_fee' => 32500,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Mathematics with min 45% aggregate; approved by PCI.',
                    'exam' => 'Merit / JEECUP / MUET',
                    'seats' => 60,
                ],
                // 17. B.Sc. Nursing
                [
                    'slug' => 'bsc-nursing',
                    'spec' => 'Clinical Nursing & Patient Care',
                    'fee' => 102000,
                    'sem_fee' => 51000,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry, Biology and English with min 45% aggregate; approved by INC.',
                    'exam' => 'State Nursing Entrance / CUET / Merit',
                    'seats' => 60,
                ],
                // 18. GNM
                [
                    'slug' => 'gnm',
                    'spec' => 'General Nursing & Midwifery Practice',
                    'fee' => 73000,
                    'sem_fee' => 36500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream (Science preferred) with min 40% aggregate; approved by INC & State Medical Faculty.',
                    'exam' => 'Merit / Counseling',
                    'seats' => 60,
                ],
                // 19. ANM
                [
                    'slug' => 'anm',
                    'spec' => 'Community Health & Maternal Child Care',
                    'fee' => 65000,
                    'sem_fee' => 32500,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => '10+2 in any stream with min 40% aggregate (females only as per INC guidelines).',
                    'exam' => 'Merit / Counseling',
                    'seats' => 40,
                ],
                // 20. BPT (Physiotherapy)
                [
                    'slug' => 'bpt',
                    'spec' => 'Orthopaedic Physiotherapy',
                    'fee' => 80000,
                    'sem_fee' => 40000,
                    'type' => 'per_year',
                    'duration' => '4.5 Years (Incl. 6 Months Internship)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology with min 50% aggregate.',
                    'exam' => 'CUET / MUET / Merit',
                    'seats' => 60,
                ],
                // 21. BMLT (Medical Lab Technology)
                [
                    'slug' => 'bmlt',
                    'spec' => 'Clinical Biochemistry & Microbiology',
                    'fee' => 75000,
                    'sem_fee' => 37500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology with min 45% aggregate.',
                    'exam' => 'CUET / MUET / Merit',
                ],
            ],
        ];
    }

    /**
     * 5. Dr. K.N. Modi University – Modinagar (Ghaziabad, UP) / Newai (Rajasthan)
     *
     * @return array<string, mixed>
     */
    private function knModiCollege(): array
    {
        return [
            'name' => 'Dr. K.N. Modi University',
            'short_name' => 'DKNMU Modinagar',
            'slug' => 'dr-k-n-modi-university-modinagar',
            'type' => 'Private',
            'university' => 'Dr. K.N. Modi University',
            'website' => 'https://dknmu.org',
            'state' => 'Uttar Pradesh',
            'city' => 'Ghaziabad',
            'address' => 'Delhi-Meerut Road, Modinagar, Ghaziabad, Uttar Pradesh - 201204',
            'year' => '2010',
            'campus' => '45+ Acres Sprawling Eco-Friendly Campus',
            'approvals' => 'UGC, AICTE, BCI, PCI, COA, AIU',
            'naac_grade' => null,
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'JEE Main, CUET-UG, CUET-PG, CAT, MAT, CLAT, Merit-Based',
            'rating' => 4.4,
            'reviews_count' => 540,
            'highest' => '12.00 LPA',
            'average' => '4.20 LPA',
            'top_recruiters' => 'TCS, Infosys, Wipro, Tech Mahindra, HCL Technologies, Capgemini, L&T Infotech, Genpact, ICICI Bank, HDFC Bank, Axis Bank, Sun Pharma, Cipla, Mankind Pharma, Dabur, Mother Dairy, Mahindra & Mahindra, Escorts, Tata Motors, Reliance Jio',
            'is_featured' => true,

            'overview' => 'Dr. K.N. Modi University (DKNMU), established by Rajasthan State Legislature Act No. 8 of 2010 and managed by the venerable Dr. K.N. Modi Foundation (founded in 1942 by Padma Bhushan Rai Bahadur Dr. K.N. Modi), is a multidisciplinary private university committed to accessible, job-oriented education. Operating its primary 45-acre residential campus alongside its prominent NCR campus on Delhi-Meerut Road in Modinagar (Ghaziabad, UP), DKNMU offers accredited programs in Engineering & Technology, Management, Computer Applications, Legal Studies, Pharmaceutical Sciences, Nursing, Agriculture, and Doctoral Research. Recognized by UGC, AICTE, BCI, PCI, and COA, the university emphasizes practical knowledge, ethical leadership, industry internships, and value-based holistic development for students across North India.',

            'scholarship_info' => 'Dr. K.N. Modi University offers extensive financial assistance: (1) Dr. K.N. Modi Memorial Merit Scholarship offering up to 50% tuition waiver for top academic performers; (2) Beti Bachao Beti Padhao Girl Child Scholarship offering a 20% concession; (3) Defence & Armed Forces Ward Concession offering 20% waiver; (4) Sibling & Alumni Concession with a 15% discount.',

            'highlights' => [
                ['title' => 'Academic Legacy', 'value' => '80+ Years Heritage under Dr. K.N. Modi Foundation (Est. 1942)', 'icon' => 'bi-award-fill'],
                ['title' => 'Statutory Approvals', 'value' => 'Recognized by UGC, AICTE, BCI, PCI, COA & Member of AIU', 'icon' => 'bi-shield-check'],
                ['title' => 'Dual Campus Advantage', 'value' => 'Modinagar (NCR, Ghaziabad) & 45-Acre Sprawling Newai Campus', 'icon' => 'bi-geo-alt-fill'],
                ['title' => 'Affordable Excellence', 'value' => 'High ROI Quality Education with Transparent Fee Structure', 'icon' => 'bi-cash-coin'],
                ['title' => 'Corporate Connect', 'value' => '150+ Recruiters | 45,000+ Global Alumni Network', 'icon' => 'bi-briefcase-fill'],
                ['title' => 'Legal & Pharma Hub', 'value' => 'BCI-Approved Moot Court Law School & PCI-Approved Pharmacy', 'icon' => 'bi-bank2'],
                ['title' => 'Agriculture Research', 'value' => 'Dedicated Agricultural Farms & Polyhouses for Hands-on Agronomy', 'icon' => 'bi-tree-fill'],
                ['title' => 'Merit Scholarships', 'value' => 'Up to 50% Tuition Fee Waivers for Deserving Candidates', 'icon' => 'bi-patch-check-fill'],
            ],

            'facilities' => [
                ['name' => 'Central Digital Library & Book Bank', 'icon' => 'bi-book'],
                ['name' => 'Advanced AI, Robotics & CAD/CAM Labs', 'icon' => 'bi-cpu'],
                ['name' => 'BCI Approved Moot Court Hall', 'icon' => 'bi-bank2'],
                ['name' => 'Pharmaceutical Analysis & Pharmacognosy Labs', 'icon' => 'bi-capsule'],
                ['name' => 'Agriculture Research Farm & Polyhouses', 'icon' => 'bi-tree'],
                ['name' => 'Separate Boys & Girls Hostels (AC/Non-AC)', 'icon' => 'bi-building'],
                ['name' => 'Multi-Cuisine Cafeteria & Student Mess', 'icon' => 'bi-cup-hot'],
                ['name' => 'Sports Complex, Cricket & Badminton Grounds', 'icon' => 'bi-trophy'],
                ['name' => 'High-Speed Wi-Fi Campus & 24x7 Security', 'icon' => 'bi-wifi'],
                ['name' => 'Campus Health Center & Ambulance Support', 'icon' => 'bi-heart-pulse'],
            ],

            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹12,00,000 / Per Annum', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹4,20,000 / Per Annum', 'year' => '2024'],
                ['label' => 'Median Package', 'value' => '₹3,80,000 / Per Annum', 'year' => '2024'],
                ['label' => 'Placement Rate', 'value' => '85% Across Professional Streams', 'year' => '2024'],
                ['label' => 'Corporate Recruiters', 'value' => '150+ Companies Visited', 'year' => '2024'],
                ['label' => 'Alumni Network', 'value' => '45,000+ Alumni Worldwide', 'year' => '2024'],
            ],

            'recruiters' => [
                'TCS', 'Infosys', 'Wipro', 'Tech Mahindra',
                'HCL Technologies', 'Capgemini', 'L&T Infotech', 'Genpact',
                'ICICI Bank', 'HDFC Bank', 'Axis Bank', 'Sun Pharma',
                'Cipla', 'Mankind Pharma', 'Dabur', 'Mother Dairy',
                'Mahindra & Mahindra', 'Escorts', 'Tata Motors', 'Reliance Jio',
            ],

            'scholarships' => [
                [
                    'name' => 'Dr. K.N. Modi Memorial Merit Scholarship',
                    'eligibility' => '>=90% marks in 12th Board or Graduation aggregate',
                    'criteria' => 'Academic merit in qualifying examinations',
                    'amount' => null,
                    'amount_label' => 'Up to 50% Tuition Waiver',
                    'percentage' => 'Up to 50%',
                    'description' => 'Flagship scholarship offering up to 50% tuition fee waiver for top academic achievers.',
                ],
                [
                    'name' => 'Beti Bachao Beti Padhao Girl Child Scholarship',
                    'eligibility' => 'All female candidates enrolled across degree programs',
                    'criteria' => 'Direct enrollment incentive promoting women education',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Dedicated 20% annual tuition fee concession encouraging female education in technical fields.',
                ],
                [
                    'name' => 'Wards of Defence & Paramilitary Personnel Scholarship',
                    'eligibility' => 'Children of serving / retired Indian Armed Forces & Police personnel',
                    'criteria' => 'Defence identity verification certificate',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Waiver',
                    'percentage' => '20%',
                    'description' => 'Special 20% concession recognizing national service rendered by defence personnel.',
                ],
                [
                    'name' => 'Sibling & Alumni Ward Concession',
                    'eligibility' => 'Real brothers/sisters studying concurrently or wards of DKNMU alumni',
                    'criteria' => 'Proof of sibling relation or alumni registration',
                    'amount' => null,
                    'amount_label' => '15% Tuition Concession',
                    'percentage' => '15%',
                    'description' => '15% concession granted to siblings or children of Foundation alumni.',
                ],
            ],

            'faqs' => [
                [
                    'q' => 'Is Dr. K.N. Modi University recognized by UGC and statutory councils?',
                    'a' => 'Yes, Dr. K.N. Modi University is established under Rajasthan State Legislature Act No. 8 of 2010 and recognized by UGC under Section 2(f). Its programs are approved by AICTE, Bar Council of India (BCI), Pharmacy Council of India (PCI), and Council of Architecture (COA).',
                ],
                [
                    'q' => 'What is the relationship between the Modinagar and Newai campuses?',
                    'a' => 'The university was established by the Dr. K.N. Modi Foundation, which has operated in Modinagar (Ghaziabad, UP) since 1942. It runs its primary residential campus in Newai, Rajasthan alongside the NCR campus at Modinagar, providing accessible admissions, counseling, and training facilities.',
                ],
                [
                    'q' => 'What is the fee structure for B.Tech and Professional courses?',
                    'a' => 'B.Tech in Computer Science and emerging technologies has an affordable tuition fee of ₹85,000 per year (₹42,500/semester), with conventional branches like Mechanical and Civil at ₹70,000 per year. Polytechnic diplomas start at ₹35,000 per year.',
                ],
                [
                    'q' => 'What are the placement opportunities at Dr. K.N. Modi University?',
                    'a' => 'DKNMU has an 85% placement track record with the highest package reaching ₹12 LPA and average packages around ₹4.20 LPA, with recruiters including TCS, Infosys, Wipro, HCL, Sun Pharma, Cipla, and ICICI Bank.',
                ],
                [
                    'q' => 'What is the admission procedure for DKNMU courses?',
                    'a' => 'Admissions are conducted through national exams like JEE Main, CUET, CAT, CLAT, or the university merit-based evaluation and personal counseling process.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Admission Process',
                    'content' => 'Admissions at Dr. K.N. Modi University are conducted through online and on-campus counseling channels.',
                    'items' => [
                        'Step 1: Apply online through the official portal (www.dknmu.org / www.dknmuncr.edu.in) or visit the Modinagar NCR admission office.',
                        'Step 2: Submit academic qualification details along with national entrance exam scores (JEE Main / CUET / CAT / CLAT) or register for merit evaluation.',
                        'Step 3: Upload scanned copies of required academic certificates and photo identification.',
                        'Step 4: Participate in the admission counseling and personal interview session.',
                        'Step 5: Accept the provisional offer of admission and deposit the initial semester fee to confirm the seat.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required at Admission Verification',
                    'content' => 'Applicants must present the following credentials during enrollment verification:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (for age proof)',
                        'Class 12th Marksheet & Passing Certificate',
                        'Graduation Marksheets & Degree (for PG / LLM / MBA / MCA candidates)',
                        'National / State Entrance Exam Scorecard (if applicable)',
                        'Transfer Certificate (TC) & Migration Certificate',
                        'Aadhaar Card or Valid Photo Identity Proof',
                        'Recent Passport Size Photographs (5 copies)',
                        'Category / Income Certificate (for scholarship applicants)',
                    ],
                ],
            ],

            'courses' => [
                // 1. B.Tech Computer Science & Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 85000,
                    'sem_fee' => 42500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics and Mathematics along with Chemistry/CS with min 45% aggregate (40% for reserved categories).',
                    'exam' => 'JEE Main / CUET / Merit',
                    'seats' => 120,
                ],
                // 2. B.Tech Artificial Intelligence & Machine Learning
                [
                    'slug' => 'btech',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 85000,
                    'sem_fee' => 42500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 45% aggregate; JEE Main / CUET score preferred.',
                    'exam' => 'JEE Main / CUET / Merit',
                    'seats' => 60,
                ],
                // 3. B.Tech Data Science
                [
                    'slug' => 'btech',
                    'spec' => 'Data Science',
                    'fee' => 85000,
                    'sem_fee' => 42500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 45% aggregate.',
                    'exam' => 'JEE Main / CUET / Merit',
                    'seats' => 60,
                ],
                // 4. B.Tech Cyber Security
                [
                    'slug' => 'btech',
                    'spec' => 'Cyber Security',
                    'fee' => 85000,
                    'sem_fee' => 42500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 45% aggregate.',
                    'exam' => 'JEE Main / CUET / Merit',
                    'seats' => 60,
                ],
                // 5. B.Tech Mechanical Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Mechanical Engineering',
                    'fee' => 70000,
                    'sem_fee' => 35000,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 45% aggregate.',
                    'exam' => 'JEE Main / Merit',
                    'seats' => 60,
                ],
                // 6. B.Tech Civil Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Civil Engineering',
                    'fee' => 70000,
                    'sem_fee' => 35000,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 45% aggregate.',
                    'exam' => 'JEE Main / Merit',
                    'seats' => 60,
                ],
                // 7. M.Tech Computer Science & Engineering
                [
                    'slug' => 'mtech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 60000,
                    'sem_fee' => 30000,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'B.Tech / B.E. in relevant discipline with min 50% marks; GATE / CUET-PG score preferred.',
                    'exam' => 'GATE / CUET-PG / Merit',
                    'seats' => 30,
                ],
                // 8. Diploma in Engineering (Polytechnic) - Civil Engineering
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Civil Engineering',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => 'Class 10th passed with Science & Mathematics with min 35% marks.',
                    'exam' => 'State Polytechnic Exam / Merit',
                    'seats' => 60,
                ],
                // 9. Diploma in Engineering (Polytechnic) - Computer Science
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => 'Class 10th passed with Science & Mathematics with min 35% marks.',
                    'exam' => 'State Polytechnic Exam / Merit',
                    'seats' => 60,
                ],
                // 10. Diploma in Engineering (Polytechnic) - Mechanical Engineering
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Mechanical Engineering (Production)',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => 'Class 10th passed with Science & Mathematics with min 35% marks.',
                    'exam' => 'State Polytechnic Exam / Merit',
                    'seats' => 60,
                ],
                // 11. Diploma in Engineering (Polytechnic) - Electrical Engineering
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Electrical Engineering',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => 'Class 10th passed with Science & Mathematics with min 35% marks.',
                    'exam' => 'State Polytechnic Exam / Merit',
                    'seats' => 60,
                ],
                // 12. BCA
                [
                    'slug' => 'bca',
                    'spec' => 'General BCA / Core Computing',
                    'fee' => 51000,
                    'sem_fee' => 25500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream with Mathematics or Computer Application with min 45% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 60,
                ],
                // 13. MCA
                [
                    'slug' => 'mca',
                    'spec' => 'General MCA / Software Engineering',
                    'fee' => 60000,
                    'sem_fee' => 30000,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'BCA / B.Sc (CS/IT) / Graduate with Mathematics at 10+2 or Graduation with min 50% aggregate.',
                    'exam' => 'CUET-PG / Merit',
                    'seats' => 60,
                ],
                // 14. BBA
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 51000,
                    'sem_fee' => 25500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any discipline from a recognized board with min 45% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 60,
                ],
                // 15. MBA - Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 80000,
                    'sem_fee' => 40000,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'Graduation in any discipline with min 50% marks (45% for SC/ST); CAT / MAT / CMAT preferred.',
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Merit',
                    'seats' => 60,
                ],
                // 16. MBA - Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 80000,
                    'sem_fee' => 40000,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'Graduation in any discipline with min 50% marks.',
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Merit',
                    'seats' => 60,
                ],
                // 17. B.Com (Hons.)
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'Accounting & Finance (Hons)',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in Commerce or Science stream with min 45% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 60,
                ],
                // 18. B.Pharm (Bachelor of Pharmacy)
                [
                    'slug' => 'bpharma',
                    'spec' => 'General Pharmacy Practice',
                    'fee' => 92000,
                    'sem_fee' => 46000,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Maths with min 50% aggregate; approved by PCI.',
                    'exam' => 'CUET / State Entrance / Merit',
                    'seats' => 100,
                ],
                // 19. D.Pharm (Diploma in Pharmacy)
                [
                    'slug' => 'dpharma',
                    'spec' => 'Diploma in Pharmacy Practice',
                    'fee' => 65000,
                    'sem_fee' => 32500,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Maths with min 45% aggregate; approved by PCI.',
                    'exam' => 'Merit / State Counseling',
                    'seats' => 60,
                ],
                // 20. B.Sc. (Hons) Agriculture
                [
                    'slug' => 'bsc-agri',
                    'spec' => 'Agronomy & Organic Farming',
                    'fee' => 60000,
                    'sem_fee' => 30000,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCB / PCM / Agriculture with min 50% aggregate.',
                    'exam' => 'CUET / State Ag. Test / Merit',
                    'seats' => 60,
                ],
                // 21. B.Sc. Biotechnology
                [
                    'slug' => 'bsc-biotech',
                    'spec' => 'Biotechnology & Genetic Engineering',
                    'fee' => 40000,
                    'sem_fee' => 20000,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 with PCB with min 45% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 40,
                ],
                // 22. B.A. LL.B (Integrated 5 Years)
                [
                    'slug' => 'ba-llb',
                    'spec' => 'Integrated Corporate & Criminal Law',
                    'fee' => 45000,
                    'sem_fee' => 22500,
                    'type' => 'per_year',
                    'duration' => '5 Years (10 Semesters)',
                    'eligibility' => '10+2 in any stream with min 45% aggregate (40% for SC/ST); approved by BCI.',
                    'exam' => 'CLAT / CUET / Merit',
                    'seats' => 120,
                ],
                // 23. BBA LL.B (Integrated 5 Years)
                [
                    'slug' => 'bba-llb',
                    'spec' => 'Corporate & Commercial Law',
                    'fee' => 45000,
                    'sem_fee' => 22500,
                    'type' => 'per_year',
                    'duration' => '5 Years (10 Semesters)',
                    'eligibility' => '10+2 in any stream with min 45% aggregate (40% for SC/ST); approved by BCI.',
                    'exam' => 'CLAT / CUET / Merit',
                    'seats' => 60,
                ],
                // 24. LL.B (3 Years)
                [
                    'slug' => 'llb',
                    'spec' => 'General Law & Litigation',
                    'fee' => 42000,
                    'sem_fee' => 21000,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => 'Graduation in any discipline with min 45% aggregate (40% for SC/ST); approved by BCI.',
                    'exam' => 'Merit / Law Entrance',
                    'seats' => 120,
                ],
                // 25. LL.M (Master of Laws)
                [
                    'slug' => 'llm',
                    'spec' => 'Corporate & Commercial Law',
                    'fee' => 50000,
                    'sem_fee' => 25000,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'LL.B. (3 Years or 5 Years Integrated) with min 50% aggregate.',
                    'exam' => 'CLAT-PG / CUET-PG / Merit',
                    'seats' => 30,
                ],
                // 26. B.Sc. Nursing
                [
                    'slug' => 'bsc-nursing',
                    'spec' => 'Clinical Nursing & Patient Care',
                    'fee' => 90000,
                    'sem_fee' => 45000,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry, Biology and English with min 45% aggregate.',
                    'exam' => 'State Nursing Entrance / Merit',
                    'seats' => 60,
                ],
                // 27. GNM
                [
                    'slug' => 'gnm',
                    'spec' => 'General Nursing & Midwifery Practice',
                    'fee' => 60000,
                    'sem_fee' => 30000,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream (Science preferred) with min 40% aggregate.',
                    'exam' => 'Merit / Counseling',
                    'seats' => 60,
                ],
                // 28. BPT (Physiotherapy)
                [
                    'slug' => 'bpt',
                    'spec' => 'Orthopaedic Physiotherapy',
                    'fee' => 70000,
                    'sem_fee' => 35000,
                    'type' => 'per_year',
                    'duration' => '4.5 Years (Incl. 6 Months Internship)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology with min 50% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 60,
                ],
                // 29. Ph.D.
                [
                    'slug' => 'phd',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 120000,
                    'sem_fee' => 60000,
                    'type' => 'per_year',
                    'duration' => '3 Years (Minimum)',
                    'eligibility' => 'Master degree in relevant discipline with min 55% marks (50% for SC/ST/OBC); UGC-NET / GATE preferred.',
                    'exam' => 'UGC NET / DKNMU Ph.D. Entrance Test (PET)',
                    'seats' => 20,
                ],
            ],
        ];
    }

    /**
     * 6. Galgotias University – Greater Noida, Uttar Pradesh
     *
     * @return array<string, mixed>
     */
    private function galgotiasCollege(): array
    {
        return [
            'name' => 'Galgotias University',
            'short_name' => 'Galgotias Greater Noida',
            'slug' => 'galgotias-university-greater-noida',
            'type' => 'Private',
            'university' => 'Galgotias University',
            'website' => 'https://www.galgotiasuniversity.edu.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Greater Noida',
            'address' => 'Plot No. 2, Sector 17-A, Yamuna Expressway, Greater Noida, Gautam Buddha Nagar, Uttar Pradesh - 203201',
            'year' => '2011',
            'campus' => '52+ Acres Ultra-Modern Smart Campus',
            'approvals' => 'UGC, AICTE, NAAC A+ (3.37 CGPA), BCI, PCI, INC, COA, AIU',
            'naac_grade' => 'A+',
            'ugc_approved' => true,
            'nirf_rank' => '101-150',
            'nirf_year' => '2024',
            'entrance_exams' => 'JEE Main, CUET-UG, CUET-PG, CAT, MAT, CLAT, GEEE, Merit-Based',
            'rating' => 4.7,
            'reviews_count' => 1250,
            'highest' => '1.50 Crore (Int.) / 44.00 LPA (Dom.)',
            'average' => '5.40 LPA (7.20 LPA CSE)',
            'top_recruiters' => 'Microsoft, Amazon, Google, Cisco, Adobe, Capgemini, Infosys, Cognizant, Wipro, TCS, Deloitte, EY, KPMG, Tech Mahindra, Bosch, Ericsson, Zscaler, Paytm, Flipkart',
            'is_featured' => true,

            'overview' => 'Galgotias University, situated on the Yamuna Expressway in Greater Noida, Uttar Pradesh, is recognized as one of India\'s premier multidisciplinary private universities. Accredited with a distinguished NAAC A+ Grade (3.37 CGPA), the university is committed to world-class education, research-driven innovation, and holistic development. Spanning a 52+ acre ultra-modern green campus, Galgotias offers over 180 programs across 20 specialized schools encompassing Engineering & Technology, Management, Computing, Legal Studies, Pharmacy, Nursing, Allied Health, Design, Media, and Agriculture. Renowned for its stellar placement ecosystem with over 8,500+ job offers in a single season and top packages reaching ₹1.50 Crore internationally and ₹44 LPA domestically, Galgotias University provides students with global exposure, industry-aligned curricula, and exceptional career outcomes.',

            'scholarship_info' => 'Galgotias University provides generous merit-based and excellence scholarships: (1) 100% Tuition Fee Waiver for state/national board and university toppers; (2) 50% Tuition Fee Waiver for top percentile rankers in JEE Main, CLAT, and CAT; (3) 25% Tuition Fee Waiver for candidates scoring >=90% in qualifying board exams; (4) Sports & Cultural Champions Concession offering up to 50% waiver; (5) Sibling Concession offering 15% annual tuition waiver.',

            'highlights' => [
                ['title' => 'NAAC A+ Accreditation', 'value' => 'Accredited with NAAC A+ Grade (3.37 CGPA), among highest in UP', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'Historic Placements', 'value' => '₹1.50 Cr International & ₹44 LPA Domestic | 8,500+ Offers in Single Season', 'icon' => 'bi-briefcase-fill'],
                ['title' => 'Global Marquee Recruiters', 'value' => '850+ Recruiter Network including Microsoft, Google, Amazon & Cisco', 'icon' => 'bi-building-check'],
                ['title' => 'Statutory Approvals', 'value' => 'Recognized by UGC, AICTE, BCI, PCI, INC, COA & Member of AIU', 'icon' => 'bi-shield-check'],
                ['title' => '52+ Acre Smart Campus', 'value' => 'Lush Green Hi-Tech Campus on Yamuna Expressway, Greater Noida', 'icon' => 'bi-geo-alt-fill'],
                ['title' => 'Advanced Tech Infrastructure', 'value' => 'Apple Authorized Training Center & Cisco Networking Academy', 'icon' => 'bi-laptop'],
                ['title' => 'Healthcare & Legal Hub', 'value' => 'BCI-Approved Moot Court Law School & INC/PCI-Approved Health Sciences', 'icon' => 'bi-hospital-fill'],
                ['title' => 'Generous Scholarships', 'value' => 'Up to 100% Tuition Fee Waivers for Board Toppers & National Achievers', 'icon' => 'bi-award-fill'],
            ],

            'facilities' => [
                ['name' => '5-Star Smart Campus & Central AC Digital Library', 'icon' => 'bi-book'],
                ['name' => 'Apple Authorized Training Center & Cisco Labs', 'icon' => 'bi-apple'],
                ['name' => 'BCI Approved Moot Court Halls', 'icon' => 'bi-bank2'],
                ['name' => 'Medical Simulation & Diagnostic Labs', 'icon' => 'bi-capsule'],
                ['name' => 'Smart Multimedia Amphitheatres & AC Classrooms', 'icon' => 'bi-display'],
                ['name' => 'On-Campus Air-Conditioned Hostels for 4,000+ Students', 'icon' => 'bi-building'],
                ['name' => 'Multi-Cuisine Food Courts, Cafes & Retail Hub', 'icon' => 'bi-cup-hot'],
                ['name' => 'Olympic-Standard Sports Complex & Fitness Gym', 'icon' => 'bi-trophy'],
                ['name' => 'Gigabit Wi-Fi Campus & 24x7 Security Surveillance', 'icon' => 'bi-wifi'],
                ['name' => '24x7 Campus Medical Infirmary & Ambulance Support', 'icon' => 'bi-heart-pulse'],
            ],

            'placement_stats' => [
                ['label' => 'Highest Package (International)', 'value' => '₹1,50,00,000 / Per Annum', 'year' => '2024'],
                ['label' => 'Highest Package (Domestic)', 'value' => '₹44,00,000 / Per Annum', 'year' => '2024'],
                ['label' => 'B.Tech CSE Average Package', 'value' => '₹7,20,000 / Per Annum', 'year' => '2024'],
                ['label' => 'Overall University Average', 'value' => '₹5,40,000 / Per Annum', 'year' => '2024'],
                ['label' => 'Total Placement Offers', 'value' => '8,500+ Offers in Single Season', 'year' => '2024'],
                ['label' => 'Corporate Recruitment Partners', 'value' => '850+ Companies', 'year' => '2024'],
            ],

            'recruiters' => [
                'Microsoft', 'Amazon', 'Google', 'Cisco',
                'Adobe', 'Capgemini', 'Infosys', 'Cognizant',
                'Wipro', 'TCS', 'Deloitte', 'EY',
                'KPMG', 'Tech Mahindra', 'Bosch', 'Ericsson',
                'Zscaler', 'Paytm', 'Flipkart', 'Accenture',
            ],

            'scholarships' => [
                [
                    'name' => 'Galgotias Chancellor Merit Scholarship',
                    'eligibility' => 'Toppers of State / CBSE / ICSE Board examinations or University Rank 1',
                    'criteria' => 'Rank 1 in qualifying board or university examinations',
                    'amount' => null,
                    'amount_label' => '100% Tuition Fee Waiver',
                    'percentage' => '100%',
                    'description' => 'Prestigious 100% tuition fee waiver granted to state and central board toppers for their entire first year.',
                ],
                [
                    'name' => 'National Entrance Achievers Scholarship',
                    'eligibility' => 'High percentile rankers in JEE Main (Air < 50,000), CLAT (< 5,000), or CAT (> 85 percentile)',
                    'criteria' => 'National competitive entrance exam rank verification',
                    'amount' => null,
                    'amount_label' => '50% Tuition Fee Waiver',
                    'percentage' => '50%',
                    'description' => '50% tuition waiver for outstanding performers in recognized national competitive examinations.',
                ],
                [
                    'name' => 'Academic Merit Board Scholarship',
                    'eligibility' => '>=90% marks aggregate in 10+2 or Bachelor degree qualifying exams',
                    'criteria' => 'Verification of Class 12th or graduation transcript',
                    'amount' => null,
                    'amount_label' => '25% Tuition Fee Waiver',
                    'percentage' => '25%',
                    'description' => '25% tuition fee waiver for academic excellence in qualifying board examinations.',
                ],
                [
                    'name' => 'Sports & Cultural Excellence Award',
                    'eligibility' => 'National and State level medal winners in AIU / Olympic recognized sports',
                    'criteria' => 'Sports trials and federation certificate verification',
                    'amount' => null,
                    'amount_label' => 'Up to 50% Tuition Concession',
                    'percentage' => 'Up to 50%',
                    'description' => 'Special athletic scholarship recognizing distinguished sporting achievements at state and national levels.',
                ],
            ],

            'faqs' => [
                [
                    'q' => 'What NAAC accreditation grade does Galgotias University hold?',
                    'a' => 'Galgotias University is accredited with NAAC A+ Grade with an outstanding 3.37 CGPA score, placing it among the top private universities in Uttar Pradesh and India.',
                ],
                [
                    'q' => 'What are the highest and average salary packages at Galgotias?',
                    'a' => 'Galgotias University achieved a highest international placement package of ₹1.50 Crore per annum and a domestic highest package of ₹44 LPA. The average salary across the university is ₹5.40 LPA, with B.Tech CSE averaging ₹7.20 LPA.',
                ],
                [
                    'q' => 'Where is Galgotias University located and how accessible is it?',
                    'a' => 'Galgotias University is located at Plot No. 2, Sector 17-A on the Yamuna Expressway in Greater Noida, Gautam Buddha Nagar, UP. It is easily accessible via the Aqua Line Metro, Noida-Greater Noida Expressway, and dedicated university fleet transport.',
                ],
                [
                    'q' => 'What are the popular courses and eligibility at Galgotias University?',
                    'a' => 'Galgotias University offers top programs including B.Tech (CSE, AI/ML, Data Science), BCA, MCA, BBA, MBA, B.Pharm, D.Pharm, B.Sc Nursing, BPT, BA-LLB, BBA-LLB, and B.Des. Eligibility for UG courses is generally 50-60% in 10+2 with relevant subjects.',
                ],
                [
                    'q' => 'What scholarships are offered to students at Galgotias University?',
                    'a' => 'Galgotias University provides up to 100% tuition fee waivers for board and university toppers, 50% waivers for top national exam rankers (JEE Main, CAT, CLAT), 25% for 90%+ in 10+2, and up to 50% for national sports champions.',
                ],
            ],

            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Admission Process',
                    'content' => 'Admissions to Galgotias University are conducted through an online portal and on-campus counseling sessions.',
                    'items' => [
                        'Step 1: Complete online registration on the official portal (www.galgotiasuniversity.edu.in).',
                        'Step 2: Fill out academic particulars and entrance exam scores (JEE Main / CUET / CAT / CLAT / GEEE / Merit).',
                        'Step 3: Upload self-attested copies of academic mark sheets and government identity proof.',
                        'Step 4: Receive provisional admission offer based on cutoff merit and eligibility validation.',
                        'Step 5: Deposit the first semester tuition fee and complete on-campus document verification.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required at Admission Verification',
                    'content' => 'Admitted candidates must submit the following original credentials along with self-attested photocopies:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (proof of date of birth)',
                        'Class 12th Marksheet & Passing Certificate',
                        'Graduation Marksheets & Degree (for PG / MBA / MCA / LLM / PhD applicants)',
                        'Scorecard of Competitive Exam (JEE Main / CUET / CAT / MAT / CLAT / GEEE)',
                        'Transfer Certificate (TC) & Migration Certificate from last institution',
                        'Character Certificate issued by the Head of Institution last attended',
                        'Aadhaar Card or Valid Government Photo ID Proof',
                        'Medical Fitness Certificate from registered MBBS doctor',
                        'Recent passport size color photographs (6 copies)',
                    ],
                ],
            ],

            'courses' => [
                // 1. B.Tech Computer Science & Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 149000,
                    'sem_fee' => 74500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 60% aggregate; valid JEE Main / CUET / GEEE score.',
                    'exam' => 'JEE Main / CUET / GEEE / Merit',
                    'seats' => 600,
                ],
                // 2. B.Tech Artificial Intelligence & Machine Learning
                [
                    'slug' => 'btech',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 159000,
                    'sem_fee' => 79500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 60% aggregate.',
                    'exam' => 'JEE Main / CUET / GEEE / Merit',
                    'seats' => 240,
                ],
                // 3. B.Tech Data Science
                [
                    'slug' => 'btech',
                    'spec' => 'Data Science',
                    'fee' => 159000,
                    'sem_fee' => 79500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 60% aggregate.',
                    'exam' => 'JEE Main / CUET / GEEE / Merit',
                    'seats' => 120,
                ],
                // 4. B.Tech Cyber Security
                [
                    'slug' => 'btech',
                    'spec' => 'Cyber Security',
                    'fee' => 159000,
                    'sem_fee' => 79500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 60% aggregate.',
                    'exam' => 'JEE Main / CUET / GEEE / Merit',
                    'seats' => 120,
                ],
                // 5. B.Tech Cloud Computing & DevOps
                [
                    'slug' => 'btech',
                    'spec' => 'Cloud Computing & DevOps',
                    'fee' => 159000,
                    'sem_fee' => 79500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 60% aggregate.',
                    'exam' => 'JEE Main / CUET / GEEE / Merit',
                    'seats' => 60,
                ],
                // 6. B.Tech Electronics & Communication Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Electronics & Communication Engineering',
                    'fee' => 149000,
                    'sem_fee' => 74500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 55% aggregate.',
                    'exam' => 'JEE Main / CUET / Merit',
                    'seats' => 60,
                ],
                // 7. B.Tech Mechanical Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Mechanical Engineering',
                    'fee' => 149000,
                    'sem_fee' => 74500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 50% aggregate.',
                    'exam' => 'JEE Main / CUET / Merit',
                    'seats' => 60,
                ],
                // 8. B.Tech Civil Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Civil Engineering',
                    'fee' => 149000,
                    'sem_fee' => 74500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM with min 50% aggregate.',
                    'exam' => 'JEE Main / CUET / Merit',
                    'seats' => 60,
                ],
                // 9. M.Tech Computer Science & Engineering
                [
                    'slug' => 'mtech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 77000,
                    'sem_fee' => 38500,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'B.Tech / B.E. in CSE/IT/ECE or MCA/M.Sc (CS/IT) with min 55% marks; GATE score preferred.',
                    'exam' => 'GATE / CUET-PG / Merit',
                    'seats' => 30,
                ],
                // 10. Diploma in Engineering (Polytechnic) - Computer Science
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 45000,
                    'sem_fee' => 22500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10th standard passed with min 40% marks with Science and Mathematics.',
                    'exam' => 'Merit / JEECUP',
                    'seats' => 60,
                ],
                // 11. Diploma in Engineering (Polytechnic) - Mechanical Engineering
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Mechanical Engineering (Production)',
                    'fee' => 45000,
                    'sem_fee' => 22500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10th standard passed with min 40% marks.',
                    'exam' => 'Merit / JEECUP',
                    'seats' => 60,
                ],
                // 12. Diploma in Engineering (Polytechnic) - Civil Engineering
                [
                    'slug' => 'polytechnic',
                    'spec' => 'Civil Engineering',
                    'fee' => 45000,
                    'sem_fee' => 22500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10th standard passed with min 40% marks.',
                    'exam' => 'Merit / JEECUP',
                    'seats' => 60,
                ],
                // 13. BCA
                [
                    'slug' => 'bca',
                    'spec' => 'General BCA / Core Computing',
                    'fee' => 72000,
                    'sem_fee' => 36000,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 with Mathematics/CS/IT or Statistics with min 50% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 120,
                ],
                // 14. BCA - AI & ML
                [
                    'slug' => 'bca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 72000,
                    'sem_fee' => 36000,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 with Mathematics/CS with min 50% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 60,
                ],
                // 15. MCA
                [
                    'slug' => 'mca',
                    'spec' => 'General MCA / Software Engineering',
                    'fee' => 92000,
                    'sem_fee' => 46000,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'BCA / B.Sc (CS/IT) / B.Tech or Graduation with Mathematics with min 50% aggregate.',
                    'exam' => 'CUET-PG / Merit',
                    'seats' => 120,
                ],
                // 16. BBA
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 95000,
                    'sem_fee' => 47500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream from a recognized board with min 50% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 240,
                ],
                // 17. BBA - Business Analytics
                [
                    'slug' => 'bba',
                    'spec' => 'Business Analytics',
                    'fee' => 105000,
                    'sem_fee' => 52500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream with min 50% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 60,
                ],
                // 18. MBA - Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 164000,
                    'sem_fee' => 82000,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'Bachelor degree in any discipline with min 55% marks; valid CAT / MAT / CMAT / CUET-PG score.',
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Merit',
                    'seats' => 120,
                ],
                // 19. MBA - Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 164000,
                    'sem_fee' => 82000,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => 'Bachelor degree in any discipline with min 55% marks.',
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Merit',
                    'seats' => 120,
                ],
                // 20. B.Com (Hons.)
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'Accounting & Finance (Hons)',
                    'fee' => 95000,
                    'sem_fee' => 47500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 with Commerce / Science / Arts with min 50% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 120,
                ],
                // 21. B.Pharm (Bachelor of Pharmacy)
                [
                    'slug' => 'bpharma',
                    'spec' => 'General Pharmacy Practice',
                    'fee' => 129000,
                    'sem_fee' => 64500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Maths with min 50% aggregate; approved by PCI.',
                    'exam' => 'CUET / State Entrance / Merit',
                    'seats' => 100,
                ],
                // 22. D.Pharm (Diploma in Pharmacy)
                [
                    'slug' => 'dpharma',
                    'spec' => 'Diploma in Pharmacy Practice',
                    'fee' => 90000,
                    'sem_fee' => 45000,
                    'type' => 'per_year',
                    'duration' => '2 Years (4 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology/Maths with min 45% aggregate; approved by PCI.',
                    'exam' => 'Merit / Counseling',
                    'seats' => 60,
                ],
                // 23. B.Sc. Nursing
                [
                    'slug' => 'bsc-nursing',
                    'spec' => 'Clinical Nursing & Patient Care',
                    'fee' => 151000,
                    'sem_fee' => 75500,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry, Biology and English with min 45% aggregate; approved by INC.',
                    'exam' => 'State Nursing Entrance / CUET / Merit',
                    'seats' => 60,
                ],
                // 24. GNM
                [
                    'slug' => 'gnm',
                    'spec' => 'General Nursing & Midwifery Practice',
                    'fee' => 80000,
                    'sem_fee' => 40000,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream (Science preferred) with min 40% aggregate; approved by INC.',
                    'exam' => 'Merit / Counseling',
                    'seats' => 60,
                ],
                // 25. BPT (Physiotherapy)
                [
                    'slug' => 'bpt',
                    'spec' => 'Orthopaedic Physiotherapy',
                    'fee' => 80000,
                    'sem_fee' => 40000,
                    'type' => 'per_year',
                    'duration' => '4.5 Years (Incl. 6 Months Internship)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology with min 50% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 60,
                ],
                // 26. BMLT (Medical Lab Technology)
                [
                    'slug' => 'bmlt',
                    'spec' => 'Clinical Biochemistry & Microbiology',
                    'fee' => 70000,
                    'sem_fee' => 35000,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology with min 45% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 60,
                ],
                // 27. B.A. LL.B (Hons - Integrated 5 Years)
                [
                    'slug' => 'ba-llb',
                    'spec' => 'Integrated Corporate & Criminal Law',
                    'fee' => 100000,
                    'sem_fee' => 50000,
                    'type' => 'per_year',
                    'duration' => '5 Years (10 Semesters)',
                    'eligibility' => '10+2 in any stream with min 45% aggregate (40% for SC/ST); approved by BCI.',
                    'exam' => 'CLAT / CUET / Merit',
                    'seats' => 120,
                ],
                // 28. BBA LL.B (Hons - Integrated 5 Years)
                [
                    'slug' => 'bba-llb',
                    'spec' => 'Corporate & Commercial Law',
                    'fee' => 100000,
                    'sem_fee' => 50000,
                    'type' => 'per_year',
                    'duration' => '5 Years (10 Semesters)',
                    'eligibility' => '10+2 in any stream with min 45% aggregate (40% for SC/ST); approved by BCI.',
                    'exam' => 'CLAT / CUET / Merit',
                    'seats' => 120,
                ],
                // 29. LL.B (3 Years)
                [
                    'slug' => 'llb',
                    'spec' => 'General Law & Litigation',
                    'fee' => 60000,
                    'sem_fee' => 30000,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => 'Graduation in any discipline with min 45% aggregate; approved by BCI.',
                    'exam' => 'Merit / Law Entrance',
                    'seats' => 120,
                ],
                // 30. LL.M (Master of Laws)
                [
                    'slug' => 'llm',
                    'spec' => 'Corporate & Commercial Law',
                    'fee' => 65000,
                    'sem_fee' => 32500,
                    'type' => 'per_year',
                    'duration' => '1 Year (2 Semesters)',
                    'eligibility' => 'LL.B. (3 Years or 5 Years Integrated) with min 50% aggregate.',
                    'exam' => 'CLAT-PG / CUET-PG / Merit',
                    'seats' => 60,
                ],
                // 31. B.Des (Bachelor of Design)
                [
                    'slug' => 'bdes',
                    'spec' => 'UX/UI & Digital Product Design',
                    'fee' => 110000,
                    'sem_fee' => 55000,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 in any stream with min 50% aggregate; Design aptitude test preferred.',
                    'exam' => 'UCEED / CUET / Merit',
                    'seats' => 60,
                ],
                // 32. B.A. (Journalism & Mass Communication)
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Digital Media, VFX & Content Creation',
                    'fee' => 77000,
                    'sem_fee' => 38500,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 in any stream with min 50% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 60,
                ],
                // 33. B.Sc. (Hons) Agriculture
                [
                    'slug' => 'bsc-agri',
                    'spec' => 'Agronomy & Organic Farming',
                    'fee' => 70000,
                    'sem_fee' => 35000,
                    'type' => 'per_year',
                    'duration' => '4 Years (8 Semesters)',
                    'eligibility' => '10+2 with PCM / PCB / Agriculture with min 50% aggregate.',
                    'exam' => 'CUET / ICAR / Merit',
                    'seats' => 60,
                ],
                // 34. B.Sc. Biotechnology
                [
                    'slug' => 'bsc-biotech',
                    'spec' => 'Biotechnology & Genetic Engineering',
                    'fee' => 60000,
                    'sem_fee' => 30000,
                    'type' => 'per_year',
                    'duration' => '3 Years (6 Semesters)',
                    'eligibility' => '10+2 with Physics, Chemistry and Biology with min 50% aggregate.',
                    'exam' => 'CUET / Merit',
                    'seats' => 60,
                ],
                // 35. Ph.D.
                [
                    'slug' => 'phd',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 100000,
                    'sem_fee' => 50000,
                    'type' => 'per_year',
                    'duration' => '3 Years (Minimum)',
                    'eligibility' => 'Master degree in relevant discipline with min 55% marks (50% for SC/ST); UGC-NET / GATE preferred.',
                    'exam' => 'UGC NET / Galgotias University Research Entrance Test (GURET)',
                    'seats' => 30,
                ],
            ],
        ];
    }

    /**
     * Seed a single college with all its rich relational data
     *
     * @param  array<string, mixed>  $def
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
                'is_popular' => in_array($def['city'], ['Dehradun', 'Meerut', 'Noida', 'Greater Noida', 'Ghaziabad', 'Bareilly', 'Roorkee', 'Haldwani', 'Moradabad']),
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
            'college_course_specializations',
            'college_course_fees',
            'college_courses',
            'college_highlights',
            'college_accreditations',
            'college_admission_sections',
            'college_scholarships',
            'college_placement_stats',
            'college_recruiters',
            'college_career_outcomes',
            'college_facilities',
            'college_faqs',
            'college_quick_facts',
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

    /**
     * Insert courses, semester breakdown fees, and specializations
     *
     * @param  array<int, array<string, mixed>>  $courses
     */
    private function insertCollegeCourses(int $collegeId, array $courses): void
    {
        $now = now();

        foreach ($courses as $idx => $c) {
            $courseId = $this->courseIds[$c['slug']] ?? null;
            if (! $courseId) {
                continue;
            }

            $specId = $this->specializationIds[$c['slug'].'|'.$c['spec']] ?? null;

            $ccData = [
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
            ];

            $ccId = (int) DB::table('college_courses')->insertGetId($ccData);

            // Fee Records (Semester 1 & Semester 2 breakdown)
            if (Schema::hasTable('college_course_fees')) {
                $semFee = $c['sem_fee'] ?? ($c['fee'] / 2);

                DB::table('college_course_fees')->insert([
                    [
                        'college_course_id' => $ccId,
                        'fee_type' => 'Semester Tuition Fee',
                        'label' => '1st Semester Tuition Fee',
                        'amount' => $semFee,
                        'academic_session' => '2025-2026',
                        'description' => 'Semester 1 tuition fee payable at admission registration.',
                        'sort_order' => 1,
                        'status' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'college_course_id' => $ccId,
                        'fee_type' => 'Semester Tuition Fee',
                        'label' => '2nd Semester Tuition Fee',
                        'amount' => $semFee,
                        'academic_session' => '2025-2026',
                        'description' => 'Semester 2 academic tuition fee.',
                        'sort_order' => 2,
                        'status' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'college_course_id' => $ccId,
                        'fee_type' => 'Annual Tuition Fee',
                        'label' => 'Total Annual Tuition Fee',
                        'amount' => $c['fee'],
                        'academic_session' => '2025-2026',
                        'description' => 'Combined academic session annual tuition fee.',
                        'sort_order' => 3,
                        'status' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                ]);
            }

            // Map specialization
            if ($specId && Schema::hasTable('college_course_specializations')) {
                DB::table('college_course_specializations')->insert([
                    'college_course_id' => $ccId,
                    'specialization_id' => $specId,
                    'fee_amount' => $c['fee'],
                    'fee_type' => $c['type'] ?? 'per_year',
                    'eligibility' => $c['eligibility'],
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
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
                'description' => $name.' recruitment drive at Graphic Era campus.',
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
            ['parameter' => 'Type of University',    'value' => $def['type'].' University',               'icon' => 'building'],
            ['parameter' => 'Year of Establishment', 'value' => (string) $def['year'],                      'icon' => 'calendar'],
            ['parameter' => 'Statutory Approvals',   'value' => $def['approvals'],                           'icon' => 'shield-check'],
            ['parameter' => 'NAAC Grade',            'value' => 'Grade '.($def['naac_grade'] ?? 'A+'),     'icon' => 'patch-check-fill'],
            ['parameter' => 'Mode of Education',     'value' => 'Regular Full-Time Campus Degree',           'icon' => 'mortarboard'],
            ['parameter' => 'Campus Size',           'value' => $def['campus'],                              'icon' => 'geo-alt'],
            ['parameter' => 'Highest Package',       'value' => $def['highest'],                            'icon' => 'briefcase'],
            ['parameter' => 'Average Package',       'value' => $def['average'],                            'icon' => 'cash-coin'],
            ['parameter' => 'Hostel Facility',       'value' => 'Separate AC & Non-AC Boys & Girls Hostels', 'icon' => 'house'],
            ['parameter' => 'Location',              'value' => $def['city'].', '.$def['state'],        'icon' => 'pin-map'],
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
     *
     * @param  array<string, mixed>  $d
     * @return array<string, mixed>
     */
    private function buildBasePayload(array $d, int $stateId, int $cityId): array
    {
        $fees = array_column($d['courses'], 'fee');
        $minFee = ! empty($fees) ? min($fees) : 100000;
        $maxFee = ! empty($fees) ? max($fees) : 500000;

        $typeMap = [
            'State Public' => 'Govt',
            'Central Public' => 'Govt',
            'Govt' => 'Govt',
            'Deemed' => 'Deemed',
            'Autonomous' => 'Autonomous',
            'Private' => 'Private',
        ];

        $payload = [
            'name' => $d['name'],
            'short_name' => $d['short_name'],
            'slug' => $d['slug'],
            'logo' => null,
            'banner_image' => null,
            'college_mode' => 'regular',
            'college_type' => $typeMap[$d['type']] ?? 'Private',
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
            'entrance_exams' => $d['entrance_exams'] ?? 'JEE Main / CUET / Merit',
            'rating' => $d['rating'],
            'reviews_count' => $d['reviews_count'],
            'highest_package' => $d['highest'],
            'average_package' => $d['average'],
            'top_recruiters' => $d['top_recruiters'],
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
            'seo_description' => 'Get comprehensive admission details, fees, courses, ranking, scholarships, and placements for '.$d['name'].' on GrowPec.',
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
            $payload['emi_starts_at'] = 8500.00;
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

    /**
     * 7. Teerthanker Mahaveer University (TMU) – Moradabad, Uttar Pradesh
     *
     * @return array<string, mixed>
     */
    private function tmuCollege(): array
    {
        return [
            'name' => 'Teerthanker Mahaveer University',
            'short_name' => 'TMU Moradabad',
            'slug' => 'teerthanker-mahaveer-university-moradabad',
            'type' => 'Private',
            'university' => 'Teerthanker Mahaveer University',
            'website' => 'https://www.tmu.ac.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Moradabad',
            'address' => 'Delhi Road, NH-24, Bagadpur, Moradabad, Uttar Pradesh - 244001',
            'year' => '2008',
            'campus' => '150+ Acres Green Campus',
            'approvals' => 'UGC, AICTE, BCI, PCI, NCTE, INC, DCI, COA, NAAC A (3.15 CGPA)',
            'naac_grade' => 'A',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'JEE Main, NEET, CUET-UG, CUET-PG, CAT, MAT, CLAT, NATA, Merit-Based',
            'rating' => 4.4,
            'reviews_count' => 920,
            'highest' => '₹60 LPA',
            'average' => '₹5.50 LPA',
            'top_recruiters' => 'TCS, Infosys, Wipro, HCL, IBM, Tech Mahindra, Deloitte, Cognizant, Reliance Jio, Tata Motors, HDFC Bank, ICICI Bank, Bajaj Finserv, Amazon',
            'is_featured' => true,
            'overview' => 'Teerthanker Mahaveer University (TMU), established in 2008 under the Uttar Pradesh State University Act and situated on a sprawling 150+ acre green campus along Delhi-Moradabad NH-24, is a premier multi-disciplinary private university of Western Uttar Pradesh. Accredited with NAAC Grade \'A\' (CGPA 3.15) and approved by UGC, AICTE, BCI, PCI, NCTE, INC, DCI, and COA, TMU offers more than 200 programs across 14 constituent faculties, including Engineering & Technology, Management, Medical Sciences, Dental Sciences, Law, Pharmacy, Nursing, Paramedical Sciences, Agriculture, Education, and Fine Arts. The campus is home to a 1,000+ bed multi-specialty Teerthanker Mahaveer Medical College & Research Centre, the only such integrated medical ecosystem in the Moradabad region. With a dedicated Corporate Resource Centre (CRC), 100+ active placement partners, and highest packages reaching ₹60 LPA, TMU consistently delivers outstanding career outcomes. The university is particularly renowned for strong Jain minority scholarships, robust research culture with 2,000+ publications, cutting-edge incubation and innovation labs, and a vibrant cultural ecosystem.',
            'scholarship_info' => 'TMU offers generous scholarships including merit-based awards for top 10+2 performers (up to 50% fee waiver for 90%+ scorers), Jain minority scholarships (up to 50% tuition fee exemption and 30% hostel fee waiver for eligible students), sports scholarships for state and national level athletes, and full support for UP State Government Post-Matric scholarships (OBC/SC/ST). Defence personnel wards receive a 5% tuition concession. The Vice Chancellor Scholarship is awarded to the overall university topper in each graduating batch.',

            'courses' => [
                // 1. B.Tech CSE
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 130000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 240,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate',
                    'sem_fee' => 65000.00,
                ],
                // 2. B.Tech CSE (AI & Machine Learning)
                [
                    'slug' => 'btech',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 135000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 120,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate',
                    'sem_fee' => 67500.00,
                ],
                // 3. B.Tech CSE (Data Science)
                [
                    'slug' => 'btech',
                    'spec' => 'Data Science',
                    'fee' => 135000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate',
                    'sem_fee' => 67500.00,
                ],
                // 4. B.Tech CSE (Cyber Security)
                [
                    'slug' => 'btech',
                    'spec' => 'Cyber Security',
                    'fee' => 135000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate',
                    'sem_fee' => 67500.00,
                ],
                // 5. B.Tech Mechanical Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Mechanical Engineering',
                    'fee' => 100000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 45% aggregate',
                    'sem_fee' => 50000.00,
                ],
                // 6. B.Tech Civil Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Civil Engineering',
                    'fee' => 100000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 45% aggregate',
                    'sem_fee' => 50000.00,
                ],
                // 7. B.Tech ECE
                [
                    'slug' => 'btech',
                    'spec' => 'Electronics & Communication Engineering',
                    'fee' => 100000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 45% aggregate',
                    'sem_fee' => 50000.00,
                ],
                // 8. MBA Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 125000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'CAT / MAT / CMAT / XAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate',
                    'sem_fee' => 62500.00,
                ],
                // 9. MBA HRM
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 125000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CAT / MAT / CMAT / XAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate',
                    'sem_fee' => 62500.00,
                ],
                // 10. MBA Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 125000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CAT / MAT / CMAT / XAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate',
                    'sem_fee' => 62500.00,
                ],
                // 11. BBA
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 in any stream with min 45% aggregate marks',
                    'sem_fee' => 40000.00,
                ],
                // 12. BCA
                [
                    'slug' => 'bca',
                    'spec' => 'General BCA / Core Computing',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science with min 45% marks',
                    'sem_fee' => 40000.00,
                ],
                // 13. MCA
                [
                    'slug' => 'mca',
                    'spec' => 'General MCA / Software Engineering',
                    'fee' => 100000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / Merit-Based',
                    'eligibility' => 'BCA / B.Sc (IT/CS) or Bachelor degree with Mathematics at 10+2/Graduation with min 50%',
                    'sem_fee' => 50000.00,
                ],
                // 14. B.Pharm
                [
                    'slug' => 'bpharm',
                    'spec' => 'Pharmaceutical Sciences',
                    'fee' => 90000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 100,
                    'exam' => 'CUET-UG / 10+2 PCB/PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Mathematics with min 50% aggregate',
                    'sem_fee' => 45000.00,
                ],
                // 15. M.Pharm
                [
                    'slug' => 'mpharm',
                    'spec' => 'Pharmacology',
                    'fee' => 100000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 30,
                    'exam' => 'GPAT / CUET-PG / Merit',
                    'eligibility' => 'B.Pharm with min 55% aggregate marks',
                    'sem_fee' => 50000.00,
                ],
                // 16. B.Sc. Nursing
                [
                    'slug' => 'bsc-nursing',
                    'spec' => 'Clinical Nursing & Patient Care',
                    'fee' => 95000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 100,
                    'exam' => 'NEET / University Entrance Test',
                    'eligibility' => '10+2 with Physics, Chemistry, Biology & English min 45% aggregate',
                    'sem_fee' => 47500.00,
                ],
                // 17. MBBS
                [
                    'slug' => 'mbbs',
                    'spec' => 'General Medicine & Surgery',
                    'fee' => 1100000.00,
                    'type' => 'per_year',
                    'duration' => '5.5 Years',
                    'seats' => 150,
                    'exam' => 'NEET (Mandatory)',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology with min 50% aggregate; NEET qualified',
                    'sem_fee' => 550000.00,
                ],
                // 18. BDS
                [
                    'slug' => 'bds',
                    'spec' => 'Dental Surgery & Oral Health',
                    'fee' => 550000.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 100,
                    'exam' => 'NEET (Mandatory)',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology with min 50% aggregate; NEET qualified',
                    'sem_fee' => 275000.00,
                ],
                // 19. BA LL.B (Hons)
                [
                    'slug' => 'ba-llb',
                    'spec' => 'Integrated Corporate & Criminal Law',
                    'fee' => 100000.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 120,
                    'exam' => 'CLAT / CUET / Merit',
                    'eligibility' => '10+2 in any stream with min 45% aggregate (40% for SC/ST)',
                    'sem_fee' => 50000.00,
                ],
                // 20. B.Sc. Agriculture
                [
                    'slug' => 'bsc-agri',
                    'spec' => 'Agronomy & Crop Science',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / ICAR / Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Agriculture with min 45% aggregate',
                    'sem_fee' => 40000.00,
                ],
                // 21. B.Arch
                [
                    'slug' => 'barch',
                    'spec' => 'Architecture & Urban Design',
                    'fee' => 120000.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 40,
                    'exam' => 'NATA / JEE Paper-2',
                    'eligibility' => '10+2 with Mathematics with min 50% aggregate marks; NATA / JEE Paper-2 qualified',
                    'sem_fee' => 60000.00,
                ],
                // 22. B.Com (Hons)
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'Accounting & Finance (Hons)',
                    'fee' => 70000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 with Commerce / Mathematics with min 45% marks',
                    'sem_fee' => 35000.00,
                ],
                // 23. BPT
                [
                    'slug' => 'bpt',
                    'spec' => 'Physiotherapy & Rehabilitation',
                    'fee' => 75000.00,
                    'type' => 'per_year',
                    'duration' => '4.5 Years',
                    'seats' => 60,
                    'exam' => 'CUET / 10+2 PCB Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology with min 45% marks',
                    'sem_fee' => 37500.00,
                ],
                // 24. Ph.D.
                [
                    'slug' => 'phd',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 20,
                    'exam' => 'UGC-NET / CSIR-NET / GATE / TMU Research Entrance Test (RET)',
                    'eligibility' => 'Master\'s Degree in relevant discipline with min 55% aggregate marks',
                    'sem_fee' => 40000.00,
                ],
            ],

            // Highlights
            'highlights' => [
                ['title' => 'NAAC Grade A Accreditation',     'value' => 'Accredited with CGPA 3.15 (Grade A)',           'icon' => 'bi-patch-check-fill'],
                ['title' => 'Highest CTC Placement',          'value' => '₹60 LPA Highest Package (2024)',                'icon' => 'bi-briefcase-fill'],
                ['title' => 'Average Salary Package',         'value' => '₹5.50 LPA Average CTC',                        'icon' => 'bi-graph-up-arrow'],
                ['title' => 'Integrated Medical Ecosystem',   'value' => '1,000+ Bed Multi-Specialty Hospital on Campus', 'icon' => 'bi-hospital'],
                ['title' => 'Spacious Green Campus',          'value' => '150+ Acres NH-24 Delhi Road Campus',            'icon' => 'bi-tree-fill'],
                ['title' => '14 Faculties & 200+ Programs',   'value' => 'Multi-Disciplinary University Programs',         'icon' => 'bi-mortarboard-fill'],
                ['title' => 'Strong Research Culture',        'value' => '2,000+ Research Publications',                  'icon' => 'bi-lightbulb-fill'],
                ['title' => 'Jain Minority Scholarship',      'value' => 'Up to 50% Tuition Fee Exemption',               'icon' => 'bi-heart-fill'],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'Advanced Computing & AI Research Labs',         'icon' => 'bi-cpu'],
                ['name' => 'Smart Air-Conditioned Lecture Theatres',        'icon' => 'bi-display'],
                ['name' => 'Central Digital Library (DELNET Access)',       'icon' => 'bi-book-half'],
                ['name' => 'Separate AC & Non-AC Boys & Girls Hostels',     'icon' => 'bi-houses'],
                ['name' => '1,000+ Bed Multi-Specialty Hospital',           'icon' => 'bi-hospital'],
                ['name' => 'Indoor & Outdoor Sports Complex & Gymnasium',   'icon' => 'bi-trophy'],
                ['name' => 'Multi-Cuisine Hygienic Food Court & Cafeteria', 'icon' => 'bi-cup-hot'],
                ['name' => 'Moot Court & Legal Aid Research Centre',        'icon' => 'bi-hammer'],
                ['name' => 'Innovation & Incubation Centre',                'icon' => 'bi-lightbulb'],
                ['name' => 'University Transport Fleet on NH-24',           'icon' => 'bi-bus-front'],
            ],

            // FAQs
            'faqs' => [
                [
                    'q' => 'What is the NAAC grade and ranking of Teerthanker Mahaveer University?',
                    'a' => 'TMU is accredited by NAAC with Grade A (CGPA 3.15), recognized by UGC under 2(f) & 12(B), and approved by AICTE, BCI, PCI, NCTE, INC, DCI, and COA for professional programs.',
                ],
                [
                    'q' => 'What is the highest placement package at TMU?',
                    'a' => 'The highest placement package at TMU has reached Rs.60 LPA in recent placement cycles. The average salary package stands at approximately Rs.5.50 LPA, with a placement rate of 82-85% across disciplines.',
                ],
                [
                    'q' => 'Does TMU have a hospital campus for medical students?',
                    'a' => 'Yes. TMU campus houses the Teerthanker Mahaveer Medical College & Research Centre with a 1,000+ bed multi-specialty hospital, providing integrated clinical training for MBBS, BDS, Nursing, Pharmacy, and Physiotherapy students.',
                ],
                [
                    'q' => 'What scholarships does TMU offer for Jain students?',
                    'a' => 'TMU offers dedicated Jain minority scholarships providing up to 50% exemption on tuition fees and 30% waiver on hostel fees for eligible Jain community students. Other scholarships include merit-based awards, sports scholarships, and UP state government post-matric scholarships.',
                ],
                [
                    'q' => 'What is the admission process for B.Tech at TMU?',
                    'a' => 'B.Tech admissions at TMU are based on JEE Main percentile, CUET-UG scores, or 10+2 PCM merit. Candidates must have passed 10+2 with Physics, Mathematics, and Chemistry/Computer Science with a minimum 45% aggregate. Applications can be submitted online at tmu.ac.in.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package',            'value' => '₹60 LPA',   'year' => '2024'],
                ['label' => 'Average Package',            'value' => '₹5.50 LPA', 'year' => '2024'],
                ['label' => 'Placement Rate',             'value' => '83%',        'year' => '2024'],
                ['label' => 'Total Recruiter Companies',  'value' => '100+',       'year' => '2024'],
                ['label' => 'Placement Drives Conducted', 'value' => '300+',       'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'TCS', 'Infosys', 'Wipro', 'HCL', 'IBM', 'Tech Mahindra',
                'Deloitte', 'Cognizant', 'Reliance Jio', 'Tata Motors',
                'HDFC Bank', 'ICICI Bank', 'Bajaj Finserv', 'Amazon',
                'Accenture', 'Capgemini', 'KPMG',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Merit Scholarship (Academic Excellence)',
                    'eligibility' => '90%+ in qualifying 10+2 examination or equivalent',
                    'criteria' => 'Merit-based on Class 12th board percentage',
                    'amount' => null,
                    'amount_label' => 'Up to 50% Tuition Fee Waiver',
                    'percentage' => 'Up to 50%',
                    'description' => 'Awarded to meritorious students who have secured 90% and above in their qualifying examination.',
                ],
                [
                    'name' => 'Jain Minority Scholarship',
                    'eligibility' => 'Students belonging to the Jain minority community',
                    'criteria' => 'Community certificate and Jain minority declaration',
                    'amount' => null,
                    'amount_label' => '50% Tuition + 30% Hostel Fee Waiver',
                    'percentage' => 'Up to 50%',
                    'description' => 'TMU offers exclusive minority scholarships to Jain community students with up to 50% exemption on tuition and 30% waiver on hostel charges.',
                ],
                [
                    'name' => 'Sports Scholarship',
                    'eligibility' => 'State or national level sports achievers with valid certificates',
                    'criteria' => 'Sports participation certificate from authorized body',
                    'amount' => null,
                    'amount_label' => 'Variable Fee Waiver',
                    'percentage' => 'Up to 25%',
                    'description' => 'Awarded to students representing state or national level in recognized sports events.',
                ],
                [
                    'name' => 'UP Government Post-Matric Scholarship',
                    'eligibility' => 'OBC / SC / ST category students domiciled in Uttar Pradesh',
                    'criteria' => 'Category certificate and UP domicile certificate',
                    'amount' => null,
                    'amount_label' => 'As per government norms',
                    'percentage' => null,
                    'description' => 'TMU fully supports UP State Post-Matric scholarship disbursement for eligible OBC, SC, and ST category students.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Admission Process at TMU',
                    'content' => 'Admissions at Teerthanker Mahaveer University are conducted through a transparent merit-based online process.',
                    'items' => [
                        'Step 1: Visit the official TMU admission portal at tmu.ac.in and complete the online application form.',
                        'Step 2: Upload academic documents, qualifying exam scorecard (JEE Main / NEET / CUET / CLAT), and photo ID.',
                        'Step 3: Pay the application and registration fee through the secure online payment gateway.',
                        'Step 4: Attend the university counseling session and receive your program allotment based on merit rank.',
                        'Step 5: Submit original documents during verification, pay the first semester fee, and complete enrollment.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required for Admission',
                    'content' => 'Bring originals and self-attested photocopies of the following during document verification:',
                    'items' => [
                        'Class 10th Marksheet and Passing Certificate',
                        'Class 12th Marksheet and Passing Certificate',
                        'Graduation Marksheets and Degree (for PG/medical programs)',
                        'Qualifying Entrance Exam Scorecard (JEE Main / NEET / CUET / CLAT / NATA / GPAT)',
                        'Transfer Certificate (TC) and Migration Certificate',
                        'Category / Caste Certificate (SC/ST/OBC/EWS) if applicable',
                        'Jain Minority Certificate (if claiming Jain scholarship)',
                        'Passport size photographs (6 copies) and Government Photo ID (Aadhaar Card)',
                    ],
                ],
            ],
        ];
    }

    /**
     * 8. Amrapali University – Haldwani, Uttarakhand
     *
     * @return array<string, mixed>
     */
    private function amrapaliCollege(): array
    {
        return [
            'name' => 'Amrapali University',
            'short_name' => 'Amrapali Haldwani',
            'slug' => 'amrapali-university-haldwani',
            'type' => 'Private',
            'university' => 'Amrapali University',
            'website' => 'https://amrapali.ac.in',
            'state' => 'Uttarakhand',
            'city' => 'Haldwani',
            'address' => 'Lamachaur, Haldwani, Nainital, Uttarakhand - 263139',
            'year' => '2012',
            'campus' => '100+ Acres Green Campus',
            'approvals' => 'UGC, AICTE, PCI, NCTE, BCI, NAAC B+',
            'naac_grade' => 'B+',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'JEE Main, CUET-UG, CUET-PG, CAT, MAT, CLAT, Merit-Based',
            'rating' => 4.2,
            'reviews_count' => 650,
            'highest' => '12 LPA',
            'average' => '3.80 LPA',
            'top_recruiters' => 'Infosys, TCS, Wipro, HCL, Concentrix, Tech Mahindra, Amazon, Cognizant, IBM, HDFC Bank, ICICI Bank, Accenture',
            'is_featured' => true,
            'overview' => 'Amrapali University, established in 2012 under the Uttarakhand Private University Act and situated in the scenic Kumaon foothills of Haldwani, is a UGC-recognized multi-disciplinary private university accredited with NAAC Grade B+. As part of the Amrapali Group of Institutions — one of the most reputed educational groups in Uttarakhand with a legacy spanning over two decades — the university offers more than 100 undergraduate, postgraduate, diploma, and doctoral programs across Engineering & Technology, Management, Computer Applications, Law, Pharmacy, Education, Nursing, Agriculture, and Applied Sciences. The university is particularly known for its state-of-the-art computing labs with IBM-partnership programs, an active Centralized Training and Placement Department (CTPD) that drives 75%+ placement rates, excellent hostel infrastructure amidst the Himalayan foothills, and affordable fee structures designed to make quality higher education accessible to students from Uttarakhand, UP, and neighboring states.',
            'scholarship_info' => 'Amrapali University offers merit scholarships based on Class 12th board performance (up to 100% tuition fee waiver for 95%+ scorers), sports scholarships for state and national achievers, and complete facilitation for Uttarakhand State Government Post-Matric Scholarships (OBC/SC/ST). Special concessions are provided for wards of defence and paramilitary personnel. Domicile-based fee concessions are available for bonafide Uttarakhand students.',

            'courses' => [
                // 1. B.Tech CSE
                [
                    'slug' => 'btech',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 148000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 180,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate',
                    'sem_fee' => 74000.00,
                ],
                // 2. B.Tech CSE (AI & ML)
                [
                    'slug' => 'btech',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 148000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate',
                    'sem_fee' => 74000.00,
                ],
                // 3. B.Tech CSE (Data Science)
                [
                    'slug' => 'btech',
                    'spec' => 'Data Science',
                    'fee' => 148000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Mathematics & Chemistry/CS with min 45% aggregate',
                    'sem_fee' => 74000.00,
                ],
                // 4. B.Tech Civil Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Civil Engineering',
                    'fee' => 111000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 45% aggregate',
                    'sem_fee' => 55500.00,
                ],
                // 5. B.Tech Mechanical Engineering
                [
                    'slug' => 'btech',
                    'spec' => 'Mechanical Engineering',
                    'fee' => 111000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 45% aggregate',
                    'sem_fee' => 55500.00,
                ],
                // 6. B.Tech ECE
                [
                    'slug' => 'btech',
                    'spec' => 'Electronics & Communication Engineering',
                    'fee' => 111000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'JEE Main / CUET-UG / 10+2 PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Mathematics with min 45% aggregate',
                    'sem_fee' => 55500.00,
                ],
                // 7. MBA Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 160000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate',
                    'sem_fee' => 80000.00,
                ],
                // 8. MBA HRM
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 160000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate',
                    'sem_fee' => 80000.00,
                ],
                // 9. MBA Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 160000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CAT / MAT / CMAT / CUET-PG / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate',
                    'sem_fee' => 80000.00,
                ],
                // 10. BBA
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 in any stream with min 45% aggregate marks',
                    'sem_fee' => 40000.00,
                ],
                // 11. BCA
                [
                    'slug' => 'bca',
                    'spec' => 'General BCA / Core Computing',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science with min 45% marks',
                    'sem_fee' => 40000.00,
                ],
                // 12. BCA (AI & ML)
                [
                    'slug' => 'bca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 88000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science with min 45% marks',
                    'sem_fee' => 44000.00,
                ],
                // 13. MCA
                [
                    'slug' => 'mca',
                    'spec' => 'General MCA / Software Engineering',
                    'fee' => 100000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 60,
                    'exam' => 'CUET-PG / Merit-Based',
                    'eligibility' => 'BCA / B.Sc (IT/CS) or Bachelor degree with Mathematics with min 50%',
                    'sem_fee' => 50000.00,
                ],
                // 14. B.Pharm
                [
                    'slug' => 'bpharm',
                    'spec' => 'Pharmaceutical Sciences',
                    'fee' => 90000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / 10+2 PCB/PCM Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Mathematics with min 50% aggregate',
                    'sem_fee' => 45000.00,
                ],
                // 15. B.Sc. Nursing
                [
                    'slug' => 'bsc-nursing',
                    'spec' => 'Clinical Nursing & Patient Care',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'NEET / University Entrance Test',
                    'eligibility' => '10+2 with Physics, Chemistry, Biology & English min 45% aggregate',
                    'sem_fee' => 42500.00,
                ],
                // 16. BA LL.B (Hons)
                [
                    'slug' => 'ba-llb',
                    'spec' => 'Integrated Corporate & Criminal Law',
                    'fee' => 90000.00,
                    'type' => 'per_year',
                    'duration' => '5 Years',
                    'seats' => 60,
                    'exam' => 'CLAT / CUET / Merit',
                    'eligibility' => '10+2 in any stream with min 45% aggregate (40% for SC/ST)',
                    'sem_fee' => 45000.00,
                ],
                // 17. B.Sc. Agriculture
                [
                    'slug' => 'bsc-agri',
                    'spec' => 'Agronomy & Crop Science',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'duration' => '4 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / ICAR / Merit',
                    'eligibility' => '10+2 with Physics, Chemistry & Biology/Agriculture with min 45% aggregate',
                    'sem_fee' => 40000.00,
                ],
                // 18. B.Ed
                [
                    'slug' => 'bed',
                    'spec' => 'Elementary & Secondary Teacher Education',
                    'fee' => 65000.00,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'CUET-PG / State B.Ed Entrance / Merit',
                    'eligibility' => 'Graduation in any discipline with min 50% aggregate marks',
                    'sem_fee' => 32500.00,
                ],
                // 19. B.Com (Hons)
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'Accounting & Finance (Hons)',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 60,
                    'exam' => 'CUET-UG / Merit-Based',
                    'eligibility' => '10+2 with Commerce / Mathematics with min 45% marks',
                    'sem_fee' => 30000.00,
                ],
                // 20. Ph.D.
                [
                    'slug' => 'phd',
                    'spec' => 'Computer Science & Engineering',
                    'fee' => 70000.00,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 15,
                    'exam' => 'UGC-NET / CSIR-NET / GATE / University Entrance Test',
                    'eligibility' => 'Master\'s Degree in relevant discipline with min 55% aggregate marks',
                    'sem_fee' => 35000.00,
                ],
            ],

            // Highlights
            'highlights' => [
                ['title' => 'NAAC Accredited B+',         'value' => 'UGC-Recognized Private University',              'icon' => 'bi-patch-check-fill'],
                ['title' => 'Highest Package',             'value' => '12 LPA Highest Placement Package',              'icon' => 'bi-briefcase-fill'],
                ['title' => 'Placement Rate',              'value' => '75%+ Students Placed Annually',                 'icon' => 'bi-graph-up-arrow'],
                ['title' => 'Himalayan Foothills Campus',  'value' => '100+ Acres in Scenic Haldwani',                 'icon' => 'bi-tree-fill'],
                ['title' => 'IBM Partnership Programs',    'value' => 'Industry-Aligned BCA & B.Tech Specializations', 'icon' => 'bi-cpu'],
                ['title' => '100+ Programs Offered',       'value' => 'Multi-Disciplinary University Education',        'icon' => 'bi-mortarboard-fill'],
                ['title' => 'Merit Scholarship',           'value' => 'Up to 100% Tuition Fee Waiver for Toppers',     'icon' => 'bi-heart-fill'],
                ['title' => 'Domicile Fee Concession',     'value' => 'Special Fees for Uttarakhand Students',         'icon' => 'bi-currency-rupee'],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'Modern Computing & AI Labs with IBM Partnership',  'icon' => 'bi-cpu'],
                ['name' => 'Smart Digital Classrooms & Seminar Halls',         'icon' => 'bi-display'],
                ['name' => 'Central Library with Digital Resources',           'icon' => 'bi-book-half'],
                ['name' => 'Separate Boys & Girls Hostel Accommodation',       'icon' => 'bi-houses'],
                ['name' => 'Health Centre & Medical Facilities on Campus',     'icon' => 'bi-hospital'],
                ['name' => 'Outdoor Sports Grounds & Indoor Gymnasium',        'icon' => 'bi-trophy'],
                ['name' => 'Multi-Cuisine Cafeteria & Hygienic Mess',          'icon' => 'bi-cup-hot'],
                ['name' => 'Moot Court & Law Research Centre',                 'icon' => 'bi-hammer'],
                ['name' => 'Innovation & Start-Up Incubation Cell',            'icon' => 'bi-lightbulb'],
                ['name' => 'University Bus Service (Haldwani & Surroundings)', 'icon' => 'bi-bus-front'],
            ],

            // FAQs
            'faqs' => [
                [
                    'q' => 'What is the NAAC grade of Amrapali University?',
                    'a' => 'Amrapali University is accredited with NAAC Grade B+ and is recognized by UGC under 2(f). The university is also approved by AICTE, PCI, NCTE, and BCI for respective professional programs.',
                ],
                [
                    'q' => 'What is the placement record at Amrapali University?',
                    'a' => 'Amrapali University has a strong placement record through its Centralized Training and Placement Department (CTPD), consistently placing 75%+ students. The highest package recorded is 12 LPA with an average of approximately Rs.3.80 LPA across disciplines.',
                ],
                [
                    'q' => 'Are there special fee concessions for Uttarakhand students?',
                    'a' => 'Yes. Amrapali University offers domicile-based fee concessions for bonafide Uttarakhand residents, with B.Tech tuition fees at approximately Rs.55,500 per semester for Uttarakhand domicile students vs Rs.74,000 for All India category.',
                ],
                [
                    'q' => 'What scholarships are available at Amrapali University?',
                    'a' => 'The university offers merit scholarships (up to 100% tuition waiver for 95%+ board scorers), sports scholarships for state/national athletes, defence personnel concessions, and full support for Uttarakhand State Government Post-Matric Scholarships for OBC/SC/ST students.',
                ],
                [
                    'q' => 'How is the campus location and hostel facility at Amrapali University?',
                    'a' => 'Amrapali University is located at Lamachaur, Haldwani in Uttarakhand, in the scenic Kumaon foothills. The campus spans 100+ acres and provides separate, well-maintained boys and girls hostel facilities with mess services, Wi-Fi, and 24-hour security.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package',            'value' => '12 LPA',   'year' => '2024'],
                ['label' => 'Average Package',            'value' => '3.80 LPA', 'year' => '2024'],
                ['label' => 'Placement Rate',             'value' => '75%+',      'year' => '2024'],
                ['label' => 'Total Recruiter Companies',  'value' => '80+',       'year' => '2024'],
                ['label' => 'Placement Drives Conducted', 'value' => '150+',      'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'Infosys', 'TCS', 'Wipro', 'HCL', 'Concentrix',
                'Tech Mahindra', 'Amazon', 'Cognizant', 'IBM',
                'HDFC Bank', 'ICICI Bank', 'Axis Bank', 'Accenture',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Merit Scholarship (Board Toppers)',
                    'eligibility' => '95%+ in Class 12th qualifying examination',
                    'criteria' => 'Merit-based on qualifying board percentage',
                    'amount' => null,
                    'amount_label' => 'Up to 100% Tuition Fee Waiver',
                    'percentage' => 'Up to 100%',
                    'description' => 'Full tuition fee waiver for students scoring 95% and above in qualifying board exams, on first-come-first-serve basis.',
                ],
                [
                    'name' => 'Sports Scholarship',
                    'eligibility' => 'State or national level sports achievers with valid certificates',
                    'criteria' => 'Sports achievement certificate from authorized body',
                    'amount' => null,
                    'amount_label' => 'Variable Fee Waiver',
                    'percentage' => 'Up to 50%',
                    'description' => 'Awarded to students with outstanding sports achievements at state or national level.',
                ],
                [
                    'name' => 'Uttarakhand Domicile Concession',
                    'eligibility' => 'Students with bonafide Uttarakhand domicile certificate',
                    'criteria' => 'Uttarakhand domicile / residence certificate',
                    'amount' => null,
                    'amount_label' => 'Reduced Tuition Fee Slab',
                    'percentage' => 'Up to 25%',
                    'description' => 'Lower tuition fee structure (Rs.55,500/sem vs Rs.74,000/sem for B.Tech) for Uttarakhand domicile students.',
                ],
                [
                    'name' => 'UK Government Post-Matric Scholarship',
                    'eligibility' => 'OBC / SC / ST category students domiciled in Uttarakhand',
                    'criteria' => 'Category certificate and Uttarakhand domicile certificate',
                    'amount' => null,
                    'amount_label' => 'As per government norms',
                    'percentage' => null,
                    'description' => 'Full support and facilitation for Uttarakhand State Government Post-Matric Scholarship disbursement for eligible students.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Admission Process at Amrapali University',
                    'content' => 'Admissions at Amrapali University are conducted through a streamlined online process.',
                    'items' => [
                        'Step 1: Visit the official admission portal at amrapali.ac.in and fill out the online application form.',
                        'Step 2: Upload academic documents including 10th/12th marksheets, entrance exam scorecards, and photo ID.',
                        'Step 3: Pay the application and registration fee online via secure payment gateway.',
                        'Step 4: Attend the merit-based counseling session and receive your program allotment.',
                        'Step 5: Report to the campus, complete document verification, pay initial semester fee, and confirm admission.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required for Admission',
                    'content' => 'Bring originals and self-attested photocopies of the following during document verification:',
                    'items' => [
                        'Class 10th Marksheet and Passing Certificate',
                        'Class 12th Marksheet and Passing Certificate',
                        'Graduation Marksheets and Degree (for PG programs)',
                        'Qualifying Entrance Exam Scorecard (JEE Main / CUET / CAT / CLAT / NEET)',
                        'Transfer Certificate (TC) and Migration Certificate',
                        'Uttarakhand Domicile Certificate (if claiming domicile concession)',
                        'Category / Caste Certificate (SC/ST/OBC/EWS) if applicable',
                        'Passport size photographs (6 copies) and Government Photo ID (Aadhaar Card)',
                    ],
                ],
            ],
        ];
    }
}
