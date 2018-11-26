## sharingeconomy
## Tài khoản admin 
    email / sdt: admin@sharingeconomy.vn / chưa set
    password : itvina@123
## First step

    Chạy "composer update" để cập nhật các phiên bản đã cài trong source hoặc "composer install".
    Chạy npm install.
    Khi code
    Chạy lệnh "npm run dev" để public nén css, js khi code.
    Nếu còn lỗi thì chạy composer dump-autoload

## - link chạy LIVE
    admin:
    sharingeconomy web:

## - link chạy LOCAL
    admin: 
    sharingeconomy web: http://sharingeconomy.local/

## Các lệnh thêm

    Chạy "php artisan cache:clear" xóa catche
    php artisan module:make <module-name> - Tạo 1 module
    npm run dev - chay mix css, js, image, fonts, ... sang public
    Fix lỗi phpuinit: composer install --prefer-source

## Các phần đã cài đặt

    Các package đã cài trong composer.json:
        . "nwidart/laravel-modules": "^2.6"     -> Đa module

## Vhost local

    <VirtualHost *:80>
        ServerAdmin webmaster@dummy-host2.example.com
        DocumentRoot "D:\xampp\htdocs\sharingeconomy_web_final\sharingeconomy.vn_web\sharingconomy_source\public"
        ServerName sharingeconomy.local
        ErrorLog "logs/sharingeconomy.local-error.log"
        CustomLog "logs/sharingeconomy.local-access.log" common
    </VirtualHost>

## - account login
    username :
    password :

## Database local

    DB_CONNECTION=mysql
    DB_HOST=118.69.173.212
    DB_PORT=3312
    DB_DATABASE=sharingeconomy_demo
    DB_USERNAME=root
    DB_PASSWORD=itvina@123
    DB_CHARSET=utf8mb4

## Cấu hình MAIL ở
MAIL_DRIVER=smtp 
MAIL_HOST=smtp.gmail.com
MAIL_PORT=25
MAIL_USERNAME=sharingeconomyinfo@gmail.com
MAIL_PASSWORD=uhahvhpaspkraonz
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Sharingeconomy"

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=

## Cấu hình SMS VIVAS ở đây
SMS_URL_LOGIN=http://mkt.vivas.vn:9080/SMSBNAPI/login
SMS_URL_SEND=http://mkt.vivas.vn:9080/SMSBNAPI/send_sms
SMS_USER=hcmtest
SMS_PWD=NK/q524OVGH3eRBLmAyCLsyoFsw=
SMS_BRAND=Vmarketing
SMS_SHAREKEY=123456

## Database online

## Công nghệ
    _ Dùng laravel 5.5 : querybuilder

## Cấu hình lưu ý:
    _ Module: Dùng đa module để tiện cho việc quản lý
    . Module được đặt theo chức năng chung( VD: Tạo 1 module "payment" thì tất cả những gì liên quan đến payment thì ta vào đây xử lý )
    . Những thao tác gọi đến function để xử lý chức năng thì được ghi trong controller, từ controller ta gọi đến service kèm theo các tham số xử lý và xử lý vấn đề trong service, khi xử lý xong ta trả kết quả về cho controller. Như vậy controller chỉ dùng để gọi function từ service và nhận kết quả từ serive để trả về view, ... Ngoài ra controller không viết gì thêm.

## Các concept lưu ý:
    _ Tầng service:
    . Service được đặt bên ngoài module và không nằm trong module để tiện cho việc sử dụng chung các source phát sinh sau này.
    . Khi tạo 1 service trong tầng "service" thì ta đặt tên theo chữ cái đầu viết hoa. VD: "PacKageService".
    _ Tầng Core:
    . Chủ yếu dùng để bắt các lỗi phát sinh trong quá trình viết code.
    . Trong tầng core folder helpers file allFunction dùng để viết các function chung cho cả source

    Thư viện: use Core\Responders\ServiceResponse;

    VD: về bắt lỗi, dưới đây là 1 cấu trúc bắt lỗi có thể dùng cho source này:

    // dữ liệu trả về
    $result = new ServiceResponse();
    try
    {
        DB::beginTransaction();
        // phát sinh lỗi
        if( true == false ) {
            
            DB::rollBack();
            // add lỗi vào kết quả trả về
            $result->addException(('error'), 500);
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);
            return $result;
        }

        // $id = DB::table('users')->insertGetId(
        //     ['email' => 'john@example.com', 'votes' => 0]
        // );

        DB::commit();
        $result->setData(  );
        return $result;
    } catch (\Exception $ex) {
        
        DB::rollBack();
        // add lỗi vào kết quả trả về
        $result->addException($ex->getMessage(), $ex->getCode());
        $result->setStatus(ServiceResponse::STATUS_ERROR);
        $result->setStatusCode(500);
        
        // trả về cho controller
        return $result;
    }

VD: Bên controller nhận được lỗi:

    if( $response->fails() )
    {
        
        return \Redirect::back()->withErrors( $response->errors() );
    }

VD: Bên controller thành công

    return redirect()->back()->withSuccess( 'Sửa dữ liệu thành công!' );

VD: Comment

    /**
	 * @todo Hàm lấy 1 admin của brand
	 * @author Croco
	 * @since 27-10-2017
	 * @param int $brandID: mã brand
	 * @return ServiceResponse stdClass Admin
	*/

VD: Query lấy dữ liệu có phân trang

    1/ public
        try {

            if ($options['paginate']) {

                $options['mode'] = 'QueryBuilder';
                $queryBuilder = $this->getListVehicleDetail($options);

                return $queryBuilder->paginate( $options['paginate'] );
            }
            return $this->getListVehicleDetail($options);

        } catch (\Exception $ex) {

            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }

    2/private
        $auth = Auth::user();

        $queryBuilder = DB::table('tbl_fleets AS fleets')
            ->select( '*' )
            // Lấy ra danh sách chưa xóa
            ->whereNull('fleets_deleted_time');

        $queryBuilder->where( "fleets.fleets_create_by", "=",  $auth->id );

        // Sắp xếp tăng giảm
        $queryBuilder->orderBy('fleets.fleets_id', 'DESC');

        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }

        return $queryBuilder->get();

    3/ Phân trang
        $listVehicle = $this->service->getListVehicle(['paginate' => 100]);

## Nội dung các branch:
    _ Master:
    . Dùng để chứa source đã kiểm tra và sẵn sàng vào chính thức

    _ Develop:
    . Dùng để chứa source được thừa kế từ master
    . dùng để test code lần cuối và đưa lên master

    _ feature:
    . Dùng để chứa source được thừa kế từ develop
    . dùng để test code lần đầu khi các lập trình viên khác đã up code phần task của mình lên

    _ Các brand khác:
    . Là các brand mà lập trình viên khác đang thao tác

    _ Xóa branch:
       git branch -d <branchname>
## Ghi chú: Chưa đề cập đến

## Ajax file:
_ https://stackoverflow.com/questions/2320069/jquery-ajax-file-upload