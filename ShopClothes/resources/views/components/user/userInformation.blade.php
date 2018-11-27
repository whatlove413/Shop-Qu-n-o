<div class="col-md-12 header-post-news">
    <h3><i class="fa fa-plus-circle"></i> {{isset($title)? $title : null}}</h3>
</div>
<div class="col-sm-12 col-md-12 block-profile">
    <div class="row clear_margin">
        <div class="col-xs-12 col-sm-2 col-md-2 clear-padding">
            <img src="{{ asset('img/avatar/profile.png') }}">
        </div>
        <div class="col-xs-12 col-sm-10 col-md-10 clear-padding">
            <h2>{{Auth::user()->user_fullname}} <a href="" title="sửa thông tin tài khoản"><a href="{{ route('web::profile') }}"><i class="fa fa-edit"></i></a></a></h2>
            <p><i class="fa fa-user"></i> <a href="{{ route('web::profile') }}">Thông tin tài khoản</a></p>
            <p><i class="fa fa-key"></i> <a href="{{ route('web::resetpassword') }}">Đổi mật khẩu</a></p>
            <p><i class="fa fa-list-alt"></i> <a id="list_news" href="{{ route('web::list_news') }}">Danh sách tin đăng</a></p>
        </div>
    </div>
</div>
@section('javascripts')
<script type="text/javascript">
    $('#list_news').click(function(event) {
        @if(isset($list_news))
        event.preventDefault();
        var list_news_position = $('#list_news_head').offset().top;
        $('html').animate({scrollTop: list_news_position},400);
        @endif
    });
</script>
@endsection