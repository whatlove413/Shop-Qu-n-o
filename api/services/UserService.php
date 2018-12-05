<?php

namespace Services;

use Core\Responders\ServiceResponse;
use DB;
use Hash;

class UserService
{
    use \Core\Traits\Helpers;
    use \Core\Traits\Login;

    protected $column = [
        'user_id',
        'user_fullname',
        'user_mobile_phone',
        'user_email',
        'user_address',
        'user_password',
        'user_permission',
        'user_active_code',
        'user_active_time',
        'user_confirm_code',
        'user_confirm_time',
        'user_status',
        'user_deleted_time',
        'user_discount'
    ];

    protected $detail = [
        'user_id',
        'user_fullname',
        'user_mobile_phone',
        'user_email',
        'user_address',
        'user_status',
    ];
    /**
     * @todo Tạo user mới
     * @author Hiển
     * @since 09/10/2018
     * @param array $request
     * @return $data
     */

    public function register($request)
    {
        $result = new ServiceResponse();
        // Validate các params trong request
        $validate = $this->validate($request);
        if (!is_bool($validate)) {
            return $this->addError($result, [$validate]);
        }
        if($request['user_permission']==1){
            $request['user_discount'] = 10;
        }
        else if ($request['user_permission']==2){
            $request['user_discount'] = 30;
        }
        else{
            $request['user_discount'] = 0;
        }
        foreach ($request as $key => $value) {
            if (!in_array($key, $this->column)) {
                unset($request[$key]);
            }
        }
        try {
            $request['user_password'] = Hash::make($request["user_password"]);
            $id = DB::table('tbl_user')->insertGetId($request);
            if (!$id) {
                return $this->addError($result, ['Có lỗi xảy ra']);
            }
            DB::commit();
            // Lấy thông tin user sau khi thay đổi
            $user = DB::table('tbl_user')
                ->select($this->detail)
                ->where('user_id', $id)
                ->first();
            // Trả result
            $result->setData(['data' => $user]);
            return $result;
        } catch (\Exception $ex) {
            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }
    }

    /**
     * @todo Cập nhật user
     * @author Hiển
     * @since 09/10/2018
     * @param array $request
     * @return $data
     */

    public function update($request, $id)
    {
        $result = new ServiceResponse();
        $user = DB::table('tbl_user')->where('user_id',$id)->first();
        if(!$user){
            return $this->addError($result, ['Người dùng không tồn tại']);
        }
        // Validate request
        $validate = $this->validate($request, $id);
        if (!is_bool($validate)) {
            return $this->addError($result, [$validate]);
        }

        foreach ($request as $key => $value) {
            if (!in_array($key, $this->detail)) {
                unset($request[$key]);
            }
        }
        // Bắt đầu update
        try {
            DB::beginTransaction();
            // Băm mật khẩu ra trước khi nhập vào DB
            $request['user_password'] = Hash::make($request["user_password"]);

            // Lấy response DB trả về khi update
            $request = DB::table('tbl_user')->where('user_id', $id)->update($request);
            // update ko thành công thì báo lỗi
            if (!$update) {
                return $this->addError($result, ['Có lỗi xảy ra']);
            }

            // Lưu lại update nếu update thành công
            DB::commit();

            // Lấy dữ liệu user mới tạo và trả về api
            $user = DB::table('tbl_user')
                ->select($this->column['detail'])
                ->where('user_id', $id)
                ->first();
            $result->setData(['data' => $user]);
            return $result;

        } catch (\Exception $ex) {
            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }
    }

    /**
     * @todo Lấy chi tiết tài khoản
     * @author Hiển
     * @since 09.10.2018
     * @param array $options
     * @return Response
     */

    public function detail($id)
    {
        $result = new ServiceResponse();

        // Bắt đầu update
        try {
            DB::beginTransaction();
            $user = DB::table('tbl_user')
                ->select($this->column['detail'])
                ->where('user_id', $id)
                ->first();
            $result->setData(['data' => $user]);
            return $result;

        } catch (\Exception $ex) {
            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }
    }

    /**
     * @todo Khóa tài khoản
     * @author Hiển
     * @since 09.10.2018
     * @param array $options
     * @return Response
     */

    public function delete($request, $id)
    {
        $result = new ServiceResponse();

        // Kiểm tra quyền của user
        $auth = (Array) $this->findUserByToken($request)->getData()['users'];

        // Bỏ auth
        unset($request['authorization'], $request['deviceid']);

        // Nếu ko phải admin thì ko có quyền xóa user
        if ($auth['user_permission'] != "2") {
            return $this->addError($result, ["Bạn không có quyền thực hiện hành động này"], 403);
        }

        try {
            // update thời gian xóa
            $query = DB::table('tbl_user')
                ->where('user_id', $id)
                ->update(['user_deleted_time' => time()]);

            // Nếu update thất bại
            if (!$query) {
                return $this->addError($result, ['Không thể xóa tài khoản này']);
            }

            $result->setData(['Message' => "Xóa tài khoản thành công"]);
            return $result;
        } catch (\Exception $ex) {
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);
            return $result;
        }
    }

    /**
     * @todo Validate request tạo user
     * @author Hiển
     * @since 09/10/2018
     * @param array $request
     * @return Response
     */

    private function validate($request, $id = null)
    {
        $user = DB::table('tbl_user');
        // Kiểm tra params
        if (!$request) {
            return "Không có params truyền vào";
        }
        // Kiểm tra sdt hoặc email
        if (!$request['user_email'] && !$request['user_mobile_phone']) {
            return "Tài khoản phải có số điện thoại hoặc email";
        }
        // Validate sđt
        if (
            $request['user_mobile_phone'] &&
            (strlen($request['user_mobile_phone']) > 11 || !ctype_digit($request['user_mobile_phone']))
        ) {
            return "Số điện thoại không hợp lệ";
        }
        // Validate EMAIL
        if ($request['user_email'] && !strpos($request['user_email'], "@")) {
            return "Email không hợp lệ";
        }
        // Check Unique EMAIL
        if (
            $request['user_email'] && $id &&
            $user->where('user_email', $request['user_email'])->where('user_id', '!=', $id)->first()
        ) {
            return "Email này đã tồn tại";
        } elseif (
            $request['user_email'] &&
            $user->where('user_email', $request['user_email'])->first()
        ) {
            return "Email này đã tồn tại";
        }
        // Check Unique SĐT
        if (
            $request['user_mobile_phone'] && $id &&
            $user->where('user_mobile_phone', $request['user_mobile_phone'])->where('user_id', '!=', $id)->first()
        ) {
            return "Số điện thoại này đã tồn tại";
        } elseif (
            $request['user_mobile_phone'] &&
            $user->where('user_mobile_phone', $request['user_mobile_phone'])->first()
        ) {
            return "Số điện thoại này đã tồn tại";
        }
        // Check Pass
        if (!$request['user_password']) {
            return "Vui lòng nhập mật khẩu";
        }
        return true;
    }


    /**
     * @todo Lấy danh sách tài khoản
     * @author Hiển
     * @since 09.10.2018
     * @param array $options
     * @return Response
     */
    function list($options = null) {
        $result = new ServiceResponse();
        try {
            $list = DB::table('tbl_user')
                ->select($this->detail)
                ->whereNull('user_deleted_time')
                ->distinct();
            $data = $list->get()->toArray();
            $result->setData($data);
            return $result;

        } catch (\Exception $ex) {
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);
            return $result;
        }
    }

    /**
     * @todo Lấy info đăng nhập
     * @author Đại
     * @since 13.9.2018
     * @param $options: các params truyền vào
     * @return response
     */
    public function login($options = null)
    {
        /** dữ liệu trả về */
        $result = new ServiceResponse();
        try
        {
            /** phát sinh lỗi - Không có tham số truyền vào */
            if (!$options) {
                /** add lỗi vào kết quả trả về */
                return $this->addError($result, ["không có params truyền vào"]);
            }

            $users = DB::table('tbl_user')
                ->whereNull("user_deleted_time");
            if ($options['user_email']) {
                $users = $users->where('user_email', $options['user_email']);
            }
            if ($options['user_mobile_phone']) {
                $users = $users->where('user_mobile_phone', $options['user_mobile_phone']);
            }
            /** Tìm theo mật khẩu */
            $users= $users->first();
            if ($options["user_password"]) {
                /** Nếu tồn tại toàn khoản */
                if ($users) {
                    $password = $users->user_password;
                    /** Kiểm tra mật khẩu người dùng nhập và DB */
                    if (!Hash::check($options["user_password"], $password)) {
                        $users = null;
                    }
                }
            }
            foreach ($users as $key => $value) {
                if (!in_array($key, $this->detail)) {
                    unset($users->$key);
                }
            }
            $result->setData($users);
            return $result;
        } catch (\Exception $ex) {

            /** add lỗi vào kết quả trả về */
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            /** trả về cho controller */
            return $result;
        }
    }

    /**
     * @todo fix error search D - Đ
     * @version 1
     * @param $query
     * @param $column
     * @return $query
     */
    public function setHelpersSearch($query, $column)
    {
        $first = 0;
        foreach ($column as $k => $v) {
            $v = strtolower($v);
            if ($first == 0) {
                $query = $query->whereRaw("REPLACE(LCASE(" . $k . "), 'đ', 'd') LIKE '%" . $v . "%'")
                    ->orWhereRaw("REPLACE(LCASE(" . $k . "), 'd', 'đ') LIKE '%" . $v . "%'");
                $first = 1;
            } else {
                $query = $query->orWhereRaw("REPLACE(LCASE(" . $k . "), 'đ', 'd') LIKE '%" . $v . "%'")
                    ->orWhereRaw("REPLACE(LCASE(" . $k . "), 'd', 'đ') LIKE '%" . $v . "%'");
            }
        }
        return $query;
    }

}
