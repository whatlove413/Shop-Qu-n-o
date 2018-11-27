<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Admin</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link href="{{ asset('css/all.css') }}" rel="stylesheet" />
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
        <link rel="stylesheet" type="text/css" href="{{asset('css/admin/admin.css')}}">
        <script src="{{asset('js/ckfinder/ckfinder.js')}}"></script>
        <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <!-- *************************************Phần đầu****************************************** -->
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                @include('includes.topBar')
            </div>
        </div>
        <!-- **************************************End đầu****************************************** -->
        <div class="clearfix"> </div>
        <!-- *************************************Phần giữa***************************************** -->
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    @include('includes.leftBar')
                </div>
            </div>
            <div class="page-content-wrapper">
                <div class="page-content" style="min-height:1000px">
                    @include('includes.pageContent')
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- *************************************End giữa****************************************** -->
        <!-- *************************************Phần cuối***************************************** -->
        <div class="page-footer">
            @include('includes.botBar')
        </div>
        <!-- *************************************End cuối****************************************** -->
        <script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
        <script src="{!! asset('js/master/jquery.autocomplete.js') !!}"></script>
        <script src="{{ asset('js/all.js') }}"></script>
        <script src="{{ asset('js/admin/admin.js') }}"></script>
        <script src="{!! asset('js/master/frontendMaster.js') !!}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOsepIKngDmHLHZlUBLn_-0xh3dPFm0gs&libraries=places&callback=initAutocomplete"
        async defer></script>
        @yield('javascripts')

    </body>

</html>