@extends('layouts.frontendMaster')
@section('content')
<!-- Đây là menu top trên cùng của trang -->
@component('components.master.menuTop',["constant" => $constant])
@endcomponent
<div class="col-md-12 col-xs-12 clear-padding" style="padding-top: 2%;">
    <img class="banner_responsive clear-padding col-md-12 col-xs-12" src="/img/banner/Huongdandangtin_full.png" style="height:140px"/>
</div>
<div class="block_post_news_transport">
    @component('components.master.postNews',["href" => route('web::getDealPost') ])@endcomponent
</div>
<div class="clear-padding guide col-xs-12 col-sm-12 col-md-12">
    <div class="col-xs-12 col-sm-12 col-md-12 clear-padding guide-register">
        <h4 class="text-left">ĐĂNG KÝ TÀI KHOẢN</h4>
        <div class="block-guide-15">
            <p>Bước 1</p>
            <img src="{{ asset('img/Huongdandangtin/guide1.png') }}">
            <p>Chọn đăng tin miễn phí</p>
        </div>
        <div class="block-guide-5">
            <img class="guide-arrow" src="/img/Huongdandangtin/iconnext.png">
        </div>
        <div class="block-guide-15">
            <p>Bước 2</p>
            <img src="{{ asset('img/Huongdandangtin/guide2.png') }}">
            <p>Nếu có tài khoản chọn đăng nhập nếu chưa bạn chọn đăng ký</p>
        </div>
        <div class="block-guide-5">
            <img class="guide-arrow" src="/img/Huongdandangtin/iconnext.png">
        </div>
        <div class="block-guide-15">
            <p>Bước 3</p>
            <img src="{{ asset('img/Huongdandangtin/guide3.png') }}">
            <p>Điền thông tin đăng ký</p>
        </div>
        <div class="block-guide-5">
            <img class="guide-arrow" src="/img/Huongdandangtin/iconnext.png">
        </div>
        <div class="block-guide-15">
            <p>Bước 4</p>
            <img src="{{ asset('img/Huongdandangtin/guide4.png') }}">
            <p>Nhập mã xác nhận</p>
        </div>
        <div class="block-guide-5">
            <img class="guide-arrow" src="/img/Huongdandangtin/iconnext.png">
        </div>
        <div class="block-guide-15">
            <p>Bước 5</p>
            <img src="{{ asset('img/Huongdandangtin/guide5.png') }}">
            <p>Bắt đầu đăng tin</p>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 clear-padding guide-register">
        <h4 class="text-left">ĐĂNG TIN</h4>
        <div class="block-guide-15">
            <p>Bước 1</p>
            <img src="{{ asset('img/Huongdandangtin/guide6.png') }}">
            <p>Chọn đăng tin miễn phí</p>
        </div>
        <div class="block-guide-5">
            <img class="guide-arrow" src="/img/Huongdandangtin/iconnext.png">
        </div>
        <div class="block-guide-15">
            <p>Bước 2</p>
            <img src="{{ asset('img/Huongdandangtin/guide7.png') }}">
            <p>Chọn mục cần đăng</p>
        </div>
        <div class="block-guide-5">
            <img class="guide-arrow" src="/img/Huongdandangtin/iconnext.png">
        </div>
        <div class="block-guide-15">
            <p>Bước 3</p>
            <img src="{{ asset('img/Huongdandangtin/guide8.png') }}">
            <p>Nhập thông tin đăng</p>
        </div>
        <div class="block-guide-5">
            <img class="guide-arrow" src="/img/Huongdandangtin/iconnext.png">
        </div>
        <div class="block-guide-15">
            <p>Bước 4</p>
            <img src="{{ asset('img/Huongdandangtin/guide9.png') }}">
            <p>Nhập thông tin giao dịch</p>
        </div>
        <div class="block-guide-5">
            <img class="guide-arrow" src="/img/Huongdandangtin/iconnext.png">
        </div>
        <div class="block-guide-15">
            <p>Bước 5</p>
            <img src="{{ asset('img/Huongdandangtin/guide10.png') }}">
            <p>Đăng tin thành công</p>
        </div>
    </div>
    
</div>
@endsection