@extends('layouts.admin')

@section('page_title', 'Pengeluaran Rutin')

@section('content')
<style>
    .page-hero { position: relative; background: var(--gradient-primary); border-radius: var(--radius-lg); padding: 1.75rem 2rem; margin-bottom: 1.75rem; overflow: hidden; box-shadow: var(--shadow-glow-primary); }
    .page-hero::before { content: ''; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; border-radius: 50%; background: rgba(201,168,76,0.1); pointer-events: none; }
    .page-hero::after  { content: ''; position: absolute; bottom: -35px; left: 40%; width: 140px; height: 140px; border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events: none; }
    .page-hero-content { position: relative; z-index: 1; }
    .page-hero-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(201,168,76,0.2); border: 1px solid rgba(201,168,76,0.35); color: var(--brand-accent-light); font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; padding: 0.25rem 0.7rem; border-radius: var(--radius-pill); margin-bottom: 0.5rem; }
    .page-hero-title { font-size: 1.45rem; font-weight: 800; color: #fff; letter-spacing: -0.03em; margin-bottom: 0.2rem; }
    .page-hero-subtitle { font-size: 0.82rem; color: rgba(255,255,255,0.55); font-weight: 500; margin: 0; }
    .alert-premium { display: flex; align-items: center; gap: 0.75rem; border-radius: var(--radius-sm); padding: 0.85rem 1.1rem; font-size: 0.84rem; font-weight: 500; margin-bottom: 1rem; }
    .alert-premium.success { background: rgba(16,185,129,0.08); color: #065f46; border: 1px solid rgba(16,185,129,0.2); }
    .alert-premium.danger  { background: rgba(239,68,68,0.08);  color: #991b1b; border: 1px solid rgba(239,68,68,0.2); }
    .alert-premium .btn-close { margin-left: auto; }
    .stat-cards-row { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem; }
    .stat-card { flex: 1; min-width: 140px; background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); padding: 1rem 1.25rem; display: flex; align-items: center; gap: 0.9rem; transition: box-shadow 0.2s, transform 0.2s; }
    .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .stat-card-icon { width: 42px; height: 42px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .stat-card-icon.primary { background: rgba(27,61,47,0.08);  color: var(--brand-primary); }
    .stat-card-icon.success { background: rgba(16,185,129,0.1); color: var(--success); }
    .stat-card-icon.danger  { background: rgba(239,68,68,0.08); color: var(--danger); }
    .stat-card-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); margin-bottom: 0.1rem; }
    .stat-card-value { font-size: 1.35rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.02em; line-height: 1; }
    .rec-table-card { background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); overflow: hidden; }
    .rec-table-header { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border-subtle); }
    .rec-table-title { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; }
    .count-badge { background: rgba(27,61,47,0.08); color: var(--brand-primary); font-size: 0.68rem; font-weight: 700; padding: 0.15rem 0.55rem; border-radius: var(--radius-pill); }
    .rec-table { width: 100%; border-collapse: collapse; }
    .rec-table thead tr { background: var(--bg-app); border-bottom: 1px solid var(--border-subtle); }
    .rec-table thead th { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); padding: 0.7rem 1rem; white-space: nowrap; }
    .rec-table thead th:first-child { padding-left: 1.5rem; }
    .rec-table thead th:last-child  { padding-right: 1.5rem; text-align: center; }
    .rec-table tbody tr { border-bottom: 1px solid var(--border-subtle); transition: background 0.15s; }
    .rec-table tbody tr:last-child { border-bottom: none; }
    .rec-table tbody tr:hover { background: rgba(27,61,47,0.025); }
    .rec-table tbody td { padding: 0.85rem 1rem; vertical-align: middle; }
    .rec-table tbody td:first-child { padding-left: 1.5rem; }
    .rec-table tbody td:last-child  { padding-right: 1.5rem; text-align: center; }
    .rec-icon-wrap { width: 36px; height: 36px; border-radius: var(--radius-sm); background: rgba(249,115,22,0.08); color: var(--warning); display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; }
    .rec-name { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); }
    .villa-chip { display: inline-flex; align-items: center; gap: 0.3rem; background: var(--bg-app); border: 1px solid var(--border-subtle); border-radius: var(--radius-pill); padding: 0.2rem 0.6rem 0.2rem 0.4rem; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); }
    .villa-chip i { color: var(--brand-primary); }
    .type-badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.72rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: var(--radius-pill); }
    .type-badge.income  { background: rgba(16,185,129,0.08); color: #059669; border: 1px solid rgba(16,185,129,0.2); }
    .type-badge.expense { background: rgba(239,68,68,0.08);  color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
    .freq-badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.72rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: var(--radius-pill); background: rgba(59,130,246,0.08); color: var(--info); border: 1px solid rgba(59,130,246,0.2); }
    .date-cell { font-size: 0.78rem; font-weight: 600; color: var(--text-secondary); }
    .date-none  { font-size: 0.75rem; font-weight: 500; color: var(--text-tertiary); font-style: italic; }
    .amount-badge { display: inline-flex; align-items: center; font-size: 0.82rem; font-weight: 700; color: var(--text-primary); background: rgba(249,115,22,0.08); border: 1px solid rgba(249,115,22,0.15); border-radius: var(--radius-sm); padding: 0.25rem 0.65rem; }
    .action-btn { width: 32px; height: 32px; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); background: var(--surface); display: inline-flex; align-items: center; justify-content: center; font-size: 0.82rem; transition: all 0.15s; cursor: pointer; color: var(--text-secondary); }
    .action-btn:hover { transform: translateY(-1px); box-shadow: var(--shadow-xs); }
    .action-btn.delete:hover { background: rgba(239,68,68,0.08); color: var(--danger); border-color: rgba(239,68,68,0.2); }
    .empty-table-state { text-align: center; padding: 3.5rem 1rem; }
    .empty-table-icon { width: 64px; height: 64px; border-radius: var(--radius-md); background: rgba(27,61,47,0.06); color: var(--brand-primary); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin: 0 auto 1rem; }
    .empty-table-title { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.3rem; }
    .empty-table-subtitle { font-size: 0.8rem; color: var(--text-tertiary); }
    .pagination-wrap { padding: 0.85rem 1.5rem; border-top: 1px solid var(--border-subtle); background: var(--bg-app); }
</style>

<div class="container-fluid px-0 animate-in">

    <!-- HERO -->
    <div class="page-hero mb-4">
        <div class="page-hero-content d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="page-hero-badge"><i class="bi bi-arrow-repeat"></i> Otomatis Terjadwal</div>
                <h1 class="page-hero-title">Pengeluaran Rutin</h1>
                <p class="page-hero-subtitle">Kelola dan pantau semua transaksi rutin yang terjadwal otomatis</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-premium success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-premium danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- STAT CARDS -->
    <div class="stat-cards-row">
        <div class="stat-card">
            <div class="stat-card-icon primary"><i class="bi bi-arrow-repeat"></i></div>
            <div>
                <div class="stat-card-label">Total Transaksi Rutin</div>
                <div class="stat-card-value">{{ $recurringTransactions->total() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon success"><i class="bi bi-arrow-up-circle-fill"></i></div>
            <div>
                <div class="stat-card-label">Pemasukan Rutin</div>
                <div class="stat-card-value">{{ $recurringTransactions->where('type', 'income')->count() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon danger"><i class="bi bi-arrow-down-circle-fill"></i></div>
            <div>
                <div class="stat-card-label">Pengeluaran Rutin</div>
                <div class="stat-card-value">{{ $recurringTransactions->where('type', 'expense')->count() }}</div>
            </div>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="rec-table-card">
        <div class="rec-table-header">
            <div class="rec-table-title">
                <i class="bi bi-list-ul" style="color: var(--brand-primary);"></i>
                Daftar Pengeluaran Rutin
                <span class="count-badge">{{ $recurringTransactions->total() }} total</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="rec-table">
                <thead>
                    <tr>
                        <th>Nama Transaksi</th>
                        <th>Villa</th>
                        <th>Tipe</th>
                        <th>Frekuensi</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recurringTransactions as $recurring)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rec-icon-wrap"><i class="bi bi-repeat"></i></div>
                                    <span class="rec-name">{{ $recurring->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="villa-chip">
                                    <i class="bi bi-house-door-fill"></i>
                                    {{ $recurring->villa ? $recurring->villa->name : '-' }}
                                </div>
                            </td>
                            <td>
                                @if($recurring->type === 'income')
                                    <span class="type-badge income"><i class="bi bi-arrow-up-circle-fill"></i> Pemasukan</span>
                                @else
                                    <span class="type-badge expense"><i class="bi bi-arrow-down-circle-fill"></i> Pengeluaran</span>
                                @endif
                            </td>
                            <td>
                                <span class="freq-badge"><i class="bi bi-clock"></i> {{ ucfirst($recurring->frequency) }}</span>
                            </td>
                            <td>
                                <span class="date-cell">{{ \Carbon\Carbon::parse($recurring->start_date)->format('d M Y') }}</span>
                            </td>
                            <td>
                                @if($recurring->end_date)
                                    <span class="date-cell">{{ \Carbon\Carbon::parse($recurring->end_date)->format('d M Y') }}</span>
                                @else
                                    <span class="date-none">Tanpa batas</span>
                                @endif
                            </td>
                            <td>
                                <span class="amount-badge">Rp {{ number_format($recurring->amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <form action="{{ route('recurring-transactions.destroy', $recurring->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghentikan dan menghapus pengeluaran rutin ini?');"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Hapus Rutinitas">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-table-state">
                                    <div class="empty-table-icon"><i class="bi bi-arrow-repeat"></i></div>
                                    <div class="empty-table-title">Belum Ada Pengeluaran Rutin</div>
                                    <div class="empty-table-subtitle">Transaksi rutin yang terjadwal akan muncul di sini.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($recurringTransactions->hasPages())
            <div class="pagination-wrap">{{ $recurringTransactions->links() }}</div>
        @endif
    </div>
</div>
@endsection
