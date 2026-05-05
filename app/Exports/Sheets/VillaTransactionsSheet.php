<?php

namespace App\Exports\Sheets;

use App\Models\Villa;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class VillaTransactionsSheet implements FromView, WithTitle, ShouldAutoSize, WithColumnFormatting
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

    public function view(): View
    {
        $query = $this->villa->transactions()->orderBy('date', 'desc');

        if ($this->startDate) {
            $query->whereDate('date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('date', '<=', $this->endDate);
        }

        return view('exports.villa-excel', [
            'transactions' => $query->get(),
            'villa' => $this->villa,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }

    public function title(): string
    {
        // Max length of sheet title is 31 chars in Excel
        return substr('Villa ' . $this->villa->name, 0, 31);
    }

    public function columnFormats(): array
    {
        return [
            'D' => '"Rp "#,##0_-', // Accounting format
        ];
    }
}
