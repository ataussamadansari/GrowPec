@extends('admin.layout')
@section('title', 'Edit Stream: ' . $stream->name . ' - GrowPec Admin')
@section('header', 'Edit Stream: ' . $stream->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-pencil-square me-1"></i> Edit Stream Details</h5>
                <span class="badge bg-primary-subtle text-primary border">{{ $stream->courses()->count() }} Associated Courses</span>
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

            <form action="{{ route('admin.streams.update', $stream->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label small fw-bold">Stream Name *</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $stream->name) }}" 
                           class="form-control @error('name') is-invalid @enderror" 
                           placeholder="e.g. Management, Engineering, Pharmacy" 
                           required>
                    @error('name')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Stream Slug (Auto-updated)</label>
                    <input type="text" value="{{ $stream->slug }}" class="form-control form-control-sm bg-light text-muted" disabled>
                    <small class="text-muted">Slug is automatically generated from the stream name.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Bootstrap Icon Class (Optional)</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light"><i class="bi {{ $stream->icon ?? 'bi-diagram-3' }}"></i></span>
                        <input type="text" 
                               name="icon" 
                               value="{{ old('icon', $stream->icon) }}" 
                               class="form-control" 
                               placeholder="e.g. bi-laptop, bi-gear, bi-briefcase">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-check-circle me-1"></i> Update Stream
                    </button>
                    <a href="{{ route('admin.streams.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection