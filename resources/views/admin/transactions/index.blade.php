@extends('layouts.admin')

@section('page_title', 'Manajemen Transaksi')

@section('content')
<style>
    /* ============ TRANSACTIONS INDEX — PREMIUM ============ */
    .page-hero { position: relative; background: var(--gradient-primary); border-radius: var(--radius-lg); padding: 1.75rem 2rem; margin-bottom: 1.75rem; overflow: hidden; box-shadow: var(--shadow-glow-primary); }
    .page-hero::before { content: ''; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; border-radius: 50%; background: rgba(201,168,76,0.1); pointer-events: none; }
    .page-hero::after  { content: ''; position: absolute; bottom: -35px; left: 40%; width: 140px; height: 140px; border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events: none; }
    .page-hero-content { position: relative; z-index: 1; }
    .page-hero-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(201,168,76,0.2); border: 1px solid rgba(201,168,76,0.35); color: var(--brand-accent-light); font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; padding: 0.25rem 0.7rem; border-radius: var(--radius-pill); margin-bottom: 0.5rem; }
    .page-hero-title { font-size: 1.45rem; font-weight: 800; color: #fff; letter-spacing: -0.03em; margin-bottom: 0.2rem; }
    .page-hero-subtitle { font-size: 0.82rem; color: rgba(255,255,255,0.55); font-weight: 500; margin: 0; }
    .hero-actions { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
    .btn-hero-excel { display: inline-flex; align-items: center; gap: 0.45rem; font-size: 0.82rem; font-weight: 700; border-radius: var(--radius-sm); padding: 0.5rem 1.1rem; background: rgba(16,185,129,0.2); color: #a7f3d0; border: 1px solid rgba(16,185,129,0.3); text-decoration: none; transition: all 0.2s; }
    .btn-hero-excel:hover { background: rgba(16,185,129,0.35); color: #fff; }
    .btn-hero-pdf   { display: inline-flex; align-items: center; gap: 0.45rem; font-size: 0.82rem; font-weight: 700; border-radius: var(--radius-sm); padding: 0.5rem 1.1rem; background: rgba(239,68,68,0.2); color: #fca5a5; border: 1px solid rgba(239,68,68,0.3); text-decoration: none; transition: all 0.2s; }
    .btn-hero-pdf:hover   { background: rgba(239,68,68,0.35); color: #fff; }
    .btn-hero-add { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.84rem; font-weight: 700; border-radius: var(--radius-sm); padding: 0.6rem 1.25rem; background: var(--gradient-accent); color: var(--brand-primary); border: none; text-decoration: none; box-shadow: var(--shadow-glow-accent); transition: all 0.2s; cursor: pointer; white-space: nowrap; }
    .btn-hero-add:hover { transform: translateY(-2px); opacity: 0.9; color: var(--brand-primary); }
    .alert-premium { display: flex; align-items: center; gap: 0.75rem; border-radius: var(--radius-sm); padding: 0.85rem 1.1rem; font-size: 0.84rem; font-weight: 500; margin-bottom: 1rem; }
    .alert-premium.success { background: rgba(16,185,129,0.08); color: #065f46; border: 1px solid rgba(16,185,129,0.2); }
    .alert-premium .btn-close { margin-left: auto; }

    /* Metric Cards */
    .metric-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .metric-card { background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); padding: 1.25rem 1.5rem; transition: box-shadow 0.2s, transform 0.2s; }
    .metric-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
    .metric-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem; }
    .metric-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); }
    .metric-icon { width: 40px; height: 40px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
    .metric-icon.income  { background: rgba(16,185,129,0.1);  color: var(--success); }
    .metric-icon.expense { background: rgba(239,68,68,0.08);  color: var(--danger); }
    .metric-icon.manager { background: rgba(27,61,47,0.08);   color: var(--brand-primary); }
    .metric-icon.owner   { background: rgba(59,130,246,0.08); color: var(--info); }
    .metric-value { font-size: 1.25rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.03em; line-height: 1.1; }
    .metric-value.income  { color: var(--success); }
    .metric-value.expense { color: var(--danger); }
    .metric-value.neg     { color: var(--danger); }

    /* Filter Card */
    .filter-card { background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; }
    .filter-card-title { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-tertiary); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.4rem; }
    .fi-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-bottom: 0.35rem; display: block; }
    .fi-input { width: 100%; background: var(--bg-app); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 0.55rem 0.85rem; font-size: 0.84rem; font-weight: 500; color: var(--text-primary); transition: border-color 0.15s, box-shadow 0.15s; outline: none; appearance: auto; }
    .fi-input:focus { border-color: var(--brand-primary); box-shadow: 0 0 0 3px rgba(27,61,47,0.08); background: var(--surface); }
    .btn-filter { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.84rem; font-weight: 700; border-radius: var(--radius-sm); padding: 0.6rem 1.25rem; background: var(--gradient-primary); color: #fff; border: none; cursor: pointer; box-shadow: var(--shadow-glow-primary); transition: opacity 0.15s; }
    .btn-filter:hover { opacity: 0.88; }
    .btn-reset { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.84rem; font-weight: 600; border-radius: var(--radius-sm); padding: 0.6rem 1.25rem; background: var(--bg-app); color: var(--text-secondary); border: 1px solid var(--border-subtle); text-decoration: none; transition: background 0.15s; }
    .btn-reset:hover { background: #e2e5ea; color: var(--text-primary); }

    /* Transaction Table Card */
    .trx-table-card { background: var(--surface); border-radius: var(--radius-md); border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm); overflow: hidden; }
    .trx-card-header { padding: 0 1.5rem; border-bottom: 1px solid var(--border-subtle); }
    .trx-card-header-top { display: flex; align-items: center; justify-content: space-between; padding-top: 1.1rem; padding-bottom: 0.75rem; }
    .trx-card-title { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); }

    /* Custom Tabs */
    .trx-tabs { display: flex; gap: 0; border-bottom: none; }
    .trx-tab-btn { background: none; border: none; border-bottom: 2px solid transparent; font-size: 0.84rem; font-weight: 600; color: var(--text-tertiary); padding: 0.75rem 1.1rem 0.6rem; cursor: pointer; transition: color 0.15s, border-color 0.15s; white-space: nowrap; }
    .trx-tab-btn:hover { color: var(--text-primary); }
    .trx-tab-btn.active { color: var(--brand-primary); border-bottom-color: var(--brand-primary); }

    /* Table */
    .trx-table { width: 100%; border-collapse: collapse; }
    .trx-table thead tr { background: var(--bg-app); border-bottom: 1px solid var(--border-subtle); }
    .trx-table thead th { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-tertiary); padding: 0.7rem 1rem; white-space: nowrap; }
    .trx-table thead th:first-child { padding-left: 1.5rem; }
    .trx-table thead th:last-child  { padding-right: 1.5rem; }
    .trx-table tbody tr { border-bottom: 1px solid var(--border-subtle); transition: background 0.15s; }
    .trx-table tbody tr:last-child { border-bottom: none; }
    .trx-table tbody tr:hover { background: rgba(27,61,47,0.025); }
    .trx-table tbody td { padding: 0.85rem 1rem; vertical-align: middle; }
    .trx-table tbody td:first-child { padding-left: 1.5rem; }
    .trx-table tbody td:last-child  { padding-right: 1.5rem; }
    .trx-icon-wrap { width: 38px; height: 38px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
    .trx-icon-wrap.income  { background: rgba(16,185,129,0.1); color: var(--success); }
    .trx-icon-wrap.expense { background: rgba(239,68,68,0.08); color: var(--danger); }
    .trx-icon-wrap.owner   { background: rgba(249,115,22,0.08); color: var(--warning); }
    .trx-name { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); }
    .trx-id   { font-size: 0.72rem; color: var(--text-tertiary); font-weight: 500; margin-top: 1px; }
    .date-main { font-size: 0.82rem; font-weight: 600; color: var(--text-secondary); }
    .date-rel  { font-size: 0.72rem; color: var(--text-tertiary); font-weight: 500; }
    .villa-chip { display: inline-flex; align-items: center; gap: 0.3rem; background: var(--bg-app); border: 1px solid var(--border-subtle); border-radius: var(--radius-pill); padding: 0.2rem 0.65rem 0.2rem 0.4rem; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); }
    .villa-chip i { color: var(--brand-primary); }
    .amount-cell { text-align: right; }
    .amount-value { font-size: 0.88rem; font-weight: 800; }
    .amount-value.income  { color: var(--success); }
    .amount-value.expense { color: var(--danger); }
    .amount-value.owner   { color: var(--warning); }
    .action-btn-group { display: flex; align-items: center; justify-content: flex-end; gap: 0.35rem; }
    .action-btn { width: 32px; height: 32px; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); background: var(--surface); display: inline-flex; align-items: center; justify-content: center; font-size: 0.82rem; text-decoration: none; transition: all 0.15s; cursor: pointer; color: var(--text-secondary); }
    .action-btn:hover { transform: translateY(-1px); box-shadow: var(--shadow-xs); }
    .action-btn.edit:hover   { background: rgba(59,130,246,0.08); color: var(--info);   border-color: rgba(59,130,246,0.2); }
    .action-btn.delete:hover { background: rgba(239,68,68,0.08);  color: var(--danger); border-color: rgba(239,68,68,0.2); }
    .empty-table-state { text-align: center; padding: 3rem 1rem; }
    .empty-table-icon { width: 60px; height: 60px; border-radius: var(--radius-md); background: rgba(27,61,47,0.06); color: var(--brand-primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem; }
    .empty-table-title { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem; }
    .empty-table-subtitle { font-size: 0.78rem; color: var(--text-tertiary); }
    .pagination-wrap { padding: 0.85rem 1.5rem; border-top: 1px solid var(--border-subtle); background: var(--bg-app); }
    .pagination-fi { padding: 0.85rem 1.5rem; border-top: 1px solid var(--border-subtle); }

    /* Modal Premium */
    .modal-premium .modal-content { border-radius: var(--radius-md) !important; border: none !important; box-shadow: var(--shadow-lg) !important; overflow: hidden; }
    .modal-premium .modal-hero { background: var(--gradient-primary); padding: 1.35rem 1.5rem; position: relative; overflow: hidden; }
    .modal-premium .modal-hero::before { content: ''; position: absolute; top: -30px; right: -30px; width: 100px; height: 100px; border-radius: 50%; background: rgba(201,168,76,0.15); }
    .modal-premium .modal-hero-title { font-size: 0.95rem; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 0.5rem; position: relative; z-index: 1; }
    .modal-premium .modal-hero-icon { width: 34px; height: 34px; border-radius: var(--radius-sm); background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1rem; flex-shrink: 0; }
    .modal-premium .modal-body-inner { padding: 1.5rem; }
    .modal-premium .modal-footer-inner { padding: 0 1.5rem 1.25rem; display: flex; justify-content: flex-end; gap: 0.5rem; }
    .fi-label-form { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-bottom: 0.4rem; display: block; }
    .fi-input-lg { width: 100%; background: var(--bg-app); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 0.65rem 1rem; font-size: 0.9rem; font-weight: 500; color: var(--text-primary); transition: border-color 0.15s, box-shadow 0.15s; outline: none; appearance: auto; }
    .fi-input-lg:focus { border-color: var(--brand-primary); box-shadow: 0 0 0 3px rgba(27,61,47,0.08); background: var(--surface); }
    .fi-input-prefix { display: flex; align-items: center; background: var(--bg-app); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); overflow: hidden; }
    .fi-input-prefix:focus-within { border-color: var(--brand-primary); box-shadow: 0 0 0 3px rgba(27,61,47,0.08); }
    .fi-input-prefix-text { padding: 0 0.85rem; color: var(--text-tertiary); font-size: 0.84rem; font-weight: 600; border-right: 1px solid var(--border-subtle); height: 100%; display: flex; align-items: center; background: transparent; white-space: nowrap; }
    .fi-input-prefix input { border: none; background: transparent; padding: 0.65rem 1rem; font-size: 0.9rem; font-weight: 500; color: var(--text-primary); outline: none; flex: 1; width: 100%; }
    .recurring-box { background: var(--bg-app); border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); padding: 1rem; }
    .tanggungan-box { background: rgba(249,115,22,0.04); border-radius: var(--radius-sm); border: 1px solid rgba(249,115,22,0.15); padding: 1rem; }
    .btn-submit { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.84rem; font-weight: 700; background: var(--gradient-primary); color: #fff; border: none; border-radius: var(--radius-sm); padding: 0.6rem 1.4rem; cursor: pointer; box-shadow: var(--shadow-glow-primary); transition: opacity 0.15s; }
    .btn-submit:hover { opacity: 0.88; }
    .btn-cancel-modal { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.84rem; font-weight: 600; background: var(--bg-app); color: var(--text-secondary); border: 1px solid var(--border-subtle); border-radius: var(--radius-sm); padding: 0.6rem 1.2rem; cursor: pointer; transition: background 0.15s; }
    .btn-cancel-modal:hover { background: #e2e5ea; color: var(--text-primary); }
</style>

<div class="container-fluid px-0 animate-in">

    <!-- ===== HERO ===== -->
    <div class="page-hero mb-4">
        <div class="page-hero-content d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <div class="page-hero-badge"><i class="bi bi-arrow-left-right"></i> Keuangan</div>
                <h1 class="page-hero-title">Manajemen Transaksi</h1>
                <p class="page-hero-subtitle">Kelola dan pantau semua transaksi masuk dan keluar</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('export.excel.all', request()->query()) }}" class="btn-hero-excel">
                    <i class="bi bi-file-earmark-excel-fill"></i> Excel
                </a>
                <a href="{{ route('export.pdf.all', request()->query()) }}" class="btn-hero-pdf">
                    <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                </a>
                @role('pengelola')
                <button type="button" class="btn-hero-add" data-bs-toggle="modal" data-bs-target="#createTransactionModal">
                    <i class="bi bi-plus-lg"></i> Transaksi Baru
                </button>
                @endrole
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

    <!-- ===== METRIC CARDS ===== -->
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
                <span class="metric-label">Bagian Pengelola</span>
                <div class="metric-icon manager"><i class="bi bi-person-badge-fill"></i></div>
            </div>
            <div class="metric-value {{ $bagianPengelola < 0 ? 'neg' : '' }}">Rp {{ number_format($bagianPengelola, 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-label">Bagian Pemilik</span>
                <div class="metric-icon owner"><i class="bi bi-person-fill"></i></div>
            </div>
            <div class="metric-value {{ $bagianPemilik < 0 ? 'neg' : '' }}">Rp {{ number_format($bagianPemilik, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- ===== FILTER ===== -->
    <div class="filter-card">
        <div class="filter-card-title"><i class="bi bi-funnel-fill"></i> Filter Transaksi</div>
        <form action="{{ route('transactions.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                @unlessrole('pemilik')
                <div class="col-md-3">
                    <label class="fi-label" for="villa_id">Filter Villa</label>
                    <select name="villa_id" id="villa_id" class="fi-input">
                        <option value="">Semua Villa</option>
                        @foreach($villas as $villa)
                            <option value="{{ $villa->id }}" {{ request('villa_id') == $villa->id ? 'selected' : '' }}>{{ $villa->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endunlessrole
                <div class="{{ auth()->user()->hasRole('pemilik') ? 'col-md-4' : 'col-md-3' }}">
                    <label class="fi-label" for="start_date">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" class="fi-input" value="{{ request('start_date') }}">
                </div>
                <div class="{{ auth()->user()->hasRole('pemilik') ? 'col-md-4' : 'col-md-3' }}">
                    <label class="fi-label" for="end_date">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" class="fi-input" value="{{ request('end_date') }}">
                </div>
                <div class="{{ auth()->user()->hasRole('pemilik') ? 'col-md-4' : 'col-md-3' }} d-flex gap-2">
                    <button type="submit" class="btn-filter flex-grow-1"><i class="bi bi-search"></i> Terapkan</button>
                    <a href="{{ route('transactions.index') }}" class="btn-reset flex-grow-1"><i class="bi bi-x-lg"></i> Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- ===== TRANSACTION TABLE CARD ===== -->
    <div class="trx-table-card">
        <div class="trx-card-header">
            <div class="trx-card-header-top">
                <span class="trx-card-title">Riwayat Transaksi</span>
            </div>
            <ul class="trx-tabs nav" id="transactionIndexTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="trx-tab-btn {{ request('tab', 'income') === 'income' ? 'active' : '' }}" id="index-income-tab" data-bs-toggle="tab" data-bs-target="#index-income-pane" data-tab-name="income" type="button" role="tab">
                        <i class="bi bi-arrow-up-circle me-1"></i> Pemasukan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="trx-tab-btn {{ request('tab') === 'expense' ? 'active' : '' }}" id="index-expense-tab" data-bs-toggle="tab" data-bs-target="#index-expense-pane" data-tab-name="expense" type="button" role="tab">
                        <i class="bi bi-arrow-down-circle me-1"></i> Pengeluaran
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="trx-tab-btn {{ request('tab') === 'owner' ? 'active' : '' }}" id="index-owner-tab" data-bs-toggle="tab" data-bs-target="#index-owner-pane" data-tab-name="owner" type="button" role="tab">
                        <i class="bi bi-person-exclamation me-1"></i> Tanggungan Pemilik
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="transactionIndexTabsContent">

            <!-- INCOME PANE -->
            <div class="tab-pane fade {{ request('tab', 'income') === 'income' ? 'show active' : '' }}" id="index-income-pane" role="tabpanel" tabindex="0">
                <div class="table-responsive">
                    <table class="trx-table">
                        <thead>
                            <tr>
                                <th>Detail Transaksi</th>
                                <th>Tanggal</th>
                                <th>Villa</th>
                                <th class="text-end">Jumlah (Rp)</th>
                                @role('pengelola')<th class="text-end">Aksi</th>@endrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($incomeTransactions as $transaction)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="trx-icon-wrap income"><i class="bi bi-arrow-up-right"></i></div>
                                            <div>
                                                <div class="trx-name">{{ $transaction->name }}</div>
                                                <div class="trx-id">#{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }} · Pemasukan Villa</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-main">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</div>
                                        <div class="date-rel">{{ \Carbon\Carbon::parse($transaction->date)->diffForHumans() }}</div>
                                    </td>
                                    <td><div class="villa-chip"><i class="bi bi-house-door-fill"></i> {{ $transaction->villa->name }}</div></td>
                                    <td class="amount-cell"><span class="amount-value income">+Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span></td>
                                    @role('pengelola')
                                    <td>
                                        <div class="action-btn-group">
                                            <button type="button" class="action-btn edit edit-transaction"
                                                    data-bs-toggle="modal" data-bs-target="#editTransactionModal"
                                                    data-id="{{ $transaction->id }}" data-villa="{{ $transaction->villa_id }}"
                                                    data-name="{{ $transaction->name }}" data-amount="{{ $transaction->amount }}"
                                                    data-type="{{ $transaction->type }}" data-date="{{ $transaction->date }}"
                                                    data-tanggungan="{{ $transaction->is_tanggungan_pemilik ? '1' : '0' }}" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                    @endrole
                                </tr>
                            @empty
                                <tr><td colspan="{{ auth()->user()->hasRole('pengelola') ? '5' : '4' }}">
                                    <div class="empty-table-state">
                                        <div class="empty-table-icon"><i class="bi bi-arrow-up-circle"></i></div>
                                        <div class="empty-table-title">Belum Ada Pemasukan</div>
                                        <div class="empty-table-subtitle">Transaksi pemasukan akan muncul di sini.</div>
                                    </div>
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($incomeTransactions->hasPages())
                    <div class="pagination-fi">{{ $incomeTransactions->withQueryString()->links() }}</div>
                @endif
            </div>

            <!-- EXPENSE PANE -->
            <div class="tab-pane fade {{ request('tab') === 'expense' ? 'show active' : '' }}" id="index-expense-pane" role="tabpanel" tabindex="0">
                <div class="table-responsive">
                    <table class="trx-table">
                        <thead>
                            <tr>
                                <th>Detail Transaksi</th>
                                <th>Tanggal</th>
                                <th>Villa</th>
                                <th class="text-end">Jumlah (Rp)</th>
                                @role('pengelola')<th class="text-end">Aksi</th>@endrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenseTransactions as $transaction)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="trx-icon-wrap expense"><i class="bi bi-arrow-down-left"></i></div>
                                            <div>
                                                <div class="trx-name">{{ $transaction->name }}</div>
                                                <div class="trx-id">#{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }} · Pengeluaran Operasional</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-main">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</div>
                                        <div class="date-rel">{{ \Carbon\Carbon::parse($transaction->date)->diffForHumans() }}</div>
                                    </td>
                                    <td><div class="villa-chip"><i class="bi bi-house-door-fill"></i> {{ $transaction->villa->name }}</div></td>
                                    <td class="amount-cell"><span class="amount-value expense">-Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span></td>
                                    @role('pengelola')
                                    <td>
                                        <div class="action-btn-group">
                                            <button type="button" class="action-btn edit edit-transaction"
                                                    data-bs-toggle="modal" data-bs-target="#editTransactionModal"
                                                    data-id="{{ $transaction->id }}" data-villa="{{ $transaction->villa_id }}"
                                                    data-name="{{ $transaction->name }}" data-amount="{{ $transaction->amount }}"
                                                    data-type="{{ $transaction->type }}" data-date="{{ $transaction->date }}"
                                                    data-tanggungan="{{ $transaction->is_tanggungan_pemilik ? '1' : '0' }}" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                    @endrole
                                </tr>
                            @empty
                                <tr><td colspan="{{ auth()->user()->hasRole('pengelola') ? '5' : '4' }}">
                                    <div class="empty-table-state">
                                        <div class="empty-table-icon"><i class="bi bi-arrow-down-circle"></i></div>
                                        <div class="empty-table-title">Belum Ada Pengeluaran</div>
                                        <div class="empty-table-subtitle">Transaksi pengeluaran akan muncul di sini.</div>
                                    </div>
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($expenseTransactions->hasPages())
                    <div class="pagination-fi">{{ $expenseTransactions->withQueryString()->links() }}</div>
                @endif
            </div>

            <!-- OWNER PANE -->
            <div class="tab-pane fade {{ request('tab') === 'owner' ? 'show active' : '' }}" id="index-owner-pane" role="tabpanel" tabindex="0">
                <div class="table-responsive">
                    <table class="trx-table">
                        <thead>
                            <tr>
                                <th>Detail Transaksi</th>
                                <th>Tanggal</th>
                                <th>Villa</th>
                                <th class="text-end">Jumlah (Rp)</th>
                                @role('pengelola')<th class="text-end">Aksi</th>@endrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ownerTransactions as $transaction)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="trx-icon-wrap owner"><i class="bi bi-person-exclamation"></i></div>
                                            <div>
                                                <div class="trx-name">{{ $transaction->name }}</div>
                                                <div class="trx-id">#{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }} · Tanggungan Pemilik</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-main">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</div>
                                        <div class="date-rel">{{ \Carbon\Carbon::parse($transaction->date)->diffForHumans() }}</div>
                                    </td>
                                    <td><div class="villa-chip"><i class="bi bi-house-door-fill"></i> {{ $transaction->villa->name }}</div></td>
                                    <td class="amount-cell"><span class="amount-value owner">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span></td>
                                    @role('pengelola')
                                    <td>
                                        <div class="action-btn-group">
                                            <button type="button" class="action-btn edit edit-transaction"
                                                    data-bs-toggle="modal" data-bs-target="#editTransactionModal"
                                                    data-id="{{ $transaction->id }}" data-villa="{{ $transaction->villa_id }}"
                                                    data-name="{{ $transaction->name }}" data-amount="{{ $transaction->amount }}"
                                                    data-type="{{ $transaction->type }}" data-date="{{ $transaction->date }}"
                                                    data-tanggungan="{{ $transaction->is_tanggungan_pemilik ? '1' : '0' }}" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                    @endrole
                                </tr>
                            @empty
                                <tr><td colspan="{{ auth()->user()->hasRole('pengelola') ? '5' : '4' }}">
                                    <div class="empty-table-state">
                                        <div class="empty-table-icon"><i class="bi bi-person-exclamation"></i></div>
                                        <div class="empty-table-title">Belum Ada Tanggungan Pemilik</div>
                                        <div class="empty-table-subtitle">Data tanggungan pemilik akan muncul di sini.</div>
                                    </div>
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($ownerTransactions->hasPages())
                    <div class="pagination-fi">{{ $ownerTransactions->withQueryString()->links() }}</div>
                @endif
            </div>

        </div>
    </div>
</div>

<!-- ===== MODAL CREATE ===== -->
<div class="modal fade modal-premium" id="createTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-hero d-flex align-items-center justify-content-between">
                <div class="modal-hero-title">
                    <div class="modal-hero-icon"><i class="bi bi-plus-lg"></i></div>
                    Tambah Transaksi Baru
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('transactions.store') }}">
                @csrf
                <div class="modal-body-inner">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fi-label-form">Pilih Villa <span style="color:var(--danger);">*</span></label>
                            <select name="villa_id" id="villa_id_form" class="fi-input-lg" required>
                                <option value="" disabled selected>-- Pilih Villa --</option>
                                @foreach($villas as $villa)
                                    <option value="{{ $villa->id }}">{{ $villa->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fi-label-form">Tanggal Transaksi <span style="color:var(--danger);">*</span></label>
                            <input type="date" name="date" id="date" class="fi-input-lg" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="fi-label-form">Keterangan Transaksi <span style="color:var(--danger);">*</span></label>
                            <input type="text" name="name" id="name" class="fi-input-lg" required placeholder="Cth: Pembayaran Listrik Bulan Ini">
                        </div>
                        <div class="col-md-6">
                            <label class="fi-label-form">Tipe Transaksi <span style="color:var(--danger);">*</span></label>
                            <select name="type" id="type" class="fi-input-lg" required onchange="document.getElementById('tanggungan_pemilik_wrapper').style.display = this.value === 'expense' ? 'block' : 'none'">
                                <option value="income">Pemasukan (Income)</option>
                                <option value="expense">Pengeluaran (Expense)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fi-label-form">Jumlah (Rp) <span style="color:var(--danger);">*</span></label>
                            <div class="fi-input-prefix">
                                <span class="fi-input-prefix-text">Rp</span>
                                <input type="number" name="amount" id="amount" required placeholder="0">
                            </div>
                        </div>
                        <div class="col-12" id="tanggungan_pemilik_wrapper" style="display: none;">
                            <div class="tanggungan-box">
                                <div class="fi-label-form" style="margin-bottom:0.5rem;">Apakah ini Tanggungan Pemilik?</div>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_tanggungan_pemilik" id="tanggungan_no" value="0" checked>
                                        <label class="form-check-label" for="tanggungan_no" style="font-size:0.84rem;">Tidak (Dibagi sesuai persentase)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_tanggungan_pemilik" id="tanggungan_yes" value="1">
                                        <label class="form-check-label" for="tanggungan_yes" style="font-size:0.84rem;">Ya (Dipotong penuh dari pemilik)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="recurring-box mt-3">
                        <div class="form-check form-switch d-flex align-items-center gap-2 mb-0">
                            <input class="form-check-input mt-0" style="width:38px;height:20px;" type="checkbox" role="switch" id="is_recurring" name="is_recurring" value="1"
                                   onchange="document.getElementById('recurring_options').style.display = this.checked ? 'block' : 'none'">
                            <label class="form-check-label fw-bold" for="is_recurring" style="cursor:pointer;font-size:0.84rem;">Jadikan Transaksi Rutin (Recurring)</label>
                        </div>
                        <div id="recurring_options" style="display:none;" class="mt-3 pt-3 border-top">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="fi-label-form">Frekuensi</label>
                                    <select name="frequency" id="frequency" class="fi-input-lg">
                                        <option value="daily">Harian</option>
                                        <option value="monthly" selected>Bulanan</option>
                                        <option value="weekly">Mingguan</option>
                                        <option value="yearly">Tahunan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="fi-label-form">Tgl Berakhir (Opsional)</label>
                                    <input type="date" name="end_date" id="end_date_recurring" class="fi-input-lg">
                                </div>
                            </div>
                            <div class="d-flex gap-2 mt-2" style="font-size:0.75rem;color:var(--text-tertiary);">
                                <i class="bi bi-info-circle-fill mt-1"></i>
                                <span>Sistem akan mencatat transaksi ini secara otomatis setiap periode yang dipilih.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-inner">
                    <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit"><i class="bi bi-save"></i> Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Modal Edit Transaction -->
<div class="modal fade modal-premium" id="editTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-hero d-flex align-items-center justify-content-between">
                <div class="modal-hero-title">
                    <div class="modal-hero-icon"><i class="bi bi-pencil-fill"></i></div>
                    Edit Transaksi
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTransactionForm" method="POST" action="">
                @csrf @method('PUT')
                <div class="modal-body-inner">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fi-label-form">Pilih Villa <span style="color:var(--danger);">*</span></label>
                            <select name="villa_id" id="edit_villa_id" class="fi-input-lg" required>
                                @foreach($villas as $villa)
                                    <option value="{{ $villa->id }}">{{ $villa->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fi-label-form">Tanggal Transaksi <span style="color:var(--danger);">*</span></label>
                            <input type="date" name="date" id="edit_date" class="fi-input-lg" required>
                        </div>
                        <div class="col-12">
                            <label class="fi-label-form">Keterangan Transaksi <span style="color:var(--danger);">*</span></label>
                            <input type="text" name="name" id="edit_name" class="fi-input-lg" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fi-label-form">Tipe Transaksi <span style="color:var(--danger);">*</span></label>
                            <select name="type" id="edit_type" class="fi-input-lg" required onchange="toggleEditTanggungan(this.value)">
                                <option value="income">Pemasukan (Income)</option>
                                <option value="expense">Pengeluaran (Expense)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fi-label-form">Jumlah (Rp) <span style="color:var(--danger);">*</span></label>
                            <div class="fi-input-prefix">
                                <span class="fi-input-prefix-text">Rp</span>
                                <input type="number" name="amount" id="edit_amount" required>
                            </div>
                        </div>
                        <div class="col-12" id="edit_tanggungan_pemilik_wrapper" style="display: none;">
                            <div class="tanggungan-box">
                                <div class="fi-label-form" style="margin-bottom:0.5rem;">Apakah ini Tanggungan Pemilik?</div>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_tanggungan_pemilik" id="edit_tanggungan_no" value="0">
                                        <label class="form-check-label" for="edit_tanggungan_no" style="font-size:0.84rem;">Tidak (Dibagi sesuai persentase)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_tanggungan_pemilik" id="edit_tanggungan_yes" value="1">
                                        <label class="form-check-label" for="edit_tanggungan_yes" style="font-size:0.84rem;">Ya (Dipotong penuh dari pemilik)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-inner">
                    <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit"><i class="bi bi-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-transaction');
        const editForm = document.getElementById('editTransactionForm');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const villaId = this.getAttribute('data-villa');
                const name = this.getAttribute('data-name');
                const amount = this.getAttribute('data-amount');
                const type = this.getAttribute('data-type');
                const date = this.getAttribute('data-date');
                const tanggungan = this.getAttribute('data-tanggungan');

                editForm.action = `/transactions/${id}`;
                document.getElementById('edit_villa_id').value = villaId;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_amount').value = amount;
                document.getElementById('edit_type').value = type;
                document.getElementById('edit_date').value = date;

                if (type === 'expense') {
                    document.getElementById('edit_tanggungan_pemilik_wrapper').style.display = 'block';
                    if (tanggungan === '1') { document.getElementById('edit_tanggungan_yes').checked = true; }
                    else { document.getElementById('edit_tanggungan_no').checked = true; }
                } else {
                    document.getElementById('edit_tanggungan_pemilik_wrapper').style.display = 'none';
                }
            });
        });
    });

    function toggleEditTanggungan(type) {
        document.getElementById('edit_tanggungan_pemilik_wrapper').style.display = type === 'expense' ? 'block' : 'none';
    }

    window.changePerPage = function(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        url.searchParams.delete('page_income');
        url.searchParams.delete('page_expense');
        url.searchParams.delete('page_owner');
        window.location.href = url.toString();
    }
</script>

<div id="perPageSelectorTemplate" style="display: none;">
    <div id="perPageSelectorEl" class="d-flex align-items-center gap-2 mb-2">
        <label class="text-muted small fw-medium mb-0 text-nowrap">Tampilkan</label>
        <select class="form-select form-select-sm border-light bg-light rounded-3 fw-medium" style="width: auto; font-size: 0.8rem; padding-top: 0.25rem; padding-bottom: 0.25rem;" onchange="changePerPage(this.value)">
            @foreach([10, 25, 50, 100] as $size)
                <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
            @endforeach
        </select>
        <span class="text-muted small fw-medium text-nowrap">data</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('#transactionIndexTabs button[data-tab-name]');
        const selectorTemplate = document.getElementById('perPageSelectorEl');

        function attachPerPageSelector() {
            const activePane = document.querySelector('.tab-pane.active');
            if (!activePane || !selectorTemplate) return;
            const paginationNav = activePane.querySelector('.pagination-fi nav .d-sm-flex > div:first-child');
            if (paginationNav) {
                paginationNav.classList.remove('align-items-center');
                paginationNav.classList.add('d-flex', 'flex-column', 'align-items-start', 'justify-content-center');
                const pTag = paginationNav.querySelector('p');
                if (pTag) { pTag.style.display = 'none'; paginationNav.insertBefore(selectorTemplate, pTag); }
                else { paginationNav.appendChild(selectorTemplate); }
            }
        }

        attachPerPageSelector();

        tabButtons.forEach(function(btn) {
            btn.addEventListener('shown.bs.tab', function() {
                const tabName = this.getAttribute('data-tab-name');
                const url = new URL(window.location.href);
                url.searchParams.set('tab', tabName);
                history.replaceState(null, '', url.toString());
                document.querySelectorAll('.pagination a').forEach(function(link) {
                    const linkUrl = new URL(link.href);
                    linkUrl.searchParams.set('tab', tabName);
                    link.href = linkUrl.toString();
                });
                attachPerPageSelector();
            });
        });
    });
</script>
@endpush
