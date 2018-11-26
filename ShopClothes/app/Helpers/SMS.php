<?php
namespace App\Helpers;

// service provider

// $this->app->bind('sms', function ($app) {
// 	return new \Sms();
// });

// env
/*#############################
## Cấu hình SMS VIVAS ở đây
#############################
SMS_URL_LOGIN=http://mkt.vivas.vn:9080/SMSBNAPI/login
SMS_URL_SEND=http://mkt.vivas.vn:9080/SMSBNAPI/send_sms
SMS_USER=hcmtest
##SMS_PWD=Zun61TNMu5X6OXiPN14S9SlTw2A=
SMS_PWD=NK/q524OVGH3eRBLmAyCLsyoFsw=
SMS_BRAND=Vmarketing
SMS_SHAREKEY=123456*/

// use

/*$content = "Test SMS";
$sendNumber = "0965544750";
$sendNumber = (array) app('sms')->getVnNumber($sendNumber);

if(!env("APP_DEBUG")) {

	$response = app('sms')->sendSms($sendNumber, $content);

	if (!$response) {
		return false;
	}
	return true;
}*/


// helper
if (!function_exists('uuidv4')) {

    /**
     * @todo Hàm trả về uuid v4
     */
    function uuidv4()
    {

        try {

            if (function_exists('openssl_random_pseudo_bytes') && function_exists('bin2hex')) {

                $uuid = sprintf('%s-%s-%04x-%04x-%s', bin2hex(openssl_random_pseudo_bytes(4, $strong1)), bin2hex(openssl_random_pseudo_bytes(2, $strong2)), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, bin2hex(openssl_random_pseudo_bytes(6, $strong3))
                );
                if (!$strong1 || !$strong2 || !$strong3)
                    throw new \Exception('openssl_random_pseudo_bytes could\'not use a cryptographically strong PRNG');
                return $uuid;
            } else {
                return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    // 32 bits for "time_low"
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                    // 16 bits for "time_mid"
                    mt_rand(0, 0xffff),
                    // 16 bits for "time_hi_and_version",
                    // four most significant bits holds version number 4
                    mt_rand(0, 0x0fff) | 0x4000,
                    // 16 bits, 8 bits for "clk_seq_hi_res",
                    // 8 bits for "clk_seq_low",
                    // two most significant bits holds zero and one for variant DCE1.1
                    mt_rand(0, 0x3fff) | 0x8000,
                    // 48 bits for "node"
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                );
            }
        } catch (Exception $e) {

            return "";
        }
    }
}

/**
 * Helper gửi SMS
 * Dependency Injection Class
 * Retrieve: app('sms')
 */
class Sms
{

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $pwd;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $shareKey;

    /**
     * @var string
     */
    private $loginUrl;

    /**
     * @var string
     */
    private $sendUrl;

    /**
     * @constructor
     */
    public function __construct($options = [])
    {
        $this->user = $options["VMG_USER"] ?: env('VMG_USER');
        $this->pwd = $options["VMG_PASSWORD"] ?: env('VMG_PASSWORD');
        $this->brand = $options["ALIAS"] ?: env('ALIAS');
        $this->service_url = $options["VMG_SERVICE_URL"] ?: env('VMG_SERVICE_URL');
		$this->client = new \GuzzleHttp\Client();
    }

    /**
     * Gửi SMS VIVAS
     * @param string $phoneNumbers mảng Số điện thoại
     * @param string $msg Nội dung tin nhắn
     * @type int $type Loại Tin nhắn 1.CSKH, 2.QC
     * @return string
     */
    public function sendSms($phoneNumbers,$msg,$code)
    {
        $data_string = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
        <Body>
        <BulkMessageBlockReciver xmlns="http://tempuri.org/">
        <!-- Optional -->
        <msisdns>
        <string>'.$phoneNumbers.'</string>
        </msisdns>
        <alias>'.$this->brand.'</alias>
        <message>'.$msg."Quy khach".$code.'</message>
        <sendTime></sendTime>
        <authenticateUser>'.$this->user.'</authenticateUser>
        <authenticatePass>'.$this->pwd.'</authenticatePass>
        </BulkMessageBlockReciver>
        </Body>
        </Envelope>';                                                                                
        $service_url = $this->service_url;   
        $curl = curl_init($service_url); 
        curl_setopt($curl, CURLOPT_URL,$service_url);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data_string);
        $curl_response = json_encode(curl_exec($curl));
        curl_close($curl);
        return $curl_response;
    }

    /**
     * Tạo CHECKSUM theo yêu cầu Hệ thống API VIVAS
     *
     * @param Array $datas
     * @return \DOMDocument
     */
    private function createXmlData($datas, $childDatas = [])
    {
        $domTree = new \DOMDocument('1.0', 'UTF-8');
        $xmlRoot = $domTree->createElement("RQST");
        $xmlRoot = $domTree->appendChild($xmlRoot);

        foreach ($datas as $key => $val) {
            $xmlRoot->appendChild($domTree->createElement($key, $val));
        }
        /**
         * Create children DESTINATIONS
         */
        if ($childDatas) {
            $desRoot = $domTree->createElement("DESTINATIONS");
            $desRoot = $xmlRoot->appendChild($desRoot);
            foreach ($childDatas as $childData) {
                $destination = $domTree->createElement("DESTINATION");
                $destination = $desRoot->appendChild($destination);
                foreach ($childData as $k => $v) {
                    $destination->appendChild($domTree->createElement($k, $v));
                }
            }
        }

        return $domTree;
    }

    /**
     * Đổi số điện thoại lấy mã Việt nam
     * @author duy.nguyen 21.11.2017
     * @param string $number
     */
    function getVnNumber($number)
    {
        $number = str_replace(' ', '', $number);
        if ($number[0] == '0') {
            $number = substr_replace($number, '84', 0, 1);
        }
        return $number;
    }
}
