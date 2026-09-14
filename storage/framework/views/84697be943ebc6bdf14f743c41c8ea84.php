

<?php $__env->startSection('title', 'Contact Us - GrowPec | Get Admission Guidance'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    :root {
        --gp-navy: #002B67;
        --gp-navy-dark: #001B45;
        --gp-blue: #174B8F;
        --gp-green: #008A43;
        --gp-green-dark: #006B35;
        --gp-gold: #D9A400;
        --gp-gold-dark: #B78300;
        --gp-bg: #F7F9FC;
        --gp-text: #1E293B;
        --gp-muted: #64748B;
        --gp-border: #E2E8F0;
    }

    /* =========================================================
       CONTACT HERO
       ========================================================= */
    .contact-hero {
        position: relative;
        overflow: hidden;
        padding: 64px 0 72px;
        background:
            radial-gradient(circle at 88% 18%, rgba(217,164,0,.15), transparent 24%),
            radial-gradient(circle at 7% 85%, rgba(0,138,67,.10), transparent 27%),
            linear-gradient(135deg, #F3F7FC 0%, #FFFFFF 52%, #F1F8F4 100%);
    }

    .contact-hero::before,
    .contact-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .contact-hero::before {
        width: 360px;
        height: 360px;
        right: -180px;
        top: -180px;
        background: rgba(0,43,103,.05);
    }

    .contact-hero::after {
        width: 220px;
        height: 220px;
        left: -110px;
        bottom: -110px;
        border: 32px solid rgba(217,164,0,.07);
    }

    .contact-hero-content {
        position: relative;
        z-index: 2;
    }

    .contact-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 13px;
        border-radius: 999px;
        background: #EAF1F8;
        border: 1px solid #D5E2EE;
        color: var(--gp-navy);
        font-size: .74rem;
        font-weight: 800;
    }

    .contact-eyebrow i {
        color: var(--gp-gold-dark);
    }

    .contact-hero h1 {
        max-width: 720px;
        margin: 17px 0 14px;
        color: var(--gp-navy-dark);
        font-size: clamp(2rem, 4.4vw, 3.35rem);
        line-height: 1.08;
        font-weight: 850;
        letter-spacing: -.045em;
    }

    .contact-hero h1 span {
        color: var(--gp-green);
    }

    .contact-hero-text {
        max-width: 650px;
        margin: 0;
        color: var(--gp-muted);
        font-size: .98rem;
        line-height: 1.75;
    }

    .contact-quick-points {
        display: flex;
        flex-wrap: wrap;
        gap: 9px 18px;
        margin-top: 21px;
    }

    .contact-quick-point {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #475569;
        font-size: .74rem;
        font-weight: 700;
    }

    .contact-quick-point i {
        color: var(--gp-green);
    }

    .contact-hero-card {
        position: relative;
        z-index: 2;
        padding: 27px;
        border-radius: 27px;
        background: linear-gradient(145deg, var(--gp-navy-dark), var(--gp-blue));
        box-shadow: 0 24px 50px rgba(0,43,103,.20);
        overflow: hidden;
    }

    .contact-hero-card::after {
        content: "";
        position: absolute;
        width: 190px;
        height: 190px;
        right: -75px;
        bottom: -80px;
        border-radius: 50%;
        background: rgba(217,164,0,.16);
    }

    .contact-hero-card-icon {
        width: 58px;
        height: 58px;
        display: grid;
        place-items: center;
        border-radius: 17px;
        background: rgba(217,164,0,.16);
        color: var(--gp-gold);
        font-size: 1.5rem;
        margin-bottom: 19px;
    }

    .contact-hero-card h3 {
        position: relative;
        z-index: 2;
        color: #fff;
        font-size: 1.3rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .contact-hero-card p {
        position: relative;
        z-index: 2;
        color: rgba(255,255,255,.72);
        font-size: .78rem;
        line-height: 1.65;
        margin-bottom: 20px;
    }

    .contact-hero-card-badge {
        position: relative;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: rgba(255,255,255,.9);
        font-size: .72rem;
        font-weight: 700;
    }

    .contact-hero-card-badge i {
        color: #65D49A;
    }

    /* =========================================================
       CONTACT AREA
       ========================================================= */
    .contact-section {
        padding: 68px 0;
    }

    .contact-info-card,
    .contact-form-card {
        height: 100%;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 23px;
        box-shadow: 0 12px 32px rgba(0,43,103,.06);
    }

    .contact-info-card {
        padding: 28px;
    }

    .contact-form-card {
        padding: 31px;
    }

    .contact-card-label {
        color: var(--gp-green-dark);
        font-size: .7rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .12em;
    }

    .contact-info-card h2,
    .contact-form-card h2 {
        color: var(--gp-navy-dark);
        font-size: 1.55rem;
        line-height: 1.2;
        font-weight: 850;
        margin: 7px 0 10px;
    }

    .contact-card-text {
        color: var(--gp-muted);
        font-size: .81rem;
        line-height: 1.7;
        margin-bottom: 24px;
    }

    .contact-info-list {
        display: grid;
        gap: 11px;
    }

    .contact-info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px;
        border: 1px solid #E7EDF2;
        border-radius: 15px;
        background: #FBFCFD;
    }

    .contact-info-icon {
        flex: 0 0 40px;
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: #EEF4F8;
        color: var(--gp-navy);
    }

    .contact-info-item:nth-child(2) .contact-info-icon {
        background: #E8F6EF;
        color: var(--gp-green-dark);
    }

    .contact-info-item:nth-child(3) .contact-info-icon {
        background: #FFF6D9;
        color: var(--gp-gold-dark);
    }

    .contact-info-item h6 {
        color: var(--gp-navy);
        font-size: .78rem;
        font-weight: 800;
        margin: 1px 0 4px;
    }

    .contact-info-item p {
        color: var(--gp-muted);
        font-size: .72rem;
        line-height: 1.5;
        margin: 0;
    }

    .contact-info-item a {
        color: var(--gp-navy);
        font-weight: 700;
        text-decoration: none;
    }

    .contact-info-item a:hover {
        color: var(--gp-green-dark);
    }

    .contact-trust-strip {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-top: 20px;
        padding: 12px 14px;
        border-radius: 14px;
        background: #F1F8F4;
        border: 1px solid #D9EADF;
        color: var(--gp-green-dark);
        font-size: .7rem;
        font-weight: 750;
    }

    /* =========================================================
       FORM
       ========================================================= */
    .contact-form-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 22px;
    }

    .contact-form-head-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 999px;
        background: #FFF6D9;
        color: #775900;
        font-size: .62rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .contact-form-group {
        margin-bottom: 15px;
    }

    .contact-form-label {
        display: block;
        color: #334155;
        font-size: .72rem;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .contact-form-label span {
        color: #D14B4B;
    }

    .contact-input,
    .contact-select,
    .contact-textarea {
        width: 100%;
        border: 1px solid #DCE4EB;
        border-radius: 12px;
        background: #FBFCFD;
        color: #1E293B;
        font-size: .79rem;
        padding: 11px 13px;
        outline: none;
        transition: .2s ease;
    }

    .contact-input,
    .contact-select {
        height: 44px;
    }

    .contact-textarea {
        min-height: 105px;
        resize: vertical;
    }

    .contact-input:focus,
    .contact-select:focus,
    .contact-textarea:focus {
        border-color: #6B9CCB;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(0,43,103,.08);
    }

    .contact-input::placeholder,
    .contact-textarea::placeholder {
        color: #94A3B8;
    }

    .contact-submit {
        width: 100%;
        min-height: 47px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--gp-navy), var(--gp-blue));
        color: #fff;
        font-size: .82rem;
        font-weight: 850;
        box-shadow: 0 9px 20px rgba(0,43,103,.18);
        transition: .22s ease;
    }

    .contact-submit:hover {
        background: linear-gradient(135deg, var(--gp-green-dark), var(--gp-green));
        color: #fff;
        transform: translateY(-2px);
    }

    .contact-form-note {
        margin: 11px 0 0;
        text-align: center;
        color: #94A3B8;
        font-size: .63rem;
        line-height: 1.5;
    }

    /* =========================================================
       HELP CARDS
       ========================================================= */
    .contact-help-section {
        padding: 68px 0;
        background: var(--gp-bg);
    }

    .contact-heading {
        max-width: 690px;
        margin: 0 auto 38px;
        text-align: center;
    }

    .contact-heading .label {
        color: var(--gp-green-dark);
        font-size: .7rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .12em;
    }

    .contact-heading h2 {
        margin: 7px 0 9px;
        color: var(--gp-navy-dark);
        font-size: clamp(1.55rem, 3vw, 2.25rem);
        font-weight: 850;
    }

    .contact-heading p {
        color: var(--gp-muted);
        font-size: .82rem;
        line-height: 1.7;
        margin: 0;
    }

    .contact-help-card {
        height: 100%;
        padding: 23px;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 19px;
        transition: .24s ease;
    }

    .contact-help-card:hover {
        transform: translateY(-4px);
        border-color: #C8D9E8;
        box-shadow: 0 14px 30px rgba(0,43,103,.08);
    }

    .contact-help-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        margin-bottom: 15px;
        border-radius: 14px;
        background: #EEF4F8;
        color: var(--gp-navy);
        font-size: 1.15rem;
    }

    .contact-help-card:nth-child(2) .contact-help-icon {
        background: #E8F6EF;
        color: var(--gp-green-dark);
    }

    .contact-help-card:nth-child(3) .contact-help-icon {
        background: #FFF6D9;
        color: var(--gp-gold-dark);
    }

    .contact-help-card h4 {
        color: var(--gp-navy);
        font-size: .92rem;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .contact-help-card p {
        color: var(--gp-muted);
        font-size: .73rem;
        line-height: 1.65;
        margin: 0;
    }

    /* =========================================================
       FAQ
       ========================================================= */
    .contact-faq {
        padding: 68px 0;
    }

    .contact-faq .accordion-item {
        border: 1px solid var(--gp-border);
        border-radius: 13px !important;
        overflow: hidden;
        margin-bottom: 9px;
    }

    .contact-faq .accordion-button {
        padding: 15px 17px;
        color: var(--gp-navy);
        background: #fff;
        font-size: .79rem;
        font-weight: 800;
        box-shadow: none;
    }

    .contact-faq .accordion-button:not(.collapsed) {
        color: var(--gp-navy);
        background: #F4F8FB;
    }

    .contact-faq .accordion-body {
        color: var(--gp-muted);
        font-size: .73rem;
        line-height: 1.7;
        padding: 0 17px 16px;
    }

    /* =========================================================
       FINAL CTA
       ========================================================= */
    .contact-cta {
        position: relative;
        overflow: hidden;
        padding: 45px 25px;
        border-radius: 25px;
        text-align: center;
        background:
            radial-gradient(circle at 20% 20%, rgba(217,164,0,.13), transparent 23%),
            linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 58%, var(--gp-green-dark));
        box-shadow: 0 18px 40px rgba(0,43,103,.15);
    }

    .contact-cta h2 {
        color: #fff;
        font-size: clamp(1.45rem, 3vw, 2.1rem);
        font-weight: 850;
        margin-bottom: 8px;
    }

    .contact-cta p {
        max-width: 630px;
        margin: 0 auto 19px;
        color: rgba(255,255,255,.72);
        font-size: .79rem;
        line-height: 1.65;
    }

    .contact-cta .btn {
        min-height: 44px;
        padding: 10px 20px;
        border: 0;
        border-radius: 999px;
        background: var(--gp-gold);
        color: #10200F;
        font-size: .78rem;
        font-weight: 850;
    }

    .contact-cta .btn:hover {
        background: #fff;
        color: var(--gp-navy);
    }

    .contact-lead-message {
        margin-top: 16px;
        padding: 13px 15px;
        border-radius: 13px;
        font-size: .78rem;
        font-weight: 750;
        line-height: 1.5;
    }

    .contact-lead-message.success {
        color: #126b3b;
        background: #EAF8F0;
        border: 1px solid #BFE5CF;
    }

    .contact-lead-message.error {
        color: #9b2c2c;
        background: #FFF1F1;
        border: 1px solid #F0CACA;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */
    @media (max-width: 991.98px) {
        .contact-hero {
            padding: 52px 0 62px;
        }

        .contact-section,
        .contact-help-section,
        .contact-faq {
            padding: 55px 0;
        }

        .contact-hero-card {
            max-width: 520px;
        }
    }

    @media (max-width: 767.98px) {
        .contact-hero {
            padding: 40px 0 50px;
        }

        .contact-hero h1 {
            font-size: 2rem;
        }

        .contact-hero-text {
            font-size: .84rem;
            line-height: 1.65;
        }

        .contact-quick-points {
            display: grid;
            gap: 8px;
        }

        .contact-hero-card {
            padding: 23px;
            border-radius: 22px;
        }

        .contact-section,
        .contact-help-section,
        .contact-faq {
            padding: 45px 0;
        }

        .contact-info-card,
        .contact-form-card {
            padding: 23px;
            border-radius: 19px;
        }

        .contact-form-head {
            display: block;
        }

        .contact-form-head-badge {
            margin-top: 10px;
        }

        .contact-cta {
            padding: 38px 18px;
            border-radius: 21px;
        }
    }

    @media (max-width: 380px) {
        .contact-hero h1 {
            font-size: 1.75rem;
        }

        .contact-info-item {
            padding: 12px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="contact-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="contact-hero-content">
                    <span class="contact-eyebrow">
                        <i class="bi bi-chat-dots-fill"></i>
                        Contact GrowPec
                    </span>

                    <h1>
                        Let's Make Your
                        <span>Education Journey Clearer.</span>
                    </h1>

                    <p class="contact-hero-text">
                        Have a question about colleges, courses, fees, admissions or
                        online education? Share your details and our team can help you
                        understand your options and next steps.
                    </p>

                    <div class="contact-quick-points">
                        <span class="contact-quick-point">
                            <i class="bi bi-check-circle-fill"></i>
                            Student-focused guidance
                        </span>
                        <span class="contact-quick-point">
                            <i class="bi bi-check-circle-fill"></i>
                            Admission support
                        </span>
                        <span class="contact-quick-point">
                            <i class="bi bi-check-circle-fill"></i>
                            Regular & online options
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="contact-hero-card">
                    <div class="contact-hero-card-icon">
                        <i class="bi bi-headset"></i>
                    </div>

                    <h3>Need Help Choosing?</h3>

                    <p>
                        Tell us what you are looking for. We can help you explore
                        suitable colleges, programs and admission-related information.
                    </p>

                    <span class="contact-hero-card-badge">
                        <i class="bi bi-shield-check"></i>
                        Simple • Student-first • Helpful
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="contact-section">
    <div class="container">
        <div class="row g-4 align-items-stretch">

            <div class="col-lg-5">
                <div class="contact-info-card">
                    <span class="contact-card-label">Connect With Us</span>

                    <h2>We're Here to Help</h2>

                    <p class="contact-card-text">
                        Whether you are comparing colleges, looking for a course,
                        checking admission information or simply need direction,
                        send us your query and our team will guide you.
                    </p>

                    <div class="contact-info-list">

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <h6>Talk to Our Team</h6>
                                <p>
                                    Get admission-oriented guidance and discuss your
                                    education requirements.
                                </p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h6>Email Support</h6>
                                <p>
                                    For general queries, share your question through
                                    the contact form and our team can follow up.
                                </p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div>
                                <h6>Admission Guidance</h6>
                                <p>
                                    Ask about college selection, programs, fees,
                                    admissions and available options.
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="contact-trust-strip">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Your information is used to respond to your enquiry.</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="contact-form-card">
                    <div class="contact-form-head">
                        <div>
                            <span class="contact-card-label">Send an Enquiry</span>
                            <h2>Tell Us What You Need</h2>
                        </div>

                        <span class="contact-form-head-badge">
                            <i class="bi bi-lightning-charge-fill"></i>
                            Quick Enquiry
                        </span>
                    </div>

                    <form id="contactPageLeadForm"
                          action="<?php echo e(route('lead.submit')); ?>"
                          method="POST">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="source" value="contact_page">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="contact-form-group mb-0">
                                    <label class="contact-form-label">
                                        Your Name <span>*</span>
                                    </label>
                                    <input type="text"
                                           name="name"
                                           class="contact-input"
                                           placeholder="Enter your name"
                                           autocomplete="name"
                                           required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="contact-form-group mb-0">
                                    <label class="contact-form-label">
                                        Phone Number <span>*</span>
                                    </label>
                                    <input type="tel"
                                           name="phone"
                                           class="contact-input"
                                           placeholder="Enter mobile number"
                                           inputmode="tel"
                                           autocomplete="tel"
                                           required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="contact-form-group mb-0">
                                    <label class="contact-form-label">
                                        Email Address
                                    </label>
                                    <input type="email"
                                           name="email"
                                           class="contact-input"
                                           placeholder="you@example.com"
                                           autocomplete="email">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="contact-form-group mb-0">
                                    <label class="contact-form-label">
                                        Your City
                                    </label>
                                    <input type="text"
                                           name="city"
                                           class="contact-input"
                                           placeholder="Enter your city"
                                           autocomplete="address-level2">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="contact-form-group mb-0">
                                    <label class="contact-form-label">
                                        What can we help you with?
                                    </label>
                                    <select name="interest" class="contact-select">
                                        <option value="">Select an option</option>
                                        <option value="College Selection">College Selection</option>
                                        <option value="Course Selection">Course Selection</option>
                                        <option value="Admission Guidance">Admission Guidance</option>
                                        <option value="Fees & Scholarships">Fees & Scholarships</option>
                                        <option value="Online Education">Online Education</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="contact-form-group mb-0">
                                    <label class="contact-form-label">
                                        Your Message
                                    </label>
                                    <textarea name="message"
                                              class="contact-textarea"
                                              placeholder="Tell us briefly what you are looking for..."></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="contact-submit" id="contactPageSubmitBtn">
                                    <i class="bi bi-send-fill"></i>
                                    Send Enquiry
                                    <i class="bi bi-arrow-right"></i>
                                </button>

                                <p class="contact-form-note">
                                    By submitting this form, you agree to be contacted
                                    regarding your enquiry.
                                </p>
                            </div>
                        </div>
                    <div id="contactPageLeadMessage" class="contact-lead-message" role="alert" aria-live="polite" style="display:none;"></div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="contact-help-section">
    <div class="container">
        <div class="contact-heading">
            <div class="label">How We Can Help</div>
            <h2>Not Sure What to Ask? Start Here.</h2>
            <p>
                You can reach out to GrowPec for guidance around different parts
                of your college and education decision-making journey.
            </p>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="contact-help-card">
                    <div class="contact-help-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h4>College Selection</h4>
                    <p>
                        Need help narrowing down colleges based on your preferred
                        location, program or education mode? Tell us your requirements.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="contact-help-card">
                    <div class="contact-help-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <h4>Course & Career Direction</h4>
                    <p>
                        Exploring different degrees or specializations? Share what
                        you are considering and ask about available options.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="contact-help-card">
                    <div class="contact-help-icon">
                        <i class="bi bi-file-earmark-check-fill"></i>
                    </div>
                    <h4>Admission Information</h4>
                    <p>
                        Ask about admission-related information, fees, scholarships
                        or the next steps you should verify with an institution.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="contact-faq">
    <div class="container">
        <div class="contact-heading">
            <div class="label">Frequently Asked</div>
            <h2>Common Questions</h2>
            <p>
                A few quick answers before you send your enquiry.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="accordion" id="contactFaq">

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqOne">
                                Can GrowPec help me choose a college?
                            </button>
                        </h2>
                        <div id="faqOne"
                             class="accordion-collapse collapse show"
                             data-bs-parent="#contactFaq">
                            <div class="accordion-body">
                                Yes. You can share your preferred course, city,
                                education mode and other requirements so the team
                                can help you understand suitable options.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqTwo">
                                Can I ask about fees and scholarships?
                            </button>
                        </h2>
                        <div id="faqTwo"
                             class="accordion-collapse collapse"
                             data-bs-parent="#contactFaq">
                            <div class="accordion-body">
                                You can ask about available fee and scholarship
                                information. Before making an admission or payment
                                decision, always verify the latest details directly
                                with the respective institution.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqThree">
                                Does GrowPec cover online education?
                            </button>
                        </h2>
                        <div id="faqThree"
                             class="accordion-collapse collapse"
                             data-bs-parent="#contactFaq">
                            <div class="accordion-body">
                                GrowPec supports discovery of both regular and online
                                education options, helping students explore programs
                                and colleges according to their needs.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqFour">
                                What details should I include in my enquiry?
                            </button>
                        </h2>
                        <div id="faqFour"
                             class="accordion-collapse collapse"
                             data-bs-parent="#contactFaq">
                            <div class="accordion-body">
                                Your name, phone number, city, preferred course or
                                college and a short description of what you need
                                help with are enough to get started.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


<section class="pb-5">
    <div class="container">
        <div class="contact-cta">
            <h2>Still Have a Question?</h2>
            <p>
                Don't worry if you are not sure where to begin. Send us your
                requirements and take the first step toward a more informed choice.
            </p>

            <button type="button"
                    class="btn"
                    data-bs-toggle="modal"
                    data-bs-target="#counselingModal">
                <i class="bi bi-headset me-1"></i>
                Get Free Counselling
            </button>
        </div>
    </div>
</section>


<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactPageLeadForm');
    const message = document.getElementById('contactPageLeadMessage');
    const submitBtn = document.getElementById('contactPageSubmitBtn');

    if (!form || !message || !submitBtn) return;

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        message.style.display = 'none';
        message.className = 'contact-lead-message';

        const originalButton = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Sending...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (!response.ok || data.status !== 'success') {
                throw new Error(data.message || 'Unable to submit your enquiry. Please try again.');
            }

            message.className = 'contact-lead-message success';
            message.innerHTML =
                '<i class="bi bi-check-circle-fill me-1"></i> ' +
                (data.message || 'Thank you! Your enquiry has been submitted. Our expert counselor will contact you shortly.');
            message.style.display = 'block';

            form.reset();

            message.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        } catch (error) {
            message.className = 'contact-lead-message error';
            message.innerHTML =
                '<i class="bi bi-exclamation-circle-fill me-1"></i> ' +
                (error.message || 'Something went wrong. Please try again.');
            message.style.display = 'block';
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalButton;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\GrowPec\resources\views/pages/contact.blade.php ENDPATH**/ ?>