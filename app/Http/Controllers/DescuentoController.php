<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DescuentoController extends Controller
{
    public function index()
    {
        return view('general.descuento');
    }
}
