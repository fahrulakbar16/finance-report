<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Akses Ditolak - Athara Villas</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary:       #1B3D2F;
            --primary-light: #2D6148;
            --accent:        #C9A84C;
            --bg-main:       #FAFAF8;
            --text-dark:     #1A1A1A;
            --text-muted:    #6B7280;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'DM Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-dark);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Decorative background elements */
        .bg-shape-1 {
            position: absolute;
            top: -10%; left: -5%;
            width: 40vw; height: 40vw;
            background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, rgba(201,168,76,0) 70%);
            border-radius: 50%;
            z-index: 0;
        }
        .bg-shape-2 {
            position: absolute;
            bottom: -15%; right: -5%;
            width: 50vw; height: 50vw;
            background: radial-gradient(circle, rgba(27,61,47,0.05) 0%, rgba(27,61,47,0) 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .error-container {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 600px;
            padding: 3rem;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .error-icon {
            font-size: 4rem;
            color: var(--accent);
            margin-bottom: 1rem;
            display: inline-block;
            background: rgba(201,168,76,0.1);
            width: 100px; height: 100px;
            line-height: 100px;
            border-radius: 50%;
        }

        .error-code {
            font-family: 'Cormorant Garamond', serif;
            font-size: 5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
            line-height: 1;
            letter-spacing: -2px;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 1rem 0;
            color: var(--text-dark);
        }

        .error-desc {
            font-size: 1rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.85rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(27,61,47,0.2);
        }
        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(27,61,47,0.25);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--text-dark);
            border: 1.5px solid #e5e7eb;
        }
        .btn-outline:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: rgba(201,168,76,0.05);
        }

        @media (max-width: 576px) {
            .error-container {
                padding: 2rem 1.5rem;
                margin: 0 1rem;
            }
            .error-code { font-size: 4rem; }
            .btn-group { flex-direction: column; width: 100%; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body>

    <div class="bg-shape-1"></div>
    <div class="bg-shape-2"></div>

    <div class="error-container">
        <div class="error-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h1 class="error-code">403</h1>
        <h2 class="error-title">Akses Ditolak</h2>
        
        @if($exception->getMessage() === 'USER DOES NOT HAVE THE RIGHT ROLES.')
            <p class="error-desc">Maaf, akun Anda saat ini tidak memiliki hak akses (Role) yang sesuai untuk melihat atau melakukan tindakan di halaman ini.</p>
        @else
            <p class="error-desc">Maaf, Anda tidak memiliki izin untuk mengakses halaman yang dituju. Pastikan Anda masuk dengan akun yang tepat.</p>
        @endif
        
        <div class="btn-group">
            <a href="javascript:history.back()" class="btn btn-outline">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('landing') }}" class="btn btn-primary">
                <i class="bi bi-house"></i> Beranda Utama
            </a>
        </div>
        
        @auth
        <div style="margin-top: 2rem; border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.75rem;">Masuk dengan akun yang salah?</p>
            <!-- Assuming customer route as default. For admin, you could use logic based on request path, but a generic logout form works. -->
            @if(request()->is('admin*'))
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-color: transparent; color: #ef4444; background: rgba(239,68,68,0.05);">
                        <i class="bi bi-box-arrow-right"></i> Logout Admin
                    </button>
                </form>
            @else
                <form action="{{ route('customer.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-color: transparent; color: #ef4444; background: rgba(239,68,68,0.05);">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            @endif
        </div>
        @endauth
    </div>

</body>
</html>
