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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/check', [App\Http\Controllers\WebsiteCheckController::class, 'checkWebsiteStatus']);


Route::middleware('auth')
    ->prefix('personal')
    ->name('personal.')
    ->group(function () {
        Route::get('/', [App\Http\Controllers\WebsiteController::class, 'personal'])->name('index');
        Route::resource('website', App\Http\Controllers\WebsiteController::class)
            ->only([
                'index', 'store', 'create'
            ]);
        Route::middleware('website.belongs.to.user')
            ->resource('website', App\Http\Controllers\WebsiteController::class)
            ->except([
                'index', 'show', 'create', 'store'
            ]);
    });
