@extends('admin.layout')
@section('title', 'Add New College - GrowPec Admin')
@section('header', 'Add New College')

@section('content')
<form action="{{ route('admin.colleges.store') }}" method="POST">
    @csrf

    <div class="row g-4">
        <!-- 1. Basic Details -->
        <div class="col-lg-8">
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary">1. Basic College Information</h5>
                <div class="mb-3">
                    <label class="form-label small fw-bold">College Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Amity University Lucknow" required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">College Mode *</label>
                        <select name="college_mode" class="form-select" required>
                            <option value="regular">Regular Campus</option>
                            <option value="online">100% Online</option>
                            <option value="both">Both (Regular & Online)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Ownership / Type *</label>
                        <select name="college_type" class="form-select" required>
                            <option value="Private">Private</option>
                            <option value="Govt">Government</option>
                            <option value="Deemed">Deemed</option>
                            <option value="Autonomous">Autonomous</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Affiliated University Name</label>
                    <input type="text" name="university_name" class="form-control" placeholder="e.g. AKTU / Amity University">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Banner Image URL</label>
                    <input type="url" name="banner_image" class="form-control" placeholder="https://images.unsplash.com/photo-...">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">About / Overview</label>
                    <textarea name="overview" rows="4" class="form-control" placeholder="Write college introduction, history, infrastructure details..."></textarea>
                </div>
            </div>

            <!-- 2. Dynamic Courses & Fees -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary">2. Courses, Fees & Eligibility</h5>
                    <button type="button" class="btn btn-sm btn-outline-success fw-bold" id="addCourseRowBtn">
                        <i class="bi bi-plus-circle me-1"></i> + Add Another Course
                    </button>
                </div>

                <div id="coursesContainer">
                    <div class="row g-2 align-items-end mb-3 course-row border-bottom pb-2">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Select Course</label>
                            <select name="course_ids[]" class="form-select form-select-sm">
                                <option value="">Select Course</option>
                                @foreach($courses as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->level }} - {{ $c->duration }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Annual Fee (₹)</label>
                            <input type="number" name="fee_amounts[]" class="form-control form-control-sm" placeholder="e.g. 85000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Eligibility</label>
                            <input type="text" name="eligibilities[]" class="form-control form-control-sm" placeholder="e.g. 10+2 with 50%">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-danger remove-course-btn"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Sidebar: Location, Snapshot & Facilities -->
        <div class="col-lg-4">
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary">3. Location & Snapshot</h5>
                <div class="mb-2">
                    <label class="form-label small fw-bold">State *</label>
                    <input type="text" name="state" class="form-control form-control-sm" placeholder="e.g. Uttar Pradesh" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">City *</label>
                    <input type="text" name="city" class="form-control form-control-sm" placeholder="e.g. Lucknow, Varanasi" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Full Address</label>
                    <input type="text" name="address" class="form-control form-control-sm" placeholder="Campus address...">
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
                    <label class="form-label small fw-bold">Approvals / Accreditations</label>
                    <input type="text" name="approvals" class="form-control form-control-sm" placeholder="e.g. UGC, AICTE, NAAC A+">
                </div>
            </div>

            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary">4. Placements & Hostels</h5>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Highest Package</label>
                    <input type="text" name="highest_package" class="form-control form-control-sm" placeholder="e.g. 25.0 LPA">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Average Package</label>
                    <input type="text" name="average_package" class="form-control form-control-sm" placeholder="e.g. 6.5 LPA">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Top Recruiters</label>
                    <input type="text" name="top_recruiters" class="form-control form-control-sm" placeholder="TCS, Wipro, Infosys, Amazon">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="has_boys_hostel" value="1" id="cbBoys">
                    <label class="form-check-label small" for="cbBoys">Boys Hostel Available</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="has_girls_hostel" value="1" id="cbGirls">
                    <label class="form-check-label small" for="cbGirls">Girls Hostel Available</label>
                </div>

                <button type="submit" class="btn btn-warning w-100 py-2 fw-bold shadow-sm">
                    💾 Save & Publish College
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    document.getElementById('addCourseRowBtn').addEventListener('click', function() {
        const container = document.getElementById('coursesContainer');
        const firstRow = container.querySelector('.course-row');
        const clone = firstRow.cloneNode(true);
        clone.querySelectorAll('input').forEach(i => i.value = '');
        clone.querySelector('select').value = '';
        container.appendChild(clone);
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-course-btn')) {
            const rows = document.querySelectorAll('.course-row');
            if (rows.length > 1) {
                e.target.closest('.course-row').remove();
            }
        }
    });
</script>
@endpush

@endsection