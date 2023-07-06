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
        $gimnasio = new Gimnasio();
        $resGim = $gimnasio->cargadeVista();

        $trabajador = new Trabajador();
        $resTra = $trabajador->cargadeVista();

        $color = $resGim['color'];
        $background = $resGim['background'];
        $nombreGimnasio = $resGim['nombre'];
        $nombrePerfil = $resTra['nombresYapellidos'];
        $arrayConfig= [
            'color' => $color,
            'background' => $background,
            'nombreGimnasio' => $nombreGimnasio,
            'nombrePerfil' => $nombrePerfil,
        ];

        return view('worker.homeTrabajador', compact('arrayConfig'));
    }

    public function ligas()
    {
        return view('worker.ligas');
    }

}
