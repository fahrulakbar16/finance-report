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

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return $this->fallbackAiInsight($income, $expense, $balance);
        }

        $cacheKey = "ai_insight_" . date('Y_m_d_G'); // Cache per hour

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 60 * 60, function () use ($income, $expense, $balance, $apiKey) {
            $prompt = "Sebagai penasihat keuangan Villa cerdas, sapa pengguna dan tinjau data ini: Pemasukan Rp" . number_format($income, 0, ',', '.') . ", Pengeluaran Rp" . number_format($expense, 0, ',', '.') . " (Saldo: Rp" . number_format($balance, 0, ',', '.') . "). Berikan 1-2 kalimat (maksimal 25 kata) analisis tajam atau saran praktis berbahasa Indonesia. Jangan gunakan tanda bintang tebal (*).";

            try {
                $response = \Illuminate\Support\Facades\Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    return $text ? trim($text) : $this->fallbackAiInsight($income, $expense, $balance);
                }

                return $this->fallbackAiInsight($income, $expense, $balance);
            } catch (\Exception $e) {
                return $this->fallbackAiInsight($income, $expense, $balance);
            }
        });
    }

    private function fallbackAiInsight($income, $expense, $balance)
    {
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
