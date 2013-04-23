<?php
session_start();
set_time_limit(0);
////////If a proxy should be used in server,update this 2 constants
define('USE_PROXY', true);
define('PROXY_ADDRESS', 'http://10.10.5.18:8080');

define('USER_AGENT', 'Mozilla/4.0');

////////This is account key for bing
define('BING_ACCOUNT_KEY', 'kw/qlYGBk1WPFi6b+GyC/o6BzxO+0cEiXn/GRw7ba60=');

function curl_return_string($url)
{
	$ch = curl_init();
	if(USE_PROXY)
		curl_setopt ($ch, CURLOPT_PROXY, PROXY_ADDRESS);
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_USERAGENT, USER_AGENT);
	curl_setopt ($ch, CURLOPT_HEADER, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
	$result = curl_exec ($ch);
	curl_close($ch);
	return $result;
}
function curl_through_bing($url)
{
	$headers = array(
	        "Authorization: Basic " . base64_encode(BING_ACCOUNT_KEY . ":" . BING_ACCOUNT_KEY)
	    );
	
	$ch = curl_init();
	if(USE_PROXY)
		curl_setopt ($ch, CURLOPT_PROXY, PROXY_ADDRESS);
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_USERAGENT, USER_AGENT);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec ($ch);
	curl_close($ch);
	return $result;
}
function curl_save_file($url,$saveTo)
{
	$ch = curl_init();
	if(USE_PROXY)
		curl_setopt ($ch, CURLOPT_PROXY, PROXY_ADDRESS);
	curl_setopt ($ch, CURLOPT_URL, $url);
	$fp = fopen ($saveTo, 'w');
	curl_setopt ($ch, CURLOPT_FILE, $fp);
	curl_setopt ($ch, CURLOPT_USERAGENT, USER_AGENT);
	$result = curl_exec ($ch);
	curl_close($ch);
	fclose($fp);
}

?>

