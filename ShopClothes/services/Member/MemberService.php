<?php

namespace Services\Member;
use Mail;
use App\Mail\RegisteredUser;
use App\Mail\WelcomeMail;
use App\Mail\ForgetPass;
use Core\Responders\ServiceResponse;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Facades\Input;
use File;
use DB;
use Hash, Auth,Crypt;

class MemberService
{
    // xác nhận mã active
    use \Core\Traits\Helpers;


        public function login($data){
            if(ctype_digit($data['user_email_phone'])){
                $data['user_mobile_phone'] = $data['user_email_phone'];
                unset($data['user_email_phone']);
            }
            else{
                $data['user_email'] = $data['user_email_phone'];
            }
            $res = $this->sendParamsToApi('POST',$data,'api.local.com/v1/user/login');
            $res = $res->getData()['data'];
            return $res;
        }

        public function createUser( $data )
        {
        // dữ liệu trả vềdd($data);
            if(ctype_digit($data['user_email_phone'])){
                $data['user_mobile_phone'] = $data['user_email_phone'];
                unset($data['user_email_phone']);
            }
            else{
                $data['user_email'] = $data['user_email_phone'];
            }
            $res = $this->sendParamsToApi('POST',$data,'api.local.com/v1/user/register');
            $res = $res->getData()['data'];
            return $res;
        }

    /**
	 * @todo Quên mật khẩu
	 * @author đại
	 * @since 21/04/2018
	 * @param $data: email hoặc số điện thoại
	 * @return token mã active
	*/



    /**
     * @todo Chỉnh sửa profile theo user id
     * @author thanh
     * @since 08/03/2018
     * @param int $data: Tất cả tham số request đăng tin doanh nghiệp
     * @return Chỉnh sửa profile thành công
    */
    public function postUserInfo( $data )
    {
        // dữ liệu trả về
        $result = new ServiceResponse();
        $checkPhone = DB::table('tbl_user')->where('user_mobile_phone',$data['user_mobile_phone'])->where('user_id','<>',Auth::id())->first();
        $checkMail = DB::table('tbl_user')->where('user_email',$data['user_email'])->where('user_id','<>',Auth::id())->first();
        if(!$checkPhone && !$checkMail)
        {
            try
            {
                DB::beginTransaction();
                // phát sinh lỗi
                if( !$data ) {

                    DB::rollBack();
                    // add lỗi vào kết quả trả về
                    $result->addException(('Không tìm thấy thông tin user để chỉnh sửa'), 500);
                    $result->setStatus(ServiceResponse::STATUS_ERROR);
                    $result->setStatusCode(500);
                    return $result;
                }
                DB::table('tbl_user')
                ->where( 'user_id', Auth::id())
                ->update([
                    'user_fullname'                 => $data['user_fullname'],
                    'user_mobile_phone'             => $data['user_mobile_phone'] ? $data['user_mobile_phone'] : null,
                    'user_email'                    => $data['user_email'] ? $data['user_email'] : null,
                    'user_skype'                    => $data['user_skype'] ? $data['user_skype'] : null,
                    'user_last_modified_time'       => time()
                ]);

                DB::commit();
                $result->setData( "Success" );
                return $result;
            } catch (\Exception $ex) {

                DB::rollBack();
                // add lỗi vào kết quả trả về
                $result->addException($ex->getMessage(), $ex->getCode());
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);

                // trả về cho controller
                return $result;
            }
        }
        else
        {
            $result->addException(('Email hoặc Số điện thoại này đã tồn tại'), 500);
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);
            return $result;
        }
    }

    /**
     * @todo Thay đổi password theo user_id
     * @author thanh
     * @since 08/03/2018
     * @param int $data: Tất cả tham số request đăng tin doanh nghiệp
     * @return Thay đổi password thành công
    */

}
