<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Villa;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query()->with('villa');

        // Restrict by Owner
        if (auth()->user()->hasRole('pemilik')) {
            $query->whereIn('villa_id', auth()->user()->villas->pluck('id'));
        }

        // Filter by Villa
        if ($request->filled('villa_id')) {
            $query->where('villa_id', $request->villa_id);
        }

        // Filter by Date Range
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $incomeTransactions = (clone $query)->where('type', 'income')->orderBy('date', 'desc')->paginate(10, ['*'], 'page_income');
        $expenseTransactions = (clone $query)->where('type', 'expense')->where('is_tanggungan_pemilik', false)->orderBy('date', 'desc')->paginate(10, ['*'], 'page_expense');
        $ownerTransactions = (clone $query)->where('type', 'expense')->where('is_tanggungan_pemilik', true)->orderBy('date', 'desc')->paginate(10, ['*'], 'page_owner');

        $villas = auth()->user()->hasRole('pemilik')
            ? auth()->user()->villas
            : Villa::all();

        $statsQuery = (clone $query)->reorder();
        $totalIncome = (clone $statsQuery)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $statsQuery)->where('type', 'expense')->sum('amount');

        $villasStats = (clone $statsQuery)
            ->selectRaw('villa_id, type, is_tanggungan_pemilik, SUM(amount) as total')
            ->groupBy('villa_id', 'type', 'is_tanggungan_pemilik')
            ->get();

        $bagianPengelola = 0;
        $bagianPemilik = 0;

        $villasData = $villas->keyBy('id');

        $villaProfits = [];
        $tanggunganPemilik = [];

        foreach ($villasStats as $stat) {
            if (!isset($villaProfits[$stat->villa_id])) {
                $villaProfits[$stat->villa_id] = 0;
            }
            if (!isset($tanggunganPemilik[$stat->villa_id])) {
                $tanggunganPemilik[$stat->villa_id] = 0;
            }

            if ($stat->type == 'income') {
                $villaProfits[$stat->villa_id] += $stat->total;
            } else {
                if ($stat->is_tanggungan_pemilik) {
                    $tanggunganPemilik[$stat->villa_id] += $stat->total;
                } else {
                    $villaProfits[$stat->villa_id] -= $stat->total;
                }
            }
        }

        foreach ($villaProfits as $villa_id => $profit) {
            $villa = $villasData[$villa_id] ?? null;
            if ($villa) {
                $bagianPengelola += $profit * ($villa->persenan_pengelola / 100);
                $bagianPemilik += ($profit * ($villa->persenan_pemilik / 100)) - ($tanggunganPemilik[$villa_id] ?? 0);
            }
        }

        return view('transactions.index', compact(
            'incomeTransactions',
            'expenseTransactions',
            'ownerTransactions',
            'villas',
            'totalIncome',
            'totalExpense',
            'bagianPengelola',
            'bagianPemilik'
        ));
    }

    public function store(StoreTransactionRequest $request)
    {
        $data = $request->validated();

        if (filter_var($data['is_recurring'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($data) {
                // 1. Create the Recurring Template
                $recurring = \App\Models\RecurringTransaction::create([
                    'villa_id' => $data['villa_id'],
                    'name' => $data['name'],
                    'amount' => $data['amount'],
                    'type' => $data['type'],
                    'category_id' => $data['category_id'] ?? null,
                    'frequency' => $data['frequency'],
                    'start_date' => $data['date'],
                    'end_date' => $data['end_date'] ?? null,
                ]);

                // 2. Create the First Actual Transaction for this month
                Transaction::create([
                    'villa_id' => $data['villa_id'],
                    'name' => $data['name'],
                    'amount' => $data['amount'],
                    'type' => $data['type'],
                    'category_id' => $data['category_id'] ?? null,
                    'date' => $data['date'],
                    'is_recurring' => true,
                    'recurring_id' => $recurring->id,
                    'is_tanggungan_pemilik' => $data['type'] === 'expense' ? ($data['is_tanggungan_pemilik'] ?? false) : false,
                ]);
            });

            return redirect()->back()->with('success', 'Transaksi rutin berhasil didaftarkan dan pencatatan bulan pertama telah dimasukkan.');
        } else {
            // Normal one-off transaction
            Transaction::create([
                'villa_id' => $data['villa_id'],
                'name' => $data['name'],
                'amount' => $data['amount'],
                'type' => $data['type'],
                'category_id' => $data['category_id'] ?? null,
                'date' => $data['date'],
                'is_recurring' => false,
                'is_tanggungan_pemilik' => $data['type'] === 'expense' ? ($data['is_tanggungan_pemilik'] ?? false) : false,
            ]);

            return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
        }
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
