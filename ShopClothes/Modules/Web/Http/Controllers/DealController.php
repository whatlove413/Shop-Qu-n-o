<?php

namespace Modules\Web\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Services\Deal\DealService;

class DealController extends Controller
{
    private $paginate;
    public function __construct(DealService $dealService)
    {
        $this->service = $dealService;
    }
    /**
     * Hiện trang chủ vận chuyển
     * @return trang chủ vân chuyển
     */
    public function index()
    {
        // $deal = $this->service->getDeal();
        return view('web::deal.deal');
    }

    public function uploadImage(Request $request)
    {
        $name = $this->service->uploadDeal($request);
        return $name;
    }

    /**
     * tìm tin mua bán theo địa chỉ, loại phương tiện sort theo thời gian đăng tin, giá
     * @param  $request
     * @return hàng vận chuyển theo từng $area
     */
    public function searchDeal(Request $request)
    {
        $search_info = $request->all();
        $deal = $this->service->searchDeal($search_info);
        return view('web::deal.deal', compact('deal', 'search_info'));
    }
    /**
     * lấy trang chi tiết hàng vận chuyển theo alias
     * @param  $alias
     * @return hàng vận chuyển theo alias
     */
    public function getDealDetail($id)
    {
        //theo id
        $dealbyid = $this->service->getSearchById($id);
        if ($dealbyid) {
            //tin liên quan
            $deal = $this->service->getDeal();
            return view('web::deal.dealDetail', compact('deal', 'dealbyid'));
        } else {
            return redirect()->route('web::index_deal');
        }

    }

}
