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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/user', [Api::class, 'user'])->name('user');
Route::get('/all_ticket', [Api::class, 'all_ticket'])->name('all_ticket');
Route::post('/login', [Api::class, 'login'])->name('login');

Route::get('/user', [Api::class, 'user'])->name('user');
Route::get('/user', [Api::class, 'user'])->name('user');
