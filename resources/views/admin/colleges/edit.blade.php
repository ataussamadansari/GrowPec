@extends('admin.layout')
@section('title', 'Edit College - GrowPec Admin')
@section('header', 'Edit College: ' . $college->name)

@section('content')
<form action="{{ route('admin.colleges.update', $college->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary">1. Basic College Information</h5>
                <div class="mb-3">
                    <label class="form-label small fw-bold">College Name *</label>
                    <input type="text" name="name" value="{{ $college->name }}" class="form-control" required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">College Mode *</label>
                        <select name="college_mode" class="form-select" required>
                            <option value="regular" {{ $college->college_mode == 'regular' ? 'selected' : '' }}>Regular Campus</option>
                            <option value="online" {{ $college->college_mode == 'online' ? 'selected' : '' }}>100% Online</option>
                            <option value="both" {{ $college->college_mode == 'both' ? 'selected' : '' }}>Both</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Ownership / Type *</label>
                        <select name="college_type" class="form-select" required>
                            <option value="Private" {{ $college->college_type == 'Private' ? 'selected' : '' }}>Private</option>
                            <option value="Govt" {{ $college->college_type == 'Govt' ? 'selected' : '' }}>Government</option>
                            <option value="Deemed" {{ $college->college_type == 'Deemed' ? 'selected' : '' }}>Deemed</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Affiliated University</label>
                    <input type="text" name="university_name" value="{{ $college->university_name }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Banner Image URL</label>
                    <input type="url" name="banner_image" value="{{ $college->banner_image }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Overview</label>
                    <textarea name="overview" rows="4" class="form-control">{{ $college->overview }}</textarea>
                </div>
            </div>

            <!-- Dynamic Courses -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-primary">2. Courses, Fees & Eligibility</h5>
                    <button type="button" class="btn btn-sm btn-outline-success fw-bold" id="addCourseRowBtn">
                        <i class="bi bi-plus-circle me-1"></i> + Add Another Course
                    </button>
                </div>

                <div id="coursesContainer">
                    @forelse($college->collegeCourses as $cc)
                        <div class="row g-2 align-items-end mb-3 course-row border-bottom pb-2">
                            <div class="col-md-4">
                                <select name="course_ids[]" class="form-select form-select-sm">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->id }}" {{ $cc->course_id == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->level }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="fee_amounts[]" value="{{ (int)$cc->fee_amount }}" class="form-control form-control-sm" placeholder="Fee">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="eligibilities[]" value="{{ $cc->eligibility }}" class="form-control form-control-sm" placeholder="Eligibility">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-danger remove-course-btn"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    @empty
                        <div class="row g-2 align-items-end mb-3 course-row border-bottom pb-2">
                            <div class="col-md-4">
                                <select name="course_ids[]" class="form-select form-select-sm">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="fee_amounts[]" class="form-control form-control-sm" placeholder="Fee">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="eligibilities[]" class="form-control form-control-sm" placeholder="Eligibility">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-danger remove-course-btn"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <h5 class="fw-bold mb-3 text-primary">3. Location & Snapshot</h5>
                <div class="mb-2">
                    <label class="form-label small fw-bold">State *</label>
                    <input type="text" name="state" value="{{ $college->state }}" class="form-control form-control-sm" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">City *</label>
                    <input type="text" name="city" value="{{ $college->city }}" class="form-control form-control-sm" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Established Year</label>
                    <input type="text" name="established_year" value="{{ $college->established_year }}" class="form-control form-control-sm">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Approvals</label>
                    <input type="text" name="approvals" value="{{ $college->approvals }}" class="form-control form-control-sm">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Highest Package</label>
                    <input type="text" name="highest_package" value="{{ $college->highest_package }}" class="form-control form-control-sm">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="has_boys_hostel" value="1" id="cbBoys" {{ $college->has_boys_hostel ? 'checked' : '' }}>
                    <label class="form-check-label small" for="cbBoys">Boys Hostel Available</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="has_girls_hostel" value="1" id="cbGirls" {{ $college->has_girls_hostel ? 'checked' : '' }}>
                    <label class="form-check-label small" for="cbGirls">Girls Hostel Available</label>
                </div>

                <button type="submit" class="btn btn-warning w-100 py-2 fw-bold shadow-sm">
                    💾 Update College Details
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