<?php
namespace App\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Services\UserService;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Services\UserService  $auth
     * @return void
     */
    public function __construct(UserService $user)
    {
        $this->user = $user;
        $this->auth = null;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /*if ($this->auth->guard($guard)->guest() && ! app()->environment('local')) {
        return response('Unauthorized.', 401)->header('Access-Control-Allow-Origin', '*');
        }*/
        // die('App\Http\Middleware\Authenticate');
        // $header = $request->header();
        // if ($request->method() != "GET") {
        //     $this->auth = $this->user->findUserByToken($header)->getData()['users'];
        //     if ($request->route()->uri() == 'v1/user/register') {
        //         return $next($request);
        //     } else if (!$this->auth) {
        //         return response(json_encode([
        //             'STATUS' => "UNAUTHORIZED",
        //             'message' => 'Request unauthorized.',
        //         ]), 401)->header('Access-Control-Allow-Origin', '*');
        //     }
        // }
        return $next($request);
    }
}
