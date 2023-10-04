<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Descuento;

class DescuentoController extends Controller
{
    public function index()
    {
        return view('general.descuento');
    }

    public function cargarDatos()
    {
        $descuento = new Descuento();
        $res = $descuento->cargarDatos();
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function editarDescuento(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|max:1000000|min:1',
            'titulo' => 'string|max:50|min:1',
            'total' => 'integer|max:1000000|min:1',
            'fecha' => 'string|max:50|min:1',
            'idGimnasio' => 'integer|max:50|min:1',
            'idTrabajado' => 'integer|max:50|min:1',
            'idTrabajador' => 'integer|max:50|min:1',
            'descripcion' => 'string|max:50|min:0',
            'estado' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $ligas = new Descuento();
        $res = $ligas->editarDescuento($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function crearDescuento(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:50|min:1',
            'total' => 'required|integer|max:1000000|min:1',
            'fecha' => 'required|string|max:50|min:1',
            'idGimnasio' => 'required|integer|max:50|min:1',
            'idTrabajado' => 'required|integer|max:50|min:1',
            'idTrabajador' => 'required|integer|max:50|min:1',
            'descripcion' => 'string|max:50|min:0',
            'estado' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $descuento = new Descuento();
        $res = $descuento->crearDescuento($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function eliminarDescuento(Request $request)
    {
        $descuento = new Descuento();
        $res = $descuento->eliminarDescuento($request->id);
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }
}
