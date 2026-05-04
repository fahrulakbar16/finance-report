@extends('layouts.admin')

@section('page_title', 'Dashboard Analytics')

@section('content')
<!-- Stats Widgets -->
<div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
    <div class="col">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: var(--fi-radius);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Pemasukan (Bulan Ini)</h6>
                    <div class="text-success bg-success bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalIncomeMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: var(--fi-radius);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Pengeluaran (Bulan Ini)</h6>
                    <div class="text-danger bg-danger bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-graph-down-arrow fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalExpenseMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: var(--fi-radius);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Bagian Pengelola</h6>
                    <div class="text-primary bg-primary bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-person-badge fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 {{ $bagianPengelolaMonth >= 0 ? 'text-dark' : 'text-danger' }}">Rp {{ number_format($bagianPengelolaMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: var(--fi-radius);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="card-title text-muted fw-semibold mb-0" style="font-size: 0.875rem;">Bagian Pemilik</h6>
                    <div class="text-info bg-info bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 {{ $bagianPemilikMonth >= 0 ? 'text-dark' : 'text-danger' }}">Rp {{ number_format($bagianPemilikMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Cash Flow Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100" style="border-radius: var(--fi-radius);">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0">Tren Arus Kas (6 Bulan Terakhir)</h5>
                <p class="text-muted small">Perbandingan pemasukan vs pengeluaran villa</p>
            </div>
            <div class="card-body px-2">
                <div id="cashFlowChart"></div>
            </div>
        </div>
    </div>

    <!-- AI Insight Widget -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: var(--fi-radius);">
            <div class="card-header bg-warning bg-opacity-10 border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                    <i class="bi bi-lightning-charge-fill text-warning me-2"></i> Insight AI
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="p-3 bg-light rounded-3 mb-3 border-start border-4 border-warning">
                    <p class="mb-0 text-dark small leading-relaxed" style="line-height: 1.6;">
                        "{{ $aiInsight }}"
                    </p>
                </div>
                <div class="text-center">
                    <img src="https://img.icons8.com/parakeet/96/artificial-intelligence.png" alt="AI Icon" style="width: 64px; opacity: 0.3;">
                </div>
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted d-block mb-2"><i class="bi bi-info-circle me-1"></i>Saran AI dihasilkan secara otomatis berdasarkan data transaksi tersimpan.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Transactions -->
    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100" style="border-radius: var(--fi-radius);">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0">Transaksi Terakhir</h5>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light text-primary fw-medium px-3">Semua <i class="bi bi-arrow-right small ms-1"></i></a>
            </div>
            <div class="card-body px-0 pt-4">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <tbody>
                            @forelse($recentTransactions as $tx)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-{{ $tx->type == 'income' ? 'success' : 'danger' }} bg-opacity-10 text-{{ $tx->type == 'income' ? 'success' : 'danger' }} rounded-circle d-flex align-items-center justify-content-center p-2 me-3" style="width: 36px; height: 36px;">
                                                <i class="bi bi-{{ $tx->type == 'income' ? 'arrow-up' : 'arrow-down' }}-short fs-4"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark small">{{ $tx->name }}</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">{{ $tx->villa->name }} &bull; {{ \Carbon\Carbon::parse($tx->date)->format('d M') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4 py-3">
                                        <div class="fw-bold text-{{ $tx->type == 'income' ? 'success' : 'danger' }} small">
                                            {{ $tx->type == 'income' ? '+' : '-' }}Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="text-center py-4 text-muted small">Belum ada transaksi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Recurring -->
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100" style="border-radius: var(--fi-radius);">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0">Pengeluaran Rutin (Recurring)</h5>
                <p class="text-muted small">Biaya yang terpotong otomatis tiap periode</p>
            </div>
            <div class="card-body p-4 pt-4">
                @forelse($recurringTransactions as $rt)
                    <div class="d-flex align-items-center p-3 rounded-3 border bg-light bg-opacity-50 mb-3 hover-shadow-sm transition-all">
                        <div class="bg-white rounded border d-flex align-items-center justify-content-center p-2 me-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-repeat fs-4 text-warning"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark small mb-0">{{ $rt->name }}</div>
                            <div class="text-muted small" style="font-size: 0.7rem;">{{ $rt->villa->name }} &bull; {{ ucfirst($rt->frequency) }}</div>
                        </div>
                        <div class="text-end font-monospace fw-bold text-dark small">
                            Rp {{ number_format($rt->amount, 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-cloud-slash fs-2 text-muted opacity-25"></i>
                        <p class="text-muted small mt-2">Tidak ada biaya rutin aktif</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            series: [{
                name: 'Pemasukan',
                data: {!! json_encode($chartData['income']) !!}
            }, {
                name: 'Pengeluaran',
                data: {!! json_encode($chartData['expense']) !!}
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            colors: ['#d97706', '#ef4444'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100, 100, 100]
                }
            },
            xaxis: {
                categories: {!! json_encode($chartData['labels']) !!},
                labels: { style: { colors: '#64748b', fontSize: '12px' } }
            },
            yaxis: {
                labels: { 
                    formatter: function (val) { return "Rp " + (val / 1000000).toFixed(1) + "jt" },
                    style: { colors: '#64748b', fontSize: '12px' }
                }
            },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            legend: { position: 'top', horizontalAlign: 'right' },
            tooltip: { theme: 'light' }
        };

        var chart = new ApexCharts(document.querySelector("#cashFlowChart"), options);
        chart.render();
    });
</script>
@endpush

<style>
    .transition-all { transition: all 0.3s ease; }
    .hover-shadow-sm:hover { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .leading-relaxed { line-height: 1.625; }
</style>
@endsection
