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
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
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
                            <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Saldo Akhir</h6>
                            <h3 class="fw-bold mb-0 {{ $balance >= 0 ? 'text-primary' : 'text-danger' }}">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
                        </div>
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-wallet2 fs-4"></i>
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
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="date" name="start_date" id="start_date" class="form-control border-0 bg-light rounded-3" style="box-shadow: none;" value="{{ request('start_date') }}">
                        <label for="start_date">Dari Tanggal</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="date" name="end_date" id="end_date" class="form-control border-0 bg-light rounded-3" style="box-shadow: none;" value="{{ request('end_date') }}">
                        <label for="end_date">Sampai Tanggal</label>
                    </div>
                </div>
                <div class="col-md-3 d-flex gap-2">
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
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center border-0 pt-4 pb-3 px-4 bg-white" style="border-bottom: 1px solid rgba(0,0,0,.125) !important;">
            <span class="fs-5 fw-bold text-dark">Riwayat Transaksi Terbaru</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Detail Transaksi</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Villa</th>
                        <th class="py-3">Tipe</th>
                        <th class="text-end pe-4 py-3">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td class="ps-4 py-3 text-dark">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        @if($transaction->type == 'income')
                                            <i class="bi bi-arrow-down-left fs-5"></i>
                                        @else
                                            <i class="bi bi-arrow-up-right fs-5"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $transaction->name }}</div>
                                        <small class="text-muted">Keterangan Transaksi</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark fw-medium">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($transaction->date)->diffForHumans() }}</small>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-light text-dark border px-2 py-1 fw-medium" style="font-size: 0.75rem;">
                                    <i class="bi bi-house-door me-1"></i> {{ $transaction->villa->name }}
                                </span>
                            </td>
                            <td>
                                @if($transaction->type == 'income')
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-50 px-2 py-1 fw-medium" style="font-size: 0.75rem;">
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-50 px-2 py-1 fw-medium" style="font-size: 0.75rem;">
                                        Pengeluaran
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4 fw-bold {{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $transactions->withQueryString()->links() }}
        </div>
        @endif
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
                      <select name="type" id="type" class="form-select form-select-lg border-light bg-light rounded-3" required style="font-size: 1rem;">
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
