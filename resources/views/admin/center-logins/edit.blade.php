@extends('admin.layout')

@section('title', 'Edit Center Login - GrowPec Admin')
@section('header', 'Edit Center Login')

@section('content')

<style>
    .gp-form-card {
        max-width: 680px;
        margin: 0 auto;
        border: 1px solid #E1E8F0;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(15, 35, 65, .05);
        overflow: hidden;
    }

    .gp-card-header {
        padding: 20px 24px;
        background: #F8FAFC;
        border-bottom: 1px solid #E1E8F0;
    }

    .gp-card-body {
        padding: 24px;
    }

    .form-label {
        font-weight: 750;
        color: #172033;
        font-size: .82rem;
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border-color: #D8DEE8;
        padding: 10px 14px;
        font-size: .85rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #174B8F;
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .12);
    }

    .help-hint {
        font-size: .74rem;
        color: #718096;
        margin-top: 5px;
    }
</style>

<div class="container-fluid px-0">

    <div class="d-flex align-items-center justify-content-between mb-3" style="max-width: 680px; margin: 0 auto;">
        <a href="{{ route('admin.center-logins.index') }}" class="btn btn-light border btn-sm rounded-3 px-3 fw-bold text-muted">
            <i class="bi bi-arrow-left me-1"></i> Back to Center Logins
        </a>

        <form action="{{ route('admin.center-logins.destroy', $centerLogin) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Center Login?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm rounded-3 px-3 fw-bold">
                <i class="bi bi-trash-fill me-1"></i> Delete
            </button>
        </form>
    </div>

    <div class="gp-form-card">
        <div class="gp-card-header d-flex align-items-center gap-2">
            <span class="d-inline-flex align-items-center justify-content-center bg-warning text-dark rounded-3 p-2" style="width: 34px; height: 34px;">
                <i class="bi bi-pencil-fill"></i>
            </span>
            <div>
                <h5 class="fw-bold mb-0 text-dark">Edit Center Login: {{ $centerLogin->title }}</h5>
                <small class="text-muted">Update portal login access link and visibility</small>
            </div>
        </div>

        <div class="gp-card-body">

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3 mb-3">
                    <ul class="mb-0 small ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.center-logins.update', $centerLogin) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">
                        Portal Title <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $centerLogin->title) }}"
                           placeholder="e.g. Center Login, Partner Portal"
                           required>
                    <div class="help-hint">This text will be displayed on the website buttons and links.</div>
                </div>

                <!-- URL -->
                <div class="mb-3">
                    <label for="url" class="form-label">
                        Destination URL <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-link-45deg"></i>
                        </span>
                        <input type="url"
                               name="url"
                               id="url"
                               class="form-control border-start-0 @error('url') is-invalid @enderror"
                               value="{{ old('url', $centerLogin->url) }}"
                               placeholder="https://example.com/center/login"
                               required>
                    </div>
                    <div class="help-hint">Full web address (starting with https:// or http://) where clicking the login button will take the user.</div>
                </div>

                <!-- Index & Status -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="index" class="form-label">
                            Display Order (Index)
                        </label>
                        <input type="number"
                               name="index"
                               id="index"
                               min="0"
                               class="form-control @error('index') is-invalid @enderror"
                               value="{{ old('index', $centerLogin->index) }}">
                        <div class="help-hint">Lower numbers appear first (e.g. 0, 1, 2).</div>
                    </div>

                    <div class="col-md-6 d-flex align-items-center pt-md-3">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_active"
                                   value="1"
                                   id="is_active"
                                   {{ old('is_active', $centerLogin->is_active) ? 'checked' : '' }}
                                   role="switch">
                            <label class="form-check-label fw-bold text-dark ms-1" for="is_active">
                                Active on Website
                            </label>
                            <div class="help-hint">When inactive, this login will be hidden from header and footer.</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                    <a href="{{ route('admin.center-logins.index') }}" class="btn btn-light border rounded-3 px-4 fw-bold">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Update Center Login
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
