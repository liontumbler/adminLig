<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\HoraLiga;
use App\Models\Gimnasio;
use App\Models\Trabajado;
use App\Models\Trabajador;

class GeneralController extends Controller
{
    public function cargarClientesSelect()
    {
        $cliente = new Cliente();
        return $cliente->selectClientes();
    }

    public function cargarEquiposSelect()
    {
        $equipo = new Equipo();
        return $equipo->selectEquipos();
    }

    public function cargarSelectHora()
    {
        $horaliga = new HoraLiga();
        return $horaliga->selectHoraligas();
    }

    public function cargarGimnasiosSelect()
    {
        $equipo = new Gimnasio();
        return $equipo->selectGimnasios();
    }

    public function cargarTrabajadoSelect()
    {
        $trabajado = new Trabajado();
        return $trabajado->selectTrabajado();
    }

    public function cargarTrabajadorSelect()
    {
        $trabajador = new Trabajador();
        return $trabajador->selectTrabajador();
    }










}
