@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4">Laporan Keuangan Villa</h2>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Pemasukan</h5>
                            <h3>Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Pengeluaran</h5>
                            <h3>Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Saldo Akhir</h5>
                            <h3>Rp {{ number_format($balance, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Transaksi</span>
                    @role('pengelola')
                        <button class="btn btn-sm btn-primary">Tambah Transaksi</button>
                    @endrole
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
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
                                    <td>{{ \Carbon\Carbon::parse($report->date)->format('d/m/Y') }}</td>
                                    <td>{{ $report->description }}</td>
                                    <td>
                                        <span class="badge {{ $report->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($report->type) }}
                                        </span>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($report->amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data laporan keuangan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
