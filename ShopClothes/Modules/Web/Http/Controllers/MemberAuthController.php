<?php

namespace Modules\Web\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Web\Http\Requests\RegisterRequest;
use Modules\Web\Http\Requests\ProfileRequest;
use Modules\Web\Http\Requests\ResetPassRequest;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Services\Member\MemberService;
use Services\Deal\DealService;
use Illuminate\Support\Facades\Input;

use ServiceManager;
use Redirect;
use Auth;
use Crypt;
use Hash;
use Session;


class MemberAuthController extends Controller
{
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
    public function __construct(MemberService $memberService,DealService $dealService) {

        $this->service = $memberService;
        $this->dealService = $dealService;
    }

    //Trang login
    public function login(){
        if ( Auth::check() && Auth::user()  )
        {
            return redirect()->route('web::list_news');
        }
        return view('web::member.login');
    }

    // lấy danh sách tin đăng của thành viên
    public function getListNews()
    {
        return view('web::member.listNews');
    }
    // lấy dữ liệu tìm kiếm tất cả
    public function getSearchAll()
    {
    // Tìm kiếm theo keyword
        $keyword = Input::get('search_all');
        return view('web::member.searchAll',compact('keyword'));
    }
    //Xác nhận user
    public function verify(Request $request){
        if($request->isMethod('Post')){
            if($request->input('email_phone')!=null && $request->input('password')!=null && strpos($request->input('email_phone'), "@")==true){
                if (Auth::attempt([
                    'user_email' => $request->input('email_phone'),
                    'user_password' => $request->input('password'),
                    ])) {
                    return Redirect::route('web::list_news');
                }
                else{
                    return \Redirect::back()->withErrors( "Email hoặc password của bạn sai" );
                }
            }
            elseif($request->input('email_phone')!=null && $request->input('password')!=null && ctype_digit($request->input('email_phone'))==true)
            {
                if (Auth::attempt([
                    'user_mobile_phone' => $request->input('email_phone'),
                    'user_password' => $request->input('password')
                    ])) {
                    return Redirect::route('web::list_news');
                }
                else{
                        return \Redirect::back()->withErrors( "Số điện thoại hoặc password của bạn sai" );
                    }
            }
            else {
                return \Redirect::back()->withErrors( "Bạn đã nhập thiếu email/số điện thoại hoặc password" );
            }
        }
    }
    //Đăng xuất
    public function logout()
    {
        if(Session::has('isImpersonate'))
        {
            $idAdmin = Session::get('Admin');
            Session::flush();
            Auth::loginUsingId($idAdmin);
            return redirect()->route('admin::getUserList');
        }
        else
        {
            Auth::logout();
            return redirect()->route('web::index');
        }
    }

    // Đăng nhập tài khoản view
    public function index(){
        if ( Auth::check() && Auth::user()  )
        {

            return redirect()->route('web::list_news');
        }
        return view('web::member.login');
    }

            // Form Kích hoạt tài khoản view
    public function active(){
        return view('web::member.active');
    }

    public function generateCode(Request $request)
    {

        if( $request->ajax() && $request->id_user == Auth::user()->user_id ){
            // Truyền vào tham số id user để gửi mã lại
            $user = $this->service->getInfoMemberByID($request->id_user)->getData();
            $response = " ".$this->service->generateCode( $request->id_user );
            if($user->user_mobile_phone != null)
            {
                $type = "resend_code";
                $content = "Ma kich hoat tai khoan moi ";
                $this->sms->send($user->user_mobile_phone,$type,$content,$response);
            }
            if( !is_numeric($response) && $response->fails() )
            {
                return \Redirect::back()->withErrors( $response->errors() );
            }
        }
        else{
            return \Redirect::back()->withErrors( 'Gửi lại mã thất bại' );
        }
    }
    // gửi tin xấu
    public function badPost(Request $request)
    {

        if( $request->ajax() ){
            // Truyền vào tham số báo tin xấu
            $response = $this->service->badPost( $request->all() );
            /*dd($response);*/
            if( $response->fails() )
            {
                return response()->json([
                    'data'          =>  $result->errors(),
                    'STATUS'        =>  'ERROR',
                    'status_code'   =>   200
                    ], 200);
            }
        }
        else{
            return \Redirect::back()->withErrors( 'Báo cáo thất bại' );
        }
    }

            //  Kích hoạt tài khoản
    public function checkActive(Request $request){
        $response = $this->service->checkActive($request->all());
        if( $response->fails())
        {
            return \Redirect::route('web::active')->withErrors( $response->errors() );
        }
        return redirect()->route('web::list_news')->withSuccess( 'Xác nhận thành công!' );
    }
            //  Kích hoạt tài khoản bằng link
    public function activeWithoutCode($token){

        // check mã token khi active bằng link
        if(!$token || Auth::user()->user_status == "ACTIVED")
        {
            return \Redirect::route('web::active')->withErrors( "Đường link không tồn tại vui lòng kiểm tra lại" );
        }
        $token = str_replace("slash", "/", $token);
        $token = decrypt($token);
        $response = $this->service->activeWithoutCode($token);
        if( $response->fails())
        {
            return \Redirect::route('web::active')->withErrors( $response->errors() );
        }
        return redirect()->route('web::list_news')->withSuccess( 'Xác nhận thành công!' );
    }
            //Trang đăng ký tài khoản view

    public function register(){
        if ( Auth::check() && Auth::user()  )
        {
            return redirect()->route('web::list_news');
        }
        return view('web::member.register');
    }

            // Tiến hành thêm user
    public function postRegister( RegisterRequest $request )
    {
        $type = "register";
        $response = $this->service->createUser( $request->all() );
        $user = $this->service->getInfoMemberByID($response)->getData();
        if($user->user_mobile_phone != null)
        {
            $content = "Ma xac nhan cua ";
            $code = " ".$user->user_active_code;
            $this->sms->send($user->user_mobile_phone,$type,$content,$code);
        }
        if( !is_numeric($response) && $response->fails() )
        {
            return \Redirect::back()->withErrors( $response->errors() );
        }
        Auth::loginUsingId($response);
        return view('web::member.active',compact('response','constant'))->withSuccess( 'Đăng ký thành công!' );
    }

    // Trang góp ý
    public function feedback(){
        return view('web::member.feedback');
    }
    // Trang liên hệ
    public function contact(){
        return view('web::member.contact');
    }

            // Tiến hành thêm góp ý, liên hệ
    public function contactPost( FeedbackRequest $request )
    {
        $type = $request->contact_type;
        $response = $this->service->contactPost( $request->all() );
        if( $response->fails())
        {
            if($type == "GOPY")
            {
                return \Redirect::route('web::feedback')->withErrors( $response->errors() );
            }
            else{
                return \Redirect::route('web::contact')->withErrors( $response->errors() );
            }
        }
        if($type == "GOPY")
        {
            return \Redirect::route('web::feedback')->withSuccess( 'Gửi thành công!' );
        }
        else{
            return \Redirect::route('web::contact')->withSuccess( 'Gửi thành công!' );
        }
    }


            //Trang member reset pass
    public function resetPassword()
    {
        return view('web::member.resetpass');
    }

    public function profile()
    {
        return view('web::member.profile');
    }

    //Trang profile member
    public function editProfile(ProfileRequest $request)
    {
        // Truyền các tham số thêm và tiến hành thêm
        $response = $this->service->postUserInfo( $request->all() );
        /*dd($response);*/
        if( !is_numeric($response) && $response->fails() )
        {
            return \Redirect::back()->withErrors( $response->errors() );
        }

        return redirect()->route('web::profile')->withSuccess( 'Chỉnh sửa hồ sơ thành công!' );
    }

    //Trang reset pass
    public function resetPass()
    {
        $memberInfo = $this->service->getInfoMemberByID( Auth::id() );
        if( $memberInfo->fails() )
        {

            return \Redirect::back()->withErrors( $memberInfo->errors() );
        }
        $memberInfo = $memberInfo->getData();
        return view('web::member.profile',["memberInfo" => $memberInfo ,"constant" => $constant]);
    }

    //Trang reset pass
    public function editResetPass(ResetPassRequest $request)
    {
        if(\Hash::check(Input::get('old_pass'), Auth::user()->user_password)==true){
                    // Truyền các tham số thêm và tiến hành thêm
            $response = $this->service->postResetPass( $request->all() );
            /*dd($response);*/
            if( !is_numeric($response) && $response->fails() )
            {
                return \Redirect::back()->withErrors( $response->errors() );
            }

            return redirect()->route('web::list_news')->withSuccess( 'Thay đổi password thành công!' );
        }
        else{
            return redirect()->route('web::resetpassword')->withErrors( 'Mật khẩu hiện tại không đúng. Vui lòng nhập lại.' );
        }
    }


    public function advancedSearch()
    {
        return view('web::member.searchAll',compact('keyword'));

    }

    public function forgetPass()
    {
        return view('web::member.forgetPass');
    }

    public function confirmForgetPass(Request $request)
    {
        $type = "forget_pwd";
        $user = (string) $request->user;
        $id = $this->service->getInfoMemberForgetPass($user);
        if($id->fails())
        {
            return \Redirect::back()->withErrors( $id->errors() );
        }
        $phone = $id->getData()->user_mobile_phone;
        $id = $id->getData()->user_id;
        $response = " ".$this->service->generateCode($id);
        $content = "Ma xac nhan quen mat khau ";
        if($user == $phone)
        {
            $this->sms->send($phone,$type,$content,$response);
        }
        if(!is_numeric($response) && $response->fails())
        {
            return \Redirect::back()->withErrors( $response->errors() );
        }
        return view('web::member.activeForgetpass',compact('user','constant'));

    }

    public function generateCodeFogetPass(Request $request)
    {

        $user = $this->service->getInfoMemberForgetPass($request->user)->getData();
        $response = " ".$this->service->generateCode($user->user_id);
        if($request->user == $user->user_mobile_phone)
        {
            $type = "resend_code";
            $content = "Ma xac nhan quen mat khau moi ";
            $this->sms->send($user->user_mobile_phone,$type,$content,$response);
        }

        if( !is_numeric($response) && $response->fails() )
        {
            return \Redirect::back()->withErrors( $response->errors() );
        }
    }

    public function activeForgetPass(Request $request)
    {
        $code = $request->confirm_code;
        $user = $this->service->getInfoMemberForgetPass($request->user);
        $user = $user->getData();
        if($code == $user->user_active_code)
        {
            return view('web::member.changePassForgetpass',compact('user','constant'));
        }
    }

    public function changePass(Request $request)
    {
        $user = $request->user;
        $pass = $request->password;
        $response = $this->service->renewPass($user,$pass);
        if($response->fails())
        {
            return \Redirect::back()->withErrors( $response->errors() );
        }
        Auth::loginUsingId($user);
        return redirect()->route('web::list_news');
    }

    public function checkConfirmCode(Request $request)
    {
        $user = $this->service->getInfoMemberForgetPass($request->user)->getData();
        if($request->code != $user->user_active_code)
        {
            $response =  [
                'message'       =>  "Mã xác nhận không chính xác",
                'STATUS'        =>  'ERROR',
                'status_code'   =>   500
            ];
            return $response;
        }
        else
        {
            $response =  [
                'message'       => "OK",
                'STATUS'        =>  'OK',
                'status_code'   =>  200
            ];
            return $response;
        }
    }
}