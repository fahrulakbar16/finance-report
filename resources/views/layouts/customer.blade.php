<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Athara Villas')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #0f172a; /* Deep slate */
            --accent: #c9a84c; /* Gold */
            --accent-light: #fef9e8;
            --bg-body: #f8fafc;
            --surface: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --nav-height: 65px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            padding-bottom: calc(var(--nav-height) + 15px); /* Space for bottom nav */
            -webkit-tap-highlight-color: transparent;
        }

        /* ── Navbar (PC Only) ── */
        .site-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1050;
            background: #ffffff;
            padding: 0.85rem 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            display: none; /* hidden on mobile by default */
        }
        .nav-inner { display: flex; align-items: center; justify-content: space-between; }
        .nav-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem; font-weight: 700;
            color: #1B3D2F; text-decoration: none;
            letter-spacing: 0.06em; white-space: nowrap;
        }
        .btn-nav-login {
            background: transparent; border: 1.5px solid #e5e7eb; color: var(--text-dark);
            padding: 0.45rem 1.1rem; border-radius: 2rem; font-weight: 600;
            font-size: 0.8rem; text-decoration: none; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 0.35rem;
        }
        .btn-nav-login:hover { border-color: var(--accent); color: var(--accent); }
        .nav-collapse { display: flex; align-items: center; gap: 1.5rem; }

        /* Top Header (Mobile) */
        .app-header {
            background: var(--surface);
            padding: 1rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .header-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
            margin: 0;
        }

        /* Bottom Navigation Bar */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: var(--nav-height);
            background: var(--surface);
            display: flex;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
            z-index: 1000;
            padding: 0 10px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.5rem;
            min-width: 65px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .nav-item i {
            font-size: 1.3rem;
            margin-bottom: 3px;
            transition: transform 0.3s;
        }

        .nav-item.active {
            color: var(--accent);
        }

        .nav-item.active i {
            transform: translateY(-3px);
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--accent);
        }

        /* PC Layout Adjustments */
        @media (min-width: 992px) {
            .app-header { display: none !important; }
            .bottom-nav { display: none !important; }
            .site-nav { display: block; }
            body { padding-top: 80px; padding-bottom: 0; }
        }

        /* Utilities */
        .content-area {
            padding: 1.25rem;
        }
        
        .card-custom {
            background: var(--surface);
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border: none;
            margin-bottom: 1rem;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @yield('styles')
</head>
<body>

    {{-- ══ NAVBAR (PC ONLY) ══ --}}
    <nav class="site-nav">
        <div class="container">
            <div class="nav-inner">
                <a href="{{ route('landing') }}" class="nav-brand">Athara Villas</a>
                <div class="nav-collapse">
                    @auth
                        <div class="dropdown">
                            <a href="#" class="btn-nav-login dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="border:none;">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="border:none;box-shadow:0 10px 30px rgba(0,0,0,0.1);border-radius:12px;margin-top:0.5rem;font-size:0.9rem;">
                                <li><a class="dropdown-item py-2" href="{{ route('customer.history') }}"><i class="bi bi-journal-text me-2 text-muted"></i> Pemesanan</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('customer.account') }}"><i class="bi bi-person me-2 text-muted"></i> Akun</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('customer.logout') }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger" style="background:none;border:none;width:100%;text-align:left;"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('customer.login') }}" class="btn-nav-login">
                            <i class="bi bi-person"></i> Login / Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @hasSection('header')
        <div class="app-header">
            @yield('header')
        </div>
    @endif

    <div class="content-area fade-in">
        @yield('content')
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('villa.index') }}" class="nav-item {{ request()->routeIs('villa.index') ? 'active' : '' }}">
            <i class="bi bi-house-door{{ request()->routeIs('villa.index') ? '-fill' : '' }}"></i>
            <span>Home</span>
        </a>
        <a href="{{ auth()->check() ? route('customer.history') : route('customer.login') }}" class="nav-item {{ request()->routeIs('customer.history') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i>
            <span>Pemesanan</span>
        </a>
        <a href="{{ auth()->check() ? route('customer.account') : route('customer.login') }}" class="nav-item {{ request()->routeIs('customer.account') || request()->routeIs('customer.login') ? 'active' : '' }}">
            <i class="bi bi-person{{ request()->routeIs('customer.account') || request()->routeIs('customer.login') ? '-fill' : '' }}"></i>
            <span>{{ auth()->check() ? 'Akun' : 'Login' }}</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
