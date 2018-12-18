<?php

namespace app\Http\Middleware;

use Closure;

class ApiTimestamp
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('apitimestamp', env('API_TIMESTAMP', 1));

        return $response;
    }
}
