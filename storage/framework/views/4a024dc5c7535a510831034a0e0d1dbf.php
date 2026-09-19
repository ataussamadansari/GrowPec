<?php $__env->startSection('title', 'GrowPec - Your Career Deserves A Better College | Admission Guidance'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    :root {
        --gp-purple: #001F59;
        --gp-purple-dark: #00163F;
        --gp-gold: #DCA000;
        --gp-gold-hover: #B98200;
        --gp-bg: #F8F8FA;
        --gp-border: #E7E5EB;
    }

    /* =========================================================
       1. 🎯 ADMISSION SEARCH / SUCCESS MESSAGE
       ========================================================= */
    .admission-hero-section {
        background: linear-gradient(135deg, #f3f7fc 0%, #ffffff 44%, #f1f8f4 76%, #fff9e8 100%);
        border-bottom: 1px solid var(--gp-border);
        padding: 42px 0 36px;
    }

    .admission-hero-content {
        max-width: 920px;
        margin: 0 auto;
        text-align: center;
    }

    .admission-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #edf4fb;
        color: var(--gp-purple);
        border: 1px solid #d4e1f0;
        border-radius: 30px;
        padding: 7px 15px;
        font-size: 0.82rem;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .admission-hero-title {
        color: var(--gp-purple-dark);
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        line-height: 1.15;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .admission-hero-subtitle {
        color: #64748b;
        font-size: 1rem;
        max-width: 700px;
        margin: 0 auto 22px;
    }

    .admission-search-box {
        max-width: 760px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #d4e1f0;
        border-radius: 14px;
        padding: 7px;
        box-shadow: 0 10px 28px rgba(75, 46, 131, 0.10);
    }

    .admission-search-input {
        border: 0;
        box-shadow: none !important;
        height: 48px;
        font-size: 0.95rem;
    }

    .admission-search-btn {
        background: var(--gp-purple);
        color: #ffffff;
        border: 0;
        border-radius: 10px;
        padding: 0 24px;
        font-weight: 800;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .admission-search-btn:hover {
        background: var(--gp-purple-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* =========================================================
       HOME LIVE SEARCH
       ========================================================= */
    .admission-search-box {
        position: relative;
        z-index: 20;
    }

    .home-live-search-dropdown {
        position: absolute;
        left: 7px;
        right: 7px;
        top: calc(100% + 7px);
        background: #ffffff;
        border: 1px solid #e2dcef;
        border-radius: 14px;
        box-shadow: 0 18px 42px rgba(46, 30, 107, .16);
        overflow: hidden;
        text-align: left;
        z-index: 50;
        max-height: 390px;
        overflow-y: auto;
    }

    .home-live-search-dropdown .live-search-group-title {
        padding: 9px 14px 7px;
        background: #f8f6fc;
        color: #6b6477;
        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .6px;
        text-transform: uppercase;
    }

    .home-live-search-dropdown .live-search-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 11px 14px;
        color: #1f2937;
        text-decoration: none;
        border-bottom: 1px solid #f1eef6;
        transition: background .18s ease, padding-left .18s ease;
    }

    .home-live-search-dropdown .live-search-item:hover {
        background: #faf8ff;
        padding-left: 18px;
    }

    .home-live-search-dropdown .live-search-item:last-child {
        border-bottom: 0;
    }

    .home-live-search-dropdown .live-search-name {
        font-size: .84rem;
        font-weight: 700;
        line-height: 1.25;
    }

    .home-live-search-dropdown .live-search-meta {
        margin-top: 3px;
        color: #7c7488;
        font-size: .7rem;
    }

    .home-live-search-dropdown .live-search-type {
        flex: 0 0 auto;
        padding: 4px 8px;
        border-radius: 999px;
        background: #eef4fb;
        color: var(--gp-purple);
        font-size: .65rem;
        font-weight: 800;
    }

    .home-live-search-dropdown .live-search-footer {
        padding: 10px 14px;
        background: #fafafa;
        border-top: 1px solid #eeeaf4;
        text-align: center;
    }

    .home-live-search-dropdown .live-search-footer a {
        color: var(--gp-purple);
        font-size: .76rem;
        font-weight: 800;
        text-decoration: none;
    }

    .home-live-search-dropdown .live-search-state {
        padding: 18px 14px;
        color: #7c7488;
        text-align: center;
        font-size: .78rem;
    }

    @media (max-width: 575.98px) {
        .home-live-search-dropdown {
            left: 0;
            right: 0;
        }
    }

    .success-rate {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
        color: #334155;
        font-size: 0.9rem;
        font-weight: 700;
    }

    .success-rate strong {
        color: #198754;
        font-size: 1.15rem;
    }

    @media (max-width: 575.98px) {
        .admission-hero-section {
            padding: 30px 0 28px;
        }

        .admission-search-box .input-group {
            flex-direction: column;
            gap: 8px;
        }

        .admission-search-btn {
            width: 100%;
            height: 46px;
        }

        .success-rate {
            flex-wrap: wrap;
        }
    }

    /* =========================================================
       2. 🎯 PARTNER UNIVERSITIES MARQUEE STRIP
       ========================================================= */
    .partner-strip-section {
        background: #ffffff;
        border-bottom: 1px solid #E5E7EB;
        padding: 22px 0;
        overflow: hidden;
    }

    .partner-marquee-container {
        overflow: hidden;
        white-space: nowrap;
        position: relative;
    }

    .partner-marquee-track {
        display: inline-flex;
        align-items: center;
        gap: 40px;
        animation: marqueeScroll 28s linear infinite;
    }

    .partner-marquee-track:hover {
        animation-play-state: paused;
    }

    @keyframes marqueeScroll {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .partner-logo-pill {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;

        min-width: 170px;
        min-height: 95px;
        padding: 14px 18px;

        gap: 8px;
        flex: 0 0 auto;
    }

    .partner-logo-pill img {
        width: 100px;
        height: 70px;
        object-fit: contain;
        display: block;
    }

    .partner-logo-pill .partner-logo-fallback {
        width: 100px;
        height: 75px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .partner-logo-pill .partner-logo-fallback i {
        font-size: 30px;
        line-height: 1;
        color: var(--gp-purple);
    }

    .partner-logo-pill span {
        font-size: 14px;
        line-height: 1.3;
        font-weight: 600;
        white-space: normal;
        max-width: 170px;
    }

    /* =========================================================
       3. 🎓 EXPLORE TOP PROGRAMS — REFERENCE STYLE
       ========================================================= */
    .program-section {
        background: #ffffff;
        overflow: hidden;
    }

    .program-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(320px, .85fr);
        align-items: center;
        gap: 64px;
    }

    .program-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 48px 20px;
        align-items: start;
    }

    .program-grid .col {
        min-width: 0;
    }

    .program-grid .col:nth-child(2),
    .program-grid .col:nth-child(4) {
        transform: translateY(48px);
    }

    .program-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 245px;
        padding: 20px 16px 16px;
        background: #fff3c9;
        border: 0;
        border-radius: 0;
        color: #171717;
        text-decoration: none;
        box-shadow: 0 12px 24px rgba(0, 0, 0, .12);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .program-card:hover {
        transform: translateY(-5px);
        color: #171717;
        box-shadow: 0 18px 30px rgba(0, 0, 0, .16);
    }

    .program-grid .col:nth-child(2) .program-card:hover,
    .program-grid .col:nth-child(4) .program-card:hover {
        transform: translateY(-5px);
    }

    .program-card-top {
        display: block;
    }

    .program-icon-wrap {
        width: auto;
        height: auto;
        display: inline-flex;
        align-items: center;
        justify-content: flex-start;
        margin: 0 0 12px;
        background: transparent;
        border: 0;
        border-radius: 0;
        color: #111111;
        font-size: 1.25rem;
    }

    .program-card:hover .program-icon-wrap {
        transform: none;
        background: transparent;
    }

    .program-level-badge {
        display: none;
    }

    .program-content {
        padding-top: 0;
    }

    .program-name {
        margin: 0 0 7px;
        padding: 0;
        color: #171717;
        font-size: 1.08rem;
        font-weight: 700;
        line-height: 1.45;
        display: block;
        overflow: visible;
    }

    .program-details {
        display: block;
    }

    .program-detail {
        display: block;
        color: #6d5a2b;
        font-size: .76rem;
        font-weight: 500;
        line-height: 1.8;
    }

    .program-detail i,
    .program-detail-divider {
        display: none;
    }

    .program-footer {
        display: block;
        margin-top: auto;
        padding-top: 18px;
        border-top: 0;
    }

    .program-footer-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 34px;
        padding: 5px 10px;
        border-radius: 4px;
        background: #48378d;
        color: #ffffff;
        font-size: .78rem;
        font-weight: 800;
    }

    .program-footer-label::after {
        content: "\2192";
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .program-arrow {
        display: none;
    }

    .program-copy {
        max-width: 390px;
    }

    .program-copy-label {
        display: block;
        margin-bottom: 12px;
        color: #171717;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 300;
        line-height: 1.05;
    }

    .program-copy-title {
        margin: 0 0 15px;
        color: #111111;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        line-height: 1.05;
    }

    .program-copy-line {
        width: 255px;
        height: 1px;
        margin-bottom: 20px;
        background: #222222;
        position: relative;
    }

    .program-copy-line::after {
        content: "";
        position: absolute;
        left: 0;
        top: -2px;
        width: 55px;
        height: 4px;
        background: #222222;
    }

    .program-copy-text {
        margin: 0;
        color: #5d6470;
        font-size: .9rem;
        line-height: 1.75;
    }

    .program-copy-text strong {
        color: #26364d;
        font-weight: 800;
    }

    @media (max-width: 991.98px) {
        .program-layout {
            grid-template-columns: minmax(0, 1fr) minmax(260px, .75fr);
            gap: 36px;
        }

        .program-card {
            min-height: 225px;
        }

        .program-copy-label,
        .program-copy-title {
            font-size: 2rem;
        }
    }

    @media (max-width: 767.98px) {
        .program-layout {
            grid-template-columns: 1fr;
            gap: 35px;
        }

        .program-copy {
            order: -1;
            max-width: 100%;
            text-align: left;
        }

        .program-grid {
            gap: 28px 14px;
        }

        .program-grid .col:nth-child(2),
        .program-grid .col:nth-child(4) {
            transform: translateY(28px);
        }

        .program-card {
            min-height: 205px;
            padding: 17px 13px 13px;
        }

        .program-name {
            font-size: .92rem;
        }

        .program-detail {
            font-size: .68rem;
        }

        .program-footer-label {
            font-size: .68rem;
        }

        .program-copy-label,
        .program-copy-title {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 575.98px) {
        .program-grid {
            gap: 22px 12px;
        }

        .program-grid .col:nth-child(2),
        .program-grid .col:nth-child(4) {
            transform: translateY(22px);
        }

        .program-card {
            min-height: 190px;
            padding: 15px 11px 11px;
        }

        .program-icon-wrap {
            margin-bottom: 9px;
            font-size: 1.05rem;
        }

        .program-name {
            font-size: .82rem;
        }

        .program-detail {
            font-size: .62rem;
        }

        .program-footer {
            padding-top: 12px;
        }

        .program-footer-label {
            min-height: 31px;
            padding: 4px 8px;
            font-size: .62rem;
        }

        .program-copy-label,
        .program-copy-title {
            font-size: 1.65rem;
        }

        .program-copy-line {
            width: 190px;
        }
    }

    /* =========================================================
       3. 🎓 DISCOVER THE BEST IN EDUCATION
       ========================================================= */
    .education-discovery-section {
        position: relative;
        overflow: hidden;
        background: #fbf9ff;
        padding: 58px 0 52px;
    }

    .education-discovery-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(340px, .82fr);
        align-items: center;
        gap: 60px;
    }

    .education-discovery-copy {
        max-width: 620px;
    }

    .education-discovery-label {
        display: inline-block;
        margin-bottom: 18px;
        padding: 3px 9px;
        background: #ffe9a9;
        color: #111;
        font-size: .86rem;
        font-weight: 700;
        line-height: 1.25;
    }

    .education-discovery-title {
        margin: 0;
        color: #102f55;
        font-size: clamp(2.2rem, 4.5vw, 3.7rem);
        line-height: 1.08;
        font-weight: 500;
        letter-spacing: -.035em;
    }

    .education-discovery-line {
        width: 255px;
        height: 1px;
        margin: 19px 0 26px;
        background: #222;
        position: relative;
    }

    .education-discovery-line::after {
        content: "";
        position: absolute;
        left: 0;
        top: -2px;
        width: 55px;
        height: 4px;
        background: #222;
    }

    .education-discovery-text {
        max-width: 620px;
        margin: 0;
        color: #1e3654;
        font-size: 1rem;
        line-height: 1.8;
    }

    .education-discovery-text strong {
        color: #111827;
        font-weight: 800;
    }

    .education-discovery-actions {
        display: flex;
        gap: 40px;
        margin-top: 46px;
    }

    /* Right-side education visual */
    .education-discovery-visual {
        position: relative;
        min-height: 360px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .education-visual-orbit {
        position: absolute;
        width: 285px;
        height: 285px;
        border: 1px solid rgba(91, 73, 157, .12);
        border-radius: 50%;
    }

    .education-visual-orbit::before,
    .education-visual-orbit::after {
        content: "";
        position: absolute;
        border: 1px solid rgba(91, 73, 157, .09);
        border-radius: 50%;
    }

    .education-visual-orbit::before {
        inset: 22px;
    }

    .education-visual-orbit::after {
        inset: 54px;
    }

    .education-visual-glow {
        position: absolute;
        width: 245px;
        height: 245px;
        border-radius: 50%;
        background:
            radial-gradient(circle at 50% 35%, rgba(111, 88, 196, .28), transparent 58%),
            radial-gradient(circle at 70% 70%, rgba(176, 201, 239, .34), transparent 62%);
        filter: blur(2px);
        animation: educationGlowPulse 3.8s ease-in-out infinite;
    }

    .education-visual-center {
        position: relative;
        z-index: 3;
        width: 122px;
        height: 122px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background:
            radial-gradient(circle at 32% 25%, rgba(255, 255, 255, .96), rgba(213, 229, 255, .72) 42%, rgba(132, 166, 218, .62) 100%);
        border: 1px solid rgba(255, 255, 255, .92);
        box-shadow:
            0 20px 42px rgba(61, 53, 113, .20),
            inset 0 2px 0 rgba(255, 255, 255, .92),
            inset 0 0 0 10px rgba(255, 255, 255, .18);
        backdrop-filter: blur(12px) saturate(145%);
        -webkit-backdrop-filter: blur(12px) saturate(145%);
        animation: educationCenterFloat 3.4s ease-in-out infinite;
    }

    .education-visual-center i {
        color: #071f48;
        font-size: 3.45rem;
        font-weight: 900;
        line-height: 1;
        text-shadow: 0 5px 12px rgba(19, 46, 85, .12);
    }

    .education-visual-stat {
        position: absolute;
        z-index: 4;
        min-width: 104px;
        padding: 11px 13px;
        border: 1px solid rgba(255, 255, 255, .78);
        border-top-color: rgba(255, 255, 255, .98);
        border-radius: 14px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .82), rgba(224, 232, 250, .42));
        box-shadow:
            0 14px 30px rgba(55, 44, 100, .13),
            inset 0 1px 0 rgba(255, 255, 255, .95),
            inset 0 -1px 0 rgba(105, 112, 150, .08);
        backdrop-filter: blur(14px) saturate(135%);
        -webkit-backdrop-filter: blur(14px) saturate(135%);
        text-align: center;
        animation: educationStatFloat 4s ease-in-out infinite;
    }

    .education-visual-stat strong {
        display: block;
        color: #102f55;
        font-size: 1.18rem;
        font-weight: 900;
        line-height: 1.05;
    }

    .education-visual-stat span {
        display: block;
        margin-top: 4px;
        color: #42526b;
        font-size: .64rem;
        font-weight: 800;
        line-height: 1.25;
    }

    .education-visual-stat.programs {
        top: 28px;
        left: 22px;
        animation-delay: -.8s;
    }

    .education-visual-stat.universities {
        top: 24px;
        right: 18px;
        animation-delay: -.15s;
    }

    .education-visual-stat.colleges {
        bottom: 43px;
        left: 28px;
        animation-delay: -2s;
    }

    .education-visual-stat.online {
        bottom: 30px;
        right: 22px;
        animation-delay: -2.8s;
    }

    .education-visual-consult {
        position: absolute;
        z-index: 5;
        right: -12px;
        top: 50%;
        transform: translateY(-50%);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-width: 205px;
        min-height: 58px;
        padding: 10px 13px;
        border: 1px solid rgba(255, 255, 255, .82);
        border-top-color: rgba(255, 255, 255, .98);
        border-radius: 999px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(224, 229, 244, .58));
        color: #111827;
        box-shadow:
            0 14px 30px rgba(43, 36, 77, .18),
            inset 0 1px 0 rgba(255, 255, 255, .95);
        backdrop-filter: blur(16px) saturate(145%);
        -webkit-backdrop-filter: blur(16px) saturate(145%);
        text-decoration: none;
        animation: educationConsultFloat 3.2s ease-in-out infinite;
    }

    .education-visual-consult:hover {
        color: #111827;
    }

    .education-visual-consult-icon {
        width: 32px;
        height: 32px;
        flex: 0 0 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f3f1f8;
        color: #102f55;
        font-size: .95rem;
        font-weight: 900;
    }

    .education-visual-consult-text {
        flex: 1;
        min-width: 0;
        font-size: .78rem;
        font-weight: 900;
        line-height: 1.25;
    }

    .education-visual-consult-arrow {
        color: #263f67;
        font-size: .9rem;
    }

    @keyframes educationGlowPulse {
        0%, 100% {
            transform: scale(.96);
            opacity: .72;
        }
        50% {
            transform: scale(1.06);
            opacity: 1;
        }
    }

    @keyframes educationCenterFloat {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-8px);
        }
    }

    @keyframes educationStatFloat {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-7px);
        }
    }

    @keyframes educationConsultFloat {
        0%, 100% {
            transform: translateY(-50%);
        }
        50% {
            transform: translateY(calc(-50% - 7px));
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .education-visual-glow,
        .education-visual-center,
        .education-visual-stat,
        .education-visual-consult {
            animation: none !important;
        }
    }

    .education-discovery-btn {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 216px;
        min-height: 84px;
        padding: 15px 24px;
        background: linear-gradient(135deg, #433894 0%, #7957c2 100%);
        color: #fff;
        border-radius: 52px 0 52px 0;
        box-shadow: 12px 14px 22px rgba(44, 30, 76, .22);
        text-decoration: none;
        text-align: center;
        font-size: 1rem;
        font-weight: 800;
        line-height: 1.2;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .education-discovery-btn:hover {
        color: #fff;
        transform: translateY(-4px);
        box-shadow: 14px 18px 28px rgba(44, 30, 76, .28);
    }

    .education-discovery-items {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .education-discovery-item {
        min-height: 145px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #e7e2ee;
        border-radius: 16px;
        color: #111827;
        text-decoration: none;
        box-shadow: 0 8px 22px rgba(46, 30, 107, .07);
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
    }

    .education-discovery-item:hover {
        color: #111827;
        transform: translateY(-4px);
        border-color: #d5cce5;
        box-shadow: 0 14px 28px rgba(46, 30, 107, .12);
    }

    .education-discovery-item-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #edf3fa;
        color: var(--gp-purple);
        font-size: 1.15rem;
    }

    .education-discovery-item-content strong {
        display: block;
        margin-top: 14px;
        color: #111827;
        font-size: .94rem;
        font-weight: 800;
    }

    .education-discovery-item-content small {
        display: block;
        margin-top: 4px;
        color: #737887;
        font-size: .7rem;
        line-height: 1.35;
    }

    .education-discovery-item-arrow {
        align-self: flex-end;
        color: #493996;
        font-size: .95rem;
    }

    @media (max-width: 991.98px) {
        .education-discovery-layout {
            grid-template-columns: minmax(0, 1fr) 300px;
            gap: 35px;
        }

        .education-discovery-visual {
            min-height: 320px;
        }

        .education-visual-orbit {
            width: 245px;
            height: 245px;
        }

        .education-visual-glow {
            width: 210px;
            height: 210px;
        }

        .education-visual-center {
            width: 104px;
            height: 104px;
        }

        .education-visual-center i {
            font-size: 2.9rem;
        }

        .education-visual-stat {
            min-width: 92px;
            padding: 9px 10px;
        }

        .education-visual-consult {
            right: -8px;
            min-width: 185px;
        }

        .education-discovery-actions {
            gap: 18px;
        }

        .education-discovery-btn {
            width: 190px;
            min-height: 76px;
        }
    }

    @media (max-width: 767.98px) {
        .education-discovery-section {
            padding: 42px 0;
        }

        .education-discovery-visual {
            min-height: 330px;
            margin-top: 0;
        }

        .education-visual-orbit {
            width: 230px;
            height: 230px;
        }

        .education-visual-glow {
            width: 195px;
            height: 195px;
        }

        .education-visual-center {
            width: 96px;
            height: 96px;
        }

        .education-visual-center i {
            font-size: 2.65rem;
        }

        .education-visual-stat {
            min-width: 88px;
            padding: 8px 9px;
        }

        .education-visual-stat strong {
            font-size: .95rem;
        }

        .education-visual-stat span {
            font-size: .56rem;
        }

        .education-visual-stat.programs {
            top: 18px;
            left: 2px;
        }

        .education-visual-stat.universities {
            top: 16px;
            right: 2px;
        }

        .education-visual-stat.colleges {
            bottom: 38px;
            left: 4px;
        }

        .education-visual-stat.online {
            bottom: 28px;
            right: 4px;
        }

        .education-visual-consult {
            right: 50%;
            top: auto;
            bottom: -2px;
            transform: translateX(50%);
            min-width: 205px;
        }

        .education-discovery-layout {
            grid-template-columns: 1fr;
            gap: 38px;
        }

        .education-discovery-copy {
            max-width: 100%;
        }

        .education-discovery-title {
            font-size: 2.25rem;
        }

        .education-discovery-text {
            font-size: .88rem;
            line-height: 1.65;
        }

        .education-discovery-actions {
            gap: 12px;
            margin-top: 30px;
        }

        .education-discovery-btn {
            flex: 1;
            width: auto;
            min-height: 70px;
            padding: 12px 10px;
            font-size: .82rem;
        }

        .education-phone-wrap {
            min-height: 390px;
        }

        .education-phone {
            width: 260px;
            height: 440px;
            border-radius: 34px;
        }

        .education-phone-card img {
            height: 130px;
        }
    }

    @media (max-width: 767.98px) {
        .education-discovery-items {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .education-discovery-item {
            min-height: 130px;
            padding: 16px;
        }

        .education-discovery-item-content strong {
            font-size: .86rem;
        }

        .education-discovery-item-content small {
            font-size: .65rem;
        }
    }

    @media (max-width: 575.98px) {
        .education-discovery-label {
            font-size: .78rem;
        }

        .education-discovery-title {
            font-size: 2rem;
        }

        .education-discovery-line {
            width: 190px;
            margin: 15px 0 20px;
        }

        .education-discovery-actions {
            margin-top: 25px;
        }

        .education-discovery-btn {
            min-height: 64px;
            border-radius: 38px 0 38px 0;
            font-size: .75rem;
        }

        .education-phone {
            width: 235px;
            height: 400px;
        }

        .education-phone-card {
            margin-top: 25px;
        }

        .education-phone-card img {
            height: 112px;
        }

        .education-phone-card strong {
            font-size: .74rem;
        }
    }

    /* =========================================================
       4. SECTION HEADINGS
       ========================================================= */
    .section-title {
        color: var(--gp-purple);
        font-weight: 800;
        letter-spacing: -0.3px;
    }

    .section-subtitle {
        color: #777;
        font-size: 0.9rem;
    }

    .section-link {
        color: var(--gp-purple);
        border-color: var(--gp-purple);
        font-weight: 700;
        border-radius: 8px;
    }

    .section-link:hover {
        background: var(--gp-purple);
        color: #ffffff;
    }

    /* =========================================================
       5. COLLEGE CARDS
       ========================================================= */
    .college-grid-section {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 8% 18%, rgba(78, 119, 190, .13), transparent 22%),
            radial-gradient(circle at 92% 78%, rgba(220, 160, 0, .10), transparent 20%),
            linear-gradient(135deg, #f7f9fd 0%, #ffffff 48%, #f5f8fc 100%);
    }

    .college-grid-section::before,
    .college-grid-section::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .college-grid-section::before {
        width: 280px;
        height: 280px;
        top: -125px;
        right: -70px;
        border: 1px solid rgba(255, 255, 255, .85);
        background:
            radial-gradient(circle at 35% 30%, rgba(255,255,255,.72), rgba(201,219,245,.20) 55%, transparent 72%);
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.9),
            0 20px 50px rgba(0,31,89,.06);
        animation: collegeBgFloat 7s ease-in-out infinite;
    }

    .college-grid-section::after {
        width: 190px;
        height: 190px;
        bottom: -85px;
        left: -55px;
        border: 1px solid rgba(255, 255, 255, .8);
        background: rgba(220, 231, 248, .30);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.85);
        animation: collegeBgFloatReverse 8s ease-in-out infinite;
    }

    .college-grid-section > .container {
        position: relative;
        z-index: 2;
    }

    /* =========================================================
       TOP COLLEGES — HORIZONTAL SCROLL / MOBILE FRIENDLY
       ========================================================= */
    .top-colleges-scroll {
        display: flex;
        flex-wrap: nowrap;
        gap: 20px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 4px 4px 18px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }

    .top-colleges-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .top-colleges-scroll::-webkit-scrollbar-thumb {
        background: #cfc8df;
        border-radius: 20px;
    }

    .top-college-item {
        flex: 0 0 calc(25% - 15px);
        min-width: 260px;
        scroll-snap-align: start;
    }

    .college-card {
        border-radius: 20px;
        box-shadow: 0 6px 20px rgba(32, 25, 48, 0.07);
        transition: transform .28s ease, box-shadow .28s ease;
    }

    .college-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(32, 25, 48, 0.14);
    }

    .college-image-wrapper {
        height: 175px;
    }

    .college-card-img {
        height: 175px;
    }

    .top-colleges-scroll .college-card-body {
        padding: 40px 18px 17px;
    }

    .top-colleges-scroll .college-name {
        font-size: 1rem;
    }

    .top-college-scroll-hint {
        display: none;
        color: #7b7488;
        font-size: .76rem;
        font-weight: 700;
        align-items: center;
        gap: 5px;
    }

    @media (max-width: 991.98px) {
        .top-college-item {
            flex-basis: 42%;
        }
    }

    @media (max-width: 575.98px) {
        .top-colleges-scroll {
            gap: 14px;
            margin-right: -12px;
            padding-right: 18px;
        }

        .top-college-item {
            flex: 0 0 78%;
            min-width: 0;
        }

        .top-college-scroll-hint {
            display: inline-flex;
        }

        .top-colleges-scroll .college-image-wrapper,
        .top-colleges-scroll .college-card-img {
            height: 160px;
        }
    }

    .online-section {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 88% 16%, rgba(116, 89, 194, .18), transparent 23%),
            radial-gradient(circle at 12% 86%, rgba(82, 137, 207, .13), transparent 22%),
            linear-gradient(135deg, #f4f1fb 0%, #ffffff 50%, #f0f5fb 100%);
    }

    .online-section::before,
    .online-section::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .online-section::before {
        width: 310px;
        height: 310px;
        right: -110px;
        top: -145px;
        border: 1px solid rgba(255,255,255,.86);
        background:
            radial-gradient(circle at 35% 30%, rgba(255,255,255,.78), rgba(185,169,230,.22) 55%, transparent 74%);
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.95),
            0 22px 55px rgba(72, 48, 126, .08);
        animation: collegeBgFloat 8s ease-in-out infinite;
    }

    .online-section::after {
        width: 220px;
        height: 220px;
        left: -75px;
        bottom: -105px;
        border: 1px solid rgba(255,255,255,.82);
        background:
            radial-gradient(circle at 65% 35%, rgba(255,255,255,.72), rgba(178,205,239,.22) 58%, transparent 76%);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
        animation: collegeBgFloatReverse 9s ease-in-out infinite;
    }

    .online-section > .container {
        position: relative;
        z-index: 2;
    }

    @keyframes collegeBgFloat {
        0%, 100% {
            transform: translate3d(0, 0, 0) scale(1);
        }
        50% {
            transform: translate3d(-10px, 10px, 0) scale(1.04);
        }
    }

    @keyframes collegeBgFloatReverse {
        0%, 100% {
            transform: translate3d(0, 0, 0) scale(1);
        }
        50% {
            transform: translate3d(12px, -8px, 0) scale(1.05);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .college-grid-section::before,
        .college-grid-section::after,
        .online-section::before,
        .online-section::after {
            animation: none !important;
        }
    }

    .college-card {
        background: #ffffff;
        border: 0;
        border-radius: 24px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 8px 24px rgba(32, 25, 48, 0.08);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }

    .college-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 35px rgba(32, 25, 48, 0.14);
        color: inherit;
    }

    .college-image-wrapper {
        height: 165px;
        width: 100%;
        position: relative;
    }

    .college-card-img {
        width: 100%;
        height: 165px;
        object-fit: cover;
        display: block;
        border-radius: 24px 24px 0 0;
    }

    .college-image-wrapper::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -1px;
        height: 34px;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.95));
        pointer-events: none;
    }

    .college-logo-wrapper {
        position: absolute;
        left: 20px;
        bottom: -35px;
        width: 72px;
        height: 72px;
        background: #ffffff;
        border-radius: 50%;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 5;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
    }

    .college-logo {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 50%;
        display: block;
        background: #ffffff;
    }

    .college-type-pill {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(0, 0, 0, 0.72);
        color: #ffffff;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        backdrop-filter: blur(4px);
        z-index: 3;
    }

    .college-type-pill.online {
        background: rgba(25, 135, 84, 0.92);
    }

    .college-card-body {
        padding: 42px 18px 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .college-name {
        color: var(--gp-purple);
        font-size: 1rem;
        line-height: 1.45;
        font-weight: 700;
        margin: 0 0 12px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        min-height: 46px;
    }

    .college-info {
        margin-top: auto;
    }

    .college-info-row {
        min-height: 38px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #E6E4E8;
        color: #44404A;
        font-size: 0.82rem;
        line-height: 1.35;
    }

    .college-info-row:last-child {
        border-bottom: 0;
    }

    .college-info-icon {
        width: 18px;
        min-width: 18px;
        text-align: center;
        color: #475569;
        font-size: 0.9rem;
    }

    .college-info-text {
        min-width: 0;
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* =========================================================
       6. 🏙️ TOP CITIES — SIMPLE CLEAN UI
       ========================================================= */
    .cities-grid {
        margin-top: 22px;
    }

    .cities-heading {
        text-align: center;
        margin-bottom: 24px;
    }

    .cities-heading .section-title {
        color: #111827;
        font-size: 1.45rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .cities-heading-line {
        width: 255px;
        height: 1px;
        background: #222;
        margin: 0 auto;
        position: relative;
    }

    .cities-heading-line::after {
        content: "";
        position: absolute;
        width: 60px;
        height: 4px;
        background: #222;
        left: 50%;
        top: -2px;
        transform: translateX(-50%);
    }

    .city-card-btn {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 100px;
        padding: 14px 12px;
        background: #ffffff;
        border: 1px solid #e5e5e5;
        border-radius: 20px;
        text-decoration: none;
        color: #111111;
        text-align: center;
        overflow: hidden;
        transition: transform .25s ease, border-color .25s ease,
            box-shadow .25s ease, color .25s ease;
    }

    .city-card-image {
        position: relative;
        z-index: 2;
        width: 42px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 8px;
    }

    .city-card-image img.city-real-image {
        display: block !important;
        width: 42px !important;
        height: 38px !important;
        max-width: 100%;
        object-fit: cover;
        border-radius: 8px;
        visibility: visible !important;
        opacity: 1 !important;
    }

    .city-icon-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9b8b9b;
        font-size: 1.75rem;
    }

    .city-card-body {
        position: relative;
        z-index: 2;
        min-height: auto;
        padding: 0;
        display: block;
    }

    .city-card-name {
        font-size: .96rem;
        font-weight: 500;
        line-height: 1.2;
    }

    .city-card-arrow {
        display: none;
    }

    .city-card-btn:hover {
        transform: translateY(-3px);
        border-color: #d8d2e2;
        box-shadow: 0 10px 22px rgba(75, 46, 131, .10);
        color: #111111;
    }

    .city-card-btn>* {
        position: relative;
        z-index: 2;
    }

    @media (max-width: 575.98px) {
        .cities-grid {
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            padding: 3px 4px 14px;
            margin-right: -12px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .cities-grid .col {
            flex: 0 0 220px;
            scroll-snap-align: start;
        }

        .cities-heading .section-title {
            font-size: 1.25rem;
        }
    }

    /* =========================================================
       7. 🎯 GD / PI — AD STYLE PROMO BANNER
       Compact • premium • conversion focused
       ========================================================= */
    .gd-pi-ad {
        position: relative;
        overflow: hidden;
        min-height: 205px;
        padding: 28px 32px;
        border: 1px solid #e5def4;
        border-radius: 22px;
        background:
            radial-gradient(circle at 92% 20%, rgba(245, 166, 35, .16), transparent 28%),
            linear-gradient(105deg, #f3f7fc 0%, #ffffff 55%, #fff9e9 100%);
        box-shadow: 0 12px 30px rgba(46, 30, 107, .09);
    }

    .gd-pi-ad::before {
        content: "";
        position: absolute;
        width: 250px;
        height: 250px;
        right: -105px;
        top: -125px;
        border-radius: 50%;
        background: rgba(75, 46, 131, .07);
        pointer-events: none;
    }

    .gd-pi-ad-content {
        position: relative;
        z-index: 2;
    }

    .gd-pi-ad-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 11px;
        margin-bottom: 10px;
        border-radius: 999px;
        background: #edf4fb;
        border: 1px solid #d7e3ef;
        color: var(--gp-purple);
        font-size: .72rem;
        font-weight: 800;
    }

    .gd-pi-ad-title {
        margin: 0 0 7px;
        color: #24185c;
        font-size: clamp(1.35rem, 2.6vw, 2rem);
        line-height: 1.18;
        font-weight: 800;
        letter-spacing: -.025em;
    }

    .gd-pi-ad-text {
        max-width: 650px;
        margin: 0 0 16px;
        color: #686276;
        font-size: .86rem;
        line-height: 1.5;
    }

    .gd-pi-ad-points {
        display: flex;
        flex-wrap: wrap;
        gap: 7px 16px;
        margin-bottom: 17px;
    }

    .gd-pi-ad-point {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #3f4b59;
        font-size: .72rem;
        font-weight: 700;
    }

    .gd-pi-ad-point i {
        color: #198754;
        font-size: .78rem;
    }

    .gd-pi-ad-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 42px;
        padding: 9px 18px;
        border: 0;
        border-radius: 999px;
        background: linear-gradient(135deg, #3e2a80, #174B8F);
        color: #fff;
        font-size: .82rem;
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(62, 42, 128, .20);
        transition: transform .22s ease, box-shadow .22s ease;
    }

    .gd-pi-ad-cta:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(62, 42, 128, .28);
    }

    .gd-pi-ad-visual {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 145px;
    }

    .gd-pi-ad-card {
        width: 150px;
        height: 150px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border-radius: 24px;
        background: linear-gradient(145deg, #2e1e6b, #64429d);
        color: #fff;
        box-shadow: 0 15px 30px rgba(46, 30, 107, .20);
        transform: rotate(3deg);
    }

    .gd-pi-ad-card i {
        font-size: 2.8rem;
        color: #f5a623;
    }

    .gd-pi-ad-card strong {
        font-size: 1.05rem;
        line-height: 1;
    }

    .gd-pi-ad-card span {
        font-size: .68rem;
        opacity: .78;
    }

    @media (max-width: 991.98px) {
        .gd-pi-ad {
            padding: 24px;
        }

        .gd-pi-ad-visual {
            min-height: 120px;
        }

        .gd-pi-ad-card {
            width: 125px;
            height: 125px;
        }
    }

    @media (max-width: 767.98px) {
        .gd-pi-ad {
            min-height: auto;
            padding: 21px 17px;
            border-radius: 18px;
        }

        .gd-pi-ad-title {
            font-size: 1.3rem;
        }

        .gd-pi-ad-text {
            font-size: .76rem;
            margin-bottom: 13px;
        }

        .gd-pi-ad-points {
            gap: 6px 12px;
            margin-bottom: 15px;
        }

        .gd-pi-ad-point {
            font-size: .67rem;
        }

        .gd-pi-ad-cta {
            width: 100%;
            justify-content: center;
            min-height: 42px;
        }

        .gd-pi-ad-visual {
            display: none;
        }
    }

    /* =========================================================
       8. ADVISOR CALL STRIP
       ========================================================= */
    .advisor-call-strip {
        background: linear-gradient(135deg, #001F59 0%, #00163F 100%);
        color: #ffffff;
        border-radius: 18px;
        padding: 25px 30px;
        text-align: center;
    }

    .btn-call-gold {
        background: var(--gp-gold);
        color: #17120a;
        font-weight: 800;
        border-radius: 30px;
        padding: 10px 28px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-size: 1.05rem;
        transition: all 0.2s ease;
    }

    .btn-call-gold:hover {
        background: var(--gp-gold-hover);
        color: #17120a;
        transform: scale(1.02);
    }

    /* =========================================================
       9. FEATURE PROPOSITIONS
       ========================================================= */
    /* =========================================================
       8. ✨ WHY CHOOSE GROWPEC — REDESIGNED
       ========================================================= */
    .why-growpec-section {
        position: relative;
        overflow: hidden;
        background: linear-gradient(115deg, #43388f 0%, #604bb0 52%, #8a62c5 100%);
    }

    .why-growpec-section::before {
        content: "";
        position: absolute;
        width: 420px;
        height: 420px;
        left: -220px;
        top: -230px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .06);
    }

    .why-growpec-section::after {
        content: "";
        position: absolute;
        width: 380px;
        height: 380px;
        right: -200px;
        bottom: -230px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .06);
    }

    .why-growpec-inner {
        position: relative;
        z-index: 2;
    }

    .why-growpec-title {
        color: #ffffff;
        font-size: clamp(1.9rem, 4vw, 2.6rem);
        font-weight: 800;
        margin-bottom: 13px;
    }

    .why-growpec-line {
        width: 255px;
        height: 1px;
        background: rgba(255, 255, 255, .8);
        margin: 0 auto 28px;
        position: relative;
    }

    .why-growpec-line::after {
        content: "";
        position: absolute;
        width: 60px;
        height: 4px;
        background: #ffffff;
        left: 50%;
        top: -2px;
        transform: translateX(-50%);
    }

    .why-feature-card {
        position: relative;
        overflow: hidden;
        min-height: 136px;
        background: #ffffff;
        border: 0;
        border-radius: 4px;
        padding: 27px 24px 22px;
        text-align: center;
        box-shadow: 0 8px 20px rgba(25, 15, 65, .10);
        transition: transform .28s ease, box-shadow .28s ease;
    }

    /* Small top-right corner fill, like the reference design */
    .why-feature-card::before {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        top: -95px;
        right: -95px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gp-purple-dark), #174B8F);
        transform: scale(0);
        transform-origin: top right;
        transition: transform .42s cubic-bezier(.2, .75, .25, 1);
        z-index: 0;
    }

    .why-feature-card::after {
        content: "↗";
        position: absolute;
        top: 0px;
        right: 0px;
        width: 21px;
        height: 21px;
        border-bottom-left-radius: 25%;
        border-top-left-radius: 25%;
        border-bottom-right-radius: 25%;
        color: #ffffff;
        /* changed */
        font-size: 20px;
        line-height: 21px;
        z-index: 3;
        background-color: #00163F;
    }

    .why-feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(25, 15, 65, .18);
    }

    .why-feature-card:hover::before {
        transform: scale(3.5);
    }

    .why-feature-card:hover::after {
        transform: rotate(12deg) scale(1.08);
    }

    .why-feature-icon {
        display: none;
    }

    .why-feature-card h5 {
        position: relative;
        z-index: 2;
        color: #111827;
        font-size: 1.08rem;
        font-weight: 800;
        margin: 0 0 8px;
        transition: color .25s ease;
    }

    .why-feature-card p {
        position: relative;
        z-index: 2;
        color: #111111;
        font-size: .88rem;
        line-height: 1.4;
        margin: 0 auto;
        max-width: 270px;
        transition: color .25s ease;
    }

    .why-feature-card:hover h5 {
        color: #ffffff;
    }

    .why-feature-card:hover p {
        color: rgba(255, 255, 255, .82);
    }

    @media (max-width: 767.98px) {
        .why-feature-card {
            min-height: 145px;
            padding: 25px 18px 20px;
        }

        .why-feature-card h5 {
            font-size: 1rem;
        }

        .why-feature-card p {
            font-size: .82rem;
        }
    }

    @media (max-width: 991.98px) {
        .hero-banner-img {
            height: 50vh;
            min-height: 320px;
        }

        .gd-pi-banner {
            padding: 25px;
        }
    }

    @media (max-width: 575.98px) {
        .hero-banner-img {
            height: 38vh;
            min-height: 220px;
        }
    }


    /* =========================================================
       FINAL RESPONSIVE UI
       Desktop • Laptop • Tablet • Mobile
       ========================================================= */

    html,
    body {
        max-width: 100%;
        overflow-x: hidden;
    }

    .admission-hero-section,
    .partner-strip-section,
    .program-section,
    .college-grid-section,
    .online-section,
    .cities-grid,
    .why-growpec-section {
        max-width: 100%;
        overflow-x: hidden;
    }

    /* Laptop */
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .admission-hero-section {
            padding: 38px 0 34px;
        }

        .admission-hero-title {
            font-size: 2.45rem;
        }

        .admission-search-box {
            max-width: 700px;
        }

        .program-card {
            min-height: 140px;
        }
    }

    /* Tablet */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .admission-hero-section {
            padding: 34px 0 30px;
        }

        .admission-hero-title {
            font-size: 2.15rem;
        }

        .admission-hero-subtitle {
            font-size: .92rem;
            padding: 0 20px;
        }

        .admission-search-box {
            max-width: 680px;
        }

        .program-card {
            min-height: 140px;
        }

        .top-college-item {
            flex-basis: 46%;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {
        .admission-hero-section {
            padding: 27px 0 25px;
        }

        .admission-badge {
            font-size: .7rem;
            padding: 6px 11px;
            margin-bottom: 10px;
        }

        .admission-hero-title {
            font-size: clamp(1.5rem, 7vw, 2rem);
            line-height: 1.18;
            margin-bottom: 9px;
        }

        .admission-hero-subtitle {
            font-size: .8rem;
            line-height: 1.55;
            padding: 0;
            margin-bottom: 16px;
        }

        .admission-search-box {
            width: 100%;
            padding: 6px;
            border-radius: 12px;
        }

        .admission-search-box .input-group {
            flex-direction: column;
            gap: 7px;
        }

        .admission-search-input {
            width: 100%;
            height: 44px;
            min-height: 44px;
            font-size: .82rem;
            border-radius: 9px !important;
        }

        .admission-search-btn {
            width: 100%;
            height: 43px;
            padding: 0 14px;
            border-radius: 9px;
            font-size: .8rem;
        }

        .home-live-search-dropdown {
            left: 0;
            right: 0;
            max-height: 300px;
            border-radius: 11px;
        }

        .home-live-search-dropdown .live-search-item {
            padding: 10px 11px;
        }

        .home-live-search-dropdown .live-search-name {
            font-size: .76rem;
        }

        .home-live-search-dropdown .live-search-meta {
            font-size: .66rem;
        }

        .success-rate {
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 14px;
            font-size: .74rem;
        }

        .success-rate strong {
            font-size: .96rem;
        }

        /* Partner marquee */
        .partner-strip-section {
            padding: 14px 0;
        }

        .partner-marquee-track {
            gap: 18px;
            animation-duration: 24s;
        }

        .partner-logo-pill {
            min-width: 125px;
            min-height: 72px;
            padding: 8px 10px;
            gap: 5px;
        }

        .partner-logo-pill i {
            font-size: 22px;
        }

        .partner-logo-pill span {
            font-size: 10.5px;
        }

        /* Program cards */
        .program-grid {
            margin-top: 20px;
        }

        .program-card {
            min-height: 128px;
            padding: 16px 14px;
            border-radius: 15px;
        }

        .program-icon-wrap {
            width: 41px;
            height: 41px;
            border-radius: 11px;
            font-size: 1.08rem;
        }

        .program-name {
            font-size: .84rem;
            margin-top: 10px;
        }

        .program-meta {
            font-size: .67rem;
        }

        .program-arrow {
            right: 12px;
            bottom: 12px;
            width: 26px;
            height: 26px;
        }

        /* College horizontal scroll */
        .top-colleges-scroll {
            gap: 12px;
            margin-right: -14px;
            padding: 3px 16px 16px 2px;
        }

        .top-college-item {
            flex: 0 0 82%;
            min-width: 0;
        }

        .college-card {
            border-radius: 18px;
        }

        .college-image-wrapper,
        .college-card-img {
            height: 150px;
        }

        .college-card-img {
            border-radius: 18px 18px 0 0;
        }

        .college-logo-wrapper {
            left: 14px;
            bottom: -29px;
            width: 60px;
            height: 60px;
        }

        .college-card-body,
        .top-colleges-scroll .college-card-body {
            padding: 36px 14px 14px;
        }

        .college-name {
            font-size: .86rem;
            min-height: 40px;
            margin-bottom: 8px;
        }

        .college-info-row {
            min-height: 33px;
            gap: 8px;
            font-size: .71rem;
        }

        .college-info-icon {
            font-size: .76rem;
        }

        /* Cities horizontal scroll */
        .cities-grid {
            flex-wrap: nowrap;
            gap: 10px;
            margin-right: -14px;
            padding: 3px 16px 14px 3px;
            overflow-x: auto;
            overflow-y: hidden;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .cities-grid .col {
            flex: 0 0 175px;
            scroll-snap-align: start;
        }

        .city-card-btn {
            min-height: 86px;
            padding: 11px 9px;
            border-radius: 16px;
        }

        .city-icon-badge {
            font-size: 1.4rem;
        }

        .city-card-name {
            font-size: .82rem;
        }

        .cities-heading {
            margin-bottom: 17px;
        }

        .cities-heading .section-title {
            font-size: 1.12rem;
        }

        .cities-heading-line {
            width: 185px;
        }

        /* Banners */
        .gd-pi-banner {
            border-radius: 18px;
            padding: 24px 17px;
        }

        .advisor-call-strip {
            border-radius: 15px;
            padding: 20px 14px;
        }

        .btn-call-gold {
            width: 100%;
            justify-content: center;
            font-size: .9rem;
        }
    }

    /* Small mobile */
    @media (max-width: 575.98px) {
        .program-grid .col-6 {
            width: 50%;
        }

        .program-card {
            min-height: 122px;
            padding: 14px 12px;
        }

        .program-card::before {
            width: 150px;
            height: 150px;
            top: -80px;
            right: -80px;
        }

        .program-card:hover::before {
            transform: scale(3.6);
        }

        .top-college-item {
            flex-basis: 85%;
        }

        .college-image-wrapper,
        .college-card-img {
            height: 142px;
        }

        .gd-pi-banner {
            padding: 20px 14px;
        }
    }

    /* Very small phones */
    @media (max-width: 380px) {
        .admission-hero-title {
            font-size: 1.42rem;
        }

        .admission-hero-subtitle {
            font-size: .75rem;
        }

        .program-card {
            min-height: 116px;
        }

        .program-name {
            font-size: .77rem;
        }

        .program-meta {
            font-size: .63rem;
        }

        .top-college-item {
            flex-basis: 89%;
        }

        .cities-grid .col {
            flex-basis: 160px;
        }
    }

    /* Touch screens */
    @media (hover: none) and (pointer: coarse) {

        .program-card:hover,
        .college-card:hover,
        .city-card-btn:hover {
            transform: none;
        }
    }



    /* =========================================================
       COLLEGE SECTIONS — PREMIUM UI REDESIGN
       ========================================================= */
    .college-grid-section,
    .online-section {
        position: relative;
        padding-top: 68px !important;
        padding-bottom: 68px !important;
        overflow: hidden;
    }

    .college-grid-section {
        background: #ffffff;
    }

    .online-section {
        background: linear-gradient(180deg, #faf8ff 0%, #f5f1ff 100%);
    }

    .college-grid-section::before,
    .online-section::before {
        content: "";
        position: absolute;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        background: rgba(88, 58, 160, .055);
        top: -180px;
        right: -120px;
        pointer-events: none;
    }

    .college-grid-section .container,
    .online-section .container {
        position: relative;
        z-index: 1;
    }

    .college-grid-section .d-flex,
    .online-section .d-flex {
        align-items: center !important;
        margin-bottom: 34px !important;
    }

    .college-grid-section .badge,
    .online-section .badge {
        display: none;
    }

    .college-grid-section .section-title,
    .online-section .section-title {
        position: relative;
        display: inline-block;
        margin: 0 !important;
        color: #111827;
        font-size: clamp(1.8rem, 3vw, 2.45rem);
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -.035em;
    }

    .college-grid-section .section-title::after,
    .online-section .section-title::after {
        content: none !important;
        display: none !important;
    }

    /* Use the same heading line style as Top Cities */
    .college-grid-section .cities-heading-line {
        width: 255px;
        height: 1px;
        background: #222;
        margin: 0 auto;
        position: relative;
    }

    .college-grid-section .cities-heading-line::after {
        content: "";
        position: absolute;
        width: 60px;
        height: 4px;
        background: #222;
        left: 50%;
        top: -2px;
        transform: translateX(-50%);
    }

    .college-grid-section .d-flex>div:first-child,
    .online-section .d-flex>div:first-child {
        width: 100%;
        text-align: center;
    }

    .college-grid-section .section-link,
    .online-section .section-link {
        flex: 0 0 auto;
        min-width: 122px;
        min-height: 44px;
        border: 0 !important;
        border-radius: 999px !important;
        background: linear-gradient(135deg, #001F59, #174B8F) !important;
        color: #fff !important;
        font-size: .9rem;
        font-weight: 700;
        padding: 10px 20px !important;
        box-shadow: 0 8px 22px rgba(76, 51, 145, .20);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .college-grid-section .section-link:hover,
    .online-section .section-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(76, 51, 145, .28);
    }

    /* Regular colleges: 3-column desktop carousel */
    .top-colleges-scroll {
        gap: 26px;
        padding: 8px 4px 24px;
        scrollbar-width: none;
    }

    .top-colleges-scroll::-webkit-scrollbar {
        display: none;
    }

    .top-college-item {
        flex: 0 0 calc((100% - 52px) / 3);
        min-width: 0;
    }

    /* Online colleges: same visual carousel language */
    .online-section .college-grid {
        display: flex;
        flex-wrap: nowrap;
        gap: 26px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 8px 4px 24px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .online-section .college-grid::-webkit-scrollbar {
        display: none;
    }

    .online-section .college-grid>div {
        flex: 0 0 calc((100% - 52px) / 3);
        min-width: 0;
        scroll-snap-align: start;
    }

    .college-card {
        border: 1px solid rgba(65, 49, 105, .07);
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 12px 30px rgba(35, 25, 58, .09);
        overflow: hidden;
        transform: translateY(0);
        transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }

    .college-card:hover {
        transform: translateY(-8px);
        border-color: rgba(93, 64, 163, .15);
        box-shadow: 0 20px 42px rgba(35, 25, 58, .15);
    }

    .college-image-wrapper,
    .college-card-img {
        height: 178px;
    }

    .college-image-wrapper {
        background: #eeeaf7;
    }

    .college-card-img {
        width: 100%;
        object-fit: cover;
        transition: transform .45s ease;
    }

    .college-card:hover .college-card-img {
        transform: scale(1.035);
    }

    .college-image-wrapper::after {
        height: 44px;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, .98));
    }

    .college-logo-wrapper {
        left: 20px;
        bottom: -36px;
        width: 76px;
        height: 76px;
        border: 5px solid #fff;
        padding: 5px;
        box-shadow: 0 8px 20px rgba(30, 22, 48, .14);
    }

    .college-type-pill {
        top: 14px;
        left: 14px;
        border-radius: 999px;
        padding: 6px 11px;
        font-size: .68rem;
        letter-spacing: .01em;
    }

    .college-card-body,
    .top-colleges-scroll .college-card-body {
        padding: 47px 20px 19px;
    }

    .college-name {
        color: #40308a;
        font-size: 1.04rem;
        line-height: 1.42;
        margin-bottom: 13px;
        min-height: 47px;
    }

    .college-info-row {
        min-height: 40px;
        gap: 10px;
        color: #45414d;
        font-size: .82rem;
        border-bottom-color: #ece9ef;
    }

    .college-info-icon {
        width: 19px;
        min-width: 19px;
        font-size: .88rem;
    }

    .top-college-scroll-hint {
        display: inline-flex;
        margin: 9px auto 0;
        color: #817b8c;
        font-size: .74rem;
    }

    .online-section .college-card {
        background: rgba(255, 255, 255, .92);
    }

    @media (max-width: 1199.98px) {

        .top-college-item,
        .online-section .college-grid>div {
            flex-basis: calc((100% - 26px) / 2);
        }
    }

    @media (max-width: 767.98px) {

        .college-grid-section,
        .online-section {
            padding-top: 48px !important;
            padding-bottom: 48px !important;
        }

        .college-grid-section .d-flex,
        .online-section .d-flex {
            display: block !important;
            margin-bottom: 24px !important;
            text-align: center;
        }

        .college-grid-section .section-link,
        .online-section .section-link {
            display: inline-flex;
            margin-top: 20px;
            min-height: 42px;
        }

        .top-colleges-scroll,
        .online-section .college-grid {
            gap: 15px;
            margin-right: -12px;
            padding-right: 22px;
        }

        .top-college-item,
        .online-section .college-grid>div {
            flex: 0 0 84%;
        }

        .college-image-wrapper,
        .college-card-img {
            height: 166px;
        }

        .college-card-body,
        .top-colleges-scroll .college-card-body {
            padding: 45px 17px 16px;
        }

        .college-name {
            font-size: .98rem;
        }
    }

    @media (max-width: 399.98px) {

        .top-college-item,
        .online-section .college-grid>div {
            flex-basis: 90%;
        }
    }

    /* =========================================================
   GROWPEC — TOP COLLEGES PREMIUM UI REDESIGN
   Desktop: 4 cards | Laptop: 3 | Tablet: 2 | Mobile: 1
   No clipped first card / no accidental horizontal offset
   ========================================================= */

    .college-grid-section,
    .online-section {
        position: relative;
        overflow: hidden;
    }

    .college-grid-section {
        background:
            radial-gradient(circle at 8% 20%, rgba(117, 80, 196, .055), transparent 28%),
            #fff;
    }

    .online-section {
        background:
            radial-gradient(circle at 92% 15%, rgba(117, 80, 196, .075), transparent 28%),
            linear-gradient(180deg, #faf8ff 0%, #f5f1ff 100%);
    }

    /* Section header */
    .college-grid-section .container,
    .online-section .container {
        position: relative;
        z-index: 2;
    }

    .college-grid-section .d-flex,
    .online-section .d-flex {
        display: block !important;
        text-align: center;
        margin-bottom: 34px !important;
    }

    .college-grid-section .d-flex>div:first-child,
    .online-section .d-flex>div:first-child {
        width: 100%;
    }

    .college-grid-section .badge,
    .online-section .badge {
        display: inline-flex !important;
        align-items: center;
        padding: 7px 13px;
        border-radius: 999px;
        font-size: .72rem;
        letter-spacing: .03em;
        margin-bottom: 12px !important;
    }

    .college-grid-section .section-title,
    .online-section .section-title {
        display: block;
        width: fit-content;
        max-width: 100%;
        margin: 0 auto !important;
        color: #17132a;
        font-size: clamp(1.8rem, 3vw, 2.55rem);
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -.04em;
    }

    .college-grid-section .section-title::after,
    .online-section .section-title::after {
        content: "";
        display: block;
        width: 78px;
        height: 4px;
        margin: 14px auto 0;
        border-radius: 99px;
        background: linear-gradient(90deg, #001F59, #2B6E9E);
    }

    .top-college-scroll-hint {
        display: none !important;
    }

    /* View all button */
    .college-grid-section .section-link,
    .online-section .section-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-width: 132px;
        min-height: 44px;
        margin-top: 20px;
        padding: 10px 22px !important;
        border: 0 !important;
        border-radius: 999px !important;
        background: linear-gradient(135deg, #001F59, #174B8F) !important;
        color: #fff !important;
        font-size: .88rem;
        font-weight: 800;
        box-shadow: 0 9px 24px rgba(75, 46, 131, .20);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .college-grid-section .section-link:hover,
    .online-section .section-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(75, 46, 131, .28);
    }

    /* ---------- Regular: clean 4-column grid ---------- */
    .top-colleges-scroll {
        display: grid !important;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 24px !important;

        width: 100% !important;
        margin: 0 !important;
        padding: 4px 2px 16px !important;

        overflow: visible !important;
        scroll-snap-type: none !important;
    }

    .top-college-item {
        width: 100% !important;
        min-width: 0 !important;
        flex: none !important;
    }

    /* ---------- Online: clean 4-column grid ---------- */
    .online-section .college-grid {
        display: grid !important;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 24px !important;

        width: 100% !important;
        margin: 0 !important;
        padding: 4px 2px 16px !important;

        overflow: visible !important;
        scroll-snap-type: none !important;
    }

    .online-section .college-grid>div {
        width: 100% !important;
        min-width: 0 !important;
        flex: none !important;
        padding: 0 !important;
    }

    /* ---------- Premium card ---------- */
    .top-colleges-scroll .college-card,
    .online-section .college-card {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
        min-height: 405px;

        overflow: hidden;
        background: #fff;
        border: 1px solid rgba(67, 48, 116, .09);
        border-radius: 22px;

        box-shadow:
            0 10px 28px rgba(38, 28, 65, .075),
            0 2px 8px rgba(38, 28, 65, .035);

        text-decoration: none;
        color: inherit;

        transition:
            transform .3s cubic-bezier(.2, .7, .2, 1),
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .top-colleges-scroll .college-card:hover,
    .online-section .college-card:hover {
        transform: translateY(-7px);
        border-color: rgba(75, 46, 131, .18);
        box-shadow:
            0 20px 42px rgba(38, 28, 65, .14),
            0 5px 12px rgba(38, 28, 65, .05);
    }

    /* Image */
    .top-colleges-scroll .college-image-wrapper,
    .online-section .college-image-wrapper {
        position: relative;
        width: 100%;
        height: 180px;
        flex: 0 0 180px;
        overflow: hidden;
        background: #eeeaf7;
    }

    .top-colleges-scroll .college-card-img,
    .online-section .college-card-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
        transition: transform .5s ease;
    }

    .top-colleges-scroll .college-card:hover .college-card-img,
    .online-section .college-card:hover .college-card-img {
        transform: scale(1.055);
    }

    /* Soft image fade */
    .top-colleges-scroll .college-image-wrapper::after,
    .online-section .college-image-wrapper::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 55px;
        background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, .96));
        pointer-events: none;
    }

    /* Type badge */
    .top-colleges-scroll .college-type-pill,
    .online-section .college-type-pill {
        top: 13px;
        left: 13px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: .65rem;
        font-weight: 800;
        backdrop-filter: blur(7px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, .10);
    }

    /* Logo */
    .top-colleges-scroll .college-logo-wrapper,
    .online-section .college-logo-wrapper {
        left: 18px;
        bottom: -36px;
        width: 76px;
        height: 76px;
        padding: 5px;
        border: 4px solid #fff;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 8px 20px rgba(28, 21, 48, .15);
        z-index: 5;
    }

    /* Card body */
    .top-colleges-scroll .college-card-body,
    .online-section .college-card-body {
        padding: 48px 19px 18px !important;
        flex: 1;
    }

    .top-colleges-scroll .college-name,
    .online-section .college-name {
        color: #40308a;
        font-size: .99rem;
        font-weight: 750;
        line-height: 1.42;
        min-height: 45px;
        margin: 0 0 11px;
    }

    /* Info rows */
    .top-colleges-scroll .college-info-row,
    .online-section .college-info-row {
        min-height: 39px;
        gap: 9px;
        border-bottom: 1px solid #ece9ef;
        color: #45414d;
        font-size: .79rem;
    }

    .top-colleges-scroll .college-info-row:last-child,
    .online-section .college-info-row:last-child {
        border-bottom: 0;
    }

    .top-colleges-scroll .college-info-icon,
    .online-section .college-info-icon {
        width: 19px;
        min-width: 19px;
        color: #25212d;
    }

    /* ---------- Laptop ---------- */
    @media (max-width: 1199.98px) {

        .top-colleges-scroll,
        .online-section .college-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px !important;
        }

        .top-colleges-scroll .college-card,
        .online-section .college-card {
            min-height: 400px;
        }
    }

    /* ---------- Tablet ---------- */
    @media (max-width: 991.98px) {

        .college-grid-section,
        .online-section {
            padding-top: 54px !important;
            padding-bottom: 54px !important;
        }

        .top-colleges-scroll,
        .online-section .college-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px !important;
        }

        .top-colleges-scroll .college-image-wrapper,
        .online-section .college-image-wrapper,
        .top-colleges-scroll .college-card-img,
        .online-section .college-card-img {
            height: 170px;
        }
    }

    /* ---------- Mobile ---------- */
    @media (max-width: 767.98px) {

        .college-grid-section,
        .online-section {
            padding-top: 42px !important;
            padding-bottom: 44px !important;
        }

        .college-grid-section .d-flex,
        .online-section .d-flex {
            margin-bottom: 24px !important;
        }

        .college-grid-section .section-title,
        .online-section .section-title {
            font-size: clamp(1.5rem, 7vw, 2rem);
        }

        .college-grid-section .section-title::after,
        .online-section .section-title::after {
            width: 62px;
            height: 3px;
            margin-top: 11px;
        }

        .top-colleges-scroll,
        .online-section .college-grid {
            display: flex !important;
            flex-wrap: nowrap !important;
            gap: 15px !important;

            width: calc(100% + 14px) !important;
            margin: 0 -14px 0 0 !important;
            padding: 4px 18px 17px 2px !important;

            overflow-x: auto !important;
            overflow-y: visible !important;

            scroll-snap-type: x mandatory !important;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }

        .top-colleges-scroll::-webkit-scrollbar,
        .online-section .college-grid::-webkit-scrollbar {
            display: none;
        }

        .top-college-item,
        .online-section .college-grid>div {
            flex: 0 0 86% !important;
            width: 86% !important;
            min-width: 0 !important;
            scroll-snap-align: start;
        }

        .top-colleges-scroll .college-card,
        .online-section .college-card {
            min-height: 390px;
            border-radius: 20px;
        }

        .top-colleges-scroll .college-image-wrapper,
        .online-section .college-image-wrapper,
        .top-colleges-scroll .college-card-img,
        .online-section .college-card-img {
            height: 158px;
        }

        .top-colleges-scroll .college-logo-wrapper,
        .online-section .college-logo-wrapper {
            left: 15px;
            bottom: -31px;
            width: 64px;
            height: 64px;
            border-width: 3px;
        }

        .top-colleges-scroll .college-card-body,
        .online-section .college-card-body {
            padding: 41px 15px 15px !important;
        }

        .top-colleges-scroll .college-name,
        .online-section .college-name {
            font-size: .92rem;
            min-height: 42px;
        }

        .top-colleges-scroll .college-info-row,
        .online-section .college-info-row {
            min-height: 35px;
            font-size: .72rem;
        }

        .college-grid-section .section-link,
        .online-section .section-link {
            min-width: 122px;
            min-height: 41px;
            font-size: .8rem;
            margin-top: 17px;
        }
    }

    /* ---------- Small phones ---------- */
    @media (max-width: 420px) {

        .top-college-item,
        .online-section .college-grid>div {
            flex-basis: 89% !important;
            width: 89% !important;
        }

        .top-colleges-scroll .college-card,
        .online-section .college-card {
            min-height: 375px;
        }

        .top-colleges-scroll .college-image-wrapper,
        .online-section .college-image-wrapper,
        .top-colleges-scroll .college-card-img,
        .online-section .college-card-img {
            height: 148px;
        }
    }

    /* Touch devices: keep the UI stable */
    @media (hover: none) and (pointer: coarse) {

        .top-colleges-scroll .college-card:hover,
        .online-section .college-card:hover {
            transform: none;
        }

        .top-colleges-scroll .college-card:hover .college-card-img,
        .online-section .college-card:hover .college-card-img {
            transform: none;
        }
    }


    /* =========================================================
   VIEW ALL BUTTON — BELOW COLLEGE CARDS
   ========================================================= */

    .college-view-all-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 28px;
        width: 100%;
    }

    .college-view-all-wrap .section-link {
        margin-top: 0 !important;
        min-width: 150px;
        min-height: 48px;
        padding: 11px 28px !important;
        font-size: .9rem;
    }

    @media (max-width: 767.98px) {
        .college-view-all-wrap {
            margin-top: 20px;
        }

        .college-view-all-wrap .section-link {
            min-width: 135px;
            min-height: 44px;
            font-size: .82rem;
        }
    }


    /* =========================================================
   COLLEGE LOGO OVERLAP FIX
   Keep logo correctly layered over the image/card body.
   ========================================================= */

    .college-image-wrapper {
        position: relative;
        z-index: 2;
        overflow: visible !important;
    }

    .college-logo-wrapper {
        position: absolute !important;
        left: 18px !important;
        bottom: -36px !important;
        width: 76px !important;
        height: 76px !important;
        z-index: 20 !important;
        background: #fff !important;
        border: 4px solid #fff !important;
        border-radius: 50% !important;
        padding: 5px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 8px 20px rgba(28, 21, 48, .15) !important;
    }

    .college-logo-wrapper .college-logo {
        position: relative;
        z-index: 21;
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        border-radius: 50%;
        background: #fff;
    }

    .college-card-body {
        position: relative;
        z-index: 1;
    }

    /* The logo must stay in front on mobile too */
    @media (max-width: 767.98px) {
        .college-image-wrapper {
            z-index: 2 !important;
            overflow: visible !important;
        }

        .college-logo-wrapper,
        .top-colleges-scroll .college-logo-wrapper,
        .online-section .college-logo-wrapper {
            left: 15px !important;
            bottom: -31px !important;
            width: 64px !important;
            height: 64px !important;
            z-index: 20 !important;
        }

        .college-card-body,
        .top-colleges-scroll .college-card-body,
        .online-section .college-card-body {
            position: relative;
            z-index: 1;
        }
    }


    /* =========================================================
   GROWPEC — SEARCH BAR REDESIGN
   Desktop • Laptop • Tablet • Mobile
   ========================================================= */

    .admission-search-box {
        position: relative;
        width: min(100%, 820px);
        margin: 0 auto;
        padding: 6px;
        background: rgba(255, 255, 255, .96);
        border: 1px solid #ddd4f4;
        border-radius: 18px;
        box-shadow:
            0 12px 30px rgba(46, 30, 107, .09),
            0 2px 8px rgba(46, 30, 107, .04);
        transition: border-color .22s ease, box-shadow .22s ease, transform .22s ease;
    }

    .admission-search-box:focus-within {
        border-color: #9b7ed8;
        box-shadow:
            0 16px 36px rgba(46, 30, 107, .13),
            0 0 0 4px rgba(75, 46, 131, .07);
        transform: translateY(-1px);
    }

    .admission-search-box .input-group {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
        gap: 6px;
    }

    .admission-search-input {
        height: 52px !important;
        min-width: 0;
        border: 0 !important;
        outline: 0 !important;
        box-shadow: none !important;
        background: transparent !important;
        color: #252035;
        padding: 0 16px 0 43px !important;
        font-size: .96rem;
        font-weight: 500;
        border-radius: 13px !important;
    }

    .admission-search-input::placeholder {
        color: #8b8499;
        opacity: 1;
    }

    .admission-search-input:focus::placeholder {
        opacity: .65;
    }

    .admission-search-box .input-group::before {
        content: "\F52A";
        position: absolute;
        left: 21px;
        top: 50%;
        transform: translateY(-50%);
        font-family: "bootstrap-icons";
        color: #6a4ca3;
        font-size: 1.05rem;
        pointer-events: none;
        z-index: 3;
    }

    .admission-search-btn {
        flex: 0 0 auto;
        height: 52px;
        min-width: 126px;
        border: 0 !important;
        border-radius: 13px !important;
        padding: 0 22px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        background: linear-gradient(135deg, #3d287d 0%, #60409d 100%) !important;
        color: #fff !important;
        font-size: .91rem;
        font-weight: 800;
        box-shadow: 0 7px 16px rgba(61, 40, 125, .20);
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .admission-search-btn:hover {
        background: linear-gradient(135deg, #2e1e6b 0%, #56368f 100%) !important;
        color: #fff !important;
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(61, 40, 125, .26);
    }

    .admission-search-btn:active {
        transform: translateY(0);
    }

    /* Live suggestions */
    .home-live-search-dropdown {
        left: 0 !important;
        right: 0 !important;
        top: calc(100% + 10px) !important;
        border: 1px solid #e3dcf1 !important;
        border-radius: 16px !important;
        box-shadow: 0 20px 45px rgba(46, 30, 107, .15) !important;
    }

    /* Tablet */
    @media (max-width: 991.98px) {
        .admission-search-box {
            width: min(100%, 720px);
        }

        .admission-search-input {
            font-size: .9rem;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {
        .admission-search-box {
            width: 100%;
            padding: 5px;
            border-radius: 15px;
        }

        .admission-search-box .input-group {
            gap: 5px;
        }

        .admission-search-input {
            height: 46px !important;
            padding: 0 10px 0 39px !important;
            font-size: .82rem;
            border-radius: 11px !important;
        }

        .admission-search-box .input-group::before {
            left: 17px;
            font-size: .96rem;
        }

        .admission-search-btn {
            height: 46px;
            min-width: 48px;
            width: 48px;
            padding: 0 !important;
            border-radius: 11px !important;
            gap: 0;
        }

        .admission-search-btn .search-label {
            display: none;
        }

        .admission-search-btn i {
            margin: 0 !important;
            font-size: .95rem;
        }

        .home-live-search-dropdown {
            top: calc(100% + 7px) !important;
            border-radius: 13px !important;
            max-height: 290px;
        }
    }

    /* Small phones */
    @media (max-width: 380px) {
        .admission-search-input {
            font-size: .77rem;
            padding-left: 36px !important;
        }

        .admission-search-box .input-group::before {
            left: 15px;
            font-size: .88rem;
        }

        .admission-search-btn {
            width: 44px;
            min-width: 44px;
            height: 44px;
        }
    }


    /* =========================================================
   SEARCH BAR — MOBILE BUG FIX
   Single icon + single button, never wraps
   ========================================================= */

    .admission-search-box {
        width: min(100%, 820px) !important;
        max-width: 820px !important;
        padding: 6px !important;
        border-radius: 18px !important;
        box-sizing: border-box;
    }

    .admission-search-inner {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        min-width: 0;
        gap: 5px;
    }

    .admission-search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 3;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #60409d;
        font-size: 1rem;
        pointer-events: none;
    }

    .admission-search-input {
        flex: 1 1 auto !important;
        width: 1% !important;
        min-width: 0 !important;
        height: 52px !important;
        padding: 0 12px 0 43px !important;
        margin: 0 !important;
        border: 0 !important;
        outline: 0 !important;
        box-shadow: none !important;
        background: transparent !important;
        border-radius: 13px !important;
        font-size: .95rem;
    }

    .admission-search-btn {
        position: relative !important;
        flex: 0 0 auto !important;
        width: auto !important;
        min-width: 126px !important;
        height: 52px !important;
        margin: 0 !important;
        padding: 0 22px !important;
        border-radius: 13px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 7px !important;
        white-space: nowrap !important;
    }

    /* Remove the old duplicate pseudo search icon */
    .admission-search-box .input-group::before {
        display: none !important;
        content: none !important;
    }

    /* Mobile: keep everything on one horizontal line */
    @media (max-width: 767.98px) {
        .admission-search-box {
            width: 100% !important;
            max-width: none !important;
            padding: 5px !important;
            border-radius: 15px !important;
        }

        .admission-search-inner {
            flex-wrap: nowrap !important;
            gap: 4px !important;
        }

        .admission-search-icon {
            left: 14px;
            font-size: .92rem;
        }

        .admission-search-input {
            height: 46px !important;
            padding: 0 8px 0 37px !important;
            font-size: .78rem !important;
            line-height: 46px !important;
        }

        .admission-search-input::placeholder {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admission-search-btn {
            width: 48px !important;
            min-width: 48px !important;
            max-width: 48px !important;
            height: 46px !important;
            padding: 0 !important;
            border-radius: 11px !important;
            gap: 0 !important;
        }

        .admission-search-btn .search-label {
            display: none !important;
        }

        .admission-search-btn i {
            display: block !important;
            margin: 0 !important;
            font-size: .95rem;
        }
    }

    @media (max-width: 380px) {
        .admission-search-icon {
            left: 13px;
        }

        .admission-search-input {
            padding-left: 35px !important;
            font-size: .74rem !important;
        }

        .admission-search-btn {
            width: 44px !important;
            min-width: 44px !important;
            max-width: 44px !important;
            height: 44px !important;
        }
    }


    /* =========================================================
   HOME LIVE SEARCH — MOBILE INLINE RESULTS
   Results stay directly below the search bar and remain
   visible on the home screen without an inner scroll area.
   ========================================================= */

    .home-live-search-dropdown {
        position: absolute !important;
        z-index: 1000 !important;
        left: 0 !important;
        right: 0 !important;
        top: calc(100% + 8px) !important;

        max-height: none !important;
        overflow: visible !important;

        border: 1px solid #e3dcf1 !important;
        border-radius: 14px !important;
        background: #fff !important;
        box-shadow: 0 16px 35px rgba(46, 30, 107, .14) !important;
    }

    .home-live-search-dropdown .search-results-list,
    .home-live-search-dropdown .live-search-results,
    .home-live-search-dropdown .results-list {
        max-height: none !important;
        overflow: visible !important;
    }

    @media (max-width: 767.98px) {

        /* Search wrapper must be the positioning reference */
        .admission-search-box {
            position: relative !important;
            z-index: 50 !important;
        }

        .home-live-search-dropdown {
            position: absolute !important;
            left: 0 !important;
            right: 0 !important;
            top: calc(100% + 7px) !important;

            width: 100% !important;
            max-height: none !important;
            overflow: visible !important;

            border-radius: 14px !important;
            box-shadow: 0 14px 30px rgba(46, 30, 107, .14) !important;
        }

        /* Do not create an inner scrolling results box */
        .home-live-search-dropdown,
        .home-live-search-dropdown * {
            scrollbar-width: none;
        }

        .home-live-search-dropdown::-webkit-scrollbar,
        .home-live-search-dropdown *::-webkit-scrollbar {
            display: none;
        }

        /* Keep each result compact so the first matches are visible
       immediately below the search field. */
        .home-live-search-dropdown>div,
        .home-live-search-dropdown .search-result-item,
        .home-live-search-dropdown .result-item {
            max-height: none !important;
        }

        /* Home hero should allow the dropdown to extend naturally */
        .hero-section,
        .hero,
        .hero-search-section {
            overflow: visible !important;
        }

        /* Don't let a parent section clip the live results */
        .admission-search-box,
        .admission-search-box form {
            overflow: visible !important;
        }
    }

    @media (max-width: 380px) {
        .home-live-search-dropdown {
            top: calc(100% + 6px) !important;
            border-radius: 12px !important;
        }
    }


    /* =========================================================
   HOME LIVE SEARCH — TRUE OVERLAY
   Search suggestions float over the next home sections.
   They do NOT push content or create an inner scroll.
   ========================================================= */

    .admission-search-box {
        position: relative !important;
        z-index: 100 !important;
    }

    .admission-search-inner {
        position: relative;
        z-index: 102;
    }

    /* Make the dropdown a visual overlay */
    #homeSearchResults.home-live-search-dropdown {
        position: absolute !important;
        left: 0 !important;
        right: 0 !important;
        top: calc(100% + 8px) !important;

        width: 100% !important;
        max-height: 360px !important;

        overflow-x: hidden !important;
        overflow-y: auto !important;

        z-index: 9999 !important;
        margin: 0 !important;

        background: #fff !important;
        border: 1px solid #e1d8f2 !important;
        border-radius: 15px !important;

        box-shadow:
            0 18px 45px rgba(35, 24, 65, .18),
            0 4px 12px rgba(35, 24, 65, .07) !important;
    }

    /* IMPORTANT:
   Parent sections must not clip the dropdown. */
    .admission-hero,
    .admission-hero-section,
    .hero-section,
    .hero,
    .hero-search-section {
        overflow: visible !important;
        position: relative;
        z-index: 10;
    }

    /* Following sections stay underneath the dropdown */
    .partner-strip-section,
    .partner-section,
    section {
        position: relative;
    }

    /* Do not create another scrolling container inside results */
    #homeSearchResults .search-results-list,
    #homeSearchResults .live-search-results,
    #homeSearchResults .results-list {
        max-height: none !important;
        overflow: visible !important;
    }

    /* Mobile */
    @media (max-width: 767.98px) {
        .admission-search-box {
            z-index: 1000 !important;
        }

        #homeSearchResults.home-live-search-dropdown {
            top: calc(100% + 6px) !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;

            max-height: 300px !important;
            overflow-y: auto !important;

            border-radius: 13px !important;
            z-index: 99999 !important;
        }

        .admission-hero,
        .admission-hero-section,
        .hero-section,
        .hero,
        .hero-search-section {
            overflow: visible !important;
            z-index: 100 !important;
        }

        /* Keep the results visually above the following section */
        .partner-strip-section {
            z-index: 1 !important;
        }
    }

    /* Very small mobile */
    @media (max-width: 380px) {
        #homeSearchResults.home-live-search-dropdown {
            max-height: 280px !important;
        }
    }


    /* =========================================================
       GROWPEC BRAND PALETTE — LOGO MATCH
       Navy • Green • Gold
       ========================================================= */
    :root {
        --gp-purple: #001F59;
        --gp-purple-dark: #00163F;
        --gp-green: #005F24;
        --gp-green-dark: #004A1C;
        --gp-gold: #DCA000;
        --gp-gold-hover: #B98200;
    }

    .text-success,
    .text-success-emphasis {
        color: var(--gp-green) !important;
    }

    .bg-success {
        background-color: var(--gp-green) !important;
    }

    .btn-gold {
        background: var(--gp-gold) !important;
        border-color: var(--gp-gold) !important;
        color: #10200f !important;
    }

    .btn-gold:hover {
        background: var(--gp-gold-hover) !important;
        border-color: var(--gp-gold-hover) !important;
    }

    .section-title,
    .admission-hero-title,
    .program-card,
    .college-name,
    .city-card-btn:hover {
        color: var(--gp-purple);
    }


    .why-growpec-section {
        background: linear-gradient(115deg, #001F59 0%, #0B3D7A 55%, #005F24 100%);
    }

    .gd-pi-ad-label {
        color: var(--gp-purple);
    }

    .gd-pi-ad-point i {
        color: var(--gp-green);
    }

    .gd-pi-ad-cta,
    .college-grid-section .section-link,
    .online-section .section-link {
        background: linear-gradient(135deg, #001F59, #174B8F) !important;
    }

    .partner-logo-pill i,
    .program-icon-wrap,
    .city-icon-badge {
        color: var(--gp-purple);
    }

    .program-card:hover .program-arrow {
        background: var(--gp-gold);
        color: #17200f;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<section class="admission-hero-section">
    <div class="container">
        <div class="admission-hero-content">
            <span class="admission-badge">
                <i class="bi bi-patch-check-fill"></i>
                Trusted Admission Guidance
            </span>

            <h1 class="admission-hero-title">
                Find The Right College For Your Career
            </h1>

            <p class="admission-hero-subtitle">
                Search colleges, universities and programs across India with
                personalized admission guidance from GrowPec.
            </p>

            <form action="<?php echo e(route('colleges.regular')); ?>" method="GET" class="admission-search-box" id="homeSearchForm">
                <div class="admission-search-inner">
                    <span class="admission-search-icon" aria-hidden="true">
                        <i class="bi bi-search"></i>
                    </span>

                    <input
                        type="search"
                        name="search"
                        id="homeSearchInput"
                        class="admission-search-input"
                        placeholder="Search college, university, course or city..."
                        aria-label="Search college, university, course or city"
                        autocomplete="off">

                    <button type="submit" class="admission-search-btn">
                        <i class="bi bi-search"></i>
                        <span class="search-label">Search</span>
                    </button>
                </div>

                <div id="homeSearchResults" class="home-live-search-dropdown d-none"></div>
            </form>

            <div class="success-rate">
                <i class="bi bi-check-circle-fill text-success"></i>
                <strong>95%+</strong>
                <span>Admission Success Rate</span>
                <span class="text-muted">•</span>
                <span>300+ Partner Universities</span>
            </div>
        </div>
    </div>
</section>


<section class="partner-strip-section">
    <div class="container text-center mb-3">
        <span class="badge bg-warning-subtle text-dark border px-3 py-2 fw-bold" style="font-size: 0.82rem;">
            <i class="bi bi-patch-check-fill text-warning me-1"></i>
            Explore 300+ Best-Matched Partner Universities
        </span>
    </div>

    <?php if($partners->isNotEmpty()): ?>
    <div class="partner-marquee-container">
        <div class="partner-marquee-track">

            
            <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="partner-logo-pill">
                <?php if($partner->logo): ?>
                <img
                    src="<?php echo e($partner->logo_url); ?>"
                    alt="<?php echo e($partner->name); ?>"
                    loading="lazy"
                    decoding="async">
                <?php else: ?>
                <span class="partner-logo-fallback" aria-hidden="true">
                    <i class="bi bi-buildings-fill"></i>
                </span>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="partner-logo-pill">
                <?php if($partner->logo): ?>
                <img
                    src="<?php echo e($partner->logo_url); ?>"
                    alt="<?php echo e($partner->name); ?>"
                    loading="lazy"
                    decoding="async">
                <?php else: ?>
                <span class="partner-logo-fallback" aria-hidden="true">
                    <i class="bi bi-buildings-fill"></i>
                </span>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
    <?php endif; ?>
</section>



<section class="education-discovery-section">
    <div class="container">
        <div class="education-discovery-layout">

            <div class="education-discovery-copy">
                <span class="education-discovery-label">Discover the</span>

                <h2 class="education-discovery-title">
                    Best in Education
                </h2>

                <div class="education-discovery-line"></div>

                <p class="education-discovery-text">
                    <strong>Top Colleges | Courses | Universities</strong>
                    - Find the Perfect match for your Career with
                    Expert-Selected Institutions and Programs.
                </p>

                <div class="education-discovery-actions">
                    <a href="<?php echo e(route('colleges.regular')); ?>" class="education-discovery-btn">
                        Explore Regular<br>Colleges
                    </a>

                    <a href="<?php echo e(route('colleges.online')); ?>" class="education-discovery-btn">
                        Explore Online<br>Colleges
                    </a>
                </div>
            </div>

            <div class="education-discovery-visual" aria-label="GrowPec education highlights">
                <div class="education-visual-orbit"></div>
                <div class="education-visual-glow"></div>

                <div class="education-visual-stat programs">
                    <strong><?php echo e($popularCourses->count()); ?>+</strong>
                    <span>Programs</span>
                </div>

                <div class="education-visual-stat universities">
                    <strong><?php echo e($partners->count()); ?>+</strong>
                    <span>University Partners</span>
                </div>

                <div class="education-visual-stat colleges">
                    <strong><?php echo e($regularColleges->count()); ?>+</strong>
                    <span>Regular Colleges</span>
                </div>

                <div class="education-visual-stat online">
                    <strong><?php echo e($onlineColleges->count()); ?>+</strong>
                    <span>Online Universities</span>
                </div>

                <div class="education-visual-center">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>

                <a href="#" class="education-visual-consult" data-bs-toggle="modal" data-bs-target="#counselingModal">
                    <span class="education-visual-consult-icon">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <span class="education-visual-consult-text">Request Free Consultation</span>
                    <i class="bi bi-arrow-up-right education-visual-consult-arrow"></i>
                </a>
            </div>

        </div>
    </div>
</section>



<section class="py-5 college-grid-section">
    <div class="container">
        <div class="cities-heading mb-4">
            <span class="badge bg-primary-subtle text-primary fw-bold mb-2">
                Campus Programs
            </span>

            <h3 class="section-title mb-2">Top Regular Colleges</h3>

            <div class="cities-heading-line mt-2"></div>

            <span class="top-college-scroll-hint mt-2">
                <i class="bi bi-arrow-left-right"></i> Swipe to explore
            </span>
        </div>

        
        <div class="top-colleges-scroll">
            <?php $__empty_1 = true; $__currentLoopData = $regularColleges->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $college): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="top-college-item">
                <a href="<?php echo e(route('college.show', $college->slug)); ?>" class="college-card">
                    <div class="college-image-wrapper">
                        <img src="<?php echo e($college->banner_url); ?>" class="college-card-img" alt="<?php echo e($college->name); ?>" loading="lazy">
                        <?php if($college->college_type): ?>
                        <span class="college-type-pill"><?php echo e($college->college_type); ?></span>
                        <?php endif; ?>
                        <div class="college-logo-wrapper">
                            <img src="<?php echo e($college->logo_url ?? $college->banner_url); ?>" class="college-logo" alt="<?php echo e($college->name); ?> logo" loading="lazy">
                        </div>
                    </div>

                    <div class="college-card-body">
                        <h5 class="college-name"><?php echo e($college->name); ?></h5>
                        <div class="college-info">
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-bank2"></i></span>
                                <span class="college-info-text"><?php echo e($college->college_type ?: 'University / College'); ?></span>
                            </div>
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-geo-alt-fill text-danger"></i></span>
                                <span class="college-info-text"><?php echo e($college->state); ?>, <?php echo e($college->city); ?></span>
                            </div>
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-gear-fill"></i></span>
                                <span class="college-info-text">
                                    <?php if($college->established_year): ?>
                                    Estd year <?php echo e($college->established_year); ?>

                                    <?php else: ?>
                                    Established info unavailable
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted mb-0">Colleges are being updated. Check back soon!</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="college-view-all-wrap">
            <a href="<?php echo e(route('colleges.regular')); ?>" class="btn btn-outline-primary btn-sm section-link">
                View All <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
</section>


<section class="py-5 online-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-success-subtle text-success fw-bold mb-1">UGC-DEB Approved</span>
                <h3 class="section-title mb-0">Top Online Universities</h3>
                <div class="cities-heading-line mt-2"></div>
            </div>
        </div>

        <div class="row g-4 college-grid">
            <?php $__empty_1 = true; $__currentLoopData = $onlineColleges->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $college): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="<?php echo e(route('college.show', $college->slug)); ?>" class="college-card">
                    <div class="college-image-wrapper">
                        <img src="<?php echo e($college->banner_url); ?>" class="college-card-img" alt="<?php echo e($college->name); ?>" loading="lazy">
                        <span class="college-type-pill online">100% Online</span>
                        <div class="college-logo-wrapper">
                            <img src="<?php echo e($college->logo_url ?? $college->banner_url); ?>" class="college-logo" alt="<?php echo e($college->name); ?> logo" loading="lazy">
                        </div>
                    </div>

                    <div class="college-card-body">
                        <h5 class="college-name"><?php echo e($college->name); ?></h5>
                        <div class="college-info">
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-bank2"></i></span>
                                <span class="college-info-text"><?php echo e($college->college_type ?: 'University'); ?></span>
                            </div>
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-geo-alt-fill text-danger"></i></span>
                                <span class="college-info-text"><?php echo e($college->state); ?>, <?php echo e($college->city); ?></span>
                            </div>
                            <div class="college-info-row">
                                <span class="college-info-icon"><i class="bi bi-gear-fill"></i></span>
                                <span class="college-info-text">
                                    <?php if($college->established_year): ?>
                                    Estd year <?php echo e($college->established_year); ?>

                                    <?php else: ?>
                                    Established info unavailable
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted mb-0">Online universities data coming soon.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="college-view-all-wrap">
            <a href="<?php echo e(route('colleges.online')); ?>" class="btn btn-outline-primary btn-sm section-link">
                View All <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
</section>


<section class="py-4 bg-white">
    <div class="container">
        <div class="gd-pi-ad">
            <div class="row align-items-center g-3">
                <div class="col-lg-9">
                    <div class="gd-pi-ad-content">
                        <span class="gd-pi-ad-label">
                            <i class="bi bi-stars"></i>
                            Free Career Support
                        </span>

                        <h2 class="gd-pi-ad-title">
                            Crack Your GD & PI With Confidence
                        </h2>

                        <p class="gd-pi-ad-text">
                            Get practical guidance for Group Discussions and Personal Interviews
                            and prepare smarter for your college admission journey.
                        </p>

                        <div class="gd-pi-ad-points">
                            <span class="gd-pi-ad-point">
                                <i class="bi bi-check-circle-fill"></i> Expert Tips
                            </span>
                            <span class="gd-pi-ad-point">
                                <i class="bi bi-check-circle-fill"></i> GD Techniques
                            </span>
                            <span class="gd-pi-ad-point">
                                <i class="bi bi-check-circle-fill"></i> PI Preparation
                            </span>
                            <span class="gd-pi-ad-point">
                                <i class="bi bi-check-circle-fill"></i> Confidence Training
                            </span>
                        </div>

                        <button
                            type="button"
                            class="gd-pi-ad-cta"
                            data-bs-toggle="modal"
                            data-bs-target="#counselingModal">
                            <i class="bi bi-telephone-fill"></i>
                            Get Free Guidance
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="gd-pi-ad-visual">
                        <div class="gd-pi-ad-card">
                            <i class="bi bi-person-video3"></i>
                            <strong>GD / PI</strong>
                            <span>Coaching Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="py-5 bg-white">
    <div class="container">
        <div class="cities-heading">
            <h3 class="section-title">Top Cities For MBA &amp; PGDM!</h3>
            <div class="cities-heading-line"></div>
        </div>

        <div class="row row-cols-2 row-cols-md-4 g-3 cities-grid">
            <?php
            $cityIcons = [
            'new-delhi' => 'bi-building',
            'delhi-ncr' => 'bi-building',
            'bangalore' => 'bi-buildings',
            'bengaluru' => 'bi-buildings',
            'hyderabad' => 'bi-bank',
            'mumbai' => 'bi-building',
            'kolkata' => 'bi-bank2',
            'lucknow' => 'bi-building',
            ];
            ?>

            <?php $__empty_1 = true; $__currentLoopData = $popularCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
            $citySlug = \Illuminate\Support\Str::slug($city->name);
            $cityIcon = $cityIcons[$citySlug] ?? 'bi-buildings';
            ?>
            <div class="col">
                <a href="<?php echo e(route('colleges.regular')); ?>?cities[]=<?php echo e($city->name); ?>" class="city-card-btn">
                    <div class="city-card-image">
                        <?php if(!empty($city->image)): ?>
                        <img
                            src="<?php echo e(asset('storage/' . ltrim($city->image, '/'))); ?>"
                            alt="<?php echo e($city->name); ?>"
                            class="city-real-image"
                            loading="lazy"
                            decoding="async">
                        <?php else: ?>
                        <span class="city-icon-badge">
                            <i class="bi <?php echo e($cityIcon); ?>"></i>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="city-card-body">
                        <span class="city-card-name"><?php echo e($city->name); ?></span>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php $__currentLoopData = [
            ['name' => 'New Delhi', 'icon' => 'bi-building'],
            ['name' => 'Bangalore', 'icon' => 'bi-buildings'],
            ['name' => 'Hyderabad', 'icon' => 'bi-bank'],
            ['name' => 'Mumbai', 'icon' => 'bi-building'],
            ['name' => 'Kolkata', 'icon' => 'bi-bank2'],
            ['name' => 'Lucknow', 'icon' => 'bi-building']
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col">
                <a href="<?php echo e(route('colleges.regular')); ?>?cities[]=<?php echo e($city['name']); ?>" class="city-card-btn">
                    <div class="city-card-image">
                        <span class="city-icon-badge">
                            <i class="bi <?php echo e($city['icon']); ?>"></i>
                        </span>
                    </div>
                    <div class="city-card-body">
                        <span class="city-card-name"><?php echo e($city['name']); ?></span>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="py-3 bg-white">
    <div class="container">
        <div class="advisor-call-strip shadow-sm d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="text-start">
                <h4 class="fw-bold mb-1">Connect With A Program Advisor For FREE Guidance!</h4>
                <small class="text-white-50">Instant callback & fee comparison across top universities</small>
            </div>
            <a href="tel:<?php echo e($siteSettings['general.support_phone'] ?? ''); ?>" class="btn-call-gold shadow">
                <i class="bi bi-telephone-outbound-fill me-2"></i> <?php echo e($siteSettings['general.support_phone'] ?? ''); ?>

            </a>
        </div>
    </div>
</section>


<section class="py-5 why-growpec-section">
    <div class="container why-growpec-inner">
        <div class="text-center mb-4">
            <h2 class="why-growpec-title">Why Choose GrowPec?</h2>
            <div class="why-growpec-line"></div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="why-feature-card h-100">
                    <h5>Verified University Data</h5>
                    <p>Direct fees, UGC &amp; AICTE accreditation, and verified placement reports.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="why-feature-card h-100">
                    <h5>Unbiased Comparisons</h5>
                    <p>Compare courses, fees and colleges to make a confident admission decision.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="why-feature-card h-100">
                    <h5>1-on-1 Admission Guidance</h5>
                    <p>Get personalized guidance from experienced counselors for your admission journey.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="why-feature-card h-100">
                    <h5>Scholarship Assistance</h5>
                    <p>Get guidance on merit scholarships and education loan options.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="why-feature-card h-100">
                    <h5>Top University Choices</h5>
                    <p>Explore 300+ partner universities and find programs matched to your goals.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="why-feature-card h-100">
                    <h5>Career &amp; Placement Support</h5>
                    <p>Get practical career guidance and support throughout your admission journey.</p>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="py-5 program-section">
    <div class="container">

        <div class="program-layout">

            <div class="program-grid">
                <?php $__currentLoopData = $popularCourses->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col">
                    <a href="<?php echo e(route('colleges.regular')); ?>?courses[]=<?php echo e($course->slug); ?>"
                        class="program-card">

                        <div class="program-card-top">
                            <div class="program-icon-wrap">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                        </div>

                        <div class="program-content">
                            <div class="program-name">
                                <?php echo e($course->name); ?>

                            </div>

                            <div class="program-details">
                                <?php if(!empty($course->level)): ?>
                                <span class="program-detail">
                                    <?php echo e($course->level); ?>

                                </span>
                                <?php endif; ?>

                                <?php if(!empty($course->duration)): ?>
                                <span class="program-detail">
                                    <?php echo e($course->duration); ?>

                                </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="program-footer">
                            <span class="program-footer-label">
                                Find Now
                            </span>
                        </div>

                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="program-copy">
                <span class="program-copy-label">Explore</span>

                <h3 class="program-copy-title">
                    Top Programs
                </h3>

                <div class="program-copy-line"></div>

                <p class="program-copy-text">
                    Advance Your Career With GrowPec - Choose From Leading
                    <strong>MBA</strong>, <strong>PGDM</strong>, <strong>B.Tech</strong>,
                    <strong>BBA</strong>, And More, Tailored To Your Goals.
                </p>
            </div>

        </div>

    </div>
</section>


<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('homeSearchInput');
        const results = document.getElementById('homeSearchResults');
        const form = document.getElementById('homeSearchForm');

        if (!input || !results || !form) return;

        let timer = null;
        let controller = null;

        const escapeHtml = (value) => {
            const div = document.createElement('div');
            div.textContent = value ?? '';
            return div.innerHTML;
        };

        const showState = (html) => {
            results.innerHTML = html;
            results.classList.remove('d-none');
        };

        const hideResults = () => {
            results.classList.add('d-none');
            results.innerHTML = '';
        };

        input.addEventListener('input', function() {
            const query = this.value.trim();

            clearTimeout(timer);

            if (controller) {
                controller.abort();
                controller = null;
            }

            if (query.length < 2) {
                hideResults();
                return;
            }

            showState('<div class="live-search-state"><i class="bi bi-hourglass-split me-1"></i> Searching...</div>');

            timer = setTimeout(() => {
                controller = new AbortController();

                fetch(`<?php echo e(route('api.liveSearch')); ?>?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'Accept': 'application/json'
                        },
                        signal: controller.signal
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Search request failed');
                        return response.json();
                    })
                    .then(data => {
                        const colleges = Array.isArray(data.colleges) ? data.colleges : [];
                        const courses = Array.isArray(data.courses) ? data.courses : [];

                        if (!colleges.length && !courses.length) {
                            showState(`
                        <i class="bi bi-search me-1"></i>
                        No matching colleges or courses found.
                    `);
                            return;
                        }

                        let html = '';

                        if (colleges.length) {
                            html += '<div class="live-search-group-title">Colleges & Universities</div>';

                            colleges.forEach(college => {
                                const url = `<?php echo e(url('/college')); ?>/${encodeURIComponent(college.slug)}`;
                                const city = college.city ? escapeHtml(college.city) : 'India';
                                const mode = college.college_mode ?
                                    escapeHtml(String(college.college_mode).toUpperCase()) :
                                    'COLLEGE';

                                html += `
                            <a href="${url}" class="live-search-item">
                                <div>
                                    <div class="live-search-name">${escapeHtml(college.name)}</div>
                                    <div class="live-search-meta">
                                        <i class="bi bi-geo-alt-fill me-1"></i>${city}
                                    </div>
                                </div>
                                <span class="live-search-type">${mode}</span>
                            </a>
                        `;
                            });
                        }

                        if (courses.length) {
                            html += '<div class="live-search-group-title">Programs / Courses</div>';

                            courses.forEach(course => {
                                const url = `<?php echo e(route('colleges.regular')); ?>?courses[]=${encodeURIComponent(course.slug)}`;
                                const level = course.level ? escapeHtml(course.level) : 'Program';

                                html += `
                            <a href="${url}" class="live-search-item">
                                <div>
                                    <div class="live-search-name">
                                        <i class="bi bi-mortarboard-fill text-warning me-1"></i>
                                        ${escapeHtml(course.name)}
                                    </div>
                                </div>
                                <span class="live-search-type">${level}</span>
                            </a>
                        `;
                            });
                        }

                        html += `
                    <div class="live-search-footer">
                        <a href="<?php echo e(route('colleges.regular')); ?>?search=${encodeURIComponent(query)}">
                            View all results for "${escapeHtml(query)}"
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                `;

                        showState(html);
                    })
                    .catch(error => {
                        if (error.name !== 'AbortError') {
                            hideResults();
                        }
                    });
            }, 220);
        });

        form.addEventListener('submit', function() {
            input.value = input.value.trim();
        });

        document.addEventListener('click', function(event) {
            if (!form.contains(event.target)) {
                hideResults();
            }
        });

        input.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideResults();
                input.blur();
            }
        });
    });

    // Keep homepage live-search results visible directly below the search bar.
    function normalizeHomeLiveSearchDropdown() {
        const dropdown = document.querySelector('.home-live-search-dropdown');
        if (!dropdown) return;

        dropdown.style.maxHeight = 'none';
        dropdown.style.overflow = 'visible';

        dropdown.querySelectorAll('*').forEach((el) => {
            const style = window.getComputedStyle(el);
            if (style.overflowY === 'auto' || style.overflowY === 'scroll') {
                el.style.maxHeight = 'none';
                el.style.overflowY = 'visible';
            }
        });
    }

    const homeSearchInput = document.getElementById('homeSearchInput');

    homeSearchInput?.addEventListener('input', () => {
        requestAnimationFrame(normalizeHomeLiveSearchDropdown);
        setTimeout(normalizeHomeLiveSearchDropdown, 80);
    });

    homeSearchInput?.addEventListener('focus', () => {
        requestAnimationFrame(normalizeHomeLiveSearchDropdown);
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<!-- End v3 -->
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\GrowPec Version Controll\growpec\resources\views/home.blade.php ENDPATH**/ ?>