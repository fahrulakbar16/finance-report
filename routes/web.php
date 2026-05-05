<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\UserController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:pemilik|pengelola'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // M6 Export Routes
    Route::get('/export/transactions/excel', [App\Http\Controllers\ExportController::class, 'exportAllExcel'])->name('export.excel.all');
    Route::get('/export/transactions/pdf', [App\Http\Controllers\ExportController::class, 'exportAllPdf'])->name('export.pdf.all');
    Route::get('/villas/{villa}/export/excel', [App\Http\Controllers\ExportController::class, 'exportVillaExcel'])->name('export.excel.villa');
});

Route::middleware(['auth', 'role:pengelola'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('villas', VillaController::class);
});
