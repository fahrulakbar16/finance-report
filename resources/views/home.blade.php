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
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0">Riwayat Transaksi</h5>
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light text-primary fw-medium px-3">Semua <i class="bi bi-arrow-right small ms-1"></i></a>
                </div>
                <ul class="nav nav-tabs border-0 gap-3" id="transactionTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active border-0 fw-semibold px-0 text-muted transition-all" id="income-tab" data-bs-toggle="tab" data-bs-target="#income-pane" type="button" role="tab" style="font-size: 0.85rem;">Pemasukan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link border-0 fw-semibold px-0 text-muted transition-all" id="expense-tab" data-bs-toggle="tab" data-bs-target="#expense-pane" type="button" role="tab" style="font-size: 0.85rem;">Pengeluaran</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link border-0 fw-semibold px-0 text-muted transition-all" id="owner-tab" data-bs-toggle="tab" data-bs-target="#owner-pane" type="button" role="tab" style="font-size: 0.85rem;">Tanggungan Pemilik</button>
                    </li>
                </ul>
            </div>
            <div class="card-body px-0 pt-2">
                <div class="tab-content" id="transactionTabsContent">
                    <!-- Income Pane -->
                    <div class="tab-pane fade show active" id="income-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-custom mb-0 align-middle">
                                <tbody>
                                    @forelse($recentIncome as $tx)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center p-2 me-3" style="width: 40px; height: 40px;">
                                                        <i class="bi bi-arrow-up-right fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">{{ $tx->name }}</div>
                                                        <div class="text-muted" style="font-size: 0.75rem;">
                                                            <span class="text-primary fw-medium">{{ $tx->villa->name }}</span> &bull; {{ \Carbon\Carbon::parse($tx->date)->format('d M, Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4 py-3">
                                                <div class="amount-badge bg-success bg-opacity-10 text-success">
                                                    +Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td class="text-center py-5 text-muted small">Belum ada pemasukan</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Expense Pane -->
                    <div class="tab-pane fade" id="expense-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-custom mb-0 align-middle">
                                <tbody>
                                    @forelse($recentExpense as $tx)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center justify-content-center p-2 me-3" style="width: 40px; height: 40px;">
                                                        <i class="bi bi-arrow-down-left fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">{{ $tx->name }}</div>
                                                        <div class="text-muted" style="font-size: 0.75rem;">
                                                            <span class="text-primary fw-medium">{{ $tx->villa->name }}</span> &bull; {{ \Carbon\Carbon::parse($tx->date)->format('d M, Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4 py-3">
                                                <div class="amount-badge bg-danger bg-opacity-10 text-danger">
                                                    -Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td class="text-center py-5 text-muted small">Belum ada pengeluaran</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Owner Expense Pane -->
                    <div class="tab-pane fade" id="owner-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-custom mb-0 align-middle">
                                <tbody>
                                    @forelse($recentOwnerExpense as $tx)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center p-2 me-3" style="width: 40px; height: 40px;">
                                                        <i class="bi bi-person-exclamation fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">{{ $tx->name }}</div>
                                                        <div class="text-muted" style="font-size: 0.75rem;">
                                                            <span class="text-primary fw-medium">{{ $tx->villa->name }}</span> &bull; {{ \Carbon\Carbon::parse($tx->date)->format('d M, Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4 py-3">
                                                <div class="amount-badge bg-warning bg-opacity-10 text-warning">
                                                    Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td class="text-center py-5 text-muted small">Belum ada tanggungan pemilik</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
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
    .nav-tabs .nav-link.active {
        color: var(--bs-primary) !important;
        border-bottom: 2px solid var(--bs-primary) !important;
        background: transparent;
    }
    .nav-tabs .nav-link:hover {
        color: var(--bs-primary) !important;
    }
    .table-custom tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }
    .table-custom tbody tr:last-child {
        border-bottom: none;
    }
    .table-custom tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.002);
    }
    .amount-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
    }
</style>
@endsection
