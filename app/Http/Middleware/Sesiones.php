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
        if ($request->isMethod('get')) {
            $exiteRuta = false;
            foreach ($routes as $route) {
                $rutaPermitida = explode("/", $route->uri())[0];
                if (in_array('GET', $route->methods()) && $rutaActual == $rutaPermitida) {
                    $exiteRuta = true;
                    break;
                }
            }

            /*if ((!empty(session()->get('SesionAdmin')))) {
                return $next($request);
            } elseif ((!empty(session()->get('SesionTrabajador')))) {
                return $next($request);
            } else {
                return redirect('loginAdmin');
            }*/

        }elseif ($request->isMethod('post')) {

            foreach ($routes as $route) {
                $rutaPermitida = explode("/", $route->uri())[0];
                if (in_array('POST', $route->methods()) && $rutaActual == $rutaPermitida) {
                    $exiteRuta = true;
                    break;
                }
            }
            //return new Response("./errorSesionCerrada", 500);
        }

        if ($exiteRuta) {
            return $next($request);
        }

    }
}
