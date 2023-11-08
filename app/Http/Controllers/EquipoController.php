<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Equipo;

class EquipoController extends Controller
{
    public function index()
    {
        return view('general.equipo');
    }

    public function cargarDatos()
    {
        $descuento = new Equipo();
        $res = $descuento->cargarDatos();
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function editarEquipo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'nombre' => 'string|max:50|min:1',
            'estado' => 'boolean',
            'idGimnasio' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $ligas = new Equipo();
        $res = $ligas->editarEquipo($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function crearEquipo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50|min:1',
            'estado' => 'required|boolean',
            'idGimnasio' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $descuento = new Equipo();
        $res = $descuento->crearEquipo($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function eliminarEquipo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $descuento = new Equipo();
        $res = $descuento->eliminarEquipo($request->id);
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }
}
