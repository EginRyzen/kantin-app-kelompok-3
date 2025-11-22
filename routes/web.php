<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OutletController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\CartController; // Pastikan CartController diimport jika belum
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\UserController;
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
    // Untuk Kasir
    Route::prefix('kasir')->middleware(['role:kasir'])->name('kasir.')->group(function () {

        // PERBAIKAN DI SINI: Tambahkan ->name('home')
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // Route Cart (Keranjang) - Tambahkan ini jika belum ada
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
        Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove'); // Bisa pakai post/delete
        Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

        // Route untuk proses checkout/bayar
        Route::post('/transaction/process', [App\Http\Controllers\User\TransactionController::class, 'process'])->name('transaction.process');
        Route::get('/transaction/print/{invoice}', [App\Http\Controllers\User\TransactionController::class, 'printStruk'])->name('transaction.print');

        Route::get('/profile', [UserController::class, 'profile'])->name('profile.index');
        Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');


        // Product
        Route::resource('products', ProductController::class);
        Route::resource('users', UserController::class);
    });

    // Untuk Admin
    Route::prefix('admin')->middleware(['role:admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::patch('/outlets/{outlet}/toggle-status', [OutletController::class, 'toggleStatus'])->name('outlets.toggleStatus');
        Route::resource('outlets', OutletController::class);
        Route::get('/reports/transactions', [ReportController::class, 'index'])->name('reports.transactions');
    });
});
