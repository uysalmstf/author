<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ModeratorMiddleware;
use App\Http\Middleware\WriterMiddleware;

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

Route::get('/auth/login', [AuthController::class, 'index'])->name('auth.login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login.post');

Route::get('/blogs', [BlogController::class, 'list'])->name('blogs');
Route::get('/blogs/read_me/{id}', [BlogController::class, 'main_read'])->name('main.read');

Route::get('/register', [UserController::class, 'index'])->name('auth.register');
Route::post('/register', [UserController::class, 'register'])->name('auth.register.post');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/', [HomeController::class, 'admin'])
        ->middleware(\App\Http\Middleware\RoleMiddleware::class)->name('anasayfa');
    Route::get('/admin', [HomeController::class, 'admin'])->middleware(AdminMiddleware::class)->name('admin');
    Route::get('/moderator', [HomeController::class, 'moderator'])->middleware(ModeratorMiddleware::class)->name('moderator');
    Route::get('/writer', [HomeController::class, 'writer'])->middleware(WriterMiddleware::class)->name('writer');
    Route::get('/reader', [HomeController::class, 'reader'])->name('reader');
    Route::get('/blogs/add', [BlogController::class, 'add']);
    Route::post('/blogs/create', [BlogController::class, 'create']);
    Route::get('/blogs/edit/{id}', [BlogController::class, 'edit'])->name('edit');
    Route::get('/blogs/publish/{id}', [BlogController::class, 'publish'])->name('publish');
    Route::get('/blogs/delete/{id}', [BlogController::class, 'destroy'])->name('delete');
    Route::post('/blogs/update/{id}', [BlogController::class, 'update']);


    Route::get('/vote/{id}/{vote}', [VoteController::class, 'vote']);

});