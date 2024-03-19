<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;
use App\Http\Controllers\Dashboard;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::group(['middleware' => 'LoginValidation'], function () {
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('/create_ticket', [Dashboard::class, 'create_ticket'])->name('create_ticket');
    Route::post('/post_ticket', [Dashboard::class, 'post_ticket'])->name('post_ticket');
    Route::get('/all_ticket', [Dashboard::class, 'all_ticket'])->name('all_ticket');
    Route::get('/delete_ticket/{id}', [Dashboard::class, 'delete_ticket'])->name('delete_ticket');
    Route::get('/reply/{id}', [Dashboard::class, 'reply'])->name('reply');
    Route::post('/post_reply', [Dashboard::class, 'post_reply'])->name('post_reply');
    Route::get('/user', [Dashboard::class, 'user'])->name('user');
    Route::post('/add_user', [Dashboard::class, 'add_user'])->name('add_user');
    Route::get('/delete_user/{id}', [Dashboard::class, 'delete_user'])->name('delete_user');
    Route::get('/kalender', [Dashboard::class, 'kalender'])->name('kalender');
});

Route::get('/login', [Login::class, 'index'])->name('login');
Route::post('/logincheck', [Login::class, 'logincheck'])->name('logincheck');
Route::get('/logout', [Login::class, 'logout'])->name('logout');
