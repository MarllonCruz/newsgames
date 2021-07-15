<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\AjaxController;
use App\Http\Controllers\Dashboard\UserController;

use App\Http\Controllers\Site;
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

Route::prefix('/')->group(function(){
    Route::get('/', [Site\HomeController::class, 'index'])->name('/');
    Route::get('/filter', [Site\HomeController::class, 'filter'])->name('filter');
    Route::get('/feed/{slug}', [Site\HomeController::class, 'post'])->name('feed');
});


Route::prefix('dashboard')->group(function(){
    Route::get('/login', [Dashboard\AuthController::class, 'login'])->name('login');
    Route::post('/login', [Dashboard\AuthController::class, 'loginAction']);
    Route::get('/logout', [Dashboard\AuthController::class, 'logout'])->name('logout');

    Route::get('/', [Dashboard\HomeController::class, 'index'])->name('dashboard');

    Route::resource('/post', PostController::class);
    Route::post('/post/ajax', [AjaxController::class, 'getPostSearch'])->name('search');

    Route::resource('/user', UserController::class);

    Route::get('/slider', [Dashboard\SliderController::class, 'index'])->name('slider');
    Route::post('/slider', [Dashboard\SliderController::class, 'save'])->name('sliderAction');

    Route::get('/highlight', [Dashboard\HighlightController::class, 'index'])->name('highlight');
    Route::post('/highlight', [Dashboard\HighlightController::class, 'save'])->name('highlightAction');
});

