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

    <table>
        <thead>
            <tr>
                <th width="12%">Tanggal</th>
                <th width="20%">Nama Villa</th>
                <th width="35%">Keterangan</th>
                <th width="13%" class="text-center">Tipe</th>
                <th width="20%" class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($summaryTransactions as $tx)
            <tr>
                <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
                <td>{{ $tx->villa->name }}</td>
                <td>{{ $tx->name }}</td>
                <td class="text-center {{ $tx->type == 'income' ? 'success' : 'danger' }}">
                    {{ strtoupper($tx->type) }}
                </td>
                <td class="text-right">{{ number_format($tx->amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada transaksi ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- HALAMAN BERIKUTNYA: PER VILLA -->
    @foreach($villaData as $data)
        @php 
            $villa = $data['villa'];
            $transactions = $data['transactions'];
            $income = $transactions->where('type', 'income')->sum('amount');
            $expense = $transactions->where('type', 'expense')->sum('amount');
            $profit = $income - $expense;
            $bagianPengelola = $profit * ($villa->persenan_pengelola / 100);
            $bagianPemilik = $profit * ($villa->persenan_pemilik / 100);
        @endphp

        <h2>LAPORAN TRANSAKSI - {{ strtoupper($villa->name) }}</h2>
        <p>Pemilik: {{ $villa->pemilik->name }} <br>
           Email: {{ $villa->email }}</p>

        <div class="summary-box" style="text-align: left;">
            <strong>Total Pemasukan:</strong> Rp {{ number_format($income, 0, ',', '.') }} <br>
            <strong>Total Pengeluaran:</strong> Rp {{ number_format($expense, 0, ',', '.') }} <br>
            <strong>Bagian Pengelola ({{ $villa->persenan_pengelola }}%):</strong> Rp {{ number_format($bagianPengelola, 0, ',', '.') }} <br>
            <strong>Bagian Pemilik ({{ $villa->persenan_pemilik }}%):</strong> Rp {{ number_format($bagianPemilik, 0, ',', '.') }}
        </div>

        <table>
            <thead>
                <tr>
                    <th width="15%">Tanggal</th>
                    <th width="45%">Keterangan Transaksi</th>
                    <th width="15%" class="text-center">Tipe</th>
                    <th width="25%" class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
                    <td>{{ $tx->name }}</td>
                    <td class="text-center {{ $tx->type == 'income' ? 'success' : 'danger' }}">
                        {{ strtoupper($tx->type) }}
                    </td>
                    <td class="text-right">{{ number_format($tx->amount, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada transaksi untuk villa ini.</td>
                </tr>
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
