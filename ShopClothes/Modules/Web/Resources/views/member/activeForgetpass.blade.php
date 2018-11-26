@extends('layouts.frontendMaster')
@section('content')
<!-- Đây là menu top trên cùng của trang -->
@component('components.master.menuTop',["kichhoat" => true,"constant" => $constant])
@endcomponent
@include('includes.successes')
@include('includes.errors')
@if(!isset($user))
header('Location: ../');
exit();
@endif
<div class="col-md-12 col-xs-12 clear-padding" style="padding-top: 2%;">
  <?php echo $constant['banner-tai-khoan']->constant_content; ?>
</div>
<div class="col-xs-12 news_transport clear-padding">
  <div class="col-sm-6 col-md-6 form_news clear-padding">
    <div class="row clear_margin header_form_postnews">
      <p><i class="fa fa-plus-circle"></i> QUÊN MẬT KHẨU</p>
    </div>
    @include('includes.successes')
    <form id="confirm_form" action="{!! URL::route('web::activeForgetPass') !!}" method="post">
      {{ csrf_field() }}
      <div class="row clear_margin" id="step-11">
        <div class="col-xs-12 clear-padding">
          <div class="col-md-12">
            <h4>Hệ thống đã gửi Email / SMS vào Email / điện thoại của bạn mã xác nhận.<br/>
            Vui lòng kiểm tra email/ SMS để nhập mã xác nhận và tiến hành đổi mật khẩu </h4>
            <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar">Gửi mã kích hoạt</div>
            </div>
            <div class="col-md-12 form_post">
              <div class="form-group">
                <label for="active_code" class="control-label">Nhập mã xác nhận </label>
                <input type="text" id="confirm_code" name="confirm_code" class="form-control" value="{{ old('confirm_code') }}" placeholder="Nhập mã kích hoạt"/>
                <input type="hidden" id="user" name="user" class="form-control" value="{{$user}}" placeholder="Nhập mã kích hoạt"/>                  
                <input type="hidden" id="url_generate_code" value="{{ route('web::resendConfirmCode') }}">
              </div>
              <div class="form-group active-account">
                <a id="generate_code" href="">Gửi lại mã</a> (xin đợi ít phút trước khi yêu cầu mã khác)
              </div>
              <div class="form-group">
                <button class="btn btn-primary nextBtn btn-lg pull-right btnConfirm" type="submit" >Xác nhận</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="col-sm-6 col-md-6 advertisement clear-padding">
    <?php echo $constant['quang-cao']->constant_content; ?>
  </div>
</div>
@section('javascripts')
<script type="text/javascript">
  $('#generate_code').click(function(e) {
   e.preventDefault();
   var url_generate_code = $('#url_generate_code').val();
   var user = $('#user').val();
   swal("Gửi lại mã thành công!", {
     icon: "success",
   });
   $.ajax({
     url: url_generate_code,
     method: 'get',
     data: { "user": user },
     success:function(data){
     },
     error: function(data){
       swal("Gửi lại mã thất bại!", {
        icon: "error",
      });
     }
   });
 });

  $('#confirm_code').on("keypress",function(e){
    if(e.keyCode() == 13)
    {
      e.preventDefault();
      $('.btnConfirm').click();
    }
  })

  $('.btnConfirm').on('click',function(e){
    e.preventDefault();
    var code = $("#confirm_code").val();
    var url = "{{route('web::check_confirm_code')}}";
    var user = '{{$user}}';
    $.ajax({
      url: url,
      method: 'get',
      data: {"user":user , "code":code},
      success:function(response){
        if(response.STATUS == "OK")
        {
          $('#confirm_form').submit();
        }
        else
        {
          swal("Mã xác nhận không chính xác", {icon: "error"})
        }
      },
    });
  })
</script>
@endsection
@endsection