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
            @forelse($villas as $v)
            @php
                $thumb = $v->image
                    ? (filter_var($v->image, FILTER_VALIDATE_URL) ? $v->image : asset('storage/' . $v->image))
                    : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=800&auto=format&fit=crop';
                $roomCount = $v->rooms->count();
            @endphp
            <div class="col-md-6 col-lg-4 d-flex fade-up villa-item" data-bedrooms="{{ $roomCount }}">
                <div class="v-card w-100">
                    <div class="v-card-img">
                        <img src="{{ $thumb }}" alt="{{ $v->name }}" loading="lazy">
                    </div>
                    <div class="v-body">
                        <h3 class="v-name">{{ $v->name }}</h3>
                        <div class="v-meta">
                            <span><i class="bi bi-door-closed-fill"></i> {{ $roomCount }} Ruangan</span>
                            @if($v->address)
                            <span><i class="bi bi-geo-alt-fill"></i> {{ Str::limit($v->address, 28) }}</span>
                            @endif
                        </div>
                        <p class="v-desc">{{ Str::limit($v->description, 100) }}</p>
                        @if($v->price)
                        <div style="font-size:0.82rem;color:var(--text-muted);margin-bottom:0.85rem;">
                            Mulai <strong style="color:var(--primary);font-size:0.95rem;">Rp {{ number_format($v->price,0,',','.') }}</strong> / malam
                        </div>
                        @endif
                        <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
                            <a href="{{ route('villa.show', $v->id) }}" class="btn-underline">
                                Lihat Detail <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada villa yang tersedia saat ini.</p>
            </div>
            @endforelse
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
