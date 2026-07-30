@extends('layouts.admin')

@section('page_title', 'Manajemen Villa')

@section('content')
<style>
    /* ============================================
       VILLA INDEX PAGE — PREMIUM DESIGN
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
        bottom: -35px; left: 40%;
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
    }
    .btn-hero-add:hover {
        transform: translateY(-2px);
        opacity: 0.9;
        color: var(--brand-primary);
    }

    /* --- Stat Cards --- */
    .stat-cards-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        flex: 1;
        min-width: 140px;
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-sm);
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.9rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .stat-card-icon {
        width: 42px; height: 42px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .stat-card-icon.primary { background: rgba(27,61,47,0.08); color: var(--brand-primary); }
    .stat-card-icon.accent  { background: rgba(201,168,76,0.1);  color: #A37D2A; }
    .stat-card-icon.success { background: rgba(16,185,129,0.1);  color: var(--success); }
    .stat-card-label {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-tertiary);
        margin-bottom: 0.1rem;
    }
    .stat-card-value {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -0.02em;
        line-height: 1;
    }

    /* --- Table Card --- */
    .villa-table-card {
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .villa-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid var(--border-subtle);
        background: var(--surface);
    }
    .villa-table-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .villa-count-badge {
        background: rgba(27,61,47,0.08);
        color: var(--brand-primary);
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.15rem 0.55rem;
        border-radius: var(--radius-pill);
    }

    /* --- Table Styles --- */
    .villa-table { width: 100%; border-collapse: collapse; }
    .villa-table thead tr {
        background: var(--bg-app);
        border-bottom: 1px solid var(--border-subtle);
    }
    .villa-table thead th {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-tertiary);
        padding: 0.7rem 1rem;
        white-space: nowrap;
    }
    .villa-table thead th:first-child { padding-left: 1.5rem; }
    .villa-table thead th:last-child  { padding-right: 1.5rem; text-align: right; }
    .villa-table tbody tr {
        border-bottom: 1px solid var(--border-subtle);
        transition: background 0.15s;
    }
    .villa-table tbody tr:last-child { border-bottom: none; }
    .villa-table tbody tr:hover { background: rgba(27,61,47,0.025); }
    .villa-table tbody td { padding: 0.85rem 1rem; vertical-align: middle; }
    .villa-table tbody td:first-child { padding-left: 1.5rem; }
    .villa-table tbody td:last-child  { padding-right: 1.5rem; }

    /* --- Villa Name Cell --- */
    .villa-icon-wrap {
        width: 38px; height: 38px;
        border-radius: var(--radius-sm);
        background: rgba(27,61,47,0.08);
        color: var(--brand-primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .villa-name-text {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    .villa-address-text {
        font-size: 0.72rem;
        color: var(--text-tertiary);
        font-weight: 500;
        margin-top: 1px;
    }

    /* --- Email Cell --- */
    .villa-email-link {
        font-size: 0.82rem;
        color: var(--text-secondary);
        font-weight: 500;
        text-decoration: none;
    }
    .villa-email-link:hover { color: var(--info); text-decoration: underline; }

    /* --- Owner Badge --- */
    .owner-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: var(--bg-app);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-pill);
        padding: 0.25rem 0.65rem 0.25rem 0.4rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
    }
    .owner-badge-avatar {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: var(--gradient-primary);
        color: #fff;
        font-size: 0.6rem;
        font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* --- Action Buttons --- */
    .action-btn-group {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.35rem;
    }
    .action-btn {
        width: 32px; height: 32px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-subtle);
        background: var(--surface);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.82rem;
        text-decoration: none;
        transition: all 0.15s;
        cursor: pointer;
        color: var(--text-secondary);
    }
    .action-btn:hover { transform: translateY(-1px); box-shadow: var(--shadow-xs); }
    .action-btn.view:hover  { background: rgba(27,61,47,0.08);  color: var(--brand-primary); border-color: rgba(27,61,47,0.2); }
    .action-btn.edit:hover  { background: rgba(59,130,246,0.08); color: var(--info); border-color: rgba(59,130,246,0.2); }
    .action-btn.delete:hover { background: rgba(239,68,68,0.08); color: var(--danger); border-color: rgba(239,68,68,0.2); }

    /* --- Alerts --- */
    .alert-premium {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-radius: var(--radius-sm);
        padding: 0.85rem 1.1rem;
        font-size: 0.84rem;
        font-weight: 500;
        border: none;
        margin-bottom: 1rem;
    }
    .alert-premium.success {
        background: rgba(16,185,129,0.08);
        color: #065f46;
        border: 1px solid rgba(16,185,129,0.2);
    }
    .alert-premium.danger {
        background: rgba(239,68,68,0.08);
        color: #991b1b;
        border: 1px solid rgba(239,68,68,0.2);
    }
    .alert-premium i { font-size: 1rem; flex-shrink: 0; }
    .alert-premium .btn-close { margin-left: auto; }

    /* --- Empty State --- */
    .empty-table-state {
        text-align: center;
        padding: 3.5rem 1rem;
    }
    .empty-table-icon {
        width: 64px; height: 64px;
        border-radius: var(--radius-md);
        background: rgba(27,61,47,0.06);
        color: var(--brand-primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem;
        margin: 0 auto 1rem;
    }
    .empty-table-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.3rem;
    }
    .empty-table-subtitle {
        font-size: 0.8rem;
        color: var(--text-tertiary);
        margin-bottom: 1.25rem;
    }

    /* --- Pagination wrapper --- */
    .pagination-wrap {
        padding: 0.85rem 1.5rem;
        border-top: 1px solid var(--border-subtle);
        background: var(--bg-app);
    }
</style>

<div class="container-fluid px-0 animate-in">

    <!-- ============ PAGE HERO ============ -->
    <div class="page-hero mb-4">
        <div class="page-hero-content d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="page-hero-badge">
                    <i class="bi bi-building"></i> Manajemen Properti
                </div>
                <h1 class="page-hero-title">Manajemen Villa</h1>
                <p class="page-hero-subtitle">Kelola data villa beserta persentase bagi hasil pemilik</p>
            </div>
            <a href="{{ route('villas.create') }}" class="btn-hero-add">
                <i class="bi bi-plus-lg"></i> Tambah Villa
            </a>
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
            <span>Terdapat kesalahan input form. Silakan periksa kembali isian Anda.</span>
            <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ============ STAT CARDS ============ -->
    <div class="stat-cards-row">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="bi bi-building-fill"></i>
            </div>
            <div>
                <div class="stat-card-label">Total Villa</div>
                <div class="stat-card-value">{{ $villas->total() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon accent">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <div class="stat-card-label">Pemilik Terdaftar</div>
                <div class="stat-card-value">{{ $villas->pluck('pemilik_id')->unique()->count() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </div>
            <div>
                <div class="stat-card-label">Halaman Ini</div>
                <div class="stat-card-value">{{ $villas->count() }}</div>
            </div>
        </div>
    </div>

    <!-- ============ TABLE CARD ============ -->
    <div class="villa-table-card">
        <div class="villa-table-header">
            <div class="villa-table-title">
                <i class="bi bi-list-ul" style="color: var(--brand-primary);"></i>
                Daftar Villa
                <span class="villa-count-badge">{{ $villas->total() }} total</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="villa-table">
                <thead>
                    <tr>
                        <th>Nama Villa</th>
                        <th>Email Kontak</th>
                        <th>Pemilik</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($villas as $villa)
                        <tr>
                            {{-- Villa Name --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="villa-icon-wrap">
                                        <i class="bi bi-house-door-fill"></i>
                                    </div>
                                    <div>
                                        <div class="villa-name-text">{{ $villa->name }}</div>
                                        @if($villa->address)
                                            <div class="villa-address-text">
                                                <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($villa->address, 40) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td>
                                <a href="mailto:{{ $villa->email }}" class="villa-email-link">
                                    <i class="bi bi-envelope me-1" style="font-size:0.7rem;"></i>
                                    {{ $villa->email }}
                                </a>
                            </td>

                            {{-- Owner --}}
                            <td>
                                <div class="owner-badge">
                                    <div class="owner-badge-avatar">
                                        {{ strtoupper(substr($villa->pemilik->name ?? 'P', 0, 1)) }}
                                    </div>
                                    {{ $villa->pemilik->name ?? '-' }}
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="action-btn-group">
                                    <a href="{{ route('villas.show', $villa) }}" class="action-btn view" title="Lihat Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('villas.edit', $villa) }}" class="action-btn edit" title="Edit Villa">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('villas.destroy', $villa) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus villa ini? Seluruh data transaksi juga akan terhapus.')"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Hapus Villa">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-table-state">
                                    <div class="empty-table-icon">
                                        <i class="bi bi-building-slash"></i>
                                    </div>
                                    <div class="empty-table-title">Belum Ada Data Villa</div>
                                    <div class="empty-table-subtitle">Mulai tambahkan villa pertama Anda ke dalam sistem.</div>
                                    <a href="{{ route('villas.create') }}" class="btn-hero-add" style="display:inline-flex;">
                                        <i class="bi bi-plus-lg"></i> Tambah Villa Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($villas->hasPages())
            <div class="pagination-wrap">
                {{ $villas->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
