<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

class Sesiones
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routes = Route::getRoutes();
        $rutaActual = explode("/", $request->path())[0];
        //echo 'solicita aceso a '.$rutaActual . "<br>";
        //echo (!empty(session()->get('SesionTrabajador')) || !empty(session()->get('SesionAdmin')));
        //echo $rutaActual == 'login';
        //echo 'uno'.!empty(session()->get('SesionTrabajador'));
        //echo 'dos'.!empty(session()->get('SesionAdmin'));
        //exit;

        if (!empty(session()->get('SesionTrabajador')) || !empty(session()->get('SesionAdmin'))) {
            if ($rutaActual == 'login' || $rutaActual == 'loginTrabajador') {
                if (!empty(session()->get('SesionTrabajador'))) {
                    return redirect('/homeTrabajador');
                } elseif (!empty(session()->get('SesionAdmin'))) {
                    return redirect('/homeAdmin');
                }
            }
            return $next($request);
        }else {
            if ($rutaActual == 'login' || $rutaActual == 'loginTrabajador') {
                return $next($request);
            }
            return redirect('/');
        }
    }
}
