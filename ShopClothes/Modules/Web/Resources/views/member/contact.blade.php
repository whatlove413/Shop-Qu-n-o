@extends('layouts.frontendMaster')
@section('content')
<!-- Đây là menu top trên cùng của trang -->
@component('components.master.menuTop',["vanchuyen" => true,"constant" => $constant])
@endcomponent
<div class="col-md-12 col-xs-12 clear-padding" style="padding-top: 2%;">
    <?php echo $constant['banner-hang-van-chuyen']->constant_content; ?>
</div>
<div class="block_post_news_transport">
    @component('components.master.postNews')@endcomponent
</div>
<div class="col-xs-12 col-sm-12 col-md-12 news_transport clear-padding">
    @include('includes.successes')
    <div class="col-xs-12 col-sm-6 col-md-6 form_news clear-padding">
        <div class="row clear_margin header_form_postnews">
            <p><i class="fa fa-plus-circle"></i> LIÊN HỆ</p>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 feedback_block_info">
            <p>CÔNG TY CỔ PHẦN SHARINGECONOMY</p>
            <p>Nhà số 10, đường 18A, Khu dân cư Bình Hưng, xã Bình Hưng, huyện Bình Chánh, TP.HCM</p>
            <p>Điện thoại: <a href="tel:0906943250">0906943250</a></p>
            <p>Email: <a href="mailto:info@sharingeconomy.vn">info@sharingeconomy.vn</a></p>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 clear-padding form_feedback">
        <form action="{{ URL::route('web::contactPost') }}" method="POST" novalidate="novalidate" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row setup-content clear_margin">
                <div class="col-xs-12 col-sm-12 col-md-12 clear-padding">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h4> THÔNG TIN LIÊN HỆ</h4>
                        <div class="col-md-12 form_post">
                            <div class="form-group">
                                <label class="control-label">Tiêu đề <span class="required"> * </span></label>
                                <input type="text" name="contact_title" value="{!! old('contact_title') !!}" class="form-control" title="Tiêu đề" placeholder="Nhập tiêu đề">
                                @component('components.transport.error', ["name" => "contact_title"])@endcomponent
                            </div>
                            <div class="form-group">
                                <label class="control-label">Họ và tên <span class="required"> * </span></label>
                                <input type="text" name="contact_name" value="{!! old('contact_name') !!}" class="form-control" title="Họ tên" placeholder="Nhập họ tên">
                                @component('components.transport.error', ["name" => "contact_name"])@endcomponent
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email <span class="required"> * </span></label>
                                <input type="email" name="contact_email" value="{!! old('contact_email') !!}" class="form-control" title="Email" placeholder="Nhập email">
                                @component('components.transport.error', ["name" => "contact_email"])@endcomponent
                            </div>
                            <div class="form-group">
                                <label class="control-label">Số điện thoại <span class="required"> * </span></label>
                                <input type="text" name="contact_phone" value="{!! old('contact_phone') !!}" class="form-control" title="Số điện thoại" placeholder="Nhập số điện thoại">
                                @component('components.transport.error', ["name" => "contact_phone"])@endcomponent
                            </div>
                            <div class="form-group">
                                <label for="contact_content">Nội dung</label>
                                <span><textarea class="form-control" rows="5" name="contact_content" placeholder="Nhập nội dung">{!! old('contact_content') !!}</textarea></span>
                                @component('components.transport.error', ["name" => "contact_content"])@endcomponent
                            </div>
                            <input type="hidden" name="contact_type" value="LIENHE">
                        </div>
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="submit"> Gửi</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
<div class="col-xs-12 col-sm-6 col-md-6 advertisement clear-padding">
    <?php echo $constant['quang-cao']->constant_content; ?>
</div>
</div>
@endsection