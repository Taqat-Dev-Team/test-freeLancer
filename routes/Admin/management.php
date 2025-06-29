<?php

use App\Http\Controllers\Admin\Management\BadgesController;
use App\Http\Controllers\Admin\Management\CategoryController;
use App\Http\Controllers\Admin\Management\CountryController;
use App\Http\Controllers\Admin\Management\EducationLevelController;
use App\Http\Controllers\Admin\Management\languageController;
use App\Http\Controllers\Admin\Management\SkillsController;
use App\Http\Controllers\Admin\Management\SocialMediaController;
use App\Http\Controllers\Admin\Management\SubCategoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->group(function () {


    Route::middleware('admin')->group(function () {


        Route::name('management.')->group(function () {

            Route::controller(CategoryController::class)->group(function () {
                Route::get('categories', 'index')->name('categories.index');
                Route::get('categories/data', 'getData')->name('categories.data');
                Route::post('categories', 'store')->name('categories.store');
                Route::get('categories/{id}/show', 'show')->name('categories.show');
                Route::put('categories/{id}', 'update')->name('categories.update');
                Route::delete('categories/{id}', 'destroy')->name('categories.destroy');
            });


            Route::controller(SubCategoryController::class)->group(function () {
                Route::get('subcategories', 'index')->name('subcategories.index');
                Route::get('subcategories/data', 'getData')->name('subcategories.data');
                Route::post('subcategories', 'store')->name('subcategories.store');
                Route::get('subcategories/{id}/show', 'show')->name('subcategories.show');
                Route::put('subcategories/{id}', 'update')->name('subcategories.update');
                Route::delete('subcategories/{id}', 'destroy')->name('subcategories.destroy');

            });

            Route::controller(CountryController::class)->group(function () {
                Route::get('countries', 'index')->name('countries.index');
                Route::get('countries/data', 'getData')->name('countries.data');
                Route::post('countries', 'store')->name('countries.store');
                Route::get('countries/{id}/show', 'show')->name('countries.show');
                Route::put('countries/{id}', 'update')->name('countries.update');
                Route::delete('countries/{id}', 'destroy')->name('countries.destroy');
                Route::post('countries/change-status', 'changeStatus')->name('countries.changeStatus');

            });

            Route::controller(SkillsController::class)->group(function () {
                Route::get('skills', 'index')->name('skills.index');
                Route::get('skills/data', 'getData')->name('skills.data');
                Route::post('skills', 'store')->name('skills.store');
                Route::get('skills/{id}/show', 'show')->name('skills.show');
                Route::put('skills/{id}', 'update')->name('skills.update');
                Route::delete('skills/{id}', 'destroy')->name('skills.destroy');
            });


            Route::controller(EducationLevelController::class)->group(function () {
                Route::get('educations', 'index')->name('educations.index');
                Route::get('educations/data', 'getData')->name('educations.data');
                Route::post('educations', 'store')->name('educations.store');
                Route::get('educations/{id}/show', 'show')->name('educations.show');
                Route::put('educations/{id}', 'update')->name('educations.update');
                Route::delete('educations/{id}', 'destroy')->name('educations.destroy');
            });

            Route::controller(SocialMediaController::class)->group(function () {
                Route::get('socials', 'index')->name('socials.index');
                Route::get('socials/data', 'getData')->name('socials.data');
                Route::post('socials', 'store')->name('socials.store');
                Route::get('socials/{id}/show', 'show')->name('socials.show');
                Route::put('socials/{id}', 'update')->name('socials.update');
                Route::delete('socials/{id}', 'destroy')->name('socials.destroy');
            });

            Route::controller(BadgesController::class)->group(function () {
                Route::get('badges', 'index')->name('badges.index');
                Route::get('badges/data', 'getData')->name('badges.data');
                Route::post('badges', 'store')->name('badges.store');
                Route::get('badges/{id}/show', 'show')->name('badges.show');
                Route::put('badges/{id}', 'update')->name('badges.update');
                Route::delete('badges/{id}', 'destroy')->name('badges.destroy');
            });

            Route::controller(languageController::class)->group(function () {
                Route::get('languages', 'index')->name('languages.index');
                Route::get('languages/data', 'getData')->name('languages.data');
                Route::post('languages', 'store')->name('languages.store');
                Route::get('languages/{id}/show', 'show')->name('languages.show');
                Route::put('languages/{id}', 'update')->name('languages.update');
                Route::delete('languages/{id}', 'destroy')->name('languages.destroy');
            });


        });
    });


    });
