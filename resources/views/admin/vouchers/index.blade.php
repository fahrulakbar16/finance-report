@extends('layouts.admin')

@section('page_title', 'Manajemen Voucher')

@section('content')
<style>
    /* ============================================
       VOUCHER INDEX PAGE — PREMIUM DESIGN
    ============================================ */

    /* --- Page Hero --- */
    .page-hero {
        position: relative;
        background: var(--gradient-primary);
        border-radius: var(--radius-lg);
        padding: 1.75rem 2rem;
        margin-bottom: 1.75rem;
        overflow: hidden;
        box-shadow: var(--shadow-glow-primary);
    }
    .page-hero::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(201, 168, 76, 0.1);
        pointer-events: none;
    }
    .page-hero::after {
        content: '';
        position: absolute;
        bottom: -35px; left: 45%;
        width: 140px; height: 140px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }
    .page-hero-content { position: relative; z-index: 1; }
    .page-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(201, 168, 76, 0.2);
        border: 1px solid rgba(201, 168, 76, 0.35);
        color: var(--brand-accent-light);
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 0.25rem 0.7rem;
        border-radius: var(--radius-pill);
        margin-bottom: 0.5rem;
    }
    .page-hero-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.03em;
        margin-bottom: 0.2rem;
    }
    .page-hero-subtitle {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.55);
        font-weight: 500;
        margin: 0;
    }
    .btn-hero-add {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.84rem;
        font-weight: 700;
        border-radius: var(--radius-sm);
        padding: 0.6rem 1.25rem;
        background: var(--gradient-accent);
        color: var(--brand-primary);
        border: none;
        text-decoration: none;
        box-shadow: var(--shadow-glow-accent);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        white-space: nowrap;
        cursor: pointer;
    }
    .btn-hero-add:hover { transform: translateY(-2px); opacity: 0.9; color: var(--brand-primary); }

    /* --- Alerts --- */
    .alert-premium {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-radius: var(--radius-sm);
        padding: 0.85rem 1.1rem;
        font-size: 0.84rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    .alert-premium.success { background: rgba(16,185,129,0.08); color: #065f46; border: 1px solid rgba(16,185,129,0.2); }
    .alert-premium.danger  { background: rgba(239,68,68,0.08);  color: #991b1b; border: 1px solid rgba(239,68,68,0.2); }
    .alert-premium i { font-size: 1rem; flex-shrink: 0; }
    .alert-premium .btn-close { margin-left: auto; }

    /* --- Stat Cards --- */
    .stat-cards-row { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem; }
    .stat-card {
        flex: 1; min-width: 140px;
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-sm);
        padding: 1rem 1.25rem;
        display: flex; align-items: center; gap: 0.9rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .stat-card-icon {
        width: 42px; height: 42px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .stat-card-icon.primary { background: rgba(27,61,47,0.08); color: var(--brand-primary); }
    .stat-card-icon.success { background: rgba(16,185,129,0.1); color: var(--success); }
    .stat-card-icon.warning { background: rgba(249,115,22,0.1); color: var(--warning); }
    .stat-card-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); margin-bottom: 0.1rem; }
    .stat-card-value { font-size: 1.35rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.02em; line-height: 1; }

    /* --- Table Card --- */
    .voucher-table-card {
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .voucher-table-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid var(--border-subtle);
    }
    .voucher-table-title {
        font-size: 0.88rem; font-weight: 700; color: var(--text-primary);
        display: flex; align-items: center; gap: 0.5rem;
    }
    .count-badge {
        background: rgba(27,61,47,0.08); color: var(--brand-primary);
        font-size: 0.68rem; font-weight: 700;
        padding: 0.15rem 0.55rem; border-radius: var(--radius-pill);
    }

    /* --- Table --- */
    .voucher-table { width: 100%; border-collapse: collapse; }
    .voucher-table thead tr { background: var(--bg-app); border-bottom: 1px solid var(--border-subtle); }
    .voucher-table thead th {
        font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.6px; color: var(--text-tertiary);
        padding: 0.7rem 1rem; white-space: nowrap;
    }
    .voucher-table thead th:first-child { padding-left: 1.5rem; }
    .voucher-table thead th:last-child  { padding-right: 1.5rem; text-align: right; }
    .voucher-table tbody tr { border-bottom: 1px solid var(--border-subtle); transition: background 0.15s; }
    .voucher-table tbody tr:last-child { border-bottom: none; }
    .voucher-table tbody tr:hover { background: rgba(27,61,47,0.025); }
    .voucher-table tbody td { padding: 0.85rem 1rem; vertical-align: middle; }
    .voucher-table tbody td:first-child { padding-left: 1.5rem; }
    .voucher-table tbody td:last-child  { padding-right: 1.5rem; }

    /* --- No Column --- */
    .row-no {
        font-size: 0.72rem; font-weight: 700;
        color: var(--text-tertiary);
        background: var(--bg-app);
        border-radius: var(--radius-sm);
        width: 26px; height: 26px;
        display: flex; align-items: center; justify-content: center;
    }

    /* --- Voucher Code --- */
    .voucher-code {
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--brand-primary);
        background: rgba(27,61,47,0.06);
        border: 1px solid rgba(27,61,47,0.12);
        border-radius: var(--radius-sm);
        padding: 0.3rem 0.65rem;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    /* --- Type Badge --- */
    .type-badge {
        display: inline-flex; align-items: center; gap: 0.3rem;
        font-size: 0.72rem; font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: var(--radius-pill);
    }
    .type-badge.percentage { background: rgba(59,130,246,0.08); color: var(--info);    border: 1px solid rgba(59,130,246,0.2); }
    .type-badge.fixed      { background: rgba(201,168,76,0.1);   color: #A37D2A;       border: 1px solid rgba(201,168,76,0.25); }

    /* --- Discount Value --- */
    .discount-value { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); }

    /* --- Usage bar --- */
    .usage-cell { min-width: 110px; }
    .usage-text { font-size: 0.78rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px; }
    .usage-bar-wrap { background: #eef0f4; border-radius: var(--radius-pill); height: 5px; overflow: hidden; }
    .usage-bar-fill { height: 100%; border-radius: var(--radius-pill); background: var(--gradient-primary); }

    /* --- Expiry Date --- */
    .expiry-expired { font-size: 0.78rem; font-weight: 600; color: var(--danger); }
    .expiry-valid   { font-size: 0.78rem; font-weight: 600; color: var(--success); }
    .expiry-none    { font-size: 0.78rem; font-weight: 500; color: var(--text-tertiary); font-style: italic; }

    /* --- Status Badge --- */
    .status-badge {
        display: inline-flex; align-items: center; gap: 0.3rem;
        font-size: 0.72rem; font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: var(--radius-pill);
    }
    .status-badge.active   { background: rgba(16,185,129,0.08); color: #059669; border: 1px solid rgba(16,185,129,0.25); }
    .status-badge.inactive { background: rgba(239,68,68,0.08);  color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }

    /* --- Action Buttons --- */
    .action-btn-group { display: flex; align-items: center; justify-content: flex-end; gap: 0.35rem; }
    .action-btn {
        width: 32px; height: 32px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-subtle);
        background: var(--surface);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.82rem; text-decoration: none;
        transition: all 0.15s; cursor: pointer; color: var(--text-secondary);
    }
    .action-btn:hover { transform: translateY(-1px); box-shadow: var(--shadow-xs); }
    .action-btn.edit:hover   { background: rgba(59,130,246,0.08); color: var(--info);   border-color: rgba(59,130,246,0.2); }
    .action-btn.delete:hover { background: rgba(239,68,68,0.08);  color: var(--danger); border-color: rgba(239,68,68,0.2); }

    /* --- Empty State --- */
    .empty-table-state { text-align: center; padding: 3.5rem 1rem; }
    .empty-table-icon {
        width: 64px; height: 64px; border-radius: var(--radius-md);
        background: rgba(27,61,47,0.06); color: var(--brand-primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; margin: 0 auto 1rem;
    }
    .empty-table-title { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.3rem; }
    .empty-table-subtitle { font-size: 0.8rem; color: var(--text-tertiary); margin-bottom: 1.25rem; }

    /* --- Pagination --- */
    .pagination-wrap {
        padding: 0.85rem 1.5rem;
        border-top: 1px solid var(--border-subtle);
        background: var(--bg-app);
    }

    /* --- Modal Premium --- */
    .modal-premium .modal-content {
        border-radius: var(--radius-md) !important;
        border: none !important;
        box-shadow: var(--shadow-lg) !important;
        overflow: hidden;
    }
    .modal-premium .modal-hero {
        background: var(--gradient-primary);
        padding: 1.35rem 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .modal-premium .modal-hero::before {
        content: '';
        position: absolute; top: -30px; right: -30px;
        width: 100px; height: 100px; border-radius: 50%;
        background: rgba(201,168,76,0.15);
    }
    .modal-premium .modal-hero-title {
        font-size: 0.95rem; font-weight: 800; color: #fff;
        display: flex; align-items: center; gap: 0.5rem;
        position: relative; z-index: 1;
    }
    .modal-premium .modal-hero-icon {
        width: 34px; height: 34px; border-radius: var(--radius-sm);
        background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2);
        display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1rem;
        flex-shrink: 0;
    }
    .modal-premium .btn-close-white { position: relative; z-index: 1; }
    .modal-premium .modal-body-inner { padding: 1.5rem; }
    .modal-premium .modal-footer-inner {
        padding: 0 1.5rem 1.25rem;
        display: flex; justify-content: flex-end; gap: 0.5rem;
    }

    /* --- Form Controls --- */
    .fi-label {
        font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; color: var(--text-secondary); margin-bottom: 0.4rem; display: block;
    }
    .fi-label span { color: var(--danger); }
    .fi-input {
        width: 100%;
        background: var(--bg-app);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-sm);
        padding: 0.55rem 0.85rem;
        font-size: 0.84rem;
        font-weight: 500;
        color: var(--text-primary);
        transition: border-color 0.15s, box-shadow 0.15s;
        outline: none;
        appearance: auto;
    }
    .fi-input:focus {
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 3px rgba(27,61,47,0.08);
        background: var(--surface);
    }
    .fi-hint { font-size: 0.72rem; color: var(--text-tertiary); margin-top: 0.3rem; }

    /* --- Toggle Switch --- */
    .fi-switch-wrap {
        display: flex; align-items: center; gap: 0.75rem;
        background: var(--bg-app); border-radius: var(--radius-sm);
        border: 1px solid var(--border-subtle); padding: 0.65rem 0.9rem;
    }
    .fi-switch-label { font-size: 0.84rem; font-weight: 600; color: var(--text-primary); }

    /* --- Buttons --- */
    .btn-submit {
        display: inline-flex; align-items: center; gap: 0.4rem;
        font-size: 0.84rem; font-weight: 700;
        background: var(--gradient-primary); color: #fff;
        border: none; border-radius: var(--radius-sm);
        padding: 0.6rem 1.4rem; cursor: pointer;
        box-shadow: var(--shadow-glow-primary);
        transition: all 0.15s;
    }
    .btn-submit:hover { opacity: 0.88; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 0.4rem;
        font-size: 0.84rem; font-weight: 600;
        background: var(--bg-app); color: var(--text-secondary);
        border: 1px solid var(--border-subtle); border-radius: var(--radius-sm);
        padding: 0.6rem 1.2rem; cursor: pointer;
        transition: all 0.15s;
    }
    .btn-cancel:hover { background: #e2e5ea; color: var(--text-primary); }
</style>

<div class="container-fluid px-0 animate-in">

    <!-- ============ PAGE HERO ============ -->
    <div class="page-hero mb-4">
        <div class="page-hero-content d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="page-hero-badge">
                    <i class="bi bi-ticket-perforated-fill"></i> Diskon & Promo
                </div>
                <h1 class="page-hero-title">Manajemen Voucher</h1>
                <p class="page-hero-subtitle">Kelola daftar voucher diskon untuk pengguna villa</p>
            </div>
            <button type="button" class="btn-hero-add" data-bs-toggle="modal" data-bs-target="#createVoucherModal">
                <i class="bi bi-plus-lg"></i> Tambah Voucher Baru
            </button>
        </div>
    </div>

    <!-- ============ ALERTS ============ -->
    @if(session('success'))
        <div class="alert-premium success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert-premium danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>Terdapat kesalahan input. Silakan periksa kembali isian Anda.</span>
            <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ============ STAT CARDS ============ -->
    <div class="stat-cards-row">
        <div class="stat-card">
            <div class="stat-card-icon primary"><i class="bi bi-ticket-perforated-fill"></i></div>
            <div>
                <div class="stat-card-label">Total Voucher</div>
                <div class="stat-card-value">{{ $vouchers->total() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon success"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="stat-card-label">Aktif</div>
                <div class="stat-card-value">{{ $vouchers->where('is_active', true)->count() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon warning"><i class="bi bi-x-circle-fill"></i></div>
            <div>
                <div class="stat-card-label">Nonaktif</div>
                <div class="stat-card-value">{{ $vouchers->where('is_active', false)->count() }}</div>
            </div>
        </div>
    </div>

    <!-- ============ TABLE CARD ============ -->
    <div class="voucher-table-card">
        <div class="voucher-table-header">
            <div class="voucher-table-title">
                <i class="bi bi-list-ul" style="color: var(--brand-primary);"></i>
                Daftar Voucher
                <span class="count-badge">{{ $vouchers->total() }} total</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="voucher-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Voucher</th>
                        <th>Tipe Diskon</th>
                        <th>Jumlah Diskon</th>
                        <th>Penggunaan</th>
                        <th>Batas Waktu</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vouchers as $index => $voucher)
                        @php
                            $usageLimit = $voucher->usage_limit ?: 0;
                            $usagePct   = $usageLimit > 0 ? min(100, ($voucher->used_count / $usageLimit) * 100) : 0;
                        @endphp
                        <tr>
                            {{-- No --}}
                            <td><div class="row-no">{{ $vouchers->firstItem() + $index }}</div></td>

                            {{-- Code --}}
                            <td><span class="voucher-code">{{ $voucher->code }}</span></td>

                            {{-- Type --}}
                            <td>
                                @if($voucher->discount_type === 'percentage')
                                    <span class="type-badge percentage"><i class="bi bi-percent"></i> Persentase</span>
                                @else
                                    <span class="type-badge fixed"><i class="bi bi-cash-coin"></i> Nominal</span>
                                @endif
                            </td>

                            {{-- Discount Amount --}}
                            <td>
                                <span class="discount-value">
                                    @if($voucher->discount_type === 'percentage')
                                        {{ $voucher->discount_amount }}%
                                    @else
                                        Rp {{ number_format($voucher->discount_amount, 0, ',', '.') }}
                                    @endif
                                </span>
                            </td>

                            {{-- Usage --}}
                            <td class="usage-cell">
                                <div class="usage-text">
                                    {{ $voucher->used_count }} / {{ $voucher->usage_limit ?: '∞' }}
                                </div>
                                @if($usageLimit > 0)
                                    <div class="usage-bar-wrap">
                                        <div class="usage-bar-fill" style="width: {{ $usagePct }}%;"></div>
                                    </div>
                                @endif
                            </td>

                            {{-- Expiry --}}
                            <td>
                                @if($voucher->valid_until)
                                    @if($voucher->valid_until->isPast())
                                        <span class="expiry-expired">
                                            <i class="bi bi-clock-history me-1"></i>
                                            {{ $voucher->valid_until->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="expiry-valid">
                                            <i class="bi bi-calendar-check me-1"></i>
                                            {{ $voucher->valid_until->format('d M Y') }}
                                        </span>
                                    @endif
                                @else
                                    <span class="expiry-none">Tanpa Batas</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($voucher->is_active)
                                    <span class="status-badge active"><i class="bi bi-check-circle-fill"></i> Aktif</span>
                                @else
                                    <span class="status-badge inactive"><i class="bi bi-x-circle-fill"></i> Nonaktif</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="action-btn edit"
                                            data-bs-toggle="modal" data-bs-target="#editVoucherModal{{ $voucher->id }}"
                                            title="Edit Voucher">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus voucher ini?');"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Hapus Voucher">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-table-state">
                                    <div class="empty-table-icon"><i class="bi bi-ticket-perforated"></i></div>
                                    <div class="empty-table-title">Belum Ada Data Voucher</div>
                                    <div class="empty-table-subtitle">Tambahkan voucher diskon pertama untuk pelanggan Anda.</div>
                                    <button type="button" class="btn-hero-add" style="display:inline-flex;"
                                            data-bs-toggle="modal" data-bs-target="#createVoucherModal">
                                        <i class="bi bi-plus-lg"></i> Tambah Voucher Sekarang
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($vouchers->hasPages())
            <div class="pagination-wrap">{{ $vouchers->links() }}</div>
        @endif
    </div>

</div>

<!-- ============ Create Modal ============ -->
<div class="modal fade modal-premium" id="createVoucherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-hero d-flex align-items-center justify-content-between">
                <div class="modal-hero-title">
                    <div class="modal-hero-icon"><i class="bi bi-plus-lg"></i></div>
                    Tambah Voucher Baru
                </div>
                <button type="button" class="btn-close btn-close-white btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-inner">
                <form action="{{ route('vouchers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="fi-label">Kode Voucher <span>*</span></label>
                        <input type="text" class="fi-input" name="code" required placeholder="Contoh: PROMO2024" style="text-transform: uppercase;">
                        <div class="fi-hint">Gunakan huruf kapital dan angka tanpa spasi.</div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="fi-label">Tipe Diskon <span>*</span></label>
                            <select class="fi-input" name="discount_type" required>
                                <option value="" disabled selected>Pilih Tipe</option>
                                <option value="percentage">Persentase (%)</option>
                                <option value="fixed">Nominal (Rp)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fi-label">Jumlah Diskon <span>*</span></label>
                            <input type="number" step="0.01" class="fi-input" name="discount_amount" required min="0" placeholder="Contoh: 10">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="fi-label">Batas Penggunaan</label>
                            <input type="number" class="fi-input" name="usage_limit" min="1" placeholder="Kosong = tak terbatas">
                        </div>
                        <div class="col-md-6">
                            <label class="fi-label">Berlaku Hingga</label>
                            <input type="datetime-local" class="fi-input" name="valid_until">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="fi-switch-wrap">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked style="cursor:pointer; width:38px; height:20px;">
                            <span class="fi-switch-label">Status Aktif</span>
                        </div>
                    </div>
                    <div class="modal-footer-inner">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-submit"><i class="bi bi-check-lg"></i> Simpan Voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============ Edit Modals ============ -->
@foreach($vouchers as $voucher)
<div class="modal fade modal-premium" id="editVoucherModal{{ $voucher->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-hero d-flex align-items-center justify-content-between">
                <div class="modal-hero-title">
                    <div class="modal-hero-icon"><i class="bi bi-pencil-fill"></i></div>
                    Edit: <span style="color: var(--brand-accent-light);">{{ $voucher->code }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-inner">
                <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="fi-label">Kode Voucher <span>*</span></label>
                        <input type="text" class="fi-input" name="code" value="{{ $voucher->code }}" required style="text-transform: uppercase;">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="fi-label">Tipe Diskon <span>*</span></label>
                            <select class="fi-input" name="discount_type" required>
                                <option value="percentage" {{ $voucher->discount_type == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                <option value="fixed"      {{ $voucher->discount_type == 'fixed'       ? 'selected' : '' }}>Nominal (Rp)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fi-label">Jumlah Diskon <span>*</span></label>
                            <input type="number" step="0.01" class="fi-input" name="discount_amount" value="{{ $voucher->discount_amount }}" required min="0">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="fi-label">Batas Penggunaan</label>
                            <input type="number" class="fi-input" name="usage_limit" value="{{ $voucher->usage_limit }}" min="0" placeholder="Kosong = tak terbatas">
                        </div>
                        <div class="col-md-6">
                            <label class="fi-label">Berlaku Hingga</label>
                            <input type="datetime-local" class="fi-input" name="valid_until" value="{{ $voucher->valid_until ? $voucher->valid_until->format('Y-m-d\TH:i') : '' }}">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="fi-switch-wrap">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $voucher->is_active ? 'checked' : '' }} style="cursor:pointer; width:38px; height:20px;">
                            <span class="fi-switch-label">Status Aktif</span>
                        </div>
                    </div>
                    <div class="modal-footer-inner">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-submit"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
