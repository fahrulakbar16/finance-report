@extends('layouts.admin')

@section('page_title', 'Manajemen Fasilitas')

@section('content')
<style>
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
        position: absolute; top: -50px; right: -50px;
        width: 200px; height: 200px; border-radius: 50%;
        background: rgba(201,168,76,0.1); pointer-events: none;
    }
    .page-hero::after {
        content: '';
        position: absolute; bottom: -35px; left: 40%;
        width: 140px; height: 140px; border-radius: 50%;
        background: rgba(255,255,255,0.04); pointer-events: none;
    }
    .page-hero-content { position: relative; z-index: 1; }
    .page-hero-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: rgba(201,168,76,0.2); border: 1px solid rgba(201,168,76,0.35);
        color: var(--brand-accent-light); font-size: 0.68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        padding: 0.25rem 0.7rem; border-radius: var(--radius-pill); margin-bottom: 0.5rem;
    }
    .page-hero-title { font-size: 1.45rem; font-weight: 800; color: #fff; letter-spacing: -0.03em; margin-bottom: 0.2rem; }
    .page-hero-subtitle { font-size: 0.82rem; color: rgba(255,255,255,0.55); font-weight: 500; margin: 0; }
    .btn-hero-add {
        display: inline-flex; align-items: center; gap: 0.5rem;
        font-size: 0.84rem; font-weight: 700;
        border-radius: var(--radius-sm); padding: 0.6rem 1.25rem;
        background: var(--gradient-accent); color: var(--brand-primary);
        border: none; text-decoration: none; box-shadow: var(--shadow-glow-accent);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1); white-space: nowrap;
    }
    .btn-hero-add:hover { transform: translateY(-2px); opacity: 0.9; color: var(--brand-primary); }
    .alert-premium {
        display: flex; align-items: center; gap: 0.75rem;
        border-radius: var(--radius-sm); padding: 0.85rem 1.1rem;
        font-size: 0.84rem; font-weight: 500; margin-bottom: 1rem;
    }
    .alert-premium.success { background: rgba(16,185,129,0.08); color: #065f46; border: 1px solid rgba(16,185,129,0.2); }
    .alert-premium.danger  { background: rgba(239,68,68,0.08);  color: #991b1b; border: 1px solid rgba(239,68,68,0.2); }
    .alert-premium .btn-close { margin-left: auto; }
    .stat-cards-row { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem; }
    .stat-card {
        flex: 1; min-width: 140px; background: var(--surface);
        border-radius: var(--radius-md); border: 1px solid var(--border-subtle);
        box-shadow: var(--shadow-sm); padding: 1rem 1.25rem;
        display: flex; align-items: center; gap: 0.9rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .stat-card-icon {
        width: 42px; height: 42px; border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .stat-card-icon.primary { background: rgba(27,61,47,0.08); color: var(--brand-primary); }
    .stat-card-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); margin-bottom: 0.1rem; }
    .stat-card-value { font-size: 1.35rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.02em; line-height: 1; }
    .fac-table-card { background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); overflow: hidden; }
    .fac-table-header { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border-subtle); }
    .fac-table-title { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; }
    .count-badge { background: rgba(27,61,47,0.08); color: var(--brand-primary); font-size: 0.68rem; font-weight: 700; padding: 0.15rem 0.55rem; border-radius: var(--radius-pill); }
    .fac-table { width: 100%; border-collapse: collapse; }
    .fac-table thead tr { background: var(--bg-app); border-bottom: 1px solid var(--border-subtle); }
    .fac-table thead th { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); padding: 0.7rem 1rem; white-space: nowrap; }
    .fac-table thead th:first-child { padding-left: 1.5rem; }
    .fac-table thead th:last-child  { padding-right: 1.5rem; text-align: right; }
    .fac-table tbody tr { border-bottom: 1px solid var(--border-subtle); transition: background 0.15s; }
    .fac-table tbody tr:last-child { border-bottom: none; }
    .fac-table tbody tr:hover { background: rgba(27,61,47,0.025); }
    .fac-table tbody td { padding: 0.85rem 1rem; vertical-align: middle; }
    .fac-table tbody td:first-child { padding-left: 1.5rem; }
    .fac-table tbody td:last-child  { padding-right: 1.5rem; }
    .fac-icon-chip {
        width: 38px; height: 38px; border-radius: var(--radius-sm);
        background: rgba(27,61,47,0.08); color: var(--brand-primary);
        display: inline-flex; align-items: center; justify-content: center; font-size: 1rem;
    }
    .fac-name { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); }
    .action-btn-group { display: flex; align-items: center; justify-content: flex-end; gap: 0.35rem; }
    .action-btn {
        width: 32px; height: 32px; border-radius: var(--radius-sm);
        border: 1px solid var(--border-subtle); background: var(--surface);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.82rem; text-decoration: none; transition: all 0.15s; cursor: pointer; color: var(--text-secondary);
    }
    .action-btn:hover { transform: translateY(-1px); box-shadow: var(--shadow-xs); }
    .action-btn.edit:hover   { background: rgba(59,130,246,0.08); color: var(--info);   border-color: rgba(59,130,246,0.2); }
    .action-btn.delete:hover { background: rgba(239,68,68,0.08);  color: var(--danger); border-color: rgba(239,68,68,0.2); }
    .empty-table-state { text-align: center; padding: 3.5rem 1rem; }
    .empty-table-icon { width: 64px; height: 64px; border-radius: var(--radius-md); background: rgba(27,61,47,0.06); color: var(--brand-primary); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin: 0 auto 1rem; }
    .empty-table-title { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.3rem; }
    .empty-table-subtitle { font-size: 0.8rem; color: var(--text-tertiary); margin-bottom: 1.25rem; }
    .pagination-wrap { padding: 0.85rem 1.5rem; border-top: 1px solid var(--border-subtle); background: var(--bg-app); }
    /* Delete modal */
    .delete-modal-content { border-radius: var(--radius-md) !important; border: none !important; box-shadow: var(--shadow-lg) !important; overflow: hidden; }
    .delete-modal-body { padding: 2rem 1.5rem; text-align: center; }
    .delete-icon-wrap { width: 64px; height: 64px; border-radius: var(--radius-pill); background: rgba(239,68,68,0.1); border: 2px solid rgba(239,68,68,0.2); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; color: var(--danger); margin: 0 auto 1rem; }
    .delete-title { font-size: 1rem; font-weight: 800; color: var(--text-primary); margin-bottom: 0.4rem; }
    .delete-subtitle { font-size: 0.82rem; color: var(--text-secondary); margin-bottom: 1.5rem; }
    .delete-modal-footer { padding: 0 1.5rem 1.5rem; display: flex; gap: 0.5rem; }
    .btn-delete-confirm { flex: 1; background: var(--gradient-danger); color: #fff; border: none; border-radius: var(--radius-sm); padding: 0.65rem; font-size: 0.84rem; font-weight: 700; cursor: pointer; transition: opacity 0.15s; }
    .btn-delete-confirm:hover { opacity: 0.88; }
    .btn-delete-cancel { flex: 1; background: var(--bg-app); color: var(--text-secondary); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 0.65rem; font-size: 0.84rem; font-weight: 600; cursor: pointer; transition: background 0.15s; }
    .btn-delete-cancel:hover { background: #e2e5ea; }
</style>

<div class="container-fluid px-0 animate-in">

    <!-- HERO -->
    <div class="page-hero mb-4">
        <div class="page-hero-content d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="page-hero-badge"><i class="bi bi-grid-fill"></i> Fasilitas Villa</div>
                <h1 class="page-hero-title">Manajemen Fasilitas</h1>
                <p class="page-hero-subtitle">Kelola data fasilitas yang tersedia di villa</p>
            </div>
            <a href="{{ route('fasilitas.create') }}" class="btn-hero-add">
                <i class="bi bi-plus-lg"></i> Tambah Fasilitas
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-premium success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert-premium danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>Terdapat kesalahan input form. Silakan periksa kembali isian Anda.</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- STAT CARDS -->
    <div class="stat-cards-row">
        <div class="stat-card">
            <div class="stat-card-icon primary"><i class="bi bi-grid-3x3-gap-fill"></i></div>
            <div>
                <div class="stat-card-label">Total Fasilitas</div>
                <div class="stat-card-value">{{ $fasilitas->total() }}</div>
            </div>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="fac-table-card">
        <div class="fac-table-header">
            <div class="fac-table-title">
                <i class="bi bi-list-ul" style="color: var(--brand-primary);"></i>
                Daftar Fasilitas
                <span class="count-badge">{{ $fasilitas->total() }} total</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="fac-table">
                <thead>
                    <tr>
                        <th>Ikon</th>
                        <th>Nama Fasilitas</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fasilitas as $item)
                        <tr>
                            <td>
                                <div class="fac-icon-chip">
                                    <i class="{{ $item->ikon ?? 'bi bi-grid' }}"></i>
                                </div>
                            </td>
                            <td><span class="fac-name">{{ $item->nama }}</span></td>
                            <td>
                                <div class="action-btn-group">
                                    <a href="{{ route('fasilitas.edit', $item->id) }}" class="action-btn edit" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="action-btn delete" data-bs-toggle="modal" data-bs-target="#deleteFasilitasModal{{ $item->id }}" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteFasilitasModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content delete-modal-content">
                                    <div class="delete-modal-body">
                                        <div class="delete-icon-wrap"><i class="bi bi-trash3-fill"></i></div>
                                        <div class="delete-title">Hapus Fasilitas?</div>
                                        <div class="delete-subtitle">Fasilitas <strong>{{ $item->nama }}</strong> akan dihapus secara permanen dan tidak dapat dipulihkan.</div>
                                        <form action="{{ route('fasilitas.destroy', $item->id) }}" method="POST" id="deleteForm{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                    <div class="delete-modal-footer">
                                        <button type="button" class="btn-delete-cancel" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" form="deleteForm{{ $item->id }}" class="btn-delete-confirm">
                                            <i class="bi bi-trash-fill me-1"></i> Ya, Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-table-state">
                                    <div class="empty-table-icon"><i class="bi bi-grid-slash"></i></div>
                                    <div class="empty-table-title">Belum Ada Fasilitas</div>
                                    <div class="empty-table-subtitle">Mulai tambahkan fasilitas untuk villa Anda.</div>
                                    <a href="{{ route('fasilitas.create') }}" class="btn-hero-add" style="display:inline-flex;">
                                        <i class="bi bi-plus-lg"></i> Tambah Fasilitas
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($fasilitas->hasPages())
            <div class="pagination-wrap">{{ $fasilitas->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
</div>
@endsection
