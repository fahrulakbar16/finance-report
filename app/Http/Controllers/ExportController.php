<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllTransactionsExport;
use App\Exports\Sheets\VillaTransactionsSheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Concerns\Exportable;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Export All Transactions to Multi-Sheet Excel
     */
    public function exportAllExcel(Request $request)
    {
        $fileName = 'Laporan_Keuangan_Villas_' . date('Y_m_d_H_i') . '.xlsx';
        
        return Excel::download(
            new AllTransactionsExport($request->start_date, $request->end_date, $request->villa_id), 
            $fileName
        );
    }

    /**
     * Export Single Villa to Excel (1 Sheet)
     */
    public function exportVillaExcel(Request $request, Villa $villa)
    {
        $fileName = 'Laporan_' . str_replace(' ', '_', $villa->name) . '_' . date('Y_m_d') . '.xlsx';

        // we can wrap the single sheet in an anonymous export class, or just create a class containing only this sheet
        $export = new class($villa, $request->start_date, $request->end_date) implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
            use \Maatwebsite\Excel\Concerns\Exportable;
            private $villa, $start, $end;
            public function __construct($villa, $start, $end) {
                $this->villa = $villa;
                $this->start = $start;
                $this->end = $end;
            }
            public function sheets(): array {
                return [new VillaTransactionsSheet($this->villa, $this->start, $this->end)];
            }
        };

        return Excel::download($export, $fileName);
    }

    /**
     * Export All Transactions to Multi-page PDF
     */
    public function exportAllPdf(Request $request)
    {
        // 1. Get Summary Data
        $summaryQuery = Transaction::query()->with('villa')->orderBy('date', 'desc');
        if ($request->filled('start_date')) $summaryQuery->whereDate('date', '>=', $request->start_date);
        if ($request->filled('end_date'))   $summaryQuery->whereDate('date', '<=', $request->end_date);
        if ($request->filled('villa_id'))   $summaryQuery->where('villa_id', $request->villa_id);
        $summaryTransactions = $summaryQuery->get();

        // 2. Get Per-Villa Data
        if ($request->filled('villa_id')) {
            $villas = Villa::where('id', $request->villa_id)->get();
        } else {
            $villas = Villa::all();
        }
        
        $villaData = [];
        foreach ($villas as $villa) {
            $vq = $villa->transactions()->orderBy('date', 'desc');
            if ($request->filled('start_date')) $vq->whereDate('date', '>=', $request->start_date);
            if ($request->filled('end_date'))   $vq->whereDate('date', '<=', $request->end_date);
            $villaData[] = [
                'villa' => $villa,
                'transactions' => $vq->get()
            ];
        }

        $pdf = Pdf::loadView('exports.transactions-pdf', [
            'summaryTransactions' => $summaryTransactions,
            'villaData' => $villaData,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date
        ]);

        return $pdf->download('Laporan_Keuangan_Villas_' . date('Y_m_d') . '.pdf');
    }
}
