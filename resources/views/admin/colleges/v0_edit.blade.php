@extends('admin.layout')

@section('title', 'Edit College: ' . $college->name . ' - GrowPec Admin')
@section('header', 'Edit College: ' . $college->name)

@section('content')
<form action="{{ route('admin.colleges.update', $college->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Left Column: Main Info, Courses, Highlights & FAQs -->
        <div class="col-lg-8">
            
            <!-- 1. Basic Information -->
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
                        <label class="form-label small fw-bold">Ownership / Type *</label>
                        <select name="college_type" class="form-select" required>
                            <option value="Private" {{ old('college_type', $college->college_type) == 'Private' ? 'selected' : '' }}>Private University</option>
                            <option value="Govt" {{ old('college_type', $college->college_type) == 'Govt' ? 'selected' : '' }}>Government University</option>
                            <option value="Deemed" {{ old('college_type', $college->college_type) == 'Deemed' ? 'selected' : '' }}>Deemed University</option>
                            <option value="Autonomous" {{ old('college_type', $college->college_type) == 'Autonomous' ? 'selected' : '' }}>Autonomous Institute</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Affiliated University</label>
                    <input type="text" name="university_name" value="{{ old('university_name', $college->university_name) }}" class="form-control" placeholder="e.g. UGC Recognized / AKTU Affiliated">
                </div>

                <!-- Banner & Logo Files with Previews -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Banner Image</label>
                        <input type="file" name="banner_image" class="form-control form-control-sm" accept="image/*">
                        @if($college->banner_image)
                        <div class="mt-2">
                            <img src="{{ $college->banner_url }}" class="rounded border" style="height: 60px; width: 100%; object-fit: cover;" alt="Current Banner">
                            <small class="text-muted d-block mt-1">Current Banner</small>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">College Logo</label>
                        <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                        @if($college->logo)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ $college->logo_url }}" class="rounded border p-1" style="width: 50px; height: 50px; object-fit: contain;" alt="Current Logo">
                            <small class="text-muted">Current Logo</small>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Certificate & Brochure Files with Previews -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Sample Degree Certificate</label>
                        <input type="file" name="sample_certificate_image" class="form-control form-control-sm" accept="image/*">
                        @if($college->certificate_url)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ $college->certificate_url }}" class="rounded border" style="height: 50px; object-fit: contain;" alt="Current Certificate">
                            <small class="text-muted">Current Certificate Attached</small>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Brochure PDF</label>
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

                <div class="mb-3">
                    <label class="form-label small fw-bold">About / Overview Narrative</label>
                    <textarea name="overview" rows="3" class="form-control">{{ old('overview', $college->overview) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Admission Process Steps</label>
                    <textarea name="admission_process" rows="3" class="form-control">{{ old('admission_process', $college->admission_process) }}</textarea>
                </div>
            </div>

            <!-- 2. Dynamic Courses, Specializations & Fees -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-mortarboard me-1"></i> 2. Courses, Fees & Eligibility</h5>
                    <button type="button" class="btn btn-sm btn-outline-success fw-bold" id="addCourseRowBtn">
                        <i class="bi bi-plus-circle me-1"></i> + Add Course
                    </button>
                </div>

                <div id="coursesContainer">
                    @forelse($college->collegeCourses as $cc)
                    <div class="row g-2 align-items-end mb-3 course-row border-bottom pb-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Course *</label>
                            <select name="course_ids[]" class="form-select form-select-sm" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ $cc->course_id == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->level }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Specialization</label>
                            <input type="text" name="specializations[]" value="{{ $cc->specialization }}" class="form-control form-control-sm" placeholder="e.g. Marketing / AI">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Fee (₹)</label>
                            <input type="number" name="fee_amounts[]" value="{{ (int)$cc->fee_amount }}" class="form-control form-control-sm" placeholder="e.g. 75000" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Frequency</label>
                            <select name="fee_types[]" class="form-select form-select-sm">
                                <option value="per_year" {{ $cc->fee_type == 'per_year' ? 'selected' : '' }}>Per Year</option>
                                <option value="per_semester" {{ $cc->fee_type == 'per_semester' ? 'selected' : '' }}>Per Sem</option>
                                <option value="total_course" {{ $cc->fee_type == 'total_course' ? 'selected' : '' }}>Total Course</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-danger remove-course-btn"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    @empty
                    <div class="row g-2 align-items-end mb-3 course-row border-bottom pb-3">
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
                            <input type="text" name="specializations[]" class="form-control form-control-sm" placeholder="e.g. AI / HR">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Fee (₹)</label>
                            <input type="number" name="fee_amounts[]" class="form-control form-control-sm" placeholder="e.g. 50000" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Frequency</label>
                            <select name="fee_types[]" class="form-select form-select-sm">
                                <option value="per_year">Per Year</option>
                                <option value="per_semester">Per Sem</option>
                                <option value="total_course">Total</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-danger remove-course-btn"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- 3. Key Highlights Repeater -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-star me-1"></i> 3. Key Highlights / USPs</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary fw-bold" id="addHighlightBtn">+ Add Highlight</button>
                </div>
                <div id="highlightsContainer">
                    @if(!empty($college->highlights) && count($college->highlights) > 0)
                        @foreach($college->highlights as $hl)
                        <div class="input-group mb-2 highlight-row">
                            <span class="input-group-text bg-light">🎯</span>
                            <input type="text" name="highlights[]" value="{{ $hl }}" class="form-control form-control-sm" placeholder="Enter highlight...">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-highlight-btn"><i class="bi bi-x"></i></button>
                        </div>
                        @endforeach
                    @else
                        <div class="input-group mb-2 highlight-row">
                            <span class="input-group-text bg-light">🎯</span>
                            <input type="text" name="highlights[]" class="form-control form-control-sm" placeholder="e.g. 100% Placement & Interview Training Assistance">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-highlight-btn"><i class="bi bi-x"></i></button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 4. Dynamic FAQs Repeater -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-question-circle me-1"></i> 4. FAQs</h5>
                    <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold" id="addFaqBtn">+ Add FAQ</button>
                </div>
                <div id="faqsContainer">
                    @if(!empty($college->faqs) && count($college->faqs) > 0)
                        @foreach($college->faqs as $f)
                        <div class="p-3 border rounded-3 bg-light mb-2 faq-row">
                            <input type="text" name="faq_questions[]" value="{{ $f['question'] ?? '' }}" class="form-control form-control-sm mb-2 fw-bold" placeholder="Question: e.g. Is this degree UGC approved?">
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

        <!-- Right Column: Location, Placements, Hostels & Actions -->
        <div class="col-lg-4">
            
            <!-- Location (Dynamic State -> City) -->
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
                    <label class="form-label small fw-bold">Established Year</label>
                    <input type="text" name="established_year" value="{{ old('established_year', $college->established_year) }}" class="form-control form-control-sm" placeholder="e.g. 2004">
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Campus Size</label>
                    <input type="text" name="campus_size" value="{{ old('campus_size', $college->campus_size) }}" class="form-control form-control-sm" placeholder="e.g. 50 Acres">
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Approvals (Badges)</label>
                    <input type="text" name="approvals" value="{{ old('approvals', $college->approvals) }}" class="form-control form-control-sm" placeholder="UGC, AICTE, NAAC A+">
                </div>
            </div>

            <!-- Placements & Hostels -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-briefcase me-1"></i> Placements & Hostels</h5>
                
                <div class="mb-2">
                    <label class="form-label small fw-bold">Highest Package</label>
                    <input type="text" name="highest_package" value="{{ old('highest_package', $college->highest_package) }}" class="form-control form-control-sm" placeholder="e.g. 18.0 LPA">
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Average Package</label>
                    <input type="text" name="average_package" value="{{ old('average_package', $college->average_package) }}" class="form-control form-control-sm" placeholder="e.g. 5.5 LPA">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Top Recruiters</label>
                    <input type="text" name="top_recruiters" value="{{ old('top_recruiters', $college->top_recruiters) }}" class="form-control form-control-sm" placeholder="TCS, Infosys, Wipro, Amazon">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Scholarship Info</label>
                    <textarea name="scholarship_info" rows="2" class="form-control form-control-sm" placeholder="Merit scholarships up to 25% waiver...">{{ old('scholarship_info', $college->scholarship_info) }}</textarea>
                </div>

                <div id="hostelFacilitiesWrapper">
                    <label class="form-label small fw-bold d-block">Hostel Facilities</label>
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="has_boys_hostel" value="1" id="cbBoys" {{ old('has_boys_hostel', $college->has_boys_hostel) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="cbBoys">Boys Hostel Available</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="has_girls_hostel" value="1" id="cbGirls" {{ old('has_girls_hostel', $college->has_girls_hostel) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="cbGirls">Girls Hostel Available</label>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-warning py-2 fw-bold shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> Update College Details
                    </button>
                    <a href="{{ route('admin.colleges.index') }}" class="btn btn-outline-secondary btn-sm">
                        Cancel
                    </a>
                </div>
            </div>

        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Dynamic State -> City loading on Edit page
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
            })
            .catch(() => {
                citySelect.innerHTML = '<option value="">Error loading cities</option>';
            });
    }

    if (stateSelect) {
        stateSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stateId = selectedOption ? selectedOption.getAttribute('data-id') : null;
            citySelect.innerHTML = '<option value="">Loading cities...</option>';
            loadCities(stateId);
        });

        // Initial trigger if state selected
        const initialOpt = stateSelect.options[stateSelect.selectedIndex];
        if (initialOpt && initialOpt.getAttribute('data-id')) {
            loadCities(initialOpt.getAttribute('data-id'), currentCity);
        }
    }

    // 2. Add Course Row
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

    // 3. Add Highlight
    document.getElementById('addHighlightBtn')?.addEventListener('click', function() {
        const container = document.getElementById('highlightsContainer');
        const div = document.createElement('div');
        div.className = 'input-group mb-2 highlight-row';
        div.innerHTML = `
            <span class="input-group-text bg-light">🎯</span>
            <input type="text" name="highlights[]" class="form-control form-control-sm" placeholder="Enter highlight...">
            <button type="button" class="btn btn-outline-danger btn-sm remove-highlight-btn"><i class="bi bi-x"></i></button>
        `;
        container.appendChild(div);
    });

    // 4. Add FAQ
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

    // 5. Global removal listener
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
});
</script>
@endpush
@endsection