<?php
namespace App\Http\Middleware;

use Auth;
use Closure;
use Redirect;

class AuthenticateCustom
{

    public function handle($request, Closure $next)
    {

        if ($request->fullUrl() == route('web::index_member') && Auth::user()) {
            return redirect(route('web::list_news'));
        }

        if ($request->isMethod('post') && $request->fullUrl() == route('auth::verify')) {

            return $next($request);
        }
        if
        (
            (Auth::check() && Auth::user()->user_permission != 2) &&
            (
                $request->route()->uri() == "admincp/user/danh-sach" ||
                $request->route()->uri() == "admincp/user/edit/{id}" ||
                $request->route()->uri() == "admincp/user/search" ||
                $request->route()->uri() == "admincp/dang-ky" ||
                $request->route()->uri() == "admincp/tin-tuc/danh-muc" ||
                $request->route()->uri() == "admincp/tin-tuc/danh-muc/edit/{id}" ||
                $request->route()->uri() == "admincp/tin-tuc/danh-muc/delete"
            )
        ) {
            return redirect(route('admin::index'));
        }
        if (Auth::check() && Auth::user()) {
            if (Auth::user()->user_permission == 0) {
                return redirect(route('web::index'));
            }
            return $next($request);

        }

        if ($request->fullUrl() == route('auth::login') && !Auth::user()) {

            return $next($request);
        }

        if ($request->fullUrl() == route('auth::login')) {
            return redirect(route('admin::index'));
        }
        return redirect(route('auth::login'));
    }
}
