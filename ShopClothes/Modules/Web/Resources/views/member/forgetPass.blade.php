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
  <div class="col-sm-6 col-md-6 form_news clear-padding form-active">
    <div class="row clear_margin header_form_postnews">
      <p><i class="fa fa-plus-circle"></i> QUÊN MẬT KHẨU</p>
    </div>
    @include('includes.successes')
    <form action="{!! URL::route('web::confirmForgetPass') !!}" method="post">
      {{ csrf_field() }}
      <div class="col-xs-12 clear-padding">
        <div class="col-md-12">
          <h4>Hãy nhập Email hoặc SĐT của bạn để nhận mã khôi phục mật khẩu </h4>
          <div class="col-md-12 form_post">
            <div class="form-group">
              <label for="active_code" class="control-label">Email / SĐT </label>
              <input type="text" id="user" name="user" class="form-control" value="{{ old('user') }}" placeholder="Nhập Email / SĐT"/>
            </div>
            <div class="form-group">
              <button class="btn btn-primary nextBtn btn-lg pull-right btnConfirm" type="submit" >Xác nhận</button>
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
@endsection