<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');







Route::group(['account'], function () {
    //Guest routes
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/account/registration', [UserController::class, 'userRegistration'])->name('account.reg');
        Route::post('/account/registration/process', [UserController::class, 'userRegistrationProcess'])->name('account.reg.process');
        Route::get('/account/login', [UserController::class, 'userLogin'])->name('account.login');
        Route::post('/account/auth', [UserController::class, 'userAuth'])->name('account.auth');
    });

    //Auth routes
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/account/profile', [UserController::class, 'userProfile'])->name('account.profile');
        Route::get('/account/logout', [UserController::class, 'userLogout'])->name('account.logout');
    });
});
