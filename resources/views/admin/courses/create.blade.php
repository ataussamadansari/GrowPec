@extends('admin.layout')
@section('title', 'Add New Course - GrowPec Admin')
@section('header', 'Add New Course')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold">Select Stream *</label>
                    <select name="stream_id" class="form-select" required>
                        <option value="">-- Choose Stream --</option>
                        @foreach($streams as $st)
                            <option value="{{ $st->id }}">{{ $st->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Course Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. BCA, MBA, B.Pharm, ANM, B.Tech" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Education Level *</label>
                        <select name="level" class="form-select" required>
                            <option value="UG">Undergraduate (UG)</option>
                            <option value="PG">Postgraduate (PG)</option>
                            <option value="Diploma">Diploma</option>
                            <option value="PhD">Ph.D. / Doctorate</option>
                            <option value="Certificate">Certificate</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Degree Type *</label>
                        <select name="degree_type" class="form-select" required>
                            <option value="Degree">Degree</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Certificate">Certificate</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Course Duration *</label>
                    <input type="text" name="duration" class="form-control" placeholder="e.g. 3 Years, 2 Years, 1 Year" value="3 Years" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">💾 Save Course</button>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection