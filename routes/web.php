<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

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


Route::controller(AuthController::class)->group(function () {
	Route::get('/login', 'index')->name('login');
	Route::post('/login', 'signIn')->name('signIn');

	Route::get('/sign-up', 'signUp')->name('signUp');
	Route::post('/sign-up', 'store')->name('store');

	Route::delete('/logout', 'logOut')->name('logOut');

	Route::get('/forgot-password', 'forgot')->middleware('guest')->name('password.request');

	Route::post('/forgot-password', 'forgotPassword')->middleware('guest')->name('password.email');

	Route::get('/reset-password/{token}', 'reset')->middleware('guest')->name('password.reset');

	Route::post('/reset-password', 'resetPassword')->middleware('guest')->name('password.update');
});


Route::get('/', HomeController::class)->name('home');
