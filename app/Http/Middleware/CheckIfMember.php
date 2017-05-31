<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\models\VRRoles;
use App\models\VRUsers;

class CheckIfMember
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
        $roles = auth()->user()->rolesConnections->pluck('roles_id')->toArray();

        if(in_array("user", $roles) or in_array("check-role-member", $roles))

            return $next($request);

        return abort(403, "no permission!");




//
//        if (Auth::check() && Auth::user()->user()) {
//            return $next($request);
//        } elseif (Auth::check() && Auth::user()->isAdmin()) {
//            return $next($request);
//        }
//
//        return abort(403, "no permission!");
    }
}
