@extends('layouts.admin')

@section('page_title', 'Laporan Transaksi')

@section('content')
<style>
    .card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.1) !important;
    }
    .fs-7 {
        font-size: 0.85rem;
    }
    .table-custom thead th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #64748b;
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-custom tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }
    .table-custom tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.001);
    }
    .amount-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-block;
    }
    .nav-tabs .nav-link.active {
        color: var(--bs-primary) !important;
        border-bottom: 2px solid var(--bs-primary) !important;
        background: transparent;
    }
    .nav-tabs .nav-link:hover {
        color: var(--bs-primary) !important;
    }
</style>

<div class="container-fluid px-0">

    <!-- Header Actions -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="mb-0 fw-bold text-dark">Manajemen Transaksi</h4>
            <p class="text-muted mb-0 small">Kelola dan pantau semua transaksi masuk dan keluar</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('export.excel.all', request()->query()) }}" class="btn btn-success d-flex align-items-center gap-2 shadow-sm rounded-3 px-3 py-2">
                <i class="bi bi-file-earmark-excel fs-5"></i>
                <span class="fw-medium">Excel</span>
            </a>
            <a href="{{ route('export.pdf.all', request()->query()) }}" class="btn btn-danger d-flex align-items-center gap-2 shadow-sm rounded-3 px-3 py-2">
                <i class="bi bi-file-earmark-pdf fs-5"></i>
                <span class="fw-medium">PDF</span>
            </a>
            @role('pengelola')
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm rounded-3 px-3 py-2" data-bs-toggle="modal" data-bs-target="#createTransactionModal">
                <i class="bi bi-plus-lg fs-5"></i>
                <span class="fw-medium">Transaksi Baru</span>
            </button>
            @endrole
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Summary Widgets -->
    <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
        <div class="col">
            <div class="card card-hover h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Pemasukan</h6>
                            <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-circle bg-success bg-opacity-10 text-success">
                            <i class="bi bi-graph-up-arrow fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-hover h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Pengeluaran</h6>
                            <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-circle bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-graph-down-arrow fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-hover h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Bagian Pengelola</h6>
                            <h3 class="fw-bold mb-0 {{ $bagianPengelola >= 0 ? 'text-dark' : 'text-danger' }}">Rp {{ number_format($bagianPengelola, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-person-badge fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-hover h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Bagian Pemilik</h6>
                            <h3 class="fw-bold mb-0 {{ $bagianPemilik >= 0 ? 'text-dark' : 'text-danger' }}">Rp {{ number_format($bagianPemilik, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-circle bg-info bg-opacity-10 text-info">
                            <i class="bi bi-person-fill fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('transactions.index') }}" method="GET" class="row g-3 align-items-center">
                @unlessrole('pemilik')
                <div class="col-md-3">
                    <div class="form-floating">
                        <select name="villa_id" id="villa_id" class="form-select border-0 bg-light rounded-3" style="box-shadow: none;">
                            <option value="">Semua Villa</option>
                            @foreach($villas as $villa)
                                <option value="{{ $villa->id }}" {{ request('villa_id') == $villa->id ? 'selected' : '' }}>
                                    {{ $villa->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="villa_id">Filter Villa</label>
                    </div>
                </div>
                @endunlessrole

                <div class="{{ auth()->user()->hasRole('pemilik') ? 'col-md-4' : 'col-md-3' }}">
                    <div class="form-floating">
                        <input type="date" name="start_date" id="start_date" class="form-control border-0 bg-light rounded-3" style="box-shadow: none;" value="{{ request('start_date') }}">
                        <label for="start_date">Dari Tanggal</label>
                    </div>
                </div>
                <div class="{{ auth()->user()->hasRole('pemilik') ? 'col-md-4' : 'col-md-3' }}">
                    <div class="form-floating">
                        <input type="date" name="end_date" id="end_date" class="form-control border-0 bg-light rounded-3" style="box-shadow: none;" value="{{ request('end_date') }}">
                        <label for="end_date">Sampai Tanggal</label>
                    </div>
                </div>
                <div class="{{ auth()->user()->hasRole('pemilik') ? 'col-md-4' : 'col-md-3' }} d-flex gap-2">
                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center flex-grow-1 rounded-3" style="height: 58px;">
                        <i class="bi bi-search me-2"></i> Terapkan
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-light border d-flex align-items-center justify-content-center flex-grow-1 rounded-3" style="height: 58px;">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="card mt-4 border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0">Riwayat Transaksi</h5>
            </div>
            <ul class="nav nav-tabs border-0 gap-3" id="transactionIndexTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active border-0 fw-semibold px-0 text-muted transition-all" id="index-income-tab" data-bs-toggle="tab" data-bs-target="#index-income-pane" type="button" role="tab" style="font-size: 0.9rem;">Pemasukan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link border-0 fw-semibold px-0 text-muted transition-all" id="index-expense-tab" data-bs-toggle="tab" data-bs-target="#index-expense-pane" type="button" role="tab" style="font-size: 0.9rem;">Pengeluaran</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link border-0 fw-semibold px-0 text-muted transition-all" id="index-owner-tab" data-bs-toggle="tab" data-bs-target="#index-owner-pane" type="button" role="tab" style="font-size: 0.9rem;">Tanggungan Pemilik</button>
                </li>
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content" id="transactionIndexTabsContent">
                <!-- Income Pane -->
                <div class="tab-pane fade show active" id="index-income-pane" role="tabpanel" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4 py-3">Detail Transaksi</th>
                                    <th class="py-3">Tanggal</th>
                                    <th class="py-3">Villa</th>
                                    <th class="text-end py-3">Jumlah (Rp)</th>
                                    @role('pengelola')
                                    <th class="text-end pe-4 py-3">Aksi</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incomeTransactions as $transaction)
                                    <tr>
                                        <td class="ps-4 py-3 text-dark">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center p-2 me-3" style="width: 44px; height: 44px;">
                                                    <i class="bi bi-arrow-up-right fs-5"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">{{ $transaction->name }}</div>
                                                    <small class="text-muted">ID: #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }} &bull; Pemasukan Villa</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</div>
                                            <small class="text-muted small">{{ \Carbon\Carbon::parse($transaction->date)->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-white text-dark border shadow-sm px-3 py-2 fw-medium">
                                                <i class="bi bi-house-door text-primary me-1"></i> {{ $transaction->villa->name }}
                                            </span>
                                        </td>
                                        <td class="text-end {{ auth()->user()->hasRole('pengelola') ? '' : 'pe-4' }}">
                                            <div class="amount-badge bg-success bg-opacity-10 text-dark">
                                                +Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        @role('pengelola')
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-light btn-sm rounded-3 edit-transaction"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editTransactionModal"
                                                        data-id="{{ $transaction->id }}"
                                                        data-villa="{{ $transaction->villa_id }}"
                                                        data-name="{{ $transaction->name }}"
                                                        data-amount="{{ $transaction->amount }}"
                                                        data-type="{{ $transaction->type }}"
                                                        data-date="{{ $transaction->date }}"
                                                        data-tanggungan="{{ $transaction->is_tanggungan_pemilik ? '1' : '0' }}">
                                                    <i class="bi bi-pencil text-primary"></i>
                                                </button>
                                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light btn-sm rounded-3">
                                                        <i class="bi bi-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        @endrole
                                    </tr>
                                @empty
                                    <tr><td colspan="{{ auth()->user()->hasRole('pengelola') ? '5' : '4' }}" class="text-center py-5 text-muted">Belum ada pemasukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($incomeTransactions->hasPages())
                        <div class="px-4 py-3 border-top bg-light bg-opacity-50">
                            {{ $incomeTransactions->withQueryString()->links() }}
                        </div>
                    @endif
                </div>

                <!-- Expense Pane -->
                <div class="tab-pane fade" id="index-expense-pane" role="tabpanel" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4 py-3">Detail Transaksi</th>
                                    <th class="py-3">Tanggal</th>
                                    <th class="py-3">Villa</th>
                                    <th class="text-end py-3">Jumlah (Rp)</th>
                                    @role('pengelola')
                                    <th class="text-end pe-4 py-3">Aksi</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenseTransactions as $transaction)
                                    <tr>
                                        <td class="ps-4 py-3 text-dark">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center justify-content-center p-2 me-3" style="width: 44px; height: 44px;">
                                                    <i class="bi bi-arrow-down-left fs-5"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">{{ $transaction->name }}</div>
                                                    <small class="text-muted">ID: #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }} &bull; Pengeluaran Operasional</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</div>
                                            <small class="text-muted small">{{ \Carbon\Carbon::parse($transaction->date)->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-white text-dark border shadow-sm px-3 py-2 fw-medium">
                                                <i class="bi bi-house-door text-primary me-1"></i> {{ $transaction->villa->name }}
                                            </span>
                                        </td>
                                        <td class="text-end {{ auth()->user()->hasRole('pengelola') ? '' : 'pe-4' }}">
                                            <div class="amount-badge bg-danger bg-opacity-10 text-dark">
                                                -Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        @role('pengelola')
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-light btn-sm rounded-3 edit-transaction"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editTransactionModal"
                                                        data-id="{{ $transaction->id }}"
                                                        data-villa="{{ $transaction->villa_id }}"
                                                        data-name="{{ $transaction->name }}"
                                                        data-amount="{{ $transaction->amount }}"
                                                        data-type="{{ $transaction->type }}"
                                                        data-date="{{ $transaction->date }}"
                                                        data-tanggungan="{{ $transaction->is_tanggungan_pemilik ? '1' : '0' }}">
                                                    <i class="bi bi-pencil text-primary"></i>
                                                </button>
                                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light btn-sm rounded-3">
                                                        <i class="bi bi-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        @endrole
                                    </tr>
                                @empty
                                    <tr><td colspan="{{ auth()->user()->hasRole('pengelola') ? '5' : '4' }}" class="text-center py-5 text-muted">Belum ada pengeluaran.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($expenseTransactions->hasPages())
                        <div class="px-4 py-3 border-top bg-light bg-opacity-50">
                            {{ $expenseTransactions->withQueryString()->links() }}
                        </div>
                    @endif
                </div>

                <!-- Owner Expense Pane -->
                <div class="tab-pane fade" id="index-owner-pane" role="tabpanel" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4 py-3">Detail Transaksi</th>
                                    <th class="py-3">Tanggal</th>
                                    <th class="py-3">Villa</th>
                                    <th class="text-end py-3">Jumlah (Rp)</th>
                                    @role('pengelola')
                                    <th class="text-end pe-4 py-3">Aksi</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ownerTransactions as $transaction)
                                    <tr>
                                        <td class="ps-4 py-3 text-dark">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center p-2 me-3" style="width: 44px; height: 44px;">
                                                    <i class="bi bi-person-exclamation fs-5"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">{{ $transaction->name }}</div>
                                                    <small class="text-muted">ID: #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }} &bull; Tanggungan Pemilik</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</div>
                                            <small class="text-muted small">{{ \Carbon\Carbon::parse($transaction->date)->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-white text-dark border shadow-sm px-3 py-2 fw-medium">
                                                <i class="bi bi-house-door text-primary me-1"></i> {{ $transaction->villa->name }}
                                            </span>
                                        </td>
                                        <td class="text-end {{ auth()->user()->hasRole('pengelola') ? '' : 'pe-4' }}">
                                            <div class="amount-badge bg-warning bg-opacity-10 text-dark">
                                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        @role('pengelola')
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-light btn-sm rounded-3 edit-transaction"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editTransactionModal"
                                                        data-id="{{ $transaction->id }}"
                                                        data-villa="{{ $transaction->villa_id }}"
                                                        data-name="{{ $transaction->name }}"
                                                        data-amount="{{ $transaction->amount }}"
                                                        data-type="{{ $transaction->type }}"
                                                        data-date="{{ $transaction->date }}"
                                                        data-tanggungan="{{ $transaction->is_tanggungan_pemilik ? '1' : '0' }}">
                                                    <i class="bi bi-pencil text-primary"></i>
                                                </button>
                                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light btn-sm rounded-3">
                                                        <i class="bi bi-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        @endrole
                                    </tr>
                                @empty
                                    <tr><td colspan="{{ auth()->user()->hasRole('pengelola') ? '5' : '4' }}" class="text-center py-5 text-muted">Belum ada tanggungan pemilik.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($ownerTransactions->hasPages())
                        <div class="px-4 py-3 border-top bg-light bg-opacity-50">
                            {{ $ownerTransactions->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Transaction -->
<div class="modal fade" id="createTransactionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-bottom-0 p-4 pb-3">
        <div>
            <h5 class="modal-title fw-bold text-dark mb-1">Tambah Transaksi Baru</h5>
            <p class="text-muted small mb-0">Catat pemasukan atau pengeluaran untuk villa.</p>
        </div>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('transactions.store') }}">
          @csrf
          <div class="modal-body p-4 pt-2">

              <div class="row g-4">
                  <div class="col-md-6">
                      <label for="villa_id_form" class="form-label fw-medium text-dark small">Pilih Villa</label>
                      <select name="villa_id" id="villa_id_form" class="form-select form-select-lg border-light bg-light rounded-3" required style="font-size: 1rem;">
                          <option value="" selected disabled>-- Pilih Villa --</option>
                          @foreach($villas as $villa)
                              <option value="{{ $villa->id }}">{{ $villa->name }}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="col-md-6">
                      <label for="date" class="form-label fw-medium text-dark small">Tanggal Transaksi</label>
                      <input type="date" name="date" id="date" class="form-control form-control-lg border-light bg-light rounded-3" value="{{ date('Y-m-d') }}" required style="font-size: 1rem;">
                  </div>

                  <div class="col-12">
                      <label for="name" class="form-label fw-medium text-dark small">Keterangan Transaksi</label>
                      <input type="text" name="name" id="name" class="form-control form-control-lg border-light bg-light rounded-3" required placeholder="Cth: Pembayaran Listrik Bulan Ini" style="font-size: 1rem;">
                  </div>

                  <div class="col-md-6">
                      <label for="type" class="form-label fw-medium text-dark small">Tipe Transaksi</label>
                      <select name="type" id="type" class="form-select form-select-lg border-light bg-light rounded-3" required style="font-size: 1rem;" onchange="document.getElementById('tanggungan_pemilik_wrapper').style.display = this.value === 'expense' ? 'block' : 'none'">
                          <option value="income">Pemasukan (Income)</option>
                          <option value="expense">Pengeluaran (Expense)</option>
                      </select>
                  </div>

                  <div class="col-md-6">
                      <label for="amount" class="form-label fw-medium text-dark small">Jumlah Rupiah (Rp)</label>
                      <div class="input-group input-group-lg">
                          <span class="input-group-text border-light bg-light rounded-start-3 border-end-0 text-muted" style="font-size: 1rem;">Rp</span>
                          <input type="number" name="amount" id="amount" class="form-control border-light bg-light rounded-end-3 border-start-0" required placeholder="0" style="font-size: 1rem;">
                      </div>
                  </div>

                  <div class="col-md-12" id="tanggungan_pemilik_wrapper" style="display: none;">
                      <div class="p-3 bg-light rounded-3 border border-light">
                          <label class="form-label fw-bold text-dark small d-block mb-2">Apakah ini Tanggungan Pemilik?</label>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="is_tanggungan_pemilik" id="tanggungan_no" value="0" checked>
                              <label class="form-check-label text-dark" for="tanggungan_no">Tidak (Dibagi sesuai persentase villa)</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="is_tanggungan_pemilik" id="tanggungan_yes" value="1">
                              <label class="form-check-label text-dark" for="tanggungan_yes">Ya (Dipotong penuh dari bagian Pemilik)</label>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="mt-4 p-4 bg-light rounded-4 border border-light">
                  <div class="form-check form-switch mb-0 d-flex align-items-center gap-2">
                      <input class="form-check-input mt-0 fs-5" type="checkbox" role="switch" id="is_recurring" name="is_recurring" value="1" onchange="document.getElementById('recurring_options').style.display = this.checked ? 'block' : 'none'">
                      <label class="form-check-label fw-bold text-dark w-100" for="is_recurring" style="cursor: pointer; padding-top: 2px;">
                          Jadikan Transaksi Rutin (Recurring)
                      </label>
                  </div>
                  <div id="recurring_options" style="display: none;" class="mt-4 pt-4 border-top">
                      <div class="row g-3">
                          <div class="col-md-6">
                              <label for="frequency" class="form-label fw-medium text-dark small">Frekuensi</label>
                              <select name="frequency" id="frequency" class="form-select border-0 rounded-3 shadow-none">
                                  <option value="daily">Harian</option>
                                  <option value="monthly" selected>Bulanan</option>
                                  <option value="weekly">Mingguan</option>
                                  <option value="yearly">Tahunan</option>
                              </select>
                          </div>
                          <div class="col-md-6">
                              <label for="end_date_recurring" class="form-label fw-medium text-dark small">Tgl Berakhir (Opsional)</label>
                              <input type="date" name="end_date" id="end_date_recurring" class="form-control border-0 rounded-3 shadow-none" placeholder="Kosongkan jika selamanya">
                          </div>
                      </div>
                      <div class="d-flex align-items-start gap-2 mt-3 text-muted small">
                          <i class="bi bi-info-circle-fill pt-1"></i>
                          <span>Sistem akan mencatat transaksi ini secara otomatis setiap periode yang dipilih sampai tanggal berakhir yang ditentukan.</span>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer border-top-0 p-4 pt-2">
            <button type="button" class="btn btn-light px-4 py-2 rounded-3 fw-medium" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-medium d-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-save"></i> Simpan Transaksi
            </button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<!-- Modal Edit Transaction -->
<div class="modal fade" id="editTransactionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-bottom-0 p-4 pb-3">
        <div>
            <h5 class="modal-title fw-bold text-dark mb-1">Edit Transaksi</h5>
            <p class="text-muted small mb-0">Perbarui detail transaksi villa.</p>
        </div>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editTransactionForm" method="POST" action="">
          @csrf
          @method('PUT')
          <div class="modal-body p-4 pt-2">

              <div class="row g-4">
                  <div class="col-md-6">
                      <label for="edit_villa_id" class="form-label fw-medium text-dark small">Pilih Villa</label>
                      <select name="villa_id" id="edit_villa_id" class="form-select form-select-lg border-light bg-light rounded-3" required style="font-size: 1rem;">
                          @foreach($villas as $villa)
                              <option value="{{ $villa->id }}">{{ $villa->name }}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="col-md-6">
                      <label for="edit_date" class="form-label fw-medium text-dark small">Tanggal Transaksi</label>
                      <input type="date" name="date" id="edit_date" class="form-control form-control-lg border-light bg-light rounded-3" required style="font-size: 1rem;">
                  </div>

                  <div class="col-12">
                      <label for="edit_name" class="form-label fw-medium text-dark small">Keterangan Transaksi</label>
                      <input type="text" name="name" id="edit_name" class="form-control form-control-lg border-light bg-light rounded-3" required style="font-size: 1rem;">
                  </div>

                  <div class="col-md-6">
                      <label for="edit_type" class="form-label fw-medium text-dark small">Tipe Transaksi</label>
                      <select name="type" id="edit_type" class="form-select form-select-lg border-light bg-light rounded-3" required style="font-size: 1rem;" onchange="toggleEditTanggungan(this.value)">
                          <option value="income">Pemasukan (Income)</option>
                          <option value="expense">Pengeluaran (Expense)</option>
                      </select>
                  </div>

                  <div class="col-md-6">
                      <label for="edit_amount" class="form-label fw-medium text-dark small">Jumlah Rupiah (Rp)</label>
                      <div class="input-group input-group-lg">
                          <span class="input-group-text border-light bg-light rounded-start-3 border-end-0 text-muted" style="font-size: 1rem;">Rp</span>
                          <input type="number" name="amount" id="edit_amount" class="form-control border-light bg-light rounded-end-3 border-start-0" required style="font-size: 1rem;">
                      </div>
                  </div>

                  <div class="col-md-12" id="edit_tanggungan_pemilik_wrapper" style="display: none;">
                      <div class="p-3 bg-light rounded-3 border border-light">
                          <label class="form-label fw-bold text-dark small d-block mb-2">Apakah ini Tanggungan Pemilik?</label>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="is_tanggungan_pemilik" id="edit_tanggungan_no" value="0">
                              <label class="form-check-label text-dark" for="edit_tanggungan_no">Tidak (Dibagi sesuai persentase villa)</label>
                          </div>
                          <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="is_tanggungan_pemilik" id="edit_tanggungan_yes" value="1">
                              <label class="form-check-label text-dark" for="edit_tanggungan_yes">Ya (Dipotong penuh dari bagian Pemilik)</label>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer border-top-0 p-4 pt-2">
            <button type="button" class="btn btn-light px-4 py-2 rounded-3 fw-medium" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-medium d-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-save"></i> Simpan Perubahan
            </button>
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
                    if (tanggungan === '1') {
                        document.getElementById('edit_tanggungan_yes').checked = true;
                    } else {
                        document.getElementById('edit_tanggungan_no').checked = true;
                    }
                } else {
                    document.getElementById('edit_tanggungan_pemilik_wrapper').style.display = 'none';
                }
            });
        });
    });

    function toggleEditTanggungan(type) {
        document.getElementById('edit_tanggungan_pemilik_wrapper').style.display = type === 'expense' ? 'block' : 'none';
    }
</script>
@endpush
