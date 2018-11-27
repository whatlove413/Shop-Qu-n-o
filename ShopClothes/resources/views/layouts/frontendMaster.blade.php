<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" href="{{ asset('img/logo/LogoSharingEconomy.png') }}">
    <title>Web Quần Áo</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="{!! asset('css/master/font-awesome.min.css') !!}" rel="stylesheet" />
    <link href="{!! asset('css/master/bootstrap/dist/css/bootstrap.min.css') !!}" rel="stylesheet" />
    <link href="{!! asset('css/master/frontendMaster.css') !!}" rel="stylesheet" />
    <link href="{!! asset('css/home/home.css') !!}" rel="stylesheet" />
    <link href="{!! asset('css/enterprise/enterprise.css') !!}" rel="stylesheet" />
    <link href="{!! asset('css/admin/user.css') !!}" rel="stylesheet" />
    <link href="{!! asset('css/transport/transport.css') !!}" rel="stylesheet" />
    <link href="{!! asset('css/master/bootstrap-datepicker.min.css') !!}" rel="stylesheet" />
    <link href="{!! asset('css/news/news.css') !!}" rel="stylesheet" />
    <link href="{{ 	url('css/warehouse/warehouse.css') }}" rel="stylesheet" />
    <link href="{!! asset('css/master/thumbnail-slider.css') !!}" rel="stylesheet" />
    <link href="{!! asset('css/fancybox/jquery.fancybox.min.css') !!}" rel="stylesheet" />
    <input id="user_agent" type="hidden">
    <script src="{{asset('js/ckeditor_basic/ckeditor.js')}}"></script>
</head>
<body>
    @include('includes.master.header')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0 5%">
        @yield('content')
    </div>
    @include('includes.master.backtotop')
    @include('includes.master.footer')
    <script src="{!! asset('js/master/sweetalert.min.js') !!}"></script>
    <script src="{!! asset('js/master/jquery.min.js') !!}"></script>
    <script src="{!! asset('js/master/bootstrap.min.js') !!}"></script>
    <script src="{!! asset('js/master/jquery.json.min.js') !!}"></script>
    <script src="{!! asset('js/master/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('js/fancybox/jquery.fancybox.min.js') !!}"></script>
    <script src="{!! asset('js/enterprise/enterprise.js') !!}"></script>
    <script src="{!! asset('js/master/frontendMaster.js') !!}"></script>
    <script src="{!! asset('js/auth/register.js') !!}"></script>
    <script src="{!! asset('js/transport/transport.js') !!}"></script>
    <script src="{!! asset('js/master/thumbnail-slider.js') !!}"></script>
    <script src="{!! asset('js/member/member.js') !!}"></script>
    <script src="{!! asset('js/master/jquery.autocomplete.js') !!}"></script>
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ad16d11ca1c5358"></script>
    @yield('javascripts')
    @yield('js')
    @yield('javascripts_edit')
</body>
</html>