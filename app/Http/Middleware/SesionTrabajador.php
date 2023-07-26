<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\DB\ConsultasDB;

class SesionTrabajador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty(session()->get('SesionTrabajador'))) {
            $sesionTrabajador = session()->get('SesionTrabajador');
            $db = new ConsultasDB();
            $res = $db->obtenerTrabajadoTrabajador($sesionTrabajador['gimnasioId'], $sesionTrabajador['trabajadorId']);
            if(empty($res)){
                if ($request->isMethod('get')) {
                    session()->forget('SesionTrabajador');
                    return redirect('errorSesionCerrada');
                }elseif ($request->isMethod('post')) {
                    return new Response("./errorSesionCerrada", 500);
                }
            }
            return $next($request);
        } else {
            if ($request->isMethod('get')) {
                return redirect('loginTrabajador');
            }elseif ($request->isMethod('post')) {
                return new Response("./loginTrabajador", 500);
            }
        }
    }
}
