<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Masuk - Athara Villas</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #1B3D2F;
            --accent: #C9A84C;
            --bg-body: #FAFAF8;
            --surface: #ffffff;
            --text-dark: #1A1A1A;
            --text-muted: #6B7280;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1.5rem;
        }

        .auth-card {
            background: var(--surface);
            border-radius: 24px;
            width: 100%;
            max-width: 400px;
            padding: 2.5rem 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        }

        .brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-control {
            border: none;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 0.85rem 1.25rem;
            font-size: 0.95rem;
            margin-bottom: 1.25rem;
        }

        .form-control:focus {
            background: #fff;
            border: 2px solid var(--accent);
            box-shadow: none;
        }

        .btn-login {
            background: var(--primary);
            color: white;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background: var(--accent);
            color: var(--primary);
        }

        .form-check-label {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="brand">Athara Villas</div>
        <div class="subtitle">Selamat datang kembali! Silakan masuk ke akun Anda.</div>

        <form method="POST" action="{{ route('customer.login') }}">
            @csrf

            @error('email')
                <div class="alert alert-danger" style="border-radius: 12px; font-size: 0.85rem;">
                    {{ $message }}
                </div>
            @enderror

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Alamat Email">
            
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Kata Sandi">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Ingat Saya
                    </label>
                </div>
                <a href="#" style="font-size: 0.85rem; color: var(--accent); text-decoration: none; font-weight: 500;">Lupa Sandi?</a>
            </div>

            <button type="submit" class="btn-login">
                Masuk
            </button>
            
            <div style="text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: var(--text-muted);">
                Belum punya akun? <a href="#" style="color: var(--primary); font-weight: 600; text-decoration: none;">Daftar</a>
            </div>
        </form>
    </div>

</body>
</html>
