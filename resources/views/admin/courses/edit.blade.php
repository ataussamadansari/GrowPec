@extends('admin.layout')
@section('title', 'Edit Course - GrowPec Admin')
@section('header', 'Edit Course: ' . $course->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label small fw-bold">Select Stream *</label>
                    <select name="stream_id" class="form-select" required>
                        @foreach($streams as $st)
                            <option value="{{ $st->id }}" {{ $course->stream_id == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Course Name *</label>
                    <input type="text" name="name" value="{{ $course->name }}" class="form-control" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Education Level *</label>
                        <select name="level" class="form-select" required>
                            @foreach(['UG' => 'Undergraduate (UG)', 'PG' => 'Postgraduate (PG)', 'Diploma' => 'Diploma', 'PhD' => 'Ph.D.', 'Certificate' => 'Certificate'] as $k => $v)
                                <option value="{{ $k }}" {{ $course->level == $k ? 'selected' : '' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Degree Type *</label>
                        <select name="degree_type" class="form-select" required>
                            @foreach(['Degree', 'Diploma', 'Certificate'] as $dt)
                                <option value="{{ $dt }}" {{ $course->degree_type == $dt ? 'selected' : '' }}>{{ $dt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Course Duration *</label>
                    <input type="text" name="duration" value="{{ $course->duration }}" class="form-control" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">💾 Update Course</button>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection