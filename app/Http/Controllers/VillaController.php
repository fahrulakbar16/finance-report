<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVillaRequest;
use App\Http\Requests\UpdateVillaRequest;
use App\Actions\Villa\CreateVillaAction;
use App\Actions\Villa\UpdateVillaAction;
use App\Actions\Villa\DeleteVillaAction;

class VillaController extends Controller
{
    public function index()
    {
        $villas = Villa::with('pemilik')->paginate(10);
        $pemiliks = User::role('pemilik')->get(); // Only show users with 'pemilik' role
        return view('villas.index', compact('villas', 'pemiliks'));
    }

    public function store(StoreVillaRequest $request)
    {
        app(CreateVillaAction::class)->execute($request->validated());

        return redirect()->route('villas.index')
            ->with('success', 'Villa successfully created.');
    }

    public function update(UpdateVillaRequest $request, Villa $villa)
    {
        app(UpdateVillaAction::class)->execute($villa, $request->validated());

        return redirect()->route('villas.index')
            ->with('success', 'Villa successfully updated.');
    }

    public function show(Request $request, Villa $villa)
    {
        $query = $villa->transactions()->with('villa');

        // Filter by Date Range
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $transactions = $query->orderBy('date', 'desc')->paginate(15);

        // Calculate Summary specifically for this villa's filtered view
        $statsQuery = clone $query;
        $totalIncome = (clone $statsQuery)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $statsQuery)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('villas.show', compact('villa', 'transactions', 'totalIncome', 'totalExpense', 'balance'));
    }

    public function destroy(Villa $villa)
    {
        app(DeleteVillaAction::class)->execute($villa);

        return redirect()->route('villas.index')
            ->with('success', 'Villa successfully deleted.');
    }
}
