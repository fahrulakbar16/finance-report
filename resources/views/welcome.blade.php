<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Athara Villas – Nikmati pengalaman menginap mewah di villa terbaik kami. Fasilitas lengkap, pemandangan indah, dan pelayanan premium.">
    <title>Athara Villas – Villa Premium & Mewah</title>

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
        }

        h1, h2, h3, .font-serif { font-family: 'Cormorant Garamond', serif; }

        /* ── NAVBAR ── */
        .site-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 1.4rem 0;
            transition: background 0.4s, padding 0.4s, box-shadow 0.4s;
        }
        .site-nav.scrolled {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(14px);
            padding: 0.8rem 0;
            box-shadow: 0 1px 24px rgba(0,0,0,0.07);
        }
        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.65rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            letter-spacing: 0.06em;
            transition: color 0.3s;
            white-space: nowrap;
        }
        .site-nav.scrolled .nav-brand { color: var(--primary); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .nav-links a {
            color: rgba(255,255,255,0.88);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            padding: 0.4rem 0.9rem;
            border-radius: 2rem;
            transition: color 0.3s, background 0.3s;
            letter-spacing: 0.02em;
        }
        .nav-links a:hover { color: var(--accent-light); }
        .site-nav.scrolled .nav-links a { color: var(--text-dark); }
        .site-nav.scrolled .nav-links a:hover { color: var(--accent); }

        .btn-nav-login {
            background: var(--accent);
            color: var(--primary) !important;
            padding: 0.5rem 1.4rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: background 0.3s, transform 0.2s;
            display: inline-block;
            white-space: nowrap;
        }
        .btn-nav-login:hover {
            background: var(--accent-light);
            transform: translateY(-1px);
            color: var(--primary) !important;
        }

        /* mobile toggler */
        .nav-toggler {
            display: none;
            background: none;
            border: 1.5px solid rgba(255,255,255,0.55);
            border-radius: 6px;
            padding: 0.35rem 0.55rem;
            cursor: pointer;
            transition: border-color 0.3s;
        }
        .nav-toggler span {
            display: block;
            width: 20px;
            height: 2px;
            background: rgba(255,255,255,0.9);
            margin: 4px 0;
            transition: background 0.3s;
        }
        .site-nav.scrolled .nav-toggler { border-color: var(--primary); }
        .site-nav.scrolled .nav-toggler span { background: var(--primary); }

        .nav-collapse { display: flex; align-items: center; gap: 1.5rem; }

        @media (max-width: 991px) {
            .nav-toggler { display: block; }
            .nav-collapse {
                display: none;
                position: absolute;
                top: 100%;
                left: 0; right: 0;
                background: rgba(255,255,255,0.97);
                backdrop-filter: blur(14px);
                padding: 1.25rem 1.5rem 1.5rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
                box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            }
            .nav-collapse.open { display: flex; }
            .nav-links { flex-direction: column; align-items: flex-start; width: 100%; gap: 0; }
            .nav-links a { color: var(--text-dark) !important; width: 100%; }
            .btn-nav-login { width: 100%; text-align: center; margin-top: 0.5rem; }
        }

        /* ── HERO ── */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        .hero-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=85&w=1920&auto=format&fit=crop') center/cover no-repeat;
            transform: scale(1.06);
            transition: transform 7s ease-out;
        }
        .hero-bg.loaded { transform: scale(1); }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(140deg, rgba(10,30,20,0.72) 0%, rgba(27,61,47,0.45) 60%, rgba(0,0,0,0.25) 100%);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 680px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(201,168,76,0.18);
            border: 1px solid rgba(201,168,76,0.45);
            color: var(--accent-light);
            padding: 0.38rem 1.1rem;
            border-radius: 2rem;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }
        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(3rem, 6vw, 5.2rem);
            font-weight: 600;
            color: #fff;
            line-height: 1.08;
            margin-bottom: 1.5rem;
        }
        .hero-title em { font-style: italic; color: var(--accent-light); }
        .hero-desc {
            color: rgba(255,255,255,0.78);
            font-size: 1.05rem;
            font-weight: 300;
            line-height: 1.75;
            max-width: 520px;
            margin-bottom: 2.5rem;
        }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; }

        .btn-primary-gold {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--accent);
            color: var(--primary);
            padding: 0.85rem 2rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
            letter-spacing: 0.02em;
        }
        .btn-primary-gold:hover {
            background: var(--accent-light);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(201,168,76,0.38);
        }
        .btn-outline-white {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: 1.5px solid rgba(255,255,255,0.55);
            color: #fff;
            padding: 0.85rem 2rem;
            border-radius: 2rem;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            transition: border-color 0.3s, background 0.3s;
        }
        .btn-outline-white:hover {
            border-color: #fff;
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .hero-scroll {
            position: absolute;
            bottom: 2.5rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .hero-scroll-line {
            width: 1px;
            height: 46px;
            background: linear-gradient(to bottom, rgba(255,255,255,0.55), transparent);
            animation: scrollPulse 1.8s ease-in-out infinite;
        }
        @keyframes scrollPulse {
            0%,100% { opacity:1; transform: scaleY(1); transform-origin: top; }
            50% { opacity:0.4; transform: scaleY(0.6); transform-origin: top; }
        }

        /* ── STATS ── */
        .stats-bar {
            background: var(--primary);
            padding: 2.75rem 0;
        }
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }
        .stat-item {
            text-align: center;
            padding: 1rem 1.5rem;
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        .stat-item:last-child { border-right: none; }
        .stat-number {
            display: block;
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem;
            font-weight: 600;
            color: var(--accent);
            line-height: 1;
        }
        .stat-label {
            display: block;
            color: rgba(255,255,255,0.65);
            font-size: 0.82rem;
            margin-top: 0.5rem;
            font-weight: 400;
        }
        @media (max-width: 767px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .stat-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.1); }
            .stat-item:nth-child(even) { border-right: none; }
            .stat-item:last-child, .stat-item:nth-last-child(2) { border-bottom: none; }
        }

        /* ── SECTION HEADER ── */
        .sec-label {
            display: inline-block;
            color: var(--accent);
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 0.9rem;
        }
        .sec-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 600;
            color: var(--primary);
            line-height: 1.15;
            margin-bottom: 1rem;
        }
        .sec-desc {
            color: var(--text-muted);
            font-size: 0.975rem;
            line-height: 1.75;
            max-width: 540px;
        }
        .sec-header-center { text-align: center; margin-bottom: 4rem; }
        .sec-header-center .sec-desc { margin: 0 auto; }

        /* ── ABOUT ── */
        .about-section { padding: 7rem 0; background: var(--bg-main); }
        .img-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 0.875rem;
            height: 500px;
            overflow: hidden;
        }
        .img-grid > * { min-height: 0; min-width: 0; overflow: hidden; }
        .img-grid img {
            border-radius: 12px;
            object-fit: cover;
            width: 100%;
            height: 100%;
            display: block;
        }
        .img-grid img:first-child { grid-row: span 2; }

        .about-body { padding-left: 3rem; }
        @media (max-width: 991px) { .about-body { padding-left: 0; margin-top: 2.5rem; } }

        .check-list {
            list-style: none;
            padding: 0;
            margin: 1.75rem 0 2.25rem;
        }
        .check-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
            font-size: 0.94rem;
            color: var(--text-dark);
        }
        .check-list li i { color: var(--accent); font-size: 0.95rem; }

        /* ── VILLA CARDS ── */
        .villa-section { padding: 7rem 0; background: var(--bg-section); }
        .villa-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            transition: transform 0.35s, box-shadow 0.35s;
            height: 100%;
        }
        .villa-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(27,61,47,0.14);
        }
        .villa-img-wrap { position: relative; overflow: hidden; }
        .villa-img-wrap img {
            width: 100%; height: 230px;
            object-fit: cover;
            transition: transform 0.5s ease;
            display: block;
        }
        .villa-card:hover .villa-img-wrap img { transform: scale(1.05); }
        .villa-pill {
            position: absolute;
            top: 1rem; left: 1rem;
            background: var(--primary);
            color: #fff;
            padding: 0.28rem 0.85rem;
            border-radius: 2rem;
            font-size: 0.73rem;
            font-weight: 500;
            letter-spacing: 0.03em;
        }
        .villa-body { padding: 1.5rem; }
        .villa-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.6rem;
        }
        .villa-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem 1.25rem;
            margin-bottom: 1rem;
        }
        .villa-meta span {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        .villa-meta i { color: var(--accent); }
        .villa-desc { font-size: 0.875rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 1.4rem; }
        .btn-underline {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            border-bottom: 1.5px solid var(--accent);
            padding-bottom: 0.15rem;
            transition: color 0.3s;
        }
        .btn-underline:hover { color: var(--accent); }

        /* ── FACILITIES ── */
        .facility-section { padding: 7rem 0; background: var(--primary); }
        .facility-card { text-align: center; padding: 2rem 1rem; }
        .facility-icon {
            width: 66px; height: 66px;
            background: rgba(201,168,76,0.13);
            border: 1px solid rgba(201,168,76,0.25);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.2rem;
            font-size: 1.55rem;
            color: var(--accent);
            transition: background 0.3s, color 0.3s, transform 0.3s;
        }
        .facility-card:hover .facility-icon {
            background: var(--accent);
            color: var(--primary);
            transform: scale(1.1);
        }
        .facility-name {
            color: #fff;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 0.35rem;
        }
        .facility-desc { color: rgba(255,255,255,0.5); font-size: 0.8rem; }

        /* ── TESTIMONIALS ── */
        .testimonial-section { padding: 7rem 0; background: var(--bg-main); }
        .testimonial-card {
            background: #fff;
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 4px 30px rgba(0,0,0,0.06);
            height: 100%;
            transition: transform 0.3s;
        }
        .testimonial-card:hover { transform: translateY(-5px); }
        .t-stars { color: var(--accent); font-size: 0.85rem; margin-bottom: 1.1rem; }
        .t-quote { font-style: italic; color: #444; font-size: 0.93rem; line-height: 1.75; margin-bottom: 1.5rem; }
        .t-author { display: flex; align-items: center; gap: 0.85rem; }
        .t-avatar {
            width: 46px; height: 46px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary);
            flex-shrink: 0;
        }
        .t-name { font-weight: 600; font-size: 0.88rem; color: var(--text-dark); }
        .t-city { font-size: 0.78rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.25rem; }
        .t-city i { color: var(--accent); font-size: 0.7rem; }

        /* ── CTA ── */
        .cta-section {
            position: relative;
            padding: 8rem 0;
            overflow: hidden;
            text-align: center;
        }
        .cta-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=85&w=1920&auto=format&fit=crop') center/cover no-repeat;
        }
        .cta-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(145deg, rgba(10,30,20,0.88), rgba(27,61,47,0.75));
        }
        .cta-inner { position: relative; z-index: 2; max-width: 680px; margin: 0 auto; }
        .cta-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.2rem, 4.5vw, 3.6rem);
            color: #fff;
            font-weight: 600;
            line-height: 1.12;
            margin-bottom: 1rem;
        }
        .cta-desc { color: rgba(255,255,255,0.72); font-size: 1.02rem; margin-bottom: 2.5rem; }
        .cta-trust {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1.5rem 3rem;
            margin-top: 3rem;
            color: rgba(255,255,255,0.6);
            font-size: 0.85rem;
        }
        .cta-trust span { display: flex; align-items: center; gap: 0.45rem; }
        .cta-trust i { color: var(--accent); }

        /* ── FOOTER ── */
        .site-footer {
            background: #0E2318;
            color: rgba(255,255,255,0.6);
            padding: 4.5rem 0 2rem;
        }
        .footer-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.06em;
            display: block;
            margin-bottom: 0.3rem;
        }
        .footer-tagline { font-size: 0.82rem; color: rgba(255,255,255,0.38); }
        .footer-about { color: rgba(255,255,255,0.45); font-size: 0.85rem; line-height: 1.75; margin: 1.1rem 0; }
        .social-row { display: flex; gap: 0.6rem; margin-top: 1.2rem; }
        .social-icon {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.14);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.48);
            font-size: 0.88rem;
            text-decoration: none;
            transition: border-color 0.3s, color 0.3s;
        }
        .social-icon:hover { border-color: var(--accent); color: var(--accent); }
        .footer-heading {
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }
        .footer-nav { list-style: none; padding: 0; margin: 0; }
        .footer-nav li { margin-bottom: 0.6rem; }
        .footer-nav a {
            color: rgba(255,255,255,0.48);
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-nav a:hover { color: var(--accent); }
        .contact-row { display: flex; align-items: flex-start; gap: 0.7rem; margin-bottom: 0.85rem; font-size: 0.85rem; color: rgba(255,255,255,0.48); }
        .contact-row i { color: var(--accent); margin-top: 0.15rem; flex-shrink: 0; }
        .footer-divider { border-color: rgba(255,255,255,0.09); margin: 2.5rem 0 1.5rem; }
        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .footer-copy { font-size: 0.78rem; color: rgba(255,255,255,0.3); }
        .footer-policy { display: flex; gap: 1.5rem; }
        .footer-policy a { font-size: 0.78rem; color: rgba(255,255,255,0.3); text-decoration: none; transition: color 0.3s; }
        .footer-policy a:hover { color: var(--accent); }

        /* ── SCROLL ANIMATIONS ── */
        .fade-up {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .fade-up.visible { opacity: 1; transform: none; }
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
    </style>
</head>
<body>

    {{-- ══ NAVBAR ══ --}}
    <nav class="site-nav" id="mainNav">
        <div class="container">
            <div class="nav-inner">
                <a href="#beranda" class="nav-brand">Athara Villas</a>

                <button class="nav-toggler" id="navToggler" aria-label="Menu">
                    <span></span><span></span><span></span>
                </button>

                <div class="nav-collapse" id="navCollapse">
                    <ul class="nav-links">
                        <li><a href="{{ route('tentang') }}">Tentang</a></li>
                        <li><a href="{{ route('villa.collection') }}">Villa</a></li>
                        <li><a href="{{ route('fasilitas') }}">Fasilitas</a></li>
                        <li><a href="{{ route('testimoni') }}">Testimoni</a></li>
                        <li><a href="{{ route('kontak') }}">Kontak</a></li>
                    </ul>
                    <a href="{{ route('villa.collection') }}" class="btn-nav-login">
                        <i class="bi bi-calendar-check-fill" style="font-size:0.85rem;"></i> Reservasi
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ══ HERO ══ --}}
    <section class="hero" id="beranda">
        <div class="hero-bg" id="heroBg"></div>
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="bi bi-star-fill"></i> Villa Premium &amp; Eksklusif
                </div>
                <h1 class="hero-title">
                    Nikmati Ketenangan<br><em>Athara Villas</em>
                </h1>
                <p class="hero-desc">
                    Pengalaman menginap tak terlupakan dengan fasilitas premium, pemandangan alam memukau, dan pelayanan hangat untuk setiap momen istimewa Anda.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('villa.collection') }}" class="btn-primary-gold">
                        Lihat Villa <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ route('kontak') }}" class="btn-outline-white">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
        <div class="hero-scroll">
            <span>Scroll</span>
            <div class="hero-scroll-line"></div>
        </div>
    </section>

    {{-- ══ STATS ══ --}}
    <section class="stats-bar">
        <div class="container">
            <div class="stats-row">
                <div class="stat-item">
                    <span class="stat-number">12+</span>
                    <span class="stat-label">Unit Villa</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">2K+</span>
                    <span class="stat-label">Tamu Puas</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">5★</span>
                    <span class="stat-label">Rating Tamu</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">5+</span>
                    <span class="stat-label">Tahun Berpengalaman</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ ABOUT ══ --}}
    <section class="about-section" id="tentang">
        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6 fade-up">
                    <div class="img-grid">
                        <img
                            src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=800&auto=format&fit=crop"
                            alt="Kolam renang villa"
                            loading="lazy"
                        >
                        <img
                            src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?q=80&w=600&auto=format&fit=crop"
                            alt="Villa malam hari"
                            loading="lazy"
                        >
                        <img
                            src="https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=600&auto=format&fit=crop"
                            alt="Interior villa"
                            loading="lazy"
                        >
                    </div>
                </div>
                <div class="col-lg-6 fade-up delay-2">
                    <div class="about-body">
                        <span class="sec-label">Tentang Kami</span>
                        <h2 class="sec-title">Pengalaman Menginap<br>yang Tak Terlupakan</h2>
                        <p style="color:var(--text-muted);line-height:1.8;font-size:0.95rem;">
                            Athara Villas hadir dengan konsep villa premium yang memadukan keindahan alam dengan kemewahan modern. Setiap villa dirancang khusus untuk memberikan kenyamanan maksimal bagi Anda dan keluarga tercinta.
                        </p>
                        <ul class="check-list">
                            <li><i class="bi bi-check-circle-fill"></i> Lokasi strategis dengan pemandangan alam memukau</li>
                            <li><i class="bi bi-check-circle-fill"></i> Fasilitas lengkap standar internasional</li>
                            <li><i class="bi bi-check-circle-fill"></i> Tim profesional siap melayani 24 jam</li>
                            <li><i class="bi bi-check-circle-fill"></i> Cocok untuk keluarga, pasangan & grup</li>
                            <li><i class="bi bi-check-circle-fill"></i> Sistem reservasi mudah & transparan</li>
                        </ul>
                        <a href="{{ route('kontak') }}" class="btn-primary-gold">
                            Hubungi Kami <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ VILLA CARDS ══ --}}
    <section class="villa-section" id="villa">
        <div class="container">
            <div class="sec-header-center fade-up">
                <span class="sec-label">Koleksi Villa</span>
                <h2 class="sec-title">Pilih Villa Impian Anda</h2>
                <p class="sec-desc">Temukan villa yang sempurna untuk momen istimewa bersama orang-orang terkasih.</p>
            </div>
            <div class="row g-4">
                @forelse($homeVillas as $hv)
                @php
                    $hvThumb = $hv->image
                        ? (filter_var($hv->image, FILTER_VALIDATE_URL) ? $hv->image : asset('storage/' . $hv->image))
                        : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=800&auto=format&fit=crop';
                @endphp
                <div class="col-md-6 col-lg-4 d-flex fade-up delay-{{ $loop->iteration }}">
                    <div class="villa-card w-100">
                        <div class="villa-img-wrap">
                            <img src="{{ $hvThumb }}" alt="{{ $hv->name }}" loading="lazy">
                            <span class="villa-pill">Tersedia</span>
                        </div>
                        <div class="villa-body">
                            <h3 class="villa-name">{{ $hv->name }}</h3>
                            <div class="villa-meta">
                                <span><i class="bi bi-door-closed-fill"></i> {{ $hv->rooms->count() }} Ruangan</span>
                                @if($hv->address)
                                <span><i class="bi bi-geo-alt-fill"></i> {{ Str::limit($hv->address, 24) }}</span>
                                @endif
                            </div>
                            <p class="villa-desc">{{ Str::limit($hv->description, 110) }}</p>
                            <a href="{{ route('villa.show', $hv->id) }}" class="btn-underline">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada villa yang tersedia saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ══ FACILITIES ══ --}}
    <section class="facility-section" id="fasilitas">
        <div class="container">
            <div class="sec-header-center fade-up">
                <span class="sec-label" style="color:var(--accent-light);">Fasilitas</span>
                <h2 class="sec-title" style="color:#fff;">Lengkap untuk Kenyamanan Anda</h2>
                <p class="sec-desc" style="color:rgba(255,255,255,0.58);margin:0 auto;">Setiap villa dilengkapi fasilitas premium yang memenuhi standar kenyamanan tertinggi.</p>
            </div>
            <div class="row g-3 g-md-4 text-center">
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-1">
                    <div class="facility-card">
                        <div class="facility-icon"><i class="bi bi-droplet-fill"></i></div>
                        <div class="facility-name">Private Pool</div>
                        <div class="facility-desc">Kolam renang pribadi</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-2">
                    <div class="facility-card">
                        <div class="facility-icon"><i class="bi bi-wifi"></i></div>
                        <div class="facility-name">WiFi Cepat</div>
                        <div class="facility-desc">Internet tanpa batas</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-1">
                    <div class="facility-card">
                        <div class="facility-icon"><i class="bi bi-tv-fill"></i></div>
                        <div class="facility-name">Smart TV</div>
                        <div class="facility-desc">TV layar lebar premium</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-2">
                    <div class="facility-card">
                        <div class="facility-icon"><i class="bi bi-snow2"></i></div>
                        <div class="facility-name">AC</div>
                        <div class="facility-desc">Pendingin di setiap ruang</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-1">
                    <div class="facility-card">
                        <div class="facility-icon"><i class="bi bi-car-front-fill"></i></div>
                        <div class="facility-name">Parkir Luas</div>
                        <div class="facility-desc">Area parkir aman</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-2">
                    <div class="facility-card">
                        <div class="facility-icon"><i class="bi bi-egg-fried"></i></div>
                        <div class="facility-name">Dapur Lengkap</div>
                        <div class="facility-desc">Fully equipped kitchen</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ TESTIMONIALS ══ --}}
    <section class="testimonial-section" id="testimoni">
        <div class="container">
            <div class="sec-header-center fade-up">
                <span class="sec-label">Testimoni</span>
                <h2 class="sec-title">Kata Tamu Kami</h2>
                <p class="sec-desc">Kepuasan tamu adalah prioritas utama kami. Berikut cerita mereka.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 d-flex fade-up delay-1">
                    <div class="testimonial-card w-100">
                        <div class="t-stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="t-quote">"Pengalaman luar biasa! Villa sangat bersih, fasilitas lengkap, dan pemandangannya memukau. Staf juga sangat ramah dan profesional. Pasti akan kembali lagi!"</p>
                        <div class="t-author">
                            <div class="t-avatar" style="background:#E8F5E9;">R</div>
                            <div>
                                <div class="t-name">Rina Kusuma</div>
                                <div class="t-city"><i class="bi bi-geo-alt-fill"></i> Jakarta</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex fade-up delay-2">
                    <div class="testimonial-card w-100">
                        <div class="t-stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="t-quote">"Kami merayakan anniversary di sini dan sungguh tidak menyesal. Suasana romantis, private pool yang jernih, kamar yang nyaman sekali. Recommended banget untuk pasangan!"</p>
                        <div class="t-author">
                            <div class="t-avatar" style="background:#FFF3E0;">B</div>
                            <div>
                                <div class="t-name">Budi Santoso</div>
                                <div class="t-city"><i class="bi bi-geo-alt-fill"></i> Surabaya</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex fade-up delay-3">
                    <div class="testimonial-card w-100">
                        <div class="t-stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                        </div>
                        <p class="t-quote">"Family gathering paling berkesan! Villa Surya cocok untuk rombongan besar. Anak-anak senang main di pool, orang tua santai di beranda. Worth every penny!"</p>
                        <div class="t-author">
                            <div class="t-avatar" style="background:#E3F2FD;">D</div>
                            <div>
                                <div class="t-name">Dewi Anggraini</div>
                                <div class="t-city"><i class="bi bi-geo-alt-fill"></i> Bandung</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ CTA ══ --}}
    <section class="cta-section" id="kontak">
        <div class="cta-bg"></div>
        <div class="cta-overlay"></div>
        <div class="container">
            <div class="cta-inner fade-up">
                <span class="sec-label" style="color:var(--accent-light);">Reservasi Sekarang</span>
                <h2 class="cta-title">Siap Menikmati<br>Pengalaman Istimewa?</h2>
                <p class="cta-desc">Hubungi kami sekarang dan wujudkan liburan impian Anda bersama Athara Villas.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="btn-primary-gold">
                        <i class="bi bi-whatsapp"></i> Chat WhatsApp
                    </a>
                    <a href="tel:+6281234567890" class="btn-outline-white">
                        <i class="bi bi-telephone-fill"></i> Telepon Kami
                    </a>
                </div>
                <div class="cta-trust">
                    <span><i class="bi bi-clock-fill"></i> Respon dalam 1 jam</span>
                    <span><i class="bi bi-shield-check-fill"></i> Pembayaran aman & terjamin</span>
                    <span><i class="bi bi-calendar-check-fill"></i> Reservasi fleksibel</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ FOOTER ══ --}}
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-4 col-md-6">
                    <span class="footer-brand">Athara Villas</span>
                    <span class="footer-tagline">Premium Villa Experience</span>
                    <p class="footer-about">
                        Menghadirkan pengalaman menginap mewah dan tak terlupakan di villa-villa terbaik kami. Kepuasan Anda adalah kebahagiaan kami.
                    </p>
                    <div class="social-row">
                        <a href="#" class="social-icon" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                        <a href="#" class="social-icon" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-6">
                    <div class="footer-heading">Menu</div>
                    <ul class="footer-nav">
                        <li><a href="{{ route('landing') }}">Beranda</a></li>
                        <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('villa.index') }}">Koleksi Villa</a></li>
                        <li><a href="{{ route('fasilitas') }}">Fasilitas</a></li>
                        <li><a href="{{ route('testimoni') }}">Testimoni</a></li>
                        <li><a href="{{ route('kontak') }}">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 col-6">
                    <div class="footer-heading">Villa</div>
                    <ul class="footer-nav">
                        @forelse($footerVillas as $fv)
                        <li><a href="{{ route('villa.show', $fv->id) }}">{{ $fv->name }}</a></li>
                        @empty
                        <li><span class="text-muted">Belum ada villa</span></li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-heading">Kontak</div>
                    <div class="contact-row">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Jl. Raya Villa No. 123, Batu, Malang, Jawa Timur 65314</span>
                    </div>
                    <div class="contact-row">
                        <i class="bi bi-telephone-fill"></i>
                        <span>+62 812-3456-7890</span>
                    </div>
                    <div class="contact-row">
                        <i class="bi bi-envelope-fill"></i>
                        <span>info@atharavillas.com</span>
                    </div>
                    <div class="contact-row">
                        <i class="bi bi-clock-fill"></i>
                        <span>Check-in: 14.00 &nbsp;|&nbsp; Check-out: 12.00</span>
                    </div>
                </div>
            </div>

            <hr class="footer-divider">

            <div class="footer-bottom">
                <span class="footer-copy">&copy; {{ date('Y') }} Athara Villas. All rights reserved.</span>
                <div class="footer-policy">
                    <a href="#">Kebijakan Privasi</a>
                    <a href="#">Syarat &amp; Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // ── Navbar scroll ──
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 60);
        }, { passive: true });

        // ── Mobile nav toggle ──
        document.getElementById('navToggler').addEventListener('click', () => {
            document.getElementById('navCollapse').classList.toggle('open');
        });

        // Close mobile nav on link click
        document.querySelectorAll('#navCollapse a').forEach(a => {
            a.addEventListener('click', () => {
                document.getElementById('navCollapse').classList.remove('open');
            });
        });

        // ── Hero bg parallax load ──
        const heroBg = document.getElementById('heroBg');
        setTimeout(() => heroBg.classList.add('loaded'), 80);

        // ── Fade on scroll (IntersectionObserver) ──
        const observer = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    observer.unobserve(e.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    </script>
</body>
</html>
