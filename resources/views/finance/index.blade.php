@extends('layouts.admin')

@section('page_title', 'Laporan Keuangan')

@section('content')
<!-- Summary Cards -->
<div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
    <div class="col">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Total Pemasukan</h6>
                    <div class="text-success bg-success bg-opacity-10 rounded-circle p-2 d-flex d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Total Pengeluaran</h6>
                    <div class="text-danger bg-danger bg-opacity-10 rounded-circle p-2 d-flex d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-graph-down-arrow fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100">
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

<!-- Reports Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center border-0 pt-4 pb-3 px-4">
        <span class="fs-5 fw-bold">Daftar Transaksi</span>
        @role('pengelola')
            <button class="btn btn-sm btn-primary py-2 px-3">Tambah Transaksi</button>
        @endrole
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3">Tanggal</th>
                    <th class="py-3">Keterangan</th>
                    <th class="py-3">Tipe</th>
                    <th class="text-end pe-4 py-3">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td class="ps-4 text-muted">{{ \Carbon\Carbon::parse($report->date)->format('d/m/Y') }}</td>
                        <td class="fw-medium text-dark">{{ $report->description }}</td>
                        <td>
                            @if($report->type == 'income')
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 fw-medium" style="font-size: 0.75rem;">Income</span>
                            @else
                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 fw-medium" style="font-size: 0.75rem;">Expense</span>
                            @endif
                        </td>
                        <td class="text-end pe-4 fw-medium text-dark">Rp {{ number_format($report->amount, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-inbox fs-1 text-light mb-2"></i>
                                <span>Belum ada data laporan keuangan.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
