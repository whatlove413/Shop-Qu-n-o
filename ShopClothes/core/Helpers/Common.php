<?php
use Carbon\Carbon;
use Lang as Lang;

if (!function_exists('timeAgo')) {

	// duyệt thư mục tìm locale của Carbon
	$translator = Carbon::getTranslator();
	foreach (glob(__DIR__ . '/../Passion/CarbonLanguage_*.php') as $filename) {

		// tách tên file lấy tên locale
		preg_match("/CarbonLanguage_([a-zA-Z-_]+)\.php/", $filename, $matches);
		if ($matches && count($matches) == 2) {

			$locale = $matches[1];
			$resource = require $filename;

			// add resource cho Carbon
			$translator->addResource('array', $resource, $locale);
		}
	}

	// $translator->addResource('array', require __DIR__ . "/../Passion/CarbonLanguage_vi.php", "vi");


	/**
	 * @todo Hàm kiểm tra có phải thời gian dạng số
	 */
	if (!function_exists("isTimestamp")) {

		function isTimestamp($timestamp)
		{
			if (is_numeric($timestamp) && strlen((int)$timestamp) === 10) {

				return true;
			}
			return ((string)(int)$timestamp === $timestamp)
				&& ($timestamp <= PHP_INT_MAX)
				&& ($timestamp >= ~PHP_INT_MAX);
		}
	}


	/**
	 * https://github.com/Stillat/numeral.php/
	 * @todo Hàm format số
	 * @author Croco
	 * @since 15-9-2017
	 * @param $number: số cần format
	 * @param $format: chuỗi định dạng
	 * @param $locale: mã ngôn ngữ
	 * @return string
	 */
	function timeAgo($time, $locale = "vi")
	{

		if (!$time) {

			return "";
		}

		// unix timestamp helper
		if (isTimestamp($time))
			{
			$time = '@' . $time;
		}

		$locale = app()->getLocale();
		
		// nếu không phải ngôn ngữ hiện tại
		if ($locale != Carbon::getLocale()) {

			$translator = Carbon::getTranslator();

			$translator->setLocale($locale);
		}

		$now = Carbon::now();

		$diff = new Carbon($time);

		if (function_exists("date_default_timezone_get")) {

			$timezone = date_default_timezone_get();
			$now->setTimezone($timezone);
			$diff->setTimezone($timezone);
		}

		return $diff->diffForHumans($now);
	}
}

if (!function_exists('transferDataToJs')) {

	/**
	 * @todo Hàm truyền data từ php sang js thông qua biến jsData trong View
	 * @param name: tên
	 * @param data: giá trị
	 */
	function transferDataToJs($name, $data)
	{
		// $i = $i +1;
		$view = view();
	
		//override
		$view->composer('*', function ($view) use ($name, $data) {

			$jsData = $view->getData()['jsData'] ?: [];
			$jsData = array_merge($jsData, [
				$name => $data
			]);

			$view->with('jsData', $jsData);
		});
	}
}

if (!function_exists('transferObjToJsData')) {

	function transferObjToJsData($array, &$res, $isHot)
	{

		foreach ($array as $key => $value) {

			$new = array(
				'value' => $key,
				'label' => is_array($value) ? (Lang::has('common.'.$key) ? trans('common.'.$key) : $key ) : ($value ? $value : "")
			);

			if (count($isHot > 0 ) && in_array($key, $isHot)) $new['isHot'] = true;
			if (!$value) $new['isOther'] = true;


			if (is_array($value)) {
				$new['children'] = [];
				$new['hideLabel'] = true;
				transferObjToJsData($value, $new['children'], $isHot);
			}
			array_push($res, $new);

		}

	}
}