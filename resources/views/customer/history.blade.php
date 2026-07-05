@extends('layouts.search')

@section('title', 'History - Athara Villas')

@section('styles')
<style>
    .history-card {
        background: var(--surface);
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35rem 0.75rem;
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
        font-size: 1rem;
        margin: 0.5rem 0 0.25rem;
    }
    .history-date {
        color: var(--text-muted);
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
    }
</style>
@endsection

@section('content')
<div class="container py-4" style="max-width: 600px; margin: 0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4 d-md-none">
        <h1 class="header-title" style="font-size:1.5rem;font-weight:700;margin:0;color:var(--primary);">Riwayat Pemesanan</h1>
    </div>

    <!-- Placeholder data -->
    <div class="history-card fade-in">
        <div class="d-flex justify-content-between align-items-center">
            <span class="status-badge status-success">Selesai</span>
            <span style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">#TRX-001</span>
        </div>
        <h3 class="history-title">Villa Sunset Paradise</h3>
        <div class="history-date">12 - 14 Agustus 2026 (2 Malam)</div>
        <div class="d-flex justify-content-between align-items-end mt-3">
            <div>
                <div style="font-size:0.75rem;color:var(--text-muted);">Total Bayar</div>
                <div style="font-weight:700;color:var(--primary);">Rp 2.500.000</div>
            </div>
            <button class="btn btn-sm btn-outline-dark" style="border-radius:8px;font-size:0.8rem;">Pesan Lagi</button>
        </div>
    </div>

    <div class="history-card fade-in" style="animation-delay: 0.1s;">
        <div class="d-flex justify-content-between align-items-center">
            <span class="status-badge status-pending">Menunggu Pembayaran</span>
            <span style="font-size:0.85rem;color:var(--text-muted);font-weight:600;">#TRX-002</span>
        </div>
        <h3 class="history-title">Villa Arjuna</h3>
        <div class="history-date">20 - 21 Agustus 2026 (1 Malam)</div>
        <div class="d-flex justify-content-between align-items-end mt-3">
            <div>
                <div style="font-size:0.75rem;color:var(--text-muted);">Total Bayar</div>
                <div style="font-weight:700;color:var(--primary);">Rp 1.500.000</div>
            </div>
            <button class="btn btn-sm btn-dark" style="background:var(--accent);border:none;border-radius:8px;font-size:0.8rem;color:var(--primary);font-weight:600;">Bayar Sekarang</button>
        </div>
    </div>
</div>
@endsection
