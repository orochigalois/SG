<?php
include_once('./common.php');


$skip=intval($_REQUEST["page"])*18;

$ServiceRootURL =  'https://api.datamarket.azure.com/Bing/Search/v1/Composite/';                    
$WebSearchURL = $ServiceRootURL . 'Image?$format=json&$top=18&$skip='.$skip.'&Query=';
$url = $WebSearchURL . urlencode( '\'' . $_REQUEST["picName"] . '\'');
$result=curl_through_bing($url);
//echo($result);

$jsonobj = json_decode($result);
//print_r($jsonobj);
$return_str='<div id="layout"><ul>';
    

foreach($jsonobj->d->results as $value)
{                        
    $return_str=$return_str.'<li><img src="' 
            .$value->Thumbnail->MediaUrl.'&w=200&h=150" /></li>';
}

$return_str=$return_str.'</ul></div>';
echo $return_str;

?>