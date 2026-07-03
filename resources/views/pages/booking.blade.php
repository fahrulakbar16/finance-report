@extends('layouts.landing')

@section('title', 'Reservasi Villa')
@section('description', 'Pesan villa impian Anda di Athara Villas — pilih tanggal, isi data, dan konfirmasi reservasi dalam hitungan menit.')

@section('banner-label', 'Reservasi')
@section('banner', 'Pesan Villa Anda')
@section('banner-desc', 'Proses mudah & cepat. Konfirmasi dalam 1×24 jam.')

@section('styles')
<style>
    /* ── Step indicator ── */
    .step-bar { background:#fff; border-bottom:1px solid #f0f0ea; padding:1.5rem 0; position:sticky; top:65px; z-index:100; box-shadow:0 2px 12px rgba(0,0,0,0.04); }
    .step-list { display:flex; align-items:center; justify-content:center; gap:0; max-width:680px; margin:0 auto; }
    .step-item { display:flex; align-items:center; gap:0.5rem; flex:1; }
    .step-item:last-child { flex:none; }
    .step-num { width:34px; height:34px; border-radius:50%; border:2px solid #ddd; display:flex; align-items:center; justify-content:center; font-size:0.8rem; font-weight:700; color:#aaa; background:#fff; flex-shrink:0; transition:all 0.3s; }
    .step-label { font-size:0.78rem; font-weight:600; color:#aaa; white-space:nowrap; transition:color 0.3s; }
    .step-line { flex:1; height:2px; background:#e5e7eb; margin:0 0.5rem; transition:background 0.4s; }
    .step-item.active .step-num { border-color:var(--accent); background:var(--accent); color:var(--primary); }
    .step-item.active .step-label { color:var(--primary); }
    .step-item.done .step-num { border-color:var(--primary); background:var(--primary); color:#fff; }
    .step-item.done .step-label { color:var(--primary); }
    .step-item.done + .step-line,
    .step-line.done { background:var(--primary); }

    /* ── Main layout ── */
    .booking-wrap { padding:3rem 0 6rem; background:var(--bg-main); min-height:60vh; }
    .booking-step { display:none; }
    .booking-step.active { display:block; }

    /* ── Villa selector ── */
    .villa-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem; }
    @media(max-width:991px){ .villa-grid { grid-template-columns:repeat(2,1fr); } }
    @media(max-width:575px){ .villa-grid { grid-template-columns:1fr; } }

    .v-pick { border:2px solid #e5e7eb; border-radius:16px; overflow:hidden; cursor:pointer; transition:border-color 0.25s, box-shadow 0.25s, transform 0.2s; background:#fff; position:relative; }
    .v-pick:hover { border-color:var(--accent); transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,0.08); }
    .v-pick.selected { border-color:var(--accent); box-shadow:0 0 0 3px rgba(201,168,76,0.2); }
    .v-pick-check { position:absolute; top:10px; right:10px; width:28px; height:28px; border-radius:50%; background:var(--accent); color:var(--primary); display:none; align-items:center; justify-content:center; font-size:0.9rem; z-index:2; }
    .v-pick.selected .v-pick-check { display:flex; }
    .v-pick-img { height:130px; overflow:hidden; }
    .v-pick-img img { width:100%; height:100%; object-fit:cover; transition:transform 0.4s; }
    .v-pick:hover .v-pick-img img { transform:scale(1.05); }
    .v-pick-badge { position:absolute; top:10px; left:10px; background:var(--primary); color:var(--accent); font-size:0.65rem; font-weight:700; padding:0.2rem 0.6rem; border-radius:2rem; letter-spacing:.04em; }
    .v-pick-body { padding:0.9rem 1rem 1rem; }
    .v-pick-name { font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:600; color:var(--primary); margin-bottom:0.35rem; }
    .v-pick-meta { display:flex; gap:0.75rem; font-size:0.75rem; color:var(--text-muted); margin-bottom:0.5rem; }
    .v-pick-meta i { color:var(--accent); margin-right:0.2rem; }
    .v-pick-price { font-size:0.9rem; font-weight:700; color:var(--primary); }
    .v-pick-price span { font-size:0.72rem; font-weight:400; color:var(--text-muted); }

    /* ── Dates & guests ── */
    .dates-row { background:#fff; border-radius:16px; padding:1.5rem; box-shadow:0 2px 12px rgba(0,0,0,0.05); }
    .dates-row label { font-size:0.82rem; font-weight:600; color:var(--text-dark); display:block; margin-bottom:0.4rem; }
    .form-ctrl { border:1.5px solid #e5e7eb; border-radius:10px; padding:0.7rem 1rem; font-size:0.88rem; width:100%; transition:border-color 0.3s; font-family:'DM Sans',sans-serif; background:#fff; }
    .form-ctrl:focus { outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(201,168,76,0.15); }
    .form-ctrl.error { border-color:#e53e3e; }

    /* ── Sticky summary panel ── */
    .summary-panel { background:#fff; border-radius:20px; padding:1.75rem; box-shadow:0 4px 30px rgba(0,0,0,0.07); position:sticky; top:140px; }
    .summary-title { font-family:'Cormorant Garamond',serif; font-size:1.35rem; color:var(--primary); margin-bottom:1.25rem; font-weight:600; }
    .summary-villa-row { display:flex; gap:0.85rem; align-items:center; margin-bottom:1.25rem; padding-bottom:1.25rem; border-bottom:1px solid #f3f4f6; }
    .summary-villa-img { width:70px; height:54px; border-radius:10px; object-fit:cover; flex-shrink:0; }
    .summary-villa-name { font-weight:600; font-size:0.9rem; color:var(--text-dark); margin-bottom:0.15rem; }
    .summary-villa-cap { font-size:0.76rem; color:var(--text-muted); }
    .summary-row { display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:0.65rem; color:var(--text-muted); }
    .summary-row strong { color:var(--text-dark); }
    .summary-divider { height:1px; background:#f3f4f6; margin:1rem 0; }
    .summary-total { display:flex; justify-content:space-between; font-size:1rem; font-weight:700; color:var(--primary); }
    .summary-empty { text-align:center; padding:1.5rem 0; color:var(--text-muted); font-size:0.85rem; }
    .summary-empty i { font-size:2rem; color:#e5e7eb; display:block; margin-bottom:0.5rem; }

    /* ── Btn next/prev ── */
    .btn-next { background:var(--accent); color:var(--primary); border:none; border-radius:2rem; padding:0.85rem 2.2rem; font-weight:700; font-size:0.92rem; cursor:pointer; display:inline-flex; align-items:center; gap:0.5rem; transition:background 0.3s, transform 0.2s; }
    .btn-next:hover { background:var(--accent-light); transform:translateY(-2px); }
    .btn-next:disabled { background:#e5e7eb; color:#aaa; cursor:not-allowed; transform:none; }
    .btn-prev { background:transparent; color:var(--text-muted); border:1.5px solid #e5e7eb; border-radius:2rem; padding:0.85rem 2rem; font-weight:600; font-size:0.92rem; cursor:pointer; display:inline-flex; align-items:center; gap:0.5rem; transition:all 0.3s; }
    .btn-prev:hover { border-color:var(--primary); color:var(--primary); }
    .btn-bar { display:flex; align-items:center; justify-content:space-between; margin-top:2rem; padding-top:1.5rem; border-top:1px solid #f0f0ea; }

    /* ── Form step 2 ── */
    .form-card { background:#fff; border-radius:20px; padding:2rem; box-shadow:0 4px 24px rgba(0,0,0,0.06); }
    .form-section-title { font-family:'Cormorant Garamond',serif; font-size:1.5rem; color:var(--primary); margin-bottom:1.25rem; }
    .form-row { display:grid; gap:1rem; margin-bottom:1rem; }
    .form-row.two { grid-template-columns:1fr 1fr; }
    @media(max-width:575px){ .form-row.two { grid-template-columns:1fr; } }
    .form-group label { font-size:0.82rem; font-weight:600; color:var(--text-dark); display:block; margin-bottom:0.4rem; }
    .form-group label .req { color:var(--accent); }
    textarea.form-ctrl { resize:vertical; min-height:100px; }
    .terms-row { display:flex; align-items:flex-start; gap:0.75rem; padding:1rem; background:var(--bg-section); border-radius:10px; margin-top:0.5rem; }
    .terms-row input[type=checkbox] { width:18px; height:18px; margin-top:2px; accent-color:var(--accent); flex-shrink:0; cursor:pointer; }
    .terms-row label { font-size:0.82rem; color:var(--text-muted); cursor:pointer; }
    .terms-row a { color:var(--accent); font-weight:600; }
    .err-msg { font-size:0.76rem; color:#e53e3e; margin-top:0.3rem; display:none; }
    .err-msg.show { display:block; }

    /* ── Step 3: summary + payment ── */
    .confirm-card { background:#fff; border-radius:20px; padding:2rem; box-shadow:0 4px 24px rgba(0,0,0,0.06); }
    .confirm-section { margin-bottom:1.5rem; }
    .confirm-label { font-size:0.75rem; font-weight:700; color:var(--text-muted); letter-spacing:.06em; text-transform:uppercase; margin-bottom:0.6rem; }
    .confirm-val { font-size:0.92rem; color:var(--text-dark); font-weight:500; }
    .price-row { display:flex; justify-content:space-between; font-size:0.88rem; margin-bottom:0.6rem; }
    .price-row.total { font-weight:700; font-size:1rem; color:var(--primary); border-top:1px solid #f0f0ea; padding-top:0.75rem; margin-top:0.75rem; }
    .price-row .muted { color:var(--text-muted); }

    .payment-card { background:#fff; border-radius:20px; padding:2rem; box-shadow:0 4px 24px rgba(0,0,0,0.06); height:100%; }
    .bank-item { display:flex; align-items:center; gap:1rem; padding:1rem; background:var(--bg-section); border-radius:12px; margin-bottom:0.75rem; }
    .bank-logo { width:56px; height:34px; border-radius:6px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.75rem; flex-shrink:0; }
    .bank-name { font-size:0.82rem; font-weight:600; color:var(--text-dark); }
    .bank-num { font-size:0.9rem; font-family:monospace; color:var(--primary); font-weight:700; letter-spacing:.05em; }
    .bank-holder { font-size:0.76rem; color:var(--text-muted); }
    .notice-box { background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.25); border-radius:12px; padding:1rem 1.25rem; font-size:0.82rem; color:var(--primary); margin-top:1rem; }
    .notice-box i { color:var(--accent); margin-right:0.4rem; }

    /* ── Step 4: Success ── */
    .success-wrap { text-align:center; padding:3rem 0; }
    .success-icon { width:90px; height:90px; border-radius:50%; background:linear-gradient(135deg,var(--primary),#2D6148); display:flex; align-items:center; justify-content:center; font-size:2.5rem; color:#fff; margin:0 auto 1.5rem; }
    .success-ref { display:inline-block; background:var(--bg-section); border:2px dashed var(--accent); border-radius:12px; padding:0.85rem 2rem; font-family:monospace; font-size:1.4rem; font-weight:700; color:var(--primary); letter-spacing:.1em; margin:1rem 0; }
    .success-steps { text-align:left; max-width:480px; margin:1.5rem auto; }
    .success-step { display:flex; gap:1rem; align-items:flex-start; margin-bottom:1.1rem; }
    .success-step-num { width:30px; height:30px; border-radius:50%; background:var(--accent); color:var(--primary); font-weight:700; font-size:0.8rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:2px; }
    .success-step-text { font-size:0.875rem; color:var(--text-muted); line-height:1.6; }
    .success-step-text strong { color:var(--text-dark); display:block; margin-bottom:0.1rem; }
</style>
@endsection

@section('content')

{{-- Step indicator --}}
<div class="step-bar">
    <div class="container">
        <div class="step-list">
            <div class="step-item active" id="si-1">
                <div class="step-num" id="sn-1">1</div>
                <div class="step-label">Villa & Tanggal</div>
            </div>
            <div class="step-line" id="sl-1"></div>
            <div class="step-item" id="si-2">
                <div class="step-num" id="sn-2">2</div>
                <div class="step-label">Data Tamu</div>
            </div>
            <div class="step-line" id="sl-2"></div>
            <div class="step-item" id="si-3">
                <div class="step-num" id="sn-3">3</div>
                <div class="step-label">Konfirmasi</div>
            </div>
            <div class="step-line" id="sl-3"></div>
            <div class="step-item" id="si-4">
                <div class="step-num" id="sn-4"><i class="bi bi-check-lg" style="font-size:.85rem;"></i></div>
                <div class="step-label">Selesai</div>
            </div>
        </div>
    </div>
</div>

<section class="booking-wrap">
<div class="container">

{{-- ════ STEP 1: Villa & Tanggal ════ --}}
<div class="booking-step active" id="step-1">
    <div class="row g-4 align-items-start">
        <div class="col-lg-8">

            {{-- Villa selector --}}
            <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.6rem;color:var(--primary);margin-bottom:1rem;">Pilih Villa</h3>
            <div class="villa-grid" id="villaGrid">
                @foreach($villas as $v)
                <div class="v-pick" data-slug="{{ $v['slug'] }}" onclick="selectVilla('{{ $v['slug'] }}')">
                    <div class="v-pick-check"><i class="bi bi-check-lg"></i></div>
                    @if($v['badge'])<div class="v-pick-badge">{{ $v['badge'] }}</div>@endif
                    <div class="v-pick-img">
                        <img src="{{ $v['thumb'] }}" alt="{{ $v['name'] }}" loading="lazy">
                    </div>
                    <div class="v-pick-body">
                        <div class="v-pick-name">{{ $v['name'] }}</div>
                        <div class="v-pick-meta">
                            <span><i class="bi bi-people-fill"></i>{{ $v['capacity'] }} orang</span>
                            <span><i class="bi bi-door-closed-fill"></i>{{ $v['bedrooms'] }} kamar</span>
                        </div>
                        <div class="v-pick-price">Rp {{ number_format($v['price'], 0, ',', '.') }} <span>/ malam</span></div>
                    </div>
                </div>
                @endforeach
            </div>
            <div id="villa-err" class="err-msg">Silakan pilih villa terlebih dahulu.</div>

            {{-- Dates & guests --}}
            <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.6rem;color:var(--primary);margin:1.75rem 0 1rem;">Tanggal & Tamu</h3>
            <div class="dates-row">
                <div class="row g-3">
                    <div class="col-sm-6 col-lg-3">
                        <div class="form-group">
                            <label>Check-in <span class="req">*</span></label>
                            <input type="date" id="checkin" class="form-ctrl" onchange="onDateChange()">
                            <div class="err-msg" id="checkin-err">Pilih tanggal check-in.</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="form-group">
                            <label>Check-out <span class="req">*</span></label>
                            <input type="date" id="checkout" class="form-ctrl" onchange="onDateChange()">
                            <div class="err-msg" id="checkout-err">Pilih tanggal check-out (minimal 1 malam).</div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="form-group">
                            <label>Jumlah Tamu <span class="req">*</span></label>
                            <input type="number" id="guests" class="form-ctrl" value="1" min="1" max="30" onchange="updateSummary()">
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="form-group">
                            <label>Durasi</label>
                            <div class="form-ctrl" id="nights-display" style="background:#f9fafb;color:var(--text-muted);">— malam</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-bar">
                <div></div>
                <button class="btn-next" onclick="goStep2()">Lanjutkan <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>

        {{-- Sticky summary --}}
        <div class="col-lg-4">
            <div class="summary-panel">
                <div class="summary-title">Ringkasan Pesanan</div>
                <div id="summary-empty" class="summary-empty">
                    <i class="bi bi-house-door"></i>
                    Pilih villa dan tanggal untuk melihat ringkasan.
                </div>
                <div id="summary-content" style="display:none;">
                    <div class="summary-villa-row">
                        <img class="summary-villa-img" id="s-thumb" src="" alt="">
                        <div>
                            <div class="summary-villa-name" id="s-name">—</div>
                            <div class="summary-villa-cap" id="s-cap">—</div>
                        </div>
                    </div>
                    <div class="summary-row"><span>Check-in</span><strong id="s-checkin">—</strong></div>
                    <div class="summary-row"><span>Check-out</span><strong id="s-checkout">—</strong></div>
                    <div class="summary-row"><span>Durasi</span><strong id="s-nights">—</strong></div>
                    <div class="summary-row"><span>Tamu</span><strong id="s-guests">—</strong></div>
                    <div class="summary-divider"></div>
                    <div class="summary-row"><span id="s-price-label">Harga villa</span><strong id="s-price-sub">—</strong></div>
                    <div class="summary-row"><span>Biaya kebersihan</span><strong id="s-clean">Rp 200.000</strong></div>
                    <div class="summary-divider"></div>
                    <div class="summary-total"><span>Total</span><span id="s-total">—</span></div>
                    <p style="font-size:0.72rem;color:var(--text-muted);margin-top:0.75rem;"><i class="bi bi-info-circle me-1"></i>Belum termasuk deposit Rp 500.000 (refundable).</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ════ STEP 2: Data Tamu ════ --}}
<div class="booking-step" id="step-2">
    <div class="row g-4 align-items-start">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-section-title">Data Pemesan</div>
                <div class="form-row two">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="req">*</span></label>
                        <input type="text" id="f-name" class="form-ctrl" placeholder="John Doe">
                        <div class="err-msg" id="f-name-err">Nama lengkap wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label>No. HP / WhatsApp <span class="req">*</span></label>
                        <input type="tel" id="f-phone" class="form-ctrl" placeholder="+62 8xx-xxxx-xxxx">
                        <div class="err-msg" id="f-phone-err">No. HP wajib diisi.</div>
                    </div>
                </div>
                <div class="form-row two">
                    <div class="form-group">
                        <label>Email <span class="req">*</span></label>
                        <input type="email" id="f-email" class="form-ctrl" placeholder="email@contoh.com">
                        <div class="err-msg" id="f-email-err">Email tidak valid.</div>
                    </div>
                    <div class="form-group">
                        <label>Keperluan</label>
                        <select id="f-purpose" class="form-ctrl">
                            <option value="Liburan Keluarga">Liburan Keluarga</option>
                            <option value="Honeymoon / Anniversary">Honeymoon / Anniversary</option>
                            <option value="Corporate / Gathering">Corporate / Gathering</option>
                            <option value="Reuni / Arisan">Reuni / Arisan</option>
                            <option value="Ulang Tahun">Ulang Tahun</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Permintaan Khusus <span style="color:var(--text-muted);font-weight:400;">(opsional)</span></label>
                        <textarea id="f-notes" class="form-ctrl" placeholder="Dekorasi ulang tahun, high chair untuk bayi, kamar di lantai bawah, dll."></textarea>
                    </div>
                </div>
                <div class="terms-row">
                    <input type="checkbox" id="f-terms">
                    <label for="f-terms">Saya telah membaca dan menyetujui <a href="#">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Pembatalan</a> Athara Villas.</label>
                </div>
                <div class="err-msg" id="f-terms-err">Harap centang persetujuan di atas.</div>
            </div>

            <div class="btn-bar">
                <button class="btn-prev" onclick="goStep(1)"><i class="bi bi-arrow-left"></i> Kembali</button>
                <button class="btn-next" onclick="goStep3()">Lanjutkan <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="summary-panel">
                <div class="summary-title">Ringkasan Pesanan</div>
                <div class="summary-villa-row">
                    <img class="summary-villa-img" id="s2-thumb" src="" alt="">
                    <div>
                        <div class="summary-villa-name" id="s2-name">—</div>
                        <div class="summary-villa-cap" id="s2-cap">—</div>
                    </div>
                </div>
                <div class="summary-row"><span>Check-in</span><strong id="s2-checkin">—</strong></div>
                <div class="summary-row"><span>Check-out</span><strong id="s2-checkout">—</strong></div>
                <div class="summary-row"><span>Durasi</span><strong id="s2-nights">—</strong></div>
                <div class="summary-row"><span>Tamu</span><strong id="s2-guests">—</strong></div>
                <div class="summary-divider"></div>
                <div class="summary-row"><span id="s2-price-label">Harga villa</span><strong id="s2-price-sub">—</strong></div>
                <div class="summary-row"><span>Biaya kebersihan</span><strong>Rp 200.000</strong></div>
                <div class="summary-divider"></div>
                <div class="summary-total"><span>Total</span><span id="s2-total">—</span></div>
            </div>
        </div>
    </div>
</div>

{{-- ════ STEP 3: Konfirmasi ════ --}}
<div class="booking-step" id="step-3">
    <div class="row g-4 align-items-start">
        <div class="col-lg-7">
            <div class="confirm-card mb-4">
                <div class="form-section-title" style="font-size:1.5rem;margin-bottom:1.5rem;">Detail Pemesanan</div>

                {{-- Villa --}}
                <div class="confirm-section" style="padding-bottom:1.25rem;border-bottom:1px solid #f3f4f6;">
                    <div class="confirm-label">Villa Dipilih</div>
                    <div style="display:flex;gap:1rem;align-items:center;margin-top:0.5rem;">
                        <img id="c-thumb" src="" style="width:80px;height:60px;border-radius:10px;object-fit:cover;" alt="">
                        <div>
                            <div style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:600;color:var(--primary);" id="c-name">—</div>
                            <div style="font-size:0.8rem;color:var(--text-muted);" id="c-cap">—</div>
                        </div>
                    </div>
                </div>

                {{-- Dates --}}
                <div class="confirm-section" style="padding:1.25rem 0;border-bottom:1px solid #f3f4f6;">
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="confirm-label">Check-in</div>
                            <div class="confirm-val" id="c-checkin">—</div>
                        </div>
                        <div class="col-4">
                            <div class="confirm-label">Check-out</div>
                            <div class="confirm-val" id="c-checkout">—</div>
                        </div>
                        <div class="col-4">
                            <div class="confirm-label">Durasi / Tamu</div>
                            <div class="confirm-val" id="c-dur">—</div>
                        </div>
                    </div>
                </div>

                {{-- Guest --}}
                <div class="confirm-section" style="padding:1.25rem 0;border-bottom:1px solid #f3f4f6;">
                    <div class="confirm-label">Data Pemesan</div>
                    <div class="row g-2 mt-1">
                        <div class="col-6"><div style="font-size:0.78rem;color:var(--text-muted);">Nama</div><div class="confirm-val" id="c-gname">—</div></div>
                        <div class="col-6"><div style="font-size:0.78rem;color:var(--text-muted);">No. HP</div><div class="confirm-val" id="c-gphone">—</div></div>
                        <div class="col-6"><div style="font-size:0.78rem;color:var(--text-muted);">Email</div><div class="confirm-val" id="c-gemail">—</div></div>
                        <div class="col-6"><div style="font-size:0.78rem;color:var(--text-muted);">Keperluan</div><div class="confirm-val" id="c-gpurpose">—</div></div>
                    </div>
                    <div id="c-notes-wrap" style="display:none;margin-top:0.75rem;">
                        <div style="font-size:0.78rem;color:var(--text-muted);">Permintaan Khusus</div>
                        <div class="confirm-val" id="c-gnotes" style="font-style:italic;"></div>
                    </div>
                </div>

                {{-- Price --}}
                <div style="padding-top:1.25rem;">
                    <div class="confirm-label">Rincian Biaya</div>
                    <div class="price-row mt-2"><span class="muted" id="c-p-label">Harga villa</span><span id="c-p-sub">—</span></div>
                    <div class="price-row"><span class="muted">Biaya kebersihan</span><span>Rp 200.000</span></div>
                    <div class="price-row"><span class="muted">Deposit (refundable)</span><span>Rp 500.000</span></div>
                    <div class="price-row total"><span>Total Pembayaran</span><span id="c-total">—</span></div>
                </div>
            </div>

            <div class="btn-bar">
                <button class="btn-prev" onclick="goStep(2)"><i class="bi bi-arrow-left"></i> Kembali</button>
                <button class="btn-next" id="btn-confirm" onclick="confirmBooking()">
                    <i class="bi bi-lock-fill" style="font-size:0.8rem;"></i> Konfirmasi Pemesanan
                </button>
            </div>
        </div>

        {{-- Payment info --}}
        <div class="col-lg-5">
            <div class="payment-card">
                <div class="form-section-title" style="font-size:1.35rem;margin-bottom:1.25rem;">Informasi Pembayaran</div>
                <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1.5rem;">Setelah konfirmasi, lakukan transfer DP (50%) ke salah satu rekening berikut:</p>

                <div class="bank-item">
                    <div class="bank-logo" style="background:#003087;color:#fff;">BCA</div>
                    <div>
                        <div class="bank-name">Bank BCA</div>
                        <div class="bank-num">1234 5678 90</div>
                        <div class="bank-holder">a.n. Athara Villas Indonesia</div>
                    </div>
                </div>
                <div class="bank-item">
                    <div class="bank-logo" style="background:#f15a24;color:#fff;">MAND</div>
                    <div>
                        <div class="bank-name">Bank Mandiri</div>
                        <div class="bank-num">1400 0098 7654</div>
                        <div class="bank-holder">a.n. Athara Villas Indonesia</div>
                    </div>
                </div>
                <div class="bank-item">
                    <div class="bank-logo" style="background:#009a44;color:#fff;">BRI</div>
                    <div>
                        <div class="bank-name">Bank BRI</div>
                        <div class="bank-num">0987 0100 1234 567</div>
                        <div class="bank-holder">a.n. Athara Villas Indonesia</div>
                    </div>
                </div>

                <div style="margin-top:1.25rem;padding:1rem;background:var(--bg-section);border-radius:12px;">
                    <div style="font-size:0.78rem;font-weight:700;color:var(--primary);margin-bottom:0.6rem;letter-spacing:.04em;">QRIS</div>
                    <div style="background:#e5e7eb;border-radius:8px;height:120px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:0.8rem;">
                        <span>QR Code tersedia setelah integrasi backend</span>
                    </div>
                </div>

                <div class="notice-box">
                    <i class="bi bi-info-circle-fill"></i>
                    Kirim bukti transfer ke tim kami. Reservasi dikonfirmasi dalam <strong>1×24 jam</strong> kerja setelah pembayaran diterima.
                </div>

                <div style="margin-top:1.25rem;display:flex;gap:0.75rem;font-size:0.8rem;color:var(--text-muted);">
                    <span><i class="bi bi-clock text-warning me-1"></i>Check-in 14.00</span>
                    <span><i class="bi bi-clock text-warning me-1"></i>Check-out 12.00</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ════ STEP 4: Selesai ════ --}}
<div class="booking-step" id="step-4">
    <div class="success-wrap">
        <div class="success-icon"><i class="bi bi-check-lg"></i></div>
        <span style="font-size:0.8rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--accent);">Reservasi Diterima</span>
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:2.4rem;color:var(--primary);margin:0.5rem 0;">Terima Kasih!</h2>
        <p style="color:var(--text-muted);max-width:480px;margin:0 auto 0.5rem;">Permintaan reservasi Anda telah kami terima. Berikut nomor referensi Anda:</p>
        <div class="success-ref" id="booking-ref">AV-20250101-0000</div>
        <p style="font-size:0.8rem;color:var(--text-muted);">Simpan nomor ini sebagai bukti pemesanan.</p>

        {{-- Summary box --}}
        <div style="max-width:480px;margin:1.5rem auto;background:#fff;border-radius:16px;padding:1.5rem;box-shadow:0 4px 20px rgba(0,0,0,0.06);text-align:left;">
            <div class="summary-row"><span>Villa</span><strong id="done-villa">—</strong></div>
            <div class="summary-row"><span>Check-in</span><strong id="done-checkin">—</strong></div>
            <div class="summary-row"><span>Check-out</span><strong id="done-checkout">—</strong></div>
            <div class="summary-row"><span>Tamu</span><strong id="done-guests">—</strong></div>
            <div class="summary-divider"></div>
            <div class="summary-total"><span>Total</span><span id="done-total">—</span></div>
        </div>

        <div class="success-steps">
            <div style="font-weight:600;color:var(--primary);margin-bottom:1rem;">Langkah Selanjutnya:</div>
            <div class="success-step">
                <div class="success-step-num">1</div>
                <div class="success-step-text">
                    <strong>Transfer DP 50%</strong>
                    Lakukan transfer ke rekening yang tertera di halaman sebelumnya.
                </div>
            </div>
            <div class="success-step">
                <div class="success-step-num">2</div>
                <div class="success-step-text">
                    <strong>Kirim Bukti Transfer</strong>
                    Kirim foto bukti transfer beserta nomor referensi ke email <a href="mailto:booking@atharavillas.com" style="color:var(--accent);">booking@atharavillas.com</a>.
                </div>
            </div>
            <div class="success-step">
                <div class="success-step-num">3</div>
                <div class="success-step-text">
                    <strong>Tunggu Konfirmasi</strong>
                    Tim kami akan mengkonfirmasi reservasi dalam 1×24 jam dan mengirim voucher ke email Anda.
                </div>
            </div>
        </div>

        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;margin-top:1rem;">
            <a href="{{ route('villa.index') }}" class="btn-prev" style="text-decoration:none;">
                <i class="bi bi-grid"></i> Lihat Villa Lain
            </a>
            <a href="{{ route('landing') }}" class="btn-next" style="text-decoration:none;">
                <i class="bi bi-house-door-fill"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

</div>
</section>

@endsection

@section('scripts')
<script>
const VILLAS = @json($villas);
const SELECTED_SLUG = @json($selectedSlug);
const CLEANING_FEE = 200000;
const DEPOSIT = 500000;

let state = {
    slug: null, villa: null,
    checkin: null, checkout: null, nights: 0, guests: 1,
};

// ── Helpers ──
function fmt(n) {
    return 'Rp ' + n.toLocaleString('id-ID');
}
function fmtDate(d) {
    if (!d) return '—';
    const [y,m,day] = d.split('-');
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    return `${parseInt(day)} ${months[parseInt(m)-1]} ${y}`;
}
function setMinDates() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('checkin').min = today;
    document.getElementById('checkout').min = today;
}

// ── Villa selection ──
function selectVilla(slug) {
    state.slug = slug;
    state.villa = VILLAS.find(v => v.slug === slug);
    document.querySelectorAll('.v-pick').forEach(el => el.classList.remove('selected'));
    document.querySelector(`.v-pick[data-slug="${slug}"]`).classList.add('selected');
    document.getElementById('villa-err').classList.remove('show');
    // Update guests max
    document.getElementById('guests').max = state.villa.capacity;
    updateSummary();
}

// ── Date change ──
function onDateChange() {
    const ci = document.getElementById('checkin').value;
    const co = document.getElementById('checkout').value;
    state.checkin = ci || null;
    state.checkout = co || null;

    if (ci && co) {
        const d1 = new Date(ci), d2 = new Date(co);
        // enforce checkout > checkin
        if (d2 <= d1) {
            const next = new Date(d1);
            next.setDate(next.getDate() + 1);
            state.checkout = next.toISOString().split('T')[0];
            document.getElementById('checkout').value = state.checkout;
        }
        const diff = (new Date(state.checkout) - new Date(state.checkin)) / 86400000;
        state.nights = Math.max(1, diff);
        // set checkout min = checkin+1
        const ciPlus = new Date(ci);
        ciPlus.setDate(ciPlus.getDate() + 1);
        document.getElementById('checkout').min = ciPlus.toISOString().split('T')[0];
    } else {
        state.nights = 0;
    }

    document.getElementById('nights-display').textContent =
        state.nights > 0 ? `${state.nights} malam` : '— malam';
    updateSummary();
}

// ── Update summary (step 1 & 2 panels) ──
function updateSummary() {
    state.guests = parseInt(document.getElementById('guests').value) || 1;
    const ready = state.villa && state.nights > 0;

    // Step 1 panel
    document.getElementById('summary-empty').style.display   = ready ? 'none'  : '';
    document.getElementById('summary-content').style.display = ready ? 'block' : 'none';

    if (!ready) return;

    const subtotal = state.villa.price * state.nights;
    const total    = subtotal + CLEANING_FEE;

    // Step 1
    document.getElementById('s-thumb').src          = state.villa.thumb;
    document.getElementById('s-thumb').alt          = state.villa.name;
    document.getElementById('s-name').textContent   = state.villa.name;
    document.getElementById('s-cap').textContent    = `${state.villa.bedrooms} kamar · ${state.villa.capacity} orang`;
    document.getElementById('s-checkin').textContent  = fmtDate(state.checkin);
    document.getElementById('s-checkout').textContent = fmtDate(state.checkout);
    document.getElementById('s-nights').textContent   = `${state.nights} malam`;
    document.getElementById('s-guests').textContent   = `${state.guests} orang`;
    document.getElementById('s-price-label').textContent = `${fmt(state.villa.price)} × ${state.nights} malam`;
    document.getElementById('s-price-sub').textContent   = fmt(subtotal);
    document.getElementById('s-total').textContent       = fmt(total);

    // Step 2 panel (sync)
    document.getElementById('s2-thumb').src           = state.villa.thumb;
    document.getElementById('s2-name').textContent    = state.villa.name;
    document.getElementById('s2-cap').textContent     = `${state.villa.bedrooms} kamar · ${state.villa.capacity} orang`;
    document.getElementById('s2-checkin').textContent  = fmtDate(state.checkin);
    document.getElementById('s2-checkout').textContent = fmtDate(state.checkout);
    document.getElementById('s2-nights').textContent   = `${state.nights} malam`;
    document.getElementById('s2-guests').textContent   = `${state.guests} orang`;
    document.getElementById('s2-price-label').textContent = `${fmt(state.villa.price)} × ${state.nights} malam`;
    document.getElementById('s2-price-sub').textContent   = fmt(subtotal);
    document.getElementById('s2-total').textContent       = fmt(total);
}

// ── Populate step 3 confirmation ──
function populateConfirm() {
    const subtotal = state.villa.price * state.nights;
    const total    = subtotal + CLEANING_FEE + DEPOSIT;

    document.getElementById('c-thumb').src            = state.villa.thumb;
    document.getElementById('c-name').textContent     = state.villa.name;
    document.getElementById('c-cap').textContent      = `${state.villa.bedrooms} kamar · Maks. ${state.villa.capacity} orang`;
    document.getElementById('c-checkin').textContent  = fmtDate(state.checkin);
    document.getElementById('c-checkout').textContent = fmtDate(state.checkout);
    document.getElementById('c-dur').textContent      = `${state.nights} malam / ${state.guests} tamu`;
    document.getElementById('c-gname').textContent    = document.getElementById('f-name').value;
    document.getElementById('c-gphone').textContent   = document.getElementById('f-phone').value;
    document.getElementById('c-gemail').textContent   = document.getElementById('f-email').value;
    document.getElementById('c-gpurpose').textContent = document.getElementById('f-purpose').value;
    const notes = document.getElementById('f-notes').value.trim();
    if (notes) {
        document.getElementById('c-notes-wrap').style.display = '';
        document.getElementById('c-gnotes').textContent = notes;
    } else {
        document.getElementById('c-notes-wrap').style.display = 'none';
    }
    document.getElementById('c-p-label').textContent = `${fmt(state.villa.price)} × ${state.nights} malam`;
    document.getElementById('c-p-sub').textContent   = fmt(subtotal);
    document.getElementById('c-total').textContent   = fmt(total);
}

// ── Step navigation ──
function goStep(n) {
    document.querySelectorAll('.booking-step').forEach(el => el.classList.remove('active'));
    document.getElementById(`step-${n}`).classList.add('active');

    // Update step indicators
    for (let i = 1; i <= 4; i++) {
        const si = document.getElementById(`si-${i}`);
        const sn = document.getElementById(`sn-${i}`);
        si.classList.remove('active', 'done');
        if (i < n)       { si.classList.add('done'); sn.innerHTML = '<i class="bi bi-check-lg" style="font-size:.75rem;"></i>'; }
        else if (i === n){ si.classList.add('active'); if (i < 4) sn.textContent = i; }
        else             { if (i < 4) sn.textContent = i; }
        if (i === 4 && n === 4) sn.innerHTML = '<i class="bi bi-check-lg" style="font-size:.85rem;"></i>';
    }
    for (let i = 1; i <= 3; i++) {
        const sl = document.getElementById(`sl-${i}`);
        sl.classList.toggle('done', i < n);
    }

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function goStep2() {
    let ok = true;
    if (!state.slug) {
        document.getElementById('villa-err').classList.add('show'); ok = false;
    }
    if (!state.checkin) {
        document.getElementById('checkin-err').classList.add('show');
        document.getElementById('checkin').classList.add('error'); ok = false;
    } else {
        document.getElementById('checkin-err').classList.remove('show');
        document.getElementById('checkin').classList.remove('error');
    }
    if (!state.checkout || state.nights < 1) {
        document.getElementById('checkout-err').classList.add('show');
        document.getElementById('checkout').classList.add('error'); ok = false;
    } else {
        document.getElementById('checkout-err').classList.remove('show');
        document.getElementById('checkout').classList.remove('error');
    }
    if (!ok) return;
    goStep(2);
}

function goStep3() {
    let ok = true;
    const name  = document.getElementById('f-name').value.trim();
    const phone = document.getElementById('f-phone').value.trim();
    const email = document.getElementById('f-email').value.trim();
    const terms = document.getElementById('f-terms').checked;

    if (!name)  { document.getElementById('f-name-err').classList.add('show');  document.getElementById('f-name').classList.add('error');  ok = false; } else { document.getElementById('f-name-err').classList.remove('show');  document.getElementById('f-name').classList.remove('error'); }
    if (!phone) { document.getElementById('f-phone-err').classList.add('show'); document.getElementById('f-phone').classList.add('error'); ok = false; } else { document.getElementById('f-phone-err').classList.remove('show'); document.getElementById('f-phone').classList.remove('error'); }
    if (!email || !email.includes('@')) { document.getElementById('f-email-err').classList.add('show'); document.getElementById('f-email').classList.add('error'); ok = false; } else { document.getElementById('f-email-err').classList.remove('show'); document.getElementById('f-email').classList.remove('error'); }
    if (!terms) { document.getElementById('f-terms-err').classList.add('show'); ok = false; } else { document.getElementById('f-terms-err').classList.remove('show'); }

    if (!ok) return;
    populateConfirm();
    goStep(3);
}

function confirmBooking() {
    const btn = document.getElementById('btn-confirm');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner" style="width:16px;height:16px;border:2px solid currentColor;border-top-color:transparent;border-radius:50%;display:inline-block;animation:spin .6s linear infinite;"></span> Memproses...';

    setTimeout(() => {
        // Generate booking reference
        const now  = new Date();
        const date = now.toISOString().slice(0,10).replace(/-/g,'');
        const rand = String(Math.floor(Math.random() * 9000) + 1000);
        const ref  = `AV-${date}-${rand}`;
        document.getElementById('booking-ref').textContent = ref;

        // Populate done page
        const total = state.villa.price * state.nights + CLEANING_FEE + DEPOSIT;
        document.getElementById('done-villa').textContent   = state.villa.name;
        document.getElementById('done-checkin').textContent = fmtDate(state.checkin);
        document.getElementById('done-checkout').textContent = fmtDate(state.checkout);
        document.getElementById('done-guests').textContent  = `${state.guests} orang`;
        document.getElementById('done-total').textContent   = fmt(total);

        goStep(4);
    }, 1800);
}

// ── Init ──
document.addEventListener('DOMContentLoaded', () => {
    setMinDates();
    if (SELECTED_SLUG) selectVilla(SELECTED_SLUG);
});
</script>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection
