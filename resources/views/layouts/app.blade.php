<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteSettings['general.seo_title'] ?? 'GrowPec - Discover Top Colleges & Online Degrees in India')</title>
    <meta name="description"
        content="@yield('meta_description', $siteSettings['general.site_description'] ?? '')">
    @if(!empty($siteSettings['general.site_keywords']))
        <meta name="keywords" content="{{ $siteSettings['general.site_keywords'] }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteSettings['general.site_name'] ?? 'GrowPec' }}">
    <meta property="og:title" content="@yield('title', $siteSettings['general.seo_title'] ?? 'GrowPec')">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['general.site_description'] ?? '')">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title', $siteSettings['general.seo_title'] ?? 'GrowPec')">
    <meta name="twitter:description" content="@yield('meta_description', $siteSettings['general.site_description'] ?? '')">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-purple: #002B67;
            --primary-dark: #001B45;
            --accent-gold: #D9A400;
            --accent-gold-hover: #B78300;
            --bg-light: #DCE7F3;
            --bg-light: color-mix(in srgb, var(--primary-purple) 13%, white);
            --text-dark: #1F2937;
            --text-muted: #6B7280;
        }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg,
                    var(--bg-light) 0%,
                    #EAF0F7 48%,
                    color-mix(in srgb, #054424 6%, white) 100%) fixed;
            color: var(--text-dark);
        }

        main>section,
        main>section.bg-white {
            background-color: transparent !important;
        }

        .top-notice-bar {
            background-color: var(--accent-gold);
            color: #000;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 6px 0;
            text-align: center;
        }

        /* =========================================================
           GrowPEC Responsive Header
           ========================================================= */

        .gp-header {
            position: relative;
            z-index: 1030;
        }

        .gp-topbar {
            position: relative;
            z-index: 1040;
            background: linear-gradient(90deg, #D9A400, #F8BC4D);
            color: #17110A;
            font-size: .76rem;
            font-weight: 700;
            padding: 7px 0;
        }

        .gp-topbar .dropdown-toggle::after {
            vertical-align: middle;
            margin-left: 4px;
            font-size: 0.72em;
        }

        .gp-topbar .dropdown-menu {
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.16) !important;
            border-radius: 10px;
        }

        .gp-topbar .dropdown-item:hover {
            background: #EEF4F8;
            color: var(--primary-purple);
        }

        .gp-topbar-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-height: 24px;
            line-height: 1.4;
        }

        .gp-topbar-inner span,
        .gp-topbar-phone {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .gp-topbar-phone {
            color: #17110A;
            text-decoration: none;
            font-weight: 800;
        }

        .gp-topbar-phone:hover {
            color: #17110A;
            opacity: .72;
        }

        .gp-topbar-divider {
            opacity: .45;
        }

        .gp-navbar {
            position: sticky;
            top: 0;
            background: rgba(255, 255, 255, .97);
            border-bottom: 1px solid rgba(46, 30, 107, .07);
            box-shadow: 0 5px 25px rgba(25, 17, 70, .07);
            padding: 10px 0;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .gp-header-container {
            width: 100%;
            max-width: 1380px;
            padding-left: 20px;
            padding-right: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        .gp-brand {
            display: inline-flex;
            align-items: center;
            padding: 0;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .gp-header-logo {
            display: block;
            width: 215px;
            height: 72px;
            max-width: none;
            object-fit: contain;
        }

        /* .gp-header-logo {
            display: block;
            width: auto;
            height: 46px;
            max-width: 210px;
            object-fit: contain;
        } */

        .gp-nav {
            align-items: center;
            gap: 3px;
        }

        .gp-nav .nav-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: #4B5563 !important;
            font-size: .84rem;
            font-weight: 700;
            margin: 0;
            padding: 10px 13px !important;
            border-radius: 9px;
            white-space: nowrap;
            transition: color .22s ease, background .22s ease;
        }

        .gp-nav .nav-link:hover,
        .gp-nav .nav-link.active {
            color: var(--primary-purple) !important;
            background: #EEF4F8;
        }

        .gp-nav .nav-link.active::after {
            content: "";
            position: absolute;
            left: 14px;
            right: 14px;
            bottom: 4px;
            height: 2px;
            border-radius: 4px;
            background: var(--accent-gold);
        }

        .gp-header-action {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .gp-call-btn {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            min-width: 145px;
            padding: 8px 10px;
            border-radius: 10px;
            background: #F6F9FB;
            border: 1px solid #DCE7EF;
            color: var(--primary-purple);
            text-decoration: none;
            transition: all .25s ease;
        }

        .gp-call-btn:hover {
            background: var(--primary-purple);
            border-color: var(--primary-purple);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46, 30, 107, .18);
        }

        .gp-call-icon {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(245, 166, 35, .16);
            color: var(--accent-gold);
            font-size: .72rem;
        }

        .gp-call-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            line-height: 1.15;
        }

        .gp-call-content small {
            color: #667585;
            font-size: .57rem;
            font-weight: 600;
        }

        .gp-call-content strong {
            color: var(--primary-purple);
            font-size: .73rem;
            font-weight: 800;
        }

        .gp-call-btn:hover .gp-call-content small {
            color: rgba(255, 255, 255, .65);
        }

        .gp-call-btn:hover .gp-call-content strong {
            color: #fff;
        }

        .gp-call-arrow {
            color: #738293;
            font-size: .7rem;
            transition: transform .22s ease, color .22s ease;
        }

        .gp-call-btn:hover .gp-call-arrow {
            color: var(--accent-gold);
            transform: translate(2px, -2px);
        }

        .gp-nav-dropdown {
            position: relative;
        }

        .gp-nav-dropdown .dropdown-toggle::after {
            margin-left: 6px;
            vertical-align: middle;
            font-size: .75rem;
            transition: transform .2s ease;
        }

        .gp-nav-dropdown:hover .dropdown-toggle::after {
            transform: translateY(1px);
        }

        .gp-nav-dropdown-menu {
            border: 1px solid #E5EBF2;
            border-radius: 12px;
            padding: 8px;
            min-width: 230px;
            box-shadow: 0 10px 30px rgba(0, 43, 103, .09);
            margin-top: 6px !important;
        }

        .gp-nav-dropdown-menu .dropdown-item {
            font-size: .83rem;
            font-weight: 650;
            color: #2D3748;
            padding: 9px 14px;
            border-radius: 8px;
            transition: all .18s ease;
        }

        .gp-nav-dropdown-menu .dropdown-item:hover {
            background: #EEF4F8;
            color: var(--growpec-navy, #002B67);
        }

        @media (min-width: 992px) {
            .gp-nav-dropdown:hover > .gp-nav-dropdown-menu {
                display: block;
            }
        }

        .gp-navbar-toggler {
            width: 42px;
            height: 40px;
            padding: 7px;
            border: 1px solid #D6E2EB;
            border-radius: 9px;
            background: #F6F9FB;
            box-shadow: none !important;
        }

        .gp-navbar-toggler span {
            display: block;
            width: 20px;
            height: 2px;
            margin: 4px auto;
            border-radius: 4px;
            background: var(--primary-purple);
        }

        /* Laptop / Tablet Landscape (e.g. 1024px) */
        @media (min-width: 992px) and (max-width: 1240px) {
            .gp-header-container {
                padding-left: 14px;
                padding-right: 14px;
            }

            .gp-brand {
                margin-right: 8px;
            }

            .gp-header-logo {
                width: 160px;
                height: 52px;
                max-width: none;
            }

            .gp-nav {
                gap: 2px;
            }

            .gp-nav .nav-link {
                font-size: .77rem;
                padding: 7px 7px !important;
                gap: 3px;
            }

            .gp-nav-dropdown .dropdown-toggle::after {
                margin-left: 3px;
            }

            .gp-header-action {
                gap: 4px;
            }

            .gp-call-btn {
                min-width: auto;
                padding: 6px 9px;
                gap: 6px;
            }

            .gp-call-icon {
                width: 26px;
                height: 26px;
                flex: 0 0 26px;
                font-size: .64rem;
            }

            .gp-call-content small {
                font-size: .50rem;
            }

            .gp-call-content strong {
                font-size: .68rem;
            }

            .gp-call-arrow {
                display: none;
            }
        }

        /* Tablet */
        @media (max-width: 991.98px) {
            .gp-header-container {
                padding-left: 14px;
                padding-right: 14px;
            }

            .gp-topbar-inner {
                gap: 7px 10px;
                font-size: .69rem;
                flex-wrap: wrap;
            }

            .gp-navbar {
                padding: 8px 0;
            }

            .gp-header-logo {
                width: 185px;
                height: 60px;
                max-width: none;
            }

            .gp-navbar .navbar-collapse {
                padding-top: 10px;
            }

            .gp-nav {
                width: 100%;
                align-items: stretch;
                padding: 4px 0 8px;
            }

            .gp-nav .nav-item {
                width: 100%;
            }

            .gp-nav .nav-link {
                width: 100%;
                justify-content: flex-start;
                padding: 10px 12px !important;
            }

            .gp-nav .nav-link.active::after {
                left: 12px;
                right: auto;
                bottom: 5px;
                width: 25px;
            }

            .gp-nav-dropdown {
                width: 100%;
            }

            .gp-nav-dropdown .gp-nav-dropdown-menu {
                position: static !important;
                transform: none !important;
                float: none;
                width: 100%;
                min-width: 0;
                border: none;
                background: #F4F8FC;
                border-radius: 9px;
                box-shadow: none;
                padding: 6px 8px;
                margin: 4px 0 8px !important;
            }

            .gp-header-action {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 8px;
                padding-bottom: 5px;
            }

            .gp-call-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Mobile */
        @media (max-width: 767.98px) {
            .gp-topbar {
                padding: 6px 0;
            }

            .gp-topbar-inner {
                justify-content: space-between;
                gap: 7px;
                flex-wrap: nowrap;
                font-size: .65rem;
            }

            .gp-topbar-guidance,
            .gp-topbar-divider {
                display: none !important;
            }

            .gp-navbar {
                padding: 0;
            }

            .gp-brand {
                margin: 0;
                padding: 0;
            }

            .gp-header-logo {
                width: 185px;
                height: 58px;
                max-width: none;
            }

            .gp-navbar-toggler {
                width: 40px;
                height: 38px;
            }

            .gp-navbar .navbar-collapse {
                max-height: calc(100vh - 105px);
                overflow-y: auto;
            }
        }

        /* Small Mobile */
        @media (max-width: 380px) {
            .gp-header-logo {
                width: 175px;
                height: 55px;
                max-width: none;
            }

            .gp-topbar-inner {
                font-size: .61rem;
            }

            .gp-topbar-phone {
                font-size: .64rem;
            }

            .gp-topbar-verified {
                font-size: .6rem;
            }
        }

        /* =========================================================
           GrowPEC Premium Footer
           ========================================================= */

        .gp-footer {
            position: relative;
            background:
                radial-gradient(circle at 85% 15%, rgba(105, 69, 165, 0.22), transparent 28%),
                radial-gradient(circle at 10% 80%, rgba(245, 166, 35, 0.08), transparent 25%),
                #001633;
            color: #A7A3B8;
            padding: 70px 0 0;
            overflow: hidden;
        }

        .gp-footer::before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            top: -180px;
            right: -100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.025);
            pointer-events: none;
        }

        .gp-footer::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            bottom: -120px;
            left: -80px;
            border-radius: 50%;
            background: rgba(245, 166, 35, 0.035);
            pointer-events: none;
        }

        .gp-footer-cta {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            padding: 30px 34px;
            margin-bottom: 60px;
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(46, 30, 107, 0.95), rgba(70, 45, 125, 0.82));
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18);
        }

        .gp-footer-cta-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--accent-gold);
            margin-bottom: 8px;
        }

        .gp-footer-cta h3 {
            color: #fff;
            font-size: 1.45rem;
            font-weight: 800;
            margin: 0 0 7px;
        }

        .gp-footer-cta p {
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
            font-size: 0.88rem;
        }

        .gp-footer-cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--accent-gold);
            color: #15100a;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 800;
            padding: 12px 19px;
            border-radius: 9px;
            transition: all 0.25s ease;
        }

        .gp-footer-cta-btn:hover {
            background: #fff;
            color: var(--primary-purple);
            transform: translateY(-2px);
        }

        .gp-footer-cta-btn i {
            transition: transform 0.25s ease;
        }

        .gp-footer-cta-btn:hover i {
            transform: translateX(4px);
        }

        .gp-footer-brand {
            display: block;
            width: fit-content;
            max-width: 100%;
            margin-bottom: 18px;
        }

        .gp-footer-logo {
            display: block;
            width: min(100%, 320px);
            max-width: 100%;
            height: auto;
            max-height: 118px;
            object-fit: contain;
            background: #fff;
            padding: 8px 12px;
            border-radius: 9px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.22);
            transition: transform 0.25s ease;
        }

        .gp-footer-logo:hover {
            transform: translateY(-2px);
        }

        .gp-footer-description {
            width: 100%;
            max-width: 390px;
            min-width: 0;
            color: #9691A8;
            font-size: 0.86rem;
            line-height: 1.8;
            margin-bottom: 22px;
            overflow-wrap: anywhere;
        }

        .gp-footer-description strong {
            color: #D9D5E4;
        }

        .gp-footer-contact {
            display: flex;
            flex-direction: column;
            gap: 11px;
            font-size: 0.82rem;
        }

        .gp-footer-contact>div {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .gp-footer-contact>div>span:last-child,
        .gp-footer-contact>div>a,
        .gp-footer-contact>div>div {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .gp-contact-details {
            flex: 1 1 auto;
            min-width: 0;
        }

        .gp-contact-icon {
            width: 28px;
            height: 28px;
            flex: 0 0 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            background: rgba(245, 166, 35, 0.09);
            color: var(--accent-gold);
            font-size: 0.78rem;
        }

        .gp-footer-contact a {
            color: #B8B3C7;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .gp-footer-contact a:hover {
            color: var(--accent-gold);
        }

        .gp-social-links {
            display: flex;
            gap: 9px;
            margin-top: 23px;
        }

        .gp-social-links a {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            color: #C6C1D2;
            background: rgba(255, 255, 255, 0.055);
            border: 1px solid rgba(255, 255, 255, 0.06);
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .gp-social-links a:hover {
            background: var(--accent-gold);
            border-color: var(--accent-gold);
            color: #15100a;
            transform: translateY(-3px);
        }

        .gp-footer-heading {
            position: relative;
            color: #fff;
            font-size: 0.88rem;
            font-weight: 800;
            margin: 4px 0 20px;
            padding-bottom: 11px;
        }

        .gp-footer-heading::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 28px;
            height: 2px;
            border-radius: 2px;
            background: var(--accent-gold);
        }

        .gp-footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .gp-footer-links li {
            margin: 0;
        }

        .gp-footer-links a {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #9D98AE;
            font-size: 0.82rem;
            text-decoration: none;
            transition: all 0.22s ease;
        }

        .gp-footer-links a i {
            font-size: 0.62rem;
            color: var(--accent-gold);
            transition: transform 0.22s ease;
        }

        .gp-footer-links a:hover {
            color: #fff;
            transform: translateX(3px);
        }

        .gp-footer-links a:hover i {
            transform: translateX(2px);
        }

        .gp-footer-support-text {
            color: #9691A8;
            font-size: 0.82rem;
            line-height: 1.75;
            margin-bottom: 18px;
        }

        .gp-footer-call {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.045);
            border: 1px solid rgba(255, 255, 255, 0.07);
            color: #fff;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .gp-footer-call:hover {
            background: rgba(245, 166, 35, 0.09);
            border-color: rgba(245, 166, 35, 0.25);
            transform: translateY(-2px);
        }

        .gp-footer-call-icon {
            width: 35px;
            height: 35px;
            flex: 0 0 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(245, 166, 35, 0.13);
            color: var(--accent-gold);
            border-radius: 8px;
        }

        .gp-footer-call span:nth-child(2) {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .gp-footer-call small {
            color: #8E899F;
            font-size: 0.66rem;
            margin-bottom: 2px;
        }

        .gp-footer-call strong {
            color: #fff;
            font-size: 0.78rem;
        }

        .gp-footer-call>i {
            color: #777186;
            font-size: 0.78rem;
            transition: transform 0.2s ease;
        }

        .gp-footer-call:hover>i {
            color: var(--accent-gold);
            transform: translate(2px, -2px);
        }

        .gp-footer-verified {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 13px;
            color: #777287;
            font-size: 0.72rem;
        }

        .gp-footer-verified i {
            color: #008A43;
        }

        .gp-footer-bottom {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-top: 55px;
            padding: 21px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
            color: #716C80;
            font-size: 0.73rem;
        }

        .gp-footer-bottom strong {
            color: #9D98AE;
        }

        .gp-footer-bottom-links {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .gp-footer-bottom-links a {
            color: #716C80;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .gp-footer-bottom-links a:hover {
            color: var(--accent-gold);
        }

        .gp-footer-bottom-links span {
            color: #4F4A5B;
        }

        @media (max-width: 767.98px) {
            .gp-footer {
                padding-top: 45px;
            }

            .gp-footer-brand {
                width: 100%;
            }

            .gp-footer-logo {
                width: min(100%, 300px);
                max-height: 112px;
            }

            .gp-footer-description {
                max-width: 520px;
                font-size: .84rem;
                line-height: 1.7;
            }

            .gp-footer-cta {
                flex-direction: column;
                align-items: flex-start;
                padding: 24px;
                margin-bottom: 45px;
            }

            .gp-footer-cta h3 {
                font-size: 1.2rem;
            }

            .gp-footer-cta p {
                line-height: 1.6;
            }

            .gp-footer-cta-action {
                width: 100%;
            }

            .gp-footer-cta-btn {
                width: 100%;
                justify-content: center;
            }

            .gp-footer-bottom {
                flex-direction: column;
                text-align: center;
                margin-top: 40px;
            }

            .gp-footer-bottom-links {
                justify-content: center;
                flex-wrap: wrap;
            }
        }


        /* =========================================================
           RESPONSIVE SYSTEM — Desktop / Laptop / Tablet / Mobile
           ========================================================= */
        html,
        body {
            width: 100%;
            min-width: 0;
            overflow-x: hidden;
        }

        img,
        svg,
        video,
        canvas {
            max-width: 100%;
        }

        @media (min-width: 992px) and (max-width: 1199.98px) {
            .container {
                max-width: 960px;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .container {
                max-width: 100%;
                padding-left: 24px;
                padding-right: 24px;
            }
        }

        @media (max-width: 767.98px) {
            .container {
                max-width: 100%;
                padding-left: 16px;
                padding-right: 16px;
            }

            .row {
                --bs-gutter-x: 1rem;
            }

            section,
            main {
                max-width: 100%;
                overflow-x: hidden;
            }
        }

        @media (max-width: 575.98px) {
            .container {
                padding-left: 14px;
                padding-right: 14px;
            }

            .gp-footer-logo {
                width: min(100%, 280px);
                max-height: 104px;
                padding: 7px 10px;
            }

            .gp-footer-description {
                font-size: .8rem;
                line-height: 1.65;
            }

            .gp-footer-contact {
                font-size: .78rem;
            }
        }


        /* =========================================================
           GROWPEC LOGO COLOR SYSTEM
           Matched to the supplied GrowPEC logo:
           Navy + Green + Gold
           ========================================================= */
        :root {
            --primary-purple: #002B67;
            --primary-dark: #001B45;
            --accent-gold: #D9A400;
            --accent-gold-hover: #B78300;

            --growpec-navy: #002B67;
            --growpec-navy-dark: #001B45;
            --growpec-green: #008A43;
            --growpec-green-dark: #006B35;
            --growpec-gold: #D9A400;
            --growpec-gold-dark: #B78300;
        }

        .gp-topbar {
            background: linear-gradient(90deg, #D9A400 0%, #E7BB32 100%) !important;
            color: #101A12 !important;
        }

        .gp-navbar {
            border-bottom-color: rgba(0, 43, 103, .10) !important;
        }

        .gp-nav .nav-link:hover,
        .gp-nav .nav-link.active,
        .gp-nav-dropdown:hover > .nav-link {
            color: #002B67 !important;
            background: #EEF4F8 !important;
        }

        .gp-nav .nav-link.active::after {
            background: #D9A400 !important;
        }

        .gp-nav .nav-link:hover i,
        .gp-nav .nav-link.active i {
            color: #008A43 !important;
        }

        .gp-call-btn {
            color: #002B67 !important;
            background: #F6F9FB !important;
            border-color: #DCE7EF !important;
        }

        .gp-call-icon {
            background: rgba(217, 164, 0, .15) !important;
            color: #B78300 !important;
        }

        .gp-call-btn:hover {
            background: #002B67 !important;
            border-color: #002B67 !important;
        }

        .gp-navbar-toggler {
            background: #F6F9FB !important;
            border-color: #D6E2EB !important;
        }

        .gp-navbar-toggler span {
            background: #002B67 !important;
        }

        .gp-footer {
            background:
                radial-gradient(circle at 85% 15%, rgba(0, 138, 67, .18), transparent 28%),
                radial-gradient(circle at 10% 80%, rgba(217, 164, 0, .09), transparent 25%),
                #001633 !important;
        }

        .gp-footer-cta {
            background: linear-gradient(135deg, #002B67, #064B35) !important;
        }

        .gp-footer-cta-badge,
        .gp-footer-links a i,
        .gp-footer-heading::after {
            color: #D9A400 !important;
        }

        .gp-footer-heading::after {
            background: #D9A400 !important;
        }

        .gp-footer-cta-btn {
            background: #D9A400 !important;
            color: #101A12 !important;
        }

        .gp-footer-cta-btn:hover {
            color: #002B67 !important;
            background: #fff !important;
        }

        .gp-contact-icon,
        .gp-footer-call-icon {
            background: rgba(217, 164, 0, .10) !important;
            color: #D9A400 !important;
        }

        .gp-social-links a:hover {
            background: #D9A400 !important;
            border-color: #D9A400 !important;
            color: #101A12 !important;
        }

        .gp-footer-verified i {
            color: #008A43 !important;
        }
    </style>
    @stack('styles')
</head>

<body>
@php
    $centerLogins = $activeCenterLogins ?? $centerLogins ?? collect();
@endphp
    <!-- GrowPEC Responsive Header -->
    <header class="gp-header">

        <div class="gp-topbar">
            <div class="container">
                <div class="gp-topbar-inner">
                    <span class="gp-topbar-guidance">
                        <i class="bi bi-stars"></i>
                        {{ !empty($siteSettings['general.tagline']) ? $siteSettings['general.tagline'] : 'Need Admission Guidance?' }}
                    </span>

                    @php
                        $topPhones = !empty($contactPhones) ? $contactPhones : (!empty($siteSettings['general.support_phone']) ? [['title' => 'Helpline', 'number' => $siteSettings['general.support_phone']]] : []);
                    @endphp
                    @if(!empty($topPhones))
                        @if(count($topPhones) === 1)
                            <a href="tel:{{ $topPhones[0]['number'] }}" class="gp-topbar-phone">
                                <i class="bi bi-telephone-fill"></i>
                                {{ $topPhones[0]['number'] }}
                            </a>
                        @else
                            <div class="dropdown d-inline-block">
                                <a href="#" class="gp-topbar-phone dropdown-toggle text-decoration-none" id="topbarPhoneDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-telephone-fill"></i>
                                    {{ $topPhones[0]['number'] }}
                                    <span class="badge bg-dark bg-opacity-25 rounded-pill ms-1" style="font-size:0.62rem; font-weight:700;">+{{ count($topPhones) - 1 }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2" aria-labelledby="topbarPhoneDropdown" style="font-size: 0.8rem; min-width: 220px; z-index: 1060; border-radius: 10px;">
                                    <li class="dropdown-header text-uppercase fw-bold text-muted py-1" style="font-size: 0.68rem; letter-spacing: 0.5px;">Support Helplines</li>
                                    @foreach($topPhones as $phone)
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between gap-3 py-1.5 px-3" href="tel:{{ $phone['number'] }}">
                                                <span class="text-secondary small">{{ $phone['title'] }}:</span>
                                                <strong class="text-dark">{{ $phone['number'] }}</strong>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif

                    <span class="gp-topbar-divider">|</span>

                    <span class="gp-topbar-verified">
                        <i class="bi bi-patch-check-fill"></i>
                        100% Verified Information
                    </span>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg gp-navbar">
            <div class="container-fluid gp-header-container">

                <a class="navbar-brand gp-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/logo.svg') }}" alt="GrowPEC Logo" class="gp-header-logo">
                </a>

                <button class="navbar-toggler gp-navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">

                    <ul class="navbar-nav gp-nav mx-auto">

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                href="{{ route('home') }}">
                                <span>Home</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                                href="{{ route('about') }}">
                                <span>About Us</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('colleges.regular') ? 'active' : '' }}"
                                href="{{ route('colleges.regular') }}">
                                <span>Regular Universities</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('colleges.online') ? 'active' : '' }}"
                                href="{{ route('colleges.online') }}">
                                <span>Online/Distance Universities</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                                href="{{ route('contact') }}">
                                <span>Contact Us</span>
                            </a>
                        </li>

                        @if(isset($centerLogins) && $centerLogins->isNotEmpty())
                            <li class="nav-item dropdown gp-nav-dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="centerLoginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>Center Login</span>
                                </a>
                                <ul class="dropdown-menu gp-nav-dropdown-menu shadow-sm" aria-labelledby="centerLoginDropdown">
                                    @foreach($centerLogins as $cLogin)
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between gap-3 py-2 px-3" href="{{ $cLogin->url }}" target="_blank" rel="noopener noreferrer">
                                                <span>{{ $cLogin->title }}</span>
                                                <i class="bi bi-box-arrow-up-right small text-muted"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif

                    </ul>

                    <div class="gp-header-action d-flex align-items-center">
                        <button type="button" class="gp-call-btn border-0 text-start" data-bs-toggle="modal" data-bs-target="#counselingModal">
                            <span class="gp-call-icon">
                                <i class="bi bi-chat-square-text-fill"></i>
                            </span>

                            <span class="gp-call-content">
                                <small>Admission Help</small>
                                <strong>Enquiry Now</strong>
                            </span>

                            <i class="bi bi-arrow-up-right gp-call-arrow"></i>
                        </button>
                    </div>

                </div>
            </div>
        </nav>
    </header>

    <!-- Main Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Premium Footer -->
    <footer class="gp-footer">
        <div class="container">

            <!-- Footer CTA -->
            <div class="gp-footer-cta">
                <div>
                    <span class="gp-footer-cta-badge">
                        <i class="bi bi-stars"></i>
                        {{ !empty($siteSettings['general.tagline']) ? $siteSettings['general.tagline'] : 'Your Career Starts Here' }}
                    </span>

                    <h3>Find the Right College for Your Future</h3>

                    <p>
                        Explore verified colleges, courses, fees and admission
                        information — all in one place.
                    </p>
                </div>

                <div class="gp-footer-cta-action">
                    <a href="{{ route('colleges.regular') }}" class="gp-footer-cta-btn">
                        Explore Colleges
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Footer Main -->
            <div class="row gy-5">

                <!-- Brand -->
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('home') }}" class="gp-footer-brand">
                        <img src="{{ asset('assets/GrowPEC-Logo.png') }}" alt="GrowPEC Logo" class="gp-footer-logo">
                    </a>

                    <p class="gp-footer-description">
                        <strong>Grow Pinnacle Education Consulting Pvt. Ltd.</strong>
                        — India's trusted platform for college discovery,
                        course exploration and admission guidance.
                    </p>

                    <div class="gp-footer-contact">
                        @php
                            $footerAddresses = !empty($contactAddresses) ? $contactAddresses : (!empty($siteSettings['general.office_address']) ? [['title' => 'Head Office', 'address' => $siteSettings['general.office_address']]] : []);
                            $footerPhones = !empty($contactPhones) ? $contactPhones : (!empty($siteSettings['general.support_phone']) ? [['title' => 'Helpline', 'number' => $siteSettings['general.support_phone']]] : []);
                            $footerEmails = !empty($contactEmails) ? $contactEmails : (!empty($siteSettings['general.support_email']) ? [['title' => 'Support Email', 'email' => $siteSettings['general.support_email']]] : []);
                        @endphp

                        @if(!empty($footerAddresses))
                            <div>
                                <span class="gp-contact-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </span>
                                <div class="gp-contact-details">
                                    @foreach($footerAddresses as $addr)
                                        <div class="{{ !$loop->last ? 'mb-2' : '' }}">
                                            @if(!empty($addr['title']) && count($footerAddresses) > 1)
                                                <strong class="d-block text-white" style="font-size: 0.76rem; margin-bottom: 2px;">{{ $addr['title'] }}</strong>
                                            @endif
                                            <span>
                                                {{ $addr['address'] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(!empty($footerPhones))
                            <div>
                                <span class="gp-contact-icon">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <div class="gp-contact-details">
                                    @foreach($footerPhones as $phone)
                                        <div class="{{ !$loop->last ? 'mb-1' : '' }}">
                                            @if(!empty($phone['title']) && count($footerPhones) > 1)
                                                <small class="text-white-50 me-1" style="font-size: 0.68rem;">{{ $phone['title'] }}:</small>
                                            @endif
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone['number']) }}">
                                                {{ $phone['number'] }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(!empty($footerEmails))
                            <div>
                                <span class="gp-contact-icon">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <div class="gp-contact-details">
                                    @foreach($footerEmails as $email)
                                        <div class="{{ !$loop->last ? 'mb-1' : '' }}">
                                            @if(!empty($email['title']) && count($footerEmails) > 1)
                                                <small class="text-white-50 me-1" style="font-size: 0.68rem;">{{ $email['title'] }}:</small>
                                            @endif
                                            <a href="mailto:{{ $email['email'] }}">
                                                {{ $email['email'] }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="gp-social-links">
                        @if(!empty($siteSettings['social.facebook']))
                            <a href="{{ $siteSettings['social.facebook'] }}" aria-label="Facebook" target="_blank"
                                rel="noopener noreferrer">
                                <i class="bi bi-facebook"></i>
                            </a>
                        @endif
                        @if(!empty($siteSettings['social.instagram']))
                            <a href="{{ $siteSettings['social.instagram'] }}" aria-label="Instagram" target="_blank"
                                rel="noopener noreferrer">
                                <i class="bi bi-instagram"></i>
                            </a>
                        @endif
                        @if(!empty($siteSettings['social.linkedin']))
                            <a href="{{ $siteSettings['social.linkedin'] }}" aria-label="LinkedIn" target="_blank"
                                rel="noopener noreferrer">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        @endif
                        @if(!empty($siteSettings['social.youtube']))
                            <a href="{{ $siteSettings['social.youtube'] }}" aria-label="YouTube" target="_blank"
                                rel="noopener noreferrer">
                                <i class="bi bi-youtube"></i>
                            </a>
                        @endif
                        @if(!empty($siteSettings['social.twitter']))
                            <a href="{{ $siteSettings['social.twitter'] }}" aria-label="X / Twitter" target="_blank"
                                rel="noopener noreferrer">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Explore -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="gp-footer-heading">Explore</h6>

                    <ul class="gp-footer-links">
                        <li>
                            <a href="{{ route('home') }}">
                                <i class="bi bi-chevron-right"></i> Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('colleges.regular') }}">
                                <i class="bi bi-chevron-right"></i> Regular Colleges
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('colleges.online') }}">
                                <i class="bi bi-chevron-right"></i> Online Colleges
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}">
                                <i class="bi bi-chevron-right"></i> About Us
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}">
                                <i class="bi bi-chevron-right"></i> Contact Us
                            </a>
                        </li>
                        @if(isset($centerLogins) && $centerLogins->isNotEmpty())
                            @foreach($centerLogins as $cLogin)
                                <li>
                                    <a href="{{ $cLogin->url }}" target="_blank" rel="noopener noreferrer">
                                        <i class="bi bi-chevron-right"></i> {{ $cLogin->title }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <!-- Popular Programs -->
                <div class="col-lg-3 col-md-6 col-6">
                    <h6 class="gp-footer-heading">Popular Programs</h6>

                    <ul class="gp-footer-links">
                        <li>
                            <a href="{{ route('colleges.regular') }}?courses[]=mba">
                                <i class="bi bi-chevron-right"></i> MBA / PGDM
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('colleges.regular') }}?courses[]=btech">
                                <i class="bi bi-chevron-right"></i> B.Tech Engineering
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('colleges.regular') }}?courses[]=bca">
                                <i class="bi bi-chevron-right"></i> BCA / MCA
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('colleges.regular') }}?courses[]=bpharm">
                                <i class="bi bi-chevron-right"></i> B.Pharm / D.Pharm
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('colleges.regular') }}">
                                <i class="bi bi-chevron-right"></i> All Courses
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="gp-footer-heading">Need Guidance?</h6>

                    <p class="gp-footer-support-text">
                        Confused about choosing the right college or course?
                        Talk to our admission experts for personalized guidance.
                    </p>

                    <div class="d-flex flex-column gap-2 mb-3">
                        <button type="button" class="gp-footer-call border-0 text-start w-100" data-bs-toggle="modal" data-bs-target="#counselingModal">
                            <span class="gp-footer-call-icon">
                                <i class="bi bi-chat-square-text-fill"></i>
                            </span>

                            <span>
                                <small>Admission Guidance</small>
                                <strong>Enquiry Now</strong>
                            </span>

                            <i class="bi bi-arrow-up-right"></i>
                        </button>

                        @php
                            $primaryPhone = !empty($contactPhones[0]['number']) ? $contactPhones[0]['number'] : ($siteSettings['general.support_phone'] ?? '');
                            $primaryPhoneTitle = !empty($contactPhones[0]['title']) && $contactPhones[0]['title'] !== 'Helpline' ? $contactPhones[0]['title'] : 'Talk to an Expert';
                        @endphp
                        @if(!empty($primaryPhone))
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $primaryPhone) }}" class="gp-footer-call">
                                <span class="gp-footer-call-icon">
                                    <i class="bi bi-telephone-fill"></i>
                                </span>

                                <span>
                                    <small>{{ $primaryPhoneTitle }}</small>
                                    <strong>
                                        {{ $primaryPhone }}
                                    </strong>
                                </span>

                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        @endif
                    </div>

                    <div class="gp-footer-verified">
                        <i class="bi bi-patch-check-fill"></i>
                        100% Verified Information
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="gp-footer-bottom">
                <div>
                    © {{ date('Y') }} <strong>GrowPEC</strong>. All rights reserved.
                </div>

                <div class="gp-footer-bottom-links">
                    @if(isset($centerLogins) && $centerLogins->isNotEmpty())
                        <div class="dropdown d-inline-block me-1">
                            <a class="dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: inherit;">
                                <i class="bi bi-person-badge-fill text-warning me-1"></i> Center Login
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="font-size: .8rem; background: #00224d; border: 1px solid rgba(255,255,255,.15);">
                                @foreach($centerLogins as $cLogin)
                                    <li>
                                        <a class="dropdown-item text-white py-2 px-3 d-flex align-items-center justify-content-between" href="{{ $cLogin->url }}" target="_blank" rel="noopener noreferrer">
                                            <span>{{ $cLogin->title }}</span>
                                            <i class="bi bi-box-arrow-up-right small text-warning ms-3"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <span>•</span>
                    @endif
                    <a href="#">Privacy Policy</a>
                    <span>•</span>
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>

        </div>
    </footer>


    <!-- =========================================================
         GROWPEC - FREE CONSULTANCY MODAL
    ========================================================== -->
    <style>
        .gp-consultancy-modal .modal-dialog {
            max-width: 680px
        }

        .gp-consultancy-modal .modal-content {
            border: 0;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 27, 69, .22)
        }

        .gp-consultancy-header {
            position: relative;
            padding: 30px 32px 26px;
            background: linear-gradient(135deg, #001B45 0%, #002B67 68%, #006B35 140%);
            color: #fff
        }

        .gp-consultancy-header:after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            right: -80px;
            top: -90px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .07)
        }

        .gp-consultancy-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            border-radius: 50px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .15);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .3px;
            margin-bottom: 13px
        }

        .gp-consultancy-badge i {
            color: #D9A400
        }

        .gp-consultancy-title {
            margin: 0 45px 7px 0;
            font-size: 28px;
            line-height: 1.2;
            font-weight: 800;
            color: #fff
        }

        .gp-consultancy-subtitle {
            margin: 0;
            max-width: 520px;
            color: rgba(255, 255, 255, .82);
            font-size: 14px;
            line-height: 1.6
        }

        .gp-consultancy-close {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 5;
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .12);
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: .2s ease
        }

        .gp-consultancy-close:hover {
            background: rgba(255, 255, 255, .22);
            transform: rotate(90deg)
        }

        .gp-consultancy-body {
            padding: 30px 32px 32px;
            background: #fff
        }

        .gp-consultancy-benefits {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 25px
        }

        .gp-consultancy-benefit {
            padding: 13px 10px;
            border: 1px solid #edf0f4;
            border-radius: 12px;
            background: #f8fafc;
            text-align: center
        }

        .gp-consultancy-benefit i {
            display: block;
            margin-bottom: 5px;
            color: #008A43;
            font-size: 18px
        }

        .gp-consultancy-benefit strong {
            display: block;
            color: #001B45;
            font-size: 11px;
            line-height: 1.3
        }

        .gp-form-label {
            display: block;
            margin-bottom: 7px;
            color: #001B45;
            font-size: 13px;
            font-weight: 700
        }

        .gp-form-label span {
            color: #008A43
        }

        .gp-input-wrap {
            position: relative
        }

        .gp-input-wrap>i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #008A43;
            font-size: 16px;
            pointer-events: none
        }

        .gp-form-control {
            width: 100%;
            height: 48px;
            padding: 0 15px;
            border: 1px solid #dfe5ec;
            border-radius: 11px;
            background: #fff;
            color: #1c2633;
            font-size: 14px;
            outline: none;
            transition: .2s ease
        }

        .gp-input-wrap .gp-form-control {
            padding-left: 43px
        }

        .gp-form-control::placeholder {
            color: #9aa5b1
        }

        .gp-form-control:focus {
            border-color: #008A43;
            box-shadow: 0 0 0 4px rgba(0, 138, 67, .08)
        }

        select.gp-form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23002B67' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 14px 14px;
            padding-right: 36px;
            cursor: pointer;
        }

        .gp-consultancy-submit {
            width: 100%;
            min-height: 52px;
            border: 0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            background: linear-gradient(135deg, #006B35, #008A43);
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(0, 107, 53, .18);
            transition: .25s ease
        }

        .gp-consultancy-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(0, 107, 53, .25)
        }

        .gp-consultancy-submit:disabled {
            opacity: .7;
            cursor: not-allowed;
            transform: none
        }

        .gp-consultancy-trust {
            margin-top: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            color: #7b8794;
            font-size: 12px;
            text-align: center
        }

        .gp-consult-success {
            text-align: center;
            padding: 12px 4px 4px
        }

        .gp-success-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 14px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e9f8ef;
            color: #008A43;
            font-size: 32px
        }

        .gp-consult-success h3 {
            margin: 0 0 8px;
            color: #002B67;
            font-size: 24px;
            font-weight: 800
        }

        .gp-consult-success p {
            margin: 0 auto 20px;
            max-width: 380px;
            color: #667085;
            line-height: 1.6;
            font-size: 14px
        }

        .gp-success-close {
            border: 0;
            border-radius: 10px;
            padding: 10px 28px;
            background: #008A43;
            color: #fff;
            font-weight: 700;
            cursor: pointer
        }

        .gp-consultancy-trust i {
            color: #008A43
        }

        @media(max-width:575.98px) {
            .gp-consultancy-modal .modal-dialog {
                margin: 10px
            }

            .gp-consultancy-modal .modal-content {
                border-radius: 20px
            }

            .gp-consultancy-header {
                padding: 24px 20px 22px
            }

            .gp-consultancy-title {
                font-size: 23px;
                margin-right: 35px
            }

            .gp-consultancy-subtitle {
                font-size: 13px
            }

            .gp-consultancy-body {
                padding: 22px 20px 24px
            }

            .gp-consultancy-benefits {
                gap: 7px
            }

            .gp-consultancy-benefit {
                padding: 10px 5px
            }

            .gp-consultancy-benefit i {
                font-size: 16px
            }

            .gp-consultancy-benefit strong {
                font-size: 10px
            }

            .gp-form-control {
                height: 46px
            }
        }
    </style>

    <div class="modal fade gp-consultancy-modal" id="counselingModal" tabindex="-1"
        aria-labelledby="counselingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="gp-consultancy-header">
                    <button type="button" class="gp-consultancy-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>

                    <div class="gp-consultancy-badge">
                        <i class="bi bi-stars"></i>
                        FREE EDUCATION GUIDANCE
                    </div>

                    <h2 class="gp-consultancy-title" id="counselingModalLabel">
                        Get Free Consultancy
                    </h2>

                    <p class="gp-consultancy-subtitle">
                        Tell us what you're looking for and our team will help you
                        find the right college, course or admission option.
                    </p>
                </div>

                <div class="gp-consultancy-body">

                    <div class="gp-consultancy-benefits">
                        <div class="gp-consultancy-benefit">
                            <i class="bi bi-person-check"></i>
                            <strong>Personal Guidance</strong>
                        </div>
                        <div class="gp-consultancy-benefit">
                            <i class="bi bi-mortarboard"></i>
                            <strong>College &amp; Course Help</strong>
                        </div>
                        <div class="gp-consultancy-benefit">
                            <i class="bi bi-currency-rupee"></i>
                            <strong>Free Consultation</strong>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('lead.submit') }}" id="gpConsultancyForm">
                        @csrf
                        <input type="hidden" name="source" value="consultancy_modal">

                        <div class="row g-3">

                            {{-- 1. Full Name --}}
                            <div class="col-md-6">
                                <label for="gpConsultName" class="gp-form-label">
                                    Full Name <span>*</span>
                                </label>
                                <div class="gp-input-wrap">
                                    <i class="bi bi-person"></i>
                                    <input type="text" name="name" id="gpConsultName" class="gp-form-control"
                                        placeholder="Enter your name" autocomplete="name" required>
                                </div>
                            </div>

                            {{-- 2. Mobile Number --}}
                            <div class="col-md-6">
                                <label for="gpConsultPhone" class="gp-form-label">
                                    Mobile Number <span>*</span>
                                </label>
                                <div class="gp-input-wrap">
                                    <i class="bi bi-telephone"></i>
                                    <input type="tel" name="phone" id="gpConsultPhone" class="gp-form-control"
                                        placeholder="10-digit mobile number" autocomplete="tel" inputmode="numeric"
                                        maxlength="10" required>
                                </div>
                            </div>

                            {{-- 3. Interested Course (Required) --}}
                            <div class="col-md-6">
                                <label for="gpConsultCourse" class="gp-form-label">
                                    Interested Course <span>*</span>
                                </label>
                                <div class="gp-input-wrap">
                                    <i class="bi bi-mortarboard"></i>
                                    <select name="course_id" id="gpConsultCourse" class="gp-form-control" required>
                                        <option value="">Select Interested Course *</option>
                                        @if(isset($globalCourses) && $globalCourses->isNotEmpty())
                                            @foreach($globalCourses as $gCourse)
                                                <option value="{{ $gCourse->id }}">{{ $gCourse->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="MBA">MBA / PGDM</option>
                                            <option value="B.Tech">B.Tech Engineering</option>
                                            <option value="BCA">BCA / MCA</option>
                                            <option value="B.Pharm">B.Pharm / D.Pharm</option>
                                            <option value="BBA">BBA / B.Com</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            {{-- 4. Preferred Study Mode --}}
                            <div class="col-md-6">
                                <label for="gpConsultMode" class="gp-form-label">
                                    Study Mode Preference
                                </label>
                                <div class="gp-input-wrap">
                                    <i class="bi bi-laptop"></i>
                                    <select name="preferred_mode" id="gpConsultMode" class="gp-form-control">
                                        <option value="Any">Any Mode / Need Guidance</option>
                                        <option value="Regular">Regular Campus College</option>
                                        <option value="Online">Online / Distance Degree</option>
                                    </select>
                                </div>
                            </div>

                            {{-- 5. Target College (Optional) --}}
                            <div class="col-12">
                                <label for="gpConsultCollege" class="gp-form-label">
                                    Target College / University <small class="text-muted fw-normal">(Optional)</small>
                                </label>
                                <div class="gp-input-wrap">
                                    <i class="bi bi-building"></i>
                                    <select name="college_id" id="gpConsultCollege" class="gp-form-control">
                                        <option value="">Need College Recommendation / Not Decided Yet</option>
                                        @if(isset($globalColleges) && $globalColleges->isNotEmpty())
                                            @foreach($globalColleges as $gCol)
                                                <option value="{{ $gCol->id }}" {{ (isset($college) && $college->id === $gCol->id) ? 'selected' : '' }}>
                                                    {{ $gCol->name }} @if(!empty($gCol->college_mode)) ({{ ucfirst($gCol->college_mode) }}) @endif
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            {{-- 6. Current City --}}
                            <div class="col-md-6">
                                <label for="gpConsultCity" class="gp-form-label">City</label>
                                <div class="gp-input-wrap">
                                    <i class="bi bi-geo-alt"></i>
                                    <input type="text" name="city" id="gpConsultCity" class="gp-form-control"
                                        placeholder="Your current city" autocomplete="address-level2">
                                </div>
                            </div>

                            {{-- 7. Email Address (Optional) --}}
                            <div class="col-md-6">
                                <label for="gpConsultEmail" class="gp-form-label">
                                    Email Address <small class="text-muted fw-normal">(Optional)</small>
                                </label>
                                <div class="gp-input-wrap">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" name="email" id="gpConsultEmail" class="gp-form-control"
                                        placeholder="Enter email address" autocomplete="email">
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12 pt-1">
                                <button type="submit" class="gp-consultancy-submit" id="gpConsultSubmit">
                                    <i class="bi bi-send-fill"></i>
                                    <span>Get Free Consultation</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="gp-consultancy-trust">
                        <i class="bi bi-shield-check"></i>
                        Your details are used only to respond to your enquiry.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('gpConsultancyForm');
            const phoneInput = document.getElementById('gpConsultPhone');
            const submitButton = document.getElementById('gpConsultSubmit');

            if (!form) return;

            if (phoneInput) {
                phoneInput.addEventListener('input', function () {
                    this.value = this.value.replace(/\D/g, '').slice(0, 10);
                });
            }

            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                if (phoneInput && !/^[6-9]\d{9}$/.test(phoneInput.value)) {
                    phoneInput.focus();
                    return;
                }

                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span>Submitting...</span>
                    `;
                }

                // Submit in the background so the user stays on the same page.
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json().catch(() => ({}));

                    if (!response.ok || data.status !== 'success') {
                        throw new Error(data.message || 'Unable to submit your enquiry. Please try again.');
                    }

                    form.innerHTML = `
                        <div class="gp-consult-success text-center">
                            <div class="gp-success-icon">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <h3>Thank You!</h3>
                            <p>${data.message || 'Your enquiry has been submitted. Our expert counselor will contact you shortly.'}</p>
                            <button type="button" class="gp-success-close" data-bs-dismiss="modal">
                                Done
                            </button>
                        </div>
                    `;

                } catch (error) {
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = `
                            <i class="bi bi-send-fill"></i>
                            <span>Get Free Consultation</span>
                        `;
                    }

                    let errorBox = document.getElementById('gpConsultError');
                    if (!errorBox) {
                        errorBox = document.createElement('div');
                        errorBox.id = 'gpConsultError';
                        errorBox.className = 'alert alert-danger py-2 px-3 mt-3 mb-0';
                        form.prepend(errorBox);
                    }
                    errorBox.textContent = error.message;
                }
            });

            const modal = document.getElementById('counselingModal');

            if (modal) {
                modal.addEventListener('hidden.bs.modal', function () {
                    form.reset();

                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = `
                            <i class="bi bi-send-fill"></i>
                            <span>Get Free Consultation</span>
                        `;
                    }
                });
            }
        });
    </script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html> 