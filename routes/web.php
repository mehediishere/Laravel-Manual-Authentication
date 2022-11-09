<?php

use Illuminate\Support\Facades\Route;

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

// General routes
Route::get('/', function (){ return view('index'); });
Route::get('/home', function (){ return view('index'); });

// Routes that only accessible when user not logged in
Route::middleware('guest')->controller(\App\Http\Controllers\GuestController::class)->group(function (){
    Route::get('/login', 'viewLogin')->name('login');
    Route::get('/registration', 'viewRegistration')->name('registration');
    Route::post('/user-login', 'userLoginBtn')->name('login.credentials');
    Route::post('/new-user-registration', 'userRegistrationBtn')->name('registration.credentials');
});

// Routes that only accessible when user is logged in
Route::middleware('auth')->controller(\App\Http\Controllers\UserController::class)->group(function (){
    Route::get('/profile', 'viewProfile')->name('profile');
    Route::get('/logout', 'userLogOutBtn')->name('logout');
});
