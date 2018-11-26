@php
$weightCargoOffer = config("constants.weightCargoOffer");
$cargoOffer = config("constants.cargoOffer");
$images = json_decode($data->deal_images);
@endphp
@extends('layouts.frontendMaster')
@section('content')
@php
$pagination = config("constants.pagination");
@endphp
<div class="home">
    <!-- Đây là menu top trên cùng của trang -->
    @component('components.master.menuTop',["constant" => $constant])
    @endcomponent
    <!-- đây là slider -->
    <div class="row clear_margin slider_home">
        @include('includes.home.slide')
    </div>
    <!-- Button đăng tin -->
    @component('components.master.postNews')@endcomponent
    <div id="postNews_form" class="col-md-12 col-sm-12 col-xs-12 postNews clear-padding">
        @component('components.user.userInformation',["title" => "SỬA THÔNG TIN MUA BÁN"])@endcomponent
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="header_home row clear_margin">
                <h3><img src="{{ asset('img/icon/vanchuyennew.png') }}"> Thông tin mua bán</h3>
            </div>
            <div class="stepwizard col-sm-12 col-xs-12 col-md-12 clear-padding">
                <div class="stepwizard-row setup-panel vehicle_open">
                    <div class="stepwizard-step col-xs-4 col-sm-4 col-md-4 clear-padding">
                        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                        <p>Thông tin mua bán</p>
                    </div>
                    <div class="stepwizard-step col-xs-4 col-sm-4 col-md-4 clear-padding">
                        <a href="#step-2" type="button" class="btn btn-default btn-circle">2</a>
                        <p>Thông tin giao dịch</p>
                    </div>
                    <div class="stepwizard-step col-xs-4 col-sm-4 col-md-4 clear-padding">
                     <a href="#step-3" type="button" class="btn btn-default btn-circle">3</a>
                     <p>Hoàn tất</p>
                 </div>
             </div>
         </div>
         @include('includes.successes')
         <form action="{{ URL::route('web::postEditDeal') }}" method="POST" novalidate="novalidate" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row setup-content clear_margin" id="step-1">
                <div class="col-xs-12 clear-padding">
                    <div class="col-md-12">
                        <h4> THÔNG TIN MUA - BÁN</h4>
                        <div class="col-md-12 form_post">
                            <div class="form-group">
                                <label for="deal_type_of">Loại hình<span class="required"> * </span></label>
                                <div class="form-check radio-pink-gap ">
                                    <input name="deal_type_of" value="mua" type="radio" class="with-gap" id="radio109" {{($data->deal_type_of == "mua") ? "checked" : "" }} >
                                    <label for="radio109">Mua</label>
                                </div>

                                <div class="form-check radio-pink-gap">
                                    <input name="deal_type_of" value="bán" type="radio" class="with-gap" id="radio110" {{($data->deal_type_of == "bán") ? "checked" : "" }} >
                                    <label for="radio110">Bán</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="deal_vehicles">Loại phương tiện<span class="required"> * </span></label>
                                <input type="text" name="deal_vehicles" id="autocomplete" value="{!! $data->deal_vehicles !!}" class="form-control" required>
                                <div id="selection"></div>
                            </div>
                            <div class="form-group">
                                <label for="deal_weight">Tải trọng<span class="required"> * </span></label>
                                <input type="number" name="deal_weight" id="deal_weight" value="{!!$data->deal_weight !!}" class="form-control" title="trọng lượng" placeholder="Nhập trọng lượng">
                            </div>
                            <div class="form-group">
                                <label for="deal_note">Mô tả</label>
                                <span><textarea class="form-control" rows="5" id="deal_note" name="deal_note" placeholder="Thông tin hàng vận chuyển">{!! $data->deal_note !!}</textarea></span>
                            </div>
                            <div class="form-group">
                                <label for="vehicle_open_images">Hình Chi Tiết</label>
                                <div class="row clear_margin" id="preview_images">
                                    @if($images)
                                    @foreach($images as $item)
                                    <div class="col-xs-2 col-sm-2 col-md-2 clear-padding block_preview_images" id="image_preview">
                                        <img id="image_preview" width="100%" src="{{asset('upload/deal/images/small/'.$item)}}" alt="">
                                        <button id="remove_image" type="button">&#10006</button>
                                        <input id="images_name"  name="images[]"  value="{{$item}}" type="hidden">
                                    </div>
                                    @endforeach
                                    @endif
                                    <div class="enterprise-post__avatar col-md-2 clear-padding">
                                        <a href="javascript:void(0)" title="LOGO" rel="nofollow" class="">
                                            <img id="blah" src=""><meta itemprop="image" content="">
                                            <span class="enterprise-post__img-code enterprise-post__center-center"></span>
                                        </a>
                                        <div class="enterprise-post__image-picker enterprise-post__center-center">
                                            <label class="enterprise-post__center-center" for="avatar">
                                                <i class="fa fa-camera"></i>
                                            </label><input type="file" title="LOGO" url="{{URL::route('web::uploadDealImage')}}" id="avatar" name="images[]" multiple>
                                            <input type="hidden" value="">
                                        </div>
                                    </div>
                                </div>

                                @component('components.transport.error', ["name" => "vehicle_open_images"])@endcomponent
                            </div>
                        </div>
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Tiếp tục <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
            <div class="row setup-content clear_margin" id="step-2">
                <div class="col-xs-12 clear-padding">
                    <div class="col-md-12">
                        <h4> THÔNG TIN GIAO DỊCH</h4>
                        <div class="col-md-12 form_post">
                            <div class="form-group">
                                <label for="deal_view_place">Nơi xem<span class="required"> * </span></label>
                                <input type="text" name="deal_view_place" id="noi_nhan" value="{!! $data->deal_view_place !!}" class="form-control" title="Địa chỉ" placeholder="Nhập nơi nhận">
                                <input type="hidden" value="{!! $data->deal_view_place_lat !!}" name="deal_view_place_lat" id="deal_view_place_lat">
                                <input type="hidden" value="{!! $data->deal_view_place_lng !!}" name="deal_view_place_lng" id="deal_view_place_lng">
                                <input type="hidden" value="{!! $data->deal_view_place_place_id !!}" name="deal_view_place_place_id" id="deal_view_place_place_id">
                                @component('components.transport.error', ["name" => "deal_view_place"])@endcomponent
                            </div>
                            <div class="form-group">
                                <label>Giá cả</label>
                                <input id="deal_price" name="deal_price" value="{!! number_format($data->deal_price) !!}" class="form-control" title="Nhập giá" placeholder="Nhập giá" required>
                            </div>
                            <div class="form-group">
                                <label for="deal_contact_fullname">Họ tên người giao dịch<span class="required"> * </span></label>
                                <input type="text" name="deal_contact_fullname" id="deal_contact_fullname" value="{!! $data->deal_contact_fullname !!}" class="form-control" title="Họ Tên">
                                @component('components.transport.error', ["name" => "deal_contact_fullname"])@endcomponent
                            </div>
                            <div class="form-group">
                                <label for="deal_phone">Số Điện Thoại<span class="required"> * </span></label>
                                <input type="text" name="deal_phone" id="deal_phone" value="{!! $data->deal_phone !!}" class="form-control" title="Số Điện Thoại">
                                @component('components.transport.error', ["name" => "deal_phone"])@endcomponent
                            </div>
                        </div>
                        <button class="btn btn-primary nextBtn btn-lg pull-right submit_top" type="button" >Tiếp tục <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
            <div class="row setup-content clear_margin" id="step-3">
                <div class="col-xs-12 clear-padding">
                    <div class="col-md-12">
                        <h4> HOÀN TẤT</h4>
                        <div class="col-md-12 form_post">
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input type="text" name="deal_name" value="{!! $data->deal_name !!}" class="form-control" title="Nhập tiêu đề" placeholder="Nhập tiêu đề">
                            </div>
                        </div>
                        <input type="hidden" name="id_deal" value="{{$data->deal_id}}">
                        <button class="btn btn-primary nextBtn btn-lg pull-right submit_top" type="submit" >Hoàn tất</button>
                    </div>
                </div>
            </div>
        </form>
        @section('javascripts_edit')
        <script type="text/javascript">
            function geolocate_noi_nhan() {
                var lat = noi_nhan.getPlace().geometry.location.lat();
                var lng = noi_nhan.getPlace().geometry.location.lng();
                var place_id_noi_nhan = noi_nhan.getPlace().place_id;
                $('#deal_view_place_lat').val(lat);
                $('#deal_view_place_lng').val(lng);
                $('#deal_view_place_place_id').val(place_id_noi_nhan);
            }
        </script>
        @component('components.master.jquery_autocomplete',["data" => $vehicle])@endcomponent
        @endsection
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <?php echo $constant['quang-cao']->constant_content; ?>
        </div>
    </div>
</div>
</div>
@endsection