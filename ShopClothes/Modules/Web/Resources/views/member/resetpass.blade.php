<!-- Đây là menu top trên cùng của trang -->
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
    <div class="col-xs-12 col-sm-12 col-md-12 header-list-news postNews clear-padding">
        @component('components.user.userInformation',["title" => "THAY ĐỔI MẬT KHẨU"])@endcomponent
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="header_home row clear_margin">
                <h3><i class="fa fa-user"></i> Thông tin tài khoản</h3>
            </div>
            @include('includes.errors')
            <form action="{{ URL::route('web::editResetpassword') }}" method="post">
                {{ csrf_field() }}
                <div class="col-md-12 form_post">
                    <div class="form-group">
                        <label for="old_pass" class="control-label">Mật khẩu hiện tại</label>
                        <input type="password" id="old_pass" name="old_pass" class="form-control" placeholder="Nhập mật khẩu hiện tại" value="{{ old('old_pass') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="new_pass" class="control-label">Mật khẩu mới</label>
                        <input type="password" id="new_pass" name="new_pass" class="form-control" placeholder="Nhập mật khẩu mới" value="{{ old('new_pass') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="confirm_new_pass" class="control-label">Nhập lại mật khẩu mới</label>
                        <input type="password" id="confirm_new_pass" name="confirm_new_pass" class="form-control" placeholder="Nhập lại mật khẩu mới" value="{{ old('confirm_new_pass') }}"/>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary nextBtn btn-lg pull-right btnResetPass" type="submit" >Đổi mật khẩu</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6 col-sm-5 col-xs-12">
            <div class="col-xs-12 col-sm-12 col-md-12 clear-padding">
                <?php echo $constant['quang-cao']->constant_content; ?>
            </div>
        </div>
    </div>
</div>
</div>
@endsection