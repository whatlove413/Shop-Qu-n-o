{{-- @foreach ($data as $item) --}}
<?php
$images = json_decode($item->deal_images);
?>
<div class="col-sm-6 col-md-6 col-xs-12">
    <div class="row clear_margin img_home">
        <div class="col-sm-3">
            <a href="{{ route('web::getDealDetail',1) }}" title="a">
                @if(!$images)
                <img class="news-image-home" src="{{ asset('img/avatar/muaban.png') }}" alt="">
                @else
                <img class="news-image-home" src="{{ asset('upload/deal/images/small/'.$images[0]) }}" alt="">
                @endif
            </a>
        </div>
        <div class="col-sm-8 product-home ">
            <a href="{{ route('web::getDealDetail',1) }}" title="a">
                <h4>{{mb_strtoupper("a",'UTF-8')}}</h4>
                <p><img src="{{ asset('img/icon/clock.png') }}">@php
                $timeleft = time() - 10000;
                if($timeleft<60)
                {
                    echo 'Vừa mới đăng';
                }
                elseif($timeleft<3600)
                {
                    echo round(($timeleft/60))." phút trước";
                }
                elseif($timeleft<86400) {
                    echo round(($timeleft/3600))." giờ trước";
                }
                elseif($timeleft<2592000)
                {
                    echo round(($timeleft/86400))." ngày trước";
                }
                elseif($timeleft<31104000)
                {
                    echo round(($timeleft/2592000))." tháng trước";
                }
                else {
                    echo round(($timeleft/31104000))." năm trước";
                }
                @endphp
            </p>
            <p class="last-p-product">
                <span class="price"><img src="{{ asset('img/icon/gia.png') }}">{{number_format(10000)}} VNĐ</span>
            </p>
        </a>
    </div>
</div>
</div>
{{-- @endforeach --}}
