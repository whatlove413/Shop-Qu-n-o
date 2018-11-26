@extends('layouts.frontendMaster')
@section('content')
<!-- Đây là menu top trên cùng của trang -->
@component('components.master.menuTop',["kichhoat" => true,"constant" => $constant])
@endcomponent
@include('includes.successes')
@include('includes.errors')
<div class="col-md-12 col-xs-12 col-sm-12 clear-padding" style="padding-top: 2%;">
  <?php echo $constant['banner-tai-khoan']->constant_content; ?>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 news_transport clear-padding">
  <div class="col-sm-6 col-md-6 form_news clear-padding form-active">
    <div class="row clear_margin header_form_postnews">
      <p><i class="fa fa-plus-circle"></i> KÍCH HOẠT TÀI KHOẢN</p>
    </div>
    @include('includes.successes')
    <form action="{!! URL::route('web::active') !!}" method="post">
      {{ csrf_field() }}
      <div class="row clear_margin" id="step-11">
        <div class="col-xs-12 col-sm-12 col-md-12 clear-padding">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <h4>Hệ thống đã gửi Email / SMS vào Email / điện thoại của bạn mã kích hoạt.<br/>
            Vui lòng kiểm tra email/ SMS để nhập mã kích hoạt và xác nhận hoàn tất đăng ký thành viên </h4>
            <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar">Gửi mã kích hoạt</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 form_post">
              <div class="form-group">
                <label for="active_code" class="control-label">Nhập mã kích hoạt </label>
                <input type="text" id="active_code" name="active_code" class="form-control" value="{{ old('active_code') }}" placeholder="Nhập mã kích hoạt"/>
                <input type="hidden" id="id_user" name="id_user" value="{{$response}}">
                <input type="hidden" id="url_generate_code" value="{{ route('web::generate_code') }}">
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
   var id_user = {{Auth::user()->user_id}}
   swal("Gửi lại mã thành công!", {
   icon: "success",
  });
   $.ajax({
     url: url_generate_code,
     method: 'get',
     data: { "id_user": id_user },
     success:function(data){
     },
     error: function(data){
       swal("Gửi lại mã thất bại!", {
        icon: "error",
      });
     }
   });
 });
</script>
@endsection
@endsection