<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'Villa Finance') }}</title>

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            /* Brand (landing theme) */
            --brand-primary:       #1B3D2F;
            --brand-primary-light: #2D6148;
            --brand-accent:        #C9A84C;
            --brand-accent-light:  #E8C97D;

            /* Surfaces & text */
            --bg-app:     #F6F7F9;
            --surface:    #FFFFFF;
            --text-primary:   #0F172A;
            --text-secondary: #64748B;
            --border-subtle: rgba(15, 23, 42, 0.06);

            /* Scale */
            --radius-md: 14px;
            --radius-lg: 20px;

            /* Shadows */
            --shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-sm: 0 2px 10px rgba(15, 23, 42, 0.06);
            --shadow-md: 0 10px 28px rgba(15, 23, 42, 0.09);
            --shadow-glow-primary: 0 10px 24px rgba(27, 61, 47, 0.28);
            --shadow-glow-accent: 0 10px 24px rgba(201, 168, 76, 0.35);

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #1B3D2F 0%, #2D6148 100%);
            --gradient-accent:  linear-gradient(135deg, #C9A84C 0%, #E8C97D 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-app);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: var(--text-primary);
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 2rem;
        }

        .login-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: none;
            box-shadow: var(--shadow-md);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .brand-logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .brand-badge {
            width: 56px;
            height: 56px;
            border-radius: var(--radius-md);
            background: var(--gradient-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            box-shadow: var(--shadow-glow-primary);
        }

        .brand-text {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--text-primary);
            text-align: center;
            margin-bottom: 0.25rem;
        }

        .login-subtitle {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 2.5rem;
        }

        .form-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .form-control {
            height: 3.25rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-subtle);
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            background-color: #F8FAFC;
            color: var(--text-primary);
        }

        .form-control:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(27, 61, 47, 0.1);
            border-color: var(--brand-primary);
            background-color: var(--surface);
        }

        .btn-login {
            background: var(--gradient-primary);
            color: #fff;
            height: 3.25rem;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: var(--shadow-xs);
        }

        .btn-login:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow-primary);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .input-icon-group {
            position: relative;
        }

        .input-icon-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.125rem;
        }

        .input-icon-group .form-control {
            padding-left: 2.75rem;
        }

        .forgot-link {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--brand-primary);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--brand-primary-light);
            text-decoration: underline;
        }

        .form-check-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            user-select: none;
        }

        .invalid-feedback {
            font-size: 0.75rem;
            font-weight: 500;
            color: #EF4444;
        }

        .footer-copyright {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both; }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
            }
            .login-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card animate-in">
        <div class="brand-logo-container">
            <div class="brand-badge">
                <i class="bi bi-buildings-fill"></i>
            </div>
        </div>
        <div class="brand-text">Villa Finance</div>
        <div class="login-subtitle">
            Sign in to your dashboard to continue
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-icon-group">
                    <i class="bi bi-envelope"></i>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="your@email.com">
                </div>
                @error('email')
                    <span class="invalid-feedback d-block mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label for="password" class="form-label mb-0">Password</label>
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <div class="input-icon-group">
                    <i class="bi bi-lock"></i>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                </div>
                @error('password')
                    <span class="invalid-feedback d-block mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <div class="form-check d-flex align-items-center">
                    <input class="form-check-input mt-0 me-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="cursor: pointer; width: 1.125rem; height: 1.125rem;">
                    <label class="form-check-label" for="remember" style="cursor: pointer;">
                        Remember me on this device
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Sign in
            </button>
        </form>
    </div>

    <div class="footer-copyright">
        &copy; {{ date('Y') }} Villa Finance Management. Crafted with care.
    </div>
</div>

</body>
</html>
