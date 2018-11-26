<?php

namespace Services\Deal;

use Auth;
use Core\Responders\ServiceResponse;
use DB;

class DealService
{

    /**
     * @todo Lấy danh sách tin mua bán
     * @author Đại
     * @since 08/03/2018
     * @param int $options: Các biến hay tham số cần
     * @return câu truy vấn các danh sách tin mua bán
     */
    public function getDeal($options)
    {
        $result = new ServiceResponse();
        try {

            if ($options['paginate']) {

                $options['mode'] = 'QueryBuilder';
                $queryBuilder = $this->getAllDeal($options);

                return $queryBuilder->paginate($options['paginate']);
            }
            return $this->getAllDeal($options);

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
     * @todo Lấy danh sách tin mua bán
     * @author Đại
     * @since 08/03/2018
     * @param int $options: Các biến hay tham số cần
     * @return câu truy vấn các danh sách tin mua bán
     */
    private function getAllDeal($options)
    {
        // lấy tất cả dữ liệu trong bảng tbl_deal
        $queryBuilder = DB::table('tbl_deal')
            ->whereNull('deal_deleted_time')
            ->where('deal_status', 'ACTIVE')
            ->orderBy('deal_priority', 'DESC')
            ->orderBy('deal_created_time', 'DESC');
        /*dd($queryBuilder);*/
        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }
        return $queryBuilder->get();
    }
    /**
     * @todo Lấy danh sách tin mua bán theo user
     * @author Đại
     * @since 08/03/2018
     * @param int $options: Các biến hay tham số cần
     * @return câu truy vấn các danh sách tin mua bán theo user
     */
    public function getDealByUser($options)
    {
        $result = new ServiceResponse();
        try {

            if ($options['paginate']) {

                $options['mode'] = 'QueryBuilder';
                $queryBuilder = $this->getAllDealByUser($options);

                return $queryBuilder->paginate($options['paginate']);
            }
            return $this->getAllDealByUser($options);

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
     * @todo Search all mua bán
     * @author Đại
     * @since 06/04/2018
     * @param int $options,$data: Các biến hay tham số cần và keyword
     * @return câu truy vấn các danh sách mua bán
     */
    public function getSearchAll($options, $data)
    {
        // dữ liệu trả về
        $result = new ServiceResponse();
        try {

            if ($options['paginate']) {

                $options['mode'] = 'QueryBuilder';
                $queryBuilder = $this->getAllSearchAll($options, $data);

                return $queryBuilder->paginate($options['paginate']);
            }
            return $this->getAllSearchAll($options, $data);

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
     * @todo Search all mua bán
     * @author Đại
     * @since 06/04/2018
     * @param int $options,$data: Các biến hay tham số cần và keyword
     * @return câu truy vấn các danh sách mua bán
     */
    private function getAllSearchAll($options, $data)
    {
        // lấy tất cả dữ liệu trong bảng tbl_deal
        $queryBuilder = DB::table('tbl_deal')
            ->whereNull('deal_deleted_time')
            ->where('deal_status', 'ACTIVE')
            ->where(function ($query) use ($data) {
                $query->orwhere('deal_name', "LIKE", "%" . $data . "%");
                $query->orWhere('deal_type_of', "LIKE", "%" . $data . "%");
                $query->orWhere('deal_vehicles', "LIKE", "%" . $data . "%");
                $query->orWhere('deal_weight', "LIKE", "%" . $data . "%");
                $query->orWhere('deal_note', "LIKE", "%" . $data . "%");
                $query->orWhere('deal_view_place', "LIKE", "%" . $data . "%");
                $query->orWhere('deal_price', "LIKE", "%" . $data . "%");
            })
            ->orderBy('deal_priority', 'DESC')
            ->orderBy('deal_created_time', 'DESC');
        // dd($queryBuilder);
        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }
        return $queryBuilder->get();
    }

    /**
     * @todo Lấy danh sách mua bán
     * @author Đại
     * @since 08/03/2018
     * @param int $options: Các biến hay tham số cần
     * @return câu truy vấn các danh sách phương tiện vận chuyển
     */
    private function getAllDealByUser($options)
    {
        // lấy tất cả dữ liệu trong bảng tbl_deal
        $queryBuilder = DB::table('tbl_deal')
            ->whereNull('deal_deleted_time')
            ->where('deal_status', 'ACTIVE')
            ->where('deal_created_by', Auth::user()->user_id)
            ->orderBy('deal_priority', 'DESC')
            ->orderBy('deal_created_time', 'DESC');
        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }
        return $queryBuilder->get();
    }

    /**
     * @todo Lấy tin mua bán theo id
     * @author Đại
     * @since 08/03/2018
     * @param int $id: id của tin mua bán
     * @return câu truy vấn lấy tin mua bán theo id
     */
    public function getSearchById($id)
    {
        // lấy tất cả dữ liệu trong bảng tbl_vehicle_open
        $queryBuilder = DB::table('tbl_deal')
            ->whereNull('deal_deleted_time')
            ->where('deal_status', 'ACTIVE')
            ->where('deal_id', $id);
        return $queryBuilder->first();
    }
    /**
     * @todo tìm tin mua bán theo loại phương tiện, đỉa chỉ sort theo thời gian đăng tin, giá
     * @author Đại
     * @since 02/05/2018
     * @param int $options,$condition: Các biến hay tham số cần, và điều kiện lọc
     * @return câu truy vấn các danh sách mua bán
     */
    public function searchDeal($options, $condition)
    {
        // dữ liệu trả về
        $result = new ServiceResponse();
        try {

            if ($options['paginate']) {

                $options['mode'] = 'QueryBuilder';
                $queryBuilder = $this->searchAllDeal($options, $condition);

                return $queryBuilder->paginate($options['paginate']);
            }
            return $this->searchAllDeal($options, $condition);

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
     * @todo tìm tin mua bán theo loại phương tiện, đỉa chỉ sort theo thời gian đăng tin, giá
     * @author Đại
     * @since 02/05/2018
     * @param int $options,$condition: Các biến hay tham số cần, và điều kiện lọc
     * @return câu truy vấn các danh sách mua bán
     */
    private function searchAllDeal($options, $condition)
    {
        // lấy tất cả dữ liệu trong bảng tbl_cargo_offer theo điều kiện
        $queryBuilder = DB::table('tbl_deal')
            ->where('deal_status', 'ACTIVE')
            ->whereNull('deal_deleted_time');
        if ($condition['deal_vehicles'] != null) {
            $queryBuilder->where("deal_vehicles", "LIKE", "%" . $condition["deal_vehicles"] . "%");
        }
        if ($condition['deal_view_place'] != null) {
            $queryBuilder->where('deal_view_place', "LIKE", "%" . $condition['deal_view_place'] . "%");
        }
        if ($condition['deal_price'] != null) {
            if ($condition['deal_price'] == "ASC") {
                $queryBuilder->orderBy('deal_price', 'ASC')
                    ->orderBy('deal_priority', 'DESC')
                    ->orderBy('deal_created_time', 'DESC');
            } else {
                $queryBuilder->orderBy('deal_price', 'DESC')
                    ->orderBy('deal_priority', 'DESC')
                    ->orderBy('deal_created_time', 'DESC');
            }

        }
        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }
        return $queryBuilder->get();
    }
    /**
     * @todo Đăng tin mua bán
     * @author Đại
     * @since 27/03/2018
     * @param int $data: Tất cả tham số request
     * @return đăng tin thành công
     */

    public function uploadDeal($data)
    {
        $name = uploadManyFile($data['images'], 'upload/deal/images/original');
        return $name;
    }

    public function postDeal($data)
    {
        $priority = $data['deal_priority'] + 1;
        $price = str_replace(",", "", $data['deal_price']);
        if (!$price) {
            $price = 0;
        }
        // dữ liệu trả về
        $result = new ServiceResponse();
        try
        {
            DB::beginTransaction();
            $name = json_encode($data['images']);
            $id = DB::table('tbl_deal')->insertGetId(
                [
                    'deal_name' => $data['deal_name']
                    , 'deal_type_of' => $data['deal_type_of']
                    , 'deal_priority' => $priority
                    , 'deal_vehicles' => $data['deal_vehicles']
                    , 'deal_weight' => $data['deal_weight']
                    , 'deal_note' => $data['deal_note']
                    , 'deal_view_place' => $data['deal_view_place']
                    , 'deal_view_place_lat' => $data['deal_view_place_lat']
                    , 'deal_view_place_lng' => $data['deal_view_place_lng']
                    , 'deal_view_place_place_id' => $data['deal_view_place_place_id']
                    , 'deal_price' => $price
                    , 'deal_contact_fullname' => $data['deal_contact_fullname']
                    , 'deal_phone' => $data['deal_phone']
                    , 'deal_images' => $name
                    , 'deal_created_time' => time()
                    , 'deal_created_by' => Auth::user()->user_id,
                ]
            );
            // phát sinh lỗi
            if (!$id) {

                DB::rollBack();
                // add lỗi vào kết quả trả về
                $result->addException(('Đăng tin thất bại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }

            DB::commit();
            $result->setData($id);
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

    public function searchDealList($key, $type, $options)
    {
        try {

            if ($options['paginate']) {

                $options['mode'] = 'QueryBuilder';
                $queryBuilder = $this->getDealSearchList($key, $type, $options);
                return $queryBuilder->paginate($options['paginate']);
            }
            return $this->getDealSearchList($key, $area, $options);

        } catch (\Exception $ex) {
            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }
    }

    public function getDealSearchList($key, $type, $options)
    {
        if (!$type) {
            $queryBuilder = DB::table('tbl_deal')
                ->where('deal_name', "LIKE", '%' . $key . "%")
                ->orWhere('deal_phone', "LIKE", '%' . $key . "%")
                ->orWhere('deal_vehicles', "LIKE", "%" . $data . "%")
                ->orWhere('deal_view_place', "LIKE", '%' . $key . "%")
                ->orWhere('deal_contact_fullname', "LIKE", '%' . $key . "%")
                ->orWhere('deal_note', "LIKE", "%" . $data . "%")
                ->whereNull('deal_deleted_time')
                ->orderBy('deal_priority', 'DESC')
                ->orderBy('deal_created_time', 'DESC');
        } else {
            if ($key != null) {
                $queryBuilder = DB::table('tbl_deal')
                    ->whereNull('deal_deleted_time')
                    ->where('deal_type_of', "=", $type)
                    ->where(function ($query) use ($key) {
                        $query->where('deal_name', "LIKE", '%' . $key . "%");
                        $query->orWhere('deal_vehicles', "LIKE", "%" . $data . "%");
                        $query->orWhere('deal_phone', "LIKE", '%' . $key . "%");
                        $query->orWhere('deal_view_place', "LIKE", '%' . $key . "%");
                        $query->orWhere('deal_contact_fullname', "LIKE", '%' . $key . "%");
                        $query->orWhere('deal_note', "LIKE", "%" . $data . "%");
                    })
                    ->orderBy('deal_priority', 'DESC')
                    ->orderBy('deal_id', 'DESC');
            }

        }
        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }
        return $queryBuilder->get();
    }

    public function searchListByCate($type, $options)
    {
        try {

            if ($options['paginate']) {
                $options['mode'] = 'QueryBuilder';
                $queryBuilder = $this->getListByCate($type, $options);
                return $queryBuilder->paginate($options['paginate']);
            }
            return $this->getListByCate($type, $options);

        } catch (\Exception $ex) {
            // add lỗi vào kết quả trả về
            dd($ex);
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }
    }

    public function getListByCate($type, $options)
    {
        $queryBuilder = DB::table('tbl_deal')
            ->whereNull('deal_deleted_time')
            ->where('deal_status', 'ACTIVE')
            ->where('deal_type_of', $type)
            ->orderBy('deal_priority', 'DESC')
            ->orderBy('deal_created_time', 'DESC');
        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }
        return $queryBuilder->get();
    }

    public function getDealByUserAd($options, $id)
    {
        $result = new ServiceResponse();
        try {

            if ($options['paginate']) {

                $options['mode'] = 'QueryBuilder';
                $queryBuilder = $this->getAllDealByUserAd($options, $id);

                return $queryBuilder->paginate($options['paginate']);
            }
            return $this->getAllDealByUserAd($options, $id);

        } catch (\Exception $ex) {

            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }
    }
    private function getAllDealByUserAd($options, $id)
    {
        // lấy tất cả dữ liệu trong bảng tbl_deal
        $queryBuilder = DB::table('tbl_deal')
            ->whereNull('deal_deleted_time')
            ->where('deal_status', 'ACTIVE')
            ->where('deal_created_by', $id)
            ->orderBy('deal_priority', 'DESC')
            ->orderBy('deal_created_time', 'DESC');
        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }
        return $queryBuilder->get();
    }
}
