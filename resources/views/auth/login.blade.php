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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --fi-primary: #d97706; /* Amber 600 */
            --fi-primary-hover: #b45309; /* Amber 700 */
            --fi-bg: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: #0f172a;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 2rem;
        }

        .login-card {
            background: #ffffff;
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
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
            background: var(--fi-primary);
        }

        .brand-logo {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
        }

        .brand-logo i {
            color: var(--fi-primary);
            margin-right: 0.75rem;
        }

        .login-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 2.5rem;
        }

        .form-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .form-control {
            height: 3.25rem;
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(217, 119, 6, 0.1);
            border-color: var(--fi-primary);
            background-color: #fff;
        }

        .btn-login {
            background-color: var(--fi-primary);
            color: white;
            height: 3.25rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(217, 119, 6, 0.2);
        }

        .btn-login:hover {
            background-color: var(--fi-primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(217, 119, 6, 0.3);
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
            color: #94a3b8;
            font-size: 1.125rem;
        }

        .input-icon-group .form-control {
            padding-left: 2.75rem;
        }

        .forgot-link {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--fi-primary);
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .form-check-label {
            font-size: 0.875rem;
            color: #475569;
            user-select: none;
        }

        .invalid-feedback {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .footer-copyright {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.75rem;
            color: #94a3b8;
        }

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
    <div class="login-card">
        <div class="brand-logo">
            <i class="bi bi-buildings-fill"></i>
            <span>Villa Finance</span>
        </div>
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
