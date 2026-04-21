<?php

namespace App\Exports\Sheets;

use App\Models\Villa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class VillaTransactionsSheet implements FromQuery, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    private $villa;
    private $startDate;
    private $endDate;

    public function __construct(Villa $villa, $startDate = null, $endDate = null)
    {
        $this->villa = $villa;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        $query = $this->villa->transactions()->orderBy('date', 'desc');

        if ($this->startDate) {
            $query->whereDate('date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('date', '<=', $this->endDate);
        }

        return $query;
    }

    public function title(): string
    {
        // Max length of sheet title is 31 chars in Excel
        return substr('Villa ' . $this->villa->name, 0, 31);
    }

    public function headings(): array
    {
        return [
            ['LAPORAN TRANSAKSI - ' . strtoupper($this->villa->name)],
            ['Periode:', $this->startDate ? $this->startDate . ' s/d ' . ($this->endDate ?? 'Sekarang') : 'Semua Waktu', '', ''],
            [''],
            [
                'Tanggal',
                'Keterangan Transaksi',
                'Tipe',
                'Jumlah (Rp)'
            ]
        ];
    }

    public function map($transaction): array
    {
        return [
            \Carbon\Carbon::parse($transaction->date)->format('d/m/Y'),
            $transaction->name,
            strtoupper($transaction->type),
            $transaction->amount
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '"Rp "#,##0_-', // Accounting format
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:D1');
        
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['italic' => true]],
            4 => ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FFE2E8F0']]],
        ];
    }
}
