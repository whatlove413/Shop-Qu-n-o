<?php

namespace Core\Traits;

use Core\Responders\ServiceResponse;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Guzzle\Http\Exception\BadResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

trait Helpers
{
    /**
     * Gửi params tới đường dẫn api
     * @author luffy 29.5.2018
     *
     * @param $method   : Phương thức GET, POST, PUT, ...
     * @param $params   : Các params sẽ gửi lên
     * @param $uri      : Đường dẫn uri - api đi đến
     */
    private function sendParamsToApi($method, $form_params, $uri, $headersParams = null)
    {
        // dữ liệu trả về
        $result = new ServiceResponse();
        try
        {

            // Tùy theo phương thức mà key params truyền lên thay đổi theo
            $keymethod = null;
            switch ($method) {
                case "GET":
                    $keymethod = "query";
                    break;
                case "POST":
                    $keymethod = "form_params";
                    break;
                default:
                    $keymethod = "form_params";
            }

            // Khởi tạo guzzle
            if ($headersParams) {
                $client = app()->make("guzzleClient", $headersParams);
            } else {
                $client = app("guzzleClient");
            }
            // *************************************** Send params to API ***********************************
            // ServerException
            try
            {
                // RequestException
                try
                {
                    // ConnectException
                    try
                    {
                        // ClientException
                        try
                        {
                            // BadResponseException
                            try
                            {
                                // Tiến hành gửi params lên
                                $res = $client->request($method, $uri, [
                                    $keymethod => $form_params,
                                ]);
                            } catch (Guzzle\Http\Exception\BadResponseException $ex) {
                                return $this->addError($result, [$ex->getMessage(), "BadResponseException"], 500);
                            }
                        } catch (ClientException $ex) {
                            return $this->addError($result, [$ex->getMessage(), "ClientException"], 500);
                        }
                    } catch (ConnectException $ex) {
                        return $this->addError($result, [$ex->getMessage(), "ConnectException"], 500);
                    }
                } catch (RequestException $ex) {
                    return $this->addError($result, [$ex->getMessage(), "RequestException"], 500);
                }
            } catch (ServerException $ex) {
                return $this->addError($result, [$ex->getMessage(), "ServerException"], 500);
            }
            // *************************************** End send params to API ***********************************
            $headers = $res->getHeaders();
            $data = $res->getBody()->getContents();
            try {
                $data = json_decode($data, true);
            } catch (\Exception $ex) {

                // add lỗi vào kết quả trả về
                return $this->addError($result, [$ex->getMessage()]);
            }

            // Trả kết quả về
            $result->setData([
                "headers" => $headers,
                "data" => $data,
            ]);

            return $result;

        } catch (\Exception $ex) {

            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }
    }

    /**
     * Hàm trả về response theo dạng chuẩn
     * @author luffy 30.5.2018
     *
     * @param [contens] : Nội dung trả về
     * @param [statusCode] : Status code - 200 - 500
     */
    private function returnResponseStandard($contents, $statusCode)
    {

        return (new Response(json_encode($contents), $statusCode))
            ->header('Content-Type', 'application/json');

    }

    /**
     * Hàm tiến hàm thêm lỗi phát sinh
     * @author luffy 28.5.2018
     *
     * @param [result] : $result = new ServiceResponse();
     * @param [errors] : Mảng danh sách các lỗi
     */
    private function addError($result, $errors, $statusCode = 500)
    {
        foreach ($errors as $errorsKey => $errorsItem) {
            $result->addException($errorsItem);
        }
        $result->setStatus(ServiceResponse::STATUS_ERROR);
        // Nếu có status code thì mới tiến hành set
        $result = $result->setStatusCode($statusCode);
        return $result;
    }

    /**
     * Validate ajax
     * @author luffy 16.6.2018
     */
    private function validateAjax($data, $url, $method)
    {
        // Các params sẽ được submit lên API
        $form_params = ["ajax" => "ajax"];
        $form_params = array_merge($form_params, $data);

        // Gọi API tiến hành validate user
        $res = $this->sendParamsToApi($method, $form_params, $url);
        if ($res->fails()) {

            return json_encode([
                "STATUS" => "OK",
                "data" => $res->errors()->first(),
            ]);
        }
        $res = $res->getData()["data"];

        // Nếu có dữ liệu trả về
        if ($res && $res["STATUS"] != "ERROR") {
            // Thông tin user
            $res = (object) $res["data"];
        }

        return json_encode([
            "STATUS" => "OK",
            "data" => $res,
        ]);
    }

    /**
     * @todo Lấy phân trang nhanh cho DB
     * @param $query : Câu truy vấn
     */
    public function paginateForQuery($query, $options)
    {
        // Phân trang:
        /* Nếu có phân trang */
        if ($options['item-per-page'] && $options["page"]) {

            $sumRows = $query->count();

            $options["page"] = $options["page"] - 1;
            $query = $query
                ->skip($options['item-per-page'] * $options["page"])->take($options['item-per-page'])
                ->get();

            $paginateArr =
                [
                "item-per-page" => $options["item-per-page"],
                "page" => $options["page"] + 1,
                "sum" => $sumRows,
            ];
        }
        /* Ngược lại không có phân trang */
        else {
            $query = $query->get();
        }

        return ["query" => $query, "paginateArr" => $paginateArr];
    }

    //dữ liệu trả  về
    /**
     * @todo lây dữ liểu trả về
     * @param $res : lấy dữ liệu data
     */

    public function dataGet($res, $request)
    {
        if ($res->fails()) {
            return $res->errors();
        }

        $result = array_merge(['STATUS' => "OK", "URL" => $request->fullURL()], $res->getData());
        return $this->returnResponseStandard($result, 200);
    }
    /**
     * @todo lây dữ liểu
     * @param $query : Câu truy vấn,$queryId : lấy truy vấn dữ liệu của id đó
     */
    //phát sinh lỗi
    public function queryDataId($query, $queryId, $result)
    {
        if (!$query) {
            DB::rollBack();
            return $this->addError($result, ["Thất bại"]);
        }
        $query = $queryId;
        if (!$query) {
            DB::rollBack();
            $result->addError('Có lỗi khi lấy giữ liệu', 500);
        }
        DB::commit();
        $result->setData(["query" => $query]);
        return $result;

    }

}
