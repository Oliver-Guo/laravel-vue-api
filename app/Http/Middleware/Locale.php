<?php

namespace app\Http\Middleware;

use Closure;

class Locale
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
    public function handle($request, Closure $next, $guard = null)
    {
        //dd($request->input('lang'));
        //dd($request->segment(2));
        //$lang = $request->input('lang');
        //$lang = $request->segment(2);
        $lang = $request->header('Accept-Language');
        switch (strtolower($lang)) {
            case 'tw':
                app()->setLocale('zn_tw');
                break;
            case 'en':
                app()->setLocale('en');
                break;
            default:
                app()->setLocale('en');
                break;
        }
        //\Cache::store('array')->put('lang', strtolower($lang), 1);

        return $next($request);
    }
}
