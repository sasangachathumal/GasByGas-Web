<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);

    Route::prefix('admin')->group(function () {
        Route::get('dashboard', function () {return view('admin/admin-dashboard');})->name('dashboard');

        Route::get('admin', function () {return view('admin/admin-management');})->name('admin');

        Route::get('outlet', function () {return view('admin/outlet-management');})->name('outlet');

        Route::get('schedule', function () {return view('admin/schedule-management');})->name('schedule');

        Route::get('gas', function () {return view('admin/gas-management');})->name('gas');

        Route::get('gas-request', function () {return view('admin/gas-request-management');})->name('gas-request');

        Route::get('consumer', function () {return view('admin/consumer-management');})->name('consumer');

        Route::get('outlet-manager', function () {return view('admin/outlet-managers');})->name('outlet-manager');

        Route::get('/login', function () {return view('admin/admin-dashboard');});
    });

    Route::prefix('outlet')->group(function () {
        Route::get('dashboard', function () {return view('outlet/outlet-dashboard');})->name('dashboard');

        Route::get('schedule', function () {return view('outlet/schedule-management');})->name('schedule');

        Route::get('/login', function () {return view('outlet/outlet-dashboard');});
    });

    Route::prefix('consumer')->group(function () {
        Route::get('dashboard', function () {return view('consumer/consumer-dashboard');})->name('dashboard');

        Route::get('/login', function () {return view('consumer/consumer-dashboard');});
    });

    Route::get('/logout', [SessionsController::class, 'destroy']);
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::get('/login', function () {return view('session/login-session');});
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {return view('session/login-session');})->name('login');
