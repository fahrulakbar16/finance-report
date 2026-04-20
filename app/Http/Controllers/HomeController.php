<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\RecurringTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // 1. Widget Stats (Bulan Ini)
        $totalIncomeMonth = Transaction::where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        
        $totalExpenseMonth = Transaction::where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        
        $balanceMonth = $totalIncomeMonth - $totalExpenseMonth;

        // 2. Data Grafik (6 Bulan Terakhir)
        $chartData = $this->getMonthlyTrendData();

        // 3. Data Tabel & List
        $recentTransactions = Transaction::with('villa')->latest('date')->take(5)->get();
        $recurringTransactions = RecurringTransaction::with('villa')->take(5)->get();

        // 4. AI Insight (Rule-based)
        $aiInsight = $this->generateAiInsight($totalIncomeMonth, $totalExpenseMonth, $balanceMonth);

        return view('home', compact(
            'totalIncomeMonth', 
            'totalExpenseMonth', 
            'balanceMonth', 
            'chartData',
            'recentTransactions',
            'recurringTransactions',
            'aiInsight'
        ));
    }

    private function getMonthlyTrendData()
    {
        $labels = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');
            
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $incomeData[] = Transaction::where('type', 'income')
                ->whereBetween('date', [$start, $end])
                ->sum('amount');
            
            $expenseData[] = Transaction::where('type', 'expense')
                ->whereBetween('date', [$start, $end])
                ->sum('amount');
        }

        return [
            'labels' => $labels,
            'income' => $incomeData,
            'expense' => $expenseData
        ];
    }

    private function generateAiInsight($income, $expense, $balance)
    {
        if ($income == 0 && $expense == 0) {
            return "Belum ada aktivitas keuangan bulan ini. Mulailah mencatat transaksi untuk mendapatkan analisis.";
        }

        if ($balance < 0) {
            return "Peringatan: Pengeluaran Anda melebihi pemasukan bulan ini (Defisit). Pertimbangkan untuk meninjau kembali pengeluaran rutin Anda.";
        }

        $ratio = $expense > 0 ? ($income / $expense) : 100;

        if ($ratio > 2) {
            return "Luar biasa! Pemasukan Anda dua kali lipat lebih besar dari pengeluaran. Ini saat yang tepat untuk mempertimbangkan investasi atau perawatan villa.";
        }

        if ($ratio > 1.2) {
            return "Kesehatan keuangan villa Anda stabil. Anda memiliki margin keuntungan yang sehat bulan ini.";
        }

        return "Keuangan Anda cukup ketat bulan ini. Cobalah kurangi pengeluaran non-esensial untuk meningkatkan margin keuntungan.";
    }
}
