<?php

namespace App\Exports;

use App\Models\Villa;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\AllVillasSummarySheet;
use App\Exports\Sheets\VillaTransactionsSheet;

class AllTransactionsExport implements WithMultipleSheets
{
    use Exportable;

    protected $startDate;
    protected $endDate;
    protected $villaId;

    public function __construct($startDate = null, $endDate = null, $villaId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->villaId = $villaId;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        // Sheet 1: Laporan Keseluruhan (Summary)
        $sheets[] = new AllVillasSummarySheet($this->startDate, $this->endDate, $this->villaId);

        // Sheet 2, 3, dst: Laporan Per Villa
        if ($this->villaId) {
            $villas = Villa::where('id', $this->villaId)->get();
        } else {
            $villas = Villa::all();
        }

        foreach ($villas as $villa) {
            $sheets[] = new VillaTransactionsSheet($villa, $this->startDate, $this->endDate);
        }

        return $sheets;
    }
}
