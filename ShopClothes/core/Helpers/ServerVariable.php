<?php

// hàm lấy ip client
if(!function_exists('getClientIP')){
	
	function getClientIP() {
		$ipaddress = 'UNKNOWN';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        return $ipaddress;
	}
}

if(!function_exists('getRequestScheme')){
	
	function getRequestScheme() {

        $protocol = $_SERVER["REQUEST_SCHEME"] ? $_SERVER["REQUEST_SCHEME"] : "http";

        if(
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
            $_SERVER['SERVER_PORT'] == 443 ||
            ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' )
        ) {
            $protocol = "https";
        }

        return $protocol;
	}
}

if(!function_exists('getProtocol')){
	
	function getProtocol() {

        return getRequestScheme() . "://";
	}
}