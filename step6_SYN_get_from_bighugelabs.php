<?php
include_once('./common.php');


$url="http://words.bighugelabs.com/api/2/93faf907be69cda8af750ecfa9713e9d/".$_REQUEST["word"]."/json"; 

$string=curl_return_string($url);
$json_s=json_decode(strchr($string,"{"),true);


$result_arr = array();

foreach ($json_s as $loop1) {
    foreach ($loop1["syn"] as $loop2) {
		array_push($result_arr, $loop2);
    }
}
echo json_encode($result_arr);

?>