<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - GrowPec</title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #1E1346 0%, #2E1E6B 50%, #4A2E9E 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
        }
        .login-header {
            background: #FAF8FF;
            border-bottom: 1px solid #ECE8F6;
            padding: 30px 25px 20px;
            text-align: center;
        }
        .btn-gold {
            background-color: #F5A623;
            color: #000;
            font-weight: 700;
            border-radius: 12px;
            padding: 12px 20px;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            background-color: #E09612;
            color: #000;
            transform: translateY(-1px);
        }
        .form-control-custom {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #CBD5E1;
            font-size: 0.95rem;
        }
        .form-control-custom:focus {
            border-color: #2E1E6B;
            box-shadow: 0 0 0 3px rgba(46, 30, 107, 0.15);
        }
        .demo-credentials-box {
            background: #F1EFF8;
            border-left: 4px solid #F5A623;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.82rem;
            color: #334155;
        }
    </style>
</head>
<body>

<div class="login-card">
    <!-- Header -->
    <div class="login-header">
        <a href="{{ route('home') }}" class="text-decoration-none">
            <h3 class="fw-extrabold mb-1" style="color: #2E1E6B;">
                <i class="bi bi-mortarboard-fill text-warning me-1"></i>Grow<span style="color: #F5A623;">Pec</span>
            </h3>
        </a>
        <p class="text-muted small mb-0">Admin Management Portal</p>
    </div>

    <div class="p-4 pt-4">
        <!-- Flash Alerts -->
        @if(session('error'))
        <div class="alert alert-danger py-2 small mb-3">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success py-2 small mb-3">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label small fw-bold text-dark">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;">
                        <i class="bi bi-envelope text-muted"></i>
                    </span>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           class="form-control form-control-custom border-start-0 @error('email') is-invalid @enderror" 
                           placeholder="admin@growpec.com" 
                           style="border-radius: 0 12px 12px 0;" 
                           required 
                           autofocus>
                </div>
                @error('email')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label small fw-bold text-dark">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;">
                        <i class="bi bi-lock text-muted"></i>
                    </span>
                    <input type="password" 
                           name="password" 
                           id="passwordInput"
                           class="form-control form-control-custom border-start-0 @error('password') is-invalid @enderror" 
                           placeholder="••••••••" 
                           style="border-radius: 0 12px 12px 0;" 
                           required>
                </div>
                @error('password')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label small text-muted" for="rememberMe">
                        Keep me signed in
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-gold w-100 shadow-sm mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Dashboard
            </button>

            <!-- Quick Demo Credentials Hint -->
            <div class="demo-credentials-box mb-2">
                <strong class="d-block text-dark">Default Super Admin:</strong>
                <div>Email: <code>admin@growpec.com</code></div>
                <div>Pass: <code>password123</code></div>
            </div>
        </form>
    </div>

    <!-- Card Footer -->
    <div class="text-center py-3 bg-light border-top small text-muted">
        <a href="{{ route('home') }}" class="text-decoration-none text-dark fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Back to GrowPec Website
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>