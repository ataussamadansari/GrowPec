@extends('admin.layout')

@section('title', 'Add New College - GrowPec Admin')
@section('header', 'Add New College')

@push('styles')
<!-- Summernote Lite CSS (Zero Conflict Rich Text Editor) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border-radius: 12px;
        border-color: #CBD5E1;
        overflow: hidden;
    }
    .note-toolbar {
        background: #F8FAFC !important;
        border-bottom: 1px solid #E2E8F0 !important;
    }
</style>
@endpush

@section('content')
<form action="{{ route('admin.colleges.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        <!-- 👈 Left Column (Main Details, Courses, Rich Text Sections) -->
        <div class="col-lg-8">
            
            <!-- 1. Basic Info -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-building me-1"></i> 1. Basic College Information</h5>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">College Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Amity University / Ganpat University Online" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">College Mode *</label>
                        <select name="college_mode" id="modeSelect" class="form-select fw-bold" required>
                            <option value="regular">Regular Campus College</option>
                            <option value="online">100% Online & Distance University</option>
                            <option value="both">Both (Regular & Online)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Ownership / Status *</label>
                        <select name="college_type" class="form-select" required>
                            <option value="Private">Private University</option>
                            <option value="Govt">Government University</option>
                            <option value="Deemed">Deemed University</option>
                            <option value="Autonomous">Autonomous Institute</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Affiliated University / Accreditations</label>
                        <input type="text" name="university_name" class="form-control" placeholder="e.g. UGC Recognized / AKTU Affiliated">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Approvals Badges</label>
                        <input type="text" name="approvals" class="form-control" placeholder="e.g. UGC, AICTE, NAAC A+, DEB">
                    </div>
                </div>

                <!-- Media Uploads -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">College Banner Image (1200x500 px)</label>
                        <input type="file" name="banner_image" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">College Logo (PNG / Square)</label>
                        <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>

                <div class="row g-3 mb-2">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Sample Degree Certificate Image</label>
                        <input type="file" name="sample_certificate_image" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Brochure Document (PDF)</label>
                        <input type="file" name="brochure_pdf" class="form-control form-control-sm" accept=".pdf">
                    </div>
                </div>
            </div>

            <!-- 2. Dynamic Courses, Streams & Specializations -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-mortarboard me-1"></i> 2. Courses, Fees & Specializations</h5>
                        <small class="text-muted">Select Stream $\rightarrow$ Course $\rightarrow$ Specialization with fee details</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-success fw-bold" id="addCourseRowBtn">
                        <i class="bi bi-plus-circle me-1"></i> + Add Course Row
                    </button>
                </div>

                <div id="coursesContainer">
                    <div class="p-3 border rounded-3 bg-light mb-3 course-card-row position-relative">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-course-btn" title="Remove Course">
                            <i class="bi bi-trash"></i>
                        </button>
                        <div class="row g-2 mb-2">
                            <!-- Stream Select -->
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">1. Stream</label>
                                <select class="form-select form-select-sm stream-dropdown">
                                    <option value="">-- All Streams --</option>
                                    @foreach($streams as $st)
                                    <option value="{{ $st->id }}">{{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Course Select -->
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">2. Course *</label>
                                <select name="course_ids[]" class="form-select form-select-sm course-dropdown" required>
                                    <option value="">-- Select Course --</option>
                                    @foreach($courses as $c)
                                    <option value="{{ $c->id }}" data-stream-id="{{ $c->stream_id }}">
                                        {{ $c->name }} ({{ $c->level }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Specialization Select -->
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">3. Specialization</label>
                                <select name="specializations[]" class="form-select form-select-sm specialization-dropdown">
                                    <option value="">General / Core</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Fee Amount (₹) *</label>
                                <input type="number" name="fee_amounts[]" class="form-control form-control-sm" placeholder="e.g. 75000" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Fee Frequency</label>
                                <select name="fee_types[]" class="form-select form-select-sm">
                                    <option value="per_year">Per Year</option>
                                    <option value="per_semester">Per Semester</option>
                                    <option value="total_course">Total Course</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Eligibility Criteria</label>
                                <input type="text" name="eligibilities[]" class="form-control form-control-sm" placeholder="e.g. 10+2 with 50% / Graduation">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Rich Text Customizations (Bold, Italic, Headings, Lists) -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-fonts me-1"></i> 3. Detailed Sections (Rich Text Customizations)</h5>

                <!-- About Overview -->
                <div class="mb-4">
                    <label class="form-label small fw-bold">About / Overview Narrative (Supports Bold, Italic, Bullets)</label>
                    <textarea name="overview" class="summernote" placeholder="Write university history, vision, campus culture..."></textarea>
                </div>

                <!-- Admission Process -->
                <div class="mb-4">
                    <label class="form-label small fw-bold">Step-by-Step Admission Process</label>
                    <textarea name="admission_process" class="summernote" placeholder="Step 1: Application Form, Step 2: Verification, Step 3: Fee Payment..."></textarea>
                </div>

                <!-- Scholarship Info -->
                <div class="mb-2">
                    <label class="form-label small fw-bold">Scholarship & Financial Aid Details</label>
                    <textarea name="scholarship_info" class="summernote" placeholder="Merit scholarship criteria, fee waivers, loan assistance..."></textarea>
                </div>
            </div>

            <!-- 4. Key Highlights Repeater -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-star me-1"></i> 4. Key Highlights / USPs</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary fw-bold" id="addHighlightBtn">+ Add Highlight</button>
                </div>
                <div id="highlightsContainer">
                    <div class="input-group mb-2 highlight-row">
                        <span class="input-group-text bg-light"><i class="bi bi-check2"></i></span>
                        <input type="text" name="highlights[]" class="form-control form-control-sm" placeholder="e.g. 100% Placement & Interview Training Assistance">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-highlight-btn"><i class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>

            <!-- 5. Dynamic FAQs Repeater -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-question-circle me-1"></i> 5. Frequently Asked Questions (FAQs)</h5>
                    <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold" id="addFaqBtn">+ Add FAQ</button>
                </div>
                <div id="faqsContainer">
                    <div class="p-3 border rounded-3 bg-light mb-2 faq-row">
                        <input type="text" name="faq_questions[]" class="form-control form-control-sm mb-2 fw-bold" placeholder="Question: e.g. Is this degree UGC approved?">
                        <textarea name="faq_answers[]" rows="2" class="form-control form-control-sm" placeholder="Answer: e.g. Yes, all degrees are fully approved and recognized..."></textarea>
                        <button type="button" class="btn btn-sm text-danger mt-1 remove-faq-btn p-0"><small><i class="bi bi-trash"></i> Remove FAQ</small></button>
                    </div>
                </div>
            </div>

        </div>

        <!-- 👉 Right Column (Location, Stats, Ratings, Facilities, Status) -->
        <div class="col-lg-4">
            
            <!-- Ratings & Publish Status -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-sliders2 me-1"></i> Ratings & Status</h5>
                
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Star Rating (1 - 5)</label>
                        <input type="number" step="0.1" min="1" max="5" name="rating" value="4.8" class="form-control form-control-sm font-monospace">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Review Count</label>
                        <input type="number" name="reviews_count" value="180" class="form-control form-control-sm font-monospace">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Accepted Entrance Exams</label>
                    <input type="text" name="entrance_exams" class="form-control form-control-sm" placeholder="e.g. CAT, MAT, JEE, CUET">
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="cbFeatured" checked>
                    <label class="form-check-label fw-bold small text-dark" for="cbFeatured">⭐ Mark as Featured College</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="status" value="1" id="cbStatus" checked>
                    <label class="form-check-label fw-bold small text-dark" for="cbStatus">Active (Published on Website)</label>
                </div>
            </div>

            <!-- Location -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-geo-alt me-1"></i> Location</h5>
                
                <div class="mb-2">
                    <label class="form-label small fw-bold">State *</label>
                    <select name="state" id="stateSelect" class="form-select form-select-sm" required>
                        <option value="">Select State</option>
                        @foreach($states as $st)
                        <option value="{{ $st->name }}" data-id="{{ $st->id }}">{{ $st->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">City *</label>
                    <select name="city" id="citySelect" class="form-select form-select-sm" required>
                        <option value="">Choose State First</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Full Address</label>
                    <input type="text" name="address" class="form-control form-control-sm" placeholder="Campus address...">
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Estd. Year</label>
                        <input type="text" name="established_year" class="form-control form-control-sm" placeholder="e.g. 2004">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Campus Size</label>
                        <input type="text" name="campus_size" class="form-control form-control-sm" placeholder="e.g. 60 Acres">
                    </div>
                </div>
            </div>

            <!-- Placements & Packages -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-briefcase me-1"></i> Placements</h5>
                
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Highest Package</label>
                        <input type="text" name="highest_package" class="form-control form-control-sm" placeholder="e.g. 24.0 LPA">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Average Package</label>
                        <input type="text" name="average_package" class="form-control form-control-sm" placeholder="e.g. 6.5 LPA">
                    </div>
                </div>

                <div class="mb-1">
                    <label class="form-label small fw-bold">Top Recruiters</label>
                    <input type="text" name="top_recruiters" class="form-control form-control-sm" placeholder="Amazon, TCS, Infosys, Deloitte">
                </div>
            </div>

            <!-- Campus Amenities & Facilities Checklist -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-buildings me-1"></i> Facilities & Amenities</h5>
                
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_boys_hostel" value="1" id="cbBoys">
                            <label class="form-check-label small" for="cbBoys">Boys Hostel</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_girls_hostel" value="1" id="cbGirls">
                            <label class="form-check-label small" for="cbGirls">Girls Hostel</label>
                        </div>
                    </div>
                </div>

                <label class="form-label small fw-bold d-block text-muted">Additional Infrastructure:</label>
                @php
                    $facilityList = [
                        'High-Speed Wi-Fi',
                        'Central Digital Library',
                        'Cafeteria & Food Court',
                        'Sports Arena & Gym',
                        'Air-Conditioned Classrooms',
                        'Hi-Tech Research Labs',
                        'Auditorium & Seminar Halls',
                        'Medical / Health Center',
                        'Transport & Bus Service',
                        'ATM & Banking Facility',
                    ];
                @endphp

                <div class="row g-2">
                    @foreach($facilityList as $fac)
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $fac }}" id="fac_{{ $loop->index }}">
                            <label class="form-check-label small" for="fac_{{ $loop->index }}">{{ $fac }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-warning py-3 fw-bold shadow-sm fs-6">
                    <i class="bi bi-check-circle-fill me-1"></i> Save & Publish College
                </button>
                <a href="{{ route('admin.colleges.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>

        </div>
    </div>
</form>

<!-- Data Containers -->
<script id="streamsJson" type="application/json">
    @json($streams)
</script>
<script id="coursesJson" type="application/json">
    @json($courses)
</script>

@push('scripts')
<!-- jQuery & Summernote Lite JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

<script>
    const streamsData = JSON.parse(document.getElementById('streamsJson').textContent || '[]');
    const coursesData = JSON.parse(document.getElementById('coursesJson').textContent || '[]');

    function setupCascadeRow(row) {
        const streamSelect = row.querySelector('.stream-dropdown');
        const courseSelect = row.querySelector('.course-dropdown');
        const specSelect = row.querySelector('.specialization-dropdown');

        if (!streamSelect || !courseSelect || !specSelect) return;

        // Stream change -> Filter courses
        streamSelect.addEventListener('change', function() {
            const streamId = this.value;
            let filteredCourses = coursesData;
            if (streamId) {
                filteredCourses = coursesData.filter(c => c.stream_id == streamId);
            }
            courseSelect.innerHTML = '<option value="">-- Select Course --</option>';
            filteredCourses.forEach(c => {
                courseSelect.innerHTML += `<option value="${c.id}" data-stream-id="${c.stream_id}">${c.name} (${c.level})</option>`;
            });
            specSelect.innerHTML = '<option value="">General / Core</option>';
        });

        // Course change -> Load specializations
        courseSelect.addEventListener('change', function() {
            const courseId = this.value;
            if (!courseId) {
                specSelect.innerHTML = '<option value="">General / Core</option>';
                return;
            }
            const selectedCourse = coursesData.find(c => c.id == courseId);
            if (selectedCourse) {
                if (selectedCourse.stream_id && !streamSelect.value) {
                    streamSelect.value = selectedCourse.stream_id;
                }
                specSelect.innerHTML = '<option value="">General / Core</option>';
                if (selectedCourse.specializations && selectedCourse.specializations.length > 0) {
                    selectedCourse.specializations.forEach(s => {
                        if (s.status) {
                            specSelect.innerHTML += `<option value="${s.name}">${s.name}</option>`;
                        }
                    });
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Summernote Rich Text Editor
        $('.summernote').summernote({
            placeholder: 'Type content with bold, italic, lists, and formatting...',
            tabsize: 2,
            height: 180,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        // Setup Course Cascade
        document.querySelectorAll('.course-card-row').forEach(row => setupCascadeRow(row));

        // State -> City
        const stateSelect = document.getElementById('stateSelect');
        const citySelect = document.getElementById('citySelect');
        if (stateSelect) {
            stateSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const stateId = selectedOption ? selectedOption.getAttribute('data-id') : null;
                citySelect.innerHTML = '<option value="">Loading...</option>';
                if (stateId) {
                    fetch(`/api/states/${stateId}/cities`)
                        .then(res => res.json())
                        .then(cities => {
                            citySelect.innerHTML = '<option value="">Choose City</option>';
                            cities.forEach(c => {
                                citySelect.innerHTML += `<option value="${c.name}">${c.name}</option>`;
                            });
                        });
                } else {
                    citySelect.innerHTML = '<option value="">Choose State First</option>';
                }
            });
        }

        // Add Course Row
        document.getElementById('addCourseRowBtn')?.addEventListener('click', function() {
            const container = document.getElementById('coursesContainer');
            const firstRow = container.querySelector('.course-card-row');
            if (firstRow) {
                const clone = firstRow.cloneNode(true);
                clone.querySelectorAll('input').forEach(i => i.value = '');
                clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
                const courseSelect = clone.querySelector('.course-dropdown');
                courseSelect.innerHTML = '<option value="">-- Select Course --</option>';
                coursesData.forEach(c => {
                    courseSelect.innerHTML += `<option value="${c.id}" data-stream-id="${c.stream_id}">${c.name} (${c.level})</option>`;
                });
                container.appendChild(clone);
                setupCascadeRow(clone);
            }
        });

        // Add Highlight
        document.getElementById('addHighlightBtn')?.addEventListener('click', function() {
            const container = document.getElementById('highlightsContainer');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 highlight-row';
            div.innerHTML = `
                <span class="input-group-text bg-light"><i class="bi bi-check2"></i></span>
                <input type="text" name="highlights[]" class="form-control form-control-sm" placeholder="Enter key highlight...">
                <button type="button" class="btn btn-outline-danger btn-sm remove-highlight-btn"><i class="bi bi-x"></i></button>
            `;
            container.appendChild(div);
        });

        // Add FAQ
        document.getElementById('addFaqBtn')?.addEventListener('click', function() {
            const container = document.getElementById('faqsContainer');
            const div = document.createElement('div');
            div.className = 'p-3 border rounded-3 bg-light mb-2 faq-row';
            div.innerHTML = `
                <input type="text" name="faq_questions[]" class="form-control form-control-sm mb-2 fw-bold" placeholder="Question...">
                <textarea name="faq_answers[]" rows="2" class="form-control form-control-sm" placeholder="Answer..."></textarea>
                <button type="button" class="btn btn-sm text-danger mt-1 remove-faq-btn p-0"><small><i class="bi bi-trash"></i> Remove FAQ</small></button>
            `;
            container.appendChild(div);
        });

        // Remove Handlers
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-course-btn')) {
                const rows = document.querySelectorAll('.course-card-row');
                if (rows.length > 1) {
                    e.target.closest('.course-card-row').remove();
                } else {
                    alert('At least one course entry is required.');
                }
            }
            if (e.target.closest('.remove-highlight-btn')) {
                e.target.closest('.highlight-row').remove();
            }
            if (e.target.closest('.remove-faq-btn')) {
                e.target.closest('.faq-row').remove();
            }
        });
    });
</script>
@endpush
@endsection