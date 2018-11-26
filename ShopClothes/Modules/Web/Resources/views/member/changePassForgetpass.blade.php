@extends('layouts.frontendMaster')
@section('content')
<!-- Đây là menu top trên cùng của trang -->
@component('components.master.menuTop',["kichhoat" => true,"constant" => $constant])
@endcomponent
@include('includes.successes')
@include('includes.errors')
<div class="col-md-12 col-xs-12 clear-padding" style="padding-top: 2%;">
  <?php echo $constant['banner-tai-khoan']->constant_content; ?>
</div>
<div class="col-xs-12 news_transport clear-padding">
  <div class="col-sm-6 col-md-6 form_news clear-padding">
    <div class="row clear_margin header_form_postnews">
      <p><i class="fa fa-plus-circle"></i> QUÊN MẬT KHẨU</p>
    </div>
    @include('includes.successes')
    <form id="change_pass_form" action="{!! URL::route('web::newPass') !!}" method="post">
      {{ csrf_field() }}
      <div class="row clear_margin" id="step-11">
        <div class="col-xs-12 clear-padding">
          <div class="col-md-12">
            <h4>Bạn đã xác nhận mã thành công. Vui lòng điền mật khẩu mới để hoàn tất tính năng quên mật khẩu </h4>
            <div class="col-md-12 form_post">
              <div class="form-group">
                <label for="active_code" class="control-label">Mật khẩu mới </label>
                <input type="password" id="password" name="password" class="form-control"  placeholder="Nhập mật khẩu mới"/>
                <input type="hidden" id="user" name="user" value="">
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
      $('#password').on('keyup',function(e){
        if(e.keyCode == 13)
        {
          e.preventDefault();
          $('#user').val({{$user->user_id}});
          $('#change_pass_form').submit();
        }
      })
      $('#change_pass_form').one('submit',function(e){
        e.preventDefault();
        $('#user').val({{$user->user_id}});
        $(this).submit;
      })
  </script>
@endsection
@endsection