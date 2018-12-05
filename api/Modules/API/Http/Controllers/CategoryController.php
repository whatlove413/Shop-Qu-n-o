<?php

namespace Modules\API\Http\Controllers;

use Auth;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Services\CategoryService;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function __construct(CategoryService $CategoryService, Request $request)
    {
        $this->service = $CategoryService;
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

    public function delete($id)
    {
        $response = $this->service->delete($request, $id);
        if ($response->fails()) {
            return $response->errors()->first();
        }
        $data = $response->getData();
        return $data;
    }
}
