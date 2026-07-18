@extends('layouts.admin')

@section('page_title', 'Laporan Transaksi')

@section('content')
<div class="container-fluid px-0">

    <!-- Header Actions -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div class="page-header-fi">
            <h4>Manajemen Transaksi</h4>
            <p>Kelola dan pantau semua transaksi masuk dan keluar</p>
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
        <div class="alert alert-success alert-fi alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Summary Widgets -->
    <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
        <div class="col">
            <div class="card card-fi card-hover h-100">
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
    <div class="card card-fi mb-4">
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
    <div class="card card-fi mt-4 overflow-hidden">
        <div class="card-header pt-4 px-4 pb-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0">Riwayat Transaksi</h5>
            </div>
            <ul class="nav nav-tabs nav-tabs-fi border-0 gap-3" id="transactionIndexTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('tab', 'income') === 'income' ? 'active' : '' }} border-0 fw-semibold px-0 text-muted transition-all" id="index-income-tab" data-bs-toggle="tab" data-bs-target="#index-income-pane" data-tab-name="income" type="button" role="tab" style="font-size: 0.9rem;">Pemasukan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('tab') === 'expense' ? 'active' : '' }} border-0 fw-semibold px-0 text-muted transition-all" id="index-expense-tab" data-bs-toggle="tab" data-bs-target="#index-expense-pane" data-tab-name="expense" type="button" role="tab" style="font-size: 0.9rem;">Pengeluaran</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ request('tab') === 'owner' ? 'active' : '' }} border-0 fw-semibold px-0 text-muted transition-all" id="index-owner-tab" data-bs-toggle="tab" data-bs-target="#index-owner-pane" data-tab-name="owner" type="button" role="tab" style="font-size: 0.9rem;">Tanggungan Pemilik</button>
                </li>
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content" id="transactionIndexTabsContent">
                <!-- Income Pane -->
                <div class="tab-pane fade {{ request('tab', 'income') === 'income' ? 'show active' : '' }}" id="index-income-pane" role="tabpanel" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-fi mb-0 align-middle">
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
                                    <tr><td colspan="{{ auth()->user()->hasRole('pengelola') ? '5' : '4' }}" class="empty-state"><i class="bi bi-inbox d-block"></i>Belum ada pemasukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($incomeTransactions->hasPages())
                        <div class="pagination-fi">
                            {{ $incomeTransactions->withQueryString()->links() }}
                        </div>
                    @endif
                </div>

                <!-- Expense Pane -->
                <div class="tab-pane fade {{ request('tab') === 'expense' ? 'show active' : '' }}" id="index-expense-pane" role="tabpanel" tabindex="0">
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
                                    <tr><td colspan="{{ auth()->user()->hasRole('pengelola') ? '5' : '4' }}" class="empty-state"><i class="bi bi-inbox d-block"></i>Belum ada pengeluaran.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($expenseTransactions->hasPages())
                        <div class="pagination-fi">
                            {{ $expenseTransactions->withQueryString()->links() }}
                        </div>
                    @endif
                </div>

                <!-- Owner Expense Pane -->
                <div class="tab-pane fade {{ request('tab') === 'owner' ? 'show active' : '' }}" id="index-owner-pane" role="tabpanel" tabindex="0">
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
                                    <tr><td colspan="{{ auth()->user()->hasRole('pengelola') ? '5' : '4' }}" class="empty-state"><i class="bi bi-inbox d-block"></i>Belum ada tanggungan pemilik.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($ownerTransactions->hasPages())
                        <div class="pagination-fi">
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

    // Function to handle per_page dropdown change
    window.changePerPage = function(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        // Reset all paginations to page 1 when changing size
        url.searchParams.delete('page_income');
        url.searchParams.delete('page_expense');
        url.searchParams.delete('page_owner');
        window.location.href = url.toString();
    }
</script>

<!-- Hidden template for per-page dropdown -->
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

            // Find the pagination text container "Showing 1 to N..."
            const paginationNav = activePane.querySelector('.pagination-fi nav .d-sm-flex > div:first-child');
            if (paginationNav) {
                // Remove flex-row classes if they exist, make it a column
                paginationNav.classList.remove('align-items-center');
                paginationNav.classList.add('d-flex', 'flex-column', 'align-items-start', 'justify-content-center');

                const pTag = paginationNav.querySelector('p');

                // Hide the "Showing 1 to N of M results" text
                if (pTag) {
                    pTag.style.display = 'none';
                    paginationNav.insertBefore(selectorTemplate, pTag);
                } else {
                    paginationNav.appendChild(selectorTemplate);
                }
            }
        }

        // Attach on initial load
        attachPerPageSelector();

        tabButtons.forEach(function(btn) {
            btn.addEventListener('shown.bs.tab', function() {
                const tabName = this.getAttribute('data-tab-name');
                const url = new URL(window.location.href);
                url.searchParams.set('tab', tabName);
                history.replaceState(null, '', url.toString());

                // Update all pagination links to include the tab parameter
                document.querySelectorAll('.pagination a').forEach(function(link) {
                    const linkUrl = new URL(link.href);
                    linkUrl.searchParams.set('tab', tabName);
                    link.href = linkUrl.toString();
                });

                // Re-attach selector to new active tab
                attachPerPageSelector();
            });
        });
    });
</script>
@endpush
