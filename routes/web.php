<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Site;
use App\Http\Controllers\Dashboard\PostController;
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

Route::get('/', [Site\HomeController::class, 'index']);

Route::prefix('dashboard')->group(function(){
    Route::get('/login', [Dashboard\AuthController::class, 'login'])->name('login');
    Route::post('/login', [Dashboard\AuthController::class, 'loginAction']);
    Route::get('/logout', [Dashboard\AuthController::class, 'logout'])->name('logout');

    Route::get('/', [Dashboard\HomeController::class, 'index'])->name('dashboard');

    Route::resource('/post', PostController::class);
});

