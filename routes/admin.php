<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->name('admin')->group(function(){
       
    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
        Route::view('/login', 'back.pages.admin.auth.login')->name('login');
        Route::post('/login_handler',[AdminController::class,'loginHandler'])->name('login_handler');
        Route::view('/forgot-password', 'back.pages.admin.auth.forgot-password')->name('forgot-password');
        Route::post('/send-password-reset-link',[AdminController::class,'sendPasswordResetLink'])->name('send-password-reset-link');
        Route::get('password/reset/{token}',[AdminController::class,'resetPassword'])->name('reset-password');
        Route::post('/reset_password_handler',[AdminController::class,'resetPasswordHandler'])->name('reset_password_handler');        
    });
    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
        Route::view('/home','back.pages.admin.home')->name('home');
        Route::post('/logout_handler',[AdminController::class,'logoutHandler'])->name('logout_handler');
        Route::get('/profile', [AdminController::class, 'profileView'])->name('profile');
        Route::post('/change-profile-picture',[AdminController::class,'changeProfilePicture'])->name('change-profile-picture');
    });
});