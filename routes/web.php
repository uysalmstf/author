<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;

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

Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'admin'])
        ->middleware(\App\Http\Middleware\RoleMiddleware::class)->name('anasayfa');
    Route::get('/admin', [HomeController::class, 'admin'])->middleware('admin')->name('admin');
    Route::get('/moderator', [HomeController::class, 'moderator'])->name('moderator');
    Route::get('/writer', [HomeController::class, 'writer'])->name('writer');
    Route::get('/reader', [HomeController::class, 'reader'])->name('reader');
    Route::get('/blogs/add', [BlogController::class, 'add']);
    Route::post('/blogs/create', [BlogController::class, 'create']);

});