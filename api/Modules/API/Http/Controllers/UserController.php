<?php

namespace Modules\API\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Services\UserService;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    use \Core\Traits\Helpers;

    public function __construct(UserService $user)
    {
        $this->service = $user;
    }

    function list(Request $request) {
        $req = $request->all();
        $res = $this->service->list();
        return $res->getData();
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $users = $this->service->login($data);
        if ($users->fails()) {
            return [
                "STATUS" => "ERRORS",
                "message" => $users->errors()->first(),
            ];
        }
        $users = $users->getData();

        /** Mảng dữ liệu trả về */
        return $this->returnResponseStandard($users, 200);
    }

    public function info(Request $request)
    {
        $data = array_merge(
            $request->all(),
            [
                "authorization" => $request->header('authorization'),
                "deviceid" => $request->header('deviceid'),
            ]
        );
        $users = $this->service->info($data);
        if ($users->fails()) {
            return $this->returnResponseStandard([
                "STATUS" => "ERROR",
                "message" => $users->errors()->first(),
            ], 500);
        }
        $users = $users->getData();
        if (!$users) {
            return $this->returnResponseStandard([
                "STATUS" => "ERROR",
                "message" => "Sai tên đăng nhập hoặc mật khẩu",
            ], 500);
        }
        return $this->returnResponseStandard($users, 200);
    }

    public function detail($id)
    {
        $res = $this->service->detail($id);
        if ($res->fails()) {
            return $res->errors()->first();
        }
        $data = $res->getData();
        $response = array_merge(["STATUS" => "OK"], $data);
        return $response;
    }

    public function update(Request $request, $id)
    {
        $req = array_merge(
            $request->all(),
            [
                "authorization" => $request->header('authorization'),
                "deviceid" => $request->header('deviceid'),
            ]
        );
        $res = $this->service->update($req, $id);
        if ($res->fails()) {
            return $res->errors()->first();
        }
        $data = $res->getData();
        $response = array_merge(["STATUS" => "OK"], $data);
        return $response;
    }

    public function register(Request $request)
    {
        $req = $request->all();
        $res = $this->service->register($req);
        if ($res->fails()) {
            return ["message" => $res->errors()->first(),"STATUS"=>"ERRORS"];
        }
        $data = $res->getData();
        $response = array_merge(["STATUS" => "OK"], $data);
        return $response;
    }

    public function delete(Request $request, $id)
    {
        $auth = [
            "authorization" => $request->header('authorization'),
            "deviceid" => $request->header('deviceid'),
        ];
        $res = $this->service->delete($auth, $id);
        if ($res->fails()) {
            return $res->errors()->first();
        }
        $data = $res->getData();
        return $data;
    }
}
