<?php

Route::group(['middleware' => 'custom', 'namespace' => 'Modules\Web\Http\Controllers'], function ()
{
    // Trang chủ
        // Đăng nhập tài khoản
    Route::get('/dang-nhap', [
        'as' => 'web::index_member',
        'uses' => 'MemberAuthController@index'
    ]);
    // Xác nhận đăng nhập
    Route::post('/verify', [
        'as' => 'web::verify',
        'uses' => 'MemberAuthController@verify'
    ]);
    // Xác nhận tài khoản k cần xác nhận code
    Route::get('/tai-khoan/xac-nhan/{token}', [
        'as' => 'web::activeWithoutCode',
        'uses' => 'MemberAuthController@activeWithoutCode'
    ]);
    // Lấy form đăng ký
    Route::get('/dang-ky', [
        'as' => 'web::register',
        'uses' => 'MemberAuthController@register'
    ]);
    // Tiến hành đăng ký
    Route::post('/dang-ky', [
        'as' => 'web::postRegister',
        'uses' => 'MemberAuthController@postRegister'
    ]);
    // home page
    Route::get('/', [
        'as' => 'web::index',
        'uses' => 'HomeController@index'
    ]);
    // tìm kiếm tất cả
    Route::get('/tim-kiem', [
        'as' => 'web::getSearchAll',
        'uses' => 'MemberAuthController@getSearchAll'
    ]);
    // Tìm kiếm nâng cao
    Route::get('/tim-kiem-nang-cao',[
        'as'    =>  'web::advancedSearch',
        'uses'  =>  'MemberAuthController@advancedSearch'
    ]);

    //-----MUA BÁN------//
    // Danh sách mua bán
    Route::get('mua-ban/', [
        'as' => 'web::index_deal',
        'uses' => 'DealController@index'
    ]);
    // Chi tiết mua bán
    Route::get('mua-ban/chi-tiet/{alias}', [
        'as' => 'web::getDealDetail',
        'uses' => 'DealController@getDealDetail'
    ]);
    // Tìm kiếm tin mua bán
    Route::post('/mua-ban/tim-kiem', [
        'as' => 'web::searchDeal',
        'uses' => 'DealController@searchDeal'
    ]);
    //-----END MUA BÁN------//

    Route::get('/quen-mat-khau', [
        'as' => 'web::forgetPass',
        'uses' => 'MemberAuthController@forgetPass'
    ]);
    //Nhập mail , sdt để nhận mã
    Route::post('/xac-nhan-quen-mat-khau/',[
        'as'  =>    'web::confirmForgetPass',
        'uses'   =>  'MemberAuthController@confirmForgetPass'
    ]);
    // Quên mật khẩu
    Route::get('/forget-pass', [
        'as' => 'web::forgetPass',
        'uses' => 'MemberAuthController@forgetPass'
    ]);
    // Nhập mã xác nhận
    Route::post('/nhap-ma-quen-mat-khau/',[
        'as'    =>  'web::activeForgetPass',
        'uses'  =>  'MemberAuthController@activeForgetPass'
    ]);
    Route::get('/check-confirm-code',[
        'as'    => 'web::check_confirm_code',
        'uses'  => 'MemberAuthController@checkConfirmCode'
    ]);
    // Gửi lại mã
    Route::get('/lay-lai-ma-xac-nhan/',[
        'as'    =>  'web::resendConfirmCode',
        'uses'  =>  'MemberAuthController@generateCodeFogetPass'
    ]);
    // Nhập mật khẩu mới
    Route::post('/mat-khau-moi/',[
        'as'    =>  'web::newPass',
        'uses'  =>  'MemberAuthController@changePass'
    ]);
} );

//Mua bán
Route::group(['middleware' => 'member', 'prefix' => 'mua-ban', 'namespace' => 'Modules\Web\Http\Controllers'], function()
{
    //Form đăng tin mua bán
    Route::get('/dang-tin', [
        'as' => 'web::getDealPost',
        'uses' => 'DealController@getDealPost'
    ]);
    //Tiến hành đăng tin mua bán
    Route::post('/dang-tin', [
        'uses' => 'DealController@postDealPost'
    ]);
    //Tiến hành upload ảnh
    Route::post('/dang-tin/upload', [
        'as' => 'web::uploadDealImage',
        'uses' => 'DealController@uploadImage'
    ]);
});

// tài khoản user
Route::group(['middleware' => 'member', 'prefix' => 'tai-khoan', 'namespace' => 'Modules\Web\Http\Controllers'], function ()
{

    // form kích hoạt tài khoản
    Route::get('/kich-hoat', [
        'as' => 'web::active',
        'uses' => 'MemberAuthController@active'
    ]);
    // kích hoạt tài khoản
    Route::post('/kich-hoat', [
        'uses' => 'MemberAuthController@checkActive'
    ]);
    // generate mã mới
    Route::get('/gui-lai-ma', [
        'as' => 'web::generate_code',
        'uses' => 'MemberAuthController@generateCode'
    ]);

    //Tiến hành đăng ký thành viên
    // xác nhận đăng nhập
    // đăng xuất
    Route::get('/dang-xuat', [
        'as' => 'web::logout',
        'uses' => 'MemberAuthController@logout'
    ]);

    // Trang profile
    Route::get('/ho-so', [
        'as' => 'web::profile',
        'uses' => 'MemberAuthController@profile'
    ]);

    // Tiến hành chỉnh sửa profile
    Route::post('/chinh-sua-ho-so', [
        'as' => 'web::editprofile',
        'uses' => 'MemberAuthController@editProfile'
    ]);

    // Trang reset pass
    Route::get('/thay-doi-mat-khau', [
        'as' => 'web::resetpassword',
        'uses' => 'MemberAuthController@resetPassword'
    ]);

    // Tiến hành reset pass
    Route::post('/reset-pass', [
        'as' => 'web::editResetpassword',
        'uses' => 'MemberAuthController@editResetPass'
    ]);

} );


Route::group(['middleware' => 'custom', 'prefix' => 'danh-muc', 'namespace' => 'Modules\Web\Http\Controllers'], function () {
    Route::get('/', [
        'as' => 'web::category',
        'uses' => 'ProductController@list',
    ]);
});


Route::group(['middleware' => 'custom', 'prefix' => 'san-pham', 'namespace' => 'Modules\Web\Http\Controllers'], function () {
    Route::get('/{id}', [
        'as' => 'web::product',
        'uses' => 'ProductController@detail',
    ]);
});
