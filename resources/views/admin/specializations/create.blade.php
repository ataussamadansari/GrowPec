@extends('admin.layout')
@section('title', 'Add Specialization - GrowPec Admin')
@section('header', 'Add New Specialization')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <form action="{{ route('admin.specializations.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">Select Course *</label>
                    <select name="course_id" class="form-select" required>
                        <option value="">-- Choose Course --</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->level }}) - {{ $c->stream->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Specialization Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Artificial Intelligence, Cloud Computing, Finance, Marketing" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">Save Specialization</button>
                    <a href="{{ route('admin.specializations.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection