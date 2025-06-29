<?php

use App\Http\Controllers\Front\Auth\AuthController;
use App\Http\Controllers\Front\Auth\SocialAuthController;
use App\Http\Controllers\Front\GeneralController;

use App\Http\Controllers\Front\Auth\ForgotPasswordController;
use App\Http\Controllers\Front\Auth\ResetPasswordController;

use Illuminate\Support\Facades\Route;



//Google Auth
Route::controller(SocialAuthController::class)->group(function () {
    Route::get('/auth/google', 'redirectToGoogle');
    Route::get('/auth/google/callback', 'handleGoogleCallback');
});


// Forgot Password / Reset Password Routes
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forget-password', 'sendResetLinkEmail');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('/reset-password', 'reset'); // لإعادة تعيين كلمة المرور
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/verify-otp', 'verifyOtp');
    Route::post('/resend-otp', 'resendOtp');

    Route::middleware(['auth:sanctum', 'verified.email'])->group(function () {
        Route::get('/profile', 'profile');
        Route::post('/account-type', 'type');
        Route::post('/lang', 'lang');
        Route::post('/logout', 'logout');
    });

});




Route::controller(GeneralController::class)->group(function () {
    Route::get('/policies', 'policies');
    Route::get('/skills', 'skills');
    Route::get('/skills/{id}', 'categorySkills');
    Route::get('/categories', 'categories');
    Route::get('/countries', 'countries');
    Route::get('/subcategories', 'subcategories');
    Route::get('/subcategories/{id}', 'CategorySubcategories');
    Route::get('/education-levels', 'education_levels');
    Route::get('/social', 'social');
    Route::get('/languages', 'languages');
    Route::get('/languages_levels', 'languages_levels');
    Route::get('/work_type', 'work_type');
    Route::get('/grade', 'grade');
});



require  __DIR__ . '/freelancers.php';
require  __DIR__ . '/clients.php';
