<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*protected ILoginService $loginService;

    public function __construct(ILoginService $loginService)
    {
        $this->loginService=$loginService;
    }*/

    public function index()
    {
        return view('login');
    }

    public function recaptcha(Request $request) {
        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify?response='.$request->response.'&secret='.'6LffswQmAAAAAEg6h94_61m8eEcjW2i1AI8WDFZF');
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($cu);
        curl_close($cu);

        return $response;
    }

    public function loginAdmin(Request $request) {

        $validator = Validator::make($request->all(), [
            'nickname' => 'required|string|max:50|min:1',
            'clave' => 'required|string|max:50|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        return 'edwin';
    }

    public function logout(Request $request) {

        $variableValid = $request->validate([
            'nickname' => 'required|string|max:50|min:1',
            'clave' => 'required|string|max:50|min:1',
        ]);

        return $variableValid;
    }

}
