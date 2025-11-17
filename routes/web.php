<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\UserController;
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

    Route::get('register/step-1', 'showRegisterStep1')->name('register.step1');
    Route::post('register/step-1', 'postRegisterStep1')->name('register.step1.post');
    Route::get('register/step-2', 'showRegisterStep2')->name('register.step2');
    Route::post('register/step-2', 'postRegisterStep2')->name('register.step2.post');
});

Route::middleware(['auth'])->group(function () {
    // Untuk Kasir
    Route::prefix('kasir')->middleware(['role:kasir'])->name('kasir.')->group(function () {
        Route::get('/home', [HomeController::class, 'index']);

        // Product
        Route::resource('products', ProductController::class);
        Route::resource('users', UserController::class);
    });
    // Untuk Admin
    Route::prefix('admin')->middleware(['role:admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});

