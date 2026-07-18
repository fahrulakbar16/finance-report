<table>
    <thead>
        <tr>
            <th colspan="4" style="font-weight: bold; font-size: 14pt; text-align: center;">LAPORAN TRANSAKSI - {{ strtoupper($villa->name) }}</th>
        </tr>
        <tr>
            <th colspan="4" style="font-style: italic;">Periode: {{ $startDate ?? 'Awal' }} s/d {{ $endDate ?? 'Sekarang' }}</th>
        </tr>
        <tr>
            <th colspan="4">Pemilik: {{ $villa->pemilik->name }} ({{ $villa->email }})</th>
        </tr>
        <tr></tr>
    </thead>

    @php
        $incomeSum = $transactions->where('type', 'income')->sum('amount');
        $regularExpenseSum = $transactions->where('type', 'expense')->where('is_tanggungan_pemilik', false)->sum('amount');
        $ownerExpenseSum = $transactions->where('type', 'expense')->where('is_tanggungan_pemilik', true)->sum('amount');
        $profit = $incomeSum - $regularExpenseSum;
        $bagianPengelola = $profit * ($villa->persenan_pengelola / 100);
        $bagianPemilik = ($profit * ($villa->persenan_pemilik / 100)) - $ownerExpenseSum;
    @endphp

    <thead>
        <tr>
            <th colspan="2" style="font-weight: bold; border: 1px solid #000000; background-color: #f1f5f9;">Ringkasan</th>
            <th colspan="2" style="font-weight: bold; border: 1px solid #000000; background-color: #f1f5f9;">Nilai</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" style="border: 1px solid #000000;">Total Pemasukan</td>
            <td colspan="2" style="border: 1px solid #000000;">{{ $incomeSum }}</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid #000000;">Total Pengeluaran Operasional</td>
            <td colspan="2" style="border: 1px solid #000000;">{{ $regularExpenseSum }}</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid #000000;">Total Tanggungan Pemilik</td>
            <td colspan="2" style="border: 1px solid #000000;">{{ $ownerExpenseSum }}</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid #000000; font-weight: bold;">Bagian Pengelola ({{ $villa->persenan_pengelola }}%)</td>
            <td colspan="2" style="border: 1px solid #000000; font-weight: bold;">{{ $bagianPengelola }}</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid #000000; font-weight: bold;">Bagian Pemilik ({{ $villa->persenan_pemilik }}% - Tanggungan)</td>
            <td colspan="2" style="border: 1px solid #000000; font-weight: bold;">{{ $bagianPemilik }}</td>
        </tr>
        <tr></tr>
    </tbody>

    {{-- 1. PEMASUKAN --}}
    <thead>
        <tr>
            <th colspan="4" style="font-weight: bold; background-color: #d1fae5;">1. DETAIL PEMASUKAN</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000;">Tanggal</th>
            <th colspan="2" style="font-weight: bold; border: 1px solid #000000;">Keterangan</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions->where('type', 'income') as $tx)
        <tr>
            <td style="border: 1px solid #000000;">{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
            <td colspan="2" style="border: 1px solid #000000;">{{ $tx->name }}</td>
            <td style="border: 1px solid #000000;">{{ $tx->amount }}</td>
        </tr>
        @endforeach
        <tr></tr>
    </tbody>

    {{-- 2. PENGELUARAN OPERASIONAL --}}
    <thead>
        <tr>
            <th colspan="4" style="font-weight: bold; background-color: #fee2e2;">2. DETAIL PENGELUARAN OPERASIONAL</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000;">Tanggal</th>
            <th colspan="2" style="font-weight: bold; border: 1px solid #000000;">Keterangan</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions->where('type', 'expense')->where('is_tanggungan_pemilik', false) as $tx)
        <tr>
            <td style="border: 1px solid #000000;">{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
            <td colspan="2" style="border: 1px solid #000000;">{{ $tx->name }}</td>
            <td style="border: 1px solid #000000;">{{ $tx->amount }}</td>
        </tr>
        @endforeach
        <tr></tr>
    </tbody>

    {{-- 3. TANGGUNGAN PEMILIK --}}
    <thead>
        <tr>
            <th colspan="4" style="font-weight: bold; background-color: #fef3c7;">3. DETAIL TANGGUNGAN PEMILIK</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000;">Tanggal</th>
            <th colspan="2" style="font-weight: bold; border: 1px solid #000000;">Keterangan</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions->where('type', 'expense')->where('is_tanggungan_pemilik', true) as $tx)
        <tr>
            <td style="border: 1px solid #000000;">{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
            <td colspan="2" style="border: 1px solid #000000;">{{ $tx->name }}</td>
            <td style="border: 1px solid #000000;">{{ $tx->amount }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
