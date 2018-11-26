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
    @include('includes.successes')
    <div class="col-xs-12 col-sm-12 col-md-12 clear-padding header-searchAll">
        <h3>Kết quả tìm kiếm cho '{{$keyword}}': </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 postNews postSearchAll clear-padding">
        <div class="col-xs-12 col-sm-12 col-md-12 header-post-news">
            <h3><i class="fa fa-plus-circle"></i> Tìm kiếm nâng cao</h3>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 form-search-all-detail">
            <form action="{{URL::route('web::advancedSearch')}}" method="GET">
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-form-label">Từ khóa:</label>
                    <div class="col-xs-12 col-sm-10 col-md-12 clear-padding">
                        <input type="text" class="form-control" name="keyword" value="{{$keyword}}">
                        <button><i class="fa fa-search"> <span>tìm kiếm</span></i></button>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-form-label">Danh mục:</label>
                    <div class="col-xs-12 col-sm-2 col-md-2 block-category_checkbox">
                        <i class="fa fa-check"></i>
                        <input id="cargo_checkbox" class="category_checkbox" type="checkbox" name="cargo_checkbox" {{($product_check != null) ? "checked" : ""}} >
                        <i class="fa fa-times"></i>
                        <span>Hàng vận chuyển</span>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 block-category_checkbox">
                        <i class="fa fa-check"></i>
                        <input id="vehicle_checkbox" class="category_checkbox" type="checkbox" name="vehicle_checkbox" {{($vehicle_check != null) ? "checked" : ""}} >
                        <i class="fa fa-times"></i>
                        <span>Phương tiện</span>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 block-category_checkbox">
                        <i class="fa fa-check"></i>
                        <input id="warehouse_for_checkbox" class="category_checkbox" type="checkbox" name="warehouse_for_checkbox" {{($for_check != null) ? "checked" : ""}}>
                        <i class="fa fa-times"></i>
                        <span>Cho thuê kho</span>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 block-category_checkbox">
                        <i class="fa fa-check"></i>
                        <input id="warehouse_need_checkbox" class="category_checkbox" type="checkbox" name="warehouse_need_checkbox" {{($need_check != null) ? "checked" : ""}}>
                        <i class="fa fa-times"></i>
                        <span>Cần thuê kho</span>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 block-category_checkbox">
                        <i class="fa fa-check"></i>
                        <input id="deal_checkbox" class="category_checkbox" type="checkbox" name="deal_checkbox" {{($deal_check !=null) ? "checked" : ""}}>
                        <i class="fa fa-times"></i>
                        <span>Mua bán</span>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 block-category_checkbox">
                        <i class="fa fa-check"></i>
                        <input id="service_checkbox" class="category_checkbox" type="checkbox" name="service_checkbox" {{($service_check != null) ? "checked" : ""}}>
                        <i class="fa fa-times"></i>
                        <span>Dịch vụ</span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="clear-padding transport row clear_margin">
                @include('includes.transport.homeTransport')
            </div>

            <div class="clear-padding transport row clear_margin top-5">
                @include('includes.home.warehouse')
            </div>
            <div class="clear-padding transport row block_service clear_margin top-5">
                @include('includes.deal.homeDeal')
                @include('includes.service.homeService')
            </div>
        </div>
    </div>
</div>
@section('js')
<script type="text/javascript">


</script>
@endsection
@endsection

