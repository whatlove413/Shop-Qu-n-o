<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use ServiceManager;
use Redirect;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        // $this->middleware('guest')->except('logout');
    }

    public function login(){
        
        if ( Auth::check() && Auth::user()  )
        {

            return redirect()->route('web::list_news');
        }
        return view('auth.login');
    }

    public function verify(Request $request){
        
        if($request->isMethod('Post')){
            if (Auth::attempt([
                'user_email'        =>  $request->input('username'),
                'user_password'     =>  $request->input('password'),
                'user_status'       =>  "ACTIVED", 
                'user_deleted_time' =>  NULL,
                'user_permission'   =>  '1'
            ])) {
                return Redirect::route('admin::index');
            }
            elseif (Auth::attempt([
                'user_email'        =>  $request->input('username'),
                'user_password'     =>  $request->input('password'),
                'user_status'       =>  "ACTIVED", 
                'user_deleted_time' =>  NULL,
                'user_permission'   =>  '2'
            ])) {
                return Redirect::route('admin::index');
            }
            elseif (Auth::attempt([
                'user_mobile_phone' => $request->input('username'),
                'user_password'     => $request->input('password'),
                'user_status'       =>  "ACTIVED",                 
                'user_deleted_time' =>  NULL,
                'user_permission'   =>  '1'
            ])) 
            {                    
                return Redirect::route('admin::index');
            }
            elseif (Auth::attempt([
                'user_mobile_phone' => $request->input('username'),
                'user_password'     => $request->input('password'),
                'user_status'       =>  "ACTIVED",                 
                'user_deleted_time' =>  NULL,
                'user_permission'   =>  '2'
            ])) 
            {                    
                return Redirect::route('admin::index');
            }
            
            else
            {
                $datas = array(
                    'code' => array(
                        'Bạn không có quyền truy cập trang này'
                    )
                );
               
                return \Redirect::back()->withErrors( $request->input() )->withErrors( $datas );
            }
        }
    }

    public function logout()
    {

        Auth::logout();
        return view('auth.login');
    }
}
