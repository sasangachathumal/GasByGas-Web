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

        Route::get('admin-management', function () {return view('admin/admin-management');})->name('admin-management');

        Route::get('outlet-management', function () {return view('admin/outlet-management');})->name('outlet-management');

        Route::get('schedule-management', function () {return view('admin/schedule-management');})->name('schedule-management');

        Route::get('gas-management', function () {return view('admin/gas-management');})->name('gas-management');

        Route::get('gas-request-management', function () {return view('admin/gas-request-management');})->name('gas-request-management');
    });

    Route::prefix('outlet')->group(function () {
        Route::get('dashboard', function () {return view('outlet/outlet-dashboard');})->name('dashboard');

        Route::get('schedule-management', function () {return view('outlet/schedule-management');})->name('schedule-management');

        Route::get('gas-request-management', function () {return view('outlet/gas-request-management');})->name('gas-request-management');
    });

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
    // Route::get('/register', [RegisterController::class, 'create']);
    // Route::post('/register', [RegisterController::class, 'store']);
    // Route::post('/session', [SessionsController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::get('/login', function () {return view('session/login-session');});
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {return view('session/login-session');})->name('login');
