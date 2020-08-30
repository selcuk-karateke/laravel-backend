<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Whitelist
        $domains = ['http://localhost:8080','http://localhost:63342'];
//dd($request);
        // Check HTTP_ORIGIN
        if(isset($request->server()['HTTP_ORIGIN'])) {
            $origin = $request->server()['HTTP_ORIGIN'];
            // Check Domains
            if(in_array($origin, $domains)) {
                header('Access-Control-Allow-Origin: ' . $origin);
                header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');
            }
        }
        return $next($request);
    }
}
