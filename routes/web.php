<?php

use Illuminate\Support\Facades\Route;


Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return redirect()->route('home');
});




Route::get('/link', function () {
    Artisan::call('storage:link');
});


Route::get('/', function () {
    return redirect()->route('admin.login');
})->name('home');


require  __DIR__.'/Admin/admin.php';

