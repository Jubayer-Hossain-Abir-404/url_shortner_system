<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShortLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware(['auth'])->group(function () {
    Route::get('/', [ShortLinkController::class, 'index'])->name('home');

    Route::post('generate-shorten-link', [ShortLinkController::class, 'store'])->name('generate.shorten.link.post');

    Route::get('edit/{short_link}', [ShortLinkController::class, 'edit'])->name('generate.shorten.link.edit');

    Route::put('update/{short_link}', [ShortLinkController::class, 'update'])->name('generate.shorten.link.update');

    Route::put('update/{short_link}', [ShortLinkController::class, 'update'])->name('generate.shorten.link.update');

    Route::get('delete/{short_link}', [ShortLinkController::class, 'destroy'])->name('deleteShortLink');

    Route::get('{code}', [ShortLinkController::class, 'shortenLink'])->name('shorten.link');

    Route::get('auth/logout', [AuthController::class, 'logout'])->name('logout');

});


Route::middleware(['guest'])->prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');

    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');

    Route::post('/register/submit', [AuthController::class, 'submitRegister'])->name('submitRegister');

    Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('submitLogin');
});
