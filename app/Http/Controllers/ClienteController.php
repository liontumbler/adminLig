<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        return view('general.cliente');
    }

    public function cargarDatos()
    {
        $descuento = new Cliente();
        $res = $descuento->cargarDatos();
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function editarCliente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'correo' => 'nullable|email|max:100|min:1',
            'telefono' => 'nullable|integer|max:9999999999|min:1000000',
            'nombresYapellidos' => 'string|max:50|min:1',
            'documento' => 'nullable|integer|max:99999999999|min:1000',
            'estado' => 'boolean',
            'idGimnasio' => 'integer|min:1',
            'idEquipo' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $ligas = new Cliente();
        $res = $ligas->editarCliente($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function crearCliente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'nullable|email|max:100|min:1',
            'telefono' => 'nullable|integer|max:9999999999|min:1000000',
            'nombresYapellidos' => 'required|string|max:50|min:1',
            'documento' => 'nullable|integer|max:99999999999|min:1000',
            'estado' => 'required|boolean',
            'idGimnasio' => 'required|integer|min:1',
            'idEquipo' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $descuento = new Cliente();
        $res = $descuento->crearCliente($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function eliminarCliente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $descuento = new Cliente();
        $res = $descuento->eliminarCliente($request->id);
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }
}
