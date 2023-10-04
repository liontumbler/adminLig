<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Gimnasio;
use App\Models\Trabajador;

class TrabajadorController extends Controller
{
    public function homeTrabajador()
    {
        return view('worker.homeTrabajador');
    }

    public function ligas()
    {
        return view('worker.ligas');
    }

    public function index()
    {
        return view('general.trabajador');
    }
}
