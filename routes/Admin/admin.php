<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ContactController;


Route::prefix('admin')->name('admin.')->group(function () {

    Route::controller(AdminAuthController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login')->name('login.submit');
    });

    Route::middleware('admin')->group(function () {


        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::controller(AdminAuthController::class)->group(function () {
            Route::post('logout', 'logout')->name('logout');
            Route::view('profile', 'admin.profile')->name('profile');
            Route::post('profile', 'updateProfile')->name('profile.update');
        });


        Route::controller(ContactController::class)->group(function () {
            Route::get('contacts', 'index')->name('contacts.index');
            Route::get('contacts/data', 'getData')->name('contacts.data');
            Route::get('contacts/{id}/show', 'show')->name('contacts.show');
            Route::delete('contacts/{id}', 'destroy')->name('contacts.destroy');
            Route::post('contacts/reply{id}', 'reply')->name('contacts.reply');

        });


    });


});



require  __DIR__.'/management.php';
require  __DIR__.'/freelancers.php';
