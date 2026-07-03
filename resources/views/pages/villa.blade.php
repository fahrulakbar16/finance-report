@extends('layouts.landing')

@section('title', 'Koleksi Villa')
@section('description', 'Jelajahi koleksi villa premium Athara Villas — dari villa romantis 2 kamar hingga villa besar untuk rombongan.')

@section('banner-label', 'Koleksi Villa')
@section('banner', 'Temukan Villa Impian Anda')
@section('banner-desc', 'Pilihan villa premium dengan berbagai kapasitas dan fasilitas terbaik untuk momen istimewa Anda.')

@section('styles')
<style>
    .villa-list { padding: 5rem 0 6rem; background: var(--bg-main); }
    .filter-bar { display:flex; flex-wrap:wrap; gap:0.5rem; margin-bottom:3rem; }
    .filter-btn {
        padding: 0.45rem 1.2rem; border-radius:2rem; border: 1.5px solid #e5e7eb;
        background:#fff; color:var(--text-muted); font-size:0.85rem; font-weight:500;
        cursor:pointer; transition:all 0.25s;
    }
    .filter-btn:hover, .filter-btn.active { border-color:var(--accent); color:var(--primary); background:rgba(201,168,76,0.08); }
    .villa-count { color:var(--text-muted); font-size:0.875rem; margin-bottom:2rem; }
    .villa-count strong { color:var(--primary); }
</style>
@endsection

@section('content')

<section class="villa-list">
    <div class="container">
        {{-- Filter bar --}}
        <div class="filter-bar" id="filterBar">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="2">2 Kamar</button>
            <button class="filter-btn" data-filter="3">3 Kamar</button>
            <button class="filter-btn" data-filter="4">4 Kamar</button>
            <button class="filter-btn" data-filter="5">5 Kamar</button>
        </div>

        <p class="villa-count">Menampilkan <strong>{{ count($villas) }}</strong> villa</p>

        <div class="row g-4" id="villaGrid">
            @foreach($villas as $v)
            <div class="col-md-6 col-lg-4 d-flex fade-up villa-item" data-bedrooms="{{ $v['bedrooms'] }}">
                <div class="v-card w-100">
                    <div class="v-card-img">
                        <img src="{{ $v['thumb'] }}" alt="{{ $v['name'] }}" loading="lazy">
                        @if($v['badge'])
                        <span class="v-pill">{{ $v['badge'] }}</span>
                        @endif
                    </div>
                    <div class="v-body">
                        <h3 class="v-name">{{ $v['name'] }}</h3>
                        <div class="v-meta">
                            <span><i class="bi bi-people-fill"></i> {{ $v['capacity'] }} Orang</span>
                            <span><i class="bi bi-door-closed-fill"></i> {{ $v['bedrooms'] }} Kamar</span>
                            <span><i class="bi bi-droplet-fill"></i> Private Pool</span>
                            <span><i class="bi bi-rulers"></i> {{ $v['size'] }}</span>
                        </div>
                        <p class="v-desc">{{ Str::limit($v['description'], 100) }}</p>
                        @if(isset($v['price']))
                        <div style="font-size:0.82rem;color:var(--text-muted);margin-bottom:0.85rem;">
                            Mulai <strong style="color:var(--primary);font-size:0.95rem;">Rp {{ number_format($v['price'],0,',','.') }}</strong> / malam
                        </div>
                        @endif
                        <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
                            <a href="{{ route('villa.show', $v['slug']) }}" class="btn-underline">
                                Lihat Detail <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="{{ route('booking.show', $v['slug']) }}" class="btn-gold" style="padding:0.55rem 1.25rem;font-size:0.82rem;">
                                <i class="bi bi-calendar-check-fill"></i> Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA strip --}}
<section style="background:var(--primary);padding:4rem 0;text-align:center;">
    <div class="container">
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:2.2rem;color:#fff;font-weight:600;margin-bottom:0.75rem;">
            Tidak Yakin Pilih yang Mana?
        </h2>
        <p style="color:rgba(255,255,255,0.65);margin-bottom:2rem;">Tim kami siap membantu Anda menemukan villa yang paling sesuai kebutuhan.</p>
        <a href="{{ route('kontak') }}" class="btn-gold">Konsultasi Gratis <i class="bi bi-whatsapp"></i></a>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Simple client-side filter
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;
            document.querySelectorAll('.villa-item').forEach(item => {
                const match = filter === 'all' || item.dataset.bedrooms === filter;
                item.style.display = match ? '' : 'none';
            });
        });
    });
</script>
@endsection
