<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\HoraLiga;

class HoraLigaController extends Controller
{
    public function index()
    {
        return view('general.HoraLiga');
    }

    public function cargarDatos()
    {
        $horaLiga = new HoraLiga();
        $res = $horaLiga->cargarDatos();
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function editarHoraLiga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'nombre' => 'string|max:50|min:1',
            'horas' => 'float(9,1)',
            'precio' => 'integer|max:1000000|min:1',
            'estado' => 'boolean',
            'idGimnasio' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $ligas = new HoraLiga();
        $res = $ligas->editarHoraLiga($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function crearHoraLiga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50|min:1',
            'horas' => 'required|float(9,1)',
            'precio' => 'required|integer|max:1000000|min:1',
            'estado' => 'required|boolean',
            'idGimnasio' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $horaLiga = new HoraLiga();
        $res = $horaLiga->crearHoraLiga($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function eliminarHoraLiga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $horaLiga = new HoraLiga();
        $res = $horaLiga->eliminarHoraLiga($request->id);
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }
}
