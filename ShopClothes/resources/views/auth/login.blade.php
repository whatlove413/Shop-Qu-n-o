<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Adminitrastion</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link href="{{asset('css/all.css')}}" rel="stylesheet">
    </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <!-- <img src="../assets/pages/img/logo-big.png" alt="" />  -->
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            @include("includes.errors")
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="{{ URL::route('auth::verify') }}" method="post">
                {{ csrf_field() }}
                <h3 class="form-title font-green">Đăng nhập</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Hãy nhập tài khoản và mật khẩu </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Tài khoản</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Tên đăng nhập" name="username" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Mật khẩu</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Mật khẩu" name="password" /> </div>
                <div class="form-group">
                    <button type="submit" class="btn green uppercase">Đăng nhập</button>
                    <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />Duy trì đăng nhập
                        <span></span>
                    </label>
                </div>
            </form>
            <!-- END LOGIN FORM -->

        </div>
        <div class="copyright"> 2018 © Sharing Economy  </div>
        <script src="{{asset('/js/all.js')}}"></script>
    </body>

</html>