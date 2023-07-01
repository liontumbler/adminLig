<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\LoginController;

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

Route::get('/', [PaginaController::class, 'index'])->name('principal');
Route::get('/loginAdmin', [LoginController::class, 'loginAdmin'])->name('loginAdmin');
Route::get('/loginTrabajador', [LoginController::class, 'loginTrabajador'])->name('loginTrabajador');

Route::post('/recaptcha', [LoginController::class, 'recaptcha'])->name('recaptcha');

Route::post('/loginAdm', [LoginController::class, 'loginAdm'])->name('loginAdm');
Route::post('/loginTra', [LoginController::class, 'loginTra'])->name('loginTra');

