<?php
use Intervention\Image\ImageManagerStatic as Image;
use Core\Responders\ServiceResponse;

if (!function_exists('uploadFile')) {

    /**
     * @todo Đăng ký 1 tài khoản
     * @author Thanh
     * @since 05/03/2018
     * @param $fileIn: File muốn di chuyển
     * @param string $urlIn: URL muốn di chuyển, VD: 'upload/account/image'
     * @return tên hình ảnh
     */
    function uploadFile($fileIn, $urlIn)
    {
        $name = null;
        if ($fileIn) {
            $name = $fileIn->getClientOriginalName();
            $name = time() . "_" . preg_replace("/[^A-Za-z0-9\_\-\.]/", '', basename($name));
            $name = str_replace(" ", "", $name);

            $url = public_path($urlIn);

            if (!file_exists($url)) {

                File::makeDirectory($url, $mode = 0777, true, true);
            }

            // Đường dẫn cần copy
            $path_Pro = $url . "/" . $name;
            // Copy hình ảnh vào mục cần lưu
            File::copy($fileIn->path(), $path_Pro);

        }

        return $name;
    }
}

if (!function_exists('uploadManyFile')) {

    /**
     * @todo Upload nhiều file 1 lúc
     * @author luff
     * @since 22/01/2018
     * @param $fileMany: Các flile muốn di chuyển
     * @param string $urlIn: URL muốn di chuyển, VD: 'upload/account/image'
     * @return tên hình ảnh json
     */
    function uploadManyFile($fileMany, $urlIn)
    {
        $nameFinal = [];
        if ($fileMany) {

            foreach ($fileMany as $fileIn) {
                $name = $fileIn->getClientOriginalName();
                $name = time() . "_" . preg_replace("/[^A-Za-z0-9\_\-\.]/", '', basename($name));
                $name = str_replace(" ", "", $name);

                $url = public_path($urlIn);

                if (!file_exists($url)) {

                    File::makeDirectory($url, $mode = 0777, true, true);
                    File::makeDirectory($url . "/../large/", $mode = 0777, true, true);
                    File::makeDirectory($url . "/../small/", $mode = 0777, true, true);
                }

                // Đường dẫn cần copy
                $path_Pro = $url . "/" . $name;
                // Copy hình ảnh vào mục cần lưu original
                File::copy($fileIn->path(), $path_Pro);
                // tạo watermark cho original image
                // $icon_original = Image::make(public_path('/img/logo/logo.png'))->resize(450, 342);
                $img = Image::make($path_Pro)->resize(960, 720); //your image I assume you have in public directory
                // $img->insert($icon_original, 'center'); //insert watermark in (also from public_directory)
                $img->save($path_Pro);
                $image_large = Image::make($path_Pro)->resize(270, 172)->encode('png', 50);
                /*$image_large->insert(public_path('/img/logo/logo.png'), 'center');*/
                $image_large->save($url . "/../large/" . $name);
                $image_small = Image::make($path_Pro)->resize(150, 114)->encode('png', 50);
                /*$image_small->insert(public_path('/img/logo/logo.png'), 'center');*/
                $image_small->save($url . "/../small/" . $name);
                $urlSaved = explode('original', $urlIn)[0] . 'large';
                array_push($nameFinal, $urlSaved . '/' . $name);
            }
        }
        return json_encode($nameFinal, true);
    }
}

if (!function_exists('uploadManyFileEnterprise')) {
    /**
     * @todo Upload nhiều file 1 lúc doanh nghiệp
     * @author đại
     * @since 14/05/2018
     * @param $fileMany: Các flile muốn di chuyển
     * @param string $urlIn: URL muốn di chuyển, VD: 'upload/account/image'
     * @return tên hình ảnh json
     */
    function uploadManyFileEnterprise($fileMany, $urlIn, $type)
    {
        $nameFinal = [];
        if ($fileMany) {

            foreach ($fileMany as $fileIn) {
                $name = $fileIn->getClientOriginalName();
                $name = time() . "_" . preg_replace("/[^A-Za-z0-9\_\-\.]/", '', basename($name));
                $name = str_replace(" ", "", $name);

                $url = public_path($urlIn);

                if (!file_exists($url)) {
                    File::makeDirectory($url, $mode = 0777, true, true);
                    File::makeDirectory($url . "/../large/", $mode = 0777, true, true);
                    File::makeDirectory($url . "/../small/", $mode = 0777, true, true);
                }

                // Đường dẫn cần copy
                $path_Pro = $url . "/" . $name;
                // Copy hình ảnh vào mục cần lưu original
                File::copy($fileIn->path(), $path_Pro);
                // Lấy kích thước của hình
                $data = getimagesize($path_Pro);
                $width = $data[0];
                $height = $data[1];
                //resize thành ảnh large enterprise $type = 1
                if (($width > 336 || $height > 300) && $type == 1) {
                    //resize hình thành cỡ lớn lưu vào file large
                    $image_large = Image::make($path_Pro)->resize(336, 300)->encode('png', 50);
                    $image_large->save($url . "/../large/" . $name);
                }
                //resize thành ảnh large recruitment $type = 2
                elseif (($width > 266 || $height > 156) && $type == 2) {
                    //resize hình thành cỡ lớn lưu vào file large
                    $image_large = Image::make($path_Pro)->resize(266, 156)->encode('png', 50);
                    $image_large->save($url . "/../large/" . $name);
                } else {
                    File::copy($path_Pro, $url . "/../large/" . $name);
                }
                //resize hình thành cỡ nhỏ lưu vào file small
                $image_small = Image::make($path_Pro)->resize(150, 114)->encode('png', 50);
                $image_small->save($url . "/../small/" . $name);
                $urlSaved = explode('original', $urlIn)[0] . 'large';
                array_push($nameFinal, $urlSaved . '/' . $name);
            }
        }
        return json_encode($nameFinal, true);
    }
}

if (!function_exists('uploadCV')) {
    /**
     * @todo Upload nhiều file 1 lúc doanh nghiệp
     * @author đại
     * @since 14/05/2018
     * @param $fileMany: Các flile muốn di chuyển
     * @param string $urlIn: URL muốn di chuyển, VD: 'upload/account/image'
     * @return tên hình ảnh json
     */
    function uploadCV($fileMany, $urlIn, $type)
    {
        $nameFinal = [];
        if ($fileMany) {
            foreach ($fileMany as $fileIn) {
                $name = $fileIn->getClientOriginalName();
                $name = time() . "_" . preg_replace("/[^A-Za-z0-9\_\-\.]/", '', basename($name));
                $name = str_replace(" ", "", $name);
                $url = public_path($urlIn);
                if (!file_exists($url)) {
                    File::makeDirectory($url, $mode = 0777, true, true);
                }
                $path_Pro = $url . "/" . $name;
                File::copy($fileIn->path(), $path_Pro);
                array_push($nameFinal, $urlIn . '/' . $name);
            }
        }
        return json_encode($nameFinal, true);
    }
}

if (!function_exists('postFacebook')) {
    /**
     * @todo Upload nhiều file 1 lúc doanh nghiệp
     * @author đại
     * @since 14/05/2018
     * @param $fileMany: Các flile muốn di chuyển
     * @param string $urlIn: URL muốn di chuyển, VD: 'upload/account/image'
     * @return tên hình ảnh json
     */
    function postFacebook()
    {
        $app_id = '190394634929796';
        $app_secret = '8a12eb65a4025079ff3e4c2d92d6218c';
        $page_id = '680898928703350';
        $page_access_token = 'EAACEdEose0cBAG36nQewksFqsfN0NNEIZC2HznydEHMqgprSGbA5YOrYxvYpl11Fvnm0JtHHWyxVAvaUk2ZClHDEQDZBZAyUFDeJ8GBm87nRhHzsz1hnWQQne39Rce7IkNZC7c5voBVspOfCKzhKHWIcFfZCaBPavHn2ZAKPwx66TEqy3LoHZA3MXZCVy5XI8HLadyXzLbgBBrAZDZD';
        $config = array(
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => 'v2.2',
        );
        $fb = new Facebook\Facebook($config);
        $data = [
            'message' => 'This is my Photo',
            'source' => $fb->fileToUpload('http://demo.sharingeconomy.vn/img/avatar/dichvu.png'),
        ];
        try {
// Returns a `Facebook\FacebookResponse` object
            $response = $fb->post('/' . $page_id . '/photos', $data, $page_access_token);
            $graphNode = $response->getGraphNode();
            echo 'Success!!! Photo ID: ' . $graphNode['id'];
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }
}

if (!function_exists('showErrors')) {

    /**
     * @todo Show lỗi
     * @author luff
     * @since 31/01/2018
     * @param $error: File muốn kiểm tra lỗi
     * @return redirect error
     */
    function showErrors($error)
    {
        if ($error->fails()) {

            return \Redirect::back()->withErrors($error->errors());
        }
    }
}

if (!function_exists('formatObjectDate')) {

    /**
     * @todo Show lỗi
     * @author luff
     * @since 31/01/2018
     * @param $date: Ngày format
     * @param $str: chuỗi fomat
     * @return redirect error
     */
    function formatObjectDate($date, $str)
    {

        $dateNew = new DateTime($date);
        return $dateNew->format($str);
    }
}

if (!function_exists('addError')) {
    function addError($result, $errors, $statusCode = null)
    {
        $result->addException($errors, 500);
        $result->setStatus(ServiceResponse::STATUS_ERROR);
        if ($statusCode) {
            $result->setStatusCode(500);
        }
        return $result;
    }
}
