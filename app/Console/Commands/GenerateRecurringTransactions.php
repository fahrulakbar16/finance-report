<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RecurringTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GenerateRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finance:generate-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new transactions from recurring templates if they are due today.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan transaksi rutin...');
        $today = Carbon::now()->startOfDay();

        // Ambil semua transaksi recurring yang belum berakhir
        $recurrings = RecurringTransaction::where(function ($query) use ($today) {
            $query->whereNull('end_date')
                  ->orWhere('end_date', '>=', $today);
        })->get();

        $generatedCount = 0;

        foreach ($recurrings as $recurring) {
            // Cari transaksi tercatat terakhir dari recurring ini
            $latestTransaction = Transaction::where('recurring_id', $recurring->id)
                ->orderBy('date', 'desc')
                ->first();

            if (!$latestTransaction) {
                // Jika entah bagaimana transaksi awal belum dibuat, set ke start_date
                $nextDate = Carbon::parse($recurring->start_date)->startOfDay();
            } else {
                $lastDate = Carbon::parse($latestTransaction->date)->startOfDay();

                // Hitung jadwal berikutnya berdasarkan frekuensi
                switch ($recurring->frequency) {
                    case 'daily':
                        $nextDate = $lastDate->copy()->addDay();
                        break;
                    case 'weekly':
                        $nextDate = $lastDate->copy()->addWeek();
                        break;
                    case 'monthly':
                        $nextDate = $lastDate->copy()->addMonthNoOverflow();
                        break;
                    case 'yearly':
                        $nextDate = $lastDate->copy()->addYearNoOverflow();
                        break;
                    default:
                        $nextDate = $lastDate->copy()->addDay();
                }
            }

            // Selama jadwal berikutnya sudah lewat/hari ini, DAN tidak melewati end_date (jika ada)
            // Lakukan WHILE agar bisa catch-up jika cron job sempat mati berhari-hari
            while ($today->greaterThanOrEqualTo($nextDate)) {
                if ($recurring->end_date && $nextDate->greaterThan(Carbon::parse($recurring->end_date)->startOfDay())) {
                    break;
                }

                Transaction::create([
                    'villa_id' => $recurring->villa_id,
                    'name' => $recurring->name,
                    'amount' => $recurring->amount,
                    'type' => $recurring->type,
                    'category_id' => $recurring->category_id,
                    'date' => $nextDate->format('Y-m-d'),
                    'is_recurring' => true,
                    'recurring_id' => $recurring->id,
                ]);

                $this->line("Melahirkan transaksi {$recurring->name} untuk tanggal {$nextDate->format('Y-m-d')}");
                $generatedCount++;

                // Lanjut hitung tanggal berikutnya untuk iterasi 'while' (jika masih kurang dari hari ini)
                switch ($recurring->frequency) {
                    case 'daily':
                        $nextDate->addDay();
                        break;
                    case 'weekly':
                        $nextDate->addWeek();
                        break;
                    case 'monthly':
                        $nextDate->addMonthNoOverflow();
                        break;
                    case 'yearly':
                        $nextDate->addYearNoOverflow();
                        break;
                }
            }
        }

        $this->info("Pengecekan selesai! Sebanyak {$generatedCount} transaksi baru telah berhasil dicatatkan.");
        Log::info("Command finance:generate-recurring dijalankan. Tersimpan {$generatedCount} transaksi.");
    }
}
