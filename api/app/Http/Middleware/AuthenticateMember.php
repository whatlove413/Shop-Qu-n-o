<?php
namespace App\Http\Middleware;

use Auth;
use Closure;
use Redirect;

class AuthenticateMember
{

    public function handle($request, Closure $next)
    {
        if (!Auth::user()) {
            return redirect()->route('web::index_member');
        }
        if ($request->fullUrl() == route('web::active') && Auth::user()->user_status == "ACTIVED") {
            return redirect(route('web::list_news'));
        }
        if ($request->isMethod('get') && ($request->fullUrl() == route('web::logout') || $request->fullUrl() == route('web::generate_code') . "?id_user=" . Auth::user()->user_id)) {
            return $next($request);
        }
        if ($request->isMethod('post') && ($request->fullUrl() == route('web::active'))) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()) {
            if (Auth::user()->user_status != "ACTIVED" && $request->fullUrl() != route('web::active')) {
                return redirect(route('web::active'));
            } else {
                return $next($request);
            }

        }

        return $next($request);
    }
}
