<?php
include_once('./common.php');


$inputWordFile = $_SESSION['URL'];
$accent = $_SESSION['ACCENT'];
$fh = fopen($inputWordFile, 'r');
$theData = fread($fh, filesize($inputWordFile));
$theData=trim($theData);
fclose($fh);

$rows = explode("\n", $theData);

$result=',{"word":"';


for ($i = 0; $i < count($rows); $i++) 
{
	$columns = explode("...", $rows[$i]);
	
	$word=strtolower($columns[0]);
	//If has "\r",then the final JSON is wrong,and the AJAX will never return!!!!!!
	$sentence=str_replace("\r","",$columns[1]); 
	if($accent==1)
		$word_url = "http://translate.google.co.uk/translate_tts?ie=UTF-8&q=".$word."&tl=en&prev=input";
	else if($accent==2)
		$word_url = "http://translate.google.com/translate_tts?ie=UTF-8&q=".$word."&tl=en&prev=input";
	else{}
	$word_saveTo='./userdata/'.$_SESSION['user'].'/word/'.$word.'.mp3';
    $result.= $word.'","sentence": "'.$sentence.'"},{"word":"';
    if(!file_exists($word_saveTo))
    {
		curl_save_file($word_url,$word_saveTo);
    }
	if(abs(filesize($word_saveTo))<2000)
	{
		curl_save_file($word_url,$word_saveTo);
	}
	
	if($accent==1)
		$sentence_url = "http://translate.google.co.uk/translate_tts?ie=UTF-8&q=".$sentence."&tl=en&prev=input";
	else if($accent==2)
		$sentence_url = "http://translate.google.com/translate_tts?ie=UTF-8&q=".$sentence."&tl=en&prev=input";
	else{}
	$sentence_url=str_replace(" ","%20",$sentence_url);
	$sentence_saveTo='./userdata/'.$_SESSION['user'].'/sentence/'.$word.'.mp3';
	
	if(!file_exists($sentence_saveTo))
    {
    	curl_save_file($sentence_url,$sentence_saveTo);
    }
	if(abs(filesize($sentence_saveTo))<2000)
	{
		curl_save_file($sentence_url,$sentence_saveTo);
	}
}
$result=substr($result,0,strlen($result)-10);
$result.=']';

$result='[{"wordcount":'.count($rows).'}'.$result;
echo $result;

?>
