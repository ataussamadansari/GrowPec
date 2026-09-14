@extends('admin.layout')
@section('title', 'Add Specialization - GrowPec Admin')
@section('header', 'Add New Specialization')

@section('content')

<style>
    :root {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-gold-dark: #B78300;
        --gp-border: #E2E8F0;
        --gp-text: #172033;
        --gp-muted: #68758A;
        --gp-bg: #F5F7FB;
    }

    .sp-create-page {
        max-width: 900px;
        margin: 0 auto;
    }

    .sp-create-hero {
        position: relative;
        overflow: hidden;
        margin-bottom: 18px;
        padding: 23px 25px;
        border-radius: 18px;
        color: #fff;
        background:
            radial-gradient(circle at 92% 15%, rgba(217,164,0,.18), transparent 28%),
            linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 55%, var(--gp-blue));
        box-shadow: 0 12px 30px rgba(0,43,103,.16);
    }

    .sp-create-hero::after {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        right: -65px;
        bottom: -100px;
        border: 1px solid rgba(255,255,255,.13);
        border-radius: 50%;
        box-shadow: 0 0 0 30px rgba(255,255,255,.035);
    }

    .sp-create-hero-content {
        position: relative;
        z-index: 1;
    }

    .sp-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.14);
        font-size: .66rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .sp-create-hero h2 {
        margin: 11px 0 5px;
        font-size: 1.4rem;
        font-weight: 800;
        letter-spacing: -.02em;
    }

    .sp-create-hero p {
        margin: 0;
        max-width: 650px;
        color: rgba(255,255,255,.76);
        font-size: .8rem;
    }

    .sp-form-card {
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 16px;
        box-shadow: 0 8px 26px rgba(20,35,60,.07);
        overflow: hidden;
    }

    .sp-form-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 17px 20px;
        border-bottom: 1px solid var(--gp-border);
        background: #FCFDFE;
    }

    .sp-form-header-icon {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        color: var(--gp-blue);
        background: #EAF2FB;
        border: 1px solid #D7E5F4;
        font-size: 1rem;
    }

    .sp-form-header h3 {
        margin: 0;
        color: var(--gp-text);
        font-size: .92rem;
        font-weight: 800;
    }

    .sp-form-header p {
        margin: 2px 0 0;
        color: var(--gp-muted);
        font-size: .68rem;
    }

    .sp-form-body {
        padding: 22px 20px 20px;
    }

    .sp-field {
        margin-bottom: 20px;
    }

    .sp-label {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 7px;
        color: var(--gp-text);
        font-size: .72rem;
        font-weight: 800;
    }

    .sp-label-icon {
        color: var(--gp-green);
        font-size: .82rem;
    }

    .sp-required {
        color: #C0392B;
        font-weight: 900;
    }

    .sp-field-help {
        margin-top: 6px;
        color: var(--gp-muted);
        font-size: .65rem;
        line-height: 1.45;
    }

    .sp-control {
        min-height: 45px;
        border: 1px solid #D8E0EA;
        border-radius: 10px;
        color: var(--gp-text);
        background: #fff;
        font-size: .77rem;
        font-weight: 600;
        box-shadow: none !important;
    }

    .sp-control:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23,75,143,.09) !important;
    }

    .sp-select-wrap,
    .sp-input-wrap {
        position: relative;
    }

    .sp-control-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #7B899D;
        pointer-events: none;
        z-index: 2;
    }

    .sp-control.with-icon {
        padding-left: 39px;
    }

    .sp-select {
        padding-left: 39px;
        padding-right: 35px;
        cursor: pointer;
    }

    .sp-name-input {
        padding-left: 39px;
    }

    .sp-select option {
        font-weight: 600;
    }

    .sp-error {
        margin-top: 6px;
        color: #C0392B;
        font-size: .66rem;
        font-weight: 650;
    }

    .sp-course-preview {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 9px;
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid #E1EAF5;
        background: #F7FAFE;
    }

    .sp-course-preview-icon {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        color: var(--gp-blue);
        background: #EAF2FB;
        font-size: .82rem;
    }

    .sp-course-preview-label {
        color: var(--gp-muted);
        font-size: .62rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .sp-course-preview-value {
        color: var(--gp-text);
        font-size: .72rem;
        font-weight: 800;
    }

    .sp-tip {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-top: 4px;
        padding: 12px 13px;
        border-radius: 11px;
        border: 1px solid #DCEFE5;
        background: #F3FBF7;
        color: #476454;
        font-size: .68rem;
        line-height: 1.5;
    }

    .sp-tip i {
        color: var(--gp-green);
        margin-top: 1px;
    }

    .sp-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding-top: 5px;
        margin-top: 5px;
        border-top: 1px solid #EDF1F5;
    }

    .sp-action-btn {
        min-height: 43px;
        padding: 0 18px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        font-size: .74rem;
        font-weight: 800;
        line-height: 1;
        white-space: nowrap;
        text-align: center;
        transition: all .18s ease;
    }

    .sp-save-btn {
        color: #152033;
        background: var(--gp-gold);
        border: 1px solid var(--gp-gold);
    }

    .sp-save-btn:hover {
        color: #fff;
        background: var(--gp-gold-dark);
        border-color: var(--gp-gold-dark);
        transform: translateY(-1px);
    }

    .sp-cancel-btn {
        color: #526176;
        background: #fff;
        border: 1px solid #D8E0EA;
    }

    .sp-cancel-btn:hover {
        color: var(--gp-navy);
        background: #F7F9FC;
        border-color: #BCC8D7;
        transform: translateY(-1px);
    }

    @media (max-width: 767.98px) {
        .sp-create-hero {
            padding: 19px 17px;
            border-radius: 15px;
        }

        .sp-create-hero h2 {
            font-size: 1.18rem;
        }

        .sp-create-hero p {
            font-size: .73rem;
        }

        .sp-form-header {
            padding: 14px 15px;
        }

        .sp-form-body {
            padding: 18px 15px 16px;
        }

        .sp-actions {
            flex-direction: column;
        }

        .sp-action-btn {
            width: 100%;
        }
    }
</style>

<div class="sp-create-page">

    <div class="sp-create-hero">
        <div class="sp-create-hero-content">
            <span class="sp-eyebrow">
                <i class="bi bi-plus-circle-fill"></i>
                Academic Management
            </span>

            <h2>Add New Specialization</h2>
            <p>
                Create a specialization and associate it with the correct course
                to keep the GrowPec academic catalogue organized.
            </p>
        </div>
    </div>

    <div class="sp-form-card">

        <div class="sp-form-header">
            <div class="sp-form-header-icon">
                <i class="bi bi-diagram-3-fill"></i>
            </div>

            <div>
                <h3>Specialization Details</h3>
                <p>Enter the course and specialization information below.</p>
            </div>
        </div>

        <div class="sp-form-body">

            <form action="{{ route('admin.specializations.store') }}" method="POST">
                @csrf

                <div class="sp-field">
                    <label for="course_id" class="sp-label">
                        <i class="bi bi-book-half sp-label-icon"></i>
                        Select Course
                        <span class="sp-required">*</span>
                    </label>

                    <div class="sp-select-wrap">
                        <i class="bi bi-journal-bookmark-fill sp-control-icon"></i>

                        <select
                            name="course_id"
                            id="course_id"
                            class="form-select sp-control sp-select"
                            required
                        >
                            <option value="">-- Choose Course --</option>

                            @foreach($courses as $c)
                                <option
                                    value="{{ $c->id }}"
                                    data-level="{{ $c->level }}"
                                    data-stream="{{ $c->stream->name ?? '' }}"
                                    {{ old('course_id') == $c->id ? 'selected' : '' }}
                                >
                                    {{ $c->name }}{{ $c->level ? ' (' . $c->level . ')' : '' }}{{ $c->stream ? ' - ' . $c->stream->name : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="coursePreview" class="sp-course-preview" style="display:none;">
                        <div class="sp-course-preview-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div>
                            <div class="sp-course-preview-label">Selected Course</div>
                            <div id="coursePreviewValue" class="sp-course-preview-value"></div>
                        </div>
                    </div>

                    @error('course_id')
                        <div class="sp-error">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="sp-field">
                    <label for="name" class="sp-label">
                        <i class="bi bi-pencil-square sp-label-icon"></i>
                        Specialization Name
                        <span class="sp-required">*</span>
                    </label>

                    <div class="sp-input-wrap">
                        <i class="bi bi-tag-fill sp-control-icon"></i>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            class="form-control sp-control sp-name-input"
                            placeholder="e.g. Artificial Intelligence, Cloud Computing, Finance, Marketing"
                            required
                            maxlength="255"
                            autocomplete="off"
                        >
                    </div>

                    <div class="sp-field-help">
                        Use a clear and specific specialization name, such as Artificial Intelligence or Finance.
                    </div>

                    @error('name')
                        <div class="sp-error">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="sp-tip">
                    <i class="bi bi-lightbulb-fill"></i>
                    <div>
                        <strong>Tip:</strong>
                        Choose the correct course before saving. The specialization will be
                        linked to that course in the academic catalogue.
                    </div>
                </div>

                <div class="sp-actions">
                    <button type="submit" class="btn sp-action-btn sp-save-btn">
                        <i class="bi bi-check-circle-fill"></i>
                        Save Specialization
                    </button>

                    <a
                        href="{{ route('admin.specializations.index') }}"
                        class="btn sp-action-btn sp-cancel-btn"
                    >
                        <i class="bi bi-x-circle"></i>
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const courseSelect = document.getElementById('course_id');
        const preview = document.getElementById('coursePreview');
        const previewValue = document.getElementById('coursePreviewValue');

        function updateCoursePreview() {
            if (!courseSelect || !preview || !previewValue) return;

            const option = courseSelect.options[courseSelect.selectedIndex];

            if (!courseSelect.value || !option) {
                preview.style.display = 'none';
                previewValue.textContent = '';
                return;
            }

            previewValue.textContent = option.textContent.trim();
            preview.style.display = 'flex';
        }

        courseSelect?.addEventListener('change', updateCoursePreview);
        updateCoursePreview();
    });
</script>
@endpush

@endsection
