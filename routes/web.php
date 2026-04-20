<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\FinanceReportController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:pemilik|pengelola'])->group(function () {
    Route::get('/finance', [FinanceReportController::class, 'index'])->name('finance.index');
});
