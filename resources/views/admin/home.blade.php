@extends('layouts.admin')

@section('page_title', 'Dashboard Analytics')

@section('content')

<!-- Page Header + Quick Actions -->
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4 animate-in">
    <div class="page-header-fi">
        <h4>Halo, {{ explode(' ', Auth::user()->name)[0] }} 👋</h4>
        <p>Ini ringkasan performa keuangan villa Anda hari ini.</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        @role('pengelola')
        <a href="{{ route('transactions.index') }}" class="quick-action">
            <span class="qa-icon" style="background: var(--gradient-primary);"><i class="bi bi-plus-lg"></i></span>
            Transaksi Baru
        </a>
        @endrole
        <a href="{{ route('export.excel.all') }}" class="quick-action">
            <span class="qa-icon" style="background: var(--gradient-success);"><i class="bi bi-file-earmark-excel"></i></span>
            Export Excel
        </a>
        <a href="{{ route('export.pdf.all') }}" class="quick-action">
            <span class="qa-icon" style="background: var(--gradient-danger);"><i class="bi bi-file-earmark-pdf"></i></span>
            Export PDF
        </a>
        @role('pengelola')
        <a href="{{ route('villas.index') }}" class="quick-action">
            <span class="qa-icon" style="background: var(--gradient-accent); color: var(--brand-primary);"><i class="bi bi-buildings"></i></span>
            Kelola Villa
        </a>
        @endrole
    </div>
</div>

<!-- Stats Widgets -->
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
    <div class="col">
        <div class="card card-fi card-hover stat-card stat-success h-100 animate-in" style="animation-delay: .05s">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon icon-success"><i class="bi bi-graph-up-arrow fs-5"></i></div>
                </div>
                <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.06em;">Pemasukan (Bulan Ini)</h6>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalIncomeMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card card-fi card-hover stat-card stat-danger h-100 animate-in" style="animation-delay: .1s">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon icon-danger"><i class="bi bi-graph-down-arrow fs-5"></i></div>
                </div>
                <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.06em;">Pengeluaran (Bulan Ini)</h6>
                <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalExpenseMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card card-fi card-hover stat-card stat-primary h-100 animate-in" style="animation-delay: .15s">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon icon-primary"><i class="bi bi-person-badge fs-5"></i></div>
                </div>
                <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.06em;">Bagian Pengelola</h6>
                <h3 class="fw-bold mb-0 {{ $bagianPengelolaMonth >= 0 ? 'text-dark' : 'text-danger' }}">Rp {{ number_format($bagianPengelolaMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card card-fi card-hover stat-card stat-info h-100 animate-in" style="animation-delay: .2s">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon icon-info"><i class="bi bi-person-fill fs-5"></i></div>
                </div>
                <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.06em;">Bagian Pemilik</h6>
                <h3 class="fw-bold mb-0 {{ $bagianPemilikMonth >= 0 ? 'text-dark' : 'text-danger' }}">Rp {{ number_format($bagianPemilikMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Cash Flow Chart -->
    <div class="col-lg-8">
        <div class="card card-fi h-100 animate-in" style="animation-delay: .25s">
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
        <div class="h-100 rounded-4 overflow-hidden position-relative animate-in shadow-sm" style="background: var(--gradient-primary); animation-delay: .3s;">
            <div class="position-absolute" style="top: -60px; right: -60px; width: 200px; height: 200px; border-radius: 50%; background: var(--brand-accent); opacity: .18;"></div>
            <div class="position-absolute" style="bottom: -80px; left: -40px; width: 160px; height: 160px; border-radius: 50%; background: #ffffff; opacity: .06;"></div>
            <div class="p-4 position-relative h-100 d-flex flex-column">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="d-flex align-items-center justify-content-center rounded-3" style="width: 40px; height: 40px; background: rgba(255,255,255,0.15);">
                        <i class="bi bi-lightning-charge-fill text-white fs-5"></i>
                    </span>
                    <h5 class="fw-bold text-white mb-0">Insight AI</h5>
                </div>
                <div class="p-3 rounded-3 mb-3" style="background: rgba(255,255,255,0.1);">
                    <p class="mb-0 text-white small" style="line-height: 1.65; opacity: 0.95;">
                        "{{ $aiInsight }}"
                    </p>
                </div>
                <div class="mt-auto pt-3" style="border-top: 1px solid rgba(255,255,255,0.15);">
                    <small class="text-white d-block" style="opacity: 0.65;"><i class="bi bi-info-circle me-1"></i>Saran AI dihasilkan otomatis dari data transaksi tersimpan.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Transactions -->
    <div class="col-md-7">
        <div class="card card-fi h-100 animate-in" style="animation-delay: .35s">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0">Riwayat Transaksi</h5>
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light text-primary fw-medium px-3 rounded-pill">Semua <i class="bi bi-arrow-right small ms-1"></i></a>
                </div>
                <ul class="nav nav-tabs nav-tabs-fi border-0 gap-3" id="transactionTabs" role="tablist">
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
                            <table class="table table-fi mb-0 align-middle">
                                <tbody>
                                    @forelse($recentIncome as $tx)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-circle bg-success bg-opacity-10 text-success me-3" style="width: 40px; height: 40px;">
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
                                                <div class="amount-badge bg-success bg-opacity-10 text-dark">
                                                    +Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td class="empty-state"><i class="bi bi-inbox d-block"></i>Belum ada pemasukan</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Expense Pane -->
                    <div class="tab-pane fade" id="expense-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-fi mb-0 align-middle">
                                <tbody>
                                    @forelse($recentExpense as $tx)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-circle bg-danger bg-opacity-10 text-danger me-3" style="width: 40px; height: 40px;">
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
                                                <div class="amount-badge bg-danger bg-opacity-10 text-dark">
                                                    -Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td class="empty-state"><i class="bi bi-inbox d-block"></i>Belum ada pengeluaran</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Owner Expense Pane -->
                    <div class="tab-pane fade" id="owner-pane" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-fi mb-0 align-middle">
                                <tbody>
                                    @forelse($recentOwnerExpense as $tx)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-circle bg-warning bg-opacity-10 text-warning me-3" style="width: 40px; height: 40px;">
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
                                                <div class="amount-badge bg-warning bg-opacity-10 text-dark">
                                                    Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td class="empty-state"><i class="bi bi-inbox d-block"></i>Belum ada tanggungan pemilik</td></tr>
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
        <div class="card card-fi h-100 animate-in" style="animation-delay: .4s">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0">Pengeluaran Rutin (Recurring)</h5>
                <p class="text-muted small">Biaya yang terpotong otomatis tiap periode</p>
            </div>
            <div class="card-body p-4 pt-4">
                @forelse($recurringTransactions as $rt)
                    <div class="d-flex align-items-center p-3 rounded-4 mb-3 transition-all" style="background: #FAFBFC;">
                        <div class="icon-circle bg-white shadow-xs me-3" style="width: 44px; height: 44px;">
                            <i class="bi bi-repeat fs-5 text-warning"></i>
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
            colors: ['#10B981', '#EF4444'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2.5 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [20, 100, 100, 100]
                }
            },
            xaxis: {
                categories: {!! json_encode($chartData['labels']) !!},
                labels: { style: { colors: '#94a3b8', fontSize: '12px', fontFamily: 'Inter, sans-serif' } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function (val) { return "Rp " + (val / 1000000).toFixed(1) + "jt" },
                    style: { colors: '#94a3b8', fontSize: '12px', fontFamily: 'Inter, sans-serif' }
                }
            },
            grid: { borderColor: '#F1F5F9', strokeDashArray: 4 },
            legend: { position: 'top', horizontalAlign: 'right', fontFamily: 'Inter, sans-serif', labels: { colors: '#334155' } },
            tooltip: { theme: 'light' }
        };

        var chart = new ApexCharts(document.querySelector("#cashFlowChart"), options);
        chart.render();
    });
</script>
@endpush

@endsection
