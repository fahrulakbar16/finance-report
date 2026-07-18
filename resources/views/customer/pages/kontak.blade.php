@extends('layouts.landing')

@section('title', 'Kontak')
@section('description', 'Hubungi Athara Villas untuk reservasi, pertanyaan, atau konsultasi villa yang sesuai kebutuhan Anda.')

@section('banner-label', 'Kontak')
@section('banner', 'Hubungi Kami')
@section('banner-desc', 'Tim kami siap membantu Anda 7 hari seminggu. Respon dalam 1 jam kerja.')

@section('styles')
<style>
    .kontak-section { padding: 5rem 0 6rem; background: var(--bg-main); }

    .contact-card { background:#fff; border-radius:20px; padding:2rem 1.75rem; box-shadow:0 4px 24px rgba(0,0,0,0.06); text-align:center; height:100%; transition:transform 0.3s; }
    .contact-card:hover { transform:translateY(-6px); }
    .contact-icon { width:66px; height:66px; border-radius:50%; background:rgba(201,168,76,0.12); display:flex; align-items:center; justify-content:center; font-size:1.6rem; color:var(--accent); margin:0 auto 1.2rem; }
    .contact-label { font-family:'Cormorant Garamond',serif; font-size:1.3rem; font-weight:600; color:var(--primary); margin-bottom:0.4rem; }
    .contact-value { color:var(--text-muted); font-size:0.9rem; }
    .contact-link { color:var(--primary); font-weight:600; text-decoration:none; font-size:0.95rem; transition:color 0.3s; }
    .contact-link:hover { color:var(--accent); }

    .form-card { background:#fff; border-radius:24px; padding:2.5rem; box-shadow:0 4px 30px rgba(0,0,0,0.07); }
    .form-label { font-size:0.85rem; font-weight:600; color:var(--text-dark); margin-bottom:0.5rem; }
    .form-control, .form-select {
        border:1.5px solid #e5e7eb; border-radius:10px; padding:0.72rem 1rem;
        font-size:0.9rem; font-family:'DM Sans',sans-serif; transition:border-color 0.3s;
    }
    .form-control:focus, .form-select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(201,168,76,0.15); outline:none; }
    textarea.form-control { resize:vertical; min-height:130px; }
    .btn-submit { background:var(--accent); color:var(--primary); border:none; padding:0.9rem 2.5rem; border-radius:2rem; font-weight:600; font-size:0.95rem; cursor:pointer; transition:background 0.3s,transform 0.2s; display:inline-flex; align-items:center; gap:0.4rem; }
    .btn-submit:hover { background:var(--accent-light); transform:translateY(-2px); }

    .map-placeholder { background:linear-gradient(135deg,var(--primary),var(--primary-light)); border-radius:20px; height:280px; display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.7); font-size:0.9rem; text-align:center; padding:2rem; }
    .map-placeholder i { font-size:2.5rem; color:var(--accent); display:block; margin-bottom:0.75rem; }

    .faq-section { padding: 5rem 0; background: var(--bg-section); }
    .faq-item { background:#fff; border-radius:14px; margin-bottom:0.75rem; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.04); }
    .faq-q { display:flex; justify-content:space-between; align-items:center; padding:1.1rem 1.5rem; cursor:pointer; font-weight:600; font-size:0.92rem; color:var(--text-dark); border:none; background:none; width:100%; text-align:left; gap:1rem; }
    .faq-q i { color:var(--accent); flex-shrink:0; transition:transform 0.3s; }
    .faq-q[aria-expanded="true"] i { transform:rotate(45deg); }
    .faq-a { padding:0 1.5rem 1.25rem; font-size:0.875rem; color:var(--text-muted); line-height:1.75; display:none; }
    .faq-a.show { display:block; }
</style>
@endsection

@section('content')

<section class="kontak-section">
    <div class="container">

        {{-- Contact cards --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4 d-flex fade-up d1">
                <div class="contact-card w-100">
                    <div class="contact-icon"><i class="bi bi-whatsapp"></i></div>
                    <div class="contact-label">WhatsApp</div>
                    <p class="contact-value mb-2">Chat langsung, respon cepat</p>
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="contact-link">+62 812-3456-7890</a>
                </div>
            </div>
            <div class="col-md-4 d-flex fade-up d2">
                <div class="contact-card w-100">
                    <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div class="contact-label">Telepon</div>
                    <p class="contact-value mb-2">Senin – Minggu, 08.00 – 20.00</p>
                    <a href="tel:+6281234567890" class="contact-link">+62 812-3456-7890</a>
                </div>
            </div>
            <div class="col-md-4 d-flex fade-up d3">
                <div class="contact-card w-100">
                    <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div class="contact-label">Email</div>
                    <p class="contact-value mb-2">Respon dalam 1×24 jam</p>
                    <a href="mailto:info@atharavillas.com" class="contact-link">info@atharavillas.com</a>
                </div>
            </div>
        </div>

        {{-- Form + Map --}}
        <div class="row g-5 align-items-start">
            <div class="col-lg-7 fade-up">
                <div class="form-card">
                    <h2 style="font-family:'Cormorant Garamond',serif;font-size:2rem;color:var(--primary);margin-bottom:0.25rem;">Kirim Pesan</h2>
                    <p style="color:var(--text-muted);font-size:0.875rem;margin-bottom:1.75rem;">Isi form berikut dan kami akan menghubungi Anda sesegera mungkin.</p>

                    <form id="contactForm">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label">Nama Lengkap <span style="color:var(--accent);">*</span></label>
                                <input type="text" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">No. WhatsApp <span style="color:var(--accent);">*</span></label>
                                <input type="tel" class="form-control" placeholder="+62 8xx-xxxx-xxxx" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="email@contoh.com">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Villa yang Diminati</label>
                                <select class="form-select">
                                    <option value="">-- Pilih Villa --</option>
                                    <option>Villa Arjuna (4 Kamar, 8 Orang)</option>
                                    <option>Villa Dewi (3 Kamar, 6 Orang)</option>
                                    <option>Villa Surya (5 Kamar, 12 Orang)</option>
                                    <option>Villa Bintang (2 Kamar, 4 Orang)</option>
                                    <option>Villa Kenanga (3 Kamar, 6 Orang)</option>
                                    <option>Villa Pandan (4 Kamar, 8 Orang)</option>
                                    <option>Belum Tahu / Butuh Rekomendasi</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Tanggal Check-in</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Tanggal Check-out</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Jumlah Tamu</label>
                                <input type="number" class="form-control" placeholder="Contoh: 6" min="1">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Keperluan</label>
                                <select class="form-select">
                                    <option>Liburan Keluarga</option>
                                    <option>Honeymoon / Anniversary</option>
                                    <option>Corporate / Gathering</option>
                                    <option>Reuni / Arisan</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Pesan / Pertanyaan</label>
                                <textarea class="form-control" placeholder="Tuliskan pertanyaan atau kebutuhan khusus Anda di sini..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-submit">
                                    <i class="bi bi-send-fill"></i> Kirim Pesan
                                </button>
                                <p style="font-size:0.78rem;color:var(--text-muted);margin-top:0.75rem;">
                                    <i class="bi bi-shield-check me-1" style="color:var(--accent);"></i>
                                    Data Anda aman dan tidak akan dibagikan kepada pihak ketiga.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5 fade-up d2">
                {{-- Map placeholder --}}
                <div class="map-placeholder mb-4">
                    <div>
                        <i class="bi bi-geo-alt-fill"></i>
                        <strong style="color:#fff;font-size:1rem;display:block;margin-bottom:0.5rem;">Athara Villas</strong>
                        Jl. Raya Villa No. 123<br>Batu, Malang, Jawa Timur 65314<br><br>
                        <small style="font-size:0.78rem;">(Peta interaktif akan tersedia setelah backend diintegrasikan)</small>
                    </div>
                </div>

                {{-- Info box --}}
                <div style="background:#fff;border-radius:20px;padding:1.75rem;box-shadow:0 4px 24px rgba(0,0,0,0.06);">
                    <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.45rem;color:var(--primary);margin-bottom:1.25rem;">Informasi Penting</h3>
                    @php
                    $infos = [
                        ['icon'=>'bi-clock-fill',          'title'=>'Jam Operasional', 'val'=>'Senin – Minggu, 08.00 – 20.00 WIB'],
                        ['icon'=>'bi-calendar-check-fill', 'title'=>'Check-in',        'val'=>'Pukul 14.00 WIB'],
                        ['icon'=>'bi-calendar-x-fill',     'title'=>'Check-out',       'val'=>'Pukul 12.00 WIB'],
                        ['icon'=>'bi-credit-card-fill',    'title'=>'Pembayaran',      'val'=>'Transfer Bank / Cash / QRIS'],
                    ];
                    @endphp
                    @foreach($infos as $info)
                    <div style="display:flex;gap:0.85rem;margin-bottom:1.1rem;align-items:flex-start;">
                        <div style="width:38px;height:38px;border-radius:9px;background:rgba(201,168,76,0.1);display:flex;align-items:center;justify-content:center;color:var(--accent);flex-shrink:0;">
                            <i class="bi {{ $info['icon'] }}"></i>
                        </div>
                        <div>
                            <div style="font-size:0.78rem;color:var(--text-muted);">{{ $info['title'] }}</div>
                            <div style="font-size:0.9rem;font-weight:500;color:var(--text-dark);">{{ $info['val'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="faq-section">
    <div class="container">
        <div class="sec-center fade-up">
            <span class="sec-label">FAQ</span>
            <h2 class="sec-title">Pertanyaan yang Sering Ditanyakan</h2>
        </div>
        <div style="max-width:760px;margin:0 auto;" class="fade-up d1">
            @php
            $faqs = [
                ['q'=>'Berapa minimal menginap di Athara Villas?',              'a'=>'Minimal menginap adalah 1 malam. Untuk hari libur nasional dan musim liburan sekolah, minimal menginap bisa berbeda — silakan konfirmasi dengan tim kami.'],
                ['q'=>'Apakah harga sudah termasuk sarapan?',                   'a'=>'Harga villa tidak termasuk sarapan. Namun setiap villa dilengkapi dapur lengkap sehingga Anda dapat memasak sendiri. Kami juga dapat merekomendasikan restoran terdekat.'],
                ['q'=>'Bagaimana cara melakukan reservasi?',                     'a'=>'Anda dapat melakukan reservasi melalui WhatsApp, telepon, atau mengisi form di halaman ini. Tim kami akan menghubungi Anda untuk konfirmasi ketersediaan dan detail pembayaran.'],
                ['q'=>'Apakah ada deposit yang harus dibayar?',                 'a'=>'Ya, kami memerlukan deposit 30-50% dari total biaya menginap untuk mengamankan reservasi Anda. Sisa pembayaran dapat dilunasi saat check-in.'],
                ['q'=>'Apakah boleh membawa hewan peliharaan?',                 'a'=>'Hewan peliharaan tidak diperbolehkan di area villa demi kenyamanan semua tamu dan menjaga kebersihan fasilitas.'],
                ['q'=>'Bagaimana kebijakan pembatalan reservasi?',              'a'=>'Pembatalan lebih dari 7 hari sebelum check-in: refund 100%. Pembatalan 3-7 hari: refund 50%. Pembatalan kurang dari 3 hari atau no-show: deposit tidak dikembalikan.'],
            ];
            @endphp
            @foreach($faqs as $i => $faq)
            <div class="faq-item">
                <button class="faq-q" id="faq-btn-{{ $i }}" aria-expanded="false" onclick="toggleFaq({{ $i }})">
                    {{ $faq['q'] }}
                    <i class="bi bi-plus-lg"></i>
                </button>
                <div class="faq-a" id="faq-ans-{{ $i }}">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    function toggleFaq(i) {
        const btn = document.getElementById('faq-btn-' + i);
        const ans = document.getElementById('faq-ans-' + i);
        const isOpen = ans.classList.contains('show');
        document.querySelectorAll('.faq-a').forEach(a => a.classList.remove('show'));
        document.querySelectorAll('.faq-q').forEach(b => b.setAttribute('aria-expanded','false'));
        if (!isOpen) { ans.classList.add('show'); btn.setAttribute('aria-expanded','true'); }
    }

    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('.btn-submit');
        btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Pesan Terkirim!';
        btn.style.background = '#2D6148';
        btn.disabled = true;
        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-send-fill"></i> Kirim Pesan';
            btn.style.background = '';
            btn.disabled = false;
            this.reset();
        }, 3000);
    });
</script>
@endsection
