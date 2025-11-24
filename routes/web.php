<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OutletController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login')->name('login.post');
    Route::post('logout', 'logout')->name('logout');

    Route::get('register/outlet', 'showRegisterStep1')->name('register.step1');
    Route::post('register/step-1', 'postRegisterStep1')->name('register.step1.post');
    Route::get('register/user', 'showRegisterStep2')->name('register.step2');
    Route::post('register/step-2', 'postRegisterStep2')->name('register.step2.post');
});

Route::middleware(['auth'])->group(function () {
    
    // ====================================================
    // GROUP KHUSUS KASIR
    // ====================================================
    Route::prefix('kasir')->middleware(['role:kasir'])->name('kasir.')->group(function () {

        // 1. Home & Keranjang
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
        Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
        Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

        // 2. Transaksi
        Route::post('/transaction/process', [TransactionController::class, 'process'])->name('transaction.process');
        Route::get('/transaction/print/{invoice}', [TransactionController::class, 'printStruk'])->name('transaction.print');

        // 3. Profil & Akun
        Route::get('/profile', [UserController::class, 'profile'])->name('profile.index');
        Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
        
        // 4. Laporan Kasir (Pendapatan & Transaksi Kasir)
        Route::get('/profile/income', [UserController::class, 'income'])->name('profile.income');
        Route::get('/profile/transactions', [UserController::class, 'transactions'])->name('profile.transactions');

        // 5. LAPORAN TOKO (MENU DOMPET)
        Route::get('/store-report', [UserController::class, 'storeReport'])->name('store.report');
        
        // --- ROUTE DETAIL LAPORAN TOKO (TAMBAHKAN INI) ---
        Route::get('/store-report/today', [UserController::class, 'reportToday'])->name('store.report.today');
        Route::get('/store-report/week', [UserController::class, 'reportWeek'])->name('store.report.week');
        Route::get('/store-report/month', [UserController::class, 'reportMonth'])->name('store.report.month');
        Route::get('/store-report/performance', [UserController::class, 'reportPerformance'])->name('store.report.performance');

        // 6. Produk & User Resource
        Route::resource('products', ProductController::class);
        Route::resource('users', UserController::class);
    });
    // ====================================================
    // GROUP KHUSUS ADMIN
    // ====================================================
    Route::prefix('admin')->middleware(['role:admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::patch('/outlets/{outlet}/toggle-status', [OutletController::class, 'toggleStatus'])->name('outlets.toggleStatus');
        Route::resource('outlets', OutletController::class);
        Route::get('/reports/transactions', [ReportController::class, 'index'])->name('reports.transactions');
        Route::resource('cashiers', AdminUserController::class);
    });
});