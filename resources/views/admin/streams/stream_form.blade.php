@php
$isEdit = isset($stream) && $stream !== null;
@endphp

<style>
    /* =========================================================
   STREAM CREATE
   Scoped to .stream-create-page so it never conflicts with
   the edit design.
   ========================================================= */
    .stream-create-page {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-gold-dark: #B78300;
        --gp-border: #E3E8EF;
        --gp-text: #172033;
        --gp-muted: #667085;
    }

    .stream-create-page .create-wrap {
        width: min(100%, 700px);
        margin: 4px auto 0;
    }

    .stream-create-page .create-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        box-shadow: 0 8px 26px rgba(15, 35, 65, .06);
    }

    .stream-create-page .create-header {
        position: relative;
        overflow: hidden;
        padding: 21px 23px;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 62%, var(--gp-blue));
        color: #fff;
    }

    .stream-create-page .create-header::before {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        right: -65px;
        top: -95px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .07);
    }

    .stream-create-page .create-header::after {
        content: "";
        position: absolute;
        width: 80px;
        height: 80px;
        right: 70px;
        bottom: -48px;
        border-radius: 50%;
        background: rgba(217, 164, 0, .10);
    }

    .stream-create-page .header-inner {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .stream-create-page .header-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .10);
        font-size: 1.15rem;
    }

    .stream-create-page .create-header h3 {
        margin: 0 0 4px;
        font-size: 1.13rem;
        font-weight: 800;
    }

    .stream-create-page .create-header p {
        margin: 0;
        max-width: 520px;
        color: rgba(255, 255, 255, .72);
        font-size: .78rem;
        line-height: 1.45;
    }

    .stream-create-page .form-body {
        padding: 24px;
    }

    .stream-create-page .field-group {
        margin-bottom: 18px;
    }

    .stream-create-page .field-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 8px;
        color: var(--gp-text);
        font-size: .76rem;
        font-weight: 800;
    }

    .stream-create-page .required {
        color: #D92D20;
    }

    .stream-create-page .required-label {
        color: var(--gp-muted);
        font-size: .66rem;
        font-weight: 600;
    }

    .stream-create-page .input-box {
        position: relative;
    }

    .stream-create-page .input-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        z-index: 2;
        transform: translateY(-50%);
        color: var(--gp-blue);
        pointer-events: none;
        font-size: .9rem;
    }

    .stream-create-page .stream-input {
        width: 100%;
        min-height: 46px;
        padding: 10px 13px 10px 39px;
        border: 1px solid #D5DCE6;
        border-radius: 11px;
        outline: none;
        color: var(--gp-text);
        background: #fff;
        font-size: .82rem;
        box-shadow: none;
        transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
    }

    .stream-create-page .stream-input:hover {
        border-color: #B9C5D3;
    }

    .stream-create-page .stream-input:focus {
        border-color: var(--gp-blue);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .09);
    }

    .stream-create-page .stream-input.is-invalid {
        border-color: #D92D20;
        box-shadow: 0 0 0 3px rgba(217, 45, 32, .07);
    }

    .stream-create-page .stream-input::placeholder {
        color: #A0A8B5;
    }

    .stream-create-page .error-text {
        display: block;
        margin-top: 6px;
        color: #B42318;
        font-size: .69rem;
        line-height: 1.4;
    }

    .stream-create-page .info-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 13px;
        margin-top: 3px;
        border: 1px solid #D9E8F7;
        border-radius: 11px;
        background: #F5F9FE;
        color: #53657A;
        font-size: .7rem;
        line-height: 1.5;
    }

    .stream-create-page .info-icon {
        width: 27px;
        height: 27px;
        flex: 0 0 27px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #E7F0FA;
        color: var(--gp-blue);
    }

    .stream-create-page .actions {
        display: flex;
        align-items: center;
        gap: 9px;
        padding-top: 20px;
        margin-top: 20px;
        border-top: 1px solid var(--gp-border);
    }

    .stream-create-page .action-btn {
        min-height: 43px;
        border-radius: 10px;
        padding: 0 17px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: .77rem;
        font-weight: 800;
        line-height: 1;
        text-decoration: none;
        transition: all .18s ease;
    }

    .stream-create-page .save-btn {
        border: 1px solid var(--gp-gold);
        background: var(--gp-gold);
        color: #1A1A1A;
        box-shadow: 0 5px 14px rgba(217, 164, 0, .17);
    }

    .stream-create-page .save-btn:hover,
    .stream-create-page .save-btn:focus {
        border-color: var(--gp-gold-dark);
        background: var(--gp-gold-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .stream-create-page .cancel-btn {
        border: 1px solid #D4DAE2;
        background: #fff;
        color: #475467;
    }

    .stream-create-page .cancel-btn:hover,
    .stream-create-page .cancel-btn:focus {
        border-color: #B8C2CF;
        background: #F8FAFC;
        color: var(--gp-navy);
    }

    .stream-create-page .save-btn:active,
    .stream-create-page .cancel-btn:active {
        transform: translateY(0);
    }


    .stream-create-page .icon-section {
        margin-top: 18px;
        padding: 15px;
        border: 1px solid var(--gp-border);
        border-radius: 12px;
        background: #FBFCFE;
    }

    .stream-create-page .icon-section-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
        color: var(--gp-text);
        font-size: .75rem;
        font-weight: 800;
    }

    .stream-create-page .icon-section-title span:last-child {
        color: var(--gp-muted);
        font-size: .65rem;
        font-weight: 600;
    }

    .stream-create-page .icon-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 7px;
    }

    .stream-create-page .icon-option {
        min-height: 58px;
        padding: 6px 4px;
        border: 1px solid #E0E6ED;
        border-radius: 9px;
        background: #fff;
        color: #526176;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        transition: .16s ease;
    }

    .stream-create-page .icon-option i {
        font-size: 1.05rem;
        color: var(--gp-blue);
    }

    .stream-create-page .icon-option small {
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: center;
        font-size: .56rem;
    }

    .stream-create-page .icon-option:hover,
    .stream-create-page .icon-option.active {
        border-color: var(--gp-blue);
        background: #F1F6FC;
        color: var(--gp-navy);
    }

    .stream-create-page .icon-option.active {
        box-shadow: 0 0 0 2px rgba(23, 75, 143, .08);
    }

    @media (max-width: 767.98px) {
        .stream-create-page .icon-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .stream-create-page .create-wrap {
            margin-top: 0;
        }

        .stream-create-page .create-card {
            border-radius: 15px;
        }

        .stream-create-page .create-header {
            padding: 18px;
        }

        .stream-create-page .form-body {
            padding: 18px;
        }

        .stream-create-page .header-icon {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
            border-radius: 11px;
        }

        .stream-create-page .create-header h3 {
            font-size: 1.02rem;
        }

        .stream-create-page .create-header p {
            font-size: .71rem;
        }

        .stream-create-page .stream-input {
            min-height: 44px;
        }

        .stream-create-page .actions {
            flex-direction: column;
        }

        .stream-create-page .action-btn {
            width: 100%;
        }
    }

    /* =========================================================
   STREAM EDIT
   Scoped to .stream-edit-page so it never conflicts with
   the create design.
   ========================================================= */
    .stream-edit-page {
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

    .stream-edit-page .edit-wrap {
        max-width: 720px;
        margin: 8px auto 0;
    }

    .stream-edit-page .edit-hero {
        position: relative;
        overflow: hidden;
        padding: 22px 24px;
        border-radius: 18px 18px 0 0;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 62%, var(--gp-blue));
        color: #fff;
        box-shadow: 0 10px 25px rgba(0, 43, 103, .12);
    }

    .stream-edit-page .edit-hero::after {
        content: "";
        position: absolute;
        width: 175px;
        height: 175px;
        right: -58px;
        top: -88px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .07);
    }

    .stream-edit-page .edit-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .stream-edit-page .edit-hero-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        border-radius: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .12);
        font-size: 1.15rem;
    }

    .stream-edit-page .edit-hero h3 {
        margin: 0 0 4px;
        font-size: 1.15rem;
        font-weight: 800;
    }

    .stream-edit-page .edit-hero p {
        margin: 0;
        color: rgba(255, 255, 255, .73);
        font-size: .79rem;
    }

    .stream-edit-page .edit-card {
        background: #fff;
        border: 1px solid var(--gp-border);
        border-top: 0;
        border-radius: 0 0 18px 18px;
        padding: 24px;
        box-shadow: 0 8px 25px rgba(15, 35, 65, .06);
    }

    .stream-edit-page .details-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 16px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--gp-border);
    }

    .stream-edit-page .details-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--gp-text);
        font-size: .87rem;
        font-weight: 800;
    }

    .stream-edit-page .details-title-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #EAF1FA;
        color: var(--gp-blue);
    }

    .stream-edit-page .courses-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #EDF4FC;
        border: 1px solid #D9E7F7;
        color: var(--gp-blue);
        font-size: .67rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .stream-edit-page .error-box {
        border: 1px solid #F2C5C2;
        background: #FEF3F2;
        color: #B42318;
        border-radius: 11px;
        padding: 11px 13px;
        margin-bottom: 18px;
        font-size: .72rem;
    }

    .stream-edit-page .error-box ul {
        margin: 0;
        padding-left: 18px;
    }

    .stream-edit-page .field-group {
        margin-bottom: 17px;
    }

    .stream-edit-page .field-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 7px;
        color: var(--gp-text);
        font-size: .75rem;
        font-weight: 800;
    }

    .stream-edit-page .required-mark {
        color: #D92D20;
    }

    .stream-edit-page .optional-text {
        color: var(--gp-muted);
        font-size: .66rem;
        font-weight: 500;
    }

    .stream-edit-page .input-shell {
        position: relative;
    }

    .stream-edit-page .input-shell>i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gp-blue);
        pointer-events: none;
        z-index: 2;
    }

    .stream-edit-page .edit-input {
        min-height: 44px;
        border: 1px solid #D8DEE8;
        border-radius: 10px;
        padding: 9px 12px 9px 38px;
        color: var(--gp-text);
        font-size: .8rem;
        box-shadow: none;
    }

    .stream-edit-page .edit-input:focus {
        border-color: var(--gp-blue);
        box-shadow: 0 0 0 3px rgba(23, 75, 143, .09);
    }

    .stream-edit-page .edit-input.is-invalid {
        padding-right: 38px;
    }

    .stream-edit-page .slug-box {
        position: relative;
    }

    .stream-edit-page .slug-box i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #98A2B3;
        z-index: 2;
    }

    .stream-edit-page .slug-input {
        min-height: 41px;
        padding-left: 38px;
        background: #F8FAFC !important;
        color: #667085 !important;
        border-color: #E2E7ED;
        border-radius: 10px;
        font-size: .76rem;
    }

    .stream-edit-page .field-help {
        display: block;
        margin-top: 6px;
        color: var(--gp-muted);
        font-size: .67rem;
    }

    .stream-edit-page .icon-preview {
        min-width: 43px;
        border: 1px solid #D8DEE8;
        border-right: 0;
        border-radius: 10px 0 0 10px;
        background: #F8FAFC;
        color: var(--gp-blue);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stream-edit-page .icon-input {
        min-height: 41px;
        border-radius: 0 10px 10px 0;
        border-color: #D8DEE8;
        font-size: .76rem;
        box-shadow: none;
    }

    .stream-edit-page .icon-input:focus {
        border-color: var(--gp-blue);
        box-shadow: none;
    }

    .stream-edit-page .form-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        padding-top: 19px;
        margin-top: 20px;
        border-top: 1px solid var(--gp-border);
    }

    .stream-edit-page .update-btn,
    .stream-edit-page .cancel-btn {
        min-height: 42px;
        border-radius: 10px;
        padding: 0 17px;
        font-size: .77rem;
        font-weight: 800;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        transition: all .18s ease;
    }

    .stream-edit-page .update-btn {
        border: 1px solid var(--gp-gold);
        background: var(--gp-gold);
        color: #1B1B1B;
        box-shadow: 0 5px 13px rgba(217, 164, 0, .17);
    }

    .stream-edit-page .update-btn:hover {
        background: #C89400;
        border-color: #C89400;
        color: #111;
        transform: translateY(-1px);
        box-shadow: 0 7px 16px rgba(217, 164, 0, .22);
    }

    .stream-edit-page .cancel-btn {
        border: 1px solid #D8DEE8;
        background: #fff;
        color: #526176;
    }

    .stream-edit-page .cancel-btn:hover {
        background: #F8FAFC;
        border-color: #B8C2D0;
        color: var(--gp-navy);
        transform: translateY(-1px);
    }

    .stream-edit-page .update-btn:active,
    .stream-edit-page .cancel-btn:active {
        transform: translateY(0);
    }


    .stream-edit-page .icon-section {
        margin-top: 6px;
        padding: 15px;
        border: 1px solid var(--gp-border);
        border-radius: 12px;
        background: #FBFCFE;
    }

    .stream-edit-page .icon-section-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
        color: var(--gp-text);
        font-size: .75rem;
        font-weight: 800;
    }

    .stream-edit-page .icon-section-title span:last-child {
        color: var(--gp-muted);
        font-size: .65rem;
        font-weight: 600;
    }

    .stream-edit-page .selected-icon {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 10px;
    }

    .stream-edit-page .selected-icon-preview {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #EAF1FA;
        color: var(--gp-blue);
        font-size: 1.05rem;
    }

    .stream-edit-page .selected-icon-text {
        color: var(--gp-muted);
        font-size: .67rem;
    }

    .stream-edit-page .selected-icon-text strong {
        display: block;
        color: var(--gp-text);
        font-size: .73rem;
        margin-bottom: 2px;
    }

    .stream-edit-page .icon-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 7px;
    }

    .stream-edit-page .icon-option {
        min-height: 58px;
        padding: 6px 4px;
        border: 1px solid #E0E6ED;
        border-radius: 9px;
        background: #fff;
        color: #526176;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        transition: .16s ease;
    }

    .stream-edit-page .icon-option i {
        font-size: 1.05rem;
        color: var(--gp-blue);
    }

    .stream-edit-page .icon-option small {
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: center;
        font-size: .56rem;
    }

    .stream-edit-page .icon-option:hover,
    .stream-edit-page .icon-option.active {
        border-color: var(--gp-blue);
        background: #F1F6FC;
        color: var(--gp-navy);
    }

    .stream-edit-page .icon-option.active {
        box-shadow: 0 0 0 2px rgba(23, 75, 143, .08);
    }

    @media (max-width: 767.98px) {
        .stream-edit-page .icon-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .stream-edit-page .edit-wrap {
            margin-top: 0;
        }

        .stream-edit-page .edit-hero {
            padding: 18px;
            border-radius: 15px 15px 0 0;
        }

        .stream-edit-page .edit-card {
            padding: 18px;
            border-radius: 0 0 15px 15px;
        }

        .stream-edit-page .edit-hero-icon {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
        }

        .stream-edit-page .edit-hero h3 {
            font-size: 1.02rem;
        }

        .stream-edit-page .edit-hero p {
            font-size: .72rem;
        }

        .stream-edit-page .details-strip {
            align-items: flex-start;
            flex-direction: column;
        }

        .stream-edit-page .courses-badge {
            align-self: flex-start;
        }

        .stream-edit-page .form-actions {
            flex-direction: column;
        }

        .stream-edit-page .update-btn,
        .stream-edit-page .cancel-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    }

    /* =========================================================
   Shared responsive safety
   ========================================================= */
    .stream-create-page,
    .stream-edit-page {
        width: 100%;
        box-sizing: border-box;
    }

    .stream-create-page *,
    .stream-edit-page * {
        box-sizing: border-box;
    }

    @media (max-width: 767.98px) {

        .stream-create-page .create-wrap,
        .stream-edit-page .edit-wrap {
            width: 100%;
            max-width: 100%;
        }

        .stream-create-page .create-card,
        .stream-edit-page .edit-card {
            width: 100%;
        }
    }
</style>

@if(!$isEdit)
<div class="stream-create-page">
    <div class="create-wrap">
        <div class="create-card">
            <div class="create-header">
                <div class="header-inner">
                    <div class="header-icon">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <div>
                        <h3>Create Academic Stream</h3>
                        <p>Add a new academic category to organize courses across GrowPec.</p>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <form action="{{ route('admin.streams.store') }}" method="POST">
                    @csrf

                    <div class="field-group">
                        <label for="streamName" class="field-label">
                            <span>
                                Stream Name <span class="required">*</span>
                            </span>
                            <span class="required-label">Required</span>
                        </label>

                        <div class="input-box">
                            <i class="bi bi-mortarboard-fill input-icon"></i>

                            <input type="text"
                                id="streamName"
                                name="name"
                                value="{{ old('name') }}"
                                class="stream-input @error('name') is-invalid @enderror"
                                placeholder="e.g. Engineering & Technology, Management, Pharmacy"
                                autocomplete="off"
                                required>
                        </div>

                        @error('name')
                        <span class="error-text">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="icon-section">
                        <div class="icon-section-title">
                            <span><i class="bi bi-stars me-1"></i>Choose Stream Icon</span>
                            <span>Optional</span>
                        </div>

                        <div class="icon-grid" id="streamIconGrid"></div>
                        <input type="hidden" name="icon" id="streamIcon" value="{{ old('icon') }}">
                    </div>

                    <div class="info-box">
                        <span class="info-icon">
                            <i class="bi bi-info-lg"></i>
                        </span>
                        <span>
                            Choose a clear category name such as Engineering, Management,
                            Commerce, Science or Pharmacy. The stream will be used to group related courses.
                        </span>
                    </div>

                    <div class="actions">
                        <button type="submit" class="action-btn save-btn">
                            <i class="bi bi-check2-circle"></i>
                            Save Stream
                        </button>

                        <a href="{{ route('admin.streams.index') }}"
                            class="action-btn cancel-btn">
                            <i class="bi bi-arrow-left"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="stream-edit-page">
    <div class="edit-wrap">
        <div class="edit-hero">
            <div class="edit-hero-content">
                <div class="edit-hero-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div>
                    <h3>Edit Academic Stream</h3>
                    <p>Update the stream details used across your GrowPec academic catalog.</p>
                </div>
            </div>
        </div>

        <div class="edit-card">
            <div class="details-strip">
                <div class="details-title">
                    <span class="details-title-icon">
                        <i class="bi bi-diagram-3-fill"></i>
                    </span>
                    Edit Stream Details
                </div>

                <span class="courses-badge">
                    <i class="bi bi-book-half"></i>
                    {{ $stream->courses()->count() }} Associated Courses
                </span>
            </div>

            @if ($errors->any())
            <div class="error-box">
                <div class="fw-bold mb-1">
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

            <form action="{{ route('admin.streams.update', $stream->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="field-group">
                    <label for="streamName" class="field-label">
                        <span>
                            Stream Name <span class="required-mark">*</span>
                        </span>
                        <span class="optional-text">Required</span>
                    </label>

                    <div class="input-shell">
                        <i class="bi bi-mortarboard-fill"></i>

                        <input type="text"
                            id="streamName"
                            name="name"
                            value="{{ old('name', $stream->name) }}"
                            class="form-control edit-input @error('name') is-invalid @enderror"
                            placeholder="e.g. Management, Engineering, Pharmacy"
                            required>

                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">
                        <span>Stream Slug</span>
                        <span class="optional-text">Auto-generated</span>
                    </label>

                    <div class="slug-box">
                        <i class="bi bi-link-45deg"></i>
                        <input type="text"
                            value="{{ $stream->slug }}"
                            class="form-control slug-input"
                            disabled>
                    </div>

                    <small class="field-help">
                        <i class="bi bi-info-circle me-1"></i>
                        The slug is automatically generated from the stream name.
                    </small>
                </div>

                <div class="field-group mb-0">
                    <label for="streamIcon" class="field-label">
                        <span>Stream Icon</span>
                        <span class="optional-text">Optional</span>
                    </label>

                    <div class="icon-section">
                        <div class="selected-icon">
                            <span class="selected-icon-preview">
                                <i id="streamIconPreview"></i>
                            </span>
                            <span class="selected-icon-text">
                                <strong id="selectedIconName">Default icon</strong>
                                Choose an icon below for this stream.
                            </span>
                        </div>

                        <div class="icon-grid" id="streamIconGrid"></div>

                        <input type="hidden"
                            id="streamIcon"
                            name="icon"
                            value="{{ old('icon', $stream->icon) }}">
                    </div>

                    <small class="field-help">
                        <i class="bi bi-info-circle me-1"></i>
                        Select an icon instead of entering a Bootstrap class manually.
                    </small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn update-btn">
                        <i class="bi bi-check2-circle me-1"></i>
                        Update Stream
                    </button>

                    <a href="{{ route('admin.streams.index') }}"
                        class="action-btn cancel-btn">
                        <i class="bi bi-arrow-left"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const grid = document.getElementById('streamIconGrid');
        const input = document.getElementById('streamIcon');

        if (!grid || !input) return;

        const icons = [
            ['bi-laptop', 'Engineering / IT'],
            ['bi-gear-wide-connected', 'Engineering'],
            ['bi-cpu', 'Technology'],
            ['bi-code-slash', 'Computer Science'],
            ['bi-briefcase-fill', 'Management'],
            ['bi-bar-chart-fill', 'Commerce'],
            ['bi-calculator-fill', 'Finance'],
            ['bi-bank', 'Banking'],
            ['bi-capsule', 'Pharmacy'],
            ['bi-heart-pulse-fill', 'Medical'],
            ['bi-hospital-fill', 'Healthcare'],
            ['bi-flask-fill', 'Science'],
            ['bi-atom', 'Physics / Science'],
            ['bi-beaker-fill', 'Chemistry'],
            ['bi-book-half', 'Arts / Humanities'],
            ['bi-journal-bookmark-fill', 'Education'],
            ['bi-mortarboard-fill', 'Education'],
            ['bi-people-fill', 'Social Science'],
            ['bi-globe2', 'International'],
            ['bi-palette-fill', 'Design / Arts'],
            ['bi-camera-fill', 'Media'],
            ['bi-megaphone-fill', 'Mass Communication'],
            ['bi-shield-fill-check', 'Law / Security'],
            ['bi-building', 'Architecture'],
            ['bi-tree-fill', 'Agriculture'],
            ['bi-lightbulb-fill', 'General'],
            ['bi-diagram-3-fill', 'General']
        ];

        icons.forEach(([icon, label]) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'icon-option';
            button.dataset.icon = icon;
            button.title = label;
            button.innerHTML =
                '<i class="bi ' + icon + '"></i><small>' + label + '</small>';

            button.addEventListener('click', function() {
                input.value = icon;

                grid.querySelectorAll('.icon-option').forEach(function(el) {
                    el.classList.remove('active');
                });

                button.classList.add('active');

                const preview = document.getElementById('streamIconPreview');
                const selectedName = document.getElementById('selectedIconName');

                if (preview) {
                    preview.className = 'bi ' + icon;
                }

                if (selectedName) {
                    selectedName.textContent = label;
                }
            });

            grid.appendChild(button);
        });

        const current = input.value.trim();

        if (current) {
            const active = grid.querySelector('[data-icon="' + current + '"]');

            if (active) {
                active.classList.add('active');

                const preview = document.getElementById('streamIconPreview');
                const selectedName = document.getElementById('selectedIconName');

                if (preview) {
                    preview.className = 'bi ' + current;
                }

                if (selectedName) {
                    const selected = icons.find(function(item) {
                        return item[0] === current;
                    });

                    selectedName.textContent = selected ? selected[1] : 'Custom icon';
                }
            }
        }
    });
</script>
@endpush