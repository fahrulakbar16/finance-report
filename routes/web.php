<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PublicVillaController;
use Illuminate\Support\Facades\Auth;

// ── Static villa data (backend team will replace with DB queries) ──

// ── Landing page ──
Route::get('/', fn() => view('welcome'))->name('landing');

// ── Public pages ──
Route::get('/tentang',   fn() => view('customer.pages.tentang'))->name('tentang');
Route::get('/fasilitas', fn() => view('customer.pages.fasilitas'))->name('fasilitas');
Route::get('/testimoni', fn() => view('customer.pages.testimoni'))->name('testimoni');
Route::get('/kontak',    fn() => view('customer.pages.kontak'))->name('kontak');

Route::get('/reservasi/clear-history', [PublicVillaController::class, 'clearHistory'])->name('villa.clear_history');
Route::get('/reservasi/search', [PublicVillaController::class, 'search'])->name('villa.search');
Route::get('/reservasi', [PublicVillaController::class, 'index'])->name('villa.index');
Route::get('/reservasi/{villa}', [PublicVillaController::class, 'show'])->name('villa.show');

// ── Villa collection (nav "Villa" — original simple listing layout) ──
Route::get('/villa', [PublicVillaController::class, 'collection'])->name('villa.collection');

Route::get('/booking', function () {
    return view('customer.pages.booking', ['selectedSlug' => null]);
})->middleware(['auth', 'role:customer'])->name('booking.index');

// ── Auth ──
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware(['auth', 'role:pemilik|pengelola'])
    ->name('home');

// ── Checkout & Payment ──
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/voucher', [App\Http\Controllers\CheckoutController::class, 'applyVoucher'])->name('checkout.voucher');
Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

// Webhook DOKU
Route::match(['get', 'post'], '/doku/notification', [App\Http\Controllers\CheckoutController::class, 'dokuNotification'])->name('doku.notification');

// ── Customer Pages ──
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/login', [App\Http\Controllers\CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\CustomerAuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\CustomerAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'role:customer'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/history', [App\Http\Controllers\CustomerDashboardController::class, 'history'])->name('history');
        Route::get('/account', [App\Http\Controllers\CustomerDashboardController::class, 'account'])->name('account');
    });
});

Route::middleware(['auth', 'role:pemilik|pengelola'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    Route::get('/recurring-transactions', [App\Http\Controllers\RecurringTransactionController::class, 'index'])->name('recurring-transactions.index');
    Route::delete('/recurring-transactions/{recurringTransaction}', [App\Http\Controllers\RecurringTransactionController::class, 'destroy'])->name('recurring-transactions.destroy');

    Route::get('/export/transactions/excel', [App\Http\Controllers\ExportController::class, 'exportAllExcel'])->name('export.excel.all');
    Route::get('/export/transactions/pdf', [App\Http\Controllers\ExportController::class, 'exportAllPdf'])->name('export.pdf.all');
    Route::get('/villas/{villa}/export/excel', [App\Http\Controllers\ExportController::class, 'exportVillaExcel'])->name('export.excel.villa');
});

Route::middleware(['auth', 'role:pengelola'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('villas/{villa}/laporan', [VillaController::class, 'laporan'])->name('villas.laporan');
    Route::resource('villas', VillaController::class);
    Route::resource('admin-fasilitas', \App\Http\Controllers\FasilitasController::class)->parameters(['admin-fasilitas' => 'fasilita'])->names('fasilitas');
    Route::resource('vouchers', \App\Http\Controllers\VoucherController::class);
});
