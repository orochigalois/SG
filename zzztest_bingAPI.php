<html>
<head>
  <title>PHP Bing</title>
</head>
<body>

<?php
	$user_agent = "Mozilla/4.0";
	$proxy = "http://10.10.5.18:8080";

	$accountKey = 'kw/qlYGBk1WPFi6b+GyC/o6BzxO+0cEiXn/GRw7ba60=';
	$headers = array(
	        "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
	    );

	$ServiceRootURL =  'https://api.datamarket.azure.com/Bing/Search/v1/Composite/';                    
	$WebSearchURL = $ServiceRootURL . 'Image?$format=json&$top=10&$skip=0&Query=';
	$url = $WebSearchURL . urlencode( '\'' . 'novella' . '\'');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	/*Cancel this comment to enable the proxy*/
	curl_setopt ($ch, CURLOPT_PROXY, $proxy);
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec ($ch);
	curl_close($ch);
	//echo($result);

	$jsonobj = json_decode($result);
	//print_r($jsonobj);
    echo('<ul ID="resultList">');

    foreach($jsonobj->d->results as $value)
    {                        
        echo('<li class="resultlistitem"><img src="' 
                .$value->Thumbnail->MediaUrl.'&w=150&h=150" />');
    }

    echo("</ul>");

?>
</body>
</html>