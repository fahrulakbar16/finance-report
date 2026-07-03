@extends('layouts.landing')

@section('title', $villa['name'])
@section('description', $villa['description'])

@section('breadcrumb-parent', 'Villa')
@section('breadcrumb-parent-url', route('villa.index'))
@section('banner-label', $villa['tagline'])
@section('banner', $villa['name'])

@section('styles')
<style>
    .villa-hero {
        position: relative; height: 520px; overflow: hidden;
        margin-top: -56px; /* sit behind the page banner */
    }
    .villa-hero img { width:100%; height:100%; object-fit:cover; display:block; }
    .villa-hero-overlay { position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.5) 0%, transparent 60%); }

    .villa-content { padding: 3.5rem 0 6rem; background: var(--bg-main); }

    /* Gallery */
    .gallery-main { border-radius:16px; overflow:hidden; height:420px; }
    .gallery-main img { width:100%; height:100%; object-fit:cover; cursor:pointer; transition: transform 0.4s; }
    .gallery-main img:hover { transform: scale(1.02); }
    .gallery-thumbs { display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; height:420px; }
    .gallery-thumbs img { border-radius:12px; object-fit:cover; width:100%; height:100%; cursor:pointer; transition: opacity 0.3s; }
    .gallery-thumbs img:hover { opacity:0.85; }

    /* Info panel */
    .info-panel { background:#fff; border-radius:20px; padding:2rem; box-shadow:0 4px 30px rgba(0,0,0,0.07); position:sticky; top:90px; }
    .info-stat { display:flex; align-items:center; gap:0.85rem; padding:1rem 0; border-bottom:1px solid #f3f4f6; }
    .info-stat:last-of-type { border-bottom:none; }
    .info-stat-icon { width:42px; height:42px; border-radius:10px; background:rgba(201,168,76,0.1); display:flex; align-items:center; justify-content:center; color:var(--accent); font-size:1.1rem; flex-shrink:0; }
    .info-stat-label { font-size:0.78rem; color:var(--text-muted); }
    .info-stat-value { font-size:0.95rem; font-weight:600; color:var(--text-dark); }

    /* Facilities */
    .fac-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:0.75rem; margin-top:1.5rem; }
    .fac-item { display:flex; align-items:center; gap:0.6rem; background:#f9fafb; border-radius:10px; padding:0.7rem 1rem; font-size:0.85rem; color:var(--text-dark); }
    .fac-item i { color:var(--accent); font-size:0.9rem; }

    /* Nearby */
    .nearby-item { display:flex; justify-content:space-between; align-items:center; padding:0.75rem 0; border-bottom:1px solid #f3f4f6; }
    .nearby-item:last-child { border-bottom:none; }
    .nearby-name { display:flex; align-items:center; gap:0.6rem; font-size:0.9rem; }
    .nearby-name i { color:var(--accent); }
    .nearby-dist { font-size:0.82rem; color:var(--text-muted); background:#f3f4f6; padding:0.2rem 0.65rem; border-radius:2rem; }

    /* Related */
    .related-section { padding: 5rem 0; background:var(--bg-section); }
</style>
@endsection

@section('content')

{{-- Gallery --}}
<section class="villa-content">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-7 fade-up">
                <div class="gallery-main">
                    <img src="{{ $villa['gallery'][0] }}" alt="{{ $villa['name'] }}" id="mainImg">
                </div>
            </div>
            <div class="col-lg-5 fade-up d2">
                <div class="gallery-thumbs">
                    @foreach(array_slice($villa['gallery'], 1, 4) as $img)
                    <img src="{{ $img }}" alt="{{ $villa['name'] }}" onclick="document.getElementById('mainImg').src='{{ $img }}'">
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row g-5">
            {{-- Left: description & details --}}
            <div class="col-lg-8">
                <div class="fade-up">
                    <span class="sec-label">{{ $villa['tagline'] }}</span>
                    <h2 class="sec-title">{{ $villa['name'] }}</h2>
                    <p style="color:var(--text-muted);line-height:1.85;font-size:0.96rem;">{{ $villa['description'] }}</p>
                </div>

                {{-- Facilities --}}
                <div class="mt-4 fade-up d1">
                    <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.7rem;color:var(--primary);margin-bottom:0;">Fasilitas Villa</h3>
                    <div class="fac-grid">
                        @foreach($villa['facilities'] as $fac)
                        <div class="fac-item">
                            <i class="bi bi-check-circle-fill"></i> {{ $fac }}
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Nearby --}}
                <div class="mt-5 fade-up d2">
                    <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.7rem;color:var(--primary);margin-bottom:1rem;">Tempat Terdekat</h3>
                    @foreach($villa['nearby'] as $place)
                    <div class="nearby-item">
                        <span class="nearby-name"><i class="bi bi-geo-alt-fill"></i> {{ $place['name'] }}</span>
                        <span class="nearby-dist">{{ $place['dist'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: info panel --}}
            <div class="col-lg-4 fade-up d2">
                <div class="info-panel">
                    <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:var(--primary);margin-bottom:1.25rem;">Informasi Villa</h3>

                    <div class="info-stat">
                        <div class="info-stat-icon"><i class="bi bi-people-fill"></i></div>
                        <div><div class="info-stat-label">Kapasitas</div><div class="info-stat-value">{{ $villa['capacity'] }} Orang</div></div>
                    </div>
                    <div class="info-stat">
                        <div class="info-stat-icon"><i class="bi bi-door-closed-fill"></i></div>
                        <div><div class="info-stat-label">Kamar Tidur</div><div class="info-stat-value">{{ $villa['bedrooms'] }} Kamar</div></div>
                    </div>
                    <div class="info-stat">
                        <div class="info-stat-icon"><i class="bi bi-droplet-half"></i></div>
                        <div><div class="info-stat-label">Kamar Mandi</div><div class="info-stat-value">{{ $villa['bathrooms'] }} Kamar</div></div>
                    </div>
                    <div class="info-stat">
                        <div class="info-stat-icon"><i class="bi bi-rulers"></i></div>
                        <div><div class="info-stat-label">Luas Villa</div><div class="info-stat-value">{{ $villa['size'] }}</div></div>
                    </div>
                    <div class="info-stat">
                        <div class="info-stat-icon"><i class="bi bi-droplet-fill"></i></div>
                        <div><div class="info-stat-label">Kolam Renang</div><div class="info-stat-value">Private Pool</div></div>
                    </div>

                    <div style="margin-top:1.75rem;padding-top:1.5rem;border-top:1px solid #f3f4f6;">
                        @if(isset($villa['price']))
                        <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:1rem;">
                            <span style="font-size:0.78rem;color:var(--text-muted);">Mulai dari</span>
                            <span style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:700;color:var(--primary);">Rp {{ number_format($villa['price'],0,',','.') }}<span style="font-size:0.78rem;font-weight:400;color:var(--text-muted);"> / malam</span></span>
                        </div>
                        @endif
                        <a href="{{ route('booking.show', $villa['slug']) }}" class="btn-gold w-100 justify-content-center mb-2">
                            <i class="bi bi-calendar-check-fill"></i> Pesan Sekarang
                        </a>
                        <a href="{{ route('kontak') }}" class="btn-outline-dark w-100 justify-content-center">
                            <i class="bi bi-envelope"></i> Tanya Dulu
                        </a>
                    </div>

                    <div style="margin-top:1.25rem;display:flex;gap:1rem;font-size:0.8rem;color:var(--text-muted);">
                        <span><i class="bi bi-clock text-warning me-1"></i> Check-in 14.00</span>
                        <span><i class="bi bi-clock text-warning me-1"></i> Check-out 12.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related Villas --}}
@if(count($related))
<section class="related-section">
    <div class="container">
        <div class="sec-center fade-up">
            <span class="sec-label">Villa Lainnya</span>
            <h2 class="sec-title">Mungkin Anda Juga Suka</h2>
        </div>
        <div class="row g-4">
            @foreach($related as $r)
            <div class="col-md-4 d-flex fade-up d{{ $loop->index + 1 }}">
                <div class="v-card w-100">
                    <div class="v-card-img">
                        <img src="{{ $r['thumb'] }}" alt="{{ $r['name'] }}" loading="lazy">
                        @if($r['badge'])<span class="v-pill">{{ $r['badge'] }}</span>@endif
                    </div>
                    <div class="v-body">
                        <h3 class="v-name">{{ $r['name'] }}</h3>
                        <div class="v-meta">
                            <span><i class="bi bi-people-fill"></i> {{ $r['capacity'] }} Orang</span>
                            <span><i class="bi bi-door-closed-fill"></i> {{ $r['bedrooms'] }} Kamar</span>
                        </div>
                        <a href="{{ route('villa.show', $r['slug']) }}" class="btn-underline">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
