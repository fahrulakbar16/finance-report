@extends('layouts.landing')

@section('title', 'Testimoni')
@section('description', 'Ribuan tamu telah merasakan pengalaman menginap di Athara Villas. Baca cerita mereka di sini.')

@section('banner-label', 'Testimoni')
@section('banner', 'Kata Mereka tentang Athara Villas')
@section('banner-desc', 'Kepuasan tamu adalah ukuran keberhasilan kami. Berikut pengalaman nyata mereka.')

@section('styles')
<style>
    .rating-summary { padding: 4rem 0 3rem; background: var(--bg-main); }
    .rating-big { font-family:'Cormorant Garamond',serif; font-size:5rem; font-weight:600; color:var(--primary); line-height:1; }
    .rating-stars { color:var(--accent); font-size:1.4rem; margin:0.5rem 0; }
    .rating-count { color:var(--text-muted); font-size:0.9rem; }
    .rating-bar-row { display:flex; align-items:center; gap:0.75rem; margin-bottom:0.6rem; }
    .rating-bar-label { font-size:0.82rem; color:var(--text-muted); width:40px; }
    .rating-bar-track { flex:1; height:8px; background:#f3f4f6; border-radius:4px; overflow:hidden; }
    .rating-bar-fill { height:100%; background:var(--accent); border-radius:4px; transition:width 1s ease; }
    .rating-bar-pct { font-size:0.78rem; color:var(--text-muted); width:32px; text-align:right; }

    .testi-section { padding: 2rem 0 6rem; background: var(--bg-main); }
    .t-card { background:#fff; border-radius:18px; padding:1.75rem; box-shadow:0 4px 24px rgba(0,0,0,0.06); height:100%; transition:transform 0.3s; }
    .t-card:hover { transform:translateY(-5px); }
    .t-stars { color:var(--accent); font-size:0.85rem; margin-bottom:0.9rem; }
    .t-quote { font-style:italic; color:#444; font-size:0.92rem; line-height:1.75; margin-bottom:1.4rem; }
    .t-author { display:flex; align-items:center; gap:0.8rem; }
    .t-avatar { width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:600; color:var(--primary); flex-shrink:0; }
    .t-name { font-weight:600; font-size:0.88rem; color:var(--text-dark); }
    .t-meta { font-size:0.78rem; color:var(--text-muted); display:flex; align-items:center; gap:0.3rem; }
    .t-meta i { color:var(--accent); font-size:0.7rem; }
    .t-villa { display:inline-block; background:rgba(201,168,76,0.1); color:var(--primary); font-size:0.72rem; font-weight:600; padding:0.22rem 0.7rem; border-radius:2rem; margin-bottom:0.75rem; border:1px solid rgba(201,168,76,0.25); }
</style>
@endsection

@section('content')

{{-- Rating summary --}}
<section class="rating-summary">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-3 text-center fade-up">
                <div class="rating-big">4.9</div>
                <div class="rating-stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                </div>
                <div class="rating-count">Dari 200+ ulasan</div>
            </div>
            <div class="col-lg-5 fade-up d1">
                @php
                $bars = [['label'=>'5★','pct'=>82],['label'=>'4★','pct'=>13],['label'=>'3★','pct'=>4],['label'=>'2★','pct'=>1],['label'=>'1★','pct'=>0]];
                @endphp
                @foreach($bars as $bar)
                <div class="rating-bar-row">
                    <span class="rating-bar-label">{{ $bar['label'] }}</span>
                    <div class="rating-bar-track"><div class="rating-bar-fill" style="width:{{ $bar['pct'] }}%"></div></div>
                    <span class="rating-bar-pct">{{ $bar['pct'] }}%</span>
                </div>
                @endforeach
            </div>
            <div class="col-lg-4 fade-up d2">
                <div style="background:var(--bg-section);border-radius:16px;padding:1.75rem;">
                    <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:var(--primary);margin-bottom:1rem;">Yang Paling Dipuji</h3>
                    @php $praise = ['Kebersihan villa', 'Pelayanan staf', 'Fasilitas private pool', 'Lokasi strategis', 'Value for money']; @endphp
                    @foreach($praise as $p)
                    <div style="display:flex;align-items:center;gap:0.6rem;padding:0.45rem 0;font-size:0.875rem;">
                        <i class="bi bi-hand-thumbs-up-fill" style="color:var(--accent);"></i> {{ $p }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials grid --}}
<section class="testi-section">
    <div class="container">
        @php
        $testimonials = [
            ['name'=>'Rina Kusuma',     'init'=>'R', 'bg'=>'#E8F5E9', 'city'=>'Jakarta',    'villa'=>'Villa Arjuna',  'stars'=>5, 'date'=>'Jun 2025', 'quote'=>'"Villa sangat bersih dan nyaman. Private pool-nya jernih dan area outdoor-nya luar biasa. Staf sangat ramah dan responsif. Kami pasti akan kembali lagi ke Athara Villas!"'],
            ['name'=>'Budi Santoso',    'init'=>'B', 'bg'=>'#FFF3E0', 'city'=>'Surabaya',   'villa'=>'Villa Dewi',    'stars'=>5, 'date'=>'Mei 2025', 'quote'=>'"Honeymoon kami jadi sangat berkesan! Villa Dewi sangat romantis dengan dekorasi yang indah. Bathtub-nya mewah dan view dari kamar menakjubkan. Terima kasih Athara Villas!"'],
            ['name'=>'Dewi Anggraini', 'init'=>'D', 'bg'=>'#E3F2FD', 'city'=>'Bandung',    'villa'=>'Villa Surya',   'stars'=>5, 'date'=>'Apr 2025', 'quote'=>'"Family gathering terbaik yang pernah kami lakukan! Villa Surya sempurna untuk 12 orang. Anak-anak senang main di pool, orang tua bisa santai di teras. Sangat worth it!"'],
            ['name'=>'Arif Rahman',     'init'=>'A', 'bg'=>'#F3E5F5', 'city'=>'Malang',     'villa'=>'Villa Arjuna',  'stars'=>5, 'date'=>'Mar 2025', 'quote'=>'"Corporate retreat tim kami berjalan sangat lancar. Fasilitas meeting room-nya memadai dan makanan yang kami masak di dapur lengkap villa sangat menyenangkan. Recommended!"'],
            ['name'=>'Siti Rahayu',     'init'=>'S', 'bg'=>'#E8F5E9', 'city'=>'Yogyakarta', 'villa'=>'Villa Bintang', 'stars'=>4, 'date'=>'Feb 2025', 'quote'=>'"Tempat yang tenang dan bersih. Cocok untuk me-time berdua suami. Fasilitas lengkap, WiFi kencang. Sedikit catatan untuk area taman yang bisa lebih dirawat lagi. Overall sangat puas!"'],
            ['name'=>'Hendra Wijaya',   'init'=>'H', 'bg'=>'#FFF9C4', 'city'=>'Semarang',   'villa'=>'Villa Kenanga', 'stars'=>5, 'date'=>'Jan 2025', 'quote'=>'"Suasana Villa Kenanga sangat alami dan tenang. Gazebo tepi pool-nya jadi tempat favorit kami seharian. Tim Athara sangat helpful dan fast response. Pasti balik lagi!"'],
            ['name'=>'Maya Lestari',    'init'=>'M', 'bg'=>'#FCE4EC', 'city'=>'Jakarta',     'villa'=>'Villa Pandan',  'stars'=>5, 'date'=>'Des 2024', 'quote'=>'"Villa Pandan adalah villa terbaru dan wow — infinity pool-nya luar biasa indah! Smart home system-nya sangat keren. Desain interiornya instagramable banget. 10/10!"'],
            ['name'=>'Rizky Pratama',   'init'=>'R', 'bg'=>'#E0F2F1', 'city'=>'Surabaya',   'villa'=>'Villa Surya',   'stars'=>5, 'date'=>'Nov 2024', 'quote'=>'"Reuni SMA kami (20 orang dibagi 2 villa) jadi sangat meriah. Staf sangat akomodatif untuk request kami. Harga sangat sesuai dengan fasilitas premium yang didapat!"'],
            ['name'=>'Fitri Handayani', 'init'=>'F', 'bg'=>'#E8EAF6', 'city'=>'Malang',     'villa'=>'Villa Dewi',    'stars'=>5, 'date'=>'Okt 2024', 'quote'=>'"Merayakan anniversary ke-5 di sini — keputusan terbaik! Surprise dekorasi yang kami request dipersiapkan dengan sempurna. Pelayanan sangat memuaskan. Highly recommended!"'],
        ];
        @endphp
        <div class="row g-4">
            @foreach($testimonials as $i => $t)
            <div class="col-md-6 col-lg-4 d-flex fade-up d{{ ($i % 3) + 1 }}">
                <div class="t-card w-100">
                    <div class="t-villa">{{ $t['villa'] }}</div>
                    <div class="t-stars">
                        @for($s=0;$s<$t['stars'];$s++)<i class="bi bi-star-fill"></i>@endfor
                        @if($t['stars'] < 5)<i class="bi bi-star-half"></i>@endif
                    </div>
                    <p class="t-quote">{{ $t['quote'] }}</p>
                    <div class="t-author">
                        <div class="t-avatar" style="background:{{ $t['bg'] }};">{{ $t['init'] }}</div>
                        <div>
                            <div class="t-name">{{ $t['name'] }}</div>
                            <div class="t-meta"><i class="bi bi-geo-alt-fill"></i>{{ $t['city'] }} &middot; {{ $t['date'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="background:var(--bg-section);padding:5rem 0;text-align:center;">
    <div class="container fade-up">
        <span class="sec-label">Giliran Anda</span>
        <h2 class="sec-title" style="max-width:480px;margin:0 auto 1rem;">Ciptakan Kenangan Indah Anda Sendiri</h2>
        <p class="sec-desc" style="margin:0 auto 2rem;">Bergabunglah bersama ribuan tamu yang telah merasakan pengalaman istimewa di Athara Villas.</p>
        <a href="{{ route('kontak') }}" class="btn-gold">Reservasi Sekarang <i class="bi bi-arrow-right"></i></a>
    </div>
</section>

@endsection
