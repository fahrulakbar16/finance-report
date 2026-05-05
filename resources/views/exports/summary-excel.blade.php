<table>
    <thead>
        <tr>
            <th colspan="5" style="font-weight: bold; font-size: 14pt; text-align: center;">LAPORAN TRANSAKSI KESELURUHAN (SEMUA VILLA)</th>
        </tr>
        <tr>
            <th colspan="5" style="font-style: italic;">Periode: {{ $startDate ?? 'Awal' }} s/d {{ $endDate ?? 'Sekarang' }}</th>
        </tr>
        <tr></tr>
    </thead>

    {{-- 1. PEMASUKAN --}}
    <thead>
        <tr>
            <th colspan="5" style="font-weight: bold; background-color: #d1fae5; color: #065f46;">1. PEMASUKAN</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000;">Tanggal</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Nama Villa</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Keterangan Transaksi</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Tipe</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions->where('type', 'income') as $tx)
        <tr>
            <td style="border: 1px solid #000000;">{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
            <td style="border: 1px solid #000000;">{{ $tx->villa->name }}</td>
            <td style="border: 1px solid #000000;">{{ $tx->name }}</td>
            <td style="border: 1px solid #000000;">PEMASUKAN</td>
            <td style="border: 1px solid #000000;">{{ $tx->amount }}</td>
        </tr>
        @endforeach
        <tr></tr>
    </tbody>

    {{-- 2. PENGELUARAN OPERASIONAL --}}
    <thead>
        <tr>
            <th colspan="5" style="font-weight: bold; background-color: #fee2e2; color: #991b1b;">2. PENGELUARAN OPERASIONAL</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000;">Tanggal</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Nama Villa</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Keterangan Transaksi</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Tipe</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions->where('type', 'expense')->where('is_tanggungan_pemilik', false) as $tx)
        <tr>
            <td style="border: 1px solid #000000;">{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
            <td style="border: 1px solid #000000;">{{ $tx->villa->name }}</td>
            <td style="border: 1px solid #000000;">{{ $tx->name }}</td>
            <td style="border: 1px solid #000000;">PENGELUARAN</td>
            <td style="border: 1px solid #000000;">{{ $tx->amount }}</td>
        </tr>
        @endforeach
        <tr></tr>
    </tbody>

    {{-- 3. TANGGUNGAN PEMILIK --}}
    <thead>
        <tr>
            <th colspan="5" style="font-weight: bold; background-color: #fef3c7; color: #92400e;">3. TANGGUNGAN PEMILIK</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000;">Tanggal</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Nama Villa</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Keterangan Transaksi</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Tipe</th>
            <th style="font-weight: bold; border: 1px solid #000000;">Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions->where('type', 'expense')->where('is_tanggungan_pemilik', true) as $tx)
        <tr>
            <td style="border: 1px solid #000000;">{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
            <td style="border: 1px solid #000000;">{{ $tx->villa->name }}</td>
            <td style="border: 1px solid #000000;">{{ $tx->name }}</td>
            <td style="border: 1px solid #000000;">TANGGUNGAN</td>
            <td style="border: 1px solid #000000;">{{ $tx->amount }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
