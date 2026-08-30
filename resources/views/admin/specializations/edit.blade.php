@extends('admin.layout')
@section('title', 'Edit Specialization: ' . $specialization->name . ' - GrowPec Admin')
@section('header', 'Edit Specialization')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-pencil-square me-1"></i> Edit Specialization Details</h5>
                <span class="badge bg-light text-secondary border">ID: #{{ $specialization->id }}</span>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.specializations.update', $specialization->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Associated Course -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Select Course *</label>
                    <select name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                        <option value="">-- Choose Course --</option>
                        @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ old('course_id', $specialization->course_id) == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} ({{ $c->level }}) - {{ $c->stream->name ?? 'General' }}
                        </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Specialization Name -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Specialization Name *</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $specialization->name) }}" 
                           class="form-control @error('name') is-invalid @enderror" 
                           placeholder="e.g. Artificial Intelligence & ML, Marketing, Finance" 
                           required>
                    @error('name')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Slug Preview -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Specialization Slug</label>
                    <input type="text" value="{{ $specialization->slug }}" class="form-control form-control-sm bg-light text-muted" disabled>
                </div>

                <!-- Active Status -->
                <div class="form-check mb-4">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="status" 
                           value="1" 
                           id="specStatus" 
                           {{ old('status', $specialization->status) ? 'checked' : '' }}>
                    <label class="form-check-label small fw-semibold" for="specStatus">
                        Active Specialization (Visible in college selection & filters)
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-check-circle me-1"></i> Update Specialization
                    </button>
                    <a href="{{ route('admin.specializations.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection