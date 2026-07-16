@extends('layouts.search')

@section('title', 'History - Athara Villas')

@section('styles')
<style>
    .history-card {
        background: var(--surface);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.04);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .history-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    }
    .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.4rem 0.85rem;
        border-radius: 2rem;
    }
    .status-success {
        background: rgba(34,197,94,0.1);
        color: #16a34a;
    }
    .status-pending {
        background: rgba(234,179,8,0.1);
        color: #ca8a04;
    }
    .history-title {
        font-weight: 700;
        font-size: 1.15rem;
        margin: 0.5rem 0 0.25rem;
        line-height: 1.3;
    }
    .history-date {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
    }
</style>
@endsection

@section('content')
<div class="container py-4 py-md-5" style="max-width: 1000px; margin: 0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="header-title" style="font-size:1.75rem;font-weight:700;margin:0;color:var(--primary);">Pemesanan Saya</h1>
    </div>

    @if($bookings->isEmpty())
        <div class="text-center py-5" style="background: var(--surface); border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <i class="bi bi-journal-x" style="font-size: 3rem; color: var(--border-color);"></i>
            <h4 class="mt-3" style="color: var(--text-muted); font-size: 1.1rem;">Belum ada pemesanan aktif</h4>
            <a href="{{ route('villa.index') }}" class="btn mt-3" style="background:var(--accent); color:var(--primary); font-weight:600; border-radius:12px; padding: 0.6rem 1.5rem;">Cari Villa</a>
        </div>
    @else
        <div class="row g-4">
        @foreach($bookings as $index => $booking)
            @php
                $isPending = $booking->payment_status === 'pending';
                $statusClass = $isPending ? 'status-pending' : 'status-success';
                $statusText = $isPending ? 'Menunggu Pembayaran' : 'Telah Dibayar';
                $nights = \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out));
            @endphp
            <div class="col-12 col-md-6">
                <div class="history-card fade-in h-100 d-flex flex-column" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        <span style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">{{ $booking->invoice_number }}</span>
                    </div>
                    <h3 class="history-title mt-3">{{ $booking->villa_snapshot['name'] ?? 'Villa' }}</h3>
                    <div class="history-date mb-4">
                        {{ \Carbon\Carbon::parse($booking->check_in)->isoFormat('D MMM YYYY') }} - {{ \Carbon\Carbon::parse($booking->check_out)->isoFormat('D MMM YYYY') }} ({{ $nights }} Malam)
                    </div>
                    <div class="d-flex justify-content-between align-items-end mt-auto pt-3" style="border-top: 1px solid rgba(0,0,0,0.05);">
                        <div>
                            <div style="font-size:0.75rem;color:var(--text-muted);">Total Bayar</div>
                            <div style="font-weight:700;color:var(--primary);font-size:1.1rem;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        </div>
                        @if($isPending && $booking->payment_url)
                            <a href="{{ $booking->payment_url }}" class="btn btn-sm btn-dark px-3" style="background:var(--accent);border:none;border-radius:8px;font-size:0.85rem;color:var(--primary);font-weight:600;">Bayar</a>
                        @else
                            <a href="{{ route('villa.show', $booking->villa_id) }}" class="btn btn-sm btn-outline-dark px-3" style="border-radius:8px;font-size:0.85rem;font-weight:500;">Detail</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    @endif
</div>
@endsection
