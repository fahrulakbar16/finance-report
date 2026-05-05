<?php

namespace App\Exports\Sheets;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class AllVillasSummarySheet implements FromView, WithTitle, ShouldAutoSize, WithColumnFormatting
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

    public function view(): View
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

        return view('exports.summary-excel', [
            'transactions' => $query->get(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }

    public function title(): string
    {
        return 'Rekap Keseluruhan';
    }

    public function columnFormats(): array
    {
        return [
            'E' => '"Rp "#,##0_-', // Accounting format
        ];
    }
}
