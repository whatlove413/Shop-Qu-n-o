<?php

namespace Services;

use Core\Responders\ServiceResponse;
use DB;

class CategoryService
{

    use \Core\Traits\Helpers;

    // Danh sách tất cả các cột
    protected $all = [
        'category_id',
        'category_name',
        'category_parent_id',
        'category_note',
    ];


    /**
     * @todo Tạo tin mới
     * @author Hiển
     * @since 06/10/2018
     * @param array $request
     * @return $data
     */

    public function create($request)
    {
        $result = new ServiceResponse();

        // Sau khi xử lý các option loại bỏ tất cả options ko liên quan đến DB
        foreach ($request as $column => $value) {
            if (!in_array($column, $this->all)) {
                unset($request[$column]);
            }
        }
        //Bắt đầu thêm DB
        try {
            DB::beginTransaction();
            $id = DB::table('tbl_category')->insertGetId($request);
            if ($id) {
                DB::commit();
                $data = DB::table('tbl_category')->where('category_id', $id)->first();
                $result->setData(['data' => $data]);
                return $result;
            }
            else{
                $this->addError($result,['Có lỗi xảy ra']);
            }
        } catch (\Exception $ex) {
            $result = addError($result, $ex->getMessage(), $ex->getCode());
            return $result;
        }
    }

    /**
     * *
     * @todo Lấy danh sách tin kho
     * @author Hiển
     * @since 06/10/2018
     * @param array $options
     * @return $data danh sach tin
     * *
     */

    function list($options) {
        $result = new ServiceResponse();
        try {
            $data = DB::table('tbl_category');
            // Lấy danh sách theo người đăng tin
       
            $data = $data->orderBy('category_id', 'DESC');
            $data = $data->get()->toArray();
            $result->setData($data);
            return $result;
        }
        // Nếu xảy ra lỗi trong quá trình query thì add Error trả về front end
         catch (\Exception $ex) {
            $result = addError($result, $ex->getMessage(), $ex->getCode());
            return $result;
        }
    }

    /**
     * @todo Lấy chi tiết tin
     * @author Hiển
     * @since 08/10/2018
     * @param array $id
     * @return $data danh sach tin
     */

    public function detail($id)
    {
        $result = new ServiceResponse();
        try {
            $data = DB::table('tbl_product')
                ->where('product_id', $id)
                ->first();
            if ($data) {
                $result->setData(["data" => $data]);
                return $result;
            } else {
                $result = addError($result, "Tin không tồn tại");
                return $result;
            }
        } catch (\Exception $ex) {
            $result = addError($result, $ex->getMessage(), $ex->getCode());
            return $result;
        }
    }

    /**
     * @todo Xóa tin
     * @author Hiển
     * @since 08/10/2018
     * @param $id
     * @return $response
     */

    public function delete($request, $id)
    {
        $result = new ServiceResponse();
        // Lấy thông tin kho

        $warehouse = $this->detail($id);
        if ($warehouse->fails()) {
            return $this->addError($result, $warehouse->errors()->first());
        }
        $warehouse = (array) $warehouse->getData()['data'];

        // Lấy auth và kiểm tra quyền
        $auth = $this->getAuth($request)['data'];
        if ($auth['user_permission'] != '2' && $warehouse['warehouse_created_by'] != $auth['user_id']) {
            return $this->addError($result, ['Bạn không có quyền thực hiện thao tác này']);
        }

        try {
            DB::beginTransaction();
            $data = DB::table('tbl_warehouse')
                ->whereNull('warehouse_deleted_time')
                ->where('warehouse_id', $id);
            // Kiểm tra dữ liệu tồn tại
            if ($data->first()) {
                $res = $data->update([
                    'warehouse_deleted_time' => time(),
                    'warehouse_deleted_by' => $auth['user_id'],
                ]);
                // Kiểm tra response DB
                if ($res) {
                    DB::commit();
                    $result->setData([
                        'STATUS' => "OK",
                        'MESSAGE' => "Xóa tin thành công",
                    ]);
                    return $result;
                } else {
                    DB::rollBack();
                    $result = addError($result, 'Có lỗi xảy ra', 500);
                    return $result;
                }
            } else {
                $result = addError($result, 'Tin đã bị xóa hoặc không tồn tại', 500);
                return $result;
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            $result = addError($result, $ex->getMessage(), $ex->getCode());
            return $result;
        }
    }

    /**
     * @todo Validate
     * @author Hiển
     * @since 08/10/2018
     * @param $request
     * @return $response
     */
    private function validate($request)
    {
        if (!$request) {
            return "Không có params truyền vào";
        }
        if (!$request['warehouse_contact_phone']) {
            return "Vui lòng nhập số điện thoại người cung cấp tin";
        }
        if (!$request['warehouse_contact_name']) {
            return "Vui lòng nhập tên người cung cấp tin";
        }
        // Kiểm tra diện tích
        if (!is_numeric($request['warehouse_acreage'])) {
            return "Diện tích phải là số";
        }
        // Kiểm tra số điện thoại
        if (
            $request['warehouse_contact_phone'] &&
            (strlen($request['warehouse_contact_phone']) > 11 || !ctype_digit($request['warehouse_contact_phone']))
        ) {
            return "Số điện thoại không hợp lệ";
        }
        // Kiểm tra tọa độ
        if (!is_numeric($request['warehouse_address_lat']) || !is_numeric($request['warehouse_address_lng'])) {
            return "Tọa độ không hợp lệ";
        }
        return true;
    }
}
