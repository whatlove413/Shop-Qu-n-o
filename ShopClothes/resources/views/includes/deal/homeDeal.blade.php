@if($deal)
<div id="deal_component" class="col-sm-12 col-md-12 col-xs-12 package clear-padding transport-custom-left">
    <div class="header_home row clear_margin">
        <a href="{{ route('web::index_deal') }}"><h3><img src="{{ asset('img/icon/muanew.png') }}"> QUẦN ÁO NỔI BẬT</h3></a>
    </div>
    <div class="tab-content">
        <div id="package_home" class="tab-pane fade in active">
            @component('components.home.deal', ["data" => $deal])
            @endcomponent
            @component('components.home.deal', ["data" => $deal])
            @endcomponent
            @component('components.home.deal', ["data" => $deal])
            @endcomponent
            @component('components.home.deal', ["data" => $deal])
            @endcomponent
            @component('components.home.deal', ["data" => $deal])
            @endcomponent
            @component('components.home.deal', ["data" => $deal])
            @endcomponent
            <a class="xemthem btn btn-outline-info" href="{{ route('web::index_deal') }}">Xem thêm</span></a>
        </div>
    </div>
</div>
@endif