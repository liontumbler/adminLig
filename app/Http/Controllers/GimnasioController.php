<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Gimnasio;

class GimnasioController extends Controller
{
    public function index()
    {
        return view('general.gimnasio');
    }

    public function cargarDatos()
    {
        $gimnasio = new Gimnasio();
        $res = $gimnasio->cargarDatos();
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function editarGimnasio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'correo' => 'email|max:100|min:1',
            'nickname' => 'string|max:50|min:1',
            'nombre' => 'string|max:50|min:1',
            'clave' => 'string|max:100|min:1',
            'color' => 'string|max:10|min:1',
            'background' => 'string|max:10|min:1',
            'direccion' => 'nullable|string|max:50|min:1',
            'telefono' => 'integer|max:10|min:1',
            'descripcion' => 'nullable|string|max:255|min:1',
            'habilitado' => 'boolean',
            'minDeMasLiga' => 'integer|max:99|min:1',
            'superAdmin' => 'boolean',
            'estado' => 'boolean',
            'idPlan' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $ligas = new Gimnasio();
        $res = $ligas->editarGimnasio($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function crearGimnasio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email|max:100|min:1',
            'nickname' => 'required|string|max:50|min:1',
            'nombre' => 'required|string|max:50|min:1',
            'clave' => 'required|string|max:100|min:1',
            'color' => 'required|string|max:10|min:1',
            'background' => 'required|string|max:10|min:1',
            'direccion' => 'nullable|string|max:50|min:1',
            'telefono' => 'required|integer|max:10|min:1',
            'descripcion' => 'nullable|string|max:255|min:1',
            'habilitado' => 'required|boolean',
            'minDeMasLiga' => 'required|integer|max:99|min:1',
            'superAdmin' => 'required|boolean',
            'estado' => 'required|boolean',
            'idPlan' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $gimnasio = new Gimnasio();
        $res = $gimnasio->crearGimnasio($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function eliminarGimnasio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $gimnasio = new Gimnasio();
        $res = $gimnasio->eliminarGimnasio($request->id);
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

}
