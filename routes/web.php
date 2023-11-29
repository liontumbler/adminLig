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
Route::get('/login', [LoginController::class, 'loginAdmin'])->name('loginAdmin')->middleware('sesion');
Route::get('/loginTrabajador', [LoginController::class, 'loginTrabajador'])->name('loginTrabajador')->middleware('sesion');
Route::get('/loginAdmOut', [LoginController::class, 'loginAdmOut'])->name('loginAdmOut');
Route::get('/loginTraOut', [LoginController::class, 'loginTraOut'])->name('loginTraOut');

Route::get('/homeAdmin', [AdminController::class, 'homeAdmin'])->name('homeAdmin')->middleware('sesion');
Route::get('/homeTrabajador', [TrabajadorController::class, 'homeTrabajador'])->name('homeTrabajador')->middleware('sesion');

Route::get('/ligasTrabajador', [TrabajadorController::class, 'ligasTrabajador'])->name('ligasTrabajador');

Route::get('/errorSesionCerrada', [LoginController::class, 'errorSesionCerrada'])->name('errorSesionCerrada');

Route::get('/mail', [LoginController::class, 'mail'])->name('mail');

Route::get('/clientes', [ClienteController::class, 'index'])->name('index')->middleware('sesion');

Route::get('/gimnasios', [GimnasioController::class, 'index'])->name('index')->middleware('sesion');

Route::get('/equipos', [EquipoController::class, 'index'])->name('index')->middleware('sesion');

Route::get('/descuentos', [DescuentoController::class, 'index'])->name('index');//->middleware('sesion');

Route::get('/plans', [PlanController::class, 'index'])->name('index')->middleware('sesion');

Route::get('/horaligas', [HoraLigaController::class, 'index'])->name('index')->middleware('sesion');

Route::get('/productos', [ProductoController::class, 'index'])->name('index')->middleware('sesion');

Route::get('/trabajadors', [TrabajadorController::class, 'index'])->name('index')->middleware('sesion');

Route::get('/ligas', [LigaController::class, 'index'])->name('index')->middleware('sesion');

//accciones
Route::post('/recaptcha', [LoginController::class, 'recaptcha'])->name('recaptcha');
Route::post('/loginAdm', [LoginController::class, 'loginAdm'])->name('loginAdm');
Route::post('/loginTra', [LoginController::class, 'loginTra'])->name('loginTra');

Route::post('/crearLigaTrabajador', [LigaController::class, 'crearLigaTrabajador'])->name('crearLigaTrabajador')->middleware('sesion');

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

Route::post('/cargarClientes', [ClienteController::class, 'cargarDatos'])->name('cargarDatos');
Route::post('/editarCliente', [ClienteController::class, 'editarCliente'])->name('editarCliente');
Route::post('/crearCliente', [ClienteController::class, 'crearCliente'])->name('crearCliente');
Route::post('/eliminarCliente', [ClienteController::class, 'eliminarCliente'])->name('eliminarCliente');

Route::post('/cargarEquipos', [EquipoController::class, 'cargarDatos'])->name('cargarDatos');
Route::post('/editarEquipo', [EquipoController::class, 'editarEquipo'])->name('editarEquipo');
Route::post('/crearEquipo', [EquipoController::class, 'crearEquipo'])->name('crearEquipo');
Route::post('/eliminarEquipo', [EquipoController::class, 'eliminarEquipo'])->name('eliminarEquipo');

Route::post('/cargarLigas', [LigaController::class, 'cargarDatos'])->name('cargarDatos')->middleware('sesion');
Route::post('/editarLiga', [LigaController::class, 'editarLiga'])->name('editarLiga')->middleware('sesion');
Route::post('/crearLiga', [LigaController::class, 'crearLiga'])->name('crearLiga')->middleware('sesion');
Route::post('/eliminarLiga', [LigaController::class, 'eliminarLiga'])->name('eliminarLiga')->middleware('sesion');
