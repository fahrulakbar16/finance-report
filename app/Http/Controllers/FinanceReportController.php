<?php

namespace App\Http\Controllers;

use App\Models\FinanceReport;
use Illuminate\Http\Request;

class FinanceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = FinanceReport::orderBy('date', 'desc')->get();
        $totalIncome = FinanceReport::where('type', 'income')->sum('amount');
        $totalExpense = FinanceReport::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('finance.index', compact('reports', 'totalIncome', 'totalExpense', 'balance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FinanceReport $financeReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinanceReport $financeReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinanceReport $financeReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinanceReport $financeReport)
    {
        //
    }
}
