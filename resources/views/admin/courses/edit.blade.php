@extends('admin.layout')
@section('title', 'Edit Course - GrowPec Admin')
@section('header', 'Edit Course: ' . $course->name)

@section('content')

<style>
    .course-edit-page {
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

    .course-edit-wrap {
        max-width: 760px;
        margin: 8px auto 0;
    }

    .edit-hero {
        position: relative;
        overflow: hidden;
        padding: 22px 24px;
        border-radius: 18px 18px 0 0;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 62%, var(--gp-blue));
        color: #fff;
        box-shadow: 0 10px 25px rgba(0,43,103,.12);
    }

    .edit-hero::before {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -65px;
        top: -95px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
    }

    .edit-hero::after {
        content: "";
        position: absolute;
        width: 90px;
        height: 90px;
        right: 130px;
        bottom: -62px;
        border-radius: 50%;
        background: rgba(0,138,67,.14);
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

    .course-name-pill {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        margin-left: 60px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.12);
        color: rgba(255,255,255,.9);
        font-size: .65rem;
        font-weight: 800;
    }

    .edit-card {
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

    .input-shell,
    .select-shell {
        position: relative;
    }

    .input-shell > i,
    .select-shell > i {
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
        padding: 9px 36px 9px 38px;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
    }

    .select-shell::after {
        content: "";
        position: absolute;
        right: 14px;
        top: 50%;
        width: 7px;
        height: 7px;
        border-right: 1.5px solid #667085;
        border-bottom: 1.5px solid #667085;
        transform: translateY(-65%) rotate(45deg);
        pointer-events: none;
    }

    .course-input:focus,
    .course-select:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23,75,143,.09);
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
        margin-bottom: 18px;
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

    .current-value {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 7px;
        padding: 5px 9px;
        border-radius: 999px;
        background: #F1F6FC;
        border: 1px solid #D9E7F7;
        color: var(--gp-blue);
        font-size: .61rem;
        font-weight: 800;
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
        vertical-align: middle;
        white-space: nowrap;
        transition: all .18s ease;
    }

    .update-btn {
        border: 1px solid var(--gp-gold);
        background: var(--gp-gold);
        color: #1B1B1B;
        box-shadow: 0 5px 13px rgba(217,164,0,.17);
    }

    .update-btn:hover {
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

    @media (max-width: 767.98px) {
        .course-edit-wrap {
            margin-top: 0;
        }

        .edit-hero {
            padding: 18px;
            border-radius: 15px 15px 0 0;
        }

        .edit-card {
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

        .course-name-pill {
            margin-left: 55px;
            max-width: calc(100% - 55px);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    }
</style>

<div class="course-edit-page">
    <div class="course-edit-wrap">

        {{-- Header --}}
        <div class="edit-hero">
            <div class="hero-content">
                <span class="hero-icon">
                    <i class="bi bi-pencil-square"></i>
                </span>

                <div>
                    <h3>Edit Course</h3>
                    <p>Update this academic program in the GrowPec course catalog.</p>
                </div>
            </div>

            <span class="course-name-pill">
                <i class="bi bi-book-half"></i>
                {{ $course->name }}
            </span>
        </div>

        {{-- Form Card --}}
        <div class="edit-card">

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

            <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Basic Information --}}
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
                                @foreach($streams as $st)
                                    <option
                                        value="{{ $st->id }}"
                                        {{ old('stream_id', $course->stream_id) == $st->id ? 'selected' : '' }}
                                    >
                                        {{ $st->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <span class="current-value">
                            <i class="bi bi-check-circle-fill"></i>
                            Current stream selected
                        </span>
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
                                value="{{ old('name', $course->name) }}"
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
                                        @foreach([
                                            'UG' => 'Undergraduate (UG)',
                                            'PG' => 'Postgraduate (PG)',
                                            'Diploma' => 'Diploma',
                                            'PhD' => 'Ph.D.',
                                            'Certificate' => 'Certificate'
                                        ] as $k => $v)
                                            <option
                                                value="{{ $k }}"
                                                {{ old('level', $course->level) == $k ? 'selected' : '' }}
                                            >
                                                {{ $v }}
                                            </option>
                                        @endforeach
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
                                        @foreach(['Degree', 'Diploma', 'Certificate'] as $dt)
                                            <option
                                                value="{{ $dt }}"
                                                {{ old('degree_type', $course->degree_type) == $dt ? 'selected' : '' }}
                                            >
                                                {{ $dt }}
                                            </option>
                                        @endforeach
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
                            value="{{ old('duration', $course->duration) }}"
                            class="form-control course-input @error('duration') is-invalid @enderror"
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
                    <button type="submit" class="btn action-btn update-btn">
                        <i class="bi bi-check2-circle"></i>
                        Update Course
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
