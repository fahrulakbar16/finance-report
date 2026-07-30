@extends('layouts.admin')

@section('page_title', 'Laporan Keuangan')

@section('content')
<style>
    .page-hero {
        position: relative; background: var(--gradient-primary);
        border-radius: var(--radius-lg); padding: 1.75rem 2rem; margin-bottom: 1.75rem;
        overflow: hidden; box-shadow: var(--shadow-glow-primary);
    }
    .page-hero::before { content: ''; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; border-radius: 50%; background: rgba(201,168,76,0.1); pointer-events: none; }
    .page-hero::after  { content: ''; position: absolute; bottom: -35px; left: 40%; width: 140px; height: 140px; border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events: none; }
    .page-hero-content { position: relative; z-index: 1; }
    .page-hero-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(201,168,76,0.2); border: 1px solid rgba(201,168,76,0.35); color: var(--brand-accent-light); font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; padding: 0.25rem 0.7rem; border-radius: var(--radius-pill); margin-bottom: 0.5rem; }
    .page-hero-title { font-size: 1.45rem; font-weight: 800; color: #fff; letter-spacing: -0.03em; margin-bottom: 0.2rem; }
    .page-hero-subtitle { font-size: 0.82rem; color: rgba(255,255,255,0.55); font-weight: 500; margin: 0; }

    /* Metric Cards */
    .metric-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
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

    /* Table Card */
    .fin-table-card { background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); overflow: hidden; }
    .fin-table-header { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border-subtle); }
    .fin-table-title { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; }
    .fin-table { width: 100%; border-collapse: collapse; }
    .fin-table thead tr { background: var(--bg-app); border-bottom: 1px solid var(--border-subtle); }
    .fin-table thead th { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); padding: 0.7rem 1rem; white-space: nowrap; }
    .fin-table thead th:first-child { padding-left: 1.5rem; }
    .fin-table thead th:last-child  { padding-right: 1.5rem; text-align: right; }
    .fin-table tbody tr { border-bottom: 1px solid var(--border-subtle); transition: background 0.15s; }
    .fin-table tbody tr:last-child { border-bottom: none; }
    .fin-table tbody tr:hover { background: rgba(27,61,47,0.025); }
    .fin-table tbody td { padding: 0.85rem 1rem; vertical-align: middle; }
    .fin-table tbody td:first-child { padding-left: 1.5rem; }
    .fin-table tbody td:last-child  { padding-right: 1.5rem; }
    .date-cell { font-size: 0.78rem; font-weight: 600; color: var(--text-secondary); white-space: nowrap; }
    .desc-cell { font-size: 0.88rem; font-weight: 600; color: var(--text-primary); }
    .type-badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.72rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: var(--radius-pill); }
    .type-badge.income  { background: rgba(16,185,129,0.08); color: #059669; border: 1px solid rgba(16,185,129,0.2); }
    .type-badge.expense { background: rgba(239,68,68,0.08);  color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
    .amount-cell { text-align: right; }
    .amount-value { display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.88rem; font-weight: 700; }
    .amount-value.income  { color: var(--success); }
    .amount-value.expense { color: var(--danger); }
    .empty-table-state { text-align: center; padding: 3rem 1rem; }
    .empty-table-icon { width: 60px; height: 60px; border-radius: var(--radius-md); background: rgba(27,61,47,0.06); color: var(--brand-primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem; }
    .empty-table-title { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem; }
    .empty-table-subtitle { font-size: 0.78rem; color: var(--text-tertiary); }
</style>

<div class="container-fluid px-0 animate-in">

    <!-- HERO -->
    <div class="page-hero mb-4">
        <div class="page-hero-content d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="page-hero-badge"><i class="bi bi-bar-chart-line-fill"></i> Keuangan</div>
                <h1 class="page-hero-title">Laporan Keuangan</h1>
                <p class="page-hero-subtitle">Ringkasan pemasukan, pengeluaran, dan saldo seluruh villa</p>
            </div>
        </div>
    </div>

    <!-- METRIC CARDS -->
    <div class="metric-cards">
        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-label">Total Pemasukan</span>
                <div class="metric-icon income"><i class="bi bi-graph-up-arrow"></i></div>
            </div>
            <div class="metric-value income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-label">Total Pengeluaran</span>
                <div class="metric-icon expense"><i class="bi bi-graph-down-arrow"></i></div>
            </div>
            <div class="metric-value expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-label">Saldo Akhir</span>
                <div class="metric-icon balance"><i class="bi bi-wallet2"></i></div>
            </div>
            <div class="metric-value {{ $balance < 0 ? 'balance-neg' : '' }}">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="fin-table-card">
        <div class="fin-table-header">
            <div class="fin-table-title">
                <i class="bi bi-list-ul" style="color: var(--brand-primary);"></i>
                Daftar Transaksi
            </div>
            @role('pengelola')
                <button class="btn-hero-add" style="display:inline-flex; font-size:0.78rem; padding:0.45rem 1rem;">
                    <i class="bi bi-plus-lg"></i> Tambah Transaksi
                </button>
            @endrole
        </div>
        <div class="table-responsive">
            <table class="fin-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td><span class="date-cell">{{ \Carbon\Carbon::parse($report->date)->format('d M Y') }}</span></td>
                            <td><span class="desc-cell">{{ $report->description }}</span></td>
                            <td>
                                @if($report->type == 'income')
                                    <span class="type-badge income"><i class="bi bi-arrow-up-circle-fill"></i> Pemasukan</span>
                                @else
                                    <span class="type-badge expense"><i class="bi bi-arrow-down-circle-fill"></i> Pengeluaran</span>
                                @endif
                            </td>
                            <td class="amount-cell">
                                <span class="amount-value {{ $report->type == 'income' ? 'income' : 'expense' }}">
                                    {{ $report->type == 'income' ? '+' : '-' }}
                                    Rp {{ number_format($report->amount, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-table-state">
                                    <div class="empty-table-icon"><i class="bi bi-receipt"></i></div>
                                    <div class="empty-table-title">Belum Ada Data Transaksi</div>
                                    <div class="empty-table-subtitle">Belum ada data laporan keuangan yang tersedia.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    .btn-hero-add { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.84rem; font-weight: 700; border-radius: var(--radius-sm); padding: 0.6rem 1.25rem; background: var(--gradient-accent); color: var(--brand-primary); border: none; text-decoration: none; box-shadow: var(--shadow-glow-accent); transition: all 0.2s; cursor: pointer; }
    .btn-hero-add:hover { transform: translateY(-2px); opacity: 0.9; }
</style>
@endsection
