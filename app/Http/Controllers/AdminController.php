<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Gimnasio;

class AdminController extends Controller
{
    /*protected ILoginService $loginService;

    public function __construct(ILoginService $loginService)
    {
        $this->loginService=$loginService;
    }*/

    public function homeAdmin()
    {
        return view('admin.homeAdmin');
    }

}
