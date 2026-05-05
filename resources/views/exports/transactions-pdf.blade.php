<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Villas</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .page-break { page-break-after: always; }
        h2 { text-transform: uppercase; color: #d97706; border-bottom: 2px solid #e2e8f0; padding-bottom: 5px; }
        h3 { color: #475569; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 20px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
        th { background-color: #f8fafc; color: #475569; text-transform: uppercase; font-size: 10px; font-weight: bold; }
        td { font-size: 11px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .success { color: #16a34a; }
        .danger { color: #dc2626; }
        .warning { color: #d97706; }
        .summary-box { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; margin-bottom: 20px; text-align: center;}
    </style>
</head>
<body>

    <!-- HALAMAN 1: SUMMARY -->
    <h2>LAPORAN TRANSAKSI KESELURUHAN (SEMUA VILLA)</h2>
    <p>Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Awal' }} - {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Sekarang' }}</p>
    
    <div class="summary-box">
        <h4>Ringkasan Transaksi Global</h4>
        Total Transaksi: {{ count($summaryTransactions) }} transaksi
    </div>

    @php
        $summaryIncome = $summaryTransactions->where('type', 'income');
        $summaryRegularExpense = $summaryTransactions->where('type', 'expense')->where('is_tanggungan_pemilik', false);
        $summaryOwnerExpense = $summaryTransactions->where('type', 'expense')->where('is_tanggungan_pemilik', true);
    @endphp

    <h3>1. PEMASUKAN</h3>
    <table>
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="25%">Nama Villa</th>
                <th width="40%">Keterangan</th>
                <th width="20%" class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($summaryIncome as $tx)
            <tr>
                <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
                <td>{{ $tx->villa->name }}</td>
                <td>{{ $tx->name }}</td>
                <td class="text-right success">{{ number_format($tx->amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">Tidak ada pemasukan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>2. PENGELUARAN OPERASIONAL</h3>
    <table>
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="25%">Nama Villa</th>
                <th width="40%">Keterangan</th>
                <th width="20%" class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($summaryRegularExpense as $tx)
            <tr>
                <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
                <td>{{ $tx->villa->name }}</td>
                <td>{{ $tx->name }}</td>
                <td class="text-right danger">{{ number_format($tx->amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">Tidak ada pengeluaran operasional.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>3. TANGGUNGAN PEMILIK</h3>
    <table>
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="25%">Nama Villa</th>
                <th width="40%">Keterangan</th>
                <th width="20%" class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($summaryOwnerExpense as $tx)
            <tr>
                <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
                <td>{{ $tx->villa->name }}</td>
                <td>{{ $tx->name }}</td>
                <td class="text-right warning">{{ number_format($tx->amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">Tidak ada tanggungan pemilik.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- HALAMAN BERIKUTNYA: PER VILLA -->
    @foreach($villaData as $data)
        @php 
            $villa = $data['villa'];
            $transactions = $data['transactions'];
            $incomeList = $transactions->where('type', 'income');
            $regularExpenseList = $transactions->where('type', 'expense')->where('is_tanggungan_pemilik', false);
            $ownerExpenseList = $transactions->where('type', 'expense')->where('is_tanggungan_pemilik', true);

            $incomeSum = $incomeList->sum('amount');
            $regularExpenseSum = $regularExpenseList->sum('amount');
            $ownerExpenseSum = $ownerExpenseList->sum('amount');

            $profit = $incomeSum - $regularExpenseSum;
            $bagianPengelola = $profit * ($villa->persenan_pengelola / 100);
            $bagianPemilik = ($profit * ($villa->persenan_pemilik / 100)) - $ownerExpenseSum;
        @endphp

        <h2>LAPORAN TRANSAKSI - {{ strtoupper($villa->name) }}</h2>
        <p>Pemilik: {{ $villa->pemilik->name }} <br>
           Email: {{ $villa->email }}</p>

        <div class="summary-box" style="text-align: left;">
            <strong>Total Pemasukan:</strong> Rp {{ number_format($incomeSum, 0, ',', '.') }} <br>
            <strong>Total Pengeluaran Operasional:</strong> Rp {{ number_format($regularExpenseSum, 0, ',', '.') }} <br>
            <strong>Total Tanggungan Pemilik:</strong> Rp {{ number_format($ownerExpenseSum, 0, ',', '.') }} <br>
            <strong>Bagian Pengelola ({{ $villa->persenan_pengelola }}%):</strong> Rp {{ number_format($bagianPengelola, 0, ',', '.') }} <br>
            <strong>Bagian Pemilik ({{ $villa->persenan_pemilik }}% - Tanggungan):</strong> Rp {{ number_format($bagianPemilik, 0, ',', '.') }}
        </div>

        <h4 style="margin-top: 20px;">Detail Pemasukan</h4>
        <table>
            <thead>
                <tr>
                    <th width="20%">Tanggal</th>
                    <th width="55%">Keterangan Transaksi</th>
                    <th width="25%" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incomeList as $tx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
                    <td>{{ $tx->name }}</td>
                    <td class="text-right success">{{ number_format($tx->amount, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">Tidak ada pemasukan.</td></tr>
                @endforelse
            </tbody>
        </table>

        <h4>Detail Pengeluaran Operasional</h4>
        <table>
            <thead>
                <tr>
                    <th width="20%">Tanggal</th>
                    <th width="55%">Keterangan Transaksi</th>
                    <th width="25%" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($regularExpenseList as $tx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
                    <td>{{ $tx->name }}</td>
                    <td class="text-right danger">{{ number_format($tx->amount, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">Tidak ada pengeluaran operasional.</td></tr>
                @endforelse
            </tbody>
        </table>

        <h4>Detail Tanggungan Pemilik</h4>
        <table>
            <thead>
                <tr>
                    <th width="20%">Tanggal</th>
                    <th width="55%">Keterangan Transaksi</th>
                    <th width="25%" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ownerExpenseList as $tx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
                    <td>{{ $tx->name }}</td>
                    <td class="text-right warning">{{ number_format($tx->amount, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">Tidak ada tanggungan pemilik.</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- Jangan tambahkan page break di villa terakhir -->
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>
</html>
