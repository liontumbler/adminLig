<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrabajadorController;

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
Route::get('/loginAdmin', [LoginController::class, 'loginAdmin'])->name('loginAdmin')->middleware('sesion.admin.login');
Route::get('/loginTrabajador', [LoginController::class, 'loginTrabajador'])->name('loginTrabajador')->middleware('sesion.trabajador.login');
Route::get('/loginAdmOut', [LoginController::class, 'loginAdmOut'])->name('loginAdmOut');
Route::get('/loginTraOut', [LoginController::class, 'loginTraOut'])->name('loginTraOut');


Route::get('/homeAdmin', [AdminController::class, 'homeAdmin'])->name('homeAdmin')->middleware('sesion.admin');
Route::get('/homeTrabajador', [TrabajadorController::class, 'homeTrabajador'])->name('homeTrabajador')->middleware('sesion.trabajador');

Route::get('/ligas', [TrabajadorController::class, 'ligas'])->name('ligas');


Route::post('/recaptcha', [LoginController::class, 'recaptcha'])->name('recaptcha');
Route::post('/loginAdm', [LoginController::class, 'loginAdm'])->name('loginAdm');
Route::post('/loginTra', [LoginController::class, 'loginTra'])->name('loginTra');

