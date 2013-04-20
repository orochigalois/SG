<?php
include_once('./common.php');

   
$url=$_REQUEST["picURL"];
$saveTo='./userdata/'.$_SESSION['user'].'/picture/'.$_REQUEST["picName"];
curl_save_file($url,$saveTo)
?>