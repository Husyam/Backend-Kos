<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\profileController;

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
    return view('pages.auth.login');
});


//route middleware auth
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');

    Route::resource('user', UserController::class)->middleware('admin');

    Route::resource('user', UserController::class);


    //get to show profile
    // Route::get('profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('profile', [profileController::class, 'showProfile'])->name('profile');

    //edit profile
    Route::get('profile/edit', [profileController::class, 'editProfile'])->name('user.editProfile');
    //update profile
    Route::put('/user/profile/update', [profileController::class, 'updateProfile'])->name('user.updateProfile');


    //category
    Route::resource('category', CategoryController::class);

    //product
    Route::resource('product', ProductController::class);

    //order
    Route::resource('order', OrderController::class);

    Route::get('orders/download-rekap-pdf', [OrderController::class, 'downloadRekapPdf'])->name('order.downloadRekapPdf');


});
