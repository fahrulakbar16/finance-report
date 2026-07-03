<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Athara Villas – Villa premium dengan fasilitas lengkap dan pemandangan indah.')">
    <title>@yield('title', 'Athara Villas') – Athara Villas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

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
            padding-top: 70px;
        }
        h1,h2,h3 { font-family: 'Cormorant Garamond', serif; }

        /* ── Navbar ── */
        .site-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(14px);
            padding: 0.85rem 0;
            box-shadow: 0 1px 20px rgba(0,0,0,0.07);
        }
        .nav-inner { display: flex; align-items: center; justify-content: space-between; }
        .nav-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem; font-weight: 600;
            color: var(--primary); text-decoration: none;
            letter-spacing: 0.06em; white-space: nowrap;
        }
        .nav-links {
            display: flex; align-items: center; gap: 0.15rem;
            list-style: none; margin: 0; padding: 0;
        }
        .nav-links a {
            color: var(--text-dark); font-size: 0.875rem; font-weight: 500;
            text-decoration: none; padding: 0.4rem 0.85rem; border-radius: 2rem;
            transition: color 0.3s; letter-spacing: 0.02em;
        }
        .nav-links a:hover { color: var(--accent); }
        .nav-links a.active { color: var(--accent); font-weight: 600; }
        .btn-nav-login {
            background: var(--accent); color: var(--primary) !important;
            padding: 0.48rem 1.3rem; border-radius: 2rem; font-weight: 600;
            font-size: 0.85rem; text-decoration: none;
            transition: background 0.3s, transform 0.2s; display: inline-flex;
            align-items: center; gap: 0.35rem; white-space: nowrap;
        }
        .btn-nav-login:hover { background: var(--accent-light); transform: translateY(-1px); }
        .nav-toggler {
            display: none; background: none;
            border: 1.5px solid var(--primary); border-radius: 6px;
            padding: 0.35rem 0.55rem; cursor: pointer;
        }
        .nav-toggler span { display: block; width: 20px; height: 2px; background: var(--primary); margin: 4px 0; }
        .nav-collapse { display: flex; align-items: center; gap: 1.25rem; }
        @media (max-width: 991px) {
            .nav-toggler { display: block; }
            .nav-collapse {
                display: none; position: absolute; top: 100%; left: 0; right: 0;
                background: rgba(255,255,255,0.98); padding: 1rem 1.5rem 1.5rem;
                flex-direction: column; align-items: flex-start; gap: 0.1rem;
                box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            }
            .nav-collapse.open { display: flex; }
            .nav-links { flex-direction: column; align-items: flex-start; width: 100%; }
            .nav-links a { width: 100%; display: block; }
            .btn-nav-login { width: 100%; text-align: center; justify-content: center; margin-top: 0.5rem; }
        }

        /* ── Page Banner ── */
        .page-banner {
            background: var(--primary);
            padding: 4rem 0 5rem;
            position: relative; overflow: hidden;
        }
        .page-banner::before {
            content: '';
            position: absolute; inset: 0;
            background: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=30&w=1200&auto=format&fit=crop') center/cover;
            opacity: 0.08;
        }
        .page-banner::after {
            content: '';
            position: absolute; bottom: -1px; left: 0; right: 0;
            height: 56px; background: var(--bg-main);
            clip-path: ellipse(56% 100% at 50% 100%);
        }
        .page-banner .container { position: relative; z-index: 1; }
        .breadcrumb-bar {
            display: flex; align-items: center; gap: 0.5rem;
            margin-bottom: 1.25rem; font-size: 0.8rem;
        }
        .breadcrumb-bar a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.3s; }
        .breadcrumb-bar a:hover { color: var(--accent-light); }
        .breadcrumb-bar .sep { color: rgba(255,255,255,0.3); }
        .breadcrumb-bar .cur { color: var(--accent-light); }
        .banner-label {
            display: inline-block; color: var(--accent-light);
            font-size: 0.78rem; font-weight: 600; letter-spacing: 0.15em;
            text-transform: uppercase; margin-bottom: 0.7rem;
        }
        .banner-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.2rem, 5vw, 3.6rem); font-weight: 600;
            color: #fff; line-height: 1.1; margin: 0 0 0.75rem;
        }
        .banner-desc { color: rgba(255,255,255,0.62); font-size: 1rem; max-width: 520px; line-height: 1.7; }

        /* ── Common Section ── */
        .sec-label {
            display: inline-block; color: var(--accent);
            font-size: 0.78rem; font-weight: 600;
            letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 0.85rem;
        }
        .sec-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.9rem, 3.5vw, 2.9rem); font-weight: 600;
            color: var(--primary); line-height: 1.15; margin-bottom: 1rem;
        }
        .sec-desc { color: var(--text-muted); font-size: 0.96rem; line-height: 1.75; max-width: 540px; }
        .sec-center { text-align: center; margin-bottom: 3.5rem; }
        .sec-center .sec-desc { margin: 0 auto; }

        /* ── Buttons ── */
        .btn-gold {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--accent); color: var(--primary);
            padding: 0.82rem 1.9rem; border-radius: 2rem;
            font-weight: 600; font-size: 0.9rem; text-decoration: none;
            transition: background 0.3s, transform 0.2s, box-shadow 0.3s; border: none; cursor: pointer;
        }
        .btn-gold:hover { background: var(--accent-light); color: var(--primary); transform: translateY(-2px); box-shadow: 0 10px 28px rgba(201,168,76,0.35); }
        .btn-outline-dark {
            display: inline-flex; align-items: center; gap: 0.4rem;
            border: 1.5px solid var(--primary); color: var(--primary);
            padding: 0.82rem 1.9rem; border-radius: 2rem;
            font-weight: 500; font-size: 0.9rem; text-decoration: none;
            transition: all 0.3s; background: none;
        }
        .btn-outline-dark:hover { background: var(--primary); color: #fff; }
        .btn-underline {
            display: inline-flex; align-items: center; gap: 0.35rem;
            color: var(--primary); font-weight: 600; font-size: 0.875rem;
            text-decoration: none; border-bottom: 1.5px solid var(--accent);
            padding-bottom: 0.15rem; transition: color 0.3s;
        }
        .btn-underline:hover { color: var(--accent); }

        /* ── Animations ── */
        .fade-up {
            opacity: 0; transform: translateY(26px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-up.visible { opacity: 1; transform: none; }
        .d1 { transition-delay: 0.1s; }
        .d2 { transition-delay: 0.2s; }
        .d3 { transition-delay: 0.3s; }
        .d4 { transition-delay: 0.4s; }

        /* ── Villa Card (shared) ── */
        .v-card {
            background: #fff; border-radius: 18px; overflow: hidden;
            border: none; box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            transition: transform 0.35s, box-shadow 0.35s; height: 100%;
        }
        .v-card:hover { transform: translateY(-8px); box-shadow: 0 20px 60px rgba(27,61,47,0.13); }
        .v-card-img { position: relative; overflow: hidden; }
        .v-card-img img { width: 100%; height: 220px; object-fit: cover; transition: transform 0.5s; display: block; }
        .v-card:hover .v-card-img img { transform: scale(1.05); }
        .v-pill {
            position: absolute; top: 1rem; left: 1rem;
            background: var(--primary); color: #fff;
            padding: 0.27rem 0.8rem; border-radius: 2rem;
            font-size: 0.72rem; font-weight: 500;
        }
        .v-body { padding: 1.4rem; }
        .v-name { font-family: 'Cormorant Garamond', serif; font-size: 1.45rem; font-weight: 600; color: var(--primary); margin-bottom: 0.55rem; }
        .v-meta { display: flex; flex-wrap: wrap; gap: 0.6rem 1.1rem; margin-bottom: 0.9rem; }
        .v-meta span { font-size: 0.8rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.3rem; }
        .v-meta i { color: var(--accent); }
        .v-desc { font-size: 0.875rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 1.25rem; }

        /* ── Footer ── */
        .site-footer { background: #0E2318; color: rgba(255,255,255,0.6); padding: 4.5rem 0 2rem; }
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
        .f-contact-row { display: flex; align-items: flex-start; gap: 0.7rem; margin-bottom: 0.8rem; font-size: 0.85rem; color: rgba(255,255,255,0.45); }
        .f-contact-row i { color: var(--accent); margin-top: 0.15rem; flex-shrink: 0; }
        .f-divider { border-color: rgba(255,255,255,0.08); margin: 2.5rem 0 1.5rem; }
        .f-bottom { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; }
        .f-copy { font-size: 0.78rem; color: rgba(255,255,255,0.28); }
        .f-policy { display: flex; gap: 1.5rem; }
        .f-policy a { font-size: 0.78rem; color: rgba(255,255,255,0.28); text-decoration: none; transition: color 0.3s; }
        .f-policy a:hover { color: var(--accent); }
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
                <span></span><span></span><span></span>
            </button>

            <div class="nav-collapse" id="navCollapse">
                <ul class="nav-links">
                    <li><a href="{{ route('tentang') }}"   class="{{ request()->routeIs('tentang')    ? 'active' : '' }}">Tentang</a></li>
                    <li><a href="{{ route('villa.index') }}" class="{{ request()->routeIs('villa.*')    ? 'active' : '' }}">Villa</a></li>
                    <li><a href="{{ route('fasilitas') }}" class="{{ request()->routeIs('fasilitas')  ? 'active' : '' }}">Fasilitas</a></li>
                    <li><a href="{{ route('testimoni') }}" class="{{ request()->routeIs('testimoni')  ? 'active' : '' }}">Testimoni</a></li>
                    <li><a href="{{ route('kontak') }}"    class="{{ request()->routeIs('kontak')     ? 'active' : '' }}">Kontak</a></li>
                </ul>
                <a href="{{ route('booking.index') }}" class="btn-nav-login">
                    <i class="bi bi-calendar-check-fill"></i> Reservasi
                </a>
                <a href="{{ route('login') }}" class="btn-nav-login" style="background:transparent;border:1.5px solid #e5e7eb;color:var(--text-muted);font-size:0.8rem;padding:0.45rem 1rem;">
                    <i class="bi bi-box-arrow-in-right"></i> Admin
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- ══ PAGE BANNER (optional) ══ --}}
@hasSection('banner')
<section class="page-banner">
    <div class="container">
        <nav class="breadcrumb-bar">
            <a href="{{ route('landing') }}">Beranda</a>
            @hasSection('breadcrumb-parent')
                <span class="sep">/</span>
                <a href="@yield('breadcrumb-parent-url')">@yield('breadcrumb-parent')</a>
            @endif
            <span class="sep">/</span>
            <span class="cur">@yield('banner')</span>
        </nav>
        <span class="banner-label">@yield('banner-label')</span>
        <h1 class="banner-title">@yield('banner')</h1>
        @hasSection('banner-desc')
        <p class="banner-desc">@yield('banner-desc')</p>
        @endif
    </div>
</section>
@endif

{{-- ══ CONTENT ══ --}}
@yield('content')

{{-- ══ FOOTER ══ --}}
<footer class="site-footer">
    <div class="container">
        <div class="row g-4 g-lg-5">
            <div class="col-lg-4 col-md-6">
                <span class="f-brand">Athara Villas</span>
                <span class="f-tagline">Premium Villa Experience</span>
                <p class="f-about">Menghadirkan pengalaman menginap mewah dan tak terlupakan. Kepuasan Anda adalah kebahagiaan kami.</p>
                <div class="f-social">
                    <a href="#" class="f-soc-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="f-soc-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="f-soc-icon"><i class="bi bi-tiktok"></i></a>
                    <a href="#" class="f-soc-icon"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <div class="f-heading">Menu</div>
                <ul class="f-nav">
                    <li><a href="{{ route('landing') }}">Beranda</a></li>
                    <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('villa.index') }}">Koleksi Villa</a></li>
                    <li><a href="{{ route('fasilitas') }}">Fasilitas</a></li>
                    <li><a href="{{ route('testimoni') }}">Testimoni</a></li>
                    <li><a href="{{ route('kontak') }}">Kontak</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <div class="f-heading">Villa</div>
                <ul class="f-nav">
                    <li><a href="{{ route('villa.show', 'villa-arjuna') }}">Villa Arjuna</a></li>
                    <li><a href="{{ route('villa.show', 'villa-dewi') }}">Villa Dewi</a></li>
                    <li><a href="{{ route('villa.show', 'villa-surya') }}">Villa Surya</a></li>
                    <li><a href="{{ route('villa.show', 'villa-bintang') }}">Villa Bintang</a></li>
                    <li><a href="{{ route('villa.show', 'villa-kenanga') }}">Villa Kenanga</a></li>
                    <li><a href="{{ route('villa.show', 'villa-pandan') }}">Villa Pandan</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="f-heading">Kontak</div>
                <div class="f-contact-row"><i class="bi bi-geo-alt-fill"></i><span>Jl. Raya Villa No. 123, Batu, Malang, Jawa Timur 65314</span></div>
                <div class="f-contact-row"><i class="bi bi-telephone-fill"></i><span>+62 812-3456-7890</span></div>
                <div class="f-contact-row"><i class="bi bi-envelope-fill"></i><span>info@atharavillas.com</span></div>
                <div class="f-contact-row"><i class="bi bi-clock-fill"></i><span>Check-in: 14.00 &nbsp;|&nbsp; Check-out: 12.00</span></div>
            </div>
        </div>
        <hr class="f-divider">
        <div class="f-bottom">
            <span class="f-copy">&copy; {{ date('Y') }} Athara Villas. All rights reserved.</span>
            <div class="f-policy">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </div>
</footer>

<script>
    // Mobile nav
    document.getElementById('navToggler').addEventListener('click', () => {
        document.getElementById('navCollapse').classList.toggle('open');
    });
    document.querySelectorAll('#navCollapse a').forEach(a =>
        a.addEventListener('click', () => document.getElementById('navCollapse').classList.remove('open'))
    );

    // Fade on scroll
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
</script>

@yield('scripts')
</body>
</html>
