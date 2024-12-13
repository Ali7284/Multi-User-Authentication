<?php

use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\loginController as AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function(){
    return view('welcome');
});

Route::group(['prefix' => "account"], function () {
    
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [LoginController::class, "index"])->name("account.login"); // Login form
        Route::post('login', [LoginController::class, "authenticate"])->name("account.process-login"); // Process login
        Route::get('register', [LoginController::class, "register"])->name("account.register"); // Registration form
        Route::post('register', [LoginController::class, "processRegister"])->name("account.process-register"); // Process registration
    });
    

    Route::group(['middleware' => 'auth'], function () {
        Route::get('dashboard', [DashboardController::class, "index"])->name("account.dashboard"); // Dashboard
        Route::get('logout', [LoginController::class, "logout"])->name("account.logout"); // Logout
    
    });
});



Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard'); // Dashboard
        Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
    });
});
