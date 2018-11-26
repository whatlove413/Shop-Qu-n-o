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
    @include('includes.errors')
    <div class="col-xs-12 col-sm-12 col-md-12 header-list-news postNews clear-padding">
        @component('components.user.userInformation',["title" => "QUẢN LÝ TIN ĐĂNG THÀNH VIÊN","list_news" => true])@endcomponent
        <!-- Phần list tin hàng vận chuyển -->
        <div id="list_news_head" class="col-sm-12 col-md-12 col-xs-12 package">
            @include('includes.transport.listCargoOffer')
        </div>
        <!-- Phần list tin phương tiện vận chuyển -->
        <div id="vehicleOpen_head" class="col-sm-12 col-md-12 col-xs-12 package">
            @include('includes.transport.listVehicleOpen')
        </div>
        <!-- Phần list tin kho -->
        <div id="wareHouse_head" class="col-sm-12 col-md-12 col-xs-12 package">
            @include('includes.warehouse.listWareHouse')
        </div>
        <!-- Phần list tin mua bán -->
        <div id="deal_head" class="col-sm-12 col-md-12 col-xs-12 package">
            @include('includes.deal.listDeal')
        </div>
        <!-- Phần list tin dịch vụ -->
        <div id="service_head" class="col-sm-12 col-md-12 col-xs-12 package">
            @include('includes.service.listService')
        </div>
        <!-- Phần list tin tuyển dụng -->
        <div id="recruitment_head" class="col-sm-12 col-md-12 col-xs-12 package">
            @include('includes.recruitment.listRecruitment')
        </div>
        <!-- Phần list tin doanh nghiệp -->
        <div id="enterprise_head" class="col-sm-12 col-md-12 col-xs-12 package list_enterprise">
            @include('includes.enterprise.listEnterprise')
        </div>
    </div>
</div>
<div class="go-to-exchange">
    <div id="cargoOffer">
        <img title="hàng vận chuyển" src="{{ asset('img/icon/vanchuyennew.png') }}">
    </div>
    <div id="vehicleOpen">
        <img title="phương tiện vận chuyển" src="{{ asset('img/icon/hangvanchuyennew.png') }}">
    </div>
    <div id="wareHouse">
        <img title="kho" src="{{ asset('img/icon/nhanthuekhonew.png') }}">
    </div>
    <div id="deal">
        <img title="mua bán" src="{{ asset('img/icon/muanew.png') }}">
    </div>
    <div id="service">
        <img title="dịch vụ" src="{{ asset('img/icon/logicnew.png') }}">
    </div>
    <div id="recruitment">
        <img title="tuyển dụng" src="{{ asset('img/icon/tuyendung.png') }}">
    </div>
    <div id="enterprise">
        <img title="doanh nghiệp" src="{{ asset('img/icon/DN.png') }}">
    </div>
</div>
@endsection

