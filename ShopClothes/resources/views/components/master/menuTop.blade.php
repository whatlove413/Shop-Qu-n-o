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
                <a class="{{isset($vanchuyen) ? "menu_active" : null}}" href="">VẬN CHUYỂN</a>
                <a class="{{isset($kho) ? "menu_active" : null}}" href="">KHO</a>
                <a class="{{isset($muaban) ? "menu_active" : null}}" href="{{ route('web::index_deal') }}">MUA BÁN</a>
                <a class="{{isset($dichvu) ? "menu_active" : null}}" href="">DỊCH VỤ</a>
                <a class="{{isset($tuyendung) ? "menu_active" : null}}" href="">TUYỂN DỤNG</a>
                <a class="{{isset($doanhnghiep) ? "menu_active" : null}}" href="">DOANH NGHIỆP</a>
                <a href="javascript:void(0);" class="icon_nav_responsive" onclick="myFunction()">&#9776;</a>
                <form action="{{ URL::route('web::getSearchAll') }}" method="get">
                    <input title="nhập từ khóa để tìm kiếm" type="text" name="search_all" id="search_all" class="form-control search_all" placeholder="Tìm"><button><i title="tìm kiếm" id="button_searchall" class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
