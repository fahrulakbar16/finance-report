@extends('layouts.admin')

@section('page_title', 'Laporan Villa: ' . $villa->name)

@section('content')
<style>
    /* --- Villa Laporan Hero --- */
    .laporan-hero {
        position: relative; background: var(--gradient-primary);
        border-radius: var(--radius-lg); padding: 1.75rem 2rem; margin-bottom: 1.75rem;
        overflow: hidden; box-shadow: var(--shadow-glow-primary);
    }
    .laporan-hero::before { content: ''; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; border-radius: 50%; background: rgba(201,168,76,0.12); pointer-events: none; }
    .laporan-hero::after  { content: ''; position: absolute; bottom: -30px; left: 35%; width: 130px; height: 130px; border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events: none; }
    .laporan-hero-content { position: relative; z-index: 1; }
    .btn-hero-back { display: inline-flex; align-items: center; gap: 0.45rem; font-size: 0.82rem; font-weight: 600; border-radius: var(--radius-sm); padding: 0.45rem 1rem; background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.85); border: 1px solid rgba(255,255,255,0.15); backdrop-filter: blur(8px); text-decoration: none; transition: all 0.2s; }
    .btn-hero-back:hover { background: rgba(255,255,255,0.18); color: #fff; }
    .villa-hero-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(201,168,76,0.2); border: 1px solid rgba(201,168,76,0.35); color: var(--brand-accent-light); font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; padding: 0.25rem 0.7rem; border-radius: var(--radius-pill); margin-bottom: 0.5rem; }
    .villa-hero-name { font-size: 1.5rem; font-weight: 800; color: #fff; letter-spacing: -0.03em; margin-bottom: 0.25rem; }
    .villa-hero-meta { font-size: 0.8rem; color: rgba(255,255,255,0.6); display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
    .villa-hero-meta i { font-size: 0.75rem; }
    .btn-export { display: inline-flex; align-items: center; gap: 0.45rem; font-size: 0.82rem; font-weight: 700; border-radius: var(--radius-sm); padding: 0.5rem 1.1rem; background: var(--gradient-accent); color: var(--brand-primary); border: none; text-decoration: none; box-shadow: var(--shadow-glow-accent); transition: all 0.2s; }
    .btn-export:hover { transform: translateY(-2px); opacity: 0.9; color: var(--brand-primary); }
    .btn-transactions { display: inline-flex; align-items: center; gap: 0.45rem; font-size: 0.82rem; font-weight: 600; border-radius: var(--radius-sm); padding: 0.5rem 1.1rem; background: rgba(255,255,255,0.12); color: rgba(255,255,255,0.9); border: 1px solid rgba(255,255,255,0.2); text-decoration: none; transition: all 0.2s; cursor: pointer; }
    .btn-transactions:hover { background: rgba(255,255,255,0.2); color: #fff; }

    /* --- Filter Card --- */
    .filter-card { background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); padding: 1.25rem 1.5rem; margin-bottom: 1.25rem; }
    .filter-card-title { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-tertiary); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.4rem; }
    .fi-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-bottom: 0.35rem; display: block; }
    .fi-input { width: 100%; background: var(--bg-app); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 0.55rem 0.85rem; font-size: 0.84rem; font-weight: 500; color: var(--text-primary); transition: border-color 0.15s, box-shadow 0.15s; outline: none; }
    .fi-input:focus { border-color: var(--brand-primary); box-shadow: 0 0 0 3px rgba(27,61,47,0.08); background: var(--surface); }
    .btn-filter { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.84rem; font-weight: 700; border-radius: var(--radius-sm); padding: 0.6rem 1.25rem; background: var(--gradient-primary); color: #fff; border: none; cursor: pointer; box-shadow: var(--shadow-glow-primary); transition: opacity 0.15s; width: 100%; justify-content: center; }
    .btn-filter:hover { opacity: 0.88; }
    .btn-reset { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.84rem; font-weight: 600; border-radius: var(--radius-sm); padding: 0.6rem 1.25rem; background: var(--bg-app); color: var(--text-secondary); border: 1px solid var(--border-subtle); text-decoration: none; width: 100%; justify-content: center; transition: background 0.15s; }
    .btn-reset:hover { background: #e2e5ea; color: var(--text-primary); }

    /* --- Metric Cards --- */
    .metric-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .metric-card { background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); padding: 1.25rem 1.5rem; transition: box-shadow 0.2s, transform 0.2s; }
    .metric-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .metric-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem; }
    .metric-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); }
    .metric-icon { width: 40px; height: 40px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
    .metric-icon.income  { background: rgba(16,185,129,0.1);  color: var(--success); }
    .metric-icon.expense { background: rgba(239,68,68,0.08);  color: var(--danger); }
    .metric-icon.balance { background: rgba(27,61,47,0.08);   color: var(--brand-primary); }
    .metric-value { font-size: 1.4rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.03em; line-height: 1.1; }
    .metric-value.income  { color: var(--success); }
    .metric-value.expense { color: var(--danger); }
    .metric-value.balance-neg { color: var(--danger); }

    /* --- Transaction Table --- */
    .trx-table-card { background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); overflow: hidden; }
    .trx-table-header { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border-subtle); }
    .trx-table-title { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; }
    .trx-table { width: 100%; border-collapse: collapse; }
    .trx-table thead tr { background: var(--bg-app); border-bottom: 1px solid var(--border-subtle); }
    .trx-table thead th { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); padding: 0.7rem 1rem; white-space: nowrap; }
    .trx-table thead th:first-child { padding-left: 1.5rem; }
    .trx-table thead th:last-child  { padding-right: 1.5rem; text-align: right; }
    .trx-table tbody tr { border-bottom: 1px solid var(--border-subtle); transition: background 0.15s; }
    .trx-table tbody tr:last-child { border-bottom: none; }
    .trx-table tbody tr:hover { background: rgba(27,61,47,0.025); }
    .trx-table tbody td { padding: 0.85rem 1rem; vertical-align: middle; }
    .trx-table tbody td:first-child { padding-left: 1.5rem; }
    .trx-table tbody td:last-child  { padding-right: 1.5rem; text-align: right; }
    .date-cell { font-size: 0.78rem; font-weight: 600; color: var(--text-secondary); white-space: nowrap; }
    .name-cell { font-size: 0.88rem; font-weight: 600; color: var(--text-primary); }
    .type-badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.72rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: var(--radius-pill); }
    .type-badge.income  { background: rgba(16,185,129,0.08); color: #059669; border: 1px solid rgba(16,185,129,0.2); }
    .type-badge.expense { background: rgba(239,68,68,0.08);  color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
    .amount-value { font-size: 0.88rem; font-weight: 700; }
    .amount-value.income  { color: var(--success); }
    .amount-value.expense { color: var(--danger); }
    .empty-table-state { text-align: center; padding: 3rem 1rem; }
    .empty-table-icon { width: 60px; height: 60px; border-radius: var(--radius-md); background: rgba(27,61,47,0.06); color: var(--brand-primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem; }
    .empty-table-title { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem; }
    .empty-table-subtitle { font-size: 0.78rem; color: var(--text-tertiary); }
    .pagination-wrap { padding: 0.85rem 1.5rem; border-top: 1px solid var(--border-subtle); background: var(--bg-app); }
</style>

<div class="container-fluid px-0 animate-in">

    <!-- HERO -->
    <div class="laporan-hero mb-4">
        <div class="laporan-hero-content">
            <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-3">
                <a href="javascript:void(0)" onclick="window.history.back();" class="btn-hero-back">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('export.excel.villa', ['villa' => $villa->id] + request()->query()) }}" class="btn-export">
                        <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
                    </a>
                    <form action="{{ route('transactions.index', ['villa_id' => $villa->id]) }}" method="GET" style="display:inline;">
                        <button type="submit" class="btn-transactions">
                            <i class="bi bi-list-stars"></i> Lihat Semua Transaksi
                        </button>
                    </form>
                </div>
            </div>
            <div class="villa-hero-badge"><i class="bi bi-bar-chart-line-fill"></i> Laporan Villa</div>
            <h1 class="villa-hero-name">{{ $villa->name }}</h1>
            <div class="villa-hero-meta">
                <span><i class="bi bi-envelope-fill"></i> {{ $villa->email }}</span>
                <span><i class="bi bi-person-fill"></i> {{ $villa->pemilik->name }}</span>
            </div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="filter-card mb-4">
        <div class="filter-card-title"><i class="bi bi-funnel-fill"></i> Filter Periode</div>
        <form action="{{ route('villas.laporan', $villa) }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="fi-label" for="start_date">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" class="fi-input" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="fi-label" for="end_date">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" class="fi-input" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-filter"><i class="bi bi-filter"></i> Filter</button>
                        <a href="{{ route('villas.laporan', $villa) }}" class="btn-reset"><i class="bi bi-x-lg"></i> Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- METRIC CARDS -->
    <div class="metric-cards">
        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-label">Pemasukan Villa</span>
                <div class="metric-icon income"><i class="bi bi-graph-up-arrow"></i></div>
            </div>
            <div class="metric-value income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-label">Pengeluaran Villa</span>
                <div class="metric-icon expense"><i class="bi bi-graph-down-arrow"></i></div>
            </div>
            <div class="metric-value expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-label">Profitability</span>
                <div class="metric-icon balance"><i class="bi bi-cash-coin"></i></div>
            </div>
            <div class="metric-value {{ $balance < 0 ? 'balance-neg' : '' }}">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- TRANSACTION TABLE -->
    <div class="trx-table-card">
        <div class="trx-table-header">
            <div class="trx-table-title">
                <i class="bi bi-list-ul" style="color: var(--brand-primary);"></i>
                Riwayat Transaksi Villa
            </div>
        </div>
        <div class="table-responsive">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td><span class="date-cell">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</span></td>
                            <td><span class="name-cell">{{ $transaction->name }}</span></td>
                            <td>
                                @if($transaction->type == 'income')
                                    <span class="type-badge income"><i class="bi bi-arrow-up-circle-fill"></i> Pemasukan</span>
                                @else
                                    <span class="type-badge expense"><i class="bi bi-arrow-down-circle-fill"></i> Pengeluaran</span>
                                @endif
                            </td>
                            <td>
                                <span class="amount-value {{ $transaction->type == 'income' ? 'income' : 'expense' }}">
                                    {{ $transaction->type == 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-table-state">
                                    <div class="empty-table-icon"><i class="bi bi-receipt"></i></div>
                                    <div class="empty-table-title">Tidak Ada Transaksi</div>
                                    <div class="empty-table-subtitle">Tidak ada transaksi ditemukan untuk kriteria filter ini.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="pagination-wrap">{{ $transactions->withQueryString()->links() }}</div>
        @endif
    </div>

</div>
@endsection
