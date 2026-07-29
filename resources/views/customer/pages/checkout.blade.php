@extends('layouts.landing')

@section('title', 'Checkout Pemesanan - Athara Villas')

@section('styles')
<style>
    :root {
        --surface: #ffffff;
        --bg-section: #fbfbfb;
        --border-color: rgba(0,0,0,0.08);
    }

    .vd-content { padding: 3rem 0 5rem; }
    .vd-checkout-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 2.5rem;
        align-items: start;
    }

    /* Entry Animation */
    .fade-up { opacity: 0; transform: translateY(20px); animation: fadeUpAnim 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .delay-1 { animation-delay: 0.15s; }
    .delay-2 { animation-delay: 0.3s; }
    @keyframes fadeUpAnim { to { opacity: 1; transform: translateY(0); } }

    .checkout-card {
        background: var(--surface);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        border: 1px solid var(--border-color);
        margin-bottom: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .checkout-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.06);
    }
    .checkout-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1.5rem;
    }

    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; }
    .form-control {
        width: 100%;
        padding: 0.85rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.95rem;
        background: var(--surface);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.15);
        background: #fff;
    }

    /* Validation Styles */
    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
        background: #fff;
    }
    .invalid-feedback {
        font-size: 0.82rem;
        color: #dc3545;
        margin-top: 0.4rem;
        display: none;
        animation: fadeUpAnim 0.3s ease;
    }
    .is-invalid ~ .invalid-feedback { display: block; }

    /* Voucher Area */
    .voucher-wrap {
        display: flex; gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .btn-apply {
        background: var(--accent);
        color: #fff; border: none;
        padding: 0 1.25rem; border-radius: 12px;
        font-weight: 600; cursor: pointer; transition: all 0.3s ease;
    }
    .btn-apply:hover {
        background: var(--accent-light);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(201, 168, 76, 0.25);
    }
    .btn-apply:active { transform: translateY(0); }
    .voucher-message { font-size: 0.82rem; font-weight: 500; }
    .voucher-message.success { color: #198754; }
    .voucher-message.error { color: #dc3545; }

    /* Summary Area */
    .summary-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 0.85rem 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.93rem;
    }
    .summary-item:last-of-type { border-bottom: none; }
    .summary-label { color: var(--text-muted); }
    .summary-val { font-weight: 600; color: var(--text-dark); }

    .summary-total {
        display: flex; justify-content: space-between; align-items: center;
        padding-top: 1rem;
        margin-top: 1rem;
        border-top: 2px dashed var(--border-color);
    }
    .summary-total-label { font-size: 1.1rem; font-weight: 700; color: var(--primary); }
    .summary-total-val { font-size: 1.5rem; font-weight: 700; color: var(--primary); }

    .villa-thumb {
        display: flex; gap: 1rem; align-items: center;
        margin-bottom: 1.5rem;
    }
    .villa-thumb img {
        width: 100px; height: 80px; object-fit: cover; border-radius: 12px;
    }
    .villa-thumb h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem; font-weight: 700; margin: 0 0 0.25rem; color: var(--primary);
    }
    .villa-thumb p { margin: 0; font-size: 0.85rem; color: var(--text-muted); }

    .btn-submit {
        display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        width: 100%;
        background: var(--primary); color: #fff;
        border: none; padding: 1.05rem; border-radius: 12px;
        font-size: 1.05rem; font-weight: 600; cursor: pointer;
        text-align: center; transition: all 0.3s ease;
        margin-top: 1.5rem;
    }
    .btn-submit i { transition: transform 0.3s ease; }
    .btn-submit:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27, 61, 47, 0.2);
    }
    .btn-submit:hover i { transform: translateX(5px); }
    .btn-submit:active { transform: translateY(0); box-shadow: none; }
    .btn-submit.loading { pointer-events: none; opacity: 0.85; }

    .doku-badge {
        display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        margin-top: 1.25rem; font-size: 0.78rem; color: var(--text-muted);
        background: rgba(25, 135, 84, 0.05); padding: 0.5rem; border-radius: 8px;
    }

    /* Animation for discount row */
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .discount-animate { animation: slideDown 0.4s ease forwards; }

    .checkout-mobile-bar {
        display: none;
        position: fixed; bottom: 0; left: 0; right: 0;
        background: var(--surface);
        padding: 0.85rem 1.25rem;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
        z-index: 1001;
        align-items: center; justify-content: space-between;
        border-top: 1px solid var(--border-color);
    }
    .btn-submit-mobile {
        background: var(--primary); color: #fff;
        border: none; padding: 0.6rem 1.25rem; border-radius: 12px;
        font-size: 0.9rem; font-weight: 600; cursor: pointer;
        transition: background 0.3s;
    }

    @media (max-width: 991px) {
        .vd-checkout-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .site-nav { display: none !important; }
        .site-footer { display: none !important; }
        body { padding-top: 0 !important; padding-bottom: 85px !important; }
        .checkout-mobile-bar { display: flex; }
        /* Sembunyikan tombol submit desktop di mobile */
        .btn-submit { display: none; }
        .vd-content { padding-top: 1.5rem; }
    }
</style>
@endsection

@section('content')
<section class="vd-content">
    <div class="container">

        @if(session('error'))
            <div class="alert alert-danger" style="background: #f8d7da; color: #842029; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <input type="hidden" name="villa_id" value="{{ $villa->id }}">
            <input type="hidden" name="check_in" value="{{ $checkIn->format('Y-m-d') }}">
            <input type="hidden" name="check_out" value="{{ $checkOut->format('Y-m-d') }}">
            <input type="hidden" name="voucher_code" id="inputVoucherCode" value="">

            <div class="vd-checkout-grid">

                {{-- LEFT: FORM DATA --}}
                <div>
                    <div class="checkout-card fade-up">
                        <h2 class="checkout-title">Detail Tamu</h2>

                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="guest_name" class="form-control" value="{{ Auth::user()->name ?? '' }}" required placeholder="Nama pemesan">
                            <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="guest_email" class="form-control" value="{{ Auth::user()->email ?? '' }}" required placeholder="Email untuk pengiriman e-invoice">
                            <div class="invalid-feedback">Alamat email wajib diisi dengan format yang benar.</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor WhatsApp / HP</label>
                            <input type="text" name="guest_phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}" required placeholder="Contoh: 08123456789">
                            <div class="invalid-feedback">Nomor WhatsApp / HP wajib diisi.</div>
                        </div>
                    </div>

                    <div class="checkout-card fade-up delay-1">
                        <h2 class="checkout-title" style="font-size: 1.4rem;">Punya Kode Voucher?</h2>
                        <div class="voucher-wrap">
                            <input type="text" id="voucherField" class="form-control" placeholder="Masukkan kode promo">
                            <button type="button" class="btn-apply" id="btnApplyVoucher">Apply</button>
                        </div>
                        <div id="voucherMessage" class="voucher-message"></div>
                    </div>
                </div>

                {{-- RIGHT: SUMMARY --}}
                <div>
                    <div class="checkout-card fade-up delay-2">
                        <h2 class="checkout-title">Ringkasan Pesanan</h2>

                        <div class="villa-thumb">
                            @php
                                $img = $villa->galleries->first() ? $villa->galleries->first()->image : $villa->image;
                                $imgSrc = filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/' . $img);
                            @endphp
                            <img src="{{ $imgSrc }}" alt="{{ $villa->name }}">
                            <div>
                                <h3>{{ $villa->name }}</h3>
                                <p><i class="bi bi-geo-alt"></i> {{ Str::limit($villa->address, 30) }}</p>
                            </div>
                        </div>

                        <div class="summary-item">
                            <span class="summary-label">Check-in</span>
                            <span class="summary-val">{{ $checkIn->format('d M Y') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Check-out</span>
                            <span class="summary-val">{{ $checkOut->format('d M Y') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Lama Menginap</span>
                            <span class="summary-val">{{ $nights }} Malam</span>
                        </div>

                        <div style="margin-top: 1.5rem;">
                            <div class="summary-item">
                                <span class="summary-label">Harga ({{ $nights }} malam)</span>
                                <span class="summary-val">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>

                            <div class="summary-item discount-animate" id="discountRow" style="display: none;">
                                <span class="summary-label" style="color: #198754;">Diskon Promo</span>
                                <span class="summary-val" style="color: #198754;" id="discountVal">- Rp 0</span>
                            </div>

                            <div class="summary-total">
                                <span class="summary-total-label">Total Pembayaran</span>
                                <span class="summary-total-val" id="totalVal">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit">
                            Lanjutkan Pembayaran <i class="bi bi-arrow-right"></i>
                        </button>

                        <div class="doku-badge">
                            <i class="bi bi-shield-lock-fill" style="color: #198754;"></i> Pembayaran aman didukung oleh <strong>DOKU</strong>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

{{-- MOBILE BOTTOM BAR --}}
<div class="checkout-mobile-bar">
    <div>
        <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.15rem;">Total Pembayaran</div>
        <div style="font-size: 1.15rem; font-weight: 700; color: var(--primary);" id="mobileTotalVal">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
    </div>
    <button type="button" class="btn-submit-mobile" id="btnSubmitMobile">
        Bayar <i class="bi bi-arrow-right"></i>
    </button>
</div>
@endsection

@section('scripts')
<script>
    const baseTotal = {{ $totalPrice }};
    const formatRp = (num) => 'Rp ' + new Intl.NumberFormat('id-ID').format(num);

    document.getElementById('btnApplyVoucher').addEventListener('click', function() {
        const code = document.getElementById('voucherField').value.trim();
        const msgDiv = document.getElementById('voucherMessage');
        const btn = this;

        if (!code) return;

        btn.disabled = true;
        btn.textContent = '...';
        msgDiv.textContent = '';
        msgDiv.className = 'voucher-message';

        fetch('{{ route("checkout.voucher") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: code, base_total: baseTotal })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                msgDiv.textContent = data.message;
                msgDiv.classList.add('success');

                // Update hidden input
                document.getElementById('inputVoucherCode').value = code;

                // Show discount row
                document.getElementById('discountRow').style.display = 'flex';
                document.getElementById('discountVal').textContent = '- ' + formatRp(data.discount_amount);

                // Update total
                document.getElementById('totalVal').textContent = formatRp(data.final_price);
                document.getElementById('mobileTotalVal').textContent = formatRp(data.final_price);
            } else {
                msgDiv.textContent = data.message;
                msgDiv.classList.add('error');

                // Reset hidden input & UI
                document.getElementById('inputVoucherCode').value = '';
                document.getElementById('discountRow').style.display = 'none';
                document.getElementById('totalVal').textContent = formatRp(baseTotal);
                document.getElementById('mobileTotalVal').textContent = formatRp(baseTotal);
            }
        })
        .catch(err => {
            msgDiv.textContent = 'Terjadi kesalahan, silakan coba lagi.';
            msgDiv.classList.add('error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'Apply';
        });
    });

    // Form Validation and Submission
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const form = this;
        let isValid = true;

        // Fields to validate
        const name = form.querySelector('[name="guest_name"]');
        const email = form.querySelector('[name="guest_email"]');
        const phone = form.querySelector('[name="guest_phone"]');

        // Reset classes
        [name, email, phone].forEach(el => el.classList.remove('is-invalid'));

        if (!name.value.trim()) { name.classList.add('is-invalid'); isValid = false; }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim() || !emailPattern.test(email.value)) { email.classList.add('is-invalid'); isValid = false; }

        if (!phone.value.trim()) { phone.classList.add('is-invalid'); isValid = false; }

        // Remove 'is-invalid' class on input change
        [name, email, phone].forEach(el => {
            el.addEventListener('input', function() { this.classList.remove('is-invalid'); }, {once: true});
        });

        if (!isValid) {
            e.preventDefault(); // Stop submission
            const firstInvalid = document.querySelector('.is-invalid');
            if (firstInvalid) {
                // Scroll specifically to make the label and field visible
                const offset = firstInvalid.getBoundingClientRect().top + window.scrollY - 100;
                window.scrollTo({ top: offset, behavior: 'smooth' });
                firstInvalid.focus();
            }
            return;
        }

        // If valid, show loading state
        const desktopBtn = document.querySelector('.btn-submit');
        const mobileBtn = document.querySelector('.btn-submit-mobile');

        if(desktopBtn) {
            desktopBtn.classList.add('loading');
            desktopBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
        }
        if(mobileBtn) {
            mobileBtn.style.pointerEvents = 'none';
            mobileBtn.style.opacity = '0.8';
            mobileBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...';
        }
    });

    // Trigger form submit via mobile button properly
    document.getElementById('btnSubmitMobile').addEventListener('click', function() {
        const form = document.getElementById('checkoutForm');
        // Gunakan requestSubmit agar validasi HTML5 dan listener submit kita terpanggil
        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
        } else {
            form.dispatchEvent(new Event('submit', { cancelable: true }));
        }
    });
</script>
@endsection
