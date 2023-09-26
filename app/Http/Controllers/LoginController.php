<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Gimnasio;
use App\Models\Trabajador;

use App\Mail\ClaveCajaMail;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function errorSesionCerrada()
    {
        return view('errors.errorSesionCerrada');
    }

    public function loginAdmin()
    {
        return view('admin.loginAdmin');
    }

    public function loginTrabajador()
    {
        return view('worker.loginTrabajador');
    }

    public function recaptcha(Request $request) {
        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify?response='.$request->response.'&secret='.'6LffswQmAAAAAEg6h94_61m8eEcjW2i1AI8WDFZF');
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($cu);
        curl_close($cu);

        return $response;
    }

    public function loginAdm(Request $request) {
        $validator = Validator::make($request->all(), [
            'nickname' => 'required|string|max:50|min:1',
            'clave' => 'required|string|max:50|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $gimnasio = new Gimnasio();
        $res = $gimnasio->loginAdmin($request->all());
        if ($res == true) {
            return $res;
        }else{
            return $res;
        }
    }

    public function loginTra(Request $request) {

        $validator = Validator::make($request->all(), [
            'nickname' => 'required|string|max:50|min:1',
            'clave' => 'required|string|max:50|min:1',
            'caja' => 'required|numeric|max:1000000|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $trabajador = new Trabajador();
        $res = $trabajador->loginTrabajador($request->all());
        if ($res == true) {
            return $res;
        }else{
            return json_encode($res);
        }
    }

    public function loginTraOut() {
        //falata

        //session()->flush();
        session()->forget('SesionTrabajador');
        return redirect('loginTrabajador');
    }
    public function loginAdmOut()
    {
        //session()->flush();//elimina todo
        session()->forget('SesionAdmin');
        return redirect('loginAdmin');
    }

    public function mail(Request $request) {
        try {
            Mail::to('lion_3214@hotmail.com')
            ->send(new ClaveCajaMail('xxxx'));
            return 'bien';
        } catch (\Exception $e) {
            \Log::error('Error al enviar el correo: ' . $e->getMessage());
            return 'mal';
        }
    }
}
