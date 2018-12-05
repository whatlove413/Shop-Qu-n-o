<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clear-padding header">
	<div class="navbar navbar-default">
		<ul class="nav navbar-nav">
			@if(Auth::user())
			<li><a href="" title="Tài khoản"><b>{{Auth::user()->user_fullname}}</b></a></li>
			<li><a href="{{ route('web::logout') }}" title="Đăng xuất">Đăng xuất</a></li>
			@else
			<li><a href="{{ route('web::index_member') }}" title="Đăng nhập">Đăng nhập</a></li>
			<li><a href="{{ route('web::register') }}" title="Đăng ký">Đăng ký</a></li>
			@endif
			<li><a href="#">Tiếng Việt</a></li>
		</ul>
	</div>
</div>