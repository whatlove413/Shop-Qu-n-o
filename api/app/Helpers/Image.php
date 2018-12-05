<?php

namespace App\Helpers;

use File;

class Image
{
    public function __construct($options = [])
    {
        $this->path = [
            "cargo_offer" => public_path('upload/transport/cargoOffer/images/original/default/'),
            "deal" => public_path('upload/deal/images/original/default/'),
            "recruitment" => public_path('upload/recruitment/images/logo/original/default/'),
            "vehicle_open" => public_path('upload/transport/vehicleOpen/images/original/default/'),
            "warehouse" => public_path('upload/warehouse/images/original/default/'),
            "service" => public_path('upload/service/images/original/default/'),
        ];
    }

    public function getDefaultImage($options = [])
    {
        $type = $options['type'];
        $path = ($this->path)[$type];
        $array = [];
        if (file_exists($path)) {
            $files = File::files($path);
            $temp = [];
            $default = [];
            $pre_set = [];
            $file_path = [];
            foreach ($files as $key => $value) {
                $temp[] = $value->getBaseName('.' . $value->getExtension());
                $file_path[$value->getBaseName('.' . $value->getExtension())] = 'default/' . $value->getFileName();
            }
            foreach ($temp as $value) {
                if (ctype_digit(explode(".", $value)[0])) {
                    $default[] = $value;
                } else {
                    $pre_set[] = $value;
                }
            }
            $array[$type] = array_merge(['default' => $default, 'preset' => $pre_set, "path" => $file_path]);
        }
        return $array;
    }
}
