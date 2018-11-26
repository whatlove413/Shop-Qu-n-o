@extends('layouts.frontendMaster')
@section('content')
<!-- Đây là menu top trên cùng của trang -->
@component('components.master.menuTop',["muaban" => true,"constant" => $constant])
@endcomponent
@php
$images = json_decode($dealbyid->deal_images);
@endphp
<div class="col-md-12 col-xs-12 clear-padding" style="padding-top: 2%;">
    <?php echo $constant['banner-mua-ban']->constant_content; ?>
</div>
<div class="block_post_news_transport">
    @component('components.master.postNews',["href" => route('web::getDealPost') ])@endcomponent
</div>
<div class="col-sm-6 col-md-6 col-xs-12 package clear-padding transport-custom-left">
    <div class="header_home row clear_margin">
        <a href="{{ route('web::index_deal') }}"><h3><img src="{{ asset('img/icon/vanchuyennew.png') }}"> MUA BÁN</h3></a>
    </div>
    <div class="block_detail">
        <div class="row clear_margin">
            <div class="col-md-6">
                <div class="big_img_detail">
                 @if($images && count($images) > 1)
                 <a data-trigger="gallery" href="javascript:;">
                     <img id="big_img_detail" class="small" src="{{asset('upload/deal/images/large/'.$images[0])}}">
                 </a>
                 @elseif($images && count($images) == 1)
                 <a href=""><img id="big_img_detail" data-fancybox="gallery" class="thumb small" href="{{asset('upload/deal/images/original/'.$images[0])}}" data-thumb="{{asset('upload/deal/images/small/'.$images[0])}}" src="{{asset('upload/deal/images/large/'.$images[0])}}"></a>
                 @else
                 <a href=""><img id="big_img_detail" data-height="1000" data-fancybox="gallery" class="thumb small" href="{{asset('img/avatar/muaban.png')}}" data-thumb="{{asset('img/avatar/muaban.png')}}" src="{{asset('img/avatar/muaban.png')}}"></a>
                 @endif
             </div>
         </div>
         <div class="col-md-6 detail">
            <h4>{{mb_strtoupper($dealbyid->deal_name, 'UTF-8')}}</h4>
            <p class="enterprise-detail__item-info"><img src="{{ asset('img/icon/gps.png') }}">{{ $dealbyid->deal_view_place }}</p>
            <p class="enterprise-detail__item-info"><img src="{{ asset('img/icon/trongluongnew.png') }}">{{ number_format($dealbyid->deal_weight,1) }} tấn</p>
            @if ($dealbyid->deal_price == 0)
            <p class="enterprise-detail__item-info price"><img src="{{ asset('img/icon/gia.png') }}">Giá thỏa thuận</p>
            @else
            <p class="enterprise-detail__item-info price"><img src="{{ asset('img/icon/gia.png') }}">{{number_format($dealbyid->deal_price)}} VNĐ</p>
            @endif
            <!--  <p class="enterprise-detail__item-info hotline"><img src="{{ asset('img/icon/dienthoaido.png') }}"><span>Hotline:</span>{{$dealbyid->deal_phone}}</p> -->
        </div>
    </div>
    <div class="row clear_margin">
        <div id="thumbnail-slider">
            <div class="inner">
                <ul>
                    @if($images && count($images) > 1)
                    @foreach ($images as $item)
                    <li><a data-fancybox="gallery" class="thumb" href="{{asset('upload/deal/images/original/'.$item)}}" data-thumb="{{asset('upload/deal/images/small/'.$item)}}"></a></li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="row clear_margin">
        <div class="row clear_margin">
            <div class="col-xs-12 col-sm-12 col-md-12 deal-note">
                <h4>MÔ TẢ</h4>
                <?php echo $dealbyid->deal_note ;?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h4 class="lienhe-detail">LIÊN HỆ</h4>
                <p>Tên: {{$dealbyid->deal_contact_fullname}}</p>
                <p>Số điện thoại: <a href="tel:{{$dealbyid->deal_phone}}">{{$dealbyid->deal_phone}}</a></p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h4>Chia sẻ</h4>
                <!-- Go to www.addthis.com/dashboard to customize your tools --> 
                <div class="addthis_inline_share_toolbox">
                </div>
                @component('components.auth.badPost',['bad_post_post_id'=>$dealbyid->deal_id,'bad_post_post_object'=>"MUA BÁN"])@endcomponent
            </div>
        </div>
    </div>
</div>
</div>
@component('components.master.map', ["data" => $dealbyid,"exchange" => 5,"detail" => true])
@endcomponent
<div class="col-xs-12 news_relates">
    <h3>TIN LIÊN QUAN</h3>
</div>

<div class="col-md-12 clear-padding enterprise-detail__related-news-card tinlquan-content">
    <div class="col-sm-12 col-md-12 transport detail clear-padding">
        @component('components.home.deal',['data'   =>  $deal,'news_relates' => true])
        @endcomponent

    </div>
</div>
</div>
@endsection