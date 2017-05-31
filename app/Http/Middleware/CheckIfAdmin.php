<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array("super-admin", auth()->user()->rolesConnections->pluck('roles_id')->toArray()))
            return $next($request);

        return redirect('home');

    }

}



//    public function handle($request, Closure $next, $guard = null)
//    {
//        if(in_array("admin", auth()->user()->rolesConnections->pluck('roles_id')->toArray()))
//            return $next($request);
//
//        return abort(403, "No can dosville, babydoll!");
//    }

