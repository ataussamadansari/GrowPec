<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - GrowPec</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --gp-navy: #002B67;
            --gp-navy-dark: #001B45;
            --gp-blue: #174B8F;
            --gp-green: #008A43;
            --gp-green-dark: #006B35;
            --gp-gold: #D9A400;
            --gp-gold-dark: #B78300;
            --gp-text: #172033;
            --gp-muted: #718096;
            --gp-border: #DCE5EF;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background:
                radial-gradient(circle at 12% 15%, rgba(0,138,67,.14), transparent 27%),
                radial-gradient(circle at 88% 85%, rgba(217,164,0,.12), transparent 25%),
                linear-gradient(135deg, var(--gp-navy-dark) 0%, var(--gp-navy) 55%, var(--gp-blue) 100%);
            color: var(--gp-text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px;
            overflow-x: hidden;
        }

        .gp-login-shell {
            position: relative;
            width: 100%;
            max-width: 1040px;
            min-height: 610px;
            display: grid;
            grid-template-columns: minmax(0, 1.02fr) minmax(390px, .98fr);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.16);
            border-radius: 28px;
            background: rgba(255,255,255,.96);
            box-shadow: 0 30px 75px rgba(0,0,0,.27);
        }

        .gp-login-brand {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px;
            color: #fff;
            background:
                linear-gradient(145deg, rgba(0,27,69,.96), rgba(0,43,103,.94) 55%, rgba(23,75,143,.94)),
                #002B67;
        }

        .gp-login-brand::before,
        .gp-login-brand::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255,255,255,.11);
            border-radius: 50%;
            pointer-events: none;
        }

        .gp-login-brand::before {
            width: 430px;
            height: 430px;
            right: -245px;
            top: -170px;
            box-shadow:
                0 0 0 34px rgba(255,255,255,.025),
                0 0 0 68px rgba(255,255,255,.018);
        }

        .gp-login-brand::after {
            width: 260px;
            height: 260px;
            left: -150px;
            bottom: -125px;
        }

        .gp-brand-content,
        .gp-brand-bottom {
            position: relative;
            z-index: 2;
        }

        .gp-logo {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #fff;
            text-decoration: none;
        }

        .gp-logo-mark {
            width: 43px;
            height: 43px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: linear-gradient(135deg, var(--gp-green), #00A952);
            color: #fff;
            font-size: 1.05rem;
            box-shadow: 0 9px 20px rgba(0,0,0,.16);
        }

        .gp-logo-text {
            font-size: 1.45rem;
            line-height: 1;
            font-weight: 850;
            letter-spacing: -.04em;
        }

        .gp-logo-text span {
            color: var(--gp-gold);
        }

        .gp-admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 52px;
            padding: 7px 11px;
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 999px;
            background: rgba(255,255,255,.08);
            color: rgba(255,255,255,.9);
            font-size: .61rem;
            font-weight: 800;
            letter-spacing: .07em;
            text-transform: uppercase;
        }

        .gp-brand-content h1 {
            max-width: 470px;
            margin: 17px 0 12px;
            font-size: clamp(2rem, 4vw, 3.15rem);
            line-height: 1.05;
            font-weight: 850;
            letter-spacing: -.055em;
        }

        .gp-brand-content > p {
            max-width: 475px;
            margin: 0;
            color: rgba(255,255,255,.73);
            font-size: .76rem;
            line-height: 1.75;
        }

        .gp-feature-list {
            display: grid;
            gap: 11px;
            margin-top: 28px;
            max-width: 420px;
        }

        .gp-feature {
            display: flex;
            align-items: center;
            gap: 11px;
            color: rgba(255,255,255,.84);
            font-size: .66rem;
            font-weight: 650;
        }

        .gp-feature-icon {
            flex: 0 0 30px;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: rgba(255,255,255,.09);
            color: #fff;
        }

        .gp-brand-bottom {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,.52);
            font-size: .59rem;
        }

        .gp-brand-bottom i {
            color: var(--gp-green);
        }

        .gp-login-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 42px 44px;
            background: #fff;
        }

        .gp-login-heading {
            margin-bottom: 26px;
        }

        .gp-login-heading .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--gp-green);
            font-size: .61rem;
            font-weight: 850;
            letter-spacing: .09em;
            text-transform: uppercase;
        }

        .gp-login-heading h2 {
            margin: 8px 0 6px;
            color: var(--gp-navy);
            font-size: 1.55rem;
            line-height: 1.2;
            font-weight: 850;
            letter-spacing: -.035em;
        }

        .gp-login-heading p {
            margin: 0;
            color: var(--gp-muted);
            font-size: .67rem;
            line-height: 1.55;
        }

        .gp-alert {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 16px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: .63rem;
            line-height: 1.5;
        }

        .gp-alert i {
            flex: 0 0 auto;
            margin-top: 1px;
        }

        .gp-alert-danger {
            border: 1px solid #F2C9CE;
            background: #FFF4F5;
            color: #A92E3A;
        }

        .gp-alert-success {
            border: 1px solid #BCE3CE;
            background: #F0FBF5;
            color: #08713B;
        }

        .gp-field {
            margin-bottom: 17px;
        }

        .gp-label {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 7px;
            color: var(--gp-text);
            font-size: .65rem;
            font-weight: 800;
        }

        .gp-label i {
            color: var(--gp-green);
            font-size: .72rem;
        }

        .gp-input-wrap {
            position: relative;
        }

        .gp-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            z-index: 2;
            transform: translateY(-50%);
            color: #8290A2;
            font-size: .8rem;
            pointer-events: none;
        }

        .gp-input {
            width: 100%;
            min-height: 46px;
            padding: 0 42px;
            border: 1px solid var(--gp-border);
            border-radius: 11px;
            background: #FBFCFE;
            color: var(--gp-text);
            font-family: inherit;
            font-size: .69rem;
            font-weight: 600;
            outline: none;
            transition: all .18s ease;
        }

        .gp-input::placeholder {
            color: #A0AABA;
            font-weight: 500;
        }

        .gp-input:hover {
            border-color: #C5D4E2;
            background: #fff;
        }

        .gp-input:focus {
            border-color: #6E9DCA;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(23,75,143,.08);
        }

        .gp-input.is-invalid {
            border-color: #DC6872;
            background: #FFF9F9;
        }

        .gp-password-toggle {
            position: absolute;
            right: 5px;
            top: 50%;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transform: translateY(-50%);
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: #8190A2;
            cursor: pointer;
            transition: all .15s ease;
        }

        .gp-password-toggle:hover {
            background: #EEF4F9;
            color: var(--gp-navy);
        }

        .gp-error {
            display: block;
            margin-top: 5px;
            color: #C43A47;
            font-size: .59rem;
            line-height: 1.45;
        }

        .gp-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 2px 0 21px;
        }

        .gp-check {
            display: flex;
            align-items: center;
            gap: 7px;
            margin: 0;
            color: var(--gp-muted);
            font-size: .62rem;
            cursor: pointer;
        }

        .gp-check input {
            width: 16px;
            height: 16px;
            margin: 0;
            border-color: #C7D3DF;
            cursor: pointer;
        }

        .gp-check input:checked {
            border-color: var(--gp-green);
            background-color: var(--gp-green);
        }

        .gp-submit {
            width: 100%;
            min-height: 47px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid var(--gp-gold);
            border-radius: 11px;
            background: linear-gradient(135deg, #E0AB00, #C79200);
            color: #172033;
            font-family: inherit;
            font-size: .68rem;
            font-weight: 850;
            box-shadow: 0 8px 17px rgba(217,164,0,.18);
            cursor: pointer;
            transition: all .18s ease;
        }

        .gp-submit:hover {
            border-color: var(--gp-gold-dark);
            background: linear-gradient(135deg, #C79200, #B78300);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 10px 21px rgba(183,131,0,.21);
        }

        .gp-submit:focus-visible {
            outline: 0;
            box-shadow: 0 0 0 4px rgba(217,164,0,.18);
        }

        .gp-demo {
            margin-top: 17px;
            padding: 12px 13px;
            border: 1px solid #DDE7F0;
            border-left: 3px solid var(--gp-green);
            border-radius: 10px;
            background: #F8FAFC;
        }

        .gp-demo-title {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 7px;
            color: var(--gp-text);
            font-size: .61rem;
            font-weight: 850;
        }

        .gp-demo-title i {
            color: var(--gp-green);
        }

        .gp-demo-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: var(--gp-muted);
            font-size: .58rem;
            line-height: 1.7;
        }

        .gp-demo code {
            padding: 2px 5px;
            border-radius: 5px;
            background: #EDF2F7;
            color: var(--gp-navy);
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            font-size: .57rem;
        }

        .gp-login-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 23px;
            padding-top: 18px;
            border-top: 1px solid #EDF1F5;
        }

        .gp-login-footer a {
            color: #65748A;
            font-size: .62rem;
            font-weight: 700;
            text-decoration: none;
            transition: color .15s ease;
        }

        .gp-login-footer a:hover {
            color: var(--gp-navy);
        }

        .gp-security {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 13px;
            color: #98A3B2;
            font-size: .55rem;
            text-align: center;
        }

        .gp-security i {
            color: var(--gp-green);
        }

        @media (max-width: 900px) {
            body {
                padding: 20px;
            }

            .gp-login-shell {
                max-width: 600px;
                min-height: auto;
                grid-template-columns: 1fr;
            }

            .gp-login-brand {
                min-height: 275px;
                padding: 28px 30px;
            }

            .gp-admin-badge {
                margin-top: 28px;
            }

            .gp-brand-content h1 {
                max-width: 550px;
                font-size: 2rem;
            }

            .gp-feature-list {
                grid-template-columns: repeat(3, minmax(0,1fr));
                max-width: none;
                margin-top: 20px;
            }

            .gp-feature {
                align-items: flex-start;
            }

            .gp-brand-bottom {
                margin-top: 25px;
            }

            .gp-login-panel {
                padding: 32px 34px;
            }
        }

        @media (max-width: 600px) {
            body {
                align-items: flex-start;
                padding: 12px;
            }

            .gp-login-shell {
                border-radius: 20px;
            }

            .gp-login-brand {
                min-height: auto;
                padding: 23px 20px;
            }

            .gp-logo-mark {
                width: 39px;
                height: 39px;
            }

            .gp-logo-text {
                font-size: 1.25rem;
            }

            .gp-admin-badge {
                margin-top: 24px;
                font-size: .56rem;
            }

            .gp-brand-content h1 {
                margin-top: 13px;
                font-size: 1.55rem;
            }

            .gp-brand-content > p {
                font-size: .64rem;
            }

            .gp-feature-list {
                grid-template-columns: 1fr;
                gap: 8px;
                margin-top: 18px;
            }

            .gp-feature {
                font-size: .6rem;
            }

            .gp-feature-icon {
                width: 27px;
                height: 27px;
                flex-basis: 27px;
            }

            .gp-brand-bottom {
                display: none;
            }

            .gp-login-panel {
                padding: 25px 19px 21px;
            }

            .gp-login-heading {
                margin-bottom: 21px;
            }

            .gp-login-heading h2 {
                font-size: 1.3rem;
            }

            .gp-login-heading p {
                font-size: .62rem;
            }

            .gp-field {
                margin-bottom: 15px;
            }

            .gp-options {
                margin-bottom: 18px;
            }

            .gp-submit {
                min-height: 45px;
            }

            .gp-demo-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 1px;
            }
        }

        @media (max-width: 380px) {
            .gp-login-panel {
                padding: 22px 15px 18px;
            }

            .gp-login-brand {
                padding: 20px 16px;
            }

            .gp-brand-content h1 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>

<body>

<div class="gp-login-shell">

    <section class="gp-login-brand">
        <div class="gp-brand-content">

            <a href="{{ route('home') }}" class="gp-logo">
                <span class="gp-logo-mark">
                    <i class="bi bi-mortarboard-fill"></i>
                </span>

                <span class="gp-logo-text">
                    Grow<span>Pec</span>
                </span>
            </a>

            <span class="gp-admin-badge">
                <i class="bi bi-shield-lock-fill"></i>
                Secure Admin Portal
            </span>

            <h1>Manage GrowPec with confidence.</h1>

            <p>
                Access your admin dashboard to manage colleges, courses,
                locations, banners, partners, leads and platform settings.
            </p>

            <div class="gp-feature-list">
                <div class="gp-feature">
                    <span class="gp-feature-icon">
                        <i class="bi bi-building"></i>
                    </span>
                    College Management
                </div>

                <div class="gp-feature">
                    <span class="gp-feature-icon">
                        <i class="bi bi-mortarboard"></i>
                    </span>
                    Courses & Programs
                </div>

                <div class="gp-feature">
                    <span class="gp-feature-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </span>
                    Lead Management
                </div>
            </div>
        </div>

        <div class="gp-brand-bottom">
            <i class="bi bi-check-circle-fill"></i>
            <span>GrowPec Admin Management Portal</span>
        </div>
    </section>

    <section class="gp-login-panel">

        <div class="gp-login-heading">
            <span class="eyebrow">
                <i class="bi bi-person-badge-fill"></i>
                Administrator Access
            </span>

            <h2>Welcome back</h2>

            <p>Sign in to continue to your GrowPec dashboard.</p>
        </div>

        @if(session('error'))
            <div class="gp-alert gp-alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="gp-alert gp-alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <div class="gp-field">
                <label for="email" class="gp-label">
                    <i class="bi bi-envelope-fill"></i>
                    Email Address
                </label>

                <div class="gp-input-wrap">
                    <i class="bi bi-envelope gp-input-icon"></i>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        class="gp-input @error('email') is-invalid @enderror"
                        placeholder="admin@growpec.com"
                        autocomplete="email"
                        required
                        autofocus
                    >
                </div>

                @error('email')
                    <small class="gp-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="gp-field">
                <label for="passwordInput" class="gp-label">
                    <i class="bi bi-lock-fill"></i>
                    Password
                </label>

                <div class="gp-input-wrap">
                    <i class="bi bi-lock gp-input-icon"></i>

                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        class="gp-input @error('password') is-invalid @enderror"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="gp-password-toggle"
                        id="passwordToggle"
                        aria-label="Show password"
                    >
                        <i class="bi bi-eye" id="passwordIcon"></i>
                    </button>
                </div>

                @error('password')
                    <small class="gp-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="gp-options">
                <label class="gp-check" for="rememberMe">
                    <input
                        type="checkbox"
                        name="remember"
                        id="rememberMe"
                        value="1"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <span>Keep me signed in</span>
                </label>
            </div>

            <button type="submit" class="gp-submit">
                <i class="bi bi-box-arrow-in-right"></i>
                Sign In to Dashboard
            </button>

            <div class="gp-demo">
                <div class="gp-demo-title">
                    <i class="bi bi-info-circle-fill"></i>
                    Default Super Admin
                </div>

                <div class="gp-demo-row">
                    <span>Email</span>
                    <code>admin@growpec.com</code>
                </div>

                <div class="gp-demo-row">
                    <span>Password</span>
                    <code>password123</code>
                </div>
            </div>
        </form>

        <div class="gp-login-footer">
            <i class="bi bi-arrow-left"></i>

            <a href="{{ route('home') }}">
                Back to GrowPec Website
            </a>
        </div>

        <div class="text-center">
            <span class="gp-security">
                <i class="bi bi-shield-check"></i>
                Secure administrator authentication
            </span>
        </div>

    </section>
</div>

<script>
document.getElementById('passwordToggle')?.addEventListener('click', function () {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('passwordIcon');

    if (!input || !icon) return;

    const isPassword = input.type === 'password';

    input.type = isPassword ? 'text' : 'password';
    icon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';

    this.setAttribute(
        'aria-label',
        isPassword ? 'Hide password' : 'Show password'
    );
});
</script>

</body>
</html>
