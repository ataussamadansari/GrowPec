@extends('layouts.app')

@section('title', $college->name . ' - Admission, Courses, Fees, Placements & Brochure | GrowPEC')

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-50 py-3 border-b border-gray-200 text-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2" aria-label="breadcrumb">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">Home</a>
            <span class="text-gray-400">/</span>
            <a href="{{ $college->college_mode == 'online' ? route('colleges.online') : route('colleges.regular') }}" class="text-gray-600 hover:text-gray-900">
                {{ $college->college_mode == 'online' ? 'Online Colleges' : 'Regular Colleges' }}
            </a>
            <span class="text-gray-400">/</span>
            <span class="font-bold text-gray-900">{{ $college->name }}</span>
        </nav>
    </div>
</div>

<!-- HERO SECTION: Banner, Logo Overlay, Info & Admission Form -->
<div class="bg-white border-b border-gray-200 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Left: Banner & Info (2 cols on desktop) -->
            <div class="lg:col-span-2">
                <!-- Banner with Logo Overlay -->
                <div class="relative rounded-2xl overflow-hidden bg-black shadow-lg mb-4" style="height: 330px;">
                    <img src="{{ $college->banner_url }}" class="w-full h-full object-cover" alt="{{ $college->name }}">
                    <!-- Logo Overlay -->
                    <div class="absolute top-4 left-4 w-20 h-20 bg-white rounded-2xl p-1.5 shadow-lg flex items-center justify-center">
                        <img src="{{ $college->logo_url ?? $college->banner_url }}" alt="{{ $college->name }} logo" class="w-full h-full object-contain rounded-lg">
                    </div>
                </div>

                <!-- Badges Row -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-bold rounded-full">
                        {{ $college->college_type }} University
                    </span>
                    <span class="inline-flex items-center px-3 py-1.5 {{ $college->college_mode == 'online' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-900' }} text-xs font-bold rounded-full">
                        {{ strtoupper($college->college_mode) }}
                    </span>
                    @if($college->approvals)
                    <span class="inline-flex items-center px-3 py-1.5 bg-yellow-50 text-yellow-700 text-xs font-bold rounded-full gap-1">
                        <i class="bi bi-shield-check"></i> {{ $college->approvals }}
                    </span>
                    @endif
                    <span class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 text-gray-900 text-xs font-bold rounded-full gap-1">
                        <i class="bi bi-star-fill text-yellow-400"></i> {{ $college->rating }} ({{ $college->reviews_count }} Reviews)
                    </span>
                    @if($college->entrance_exams)
                    <span class="inline-flex items-center px-3 py-1.5 bg-cyan-50 text-cyan-700 text-xs font-bold rounded-full gap-1">
                        <i class="bi bi-pencil-fill"></i> Exams: {{ $college->entrance_exams }}
                    </span>
                    @endif
                    @if($college->is_featured)
                    <span class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 text-xs font-bold rounded-full gap-1">
                        <i class="bi bi-patch-check-fill"></i> Featured
                    </span>
                    @endif
                </div>

                <!-- Title & Affiliation -->
                <h1 class="text-3xl font-bold text-purple-900 mb-2">{{ $college->name }}</h1>
                <p class="text-gray-700 text-sm mb-4">
                    <i class="bi bi-geo-alt-fill text-red-600 mr-1"></i>
                    {{ $college->address ?? ($college->city . ', ' . $college->state) }}
                    @if($college->university_name)
                        • Affiliated to: <strong>{{ $college->university_name }}</strong>
                    @endif
                    @if($college->established_year)
                        • Estd. Year: <strong>{{ $college->established_year }}</strong>
                    @endif
                    @if($college->campus_size)
                        • Campus: <strong>{{ $college->campus_size }}</strong>
                    @endif
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-2">
                    <a href="#admissionSupportForm" class="inline-flex items-center gap-2 px-6 py-2.5 bg-purple-900 text-white font-bold rounded-full hover:bg-purple-800 transition">
                        <i class="bi bi-telephone-forward"></i> Get in Touch
                    </a>
                    @if($college->brochure_pdf)
                    <a href="{{ asset('storage/' . $college->brochure_pdf) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 bg-yellow-500 text-gray-900 font-bold rounded-full hover:bg-yellow-600 transition">
                        <i class="bi bi-download"></i> Download Brochure
                    </a>
                    @endif
                    <a href="https://wa.me/{{ $siteSettings['general.whatsapp_number'] ?? '918858285271' }}?text=Hello,%20I%20am%20interested%20in%20{{ urlencode($college->name) }}%20{{ urlencode($college->city) }}%20Admission.%20Please%20guide%20with%20Fees%20and%20Scholarship%20details." 
                       target="_blank" 
                       class="inline-flex items-center gap-2 px-6 py-2.5 bg-green-500 text-white font-bold rounded-full hover:bg-green-600 transition">
                        <i class="bi bi-whatsapp"></i> WhatsApp Query
                    </a>
                </div>
            </div>

            <!-- Right: Sticky Admission Form (1 col on desktop) -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-6 sticky top-32 max-h-[calc(100vh-150px)] overflow-y-auto">
                    <h4 class="text-lg font-bold text-purple-900 mb-4 flex items-center gap-2">
                        <i class="bi bi-headset text-yellow-500"></i> Get 1-on-1 Support
                    </h4>
                    
                    <form action="{{ route('lead.submit') }}" method="POST" id="admissionSupportForm">
                        @csrf
                        <input type="hidden" name="college_id" value="{{ $college->id }}">
                        <input type="hidden" name="source" value="college_detail_page">

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Name <span class="text-red-600">*</span></label>
                            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-full text-sm bg-white focus:border-purple-600 focus:ring-2 focus:ring-purple-100" value="{{ Auth::user()->name ?? '' }}" placeholder="Enter your full name" required>
                        </div>

                        <!-- Mobile -->
                        <div class="mb-3">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Mobile <span class="text-red-600">*</span></label>
                            <input type="tel" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-full text-sm bg-white focus:border-purple-600 focus:ring-2 focus:ring-purple-100" value="{{ Auth::user()->phone ?? '' }}" placeholder="WhatsApp mobile" maxlength="10" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Email <span class="text-red-600">*</span></label>
                            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-full text-sm bg-white focus:border-purple-600 focus:ring-2 focus:ring-purple-100" value="{{ str_ends_with(Auth::user()->email ?? '', '@growpec.local') ? '' : (Auth::user()->email ?? '') }}" placeholder="Enter email" required>
                        </div>

                        <!-- Course -->
                        <div class="mb-3">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Program <span class="text-red-600">*</span></label>
                            <select name="course_id" class="w-full px-4 py-2 border border-gray-300 rounded-full text-sm bg-white focus:border-purple-600 focus:ring-2 focus:ring-purple-100" required>
                                <option value="">-- Choose Course --</option>
                                @foreach($college->collegeCourses as $cc)
                                <option value="{{ $cc->course_id }}">
                                    {{ $cc->course->name }} @if($cc->specialization) ({{ $cc->specialization }}) @endif
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- State -->
                        <div class="mb-3">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">State <span class="text-red-600">*</span></label>
                            <select name="state" id="leadCardStateSelect" class="w-full px-4 py-2 border border-gray-300 rounded-full text-sm bg-white focus:border-purple-600 focus:ring-2 focus:ring-purple-100" required>
                                <option value="">Select State</option>
                                @php
                                $leadStates = \App\Models\State::where('status', true)->orderBy('name')->get();
                                @endphp
                                @foreach($leadStates as $st)
                                <option value="{{ $st->name }}" data-id="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- City -->
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">City <span class="text-red-600">*</span></label>
                            <select name="city" id="leadCardCitySelect" class="w-full px-4 py-2 border border-gray-300 rounded-full text-sm bg-white focus:border-purple-600 focus:ring-2 focus:ring-purple-100" required>
                                <option value="">Choose State First</option>
                            </select>
                        </div>

                        <div id="admissionSupportMsg"></div>

                        <button type="submit" id="admissionSupportBtn" class="w-full py-2.5 bg-purple-700 text-white font-bold rounded-full text-sm hover:bg-purple-600 transition shadow-sm">
                            Save & Request Callback
                        </button>

                        <p class="text-center text-gray-600 mt-2 mb-0 text-xs">
                            100% Free & Unbiased Guidance
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CONTENT: Quick Nav Sidebar + Content Blocks -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <!-- Left Sidebar: Quick Navigation (1 col on desktop) -->
        <div class="hidden lg:block lg:col-span-1">
            <div class="bg-white border border-gray-200 rounded-2xl p-2.5 sticky top-32 max-h-[calc(100vh-150px)] overflow-y-auto">
                <p class="text-xs font-bold text-gray-600 uppercase px-3 py-2 tracking-wide">Quick Jump</p>
                @foreach($quickNav as $index => $nav)
                <a href="#{{ $nav['id'] }}" class="quick-nav-link flex items-center gap-2 px-3 py-2.5 text-sm font-semibold text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-xl transition {{ $index === 0 ? 'bg-purple-100 text-purple-700 border-l-4 border-purple-700' : '' }}" data-target="{{ $nav['id'] }}">
                    <i class="bi {{ $nav['icon'] }}"></i>
                    <span>{{ $nav['title'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Right Side: Content Blocks (3 cols on desktop) -->
        <div class="lg:col-span-3">

            <!-- 1. QUICK FACTS TABLE -->
            <div class="bg-white border border-gray-200 rounded-2xl p-7 mb-6 scroll-mt-28" id="sec-overview">
                <h3 class="text-xl font-bold text-purple-900 mb-4 pb-3 border-b-2 border-purple-100 flex items-center gap-2">
                    <i class="bi bi-info-circle-fill text-yellow-500"></i> Quick Facts & Snapshot
                </h3>
                <div class="overflow-x-auto mb-6">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="bg-yellow-500 text-black font-bold px-4 py-3 text-left text-sm border border-gray-300" style="width: 40%;">Particulars</th>
                                <th class="bg-yellow-500 text-black font-bold px-4 py-3 text-left text-sm border border-gray-300">Details</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr>
                                <td class="font-semibold text-gray-600 px-4 py-2 border border-gray-300">Mode of Education</td>
                                <td class="font-bold text-gray-900 px-4 py-2 border border-gray-300">{{ ucfirst($college->college_mode) }} Mode</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="font-semibold text-gray-600 px-4 py-2 border border-gray-300">Ownership / Status</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $college->college_type }} University</td>
                            </tr>
                            <tr>
                                <td class="font-semibold text-gray-600 px-4 py-2 border border-gray-300">Approvals & Accreditations</td>
                                <td class="px-4 py-2 border border-gray-300"><span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">{{ $college->approvals ?? 'UGC / AICTE / DEB Approved' }}</span></td>
                            </tr>
                            @if($college->entrance_exams)
                            <tr class="bg-gray-50">
                                <td class="font-semibold text-gray-600 px-4 py-2 border border-gray-300">Accepted Entrance Exams</td>
                                <td class="font-bold text-blue-600 px-4 py-2 border border-gray-300">{{ $college->entrance_exams }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="font-semibold text-gray-600 px-4 py-2 border border-gray-300">Campus Location</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $college->city }}, {{ $college->state }} {{ $college->campus_size ? '('.$college->campus_size.')' : '' }}</td>
                            </tr>
                            @if($college->highest_package)
                            <tr class="bg-gray-50">
                                <td class="font-semibold text-gray-600 px-4 py-2 border border-gray-300">Highest Salary Package</td>
                                <td class="font-bold text-green-600 text-lg px-4 py-2 border border-gray-300">{{ $college->highest_package }}</td>
                            </tr>
                            @endif
                            @if($college->average_package)
                            <tr>
                                <td class="font-semibold text-gray-600 px-4 py-2 border border-gray-300">Average Salary Package</td>
                                <td class="font-bold text-gray-900 px-4 py-2 border border-gray-300">{{ $college->average_package }}</td>
                            </tr>
                            @endif
                            @if($college->college_mode !== 'online')
                            <tr class="bg-gray-50">
                                <td class="font-semibold text-gray-600 px-4 py-2 border border-gray-300">Hostel Facilities</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    @if($college->has_boys_hostel) <span class="inline-block bg-gray-100 text-gray-900 px-2 py-1 rounded text-xs font-semibold mr-1">Boys Hostel</span> @endif
                                    @if($college->has_girls_hostel) <span class="inline-block bg-gray-100 text-gray-900 px-2 py-1 rounded text-xs font-semibold">Girls Hostel</span> @endif
                                    @if(!$college->has_boys_hostel && !$college->has_girls_hostel) <span class="text-gray-600">Day Scholar Campus</span> @endif
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- About Section -->
                <div class="pt-4 border-t border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3">About {{ $college->name }}</h4>
                    <div class="text-gray-700 leading-relaxed text-sm space-y-3">
                        @if(!empty($college->overview))
                            {!! $college->overview !!}
                        @else
                            <p>{{ $college->name }} is a premier institution located in {{ $college->city }}, {{ $college->state }}. Offering verified industry-aligned degree programs with experienced faculty, modern research facilities, and active placement assistance.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 2. KEY HIGHLIGHTS -->
            @if(!empty($college->highlights) && count($college->highlights) > 0)
            <div class="bg-white border border-gray-200 rounded-2xl p-7 mb-6 scroll-mt-28" id="sec-highlights">
                <h3 class="text-xl font-bold text-purple-900 mb-4 pb-3 border-b-2 border-purple-100 flex items-center gap-2">
                    <i class="bi bi-star-fill text-yellow-500"></i> Key Highlights & USPs
                </h3>
                <div class="space-y-3">
                    @foreach($college->highlights as $highlight)
                    <div class="flex items-start gap-3 p-3 bg-purple-50 border border-purple-200 rounded-lg">
                        <i class="bi bi-check-circle-fill text-green-600 mt-0.5 text-lg flex-shrink-0"></i>
                        <span class="font-semibold text-gray-800">{{ $highlight }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 3. COURSES & FEES TABLE -->
            @if($college->collegeCourses->count() > 0)
            <div class="bg-white border border-gray-200 rounded-2xl p-7 mb-6 scroll-mt-28" id="sec-courses">
                <h3 class="text-xl font-bold text-purple-900 mb-4 pb-3 border-b-2 border-purple-100 flex items-center gap-2">
                    <i class="bi bi-mortarboard-fill text-blue-600"></i> Courses, Fees & Specializations
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr>
                                <th class="bg-purple-100 text-purple-900 font-bold px-3 py-2.5 text-left border border-gray-300">Course</th>
                                <th class="bg-purple-100 text-purple-900 font-bold px-3 py-2.5 text-left border border-gray-300">Specialization</th>
                                <th class="bg-purple-100 text-purple-900 font-bold px-3 py-2.5 text-left border border-gray-300">Duration</th>
                                <th class="bg-purple-100 text-purple-900 font-bold px-3 py-2.5 text-left border border-gray-300">Eligibility</th>
                                <th class="bg-purple-100 text-purple-900 font-bold px-3 py-2.5 text-left border border-gray-300">Fee Structure</th>
                                <th class="bg-purple-100 text-purple-900 font-bold px-3 py-2.5 text-center border border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($college->collegeCourses as $cc)
                            <tr>
                                <td class="font-bold text-gray-900 px-3 py-2 border border-gray-300">
                                    {{ $cc->course->name }}
                                    <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-0.5 rounded ml-1">{{ $cc->course->level }}</span>
                                </td>
                                <td class="px-3 py-2 border border-gray-300 text-gray-700">{{ $cc->specialization ?: 'General / Core' }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-gray-700">{{ $cc->course->duration }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-gray-600 text-xs">{{ $cc->eligibility ?: '10+2 with 50% / Graduation' }}</td>
                                <td class="px-3 py-2 border border-gray-300">
                                    <strong class="text-green-600 text-lg block">₹ {{ number_format($cc->fee_amount) }}</strong>
                                    <small class="text-gray-600">/ {{ str_replace('_', ' ', $cc->fee_type) }}</small>
                                </td>
                                <td class="px-3 py-2 border border-gray-300 text-center">
                                    <a href="#admissionSupportForm" class="inline-block px-4 py-1.5 bg-yellow-500 text-gray-900 font-bold rounded-full text-xs hover:bg-yellow-600 transition">
                                        Apply Now
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- 4. ADMISSION PROCESS -->
            @if(!empty($college->admission_process))
            <div class="bg-white border border-gray-200 rounded-2xl p-7 mb-6 scroll-mt-28" id="sec-admission">
                <h3 class="text-xl font-bold text-purple-900 mb-4 pb-3 border-b-2 border-purple-100 flex items-center gap-2">
                    <i class="bi bi-card-checklist text-green-600"></i> Step-by-Step Admission Process
                </h3>
                <div class="text-gray-700 leading-relaxed text-sm space-y-3">
                    {!! $college->admission_process !!}
                </div>
            </div>
            @endif

            <!-- 5. APPROVALS & ACCREDITATIONS -->
            <div class="bg-white border border-gray-200 rounded-2xl p-7 mb-6 scroll-mt-28" id="sec-approvals">
                <h3 class="text-xl font-bold text-purple-900 mb-4 pb-3 border-b-2 border-purple-100 flex items-center gap-2">
                    <i class="bi bi-shield-check text-yellow-500"></i> Approvals & Accreditations
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr>
                                <th class="bg-yellow-500 text-black font-bold px-4 py-3 text-left border border-gray-300">Statutory Body</th>
                                <th class="bg-yellow-500 text-black font-bold px-4 py-3 text-left border border-gray-300">Accreditation Status</th>
                                <th class="bg-yellow-500 text-black font-bold px-4 py-3 text-left border border-gray-300">Validity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-bold px-4 py-2 border border-gray-300">University Grants Commission (UGC)</td>
                                <td class="px-4 py-2 border border-gray-300">Fully Recognized under section 2(f) / 12(B)</td>
                                <td class="px-4 py-2 border border-gray-300"><span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Valid Nationwide</span></td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="font-bold px-4 py-2 border border-gray-300">AICTE / Distance Education Bureau (DEB)</td>
                                <td class="px-4 py-2 border border-gray-300">Approved for Technical & Management Programs</td>
                                <td class="px-4 py-2 border border-gray-300"><span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Approved</span></td>
                            </tr>
                            <tr>
                                <td class="font-bold px-4 py-2 border border-gray-300">Accreditation Badges</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $college->approvals ?: 'Accredited with Grade A+' }}</td>
                                <td class="px-4 py-2 border border-gray-300"><span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">Certified</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 6. SAMPLE DEGREE & CERTIFICATE -->
            @if($college->certificate_url)
            <div class="bg-white border border-gray-200 rounded-2xl p-7 mb-6 scroll-mt-28" id="sec-certificate">
                <h3 class="text-xl font-bold text-purple-900 mb-4 pb-3 border-b-2 border-purple-100 flex items-center gap-2">
                    <i class="bi bi-patch-check-fill text-green-600"></i> Sample Degree & Certification
                </h3>
                <p class="text-gray-600 text-sm mb-4">
                    Degrees awarded by {{ $college->name }} carry full government approvals and are valid for all state/central government jobs, corporate hiring, and higher studies worldwide.
                </p>
                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 bg-purple-50 text-center">
                    <img src="{{ $college->certificate_url }}" class="mx-auto rounded-lg shadow-md" style="max-height: 380px; object-fit: contain;" alt="Sample Certificate">
                </div>
            </div>
            @endif

            <!-- 7. PLACEMENTS & RECRUITERS -->
            @if(!empty($college->highest_package) || !empty($college->average_package) || !empty($college->top_recruiters))
            <div class="bg-white border border-gray-200 rounded-2xl p-7 mb-6 scroll-mt-28" id="sec-placements">
                <h3 class="text-xl font-bold text-purple-900 mb-4 pb-3 border-b-2 border-purple-100 flex items-center gap-2">
                    <i class="bi bi-briefcase-fill text-red-600"></i> Placement Records & Recruiters
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    @if($college->highest_package)
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-gray-600 text-xs mb-1">Highest Salary Package</p>
                        <h3 class="text-2xl font-bold text-green-600">{{ $college->highest_package }}</h3>
                    </div>
                    @endif
                    @if($college->average_package)
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-gray-600 text-xs mb-1">Average Salary Package</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $college->average_package }}</h3>
                    </div>
                    @endif
                </div>
                @if($college->top_recruiters)
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="font-bold text-gray-900 text-sm mb-2 flex items-center gap-2">
                        <i class="bi bi-building-check text-blue-600"></i> Prominent Hiring Partners
                    </p>
                    <p class="text-gray-700 text-sm">{{ $college->top_recruiters }}</p>
                </div>
                @endif
            </div>
            @endif

            <!-- 8. SCHOLARSHIPS & FINANCIAL AID -->
            @if(!empty($college->scholarship_info))
            <div class="bg-white border border-gray-200 rounded-2xl p-7 mb-6 scroll-mt-28" id="sec-scholarships">
                <h3 class="text-xl font-bold text-purple-900 mb-4 pb-3 border-b-2 border-purple-100 flex items-center gap-2">
                    <i class="bi bi-award-fill text-yellow-500"></i> Scholarships & Financial Support
                </h3>
                <div class="text-gray-700 leading-relaxed text-sm space-y-3">
                    {!! $college->scholarship_info !!}
                </div>
            </div>
            @endif

            <!-- 9. CAMPUS INFRASTRUCTURE & FACILITIES -->
            @if($college->college_mode !== 'online' && ($college->has_boys_hostel || $college->has_girls_hostel || $college->campus_size || !empty($college->facilities)))
            <div class="bg-white border border-gray-200 rounded-2xl p-7 mb-6 scroll-mt-28" id="sec-facilities">
                <h3 class="text-xl font-bold text-purple-900 mb-4 pb-3 border-b-2 border-purple-100 flex items-center gap-2">
                    <i class="bi bi-buildings-fill text-blue-600"></i> Campus Infrastructure & Facilities
                </h3>
                <div class="flex flex-wrap gap-2">
                    @if(!empty($college->facilities) && is_array($college->facilities))
                        @foreach($college->facilities as $fac)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-900 text-xs font-semibold rounded-full border border-gray-300">
                            <i class="bi bi-check-circle-fill text-blue-600"></i> {{ $fac }}
                        </span>
                        @endforeach
                    @endif
                    @if($college->has_boys_hostel) 
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-900 text-xs font-semibold rounded-full border border-gray-300">
                            <i class="bi bi-house text-gray-900"></i> Boys Hostel
                        </span>
                    @endif
                    @if($college->has_girls_hostel) 
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-900 text-xs font-semibold rounded-full border border-gray-300">
                            <i class="bi bi-house-heart text-red-600"></i> Girls Hostel
                        </span>
                    @endif
                    @if($college->campus_size) 
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-900 text-xs font-semibold rounded-full border border-gray-300">
                            <i class="bi bi-geo-alt text-yellow-500"></i> Campus: {{ $college->campus_size }}
                        </span>
                    @endif
                </div>
            </div>
            @endif

            <!-- 10. FAQs -->
            @if(!empty($college->faqs) && count($college->faqs) > 0)
            <div class="bg-white border border-gray-200 rounded-2xl p-7 mb-6 scroll-mt-28" id="sec-faqs">
                <h3 class="text-xl font-bold text-purple-900 mb-4 pb-3 border-b-2 border-purple-100 flex items-center gap-2">
                    <i class="bi bi-question-circle-fill text-yellow-500"></i> Frequently Asked Questions
                </h3>
                <div id="collegeFaqs" class="space-y-2">
                    @foreach($college->faqs as $idx => $faq)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button class="w-full flex items-center justify-between px-4 py-3 hover:bg-gray-50 transition font-bold text-gray-900" type="button" data-bs-toggle="collapse" data-bs-target="#faq_{{ $idx }}">
                            {{ $faq['question'] ?? 'Question' }}
                            <i class="bi bi-chevron-down text-gray-600"></i>
                        </button>
                        <div id="faq_{{ $idx }}" class="collapse {{ $idx === 0 ? 'show' : '' }}" data-bs-parent="#collegeFaqs">
                            <div class="px-4 py-3 bg-gray-50 text-gray-700 text-sm border-t border-gray-200">
                                {{ $faq['answer'] ?? '' }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 11. RELATED INSTITUTES -->
            @if(isset($relatedColleges) && $relatedColleges->count() > 0)
            <div class="mt-6 pt-4">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Similar Institutes in {{ $college->state }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($relatedColleges as $rel)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition p-4">
                        <img src="{{ $rel->banner_url }}" class="rounded-lg mb-3 w-full" style="height: 120px; object-fit: cover;" alt="{{ $rel->name }}">
                        <h6 class="font-bold text-gray-900 mb-1.5">
                            <a href="{{ route('college.show', $rel->slug) }}" class="text-gray-900 hover:text-purple-700">{{ $rel->name }}</a>
                        </h6>
                        <p class="text-gray-600 text-xs mb-3 flex items-center gap-1">
                            <i class="bi bi-geo-alt text-red-600"></i> {{ $rel->city }}, {{ $rel->state }}
                        </p>
                        <a href="{{ route('college.show', $rel->slug) }}" class="block w-full px-4 py-2 bg-purple-100 text-purple-900 font-bold rounded-lg text-sm text-center hover:bg-purple-200 transition">
                            View College
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Dynamic ScrollSpy for Quick Navigation
        const navLinks = document.querySelectorAll('.quick-nav-link');
        const sections = Array.from(navLinks).map(link => document.getElementById(link.getAttribute('data-target'))).filter(Boolean);

        window.addEventListener('scroll', () => {
            let currentSectionId = '';
            const scrollPosition = window.scrollY + 140;

            sections.forEach(section => {
                if (section.offsetTop <= scrollPosition) {
                    currentSectionId = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('bg-purple-100', 'text-purple-700', 'border-l-4', 'border-purple-700');
                if (link.getAttribute('data-target') === currentSectionId) {
                    link.classList.add('bg-purple-100', 'text-purple-700', 'border-l-4', 'border-purple-700');
                }
            });
        });

        // 2. State -> City dropdown
        const stateDropdown = document.getElementById('leadCardStateSelect');
        const cityDropdown = document.getElementById('leadCardCitySelect');

        if (stateDropdown) {
            stateDropdown.addEventListener('change', function() {
                const selectedOpt = this.options[this.selectedIndex];
                const stateId = selectedOpt ? selectedOpt.getAttribute('data-id') : null;

                cityDropdown.innerHTML = '<option value="">Loading...</option>';

                if (stateId) {
                    fetch(`/api/states/${stateId}/cities`)
                        .then(res => res.json())
                        .then(cities => {
                            cityDropdown.innerHTML = '<option value="">Select City</option>';
                            cities.forEach(c => {
                                cityDropdown.innerHTML += `<option value="${c.name}">${c.name}</option>`;
                            });
                        })
                        .catch(() => {
                            cityDropdown.innerHTML = '<option value="">Select City</option>';
                        });
                } else {
                    cityDropdown.innerHTML = '<option value="">Select City</option>';
                }
            });
        }

        // 3. AJAX Lead Submission
        const leadForm = document.getElementById('admissionSupportForm');
        if (leadForm) {
            leadForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = document.getElementById('admissionSupportBtn');
                const msg = document.getElementById('admissionSupportMsg');

                btn.disabled = true;
                btn.innerText = 'Saving...';

                fetch("{{ route('lead.submit') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        "Accept": "application/json"
                    },
                    body: new FormData(this)
                })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerText = 'Save & Request Callback';
                    msg.innerHTML = `<div class="alert alert-success py-2 px-4 text-center text-sm rounded-lg mb-3 bg-green-100 text-green-800">${data.message || 'Thank you! We will contact you soon.'}</div>`;
                    leadForm.reset();
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerText = 'Save & Request Callback';
                    msg.innerHTML = `<div class="alert alert-danger py-2 px-4 text-center text-sm rounded-lg mb-3 bg-red-100 text-red-800">Something went wrong. Try again.</div>`;
                });
            });
        }
    });
</script>
@endpush
@endsection