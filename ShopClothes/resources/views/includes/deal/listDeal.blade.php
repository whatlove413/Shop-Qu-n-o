<div class="col-xs-12 clear-padding">
    <div class="header_home row clear_margin">
        <a href="{{ route('web::index_deal') }}"><h3><img src="{{ asset('img/icon/muanew.png') }}"> MUA BÁN</h3></a>
    </div>
    <div class="tabbable-panel">
        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li class="active">
                    <a href="#tab_deal_1" data-toggle="tab">
                    Tin đã đăng </a>
                    <div class="border-bottom-tab"></div>
                </li>
                <li>
                    <a href="#tab_deal_2" data-toggle="tab">
                    Tin chờ duyệt </a>
                    <div class="border-bottom-tab"></div>
                </li>
                <li>
                    <a href="#tab_deal_3" data-toggle="tab">
                    Tin bị hủy </a>
                    <div class="border-bottom-tab"></div>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_deal_1">
                    @component('components.home.deal', ["data" => $Deal,"list_news" => true])@endcomponent
                </div>
                <div class="tab-pane" id="tab_deal_2">
                </div>
                <div class="tab-pane" id="tab_deal_3">
                </div>
            </div>
        </div>
    </div>
</div>
