<?php
include_once('./common.php');

$result="";
	$myFile=$_POST["wordfile"];
	$fh=fopen($myFile, 'r');
	$wordData=fread($fh, filesize($myFile));
	fclose($fh);
	$wordData=trim($wordData);
	$rows=explode( "\n", $wordData);

	for ($i = 0; $i < count($rows); $i++) 
	{
		$columns = explode("...", $rows[$i]);
		
		$word=strtolower($columns[0]);
		$result=$result."<p><code>".$word."</code></p>";

	}
	



echo $result;



?>