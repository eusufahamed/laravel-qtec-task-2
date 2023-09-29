<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlController;

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

// Home route
Route::get('/', function () {
    return view('home');
})->name('home');

// Registration routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register_form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login_form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Authenticated routes
Route::group(['middleware' => 'auth'], function(){
    // URL-related routes
    Route::get('/create', [UrlController::class, 'create'])->name('url.create');
    Route::post('/store', [UrlController::class, 'store'])->name('url.store');
    Route::get('/statistics', [UrlController::class, 'showStatistic'])->name('statistic');
    Route::get('/click-count', [UrlController::class, 'clickCount'])->name('url.clickCount');
    Route::get('/{shortenedUrl}', [UrlController::class, 'redirect'])->name('url.redirect');

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});






