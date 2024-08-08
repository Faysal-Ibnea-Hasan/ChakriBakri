<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/all-jobs', [JobController::class, 'index'])->name('all.jobs');








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
        Route::put('/account/update/profile', [UserController::class, 'userProfileUpdate'])->name('account.profile.update');
        Route::get('/account/create_job', [UserController::class, 'createJob'])->name('account.create.job');
        Route::get('/account/my_job', [UserController::class, 'myJob'])->name('account.my.job');
        Route::get('/account/my_job/edit/{jobId}', [UserController::class, 'editJob'])->name('account.edit.job');
        Route::post('/account/update_job/{jobId}', [UserController::class, 'updateJob'])->name('account.update.job');
        Route::post('/account/delete_job', [UserController::class, 'deleteJob'])->name('account.delete.job');
        Route::post('/account/save_job', [UserController::class, 'saveJob'])->name('account.save.job');
        Route::post('/account/update/profile-pic', [UserController::class, 'updateProfilePic'])->name('account.profile-pic.update');
        Route::get('/account/logout', [UserController::class, 'userLogout'])->name('account.logout');
    });
});
