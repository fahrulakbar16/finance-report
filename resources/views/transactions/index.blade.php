@extends('layouts.admin')

@section('page_title', 'Laporan Transaksi')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: var(--fi-radius);">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="d-flex justify-content-end mb-3 gap-2">
    <a href="{{ route('export.excel.all', request()->query()) }}" class="btn btn-sm btn-success py-2 px-3 fw-medium shadow-sm" style="border-radius: 0.5rem;">
        <i class="bi bi-file-earmark-excel me-1"></i> Download Excel
    </a>
    <a href="{{ route('export.pdf.all', request()->query()) }}" class="btn btn-sm btn-danger py-2 px-3 fw-medium shadow-sm" style="border-radius: 0.5rem;">
        <i class="bi bi-file-earmark-pdf me-1"></i> Download PDF
    </a>
</div>

<!-- Filter Bar -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: var(--fi-radius);">
    <div class="card-body p-4">
        <form action="{{ route('transactions.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="villa_id" class="form-label fw-medium text-dark small">Villa</label>
                <select name="villa_id" id="villa_id" class="form-select border-light bg-light" style="border-radius: 0.5rem;">
                    <option value="">Semua Villa</option>
                    @foreach($villas as $villa)
                        <option value="{{ $villa->id }}" {{ request('villa_id') == $villa->id ? 'selected' : '' }}>
                            {{ $villa->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="start_date" class="form-label fw-medium text-dark small">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" class="form-control border-light bg-light" style="border-radius: 0.5rem;" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label fw-medium text-dark small">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" class="form-control border-light bg-light" style="border-radius: 0.5rem;" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 py-2" style="border-radius: 0.5rem;">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <a href="{{ route('transactions.index') }}" class="btn btn-light border w-100 py-2" style="border-radius: 0.5rem;">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Summary Widgets -->
<div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
    <div class="col">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: var(--fi-radius);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Total Pemasukan</h6>
                    <div class="text-success bg-success bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: var(--fi-radius);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Total Pengeluaran</h6>
                    <div class="text-danger bg-danger bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-graph-down-arrow fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: var(--fi-radius);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Saldo Akhir</h6>
                    <div class="text-primary bg-primary bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-wallet2 fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 {{ $balance >= 0 ? 'text-dark' : 'text-danger' }}">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="card border-0 shadow-sm" style="border-radius: var(--fi-radius);">
    <div class="card-header d-flex justify-content-between align-items-center border-0 pt-4 pb-3 px-4 bg-transparent">
        <span class="fs-5 fw-bold text-dark">Riwayat Transaksi</span>
        @role('pengelola')
            <button type="button" class="btn btn-sm btn-primary py-2 px-3" data-bs-toggle="modal" data-bs-target="#createTransactionModal">
                <i class="bi bi-plus-lg me-1"></i> Transaksi Baru
            </button>
        @endrole
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-muted fw-bold small text-uppercase" style="letter-spacing: 0.05em;">Tanggal</th>
                    <th class="py-3 text-muted fw-bold small text-uppercase" style="letter-spacing: 0.05em;">Villa</th>
                    <th class="py-3 text-muted fw-bold small text-uppercase" style="letter-spacing: 0.05em;">Keterangan</th>
                    <th class="py-3 text-muted fw-bold small text-uppercase" style="letter-spacing: 0.05em;">Tipe</th>
                    <th class="text-end pe-4 py-3 text-muted fw-bold small text-uppercase" style="letter-spacing: 0.05em;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td class="ps-4 text-muted small">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</td>
                        <td>
                            <span class="badge rounded-pill bg-light text-dark border px-2 py-1 fw-medium" style="font-size: 0.7rem;">
                                {{ $transaction->villa->name }}
                            </span>
                        </td>
                        <td class="fw-medium text-dark">{{ $transaction->name }}</td>
                        <td>
                            @if($transaction->type == 'income')
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 fw-medium" style="font-size: 0.75rem;">Income</span>
                            @else
                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 fw-medium" style="font-size: 0.75rem;">Expense</span>
                            @endif
                        </td>
                        <td class="text-end pe-4 fw-bold text-dark">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Tidak ada transaksi ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
        <div class="card-footer bg-transparent border-top py-3 px-4">
            {{ $transactions->withQueryString()->links() }}
        </div>
    @endif
</div>

<!-- Modal Create Transaction -->
<div class="modal fade" id="createTransactionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow" style="border-radius: var(--fi-radius);">
      <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
        <h5 class="modal-title fw-bold">Tambah Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('transactions.store') }}">
          @csrf
          <div class="modal-body px-4 pt-4 pb-2">
              <div class="mb-3">
                  <label for="villa_id_form" class="form-label fw-medium text-dark small">Villa</label>
                  <select name="villa_id" id="villa_id_form" class="form-select" required>
                      <option value="" selected disabled>Pilih Villa</option>
                      @foreach($villas as $villa)
                          <option value="{{ $villa->id }}">{{ $villa->name }}</option>
                      @endforeach
                  </select>
              </div>

              <div class="mb-3">
                  <label for="name" class="form-label fw-medium text-dark small">Keterangan</label>
                  <input type="text" name="name" id="name" class="form-control" required placeholder="Cth: Pembelian Listrik">
              </div>

              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label for="amount" class="form-label fw-medium text-dark small">Jumlah (Rp)</label>
                      <input type="number" name="amount" id="amount" class="form-control" required placeholder="Cth: 100000">
                  </div>
                  <div class="col-md-6 mb-3">
                      <label for="type" class="form-label fw-medium text-dark small">Tipe</label>
                      <select name="type" id="type" class="form-select" required>
                          <option value="income">Pemasukan (Income)</option>
                          <option value="expense">Pengeluaran (Expense)</option>
                      </select>
                  </div>
              </div>

              <div class="mb-3">
                  <label for="date" class="form-label fw-medium text-dark small">Tanggal Pertama Keluar / Masuk</label>
                  <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
              </div>

              <div class="mt-4 p-3 bg-light rounded border border-light">
                  <div class="form-check form-switch mb-0">
                      <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring" value="1" onchange="document.getElementById('recurring_options').style.display = this.checked ? 'block' : 'none'">
                      <label class="form-check-label fw-bold text-dark" for="is_recurring">Jadikan Transaksi Rutin (Recurring)</label>
                  </div>
                  <div id="recurring_options" style="display: none;" class="mt-3 pt-3 border-top">
                      <div class="row">
                          <div class="col-md-6 mb-3">
                              <label for="frequency" class="form-label fw-medium text-dark small">Frekuensi</label>
                              <select name="frequency" id="frequency" class="form-select">
                                  <option value="daily">Harian</option>
                                  <option value="monthly" selected>Bulanan</option>
                                  <option value="weekly">Mingguan</option>
                                  <option value="yearly">Tahunan</option>
                              </select>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label for="end_date" class="form-label fw-medium text-dark small">Tgl Berakhir (Opsional)</label>
                              <input type="date" name="end_date" id="end_date" class="form-control" placeholder="Kosongkan jika selamanya">
                          </div>
                      </div>
                      <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Sistem akan mencatat transaksi ini secara otomatis setiap periode yang dipilih.</small>
                  </div>
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4">Simpan Transaksi</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
