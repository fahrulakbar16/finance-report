@extends('layouts.search')

@section('title', $villa->name . ' - Athara Villas')
@section('description', Str::limit($villa->description, 155))

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* ── Variables (inherit from layout, add surface) ── */
    :root { --surface: #ffffff; }

    /* ── Hero Gallery Slider ── */
    .vd-gallery { padding: 1.5rem 0 0; }
    .vd-gallery-slider {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
    }
    .vd-gallery-track {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .vd-gallery-track::-webkit-scrollbar { display: none; }
    .vd-gallery-slide {
        flex: 0 0 100%;
        scroll-snap-align: start;
        position: relative;
        height: 420px;
        cursor: pointer;
    }
    .vd-gallery-slide img {
        width: 100%; height: 100%;
        object-fit: cover; display: block;
    }
    /* Slider nav arrows */
    .vd-gallery-nav {
        position: absolute; top: 50%; transform: translateY(-50%);
        width: 42px; height: 42px; border-radius: 50%;
        background: rgba(255,255,255,0.85); border: none;
        display: flex; align-items: center; justify-content: center;
        color: var(--primary); font-size: 1.1rem;
        cursor: pointer; z-index: 5;
        box-shadow: 0 2px 10px rgba(0,0,0,0.12);
        transition: all 0.3s;
        backdrop-filter: blur(4px);
    }
    .vd-gallery-nav:hover { background: #fff; box-shadow: 0 4px 16px rgba(0,0,0,0.18); }
    .vd-gallery-prev { left: 1rem; }
    .vd-gallery-next { right: 1rem; }
    /* Dots */
    .vd-gallery-dots {
        position: absolute; bottom: 1rem; left: 50%;
        transform: translateX(-50%);
        display: flex; gap: 0.4rem; z-index: 5;
    }
    .vd-gallery-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: rgba(255,255,255,0.5);
        border: none; cursor: pointer;
        transition: all 0.3s;
        padding: 0;
    }
    .vd-gallery-dot.active {
        background: #fff;
        width: 24px; border-radius: 4px;
    }
    /* Counter badge */
    .vd-gallery-counter {
        position: absolute; top: 1rem; right: 1rem;
        background: rgba(0,0,0,0.55);
        color: #fff; font-size: 0.78rem; font-weight: 600;
        padding: 0.3rem 0.8rem; border-radius: 2rem;
        z-index: 5; backdrop-filter: blur(4px);
    }

    /* ── Quick Info Bar ── */
    .vd-quick-bar {
        display: flex; flex-wrap: wrap; gap: 0.75rem;
        padding: 1.25rem 0; margin-bottom: 0.5rem;
    }
    .vd-quick-chip {
        display: inline-flex; align-items: center; gap: 0.45rem;
        background: var(--bg-section);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.82rem; font-weight: 500;
        color: var(--text-dark);
    }
    .vd-quick-chip i { color: var(--accent); font-size: 0.9rem; }

    /* ── Page Content ── */
    .vd-content { padding: 1rem 0 5rem; }
    .vd-content-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
        align-items: start;
    }

    /* ── Left Column ── */
    .vd-section-card {
        background: var(--surface);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }
    .vd-section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: 0.6rem;
    }
    .vd-section-title i {
        color: var(--accent); font-size: 1.1rem;
    }

    /* Title area */
    .vd-title-wrap {
        margin-bottom: 0.5rem;
    }
    .vd-villa-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.3rem;
        line-height: 1.2;
    }
    .vd-villa-address {
        display: flex; align-items: center; gap: 0.4rem;
        color: var(--text-muted); font-size: 0.9rem;
        margin-bottom: 0;
    }
    .vd-villa-address i { color: var(--accent); }

    /* Description */
    .vd-desc {
        color: var(--text-muted);
        line-height: 1.85;
        font-size: 0.93rem;
    }
    .vd-desc-toggle {
        display: inline-block; margin-top: 0.5rem;
        color: var(--accent); font-weight: 600; font-size: 0.85rem;
        cursor: pointer; border: none; background: none; padding: 0;
        transition: color 0.3s;
    }
    .vd-desc-toggle:hover { color: var(--primary); }

    /* Facilities Grid */
    .vd-fac-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 0.75rem;
    }
    .vd-fac-item {
        display: flex; align-items: center; gap: 0.75rem;
        background: var(--bg-section);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        font-size: 0.88rem;
        font-weight: 500;
        color: var(--text-dark);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .vd-fac-item:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
    .vd-fac-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: rgba(201,168,76,0.12);
        display: flex; align-items: center; justify-content: center;
        color: var(--accent); font-size: 1rem;
        flex-shrink: 0;
    }

    /* Address */
    .vd-address-box {
        display: flex; align-items: flex-start; gap: 1rem;
    }
    .vd-address-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        background: rgba(201,168,76,0.12);
        display: flex; align-items: center; justify-content: center;
        color: var(--accent); font-size: 1.25rem;
        flex-shrink: 0;
    }
    .vd-address-text { font-size: 0.93rem; line-height: 1.65; color: var(--text-dark); }
    .vd-address-label { font-size: 0.78rem; color: var(--text-muted); font-weight: 500; margin-bottom: 0.15rem; }

    /* Map embed */
    .vd-map-wrap {
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(0,0,0,0.06);
        position: relative;
        background: var(--bg-section);
    }
    .vd-map-wrap iframe {
        width: 100%; height: 280px;
        border: 0; display: block;
    }
    .vd-map-overlay {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,0.03);
        pointer-events: none;
        opacity: 0; transition: opacity 0.3s;
    }
    .vd-map-wrap:hover .vd-map-overlay { opacity: 0; }

    /* ── Right Column — Booking Panel ── */
    .vd-booking-panel {
        position: sticky; top: 90px;
        background: var(--surface);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 25px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .vd-price-tag {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1;
    }
    .vd-price-unit { font-size: 0.82rem; font-weight: 400; color: var(--text-muted); }
    .vd-price-label { font-size: 0.78rem; color: var(--text-muted); margin-bottom: 0.2rem; }

    .vd-panel-divider { border: none; border-top: 1px solid rgba(0,0,0,0.06); margin: 1.25rem 0; }

    .vd-panel-stat {
        display: flex; align-items: center; gap: 0.85rem;
        padding: 0.85rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.04);
    }
    .vd-panel-stat:last-of-type { border-bottom: none; }
    .vd-panel-stat-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: rgba(201,168,76,0.1);
        display: flex; align-items: center; justify-content: center;
        color: var(--accent); font-size: 1rem;
        flex-shrink: 0;
    }
    .vd-panel-stat-label { font-size: 0.76rem; color: var(--text-muted); }
    .vd-panel-stat-value { font-size: 0.9rem; font-weight: 600; color: var(--text-dark); }

    .vd-btn-primary {
        display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        width: 100%;
        background: var(--primary);
        color: #fff; border: none;
        padding: 0.85rem 1.5rem;
        border-radius: 12px;
        font-weight: 600; font-size: 0.95rem;
        text-decoration: none;
        transition: background 0.3s, transform 0.2s;
        cursor: pointer;
    }
    .vd-btn-primary:hover { background: var(--primary-light); color: #fff; transform: translateY(-1px); }

    .vd-btn-outline {
        display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        width: 100%;
        background: transparent;
        color: var(--primary);
        border: 1.5px solid rgba(0,0,0,0.12);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600; font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    .vd-btn-outline:hover { border-color: var(--accent); color: var(--accent); }

    /* Date Picker */
    .vd-date-picker {
        position: relative;
        display: flex; border: 1px solid rgba(0,0,0,0.15); border-radius: 12px; overflow: hidden;
        margin-bottom: 1rem; cursor: pointer;
    }
    .vd-date-input {
        flex: 1; padding: 0.65rem 1rem;
        background: var(--surface); transition: background 0.2s;
    }
    .vd-date-input:first-child { border-right: 1px solid rgba(0,0,0,0.15); }
    .vd-date-input:hover { background: rgba(0,0,0,0.02); }
    .vd-date-input label { display: block; font-size: 0.65rem; font-weight: 700; color: var(--primary); margin-bottom: 0.15rem; }
    .vd-date-val { font-size: 0.9rem; color: var(--text-muted); }
    .vd-date-val.selected { color: var(--text-dark); font-weight: 600; }

    .vd-check-times {
        display: flex; justify-content: center; gap: 1.5rem;
        margin-top: 1rem;
        font-size: 0.78rem; color: var(--text-muted);
    }
    .vd-check-times i { color: var(--accent); margin-right: 0.3rem; }

    /* ── Related Slider ── */
    .vd-related { padding: 4rem 0 5rem; background: var(--bg-section); }
    .vd-related-header {
        display: flex; align-items: flex-end; justify-content: space-between;
        margin-bottom: 2rem;
    }
    .vd-related-title { margin-bottom: 0; }
    .vd-related-title span {
        display: block;
        font-size: 0.78rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 600;
        margin-bottom: 0.35rem;
    }
    .vd-related-title h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem; font-weight: 700;
        color: var(--primary); margin-bottom: 0;
    }
    .vd-slider-navs {
        display: flex; gap: 0.5rem; flex-shrink: 0;
    }
    .vd-slider-btn {
        width: 44px; height: 44px;
        border-radius: 50%;
        background: var(--surface);
        border: 1px solid rgba(0,0,0,0.08);
        display: flex; align-items: center; justify-content: center;
        color: var(--primary); font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .vd-slider-btn:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
    .vd-slider-btn:disabled { opacity: 0.35; cursor: default; pointer-events: none; }

    .vd-slider-track {
        display: flex;
        gap: 1.25rem;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 0.5rem;
        /* hide scrollbar */
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .vd-slider-track::-webkit-scrollbar { display: none; }

    .vd-slider-slide {
        flex: 0 0 calc(33.333% - 0.85rem);
        scroll-snap-align: start;
        min-width: 0;
    }

    .vd-rcard {
        background: var(--surface);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        display: flex; flex-direction: column;
    }
    .vd-rcard:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .vd-rcard-img { height: 200px; overflow: hidden; }
    .vd-rcard-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .vd-rcard:hover .vd-rcard-img img { transform: scale(1.06); }
    .vd-rcard-body { padding: 1.25rem 1.5rem; flex: 1; display: flex; flex-direction: column; }
    .vd-rcard-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem; font-weight: 700; color: var(--primary);
        margin-bottom: 0.3rem;
    }
    .vd-rcard-addr { font-size: 0.82rem; color: var(--text-muted); margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.3rem; }
    .vd-rcard-addr i { color: var(--accent); }
    .vd-rcard-link {
        margin-top: auto;
        color: var(--accent); font-weight: 600; font-size: 0.88rem;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 0.3rem;
        transition: gap 0.3s;
    }
    .vd-rcard-link:hover { gap: 0.65rem; }

    @media (max-width: 991px) {
        .vd-slider-slide { flex: 0 0 calc(50% - 0.65rem); }
    }
    @media (max-width: 768px) {
        .vd-slider-slide { flex: 0 0 80%; }
        .vd-slider-navs { display: none; }
        .vd-related-header { text-align: center; justify-content: center; }
        .vd-related-title span, .vd-related-title h2 { text-align: center; }
    }

    /* ── Mobile Top Bar ── */
    .vd-mobile-topbar {
        display: none;
        position: fixed; top: 0; left: 0; right: 0;
        background: var(--surface);
        padding: 0.75rem 1rem;
        z-index: 1001;
        align-items: center; gap: 0.75rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .vd-back-btn {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: var(--bg-section);
        border: none;
        display: flex; align-items: center; justify-content: center;
        color: var(--primary); font-size: 1.1rem;
        cursor: pointer;
        transition: background 0.3s;
        text-decoration: none;
        flex-shrink: 0;
    }
    .vd-back-btn:hover { background: rgba(201,168,76,0.15); color: var(--accent); }
    .vd-topbar-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem; font-weight: 700;
        color: var(--primary);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    /* ── Mobile Bottom Bar ── */
    .vd-mobile-bar {
        display: none;
        position: fixed; bottom: 0; left: 0; right: 0;
        background: var(--surface);
        padding: 0.85rem 1.25rem;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
        z-index: 1001;
        align-items: center; justify-content: space-between;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    .vd-mobile-bar-price { font-size: 0.78rem; color: var(--text-muted); }
    .vd-mobile-bar-price strong {
        display: block;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        color: var(--primary);
        font-weight: 700;
    }
    .vd-mobile-bar .vd-btn-primary { width: auto; padding: 0.7rem 1.5rem; font-size: 0.88rem; }

    /* ── Lightbox ── */
    .vd-lightbox {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.92); z-index: 9999;
        align-items: center; justify-content: center;
        padding: 2rem;
    }
    .vd-lightbox.active { display: flex; }
    .vd-lightbox img { max-width: 90%; max-height: 85vh; object-fit: contain; border-radius: 12px; }
    .vd-lightbox-close {
        position: absolute; top: 1.5rem; right: 1.5rem;
        background: rgba(255,255,255,0.15); border: none;
        width: 44px; height: 44px; border-radius: 50%;
        color: #fff; font-size: 1.3rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.3s;
    }
    .vd-lightbox-close:hover { background: rgba(255,255,255,0.3); }
    .vd-lightbox-nav {
        position: absolute; top: 50%; transform: translateY(-50%);
        background: rgba(255,255,255,0.15); border: none;
        width: 48px; height: 48px; border-radius: 50%;
        color: #fff; font-size: 1.3rem; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.3s;
    }
    .vd-lightbox-nav:hover { background: rgba(255,255,255,0.3); }
    .vd-lightbox-prev { left: 1.5rem; }
    .vd-lightbox-next { right: 1.5rem; }

    /* ── Responsive ── */
    @media (max-width: 991px) {
        .vd-content-grid { grid-template-columns: 1fr; }
        .vd-booking-panel { position: static; margin-top: 1.5rem; margin-bottom: 2rem; }
        /* Hide redundant panel sections on mobile since they are in main content or bottom bar */
        .vd-booking-panel > .vd-panel-stat,
        .vd-booking-panel > .vd-btn-primary,
        .vd-booking-panel > .vd-btn-outline,
        .vd-booking-panel > .vd-panel-divider,
        .vd-booking-panel > div[style*="uppercase"] { display: none !important; }
        .vd-mobile-bar { display: flex; }
        .vd-villa-name { font-size: 1.8rem; }
        .vd-gallery-slide { height: 340px; }
    }
    @media (max-width: 768px) {
        /* Hide layout bottom nav & top nav on mobile */
        .bottom-nav { display: none !important; }
        .site-nav { display: none !important; }
        body { padding-top: 0; padding-bottom: 0; }

        .vd-mobile-topbar { display: flex; }
        .vd-gallery { padding-top: calc(54px + 0.75rem); }
        .vd-gallery-slider { border-radius: 14px; }
        .vd-gallery-slide { height: 240px; }
        .vd-gallery-nav { width: 34px; height: 34px; font-size: 0.9rem; }
        .vd-gallery-prev { left: 0.6rem; }
        .vd-gallery-next { right: 0.6rem; }

        .vd-section-card { padding: 1.5rem; border-radius: 16px; }
        .vd-fac-grid { grid-template-columns: 1fr 1fr; }
        .vd-quick-bar { gap: 0.5rem; }
        .vd-quick-chip { padding: 0.4rem 0.75rem; font-size: 0.78rem; }
        .vd-content { padding: 0.5rem 0 5rem; }
        .vd-related { padding: 3rem 0 6rem; }
    }

    /* ── Fade-in animation ── */
    .vd-fade {
        opacity: 0; transform: translateY(20px);
        animation: vdFadeIn 0.6s ease forwards;
    }
    .vd-d1 { animation-delay: 0.1s; }
    .vd-d2 { animation-delay: 0.2s; }
    .vd-d3 { animation-delay: 0.3s; }
    .vd-d4 { animation-delay: 0.4s; }
    @keyframes vdFadeIn {
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')

@php
    $allImages = collect();
    // Gallery images from VillaGallery
    foreach($villa->galleries ?? [] as $g) {
        $gUrl = filter_var($g->image, FILTER_VALIDATE_URL) ? $g->image : asset('storage/' . $g->image);
        $allImages->push($gUrl);
    }
    // Fallback: use villa main image if no gallery images
    if($allImages->isEmpty() && $villa->image) {
        $allImages->push(filter_var($villa->image, FILTER_VALIDATE_URL) ? $villa->image : asset('storage/' . $villa->image));
    }
    $roomCount = $villa->rooms->count();
@endphp

{{-- ══ MOBILE TOP BAR ══ --}}
<div class="vd-mobile-topbar">
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('villa.index') }}" class="vd-back-btn"><i class="bi bi-arrow-left"></i></a>
    <div class="vd-topbar-title">{{ $villa->name }}</div>
</div>

{{-- ══ GALLERY SLIDER ══ --}}
<section class="vd-gallery">
    <div class="container">
        <div class="vd-gallery-slider vd-fade" id="gallerySlider">
            <div class="vd-gallery-track" id="galleryTrack">
                @foreach($allImages as $idx => $img)
                <div class="vd-gallery-slide" onclick="openLightbox({{ $idx }})">
                    <img src="{{ $img }}" alt="{{ $villa->name }} - Foto {{ $idx + 1 }}" loading="{{ $idx === 0 ? 'eager' : 'lazy' }}">
                </div>
                @endforeach
            </div>

            @if($allImages->count() > 1)
            <button class="vd-gallery-nav vd-gallery-prev" id="galleryPrev"><i class="bi bi-chevron-left"></i></button>
            <button class="vd-gallery-nav vd-gallery-next" id="galleryNext"><i class="bi bi-chevron-right"></i></button>

            <div class="vd-gallery-dots" id="galleryDots">
                @foreach($allImages as $idx => $img)
                <button class="vd-gallery-dot {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}"></button>
                @endforeach
            </div>
            @endif

            <div class="vd-gallery-counter">
                <i class="bi bi-images me-1"></i> <span id="galleryCurrentIdx">1</span> / {{ $allImages->count() }}
            </div>
        </div>
    </div>
</section>

{{-- ══ QUICK INFO BAR ══ --}}
<div class="container">
    <div class="vd-quick-bar vd-fade vd-d1">
        @foreach($villa->rooms as $room)
            <div class="vd-quick-chip"><i class="bi bi-check2-square"></i> {{ $room->amount }} {{ $room->name }}</div>
        @endforeach
        @if($villa->fasilitas && $villa->fasilitas->count())
            <div class="vd-quick-chip"><i class="bi bi-grid-fill"></i> {{ $villa->fasilitas->count() }} Fasilitas</div>
        @endif
        @if($villa->price)
            <div class="vd-quick-chip"><i class="bi bi-tag-fill"></i> Mulai Rp {{ number_format($villa->price, 0, ',', '.') }}</div>
        @endif
        <div class="vd-quick-chip"><i class="bi bi-geo-alt-fill"></i> {{ Str::limit($villa->address, 35) }}</div>
    </div>
</div>

{{-- ══ MAIN CONTENT ══ --}}
<section class="vd-content">
    <div class="container">
        <div class="vd-content-grid">

            {{-- LEFT COLUMN --}}
            <div>
                {{-- Title & Description --}}
                <div class="vd-section-card vd-fade vd-d1">
                    <div class="vd-title-wrap">
                        <h1 class="vd-villa-name">{{ $villa->name }}</h1>
                        <p class="vd-villa-address"><i class="bi bi-geo-alt-fill"></i> {{ $villa->address }}</p>
                    </div>

                    <hr class="vd-panel-divider">

                    <div class="vd-section-title"><i class="bi bi-journal-text"></i> Tentang Villa</div>
                    <div class="vd-desc" id="villaDesc">
                        <span id="descShort">{{ Str::limit($villa->description, 250) }}</span>
                        <span id="descFull" style="display:none;">{{ $villa->description }}</span>
                    </div>
                    @if(strlen($villa->description) > 250)
                        <button class="vd-desc-toggle" id="descToggle" onclick="toggleDesc()">
                            Baca selengkapnya <i class="bi bi-chevron-down"></i>
                        </button>
                    @endif
                </div>


                {{-- Facilities --}}
                @if($villa->fasilitas && $villa->fasilitas->count())
                <div class="vd-section-card vd-fade vd-d3">
                    <div class="vd-section-title"><i class="bi bi-grid-1x2-fill"></i> Fasilitas Villa</div>
                    <div class="vd-fac-grid">
                        @foreach($villa->fasilitas as $fac)
                        <div class="vd-fac-item">
                            <div class="vd-fac-icon">
                                <i class="{{ $fac->ikon ?? 'bi bi-check-circle-fill' }}"></i>
                            </div>
                            {{ $fac->nama }}
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Address & Map --}}
                <div class="vd-section-card vd-fade vd-d4">
                    <div class="vd-section-title"><i class="bi bi-pin-map-fill"></i> Lokasi Villa</div>

                    @if($villa->latitude && $villa->longitude)
                    <div class="vd-map-wrap">
                        <iframe
                            src="https://www.openstreetmap.org/export/embed.html?bbox={{ $villa->longitude - 0.005 }},{{ $villa->latitude - 0.003 }},{{ $villa->longitude + 0.005 }},{{ $villa->latitude + 0.003 }}&layer=mapnik&marker={{ $villa->latitude }},{{ $villa->longitude }}"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    @endif

                    <div class="vd-address-box">
                        <div class="vd-address-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div class="vd-address-label">Alamat Lengkap</div>
                            <div class="vd-address-text">{{ $villa->address }}</div>
                        </div>
                    </div>

                    @if($villa->latitude && $villa->longitude)
                    <div style="margin-top: 1.25rem; display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        <a href="https://www.google.com/maps?q={{ $villa->latitude }},{{ $villa->longitude }}"
                           target="_blank" class="vd-btn-outline" style="width: auto; display: inline-flex; padding: 0.55rem 1.25rem; font-size: 0.85rem;">
                            <i class="bi bi-google"></i> Buka di Google Maps
                        </a>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $villa->latitude }},{{ $villa->longitude }}"
                           target="_blank" class="vd-btn-outline" style="width: auto; display: inline-flex; padding: 0.55rem 1.25rem; font-size: 0.85rem;">
                            <i class="bi bi-signpost-2"></i> Petunjuk Arah
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT COLUMN — Booking Panel (PC) --}}
            <div>
                <div class="vd-booking-panel vd-fade vd-d2">
                    @if($villa->price)
                    <div class="vd-price-label">Harga mulai dari</div>
                    <div class="vd-price-tag" style="margin-bottom: 1.25rem;">
                        Rp {{ number_format($villa->price, 0, ',', '.') }}
                        <span class="vd-price-unit">/ malam</span>
                    </div>

                    <!-- Date Range Picker -->
                    <div class="vd-date-picker">
                        <div class="vd-date-input" id="vdCheckinBtn">
                            <label>CHECK-IN</label>
                            <div class="vd-date-val" id="vdCheckinVal">Pilih tanggal</div>
                        </div>
                        <div class="vd-date-input" id="vdCheckoutBtn">
                            <label>CHECK-OUT</label>
                            <div class="vd-date-val" id="vdCheckoutVal">Pilih tanggal</div>
                        </div>
                        <input type="text" id="vdDateRange" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; pointer-events: none; margin: 0; padding: 0; border: none;">
                    </div>

                    <!-- Total Price Breakdown (Hidden by default) -->
                    <div id="vdBookingTotal" style="display: none; margin-bottom: 1.25rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span style="color: var(--text-dark); font-size: 0.93rem;" id="vdNightsText">0 malam x Rp 0</span>
                            <span style="font-weight: 600; color: var(--text-dark);" id="vdNightsPrice">Rp 0</span>
                        </div>
                        <hr class="vd-panel-divider" style="margin: 0.85rem 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <strong style="font-size: 1rem; color: var(--primary);">Total Pembayaran</strong>
                            <strong style="font-size: 1.25rem; color: var(--primary);" id="vdTotalPrice">Rp 0</strong>
                        </div>
                    </div>
                    @endif

                    <div style="font-size: 0.82rem; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; letter-spacing: 0.5px; text-transform: uppercase;">Informasi Villa</div>

                    <div class="vd-panel-stat">
                        <div class="vd-panel-stat-icon"><i class="bi bi-house-door-fill"></i></div>
                        <div>
                            <div class="vd-panel-stat-label">Jumlah Ruangan</div>
                            <div class="vd-panel-stat-value">{{ $roomCount }} Ruangan</div>
                        </div>
                    </div>
                    @if($villa->fasilitas && $villa->fasilitas->count())
                    <div class="vd-panel-stat">
                        <div class="vd-panel-stat-icon"><i class="bi bi-grid-fill"></i></div>
                        <div>
                            <div class="vd-panel-stat-label">Fasilitas</div>
                            <div class="vd-panel-stat-value">{{ $villa->fasilitas->count() }} Fasilitas</div>
                        </div>
                    </div>
                    @endif
                    @if($villa->galleries && $villa->galleries->count())
                    <div class="vd-panel-stat">
                        <div class="vd-panel-stat-icon"><i class="bi bi-images"></i></div>
                        <div>
                            <div class="vd-panel-stat-label">Galeri</div>
                            <div class="vd-panel-stat-value">{{ $allImages->count() }} Foto</div>
                        </div>
                    </div>
                    @endif

                    <hr class="vd-panel-divider">

                    <a href="javascript:Swal.fire({icon:'warning', title:'Perhatian', text:'Silakan pilih tanggal Check-in dan Check-out terlebih dahulu', confirmButtonColor:'#C9A84C'})" class="vd-btn-primary mb-2" id="vdPesanBtn">
                        <i class="bi bi-calendar-check"></i> Pesan
                    </a>
                    <a href="{{ route('kontak') }}" class="vd-btn-outline">
                        <i class="bi bi-chat-dots"></i> Tanya Dulu
                    </a>

                    <div class="vd-check-times">
                        <span><i class="bi bi-box-arrow-in-right"></i> Check-in 14.00</span>
                        <span><i class="bi bi-box-arrow-right"></i> Check-out 12.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ MOBILE BOTTOM BAR ══ --}}
<div class="vd-mobile-bar">
    <div class="vd-mobile-bar-price" id="vdMobilePriceText">
        @if($villa->price)
            Mulai dari
            <strong>Rp {{ number_format($villa->price, 0, ',', '.') }} <span style="font-size: 0.7rem; font-weight: 400; color: var(--text-muted);">/ malam</span></strong>
        @else
            <strong>Hubungi Kami</strong>
        @endif
    </div>
    <a href="javascript:Swal.fire({icon:'warning', title:'Perhatian', text:'Silakan pilih tanggal Check-in dan Check-out terlebih dahulu', confirmButtonColor:'#C9A84C'})" class="vd-btn-primary" id="vdMobilePesanBtn">
        <i class="bi bi-calendar-check"></i> Pesan
    </a>
</div>

{{-- ══ RELATED VILLAS (SLIDER) ══ --}}
@if(count($related))
<section class="vd-related">
    <div class="container">
        <div class="vd-related-header vd-fade">
            <div class="vd-related-title">
                <span>Villa Lainnya</span>
                <h2>Mungkin Anda Juga Suka</h2>
            </div>
            <div class="vd-slider-navs">
                <button class="vd-slider-btn" id="sliderPrev" aria-label="Previous"><i class="bi bi-arrow-left"></i></button>
                <button class="vd-slider-btn" id="sliderNext" aria-label="Next"><i class="bi bi-arrow-right"></i></button>
            </div>
        </div>

        <div class="vd-slider-track vd-fade vd-d1" id="relatedSlider">
            @foreach($related as $r)
            <div class="vd-slider-slide">
                <a href="{{ route('villa.show', $r->id) }}" class="text-decoration-none">
                    <div class="vd-rcard">
                        <div class="vd-rcard-img">
                            <img src="{{ filter_var($r->image, FILTER_VALIDATE_URL) ? $r->image : asset('storage/' . $r->image) }}" alt="{{ $r->name }}" loading="lazy">
                        </div>
                        <div class="vd-rcard-body">
                            <h3 class="vd-rcard-name">{{ $r->name }}</h3>
                            <div class="vd-rcard-addr"><i class="bi bi-geo-alt-fill"></i> {{ Str::limit($r->address, 30) }}</div>
                            <span class="vd-rcard-link">Lihat Detail <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══ LIGHTBOX ══ --}}
<div class="vd-lightbox" id="vdLightbox">
    <button class="vd-lightbox-close" onclick="closeLightbox()"><i class="bi bi-x-lg"></i></button>
    <button class="vd-lightbox-nav vd-lightbox-prev" onclick="navLightbox(-1)"><i class="bi bi-chevron-left"></i></button>
    <img src="" alt="Gallery" id="vdLightboxImg">
    <button class="vd-lightbox-nav vd-lightbox-next" onclick="navLightbox(1)"><i class="bi bi-chevron-right"></i></button>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    // Date Picker & Pricing Logic
    const basePrice = {{ $villa->price ?? 0 }};
    const formatRp = (num) => 'Rp ' + new Intl.NumberFormat('id-ID').format(num);

    if (basePrice > 0 && document.getElementById('vdDateRange')) {
        let defaultDates = [];
        @if(request('checkin')) defaultDates.push("{{ request('checkin') }}"); @endif
        @if(request('checkout')) defaultDates.push("{{ request('checkout') }}"); @endif

        const fp = flatpickr("#vdDateRange", {
            mode: "range",
            minDate: "today",
            locale: "id",
            showMonths: window.innerWidth > 768 ? 2 : 1,
            dateFormat: "Y-m-d",
            defaultDate: defaultDates.length > 0 ? defaultDates : null,
            onReady: function(selectedDates) {
                if (selectedDates.length > 0) {
                    updateBookingInfo(selectedDates);
                }
            },
            onChange: function(selectedDates) {
                updateBookingInfo(selectedDates);
            }
        });

        function updateBookingInfo(selectedDates) {
            const checkinVal = document.getElementById('vdCheckinVal');
            const checkoutVal = document.getElementById('vdCheckoutVal');
            
            if (selectedDates && selectedDates.length > 0) {
                checkinVal.textContent = flatpickr.formatDate(selectedDates[0], "d M Y");
                checkinVal.classList.add('selected');
            } else {
                checkinVal.textContent = "Pilih tanggal";
                checkinVal.classList.remove('selected');
            }

            if (selectedDates && selectedDates.length === 2) {
                checkoutVal.textContent = flatpickr.formatDate(selectedDates[1], "d M Y");
                checkoutVal.classList.add('selected');

                // Calculate nights
                const diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (diffDays > 0) {
                    const total = diffDays * basePrice;
                    document.getElementById('vdBookingTotal').style.display = 'block';
                    document.getElementById('vdNightsText').textContent = diffDays + ' malam x ' + formatRp(basePrice);
                    document.getElementById('vdNightsPrice').textContent = formatRp(total);
                    document.getElementById('vdTotalPrice').textContent = formatRp(total);
                    
                    // Update message for checkout link
                    const waBtn = document.getElementById('vdPesanBtn');
                    const waMobileBtn = document.getElementById('vdMobilePesanBtn');
                    
                    const checkinStr = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                    const checkoutStr = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                    
                    const url = `{{ route('checkout.index') }}?villa_id={{ $villa->id }}&checkin=${checkinStr}&checkout=${checkoutStr}`;
                    
                    @auth
                        if (waBtn) waBtn.href = url;
                        if (waMobileBtn) waMobileBtn.href = url;
                    @else
                        const loginAlert = `javascript:Swal.fire({
                            icon:'info', 
                            title:'Harap Login', 
                            text:'Anda harus login terlebih dahulu untuk melakukan pemesanan.', 
                            showCancelButton: true,
                            confirmButtonText:'Login Sekarang',
                            cancelButtonText:'Batal',
                            confirmButtonColor:'#C9A84C'
                        }).then((result) => { 
                            if(result.isConfirmed) { 
                                window.location.href = '${url}'; 
                            } 
                        })`;
                        if (waBtn) waBtn.href = loginAlert;
                        if (waMobileBtn) waMobileBtn.href = loginAlert;
                    @endauth

                    // Update mobile sticky bar price text
                    const mobilePriceText = document.getElementById('vdMobilePriceText');
                    if (mobilePriceText) {
                        mobilePriceText.innerHTML = `Total Pembayaran<br><strong>${formatRp(total)}</strong> <span style="font-size: 0.7rem; font-weight: 400; color: var(--text-muted);">/ ${diffDays} malam</span>`;
                    }
                }
            } else {
                if (checkoutVal) {
                    checkoutVal.textContent = "Pilih tanggal";
                    checkoutVal.classList.remove('selected');
                }
                document.getElementById('vdBookingTotal').style.display = 'none';
                
                const emptyUrl = `javascript:Swal.fire({icon:'warning', title:'Perhatian', text:'Silakan pilih tanggal Check-in dan Check-out terlebih dahulu', confirmButtonColor:'#C9A84C'})`;
                const waBtn = document.getElementById('vdPesanBtn');
                const waMobileBtn = document.getElementById('vdMobilePesanBtn');
                if (waBtn) waBtn.href = emptyUrl;
                if (waMobileBtn) waMobileBtn.href = emptyUrl;

                const mobilePriceText = document.getElementById('vdMobilePriceText');
                if (mobilePriceText) {
                    mobilePriceText.innerHTML = `Mulai dari<br><strong>${formatRp(basePrice)} <span style="font-size: 0.7rem; font-weight: 400; color: var(--text-muted);">/ malam</span></strong>`;
                }
            }
        }

        // Bind clicks
        document.getElementById('vdCheckinBtn').addEventListener('click', () => document.getElementById('vdDateRange')._flatpickr.open());
        document.getElementById('vdCheckoutBtn').addEventListener('click', () => document.getElementById('vdDateRange')._flatpickr.open());
    }

    // Description toggle
    function toggleDesc() {
        const short = document.getElementById('descShort');
        const full = document.getElementById('descFull');
        const btn = document.getElementById('descToggle');
        if (full.style.display === 'none') {
            short.style.display = 'none';
            full.style.display = 'inline';
            btn.innerHTML = 'Tutup <i class="bi bi-chevron-up"></i>';
        } else {
            short.style.display = 'inline';
            full.style.display = 'none';
            btn.innerHTML = 'Baca selengkapnya <i class="bi bi-chevron-down"></i>';
        }
    }

    // Lightbox
    const lbImages = @json($allImages->values());
    let lbIndex = 0;
    function openLightbox(i) {
        lbIndex = i;
        document.getElementById('vdLightboxImg').src = lbImages[lbIndex];
        document.getElementById('vdLightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
        document.getElementById('vdLightbox').classList.remove('active');
        document.body.style.overflow = '';
    }
    function navLightbox(dir) {
        lbIndex = (lbIndex + dir + lbImages.length) % lbImages.length;
        document.getElementById('vdLightboxImg').src = lbImages[lbIndex];
    }
    document.getElementById('vdLightbox').addEventListener('click', function(e) {
        if (e.target === this) closeLightbox();
    });
    document.addEventListener('keydown', function(e) {
        if (!document.getElementById('vdLightbox').classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navLightbox(-1);
        if (e.key === 'ArrowRight') navLightbox(1);
    });

    // Gallery slider
    (function() {
        const track = document.getElementById('galleryTrack');
        const prevBtn = document.getElementById('galleryPrev');
        const nextBtn = document.getElementById('galleryNext');
        const dots = document.querySelectorAll('.vd-gallery-dot');
        const counter = document.getElementById('galleryCurrentIdx');
        if (!track) return;

        const totalSlides = track.children.length;
        let currentSlide = 0;

        function goToSlide(idx) {
            currentSlide = Math.max(0, Math.min(idx, totalSlides - 1));
            const slideWidth = track.children[0].offsetWidth;
            track.scrollTo({ left: currentSlide * slideWidth, behavior: 'smooth' });
            updateUI();
        }

        function updateUI() {
            dots.forEach((d, i) => d.classList.toggle('active', i === currentSlide));
            if (counter) counter.textContent = currentSlide + 1;
        }

        if (prevBtn) prevBtn.addEventListener('click', () => goToSlide(currentSlide - 1));
        if (nextBtn) nextBtn.addEventListener('click', () => goToSlide(currentSlide + 1));
        dots.forEach(d => d.addEventListener('click', () => goToSlide(parseInt(d.dataset.index))));

        // Sync on scroll (for swipe)
        let scrollTimer;
        track.addEventListener('scroll', function() {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(() => {
                const slideWidth = track.children[0].offsetWidth;
                currentSlide = Math.round(track.scrollLeft / slideWidth);
                updateUI();
            }, 80);
        });
    })();

    // Related villas slider
    (function() {
        const track = document.getElementById('relatedSlider');
        const prevBtn = document.getElementById('sliderPrev');
        const nextBtn = document.getElementById('sliderNext');
        if (!track || !prevBtn || !nextBtn) return;

        function getSlideWidth() {
            const slide = track.querySelector('.vd-slider-slide');
            if (!slide) return 300;
            return slide.offsetWidth + parseFloat(getComputedStyle(track).gap || 20);
        }

        function updateBtns() {
            prevBtn.disabled = track.scrollLeft <= 5;
            nextBtn.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 5;
        }

        prevBtn.addEventListener('click', function() {
            track.scrollBy({ left: -getSlideWidth(), behavior: 'smooth' });
        });
        nextBtn.addEventListener('click', function() {
            track.scrollBy({ left: getSlideWidth(), behavior: 'smooth' });
        });

        track.addEventListener('scroll', updateBtns);
        window.addEventListener('resize', updateBtns);
        updateBtns();
    })();
</script>
@endsection
