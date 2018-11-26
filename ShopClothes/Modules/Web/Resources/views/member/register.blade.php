@extends('layouts.frontendMaster')
@section('content')
<!-- Đây là menu top trên cùng của trang -->
@component('components.master.menuTop',["dangky" => true,"constant" => $constant])
@endcomponent
@include('includes.successes')
@include('includes.errors')
<div class="col-md-12 col-xs-12 col-sm-12 clear-padding" style="padding-top: 2%;">
    <?php echo $constant['banner-tai-khoan']->constant_content; ?>
</div>
<div class="col-xs-12 news_transport clear-padding">
    <div class="col-xs-12 col-sm-6 col-md-6 form_news form-active register-form clear-padding">
        <div class="row clear_margin header_form_postnews">
            <p><i class="fa fa-plus-circle"></i> ĐĂNG KÝ THÀNH VIÊN</p>
        </div>
        <form action="{!! URL::route('web::postRegister') !!}" method="post">
            {{ csrf_field() }}
            <div class="row clear_margin" id="step-11">
                <div class="col-xs-12 col-sm-12 col-md-12 clear-padding">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h4> Vui lòng nhập thông tin đăng ký </h4>
                        <div class="col-xs-12 col-sm-12 col-md-12 form_post">
                            <div class="form-group">
                                <label for="user_fullname" class="control-label">Nhập tên họ tên cá nhân hoặc tên công ty <span class="required"> * </span></label>
                                <input type="text" id="user_fullname" name="user_fullname" class="form-control" value="{{ old('user_fullname') }}" placeholder="Nhập họ tên đầy đủ"/>
                            </div>
                            <div class="form-group">
                                <label for="user_email_phone" class="control-label">Số điện thoại/email <span class="required"> * </span></label>
                                <input type="text" id="user_email_phone" name="user_email_phone" class="form-control" value="{{ old('user_email_phone') }}" placeholder="Nhập số điện thoại hoặc email"/>
                            </div>
                            <div class="form-group">
                                <label for="user_password" class="control-label">Mật khẩu <span class="required"> * </span></label>
                                <input type="password" id="user_password" name="user_password" class="form-control" placeholder="Nhập mật khẩu tối thiểu từ  6 ký tự trở lên"/>
                            </div>
                            <div class="form-group">
                                <label for="user_password" class="control-label">Nhập lại mật khẩu <span class="required"> * </span></label>
                                <input type="password" id="user_password_confirm" name="user_password_confirm" class="form-control" placeholder="Nhập lại mật khẩu tối thiểu từ 6 ký tự trở lên"/>
                            </div>
                            <div class="form-group register">
                                <input type="checkbox" id="check_requestment" name="check_requestment" value="0">
                                <span> Tôi đồng ý với các @component('components.auth.requirement',["constant" => $constant])@endcomponent trên <a href="http://demo.sharingeconomy.vn">sharingeconomy.vn</a>
                                </span>
                                <div class="col-xs-12 col-sm-12 col-md-12 clear-padding">Nếu bạn đã có tài khoản. <a href="{{ URL::route('web::index_member') }}">Đăng nhập</a> ngay để đăng tin miễn phí.</div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary nextBtn btn-lg pull-right btnRegister" type="submit" >Đăng ký</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 advertisement clear-padding">
        <?php echo $constant['quang-cao']->constant_content ;?>
    </div>
</div>
@endsection