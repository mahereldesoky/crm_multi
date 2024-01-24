<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SubDomianController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('account/verify/{token}', [SubDomianController::class, 'verifyAccount'])->name('user.verify'); 

Route::get('/', [SubDomianController::class, 'index']);
Route::get('/login', [SubDomianController::class, 'loginForm'])->name('login');
Route::post('logout', [SubDomianController::class, 'logout'])->name('logout');
Route::post('/login', [SubDomianController::class, 'login']);
Route::post('/subdomain',[SubDomianController::class, 'store']);
