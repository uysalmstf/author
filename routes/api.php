<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\BlogController;

Route::post('/login', [ApiAuthController::class, 'login'])->name('login.api');
Route::post('/register',[ApiAuthController::class, 'register'])->name('register.api');


Route::group(['middleware' => ['cors', 'json.response']], function () {
    
    Route::middleware('auth:api')->group(function () {
        // our routes to be protected will go in here
        Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout.api');

        Route::get('/blogs', [BlogController::class, 'list_api'])->name('blogs_list.api');
        Route::post('/blogs/create', [BlogController::class, 'insert'])->name('blogs_create.api');
        Route::post('/blogs/edit', [BlogController::class, 'edit_api'])->name('blogs_edit.api');
    });

});