<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// authentication route
Route::controller(AuthController::class)->group(
    function () {
        Route::post('/register', 'register');

        Route::post('/login', 'login');

        Route::middleware(['auth:sanctum'])->group(
            function () {
                Route::post('/profile', 'profile');

                Route::put('/profile-update', 'update');

                Route::get('/logout', 'logout');
            }
        );
    }
);

// article route
Route::controller(ArticleController::class)->group(function () {
    Route::get('/article', 'index');
});

// category route
Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'index');
});
