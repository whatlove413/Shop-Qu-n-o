<ul class="page-sidebar-menu  page-header-fixed  " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
    <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
            <span></span>
        </div>
    </li>
    <li id="leftBarParent" class="nav-item text-center">
        <a href="{{ URL::route('admin::index') }}" class="nav-link nav-toggle">
            <img src="{{asset('img/logo/LogoSharingEconomy.png')}}">
            <div class="company-title">Sharing Economy</div>
            <hr/>
        </a>
    </li>
    <li class="sidebar-search-wrapper">
        <form class="sidebar-search  sidebar-search-bordered" action="page_general_search_3.html" method="POST">
            <a href="javascript:;" class="remove">
                <i class="icon-close"></i>
            </a>
            <div class="input-group hidden">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <a href="javascript:;" class="btn submit">
                        <i class="icon-magnifier"></i>
                    </a>
                </span>
            </div>
        </form>
    </li>
    <li class="heading">
        <h3 class="uppercase">Admins</h3>
    </li>
    @component('components.groupItemLeftBar', [
        "name"          => "Tài khoản",
        "faIcon"        => "fa-user",
        "child"         => [
            [
                "isCurrent"         => Request::url() == route('admin::getUserList'),
                "link"              => route('admin::getUserList'),
                "name"              => "Người dùng", 
            ],
            [
                "isCurrent"         => Request::url() == route('admin::getEnterpriseList'),
                "link"              => route('admin::getEnterpriseList'),
                "name"              => "Doanh nghiệp",  
            ],
            [
                "isCurrent"         => Request::url() == route('admin::enterpriseCategory'),
                "link"              => route('admin::enterpriseCategory'),
                "name"              => "Danh mục doanh nghiệp",  
            ],
        ]
    ])
    @endcomponent
    @component('components.itemLeftBar', [
        "name"          => "SMS",
        "faIcon"        => "fa-user",
        "isCurrent"         => Request::url() == route('admin::getSMSList'),
        "link"              => route('admin::getSMSList'),
    ])
    @endcomponent  
    @component('components.itemLeftBar', [
        "name"          => "SEO",
        "faIcon"        => "fa-user",
        "isCurrent"         => Request::url() == route('admin::getSeoList'),
        "link"              => route('admin::getSeoList'),
    ])
    @endcomponent

    @component('components.itemLeftBar', [
        "name"          => "Góp Ý - Liên Hệ",
        "faIcon"        => "fa-user",
        "isCurrent"         => Request::url() == route('admin::contactList'),
        "link"              => route('admin::contactList'),
    ])
    @endcomponent
    @component('components.itemLeftBar', [
        "name"          => "Danh sách báo cáo",
        "faIcon"        => "fa-user",
        "isCurrent"         => Request::url() == route('admin::badPostList'),
        "link"              => route('admin::badPostList'),
    ])
    @endcomponent
    <li class="heading">
        <h3 class="uppercase">Quản trị dữ liệu</h3>
    </li>
    @component('components.groupItemLeftBar', [
        "name"          => "Tin tức",
        "faIcon"        => "fa-user",
        "child"         => [
            [
                "isCurrent"         => Request::url() == route('admin::getListNews'),
                "link"              => route('admin::getListNews'),
                "name"              => "Danh sách tin tức", 
            ],
            [
                "isCurrent"         => Request::url() == route('admin::getNewsCategory'),
                "link"              => route('admin::getNewsCategory'),
                "name"              => "Danh mục tin tức", 
            ]
        ]
    ])
    @endcomponent
        @component('components.itemLeftBar', [
        "name"          => "Hằng số",
        "faIcon"        => "fa-user",
        "isCurrent"         => Request::url() == route('admin::getConstantList'),
        "link"              => route('admin::getConstantList'),
    ])
    @endcomponent
    @component('components.itemLeftBar', [
        "name"          => "Hàng vận chuyển",
        "faIcon"        => "fa-user",
        "isCurrent"     => Request::url() == route('admin::getCargoList'),
        "link"          => route('admin::getCargoList'),
    ])
    @endcomponent
    @component('components.itemLeftBar', [
        "name"          => "Phương tiện vận chuyển",
        "faIcon"        => "fa-user",
        "isCurrent"         => Request::url() == route('admin::getVehicleList'),
        "link"              => route('admin::getVehicleList'),
    ])
    @endcomponent
    @component('components.itemLeftBar', [
        "name"          => "Tin kho",
        "faIcon"        => "fa-user",
        "isCurrent"         => Request::url() == route('admin::getAllWarehouse'),
        "link"              => route('admin::getAllWarehouse'),
    ])
    @endcomponent      
    @component('components.itemLeftBar', [
        "name"          => "Mua - Bán",
        "faIcon"        => "fa-user",
        "isCurrent"         => Request::url() == route('admin::getDealList'),
        "link"              => route('admin::getDealList'),
    ])
    @endcomponent      
    @component('components.itemLeftBar', [
        "name"          =>  "Dịch vụ",
        "faIcon"        =>  "fa-user",
        "isCurrent"         => Request::url() == route('admin::getServiceList'),
        "link"          =>  route('admin::getServiceList'),
    ])
    @endcomponent    
     @component('components.groupItemLeftBar', [
        "name"          => "Tuyển Dụng",
        "faIcon"        => "fa-user",
        "child"         => [
            [
                "name"              => "Danh sách tuyển dụng", 
                "isCurrent"         => Request::url() == route('admin::recruitmentList'),
                "link"              => route('admin::recruitmentList'),
            ],
            [
                "isCurrent"         => Request::url() == route('admin::recruitmentCategory'),
                "link"              => route('admin::recruitmentCategory'),
                "name"              => "Danh mục tuyển dụng",  
            ],
        ]
    ])
    @endcomponent
</ul>
