@php
$isEdit = isset($specialization) && $specialization !== null;
$specializationId = $isEdit ? $specialization->id : null;
$specializationName = $isEdit ? ($specialization->name ?? '') : '';
$specializationCourseId = $isEdit ? ($specialization->course_id ?? '') : '';
$specializationSlug = $isEdit ? ($specialization->slug ?? '') : '';
$specializationStatus = $isEdit ? ($specialization->status ?? 1) : 1;
@endphp

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
    }

    .sp-edit-page {
        max-width: 900px;
        margin: 0 auto;
    }

    .sp-hero {
        position: relative;
        overflow: hidden;
        margin-bottom: 18px;
        padding: 23px 25px;
        border-radius: 18px;
        color: #fff;
        background:
            radial-gradient(circle at 92% 15%, rgba(217, 164, 0, .18), transparent 28%),
            linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 55%, var(--gp-blue));
        box-shadow: 0 12px 30px rgba(0, 43, 103, .16);
    }

    .sp-hero::after {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        right: -65px;
        bottom: -100px;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        box-shadow: 0 0 0 30px rgba(255, 255, 255, .035);
    }

    .sp-hero-content {
        position: relative;
        z-index: 1;
    }

    .sp-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .14);
        font-size: .66rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .sp-hero h2 {
        margin: 11px 0 7px;
        font-size: 1.4rem;
        font-weight: 800;
        letter-spacing: -.02em;
    }

    .sp-hero p {
        margin: 0;
        color: rgba(255, 255, 255, .76);
        font-size: .8rem;
    }

    .sp-name-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 13px;
        padding: 7px 11px;
        max-width: 100%;
        border-radius: 9px;
        color: #fff;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .15);
        font-size: .7rem;
        font-weight: 750;
    }

    .sp-form-card {
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 16px;
        box-shadow: 0 8px 26px rgba(20, 35, 60, .07);
        overflow: hidden;
    }

    .sp-form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 20px;
        border-bottom: 1px solid var(--gp-border);
        background: #FCFDFE;
    }

    .sp-form-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
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
        font-size: .67rem;
    }

    .sp-id-badge {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 8px;
        color: var(--gp-blue);
        background: #F0F5FB;
        border: 1px solid #DCE7F3;
        font-size: .66rem;
        font-weight: 800;
    }

    .sp-form-body {
        padding: 22px 20px 20px;
    }

    .sp-alert {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 19px;
        padding: 11px 12px;
        border: 1px solid #F1CBC7;
        border-radius: 10px;
        background: #FFF7F6;
        color: #9F3025;
        font-size: .69rem;
    }

    .sp-alert i {
        margin-top: 1px;
        font-size: .85rem;
    }

    .sp-alert ul {
        margin: 0;
        padding-left: 15px;
    }

    .sp-field {
        margin-bottom: 19px;
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

    .sp-control-wrap {
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
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .09) !important;
    }

    .sp-select {
        padding-left: 39px;
        padding-right: 35px;
        cursor: pointer;
    }

    .sp-name-input {
        padding-left: 39px;
    }

    .sp-slug-input {
        padding-left: 39px;
        color: #718096 !important;
        background: #F6F8FA !important;
        cursor: not-allowed;
    }

    .sp-help {
        margin-top: 6px;
        color: var(--gp-muted);
        font-size: .64rem;
        line-height: 1.45;
    }

    .sp-invalid {
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

    .sp-preview-label {
        color: var(--gp-muted);
        font-size: .61rem;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .sp-preview-value {
        color: var(--gp-text);
        font-size: .71rem;
        font-weight: 800;
    }

    .sp-status-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 13px;
        margin-bottom: 20px;
        border: 1px solid #DDE6F0;
        border-radius: 11px;
        background: #F8FAFC;
    }

    .sp-status-info {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .sp-status-icon {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        color: var(--gp-green);
        background: #EAF8F0;
        border: 1px solid #D0EBDD;
    }

    .sp-status-title {
        color: var(--gp-text);
        font-size: .72rem;
        font-weight: 800;
        line-height: 1.3;
    }

    .sp-status-desc {
        margin-top: 2px;
        color: var(--gp-muted);
        font-size: .63rem;
        line-height: 1.4;
    }

    .sp-switch {
        flex: 0 0 auto;
        margin: 0;
    }

    .sp-switch .form-check-input {
        width: 2.35rem;
        height: 1.25rem;
        margin: 0;
        cursor: pointer;
        box-shadow: none !important;
        border-color: #BFC9D7;
    }

    .sp-switch .form-check-input:checked {
        background-color: var(--gp-green);
        border-color: var(--gp-green);
    }

    .sp-tip {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        padding: 12px 13px;
        border-radius: 11px;
        border: 1px solid #DCEFE5;
        background: #F3FBF7;
        color: #476454;
        font-size: .67rem;
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
        padding-top: 17px;
        margin-top: 17px;
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

    .sp-update-btn {
        color: #152033;
        background: var(--gp-gold);
        border: 1px solid var(--gp-gold);
    }

    .sp-update-btn:hover {
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
        .sp-hero {
            padding: 19px 17px;
            border-radius: 15px;
        }

        .sp-hero h2 {
            font-size: 1.18rem;
        }

        .sp-hero p {
            font-size: .73rem;
        }

        .sp-form-header {
            padding: 14px 15px;
            align-items: flex-start;
        }

        .sp-form-body {
            padding: 18px 15px 16px;
        }

        .sp-id-badge {
            padding: 5px 7px;
            font-size: .61rem;
        }

        .sp-status-box {
            align-items: flex-start;
        }

        .sp-actions {
            flex-direction: column;
        }

        .sp-action-btn {
            width: 100%;
        }
    }

    /* Create-mode styles */
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
            radial-gradient(circle at 92% 15%, rgba(217, 164, 0, .18), transparent 28%),
            linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 55%, var(--gp-blue));
        box-shadow: 0 12px 30px rgba(0, 43, 103, .16);
    }

    .sp-create-hero::after {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        right: -65px;
        bottom: -100px;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        box-shadow: 0 0 0 30px rgba(255, 255, 255, .035);
    }

    .sp-create-hero-content {
        position: relative;
        z-index: 1;
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
        color: rgba(255, 255, 255, .76);
        font-size: .8rem;
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

    .sp-field-help {
        margin-top: 6px;
        color: var(--gp-muted);
        font-size: .65rem;
        line-height: 1.45;
    }

    .sp-error {
        margin-top: 6px;
        color: #C0392B;
        font-size: .66rem;
        font-weight: 650;
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
    }
</style>

<div class="{{ $isEdit ? 'sp-edit-page' : 'sp-create-page' }}">

    <div class="{{ $isEdit ? 'sp-hero' : 'sp-create-hero' }}">
        <div class="{{ $isEdit ? 'sp-hero-content' : 'sp-create-hero-content' }}">
            <span class="sp-eyebrow">
                <i class="bi {{ $isEdit ? 'bi-pencil-square' : 'bi-plus-circle-fill' }}"></i>
                Academic Management
            </span>

            <h2>{{ $isEdit ? 'Edit Specialization' : 'Add New Specialization' }}</h2>

            <p>
                {{ $isEdit
                    ? 'Update the specialization details, associated course, and visibility status from one place.'
                    : 'Create a specialization and associate it with the correct course to keep the GrowPec academic catalogue organized.'
                }}
            </p>

            @if($isEdit)
            <span class="sp-name-pill">
                <i class="bi bi-diagram-3-fill"></i>
                {{ $specializationName }}
            </span>
            @endif
        </div>
    </div>

    <div class="sp-form-card">

        <div class="sp-form-header">
            <div class="{{ $isEdit ? 'sp-form-heading' : '' }}">
                <div class="sp-form-header-icon">
                    <i class="bi {{ $isEdit ? 'bi-pencil-fill' : 'bi-diagram-3-fill' }}"></i>
                </div>

                <div>
                    <h3>Specialization Details</h3>
                    <p>
                        {{ $isEdit
                            ? 'Modify the information below and save your changes.'
                            : 'Enter the course and specialization information below.'
                        }}
                    </p>
                </div>
            </div>

            @if($isEdit)
            <span class="sp-id-badge">
                <i class="bi bi-hash"></i>
                ID: {{ $specializationId }}
            </span>
            @endif
        </div>

        <div class="sp-form-body">

            @if ($errors->any())
            <div class="sp-alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    <strong>Please check the following:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form
                action="{{ $isEdit ? route('admin.specializations.update', $specializationId) : route('admin.specializations.store') }}"
                method="POST"
                data-is-edit="{{ $isEdit ? '1' : '0' }}">
                @csrf

                @if($isEdit)
                @method('PUT')
                @endif

                <div class="sp-field">
                    <label for="course_id" class="sp-label">
                        <i class="bi bi-book-half sp-label-icon"></i>
                        Select Course
                        <span class="sp-required">*</span>
                    </label>

                    <div class="sp-control-wrap">
                        <i class="bi bi-journal-bookmark-fill sp-control-icon"></i>

                        <select
                            name="course_id"
                            id="course_id"
                            class="form-select sp-control sp-select @error('course_id') is-invalid @enderror"
                            required>
                            <option value="">-- Choose Course --</option>

                            @foreach($courses as $c)
                            <option
                                value="{{ $c->id }}"
                                data-level="{{ $c->level ?? '' }}"
                                data-stream="{{ $c->stream->name ?? 'General' }}"
                                {{ old('course_id', $specializationCourseId) == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}{{ $c->level ? ' (' . $c->level . ')' : '' }} - {{ $c->stream->name ?? 'General' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="coursePreview" class="sp-course-preview" style="display:none;">
                        <div class="sp-course-preview-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div>
                            <div class="{{ $isEdit ? 'sp-preview-label' : 'sp-course-preview-label' }}">
                                Selected Course
                            </div>
                            <div id="coursePreviewValue" class="{{ $isEdit ? 'sp-preview-value' : 'sp-course-preview-value' }}"></div>
                        </div>
                    </div>

                    @error('course_id')
                    <div class="{{ $isEdit ? 'sp-invalid' : 'sp-error' }}">
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

                    <div class="sp-control-wrap">
                        <i class="bi bi-tag-fill sp-control-icon"></i>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $specializationName) }}"
                            class="form-control sp-control sp-name-input @error('name') is-invalid @enderror"
                            placeholder="e.g. Artificial Intelligence, Cloud Computing, Finance, Marketing"
                            required
                            maxlength="255"
                            autocomplete="off">
                    </div>

                    <div class="{{ $isEdit ? 'sp-help' : 'sp-field-help' }}">
                        {{ $isEdit
                            ? 'Use a clear and specific specialization name that students can easily understand.'
                            : 'Use a clear and specific specialization name, such as Artificial Intelligence or Finance.'
                        }}
                    </div>

                    @error('name')
                    <div class="{{ $isEdit ? 'sp-invalid' : 'sp-error' }}">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                @if($isEdit)
                <div class="sp-field">
                    <label for="slug" class="sp-label">
                        <i class="bi bi-link-45deg sp-label-icon"></i>
                        Specialization Slug
                    </label>

                    <div class="sp-control-wrap">
                        <i class="bi bi-code-slash sp-control-icon"></i>

                        <input
                            type="text"
                            id="slug"
                            value="{{ $specializationSlug }}"
                            class="form-control sp-control sp-slug-input"
                            disabled>
                    </div>

                    <div class="sp-help">
                        The current slug is shown for reference and is not editable from this form.
                    </div>
                </div>

                <div class="sp-status-box">
                    <div class="sp-status-info">
                        <div class="sp-status-icon">
                            <i class="bi bi-eye-fill"></i>
                        </div>

                        <div>
                            <div class="sp-status-title">Active Specialization</div>
                            <div class="sp-status-desc">
                                Keep this enabled to make the specialization visible in college selection and filters.
                            </div>
                        </div>
                    </div>

                    <div class="form-check form-switch sp-switch">
                        <input type="hidden" name="status" value="0">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="status"
                            value="1"
                            id="specStatus"
                            {{ old('status', $specializationStatus) ? 'checked' : '' }}>
                    </div>
                </div>
                @endif

                <div class="sp-tip">
                    <i class="bi bi-lightbulb-fill"></i>
                    <div>
                        <strong>Tip:</strong>
                        {{ $isEdit
                            ? 'Verify the associated course before updating. Changing the course changes where this specialization appears in the academic catalogue.'
                            : 'Choose the correct course before saving. The specialization will be linked to that course in the academic catalogue.'
                        }}
                    </div>
                </div>

                <div class="sp-actions">
                    <button type="submit" class="btn sp-action-btn {{ $isEdit ? 'sp-update-btn' : 'sp-save-btn' }}">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ $isEdit ? 'Update Specialization' : 'Save Specialization' }}
                    </button>

                    <a
                        href="{{ route('admin.specializations.index') }}"
                        class="btn sp-action-btn sp-cancel-btn">
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
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[data-is-edit]');
        const courseSelect = document.getElementById('course_id');
        const preview = document.getElementById('coursePreview');
        const previewValue = document.getElementById('coursePreviewValue');

        if (!courseSelect || !preview || !previewValue) {
            return;
        }

        function updateCoursePreview() {
            const option = courseSelect.options[courseSelect.selectedIndex];

            if (!courseSelect.value || !option) {
                preview.style.display = 'none';
                previewValue.textContent = '';
                return;
            }

            previewValue.textContent = option.textContent.trim();
            preview.style.display = 'flex';
        }

        courseSelect.addEventListener('change', updateCoursePreview);
        updateCoursePreview();
    });
</script>
@endpush