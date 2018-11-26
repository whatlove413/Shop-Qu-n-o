<?php

namespace Modules\Web\Http\Controllers;

use Illuminate\Routing\Controller;
use Services\Deal\DealService;

class HomeController extends Controller
{
    private $paginate;

    public function __construct(DealService $dealService)
    {
        $this->dealService = $dealService;
    }

    public function index()
    {
        //lấy dữ liệu mua bán
        $deal = $this->dealService->getDeal(['paginate' => $this->paginate['so-tin']]);
        return view('web::home.index', compact('deal'));
    }

    // trang hướng dẫn sử dụng
    public function guide()
    {
        $constant = $this->constantService->getIndexConstant();
        $constant = $constant->getData();
        return view('web::home.guide', compact('constant'));
    }
}
