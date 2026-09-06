@extends('admin.layout')

@section('title', 'Edit College: ' . $college->name . ' - GrowPec Admin')
@section('header', 'Edit College: ' . $college->name)

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
<form action="{{ route('admin.colleges.update', $college->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- 👈 Left Column -->
        <div class="col-lg-8">
            
            <!-- 1. Basic Info -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-building me-1"></i> 1. Basic College Information</h5>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">College Name *</label>
                    <input type="text" name="name" value="{{ old('name', $college->name) }}" class="form-control" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">College Mode *</label>
                        <select name="college_mode" id="modeSelect" class="form-select fw-bold" required>
                            <option value="regular" {{ old('college_mode', $college->college_mode) == 'regular' ? 'selected' : '' }}>Regular Campus College</option>
                            <option value="online" {{ old('college_mode', $college->college_mode) == 'online' ? 'selected' : '' }}>100% Online & Distance University</option>
                            <option value="both" {{ old('college_mode', $college->college_mode) == 'both' ? 'selected' : '' }}>Both (Regular & Online)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Ownership / Status *</label>
                        <select name="college_type" class="form-select" required>
                            <option value="Private" {{ old('college_type', $college->college_type) == 'Private' ? 'selected' : '' }}>Private University</option>
                            <option value="Govt" {{ old('college_type', $college->college_type) == 'Govt' ? 'selected' : '' }}>Government University</option>
                            <option value="Deemed" {{ old('college_type', $college->college_type) == 'Deemed' ? 'selected' : '' }}>Deemed University</option>
                            <option value="Autonomous" {{ old('college_type', $college->college_type) == 'Autonomous' ? 'selected' : '' }}>Autonomous Institute</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Affiliated University / Accreditations</label>
                        <input type="text" name="university_name" value="{{ old('university_name', $college->university_name) }}" class="form-control" placeholder="e.g. UGC Recognized / AKTU Affiliated">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Approvals Badges</label>
                        <input type="text" name="approvals" value="{{ old('approvals', $college->approvals) }}" class="form-control" placeholder="e.g. UGC, AICTE, NAAC A+, DEB">
                    </div>
                </div>

                <!-- Media Uploads & Previews -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Change Banner Image (1200x500 px)</label>
                        <input type="file" name="banner_image" class="form-control form-control-sm" accept="image/*">
                        @if($college->banner_image)
                        <div class="mt-2">
                            <img src="{{ $college->banner_url }}" class="rounded border" style="height: 60px; width: 100%; object-fit: cover;" alt="Current Banner">
                            <small class="text-muted d-block mt-1">Current Banner</small>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Change College Logo (PNG / Square)</label>
                        <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                        @if($college->logo)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ $college->logo_url }}" class="rounded border p-1" style="width: 50px; height: 50px; object-fit: contain;" alt="Current Logo">
                            <small class="text-muted">Current Active Logo</small>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row g-3 mb-2">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Change Sample Degree Certificate</label>
                        <input type="file" name="sample_certificate_image" class="form-control form-control-sm" accept="image/*">
                        @if($college->certificate_url)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ $college->certificate_url }}" class="rounded border" style="height: 50px; object-fit: contain;" alt="Current Certificate">
                            <small class="text-muted">Certificate Attached</small>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Change Brochure PDF</label>
                        <input type="file" name="brochure_pdf" class="form-control form-control-sm" accept=".pdf">
                        @if($college->brochure_pdf)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $college->brochure_pdf) }}" target="_blank" class="btn btn-sm btn-outline-danger py-1">
                                <i class="bi bi-file-earmark-pdf me-1"></i> View Current PDF
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 2. Dynamic Courses, Streams & Specializations (EDIT) -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-mortarboard me-1"></i> 2. Courses, Fees & Specializations</h5>
                        <small class="text-muted">Manage offerings, streams & specializations</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-success fw-bold" id="addCourseRowBtn">
                        <i class="bi bi-plus-circle me-1"></i> + Add Course Row
                    </button>
                </div>

                <div id="coursesContainer">
                    @forelse($college->collegeCourses as $cc)
                    <div class="p-3 border rounded-3 bg-light mb-3 course-card-row position-relative"
                        data-initial-course-id="{{ $cc->course_id }}"
                        data-initial-stream-id="{{ $cc->course->stream_id ?? '' }}"
                        data-initial-specialization="{{ $cc->specialization ?? '' }}">
                        
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-course-btn" title="Remove Course">
                            <i class="bi bi-trash"></i>
                        </button>

                        <div class="row g-2 mb-2">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">1. Stream</label>
                                <select class="form-select form-select-sm stream-dropdown">
                                    <option value="">-- All Streams --</option>
                                    @foreach($streams as $st)
                                    <option value="{{ $st->id }}" {{ ($cc->course->stream_id ?? '') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">2. Course *</label>
                                <select name="course_ids[]" class="form-select form-select-sm course-dropdown" required>
                                    <option value="">-- Select Course --</option>
                                    @foreach($courses as $c)
                                    <option value="{{ $c->id }}" data-stream-id="{{ $c->stream_id }}" {{ $cc->course_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }} ({{ $c->level }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">3. Specialization</label>
                                <select name="specializations[]" class="form-select form-select-sm specialization-dropdown">
                                    <option value="">General / Core</option>
                                    @if($cc->course && $cc->course->specializations)
                                    @foreach($cc->course->specializations as $sp)
                                    <option value="{{ $sp->name }}" {{ $cc->specialization == $sp->name ? 'selected' : '' }}>{{ $sp->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Fee Amount (₹) *</label>
                                <input type="number" name="fee_amounts[]" value="{{ (int)$cc->fee_amount }}" class="form-control form-control-sm" placeholder="e.g. 75000" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Fee Frequency</label>
                                <select name="fee_types[]" class="form-select form-select-sm">
                                    <option value="per_year" {{ $cc->fee_type == 'per_year' ? 'selected' : '' }}>Per Year</option>
                                    <option value="per_semester" {{ $cc->fee_type == 'per_semester' ? 'selected' : '' }}>Per Semester</option>
                                    <option value="total_course" {{ $cc->fee_type == 'total_course' ? 'selected' : '' }}>Total Course</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Eligibility Criteria</label>
                                <input type="text" name="eligibilities[]" value="{{ $cc->eligibility }}" class="form-control form-control-sm" placeholder="e.g. 10+2 with 50% / Graduation">
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- Default fallback row -->
                    <div class="p-3 border rounded-3 bg-light mb-3 course-card-row position-relative">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-course-btn"><i class="bi bi-trash"></i></button>
                        <div class="row g-2 mb-2">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">1. Stream</label>
                                <select class="form-select form-select-sm stream-dropdown">
                                    <option value="">-- All Streams --</option>
                                    @foreach($streams as $st)
                                    <option value="{{ $st->id }}">{{ $st->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">2. Course *</label>
                                <select name="course_ids[]" class="form-select form-select-sm course-dropdown" required>
                                    <option value="">-- Select Course --</option>
                                    @foreach($courses as $c)
                                    <option value="{{ $c->id }}" data-stream-id="{{ $c->stream_id }}">{{ $c->name }} ({{ $c->level }})</option>
                                    @endforeach
                                </select>
                            </div>
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
                                <input type="number" name="fee_amounts[]" class="form-control form-control-sm" placeholder="e.g. 50000" required>
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
                                <input type="text" name="eligibilities[]" class="form-control form-control-sm" placeholder="e.g. 10+2">
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- 3. Rich Text Customizations (Bold, Italic, Lists) -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-fonts me-1"></i> 3. Detailed Sections (Rich Text Customizations)</h5>

                <div class="mb-4">
                    <label class="form-label small fw-bold">About / Overview Narrative (Bold, Italic, Headings, Bullets)</label>
                    <textarea name="overview" class="summernote">{{ old('overview', $college->overview) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Step-by-Step Admission Process</label>
                    <textarea name="admission_process" class="summernote">{{ old('admission_process', $college->admission_process) }}</textarea>
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Scholarship & Financial Aid Details</label>
                    <textarea name="scholarship_info" class="summernote">{{ old('scholarship_info', $college->scholarship_info) }}</textarea>
                </div>
            </div>

            <!-- 4. Key Highlights Repeater -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-star me-1"></i> 4. Key Highlights / USPs</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary fw-bold" id="addHighlightBtn">+ Add Highlight</button>
                </div>
                <div id="highlightsContainer">
                    @if(!empty($college->highlights) && count($college->highlights) > 0)
                    @foreach($college->highlights as $hl)
                    <div class="input-group mb-2 highlight-row">
                        <span class="input-group-text bg-light"><i class="bi bi-check2"></i></span>
                        <input type="text" name="highlights[]" value="{{ $hl }}" class="form-control form-control-sm" placeholder="Enter highlight...">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-highlight-btn"><i class="bi bi-x"></i></button>
                    </div>
                    @endforeach
                    @else
                    <div class="input-group mb-2 highlight-row">
                        <span class="input-group-text bg-light"><i class="bi bi-check2"></i></span>
                        <input type="text" name="highlights[]" class="form-control form-control-sm" placeholder="e.g. 100% Placement Assistance">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-highlight-btn"><i class="bi bi-x"></i></button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 5. Dynamic FAQs Repeater -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-question-circle me-1"></i> 5. FAQs</h5>
                    <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold" id="addFaqBtn">+ Add FAQ</button>
                </div>
                <div id="faqsContainer">
                    @if(!empty($college->faqs) && count($college->faqs) > 0)
                    @foreach($college->faqs as $f)
                    <div class="p-3 border rounded-3 bg-light mb-2 faq-row">
                        <input type="text" name="faq_questions[]" value="{{ $f['question'] ?? '' }}" class="form-control form-control-sm mb-2 fw-bold" placeholder="Question...">
                        <textarea name="faq_answers[]" rows="2" class="form-control form-control-sm" placeholder="Answer...">{{ $f['answer'] ?? '' }}</textarea>
                        <button type="button" class="btn btn-sm text-danger mt-1 remove-faq-btn p-0"><small><i class="bi bi-trash"></i> Remove FAQ</small></button>
                    </div>
                    @endforeach
                    @else
                    <div class="p-3 border rounded-3 bg-light mb-2 faq-row">
                        <input type="text" name="faq_questions[]" class="form-control form-control-sm mb-2 fw-bold" placeholder="Question...">
                        <textarea name="faq_answers[]" rows="2" class="form-control form-control-sm" placeholder="Answer..."></textarea>
                        <button type="button" class="btn btn-sm text-danger mt-1 remove-faq-btn p-0"><small><i class="bi bi-trash"></i> Remove FAQ</small></button>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- 👉 Right Column -->
        <div class="col-lg-4">
            
            <!-- Ratings & Status -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-sliders2 me-1"></i> Ratings & Status</h5>
                
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Star Rating (1 - 5)</label>
                        <input type="number" step="0.1" min="1" max="5" name="rating" value="{{ old('rating', $college->rating) }}" class="form-control form-control-sm font-monospace">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Review Count</label>
                        <input type="number" name="reviews_count" value="{{ old('reviews_count', $college->reviews_count) }}" class="form-control form-control-sm font-monospace">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Accepted Entrance Exams</label>
                    <input type="text" name="entrance_exams" value="{{ old('entrance_exams', $college->entrance_exams) }}" class="form-control form-control-sm" placeholder="e.g. CAT, MAT, JEE, CUET">
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="cbFeatured" {{ old('is_featured', $college->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small text-dark" for="cbFeatured">⭐ Mark as Featured College</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="status" value="1" id="cbStatus" {{ old('status', $college->status) ? 'checked' : '' }}>
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
                        <option value="{{ $st->name }}" data-id="{{ $st->id }}" {{ old('state', $college->state) == $st->name ? 'selected' : '' }}>
                            {{ $st->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">City *</label>
                    <select name="city" id="citySelect" class="form-select form-select-sm" required>
                        <option value="{{ $college->city }}">{{ $college->city }}</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Full Address</label>
                    <input type="text" name="address" value="{{ old('address', $college->address) }}" class="form-control form-control-sm">
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Estd. Year</label>
                        <input type="text" name="established_year" value="{{ old('established_year', $college->established_year) }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Campus Size</label>
                        <input type="text" name="campus_size" value="{{ old('campus_size', $college->campus_size) }}" class="form-control form-control-sm">
                    </div>
                </div>
            </div>

            <!-- Placements -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-briefcase me-1"></i> Placements</h5>
                
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Highest Package</label>
                        <input type="text" name="highest_package" value="{{ old('highest_package', $college->highest_package) }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Average Package</label>
                        <input type="text" name="average_package" value="{{ old('average_package', $college->average_package) }}" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="mb-1">
                    <label class="form-label small fw-bold">Top Recruiters</label>
                    <input type="text" name="top_recruiters" value="{{ old('top_recruiters', $college->top_recruiters) }}" class="form-control form-control-sm">
                </div>
            </div>

            <!-- Facilities & Amenities Checklist -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-buildings me-1"></i> Facilities & Amenities</h5>
                
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_boys_hostel" value="1" id="cbBoys" {{ old('has_boys_hostel', $college->has_boys_hostel) ? 'checked' : '' }}>
                            <label class="form-check-label small" for="cbBoys">Boys Hostel</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_girls_hostel" value="1" id="cbGirls" {{ old('has_girls_hostel', $college->has_girls_hostel) ? 'checked' : '' }}>
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
                    $savedFacilities = (array) ($college->facilities ?? []);
                @endphp

                <div class="row g-2">
                    @foreach($facilityList as $fac)
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $fac }}" id="fac_{{ $loop->index }}" {{ in_array($fac, $savedFacilities) ? 'checked' : '' }}>
                            <label class="form-check-label small" for="fac_{{ $loop->index }}">{{ $fac }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-warning py-3 fw-bold shadow-sm fs-6">
                    <i class="bi bi-check-circle-fill me-1"></i> Update College Details
                </button>
                <a href="{{ route('admin.colleges.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>

        </div>
    </div>
</form>

<script id="streamsJsonEdit" type="application/json">
    @json($streams)
</script>
<script id="coursesJsonEdit" type="application/json">
    @json($courses)
</script>

@push('scripts')
<!-- jQuery & Summernote Lite JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

<script>
    const streamsData = JSON.parse(document.getElementById('streamsJsonEdit').textContent || '[]');
    const coursesData = JSON.parse(document.getElementById('coursesJsonEdit').textContent || '[]');

    function setupCascadeRow(row) {
        const streamSelect = row.querySelector('.stream-dropdown');
        const courseSelect = row.querySelector('.course-dropdown');
        const specSelect = row.querySelector('.specialization-dropdown');

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
            courseSelect.dispatchEvent(new Event('change'));
        });

        courseSelect.addEventListener('change', function() {
            const courseId = this.value;
            const currentSpecVal = specSelect.value || row.getAttribute('data-initial-specialization');
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
                let foundMatch = false;
                if (selectedCourse.specializations && selectedCourse.specializations.length > 0) {
                    selectedCourse.specializations.forEach(s => {
                        if (s.status) {
                            const isSelected = (currentSpecVal && currentSpecVal.toLowerCase() === s.name.toLowerCase()) ? 'selected' : '';
                            if (isSelected) foundMatch = true;
                            specSelect.innerHTML += `<option value="${s.name}" ${isSelected}>${s.name}</option>`;
                        }
                    });
                }
                if (currentSpecVal && !foundMatch && currentSpecVal !== 'General / Core') {
                    specSelect.innerHTML += `<option value="${currentSpecVal}" selected>${currentSpecVal}</option>`;
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Summernote Rich Text Editor
        $('.summernote').summernote({
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

        document.querySelectorAll('.course-card-row').forEach(row => setupCascadeRow(row));

        // State -> City
        const stateSelect = document.getElementById('stateSelect');
        const citySelect = document.getElementById('citySelect');
        const currentCity = "{{ $college->city }}";

        function loadCities(stateId, selectedCity = null) {
            if (!stateId) return;
            fetch(`/api/states/${stateId}/cities`)
                .then(res => res.json())
                .then(cities => {
                    citySelect.innerHTML = '<option value="">Choose City</option>';
                    cities.forEach(c => {
                        const isSelected = (selectedCity && selectedCity === c.name) ? 'selected' : '';
                        citySelect.innerHTML += `<option value="${c.name}" ${isSelected}>${c.name}</option>`;
                    });
                });
        }

        if (stateSelect) {
            stateSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const stateId = selectedOption ? selectedOption.getAttribute('data-id') : null;
                citySelect.innerHTML = '<option value="">Loading...</option>';
                loadCities(stateId);
            });
            const initialOpt = stateSelect.options[stateSelect.selectedIndex];
            if (initialOpt && initialOpt.getAttribute('data-id')) {
                loadCities(initialOpt.getAttribute('data-id'), currentCity);
            }
        }

        // Add Course Row
        document.getElementById('addCourseRowBtn')?.addEventListener('click', function() {
            const container = document.getElementById('coursesContainer');
            const firstRow = container.querySelector('.course-card-row');
            if (firstRow) {
                const clone = firstRow.cloneNode(true);
                clone.removeAttribute('data-initial-course-id');
                clone.removeAttribute('data-initial-stream-id');
                clone.removeAttribute('data-initial-specialization');
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

        // Add Highlight & FAQ
        document.getElementById('addHighlightBtn')?.addEventListener('click', function() {
            const container = document.getElementById('highlightsContainer');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 highlight-row';
            div.innerHTML = `
                <span class="input-group-text bg-light"><i class="bi bi-check2"></i></span>
                <input type="text" name="highlights[]" class="form-control form-control-sm" placeholder="Enter highlight...">
                <button type="button" class="btn btn-outline-danger btn-sm remove-highlight-btn"><i class="bi bi-x"></i></button>
            `;
            container.appendChild(div);
        });

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