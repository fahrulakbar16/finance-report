@extends('layouts.admin')

@section('page_title', 'Detail Villa: ' . $villa->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('villas.index') }}" class="btn btn-sm btn-light text-muted fw-medium py-2 px-3 border shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Manajemen Villa
    </a>
</div>

<!-- Header Card -->
<div class="card card-fi mb-4">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-auto">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                    <i class="bi bi-house-door-fill fs-2"></i>
                </div>
            </div>
            <div class="col">
                <h4 class="fw-bold text-dark mb-1">{{ $villa->name }}</h4>
                <p class="text-muted mb-0 small"><i class="bi bi-envelope me-1"></i> {{ $villa->email }} &bull; <i class="bi bi-person me-1"></i> {{ $villa->pemilik->name }}</p>
            </div>
            <div class="col-md-auto mt-3 mt-md-0 d-flex gap-2">
                <a href="{{ route('export.excel.villa', ['villa' => $villa->id] + request()->query()) }}" class="btn btn-sm btn-success px-3 py-2 fw-medium shadow-sm">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                </a>
                <form action="{{ route('transactions.index', ['villa_id' => $villa->id]) }}" method="GET">
                    <button type="submit" class="btn btn-sm btn-light border px-3 py-2 fw-medium shadow-sm">
                        <i class="bi bi-list-stars me-1"></i> Lihat Semua Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="card card-fi mb-4">
    <div class="card-body p-4">
        <form action="{{ route('villas.show', $villa) }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="start_date" class="form-label fw-medium text-dark small">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" class="form-control border-light bg-light" style="border-radius: 0.5rem;" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label fw-medium text-dark small">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" class="form-control border-light bg-light" style="border-radius: 0.5rem;" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 py-2" style="border-radius: 0.5rem;">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <a href="{{ route('villas.show', $villa) }}" class="btn btn-light border w-100 py-2" style="border-radius: 0.5rem;">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Summary Widgets -->
<div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
    <div class="col">
        <div class="card card-fi card-hover h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Pemasukan Villa</h6>
                    <div class="text-success bg-success bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card card-fi card-hover h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Pengeluaran Villa</h6>
                    <div class="text-danger bg-danger bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-graph-down-arrow fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card card-fi card-hover h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Profitability</h6>
                    <div class="text-primary bg-primary bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-cash-coin fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 {{ $balance >= 0 ? 'text-dark' : 'text-danger' }}">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="card card-fi overflow-hidden">
    <div class="card-header d-flex justify-content-between align-items-center pt-4 pb-3 px-4">
        <h5 class="fw-bold text-dark mb-0">Riwayat Transaksi Villa</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-fi mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-4 py-3">Tanggal</th>
                    <th class="py-3">Keterangan</th>
                    <th class="py-3">Tipe</th>
                    <th class="text-end pe-4 py-3">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td class="ps-4 text-muted small">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</td>
                        <td class="fw-medium text-dark">{{ $transaction->name }}</td>
                        <td>
                            @if($transaction->type == 'income')
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 fw-medium" style="font-size: 0.75rem;">Pemasukan</span>
                            @else
                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 fw-medium" style="font-size: 0.75rem;">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="amount-badge {{ $transaction->type == 'income' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 text-dark">
                                {{ $transaction->type == 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            <i class="bi bi-inbox d-block"></i>
                            Tidak ada transaksi ditemukan untuk kriteria ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
        <div class="pagination-fi">
            {{ $transactions->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
