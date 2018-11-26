<?php

return [
    "area" => [
        "ho-chi-minh"   =>  "HỒ CHÍ MINH",
        "ha-noi"        =>  "HÀ NỘI",
        "da-nang"       =>  "ĐÀ NẴNG",
        "can-tho"       =>  "CẦN THƠ",
        "nha-trang"     =>  "NHA TRANG",
        "phan-thiet"    =>  "PHAN THIẾT"
    ],


    "typeVehicle" => [
        "container"     =>  "CONTAINER",
        "tau-thuy"      =>  "TÀU THỦY",
        "tau-hoa"       =>  "TÀU HỎA",
        "xe-tai"        =>  "XE TẢI",
        "xe-hoi"        =>  "XE HƠI",
        "xe-lua"        =>  "XE LỬA",
        "xe-khach"      =>  "XE KHÁCH"

    ],
    "weightCargoOffer" => [
        "tấn","cái","chuyến"
    ],
    //Số tin hiện trên trang chủ
    "paginateIndex"    =>[
       "so-tin"                     =>  "5",
       //custom
       "so-tin-doanh-nghiep"        =>  "15",
       "so-tin-kho"                 =>  "5",
       "so-tin-mua-ban"             =>  "5",
       "so-tin-hang-van-chuyen"     =>  "5",
       "so-tin-phuong-tien"         =>  "5",
       "so-tin-dich-vu"             =>  "5",
    ], 
    //Số tin hiện trên trang con
    "paginateWeb"    =>[
       "so-tin"                     =>  "5",
       "so-tin-lien-quan"           =>  "4",
       //custom
       "so-tin-doanh-nghiep"        =>  "15",
       "so-tin-kho"                 =>  "5",
       "so-tin-mua-ban"             =>  "5",
       "so-tin-hang-van-chuyen"     =>  "5",
       "so-tin-phuong-tien"         =>  "5",
       "so-tin-dich-vu"             =>  "5",
    ], 
    "constant_type"    =>[
       "system"                     =>  "Hệ thống",
       "admin"                      =>  "Quản lý",
       "user"                       =>  "Người dùng",
    ], 
    
    "newsCategory" => [
        "tu-van-logistics"                      =>  "Tư vấn Logistics",
        "tu-van-giao-dich"                      =>  "Tư vấn giao dịch",
        "doanh-nghiep-van-tai"                  =>  "Doanh nghiệp vận tải",
        "van-chuyen-hang-hoa"                   =>  "Vận chuyển hàng hóa",
        "cho-thue-kho-bai"                      =>  "Cho thuê kho bãi",
        "xu-huong-cong-nghe-trong-logistics"    =>  "Xu hướng công nghệ trong Logistics"
    ],
    "vehicle" => [
        [ "value" => 'Container'],
        [ "value" => 'Tàu thủy'],
        [ "value" => 'Tàu hỏa'],
        [ "value" => 'Xe tải'],
        [ "value" => 'Xe hơi'],
        [ "value" => 'Xe lửa'],
        [ "value" => 'Xe khách'],
        [ "value" => 'Xe 3 bán'],

    ],

    "cargoOffer" => [
        [ "value" => 'gạch ngói'],
        [ "value" => 'xi măng'],
        [ "value" => 'gạch vuông'],
        [ "value" => 'đá'],
    ],
        "warehouse_type" => [
        [ "value" => 'Cross Docking'],
        [ "value" => 'Kho công cộng'],
        [ "value" => 'Kho ngoại quan'],
        [ "value" => 'Kho bảo thuế'],
        [ "value" => 'Kho CFS'],
    ],


    "welcomeMail" => [
      "titleMail"   =>  "Sharingeconomy",
      "contentMail" =>  "Chào mừng bạn đến với sàn logistics miễn phí",
    ]
];
