@extends('admin.layout')
@section('title', 'Add New Course - GrowPec Admin')
@section('header', 'Add New Course')

@section('content')

<style>
    .course-create-page {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-border: #E5EAF0;
        --gp-text: #172033;
        --gp-muted: #718096;
    }

    .course-create-wrap {
        max-width: 760px;
        margin: 8px auto 0;
    }

    .create-hero {
        position: relative;
        overflow: hidden;
        padding: 22px 24px;
        border-radius: 18px 18px 0 0;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 62%, var(--gp-blue));
        color: #fff;
        box-shadow: 0 10px 25px rgba(0,43,103,.12);
    }

    .create-hero::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -65px;
        top: -95px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .hero-icon {
        width: 47px;
        height: 47px;
        flex: 0 0 47px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.12);
        font-size: 1.15rem;
    }

    .hero-content h3 {
        margin: 0 0 4px;
        font-size: 1.16rem;
        font-weight: 800;
    }

    .hero-content p {
        margin: 0;
        color: rgba(255,255,255,.72);
        font-size: .76rem;
    }

    .create-card {
        background: #fff;
        border: 1px solid var(--gp-border);
        border-top: 0;
        border-radius: 0 0 18px 18px;
        padding: 24px;
        box-shadow: 0 8px 25px rgba(15,35,65,.06);
    }

    .form-heading {
        display: flex;
        align-items: center;
        gap: 9px;
        padding-bottom: 15px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--gp-border);
        color: var(--gp-text);
        font-size: .87rem;
        font-weight: 800;
    }

    .form-heading-icon {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #EAF1FA;
        color: var(--gp-blue);
    }

    .field-group {
        margin-bottom: 17px;
    }

    .field-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 7px;
        color: var(--gp-text);
        font-size: .75rem;
        font-weight: 800;
    }

    .required {
        color: #D92D20;
    }

    .field-note {
        color: var(--gp-muted);
        font-size: .64rem;
        font-weight: 500;
    }

    .input-shell {
        position: relative;
    }

    .input-shell > i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        color: var(--gp-blue);
        pointer-events: none;
    }

    .course-input,
    .course-select {
        min-height: 44px;
        border: 1px solid #D8DEE8;
        border-radius: 10px;
        color: var(--gp-text);
        font-size: .78rem;
        box-shadow: none;
    }

    .course-input {
        padding: 9px 12px 9px 38px;
    }

    .course-select {
        padding-left: 38px;
        cursor: pointer;
    }

    .course-input:focus,
    .course-select:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23,75,143,.09);
    }

    .select-shell {
        position: relative;
    }

    .select-shell > i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        color: var(--gp-blue);
        pointer-events: none;
    }

    .select-shell::after {
        content: "";
        position: absolute;
        right: 13px;
        top: 50%;
        width: 7px;
        height: 7px;
        border-right: 1.5px solid #667085;
        border-bottom: 1.5px solid #667085;
        transform: translateY(-65%) rotate(45deg);
        pointer-events: none;
    }

    .select-shell .course-select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 36px;
    }

    .field-help {
        display: block;
        margin-top: 6px;
        color: var(--gp-muted);
        font-size: .65rem;
    }

    .field-help i {
        color: var(--gp-blue);
    }

    .form-section {
        padding: 16px;
        margin: 3px 0 18px;
        border: 1px solid var(--gp-border);
        border-radius: 12px;
        background: #FBFCFE;
    }

    .section-label {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 13px;
        color: var(--gp-navy);
        font-size: .72rem;
        font-weight: 800;
    }

    .section-label i {
        color: var(--gp-blue);
    }

    .duration-input {
        font-weight: 600;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        padding-top: 19px;
        margin-top: 20px;
        border-top: 1px solid var(--gp-border);
    }

    .action-btn {
        min-height: 42px;
        border-radius: 10px;
        padding: 0 17px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        font-size: .77rem;
        font-weight: 800;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        transition: all .18s ease;
    }

    .save-btn {
        border: 1px solid var(--gp-gold);
        background: var(--gp-gold);
        color: #1B1B1B;
        box-shadow: 0 5px 13px rgba(217,164,0,.17);
    }

    .save-btn:hover {
        background: #C89400;
        border-color: #C89400;
        color: #111;
        transform: translateY(-1px);
        box-shadow: 0 7px 16px rgba(217,164,0,.22);
    }

    .cancel-btn {
        border: 1px solid #D8DEE8;
        background: #fff;
        color: #526176;
    }

    .cancel-btn:hover {
        background: #F8FAFC;
        border-color: #B8C2D0;
        color: var(--gp-navy);
        transform: translateY(-1px);
    }

    .action-btn:active {
        transform: translateY(0);
    }

    .error-box {
        margin-bottom: 18px;
        padding: 11px 13px;
        border: 1px solid #F2C5C2;
        border-radius: 11px;
        background: #FEF3F2;
        color: #B42318;
        font-size: .72rem;
    }

    .error-box ul {
        margin: 5px 0 0;
        padding-left: 18px;
    }

    @media (max-width: 767.98px) {
        .course-create-wrap {
            margin-top: 0;
        }

        .create-hero {
            padding: 18px;
            border-radius: 15px 15px 0 0;
        }

        .create-card {
            padding: 18px;
            border-radius: 0 0 15px 15px;
        }

        .hero-icon {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
            border-radius: 11px;
        }

        .hero-content h3 {
            font-size: 1.02rem;
        }

        .hero-content p {
            font-size: .69rem;
        }

        .form-section {
            padding: 13px;
        }

        .form-actions {
            flex-direction: column;
        }

        .action-btn {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
    }
</style>

<div class="course-create-page">
    <div class="course-create-wrap">

        {{-- Header --}}
        <div class="create-hero">
            <div class="hero-content">
                <span class="hero-icon">
                    <i class="bi bi-journal-plus"></i>
                </span>

                <div>
                    <h3>Add New Course</h3>
                    <p>Create a new academic program for the GrowPec course catalog.</p>
                </div>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="create-card">

            <div class="form-heading">
                <span class="form-heading-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </span>
                Course Details
            </div>

            @if ($errors->any())
                <div class="error-box">
                    <div class="fw-bold">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        Please fix the following:
                    </div>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf

                {{-- Basic Course Information --}}
                <div class="form-section">
                    <div class="section-label">
                        <i class="bi bi-info-circle-fill"></i>
                        Basic Course Information
                    </div>

                    <div class="field-group">
                        <label for="streamId" class="field-label">
                            <span>Stream <span class="required">*</span></span>
                            <span class="field-note">Required</span>
                        </label>

                        <div class="select-shell">
                            <i class="bi bi-diagram-3-fill"></i>

                            <select id="streamId" name="stream_id" class="form-select course-select" required>
                                <option value="">Choose a stream</option>

                                @foreach($streams as $st)
                                    <option
                                        value="{{ $st->id }}"
                                        {{ old('stream_id') == $st->id ? 'selected' : '' }}
                                    >
                                        {{ $st->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="field-group mb-0">
                        <label for="courseName" class="field-label">
                            <span>Course Name <span class="required">*</span></span>
                            <span class="field-note">Required</span>
                        </label>

                        <div class="input-shell">
                            <i class="bi bi-book-half"></i>

                            <input
                                type="text"
                                id="courseName"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control course-input @error('name') is-invalid @enderror"
                                placeholder="e.g. BCA, MBA, B.Pharm, ANM, B.Tech"
                                required
                            >
                        </div>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Academic Details --}}
                <div class="form-section">
                    <div class="section-label">
                        <i class="bi bi-award-fill"></i>
                        Academic Details
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="field-group mb-0">
                                <label for="courseLevel" class="field-label">
                                    <span>Education Level <span class="required">*</span></span>
                                </label>

                                <div class="select-shell">
                                    <i class="bi bi-bar-chart-steps"></i>

                                    <select id="courseLevel" name="level" class="form-select course-select" required>
                                        <option value="UG" {{ old('level', 'UG') == 'UG' ? 'selected' : '' }}>
                                            Undergraduate (UG)
                                        </option>
                                        <option value="PG" {{ old('level') == 'PG' ? 'selected' : '' }}>
                                            Postgraduate (PG)
                                        </option>
                                        <option value="Diploma" {{ old('level') == 'Diploma' ? 'selected' : '' }}>
                                            Diploma
                                        </option>
                                        <option value="PhD" {{ old('level') == 'PhD' ? 'selected' : '' }}>
                                            Ph.D. / Doctorate
                                        </option>
                                        <option value="Certificate" {{ old('level') == 'Certificate' ? 'selected' : '' }}>
                                            Certificate
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="field-group mb-0">
                                <label for="degreeType" class="field-label">
                                    <span>Degree Type <span class="required">*</span></span>
                                </label>

                                <div class="select-shell">
                                    <i class="bi bi-patch-check-fill"></i>

                                    <select id="degreeType" name="degree_type" class="form-select course-select" required>
                                        <option value="Degree" {{ old('degree_type', 'Degree') == 'Degree' ? 'selected' : '' }}>
                                            Degree
                                        </option>
                                        <option value="Diploma" {{ old('degree_type') == 'Diploma' ? 'selected' : '' }}>
                                            Diploma
                                        </option>
                                        <option value="Certificate" {{ old('degree_type') == 'Certificate' ? 'selected' : '' }}>
                                            Certificate
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Duration --}}
                <div class="field-group">
                    <label for="courseDuration" class="field-label">
                        <span>Course Duration <span class="required">*</span></span>
                        <span class="field-note">Example: 3 Years</span>
                    </label>

                    <div class="input-shell">
                        <i class="bi bi-clock-history"></i>

                        <input
                            type="text"
                            id="courseDuration"
                            name="duration"
                            value="{{ old('duration', '3 Years') }}"
                            class="form-control course-input duration-input @error('duration') is-invalid @enderror"
                            placeholder="e.g. 3 Years, 2 Years, 1 Year"
                            required
                        >
                    </div>

                    @error('duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small class="field-help">
                        <i class="bi bi-info-circle me-1"></i>
                        Enter the standard duration of this course.
                    </small>
                </div>

                {{-- Actions --}}
                <div class="form-actions">
                    <button type="submit" class="btn action-btn save-btn">
                        <i class="bi bi-check2-circle"></i>
                        Save Course
                    </button>

                    <a
                        href="{{ route('admin.courses.index') }}"
                        class="btn action-btn cancel-btn"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
