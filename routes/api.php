<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

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

Route::group(['middleware' => 'ApiValidation'], function () {
    Route::get('/user/get', [Api::class, 'user']);

    Route::get('/ticket/assign', [Api::class, 'assign_user']);
    Route::get('/ticket/category', [Api::class, 'category']);

    Route::get('/ticket/get_all', [Api::class, 'all_ticket']);
    Route::get('/ticket/reply/{id}', [Api::class, 'reply']);
    Route::post('/ticket/reply', [Api::class, 'post_reply']);
    Route::post('/ticket/create', [Api::class, 'post_ticket']);
});

Route::post('/user/login', [Api::class, 'login']);

