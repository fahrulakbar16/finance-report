@extends('layouts.search')

@section('title', 'Home - Athara Villas')

@section('styles')
<style>
    .greeting {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }
    .sub-greeting {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    .search-box {
        background: #fff;
        border-radius: 14px;
        padding: 0.8rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        margin-bottom: 1.5rem;
    }
    .search-box input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 0.95rem;
    }
    .search-box i {
        color: var(--text-muted);
        font-size: 1.2rem;
    }

    /* Horizontal scroll for categories/promos */
    .h-scroll {
        display: flex;
        overflow-x: auto;
        gap: 1rem;
        padding-bottom: 1rem;
        margin: 0 -1.25rem;
        padding: 0 1.25rem;
        scrollbar-width: none;
    }
    .h-scroll::-webkit-scrollbar { display: none; }
    
    .promo-card {
        min-width: 260px;
        height: 140px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        padding: 1.2rem;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    .promo-card::after {
        content: '';
        position: absolute;
        right: -20px;
        bottom: -20px;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 1.5rem 0 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .section-title a {
        font-size: 0.85rem;
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
    }

    /* Popular Villa Card */
    .villa-card {
        background: var(--surface);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 1.25rem;
    }
    .villa-img {
        height: 180px;
        width: 100%;
        object-fit: cover;
    }
    .villa-info {
        padding: 1rem;
    }
    .villa-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .villa-loc {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 0.75rem;
    }
    .villa-price {
        font-weight: 700;
        color: var(--accent);
        font-size: 1.05rem;
    }
</style>
@endsection

@section('content')
<div class="container py-4 py-md-5" style="max-width: 1000px; margin: 0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4 d-md-none">
        <h1 class="header-title" style="font-size:1.5rem;font-weight:700;margin:0;color:var(--primary);">Athara Villas</h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="greeting">Hi, {{ Auth::user()->name }} 👋</h2>
            <p class="sub-greeting">Mau liburan kemana hari ini?</p>
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <div class="search-box w-100 mb-0">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Cari villa di Batu, Malang...">
            </div>
        </div>
    </div>

    <div class="h-scroll">
        <div class="promo-card">
            <h4 style="font-weight:700;font-size:1.2rem;margin-bottom:0.2rem;">Diskon Spesial</h4>
            <p style="font-size:0.85rem;color:rgba(255,255,255,0.8);margin-bottom:1rem;">Potongan 20% untuk member baru!</p>
            <div style="background:var(--accent);display:inline-block;padding:0.4rem 0.8rem;border-radius:2rem;font-size:0.75rem;font-weight:600;color:var(--primary);">Klaim Sekarang</div>
        </div>
        <div class="promo-card" style="background:linear-gradient(135deg, var(--accent), #b49137);color:var(--primary);">
            <h4 style="font-weight:700;font-size:1.2rem;margin-bottom:0.2rem;">Liburan Keluarga</h4>
            <p style="font-size:0.85rem;margin-bottom:1rem;">Dapatkan harga khusus weekend.</p>
        </div>
    </div>

    <div class="section-title">
        <span>Rekomendasi Villa</span>
        <a href="{{ route('villa.index') }}">Lihat Semua</a>
    </div>

    @php
        // Fetch some villas for demo purposes in dashboard
        $villas = \App\Models\Villa::take(3)->get();
    @endphp

    <div class="row g-4">
    @foreach($villas as $villa)
    <div class="col-12 col-md-6 col-lg-4">
        <div class="villa-card h-100 d-flex flex-column mb-0">
            <img src="{{ filter_var($villa->image, FILTER_VALIDATE_URL) ? $villa->image : asset('storage/' . $villa->image) }}" class="villa-img" alt="{{ $villa->name }}">
            <div class="villa-info d-flex flex-column flex-grow-1">
                <h3 class="villa-title">{{ $villa->name }}</h3>
                <div class="villa-loc"><i class="bi bi-geo-alt-fill text-warning"></i> {{ Str::limit($villa->address, 30) }}</div>
                <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                    <span class="villa-price">Rp {{ number_format($villa->price, 0, ',', '.') }}<span style="font-size:0.75rem;color:var(--text-muted);font-weight:400;">/malam</span></span>
                    <a href="{{ route('villa.show', $villa->id) }}" class="btn btn-sm btn-dark" style="border-radius:8px;font-size:0.8rem;">Detail</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    </div>
</div>
@endsection
