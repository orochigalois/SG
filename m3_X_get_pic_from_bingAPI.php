<?php


// CSE console: https://cse.google.com/cse/all

// API console: https://console.cloud.google.com/apis/dashboard?project=shootinggame-1547031803800&duration=PT1H

// API Doc: https://developers.google.com/custom-search/v1/overview

// API parameter Doc: https://developers.google.com/custom-search/v1/cse/list


include_once('./common.php');

$start=(intval($_REQUEST["page"])-1)*9+1;
$url =  'https://www.googleapis.com/customsearch/v1?start='.$start.'&num=9&key=AIzaSyDhSPErqY29GpIKJaydpbzPmszuequWors&cx=005357025438319005378:47442hllu9g&searchType=image&imgSize=small&q='.$_REQUEST["picName"];


$result=curl_through_bing($url);
$jsonobj = json_decode($result);

$return_str='<div id="layout"><ul>';
    

foreach($jsonobj->items as $value)
{                        
    $return_str=$return_str.'<li><img style="object-fit:contain;" width=200 height=150 src="' 
            .$value->link.'" /></li>';
}

$return_str=$return_str.'</ul></div>';

echo $return_str;

?>