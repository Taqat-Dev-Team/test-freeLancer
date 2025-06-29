<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FreeLancer\FreeLancerVerificationRequestsController;


Route::prefix('admin')->name('admin.')->group(function () {


    Route::middleware('admin')->group(function () {


        Route::name('freelancers.')->group(function () {

            Route::name('request.')->prefix('freelancer/verification-request')->group(function () {

                Route::controller(FreeLancerVerificationRequestsController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/data', 'data')->name('data');
                Route::get('/{id}/show', 'show')->name('show');
                Route::post('/{id}/{action}', 'handleAction')->name('handleAction');
                Route::delete('/{id}', 'delete')->name('delete');

            });
            });

        });

    });

});
