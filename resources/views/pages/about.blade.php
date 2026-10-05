@extends('layouts.app')

@section('title', 'About Us - GrowPec | Your Career Deserves the Right Choice')

@push('styles')
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
       ABOUT HERO
       ========================================================= */
    .about-hero {
        position: relative;
        overflow: hidden;
        padding: 72px 0 78px;
        background:
            radial-gradient(circle at 88% 18%, rgba(217,164,0,.16), transparent 24%),
            radial-gradient(circle at 8% 85%, rgba(0,138,67,.10), transparent 28%),
            linear-gradient(135deg, #F3F7FC 0%, #FFFFFF 50%, #F1F8F4 100%);
    }

    .about-hero::before,
    .about-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .about-hero::before {
        width: 360px;
        height: 360px;
        right: -180px;
        top: -180px;
        background: rgba(0,43,103,.055);
    }

    .about-hero::after {
        width: 230px;
        height: 230px;
        left: -115px;
        bottom: -115px;
        border: 35px solid rgba(217,164,0,.07);
    }

    .about-hero-content {
        position: relative;
        z-index: 2;
    }

    .about-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 13px;
        border-radius: 999px;
        background: #EAF1F8;
        border: 1px solid #D5E2EE;
        color: var(--gp-navy);
        font-size: .76rem;
        font-weight: 800;
    }

    .about-eyebrow i {
        color: var(--gp-gold-dark);
    }

    .about-hero h1 {
        max-width: 760px;
        margin: 17px 0 15px;
        color: var(--gp-navy-dark);
        font-size: clamp(2rem, 4.3vw, 3.55rem);
        line-height: 1.08;
        font-weight: 850;
        letter-spacing: -.045em;
    }

    .about-hero h1 span {
        color: var(--gp-green);
    }

    .about-hero-text {
        max-width: 680px;
        margin-bottom: 25px;
        color: var(--gp-muted);
        font-size: 1rem;
        line-height: 1.75;
    }

    .about-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 11px;
    }

    .about-primary-btn,
    .about-secondary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 46px;
        padding: 11px 20px;
        border-radius: 999px;
        font-size: .84rem;
        font-weight: 800;
        text-decoration: none;
        transition: .22s ease;
    }

    .about-primary-btn {
        background: var(--gp-navy);
        color: #fff;
        box-shadow: 0 9px 20px rgba(0,43,103,.18);
    }

    .about-primary-btn:hover {
        background: var(--gp-green-dark);
        color: #fff;
        transform: translateY(-2px);
    }

    .about-secondary-btn {
        background: #fff;
        color: var(--gp-navy);
        border: 1px solid #D6E2EB;
    }

    .about-secondary-btn:hover {
        color: var(--gp-green-dark);
        border-color: #A8CDBA;
        transform: translateY(-2px);
    }

    /* Hero visual */
    .about-hero-visual {
        position: relative;
        min-height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .about-visual-main {
        position: relative;
        width: min(100%, 390px);
        min-height: 300px;
        padding: 28px;
        border-radius: 30px;
        background: linear-gradient(145deg, var(--gp-navy-dark), var(--gp-blue));
        box-shadow: 0 25px 55px rgba(0,43,103,.22);
        overflow: hidden;
    }

    .about-visual-main::after {
        content: "";
        position: absolute;
        width: 190px;
        height: 190px;
        right: -80px;
        bottom: -90px;
        border-radius: 50%;
        background: rgba(217,164,0,.18);
    }

    .about-visual-icon {
        width: 68px;
        height: 68px;
        display: grid;
        place-items: center;
        border-radius: 20px;
        background: rgba(217,164,0,.16);
        color: var(--gp-gold);
        font-size: 2rem;
        margin-bottom: 24px;
    }

    .about-visual-main h3 {
        color: #fff;
        font-size: 1.55rem;
        font-weight: 800;
        line-height: 1.25;
        margin-bottom: 10px;
    }

    .about-visual-main p {
        color: rgba(255,255,255,.76);
        font-size: .84rem;
        line-height: 1.6;
        margin-bottom: 25px;
    }

    .about-visual-points {
        display: grid;
        gap: 10px;
    }

    .about-visual-point {
        display: flex;
        align-items: center;
        gap: 9px;
        color: rgba(255,255,255,.9);
        font-size: .76rem;
        font-weight: 700;
    }

    .about-visual-point i {
        color: #65D49A;
    }

    .about-floating-card {
        position: absolute;
        right: -18px;
        bottom: 18px;
        z-index: 3;
        width: 170px;
        padding: 15px;
        border-radius: 18px;
        background: #fff;
        border: 1px solid #E2E8F0;
        box-shadow: 0 15px 35px rgba(0,43,103,.15);
    }

    .about-floating-card small {
        display: block;
        color: var(--gp-muted);
        font-size: .65rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .about-floating-card strong {
        display: block;
        color: var(--gp-navy);
        font-size: .9rem;
    }

    .about-floating-card i {
        color: var(--gp-gold-dark);
        margin-right: 4px;
    }

    /* =========================================================
       STATS
       ========================================================= */
    .about-stats {
        position: relative;
        z-index: 5;
        margin-top: -30px;
    }

    .about-stat-card {
        height: 100%;
        padding: 20px;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 18px;
        box-shadow: 0 9px 25px rgba(0,43,103,.07);
        text-align: center;
    }

    .about-stat-icon {
        width: 42px;
        height: 42px;
        margin: 0 auto 10px;
        display: grid;
        place-items: center;
        border-radius: 13px;
        background: #EEF4F8;
        color: var(--gp-navy);
    }

    .about-stat-card strong {
        display: block;
        color: var(--gp-navy);
        font-size: 1.35rem;
        font-weight: 850;
    }

    .about-stat-card span {
        color: var(--gp-muted);
        font-size: .72rem;
    }

    /* =========================================================
       COMMON SECTION
       ========================================================= */
    .about-section {
        padding: 72px 0;
    }

    .about-section-light {
        background: var(--gp-bg);
    }

    .about-section-heading {
        max-width: 720px;
        margin: 0 auto 42px;
        text-align: center;
    }

    .about-section-heading .label {
        color: var(--gp-green-dark);
        font-size: .72rem;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .12em;
    }

    .about-section-heading h2 {
        margin: 8px 0 11px;
        color: var(--gp-navy-dark);
        font-size: clamp(1.65rem, 3vw, 2.35rem);
        line-height: 1.18;
        font-weight: 850;
        letter-spacing: -.025em;
    }

    .about-section-heading p {
        color: var(--gp-muted);
        font-size: .9rem;
        line-height: 1.7;
        margin: 0;
    }

    /* =========================================================
       MISSION
       ========================================================= */
    .about-mission-card {
        height: 100%;
        padding: 31px;
        border-radius: 23px;
        background: #fff;
        border: 1px solid var(--gp-border);
        box-shadow: 0 10px 30px rgba(0,43,103,.055);
    }

    .about-mission-card.accent {
        background: linear-gradient(145deg, #F1F8F4, #FFFFFF);
        border-color: #D9EADF;
    }

    .about-mission-icon {
        width: 54px;
        height: 54px;
        display: grid;
        place-items: center;
        border-radius: 16px;
        background: #EAF1F8;
        color: var(--gp-navy);
        font-size: 1.35rem;
        margin-bottom: 18px;
    }

    .about-mission-card.accent .about-mission-icon {
        background: #E8F6EF;
        color: var(--gp-green-dark);
    }

    .about-mission-card h3 {
        color: var(--gp-navy);
        font-size: 1.2rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .about-mission-card p {
        color: var(--gp-muted);
        font-size: .84rem;
        line-height: 1.75;
        margin: 0;
    }

    /* =========================================================
       HOW IT WORKS
       ========================================================= */
    .about-step {
        position: relative;
        height: 100%;
        padding: 25px 21px;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 19px;
        transition: .25s ease;
    }

    .about-step:hover {
        transform: translateY(-5px);
        border-color: #C8D9E8;
        box-shadow: 0 14px 30px rgba(0,43,103,.09);
    }

    .about-step-number {
        width: 42px;
        height: 42px;
        display: grid;
        place-items: center;
        margin-bottom: 17px;
        border-radius: 13px;
        background: var(--gp-navy);
        color: #fff;
        font-size: .85rem;
        font-weight: 850;
    }

    .about-step:nth-child(2) .about-step-number {
        background: var(--gp-green);
    }

    .about-step:nth-child(3) .about-step-number {
        background: var(--gp-gold);
        color: #10200F;
    }

    .about-step h4 {
        color: var(--gp-navy);
        font-size: .98rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .about-step p {
        color: var(--gp-muted);
        font-size: .77rem;
        line-height: 1.65;
        margin: 0;
    }

    /* =========================================================
       WHY TRUST
       ========================================================= */
    .about-trust-box {
        padding: 35px;
        border-radius: 25px;
        background: linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy));
        overflow: hidden;
        position: relative;
    }

    .about-trust-box::after {
        content: "";
        position: absolute;
        width: 330px;
        height: 330px;
        right: -150px;
        top: -150px;
        border-radius: 50%;
        border: 45px solid rgba(217,164,0,.10);
    }

    .about-trust-content {
        position: relative;
        z-index: 2;
    }

    .about-trust-box h2 {
        color: #fff;
        font-size: clamp(1.45rem, 3vw, 2rem);
        font-weight: 850;
        margin-bottom: 11px;
    }

    .about-trust-box > .about-trust-content > p {
        max-width: 680px;
        color: rgba(255,255,255,.73);
        font-size: .83rem;
        line-height: 1.7;
    }

    .about-trust-list {
        display: grid;
        gap: 11px;
        margin-top: 22px;
    }

    .about-trust-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: rgba(255,255,255,.9);
        font-size: .78rem;
        line-height: 1.5;
    }

    .about-trust-item i {
        flex: 0 0 auto;
        color: #65D49A;
        margin-top: 2px;
    }

    /* =========================================================
       SERVICES
       ========================================================= */
    .about-service-card {
        height: 100%;
        padding: 25px;
        background: #fff;
        border: 1px solid var(--gp-border);
        border-radius: 20px;
        transition: .25s ease;
    }

    .about-service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(0,43,103,.08);
    }

    .about-service-icon {
        width: 50px;
        height: 50px;
        display: grid;
        place-items: center;
        margin-bottom: 17px;
        border-radius: 15px;
        background: #EEF4F8;
        color: var(--gp-navy);
        font-size: 1.25rem;
    }

    .about-service-card:nth-child(2) .about-service-icon {
        background: #E8F6EF;
        color: var(--gp-green-dark);
    }

    .about-service-card:nth-child(3) .about-service-icon {
        background: #FFF6D9;
        color: var(--gp-gold-dark);
    }

    .about-service-card:nth-child(4) .about-service-icon {
        background: #EEF4F8;
        color: var(--gp-blue);
    }

    .about-service-card h4 {
        color: var(--gp-navy);
        font-size: .98rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .about-service-card p {
        color: var(--gp-muted);
        font-size: .76rem;
        line-height: 1.7;
        margin: 0;
    }

    /* =========================================================
       VALUES
       ========================================================= */
    .about-value {
        display: flex;
        gap: 13px;
        padding: 17px 0;
        border-bottom: 1px solid #E8EDF2;
    }

    .about-value:last-child {
        border-bottom: 0;
    }

    .about-value-icon {
        flex: 0 0 40px;
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: #EEF4F8;
        color: var(--gp-navy);
    }

    .about-value h5 {
        color: var(--gp-navy);
        font-size: .88rem;
        font-weight: 800;
        margin: 0 0 4px;
    }

    .about-value p {
        color: var(--gp-muted);
        font-size: .73rem;
        line-height: 1.55;
        margin: 0;
    }

    /* =========================================================
       CTA
       ========================================================= */
    .about-cta {
        position: relative;
        overflow: hidden;
        padding: 52px 30px;
        border-radius: 27px;
        text-align: center;
        background:
            radial-gradient(circle at 20% 20%, rgba(217,164,0,.13), transparent 23%),
            linear-gradient(135deg, var(--gp-navy-dark), var(--gp-navy) 58%, var(--gp-green-dark));
        box-shadow: 0 20px 45px rgba(0,43,103,.17);
    }

    .about-cta h2 {
        position: relative;
        z-index: 2;
        color: #fff;
        font-size: clamp(1.55rem, 3vw, 2.25rem);
        font-weight: 850;
        margin-bottom: 10px;
    }

    .about-cta p {
        position: relative;
        z-index: 2;
        max-width: 650px;
        margin: 0 auto 22px;
        color: rgba(255,255,255,.74);
        font-size: .84rem;
        line-height: 1.7;
    }

    .about-cta .btn {
        position: relative;
        z-index: 2;
        min-height: 45px;
        padding: 10px 21px;
        border: 0;
        border-radius: 999px;
        background: var(--gp-gold);
        color: #10200F;
        font-weight: 850;
    }

    .about-cta .btn:hover {
        background: #fff;
        color: var(--gp-navy);
    }

    .about-disclaimer {
        max-width: 900px;
        margin: 20px auto 0;
        text-align: center;
        color: #8793A1;
        font-size: .68rem;
        line-height: 1.6;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */
    @media (max-width: 991.98px) {
        .about-hero {
            padding: 55px 0 65px;
        }

        .about-hero-visual {
            min-height: 310px;
        }

        .about-section {
            padding: 58px 0;
        }
    }

    @media (max-width: 767.98px) {
        .about-hero {
            padding: 42px 0 55px;
        }

        .about-hero h1 {
            font-size: 2rem;
        }

        .about-hero-text {
            font-size: .86rem;
            line-height: 1.65;
        }

        .about-hero-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .about-primary-btn,
        .about-secondary-btn {
            width: 100%;
        }

        .about-hero-visual {
            min-height: 285px;
            margin-top: 5px;
        }

        .about-visual-main {
            width: 100%;
            min-height: 275px;
            padding: 23px;
            border-radius: 23px;
        }

        .about-floating-card {
            right: 8px;
            bottom: 4px;
        }

        .about-stats {
            margin-top: -20px;
        }

        .about-stat-card {
            padding: 15px 10px;
        }

        .about-stat-card strong {
            font-size: 1.1rem;
        }

        .about-section {
            padding: 48px 0;
        }

        .about-section-heading {
            margin-bottom: 28px;
        }

        .about-mission-card,
        .about-trust-box {
            padding: 24px;
        }

        .about-trust-box {
            border-radius: 21px;
        }

        .about-cta {
            padding: 40px 20px;
            border-radius: 22px;
        }
    }

    @media (max-width: 380px) {
        .about-hero h1 {
            font-size: 1.75rem;
        }

        .about-floating-card {
            width: 150px;
        }
    }

    .about-hero {
        background:
            radial-gradient(circle at 80% 16%, rgba(217,164,0,.18), transparent 23%),
            radial-gradient(circle at 8% 88%, rgba(0,138,67,.15), transparent 28%),
            linear-gradient(135deg, #E7EEF7 0%, #F5F8FC 52%, #EAF4EE 100%);
    }

    .about-visual-main {
        background: linear-gradient(145deg, #002B67 0%, #174B8F 58%, #007B55 100%);
    }

    .about-stat-card,
    .about-mission-card,
    .about-step,
    .about-service-card {
        border-color: rgba(0,43,103,.1);
        box-shadow: 0 14px 34px rgba(0,43,103,.065);
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .about-hero {
            padding: 44px 0 56px;
        }

        .about-hero .row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 1rem;
        }

        .about-hero h1 {
            font-size: clamp(1.8rem, 3.6vw, 2.45rem);
        }

        .about-hero-visual {
            min-height: 320px;
        }

        .about-visual-main {
            min-height: 285px;
            padding: 23px;
            border-radius: 24px;
        }

        .about-floating-card {
            right: -4px;
            bottom: 2px;
        }
    }

    .leadership-section { position:relative; isolation:isolate; overflow:hidden; padding:86px 0; background:radial-gradient(ellipse at 8% 8%,rgba(91,203,163,.12),transparent 30%),radial-gradient(ellipse at 94% 78%,rgba(94,174,245,.13),transparent 32%),linear-gradient(135deg,#F1FAF8 0%,#fff 48%,#F1F8FF 100%); }
    .leadership-section:before,.leadership-section:after { position:absolute; z-index:-1; content:""; width:330px; height:330px; border:1px solid rgba(37,174,125,.15); border-radius:50%; pointer-events:none; }
    .leadership-section:before { top:-205px; right:-70px; box-shadow:0 0 0 30px rgba(37,174,125,.035),0 0 0 70px rgba(37,174,125,.025); }
    .leadership-section:after { bottom:-250px; left:-90px; border-color:rgba(68,145,224,.13); box-shadow:0 0 0 32px rgba(68,145,224,.035),0 0 0 76px rgba(68,145,224,.025); }
    .leadership-section-heading { max-width:820px; margin:0 auto 40px; text-align:center; }
    .leadership-section-heading span { display:inline-flex; align-items:center; gap:16px; color:#07975C; font-size:.76rem; font-weight:850; letter-spacing:.12em; text-transform:uppercase; }
    .leadership-section-heading span:before,.leadership-section-heading span:after { width:42px; height:1px; background:linear-gradient(90deg,transparent,#70D1AB); content:""; }
    .leadership-section-heading span:after { transform:rotate(180deg); }
    .leadership-section-heading h2 { margin:12px 0 7px; color:#0B1D3D; font-size:clamp(2rem,4vw,3.25rem); font-weight:850; letter-spacing:-.045em; }
    .leadership-section-heading h2 em { color:#07975C; font-style:normal; }
    .leadership-section-heading p { max-width:700px; margin:0 auto; color:#71809B; font-size:clamp(.95rem,1.6vw,1.15rem); line-height:1.65; }
    .leadership-message-grid { display:grid; grid-template-columns:minmax(0,1fr); gap:24px; }
    .leadership-message-card { --leadership-accent:#0A9B64; --leadership-soft:#D9F3E9; overflow:hidden; padding:16px; border:1px solid rgba(255,255,255,.9); border-radius:30px; background:rgba(255,255,255,.91); box-shadow:0 24px 65px rgba(25,77,91,.1); }
    .leadership-message-card-ceo { --leadership-accent:#1677E8; --leadership-soft:#DCEBFF; }
    .leadership-message-card-inner { display:grid; grid-template-columns:minmax(250px,.39fr) minmax(0,1fr); align-items:stretch; gap:clamp(24px,4vw,54px); min-height:350px; }
    .leadership-message-card-ceo .leadership-message-card-inner { grid-template-columns:minmax(0,1fr) minmax(250px,.39fr); }
    .leadership-message-card-ceo .leadership-message-portrait { order:2; }
    .leadership-message-portrait { position:relative; display:flex; min-height:330px; align-items:flex-end; justify-content:center; overflow:hidden; border-radius:24px; background:radial-gradient(ellipse at 50% 35%,#fff 0%,transparent 55%),linear-gradient(145deg,var(--leadership-soft),#F5FBFA); }
    .leadership-message-portrait:before { position:absolute; top:16px; left:18px; width:78%; height:85%; border:1px solid rgba(255,255,255,.8); border-radius:48% 42% 28% 25%; content:""; }
    .leadership-message-portrait:after { position:absolute; right:-32px; bottom:-50px; width:170px; height:170px; border-radius:50%; background:var(--leadership-soft); content:""; }
    .leadership-message-photo { position:relative; z-index:1; display:grid; width:100%; height:100%; min-height:330px; place-items:center; overflow:hidden; color:var(--leadership-accent); font-size:5rem; font-weight:850; }
    .leadership-message-photo img { position:absolute; bottom:0; width:100%; height:100%; object-fit:cover; object-position:center top; mask-image:linear-gradient(#000 72%,rgba(0,0,0,.82)); }
    .leadership-message-photo-fallback { position:relative; z-index:1; display:grid; width:170px; height:170px; margin-bottom:32px; place-items:center; border:8px solid rgba(255,255,255,.75); border-radius:50%; background:linear-gradient(145deg,var(--leadership-soft),#fff); }
    .leadership-message-photo-note { position:absolute; z-index:2; bottom:18px; left:16px; display:flex; align-items:center; gap:11px; padding:11px 15px; border:1px solid rgba(255,255,255,.88); border-radius:17px; background:rgba(255,255,255,.9); box-shadow:0 10px 28px rgba(15,48,66,.1); color:#142746; font-size:.78rem; font-weight:750; }
    .leadership-message-photo-note i { display:grid; width:35px; height:35px; place-items:center; border-radius:50%; background:var(--leadership-soft); color:var(--leadership-accent); font-size:1rem; }
    .leadership-message-copy { position:relative; display:flex; min-width:0; flex-direction:column; justify-content:center; padding:22px clamp(8px,2vw,24px) 20px 0; }
    .leadership-message-copy:before { position:absolute; top:8px; right:8px; color:var(--leadership-soft); content:"“"; font-family:Georgia,serif; font-size:8rem; font-weight:700; line-height:1; pointer-events:none; }
    .leadership-message-role { position:relative; z-index:1; display:inline-flex; align-self:flex-start; padding:6px 13px; border-radius:999px; background:var(--leadership-soft); color:var(--leadership-accent); font-size:.75rem; font-weight:850; letter-spacing:.06em; text-transform:uppercase; }
    .leadership-message-copy h3 { position:relative; z-index:1; margin:12px 0 2px; color:#0B1D3D; font-size:clamp(1.5rem,2.7vw,2.1rem); font-weight:850; letter-spacing:-.03em; }
    .leadership-message-designation { margin:0 0 13px; color:#71809B; font-size:.95rem; font-weight:650; }
    .leadership-message-quote { max-width:780px; margin:0; color:#5A6A86; font-size:clamp(.9rem,1.25vw,1.02rem); line-height:1.65; white-space:pre-line; overflow-wrap:anywhere; }
    .leadership-message-vision { margin-top:10px; }
    .leadership-message-footer { display:flex; align-items:flex-end; justify-content:space-between; gap:18px; margin-top:18px; }
    .leadership-message-read { display:inline-flex; align-items:center; gap:12px; padding:12px 20px; border-radius:15px; background:linear-gradient(110deg,var(--leadership-accent),color-mix(in srgb,var(--leadership-accent),#047553 35%)); box-shadow:0 10px 22px color-mix(in srgb,var(--leadership-accent),transparent 78%); color:#fff; font-size:.9rem; font-weight:800; text-decoration:none; transition:transform .2s ease,box-shadow .2s ease; }
    .leadership-message-read:hover { transform:translateY(-2px); box-shadow:0 14px 26px color-mix(in srgb,var(--leadership-accent),transparent 68%); color:#fff; }
    .leadership-message-signoff { display:grid; gap:2px; justify-items:end; color:#536582; font-size:.84rem; text-align:right; }
    .leadership-message-signoff strong { color:#142746; font-family:cursive; font-size:1.15rem; font-weight:600; }
    @media (max-width:767.98px) { .leadership-section { padding:58px 0; } .leadership-section-heading { margin-bottom:26px; } .leadership-section-heading span { gap:9px; font-size:.67rem; } .leadership-section-heading span:before,.leadership-section-heading span:after { width:23px; } .leadership-message-card { padding:10px; border-radius:23px; } .leadership-message-card-inner,.leadership-message-card-ceo .leadership-message-card-inner { grid-template-columns:1fr; gap:0; } .leadership-message-card-ceo .leadership-message-portrait { order:0; } .leadership-message-portrait,.leadership-message-photo { min-height:270px; max-height:350px; } .leadership-message-copy { padding:22px 12px 14px; } .leadership-message-copy:before { top:6px; right:7px; font-size:6rem; } .leadership-message-footer { align-items:flex-start; flex-direction:column; } .leadership-message-signoff { justify-items:start; text-align:left; } }
</style>
@endpush

@section('content')

{{-- =========================================================
     1. ABOUT HERO
     ========================================================= --}}
<section class="about-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-7 col-lg-7">
                <div class="about-hero-content">
                    <span class="about-eyebrow">
                        <i class="bi bi-mortarboard-fill"></i>
                        About GrowPec
                    </span>

                    <h1>
                        Explore Your Options.
                        <span>Choose Your Next Step.</span>
                    </h1>

                    <p class="about-hero-text">
                        GrowPec helps students explore colleges, courses and study modes
                        in one place. Compare the options that fit your goals, then connect
                        with our team when you need help understanding what to do next.
                    </p>

                    <div class="about-hero-actions">
                        <a href="{{ route('colleges.regular') }}" class="about-primary-btn">
                            <i class="bi bi-search"></i>
                            Explore Colleges
                        </a>

                        <button type="button"
                                class="about-secondary-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#counselingModal">
                            <i class="bi bi-headset"></i>
                            Get Free Counselling
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-lg-5">
                <div class="about-hero-visual">
                    <div class="about-visual-main">
                        <div class="about-visual-icon">
                            <i class="bi bi-compass"></i>
                        </div>

                        <h3>Make the next step<br>feel clearer.</h3>

                        <p>
                            Explore regular and online colleges, review program details,
                            and ask for guidance when you need it.
                        </p>

                        <div class="about-visual-points">
                            <div class="about-visual-point">
                                <i class="bi bi-check-circle-fill"></i>
                                College & Program Discovery
                            </div>
                            <div class="about-visual-point">
                                <i class="bi bi-check-circle-fill"></i>
                                Admission Guidance
                            </div>
                            <div class="about-visual-point">
                                <i class="bi bi-check-circle-fill"></i>
                                Regular & Online Education Options
                            </div>
                        </div>
                    </div>

                    <div class="about-floating-card">
                        <small>Start exploring</small>
                        <strong>
                            <i class="bi bi-arrow-up-right-circle"></i>
                            Your next step
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     2. QUICK STATS / VALUE STRIP
     ========================================================= --}}
<section class="about-stats">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <strong>Explore</strong>
                    <span>Colleges</span>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <strong>Compare</strong>
                    <span>Programs</span>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <strong>Get</strong>
                    <span>Guidance</span>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="about-stat-card">
                    <div class="about-stat-icon">
                        <i class="bi bi-globe2"></i>
                    </div>
                    <strong>Choose</strong>
                    <span>Your study mode</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     3. MISSION & VISION
     ========================================================= --}}
<section class="about-section">
    <div class="container">
        <div class="about-section-heading">
            <div class="label">Who We Are</div>
            <h2>Useful Information for a Big Decision</h2>
            <p>
                Finding the right college takes research. GrowPec brings college,
                course and admission information together to help you make a shortlist
                that reflects your interests and priorities.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="about-mission-card">
                    <div class="about-mission-icon">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>
                        Help students explore colleges and programs with clear information
                        and practical guidance, so they can compare options against their
                        own goals, preferences and admission requirements.
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="about-mission-card accent">
                    <div class="about-mission-icon">
                        <i class="bi bi-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>
                        Make education discovery easier to navigate, with regular and
                        online college options, useful program details and a simple way
                        to ask for support before taking the next step.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@if(isset($leadershipMessages) && $leadershipMessages->isNotEmpty())
<section class="leadership-section" id="leadershipMessages" aria-labelledby="leadershipTitle">
    <div class="container">
        <div class="leadership-section-heading">
            <span>Meet Our Leadership</span>
            <h2 id="leadershipTitle">A Message from <em>GrowPec</em></h2>
            <p>Our leadership team shares their vision, values, and commitment towards building a brighter future for every student.</p>
        </div>
        <div class="leadership-message-grid">
            @foreach($leadershipMessages as $leadershipMessage)
            <article class="leadership-message-card leadership-message-card-{{ $leadershipMessage->role }}">
                <div class="leadership-message-card-inner">
                    <div class="leadership-message-portrait">
                        <div class="leadership-message-photo">
                    @if($leadershipMessage->photo_url)
                        <img src="{{ $leadershipMessage->photo_url }}" alt="{{ $leadershipMessage->name }}" loading="lazy">
                    @else
                        <span class="leadership-message-photo-fallback">{{ mb_strtoupper(mb_substr($leadershipMessage->name, 0, 1)) }}</span>
                    @endif
                        </div>
                        <div class="leadership-message-photo-note">
                            <i class="bi bi-mortarboard-fill"></i>
                            <span>{{ $leadershipMessage->role === 'ceo' ? 'Empowering Every Student' : 'Building Better Futures' }}</span>
                        </div>
                    </div>
                    <div class="leadership-message-copy">
                    <span class="leadership-message-role">{{ ucfirst($leadershipMessage->role) }}</span>
                    <h3>{{ $leadershipMessage->name }}</h3>
                    <p class="leadership-message-designation">{{ $leadershipMessage->designation }}</p>
                    <p class="leadership-message-quote">{{ \Illuminate\Support\Str::limit($leadershipMessage->message, 420) }}</p>
                    <div class="leadership-message-footer">
                        <a href="{{ route('leadership-messages.show', $leadershipMessage) }}" class="leadership-message-read">
                            Read their story <i class="bi bi-arrow-right"></i>
                        </a>
                        <div class="leadership-message-signoff">
                            <strong>{{ $leadershipMessage->name }}</strong>
                            <span>{{ $leadershipMessage->designation }}</span>
                        </div>
                    </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- =========================================================
     4. HOW GROWPEC HELPS
     ========================================================= --}}
<section class="about-section about-section-light">
    <div class="container">
        <div class="about-section-heading">
            <div class="label">How It Works</div>
            <h2>A Simpler Way to Find Your Next Step</h2>
            <p>
                Start with what you want to study, compare relevant options and reach
                out to the team whenever you want a person to help you move forward.
            </p>
        </div>

        <div class="row g-3">
            <div class="col-lg-4">
                <div class="about-step">
                    <div class="about-step-number">01</div>
                    <h4>Explore</h4>
                    <p>
                        Search colleges, universities, cities and programs that match
                        the direction you are considering.
                    </p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="about-step">
                    <div class="about-step-number">02</div>
                    <h4>Understand</h4>
                    <p>
                        Review available program details, admission information,
                        fees, approvals and other useful college information.
                    </p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="about-step">
                    <div class="about-step-number">03</div>
                    <h4>Get Guidance</h4>
                    <p>
                        When you need help, connect with the GrowPec team for
                        admission-oriented guidance and next-step support.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     5. WHY TRUST GROWPEC
     ========================================================= --}}
<section class="about-section">
    <div class="container">
        <div class="about-trust-box">
            <div class="about-trust-content">
                <h2>Guidance That Keeps Your Goals in View</h2>

                <p>
                    Our goal is not to make the decision for you. It is to make the
                    information easier to understand so you can make a more informed
                    decision for your education journey.
                </p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="about-trust-list">
                            <div class="about-trust-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Student-first college and program discovery experience.</span>
                            </div>
                            <div class="about-trust-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Clear presentation of available college and admission information.</span>
                            </div>
                            <div class="about-trust-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Options across regular and online education.</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="about-trust-list">
                            <div class="about-trust-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Guidance designed to help students understand their choices.</span>
                            </div>
                            <div class="about-trust-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Easy access to college, course and location-based discovery.</span>
                            </div>
                            <div class="about-trust-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Support for students who want help before applying.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     6. WHAT WE OFFER
     ========================================================= --}}
<section class="about-section about-section-light">
    <div class="container">
        <div class="about-section-heading">
            <div class="label">What We Offer</div>
            <h2>More Than Just a College Search</h2>
            <p>
                GrowPec brings several parts of the admission journey together
                so students do not have to start from scratch every time.
            </p>
        </div>

        <div class="row g-3">
            <div class="col-sm-6 col-lg-3">
                <div class="about-service-card">
                    <div class="about-service-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h4>College Discovery</h4>
                    <p>
                        Find colleges and universities by education mode, location
                        and other relevant preferences.
                    </p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="about-service-card">
                    <div class="about-service-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <h4>Program Exploration</h4>
                    <p>
                        Explore degrees, courses and specializations to understand
                        possible academic pathways.
                    </p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="about-service-card">
                    <div class="about-service-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h4>Admission Guidance</h4>
                    <p>
                        Get assistance when you need help understanding your
                        admission journey and next steps.
                    </p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="about-service-card">
                    <div class="about-service-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h4>Scholarship Awareness</h4>
                    <p>
                        Understand scholarship and financial-support information
                        where it is available for a college or program.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     7. OUR PRINCIPLES
     ========================================================= --}}
<section class="about-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="about-section-heading text-start mb-0">
                    <div class="label">Our Approach</div>
                    <h2>Built Around Better Decisions</h2>
                    <p>
                        Education choices can feel overwhelming. Our approach is
                        designed around clarity, accessibility and practical support.
                    </p>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="about-value">
                    <div class="about-value-icon">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <div>
                        <h5>Clarity First</h5>
                        <p>We aim to present important information in a straightforward format.</p>
                    </div>
                </div>

                <div class="about-value">
                    <div class="about-value-icon">
                        <i class="bi bi-person-heart"></i>
                    </div>
                    <div>
                        <h5>Student Focus</h5>
                        <p>We keep the student's goals and decision-making journey at the center.</p>
                    </div>
                </div>

                <div class="about-value">
                    <div class="about-value-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h5>Responsible Information</h5>
                        <p>We encourage students to review official college information before applying.</p>
                    </div>
                </div>

                <div class="about-value">
                    <div class="about-value-icon">
                        <i class="bi bi-arrow-up-right-circle"></i>
                    </div>
                    <div>
                        <h5>Next-Step Support</h5>
                        <p>When students need help, we make it easier to connect for guidance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================
     8. FINAL CTA
     ========================================================= --}}
<section class="about-section pt-0">
    <div class="container">
        <div class="about-cta">
            <h2>Your Career Deserves the Right Choice</h2>
            <p>
                Start exploring colleges and programs today, or speak with our team
                if you want help understanding your options.
            </p>

            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="{{ route('colleges.regular') }}" class="btn">
                    <i class="bi bi-search me-1"></i>
                    Explore Colleges
                </a>

                <button type="button"
                        class="btn"
                        data-bs-toggle="modal"
                        data-bs-target="#counselingModal">
                    <i class="bi bi-headset me-1"></i>
                    Get Free Counselling
                </button>
            </div>
        </div>

        <p class="about-disclaimer">
            GrowPec is an education discovery and guidance platform. Students are
            encouraged to verify admission rules, fees, approvals, scholarships and
            other official details directly with the respective institution before
            making an admission or payment decision.
        </p>
    </div>
</section>

@endsection
