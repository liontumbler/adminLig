<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\GimnasioController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\HoraligaController;
use App\Http\Controllers\ProductoController;

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
//views
Route::get('/', [PaginaController::class, 'index'])->name('principal');
Route::get('/loginAdmin', [LoginController::class, 'loginAdmin'])->name('loginAdmin');//->middleware('sesion.admin.login');
Route::get('/loginTrabajador', [LoginController::class, 'loginTrabajador'])->name('loginTrabajador');
Route::get('/loginAdmOut', [LoginController::class, 'loginAdmOut'])->name('loginAdmOut');
Route::get('/loginTraOut', [LoginController::class, 'loginTraOut'])->name('loginTraOut');

Route::get('/homeAdmin', [AdminController::class, 'homeAdmin'])->name('homeAdmin');
Route::get('/homeTrabajador', [TrabajadorController::class, 'homeTrabajador'])->name('homeTrabajador');

Route::get('/ligas', [TrabajadorController::class, 'ligas'])->name('ligas');

Route::get('/errorSesionCerrada', [LoginController::class, 'errorSesionCerrada'])->name('errorSesionCerrada');

Route::get('/mail', [LoginController::class, 'mail'])->name('mail');

Route::get('/clientes', [ClienteController::class, 'index'])->name('index');

Route::get('/gimnasios', [GimnasioController::class, 'index'])->name('index');

Route::get('/equipos', [EquipoController::class, 'index'])->name('index');

Route::get('/descuentos', [DescuentoController::class, 'index'])->name('index');

Route::get('/plans', [PlanController::class, 'index'])->name('index');

Route::get('/horaligas', [HoraLigaController::class, 'index'])->name('index');

Route::get('/productos', [ProductoController::class, 'index'])->name('index');

//accciones
Route::post('/recaptcha', [LoginController::class, 'recaptcha'])->name('recaptcha');
Route::post('/loginAdm', [LoginController::class, 'loginAdm'])->name('loginAdm');
Route::post('/loginTra', [LoginController::class, 'loginTra'])->name('loginTra');

Route::post('/crearLiga', [LigaController::class, 'crearLiga'])->name('crearLiga');

Route::post('/cargarClientesSelect', [GeneralController::class, 'cargarClientesSelect'])->name('cargarClientesSelect');
Route::post('/cargarEquiposSelect', [GeneralController::class, 'cargarEquiposSelect'])->name('cargarEquiposSelect');
Route::post('/cargarSelectHora', [GeneralController::class, 'cargarSelectHora'])->name('cargarSelectHora');
Route::post('/cargarGimnasiosSelect', [GeneralController::class, 'cargarGimnasiosSelect'])->name('cargarGimnasiosSelect');
Route::post('/cargarTrabajadoSelect', [GeneralController::class, 'cargarTrabajadoSelect'])->name('cargarTrabajadoSelect');
Route::post('/cargarTrabajadorSelect', [GeneralController::class, 'cargarTrabajadorSelect'])->name('cargarTrabajadorSelect');

Route::post('/cargarDescuentos', [DescuentoController::class, 'cargarDatos'])->name('cargarDatos');
Route::post('/editarDescuento', [DescuentoController::class, 'editarDescuento'])->name('editarDescuento');
Route::post('/crearDescuento', [DescuentoController::class, 'crearDescuento'])->name('crearDescuento');
Route::post('/eliminarDescuento', [DescuentoController::class, 'eliminarDescuento'])->name('eliminarDescuento');




