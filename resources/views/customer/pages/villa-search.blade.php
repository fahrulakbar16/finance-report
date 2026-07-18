@extends('layouts.search')

@section('title', 'Hasil Pencarian - Athara Villas')

@section('styles')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .search-header-section {
        background: #ffffff;
        padding: 1.5rem 0 1rem 0;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
        /* Pull it up a bit if needed, but layouts.search has padding-top:70px on body */
    }

    .search-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary);
    }

    .search-form-horizontal {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        background: #f4f5f7;
        padding: 0.5rem;
        border-radius: 16px;
    }

    .search-input-group {
        background: #ffffff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        flex: 1;
        transition: all 0.3s;
        border: 1px solid transparent;
    }

    .search-input-group:focus-within {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(201,168,76,0.1);
    }

    .search-input-group i {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin-right: 0.75rem;
    }

    .search-input-group input {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        font-size: 0.95rem;
        color: var(--text-dark);
        font-weight: 500;
    }

    .btn-search {
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: background 0.3s;
        white-space: nowrap;
    }

    .btn-search:hover {
        background: var(--accent);
        color: var(--primary);
    }

    .filter-pills-scroll {
        display: flex;
        gap: 0.75rem;
        overflow-x: auto;
        padding-top: 1rem;
        padding-bottom: 0.5rem;
        scrollbar-width: none; /* Firefox */
    }
    .filter-pills-scroll::-webkit-scrollbar { display: none; /* Chrome/Safari */ }

    .filter-pill {
        background: #fff;
        border: 1px solid #d1d5db;
        border-radius: 20px;
        padding: 0.45rem 1rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-dark);
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s;
        cursor: pointer;
    }
    .filter-pill:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }

    .search-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .search-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .card-img-top {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .card-body-custom {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .villa-name {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .villa-address {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .price-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .villa-price {
        font-weight: 700;
        color: var(--accent);
        font-size: 1.15rem;
    }

    .btn-detail {
        background: var(--primary);
        color: #fff;
        border-radius: 8px;
        font-size: 0.9rem;
        padding: 0.5rem 1.25rem;
        text-decoration: none;
        transition: background 0.3s;
    }

    .btn-detail:hover {
        background: var(--accent);
        color: var(--primary);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        background: #fff;
        border-radius: 16px;
        border: 1px dashed #e5e7eb;
    }

    @media (max-width: 768px) {
        .search-form-horizontal {
            flex-direction: column;
            background: transparent;
            padding: 0;
            gap: 0.75rem;
        }
        .search-input-group {
            background: #f4f5f7;
            width: 100%;
        }
        .btn-search {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .search-header-section {
            padding: 1rem 0;
            margin-bottom: 1rem;
        }
        .search-title {
            display: none; /* Hide big title on mobile to match compact app style */
        }
        .card-img-top {
            height: 180px;
        }
        .card-body-custom {
            padding: 1.2rem;
        }
        .villa-name {
            font-size: 1.15rem;
            margin-bottom: 0.3rem;
        }
        .villa-address {
            margin-bottom: 1rem;
        }
        .price-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .villa-price {
            font-size: 1.1rem;
        }
        .btn-detail {
            width: 100%;
            text-align: center;
            padding: 0.65rem;
        }
    }
</style>
@endsection

@section('content')

<div class="search-header-section">
    <div class="container">
        <!-- Desktop Title -->
        <h1 class="search-title d-none d-sm-block">Hasil Pencarian</h1>

        <!-- Search Form -->
        <form action="{{ route('villa.search') }}" method="GET" id="searchForm" class="search-form-horizontal">
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

            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <button type="submit" class="btn-search">Ayo Cari</button>
        </form>

        <!-- Filter Dropdown -->
        <div class="mt-3 mb-1">
            <div class="dropdown">
                <button class="filter-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @php
                        $sortLabel = 'Urutkan';
                        if(request('sort') == 'newest') $sortLabel = 'Baru ditambahkan';
                        elseif(request('sort') == 'price_asc') $sortLabel = 'Harga termurah';
                        elseif(request('sort') == 'price_desc') $sortLabel = 'Harga tertinggi';
                    @endphp
                    <i class="bi bi-sort-down"></i> {{ $sortLabel }}
                </button>
                <ul class="dropdown-menu border-0 shadow-sm" style="border-radius: 12px; font-size: 0.9rem;">
                    <li><a class="dropdown-item py-2 {{ request('sort') == 'newest' ? 'active bg-light text-primary fw-bold' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Baru ditambahkan</a></li>
                    <li><a class="dropdown-item py-2 {{ request('sort') == 'price_asc' ? 'active bg-light text-primary fw-bold' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Harga termurah ke tinggi</a></li>
                    <li><a class="dropdown-item py-2 {{ request('sort') == 'price_desc' ? 'active bg-light text-primary fw-bold' : '' }}" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Harga tinggi ke murah</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-bottom: 4rem;">
    @if($villas->isEmpty())
        <div class="empty-state">
            <i class="bi bi-search text-muted" style="font-size: 4rem; margin-bottom: 1rem; display: inline-block;"></i>
            <h3 style="font-weight: 700; color: var(--text-dark);">Villa Tidak Ditemukan</h3>
            <p class="text-muted">Maaf, kami tidak dapat menemukan villa yang cocok dengan kata kunci tersebut. Silakan coba kata kunci lain.</p>
            <a href="{{ route('villa.index') }}" class="btn btn-primary mt-3" style="border-radius: 8px;">
                Coba Pencarian Lain
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($villas as $villa)
                <div class="col-md-6 col-lg-4">
                    <div class="search-card">
                        <img src="{{ filter_var($villa->image, FILTER_VALIDATE_URL) ? $villa->image : asset('storage/' . $villa->image) }}" class="card-img-top" alt="{{ $villa->name }}">
                        <div class="card-body-custom">
                            <h3 class="villa-name">{{ $villa->name }}</h3>
                            <div class="villa-address"><i class="bi bi-geo-alt-fill text-warning"></i> {{ Str::limit($villa->address, 40) }}</div>
                            <div class="price-section mt-auto">
                                <span class="villa-price">Rp {{ number_format($villa->price, 0, ',', '.') }}<small style="font-size:0.75rem;color:var(--text-muted);font-weight:400;"> / malam</small></span>
                                <a href="{{ request('checkin') && request('checkout') ? route('villa.show', ['villa' => $villa->id, 'checkin' => request('checkin'), 'checkout' => request('checkout')]) : route('villa.show', $villa->id) }}" class="btn-detail">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
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
