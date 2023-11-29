<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Ligas;

class ligaController extends Controller
{
    public function crearLigaTrabajador(Request $request)
    {
        //return $request->all();
        $validator = Validator::make($request->all(), [
            'cliente' => 'integer|max:1000000|min:1',
            'selectHora' => 'integer|max:1000000|min:1',
            'tipoPago' => 'nullable|string|max:50|min:1',
            'fechaInicio' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $ligas = new Ligas();
        $res = $ligas->crearLigaTrabajador($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function index()
    {
        return view('general.liga');
    }

    public function cargarDatos()
    {
        $descuento = new Ligas();
        $res = $descuento->cargarDatos();
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function editarLiga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'titulo' => 'string|max:50|min:1',
            'total' => 'integer|max:1000000|min:1',
            'idGimnasio' => 'integer|min:1',
            'idTrabajado' => 'integer|min:1',
            'idTrabajador' => 'integer|min:1',
            'descripcion' => 'nullable|string|max:255|min:1',
            'estado' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $ligas = new Ligas();
        $res = $ligas->editarLiga($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function crearLiga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:50|min:1',
            'total' => 'required|integer|max:1000000|min:1',
            'idGimnasio' => 'required|integer|min:1',
            'idTrabajado' => 'required|integer|min:1',
            'idTrabajador' => 'required|integer|min:1',
            'descripcion' => 'nullable|string|max:255|min:1',
            'estado' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $descuento = new Liga();
        $res = $descuento->crearLiga($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function eliminarLiga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $descuento = new Liga();
        $res = $descuento->eliminarLiga($request->id);
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }
}
