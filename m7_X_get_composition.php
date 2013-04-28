<?php
include_once('./common.php');

$myFile = $_POST["compositionfile"];
$url="JavaScript:newPopup1(\"/SG/m7_COMPOSITION.php?WURL=".$_POST["wordfile"]."&URL=".$_POST["compositionfile"]."\");";
if(!file_exists($myFile))
{
	$compositionData="<a href='".$url."'>Write a composition using your words</a>";
}
else
{
	$fh = fopen($myFile, 'r');
	$compositionData = fread($fh, filesize($myFile));
	fclose($fh);
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
		if(!strchr("<code>",$word))
			if(strchr($compositionData,$word))
				$compositionData=str_replace($word,"<code>".$word."</code>",$compositionData);
		

	}
	
	$compositionData="<p><a href='".$url."'>Update</a></p>".$compositionData;


	
}

echo $compositionData;



?>