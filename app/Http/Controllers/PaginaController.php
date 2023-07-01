<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginaController extends Controller
{
    /*protected ILoginService $loginService;

    public function __construct(ILoginService $loginService)
    {
        $this->loginService=$loginService;
    }*/

    public function index()
    {
        return view('welcome');
    }

}
