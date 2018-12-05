<?php

namespace Core\Traits;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;

trait Login
{
    protected $whiteList = [
        'user_id',
        'user_fullname',
        'user_mobile_phone',
        'user_passowrd',
        'user_email',
        'user_permission',
        'user_status',
        'user_active_code',
    ];

    protected function filter($user)
    {
        if (!$user) {
            return false;
        }

        foreach ($user as $field => $value) {
            if (!in_array($field, $this->whiteList)) {
                unset($user->{$field});
            }
        }
        return $user;
    }

    /**
     * @todo: Hàm lấy mã thiết bị
     * @author: Croco
     * @since: 1-7-2017
     * @return String
     */
    public function getDeviceID()
    {
        /* dd($_SERVER['HTTP_USER_AGENT']);
        $deviceID = $this->request->header('deviceid') || false;
        $deviceID = $deviceID ? $deviceID : $this->request->header('x-deviceid');
        $deviceID = $deviceID ? $deviceID : $this->request->header('x-requested-with'); */
        $deviceID = $deviceID ? $deviceID : $_SERVER['HTTP_USER_AGENT'];

        return $deviceID;
    }

    /**
     * @todo: Hàm lấy ip client
     * @author: Croco
     * @since: 20-4-2017
     */
    public function get_client_ip()
    {
        $ipaddress = 'UNKNOWN';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }

        return $ipaddress;
    }

    /**
     * @author T.Hùng 26/10/2016
     * @editor Mr.Phúc 11/8/2017
     * @todo Tạo token
     * @param array $dataAccount Mảng chứa thông tin account
     * @return string
     */
    protected function _generateToken($dataAccount = array(), &$expire = null)
    {

        $configJwt = array(
            'key' => base64_encode(md5("sharingeconomy.vn;nhieu;a@")), // private key
            'algorithm' => 'HS512', // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
            'serverName' => 'sharingeconomy.vn',
            'expire' => 90,
        );

        $tokenId = base64_encode(random_bytes(32));
        $issuedAt = time();
        $expire = ($expire === null) ? $issuedAt + 86400 * $configJwt['expire'] : $expire; // Thời gian token hết hạn
        $serverName = $configJwt['serverName'];

        // lấy thông tin thiết bị
        //$request    = $this->getRequest();
        $deviceID = $this->getDeviceID();
        /*
         * Create the token as an array
         */
        $data = [
            'jti' => $tokenId, // Json Token Id: an unique identifier for the token
            'iat' => $issuedAt, // Issued at: time when the token was generated
            'iss' => $serverName, // Issuer
            'exp' => $expire, // Expire
            'data' => $dataAccount,
            'device' => $deviceID,
        ];

        $secretKey = base64_decode($configJwt['key']);

        $algorithm = $configJwt['algorithm'];

        $jwt = JWT::encode(
            $data, //Data to be encoded in the JWT
            $secretKey, // The signing key
            $algorithm // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );

        return $jwt;
    }

    /**
     * Tạo mã xác thực tài khoản đăng nhập
     * @author duy.nguyen 1.6.2018
     *
     * @param type $accountId
     * @return int
     */
    public function generateVerifyCode($accountId, $activeCode = null)
    {
        if (!$accountId) {
            return null;
        }

        $activeCode = $activeCode ?: generateRandomString(4);
        try {

            DB::beginTransaction();

            // Cập nhật lại mã active code
            DB::table('tbl_user')
                ->where('user_id', $accountId)
                ->update
                (
                [
                    "user_active_code" => $activeCode,
                ]
            );

            DB::commit();
        } catch (\Exception $ex) {
            return null;
        }
        return $activeCode;
    }
}
