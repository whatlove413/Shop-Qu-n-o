<?php

namespace Modules\Web\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Services\Product\ProductService;

class ProductController  extends Controller
{
    private $paginate;
    use \Core\Traits\Helpers;
    public function __construct(ProductService  $productService)
    {
        $this->service = $productService;
    }

    public function list(Request $request)
    {
        $options = $request->all();
        $product = $this->service->list($options);
        $client = app("guzzleClient");
        $res = $client->request('GET', 'api.local.com/v1/category/');
        $headers = $res->getHeaders();
        $data = $res->getBody()->getContents();
        $data = json_decode($data, true)['data'];
        foreach ($data as  $cate) {
           if($cate['category_id'] == $options['category_id']);
           $name = $cate['category_name'];
        }
        return view('web::deal.deal', compact('product','name'));
    }
    /**
     * lấy trang chi tiết hàng vận chuyển theo alias
     * @param  $alias
     * @return hàng vận chuyển theo alias
     */
    public function detail($id)
    {
        //theo id
        $product = $this->service->detail($id);
        return view('web::deal.dealDetail', compact('product'));
    }
    public function order(Request $request)
    {
        //theo id
        $res = $this->sendParamsToApi('POST',$request->all(),'api.local.com/v1/product/order');
        $res = $res->getData()['data'];
       if($res['STATUS'] == "OK"){
           return redirect()->route('web::product',$request->all()['product_id'])->withSuccess($res['message']);
       }
       return redirect()->route('web::product',$request->all()['product_id'])->withErrors($res['message']);
    }

}
