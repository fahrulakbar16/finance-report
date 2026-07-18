@extends('layouts.admin')

@section('page_title', 'Pengeluaran Rutin')

@section('content')
<div class="container-fluid px-0">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div class="page-header-fi">
            <h4>Pengeluaran Rutin</h4>
            <p>Kelola dan pantau semua transaksi rutin yang terjadwal otomatis</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-fi alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-fi alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-fi overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center pt-4 pb-3 px-4">
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-arrow-repeat me-2 text-warning"></i>Daftar Pengeluaran Rutin
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-fi mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">Nama Transaksi</th>
                            <th class="py-3">Villa</th>
                            <th class="py-3">Tipe</th>
                            <th class="py-3">Frekuensi</th>
                            <th class="py-3">Mulai</th>
                            <th class="py-3">Selesai</th>
                            <th class="py-3">Jumlah</th>
                            <th class="text-center pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recurringTransactions as $recurring)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center p-2 me-3" style="width: 44px; height: 44px;">
                                            <i class="bi bi-repeat fs-5"></i>
                                        </div>
                                        <div class="fw-semibold text-dark">{{ $recurring->name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-white text-dark border shadow-sm px-3 py-2 fw-medium">
                                        <i class="bi bi-house-door text-primary me-1"></i> {{ $recurring->villa ? $recurring->villa->name : '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($recurring->type === 'income')
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 fw-medium" style="font-size: 0.75rem;">Pemasukan</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 fw-medium" style="font-size: 0.75rem;">Pengeluaran</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-light text-dark border px-2 py-1 fw-medium" style="font-size: 0.75rem;">{{ ucfirst($recurring->frequency) }}</span>
                                </td>
                                <td>
                                    <div class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($recurring->start_date)->format('d M Y') }}</div>
                                </td>
                                <td>
                                    @if($recurring->end_date)
                                        <div class="text-dark fw-semibold">{{ \Carbon\Carbon::parse($recurring->end_date)->format('d M Y') }}</div>
                                    @else
                                        <span class="text-muted small">Tanpa batas</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="amount-badge bg-warning bg-opacity-10 text-dark">
                                        Rp {{ number_format($recurring->amount, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="text-center pe-4">
                                    <form action="{{ route('recurring-transactions.destroy', $recurring->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghentikan dan menghapus pengeluaran rutin ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border text-danger rounded-3" title="Hapus Rutinitas">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <i class="bi bi-inbox d-block"></i>
                                    Belum ada data pengeluaran rutin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($recurringTransactions->hasPages())
            <div class="pagination-fi">
                {{ $recurringTransactions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
