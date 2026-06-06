<?php

namespace App\Http\Controllers;

use App\Models\RecurringTransaction;
use Illuminate\Http\Request;

class RecurringTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = RecurringTransaction::query()->with('villa');

        // Restrict by Owner
        if (auth()->user()->hasRole('pemilik')) {
            $query->whereIn('villa_id', auth()->user()->villas->pluck('id'));
        }

        $recurringTransactions = $query->orderBy('start_date', 'desc')->paginate(10);

        return view('recurring_transactions.index', compact('recurringTransactions'));
    }

    public function destroy(RecurringTransaction $recurringTransaction)
    {
        // Restrict by Owner
        if (auth()->user()->hasRole('pemilik')) {
            $userVillaIds = auth()->user()->villas->pluck('id')->toArray();
            if (!in_array($recurringTransaction->villa_id, $userVillaIds)) {
                abort(403, 'Unauthorized action.');
            }
        }

        $recurringTransaction->delete();
        return redirect()->back()->with('success', 'Pengeluaran rutin berhasil dihentikan (dihapus).');
    }
}
