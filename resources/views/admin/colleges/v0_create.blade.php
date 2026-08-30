@extends('admin.layout')

@section('title', 'Add New College - GrowPec Admin')
@section('header', 'Add New College')

@section('content')
<form action="{{ route('admin.colleges.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- 1. Basic Info -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-building me-1"></i> 1. Basic College Info</h5>
                <div class="mb-3">
                    <label class="form-label small fw-bold">College Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Ganpat University / Amity University Online" required>
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
                        <label class="form-label small fw-bold">Ownership / Type *</label>
                        <select name="college_type" class="form-select" required>
                            <option value="Private">Private University</option>
                            <option value="Govt">Government University</option>
                            <option value="Deemed">Deemed University</option>
                            <option value="Autonomous">Autonomous Institute</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Affiliated University</label>
                    <input type="text" name="university_name" class="form-control" placeholder="e.g. UGC Recognized / AKTU Affiliated">
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Banner Image</label>
                        <input type="file" name="banner_image" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">College Logo</label>
                        <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Sample Degree Certificate</label>
                        <input type="file" name="sample_certificate_image" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Brochure (PDF)</label>
                        <input type="file" name="brochure_pdf" class="form-control form-control-sm" accept=".pdf">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">About / Overview Narrative</label>
                    <textarea name="overview" rows="3" class="form-control" placeholder="Write university background, vision, faculty..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Admission Process Steps</label>
                    <textarea name="admission_process" rows="3" class="form-control" placeholder="Step 1: Application, Step 2: Verification..."></textarea>
                </div>
            </div>

            <!-- 2. Dynamic Courses & Fees -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-mortarboard me-1"></i> 2. Courses, Fees & Eligibility</h5>
                    <button type="button" class="btn btn-sm btn-outline-success fw-bold" id="addCourseRowBtn">
                        <i class="bi bi-plus-circle me-1"></i> + Add Course
                    </button>
                </div>
                <div id="coursesContainer">
                    <div class="row g-2 align-items-end mb-3 course-row border-bottom pb-2">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Course *</label>
                            <select name="course_ids[]" class="form-select form-select-sm" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->level }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Specialization</label>
                            <input type="text" name="specializations[]" class="form-control form-control-sm" placeholder="e.g. Marketing / AI">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Fee (₹)</label>
                            <input type="number" name="fee_amounts[]" class="form-control form-control-sm" placeholder="e.g. 75000" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Frequency</label>
                            <select name="fee_types[]" class="form-select form-select-sm">
                                <option value="per_year">Per Year</option>
                                <option value="per_sem">Per Semester</option>
                                <option value="total_course">Total Course</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-danger remove-course-btn"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Key Highlights Repeater -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-star me-1"></i> 3. Key Highlights / USPs</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary fw-bold" id="addHighlightBtn">+ Add Highlight</button>
                </div>
                <div id="highlightsContainer">
                    <div class="input-group mb-2 highlight-row">
                        <span class="input-group-text bg-light">🎯</span>
                        <input type="text" name="highlights[]" class="form-control form-control-sm" placeholder="e.g. 100% Placement & Interview Training Assistance">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-highlight-btn"><i class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>

            <!-- 4. Dynamic FAQs Repeater -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-question-circle me-1"></i> 4. FAQs</h5>
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

        <!-- Right Column: Location, Placements & Hostels -->
        <div class="col-lg-4">
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
                    <label class="form-label small fw-bold">Established Year</label>
                    <input type="text" name="established_year" class="form-control form-control-sm" placeholder="e.g. 2004">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Campus Size</label>
                    <input type="text" name="campus_size" class="form-control form-control-sm" placeholder="e.g. 50 Acres">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Approvals (Badges)</label>
                    <input type="text" name="approvals" class="form-control form-control-sm" placeholder="UGC, AICTE, NAAC A+">
                </div>
            </div>

            <!-- Placements & Hostels -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-briefcase me-1"></i> Placements & Hostels</h5>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Highest Package</label>
                    <input type="text" name="highest_package" class="form-control form-control-sm" placeholder="e.g. 18.0 LPA">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Average Package</label>
                    <input type="text" name="average_package" class="form-control form-control-sm" placeholder="e.g. 5.5 LPA">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Top Recruiters</label>
                    <input type="text" name="top_recruiters" class="form-control form-control-sm" placeholder="TCS, Infosys, Wipro, Amazon">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Scholarships Info</label>
                    <textarea name="scholarship_info" rows="2" class="form-control form-control-sm" placeholder="Merit scholarships up to 25% waiver..."></textarea>
                </div>
                <div id="hostelFacilitiesWrapper">
                    <label class="form-label small fw-bold d-block">Hostel Facilities</label>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="has_boys_hostel" value="1" id="cbBoys">
                        <label class="form-check-label small" for="cbBoys">Boys Hostel Available</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="has_girls_hostel" value="1" id="cbGirls">
                        <label class="form-check-label small" for="cbGirls">Girls Hostel Available</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning w-100 py-2 fw-bold shadow-sm">
                    Save & Publish College
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dynamic State -> City
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
            const firstRow = container.querySelector('.course-row');
            if (firstRow) {
                const clone = firstRow.cloneNode(true);
                clone.querySelectorAll('input').forEach(i => i.value = '');
                clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
                container.appendChild(clone);
            }
        });

        // Add Highlight
        document.getElementById('addHighlightBtn')?.addEventListener('click', function() {
            const container = document.getElementById('highlightsContainer');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 highlight-row';
            div.innerHTML = `
            <span class="input-group-text bg-light">🎯</span>
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

        // Global Removal Listener
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-course-btn')) {
                const rows = document.querySelectorAll('.course-row');
                if (rows.length > 1) e.target.closest('.course-row').remove();
            }
            if (e.target.closest('.remove-highlight-btn')) {
                e.target.closest('.highlight-row').remove();
            }
            if (e.target.closest('.remove-faq-btn')) {
                e.target.closest('.faq-row').remove();
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.matches('select[name="course_ids[]"]')) {
                const courseSelect = e.target;
                const row = courseSelect.closest('.course-row');
                const specInputOrSelect = row.querySelector('input[name="specializations[]"], select[name="specializations[]"]');
                const courseId = courseSelect.value;

                if (courseId) {
                    fetch(`/api/courses/${courseId}/specializations`)
                        .then(res => res.json())
                        .then(specializations => {
                            if (specializations.length > 0) {
                                let selectHtml = `<select name="specializations[]" class="form-select form-select-sm">`;
                                selectHtml += `<option value="">General / Core</option>`;
                                specializations.forEach(s => {
                                    selectHtml += `<option value="${s.name}">${s.name}</option>`;
                                });
                                selectHtml += `</select>`;
                                specInputOrSelect.outerHTML = selectHtml;
                            }
                        });
                }
            }
        });
    });
</script>
@endpush
@endsection