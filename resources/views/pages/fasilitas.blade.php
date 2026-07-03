@extends('layouts.landing')

@section('title', 'Fasilitas')
@section('description', 'Fasilitas lengkap Athara Villas — private pool, dapur modern, smart TV, WiFi cepat, dan banyak lagi.')

@section('banner-label', 'Fasilitas')
@section('banner', 'Fasilitas Lengkap untuk Kenyamanan Anda')
@section('banner-desc', 'Setiap villa kami dilengkapi fasilitas premium yang dirancang untuk memberikan pengalaman terbaik.')

@section('styles')
<style>
    .fac-main { padding: 5.5rem 0; background: var(--bg-main); }
    .fac-card {
        background:#fff; border-radius:20px; padding:2.25rem 1.75rem;
        box-shadow:0 4px 24px rgba(0,0,0,0.05); height:100%; text-align:center;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .fac-card:hover { transform:translateY(-7px); box-shadow:0 16px 48px rgba(27,61,47,0.1); }
    .fac-icon-wrap {
        width:72px; height:72px; border-radius:50%;
        background:rgba(201,168,76,0.12); border:1px solid rgba(201,168,76,0.25);
        display:flex; align-items:center; justify-content:center;
        font-size:1.65rem; color:var(--accent); margin:0 auto 1.4rem;
        transition: background 0.3s, color 0.3s;
    }
    .fac-card:hover .fac-icon-wrap { background:var(--accent); color:var(--primary); }
    .fac-name { font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-weight:600; color:var(--primary); margin-bottom:0.6rem; }
    .fac-desc { font-size:0.875rem; color:var(--text-muted); line-height:1.7; }

    .premium-section { padding: 5.5rem 0; background: var(--primary); }
    .premium-item { display:flex; align-items:flex-start; gap:1rem; margin-bottom:1.5rem; }
    .premium-dot { width:40px; height:40px; border-radius:50%; background:rgba(201,168,76,0.2); border:1px solid rgba(201,168,76,0.4); display:flex; align-items:center; justify-content:center; color:var(--accent); font-size:1rem; flex-shrink:0; margin-top:0.15rem; }
    .premium-title { color:#fff; font-weight:600; font-size:0.95rem; margin-bottom:0.25rem; }
    .premium-desc { color:rgba(255,255,255,0.55); font-size:0.85rem; line-height:1.6; }

    .include-section { padding: 5rem 0; background: var(--bg-section); }
    .include-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1rem; margin-top:2rem; }
    .include-item { background:#fff; border-radius:12px; padding:1rem 1.25rem; display:flex; align-items:center; gap:0.75rem; font-size:0.875rem; font-weight:500; color:var(--text-dark); }
    .include-item i { color:var(--accent); font-size:1rem; }
</style>
@endsection

@section('content')

{{-- Main facilities --}}
<section class="fac-main">
    <div class="container">
        <div class="sec-center fade-up">
            <span class="sec-label">Fasilitas Utama</span>
            <h2 class="sec-title">Yang Sudah Tersedia di Setiap Villa</h2>
            <p class="sec-desc">Semua fasilitas berikut tersedia di setiap unit villa Athara Villas tanpa biaya tambahan.</p>
        </div>
        <div class="row g-4">
            @php
            $facilities = [
                ['icon'=>'bi-droplet-fill',    'name'=>'Private Pool',     'desc'=>'Kolam renang pribadi eksklusif yang bersih dan terawat. Tersedia untuk Anda sepanjang waktu tanpa berbagi dengan tamu lain.'],
                ['icon'=>'bi-wifi',             'name'=>'WiFi High-Speed',  'desc'=>'Koneksi internet fiber optik berkecepatan tinggi yang menjangkau seluruh area villa, indoor maupun outdoor.'],
                ['icon'=>'bi-tv-fill',          'name'=>'Smart TV',         'desc'=>'Smart TV layar lebar dengan koneksi streaming tersedia di ruang tamu dan kamar utama.'],
                ['icon'=>'bi-snow2',            'name'=>'AC Inverter',      'desc'=>'AC inverter hemat energi di setiap kamar tidur dan ruang keluarga untuk kenyamanan maksimal.'],
                ['icon'=>'bi-egg-fried',        'name'=>'Dapur Lengkap',    'desc'=>'Dapur modern fully equipped dengan peralatan masak lengkap, kulkas, microwave, dan perlengkapan makan.'],
                ['icon'=>'bi-car-front-fill',   'name'=>'Parkir Luas',      'desc'=>'Area parkir yang luas dan aman untuk kendaraan Anda, baik mobil maupun motor.'],
            ];
            @endphp
            @foreach($facilities as $i => $f)
            <div class="col-md-6 col-lg-4 d-flex fade-up d{{ ($i % 3) + 1 }}">
                <div class="fac-card w-100">
                    <div class="fac-icon-wrap"><i class="bi {{ $f['icon'] }}"></i></div>
                    <div class="fac-name">{{ $f['name'] }}</div>
                    <p class="fac-desc">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Premium features --}}
<section class="premium-section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 fade-up">
                <span class="sec-label" style="color:var(--accent-light);">Fasilitas Premium</span>
                <h2 class="sec-title" style="color:#fff;">Lebih dari Sekadar Villa Biasa</h2>
                <p style="color:rgba(255,255,255,0.62);font-size:0.95rem;line-height:1.8;">
                    Di Athara Villas, kami percaya bahwa detail kecil menciptakan pengalaman yang besar. Itulah mengapa setiap villa kami hadir dengan sentuhan premium yang membuat liburan Anda benar-benar istimewa.
                </p>
                <a href="{{ route('villa.index') }}" class="btn-gold mt-3" style="display:inline-flex;">Lihat Koleksi Villa <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="col-lg-7 fade-up d2">
                @php
                $premium = [
                    ['icon'=>'bi-flower1',         'title'=>'Dekorasi Artistik',          'desc'=>'Setiap villa didekorasi oleh desainer interior berpengalaman dengan sentuhan art yang khas.'],
                    ['icon'=>'bi-thermometer-sun', 'title'=>'Outdoor Living Area',        'desc'=>'Area outdoor yang luas dengan gazebo, lounger, dan taman terawat untuk bersantai di udara segar.'],
                    ['icon'=>'bi-shield-lock-fill','title'=>'Keamanan 24 Jam',            'desc'=>'CCTV dan sistem keamanan aktif sepanjang waktu memastikan privasi dan keamanan Anda terjaga.'],
                    ['icon'=>'bi-person-check',    'title'=>'Concierge Service',          'desc'=>'Tim concierge kami siap membantu mengatur aktivitas, transportasi, dan kebutuhan khusus Anda.'],
                ];
                @endphp
                @foreach($premium as $p)
                <div class="premium-item">
                    <div class="premium-dot"><i class="bi {{ $p['icon'] }}"></i></div>
                    <div>
                        <div class="premium-title">{{ $p['title'] }}</div>
                        <div class="premium-desc">{{ $p['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- All included --}}
<section class="include-section">
    <div class="container">
        <div class="sec-center fade-up">
            <span class="sec-label">Sudah Termasuk</span>
            <h2 class="sec-title">Semua Sudah Tersedia</h2>
            <p class="sec-desc">Tidak perlu khawatir — semua kebutuhan dasar sudah kami siapkan untuk Anda.</p>
        </div>
        <div class="include-grid fade-up d1">
            @php
            $included = [
                'Handuk & Perlengkapan Mandi','Sabun & Sampo Premium','Air Mineral','Tempat Tidur Mewah',
                'Bantal & Selimut Extra','Perlengkapan Dapur','Peralatan BBQ','Kursi & Meja Outdoor',
                'Tempat Sampah Pilah','Tissue & Toiletries','Shower Gel','Pengering Rambut',
            ];
            @endphp
            @foreach($included as $item)
            <div class="include-item"><i class="bi bi-check-circle-fill"></i> {{ $item }}</div>
            @endforeach
        </div>
    </div>
</section>

@endsection
