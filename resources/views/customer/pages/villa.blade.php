@extends('layouts.search')

@section('title', 'Athara Villas - Booking Villa Murah Online')

@section('styles')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Hero Section */
    .hero-section {
        position: relative;
        width: 100%;
        min-height: 520px;
        background: url('https://images.unsplash.com/photo-1613977257363-707ba9348227?q=80&w=1600&auto=format&fit=crop') center/cover no-repeat;
        display: flex;
        align-items: center;
        padding: 4rem 0;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(27,61,47,0.85) 0%, rgba(27,61,47,0.2) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
    }

    .hero-title {
        color: #ffffff;
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 700;
        line-height: 1.1;
        max-width: 550px;
        margin-bottom: 2rem;
        text-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    /* Search Card */
    .search-card {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        overflow: hidden;
    }

    .search-promo {
        background: linear-gradient(135deg, var(--accent), #b49137);
        color: var(--primary);
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .search-promo-icon {
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .search-body {
        padding: 1.75rem;
    }

    .search-input-group {
        background: #f4f5f7;
        border-radius: 12px;
        display: flex;
        align-items: center;
        padding: 0.85rem 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s;
        border: 1px solid transparent;
    }

    .search-input-group:focus-within {
        border-color: var(--accent);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(201,168,76,0.1);
    }

    .search-input-group i {
        color: var(--text-muted);
        font-size: 1.2rem;
        margin-right: 0.85rem;
    }

    .search-input-group input {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        font-size: 1rem;
        color: var(--text-dark);
        font-weight: 500;
    }

    .btn-search {
        background: var(--primary);
        color: #fff;
        border: none;
        width: 100%;
        padding: 1rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.05rem;
        margin-top: 0.5rem;
        transition: background 0.3s;
    }
    .btn-search:hover {
        background: var(--accent);
        color: var(--primary);
    }

    /* Recent Searches */
    .recent-section {
        padding: 4rem 0;
        background: var(--bg-body);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .clear-link {
        font-size: 0.9rem;
        color: var(--text-muted);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    .clear-link:hover {
        color: var(--accent);
    }

    .recent-scroll {
        display: flex;
        gap: 1.25rem;
        overflow-x: auto;
        padding-bottom: 1rem;
        scrollbar-width: none;
    }
    .recent-scroll::-webkit-scrollbar { display: none; }

    .recent-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 280px;
        cursor: pointer;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    .recent-card:hover {
        border-color: var(--accent);
        box-shadow: 0 4px 15px rgba(201,168,76,0.1);
    }

    .recent-img {
        width: 56px;
        height: 56px;
        border-radius: 8px;
        object-fit: cover;
    }

    .recent-info h4 {
        font-size: 0.95rem;
        font-weight: 600;
        margin: 0 0 0.2rem;
        color: var(--text-dark);
    }

    .recent-info p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* Mobile adjustments */
    @media (max-width: 991px) {
        .hero-section {
            background-position: center right;
        }
        .hero-content {
            flex-direction: column;
            justify-content: center;
        }
        .hero-title {
            text-align: center;
            font-size: 2.5rem;
        }
        .search-card {
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')

    <div class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">

                <h1 class="hero-title">Booking villa mewah online dengan harga promo</h1>

                <div class="search-card">
                    <div class="search-promo">
                        <div class="search-promo-icon">
                            <i class="bi bi-tag-fill"></i>
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:1rem;">Promo Spesial Member</div>
                            <div style="font-size:0.85rem;opacity:0.9;">Diskon hingga 20% untuk pemesanan hari ini!</div>
                        </div>
                    </div>

                    <div class="search-body">
                        <form action="{{ route('villa.search') }}" method="GET" id="searchForm">
                            <div class="search-input-group">
                                <i class="bi bi-search"></i>
                                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari nama villa atau lokasi...">
                            </div>

                            <div class="search-input-group">
                                <i class="bi bi-calendar-event"></i>
                                <input type="text" id="dateRange" placeholder="Check-in - Check-out" readonly style="cursor:pointer; background: transparent;">
                                <input type="hidden" name="checkin" id="checkin_input" value="{{ request('checkin') }}">
                                <input type="hidden" name="checkout" id="checkout_input" value="{{ request('checkout') }}">
                            </div>

                            <!-- Input Tamu & Kamar disembunyikan sesuai permintaan -->
                            <div class="search-input-group" style="display: none;">
                                <i class="bi bi-people"></i>
                                <input type="text" placeholder="Tamu & Kamar" value="2 Dewasa, 1 Kamar" readonly>
                            </div>

                            <button type="submit" class="btn-search">Ayo Cari</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="recent-section">
        <div class="container">
            <div class="section-header">
                <h3 class="section-title">Riwayat Pencarianmu</h3>
                @if($recentVillas->isNotEmpty())
                    <a href="{{ route('villa.clear_history') }}" class="clear-link">Hapus semua</a>
                @endif
            </div>

            <div class="recent-scroll">
                @foreach($recentVillas as $villa)
                <a href="{{ route('villa.show', $villa->id) }}" style="text-decoration: none;">
                    <div class="recent-card">
                        <img src="{{ filter_var($villa->image, FILTER_VALIDATE_URL) ? $villa->image : asset('storage/' . $villa->image) }}" class="recent-img" alt="{{ $villa->name }}">
                        <div class="recent-info">
                            <h4>{{ Str::limit($villa->name, 22) }}</h4>
                            <p>{{ Str::limit($villa->address, 25) }}</p>
                        </div>
                    </div>
                </a>
                @endforeach

                @if($recentVillas->isEmpty())
                <div class="recent-card" style="opacity: 0.7;">
                    <div class="recent-img" style="background:#e5e7eb;display:flex;align-items:center;justify-content:center;color:var(--text-muted);"><i class="bi bi-clock-history"></i></div>
                    <div class="recent-info">
                        <h4>Belum ada riwayat</h4>
                        <p>Mulai cari villa impianmu</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="recent-section" style="padding-top: 0;">
        <div class="container">
            <div class="section-header">
                <h3 class="section-title">Rekomendasi Untukmu</h3>
            </div>

            <div class="row g-4">
                @php
                    $villas = \App\Models\Villa::skip(3)->take(4)->get();
                    if($villas->isEmpty()) $villas = \App\Models\Villa::take(4)->get();
                @endphp
                @foreach($villas as $villa)
                <div class="col-md-6 col-lg-3">
                    <div class="search-card" style="max-width:100%;box-shadow:0 4px 15px rgba(0,0,0,0.05);transition:transform 0.3s; height:100%;">
                        <img src="{{ filter_var($villa->image, FILTER_VALIDATE_URL) ? $villa->image : asset('storage/' . $villa->image) }}" style="width:100%;height:180px;object-fit:cover;" alt="{{ $villa->name }}">
                        <div style="padding:1.25rem;">
                            <h4 style="font-weight:700;font-size:1.1rem;margin:0 0 0.4rem;">{{ $villa->name }}</h4>
                            <div style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1rem;"><i class="bi bi-geo-alt-fill text-warning"></i> {{ Str::limit($villa->address, 25) }}</div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span style="font-weight:700;color:var(--accent);font-size:1.05rem;">Rp {{ number_format($villa->price,0,',','.') }}<small style="font-size:0.75rem;color:var(--text-muted);font-weight:400;">/mlm</small></span>
                                <a href="{{ route('villa.show', $villa->id) }}" class="btn btn-sm" style="background:var(--primary);color:#fff;border-radius:8px;font-size:0.85rem;padding:0.4rem 1rem;">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkinInput = document.getElementById('checkin_input');
        const checkoutInput = document.getElementById('checkout_input');
        
        let defaultDates = [];
        if (checkinInput.value) defaultDates.push(checkinInput.value);
        if (checkoutInput.value) defaultDates.push(checkoutInput.value);

        flatpickr("#dateRange", {
            mode: "range",
            minDate: "today",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d M Y",
            locale: "id",
            defaultDate: defaultDates.length > 0 ? defaultDates : null,
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 1) {
                    checkinInput.value = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                    checkoutInput.value = "";
                } else if (selectedDates.length === 2) {
                    checkinInput.value = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                    checkoutInput.value = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                } else {
                    checkinInput.value = "";
                    checkoutInput.value = "";
                }
            }
        });
    });
</script>
@endsection
