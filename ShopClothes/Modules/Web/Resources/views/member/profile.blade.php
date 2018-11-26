<!-- Đây là menu top trên cùng của trang -->
@extends('layouts.frontendMaster')
@section('content')
@php
$pagination = config("constants.pagination");
@endphp
@include('includes.successes')
@include('includes.errors')
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
    <div id="postNews_form" class="col-xs-12 col-sm-12 col-md-12 header-list-news postNews postProfile clear-padding">
        @component('components.user.userInformation',["title" => "XEM THÔNG TIN TÀI KHOẢN"])@endcomponent
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="header_home row clear_margin">
                <h3><i class="fa fa-user"></i> Thông tin tài khoản</h3>
            </div>
            <form action="{{ URL::route('web::editprofile') }}" method="post">
                {{ csrf_field() }}
                <div class="col-md-12 form_post">
                    <div class="form-group">
                        <label for="user_fullname" class="control-label">Họ tên</label>
                        <input type="text" id="user_fullname" name="user_fullname" class="form-control" value="{{ $memberInfo->user_fullname }}" readonly/>
                    </div>
                    <div class="form-group">
                        <label for="user_mobile_phone" class="control-label">Số điện thoại</label>
                        @if($memberInfo->user_mobile_phone)
                        <input type="number" id="user_mobile_phone" name="user_mobile_phone" class="form-control" value="{{ $memberInfo->user_mobile_phone }}" readonly/>
                        @else
                        <input type="number" id="user_mobile_phone" name="user_mobile_phone" class="form-control" readonly/>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="user_email" class="control-label">Email</label>
                        @if($memberInfo->user_email)
                        <input type="email" id="user_email" name="user_email" class="form-control" value="{{ $memberInfo->user_email }}" readonly/>
                        @else
                        <input type="email" id="user_email" name="user_email" class="form-control" readonly/>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="user_skype" class="control-label">Skype</label>
                        @if($memberInfo->user_skype)
                        <input type="text" id="user_skype" name="user_skype" class="form-control" value="{{ $memberInfo->user_skype }}" readonly/>
                        @else
                        <input type="text" id="user_skype" name="user_skype" class="form-control" readonly/>
                        @endif
                    </div>
                    <div class="form-group profile">
                        <div class="col-md-8 clear-padding">Bổ sung thông tin tài khoản để khôi phục khi bạn quên email/số điện thoại hoặc passowrd. </div>
                        <div class="col-md-4 clear-padding"><a class="pull-left" href="{{ URL::route('web::resetpassword') }}">Thay đổi mật khẩu</a></div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary nextBtn btn-lg pull-right btnProfile" type="submit" >Chỉnh sửa</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="col-xs-12 col-sm-12 col-md-12 clear-padding">
                <?php echo $constant['quang-cao']->constant_content; ?>
            </div>
        </div>
    </div>
</div>
</div>
@endsection