<?php

namespace Modules\API\Http\Controllers;

use Auth;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Services\ProductService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function __construct(ProductService $productService, Request $request)
    {
        $this->service = $productService;
        $this->request = $request;
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

    function list(Request $request) {
        $req = $request->all();

        $page = $req['page'] ? $req['page'] : 1;
        $per = $req['item-per-page'] ? $req['item-per-page'] : 10;
        // Lưu cache
        $res = $this->service->list($req);
        if ($res->fails()) {
                return $res->errors()->first();
        }
        $res =$res->getData();
        $sum = count($res);
        $data = array_splice($res, $per * ($page - 1), $per);
        
        $response = [
            "STATUS" => "OK",
            "paginate" => [
                "sum" => (int) $sum,
                "page" => (int) $page,
                "item-per-page" => (int) $per,
            ],
            "data" => $data,
        ];
        return $response;
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
        $res = $this->service->detail($id);
        if ($res->fails()) {
            return $res->errors()->first();
        }
        $data = $res->getData();
        $response = array_merge(["STATUS" => "OK"], $data);
        return $response;
    }

    /**
     * @todo Cập nhật tin
     * @author Hiển
     * @since 08/10/2018
     * @param array $request, $id tin
     * @return $response
     */

    public function update(Request $request, $id)
    {
        $req = $request->all();
        // merge header
        $req = array_merge($req, $this->getHeader());
        // update
        $res = $this->service->update($req, $id);
        if ($res->fails()) {
            return $res->errors()->first();
        }
        $data = $res->getData();
        $response = array_merge(["STATUS" => "OK"], $data);
        return $response;
    }

    /**
     * @todo Tạo tin mới
     * @author Hiển
     * @since 06/10/2018
     * @param array $request
     * @return $data
     */

    public function create(Request $request)
    {
        $req = $request->all();
        // merge header
        
        $req = [
            'product_name' => "Quần Jeane Nữ",
            'product_category_id' => "3",
            'product_brand_name' => '',
            'product_price' => 290000 ,
            'product_quantity' => json_encode([
                'trắng' => [
                    "small" => 10,
                    "large" => 12,
                    "xlarge" => 13,
                ],
                'đen' => [
                    "small" => 1,
                    "large" => 3,
                    "xlarge" => 7
                ],
            ]),
        ];
        $res = $this->service->create($req);
        if ($res->fails()) {
            return $res->errors()->first();
        }
        $data = $res->getData();
        $response = array_merge(["STATUS" => "OK"], $data);
        return $response;
    }

    /**
     * @todo Xóa tin
     * @author Hiển
     * @since 08/10/2018
     * @param $id
     * @return $response
     */

    public function order(Request $request)
    {
        $request = $request->all();
        $res = $this->service->order($request);
        return $res;
    }
}
