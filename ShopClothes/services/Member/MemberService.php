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

    public function renewPass($id,$pass)
    {
        $id = (int) $id;
        $password = Hash::make($pass);
        $result = new ServiceResponse();
        try
        {
            DB::beginTransaction();
                //cập nhật lại mã
            $user = DB::table('tbl_user')->where('user_id',$id)->update([
                'user_password'               => $password,
                'user_last_modified_time'     => time(),
            ]);
                // phát sinh lỗi
            if( !$user ) {

                DB::rollBack();
                    // add lỗi vào kết quả trả về
                $result->addException(('Thay đổi mật khẩu thất bại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }
            return $result;
            DB::commit();
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

    public function getInfoMemberForgetPass($user)
    {
        $result = new ServiceResponse();
        try
        {
            // phát sinh lỗi
            if( !$user ) {
                // add lỗi vào kết quả trả về
                $result->addException(('Không tìm thấy id của member'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }

            $queryBuilder = DB::table('tbl_user')
            ->select('*')
            ->where('user_mobile_phone',$user)
            ->orWhere('user_email' ,$user)
            ->first();

            if( !$queryBuilder )
            {

                // add lỗi vào kết quả trả về
                $result->addException(('Email/Số điện thoại này không tồn tại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }

            $result->setData($queryBuilder);
            return $result;
        } catch (\Exception $ex) {
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);
            return $result;
        }

    }
    public function checkActive($data)
    {
        //check dữ liệu mã token và id user
        $result = new ServiceResponse();
        $queryBuilder = DB::table('tbl_user')
        ->whereNull('user_deleted_time')
        ->where('user_id',Auth::user()->user_id)
        ->where('user_active_code',$data['active_code'])->first();
        //nếu trùng token chuyển status user thành active
        if($queryBuilder != null)
        {
            if($queryBuilder->user_status != "ACTIVED")
            {
                try
                {
                    DB::beginTransaction();
                    //cập nhật tình trạng user và thời gian cập nhật tình trạng
                    $id = DB::table('tbl_user')->where('user_id',Auth::user()->user_id)->update([
                        'user_status'               => 'ACTIVED',
                        'user_last_modified_time'   => time()
                    ]);
                    // phát sinh lỗi
                    if( !$id ) {

                        DB::rollBack();
                        // add lỗi vào kết quả trả về
                        $result->addException(('Kích hoạt tài khoản thất bại'), 500);
                        $result->setStatus(ServiceResponse::STATUS_ERROR);
                        $result->setStatusCode(500);
                        return $result;
                    }

                     //lấy tên và email qua id truyền vào mail
                    $user_info = DB::table('tbl_user')
                    ->select('user_fullname','user_email')
                    ->where('user_id',Auth::user()->user_id)->first();
                    // gửi mail
                    if($user_info->user_email)
                    {
                        $mailable = new WelcomeMail($user_info->user_fullname);
                        Mail::to($user_info->user_email)->send($mailable);
                    }
                    DB::commit();
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
                $result->addException("Tài khoản này đã kích hoạt rồi");
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);

                return $result;
            }
        }
        else {
            DB::rollBack();
                // add lỗi vào kết quả trả về
            $result->addException("Mã không tồn tại");
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);
                // trả về cho controller
            return $result;
        }
    }
    // xác nhận tài khoản bằng link
    public function activeWithoutCode($token)
    {
        $result = new ServiceResponse();
        try
        {
            DB::beginTransaction();
                //cập nhật tình trạng user và thời gian cập nhật tình trạng
            $id = DB::table('tbl_user')->where('user_active_code',$token)->update([
                'user_status'               => 'ACTIVED',
                'user_last_modified_time'   => time()
            ]);
                // phát sinh lỗi
            if( !$id ) {

                DB::rollBack();
                    // add lỗi vào kết quả trả về
                $result->addException(('Kích hoạt tài khoản thất bại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }
            DB::commit();
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

    public function generateCode($id_user)
    {
        $token = rand(100000,999999);
        $result = new ServiceResponse();
        try
        {
            DB::beginTransaction();
                //cập nhật lại mã
            $id = DB::table('tbl_user')->where('user_id',$id_user)->update([
                'user_active_code'          => $token,
                'user_last_modified_time'   => time()
            ]);
                // phát sinh lỗi
            if( !$id ) {

                DB::rollBack();
                    // add lỗi vào kết quả trả về
                $result->addException(('Tạo mã mới thất bại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }

            //lấy tên và email qua id truyền vào mail
            $user_info = DB::table('tbl_user')
            ->select('user_fullname','user_email','user_mobile_phone')
            ->where('user_id',$id_user)->first();
                // gửi mail
            if($user_info->user_email)
            {
                $mailable = new RegisteredUser($user_info->user_fullname,$token);
                Mail::to($user_info->user_email)->send($mailable);
            }
            DB::commit();
            return $token;
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

    /**
     * @todo Báo cáo tin xấu
     * @author đại
     * @since 03/05/2018
     * @param int $data: tất cả tham số báo cáo
     * @return thêm báo cáo thành công
    */

    public function badPost( $data )
    {
        $result = new ServiceResponse();
        try
        {
            DB::beginTransaction();
            // phát sinh lỗi
            if( !$data) {

                DB::rollBack();
                // add lỗi vào kết quả trả về
                $result->addException(('Không tìm thấy thông tin'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }
            $id = DB::table('tbl_bad_post')->insertGetId([
                'bad_post_post_id'          =>  $data['bad_post_post_id'],
                'bad_post_post_object'      =>  $data['bad_post_post_object'],
                'bad_post_name'             =>  $data['bad_post_name'],
                'bad_post_mobile'           =>  $data['bad_post_mobile'],
                'bad_post_email'            =>  $data['bad_post_email'],
                'bad_post_content'          =>  $data['bad_post_content'],
                'bad_post_created_time'     =>  time()
            ]);
            if( !$id ) {

                DB::rollBack();
                    // add lỗi vào kết quả trả về
                $result->addException(('Gửi thất bại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }

            DB::commit();
            $result->setData( $id );
            return $result;
                 // phát sinh lỗi
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
        /**
     * @todo Gửi góp ý, liên hệ
     * @author đại
     * @since 03/05/2018
     * @param int $data: tất cả tham số request góp ý, liên hệ
     * @return Góp ý, liên hệ thành công
    */

    public function contactPost( $data )
    {
        $result = new ServiceResponse();
        try
        {
            DB::beginTransaction();
            // phát sinh lỗi
            if( !$data) {

                DB::rollBack();
                // add lỗi vào kết quả trả về
                $result->addException(('Không tìm thấy thông tin'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }
            $id = DB::table('tbl_contact')->insertGetId([
                'contact_title'             =>  $data['contact_title'],
                'contact_name'              =>  $data['contact_name'],
                'contact_email'             =>  $data['contact_email'],
                'contact_phone'             =>  $data['contact_phone'],
                'contact_content'           =>  $data['contact_content'],
                'contact_created_at'        =>  $data['contact_created_at'],
                'contact_type'              =>  $data['contact_type'],
                'contact_create_time'       =>  time()
            ]);
            if( !$id ) {

                DB::rollBack();
                    // add lỗi vào kết quả trả về
                $result->addException(('Gửi thất bại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }

            DB::commit();
            $result->setData( $id );
            return $result;
                 // phát sinh lỗi
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

        /**
     * @todo Đăng ký thành viên
     * @author thanh
     * @since 05/03/2018
     * @param int $data: tất cả tham số request đăng ký thành viên
     * @return Đăng ký thành viên thành công
    */

        public function createUser( $data )
        {
            $token = rand(100000,999999);
        // dữ liệu trả vềdd($data);
            $result = new ServiceResponse();
            try
            {
                DB::beginTransaction();
            // phát sinh lỗi
                if( !$data) {

                    DB::rollBack();
                // add lỗi vào kết quả trả về
                    $result->addException(('Không tìm thấy thông tin để đăng ký'), 500);
                    $result->setStatus(ServiceResponse::STATUS_ERROR);
                    $result->setStatusCode(500);
                    return $result;
                }
                if(strpos($data['user_email_phone'], "@")==true){
                    $user = DB::table('tbl_user')->insertGetId([
                        'user_fullname'           =>  $data['user_fullname'],
                        'user_email'              =>  $data['user_email_phone'],
                        'user_password'           =>  Hash::make($data['user_password']),
                        'user_active_code'        =>  $token,
                        'user_created_time'       =>  time()
                    ]);
                    if( !$user ) {

                        DB::rollBack();
                    // add lỗi vào kết quả trả về
                        $result->addException(('Đăng ký thất bại'), 500);
                        $result->setStatus(ServiceResponse::STATUS_ERROR);
                        $result->setStatusCode(500);
                        return $result;
                    }

                // gửi mail
                    $mailable = new RegisteredUser($data['user_fullname'],$token);
                    Mail::to($data['user_email_phone'])->send($mailable);

                    DB::commit();
                    $result->setData( $user );
                    return $user;
                }
                elseif(ctype_digit ($data['user_email_phone'])==true){
                    $user = DB::table('tbl_user')->insertGetId([
                        'user_fullname'           =>  $data['user_fullname'],
                        'user_mobile_phone'       =>  $data['user_email_phone'],
                        'user_password'           =>  Hash::make($data['user_password']),
                        'user_active_code'        =>  $token,
                        'user_created_time'       =>  time()
                    ]);
                    if( !$user) {

                        DB::rollBack();
                    // add lỗi vào kết quả trả về
                        $result->addException(('Đăng ký thất bại'), 500);
                        $result->setStatus(ServiceResponse::STATUS_ERROR);
                        $result->setStatusCode(500);
                        return $result;
                    }
                // gửi sms
                    $content = "Ma xac nhan: ".$token;
                    $sendNumber = $data['user_email_phone'];
                    /*app('sms')->sendSms($sendNumber,$content);*/

                    DB::commit();
                    $result->setData( $user );
                    return $user;
                }
                 // phát sinh lỗi
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

    /**
	 * @todo Quên mật khẩu
	 * @author đại
	 * @since 21/04/2018
	 * @param $data: email hoặc số điện thoại
	 * @return token mã active
	*/

    public function forgetPass( $data )
    {
        $token = rand(100000,999999);
        // dữ liệu trả vềdd($data);
        $result = new ServiceResponse();
        try
        {
            DB::beginTransaction();
            // phát sinh lỗi
            if( !$data) {

                DB::rollBack();
                // add lỗi vào kết quả trả về
                $result->addException(('Không tìm thấy thông tin'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }
            // xác nhận email
            $user = DB::table('tbl_user')->where('user_email','LIKE',$data)->update([
                'user_active_code'          => $token,
                'user_status'               => 'UNACTIVE',
                'user_last_modified_time'   => time()
            ]);
            if( !$user ) {

                DB::rollBack();
                    // add lỗi vào kết quả trả về
                $result->addException(('Email không tồn tại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }
            $user_info = DB::table('tbl_user')
            ->select('*')
            ->where('user_email',$data)->first();
                // gửi mail
            $mailable = new ForgetPass($user_info->user_fullname,$token);
            Mail::to($user_info->data)->send($mailable);

            DB::commit();
            $result->setData( $user_info );
            return $result;

                 // phát sinh lỗi
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
    public function postResetPass( $data )
    {
        // dữ liệu trả về
        $result = new ServiceResponse();
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
                'user_password'                 => Hash::make($data['new_pass']),
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
}
