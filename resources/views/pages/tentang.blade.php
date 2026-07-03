@extends('layouts.landing')

@section('title', 'Tentang Kami')
@section('description', 'Kenali Athara Villas lebih dekat — cerita kami, visi misi, dan komitmen untuk memberikan pengalaman terbaik.')

@section('banner-label', 'Tentang Kami')
@section('banner', 'Kisah di Balik Athara Villas')
@section('banner-desc', 'Dari impian kecil menjadi destinasi villa premium terpercaya — inilah cerita kami.')

@section('styles')
<style>
    .about-story { padding: 6rem 0; background: var(--bg-main); }
    .story-img { border-radius: 16px; overflow: hidden; }
    .story-img img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 16px; }
    .story-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.875rem; height: 420px; }
    .story-grid img { border-radius: 12px; object-fit: cover; width: 100%; height: 100%; }
    .story-grid img:first-child { grid-row: span 2; }
    .story-body { padding-left: 2.5rem; }
    @media(max-width:991px){ .story-body { padding-left:0; margin-top: 2rem; } }
    .check-list { list-style:none; padding:0; margin: 1.5rem 0 2rem; }
    .check-list li { display:flex; align-items:center; gap:0.7rem; padding: 0.45rem 0; font-size:0.93rem; }
    .check-list li i { color: var(--accent); }

    .values-section { padding: 6rem 0; background: var(--bg-section); }
    .value-card { background:#fff; border-radius:16px; padding: 2.25rem 1.75rem; height:100%; box-shadow: 0 4px 24px rgba(0,0,0,0.05); transition: transform 0.3s; }
    .value-card:hover { transform: translateY(-6px); }
    .value-icon { width:60px; height:60px; border-radius:50%; background: rgba(201,168,76,0.12); display:flex; align-items:center; justify-content:center; font-size:1.4rem; color:var(--accent); margin-bottom:1.25rem; }
    .value-title { font-family:'Cormorant Garamond',serif; font-size:1.35rem; font-weight:600; color:var(--primary); margin-bottom:0.6rem; }
    .value-desc { font-size:0.875rem; color:var(--text-muted); line-height:1.7; }

    .stats-section { padding: 5rem 0; background: var(--primary); }
    .stat-col { text-align:center; padding: 1.5rem 1rem; border-right: 1px solid rgba(255,255,255,0.1); }
    .stat-col:last-child { border-right:none; }
    .stat-num { font-family:'Cormorant Garamond',serif; font-size:3.2rem; font-weight:600; color:var(--accent); display:block; line-height:1; }
    .stat-lbl { color:rgba(255,255,255,0.62); font-size:0.85rem; margin-top:0.5rem; display:block; }
    @media(max-width:767px){
        .stat-col { border-right:none; border-bottom:1px solid rgba(255,255,255,0.1); }
        .stat-col:last-child { border-bottom:none; }
    }

    .cta-strip { padding: 5.5rem 0; background: var(--bg-main); text-align:center; }
</style>
@endsection

@section('content')

{{-- Story --}}
<section class="about-story">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-6 fade-up">
                <div class="story-grid">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=800&auto=format&fit=crop" alt="Villa pool" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=600&auto=format&fit=crop" alt="Villa interior" loading="lazy">
                    <img src="https://images.unsplash.com/photo-1584132967334-10e028bd69f7?q=80&w=600&auto=format&fit=crop" alt="Villa view" loading="lazy">
                </div>
            </div>
            <div class="col-lg-6 fade-up d2">
                <div class="story-body">
                    <span class="sec-label">Cerita Kami</span>
                    <h2 class="sec-title">Dimulai dari Mimpi,<br>Kini Menjadi Kenyataan</h2>
                    <p style="color:var(--text-muted);line-height:1.8;font-size:0.95rem;">
                        Athara Villas lahir dari kecintaan mendalam terhadap keindahan alam dan keramahtamahan khas Indonesia. Berdiri sejak 2019, kami hadir dengan misi untuk menghadirkan pengalaman menginap premium yang memadukan kemewahan modern dengan keasrian alam.
                    </p>
                    <p style="color:var(--text-muted);line-height:1.8;font-size:0.95rem;margin-top:1rem;">
                        Setiap villa dirancang dengan penuh perhatian terhadap detail, memastikan setiap tamu merasakan kehangatan layaknya di rumah sendiri — namun dengan fasilitas kelas dunia.
                    </p>
                    <ul class="check-list">
                        <li><i class="bi bi-check-circle-fill"></i> Didirikan tahun 2019 di Batu, Malang</li>
                        <li><i class="bi bi-check-circle-fill"></i> 6 unit villa premium dengan konsep unik</li>
                        <li><i class="bi bi-check-circle-fill"></i> Lebih dari 2.000 tamu telah merasakan pengalaman kami</li>
                        <li><i class="bi bi-check-circle-fill"></i> Tim profesional berpengalaman di bidang hospitality</li>
                    </ul>
                    <a href="{{ route('villa.index') }}" class="btn-gold">Lihat Koleksi Villa <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Core Values --}}
<section class="values-section">
    <div class="container">
        <div class="sec-center fade-up">
            <span class="sec-label">Nilai Kami</span>
            <h2 class="sec-title">Yang Membuat Kami Berbeda</h2>
            <p class="sec-desc">Empat pilar utama yang menjadi landasan setiap keputusan dan pelayanan Athara Villas.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3 d-flex fade-up d1">
                <div class="value-card w-100">
                    <div class="value-icon"><i class="bi bi-heart-fill"></i></div>
                    <div class="value-title">Pelayanan Tulus</div>
                    <p class="value-desc">Setiap tamu diperlakukan seperti keluarga. Ketulusan adalah fondasi dari setiap interaksi kami.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 d-flex fade-up d2">
                <div class="value-card w-100">
                    <div class="value-icon"><i class="bi bi-gem"></i></div>
                    <div class="value-title">Kualitas Premium</div>
                    <p class="value-desc">Kami tidak berkompromi pada kualitas — dari fasilitas, kebersihan, hingga amenitas yang kami sediakan.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 d-flex fade-up d3">
                <div class="value-card w-100">
                    <div class="value-icon"><i class="bi bi-tree-fill"></i></div>
                    <div class="value-title">Ramah Lingkungan</div>
                    <p class="value-desc">Kami berkomitmen menjaga kelestarian alam sekitar sebagai bagian dari tanggung jawab kami.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 d-flex fade-up d4">
                <div class="value-card w-100">
                    <div class="value-icon"><i class="bi bi-shield-check-fill"></i></div>
                    <div class="value-title">Kepercayaan</div>
                    <p class="value-desc">Transparansi dan kejujuran dalam setiap transaksi membuat tamu percaya dan kembali lagi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="stats-section">
    <div class="container">
        <div class="row g-0">
            <div class="col-6 col-md-3"><div class="stat-col"><span class="stat-num">6+</span><span class="stat-lbl">Unit Villa</span></div></div>
            <div class="col-6 col-md-3"><div class="stat-col"><span class="stat-num">2K+</span><span class="stat-lbl">Tamu Puas</span></div></div>
            <div class="col-6 col-md-3"><div class="stat-col"><span class="stat-num">5★</span><span class="stat-lbl">Rating Rata-rata</span></div></div>
            <div class="col-6 col-md-3"><div class="stat-col"><span class="stat-num">5+</span><span class="stat-lbl">Tahun Berpengalaman</span></div></div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-strip fade-up">
    <div class="container">
        <span class="sec-label">Bergabung Bersama Kami</span>
        <h2 class="sec-title" style="max-width:500px;margin:0 auto 1rem;">Siap Menciptakan Kenangan Indah?</h2>
        <p class="sec-desc" style="margin:0 auto 2rem;">Temukan villa sempurna untuk momen istimewa Anda bersama Athara Villas.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('villa.index') }}" class="btn-gold">Lihat Villa <i class="bi bi-arrow-right"></i></a>
            <a href="{{ route('kontak') }}" class="btn-outline-dark">Hubungi Kami</a>
        </div>
    </div>
</section>

@endsection
