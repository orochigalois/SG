<?php
include_once('./common.php');
	
$url="http://www.bing.com/images/search?q=".$_REQUEST["word"]; 


$string=curl_return_string($url);
preg_match_all("/<img([^>]*)\s*src=('|\")([^'\"]+)('|\")/", $string,$matches);

echo($matches);
$new_arr=array_unique($matches[0]);
$result='<div id="layout"><ul>';
foreach($new_arr as $key){
	
	if(strpos($key,"w=")&&strpos($key,"h="))
	{
		$str1=substr($key,strpos($key,"w="));
		$str2=substr($str1,0,strpos($str1,"&"));
		$str3=substr($str2,2);
		
		if(intval($str3)>100)
			$result=$result.'<li>'.$key.' width="200" height="150" /></li>';
	}
   
}
$result=$result.'</ul></div>';
echo $result;

?>