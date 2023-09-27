<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GimnasioController extends Controller
{
    public function index()
    {
        return view('general.gimnasio');
    }
}
