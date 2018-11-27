<!-- BEGIN LOGO -->
<div class="page-logo">
    {{-- <a href=" {{URL::Route('admin::index')}} ">
        <img src="{{asset('img/all/logo.png')}}" alt="logo" class="logo-default" /> </a> --}}
    <div class="menu-toggler sidebar-toggler">
        <span></span>
    </div>
</div>
<!-- END LOGO -->
<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
    <span></span>
</a>
<!-- USER -->
<div class="top-menu">
    <ul class="nav navbar-nav pull-right">
        <li class="dropdown dropdown-user">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <img alt="" class="img-circle" src="../img/all/user01.jpg" />
                <span class="username username-hide-on-mobile"> <?php if( Auth::user() ){ echo Auth::user()->user_fullname; }else{ echo "???"; } ?> </span>
                <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-default">
                <li>
                    <a href="{{ URL::route('auth::logout') }}">
                        <i class="icon-key"></i> Log Out </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<!-- END USER -->