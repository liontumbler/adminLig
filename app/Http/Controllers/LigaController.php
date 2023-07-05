<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Ligas;

class ligaController extends Controller
{
    public function crearLiga(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente' => 'string|max:50|min:1',
            'selectHora' => 'string|max:50|min:1',
            'tipoPago' => 'string|max:50|min:1',
            'nombreYapellido' => 'string|max:50|min:1',
            'documento' => 'string|max:50|min:1',
            'equipo' => 'string|max:50|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $ligas = new Ligas();
        $res = $ligas->crearLiga($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

}
