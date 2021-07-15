<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\UploadController;
//use App\Http\Controllers\Dashboard\AjaxController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/imageupload', [UploadController::class, 'imageupload'])->name('imageupload');
//Route::middleware('auth:api')
//    ->post('/post/ajax', [AjaxController::class, 'getPostSearch'])->name('search');
