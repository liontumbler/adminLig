<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Gimnasio;

class TrabajadorController extends Controller
{
    /*protected ILoginService $loginService;

    public function __construct(ILoginService $loginService)
    {
        $this->loginService=$loginService;
    }*/

    public function homeTrabajador()
    {
        return view('worker.homeTrabajador');
    }

    public function ligas()
    {
        return view('worker.ligas');
    }

}
