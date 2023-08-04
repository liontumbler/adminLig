<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $rules = "script-src 'self' https: 'unsafe-inline'; style-src 'self' 'unsafe-inline'; object-src 'none'; img-src 'self' https: data:; media-src https:; frame-src 'none'; font-src 'self' https:; connect-src 'self';";
        $response = $next($request);

        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Cross-Origin-Resource-Policy', 'same-origin');
        $response->header('Content-Security-Policy', $rules);
        $response->header('Feature-Policy', "camera 'none'; microphone 'none';");
        $response->header('Set-Cookie', 'Secure');
        $response->header('Strict-Transport-Security', 'max-age=31536000');
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->header('X-Frame-Options', 'DENY');
        $response->header('X-XSS-Protection', '1; mode=block');
        $response->header('X-Permitted-Cross-Domain-Policies', 'none');
        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-Content-Security-Policy', $rules);
        $response->header('X-WebKit-CSP', $rules);

        return $response;
    }
}
