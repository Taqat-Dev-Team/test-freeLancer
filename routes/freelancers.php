<?php

use App\Http\Controllers\Front\FreeLancer\ProfileController;
use App\Http\Controllers\Front\FreeLancer\IdentityController;
use App\Http\Controllers\Front\FreeLancer\WorkExperienceController;
use App\Http\Controllers\Front\FreeLancer\EducationController;
use App\Http\Controllers\Front\FreeLancer\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified.email', 'freelancer'])->prefix('freelancer')->group(function () {

    Route::controller(ProfileController::class)->group(function () {
        Route::post('/save-data', 'saveData');
        Route::post('/about', 'updateAbout');
        Route::post('/skills', 'updateSkills');
        Route::post('/languages', 'updateLanguages');
        Route::post('/socials', 'updateSocials');
        Route::post('/summary', 'updateSummary');
        Route::get('/summary', 'summary');
        Route::delete('/summary/image/{id}', 'deleteImageSummary');
        Route::get('/profile-complete', 'profileComplete');
        Route::post('/update-photo', 'updatePhoto');
    });


    Route::middleware('notVerification')->group(function () {
        Route::controller(IdentityController::class)->group(function () {
            Route::post('send-otp', 'sendOtp');
            Route::post('verify-otp', 'verifyOtp');
            Route::post('update-identity', 'updateIdentity');
        });

    });


    Route::apiResource('work-experiences', WorkExperienceController::class);
    Route::apiResource('educations', EducationController::class);
    Route::apiResource('portfolio', PortfolioController::class);
    Route::post('/portfolio/{id}/content-block', [PortfolioController::class, 'deleteContentBlock']);


});

