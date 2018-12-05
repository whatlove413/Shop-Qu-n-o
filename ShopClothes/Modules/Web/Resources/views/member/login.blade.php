@extends('layouts.frontendMaster')
@section('content')
<!-- Đây là menu top trên cùng của trang -->
@component('components.master.menuTop',["dangnhap" => true,"constant" => $constant])
@endcomponent
@include('includes.successes')
@include('includes.errors')
<div class="col-md-12 col-sm col-xs-12 clear-padding" style="padding-top: 2%;">
    <?php echo $constant['banner-tai-khoan']->constant_content;?>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 news_transport clear-padding">
    <div class="col-xs-12 col-sm-6 col-md-6 form_news clear-padding form-active">
        <div class="row clear_margin header_form_postnews">
            <p><i class="fa fa-plus-circle"></i> ĐĂNG NHẬP</p>
        </div>
        <form action="{{ URL::route('web::verify') }}" method="post">
            {{ csrf_field() }}
            <div class="row clear_margin" id="step-11">
                <div class="col-xs-12 col-sm-12 col-md-12 clear-padding">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h4> Vui lòng nhập thông tin tài khoản để đăng nhập</h4>
                        <div class="col-xs-12 col-sm-12 col-md-12 form_post">
                            <div class="form-group">
                                <label for="user_email_phone" class="control-label">Số điện thoại hoặc email <span class="required"> * </span></label>
                                <input type="text" id="user_email_phone" name="user_email_phone" class="form-control" value="{{ old('user_email_phone') }}" placeholder="Nhập số điện thoại hoặc email"/>
                            </div>
                            <div class="form-group">
                                <label for="user_password" class="control-label">Password <span class="required"> * </span></label>
                                <input type="password" id="user_password" name="user_password" class="form-control" value="{{ old('user_password') }}" placeholder="Nhập password"/>
                            </div>
                            <div class="form-group login">
                                <div class="col-xs-12 col-sm-12 col-md-12 clear-padding">
                                    <p>Nếu bạn chưa có tài khoản, <a href="{{ URL::route('web::register') }}"><b>đăng ký</b></a> ngay để nhận những ưu đãi tốt nhất.</p>
                                    <a href="{{route('web::forgetPass')}}" class="forget-pass-button"><b>Quên mật khẩu?</b></a>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary nextBtn btn-lg pull-right btnLogin submit_gobottom" type="submit" >Đăng nhập</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 advertisement clear-padding">
        <?php echo $constant['quang-cao']->constant_content; ?>
    </div>
</div>
@section('javascripts')
<script type="text/javascript">
    $('.confirm-forgetpass').click(function(e){
        e.preventDefault();
        var url = $('#url_forget_pass').val();
        var user_name = $('#input_username').val();
        //js validate số điện thoại
        var validate_sdt = /^[0-9-+]+$/;
        //js validate email
        var validate_email = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (validate_sdt.test(user_name)) {
            console.log("sdt");
                        $.ajax({

                url: url,
                method: 'GET',
                dataType: 'json',
                data: { "user_name": user_name },
                success: function (response) {
                    console.log("okie");
                },
                error: function()
                {
                    swal({
                        title: "Có lỗi xảy ra",
                        icon: "error"
                    })
                }
            });
        }
        else if(validate_email.test(user_name)) {
            console.log("email");
            $.ajax({

                url: url,
                method: 'GET',
                dataType: 'json',
                data: { "user_name": user_name },
                success: function (response) {
                    console.log("okie");
                },
                error: function()
                {
                    swal({
                        title: "Có lỗi xảy ra",
                        icon: "error"
                    })
                }
            });
        }
        else{
           swal({
            title: "Thông báo",
            text: "Bạn phải nhập đúng định dạng email hoặc số điện thoại",
            icon: "error",
        })
       }
   });
</script>
@endsection
@endsection