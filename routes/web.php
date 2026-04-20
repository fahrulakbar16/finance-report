<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:pemilik|pengelola'])->group(function () {
    Route::get('/finance', [FinanceReportController::class, 'index'])->name('finance.index');
});

Route::middleware(['auth', 'role:pengelola'])->group(function () {
    Route::resource('users', UserController::class);
});
