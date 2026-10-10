<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DistanceOnlineCollegeSeeder extends Seeder
{
    /** @var array<string, int> */
    private array $courseIds = [];

    /** @var array<string, int> */
    private array $specializationIds = [];

    public function run(): void
    {
        // 1. Load academic mappings populated by StreamCourseSpecializationSeeder
        $this->loadAcademicMappings();

        // 2. Seed Distance/Online colleges strictly 1 by 1 in sequence
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
     * Seed Distance/Online universities strictly 1 by 1 in sequence
     */
    private function seedCollegesInSequence(): void
    {
        foreach ($this->collegeList() as $def) {
            $this->seedSingleCollege($def);
        }
    }

    /**
     * Curated Online/Distance Universities List (Strictly 1 by 1 in sequence):
     * 1. IIMT University (Meerut) - Added
     * 2. Bennett University (Greater Noida) - Added
     * 3. Teerthanker Mahaveer University (TMU, Moradabad) - Added
     * 4. SGT University (Gurugram) - Added
     * 5. Swami Vivekanand Subharti University (Meerut) - Added
     * 6. Mangalayatan University (Aligarh) - Added
     * 7. Chaudhary Charan Singh University (CCSU, Meerut) - Added
     * 8. Amity University Online (Noida) - Added
     * 9. Lovely Professional University (LPU Online) - Added
     * 10. Chandigarh University Online (CU Online) - Added
     * 11. Shobhit University (Meerut) - Added
     *
     * @return array<int, array<string, mixed>>
     */
    private function collegeList(): array
    {
        return [
            $this->iimtUniversity(),
            $this->bennettUniversity(),
            $this->tmuUniversity(),
            $this->sgtUniversity(),
            $this->subhartiUniversity(),
            $this->mangalayatanUniversity(),
            $this->ccsuUniversity(),
            $this->amityUniversity(),
            $this->lpuUniversity(),
            $this->chandigarhUniversity(),
            $this->shobhitUniversity(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 1. IIMT University Online / Distance (Meerut, Uttar Pradesh)
    |--------------------------------------------------------------------------
    */
    private function iimtUniversity(): array
    {
        return [
            'name' => 'IIMT University Online, Meerut',
            'short_name' => 'IIMT University Online',
            'slug' => 'iimt-university-online',
            'type' => 'Private',
            'university' => 'IIMT University, Meerut',
            'website' => 'https://onlineiimtu.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => '\'O\' Pocket, Ganga Nagar, Mawana Road, Meerut, Uttar Pradesh - 250001',
            'year' => '2016',
            'campus' => 'Centre for Online & Distance Education (CDOE) Digital Campus',
            'approvals' => 'UGC-DEB | AICTE | NAAC B++ | BCI | PCI | AIU',
            'naac_grade' => 'B++',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'Direct Admission / Merit Based',
            'rating' => 4.3,
            'reviews_count' => 340,
            'highest' => '₹12.50 LPA',
            'average' => '₹4.20 LPA',
            'top_recruiters' => 'Paytm, Wipro, Infosys, Tech Mahindra, JustDial, Capgemini, TCS, Concentrix, HCL Technologies',
            'is_featured' => true,
            'overview' => 'IIMT University Online, managed under the Centre for Online and Distance Education (CDOE), Meerut, is a recognized Higher Educational Institution entitled by the University Grants Commission - Distance Education Bureau (UGC-DEB) to offer high-quality, flexible, and industry-oriented undergraduate and postgraduate online degree programs. Accredited with NAAC Grade \'B++\' and approved by AICTE, IIMT University Online bridges the gap between ambitious professionals, remote learners, and modern academia. The university deploys a state-of-the-art Learning Management System (LMS) providing 24/7 access to digitized study material (e-SLM), high-definition recorded lectures, live interactive webinars with industry experts, and AI-proctored semester examinations. All online degrees awarded by IIMT University hold 100% equivalence to traditional on-campus degrees under UGC regulations, making graduates fully eligible for central & state government exams, UPSC, higher education across the globe, and premier corporate employment.',
            'scholarship_info' => 'IIMT University Online offers merit-based fee concessions (up to 15% for students scoring 75%+ in qualifying exams), 20% concession for serving defense & paramilitary personnel, special regional fee subsidies, and flexible No-Cost EMI options starting from ₹2,500/month across all degree programs.',

            // Authentic Programs with 100% Accurate Fees & Specializations
            'courses' => [
                // 1. MBA - Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 28000.00,
                    'type' => 'per_year',
                    'sem_fee' => 14000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate (40% for SC/ST/OBC) from a recognized university.',
                ],
                // 2. MBA - Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 28000.00,
                    'type' => 'per_year',
                    'sem_fee' => 14000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate (40% for SC/ST/OBC) from a recognized university.',
                ],
                // 3. MBA - Human Resource Management
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 28000.00,
                    'type' => 'per_year',
                    'sem_fee' => 14000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate (40% for SC/ST/OBC) from a recognized university.',
                ],
                // 4. MBA - Information Technology Management
                [
                    'slug' => 'mba',
                    'spec' => 'Information Technology Management',
                    'fee' => 28000.00,
                    'type' => 'per_year',
                    'sem_fee' => 14000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate (40% for SC/ST/OBC) from a recognized university.',
                ],
                // 5. MBA - Operations & Production Management
                [
                    'slug' => 'mba',
                    'spec' => 'Operations & Production Management',
                    'fee' => 28000.00,
                    'type' => 'per_year',
                    'sem_fee' => 14000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate (40% for SC/ST/OBC) from a recognized university.',
                ],
                // 6. MBA - International Business
                [
                    'slug' => 'mba',
                    'spec' => 'International Business',
                    'fee' => 28000.00,
                    'type' => 'per_year',
                    'sem_fee' => 14000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate (40% for SC/ST/OBC) from a recognized university.',
                ],
                // 7. MBA - Banking & Financial Services
                [
                    'slug' => 'mba',
                    'spec' => 'Banking & Financial Services',
                    'fee' => 28000.00,
                    'type' => 'per_year',
                    'sem_fee' => 14000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate (40% for SC/ST/OBC) from a recognized university.',
                ],
                // 8. MBA - General Management
                [
                    'slug' => 'mba',
                    'spec' => 'General Management',
                    'fee' => 28000.00,
                    'type' => 'per_year',
                    'sem_fee' => 14000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate (40% for SC/ST/OBC) from a recognized university.',
                ],

                // 9. MCA - General Computer Applications
                [
                    'slug' => 'mca',
                    'spec' => 'General Computer Applications',
                    'fee' => 26000.00,
                    'type' => 'per_year',
                    'sem_fee' => 13000.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 45% aggregate.',
                ],
                // 10. MCA - Artificial Intelligence & Machine Learning
                [
                    'slug' => 'mca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 28000.00,
                    'type' => 'per_year',
                    'sem_fee' => 14000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 45% aggregate.',
                ],
                // 11. MCA - Cloud Computing & DevOps
                [
                    'slug' => 'mca',
                    'spec' => 'Cloud Computing & DevOps',
                    'fee' => 28000.00,
                    'type' => 'per_year',
                    'sem_fee' => 14000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 45% aggregate.',
                ],

                // 12. BBA - General Management
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate (40% for reserved categories).',
                ],
                // 13. BBA - Marketing Management
                [
                    'slug' => 'bba',
                    'spec' => 'Marketing Management',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate (40% for reserved categories).',
                ],
                // 14. BBA - Human Resource Management
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate (40% for reserved categories).',
                ],
                // 15. BBA - Banking & Financial Services
                [
                    'slug' => 'bba',
                    'spec' => 'Banking & Financial Services',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate (40% for reserved categories).',
                ],

                // 16. BCA - General Computer Applications
                [
                    'slug' => 'bca',
                    'spec' => 'General Computer Applications',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science or equivalent from recognized board with min 45% aggregate.',
                ],
                // 17. BCA - Cloud Computing & Cyber Security
                [
                    'slug' => 'bca',
                    'spec' => 'Cloud Computing & Cyber Security',
                    'fee' => 18000.00,
                    'type' => 'per_year',
                    'sem_fee' => 9000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science or equivalent from recognized board with min 45% aggregate.',
                ],
                // 18. BCA - Data Science & Web Technologies
                [
                    'slug' => 'bca',
                    'spec' => 'Data Science & Web Technologies',
                    'fee' => 18000.00,
                    'type' => 'per_year',
                    'sem_fee' => 9000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science or equivalent from recognized board with min 45% aggregate.',
                ],

                // 19. B.Com (Hons.) - Accounting & Financial Management
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'Accounting & Financial Management',
                    'fee' => 13000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6500.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce or Allied stream (or Arts/Science with Mathematics) with min 45% aggregate from recognized board.',
                ],
                // 20. B.Com (Hons.) - Banking & Insurance
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'Banking & Insurance',
                    'fee' => 13000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6500.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce or Allied stream (or Arts/Science with Mathematics) with min 45% aggregate from recognized board.',
                ],

                // 21. B.Com - General Commerce & Accounting
                [
                    'slug' => 'bcom',
                    'spec' => 'General Commerce & Accounting',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from recognized board with min 40% aggregate.',
                ],

                // 22. M.Com - Advanced Accounting & Financial Management
                [
                    'slug' => 'mcom',
                    'spec' => 'Advanced Accounting & Financial Management',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / Allied commerce degree from a recognized university with min 45% marks.',
                ],
                // 23. M.Com - International Trade & Business Finance
                [
                    'slug' => 'mcom',
                    'spec' => 'International Trade & Business Finance',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / Allied commerce degree from a recognized university with min 45% marks.',
                ],

                // 24. B.A. (Journalism & Mass Communication) - Electronic & Print Media
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Electronic & Print Media',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate.',
                ],
                // 25. B.A. (Journalism & Mass Communication) - Digital Media & Mass Communication
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Digital Media & Mass Communication',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate.',
                ],

                // 26. B.A. - English Literature
                [
                    'slug' => 'ba',
                    'spec' => 'English Literature',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream.',
                ],
                // 27. B.A. - Political Science
                [
                    'slug' => 'ba',
                    'spec' => 'Political Science',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream.',
                ],
                // 28. B.A. - History
                [
                    'slug' => 'ba',
                    'spec' => 'History',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream.',
                ],
                // 29. B.A. - Sociology
                [
                    'slug' => 'ba',
                    'spec' => 'Sociology',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream.',
                ],
                // 30. B.A. - Hindi Literature
                [
                    'slug' => 'ba',
                    'spec' => 'Hindi Literature',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream.',
                ],
                // 31. B.A. - Economics
                [
                    'slug' => 'ba',
                    'spec' => 'Economics',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream.',
                ],
                // 32. B.A. - Psychology
                [
                    'slug' => 'ba',
                    'spec' => 'Psychology',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream.',
                ],

                // 33. M.A. - English Literature
                [
                    'slug' => 'ma',
                    'spec' => 'English Literature',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate from a recognized university.',
                ],
                // 34. M.A. - Political Science
                [
                    'slug' => 'ma',
                    'spec' => 'Political Science',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate from a recognized university.',
                ],
                // 35. M.A. - History
                [
                    'slug' => 'ma',
                    'spec' => 'History',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate from a recognized university.',
                ],
                // 36. M.A. - Sociology
                [
                    'slug' => 'ma',
                    'spec' => 'Sociology',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate from a recognized university.',
                ],
                // 37. M.A. - Hindi Literature
                [
                    'slug' => 'ma',
                    'spec' => 'Hindi Literature',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate from a recognized university.',
                ],
                // 38. M.A. - Economics
                [
                    'slug' => 'ma',
                    'spec' => 'Economics',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate from a recognized university.',
                ],
            ],

            // Highlights
            'highlights' => [
                ['title' => 'UGC-DEB Entitled Degree Programs', 'value' => '100% Equivalent to On-Campus Regular Degrees', 'icon' => 'bi-shield-check'],
                ['title' => 'NAAC B++ Accredited University', 'value' => 'Quality Benchmark Assured by UGC', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'High-Performance Cloud LMS', 'value' => '24/7 Access to e-SLM, Video Lectures & Quizzes', 'icon' => 'bi-laptop'],
                ['title' => 'Online Proctored Examinations', 'value' => 'Take Semester Exams Remotely from Anywhere', 'icon' => 'bi-display'],
                ['title' => 'Highly Affordable Fee Structure', 'value' => 'Annual Degree Fees Starting from ₹10,000/Year', 'icon' => 'bi-currency-rupee'],
                ['title' => 'Flexible No-Cost EMI Facility', 'value' => 'Monthly Installments Starting at ₹2,500/Month', 'icon' => 'bi-credit-card-2-front'],
                ['title' => 'Dedicated Placement Assistance', 'value' => 'Virtual Job Fairs & 150+ Corporate Partners', 'icon' => 'bi-briefcase-fill'],
            ],

            // Accreditations
            'accreditations' => [
                ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled to offer Online & Open Distance Learning Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council', 'grade' => 'B++', 'rank' => null, 'year' => '2023'],
                ['authority' => 'AICTE', 'accreditation' => 'All India Council for Technical Education (MBA & MCA Approval)', 'grade' => null, 'rank' => null, 'year' => '2024'],
                ['authority' => 'AIU', 'accreditation' => 'Association of Indian Universities Member', 'grade' => null, 'rank' => null, 'year' => '2020'],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'State-of-the-Art LMS Portal with Single Sign-On Access', 'icon' => 'bi-laptop'],
                ['name' => 'Live Weekend Masterclasses & Doubts Resolution Sessions', 'icon' => 'bi-camera-video'],
                ['name' => 'Self-Paced e-Learning Modules & Downloadable PDFs', 'icon' => 'bi-book-half'],
                ['name' => 'AI-Proctored Online Semester Examination Engine', 'icon' => 'bi-shield-check'],
                ['name' => 'Virtual Placement Cell & Career Mentorship Support', 'icon' => 'bi-briefcase'],
                ['name' => '24/7 Dedicated Academic Student Grievance Helpdesk', 'icon' => 'bi-headset'],
            ],

            // FAQs
            'faqs' => [
                [
                    'q' => 'Is an online degree from IIMT University valid for Government Jobs and UPSC?',
                    'a' => 'Yes. As per UGC Distance Education Bureau (DEB) and Ministry of Education regulations, online degrees awarded by UGC-DEB entitled universities have complete parity and equal recognition with regular on-campus degrees for all Central & State Government examinations, UPSC, SSC, Banking, and PSU appointments.',
                ],
                [
                    'q' => 'How are semester examinations conducted for IIMT University Online courses?',
                    'a' => 'Semester examinations are conducted completely online in an AI-monitored, remote-proctored environment. Students can conveniently appear for exams from home or their workplace using a desktop or laptop equipped with a working webcam, microphone, and stable internet connection.',
                ],
                [
                    'q' => 'Can working professionals manage the study schedule with their job?',
                    'a' => 'Absolutely. The curriculum is specifically structured for working executives, remote learners, and busy candidates. Lectures are available as recorded sessions 24/7 on the LMS, live interactive webinars are held on weekends, and study materials can be downloaded for offline review.',
                ],
                [
                    'q' => 'What is the fee payment procedure and are EMI options available?',
                    'a' => 'Students can pay fees per semester or annually through secure online payment gateways (Debit/Credit Cards, UPI, Net Banking, and NEFT). IIMT University Online also provides convenient No-Cost EMI facilities in association with financial education partners starting at ₹2,500/month.',
                ],
                [
                    'q' => 'Will my degree mention the word "Online" or "Distance"?',
                    'a' => 'In accordance with UGC regulations, the degree certificate awards the qualification (e.g., Master of Business Administration) with full legal validity equivalent to regular degrees, while transcripts and university records acknowledge the mode of delivery through the Centre for Online and Distance Education (CDOE).',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹12.50 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹4.20 LPA', 'year' => '2024'],
                ['label' => 'Hiring Partners', 'value' => '150+ Companies', 'year' => '2024'],
                ['label' => 'Placement Support', 'value' => 'Virtual Job Fairs & Career Support', 'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'Paytm', 'Wipro', 'Infosys', 'Tech Mahindra', 'JustDial',
                'Capgemini', 'TCS', 'Concentrix', 'HCL Technologies', 'Axis Bank',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Academic Merit Concession',
                    'eligibility' => 'Students securing 75% or higher in the qualifying board or degree examination.',
                    'criteria' => 'Academic Merit',
                    'amount' => null,
                    'amount_label' => 'Up to 15% Tuition Fee Waiver',
                    'percentage' => '15%',
                    'description' => 'Awarded to high-achieving applicants on first-come-first-serve basis during admission registration.',
                ],
                [
                    'name' => 'Defense & Paramilitary Concession',
                    'eligibility' => 'Wards and spouses of serving or retired Armed Forces and Paramilitary personnel.',
                    'criteria' => 'Armed Forces ID / Certificate',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Honorary 20% tuition concession across all undergraduate and postgraduate online degrees.',
                ],
                [
                    'name' => 'Divyang (Differently Abled) Scholarship',
                    'eligibility' => 'Candidates with benchmark disability (>40%) holding valid government medical certificate.',
                    'criteria' => 'Medical Disability Certificate',
                    'amount' => null,
                    'amount_label' => '20% Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Dedicated welfare scholarship to support inclusive higher education.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Digital Admission Process for IIMT University Online',
                    'content' => 'Admissions are conducted 100% online through GrowPec and the official university portal without requiring any physical campus visit.',
                    'items' => [
                        'Step 1: Choose your desired UG or PG program and fill out the online registration form.',
                        'Step 2: Upload self-attested digital copies of your academic marksheets, photo, and government photo ID (Aadhaar).',
                        'Step 3: University admission counselors verify your eligibility and issue enrollment clearance.',
                        'Step 4: Pay your semester or annual registration fee via secure payment gateway or opt for 0% interest EMI.',
                        'Step 5: Receive your official Student Admission Letter, University Roll Number, and LMS Login credentials to begin learning.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Checklist for Online Admission',
                    'content' => 'Upload clear scanned copies of the following documents during online enrollment:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (as Date of Birth proof)',
                        'Class 12th Certificate & Marksheet (for Undergraduate & Postgraduate programs)',
                        'Graduation Marksheets & Provisional / Degree Certificate (for PG MBA, MCA, M.Com, M.A. programs)',
                        'Valid Government Photo ID Proof (Aadhaar Card / Voter ID / Passport)',
                        'Recent Passport-Sized Colored Photograph (White Background)',
                        'Category / Disability / Defense Certificate (only if applying for fee concessions)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Bennett University Online (Greater Noida, Uttar Pradesh)
    |--------------------------------------------------------------------------
    */
    private function bennettUniversity(): array
    {
        return [
            'name' => 'Bennett University Online, Greater Noida',
            'short_name' => 'Bennett Online',
            'slug' => 'bennett-university-online',
            'type' => 'Private',
            'university' => 'Bennett University (The Times Group)',
            'website' => 'https://www.bennettonline.com',
            'state' => 'Uttar Pradesh',
            'city' => 'Greater Noida',
            'address' => 'Plot Nos 8-11, TechZone II, Greater Noida, Uttar Pradesh - 201310',
            'year' => '2016',
            'campus' => 'Bennett Online Directorate / Times Group Academic Centre',
            'approvals' => 'UGC-DEB | AICTE | NAAC A+ | BCI',
            'naac_grade' => 'A+',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'Direct Admission / Merit Based / Screening Interview',
            'rating' => 4.7,
            'reviews_count' => 480,
            'highest' => '₹28.50 LPA',
            'average' => '₹7.80 LPA',
            'top_recruiters' => 'The Times Group, Amazon, Microsoft, Deloitte, Google, Meta, Adobe, Ernst & Young, KPMG, PwC, Infosys, Capgemini, TCS, HDFC Bank, HSBC',
            'is_featured' => true,
            'overview' => 'Bennett University Online, backed by the prestigious 185-year legacy of The Times Group (Bennett, Coleman & Co. Ltd.), offers world-class online degree programs entitled by the University Grants Commission - Distance Education Bureau (UGC-DEB). Accredited with NAAC Grade \'A+\', Bennett Online delivers an elite, ivy-league inspired learning ecosystem custom-tailored for working executives, entrepreneurs, and forward-thinking undergraduates. With cutting-edge curricula developed in collaboration with top corporate leaders, interactive live masterclasses by global CxOs, Harvard Business Publishing case studies, and hands-on digital simulations, students gain unmatched industry relevance. The programs are hosted on an AI-powered next-generation Learning Management System featuring round-the-clock student support, interactive discussion forums, and remote AI-proctored semester exams. Graduates benefit from the expansive Times Group corporate network, dedicated virtual career fairs, and 360-degree executive placement assistance, with online degrees having 100% legal equivalence to on-campus degrees under UGC norms.',
            'scholarship_info' => 'Bennett University Online provides up to 20% Academic Merit Fee Waivers for high-scoring candidates, 15% concession for Armed Forces & Paramilitary personnel, Times Group corporate employee/alumni benefits, and flexible No-Cost EMI facilities starting from ₹4,500/month.',

            // Authentic Programs with 100% Accurate Fees & Specializations
            'courses' => [
                // 1. MBA - Finance Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 105000.00,
                    'type' => 'per_year',
                    'sem_fee' => 52500.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Academic Screening',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST) from a recognized university.',
                ],
                // 2. MBA - Sales & Marketing
                [
                    'slug' => 'mba',
                    'spec' => 'Sales and Marketing',
                    'fee' => 105000.00,
                    'type' => 'per_year',
                    'sem_fee' => 52500.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Academic Screening',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST) from a recognized university.',
                ],
                // 3. MBA - Human Resource Management
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 105000.00,
                    'type' => 'per_year',
                    'sem_fee' => 52500.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Academic Screening',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST) from a recognized university.',
                ],
                // 4. MBA - Business Analytics
                [
                    'slug' => 'mba',
                    'spec' => 'Business Analytics',
                    'fee' => 105000.00,
                    'type' => 'per_year',
                    'sem_fee' => 52500.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Academic Screening',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST) from a recognized university.',
                ],
                // 5. MBA - Media Management
                [
                    'slug' => 'mba',
                    'spec' => 'Media Management',
                    'fee' => 105000.00,
                    'type' => 'per_year',
                    'sem_fee' => 52500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Academic Screening',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST) from a recognized university.',
                ],
                // 6. MBA - Logistics & Supply Chain Management
                [
                    'slug' => 'mba',
                    'spec' => 'Logistics & Supply Chain Management',
                    'fee' => 105000.00,
                    'type' => 'per_year',
                    'sem_fee' => 52500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Academic Screening',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST) from a recognized university.',
                ],

                // 7. BBA - Marketing
                [
                    'slug' => 'bba',
                    'spec' => 'Marketing',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Academic Merit',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 8. BBA - Finance
                [
                    'slug' => 'bba',
                    'spec' => 'Finance',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Academic Merit',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 9. BBA - Human Resource Management
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Academic Merit',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 10. BBA - Business Analytics
                [
                    'slug' => 'bba',
                    'spec' => 'Business Analytics',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Academic Merit',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 11. BBA - International Business
                [
                    'slug' => 'bba',
                    'spec' => 'International Business',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Academic Merit',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 12. BBA - Entrepreneurship
                [
                    'slug' => 'bba',
                    'spec' => 'Entrepreneurship',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Academic Merit',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
            ],

            // Highlights
            'highlights' => [
                ['title' => 'The Times Group Legacy', 'value' => 'Backed by India\'s Largest 185-Year Media Conglomerate', 'icon' => 'bi-award-fill'],
                ['title' => 'UGC-DEB Entitled Degree Programs', 'value' => '100% Legally Equivalent to Regular On-Campus Degrees', 'icon' => 'bi-shield-check'],
                ['title' => 'NAAC Grade A+ Accreditation', 'value' => 'Benchmark of Academic Excellence & Rigour', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'Harvard Business Publishing Integration', 'value' => 'Live Global Case Studies & Simulation Tools', 'icon' => 'bi-book-half'],
                ['title' => 'CxO Masterclasses & Mentorship', 'value' => 'Direct Live Interactive Sessions with Top Corporate Leaders', 'icon' => 'bi-camera-video'],
                ['title' => 'AI-Enabled Digital LMS Portal', 'value' => 'Bite-Sized Modules, Mobile App & 24/7 Access', 'icon' => 'bi-laptop'],
                ['title' => 'Times Career Advantage', 'value' => 'Direct Access to Virtual Job Fairs & 800+ Recruiters', 'icon' => 'bi-briefcase-fill'],
            ],

            // Accreditations
            'accreditations' => [
                ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled to offer Online Degree Programs (Category-I / Entitled Status)', 'grade' => null, 'rank' => null, 'year' => '2026'],
                ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                ['authority' => 'AICTE', 'accreditation' => 'All India Council for Technical Education Approval', 'grade' => null, 'rank' => null, 'year' => '2024'],
                ['authority' => 'AIU', 'accreditation' => 'Association of Indian Universities Member', 'grade' => null, 'rank' => null, 'year' => '2020'],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'Next-Gen AI-Powered LMS with Mobile Learning App', 'icon' => 'bi-phone'],
                ['name' => 'Live Interactive Weekend Masterclasses with Industry Veterans', 'icon' => 'bi-camera-video'],
                ['name' => 'Harvard Business Publishing & Times Case Study Digital Library', 'icon' => 'bi-journal-bookmark'],
                ['name' => 'AI-Proctored Secure Online Semester Examination System', 'icon' => 'bi-shield-check'],
                ['name' => 'Virtual Career Services, Resume Reviews & Placement Drives', 'icon' => 'bi-briefcase'],
                ['name' => '24/7 Dedicated Student Success Mentors & Support Helpdesk', 'icon' => 'bi-headset'],
            ],

            // FAQs
            'faqs' => [
                [
                    'q' => 'Is Bennett University Online MBA and BBA recognized by UGC?',
                    'a' => 'Yes. Bennett University is recognized under Section 2(f) of the UGC Act and is entitled by the UGC Distance Education Bureau (DEB) to offer online degree programs. The degrees hold equal legal status and parity with regular campus degrees for corporate careers, government examinations, and higher studies globally.',
                ],
                [
                    'q' => 'What is the examination pattern at Bennett University Online?',
                    'a' => 'Examinations are conducted 100% online through an AI-proctored remote testing portal. Students can schedule and take their end-semester examinations from anywhere in the world on a computer equipped with a webcam and microphone.',
                ],
                [
                    'q' => 'How does the Times Group affiliation benefit students?',
                    'a' => 'Bennett University is an initiative of The Times Group (BCCL). Students gain unique access to media insights, specialized Media Management curriculum, live sessions by senior corporate editors & CXOs, and prioritized networking within the Times Group extensive corporate partner network.',
                ],
                [
                    'q' => 'What are the fees and payment options for Bennett Online programs?',
                    'a' => 'The Online MBA total fee is ₹2,10,000 (payable at ₹52,500/semester) and the Online BBA total fee is ₹1,50,000 (payable at ₹25,000/semester). The university also provides flexible No-Cost EMI financing options starting from ₹4,500/month.',
                ],
                [
                    'q' => 'Can working professionals balance this program with full-time jobs?',
                    'a' => 'Yes. The curriculum is specifically curated for working professionals with self-paced video modules, recorded lectures accessible 24/7, downloadable study materials, and interactive live mentoring sessions scheduled conveniently on weekends.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹28.50 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹7.80 LPA', 'year' => '2024'],
                ['label' => 'Corporate Network', 'value' => '800+ Companies', 'year' => '2024'],
                ['label' => 'Times Group Advantage', 'value' => 'Dedicated Virtual Placement Drives', 'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'The Times Group', 'Amazon', 'Microsoft', 'Deloitte', 'Google',
                'Meta', 'Adobe', 'Ernst & Young', 'KPMG', 'PwC', 'Infosys', 'Capgemini',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Academic Merit Scholarship',
                    'eligibility' => 'Candidates with >=80% marks in graduation (for MBA) or 10+2 (for BBA).',
                    'criteria' => 'Academic Merit Performance',
                    'amount' => null,
                    'amount_label' => 'Up to 20% Tuition Fee Waiver',
                    'percentage' => '20%',
                    'description' => 'Awarded on a first-come, first-served basis to outstanding academic achievers.',
                ],
                [
                    'name' => 'Armed Forces Concession',
                    'eligibility' => 'Serving and retired defense & paramilitary personnel, their spouses and children.',
                    'criteria' => 'Defense ID / Service Certificate',
                    'amount' => null,
                    'amount_label' => '15% Tuition Fee Concession',
                    'percentage' => '15%',
                    'description' => 'Special tuition waiver honouring the armed forces community.',
                ],
                [
                    'name' => 'Times Group Corporate & Alumni Benefit',
                    'eligibility' => 'Employees, associates, and alumni of Times Group entities.',
                    'criteria' => 'Employee ID / Corporate Verification',
                    'amount' => null,
                    'amount_label' => 'Special Corporate Fee Concession',
                    'percentage' => '15%',
                    'description' => 'Dedicated fee discount for the Times Group professional family.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Online Admission at Bennett University',
                    'content' => 'The admission process is entirely paperless and completed digitally.',
                    'items' => [
                        'Step 1: Submit your online application on bennettonline.com or through GrowPec.',
                        'Step 2: Upload digital self-attested copies of academic marksheets and photo identity.',
                        'Step 3: Academic profile screening by Bennett University admission committee.',
                        'Step 4: Receive provisional admission offer letter and complete fee payment (Semester / Annual / EMI).',
                        'Step 5: Receive student LMS login credentials and attend the virtual orientation program.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required for Bennett Online Enrollment',
                    'content' => 'Digital scanned copies needed during enrollment:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (Date of birth verification)',
                        'Class 12th Certificate & Marksheet (For BBA & MBA programs)',
                        'Graduation Degree Certificate & All Semester Marksheets (For MBA applicants)',
                        'Valid Government Photo ID (Aadhaar Card / Passport / Voter ID)',
                        'Recent Passport-Sized Colored Photograph',
                        'Work Experience Certificate / Resume (Optional, recommended for MBA)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Teerthanker Mahaveer University Online / CDOE (Moradabad, UP)
    |--------------------------------------------------------------------------
    */
    private function tmuUniversity(): array
    {
        return [
            'name' => 'Teerthanker Mahaveer University Online, Moradabad',
            'short_name' => 'TMU Online',
            'slug' => 'tmu-university-online',
            'type' => 'Private',
            'university' => 'Teerthanker Mahaveer University (TMU)',
            'website' => 'https://www.tmuonline.ac.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Moradabad',
            'address' => 'Delhi Road, NH-24, Moradabad, Uttar Pradesh - 244001',
            'year' => '2008',
            'campus' => 'Centre for Distance and Online Education (CDOE) / TMU Online Portal',
            'approvals' => 'UGC-DEB | AICTE | NAAC A (3.36 CGPA) | 12(B) Status | BCI | PCI | INC | AIU',
            'naac_grade' => 'A',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'Direct Admission / Merit Based',
            'rating' => 4.5,
            'reviews_count' => 520,
            'highest' => '₹12.00 LPA',
            'average' => '₹4.80 LPA',
            'top_recruiters' => 'Microsoft, Infosys, TCS, Wipro, Tech Mahindra, Cognizant, Accenture, Byju\'s, HCL Technologies, Concentrix, HDFC Bank, ICICI Bank',
            'is_featured' => true,
            'overview' => 'Teerthanker Mahaveer University (TMU), Moradabad, established under UP State Act No. 30 of 2008 and conferred prestigious 12(B) status by the UGC along with NAAC Grade \'A\' accreditation (3.36 CGPA), offers premier UGC-DEB entitled Online and Distance degree programs through TMU Online and its Centre for Distance and Online Education (CDOE). TMU Online is tailored to empower working executives, modern professionals, and remote students across the globe with flexible, career-accelerating education. Featuring an advanced, AI-enabled cloud Learning Management System (LMS), TMU Online delivers 24/7 access to digitized self-learning materials (e-SLM), high-definition recorded lectures, live interactive faculty webinars, hands-on virtual lab environments, and AI-monitored remote semester examinations. Degrees awarded through TMU Online enjoy complete statutory parity with regular on-campus degrees under UGC regulations, making alumni fully eligible for Central & State Government jobs, UPSC, State Public Service Commissions, banking, corporate leadership roles, and international higher studies.',
            'scholarship_info' => 'TMU Online offers an exclusive 25% Tuition Fee Scholarship per semester for TMU alumni, existing students, faculty & staff. Additionally, a 15% concession is provided for Armed Forces & Paramilitary personnel, alongside flexible No-Cost EMI facilities starting from ₹2,800/month.',

            // Authentic Programs with 100% Accurate Fees & Specializations
            'courses' => [
                // 1. MBA - Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 2. MBA - Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 3. MBA - Human Resource Management
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 4. MBA - Digital Marketing
                [
                    'slug' => 'mba',
                    'spec' => 'Digital Marketing',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 5. MBA - International Business
                [
                    'slug' => 'mba',
                    'spec' => 'International Business',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 6. MBA - Logistics & Supply Chain Management
                [
                    'slug' => 'mba',
                    'spec' => 'Logistics & Supply Chain Management',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 7. MBA - Data Analytics
                [
                    'slug' => 'mba',
                    'spec' => 'Data Analytics',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 8. MBA - Hospital & Healthcare Management
                [
                    'slug' => 'mba',
                    'spec' => 'Hospital & Healthcare Management',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 9. MBA - Operations Strategy & Project Management
                [
                    'slug' => 'mba',
                    'spec' => 'Operations Strategy & Project Management',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 10. MBA - Banking, FinTech & AI
                [
                    'slug' => 'mba',
                    'spec' => 'Banking, FinTech & AI',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 11. MBA - Agri-Business Management
                [
                    'slug' => 'mba',
                    'spec' => 'Agri-Business Management',
                    'fee' => 41400.00,
                    'type' => 'per_year',
                    'sem_fee' => 20700.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],

                // 12. BBA - Digital Marketing
                [
                    'slug' => 'bba',
                    'spec' => 'Digital Marketing',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate (40% for SC/ST).',
                ],
                // 13. BBA - Banking, FinTech & AI
                [
                    'slug' => 'bba',
                    'spec' => 'Banking, FinTech & AI',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate (40% for SC/ST).',
                ],
                // 14. BBA - Healthcare Services & Administration
                [
                    'slug' => 'bba',
                    'spec' => 'Healthcare Services & Administration',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate (40% for SC/ST).',
                ],
                // 15. BBA - International Business & Entrepreneurship
                [
                    'slug' => 'bba',
                    'spec' => 'International Business & Entrepreneurship',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate (40% for SC/ST).',
                ],
                // 16. BBA - Marketing Management
                [
                    'slug' => 'bba',
                    'spec' => 'Marketing Management',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate (40% for SC/ST).',
                ],
                // 17. BBA - Human Resource Management
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 45% aggregate (40% for SC/ST).',
                ],

                // 18. BCA - Cloud Computing & DevOps
                [
                    'slug' => 'bca',
                    'spec' => 'Cloud Computing & DevOps',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / IT or equivalent with min 45% aggregate marks.',
                ],
                // 19. BCA - AI & Data Science
                [
                    'slug' => 'bca',
                    'spec' => 'Artificial Intelligence & Data Science',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / IT or equivalent with min 45% aggregate marks.',
                ],
                // 20. BCA - Cyber Security & Ethical Hacking
                [
                    'slug' => 'bca',
                    'spec' => 'Cyber Security & Ethical Hacking',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / IT or equivalent with min 45% aggregate marks.',
                ],
                // 21. BCA - FinTech & Blockchain
                [
                    'slug' => 'bca',
                    'spec' => 'FinTech & Blockchain',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / IT or equivalent with min 45% aggregate marks.',
                ],
                // 22. BCA - General Computer Applications
                [
                    'slug' => 'bca',
                    'spec' => 'General Computer Applications',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / IT or equivalent with min 45% aggregate marks.',
                ],
                // 23. BCA - Healthcare IT & Bioinformatics
                [
                    'slug' => 'bca',
                    'spec' => 'Healthcare IT & Bioinformatics',
                    'fee' => 25200.00,
                    'type' => 'per_year',
                    'sem_fee' => 12600.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / IT or equivalent with min 45% aggregate marks.',
                ],

                // 24. B.Com - Accounting & Financial Management
                [
                    'slug' => 'bcom',
                    'spec' => 'Accounting & Financial Management',
                    'fee' => 8000.00,
                    'type' => 'per_year',
                    'sem_fee' => 4000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce or any stream with min 40% aggregate from a recognized board.',
                ],

                // 25. M.Com - Advanced Financial Accounting
                [
                    'slug' => 'mcom',
                    'spec' => 'Advanced Financial Accounting',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / Allied Commerce degree with min 45% marks from a recognized university.',
                ],

                // 26. B.A. - Economics
                [
                    'slug' => 'ba',
                    'spec' => 'Economics',
                    'fee' => 7000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3500.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board in any stream.',
                ],
                // 27. B.A. - Sociology
                [
                    'slug' => 'ba',
                    'spec' => 'Sociology',
                    'fee' => 7000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3500.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board in any stream.',
                ],
                // 28. B.A. - English Literature
                [
                    'slug' => 'ba',
                    'spec' => 'English Literature',
                    'fee' => 7000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3500.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board in any stream.',
                ],
                // 29. B.A. - Hindi Literature
                [
                    'slug' => 'ba',
                    'spec' => 'Hindi Literature',
                    'fee' => 7000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3500.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board in any stream.',
                ],
                // 30. B.A. - Political Science
                [
                    'slug' => 'ba',
                    'spec' => 'Political Science',
                    'fee' => 7000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3500.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board in any stream.',
                ],
                // 31. B.A. - History
                [
                    'slug' => 'ba',
                    'spec' => 'History',
                    'fee' => 7000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3500.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board in any stream.',
                ],

                // 32. M.A. - Economics
                [
                    'slug' => 'ma',
                    'spec' => 'Economics',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate from a recognized university.',
                ],
                // 33. M.A. - Sociology
                [
                    'slug' => 'ma',
                    'spec' => 'Sociology',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate from a recognized university.',
                ],
                // 34. M.A. - English Literature
                [
                    'slug' => 'ma',
                    'spec' => 'English Literature',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate from a recognized university.',
                ],
                // 35. M.A. - Hindi Literature
                [
                    'slug' => 'ma',
                    'spec' => 'Hindi Literature',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate from a recognized university.',
                ],
            ],

            // Highlights
            'highlights' => [
                ['title' => 'UGC 12(B) Status & UGC-DEB Entitlement', 'value' => 'Autonomous Public Trust Conferred Central Recognition', 'icon' => 'bi-shield-check'],
                ['title' => 'NAAC Grade \'A\' Accreditation (3.36 Score)', 'value' => 'Prestigious High-Scoring Academic Rating', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'Next-Gen TMU Online LMS Portal', 'value' => 'Virtual Labs, e-SLM Modules & 24/7 Lecture Access', 'icon' => 'bi-laptop'],
                ['title' => 'AI-Proctored Semester Examinations', 'value' => 'Appear for Tests Remotely from the Comfort of Home', 'icon' => 'bi-display'],
                ['title' => 'Future-Ready Tech Specializations', 'value' => 'FinTech, AI & Data Science, Cloud Computing & Cyber Security', 'icon' => 'bi-cpu'],
                ['title' => '25% Alumni & Staff Scholarship', 'value' => 'Direct Fee Waiver per Semester for TMU Family', 'icon' => 'bi-award-fill'],
                ['title' => 'Affordable Fee Structure with EMI', 'value' => 'No-Cost EMI Starting from ₹2,800/Month', 'icon' => 'bi-credit-card-2-front'],
            ],

            // Accreditations
            'accreditations' => [
                ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Online & Open Distance Learning Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                ['authority' => 'UGC 12(B)', 'accreditation' => 'Conferred 12(B) Status by University Grants Commission', 'grade' => '12(B)', 'rank' => null, 'year' => '2016'],
                ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council Grade A', 'grade' => 'A (3.36)', 'rank' => null, 'year' => '2023'],
                ['authority' => 'AICTE', 'accreditation' => 'All India Council for Technical Education Statutory Approval', 'grade' => null, 'rank' => null, 'year' => '2024'],
                ['authority' => 'AIU', 'accreditation' => 'Association of Indian Universities Permanent Member', 'grade' => null, 'rank' => null, 'year' => '2012'],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'TMU Online Cloud LMS with Single-Sign-On Student Portal', 'icon' => 'bi-laptop'],
                ['name' => 'Live Interactive Faculty Masterclasses & Recorded Lectures', 'icon' => 'bi-camera-video'],
                ['name' => 'Virtual Simulation Laboratories & Hands-On IT Coding Tools', 'icon' => 'bi-code-slash'],
                ['name' => 'AI-Proctored Remote Online Semester Examination Engine', 'icon' => 'bi-shield-check'],
                ['name' => 'Digital Library Repository with e-SLM, Journals & e-Books', 'icon' => 'bi-book-half'],
                ['name' => 'Corporate Resource Centre (CRC) Virtual Placement Drives', 'icon' => 'bi-briefcase'],
                ['name' => '24/7 Student Grievance Redressal & Academic Helpdesk', 'icon' => 'bi-headset'],
            ],

            // FAQs
            'faqs' => [
                [
                    'q' => 'Is an online degree from TMU valid for UPSC and government employment?',
                    'a' => 'Yes. Teerthanker Mahaveer University (TMU) is a UGC 12(B) recognized institution with NAAC Grade \'A\' accreditation. Under UGC regulations, online degrees awarded by UGC-DEB entitled universities have complete equivalence to regular on-campus degrees for all government jobs, competitive civil service exams (UPSC/SSC), and higher education globally.',
                ],
                [
                    'q' => 'How are semester examinations conducted in TMU Online?',
                    'a' => 'Semester examinations are conducted completely online in an AI-monitored, remote-proctored environment. Students can take exams securely from their home or office using a computer equipped with a webcam, microphone, and standard internet connection.',
                ],
                [
                    'q' => 'What are the popular online specializations offered at TMU?',
                    'a' => 'TMU Online offers in-demand industry specializations including AI & Data Science, Cloud Computing & DevOps, Cyber Security, and FinTech & Blockchain for BCA; Banking, FinTech & AI, Digital Marketing, and Healthcare Administration for BBA; and 11 high-growth specializations for MBA.',
                ],
                [
                    'q' => 'What scholarships are offered by TMU Online?',
                    'a' => 'TMU offers a dedicated 25% scholarship on tuition fees per semester for TMU alumni, faculty & staff, as well as concessions for Armed Forces personnel, merit-based waivers, and No-Cost monthly EMI facilities starting at ₹2,800/month.',
                ],
                [
                    'q' => 'Can working professionals easily balance studies with full-time employment?',
                    'a' => 'Yes. The TMU Online curriculum is designed with flexibility in mind. Recorded video lectures and self-learning materials (e-SLM) are available 24/7 on the LMS portal, and live mentoring masterclasses are held on weekends.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹12.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹4.80 LPA', 'year' => '2024'],
                ['label' => 'Hiring Partners', 'value' => '300+ Companies', 'year' => '2024'],
                ['label' => 'Career Support', 'value' => 'Virtual Job Fairs & Corporate Resource Centre (CRC)', 'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'Microsoft', 'Infosys', 'TCS', 'Wipro', 'Tech Mahindra',
                'Cognizant', 'Accenture', 'Byju\'s', 'HCL Technologies', 'Concentrix',
                'HDFC Bank', 'ICICI Bank',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'TMU Alumni & Staff 25% Scholarship',
                    'eligibility' => 'TMU alumni, existing students, university faculty & administrative staff.',
                    'criteria' => 'Valid TMU Alumni ID / Staff ID verification',
                    'amount' => null,
                    'amount_label' => '25% Tuition Fee Waiver per Semester',
                    'percentage' => '25%',
                    'description' => 'Flat 25% tuition fee waiver per semester throughout the duration of the degree program.',
                ],
                [
                    'name' => 'Armed Forces & Paramilitary Concession',
                    'eligibility' => 'Serving and retired defense personnel, paramilitary members, and their dependants.',
                    'criteria' => 'Service ID / Defense Certificate',
                    'amount' => null,
                    'amount_label' => '15% Tuition Fee Concession',
                    'percentage' => '15%',
                    'description' => 'Honour concession for defense forces across all online degree programs.',
                ],
                [
                    'name' => 'Academic Merit Fee Concession',
                    'eligibility' => 'Candidates with >=75% marks in the qualifying board or undergraduate degree.',
                    'criteria' => 'Qualifying Exam Merit Score',
                    'amount' => null,
                    'amount_label' => 'Up to 15% Tuition Waiver',
                    'percentage' => '15%',
                    'description' => 'Merit-based concession awarded during initial admission enrollment.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Online Admission at TMU Online',
                    'content' => 'Admission is conducted 100% online through GrowPec and the official TMU Online portal.',
                    'items' => [
                        'Step 1: Choose your undergraduate or postgraduate program and submit the online application form.',
                        'Step 2: Upload digital self-attested copies of academic marksheets, photo, and government ID.',
                        'Step 3: Verification of documents and eligibility by the TMU admission committee.',
                        'Step 4: Pay your semester tuition fee securely online (via Card, Net Banking, UPI, or 0% interest EMI).',
                        'Step 5: Receive your official Student Admission Letter, Enrollment Number, and LMS Login credentials.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Checklist for TMU Online Admission',
                    'content' => 'Upload clear digital scans of the following credentials:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (Date of birth verification)',
                        'Class 12th Certificate & Marksheet (For all UG & PG programs)',
                        'Graduation Marksheets & Degree Certificate (For MBA, MCA, M.Com, M.A. applicants)',
                        'Valid Government Photo ID Proof (Aadhaar Card / Voter ID / Passport)',
                        'Recent Passport-Sized Colored Photograph (White Background)',
                        'TMU Alumni / Staff ID / Defense ID (If claiming 25% or 15% scholarship)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 4. SGT University Online / CDOE (Gurugram, Haryana)
    |--------------------------------------------------------------------------
    */
    private function sgtUniversity(): array
    {
        return [
            'name' => 'SGT University Online, Gurugram',
            'short_name' => 'SGT University Online',
            'slug' => 'sgt-university-online',
            'type' => 'Private',
            'university' => 'Shree Guru Gobind Singh Tricentenary University',
            'website' => 'https://sgtonline.in',
            'state' => 'Haryana',
            'city' => 'Gurugram',
            'address' => 'Budhera, Gurugram-Badli Road, Gurugram, Haryana - 122505',
            'year' => '2013',
            'campus' => 'Centre for Distance & Online Education (CDOE), Gurugram Campus',
            'approvals' => 'UGC-DEB | AICTE | NAAC A+ | BCI | PCI | DCI | INC | AIU',
            'naac_grade' => 'A+',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'Direct Admission / Merit Based',
            'rating' => 4.6,
            'reviews_count' => 410,
            'highest' => '₹18.00 LPA',
            'average' => '₹5.50 LPA',
            'top_recruiters' => 'Deloitte, Infosys, Tech Mahindra, Fortis Healthcare, Max Healthcare, Radisson, IBM, TCS, Wipro, ICICI Bank, HDFC Bank, Cognizant',
            'is_featured' => true,
            'overview' => 'SGT University Online (Centre for Distance & Online Education - CDOE), established under the Haryana Private Universities Act and fully entitled by the University Grants Commission - Distance Education Bureau (UGC-DEB), delivers high-caliber, industry-aligned online higher education from its expansive 70-acre campus in Gurugram, Delhi-NCR. Accredited with NAAC Grade \'A+\' and recognized by AICTE, SGT University Online combines academic rigor with digital flexibility for working professionals, fresh graduates, and lifelong learners across India and abroad. The university provides programs across Management, Information Technology, Commerce, and Humanities through a cutting-edge Learning Management System (LMS) with 24/7 access to e-books, high-definition recorded lectures, weekend live interactive sessions by renowned faculty and industry practitioners, and AI-proctored remote semester examinations. Online degrees awarded by SGT University have complete legal parity with conventional on-campus degrees under UGC (ODL & Online Programs) Regulations, ensuring absolute acceptance for government jobs, corporate employment, and higher studies globally.',
            'scholarship_info' => 'SGT University Online offers comprehensive financial assistance, including a 20% Academic Merit Scholarship for candidates scoring above 80% in qualifying examinations, a 15% Special Defense Personnel & Paramilitary Concession, 15% SGT Alumni/Staff Privilege, and easy No-Cost EMI payment plans starting from ₹2,500/month.',

            // Authentic Programs with 100% Accurate Fees & Specializations
            'courses' => [
                // 1. MBA - Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 2. MBA - Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 3. MBA - Human Resource Management
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 4. MBA - Business Analytics
                [
                    'slug' => 'mba',
                    'spec' => 'Business Analytics',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 5. MBA - Digital Marketing
                [
                    'slug' => 'mba',
                    'spec' => 'Digital Marketing',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 6. MBA - Healthcare & Hospital Management
                [
                    'slug' => 'mba',
                    'spec' => 'Hospital and Health Care Management',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline (B.Sc./MBBS/BDS/B.Pharm/Allied Health preferred) with min 50% aggregate marks from a recognized university.',
                ],
                // 7. MBA - Operations & Supply Chain Management
                [
                    'slug' => 'mba',
                    'spec' => 'Operations and Supply Chain Management',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 8. MBA - Information Technology
                [
                    'slug' => 'mba',
                    'spec' => 'Information Technology',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],

                // 9. MCA - Artificial Intelligence & Machine Learning
                [
                    'slug' => 'mca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech (CSE/IT) or passed Bachelor\'s degree with Mathematics at 10+2 level or at graduation level with min 50% marks (45% for reserved category).',
                ],
                // 10. MCA - Data Science & Big Data Analytics
                [
                    'slug' => 'mca',
                    'spec' => 'Data Science',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech (CSE/IT) or passed Bachelor\'s degree with Mathematics at 10+2 level or at graduation level with min 50% marks (45% for reserved category).',
                ],
                // 11. MCA - Cyber Security & Ethical Hacking
                [
                    'slug' => 'mca',
                    'spec' => 'Cyber Security',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech (CSE/IT) or passed Bachelor\'s degree with Mathematics at 10+2 level or at graduation level with min 50% marks (45% for reserved category).',
                ],
                // 12. MCA - Cloud Computing & DevOps
                [
                    'slug' => 'mca',
                    'spec' => 'Cloud Computing',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech (CSE/IT) or passed Bachelor\'s degree with Mathematics at 10+2 level or at graduation level with min 50% marks (45% for reserved category).',
                ],
                // 13. MCA - Full Stack Software Development
                [
                    'slug' => 'mca',
                    'spec' => 'Software Engineering',
                    'fee' => 49000.00,
                    'type' => 'per_year',
                    'sem_fee' => 24500.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech (CSE/IT) or passed Bachelor\'s degree with Mathematics at 10+2 level or at graduation level with min 50% marks (45% for reserved category).',
                ],

                // 14. BBA - Marketing Management
                [
                    'slug' => 'bba',
                    'spec' => 'Marketing Management',
                    'fee' => 46000.00,
                    'type' => 'per_year',
                    'sem_fee' => 23000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 15. BBA - Financial Management
                [
                    'slug' => 'bba',
                    'spec' => 'Financial Management',
                    'fee' => 46000.00,
                    'type' => 'per_year',
                    'sem_fee' => 23000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 16. BBA - Human Resource Management
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 46000.00,
                    'type' => 'per_year',
                    'sem_fee' => 23000.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 17. BBA - Digital Marketing & E-Commerce
                [
                    'slug' => 'bba',
                    'spec' => 'Digital Marketing',
                    'fee' => 46000.00,
                    'type' => 'per_year',
                    'sem_fee' => 23000.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 18. BBA - Banking & Financial Services
                [
                    'slug' => 'bba',
                    'spec' => 'Banking and Finance',
                    'fee' => 46000.00,
                    'type' => 'per_year',
                    'sem_fee' => 23000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 19. BBA - General Management
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 46000.00,
                    'type' => 'per_year',
                    'sem_fee' => 23000.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],

                // 20. BCA - Data Science
                [
                    'slug' => 'bca',
                    'spec' => 'Data Science',
                    'fee' => 31000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15500.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Science/IT or equivalent with min 45% aggregate marks (40% for reserved category).',
                ],
                // 21. BCA - Cloud Computing
                [
                    'slug' => 'bca',
                    'spec' => 'Cloud Computing',
                    'fee' => 31000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15500.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Science/IT or equivalent with min 45% aggregate marks (40% for reserved category).',
                ],
                // 22. BCA - Cyber Security
                [
                    'slug' => 'bca',
                    'spec' => 'Cyber Security',
                    'fee' => 31000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15500.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Science/IT or equivalent with min 45% aggregate marks (40% for reserved category).',
                ],
                // 23. BCA - Artificial Intelligence
                [
                    'slug' => 'bca',
                    'spec' => 'Artificial Intelligence',
                    'fee' => 31000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15500.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Science/IT or equivalent with min 45% aggregate marks (40% for reserved category).',
                ],
                // 24. BCA - Software Development & Web Technologies
                [
                    'slug' => 'bca',
                    'spec' => 'Software Development',
                    'fee' => 31000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15500.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Science/IT or equivalent with min 45% aggregate marks (40% for reserved category).',
                ],

                // 25. B.Com - Accounting and Finance
                [
                    'slug' => 'bcom',
                    'spec' => 'Accounting and Finance',
                    'fee' => 23000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11500.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce stream or with Mathematics/Economics from a recognized board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 26. B.Com - Taxation and Auditing
                [
                    'slug' => 'bcom',
                    'spec' => 'Taxation and Auditing',
                    'fee' => 23000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11500.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce stream or with Mathematics/Economics from a recognized board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 27. B.Com - Banking and Insurance
                [
                    'slug' => 'bcom',
                    'spec' => 'Banking and Insurance',
                    'fee' => 23000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11500.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce stream or with Mathematics/Economics from a recognized board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 28. B.Com - International Business
                [
                    'slug' => 'bcom',
                    'spec' => 'International Business',
                    'fee' => 23000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11500.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce stream or with Mathematics/Economics from a recognized board with min 45% aggregate marks (40% for reserved category).',
                ],

                // 29. M.Com - Advanced Accounting & Financial Reporting
                [
                    'slug' => 'mcom',
                    'spec' => 'Accounting and Finance',
                    'fee' => 30000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15000.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation with B.Com / B.Com (Hons) / BBA or allied degree with min 50% aggregate marks (45% for reserved category).',
                ],
                // 30. M.Com - International Finance & Taxation
                [
                    'slug' => 'mcom',
                    'spec' => 'Taxation',
                    'fee' => 30000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation with B.Com / B.Com (Hons) / BBA or allied degree with min 50% aggregate marks (45% for reserved category).',
                ],
                // 31. M.Com - Banking & Financial Services
                [
                    'slug' => 'mcom',
                    'spec' => 'Banking and Finance',
                    'fee' => 30000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation with B.Com / B.Com (Hons) / BBA or allied degree with min 50% aggregate marks (45% for reserved category).',
                ],

                // 32. B.A. - English
                [
                    'slug' => 'ba',
                    'spec' => 'English',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized central or state board with min 45% aggregate marks.',
                ],
                // 33. B.A. - Economics
                [
                    'slug' => 'ba',
                    'spec' => 'Economics',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized central or state board with min 45% aggregate marks.',
                ],
                // 34. B.A. - Political Science
                [
                    'slug' => 'ba',
                    'spec' => 'Political Science',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized central or state board with min 45% aggregate marks.',
                ],
                // 35. B.A. - History
                [
                    'slug' => 'ba',
                    'spec' => 'History',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized central or state board with min 45% aggregate marks.',
                ],
                // 36. B.A. - Sociology
                [
                    'slug' => 'ba',
                    'spec' => 'Sociology',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized central or state board with min 45% aggregate marks.',
                ],

                // 37. M.A. - English Literature
                [
                    'slug' => 'ma',
                    'spec' => 'English',
                    'fee' => 20000.00,
                    'type' => 'per_year',
                    'sem_fee' => 10000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% aggregate marks.',
                ],
                // 38. M.A. - Economics
                [
                    'slug' => 'ma',
                    'spec' => 'Economics',
                    'fee' => 20000.00,
                    'type' => 'per_year',
                    'sem_fee' => 10000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% aggregate marks.',
                ],
                // 39. M.A. - Political Science
                [
                    'slug' => 'ma',
                    'spec' => 'Political Science',
                    'fee' => 20000.00,
                    'type' => 'per_year',
                    'sem_fee' => 10000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% aggregate marks.',
                ],
                // 40. M.A. - Sociology
                [
                    'slug' => 'ma',
                    'spec' => 'Sociology',
                    'fee' => 20000.00,
                    'type' => 'per_year',
                    'sem_fee' => 10000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% aggregate marks.',
                ],
                // 41. M.A. - Psychology
                [
                    'slug' => 'ma',
                    'spec' => 'Psychology',
                    'fee' => 20000.00,
                    'type' => 'per_year',
                    'sem_fee' => 10000.00,
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% aggregate marks.',
                ],
            ],

            // Key Highlights
            'highlights' => [
                ['title' => 'UGC-DEB Entitled Online Degrees', 'value' => 'Complete Parity with On-Campus Regular Degrees', 'icon' => 'bi-shield-check'],
                ['title' => 'NAAC Grade A+ Accreditation', 'value' => 'CGPA 3.48 Score & AICTE Statutory Approval', 'icon' => 'bi-patch-check-fill'],
                ['title' => '70-Acre NCR Campus Heritage', 'value' => 'Corporate-Centric Hub in Gurugram, Delhi-NCR', 'icon' => 'bi-building'],
                ['title' => '100% Online Self-Paced LMS', 'value' => 'Accessible 24/7 with Android & iOS Mobile App', 'icon' => 'bi-laptop'],
                ['title' => 'Weekend Live Masterclasses', 'value' => 'Sessions by Renowned Academicians & Industry Leaders', 'icon' => 'bi-camera-video'],
                ['title' => 'AI-Proctored Remote Exams', 'value' => 'Appear for Tests from the Comfort & Safety of Home', 'icon' => 'bi-display'],
                ['title' => 'Corporate Career Placement Cell', 'value' => 'Backed by 500+ Top Recruiting Organizations', 'icon' => 'bi-briefcase-fill'],
                ['title' => 'Flexible No-Cost EMI Options', 'value' => 'Easy Monthly Installments Starting from ₹2,500/Month', 'icon' => 'bi-credit-card-2-front'],
            ],

            // Accreditations
            'accreditations' => [
                ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled to offer Full Online Degree Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council Grade A+', 'grade' => 'A+ (3.48)', 'rank' => null, 'year' => '2023'],
                ['authority' => 'AICTE', 'accreditation' => 'All India Council for Technical Education Approval', 'grade' => null, 'rank' => null, 'year' => '2024'],
                ['authority' => 'AIU', 'accreditation' => 'Association of Indian Universities Permanent Member', 'grade' => null, 'rank' => null, 'year' => '2018'],
                ['authority' => 'Statutory Bodies', 'accreditation' => 'BCI, PCI, DCI, and INC Recognitions', 'grade' => null, 'rank' => null, 'year' => '2024'],
            ],

            // Digital Facilities
            'facilities' => [
                [
                    'name' => 'Next-Gen Learning Management System (LMS)',
                    'description' => 'State-of-the-art digital portal with 24/7 access to e-content, session recordings, and self-assessment modules.',
                ],
                [
                    'name' => 'Live Interactive Digital Classrooms',
                    'description' => 'Two-way audio-video sessions with faculty, doubt clearing webinars, and guest lectures on weekends.',
                ],
                [
                    'name' => 'Digital Library & E-Resources',
                    'description' => 'Instant access to thousands of e-books, research publications, Delnet, and international business journals.',
                ],
                [
                    'name' => 'AI-Proctored Remote Examination System',
                    'description' => 'Secure web-camera based proctored examination platform enabling students to take semester exams from anywhere.',
                ],
                [
                    'name' => 'Dedicated Student Mentor & Support Desk',
                    'description' => 'One-on-one academic mentors and a responsive ticketing helpdesk for instant technical and academic assistance.',
                ],
                [
                    'name' => 'Corporate Placement Assistance Cell',
                    'description' => 'Resume polishing, virtual interview prep, soft skills workshops, and corporate job drive alerts.',
                ],
            ],

            // FAQs
            'faqs' => [
                [
                    'question' => 'Is SGT University Online degree approved by UGC and DEB?',
                    'answer' => 'Yes. SGT University (Shree Guru Gobind Singh Tricentenary University) is fully entitled by the University Grants Commission - Distance Education Bureau (UGC-DEB) and approved by AICTE. Degrees awarded hold 100% legal parity with traditional on-campus degrees under UGC regulations.',
                ],
                [
                    'question' => 'How are semester exams conducted at SGT University Online?',
                    'answer' => 'All semester examinations are conducted 100% online in remote proctored mode. Students can appear for examinations from their home using a computer or laptop with a working webcam, microphone, and stable internet connection.',
                ],
                [
                    'question' => 'Can working professionals easily balance this degree with full-time work?',
                    'answer' => 'Absolutely. The online programs are tailored specifically for working professionals. Study materials and lecture recordings are accessible 24/7 on the LMS, and live interactive classes are held on weekends to avoid weekday work clashes.',
                ],
                [
                    'question' => 'What is the fee payment structure? Is EMI facility available?',
                    'answer' => 'Fees can be paid semester-wise or annually. SGT University Online also provides convenient 0% interest monthly EMI options through verified education finance partners starting from ₹2,500/month.',
                ],
                [
                    'question' => 'Are SGT University Online degrees accepted for government jobs and UPSC exams?',
                    'answer' => 'Yes. Entitled online degrees from UGC-recognized universities are completely valid for all Union and State Government competitive examinations (UPSC, SSC, State PSC, Banking, Railways) as well as higher education across India and globally.',
                ],
                [
                    'question' => 'Does SGT University Online provide career and placement support?',
                    'answer' => 'Yes. SGT University provides dedicated placement support through its Corporate Resource Centre (CRC), including resume workshops, aptitude and mock interview sessions, and virtual placement drives featuring over 500+ corporate recruiters.',
                ],
                [
                    'question' => 'What is the minimum eligibility criteria for Online MBA and MCA at SGT University?',
                    'answer' => 'For Online MBA, a Bachelor\'s degree in any discipline with min 50% marks (45% for reserved categories) is required. For Online MCA, a BCA/B.Sc.(CS/IT) or graduation with Mathematics at 10+2 or degree level with min 50% marks (45% for reserved categories) is required.',
                ],
                [
                    'question' => 'How can I access study material and class recordings?',
                    'answer' => 'Upon enrollment, every student receives personalized login credentials for the SGT University Online LMS and mobile app, where all e-books, study guides, video archives, and discussion forums are available 24/7.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹18.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹5.50 LPA', 'year' => '2024'],
                ['label' => 'Hiring Partners', 'value' => '500+ Companies', 'year' => '2024'],
                ['label' => 'Dedicated Placement Support', 'value' => '100% Virtual Career Services', 'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'Deloitte', 'Infosys', 'Tech Mahindra', 'Fortis Healthcare', 'Max Healthcare',
                'Radisson', 'IBM', 'TCS', 'Wipro', 'ICICI Bank', 'HDFC Bank', 'Cognizant',
                'Reliance Jio', 'Genpact', 'Accenture',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Academic Merit Scholarship',
                    'eligibility' => 'Candidates scoring >=80% aggregate in the qualifying examination.',
                    'criteria' => 'Academic Merit Performance',
                    'amount' => null,
                    'amount_label' => 'Up to 20% Tuition Fee Waiver',
                    'percentage' => '20%',
                    'description' => 'Merit incentive for high academic performers across all online degree programs.',
                ],
                [
                    'name' => 'Defense & Paramilitary Concession',
                    'eligibility' => 'Serving or retired armed forces personnel, paramilitary staff, and their direct dependents.',
                    'criteria' => 'Defense Service ID / PPO',
                    'amount' => null,
                    'amount_label' => '15% Tuition Fee Concession',
                    'percentage' => '15%',
                    'description' => 'Tuition fee reduction dedicated to serving and veteran defense families.',
                ],
                [
                    'name' => 'SGT Alumni & Staff Privilege',
                    'eligibility' => 'Alumni of SGT Group of Institutions or staff members and their wards.',
                    'criteria' => 'Alumni Registration / Employee Code',
                    'amount' => null,
                    'amount_label' => '15% Special Fee Privilege',
                    'percentage' => '15%',
                    'description' => 'Tuition rebate for the extended SGT academic family.',
                ],
                [
                    'name' => 'Divyangjan / PwD Scholarship',
                    'eligibility' => 'Differently-abled candidates with valid disability certificate (>=40%).',
                    'criteria' => 'Disability Certificate',
                    'amount' => null,
                    'amount_label' => '15% Fee Concession',
                    'percentage' => '15%',
                    'description' => 'Empowerment support for students with physical disabilities.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Online Admission at SGT University Online',
                    'content' => 'The entire admission procedure is digital, streamlined, and hassle-free.',
                    'items' => [
                        'Step 1: Visit the official portal sgtonline.in or apply through GrowPec.',
                        'Step 2: Fill out the online registration form and select your desired degree & specialization.',
                        'Step 3: Upload digital scanned copies of qualifying marksheets, photo, and government ID.',
                        'Step 4: Academic verification by the university admissions panel.',
                        'Step 5: Pay the semester fee or choose the monthly EMI option to confirm admission.',
                        'Step 6: Receive university LMS credentials and student registration number.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required for SGT University Online Enrollment',
                    'content' => 'Keep digital self-attested copies ready during admission:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (Birth date verification)',
                        'Class 12th Certificate & Marksheet (For all UG & PG admissions)',
                        'Graduation Degree Certificate & All Semester Marksheets (For PG programs)',
                        'Valid Government Photo ID Proof (Aadhaar Card / Voter ID / Passport)',
                        'Recent Passport-Sized Colored Photograph',
                        'Category / Disability / Defense Certificate (If applying for applicable scholarships)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 5. Swami Vivekanand Subharti University Distance & Online (Meerut, UP)
    |--------------------------------------------------------------------------
    */
    private function subhartiUniversity(): array
    {
        return [
            'name' => 'Swami Vivekanand Subharti University Online & Distance, Meerut',
            'short_name' => 'Subharti University DDE',
            'slug' => 'subharti-university-online',
            'type' => 'Private',
            'university' => 'Swami Vivekanand Subharti University (SVSU), Meerut',
            'website' => 'https://subhartidde.com',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => 'Subhartipuram, NH-58, Delhi-Haridwar Bypass Road, Meerut, Uttar Pradesh - 250005',
            'year' => '2008',
            'campus' => 'Directorate of Distance Education (DDE), 250-Acre Subhartipuram Campus',
            'approvals' => 'UGC-DEB | AICTE | NAAC A | AIU | BCI | MCI | DCI | INC',
            'naac_grade' => 'A',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'Direct Admission / Merit Based',
            'rating' => 4.4,
            'reviews_count' => 520,
            'highest' => '₹12.00 LPA',
            'average' => '₹4.20 LPA',
            'top_recruiters' => 'Wipro, TCS, Infosys, Tech Mahindra, HCL, Genpact, ICICI Bank, Axis Bank, Paytm, Teleperformance, Fortis Healthcare, Max Healthcare',
            'is_featured' => true,
            'overview' => 'Swami Vivekanand Subharti University (SVSU), established under the UP State Universities Act and recognized by the University Grants Commission (UGC) under Section 2(f) and 12(B), offers premier distance and online education through its Directorate of Distance Education (DDE). Accredited with NAAC Grade \'A\' and fully entitled by the UGC - Distance Education Bureau (UGC-DEB), Subharti University DDE provides affordable, accessible, and high-quality higher education across management, computer applications, commerce, humanities, and library science. Situated on a massive 250-acre green campus in Meerut, Subharti integrates self-instructional print and e-learning material (e-SLM), robust Learning Management System (LMS) access, weekend counseling sessions, and reliable evaluation systems. Subharti\'s distance and online degrees have complete equivalence to conventional on-campus degrees under UGC norms, qualifying alumni for central and state government jobs (including UPSC and SSC), private corporate careers, and further doctoral or international studies.',
            'scholarship_info' => 'Subharti University DDE offers 20% fee concession for defense personnel and war widows, 20% concession for differently-abled (PwD) students, 10% fee reduction for Subharti alumni and staff dependents, and flexible semester-wise fee installment options.',

            // Authentic Programs with 100% Accurate Fees & Specializations
            'courses' => [
                // 1. MBA - Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45-50% marks (40% for reserved category).',
                ],
                // 2. MBA - Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45-50% marks (40% for reserved category).',
                ],
                // 3. MBA - Human Resource Management
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45-50% marks (40% for reserved category).',
                ],
                // 4. MBA - Information Technology
                [
                    'slug' => 'mba',
                    'spec' => 'Information Technology',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45-50% marks (40% for reserved category).',
                ],
                // 5. MBA - Operations & Production Management
                [
                    'slug' => 'mba',
                    'spec' => 'Operations and Supply Chain Management',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45-50% marks (40% for reserved category).',
                ],
                // 6. MBA - Hospital & Healthcare Management
                [
                    'slug' => 'mba',
                    'spec' => 'Hospital and Health Care Management',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline (Life Sciences/Health/Medicine preferred) with min 45-50% marks.',
                ],
                // 7. MBA - International Business
                [
                    'slug' => 'mba',
                    'spec' => 'International Business',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45-50% marks.',
                ],

                // 8. MCA - Software Engineering
                [
                    'slug' => 'mca',
                    'spec' => 'Software Engineering',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech or Bachelor\'s with Mathematics at 10+2 or degree level with min 50% marks (45% for reserved category).',
                ],
                // 9. MCA - Data Science
                [
                    'slug' => 'mca',
                    'spec' => 'Data Science',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 350,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech or Bachelor\'s with Mathematics at 10+2 or degree level with min 50% marks (45% for reserved category).',
                ],
                // 10. MCA - Cloud Computing
                [
                    'slug' => 'mca',
                    'spec' => 'Cloud Computing',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 350,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech or Bachelor\'s with Mathematics at 10+2 or degree level with min 50% marks (45% for reserved category).',
                ],
                // 11. MCA - Artificial Intelligence & Machine Learning
                [
                    'slug' => 'mca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 32000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16000.00,
                    'duration' => '2 Years',
                    'seats' => 350,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech or Bachelor\'s with Mathematics at 10+2 or degree level with min 50% marks (45% for reserved category).',
                ],

                // 12. BBA - Marketing Management
                [
                    'slug' => 'bba',
                    'spec' => 'Marketing Management',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 13. BBA - Financial Management
                [
                    'slug' => 'bba',
                    'spec' => 'Financial Management',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 14. BBA - Human Resource Management
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 15. BBA - General Management
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],

                // 16. BCA - Software Development
                [
                    'slug' => 'bca',
                    'spec' => 'Software Development',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Application or equivalent with min 45% marks (40% for reserved category).',
                ],
                // 17. BCA - Web Technologies
                [
                    'slug' => 'bca',
                    'spec' => 'Information Technology',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Application or equivalent with min 45% marks (40% for reserved category).',
                ],
                // 18. BCA - Database Management
                [
                    'slug' => 'bca',
                    'spec' => 'Data Science',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Application or equivalent with min 45% marks (40% for reserved category).',
                ],
                // 19. BCA - Cloud & Systems
                [
                    'slug' => 'bca',
                    'spec' => 'Cloud Computing',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Application or equivalent with min 45% marks (40% for reserved category).',
                ],

                // 20. B.Com - Accounting and Finance
                [
                    'slug' => 'bcom',
                    'spec' => 'Accounting and Finance',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 600,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce stream or with Mathematics/Economics from a recognized board with min 40-45% marks.',
                ],
                // 21. B.Com - Banking and Insurance
                [
                    'slug' => 'bcom',
                    'spec' => 'Banking and Insurance',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce stream or with Mathematics/Economics from a recognized board with min 40-45% marks.',
                ],
                // 22. B.Com - General Commerce
                [
                    'slug' => 'bcom',
                    'spec' => 'General Commerce',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce stream or with Mathematics/Economics from a recognized board with min 40-45% marks.',
                ],

                // 23. M.Com - Advanced Accounting & Auditing
                [
                    'slug' => 'mcom',
                    'spec' => 'Accounting and Finance',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 350,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation with B.Com / B.Com (Hons) / BBA or allied degree with min 45% aggregate marks.',
                ],
                // 24. M.Com - Financial Management
                [
                    'slug' => 'mcom',
                    'spec' => 'Banking and Finance',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 350,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation with B.Com / B.Com (Hons) / BBA or allied degree with min 45% aggregate marks.',
                ],

                // 25. B.A. - English
                [
                    'slug' => 'ba',
                    'spec' => 'English',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board.',
                ],
                // 26. B.A. - Hindi
                [
                    'slug' => 'ba',
                    'spec' => 'Hindi',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board.',
                ],
                // 27. B.A. - History
                [
                    'slug' => 'ba',
                    'spec' => 'History',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board.',
                ],
                // 28. B.A. - Political Science
                [
                    'slug' => 'ba',
                    'spec' => 'Political Science',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board.',
                ],
                // 29. B.A. - Sociology
                [
                    'slug' => 'ba',
                    'spec' => 'Sociology',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board.',
                ],
                // 30. B.A. - Economics
                [
                    'slug' => 'ba',
                    'spec' => 'Economics',
                    'fee' => 10000.00,
                    'type' => 'per_year',
                    'sem_fee' => 5000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board.',
                ],

                // 31. M.A. - English Literature
                [
                    'slug' => 'ma',
                    'spec' => 'English',
                    'fee' => 13000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 32. M.A. - Hindi Literature
                [
                    'slug' => 'ma',
                    'spec' => 'Hindi',
                    'fee' => 13000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 33. M.A. - History
                [
                    'slug' => 'ma',
                    'spec' => 'History',
                    'fee' => 13000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 34. M.A. - Political Science
                [
                    'slug' => 'ma',
                    'spec' => 'Political Science',
                    'fee' => 13000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 35. M.A. - Sociology
                [
                    'slug' => 'ma',
                    'spec' => 'Sociology',
                    'fee' => 13000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 36. M.A. - Economics
                [
                    'slug' => 'ma',
                    'spec' => 'Economics',
                    'fee' => 13000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],

                // 37. BLIS - Bachelor of Library & Information Science
                [
                    'slug' => 'blis',
                    'spec' => 'Library and Information Science',
                    'fee' => 14000.00,
                    'type' => 'per_year',
                    'sem_fee' => 7000.00,
                    'duration' => '1 Year',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation in any discipline from a recognized university with min 45% aggregate marks.',
                ],

                // 38. MLIS - Master of Library & Information Science
                [
                    'slug' => 'mlis',
                    'spec' => 'Library and Information Science',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '1 Year',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BLIS (Bachelor of Library & Information Science) from a recognized university.',
                ],

                // 39. BA JMC - Print & Electronic Media
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Print and Electronic Media',
                    'fee' => 18000.00,
                    'type' => 'per_year',
                    'sem_fee' => 9000.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized Central or State Board in any stream.',
                ],
                // 40. BA JMC - Digital Journalism & PR
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Digital Journalism',
                    'fee' => 18000.00,
                    'type' => 'per_year',
                    'sem_fee' => 9000.00,
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized Central or State Board in any stream.',
                ],

                // 41. MA JMC - Mass Communication & Media Management
                [
                    'slug' => 'ma-jmc',
                    'spec' => 'Mass Communication and Media Management',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11000.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation in any discipline from a recognized university with min 45% marks.',
                ],
                // 42. MA JMC - Digital Broadcasting
                [
                    'slug' => 'ma-jmc',
                    'spec' => 'Digital Broadcasting',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11000.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation in any discipline from a recognized university with min 45% marks.',
                ],
            ],

            // Key Highlights
            'highlights' => [
                ['title' => 'UGC-DEB Entitled Distance Programs', 'value' => 'Conferred Full Entitlement by UGC Distance Education Bureau', 'icon' => 'bi-shield-check'],
                ['title' => 'NAAC Grade A Accredited University', 'value' => 'High Quality Academic Benchmarks & Rigorous Faculty Governance', 'icon' => 'bi-patch-check-fill'],
                ['title' => '250-Acre Lush Green Campus (Subhartipuram)', 'value' => 'Mega Multi-Disciplinary University Campus in Meerut, Delhi-NCR', 'icon' => 'bi-building'],
                ['title' => '15+ Years Distance Learning Heritage', 'value' => 'Trusted by Over 1,00,000+ Enrolled Students Across India', 'icon' => 'bi-award-fill'],
                ['title' => 'Comprehensive Print & e-SLM Modules', 'value' => 'High Quality Study Material Authored by Leading Subject Experts', 'icon' => 'bi-book-half'],
                ['title' => 'Live Weekend Interactive Counseling', 'value' => 'Webinars, Doubt Resolution Sessions & Recorded Video Archives', 'icon' => 'bi-camera-video'],
                ['title' => 'Complete UGC Government Equivalence', 'value' => '100% Eligible for UPSC, SSC, Defense, State PSCs & Higher Studies', 'icon' => 'bi-check-circle-fill'],
                ['title' => 'Affordable Government-Level Fees with Installments', 'value' => 'Easy Semester Fee Payments & Direct Defense Concessions', 'icon' => 'bi-credit-card-2-front'],
            ],

            // Accreditations
            'accreditations' => [
                ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled for Open & Distance Learning (ODL) Degree Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                ['authority' => 'UGC 12(B)', 'accreditation' => 'Recognized under Section 2(f) & 12(B) of the UGC Act 1956', 'grade' => '12(B)', 'rank' => null, 'year' => '2016'],
                ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council Grade A', 'grade' => 'A', 'rank' => null, 'year' => '2022'],
                ['authority' => 'AICTE', 'accreditation' => 'All India Council for Technical Education Statutory Approval', 'grade' => null, 'rank' => null, 'year' => '2024'],
                ['authority' => 'AIU', 'accreditation' => 'Association of Indian Universities Permanent Member', 'grade' => null, 'rank' => null, 'year' => '2010'],
                ['authority' => 'Statutory Councils', 'accreditation' => 'Recognized by BCI, MCI, DCI, and INC across professional disciplines', 'grade' => null, 'rank' => null, 'year' => '2024'],
            ],

            // Digital Facilities
            'facilities' => [
                ['name' => 'Subharti DDE Cloud Student Portal & E-Learning LMS', 'icon' => 'bi-laptop'],
                ['name' => 'Self-Instructional Material (e-SLM & Audio-Visual Lectures)', 'icon' => 'bi-journal-bookmark'],
                ['name' => 'Digital Assignment Submission & Evaluation Platform', 'icon' => 'bi-file-earmark-check'],
                ['name' => 'Student Helpdesk & Grievance Redressal Support Cell', 'icon' => 'bi-headset'],
                ['name' => 'Online Examination Registration & Admit Card Management', 'icon' => 'bi-ui-checks'],
                ['name' => 'Central Digital Library Access with E-Journals & Delnet', 'icon' => 'bi-book'],
            ],

            // FAQs
            'faqs' => [
                [
                    'question' => 'Is Subharti University Distance degree valid and approved by UGC-DEB?',
                    'answer' => 'Yes. Swami Vivekanand Subharti University (SVSU) is a recognized university under Section 2(f) and 12(B) of the UGC Act, and its Directorate of Distance Education (DDE) is fully entitled by the UGC - Distance Education Bureau (UGC-DEB) to offer distance education degree programs.',
                ],
                [
                    'question' => 'Can Subharti Distance graduates apply for government jobs and competitive exams?',
                    'answer' => 'Yes, absolutely. Under official UGC regulations, degrees obtained through distance/online mode from UGC-DEB entitled universities have 100% equivalence to on-campus degrees and are fully accepted for all Union and State government examinations (UPSC, SSC, Banking, Railways, State PSC) and corporate jobs.',
                ],
                [
                    'question' => 'How are study materials provided to enrolled students?',
                    'answer' => 'Students receive comprehensive Self-Learning Material (SLM) prepared by subject experts. Enrolled candidates can access digital e-SLM (PDFs) and video lecture archives 24/7 through the Subharti DDE student portal, and optional printed study material can also be availed.',
                ],
                [
                    'question' => 'How are semester examinations conducted at Subharti DDE?',
                    'answer' => 'Examinations are conducted in accordance with UGC-DEB guidelines at designated university examination centers and through digital evaluation modules. Admit cards, date sheets, and result declarations are managed seamlessly through the online student portal.',
                ],
                [
                    'question' => 'Are Library Science (BLIS & MLIS) programs offered by Subharti DDE?',
                    'answer' => 'Yes. Subharti University DDE offers 1-year Bachelor of Library & Information Science (BLIS) and 1-year Master of Library & Information Science (MLIS) programs recognized by UGC-DEB.',
                ],
                [
                    'question' => 'Can fees be paid on a semester-wise basis?',
                    'answer' => 'Yes. Subharti DDE provides student-friendly fee structures with semester-wise payment flexibility to make higher education accessible to everyone.',
                ],
                [
                    'question' => 'Are there any fee concessions for defense personnel and war widows?',
                    'answer' => 'Yes. Subharti University DDE offers a special 20% tuition fee concession for Indian Armed Forces & Paramilitary personnel, ex-servicemen, and war widows.',
                ],
                [
                    'question' => 'What is the step-by-step admission process for Subharti DDE?',
                    'answer' => 'Admissions are 100% digital. Applicants register online at subhartidde.com or through GrowPec, submit their academic details, upload self-attested document copies, pay the semester fee online, and receive their student enrollment number and portal login.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹12.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹4.20 LPA', 'year' => '2024'],
                ['label' => 'Hiring Partners', 'value' => '300+ Companies', 'year' => '2024'],
                ['label' => 'Enrolled Distance Alumni Network', 'value' => '1,00,000+ Students', 'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'Wipro', 'TCS', 'Infosys', 'Tech Mahindra', 'HCL', 'Genpact', 'ICICI Bank',
                'Axis Bank', 'Paytm', 'Teleperformance', 'Fortis Healthcare', 'Max Healthcare',
                'Reliance', 'Cognizant', 'Concentrix',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Defense Personnel & War Widows Concession',
                    'eligibility' => 'Serving and retired defense/paramilitary personnel, war widows, and their direct dependents.',
                    'criteria' => 'Defense ID / PPO / Discharge Book',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Dedicated tuition fee relief honouring brave armed forces personnel and defense families.',
                ],
                [
                    'name' => 'Differently-Abled (PwD) Scholarship',
                    'eligibility' => 'Physically challenged candidates holding valid government disability certificate (>=40%).',
                    'criteria' => 'Disability Certificate',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Financial encouragement enabling higher education access for differently-abled learners.',
                ],
                [
                    'name' => 'Subharti Alumni & Staff Privilege',
                    'eligibility' => 'Subharti University alumni or university staff members and their wards.',
                    'criteria' => 'Alumni Registration / Employee Verification',
                    'amount' => null,
                    'amount_label' => '10% Fee Rebate',
                    'percentage' => '10%',
                    'description' => 'Fee discount extended to the Subharti institutional community.',
                ],
                [
                    'name' => 'Academic Merit Incentive',
                    'eligibility' => 'Candidates with outstanding academic performance (>=75% marks in qualifying exams).',
                    'criteria' => 'Academic Merit Performance',
                    'amount' => null,
                    'amount_label' => '10% Tuition Fee Waiver',
                    'percentage' => '10%',
                    'description' => 'Merit encouragement for meritorious students across undergraduate and postgraduate programs.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Distance & Online Admission at Subharti University',
                    'content' => 'The admission procedure at Subharti DDE is smooth and transparent:',
                    'items' => [
                        'Step 1: Fill out the online registration form on subhartidde.com or apply through GrowPec.',
                        'Step 2: Choose your desired program (UG / PG / Diploma) and elective specialization.',
                        'Step 3: Upload digital scanned copies of qualifying examination certificates and ID proof.',
                        'Step 4: Scrutiny and document verification by the Directorate of Distance Education.',
                        'Step 5: Pay the semester fee online using Debit/Credit Card, Net Banking, or UPI.',
                        'Step 6: Receive confirmation email with your official Enrollment Number and LMS credentials.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Checklist for Subharti DDE Admission',
                    'content' => 'Keep digital scanned copies ready for upload:',
                    'items' => [
                        'Class 10th High School Certificate & Marksheet (Date of birth proof)',
                        'Class 12th Intermediate Certificate & Marksheet (For all UG & PG programs)',
                        'Graduation Degree Certificate & All Semester Marksheets (For PG, BLIS & MLIS programs)',
                        'BLIS Degree Certificate & Marksheet (Required specifically for MLIS applicants)',
                        'Valid Government Photo ID Proof (Aadhaar Card / Voter ID / Driving License)',
                        'Recent Passport-Sized Colored Photograph',
                        'Defense / Disability / Category Certificate (If availing fee concession)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 6. Mangalayatan University Online / CDOE (Aligarh, Uttar Pradesh)
    |--------------------------------------------------------------------------
    */
    private function mangalayatanUniversity(): array
    {
        return [
            'name' => 'Mangalayatan University Online, Aligarh',
            'short_name' => 'Mangalayatan University Online',
            'slug' => 'mangalayatan-university-online',
            'type' => 'Private',
            'university' => 'Mangalayatan University, Aligarh',
            'website' => 'https://online.mangalayatan.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Aligarh',
            'address' => 'Extended NCR 33rd Milestone, Aligarh-Mathura Highway, Beswan, Aligarh, Uttar Pradesh - 202145',
            'year' => '2006',
            'campus' => 'Centre for Distance & Online Education (CDOE), 70-Acre Main Campus',
            'approvals' => 'UGC-DEB | AICTE | NAAC A+ | BCI | PCI | NCTE | AIU',
            'naac_grade' => 'A+',
            'ugc_approved' => true,
            'nirf_rank' => null,
            'nirf_year' => null,
            'entrance_exams' => 'Direct Admission / Merit Based',
            'rating' => 4.5,
            'reviews_count' => 390,
            'highest' => '₹14.50 LPA',
            'average' => '₹4.80 LPA',
            'top_recruiters' => 'TCS, Infosys, Tech Mahindra, HCL, Abbott, Wipro, ICICI Bank, IndusInd Bank, Justdial, Concentrix, Reliance Retail, Radisson',
            'is_featured' => true,
            'overview' => 'Mangalayatan University (Centre for Distance & Online Education - CDOE), established under the Uttar Pradesh State Universities Act and recognized by the University Grants Commission (UGC) under Section 2(f) and 12(B), is a premier multidisciplinary institution situated on a sprawling 70-acre lush green campus near Aligarh-Mathura highway. Accredited with NAAC Grade \'A+\' and entitled by the University Grants Commission - Distance Education Bureau (UGC-DEB), Mangalayatan University Online offers career-transforming undergraduate and postgraduate programs across Management, Information Technology, Commerce, Humanities, and Library Science. With state-of-the-art e-learning pedagogies, AI-enabled Learning Management System (LMS) with 24/7 access, live and recorded masterclasses by distinguished academia and industry practitioners, and remote AI-proctored online examinations, students experience world-class higher education from anywhere. All online and distance degrees conferred by Mangalayatan University carry complete legal equivalence to regular on-campus degrees under UGC (ODL & Online Programs) Regulations, ensuring universal recognition for corporate placements, government sector jobs (UPSC, SSC, State PSC), and global higher education.',
            'scholarship_info' => 'Mangalayatan University Online offers a 20% Academic Merit Scholarship for candidates scoring above 75% in qualifying examinations, 20% special fee concession for Defense Personnel and their direct dependents, 15% concession for differently-abled (PwD) students, and flexible No-Cost EMI payment plans starting from ₹2,000/month.',

            // Authentic Programs with 100% Accurate Fees & Specializations
            'courses' => [
                // 1. MBA - Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 2. MBA - Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 3. MBA - Human Resource Management
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 4. MBA - Operations Management
                [
                    'slug' => 'mba',
                    'spec' => 'Operations and Supply Chain Management',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 5. MBA - Information Technology
                [
                    'slug' => 'mba',
                    'spec' => 'Information Technology',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 6. MBA - International Business
                [
                    'slug' => 'mba',
                    'spec' => 'International Business',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],
                // 7. MBA - Hospital & Healthcare Management
                [
                    'slug' => 'mba',
                    'spec' => 'Hospital and Health Care Management',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (Health Sciences/B.Sc. preferred).',
                ],
                // 8. MBA - Digital Marketing
                [
                    'slug' => 'mba',
                    'spec' => 'Digital Marketing',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for reserved category) from a recognized university.',
                ],

                // 9. MCA - Software Engineering
                [
                    'slug' => 'mca',
                    'spec' => 'Software Engineering',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech or Bachelor\'s with Mathematics at 10+2 or degree level with min 50% marks (45% for reserved category).',
                ],
                // 10. MCA - Data Science
                [
                    'slug' => 'mca',
                    'spec' => 'Data Science',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 350,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech or Bachelor\'s with Mathematics at 10+2 or degree level with min 50% marks (45% for reserved category).',
                ],
                // 11. MCA - Cloud Computing
                [
                    'slug' => 'mca',
                    'spec' => 'Cloud Computing',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 350,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech or Bachelor\'s with Mathematics at 10+2 or degree level with min 50% marks (45% for reserved category).',
                ],
                // 12. MCA - Artificial Intelligence & Machine Learning
                [
                    'slug' => 'mca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 350,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech or Bachelor\'s with Mathematics at 10+2 or degree level with min 50% marks (45% for reserved category).',
                ],
                // 13. MCA - Cyber Security
                [
                    'slug' => 'mca',
                    'spec' => 'Cyber Security',
                    'fee' => 36000.00,
                    'type' => 'per_year',
                    'sem_fee' => 18000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / B.Sc. (CS/IT) / BE / B.Tech or Bachelor\'s with Mathematics at 10+2 or degree level with min 50% marks (45% for reserved category).',
                ],

                // 14. BBA - Marketing Management
                [
                    'slug' => 'bba',
                    'spec' => 'Marketing Management',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 15. BBA - Financial Management
                [
                    'slug' => 'bba',
                    'spec' => 'Financial Management',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 16. BBA - Human Resource Management
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 17. BBA - Digital Business & E-Commerce
                [
                    'slug' => 'bba',
                    'spec' => 'Digital Marketing',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],
                // 18. BBA - General Management
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 45% aggregate marks (40% for reserved category).',
                ],

                // 19. BCA - Software Development
                [
                    'slug' => 'bca',
                    'spec' => 'Software Development',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Science/IT or equivalent with min 45% marks (40% for reserved category).',
                ],
                // 20. BCA - Data Science
                [
                    'slug' => 'bca',
                    'spec' => 'Data Science',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Science/IT or equivalent with min 45% marks (40% for reserved category).',
                ],
                // 21. BCA - Cloud Computing
                [
                    'slug' => 'bca',
                    'spec' => 'Cloud Computing',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Science/IT or equivalent with min 45% marks (40% for reserved category).',
                ],
                // 22. BCA - Cyber Security
                [
                    'slug' => 'bca',
                    'spec' => 'Cyber Security',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Science/IT or equivalent with min 45% marks (40% for reserved category).',
                ],
                // 23. BCA - Artificial Intelligence
                [
                    'slug' => 'bca',
                    'spec' => 'Artificial Intelligence',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from a recognized board with Mathematics/Computer Science/IT or equivalent with min 45% marks (40% for reserved category).',
                ],

                // 24. B.Com - Accounting and Finance
                [
                    'slug' => 'bcom',
                    'spec' => 'Accounting and Finance',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce stream or with Mathematics/Economics from a recognized board with min 45% marks (40% for reserved category).',
                ],
                // 25. B.Com - Banking and Insurance
                [
                    'slug' => 'bcom',
                    'spec' => 'Banking and Insurance',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce stream or with Mathematics/Economics from a recognized board with min 45% marks (40% for reserved category).',
                ],
                // 26. B.Com - Taxation and Auditing
                [
                    'slug' => 'bcom',
                    'spec' => 'Taxation and Auditing',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce stream or with Mathematics/Economics from a recognized board with min 45% marks (40% for reserved category).',
                ],

                // 27. M.Com - Accounting and Finance
                [
                    'slug' => 'mcom',
                    'spec' => 'Accounting and Finance',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation with B.Com / B.Com (Hons) / BBA or allied degree with min 50% aggregate marks (45% for reserved category).',
                ],
                // 28. M.Com - Banking and Financial Services
                [
                    'slug' => 'mcom',
                    'spec' => 'Banking and Finance',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation with B.Com / B.Com (Hons) / BBA or allied degree with min 50% aggregate marks (45% for reserved category).',
                ],
                // 29. M.Com - International Trade and Taxation
                [
                    'slug' => 'mcom',
                    'spec' => 'Taxation',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11000.00,
                    'duration' => '2 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation with B.Com / B.Com (Hons) / BBA or allied degree with min 50% aggregate marks (45% for reserved category).',
                ],

                // 30. B.A. - English
                [
                    'slug' => 'ba',
                    'spec' => 'English',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 40-45% marks.',
                ],
                // 31. B.A. - Hindi
                [
                    'slug' => 'ba',
                    'spec' => 'Hindi',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 40-45% marks.',
                ],
                // 32. B.A. - History
                [
                    'slug' => 'ba',
                    'spec' => 'History',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 40-45% marks.',
                ],
                // 33. B.A. - Political Science
                [
                    'slug' => 'ba',
                    'spec' => 'Political Science',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 40-45% marks.',
                ],
                // 34. B.A. - Sociology
                [
                    'slug' => 'ba',
                    'spec' => 'Sociology',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 40-45% marks.',
                ],
                // 35. B.A. - Economics
                [
                    'slug' => 'ba',
                    'spec' => 'Economics',
                    'fee' => 12000.00,
                    'type' => 'per_year',
                    'sem_fee' => 6000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from a recognized Central or State Board with min 40-45% marks.',
                ],

                // 36. M.A. - English Literature
                [
                    'slug' => 'ma',
                    'spec' => 'English',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 37. M.A. - Hindi Literature
                [
                    'slug' => 'ma',
                    'spec' => 'Hindi',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 38. M.A. - History
                [
                    'slug' => 'ma',
                    'spec' => 'History',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 39. M.A. - Political Science
                [
                    'slug' => 'ma',
                    'spec' => 'Political Science',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 40. M.A. - Sociology
                [
                    'slug' => 'ma',
                    'spec' => 'Sociology',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 41. M.A. - Economics
                [
                    'slug' => 'ma',
                    'spec' => 'Economics',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],
                // 42. M.A. - Journalism & Mass Communication
                [
                    'slug' => 'ma',
                    'spec' => 'Journalism and Mass Communication',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '2 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline from a recognized university with min 45% marks.',
                ],

                // 43. BLIS - Bachelor of Library & Information Science
                [
                    'slug' => 'blis',
                    'spec' => 'Library and Information Science',
                    'fee' => 16000.00,
                    'type' => 'per_year',
                    'sem_fee' => 8000.00,
                    'duration' => '1 Year',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Graduation in any discipline from a recognized university with min 45% aggregate marks.',
                ],

                // 44. MLIS - Master of Library & Information Science
                [
                    'slug' => 'mlis',
                    'spec' => 'Library and Information Science',
                    'fee' => 18000.00,
                    'type' => 'per_year',
                    'sem_fee' => 9000.00,
                    'duration' => '1 Year',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BLIS (Bachelor of Library & Information Science) from a recognized university.',
                ],

                // 45. B.Sc. IT - Information Technology
                [
                    'slug' => 'bsc-it',
                    'spec' => 'Information Technology',
                    'fee' => 22000.00,
                    'type' => 'per_year',
                    'sem_fee' => 11000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Science stream (PCM / Computer Science / IT) from a recognized board with min 45% marks.',
                ],

                // 46. M.Sc. IT - Information Technology
                [
                    'slug' => 'msc-it',
                    'spec' => 'Information Technology',
                    'fee' => 30000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15000.00,
                    'duration' => '2 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed B.Sc.(IT/CS) / BCA / B.Tech or equivalent degree from a recognized university with min 50% marks.',
                ],
            ],

            // Key Highlights
            'highlights' => [
                ['title' => 'UGC-DEB Entitled Online Programs', 'value' => 'Conferred Full Category Entitlement by UGC Distance Education Bureau', 'icon' => 'bi-shield-check'],
                ['title' => 'NAAC Grade A+ Accredited University', 'value' => 'Prestigious High-Scoring Academic Rating Benchmarking Excellence', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'Sprawling 70-Acre NCR Campus Heritage', 'value' => 'Modern Multi-Disciplinary Campus in Aligarh near Extended Delhi-NCR', 'icon' => 'bi-building'],
                ['title' => '100% Online Self-Paced LMS Delivery', 'value' => 'Round-the-Clock E-Content Access with Interactive Mobile App Support', 'icon' => 'bi-laptop'],
                ['title' => 'Weekend Live Masterclasses & Webinars', 'value' => 'Interactive Mentoring by Distinguished Professors & Industry Leaders', 'icon' => 'bi-camera-video'],
                ['title' => 'AI-Proctored Remote Online Examinations', 'value' => 'Appear for Tests Securely from Anywhere Without Visiting Exam Centers', 'icon' => 'bi-display'],
                ['title' => 'Universal Degree Legal Equivalence', 'value' => '100% Valid for UPSC, SSC, Defense, State PSCs & Corporate Careers', 'icon' => 'bi-check-circle-fill'],
                ['title' => 'Affordable Fee with Easy 0% EMI', 'value' => 'Flexible No-Cost Monthly EMI Starting from Just ₹2,000/Month', 'icon' => 'bi-credit-card-2-front'],
            ],

            // Accreditations
            'accreditations' => [
                ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled to offer Online & Open Distance Learning Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                ['authority' => 'UGC 12(B)', 'accreditation' => 'Recognized under Section 2(f) & 12(B) of the UGC Act 1956', 'grade' => '12(B)', 'rank' => null, 'year' => '2015'],
                ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council Grade A+', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                ['authority' => 'AICTE', 'accreditation' => 'All India Council for Technical Education Statutory Approval', 'grade' => null, 'rank' => null, 'year' => '2024'],
                ['authority' => 'AIU', 'accreditation' => 'Association of Indian Universities Permanent Member', 'grade' => null, 'rank' => null, 'year' => '2008'],
                ['authority' => 'Statutory Bodies', 'accreditation' => 'Recognized by BCI, PCI, and NCTE across academic disciplines', 'grade' => null, 'rank' => null, 'year' => '2024'],
            ],

            // Digital Facilities
            'facilities' => [
                ['name' => 'Mangalayatan Online Cloud LMS Portal & Mobile App', 'icon' => 'bi-laptop'],
                ['name' => 'Interactive Live Classrooms & Recorded Lecture Archives', 'icon' => 'bi-camera-video'],
                ['name' => 'Digital Library with Delnet, E-Books & Open Access Journals', 'icon' => 'bi-journal-bookmark'],
                ['name' => 'AI-Proctored Online Remote Examination Platform', 'icon' => 'bi-shield-check'],
                ['name' => 'Dedicated Student Mentor & Grievance Redressal Cell', 'icon' => 'bi-headset'],
                ['name' => 'Corporate Placement Assistance & Virtual Career Services', 'icon' => 'bi-briefcase'],
            ],

            // FAQs
            'faqs' => [
                [
                    'question' => 'Is Mangalayatan University Online approved by UGC and DEB?',
                    'answer' => 'Yes. Mangalayatan University is recognized by the UGC under Section 2(f) and 12(B), and its Centre for Distance & Online Education (CDOE) is fully entitled by the UGC - Distance Education Bureau (UGC-DEB) to offer online degree programs. Degrees have complete parity with regular campus degrees.',
                ],
                [
                    'question' => 'How are examinations conducted for Mangalayatan University Online programs?',
                    'answer' => 'All semester examinations are conducted 100% online through secure AI-monitored remote proctoring. Students can appear for examinations from their home using a computer or laptop equipped with a working webcam, microphone, and internet connection.',
                ],
                [
                    'question' => 'Can working professionals easily manage this degree alongside a job?',
                    'answer' => 'Yes. The curriculum is specifically structured for working professionals with self-paced digital learning modules, 24/7 LMS access, and live interactive lectures scheduled on weekends to ensure zero work disruption.',
                ],
                [
                    'question' => 'What is the fee payment structure? Is EMI facility available?',
                    'answer' => 'Fees can be paid on a semester-wise or annual basis. Mangalayatan University Online also offers convenient 0% interest monthly EMI facilities starting from ₹2,000/month through verified educational financing partners.',
                ],
                [
                    'question' => 'Are Mangalayatan Online degrees valid for government jobs and competitive exams?',
                    'answer' => 'Yes. Entitled online degrees from UGC-recognized universities are 100% valid for all central and state government competitive examinations (UPSC, SSC, Banking, Railways, Defense, State PSC) and higher education globally.',
                ],
                [
                    'question' => 'Does Mangalayatan University Online provide placement support?',
                    'answer' => 'Yes. Mangalayatan University provides structured placement support through its Corporate Resource Centre, including virtual job drives, resume optimization, soft skills workshops, and interview preparation sessions.',
                ],
                [
                    'question' => 'Are Library Science (BLIS & MLIS) and IT programs offered?',
                    'answer' => 'Yes. Mangalayatan University Online offers UGC-DEB entitled BLIS (1 Year), MLIS (1 Year), B.Sc. IT (3 Years), and M.Sc. IT (2 Years) programs.',
                ],
                [
                    'question' => 'How do I complete the admission process?',
                    'answer' => 'Admissions are conducted 100% digitally. Fill out the application on online.mangalayatan.in or apply through GrowPec, upload scanned academic marksheets and photo identity, pay the semester fee online, and receive instant digital confirmation and LMS credentials.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹14.50 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹4.80 LPA', 'year' => '2024'],
                ['label' => 'Corporate Recruiters', 'value' => '400+ Companies', 'year' => '2024'],
                ['label' => 'Distance & Online Alumni Base', 'value' => '50,000+ Students', 'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'TCS', 'Infosys', 'Tech Mahindra', 'HCL', 'Abbott', 'Wipro', 'ICICI Bank',
                'IndusInd Bank', 'Justdial', 'Concentrix', 'Reliance Retail', 'Radisson',
                'Genpact', 'Capgemini', 'Kotak Mahindra Bank',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Academic Merit Scholarship',
                    'eligibility' => 'Candidates securing >=75% aggregate in qualifying examinations.',
                    'criteria' => 'Academic Merit Performance',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Waiver',
                    'percentage' => '20%',
                    'description' => 'Tuition fee rebate awarded to top academic performers.',
                ],
                [
                    'name' => 'Armed Forces & Defense Concession',
                    'eligibility' => 'Serving and retired defense/paramilitary personnel, war widows, and direct dependents.',
                    'criteria' => 'Defense ID / Service Proof',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Special tuition fee reduction honouring armed forces families.',
                ],
                [
                    'name' => 'Differently-Abled (PwD) Scholarship',
                    'eligibility' => 'Candidates with valid government disability certificate (>=40%).',
                    'criteria' => 'Disability Certificate',
                    'amount' => null,
                    'amount_label' => '15% Fee Concession',
                    'percentage' => '15%',
                    'description' => 'Dedicated financial support promoting education access for differently-abled students.',
                ],
                [
                    'name' => 'Alumni & Employee Dependent Benefit',
                    'eligibility' => 'Mangalayatan alumni or university employee wards.',
                    'criteria' => 'Alumni Registration / Employee Verification',
                    'amount' => null,
                    'amount_label' => '15% Special Rebate',
                    'percentage' => '15%',
                    'description' => 'Fee discount extended to the Mangalayatan institutional community.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Step-by-Step Online Admission at Mangalayatan University',
                    'content' => 'The online admission process is simple, fast, and completely digital:',
                    'items' => [
                        'Step 1: Visit online.mangalayatan.in or apply through GrowPec.',
                        'Step 2: Fill out the application form with personal and academic qualifications.',
                        'Step 3: Upload digital scanned copies of qualifying marksheets, ID proof, and photo.',
                        'Step 4: Verification of credentials by the university admissions desk.',
                        'Step 5: Pay the semester fee online or choose easy 0% interest monthly EMI.',
                        'Step 6: Receive admission letter, student enrollment ID, and LMS login access.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Required for Mangalayatan Online Enrollment',
                    'content' => 'Keep digital self-attested copies ready during admission:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (Birth date verification)',
                        'Class 12th Certificate & Marksheet (For all UG & PG programs)',
                        'Graduation Degree Certificate & All Semester Marksheets (For PG, BLIS & MLIS programs)',
                        'BLIS Degree Certificate & Marksheet (Required specifically for MLIS applicants)',
                        'Valid Government Photo ID Proof (Aadhaar Card / Voter ID / Passport)',
                        'Recent Passport-Sized Colored Photograph',
                        'Defense / Disability / Category Certificate (If claiming applicable scholarships)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 7. Chaudhary Charan Singh University Online & Distance (CCSU, Meerut)
    |--------------------------------------------------------------------------
    */
    private function ccsuUniversity(): array
    {
        return [
            'name' => 'Chaudhary Charan Singh University Online & Distance, Meerut',
            'short_name' => 'CCSU Online / CDOE',
            'slug' => 'ccsu-university-online',
            'type' => 'State Public',
            'university' => 'Chaudhary Charan Singh University, Meerut',
            'website' => 'https://www.ccsuniversitycdoe.com',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => 'Centre for Distance and Online Education (CDOE), CCS University Campus, Ramgarhi, Meerut, Uttar Pradesh - 250004',
            'year' => '1965',
            'campus' => 'Centre for Distance & Online Education (CDOE), 222-Acre Main Green Campus',
            'approvals' => 'UGC-DEB | AICTE | NAAC A++ (CGPA 3.66) | AIU',
            'naac_grade' => 'A++',
            'ugc_approved' => true,
            'nirf_rank' => 41,
            'nirf_year' => '2024',
            'entrance_exams' => 'Direct Admission / Merit Based',
            'rating' => 4.6,
            'reviews_count' => 620,
            'highest' => '₹16.00 LPA',
            'average' => '₹4.50 LPA',
            'top_recruiters' => 'TCS, Infosys, Wipro, Tech Mahindra, HCL Technologies, ICICI Bank, HDFC Bank, Axis Bank, Genpact, Reliance Industries, Cognizant, Concentrix',
            'is_featured' => true,
            'overview' => 'Chaudhary Charan Singh University (formerly Meerut University), established in 1965 under the UP State Universities Act, is a prestigious premier State Public University accredited with NAAC Grade \'A++\' (CGPA 3.66) and ranked 41st among State Public Universities in India by NIRF. Through its Centre for Distance and Online Education (CDOE), CCSU offers UGC-DEB entitled undergraduate and postgraduate degree programs designed to provide accessible, flexible, and high-standard higher education. Benefiting from a 222-acre lush green historic campus, world-class academic faculty, and an AI-enabled modern Learning Management System (LMS), CDOE CCSU empowers students, working professionals, and lifelong learners with digitized study material (e-SLM), live interactive lectures, recorded video content, and online proctored evaluations. Degrees conferred through CCSU CDOE carry complete parity with regular campus degrees as mandated by UGC regulations, ensuring 100% eligibility for UPSC, UPPSC, SSC, Banking, Railways, State Government employment, and premier corporate careers worldwide.',
            'scholarship_info' => 'CCSU CDOE students from Uttar Pradesh are eligible for Uttar Pradesh Government Post-Matric Scholarship & Fee Reimbursement schemes (for SC, ST, OBC, and EWS categories). The university also provides a 5% qualifying mark relaxation for reserved category students, concessions for Armed Forces personnel, and accessible semester installment payment structures.',

            // Authentic Programs with 100% Accurate Fees & Specializations
            'courses' => [
                // 1. MBA - Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST candidates) from a recognized university.',
                ],
                // 2. MBA - Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST candidates) from a recognized university.',
                ],
                // 3. MBA - Human Resource Management
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST candidates) from a recognized university.',
                ],
                // 4. MBA - Information Technology Management
                [
                    'slug' => 'mba',
                    'spec' => 'Information Technology Management',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST candidates) from a recognized university.',
                ],
                // 5. MBA - International Business
                [
                    'slug' => 'mba',
                    'spec' => 'International Business',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST candidates) from a recognized university.',
                ],
                // 6. MBA - Operations Management
                [
                    'slug' => 'mba',
                    'spec' => 'Operations Management',
                    'fee' => 24000.00,
                    'type' => 'per_year',
                    'sem_fee' => 12000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST candidates) from a recognized university.',
                ],
                // 7. MBA - Hospital Administration
                [
                    'slug' => 'mba',
                    'spec' => 'Hospital Administration',
                    'fee' => 30000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15000.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST candidates) from a recognized university.',
                ],

                // 8. MCA - General Computer Applications
                [
                    'slug' => 'mca',
                    'spec' => 'General Computer Applications',
                    'fee' => 31000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 45% aggregate (40% for SC/ST).',
                ],
                // 9. MCA - Software Engineering & Data Systems
                [
                    'slug' => 'mca',
                    'spec' => 'Software Engineering & Data Systems',
                    'fee' => 31000.00,
                    'type' => 'per_year',
                    'sem_fee' => 15500.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 45% aggregate (40% for SC/ST).',
                ],

                // 10. M.Com - Advanced Accounting & Financial Management
                [
                    'slug' => 'mcom',
                    'spec' => 'Advanced Accounting & Financial Management',
                    'fee' => 7000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3500.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / Allied commerce or management degree from a recognized university with min 45% marks (40% for SC/ST).',
                ],
                // 11. M.Com - International Business & Commerce
                [
                    'slug' => 'mcom',
                    'spec' => 'International Business & Commerce',
                    'fee' => 7000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / Allied commerce or management degree from a recognized university with min 45% marks (40% for SC/ST).',
                ],

                // 12. M.A. - Economics
                [
                    'slug' => 'ma',
                    'spec' => 'Economics',
                    'fee' => 6000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 13. M.A. - Education
                [
                    'slug' => 'ma',
                    'spec' => 'Education',
                    'fee' => 6000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 14. M.A. - English Literature
                [
                    'slug' => 'ma',
                    'spec' => 'English Literature',
                    'fee' => 6000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 15. M.A. - Political Science
                [
                    'slug' => 'ma',
                    'spec' => 'Political Science',
                    'fee' => 6000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 16. M.A. - Sociology
                [
                    'slug' => 'ma',
                    'spec' => 'Sociology',
                    'fee' => 6000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 17. M.A. - History
                [
                    'slug' => 'ma',
                    'spec' => 'History',
                    'fee' => 6000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 18. M.A. - Hindi Literature
                [
                    'slug' => 'ma',
                    'spec' => 'Hindi Literature',
                    'fee' => 6000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
                // 19. M.A. - Public Administration
                [
                    'slug' => 'ma',
                    'spec' => 'Public Administration',
                    'fee' => 6000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3000.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],

                // 20. BBA - General Management
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 20000.00,
                    'type' => 'per_year',
                    'sem_fee' => 10000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination in any stream from recognized central or state board with min 45% aggregate marks (40% for SC/ST).',
                ],
                // 21. BBA - Marketing Management
                [
                    'slug' => 'bba',
                    'spec' => 'Marketing Management',
                    'fee' => 20000.00,
                    'type' => 'per_year',
                    'sem_fee' => 10000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination in any stream from recognized central or state board with min 45% aggregate marks (40% for SC/ST).',
                ],
                // 22. BBA - Financial Management
                [
                    'slug' => 'bba',
                    'spec' => 'Financial Management',
                    'fee' => 20000.00,
                    'type' => 'per_year',
                    'sem_fee' => 10000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination in any stream from recognized central or state board with min 45% aggregate marks (40% for SC/ST).',
                ],
                // 23. BBA - Human Resource Management
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 20000.00,
                    'type' => 'per_year',
                    'sem_fee' => 10000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination in any stream from recognized central or state board with min 45% aggregate marks (40% for SC/ST).',
                ],

                // 24. B.Com - General Commerce & Accounting
                [
                    'slug' => 'bcom',
                    'spec' => 'General Commerce & Accounting',
                    'fee' => 6000.00,
                    'type' => 'per_year',
                    'sem_fee' => 3000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce or Allied stream (or Arts/Science with Mathematics) with min 40% aggregate marks (35% for SC/ST).',
                ],

                // 25. B.A. - English Literature
                [
                    'slug' => 'ba',
                    'spec' => 'English Literature',
                    'fee' => 5000.00,
                    'type' => 'per_year',
                    'sem_fee' => 2500.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination in any stream from recognized central or state board with min 40% aggregate marks (35% for SC/ST).',
                ],
                // 26. B.A. - Political Science
                [
                    'slug' => 'ba',
                    'spec' => 'Political Science',
                    'fee' => 5000.00,
                    'type' => 'per_year',
                    'sem_fee' => 2500.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination in any stream from recognized central or state board with min 40% aggregate marks (35% for SC/ST).',
                ],
                // 27. B.A. - History
                [
                    'slug' => 'ba',
                    'spec' => 'History',
                    'fee' => 5000.00,
                    'type' => 'per_year',
                    'sem_fee' => 2500.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination in any stream from recognized central or state board with min 40% aggregate marks (35% for SC/ST).',
                ],
                // 28. B.A. - Sociology
                [
                    'slug' => 'ba',
                    'spec' => 'Sociology',
                    'fee' => 5000.00,
                    'type' => 'per_year',
                    'sem_fee' => 2500.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination in any stream from recognized central or state board with min 40% aggregate marks (35% for SC/ST).',
                ],
                // 29. B.A. - Economics
                [
                    'slug' => 'ba',
                    'spec' => 'Economics',
                    'fee' => 5000.00,
                    'type' => 'per_year',
                    'sem_fee' => 2500.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination in any stream from recognized central or state board with min 40% aggregate marks (35% for SC/ST).',
                ],
                // 30. B.A. - Hindi Literature
                [
                    'slug' => 'ba',
                    'spec' => 'Hindi Literature',
                    'fee' => 5000.00,
                    'type' => 'per_year',
                    'sem_fee' => 2500.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination in any stream from recognized central or state board with min 40% aggregate marks (35% for SC/ST).',
                ],

                // 31. BLIS - Library & Information Science
                [
                    'slug' => 'blis',
                    'spec' => 'Library & Information Science',
                    'fee' => 9000.00,
                    'type' => 'per_year',
                    'sem_fee' => 4500.00,
                    'duration' => '1 Year',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 45% aggregate marks (40% for SC/ST) from a recognized university.',
                ],
            ],

            // Highlights
            'highlights' => [
                ['title' => 'NAAC A++ Accredited State University', 'value' => 'CGPA 3.66 — Highest Grade by NAAC', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'NIRF Ranked #41 State Public University', 'value' => 'Top Tier Govt University in North India', 'icon' => 'bi-trophy-fill'],
                ['title' => 'UGC-DEB Entitled Distance & Online Degrees', 'value' => '100% Equivalent to Regular On-Campus Degrees', 'icon' => 'bi-shield-check'],
                ['title' => 'AICTE Approved Professional Programs', 'value' => 'Industry Standard MBA & MCA Degrees', 'icon' => 'bi-award-fill'],
                ['title' => 'Highly Economical Govt Fee Structure', 'value' => 'Annual Degree Fees Starting from ₹5,000/Year', 'icon' => 'bi-currency-rupee'],
                ['title' => 'Digital Cloud LMS & e-SLM Modules', 'value' => '24/7 Access to Recorded Lectures & Study Material', 'icon' => 'bi-laptop'],
                ['title' => 'UP Govt Scholarship Assistance', 'value' => 'Post-Matric Fee Reimbursement for Eligible Categories', 'icon' => 'bi-gift-fill'],
            ],

            // Accreditations
            'accreditations' => [
                ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled to offer Online & Open Distance Learning Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council', 'grade' => 'A++', 'rank' => null, 'year' => '2023'],
                ['authority' => 'NIRF', 'accreditation' => 'National Institutional Ranking Framework (State Public Universities)', 'grade' => null, 'rank' => '41', 'year' => '2024'],
                ['authority' => 'AICTE', 'accreditation' => 'All India Council for Technical Education (MBA & MCA Approval)', 'grade' => null, 'rank' => null, 'year' => '2024'],
                ['authority' => 'AIU', 'accreditation' => 'Association of Indian Universities Member', 'grade' => null, 'rank' => null, 'year' => '1965'],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'Centralized Digital LMS with Single Sign-On Access', 'icon' => 'bi-laptop'],
                ['name' => 'Self-Paced e-Learning Modules & Downloadable e-SLM Textbooks', 'icon' => 'bi-book-half'],
                ['name' => 'Live Interactive Faculty Sessions & Doubt-Clearing Masterclasses', 'icon' => 'bi-camera-video'],
                ['name' => 'AI-Proctored Online Semester Examination Infrastructure', 'icon' => 'bi-display'],
                ['name' => 'Central University Placement & Career Guidance Bureau', 'icon' => 'bi-briefcase'],
                ['name' => 'Student Helpdesk & Academic Grievance Redressal Portal', 'icon' => 'bi-headset'],
            ],

            // FAQs
            'faqs' => [
                [
                    'q' => 'Is an online/distance degree from CCSU valid for government jobs and competitive exams?',
                    'a' => 'Yes, absolutely. Chaudhary Charan Singh University is a prestigious State Public University established by law and accredited with NAAC A++. Its online and distance programs are entitled by the UGC-DEB. As per UGC guidelines, degrees obtained through ODL and online modes are 100% equivalent to regular on-campus degrees and fully eligible for UPSC, UPPSC, SSC, Banking, Railways, and all Central and State Government examinations.',
                ],
                [
                    'q' => 'How are semester examinations conducted for CCSU Online & Distance programs?',
                    'a' => 'Semester examinations for online programs are conducted in an AI-monitored, remotely-proctored digital environment, allowing students to appear from home using a computer with a webcam and stable internet. For ODL courses, examinations are organized at designated university examination centres across Uttar Pradesh.',
                ],
                [
                    'q' => 'Are Uttar Pradesh government scholarship benefits available for distance students?',
                    'a' => 'Yes. Eligible candidates from Uttar Pradesh belonging to SC, ST, OBC, and Minority/EWS categories can apply for the UP Government Post-Matric Scholarship and Fee Reimbursement scheme as per standard state government social welfare guidelines.',
                ],
                [
                    'q' => 'Can working executives easily balance their job with CCSU Online courses?',
                    'a' => 'Yes. The curriculum and learning delivery are purposefully tailored for working executives, remote learners, and defense personnel. Study material (e-SLM) is accessible 24/7 on the LMS, recorded lectures can be reviewed anytime, and interactive webinars are organized on weekends.',
                ],
                [
                    'q' => 'What is the procedure for paying course fees?',
                    'a' => 'Fees can be paid online per semester or annually through secure payment gateways (Net Banking, Debit/Credit Cards, UPI) directly on the official portal ccsuniversitycdoe.com. The state university fee structure is among the most economical in India.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹16.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹4.50 LPA', 'year' => '2024'],
                ['label' => 'Hiring Partners', 'value' => '200+ Companies', 'year' => '2024'],
                ['label' => 'Placement Support', 'value' => 'Central Career Guidance & Placement Bureau', 'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'TCS', 'Infosys', 'Wipro', 'Tech Mahindra', 'HCL Technologies',
                'ICICI Bank', 'HDFC Bank', 'Axis Bank', 'Genpact', 'Reliance Industries',
                'Cognizant', 'Concentrix',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'UP Govt Post-Matric Scholarship Scheme',
                    'eligibility' => 'SC/ST/OBC/Minority/EWS candidates domiciled in Uttar Pradesh meeting state income criteria.',
                    'criteria' => 'Social Welfare Department Guidelines & Income Certificate',
                    'amount' => null,
                    'amount_label' => 'Full/Partial Tuition Fee Reimbursement',
                    'percentage' => 'Up to 100%',
                    'description' => 'State government social welfare scheme facilitating higher education access for underprivileged students.',
                ],
                [
                    'name' => 'Academic Merit Concession',
                    'eligibility' => 'Students securing outstanding marks (above 80%) in qualifying board or university examinations.',
                    'criteria' => 'Academic Merit Scorecard',
                    'amount' => null,
                    'amount_label' => '15% Tuition Fee Waiver',
                    'percentage' => '15%',
                    'description' => 'Awarded on competitive merit to encourage exceptional scholars enrolling in online/distance degrees.',
                ],
                [
                    'name' => 'Defense & Paramilitary Concession',
                    'eligibility' => 'Serving and ex-servicemen of Indian Armed Forces, Central Paramilitary Forces, and their immediate dependents.',
                    'criteria' => 'Defense Service ID / Discharge Book',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Honorary fee reduction acknowledging the dedication of military and defense personnel.',
                ],
                [
                    'name' => 'Divyangjan (PwD) Welfare Concession',
                    'eligibility' => 'Differently-abled candidates holding valid civil surgeon disability certificate (>40%).',
                    'criteria' => 'Govt Disability Certificate',
                    'amount' => null,
                    'amount_label' => '25% Tuition Fee Waiver',
                    'percentage' => '25%',
                    'description' => 'Welfare concession supporting inclusive educational opportunities for differently-abled learners.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Digital Admission Process for CCSU Online & Distance Programs',
                    'content' => 'Enrollment for CCSU CDOE programs is completed online without requiring physical presence at the university campus:',
                    'items' => [
                        'Step 1: Visit the official CDOE portal (ccsuniversitycdoe.com) or GrowPec and select your program.',
                        'Step 2: Complete the online application form with personal, academic, and contact details.',
                        'Step 3: Upload scanned copies of required educational marksheets, identity proof, and photograph.',
                        'Step 4: Admission scrutiny committee validates documents and confirms eligibility status.',
                        'Step 5: Pay the semester/annual course fee securely via debit/credit card, net banking, or UPI.',
                        'Step 6: Receive official University Enrollment Number, Admission Confirmation Letter, and LMS Portal login credentials.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Required Documents Checklist for Online Enrollment',
                    'content' => 'Keep digital self-attested copies ready during online application submission:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (Date of Birth verification proof)',
                        'Class 12th Certificate & Marksheet (Mandatory for UG and PG programs)',
                        'Graduation Degree Certificate & All Semester Marksheets (Required for MBA, MCA, M.Com, M.A., BLIS)',
                        'Valid Government Photo ID Proof (Aadhaar Card / Voter ID / Passport / Driving License)',
                        'Recent Passport-Sized Colored Photograph (White Background)',
                        'Category Certificate (SC/ST/OBC/EWS) if applying under reserved quota or scholarship schemes',
                        'Income Certificate & Domicile Certificate (If applying for UP Post-Matric Scholarship)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 8. Amity University Online (Noida, Uttar Pradesh)
    |--------------------------------------------------------------------------
    */
    private function amityUniversity(): array
    {
        return [
            'name' => 'Amity University Online, Noida',
            'short_name' => 'Amity Online',
            'slug' => 'amity-university-online',
            'type' => 'Private',
            'university' => 'Amity University Uttar Pradesh (AUUP), Noida',
            'website' => 'https://amityonline.com',
            'state' => 'Uttar Pradesh',
            'city' => 'Noida',
            'address' => 'Amity Directorate of Distance & Online Education, Sector 125, Noida, Uttar Pradesh - 201313',
            'year' => '2005',
            'campus' => 'Amity Directorate of Distance & Online Education (ADDOE), 60-Acre Smart Digital Campus',
            'approvals' => 'UGC-DEB | AICTE | NAAC A+ | WASC (USA) | QAA (UK) | QS Ranked | AIU',
            'naac_grade' => 'A+',
            'ugc_approved' => true,
            'nirf_rank' => 32,
            'nirf_year' => '2024',
            'entrance_exams' => 'Direct Admission / Merit Based',
            'rating' => 4.8,
            'reviews_count' => 1250,
            'highest' => '₹36.00 LPA',
            'average' => '₹7.20 LPA',
            'top_recruiters' => 'Amazon, Microsoft, Google, Deloitte, Ernst & Young, KPMG, PwC, Accenture, IBM, TCS, Infosys, Wipro, Capgemini, Flipkart, American Express, Adobe, Cisco',
            'is_featured' => true,
            'overview' => 'Amity University Online, managed under the Amity Directorate of Distance and Online Education (ADDOE), Noida, is India’s first UGC-DEB recognized online university and one of Asia’s most celebrated digital education institutions. Accredited with NAAC Grade \'A+\', WASC Senior College and University Commission (USA), QAA (UK), and ranked #1 in India for Online MBA by QS World University Rankings, Amity Online sets the gold standard for flexible global higher education. Powered by the next-generation Amigo Learning Management System (LMS), students experience world-class academic immersion through live interactive lectures by eminent international professors, masterclasses with Fortune 500 CEOs, Harvard Business Publishing case studies, and 24/7 dedicated academic mentorship. With AI-proctored remote semester examinations, global immersion options, and dedicated placement drives connecting learners with over 300+ Fortune 500 corporate partners, Amity Online prepares students to lead in competitive global markets. Degrees awarded hold 100% legal equivalence to on-campus degrees under UGC regulations, recognized universally for central/state government jobs, UPSC, corporate careers, and global credential evaluations like WES.',
            'scholarship_info' => 'Amity University Online offers up to 45% Academic Merit Scholarships on semester tuition fees (through the AONSAT evaluation & qualifying exam marks), 20% concession for serving Armed Forces & Paramilitary personnel, 15% continuing education discount for Amity Alumni, and zero-cost No-Cost EMI facilities starting from ₹3,500/month.',

            // Authentic Programs with 100% Accurate Fees & Specializations
            'courses' => [
                // 1. MBA - Marketing & Sales Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing & Sales Management',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 800,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 2. MBA - Financial & Accounting Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial & Accounting Management',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 800,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 3. MBA - Human Resource Management
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 800,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 4. MBA - Business Analytics
                [
                    'slug' => 'mba',
                    'spec' => 'Business Analytics',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 600,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 5. MBA - Information Technology Management
                [
                    'slug' => 'mba',
                    'spec' => 'Information Technology Management',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 600,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 6. MBA - International Business Management
                [
                    'slug' => 'mba',
                    'spec' => 'International Business Management',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 7. MBA - Digital Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Digital Marketing Management',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 8. MBA - Operations & Supply Chain Management
                [
                    'slug' => 'mba',
                    'spec' => 'Operations and Supply Chain Management',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 9. MBA - Retail Management
                [
                    'slug' => 'mba',
                    'spec' => 'Retail Management',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 10. MBA - Banking & Financial Services
                [
                    'slug' => 'mba',
                    'spec' => 'Banking & Financial Services',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 11. MBA - Entrepreneurship & Leadership
                [
                    'slug' => 'mba',
                    'spec' => 'Entrepreneurship & Leadership',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],
                // 12. MBA - Data Science
                [
                    'slug' => 'mba',
                    'spec' => 'Data Science',
                    'fee' => 103500.00,
                    'type' => 'per_year',
                    'sem_fee' => 56300.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/reserved categories) from a recognized university.',
                ],

                // 13. MCA - Artificial Intelligence & Machine Learning
                [
                    'slug' => 'mca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'sem_fee' => 42500.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 50% marks (45% for reserved categories).',
                ],
                // 14. MCA - Cloud Computing & Cyber Security
                [
                    'slug' => 'mca',
                    'spec' => 'Cloud Computing & Cyber Security',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'sem_fee' => 42500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 50% marks (45% for reserved categories).',
                ],
                // 15. MCA - Data Analytics & Big Data
                [
                    'slug' => 'mca',
                    'spec' => 'Data Analytics & Big Data',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'sem_fee' => 42500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 50% marks (45% for reserved categories).',
                ],
                // 16. MCA - Full Stack Web Development
                [
                    'slug' => 'mca',
                    'spec' => 'Full Stack Web Development',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'sem_fee' => 42500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 50% marks (45% for reserved categories).',
                ],
                // 17. MCA - General Computer Applications
                [
                    'slug' => 'mca',
                    'spec' => 'General Computer Applications',
                    'fee' => 80000.00,
                    'type' => 'per_year',
                    'sem_fee' => 40000.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 50% marks (45% for reserved categories).',
                ],

                // 18. BBA - General Management
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 55000.00,
                    'type' => 'per_year',
                    'sem_fee' => 27500.00,
                    'duration' => '3 Years',
                    'seats' => 600,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 19. BBA - Digital Marketing
                [
                    'slug' => 'bba',
                    'spec' => 'Digital Marketing',
                    'fee' => 55000.00,
                    'type' => 'per_year',
                    'sem_fee' => 27500.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 20. BBA - Financial Management
                [
                    'slug' => 'bba',
                    'spec' => 'Financial Management',
                    'fee' => 55000.00,
                    'type' => 'per_year',
                    'sem_fee' => 27500.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 21. BBA - Human Resource Management
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 55000.00,
                    'type' => 'per_year',
                    'sem_fee' => 27500.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 22. BBA - Business Analytics
                [
                    'slug' => 'bba',
                    'spec' => 'Business Analytics',
                    'fee' => 55000.00,
                    'type' => 'per_year',
                    'sem_fee' => 27500.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 23. BBA - International Business
                [
                    'slug' => 'bba',
                    'spec' => 'International Business',
                    'fee' => 55000.00,
                    'type' => 'per_year',
                    'sem_fee' => 27500.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST).',
                ],

                // 24. BCA - General Computer Applications
                [
                    'slug' => 'bca',
                    'spec' => 'General Computer Applications',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / Information Technology or equivalent with min 50% marks (45% for SC/ST).',
                ],
                // 25. BCA - Cloud & Cyber Security
                [
                    'slug' => 'bca',
                    'spec' => 'Cloud Computing & Cyber Security',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / Information Technology or equivalent with min 50% marks (45% for SC/ST).',
                ],
                // 26. BCA - Data Analytics
                [
                    'slug' => 'bca',
                    'spec' => 'Data Science & Web Technologies',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / Information Technology or equivalent with min 50% marks (45% for SC/ST).',
                ],
                // 27. BCA - Artificial Intelligence & Machine Learning
                [
                    'slug' => 'bca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / Information Technology or equivalent with min 50% marks (45% for SC/ST).',
                ],

                // 28. B.Com (Hons.) - Accounting & Financial Management
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'Accounting & Financial Management',
                    'fee' => 33000.00,
                    'type' => 'per_year',
                    'sem_fee' => 19200.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce or Allied stream (with Mathematics / Accounts) with min 50% aggregate from recognized board.',
                ],
                // 29. B.Com (Hons.) - International Finance & Accounting (ACCA)
                [
                    'slug' => 'bcom-hons',
                    'spec' => 'International Finance & Accounting (ACCA)',
                    'fee' => 45000.00,
                    'type' => 'per_year',
                    'sem_fee' => 22500.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in Commerce or Allied stream (with Mathematics / Accounts) with min 50% aggregate from recognized board.',
                ],
                // 30. B.Com - General Commerce & Accounting
                [
                    'slug' => 'bcom',
                    'spec' => 'General Commerce & Accounting',
                    'fee' => 33000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16500.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from recognized board with min 45% aggregate.',
                ],

                // 31. M.Com - Advanced Accounting & Financial Management
                [
                    'slug' => 'mcom',
                    'spec' => 'Advanced Accounting & Financial Management',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'sem_fee' => 30000.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / Allied degree from a recognized university with min 50% aggregate marks.',
                ],
                // 32. M.Com - FinTech & Financial Services
                [
                    'slug' => 'mcom',
                    'spec' => 'FinTech & Financial Services',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'sem_fee' => 30000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / Allied degree from a recognized university with min 50% aggregate marks.',
                ],

                // 33. B.A. (Journalism & Mass Communication) - Digital Media & Journalism
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Digital Media & Journalism',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 50% aggregate marks.',
                ],
                // 34. B.A. (Journalism & Mass Communication) - Advertising & Public Relations
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Advertising & Public Relations',
                    'fee' => 50000.00,
                    'type' => 'per_year',
                    'sem_fee' => 25000.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized board in any stream with min 50% aggregate marks.',
                ],

                // 35. M.A. (Journalism & Mass Communication) - Digital Media & Mass Communication
                [
                    'slug' => 'ma-jmc',
                    'spec' => 'Digital Media & Mass Communication',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'sem_fee' => 47500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks from a recognized university.',
                ],
                // 36. M.A. (Journalism & Mass Communication) - Corporate Communications & PR
                [
                    'slug' => 'ma-jmc',
                    'spec' => 'Corporate Communications & PR',
                    'fee' => 85000.00,
                    'type' => 'per_year',
                    'sem_fee' => 47500.00,
                    'duration' => '2 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks from a recognized university.',
                ],

                // 37. B.A. - English Literature
                [
                    'slug' => 'ba',
                    'spec' => 'English Literature',
                    'fee' => 33000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16500.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 45% aggregate marks.',
                ],
                // 38. B.A. - Economics
                [
                    'slug' => 'ba',
                    'spec' => 'Economics',
                    'fee' => 33000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16500.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 45% aggregate marks.',
                ],
                // 39. B.A. - Political Science
                [
                    'slug' => 'ba',
                    'spec' => 'Political Science',
                    'fee' => 33000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16500.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 45% aggregate marks.',
                ],
                // 40. B.A. - Sociology
                [
                    'slug' => 'ba',
                    'spec' => 'Sociology',
                    'fee' => 33000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16500.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 45% aggregate marks.',
                ],

                // 41. M.A. - English Literature
                [
                    'slug' => 'ma',
                    'spec' => 'English Literature',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'sem_fee' => 30000.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks from a recognized university.',
                ],
                // 42. M.A. - Public Policy & Governance
                [
                    'slug' => 'ma',
                    'spec' => 'Public Policy & Governance',
                    'fee' => 65000.00,
                    'type' => 'per_year',
                    'sem_fee' => 32500.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks from a recognized university.',
                ],
                // 43. M.A. - Applied Psychology
                [
                    'slug' => 'ma',
                    'spec' => 'Applied Psychology',
                    'fee' => 60000.00,
                    'type' => 'per_year',
                    'sem_fee' => 30000.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks from a recognized university.',
                ],

                // 44. M.Sc. - Data Science
                [
                    'slug' => 'msc-cs',
                    'spec' => 'Data Science & Machine Learning',
                    'fee' => 125000.00,
                    'type' => 'per_year',
                    'sem_fee' => 62500.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Sc (Maths/Stats/Computer Science/Data Science) / BCA / B.Tech or Bachelor\'s with Mathematics with min 50% marks.',
                ],
            ],

            // Highlights
            'highlights' => [
                ['title' => 'Ranked #1 Online MBA in India', 'value' => 'QS World University Online MBA Rankings', 'icon' => 'bi-trophy-fill'],
                ['title' => 'India\'s 1st UGC-DEB Entitled Online University', 'value' => 'Pioneer in Accredited Online Education', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'Dual Global Accreditations', 'value' => 'WASC (USA) & QAA (UK) Certified Degrees', 'icon' => 'bi-globe-americas'],
                ['title' => 'NAAC A+ Accredited University', 'value' => 'NIRF Top 50 Ranked Leading University', 'icon' => 'bi-shield-check'],
                ['title' => 'Harvard Business Publishing Pedagogy', 'value' => 'Global Case Studies & Live CxO Masterclasses', 'icon' => 'bi-award-fill'],
                ['title' => 'Next-Gen Amigo LMS Platform', 'value' => '24/7 Mobile Access to Interactive Video Lectures', 'icon' => 'bi-laptop'],
                ['title' => 'Zero-Cost No-Cost EMI Facilities', 'value' => 'Flexible Monthly Installments from ₹3,500/Month', 'icon' => 'bi-credit-card-2-front'],
            ],

            // Accreditations
            'accreditations' => [
                ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled to offer Online Degree Programs (First in India)', 'grade' => null, 'rank' => null, 'year' => '2026'],
                ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council', 'grade' => 'A+', 'rank' => null, 'year' => '2023'],
                ['authority' => 'NIRF', 'accreditation' => 'National Institutional Ranking Framework (University Category)', 'grade' => null, 'rank' => '32', 'year' => '2024'],
                ['authority' => 'AICTE', 'accreditation' => 'All India Council for Technical Education (MBA & MCA Approval)', 'grade' => null, 'rank' => null, 'year' => '2024'],
                ['authority' => 'WASC (USA)', 'accreditation' => 'Western Association of Schools and Colleges, USA', 'grade' => 'Accredited', 'rank' => null, 'year' => '2022'],
                ['authority' => 'QAA (UK)', 'accreditation' => 'Quality Assurance Agency for Higher Education, United Kingdom', 'grade' => 'Certified', 'rank' => null, 'year' => '2022'],
                ['authority' => 'QS World Rankings', 'accreditation' => 'QS Online MBA Rankings (#1 in India, Top 50 Asia-Pacific)', 'grade' => null, 'rank' => '#1 in India', 'year' => '2024'],
                ['authority' => 'AIU', 'accreditation' => 'Association of Indian Universities Member', 'grade' => null, 'rank' => null, 'year' => '2005'],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'Amigo LMS Web & Mobile App with 24/7 Cloud Access', 'icon' => 'bi-laptop'],
                ['name' => 'Live Interactive Masterclasses with Global Leaders & CxOs', 'icon' => 'bi-camera-video'],
                ['name' => 'Harvard Business Publishing Digital Cases & Global Simulations', 'icon' => 'bi-book-half'],
                ['name' => 'AI-Proctored Remote Online Semester Examination Engine', 'icon' => 'bi-shield-check'],
                ['name' => 'Virtual Career Resource Centre & Executive Placement Drives', 'icon' => 'bi-briefcase'],
                ['name' => 'Dedicated 1-on-1 Academic Buddy & 24/7 Student Grievance Desk', 'icon' => 'bi-headset'],
            ],

            // FAQs
            'faqs' => [
                [
                    'q' => 'Is an online degree from Amity University valid for government jobs and global employment?',
                    'a' => 'Yes, 100%. Amity University Online is entitled by the UGC-DEB and accredited with NAAC A+, WASC (USA), and QAA (UK). Under UGC regulations, online degrees have complete parity with traditional on-campus degrees, making graduates fully eligible for UPSC, SSC, state civil services, banking exams, PSU recruitments, and corporate careers worldwide. The degree is also verified by WES for higher education and immigration across North America.',
                ],
                [
                    'q' => 'How are semester examinations conducted at Amity University Online?',
                    'a' => 'Semester examinations are conducted completely online in an AI-monitored, remote-proctored environment. Students can conveniently appear for exams from anywhere in the world using a computer equipped with a webcam, microphone, and stable internet connection, with flexible examination slot booking.',
                ],
                [
                    'q' => 'Does Amity University Online provide placement support?',
                    'a' => 'Yes. Amity Online features a dedicated Virtual Career Resource Centre that provides comprehensive career guidance, resume crafting, AI interview prep, industry mentorship, and access to virtual recruitment drives connecting learners with over 300+ Fortune 500 corporate partners.',
                ],
                [
                    'q' => 'Are No-Cost EMI payment options available for students?',
                    'a' => 'Yes. Amity University Online provides convenient 0% interest No-Cost EMI facilities in association with verified education finance partners. Monthly EMI options start from approximately ₹3,500/month, allowing students to pay tuition fees in manageable installments.',
                ],
                [
                    'q' => 'Can working professionals balance their work schedule with Amity Online courses?',
                    'a' => 'Absolutely. The curriculum is specifically designed for working professionals, entrepreneurs, and busy executives. All live lectures are recorded and accessible 24/7 on the Amigo LMS app, interactive masterclasses are scheduled during weekends, and e-learning study materials can be accessed on smartphones or laptops anytime.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹36.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹7.20 LPA', 'year' => '2024'],
                ['label' => 'Hiring Partners', 'value' => '300+ Fortune 500 Companies', 'year' => '2024'],
                ['label' => 'Placement Support', 'value' => 'Virtual Career Resource Centre & Global Job Fairs', 'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'Amazon', 'Microsoft', 'Google', 'Deloitte', 'Ernst & Young',
                'KPMG', 'PwC', 'Accenture', 'IBM', 'TCS', 'Infosys',
                'Wipro', 'Capgemini', 'Flipkart', 'American Express', 'Adobe', 'Cisco',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Academic Merit Scholarship',
                    'eligibility' => 'Students securing outstanding marks in 10+2 / Graduation or performing exceptionally in the AONSAT scholarship test.',
                    'criteria' => 'Academic Merit & AONSAT Score',
                    'amount' => null,
                    'amount_label' => 'Up to 45% Tuition Fee Waiver',
                    'percentage' => 'Up to 45%',
                    'description' => 'Generous tuition fee waiver awarded to meritorious candidates to promote digital academic excellence.',
                ],
                [
                    'name' => 'Armed Forces & Defense Concession',
                    'eligibility' => 'Serving and retired personnel of Indian Armed Forces, Paramilitary Forces, and their immediate family dependents.',
                    'criteria' => 'Armed Forces Service Identity Card',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Honorary 20% concession across all undergraduate and postgraduate online degree programs.',
                ],
                [
                    'name' => 'Amity Alumni Concession',
                    'eligibility' => 'Graduates of Amity University across any regular campus or distance program.',
                    'criteria' => 'Amity University Enrollment ID / Degree',
                    'amount' => null,
                    'amount_label' => '15% Continuing Education Waiver',
                    'percentage' => '15%',
                    'description' => 'Special discount for alumni seeking executive upskilling and postgraduate qualifications.',
                ],
                [
                    'name' => 'Divyang (Differently Abled) Scholarship',
                    'eligibility' => 'Students with certified physical disability (>40%) holding a valid government medical certificate.',
                    'criteria' => 'Government Medical Disability Certificate',
                    'amount' => null,
                    'amount_label' => '20% Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Welfare concession aimed at empowering differently-abled scholars with world-class education.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Digital Admission Process for Amity University Online',
                    'content' => 'Enrollment at Amity University Online is completed 100% digitally through the official portal or GrowPec without requiring any campus visits:',
                    'items' => [
                        'Step 1: Choose your desired online degree program and submit the basic registration form.',
                        'Step 2: Complete the detailed application profile with educational, personal, and professional credentials.',
                        'Step 3: Upload self-attested digital copies of required certificates, academic marksheets, photo, and government ID.',
                        'Step 4: Admission committee conducts eligibility screening and issues your provisional admission offer letter.',
                        'Step 5: Pay the program tuition fee securely per semester or annual plan, or select 0% interest No-Cost EMI.',
                        'Step 6: Receive your official Student Enrollment Number, Welcome Kit, and Amigo LMS login credentials to start your degree.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Checklist for Online Enrollment',
                    'content' => 'Prepare scanned, self-attested copies of the following documents before online registration:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (Date of Birth verification proof)',
                        'Class 12th Certificate & Marksheet (Mandatory for all UG and PG courses)',
                        'Graduation Degree Certificate & All Semester Marksheets (Required for MBA, MCA, M.Com, M.A., M.Sc.)',
                        'Valid Government Photo ID Proof (Aadhaar Card / Passport / Voter ID / Driving License)',
                        'Recent Passport-Sized Colored Photograph (White Background)',
                        'Defense Service Certificate / Disability Certificate (If claiming applicable scholarships)',
                        'Work Experience Certificate / Resume (Optional, recommended for executive MBA tracks)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 9. Lovely Professional University Online (LPU Online, Phagwara, Punjab)
    |--------------------------------------------------------------------------
    */
    private function lpuUniversity(): array
    {
        return [
            'name' => 'Lovely Professional University Online, Phagwara',
            'short_name' => 'LPU Online',
            'slug' => 'lpu-university-online',
            'type' => 'Private',
            'university' => 'Lovely Professional University, Phagwara',
            'website' => 'https://www.lpuonline.com',
            'state' => 'Punjab',
            'city' => 'Phagwara',
            'address' => 'Centre for Distance & Online Education, Jalandhar - Delhi G.T. Road, Phagwara, Punjab - 144411',
            'year' => '2005',
            'campus' => 'Centre for Distance and Online Education (CDOE), 600-Acre Ultra-Modern Mega Campus',
            'approvals' => 'UGC-DEB | AICTE | NAAC A++ (CGPA 3.68) | NIRF Rank 27 | World University Rankings | AIU',
            'naac_grade' => 'A++',
            'ugc_approved' => true,
            'nirf_rank' => 27,
            'nirf_year' => '2024',
            'entrance_exams' => 'Direct Admission / Merit Based',
            'rating' => 4.7,
            'reviews_count' => 1420,
            'highest' => '₹30.00 LPA',
            'average' => '₹6.50 LPA',
            'top_recruiters' => 'Amazon, Microsoft, Google, Cognizant, Capgemini, TCS, Wipro, Infosys, Tech Mahindra, IBM, Bosch, Flipkart, Adobe, Intel, Deloitte',
            'is_featured' => true,
            'overview' => 'Lovely Professional University (LPU Online), managed under the Centre for Distance and Online Education (CDOE), Phagwara, Punjab, is one of India\'s largest and highest-accredited multidisciplinary private universities. Accredited with premier NAAC Grade \'A++\' (CGPA 3.68) and ranked 27th among top universities nationwide by NIRF, LPU Online is entitled by the University Grants Commission - Distance Education Bureau (UGC-DEB) to offer career-transforming online undergraduate and postgraduate degree programs. The university deploys an innovative, proprietary digital learning ecosystem—LPU e-Connect (available on Web, Android, and iOS)—providing round-the-clock access to digitized study material (e-SLM), high-definition recorded video lectures, live interactive weekend masterclasses conducted by distinguished corporate mentors, and simulated online lab environments. With seamless AI-proctored remote semester examinations, extensive career mentorship, and dedicated recruitment drives connecting students to over 300+ Fortune 500 companies, LPU Online empowers learners worldwide. All online degrees awarded by LPU hold 100% legal equivalence to regular on-campus degrees under UGC regulations, fully valid for Central/State Government jobs, UPSC, corporate careers, and global higher education.',
            'scholarship_info' => 'LPU Online provides merit-based fee concessions of up to 25% for high-achieving applicants based on qualifying examination scores, special fee concessions for serving and retired defense personnel and their dependents, welfare scholarships for differently-abled (PwD) candidates, and flexible No-Cost EMI facilities starting from ₹2,500/month.',

            // Authentic Programs with 100% Accurate Fees & Specializations
            'courses' => [
                // 1. MBA - Marketing Management
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing Management',
                    'fee' => 80800.00,
                    'type' => 'per_year',
                    'sem_fee' => 40400.00,
                    'duration' => '2 Years',
                    'seats' => 800,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/OBC) from a recognized university.',
                ],
                // 2. MBA - Financial Management
                [
                    'slug' => 'mba',
                    'spec' => 'Financial Management',
                    'fee' => 80800.00,
                    'type' => 'per_year',
                    'sem_fee' => 40400.00,
                    'duration' => '2 Years',
                    'seats' => 800,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/OBC) from a recognized university.',
                ],
                // 3. MBA - Human Resource Management
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 80800.00,
                    'type' => 'per_year',
                    'sem_fee' => 40400.00,
                    'duration' => '2 Years',
                    'seats' => 800,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/OBC) from a recognized university.',
                ],
                // 4. MBA - Data Science
                [
                    'slug' => 'mba',
                    'spec' => 'Data Science',
                    'fee' => 80800.00,
                    'type' => 'per_year',
                    'sem_fee' => 40400.00,
                    'duration' => '2 Years',
                    'seats' => 600,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/OBC) from a recognized university.',
                ],
                // 5. MBA - Business Analytics
                [
                    'slug' => 'mba',
                    'spec' => 'Business Analytics',
                    'fee' => 80800.00,
                    'type' => 'per_year',
                    'sem_fee' => 40400.00,
                    'duration' => '2 Years',
                    'seats' => 600,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/OBC) from a recognized university.',
                ],
                // 6. MBA - Operations & Supply Chain Management
                [
                    'slug' => 'mba',
                    'spec' => 'Operations and Supply Chain Management',
                    'fee' => 80800.00,
                    'type' => 'per_year',
                    'sem_fee' => 40400.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/OBC) from a recognized university.',
                ],
                // 7. MBA - Digital Marketing
                [
                    'slug' => 'mba',
                    'spec' => 'Digital Marketing Management',
                    'fee' => 80800.00,
                    'type' => 'per_year',
                    'sem_fee' => 40400.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/OBC) from a recognized university.',
                ],
                // 8. MBA - International Business
                [
                    'slug' => 'mba',
                    'spec' => 'International Business',
                    'fee' => 80800.00,
                    'type' => 'per_year',
                    'sem_fee' => 40400.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/OBC) from a recognized university.',
                ],
                // 9. MBA - Information Technology Management
                [
                    'slug' => 'mba',
                    'spec' => 'Information Technology Management',
                    'fee' => 80800.00,
                    'type' => 'per_year',
                    'sem_fee' => 40400.00,
                    'duration' => '2 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST/OBC) from a recognized university.',
                ],

                // 10. MCA - Artificial Intelligence & Machine Learning
                [
                    'slug' => 'mca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 64800.00,
                    'type' => 'per_year',
                    'sem_fee' => 32400.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 50% marks (45% for SC/ST).',
                ],
                // 11. MCA - Data Science & Big Data
                [
                    'slug' => 'mca',
                    'spec' => 'Data Science & Big Data',
                    'fee' => 64800.00,
                    'type' => 'per_year',
                    'sem_fee' => 32400.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 50% marks (45% for SC/ST).',
                ],
                // 12. MCA - Cloud Computing & DevOps
                [
                    'slug' => 'mca',
                    'spec' => 'Cloud Computing & DevOps',
                    'fee' => 64800.00,
                    'type' => 'per_year',
                    'sem_fee' => 32400.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 50% marks (45% for SC/ST).',
                ],
                // 13. MCA - Cyber Security & Network Defense
                [
                    'slug' => 'mca',
                    'spec' => 'Cyber Security & Network Defense',
                    'fee' => 64800.00,
                    'type' => 'per_year',
                    'sem_fee' => 32400.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 50% marks (45% for SC/ST).',
                ],
                // 14. MCA - General Computer Applications
                [
                    'slug' => 'mca',
                    'spec' => 'General Computer Applications',
                    'fee' => 64800.00,
                    'type' => 'per_year',
                    'sem_fee' => 32400.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'BCA / B.Sc (Computer Science / IT) or Bachelor\'s with Mathematics at 10+2 or Graduation level with min 50% marks (45% for SC/ST).',
                ],

                // 15. BBA - General Management
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST/OBC).',
                ],
                // 16. BBA - Marketing Management
                [
                    'slug' => 'bba',
                    'spec' => 'Marketing Management',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST/OBC).',
                ],
                // 17. BBA - Financial Management
                [
                    'slug' => 'bba',
                    'spec' => 'Financial Management',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST/OBC).',
                ],
                // 18. BBA - Human Resource Management
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST/OBC).',
                ],
                // 19. BBA - Business Analytics
                [
                    'slug' => 'bba',
                    'spec' => 'Business Analytics',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST/OBC).',
                ],
                // 20. BBA - International Business
                [
                    'slug' => 'bba',
                    'spec' => 'International Business',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 from recognized central or state board in any stream with min 50% aggregate marks (45% for SC/ST/OBC).',
                ],

                // 21. BCA - General Computer Applications
                [
                    'slug' => 'bca',
                    'spec' => 'General Computer Applications',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / IT or equivalent with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 22. BCA - Cloud Computing & Cyber Security
                [
                    'slug' => 'bca',
                    'spec' => 'Cloud Computing & Cyber Security',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / IT or equivalent with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 23. BCA - Data Science & Analytics
                [
                    'slug' => 'bca',
                    'spec' => 'Data Science & Web Technologies',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / IT or equivalent with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 24. BCA - Artificial Intelligence & Machine Learning
                [
                    'slug' => 'bca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 with Mathematics / Computer Science / IT or equivalent with min 50% aggregate marks (45% for SC/ST).',
                ],

                // 25. B.Com - General Commerce & Accounting
                [
                    'slug' => 'bcom',
                    'spec' => 'General Commerce & Accounting',
                    'fee' => 33000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16500.00,
                    'duration' => '3 Years',
                    'seats' => 500,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from recognized board with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 26. B.Com - Banking & Financial Services
                [
                    'slug' => 'bcom',
                    'spec' => 'Banking & Financial Services',
                    'fee' => 33000.00,
                    'type' => 'per_year',
                    'sem_fee' => 16500.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from recognized board with min 50% aggregate marks (45% for SC/ST).',
                ],

                // 27. M.Com - Advanced Accounting & Financial Management
                [
                    'slug' => 'mcom',
                    'spec' => 'Advanced Accounting & Financial Management',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '2 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / Allied commerce degree from a recognized university with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 28. M.Com - International Business & Corporate Taxation
                [
                    'slug' => 'mcom',
                    'spec' => 'International Business & Corporate Taxation',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / Allied commerce degree from a recognized university with min 50% aggregate marks (45% for SC/ST).',
                ],

                // 29. B.A. - English Literature
                [
                    'slug' => 'ba',
                    'spec' => 'English Literature',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from recognized board with min 45% aggregate marks.',
                ],
                // 30. B.A. - Political Science
                [
                    'slug' => 'ba',
                    'spec' => 'Political Science',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from recognized board with min 45% aggregate marks.',
                ],
                // 31. B.A. - History
                [
                    'slug' => 'ba',
                    'spec' => 'History',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from recognized board with min 45% aggregate marks.',
                ],
                // 32. B.A. - Sociology
                [
                    'slug' => 'ba',
                    'spec' => 'Sociology',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '3 Years',
                    'seats' => 400,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from recognized board with min 45% aggregate marks.',
                ],
                // 33. B.A. - Economics
                [
                    'slug' => 'ba',
                    'spec' => 'Economics',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from recognized board with min 45% aggregate marks.',
                ],
                // 34. B.A. - Hindi Literature
                [
                    'slug' => 'ba',
                    'spec' => 'Hindi Literature',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '3 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 in any stream from recognized board with min 45% aggregate marks.',
                ],

                // 35. M.A. - English Literature
                [
                    'slug' => 'ma',
                    'spec' => 'English Literature',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 36. M.A. - Economics
                [
                    'slug' => 'ma',
                    'spec' => 'Economics',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 37. M.A. - History
                [
                    'slug' => 'ma',
                    'spec' => 'History',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 38. M.A. - Political Science
                [
                    'slug' => 'ma',
                    'spec' => 'Political Science',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 39. M.A. - Sociology
                [
                    'slug' => 'ma',
                    'spec' => 'Sociology',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST).',
                ],
                // 40. M.A. - Psychology
                [
                    'slug' => 'ma',
                    'spec' => 'Psychology',
                    'fee' => 32800.00,
                    'type' => 'per_year',
                    'sem_fee' => 16400.00,
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in any discipline with min 50% aggregate marks (45% for SC/ST).',
                ],

                // 41. M.Sc. - Data Science & Computing
                [
                    'slug' => 'msc-cs',
                    'spec' => 'Data Science & Machine Learning',
                    'fee' => 40800.00,
                    'type' => 'per_year',
                    'sem_fee' => 20400.00,
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s degree in Science / Mathematics / Statistics / Computer Science / IT / BCA with min 50% marks.',
                ],
            ],

            // Highlights
            'highlights' => [
                ['title' => 'NAAC A++ Accredited University', 'value' => 'CGPA 3.68 — Among India\'s Highest Accredited', 'icon' => 'bi-patch-check-fill'],
                ['title' => 'NIRF Ranked #27 in Universities', 'value' => 'Top 30 University in All India NIRF Rankings', 'icon' => 'bi-trophy-fill'],
                ['title' => 'UGC-DEB Entitled Degree Programs', 'value' => '100% Equivalent to Regular On-Campus Degrees', 'icon' => 'bi-shield-check'],
                ['title' => 'World University Rankings Recognition', 'value' => 'Ranked by Times Higher Education (THE)', 'icon' => 'bi-globe-americas'],
                ['title' => 'LPU e-Connect Next-Gen LMS', 'value' => '24/7 Mobile App, e-SLMs & Virtual Lab Simulations', 'icon' => 'bi-laptop'],
                ['title' => 'AI-Proctored Remote Online Exams', 'value' => 'Appear for Exams Flexibly from Home', 'icon' => 'bi-display'],
                ['title' => 'No-Cost EMI Starting from ₹2,500/Mo', 'value' => 'Flexible Zero-Interest Monthly Installments', 'icon' => 'bi-credit-card-2-front'],
            ],

            // Accreditations
            'accreditations' => [
                ['authority' => 'UGC-DEB', 'accreditation' => 'Entitled to offer Online & Open Distance Learning Programs', 'grade' => null, 'rank' => null, 'year' => '2026'],
                ['authority' => 'NAAC', 'accreditation' => 'National Assessment and Accreditation Council', 'grade' => 'A++', 'rank' => null, 'year' => '2023'],
                ['authority' => 'NIRF', 'accreditation' => 'National Institutional Ranking Framework (Universities Category)', 'grade' => null, 'rank' => '27', 'year' => '2024'],
                ['authority' => 'AICTE', 'accreditation' => 'All India Council for Technical Education (MBA & MCA Approval)', 'grade' => null, 'rank' => null, 'year' => '2024'],
                ['authority' => 'THE Rankings', 'accreditation' => 'Times Higher Education World University Rankings', 'grade' => 'Ranked', 'rank' => null, 'year' => '2024'],
                ['authority' => 'AIU', 'accreditation' => 'Association of Indian Universities Member', 'grade' => null, 'rank' => null, 'year' => '2005'],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'LPU e-Connect Web Portal & Mobile App with 24/7 Access', 'icon' => 'bi-laptop'],
                ['name' => 'Interactive Live Weekend Masterclasses with Industry Leaders', 'icon' => 'bi-camera-video'],
                ['name' => 'Self-Paced e-Learning Modules, Video Archives & Virtual Labs', 'icon' => 'bi-book-half'],
                ['name' => 'AI-Proctored Remote Online Semester Examination Engine', 'icon' => 'bi-shield-check'],
                ['name' => 'Dedicated Placement Assistance Cell & Virtual Job Fairs', 'icon' => 'bi-briefcase'],
                ['name' => 'Dedicated Relationship Officer & 24/7 Student Grievance Desk', 'icon' => 'bi-headset'],
            ],

            // FAQs
            'faqs' => [
                [
                    'q' => 'Is an online degree from Lovely Professional University (LPU) valid for government jobs?',
                    'a' => 'Yes, 100%. LPU is recognized by the UGC under Section 2(f) and its online programs are entitled by the UGC-DEB. Accredited with NAAC Grade A++, LPU degrees have full legal equivalence to regular on-campus degrees under UGC regulations and are recognized for all Central & State Government examinations, UPSC, SSC, Banking, Railways, and Defense services.',
                ],
                [
                    'q' => 'How are semester examinations conducted for LPU Online courses?',
                    'a' => 'Examinations are conducted completely online in an AI-monitored, remote-proctored environment. Students can easily take exams from home using a desktop or laptop with a functional webcam, microphone, and stable internet connection.',
                ],
                [
                    'q' => 'Does LPU Online provide placement assistance to students?',
                    'a' => 'Yes. LPU Online has a dedicated Placement Cell that conducts virtual recruitment drives, mock interviews, CV building sessions, and connects students with over 300+ Fortune 500 corporate recruiters and top MNCs across India and abroad.',
                ],
                [
                    'q' => 'Are No-Cost EMI options available for fee payments?',
                    'a' => 'Yes. LPU Online provides 0% interest No-Cost EMI facilities in collaboration with leading educational finance institutions. Students can pay their tuition fees in monthly installments starting as low as ₹2,500/month.',
                ],
                [
                    'q' => 'Can working professionals balance their job with LPU Online study schedules?',
                    'a' => 'Yes. The curriculum is specifically curated for working executives, remote candidates, and entrepreneurs. With the LPU e-Connect mobile app, students can view recorded lectures 24/7, download study notes, and attend interactive live webinars during weekends.',
                ],
            ],

            // Placement Statistics
            'placement_stats' => [
                ['label' => 'Highest Package', 'value' => '₹30.00 LPA', 'year' => '2024'],
                ['label' => 'Average Package', 'value' => '₹6.50 LPA', 'year' => '2024'],
                ['label' => 'Hiring Partners', 'value' => '300+ Companies', 'year' => '2024'],
                ['label' => 'Placement Support', 'value' => 'Dedicated Online Placement Support Cell', 'year' => '2024'],
            ],

            // Recruiters
            'recruiters' => [
                'Amazon', 'Microsoft', 'Google', 'Cognizant', 'Capgemini',
                'TCS', 'Wipro', 'Infosys', 'Tech Mahindra', 'IBM',
                'Bosch', 'Flipkart', 'Adobe', 'Intel', 'Deloitte',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Academic Merit Fee Concession',
                    'eligibility' => 'Candidates securing 75% or higher in qualifying degree / 10+2 examinations.',
                    'criteria' => 'Academic Merit Percentage',
                    'amount' => null,
                    'amount_label' => 'Up to 25% Tuition Fee Concession',
                    'percentage' => 'Up to 25%',
                    'description' => 'Awarded on academic merit to recognize outstanding students joining LPU Online.',
                ],
                [
                    'name' => 'Armed Forces & Defense Personnel Concession',
                    'eligibility' => 'Serving & retired personnel of Indian Armed Forces, Paramilitary Forces, and their immediate family dependents.',
                    'criteria' => 'Defense Service ID / Discharge Certificate',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Honorary 20% concession across all undergraduate and postgraduate online degree programs.',
                ],
                [
                    'name' => 'Divyang (Differently Abled) Scholarship',
                    'eligibility' => 'Candidates with benchmark disability (>40%) holding valid medical certificates.',
                    'criteria' => 'Government Medical Disability Certificate',
                    'amount' => null,
                    'amount_label' => '20% Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Dedicated welfare concession supporting inclusive digital education.',
                ],
                [
                    'name' => 'Early Bird Registration Grant',
                    'eligibility' => 'Applicants completing admission registration during the initial intake cycles.',
                    'criteria' => 'Early Admission Cycle Registration',
                    'amount' => null,
                    'amount_label' => 'Special Grant on Semester Tuition',
                    'percentage' => '10%',
                    'description' => 'Special admission incentive granting fee relief on first semester tuition fees.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Digital Admission Process for LPU Online',
                    'content' => 'Admissions are conducted 100% online through LPU e-Connect or GrowPec without requiring any physical campus presence:',
                    'items' => [
                        'Step 1: Choose your desired online UG or PG program and complete the online registration form.',
                        'Step 2: Fill in detailed personal, academic, and professional information in the application form.',
                        'Step 3: Upload self-attested digital copies of your marksheets, photo, and government identity card.',
                        'Step 4: University admission committee reviews your eligibility and approves enrollment.',
                        'Step 5: Pay your semester tuition fee securely online or choose the 0% interest monthly EMI option.',
                        'Step 6: Receive your official Student Registration Number, Admission Letter, and LPU e-Connect login credentials.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Checklist for Online Enrollment',
                    'content' => 'Upload clear scanned copies of the following documents during online application:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (as Date of Birth verification proof)',
                        'Class 12th Certificate & Marksheet (for UG and PG degree programs)',
                        'Graduation Degree Certificate & All Semester Marksheets (for PG MBA, MCA, M.Com, M.A., M.Sc.)',
                        'Valid Government Photo ID Proof (Aadhaar Card / Voter ID / Passport / Driving License)',
                        'Recent Passport-Sized Colored Photograph (White Background)',
                        'Defense / Disability / Merit Certificate (if claiming applicable scholarship concessions)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 10. Chandigarh University Online (CU Online, Mohali / Chandigarh)
    |--------------------------------------------------------------------------
    */
    private function chandigarhUniversity(): array
    {
        return [
            'name' => 'Chandigarh University Online, Mohali',
            'short_name' => 'CU Online',
            'slug' => 'chandigarh-university-online',
            'type' => 'Private',
            'university' => 'Chandigarh University, Mohali',
            'website' => 'https://onlinecu.in',
            'state' => 'Punjab',
            'city' => 'Mohali',
            'address' => 'NH-05, Chandigarh-Ludhiana Highway, Mohali, Punjab - 140413',
            'year' => '2012',
            'campus' => 'Centre for Distance and Online Learning (CDOL), 200-Acre Highway Campus',
            'approvals' => 'UGC-DEB | AICTE | NAAC A+ | NIRF Rank 20 | QS World Ranked #1 Private Univ | WES | AIU',
            'naac_grade' => 'A+',
            'ugc_approved' => true,
            'nirf_rank' => 20,
            'nirf_year' => '2024',
            'entrance_exams' => 'Direct Admission / Merit Based (UGC-DEB Recognized)',
            'rating' => 4.8,
            'reviews_count' => 1380,
            'highest' => '₹32.00 LPA',
            'average' => '₹6.80 LPA',
            'top_recruiters' => 'Google, Microsoft, Amazon, IBM, Deloitte, Cognizant, Wipro, TCS, Capgemini, Infosys, Morgan Stanley, Adobe, Bank of America, Flipkart',
            'is_featured' => true,
            'overview' => 'Chandigarh University Online (CU Online) is the digital education wing of Chandigarh University (Punjab), recognized as India\'s top-ranked private university in the QS World University Rankings 2024 and ranked 20th in the University category by NIRF 2024. Accredited with an esteemed NAAC A+ grade (3.28 CGPA), Chandigarh University is fully entitled by the University Grants Commission - Distance Education Bureau (UGC-DEB) and AICTE to deliver premium, globally recognized undergraduate and postgraduate online degree programs.

CU Online combines academic excellence with high-impact corporate integration, offering collaborative curriculum modules developed with global leaders like Harvard Business Publishing Education and IBM. Learning is delivered through an advanced, intuitive Learning Management System (LMS) with mobile app support, featuring live interactive weekend masterclasses, recorded HD video lectures, comprehensive digital e-libraries, interactive discussion forums, and automated proctored semester examinations.

Every online degree conferred by Chandigarh University holds equal legal status and academic parity with traditional on-campus degrees under UGC regulations. The degrees are recognized internationally, holding WES (World Education Services) credential evaluation equivalence for higher studies and immigration in the USA and Canada. Backed by CU\'s Corporate Resource Centre (CRC), students receive comprehensive career guidance, mock interviews, resume mentoring, and virtual placement drives with over 900+ national and multinational corporate partners.',
            'scholarship_info' => 'Chandigarh University Online offers generous academic merit scholarships of up to 30% tuition fee waiver, 20% dedicated fee concessions for Indian Armed Forces and paramilitary personnel/dependents, 15% alumni concessions for CU graduates, 20% Divyang fee concessions for differently-abled learners, and early bird registration grants, coupled with flexible 0% interest monthly EMI financing starting at ₹2,500/month.',

            // Authentic Courses & Fees
            'courses' => [
                // 1. MBA (₹90,200/Year, ₹45,100/Semester)
                [
                    'slug' => 'mba',
                    'spec' => 'Finance',
                    'fee' => 90200,
                    'sem_fee' => 45100,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% marks (45% for SC/ST/PWD) from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing',
                    'fee' => 90200,
                    'sem_fee' => 45100,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 300,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% marks (45% for SC/ST/PWD) from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 90200,
                    'sem_fee' => 45100,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% marks (45% for SC/ST/PWD) from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'International Business',
                    'fee' => 90200,
                    'sem_fee' => 45100,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% marks (45% for SC/ST/PWD) from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Business Analytics',
                    'fee' => 90200,
                    'sem_fee' => 45100,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% marks (45% for SC/ST/PWD) from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Information Technology',
                    'fee' => 90200,
                    'sem_fee' => 45100,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% marks (45% for SC/ST/PWD) from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Operations Management',
                    'fee' => 90200,
                    'sem_fee' => 45100,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% marks (45% for SC/ST/PWD) from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Banking & Financial Engineering',
                    'fee' => 90200,
                    'sem_fee' => 45100,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% marks (45% for SC/ST/PWD) from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Supply Chain & Logistics',
                    'fee' => 90200,
                    'sem_fee' => 45100,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% marks (45% for SC/ST/PWD) from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Entrepreneurship',
                    'fee' => 90200,
                    'sem_fee' => 45100,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% marks (45% for SC/ST/PWD) from a recognized university.',
                ],

                // 2. MCA (₹58,125/Year, ₹29,063/Semester)
                [
                    'slug' => 'mca',
                    'spec' => 'Cloud Computing & DevOps',
                    'fee' => 58125,
                    'sem_fee' => 29063,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / Bachelor Degree in Computer Science Engineering or equivalent, or passed B.Sc./B.Com/B.A. with Mathematics at 10+2 level or at Graduation level with minimum 50% marks (45% for SC/ST).',
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Artificial Intelligence & Machine Learning',
                    'fee' => 58125,
                    'sem_fee' => 29063,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / Bachelor Degree in Computer Science Engineering or equivalent, or passed B.Sc./B.Com/B.A. with Mathematics at 10+2 level or at Graduation level with minimum 50% marks (45% for SC/ST).',
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Data Analytics',
                    'fee' => 58125,
                    'sem_fee' => 29063,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / Bachelor Degree in Computer Science Engineering or equivalent, or passed B.Sc./B.Com/B.A. with Mathematics at 10+2 level or at Graduation level with minimum 50% marks (45% for SC/ST).',
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Full Stack Web Development',
                    'fee' => 58125,
                    'sem_fee' => 29063,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / Bachelor Degree in Computer Science Engineering or equivalent, or passed B.Sc./B.Com/B.A. with Mathematics at 10+2 level or at Graduation level with minimum 50% marks (45% for SC/ST).',
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Cyber Security',
                    'fee' => 58125,
                    'sem_fee' => 29063,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA / Bachelor Degree in Computer Science Engineering or equivalent, or passed B.Sc./B.Com/B.A. with Mathematics at 10+2 level or at Graduation level with minimum 50% marks (45% for SC/ST).',
                ],

                // 3. BBA (₹46,668/Year, ₹23,334/Semester)
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 46668,
                    'sem_fee' => 23334,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 50% aggregate marks (45% for SC/ST) from a recognized board of education.',
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Digital Marketing',
                    'fee' => 46668,
                    'sem_fee' => 23334,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 50% aggregate marks (45% for SC/ST) from a recognized board of education.',
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Finance',
                    'fee' => 46668,
                    'sem_fee' => 23334,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 50% aggregate marks (45% for SC/ST) from a recognized board of education.',
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 46668,
                    'sem_fee' => 23334,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 50% aggregate marks (45% for SC/ST) from a recognized board of education.',
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Business Analytics',
                    'fee' => 46668,
                    'sem_fee' => 23334,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 50% aggregate marks (45% for SC/ST) from a recognized board of education.',
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Foreign Trade & Global Business',
                    'fee' => 46668,
                    'sem_fee' => 23334,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 50% aggregate marks (45% for SC/ST) from a recognized board of education.',
                ],

                // 4. BCA (₹47,200/Year, ₹23,600/Semester)
                [
                    'slug' => 'bca',
                    'spec' => 'General Computing & Software',
                    'fee' => 47200,
                    'sem_fee' => 23600,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 250,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 50% marks (45% for SC/ST) from a recognized board of education.',
                ],
                [
                    'slug' => 'bca',
                    'spec' => 'Cloud Computing & Cyber Security',
                    'fee' => 47200,
                    'sem_fee' => 23600,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 50% marks (45% for SC/ST) from a recognized board of education.',
                ],
                [
                    'slug' => 'bca',
                    'spec' => 'Data Analytics & Web Tech',
                    'fee' => 47200,
                    'sem_fee' => 23600,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 50% marks (45% for SC/ST) from a recognized board of education.',
                ],
                [
                    'slug' => 'bca',
                    'spec' => 'AI & Machine Learning Foundations',
                    'fee' => 47200,
                    'sem_fee' => 23600,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 50% marks (45% for SC/ST) from a recognized board of education.',
                ],

                // 5. B.Com (₹37,000/Year, ₹18,500/Semester)
                [
                    'slug' => 'bcom',
                    'spec' => 'Accounting & Finance',
                    'fee' => 37000,
                    'sem_fee' => 18500,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 passed in Commerce stream or Science/Arts with Mathematics/Economics with minimum 45% marks (40% for SC/ST).',
                ],
                [
                    'slug' => 'bcom',
                    'spec' => 'Banking & Insurance',
                    'fee' => 37000,
                    'sem_fee' => 18500,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 passed in Commerce stream or Science/Arts with Mathematics/Economics with minimum 45% marks (40% for SC/ST).',
                ],

                // 6. M.Com (₹45,500/Year, ₹22,750/Semester)
                [
                    'slug' => 'mcom',
                    'spec' => 'Accounting & Finance',
                    'fee' => 45500,
                    'sem_fee' => 22750,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in Commerce (B.Com / BBA / B.Com Hons) or equivalent with minimum 50% marks (45% for SC/ST) from a recognized university.',
                ],
                [
                    'slug' => 'mcom',
                    'spec' => 'International Business & Banking',
                    'fee' => 45500,
                    'sem_fee' => 22750,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in Commerce (B.Com / BBA / B.Com Hons) or equivalent with minimum 50% marks (45% for SC/ST) from a recognized university.',
                ],

                // 7. B.A. JMC (₹43,750/Year, ₹21,875/Semester)
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Journalism & Mass Media',
                    'fee' => 43750,
                    'sem_fee' => 21875,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 45% aggregate marks (40% for SC/ST) from a recognized board.',
                ],
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Digital Media & Public Relations',
                    'fee' => 43750,
                    'sem_fee' => 21875,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 45% aggregate marks (40% for SC/ST) from a recognized board.',
                ],

                // 8. M.A. JMC (₹50,000/Year, ₹25,000/Semester)
                [
                    'slug' => 'ma-jmc',
                    'spec' => 'Print & Broadcast Journalism',
                    'fee' => 50000,
                    'sem_fee' => 25000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% aggregate marks (45% for SC/ST) from a recognized university.',
                ],
                [
                    'slug' => 'ma-jmc',
                    'spec' => 'Digital Media & Communication Management',
                    'fee' => 50000,
                    'sem_fee' => 25000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 50% aggregate marks (45% for SC/ST) from a recognized university.',
                ],

                // 9. B.A. (₹36,000/Year, ₹18,000/Semester)
                [
                    'slug' => 'ba',
                    'spec' => 'English',
                    'fee' => 36000,
                    'sem_fee' => 18000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 45% marks from a recognized board of education.',
                ],
                [
                    'slug' => 'ba',
                    'spec' => 'Economics',
                    'fee' => 36000,
                    'sem_fee' => 18000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 45% marks from a recognized board of education.',
                ],
                [
                    'slug' => 'ba',
                    'spec' => 'Sociology',
                    'fee' => 36000,
                    'sem_fee' => 18000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 45% marks from a recognized board of education.',
                ],
                [
                    'slug' => 'ba',
                    'spec' => 'Political Science',
                    'fee' => 36000,
                    'sem_fee' => 18000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 45% marks from a recognized board of education.',
                ],
                [
                    'slug' => 'ba',
                    'spec' => 'History',
                    'fee' => 36000,
                    'sem_fee' => 18000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 45% marks from a recognized board of education.',
                ],
                [
                    'slug' => 'ba',
                    'spec' => 'Psychology',
                    'fee' => 36000,
                    'sem_fee' => 18000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream with minimum 45% marks from a recognized board of education.',
                ],

                // 10. M.A. (₹37,500/Year, ₹18,750/Semester)
                [
                    'slug' => 'ma',
                    'spec' => 'English Literature',
                    'fee' => 37500,
                    'sem_fee' => 18750,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],
                [
                    'slug' => 'ma',
                    'spec' => 'Economics',
                    'fee' => 37500,
                    'sem_fee' => 18750,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],
                [
                    'slug' => 'ma',
                    'spec' => 'Psychology',
                    'fee' => 37500,
                    'sem_fee' => 18750,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],
                [
                    'slug' => 'ma',
                    'spec' => 'Political Science',
                    'fee' => 37500,
                    'sem_fee' => 18750,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],

                // 11. M.Sc. Data Science (msc-cs, ₹55,000/Year, ₹27,500/Semester)
                [
                    'slug' => 'msc-cs',
                    'spec' => 'Data Science & Machine Learning',
                    'fee' => 55000,
                    'sem_fee' => 27500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in B.Sc. / BCA / B.Tech / BE or equivalent with Mathematics / Statistics / Computer Science with minimum 50% marks.',
                ],
                [
                    'slug' => 'msc-cs',
                    'spec' => 'Big Data Analytics',
                    'fee' => 55000,
                    'sem_fee' => 27500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in B.Sc. / BCA / B.Tech / BE or equivalent with Mathematics / Statistics / Computer Science with minimum 50% marks.',
                ],
            ],

            // Highlights
            'highlights' => [
                [
                    'title' => 'QS World Rankings',
                    'value' => 'Ranked #1 Private University in India (QS World University Rankings 2024)',
                    'icon' => 'bi-globe-americas',
                ],
                [
                    'title' => 'NAAC A+ Accreditation',
                    'value' => 'Accredited with Grade A+ and 3.28 CGPA in the very first cycle by NAAC',
                    'icon' => 'bi-award-fill',
                ],
                [
                    'title' => 'NIRF Top 20 University',
                    'value' => 'Ranked 20th in University Category by NIRF 2024 (Ministry of Education, GoI)',
                    'icon' => 'bi-trophy-fill',
                ],
                [
                    'title' => 'UGC-DEB & AICTE Entitled',
                    'value' => 'Full entitlement for 100% online degree programs with complete degree equivalence',
                    'icon' => 'bi-patch-check-fill',
                ],
                [
                    'title' => 'Harvard Business Publishing LMS',
                    'value' => 'Curriculum modules & case studies integrated directly from Harvard Business Publishing',
                    'icon' => 'bi-book-half',
                ],
                [
                    'title' => 'Global WES Recognition',
                    'value' => 'Degrees evaluated & accepted by WES for higher studies and immigration in USA & Canada',
                    'icon' => 'bi-shield-check',
                ],
                [
                    'title' => '360° Career & Placement Cell',
                    'value' => '900+ Corporate Recruiters with dedicated virtual job fairs and interview bootcamps',
                    'icon' => 'bi-briefcase-fill',
                ],
                [
                    'title' => 'Flexible Online Proctored Exams',
                    'value' => 'Secure AI-proctored remote semester examinations from the convenience of home',
                    'icon' => 'bi-laptop',
                ],
            ],

            // Accreditations
            'accreditations' => [
                [
                    'authority' => 'UGC-DEB',
                    'accreditation' => 'Entitled Online Programs',
                    'grade' => 'Entitled',
                    'year' => '2024',
                    'description' => 'University Grants Commission - Distance Education Bureau entitlement for offering online degree programs.',
                ],
                [
                    'authority' => 'NAAC',
                    'accreditation' => 'Accredited with Grade A+',
                    'grade' => 'A+',
                    'year' => '2021',
                    'description' => 'National Assessment and Accreditation Council Grade A+ with 3.28 CGPA.',
                ],
                [
                    'authority' => 'NIRF',
                    'accreditation' => 'Rank 20 in University Category',
                    'rank' => '20',
                    'year' => '2024',
                    'description' => 'National Institutional Ranking Framework (NIRF 2024) ranked #20 among all universities in India.',
                ],
                [
                    'authority' => 'QS World University Rankings',
                    'accreditation' => 'Ranked #1 Private University in India',
                    'rank' => '#1 Private Univ',
                    'year' => '2024',
                    'description' => 'Top ranked Indian private university in the prestigious QS World University Rankings.',
                ],
                [
                    'authority' => 'AICTE',
                    'accreditation' => 'Approved Online Technical Programs',
                    'status' => 'Approved',
                    'year' => '2024',
                    'description' => 'All India Council for Technical Education approval for online Master of Business Administration and MCA programs.',
                ],
                [
                    'authority' => 'WES (USA & Canada)',
                    'accreditation' => 'Recognized Global Credential Evaluation',
                    'status' => 'Recognized',
                    'year' => '2024',
                    'description' => 'World Education Services accepts CU Online degrees as equivalent to 4-year US/Canadian master’s/bachelor’s degrees.',
                ],
                [
                    'authority' => 'AIU',
                    'accreditation' => 'Association of Indian Universities Member',
                    'status' => 'Member',
                    'year' => '2013',
                    'description' => 'Member of Association of Indian Universities ensuring pan-India and international parity.',
                ],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'CU Blackboard & LMS Mobile App (Android & iOS)', 'icon' => 'bi-phone'],
                ['name' => '24x7 Digital E-Library with IEEE, Scopus & Harvard Cases', 'icon' => 'bi-journal-bookmark-fill'],
                ['name' => 'Live Weekend Interactive Webinars & Faculty Masterclasses', 'icon' => 'bi-camera-video-fill'],
                ['name' => 'Recorded HD Video Lectures with Searchable Transcripts', 'icon' => 'bi-play-circle-fill'],
                ['name' => 'AI-Proctored Secure Online Semester Examination System', 'icon' => 'bi-display'],
                ['name' => 'Dedicated Academic Mentors & 24x7 Student Helpdesk', 'icon' => 'bi-headset'],
                ['name' => 'Corporate Resource Centre (CRC) & Virtual Placement Drives', 'icon' => 'bi-building-check'],
                ['name' => 'Resume Building, Soft Skills & Mock Interview Bootcamps', 'icon' => 'bi-person-badge-fill'],
            ],

            // FAQs
            'faqs' => [
                [
                    'question' => 'Are Chandigarh University Online degrees valid for government jobs and higher studies?',
                    'answer' => 'Yes, absolutely. Chandigarh University is entitled by the UGC-DEB and AICTE. As per UGC regulations, online degrees earned from UGC-DEB recognized universities hold 100% equal academic validity to conventional on-campus degrees and are fully eligible for UPSC, SSC, Banking, PSU employment, and PhD admissions.',
                ],
                [
                    'question' => 'How are semester examinations conducted in CU Online programs?',
                    'answer' => 'All end-semester examinations are conducted 100% online in remote proctored mode. Students can take exams from their home using a computer or laptop with a working webcam, microphone, and stable internet connection under AI-enabled proctoring and human invigilation.',
                ],
                [
                    'question' => 'Is Chandigarh University Online recognized internationally by WES?',
                    'answer' => 'Yes. Chandigarh University Online degrees are accepted by World Education Services (WES) for education credential assessments in both the USA and Canada, making graduates eligible for higher education abroad and Canadian Express Entry PR immigration pathways.',
                ],
                [
                    'question' => 'What learning resources are provided on the CU Learning Management System (LMS)?',
                    'answer' => 'Students receive access to the state-of-the-art CU LMS (available on web and mobile app) featuring Harvard Business Publishing study materials, pre-recorded high-definition video lectures, live interactive weekend masterclasses, e-books, self-assessment quizzes, and discussion forums with faculty and peers.',
                ],
                [
                    'question' => 'Does Chandigarh University Online offer placement assistance to students?',
                    'answer' => 'Yes. CU Online has a dedicated Corporate Resource Centre (CRC) that provides 100% placement assistance, resume optimization workshops, mock interview practice, industry mentor connect sessions, and access to virtual placement drives with over 900+ recruitment partners including Microsoft, Amazon, Google, IBM, and Deloitte.',
                ],
                [
                    'question' => 'What is the fee payment structure and are EMI financing options available?',
                    'answer' => 'Fees can be paid semester-wise, annually, or through no-cost monthly EMI options starting at just ₹2,500 per month through leading education financing banking partners without any interest burden.',
                ],
                [
                    'question' => 'Can working professionals attend classes while managing their jobs?',
                    'answer' => 'Yes. The curriculum is specifically architected for working professionals and self-paced learners. Live lectures are held during weekends and evenings, and all sessions are recorded and archived on the LMS for flexible 24x7 viewing at any convenient time.',
                ],
                [
                    'question' => 'What are the minimum eligibility criteria for CU Online MBA and MCA programs?',
                    'answer' => 'For MBA, candidates must hold any Bachelor\'s degree with at least 50% marks (45% for SC/ST). For MCA, candidates must have passed BCA, B.Sc. (IT/CS), or any graduation with Mathematics at 10+2 or degree level with at least 50% marks (45% for SC/ST). No entrance exam rank is required.',
                ],
            ],

            // Placement Stats
            'placement_stats' => [
                ['label' => 'Highest International Package', 'value' => '₹32.00 LPA', 'year' => '2024'],
                ['label' => 'Highest Domestic Package',      'value' => '₹18.50 LPA', 'year' => '2024'],
                ['label' => 'Average Salary Package',        'value' => '₹6.80 LPA',  'year' => '2024'],
                ['label' => 'Total Corporate Recruiters',    'value' => '900+ Multi-Nationals', 'year' => '2024'],
                ['label' => 'Placement Assistance Rate',     'value' => '100% Career Support', 'year' => '2024'],
                ['label' => 'Virtual Placement Drives',      'value' => '300+ Annual Drives', 'year' => '2024'],
            ],

            // Top Recruiters
            'recruiters' => [
                'Google',
                'Microsoft',
                'Amazon',
                'IBM',
                'Deloitte',
                'Cognizant',
                'Wipro',
                'TCS',
                'Capgemini',
                'Infosys',
                'Morgan Stanley',
                'Adobe',
                'Bank of America',
                'Flipkart',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'CU Academic Merit Scholarship',
                    'eligibility' => 'Students with 80% and above aggregate marks in their qualifying examination.',
                    'criteria' => 'Academic Qualifying Examination Marks (>=80%)',
                    'amount' => null,
                    'amount_label' => 'Up to 30% Tuition Fee Concession',
                    'percentage' => 'Up to 30%',
                    'description' => 'Awarded on academic merit to recognize outstanding students joining Chandigarh University Online.',
                ],
                [
                    'name' => 'Armed Forces & Defense Personnel Welfare Scholarship',
                    'eligibility' => 'Serving and retired defense personnel of Indian Armed Forces, Paramilitary, and their immediate wards.',
                    'criteria' => 'Defense Service ID / Discharge Book Certificate',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Honorary 20% concession across all undergraduate and postgraduate online degree programs.',
                ],
                [
                    'name' => 'CU Alumni & Sibling Fee Concession',
                    'eligibility' => 'Graduates of Chandigarh University or siblings of current enrolled CU students.',
                    'criteria' => 'Alumni Registration Number / Sibling Enrollment Proof',
                    'amount' => null,
                    'amount_label' => '15% Tuition Fee Concession',
                    'percentage' => '15%',
                    'description' => '15% fee waiver for existing alumni pursuing higher post-graduate education.',
                ],
                [
                    'name' => 'Divyang (Differently Abled) Scholarship',
                    'eligibility' => 'Candidates with benchmark disability (>40%) holding valid medical certificates.',
                    'criteria' => 'Government Medical Disability Certificate',
                    'amount' => null,
                    'amount_label' => '20% Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Dedicated welfare concession supporting inclusive digital education across the nation.',
                ],
                [
                    'name' => 'Early Bird & Women Empowerment Grant',
                    'eligibility' => 'Female applicants or candidates completing registration during initial intake cycles.',
                    'criteria' => 'Early Admission Cycle Registration / Female Candidates',
                    'amount' => null,
                    'amount_label' => '10% Tuition Fee Grant',
                    'percentage' => '10%',
                    'description' => 'Special incentive granting fee relief on first semester tuition fees.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Digital Admission Process for CU Online',
                    'content' => 'Admissions are conducted 100% online through onlinecu.in or GrowPec without requiring any physical campus visit:',
                    'items' => [
                        'Step 1: Select your preferred online UG or PG program and complete the quick registration form.',
                        'Step 2: Fill in detailed personal, academic, and professional details in the online application form.',
                        'Step 3: Upload self-attested digital copies of your academic marksheets, photo, and government identity card.',
                        'Step 4: The university admission committee verifies your eligibility and confirms provisional admission.',
                        'Step 5: Pay your semester tuition fee securely online or choose the 0% interest monthly EMI option.',
                        'Step 6: Receive your official Student Registration Number, Admission Letter, and CU LMS login credentials.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Checklist for Online Enrollment',
                    'content' => 'Upload clear scanned copies of the following documents during online application:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (as Date of Birth verification proof)',
                        'Class 12th Certificate & Marksheet (for UG and PG degree programs)',
                        'Graduation Degree Certificate & All Semester Marksheets (for PG MBA, MCA, M.Com, M.A., M.Sc.)',
                        'Valid Government Photo ID Proof (Aadhaar Card / Voter ID / Passport / Driving License)',
                        'Recent Passport-Sized Colored Photograph (White Background)',
                        'Defense / Disability / Alumni Certificate (if claiming applicable scholarship concessions)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | 11. Shobhit University Online / Distance (Meerut, Uttar Pradesh)
    |--------------------------------------------------------------------------
    */
    private function shobhitUniversity(): array
    {
        return [
            'name' => 'Shobhit University Centre for Distance and Online Education, Meerut',
            'short_name' => 'Shobhit University Online',
            'slug' => 'shobhit-university-online',
            'type' => 'Deemed',
            'university' => 'Shobhit Institute of Engineering and Technology (Deemed to-be-University), Meerut',
            'website' => 'https://shobhitodl.in',
            'state' => 'Uttar Pradesh',
            'city' => 'Meerut',
            'address' => 'NH-58, Modipuram, Meerut, Uttar Pradesh - 250110',
            'year' => '2006',
            'campus' => 'Centre for Distance and Online Education (CDOE), 100-Acre Modipuram Campus',
            'approvals' => 'UGC-DEB | AICTE | NAAC A | AIU',
            'naac_grade' => 'A',
            'ugc_approved' => true,
            'nirf_rank' => 101,
            'nirf_year' => '2024',
            'entrance_exams' => 'Direct Admission / Merit Based (UGC-DEB Recognized)',
            'rating' => 4.6,
            'reviews_count' => 840,
            'highest' => '₹23.00 LPA',
            'average' => '₹5.20 LPA',
            'top_recruiters' => 'Amazon, Airtel, Wipro, TCS, Infosys, HDFC Bank, Bandhan Bank, Cognizant, Tech Mahindra, Apollo Munich, IBM, Paytm',
            'is_featured' => false,
            'overview' => 'Shobhit University Centre for Distance and Online Education (CDOE), established under Shobhit Institute of Engineering and Technology (Deemed to-be-University), Meerut, is a NAAC Grade \'A\' accredited higher education institution in the National Capital Region (NCR). Entitled by the University Grants Commission - Distance Education Bureau (UGC-DEB) and AICTE, Shobhit University delivers flexible, affordable, and career-oriented undergraduate and postgraduate distance and online programs designed specifically for working professionals, self-paced learners, and remote students.

Situated on a lush 100-acre green campus on NH-58 Modipuram, Meerut, Shobhit University blends technological excellence with traditional academic values. The Centre for Distance and Online Education equips students with a dedicated cloud-based Learning Management System (LMS), digitized Self-Learning Materials (SLM), recorded and live faculty mentoring sessions, access to national digital libraries, and continuous interactive assessments.

All distance and online degrees awarded by Shobhit University carry complete statutory equivalence with regular on-campus degrees under UGC regulations. Graduates are 100% eligible for central and state government competitive examinations (UPSC, UPPSC, SSC, Banking, Defense), higher academic qualifications (M.Phil, Ph.D.), and national or international corporate careers. Through its Corporate Resource Centre (CRC), Shobhit University provides placement assistance, career development workshops, and campus-virtual recruitment drives with leading multinational recruiters including Amazon, Airtel, Wipro, TCS, and Infosys.',
            'scholarship_info' => 'Shobhit University CDOE offers progressive merit-based scholarships up to 25% fee concession, 20% dedicated fee waivers for Defense and Paramilitary personnel, special concession for girls/women empowerment, 15% alumni concessions, and 20% Divyang concessions for differently-abled learners, with convenient interest-free semester installments.',

            // Authentic Courses & Fees
            'courses' => [
                // 1. MBA (₹35,000/Year, ₹17,500/Semester)
                [
                    'slug' => 'mba',
                    'spec' => 'Finance',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Marketing',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Human Resource Management',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'International Business',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Information Technology',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Operations & Production Management',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],
                [
                    'slug' => 'mba',
                    'spec' => 'Agri-Business Management',
                    'fee' => 35000,
                    'sem_fee' => 17500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45-50% marks from a recognized university.',
                ],

                // 2. MCA (₹32,000/Year, ₹16,000/Semester)
                [
                    'slug' => 'mca',
                    'spec' => 'Cloud Computing & Software Engineering',
                    'fee' => 32000,
                    'sem_fee' => 16000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA/B.Sc. (Computer Science/IT) or graduation with Mathematics at 10+2 level or degree level with minimum 50% marks (45% for SC/ST).',
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Data Science & Artificial Intelligence',
                    'fee' => 32000,
                    'sem_fee' => 16000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA/B.Sc. (Computer Science/IT) or graduation with Mathematics at 10+2 level or degree level with minimum 50% marks (45% for SC/ST).',
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Cyber Security & Networking',
                    'fee' => 32000,
                    'sem_fee' => 16000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA/B.Sc. (Computer Science/IT) or graduation with Mathematics at 10+2 level or degree level with minimum 50% marks (45% for SC/ST).',
                ],
                [
                    'slug' => 'mca',
                    'spec' => 'Web Technologies & Database Systems',
                    'fee' => 32000,
                    'sem_fee' => 16000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BCA/B.Sc. (Computer Science/IT) or graduation with Mathematics at 10+2 level or degree level with minimum 50% marks (45% for SC/ST).',
                ],

                // 3. BBA (₹25,000/Year, ₹12,500/Semester)
                [
                    'slug' => 'bba',
                    'spec' => 'General Management',
                    'fee' => 25000,
                    'sem_fee' => 12500,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Marketing Management',
                    'fee' => 25000,
                    'sem_fee' => 12500,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Financial Management',
                    'fee' => 25000,
                    'sem_fee' => 12500,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],
                [
                    'slug' => 'bba',
                    'spec' => 'Human Resource Management',
                    'fee' => 25000,
                    'sem_fee' => 12500,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],

                // 4. BCA (₹25,000/Year, ₹12,500/Semester)
                [
                    'slug' => 'bca',
                    'spec' => 'Computer Applications & Software',
                    'fee' => 25000,
                    'sem_fee' => 12500,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 200,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 passed in any stream with Mathematics or Computer Science preferred from a recognized board.',
                ],
                [
                    'slug' => 'bca',
                    'spec' => 'Web Technologies & Cloud Fundamentals',
                    'fee' => 25000,
                    'sem_fee' => 12500,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 passed in any stream with Mathematics or Computer Science preferred from a recognized board.',
                ],
                [
                    'slug' => 'bca',
                    'spec' => 'Data Management & Networking',
                    'fee' => 25000,
                    'sem_fee' => 12500,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 passed in any stream with Mathematics or Computer Science preferred from a recognized board.',
                ],

                // 5. B.Com (₹20,000/Year, ₹10,000/Semester)
                [
                    'slug' => 'bcom',
                    'spec' => 'Accounting & Financial Management',
                    'fee' => 20000,
                    'sem_fee' => 10000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 passed in Commerce stream or Science/Arts with Mathematics/Economics from a recognized board.',
                ],
                [
                    'slug' => 'bcom',
                    'spec' => 'Banking & Business Law',
                    'fee' => 20000,
                    'sem_fee' => 10000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 passed in Commerce stream or Science/Arts with Mathematics/Economics from a recognized board.',
                ],

                // 6. M.Com (₹24,000/Year, ₹12,000/Semester)
                [
                    'slug' => 'mcom',
                    'spec' => 'Advanced Accounting & Auditing',
                    'fee' => 24000,
                    'sem_fee' => 12000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / B.Com (Hons) or equivalent graduation from a recognized university.',
                ],
                [
                    'slug' => 'mcom',
                    'spec' => 'Financial Systems & Corporate Taxation',
                    'fee' => 24000,
                    'sem_fee' => 12000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'B.Com / BBA / B.Com (Hons) or equivalent graduation from a recognized university.',
                ],

                // 7. B.A. (₹18,000/Year, ₹9,000/Semester)
                [
                    'slug' => 'ba',
                    'spec' => 'English',
                    'fee' => 18000,
                    'sem_fee' => 9000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 150,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],
                [
                    'slug' => 'ba',
                    'spec' => 'Economics',
                    'fee' => 18000,
                    'sem_fee' => 9000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],
                [
                    'slug' => 'ba',
                    'spec' => 'Sociology',
                    'fee' => 18000,
                    'sem_fee' => 9000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],
                [
                    'slug' => 'ba',
                    'spec' => 'Political Science',
                    'fee' => 18000,
                    'sem_fee' => 9000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 120,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],
                [
                    'slug' => 'ba',
                    'spec' => 'History',
                    'fee' => 18000,
                    'sem_fee' => 9000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],
                [
                    'slug' => 'ba',
                    'spec' => 'Hindi',
                    'fee' => 18000,
                    'sem_fee' => 9000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],

                // 8. M.A. (₹20,000/Year, ₹10,000/Semester)
                [
                    'slug' => 'ma',
                    'spec' => 'English Literature',
                    'fee' => 20000,
                    'sem_fee' => 10000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline from a recognized university.',
                ],
                [
                    'slug' => 'ma',
                    'spec' => 'Economics',
                    'fee' => 20000,
                    'sem_fee' => 10000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline from a recognized university.',
                ],
                [
                    'slug' => 'ma',
                    'spec' => 'Sociology',
                    'fee' => 20000,
                    'sem_fee' => 10000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline from a recognized university.',
                ],
                [
                    'slug' => 'ma',
                    'spec' => 'Political Science',
                    'fee' => 20000,
                    'sem_fee' => 10000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline from a recognized university.',
                ],
                [
                    'slug' => 'ma',
                    'spec' => 'History',
                    'fee' => 20000,
                    'sem_fee' => 10000,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline from a recognized university.',
                ],

                // 9. B.A. JMC (₹22,000/Year, ₹11,000/Semester)
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Journalism & Electronic Media',
                    'fee' => 22000,
                    'sem_fee' => 11000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],
                [
                    'slug' => 'ba-jmc',
                    'spec' => 'Advertising & Public Relations',
                    'fee' => 22000,
                    'sem_fee' => 11000,
                    'type' => 'per_year',
                    'duration' => '3 Years',
                    'seats' => 80,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => '10+2 examination passed in any stream from a recognized educational board.',
                ],

                // 10. M.A. JMC (₹25,000/Year, ₹12,500/Semester)
                [
                    'slug' => 'ma-jmc',
                    'spec' => 'Print & Broadcast Journalism',
                    'fee' => 25000,
                    'sem_fee' => 12500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 80,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline from a recognized university.',
                ],
                [
                    'slug' => 'ma-jmc',
                    'spec' => 'Digital Communication & New Media',
                    'fee' => 25000,
                    'sem_fee' => 12500,
                    'type' => 'per_year',
                    'duration' => '2 Years',
                    'seats' => 80,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline from a recognized university.',
                ],

                // 11. BLIS (₹20,000/Year, ₹10,000/Semester)
                [
                    'slug' => 'blis',
                    'spec' => 'Library & Information Science',
                    'fee' => 20000,
                    'sem_fee' => 10000,
                    'type' => 'per_year',
                    'duration' => '1 Year',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Bachelor\'s Degree in any discipline with minimum 45% marks from a recognized university.',
                ],

                // 12. MLIS (₹22,000/Year, ₹11,000/Semester)
                [
                    'slug' => 'mlis',
                    'spec' => 'Advanced Information Retrieval & Digital Libraries',
                    'fee' => 22000,
                    'sem_fee' => 11000,
                    'type' => 'per_year',
                    'duration' => '1 Year',
                    'seats' => 100,
                    'exam' => 'Direct Admission / Merit Based',
                    'eligibility' => 'Passed BLIS / B.Lib.I.Sc from a recognized university.',
                ],
            ],

            // Highlights
            'highlights' => [
                [
                    'title' => 'NAAC Grade A Accredited',
                    'value' => 'Accredited with Grade A by the National Assessment and Accreditation Council (NAAC)',
                    'icon' => 'bi-award-fill',
                ],
                [
                    'title' => 'UGC-DEB Entitled',
                    'value' => 'Entitled by UGC Distance Education Bureau for recognized distance and online learning',
                    'icon' => 'bi-patch-check-fill',
                ],
                [
                    'title' => 'Affordable Fee Structure',
                    'value' => 'Cost-effective education with programs starting from just ₹18,000 per year',
                    'icon' => 'bi-cash-coin',
                ],
                [
                    'title' => 'AICTE Approved MCA & MBA',
                    'value' => 'Full statutory AICTE approval for professional technical and management programs',
                    'icon' => 'bi-shield-check',
                ],
                [
                    'title' => 'Interactive Digital LMS',
                    'value' => 'Modern cloud-based learning portal with 24x7 access to digital courseware and lectures',
                    'icon' => 'bi-laptop',
                ],
                [
                    'title' => 'Weekend Academic Mentoring',
                    'value' => 'Flexible online counseling and interaction sessions designed for working professionals',
                    'icon' => 'bi-calendar-event',
                ],
                [
                    'title' => 'Complete Employment Parity',
                    'value' => '100% degree validity for Central & State Government jobs, UPSC, SSC, Banking, and Ph.D.',
                    'icon' => 'bi-briefcase-fill',
                ],
                [
                    'title' => 'Corporate Placement Network',
                    'value' => 'Active Corporate Resource Centre with 250+ top companies for placement assistance',
                    'icon' => 'bi-building-check',
                ],
            ],

            // Accreditations
            'accreditations' => [
                [
                    'authority' => 'UGC-DEB',
                    'accreditation' => 'Entitled Distance & Online Programs',
                    'grade' => 'Entitled',
                    'year' => '2024',
                    'description' => 'Entitled by University Grants Commission - Distance Education Bureau to offer ODL programs.',
                ],
                [
                    'authority' => 'NAAC',
                    'accreditation' => 'Accredited with Grade A',
                    'grade' => 'A',
                    'year' => '2022',
                    'description' => 'National Assessment and Accreditation Council Grade A Deemed-to-be University.',
                ],
                [
                    'authority' => 'AICTE',
                    'accreditation' => 'Approved Technical Programs',
                    'status' => 'Approved',
                    'year' => '2024',
                    'description' => 'All India Council for Technical Education approval for online Master of Business Administration and MCA.',
                ],
                [
                    'authority' => 'NIRF',
                    'accreditation' => 'Top 101-125 Band',
                    'rank' => '101-125',
                    'year' => '2024',
                    'description' => 'Recognized in 101-125 university rank band by the Ministry of Education, Government of India.',
                ],
                [
                    'authority' => 'AIU',
                    'accreditation' => 'Association of Indian Universities Member',
                    'status' => 'Member',
                    'year' => '2007',
                    'description' => 'Member of Association of Indian Universities ensuring national and international equivalence.',
                ],
            ],

            // Facilities
            'facilities' => [
                ['name' => 'Shobhit Cloud LMS & Mobile Learning Portal', 'icon' => 'bi-phone'],
                ['name' => '24x7 Digital E-Library with International E-Journals & Books', 'icon' => 'bi-journal-bookmark-fill'],
                ['name' => 'Comprehensive Self-Learning Materials (SLM) in Digital & Printed Form', 'icon' => 'bi-book-half'],
                ['name' => 'Live Interactive Weekend Faculty Counseling & Discussion Webinars', 'icon' => 'bi-camera-video-fill'],
                ['name' => 'Proctored End-Semester Remote Examination System', 'icon' => 'bi-display'],
                ['name' => 'Student Support Grievance Cell & 24x7 Academic Helpline', 'icon' => 'bi-headset'],
                ['name' => 'Corporate Resource Centre (CRC) & Virtual Placement Drives', 'icon' => 'bi-building-check'],
                ['name' => 'Industry Readiness & Skill Enhancement Workshops', 'icon' => 'bi-person-badge-fill'],
            ],

            // FAQs
            'faqs' => [
                [
                    'question' => 'Are degrees from Shobhit University Centre for Distance and Online Education recognized for government jobs?',
                    'answer' => 'Yes. Shobhit University is entitled by the UGC-DEB and AICTE. As per Gazette notifications issued by the Government of India and UGC regulations, degrees awarded through distance/online mode by recognized universities hold 100% academic parity with regular degrees and are completely valid for UPSC, UPPSC, SSC, Banking, Railways, Defense, and state public service commission exams.',
                ],
                [
                    'question' => 'How are the examinations conducted for Shobhit University ODL students?',
                    'answer' => 'Examinations are conducted each semester as per UGC-DEB guidelines. Students can take online remote proctored examinations from the convenience of their homes or appear at designated university examination centres.',
                ],
                [
                    'question' => 'What learning resources are provided to distance learning students?',
                    'answer' => 'Enrolled students receive access to the Shobhit University LMS containing digitized Self-Learning Material (SLM), recorded subject lectures, reference e-books, assignments, and weekend interactive live counseling sessions with faculty members.',
                ],
                [
                    'question' => 'Can working professionals pursue MBA or MCA without leaving their jobs?',
                    'answer' => 'Yes, absolutely. The programs are structured specifically for working executives and remote learners. Study schedules are completely flexible, and faculty doubt-clearing sessions are scheduled during weekends and evening hours.',
                ],
                [
                    'question' => 'What is the fee payment process and are installment options provided?',
                    'answer' => 'Fees can be paid semester-wise online through the official portal (shobhitodl.in) using debit card, credit card, net banking, or UPI. Easy semester installment options ensure that quality education remains affordable without financial hardship.',
                ],
                [
                    'question' => 'Does Shobhit University provide placement assistance to distance graduates?',
                    'answer' => 'Yes. Shobhit University\'s Corporate Resource Centre (CRC) offers active placement support, resume writing guidance, soft-skills enhancement workshops, and access to virtual job fairs with leading recruitment partners like Amazon, Wipro, Airtel, TCS, and HDFC Bank.',
                ],
                [
                    'question' => 'What are the eligibility requirements for admission into Shobhit University BBA and BCA programs?',
                    'answer' => 'Candidates must have passed 10+2 in any stream from a recognized board of school education. Admission is merit-based with direct online enrollment without any entrance examination.',
                ],
                [
                    'question' => 'Is Shobhit University accredited by NAAC?',
                    'answer' => 'Yes, Shobhit Institute of Engineering and Technology (Deemed to-be-University) is accredited with an prestigious \'A\' Grade by the National Assessment and Accreditation Council (NAAC).',
                ],
            ],

            // Placement Stats
            'placement_stats' => [
                ['label' => 'Highest Salary Package',        'value' => '₹23.00 LPA', 'year' => '2024'],
                ['label' => 'Average Salary Package',        'value' => '₹5.20 LPA',  'year' => '2024'],
                ['label' => 'Corporate Hiring Partners',     'value' => '250+ Companies', 'year' => '2024'],
                ['label' => 'Placement Assistance Rate',     'value' => '100% Career Support', 'year' => '2024'],
                ['label' => 'Virtual Campus Hiring Drives',  'value' => '120+ Drives', 'year' => '2024'],
                ['label' => 'Alumni Network Across India',    'value' => '50,000+ Alumni', 'year' => '2024'],
            ],

            // Top Recruiters
            'recruiters' => [
                'Amazon',
                'Airtel',
                'Wipro',
                'TCS',
                'Infosys',
                'HDFC Bank',
                'Bandhan Bank',
                'Cognizant',
                'Tech Mahindra',
                'Apollo Munich',
                'IBM',
                'Paytm',
            ],

            // Scholarships
            'scholarships' => [
                [
                    'name' => 'Shobhit University Academic Merit Scholarship',
                    'eligibility' => 'Students securing 75% and above aggregate marks in the qualifying examination.',
                    'criteria' => 'Academic Qualifying Marks (>=75%)',
                    'amount' => null,
                    'amount_label' => 'Up to 25% Tuition Fee Concession',
                    'percentage' => 'Up to 25%',
                    'description' => 'Granted to reward exceptional academic merit upon enrollment into distance & online degree programs.',
                ],
                [
                    'name' => 'Armed Forces & Defense Personnel Welfare Concession',
                    'eligibility' => 'Serving or retired Indian Armed Forces and Paramilitary personnel and their wards.',
                    'criteria' => 'Defense Service ID / Discharge Certificate',
                    'amount' => null,
                    'amount_label' => '20% Tuition Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Honorary 20% tuition fee waiver for defense personnel and their direct dependents.',
                ],
                [
                    'name' => 'Beti Bachao Beti Padhao / Women Empowerment Scholarship',
                    'eligibility' => 'All female candidates enrolling into undergraduate and postgraduate programs.',
                    'criteria' => 'Female Candidates Enrollment',
                    'amount' => null,
                    'amount_label' => '15% Tuition Fee Concession',
                    'percentage' => '15%',
                    'description' => 'Promotes higher education access and digital empowerment for women across India.',
                ],
                [
                    'name' => 'Shobhit University Alumni Fee Concession',
                    'eligibility' => 'Graduates of Shobhit University enrolling in higher postgraduate degree programs.',
                    'criteria' => 'Alumni Enrollment Record',
                    'amount' => null,
                    'amount_label' => '15% Tuition Fee Concession',
                    'percentage' => '15%',
                    'description' => 'Continuing education privilege grant for Shobhit alumni.',
                ],
                [
                    'name' => 'Divyang (Differently Abled) Scholarship',
                    'eligibility' => 'Differently-abled learners holding valid medical disability certificates (>40%).',
                    'criteria' => 'Government Medical Disability Certificate',
                    'amount' => null,
                    'amount_label' => '20% Fee Concession',
                    'percentage' => '20%',
                    'description' => 'Dedicated social welfare concession enabling barrier-free digital education.',
                ],
            ],

            // Admission Sections
            'admission_sections' => [
                [
                    'section_key' => 'admission_process',
                    'title' => 'Digital Admission Process for Shobhit ODL',
                    'content' => 'Admissions are conducted 100% online through shobhitodl.in or GrowPec without requiring any physical campus visit:',
                    'items' => [
                        'Step 1: Choose your preferred distance/online UG or PG program and complete the online registration form.',
                        'Step 2: Enter your personal, contact, and academic qualifications in the online portal.',
                        'Step 3: Upload self-attested digital copies of your marksheets, photo, and government identity card.',
                        'Step 4: University admission committee reviews your application and validates your eligibility.',
                        'Step 5: Pay the first semester tuition fee online securely through UPI, Net Banking, or Credit/Debit card.',
                        'Step 6: Receive your official Enrollment Number, Student Identity Card, and LMS portal login credentials.',
                    ],
                ],
                [
                    'section_key' => 'documents_required',
                    'title' => 'Documents Checklist for Online Enrollment',
                    'content' => 'Keep digital scanned copies of the following documents ready before applying:',
                    'items' => [
                        'Class 10th Certificate & Marksheet (as Date of Birth verification proof)',
                        'Class 12th Certificate & Marksheet (for UG and PG degree programs)',
                        'Graduation Degree Certificate & All Semester Marksheets (for PG MBA, MCA, M.Com, M.A., MLIS)',
                        'Valid Government Photo ID Proof (Aadhaar Card / Voter ID / Passport / Driving License)',
                        'Recent Passport-Sized Colored Photograph (White Background)',
                        'Defense / Disability / Category Certificate (if claiming applicable scholarship concessions)',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Database Inserters with Full Relational & Streamlining Support
    |--------------------------------------------------------------------------
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
                'is_popular' => in_array($def['city'], ['Meerut', 'Noida', 'Greater Noida', 'Gurugram', 'Moradabad', 'Aligarh', 'Mohali', 'Chandigarh']),
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
        $this->insertCollegeAccreditations($collegeId, $def['accreditations'] ?? []);
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

            // Ensure specialization exists
            $specId = $this->getOrCreateSpecialization($courseId, $c['slug'], $c['spec']);

            $ccData = [
                'college_id' => $collegeId,
                'course_id' => $courseId,
                'specialization' => $c['spec'],
                'specialization_id' => $specId,
                'fee_amount' => $c['fee'],
                'fee_type' => $c['type'] ?? 'per_year',
                'eligibility' => $c['eligibility'],
                'academic_session' => '2025-2026',
                'duration' => $c['duration'] ?? '2 Years',
                'seats' => $c['seats'] ?? 300,
                'entrance_exam' => $c['exam'] ?? 'Direct Admission / Merit Based',
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
                        'label' => 'Semester 1 Tuition Fee',
                        'amount' => $semFee,
                        'academic_session' => '2025-2026',
                        'description' => 'Semester 1 fee payable at registration.',
                        'sort_order' => 1,
                        'status' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                    [
                        'college_course_id' => $ccId,
                        'fee_type' => 'Semester Tuition Fee',
                        'label' => 'Semester 2 Tuition Fee',
                        'amount' => $semFee,
                        'academic_session' => '2025-2026',
                        'description' => 'Semester 2 tuition fee.',
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
                        'description' => 'Annual composite tuition fee including LMS & study material access.',
                        'sort_order' => 3,
                        'status' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                ]);
            }

            // Map specialization
            if (Schema::hasTable('college_course_specializations') && $specId) {
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
     * Dynamically find or create specialization
     */
    private function getOrCreateSpecialization(int $courseId, string $courseSlug, string $specName): ?int
    {
        $key = $courseSlug.'|'.$specName;
        if (isset($this->specializationIds[$key])) {
            return $this->specializationIds[$key];
        }

        $existing = DB::table('specializations')
            ->where('course_id', $courseId)
            ->where('name', $specName)
            ->value('id');

        if ($existing) {
            $this->specializationIds[$key] = (int) $existing;

            return (int) $existing;
        }

        $now = now();
        $newId = (int) DB::table('specializations')->insertGetId([
            'course_id' => $courseId,
            'name' => $specName,
            'slug' => Str::slug($courseSlug.'-'.$specName),
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->specializationIds[$key] = $newId;

        return $newId;
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
            $title = is_array($h) ? ($h['title'] ?? '') : (string) $h;
            $description = is_array($h) ? ($h['value'] ?? $h['description'] ?? null) : null;
            $icon = is_array($h) ? ($h['icon'] ?? 'bi-patch-check-fill') : 'bi-patch-check-fill';

            DB::table('college_highlights')->insert([
                'college_id' => $collegeId,
                'title' => $title,
                'description' => $description,
                'icon' => $icon,
                'sort_order' => $i + 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Insert accreditations
     */
    private function insertCollegeAccreditations(int $collegeId, array $items): void
    {
        if (! Schema::hasTable('college_accreditations')) {
            return;
        }

        $now = now();
        foreach ($items as $i => $a) {
            $authority = $a['authority'] ?? $a['body'] ?? 'UGC';
            $accreditation = $a['accreditation'] ?? $a['status'] ?? 'Approved';

            DB::table('college_accreditations')->insert([
                'college_id' => $collegeId,
                'authority' => $authority,
                'accreditation' => $accreditation,
                'grade' => $a['grade'] ?? null,
                'rank' => $a['rank'] ?? null,
                'year' => $a['year'] ?? null,
                'description' => $a['description'] ?? null,
                'certificate_image' => null,
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
        foreach ($items as $i => $fac) {
            DB::table('college_facilities')->insert([
                'college_id' => $collegeId,
                'name' => $fac['name'],
                'icon' => $fac['icon'] ?? 'bi-laptop',
                'description' => null,
                'image' => null,
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
        foreach ($items as $i => $faq) {
            $question = $faq['question'] ?? $faq['q'] ?? '';
            $answer = $faq['answer'] ?? $faq['a'] ?? '';

            DB::table('college_faqs')->insert([
                'college_id' => $collegeId,
                'question' => $question,
                'answer' => $answer,
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
                'description' => $name.' virtual hiring drives for online degree graduates.',
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
            ['parameter' => 'Type of University',    'value' => $def['type'].' University',                           'icon' => 'building'],
            ['parameter' => 'Year of Establishment', 'value' => (string) $def['year'],                                  'icon' => 'calendar'],
            ['parameter' => 'Statutory Approvals',   'value' => $def['approvals'],                                     'icon' => 'shield-check'],
            ['parameter' => 'NAAC Grade',            'value' => 'Grade '.($def['naac_grade'] ?? 'B++'),               'icon' => 'patch-check-fill'],
            ['parameter' => 'Mode of Education',     'value' => '100% Online Degree (UGC-DEB Entitled)',              'icon' => 'laptop'],
            ['parameter' => 'Examination Mode',      'value' => 'Online Proctored Remote Semester Examinations',       'icon' => 'display'],
            ['parameter' => 'Learning Platform',     'value' => 'IIMT Cloud LMS (Live Webinars & Recorded Classes)',  'icon' => 'camera-video'],
            ['parameter' => 'Highest Placement',     'value' => $def['highest'],                                      'icon' => 'briefcase'],
            ['parameter' => 'Average Package',       'value' => $def['average'],                                      'icon' => 'cash-coin'],
            ['parameter' => 'No-Cost EMI Options',   'value' => 'Available (Starting ₹2,500/Month)',                  'icon' => 'credit-card-2-front'],
            ['parameter' => 'Campus / Location',     'value' => $def['city'].', '.$def['state'],                  'icon' => 'pin-map'],
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
        $minFee = ! empty($fees) ? min($fees) : 10000;
        $maxFee = ! empty($fees) ? max($fees) : 28000;

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
            'college_mode' => 'online',
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
            'seo_title' => $d['name'].' — Online Degree Admission, Fees, Courses, Eligibility & Placements | GrowPec',
            'seo_description' => 'Explore '.$d['name'].' UGC-DEB entitled online degree programs, authentic fee structures, eligibility criteria, LMS platform, and placement support on GrowPec.',
        ];

        if (Schema::hasColumn('colleges', 'exam_mode')) {
            $payload['exam_mode'] = 'Online Proctored Remote Semester Examinations';
        }
        if (Schema::hasColumn('colleges', 'learning_mode')) {
            $payload['learning_mode'] = '100% Online + LMS Portal + Live Interactive Weekend Classes';
        }
        if (Schema::hasColumn('colleges', 'emi_available')) {
            $payload['emi_available'] = true;
        }
        if (Schema::hasColumn('colleges', 'emi_starts_at')) {
            $payload['emi_starts_at'] = 2500.00;
        }
        if (Schema::hasColumn('colleges', 'min_fees')) {
            $payload['min_fees'] = $minFee;
        }
        if (Schema::hasColumn('colleges', 'max_fees')) {
            $payload['max_fees'] = $maxFee;
        }
        if (Schema::hasColumn('colleges', 'facilities')) {
            $payload['facilities'] = json_encode(array_column($d['facilities'] ?? [], 'name'));
        }
        if (Schema::hasColumn('colleges', 'highlights')) {
            $payload['highlights'] = json_encode($d['highlights'] ?? []);
        }
        if (Schema::hasColumn('colleges', 'faqs')) {
            $payload['faqs'] = json_encode($d['faqs'] ?? []);
        }

        return $payload;
    }
}
