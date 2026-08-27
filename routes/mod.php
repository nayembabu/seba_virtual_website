<?php

use App\Http\Controllers\Admin\ModController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'mod', 'as' => 'mod.'], function () {
    Route::group(['middleware' => ['auth:admin', 'club_permission']], function () {
        Route::get('/dashboard', [ModController::class, 'index'])->name('index');
        Route::get('/logout', [ModController::class, 'logout'])->name('logout');
        Route::get('/profile', [ModController::class, 'profile'])->name('profile');
        Route::put('/profile', [ModController::class, 'profileUpdate'])->name('profileUpdate');
        Route::get('/password', [ModController::class, 'password'])->name('password');
        Route::put('/password', [ModController::class, 'passwordUpdate'])->name('passwordUpdate');

        Route::get('/applications', [ModController::class, 'applications'])->name('applications');
        Route::get('/my-applications', [ModController::class, 'my_applications'])->name('my-applications');
        Route::post('/accept-application/{id}', [ModController::class, 'accept_application'])->name('accept-application');
        Route::post('/cancel-application', [ModController::class, 'cancel_application'])->name('cancel-application');
        Route::post('/deliver-application', [ModController::class, 'deliver_application'])->name('deliver-application');
        Route::post('/redeliver-application', [ModController::class, 'redeliver_application'])->name('redeliver-application');
        Route::post('/check-applications', [ModController::class, 'check_applications'])->name('check-applications');
        Route::post('/photo-application', [ModController::class, 'photo_application'])->name('photo-application');
    });
});