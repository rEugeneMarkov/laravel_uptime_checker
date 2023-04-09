<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//Route::resource('personal', App\Http\Controllers\WebsiteController::class);

// Route::get('/personal', function () {
//     return view('personal');
// })->name('personal');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')
    ->prefix('personal')
    ->name('personal.')
    ->group(function () {
        Route::get('/', [App\Http\Controllers\PersonalController::class, 'index'])->name('index');
        Route::get('/profile', [App\Http\Controllers\PersonalController::class, 'profile'])->name('profile');
        Route::resource('website', App\Http\Controllers\WebsiteController::class)
            ->only([
                'index', 'store', 'create'
            ]);
        Route::middleware('website.belongs.to.user')
            ->group(function () {
                Route::resource('website', App\Http\Controllers\WebsiteController::class)
                    ->except(['index', 'create', 'store']);

                Route::get('/website/{website}/chengeStatus', [App\Http\Controllers\WebsiteController::class, 'activate'])
                ->name('website.activate');
            });
    });
