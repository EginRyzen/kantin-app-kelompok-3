<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login')->name('login.post');
    Route::post('logout', 'logout')->name('logout');
});

Route::middleware(['auth'])->group(function () {
    // Untuk Kasir
    Route::prefix('kasir')->middleware(['role:kasir'])->name('kasir.')->group(function () {
        Route::get('/home', [HomeController::class, 'index']);

        // Product
        Route::resource('products', ProductController::class);
    });
    // Untuk Admin
    Route::prefix('admin')->middleware(['role:admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});

