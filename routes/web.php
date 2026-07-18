<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PublicVillaController;
use Illuminate\Support\Facades\Auth;

// ── Static villa data (backend team will replace with DB queries) ──
$villaList = [
    [
        'slug'        => 'villa-arjuna',
        'name'        => 'Villa Arjuna',
        'tagline'     => 'Surga tersembunyi di tengah alam',
        'price'       => 2500000,
        'capacity'    => 8,
        'bedrooms'    => 4,
        'bathrooms'   => 4,
        'size'        => '600 m²',
        'badge'       => 'Most Popular',
        'hero'        => 'https://images.unsplash.com/photo-1540541338537-1220059af400?q=80&w=1600&auto=format&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1540541338537-1220059af400?q=80&w=800&auto=format&fit=crop',
        'gallery'     => [
            'https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?q=80&w=900&auto=format&fit=crop',
        ],
        'description' => 'Villa Arjuna adalah surga tersembunyi yang menawarkan ketenangan dan kemewahan dalam satu paket. Dengan luas 600 m², villa ini memiliki 4 kamar tidur yang luas, private pool berukuran besar, area BBQ, dan pemandangan alam yang menakjubkan. Cocok untuk keluarga besar, reuni teman, atau corporate retreat.',
        'facilities'  => ['Private Pool', 'BBQ Area', 'Dapur Lengkap', 'Smart TV 55"', 'WiFi Cepat', 'AC di Setiap Ruang', 'Parkir Luas', 'Outdoor Shower', 'Living Room Luas', 'Gazebo'],
        'nearby'      => [['name' => 'Pasar Seni Batu', 'dist' => '2 km'], ['name' => 'BNS', 'dist' => '5 km'], ['name' => 'Jatim Park', 'dist' => '7 km'], ['name' => 'Selecta', 'dist' => '4 km']],
    ],
    [
        'slug'        => 'villa-dewi',
        'name'        => 'Villa Dewi',
        'tagline'     => 'Romantisme di setiap sudut',
        'price'       => 1800000,
        'capacity'    => 6,
        'bedrooms'    => 3,
        'bathrooms'   => 3,
        'size'        => '450 m²',
        'badge'       => null,
        'hero'        => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?q=80&w=1600&auto=format&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?q=80&w=800&auto=format&fit=crop',
        'gallery'     => [
            'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1540541338537-1220059af400?q=80&w=900&auto=format&fit=crop',
        ],
        'description' => 'Villa Dewi menawarkan nuansa tropis yang hangat dengan dekorasi alami yang elegan. Dengan 3 kamar tidur nyaman dan private pool yang jernih, villa ini adalah pilihan sempurna untuk pasangan honeymoon, anniversary, atau liburan romantis.',
        'facilities'  => ['Private Pool', 'Dapur Lengkap', 'Smart TV', 'WiFi Cepat', 'AC', 'Parkir', 'Bathtub Premium', 'Garden View', 'Outdoor Dining', 'Breakfast Set'],
        'nearby'      => [['name' => 'Museum Angkut', 'dist' => '3 km'], ['name' => 'Alun-Alun Batu', 'dist' => '2.5 km'], ['name' => 'Wisata Petik Apel', 'dist' => '8 km']],
    ],
    [
        'slug'        => 'villa-surya',
        'name'        => 'Villa Surya',
        'tagline'     => 'Kemewahan untuk rombongan',
        'price'       => 3500000,
        'capacity'    => 12,
        'bedrooms'    => 5,
        'bathrooms'   => 5,
        'size'        => '800 m²',
        'badge'       => 'Best for Groups',
        'hero'        => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=1600&auto=format&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=800&auto=format&fit=crop',
        'gallery'     => [
            'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=900&auto=format&fit=crop',
        ],
        'description' => 'Villa Surya adalah villa terbesar kami dengan luas 800 m² dan kapasitas hingga 12 orang. Dilengkapi 5 kamar tidur mewah, private pool besar, ruang meeting, dan area BBQ — ideal untuk corporate gathering, reuni keluarga besar, atau kelompok wisata.',
        'facilities'  => ['Private Pool Besar', 'BBQ Area', 'Ruang Meeting', 'Dapur Lengkap', 'Smart TV', 'WiFi Cepat', 'AC di Setiap Ruang', 'Parkir Luas', 'Billiard', 'Karaoke', 'Game Room'],
        'nearby'      => [['name' => 'Eco Green Park', 'dist' => '4 km'], ['name' => 'Jatim Park 2', 'dist' => '6 km'], ['name' => 'Songgoriti', 'dist' => '5 km']],
    ],
    [
        'slug'        => 'villa-bintang',
        'name'        => 'Villa Bintang',
        'tagline'     => 'Nyaman untuk keluarga kecil',
        'price'       => 1200000,
        'capacity'    => 4,
        'bedrooms'    => 2,
        'bathrooms'   => 2,
        'size'        => '280 m²',
        'badge'       => null,
        'hero'        => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?q=80&w=1600&auto=format&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?q=80&w=800&auto=format&fit=crop',
        'gallery'     => [
            'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?q=80&w=900&auto=format&fit=crop',
        ],
        'description' => 'Villa Bintang hadir untuk keluarga kecil atau pasangan yang ingin menikmati liburan tanpa ribet. Desain minimalis modern dengan private pool yang menyegarkan dan suasana tenang yang membuat betah.',
        'facilities'  => ['Private Pool', 'Dapur Lengkap', 'Smart TV', 'WiFi Cepat', 'AC', 'Parkir 2 Mobil', 'Taman Pribadi'],
        'nearby'      => [['name' => 'Alun-Alun Batu', 'dist' => '1.5 km'], ['name' => 'Pasar Minggu Batu', 'dist' => '2 km'], ['name' => 'BNS', 'dist' => '4 km']],
    ],
    [
        'slug'        => 'villa-kenanga',
        'name'        => 'Villa Kenanga',
        'tagline'     => 'Sentuhan alam yang autentik',
        'price'       => 2000000,
        'capacity'    => 6,
        'bedrooms'    => 3,
        'bathrooms'   => 3,
        'size'        => '400 m²',
        'badge'       => null,
        'hero'        => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=1600&auto=format&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=800&auto=format&fit=crop',
        'gallery'     => [
            'https://images.unsplash.com/photo-1540541338537-1220059af400?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1613977257363-707ba9348227?q=80&w=900&auto=format&fit=crop',
        ],
        'description' => 'Villa Kenanga menghadirkan suasana alam yang autentik dengan sentuhan tradisional Jawa yang hangat. Dikelilingi tanaman tropis rimbun, villa ini memberikan ketenangan yang sesungguhnya, jauh dari hiruk-pikuk kota.',
        'facilities'  => ['Private Pool', 'Dapur Lengkap', 'WiFi Cepat', 'AC', 'Parkir', 'Kebun Pribadi', 'Gazebo Tepi Pool'],
        'nearby'      => [['name' => 'Air Terjun Coban Rais', 'dist' => '6 km'], ['name' => 'Hutan Pinus', 'dist' => '3 km'], ['name' => 'Selecta', 'dist' => '5 km']],
    ],
    [
        'slug'        => 'villa-pandan',
        'name'        => 'Villa Pandan',
        'tagline'     => 'Modern & elegan berpadu sempurna',
        'price'       => 4000000,
        'capacity'    => 8,
        'bedrooms'    => 4,
        'bathrooms'   => 4,
        'size'        => '520 m²',
        'badge'       => 'New',
        'hero'        => 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?q=80&w=1600&auto=format&fit=crop',
        'thumb'       => 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?q=80&w=800&auto=format&fit=crop',
        'gallery'     => [
            'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?q=80&w=900&auto=format&fit=crop',
        ],
        'description' => 'Villa Pandan adalah villa terbaru kami yang mengusung konsep modern minimalis dengan sentuhan mewah. Dilengkapi perabotan kelas dunia, infinity pool dengan view panorama, dan sistem smart home yang canggih.',
        'facilities'  => ['Infinity Pool', 'Smart Home', 'Dapur Modern', 'Smart TV 65"', 'WiFi Fiber', 'AC Inverter', 'Parkir 4 Mobil', 'Bathtub Freestanding', 'BBQ Outdoor'],
        'nearby'      => [['name' => 'Wisata Petik Apel', 'dist' => '5 km'], ['name' => 'Museum Angkut', 'dist' => '4 km'], ['name' => 'Jatim Park 3', 'dist' => '8 km']],
    ],
];

// ── Landing page ──
Route::get('/', fn() => view('welcome'))->name('landing');

// ── Public pages ──
Route::get('/tentang',   fn() => view('customer.pages.tentang'))->name('tentang');
Route::get('/fasilitas', fn() => view('customer.pages.fasilitas'))->name('fasilitas');
Route::get('/testimoni', fn() => view('customer.pages.testimoni'))->name('testimoni');
Route::get('/kontak',    fn() => view('customer.pages.kontak'))->name('kontak');

Route::get('/villa/clear-history', [PublicVillaController::class, 'clearHistory'])->name('villa.clear_history');
Route::get('/villa/search', [PublicVillaController::class, 'search'])->name('villa.search');
Route::get('/villa', [PublicVillaController::class, 'index'])->name('villa.index');
Route::get('/villa/{villa}', [PublicVillaController::class, 'show'])->name('villa.show');

Route::get('/booking', function () use ($villaList) {
    return view('customer.pages.booking', ['villas' => $villaList, 'selectedSlug' => null]);
})->middleware(['auth', 'role:customer'])->name('booking.index');

Route::get('/booking/{slug}', function ($slug) use ($villaList) {
    $villa = collect($villaList)->firstWhere('slug', $slug);
    abort_if(!$villa, 404);
    return view('customer.pages.booking', ['villas' => $villaList, 'selectedSlug' => $slug]);
})->middleware(['auth', 'role:customer'])->name('booking.show');

// ── Auth ──
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware(['auth', 'role:pemilik|pengelola'])
    ->name('home');

// ── Checkout & Payment ──
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/voucher', [App\Http\Controllers\CheckoutController::class, 'applyVoucher'])->name('checkout.voucher');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
});

// Webhook DOKU
Route::post('/doku/notification', [App\Http\Controllers\CheckoutController::class, 'dokuNotification'])->name('doku.notification');

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
    Route::resource('villas', VillaController::class);
    Route::resource('admin-fasilitas', \App\Http\Controllers\FasilitasController::class)->parameters(['admin-fasilitas' => 'fasilita'])->names('fasilitas');
});
