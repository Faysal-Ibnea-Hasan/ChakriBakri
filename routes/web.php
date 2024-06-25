<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/account/registration',[UserController::class,'userRegistration'])->name('account.reg');
Route::post('/account/registration/process',[UserController::class,'userRegistrationProcess'])->name('account.reg.process');
Route::get('/account/login',[UserController::class,'userLogin'])->name('account.login');

