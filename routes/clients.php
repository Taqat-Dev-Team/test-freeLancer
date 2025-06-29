<?php

use App\Http\Controllers\Front\Client\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(ProfileController::class)->group(function () {
    Route::middleware(['auth:sanctum', 'verified.email','client'])->prefix('client')->group(function () {
        Route::post('/save-data', 'saveData');
    });

});

