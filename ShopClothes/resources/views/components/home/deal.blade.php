@foreach ($data as $item)
<?php
$images = json_decode($item->deal_images);
?>
<div class="col-sm-6 col-md-6 col-xs-12">
    <div class="row clear_margin img_home">
        <div class="col-sm-3">
            <a href="{{ route('web::product',$item['product_id']) }}" title="a">
                @if(!$images)
                <img class="news-image-home" src="{{ asset('img/avatar/muaban.png') }}" alt="">
                @else
                <img class="news-image-home" src="{{ asset('upload/deal/images/small/'.$images[0]) }}" alt="">
                @endif
            </a>
        </div>
        <div class="col-sm-8 product-home ">
            <a href="{{ route('web::product',$item['product_id']) }}" title="a">
                <h4>{{mb_strtoupper($item['product_name'],'UTF-8')}}</h4>
                <p>
                    Thương hiệu : {{strlen($item['product_brand_name']) > 0 ? $item['product_brand_name'] : "NO BRAND" }}
            </p>
            <p class="last-p-product">
                <span class="price"><img src="{{ asset('img/icon/gia.png') }}">{{number_format($item['product_price'])}} VNĐ</span>
            </p>
        </a>
    </div>
</div>
</div>
@endforeach
