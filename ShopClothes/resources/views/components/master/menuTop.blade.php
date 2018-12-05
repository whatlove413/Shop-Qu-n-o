<div class="row clear_margin">
    <div class="col-xs-3 col-sm-3 col-md-3 block_logo">
        <a href="{{ route('web::index') }}">
            <img class="logo" src="{{ asset('img/logo/logo.jpg') }}">
            <h3 class="logo_word">Web Quần Áo</h3>
        </a>
    </div>
    <div class="col-xs-9 col-sm-9 col-md-9 clear-padding">
        <div class="row clear_margin pull-right">
            <div class="col-xs-12 col-sm-12 col-md-12 clear-padding">
                <div class="col-xs-12 col-sm-12 col-md-12 clear_margin sdt_tuvan clear-padding">
                    <h3>Q.Đại - 094.941.7778</h3>
                </div>
            </div>
        </div>
        <div class="row clear_margin nav_block">
            <div class="topnav" id="myTopnav">
                <div href="#home" class="{{isset($trangchu) ? "border-bottom-black" : null}} triangle-bottomright"></div>
                <a class="{{isset($trangchu) ? "menu_active" : null}} homepage_nav" href="{{ route('web::index') }}">TRANG CHỦ</a>
                @foreach($category as $cate)

                @php
                    $id = $cate['category_id'];
                @endphp
                <a class="{{isset($trangchu) ? "menu_active" : null}} homepage_nav" href="{{ route('web::category',['category_id' => $id]) }}">{{$cate['category_name']}}</a>
                @endforeach
                <a href="javascript:void(0);" class="icon_nav_responsive" onclick="myFunction()">&#9776;</a>
            </div>
        </div>
    </div>
</div>
