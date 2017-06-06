<?php

namespace App\Http\Middleware;

use Closure;

class CheckLanguage
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

        $locales = ['lt', 'en'];

        if(in_array(request()->segment(1), $locales)) {

            app()->setLocale(request()->segment(1));
            return $next($request);
        } else {

            dd($locales);

        }





    }
}
