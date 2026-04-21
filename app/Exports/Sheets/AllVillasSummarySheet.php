<?php

namespace App\Exports\Sheets;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class AllVillasSummarySheet implements FromQuery, WithTitle, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $startDate;
    protected $endDate;
    protected $villaId;

    public function __construct($startDate = null, $endDate = null, $villaId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->villaId = $villaId;
    }

    public function query()
    {
        $query = Transaction::query()->with('villa')->orderBy('date', 'desc');

        if ($this->startDate) {
            $query->whereDate('date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('date', '<=', $this->endDate);
        }
        if ($this->villaId) {
            $query->where('villa_id', $this->villaId);
        }

        return $query;
    }

    public function title(): string
    {
        return 'Rekap Keseluruhan';
    }

    public function headings(): array
    {
        return [
            ['LAPORAN TRANSAKSI KESELURUHAN (SEMUA VILLA)'],
            ['Periode:', $this->startDate ? $this->startDate . ' s/d ' . ($this->endDate ?? 'Sekarang') : 'Semua Waktu', '', '', ''],
            [''],
            [
                'Tanggal',
                'Nama Villa',
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
            $transaction->villa->name,
            $transaction->name,
            strtoupper($transaction->type),
            $transaction->amount
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => '"Rp "#,##0_-', // Accounting format
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:E1');
        
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['italic' => true]],
            4 => ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FFE2E8F0']]],
        ];
    }
}
