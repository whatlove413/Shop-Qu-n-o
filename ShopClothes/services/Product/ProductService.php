<?php

namespace Services\Product;

use Auth;
use Core\Responders\ServiceResponse;

class ProductService
{
    use \Core\Traits\Helpers;

    public function list($options){
        $res = $this->sendParamsToApi('GET',$options,'api.local.com/v1/product');
        $res = $res->getData()['data']['data'];
        return $res;
    }

    public function detail($id){
        $res = $this->sendParamsToApi('GET',[],'api.local.com/v1/product/detail/'.$id);
        return $res->getData()['data']['data'];
    }
}
