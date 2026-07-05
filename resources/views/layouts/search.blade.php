<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Athara Villas – Booking Villa online dengan harga promo.')">
    <title>@yield('title', 'Athara Villas')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary:       #1B3D2F;
            --primary-light: #2D6148;
            --accent:        #C9A84C;
            --accent-light:  #E8C97D;
            --bg-main:       #FAFAF8;
            --bg-section:    #F4F0E8;
            --text-dark:     #1A1A1A;
            --text-muted:    #6B7280;
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
            overflow-x: hidden;
            margin: 0;
            padding-top: 70px; /* Space for fixed navbar */
        }
        h1,h2,h3 { font-family: 'Cormorant Garamond', serif; }

        /* ── Navbar ── */
        .site-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            background: #ffffff; /* Solid white for search layout */
            padding: 0.85rem 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        .nav-inner { display: flex; align-items: center; justify-content: space-between; }
        .nav-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem; font-weight: 700;
            color: var(--primary); text-decoration: none;
            letter-spacing: 0.06em; white-space: nowrap;
        }
        .nav-links {
            display: flex; align-items: center; gap: 0.5rem;
            list-style: none; margin: 0; padding: 0;
        }
        .nav-links a {
            color: var(--text-dark); font-size: 0.875rem; font-weight: 500;
            text-decoration: none; padding: 0.4rem 0.85rem; border-radius: 2rem;
            transition: color 0.3s;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--accent); }

        .btn-nav-login {
            background: transparent; border: 1.5px solid #e5e7eb; color: var(--text-dark);
            padding: 0.45rem 1.1rem; border-radius: 2rem; font-weight: 600;
            font-size: 0.8rem; text-decoration: none; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 0.35rem;
        }
        .btn-nav-login:hover { border-color: var(--accent); color: var(--accent); }

        .nav-toggler {
            display: none; background: none;
            border: none; padding: 0.35rem; cursor: pointer;
            font-size: 1.5rem; color: var(--primary);
        }
        .nav-collapse { display: flex; align-items: center; gap: 1.5rem; }

        @media (max-width: 991px) {
            .nav-toggler { display: block; }
            .nav-collapse {
                display: none; position: absolute; top: 100%; left: 0; right: 0;
                background: #ffffff; padding: 1rem 1.5rem 1.5rem;
                flex-direction: column; align-items: flex-start; gap: 1rem;
                box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            }
            .nav-collapse.open { display: flex; }
            .nav-links { flex-direction: column; align-items: flex-start; width: 100%; gap:0; }
            .nav-links a { width: 100%; display: block; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6; border-radius: 0; }
        }

        /* ── Bottom Navigation (Mobile Only) ── */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 65px;
            background: #ffffff;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
            z-index: 1000;
            padding: 0 10px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.5rem;
            min-width: 65px;
            transition: all 0.3s;
            position: relative;
        }

        .bottom-nav-item i {
            font-size: 1.3rem;
            margin-bottom: 3px;
        }

        .bottom-nav-item.active {
            color: var(--accent);
        }

        .bottom-nav-item.active i {
            transform: translateY(-3px);
        }

        .bottom-nav-item.active::after {
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

        @media (max-width: 768px) {
            .site-nav, .site-footer { display: none !important; }
            body { padding-top: 0; padding-bottom: 75px; }
            .bottom-nav { display: flex; }
        }

        /* ── Footer ── */
        .site-footer { background: #0E2318; color: rgba(255,255,255,0.6); padding: 4.5rem 0 2rem; margin-top: 4rem; }
        .f-brand { font-family: 'Cormorant Garamond', serif; font-size: 1.75rem; color: #fff; font-weight: 600; letter-spacing: 0.06em; display: block; margin-bottom: 0.25rem; }
        .f-tagline { font-size: 0.82rem; color: rgba(255,255,255,0.35); }
        .f-about { color: rgba(255,255,255,0.42); font-size: 0.85rem; line-height: 1.75; margin: 1rem 0; }
        .f-social { display: flex; gap: 0.6rem; margin-top: 1.1rem; }
        .f-soc-icon { width: 36px; height: 36px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.13); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.45); font-size: 0.88rem; text-decoration: none; transition: border-color 0.3s, color 0.3s; }
        .f-soc-icon:hover { border-color: var(--accent); color: var(--accent); }
        .f-heading { color: #fff; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 1.2rem; }
        .f-nav { list-style: none; padding: 0; margin: 0; }
        .f-nav li { margin-bottom: 0.55rem; }
        .f-nav a { color: rgba(255,255,255,0.45); font-size: 0.875rem; text-decoration: none; transition: color 0.3s; }
        .f-nav a:hover { color: var(--accent); }
        .f-divider { border-color: rgba(255,255,255,0.08); margin: 2.5rem 0 1.5rem; }
        .f-bottom { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; }
        .f-copy { font-size: 0.78rem; color: rgba(255,255,255,0.28); }
    </style>

    @yield('styles')
</head>
<body>

{{-- ══ NAVBAR ══ --}}
<nav class="site-nav">
    <div class="container">
        <div class="nav-inner">
            <a href="{{ route('landing') }}" class="nav-brand">Athara Villas</a>

            <button class="nav-toggler" id="navToggler" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>

            <div class="nav-collapse" id="navCollapse">
                {{-- <div class="ms-auto pe-2">
                    <a href="#" style="color:var(--text-dark);font-size:1.25rem;position:relative;text-decoration:none;">
                        <i class="bi bi-bell"></i>
                        <span style="position:absolute;top:2px;right:-1px;width:9px;height:9px;background:#ef4444;border-radius:50%;border:2px solid #fff;"></span>
                    </a>
                </div> --}}

                @auth
                    <div class="dropdown">
                        <a href="#" class="btn-nav-login dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="border:none;">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="border:none;box-shadow:0 10px 30px rgba(0,0,0,0.1);border-radius:12px;margin-top:0.5rem;font-size:0.9rem;">
                            <li><a class="dropdown-item py-2" href="{{ route('customer.history') }}"><i class="bi bi-clock-history me-2 text-muted"></i> History</a></li>
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

{{-- ══ CONTENT ══ --}}
@yield('content')

{{-- ══ FOOTER ══ --}}
<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <span class="f-brand">Athara Villas</span>
                <span class="f-tagline">Premium Villa Experience</span>
                <p class="f-about">Menghadirkan pengalaman menginap mewah dan tak terlupakan. Kepuasan Anda adalah kebahagiaan kami.</p>
                <div class="f-social">
                    <a href="#" class="f-soc-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="f-soc-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="f-soc-icon"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <div class="f-heading">Menu</div>
                <ul class="f-nav">
                    <li><a href="{{ route('landing') }}">Beranda</a></li>
                    <li><a href="{{ route('villa.index') }}">Koleksi Villa</a></li>
                    <li><a href="{{ route('kontak') }}">Kontak</a></li>
                </ul>
            </div>
        </div>
        <hr class="f-divider">
        <div class="f-bottom">
            <span class="f-copy">&copy; {{ date('Y') }} Athara Villas. All rights reserved.</span>
        </div>
    </div>
</footer>

<script>
    document.getElementById('navToggler').addEventListener('click', () => {
        document.getElementById('navCollapse').classList.toggle('open');
    });
</script>

{{-- ══ BOTTOM NAV (MOBILE ONLY) ══ --}}
<div class="bottom-nav">
    <a href="{{ route('villa.index') }}" class="bottom-nav-item {{ request()->routeIs('villa.index') ? 'active' : '' }}">
        <i class="bi bi-house-door{{ request()->routeIs('villa.index') ? '-fill' : '' }}"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('customer.history') }}" class="bottom-nav-item {{ request()->routeIs('customer.history') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i>
        <span>History</span>
    </a>
    <a href="{{ route('customer.account') }}" class="bottom-nav-item {{ request()->routeIs('customer.account') ? 'active' : '' }}">
        <i class="bi bi-person{{ request()->routeIs('customer.account') ? '-fill' : '' }}"></i>
        <span>Akun</span>
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
