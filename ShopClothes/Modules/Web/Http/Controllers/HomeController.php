<?php

namespace Modules\Web\Http\Controllers;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    private $paginate;

    public function __construct()
    {
    }

    public function index()
    {
        //lấy dữ liệu mua bán
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
