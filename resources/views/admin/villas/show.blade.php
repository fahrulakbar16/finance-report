@extends('layouts.admin')

@section('page_title', 'Detail Villa: ' . $villa->name)

@section('content')
<!-- Include FullCalendar -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<style>
    /* ============================================
       VILLA DETAIL PAGE — PREMIUM DESIGN
    ============================================ */

    /* --- Hero Banner --- */
    .villa-hero {
        position: relative;
        background: var(--gradient-primary);
        border-radius: var(--radius-lg);
        padding: 2rem 2.25rem;
        margin-bottom: 1.75rem;
        overflow: hidden;
        box-shadow: var(--shadow-glow-primary);
    }
    .villa-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(201, 168, 76, 0.12);
    }
    .villa-hero::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 30%;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .villa-hero-content { position: relative; z-index: 1; }
    .villa-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(201, 168, 76, 0.2);
        border: 1px solid rgba(201, 168, 76, 0.4);
        color: var(--brand-accent-light);
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 0.3rem 0.75rem;
        border-radius: var(--radius-pill);
        margin-bottom: 0.6rem;
    }
    .villa-hero-title {
        font-size: 1.65rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.03em;
        margin-bottom: 0.25rem;
    }
    .villa-hero-price {
        font-size: 1rem;
        font-weight: 700;
        color: var(--brand-accent-light);
        margin-bottom: 0;
    }
    .hero-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.82rem;
        font-weight: 600;
        border-radius: var(--radius-sm);
        padding: 0.5rem 1.1rem;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        border: none;
        cursor: pointer;
        text-decoration: none;
    }
    .hero-action-btn:hover { transform: translateY(-2px); }
    .btn-hero-back {
        background: rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.85);
        border: 1px solid rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
    }
    .btn-hero-back:hover { background: rgba(255,255,255,0.18); color: #fff; }
    .btn-hero-edit {
        background: rgba(255,255,255,0.12);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
    }
    .btn-hero-edit:hover { background: rgba(255,255,255,0.22); color: #fff; }
    .btn-hero-laporan {
        background: var(--gradient-accent);
        color: var(--brand-primary);
        box-shadow: var(--shadow-glow-accent);
    }
    .btn-hero-laporan:hover { opacity: 0.9; color: var(--brand-primary); }

    /* --- Stat Mini Cards --- */
    .stat-mini-card {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: var(--radius-sm);
        padding: 0.65rem 1rem;
        backdrop-filter: blur(4px);
    }
    .stat-mini-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: rgba(255,255,255,0.55);
        font-weight: 600;
        display: block;
        margin-bottom: 0.15rem;
    }
    .stat-mini-value {
        font-size: 0.9rem;
        font-weight: 700;
        color: #fff;
    }

    /* --- Info Cards --- */
    .vi-card {
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-sm);
        transition: box-shadow 0.2s;
    }
    .vi-card:hover { box-shadow: var(--shadow-md); }
    .vi-card-header {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 1rem 1.25rem 0.75rem;
        border-bottom: 1px solid var(--border-subtle);
    }
    .vi-card-icon {
        width: 34px; height: 34px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .vi-card-icon.primary { background: rgba(27,61,47,0.08); color: var(--brand-primary); }
    .vi-card-icon.accent  { background: rgba(201,168,76,0.1);  color: #A37D2A; }
    .vi-card-icon.warning { background: rgba(249,115,22,0.1);  color: var(--warning); }

    .vi-card-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.01em;
    }
    .vi-card-body { padding: 1rem 1.25rem 1.25rem; }

    /* --- Field Labels & Values --- */
    .field-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: var(--text-tertiary);
        font-weight: 700;
        display: block;
        margin-bottom: 0.2rem;
    }
    .field-value {
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-primary);
    }
    .field-group {
        background: var(--bg-app);
        border-radius: var(--radius-sm);
        padding: 0.6rem 0.9rem;
    }

    /* --- Address row --- */
    .address-row {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        font-size: 0.82rem;
        color: var(--text-secondary);
        font-weight: 500;
    }
    .address-row i { color: var(--text-tertiary); margin-top: 2px; }
    .address-row a { color: var(--info); text-decoration: none; font-weight: 600; }
    .address-row a:hover { text-decoration: underline; }

    /* --- Description --- */
    .description-box {
        background: var(--bg-app);
        border-radius: var(--radius-sm);
        padding: 0.7rem 0.9rem;
        font-size: 0.8rem;
        line-height: 1.55;
        color: var(--text-secondary);
        max-height: 72px;
        overflow-y: auto;
    }
    .description-box::-webkit-scrollbar { width: 4px; }
    .description-box::-webkit-scrollbar-track { background: transparent; }
    .description-box::-webkit-scrollbar-thumb { background: var(--text-tertiary); border-radius: 2px; }

    /* --- Owner Avatar --- */
    .owner-avatar {
        width: 52px; height: 52px;
        border-radius: var(--radius-pill);
        background: var(--gradient-primary);
        color: #fff;
        font-size: 1.2rem;
        font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        box-shadow: var(--shadow-glow-primary);
        flex-shrink: 0;
    }
    .owner-name { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); }
    .owner-email { font-size: 0.75rem; color: var(--text-secondary); }

    /* --- Progress Bar --- */
    .profit-bar-wrap {
        position: relative;
        background: #eef0f4;
        border-radius: var(--radius-pill);
        height: 10px;
        overflow: hidden;
        margin: 0.5rem 0;
    }
    .profit-bar-fill {
        height: 100%;
        border-radius: var(--radius-pill);
        background: var(--gradient-primary);
        transition: width 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .profit-legend {
        display: flex;
        justify-content: space-between;
        font-size: 0.7rem;
        font-weight: 600;
        margin-top: 0.35rem;
    }
    .profit-legend-owner { color: var(--brand-primary); }
    .profit-legend-manager { color: var(--text-tertiary); }
    .profit-dot {
        display: inline-block;
        width: 7px; height: 7px;
        border-radius: 50%;
        margin-right: 4px;
        vertical-align: middle;
    }

    /* --- Room Card --- */
    .room-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.55rem 0.85rem;
        border-radius: var(--radius-sm);
        background: var(--bg-app);
        border: 1px solid var(--border-subtle);
        margin-bottom: 0.45rem;
        transition: background 0.15s;
    }
    .room-item:hover { background: #e8eaed; }
    .room-item:last-child { margin-bottom: 0; }
    .room-name { font-size: 0.82rem; font-weight: 600; color: var(--text-primary); }
    .room-badge {
        background: var(--gradient-primary);
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: var(--radius-pill);
    }

    /* --- Facility Chip --- */
    .facility-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(27, 61, 47, 0.06);
        color: var(--brand-primary);
        padding: 0.4rem 0.85rem;
        border-radius: var(--radius-pill);
        font-weight: 600;
        font-size: 0.78rem;
        margin: 0.2rem;
        border: 1px solid rgba(27, 61, 47, 0.12);
        transition: all 0.15s;
    }
    .facility-chip:hover {
        background: rgba(27, 61, 47, 0.12);
        transform: translateY(-1px);
    }
    .facility-chip i { font-size: 0.8rem; }

    /* --- Gallery Grid --- */
    .gallery-main-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-xs);
    }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: 8px;
    }
    .gallery-item {
        width: 100%;
        height: 80px;
        border-radius: var(--radius-sm);
        object-fit: cover;
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-xs);
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    .gallery-item:hover { transform: scale(1.04); box-shadow: var(--shadow-md); }
    .gallery-placeholder {
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        background: var(--bg-app);
        border-radius: var(--radius-sm);
        border: 1px dashed rgba(15,23,42,0.15);
        color: var(--text-tertiary);
        font-size: 0.78rem;
        gap: 0.3rem;
        padding: 1.2rem;
    }
    .gallery-placeholder i { font-size: 1.4rem; }

    /* --- Tabs --- */
    .vi-tabs {
        border: none;
        gap: 0.25rem;
        padding: 0 0.25rem;
    }
    .vi-tabs .nav-link {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        border: none;
        border-radius: var(--radius-sm) var(--radius-sm) 0 0;
        padding: 0.55rem 1rem;
        display: flex; align-items: center; gap: 0.35rem;
        transition: all 0.15s;
    }
    .vi-tabs .nav-link:hover { color: var(--text-primary); background: rgba(15,23,42,0.04); }
    .vi-tabs .nav-link.active {
        color: var(--brand-primary);
        background: var(--bg-app);
        border-bottom: 2.5px solid var(--brand-primary);
        font-weight: 700;
    }
    .vi-tabs-content-wrap {
        background: var(--bg-app);
        border-radius: 0 var(--radius-sm) var(--radius-sm) var(--radius-sm);
        border: 1px solid var(--border-subtle);
        padding: 1.25rem;
    }
    .vi-tab-inner {
        background: var(--surface);
        border-radius: var(--radius-sm);
        padding: 1.25rem;
        border: 1px solid var(--border-subtle);
        min-height: 100px;
    }

    /* --- FullCalendar overrides --- */
    .fc .fc-toolbar-title { font-size: 0.95rem !important; font-weight: 700; color: var(--text-primary); }
    .fc .fc-button {
        background: var(--gradient-primary) !important;
        border: none !important;
        border-radius: var(--radius-sm) !important;
        font-size: 0.78rem !important;
        font-weight: 600 !important;
        padding: 0.3rem 0.7rem !important;
        box-shadow: none !important;
    }
    .fc .fc-button:hover { opacity: 0.85 !important; }
    .fc .fc-day-today { background: rgba(27,61,47,0.06) !important; }
    .fc .fc-event { border-radius: 5px !important; font-size: 0.72rem !important; font-weight: 600 !important; }
    .fc th { font-size: 0.72rem !important; font-weight: 700 !important; color: var(--text-tertiary) !important; text-transform: uppercase; letter-spacing: 0.5px; }
    .fc .fc-col-header-cell-cushion { padding: 8px 4px !important; }
    .fc .fc-daygrid-day-number { font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); }

    /* --- Booking Legend --- */
    .booking-legend {
        display: flex; gap: 1rem; flex-wrap: wrap;
        margin-top: 0.75rem;
    }
    .legend-item {
        display: flex; align-items: center; gap: 0.35rem;
        font-size: 0.72rem; font-weight: 600; color: var(--text-secondary);
    }
    .legend-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* --- Empty state --- */
    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--text-tertiary);
    }
    .empty-state i { font-size: 2rem; margin-bottom: 0.5rem; display: block; }
    .empty-state p { font-size: 0.8rem; margin: 0; }

    /* --- Booking Modal --- */
    .booking-modal-content {
        border-radius: var(--radius-md) !important;
        border: none !important;
        box-shadow: var(--shadow-lg) !important;
        overflow: hidden;
    }
    .modal-hero {
        background: var(--gradient-primary);
        padding: 1.5rem 1.5rem 1.25rem;
        position: relative;
        overflow: hidden;
    }
    .modal-hero::before {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 100px; height: 100px;
        border-radius: 50%;
        background: rgba(201,168,76,0.15);
    }
    .modal-guest-avatar {
        width: 46px; height: 46px;
        border-radius: var(--radius-pill);
        background: rgba(255,255,255,0.18);
        border: 2px solid rgba(255,255,255,0.3);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; color: #fff;
        flex-shrink: 0;
    }
    .modal-guest-name { font-size: 1rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; }
    .modal-invoice-text { font-size: 0.72rem; color: rgba(255,255,255,0.6); font-weight: 600; }
    .modal-body-inner { padding: 1.25rem 1.5rem; }
    .modal-field-group {
        background: var(--bg-app);
        border-radius: var(--radius-sm);
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-subtle);
    }
    .modal-divider { border: none; border-top: 1px solid var(--border-subtle); margin: 1rem 0; }
    .modal-footer-inner { padding: 0 1.5rem 1.25rem; }
    .btn-modal-close {
        width: 100%;
        background: var(--bg-app);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-sm);
        color: var(--text-secondary);
        font-size: 0.82rem;
        font-weight: 600;
        padding: 0.65rem;
        transition: all 0.15s;
        cursor: pointer;
    }
    .btn-modal-close:hover { background: #e2e5ea; color: var(--text-primary); }
</style>

<div class="container-fluid px-0 animate-in">

    <!-- Hidden button to trigger modal safely without JS errors -->
    <button type="button" id="triggerBookingModal" class="d-none" data-bs-toggle="modal" data-bs-target="#bookingModal"></button>

    <!-- ============ HERO BANNER ============ -->
    <div class="villa-hero mb-4">
        <div class="villa-hero-content">
            <!-- Top row: navigation buttons -->
            <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                <a href="{{ route('villas.index') }}" class="hero-action-btn btn-hero-back">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('villas.edit', $villa) }}" class="hero-action-btn btn-hero-edit">
                        <i class="bi bi-pencil-square"></i> Edit Villa
                    </a>
                    <a href="{{ route('villas.laporan', $villa) }}" class="hero-action-btn btn-hero-laporan">
                        <i class="bi bi-bar-chart-line-fill"></i> Lihat Laporan
                    </a>
                </div>
            </div>

            <!-- Villa identity & quick stats -->
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
                <div>
                    <div class="villa-hero-badge">
                        <i class="bi bi-building"></i> Detail Villa
                    </div>
                    <h1 class="villa-hero-title">{{ $villa->name }}</h1>
                    <p class="villa-hero-price mb-0">
                        <i class="bi bi-tag-fill me-1" style="font-size:0.8rem;"></i>
                        Rp {{ number_format($villa->price, 0, ',', '.') }} / malam
                    </p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <div class="stat-mini-card">
                        <span class="stat-mini-label">Pemilik</span>
                        <span class="stat-mini-value">{{ $villa->pemilik->name ?? 'Belum ada' }}</span>
                    </div>
                    <div class="stat-mini-card">
                        <span class="stat-mini-label">Bagi Hasil</span>
                        <span class="stat-mini-value">{{ $villa->profit_sharing_percentage }}% / {{ 100 - $villa->profit_sharing_percentage }}%</span>
                    </div>
                    <div class="stat-mini-card">
                        <span class="stat-mini-label">Tipe Ruangan</span>
                        <span class="stat-mini-value">{{ $villa->rooms ? $villa->rooms->count() : 0 }} jenis</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ ROW 1: Info Cards ============ -->
    <div class="row g-3 mb-3">

        <!-- General Information -->
        <div class="col-lg-5">
            <div class="vi-card h-100">
                <div class="vi-card-header">
                    <div class="vi-card-icon primary"><i class="bi bi-info-circle-fill"></i></div>
                    <span class="vi-card-title">Informasi Villa</span>
                </div>
                <div class="vi-card-body">
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <span class="field-label">Nama Villa</span>
                            <div class="field-value" style="color: var(--brand-primary);">{{ $villa->name }}</div>
                        </div>
                        <div class="col-6">
                            <span class="field-label">Harga / Malam</span>
                            <div class="field-value" style="color: var(--success);">Rp {{ number_format($villa->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="field-group mb-2">
                        <span class="field-label">Alamat</span>
                        <div class="address-row">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>{{ $villa->address }}</span>
                        </div>
                    </div>
                    <div class="field-group mb-2">
                        <span class="field-label">Email Kontak</span>
                        <div class="address-row">
                            <i class="bi bi-envelope-fill"></i>
                            <a href="mailto:{{ $villa->email }}">{{ $villa->email }}</a>
                        </div>
                    </div>
                    @if($villa->description)
                        <div>
                            <span class="field-label">Deskripsi</span>
                            <div class="description-box">{!! nl2br(e($villa->description)) !!}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ownership & Profit Sharing -->
        <div class="col-lg-4 col-md-6">
            <div class="vi-card h-100">
                <div class="vi-card-header">
                    <div class="vi-card-icon accent"><i class="bi bi-person-badge-fill"></i></div>
                    <span class="vi-card-title">Kepemilikan & Bagi Hasil</span>
                </div>
                <div class="vi-card-body">
                    <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom: 1px solid var(--border-subtle);">
                        <div class="owner-avatar">
                            {{ strtoupper(substr($villa->pemilik->name ?? 'P', 0, 1)) }}
                        </div>
                        <div>
                            <div class="owner-name">{{ $villa->pemilik->name ?? 'Belum ada pemilik' }}</div>
                            <div class="owner-email">{{ $villa->pemilik->email ?? '-' }}</div>
                        </div>
                    </div>
                    <span class="field-label">Skema Bagi Hasil</span>
                    <div class="profit-bar-wrap">
                        <div class="profit-bar-fill" style="width: {{ $villa->profit_sharing_percentage }}%;"></div>
                    </div>
                    <div class="profit-legend">
                        <span class="profit-legend-owner">
                            <span class="profit-dot" style="background: var(--brand-primary);"></span>
                            Pemilik — {{ $villa->profit_sharing_percentage }}%
                        </span>
                        <span class="profit-legend-manager">
                            <span class="profit-dot" style="background: var(--text-tertiary);"></span>
                            Pengelola — {{ 100 - $villa->profit_sharing_percentage }}%
                        </span>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <div class="field-group text-center">
                                <div class="field-label" style="text-align:center;">Pemilik</div>
                                <div style="font-size: 1.4rem; font-weight: 800; color: var(--brand-primary);">
                                    {{ $villa->profit_sharing_percentage }}<span style="font-size:0.75rem; font-weight:700;">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="field-group text-center">
                                <div class="field-label" style="text-align:center;">Pengelola</div>
                                <div style="font-size: 1.4rem; font-weight: 800; color: var(--text-tertiary);">
                                    {{ 100 - $villa->profit_sharing_percentage }}<span style="font-size:0.75rem; font-weight:700;">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rooms -->
        <div class="col-lg-3 col-md-6">
            <div class="vi-card h-100">
                <div class="vi-card-header">
                    <div class="vi-card-icon warning"><i class="bi bi-door-open-fill"></i></div>
                    <span class="vi-card-title">Rincian Ruangan</span>
                    @if($villa->rooms && $villa->rooms->count() > 0)
                        <span class="ms-auto" style="font-size:0.68rem; font-weight:700; background: rgba(249,115,22,0.1); color: var(--warning); padding: 0.15rem 0.55rem; border-radius: var(--radius-pill);">
                            {{ $villa->rooms->count() }} tipe
                        </span>
                    @endif
                </div>
                <div class="vi-card-body">
                    <div style="max-height: 220px; overflow-y: auto;">
                        @if($villa->rooms && $villa->rooms->count() > 0)
                            @foreach($villa->rooms as $room)
                                <div class="room-item">
                                    <span class="room-name">{{ $room->name }}</span>
                                    <span class="room-badge">{{ $room->amount }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="bi bi-door-closed"></i>
                                <p>Belum ada ruangan terdaftar.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ ROW 2: Tabs ============ -->
    <div class="vi-card mb-4">
        <div style="background: var(--surface); border-radius: var(--radius-md) var(--radius-md) 0 0; padding: 0.5rem 0.75rem 0;">
            <ul class="nav vi-tabs" id="villaTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="fasilitas-tab" data-bs-toggle="tab" data-bs-target="#fasilitas" type="button" role="tab" aria-selected="true">
                        <i class="bi bi-grid-fill"></i> Fasilitas
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="galeri-tab" data-bs-toggle="tab" data-bs-target="#galeri" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-images"></i> Galeri Foto
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-calendar-event"></i> Jadwal Booking
                    </button>
                </li>
            </ul>
        </div>
        <div class="vi-tabs-content-wrap mx-3 mb-3" style="border-radius: 0 var(--radius-sm) var(--radius-sm) var(--radius-sm);">
            <div class="tab-content" id="villaTabsContent">

                <!-- Tab: Fasilitas -->
                <div class="tab-pane fade show active" id="fasilitas" role="tabpanel" tabindex="0">
                    <div class="vi-tab-inner">
                        @if($villa->fasilitas && $villa->fasilitas->count() > 0)
                            <div class="d-flex flex-wrap">
                                @foreach($villa->fasilitas as $fac)
                                    <div class="facility-chip">
                                        <i class="{{ $fac->ikon ?? 'bi bi-check2-circle' }}"></i>
                                        {{ $fac->nama }}
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-grid"></i>
                                <p>Belum ada fasilitas yang didaftarkan.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tab: Galeri -->
                <div class="tab-pane fade" id="galeri" role="tabpanel" tabindex="0">
                    <div class="vi-tab-inner">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <span class="field-label">Foto Utama</span>
                                @if($villa->image)
                                    <img src="{{ filter_var($villa->image, FILTER_VALIDATE_URL) ? $villa->image : asset('storage/' . $villa->image) }}"
                                         class="gallery-main-img" alt="{{ $villa->name }}">
                                @else
                                    <div class="gallery-placeholder" style="height: 160px;">
                                        <i class="bi bi-image"></i>
                                        <span>Tidak ada foto utama</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <span class="field-label">Galeri Tambahan</span>
                                @if($villa->galleries && $villa->galleries->count() > 0)
                                    <div class="gallery-grid">
                                        @foreach($villa->galleries as $gallery)
                                            <img src="{{ filter_var($gallery->image, FILTER_VALIDATE_URL) ? $gallery->image : asset('storage/' . $gallery->image) }}"
                                                 class="gallery-item" alt="Gallery">
                                        @endforeach
                                    </div>
                                @else
                                    <div class="gallery-placeholder">
                                        <i class="bi bi-images"></i>
                                        <span>Tidak ada galeri tambahan</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Jadwal Booking -->
                <div class="tab-pane fade" id="jadwal" role="tabpanel" tabindex="0">
                    <div class="vi-tab-inner">
                        <div id="calendar"></div>
                        <div class="booking-legend">
                            <div class="legend-item">
                                <span class="legend-dot" style="background:#198754;"></span>
                                Lunas / Sukses
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot" style="background:#F97316;"></span>
                                Menunggu Pembayaran
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- ============ Booking Modal ============ -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content booking-modal-content">
            <!-- Modal Hero -->
            <div class="modal-hero">
                <div class="d-flex align-items-center gap-3" style="position:relative; z-index:1;">
                    <div class="modal-guest-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="modal-guest-name" id="modalGuestName">-</div>
                        <div class="modal-invoice-text" id="modalInvoice">-</div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position:relative;z-index:2;"></button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body-inner">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="modal-field-group">
                            <span class="field-label" style="color:var(--success);">Check In</span>
                            <div style="font-size:0.88rem; font-weight:700; color:var(--text-primary);" id="modalCheckIn">-</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="modal-field-group">
                            <span class="field-label" style="color:var(--danger);">Check Out</span>
                            <div style="font-size:0.88rem; font-weight:700; color:var(--text-primary);" id="modalCheckOut">-</div>
                        </div>
                    </div>
                </div>

                <hr class="modal-divider">

                <div class="mb-3">
                    <span class="field-label">Kontak Tamu</span>
                    <div class="d-flex flex-column gap-1 mt-1">
                        <div class="d-flex align-items-center gap-2" style="font-size:0.82rem; color:var(--text-secondary);">
                            <i class="bi bi-telephone-fill" style="color:var(--text-tertiary); width:14px;"></i>
                            <span id="modalPhone">-</span>
                        </div>
                        <div class="d-flex align-items-center gap-2" style="font-size:0.82rem; color:var(--text-secondary);">
                            <i class="bi bi-envelope-fill" style="color:var(--text-tertiary); width:14px;"></i>
                            <span id="modalEmail">-</span>
                        </div>
                    </div>
                </div>

                <div>
                    <span class="field-label">Status Pembayaran</span>
                    <div class="mt-1" id="modalStatusBadge"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer-inner">
                <button type="button" class="btn-modal-close" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    // Parse bookings data from backend
    var bookings = @json($bookings ?? []);

    // Transform bookings into FullCalendar events format
    var eventsData = bookings.map(function(booking) {
        var isSuccess = booking.payment_status === 'success' || booking.payment_status === 'paid';
        var bgColor   = isSuccess ? '#198754' : '#F97316';

        return {
            title: booking.guest_name + (!isSuccess ? ' \u23f3' : ''),
            start: booking.check_in,
            end:   booking.check_out,
            backgroundColor: bgColor,
            borderColor:     bgColor,
            textColor:       '#ffffff',
            extendedProps: {
                invoice:        booking.invoice_number,
                guest_name:     booking.guest_name,
                guest_phone:    booking.guest_phone,
                guest_email:    booking.guest_email,
                payment_status: booking.payment_status
            }
        };
    });

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap5',
        events: eventsData,
        displayEventTime: false,
        height: 'auto',
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,dayGridWeek'
        },
        eventClick: function(info) {
            var props = info.event.extendedProps;
            var fmt = { day: 'numeric', month: 'long', year: 'numeric' };
            var startDate = info.event.start.toLocaleDateString('id-ID', fmt);
            var endDate   = info.event.end ? info.event.end.toLocaleDateString('id-ID', fmt) : startDate;

            document.getElementById('modalGuestName').innerText = props.guest_name;
            document.getElementById('modalInvoice').innerText   = props.invoice || '-';
            document.getElementById('modalCheckIn').innerText   = startDate;
            document.getElementById('modalCheckOut').innerText  = endDate;
            document.getElementById('modalPhone').innerText     = props.guest_phone || '-';
            document.getElementById('modalEmail').innerText     = props.guest_email || '-';

            var isSuccess = props.payment_status === 'success' || props.payment_status === 'paid';
            document.getElementById('modalStatusBadge').innerHTML = isSuccess
                ? '<span style="display:inline-flex;align-items:center;gap:0.35rem;background:rgba(16,185,129,0.1);color:#059669;border:1px solid rgba(16,185,129,0.3);padding:0.35rem 0.85rem;border-radius:999px;font-size:0.78rem;font-weight:700;"><i class=\"bi bi-check-circle-fill\"></i> Lunas</span>'
                : '<span style="display:inline-flex;align-items:center;gap:0.35rem;background:rgba(249,115,22,0.1);color:#c2410c;border:1px solid rgba(249,115,22,0.3);padding:0.35rem 0.85rem;border-radius:999px;font-size:0.78rem;font-weight:700;"><i class=\"bi bi-clock-fill\"></i> Menunggu Pembayaran</span>';

            document.getElementById('triggerBookingModal').click();
        }
    });

    // Fix rendering issue when tabs are switched
    document.getElementById('jadwal-tab').addEventListener('shown.bs.tab', function () {
        calendar.render();
    });
});
</script>
@endsection
