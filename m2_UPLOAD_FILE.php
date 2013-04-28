<?php
session_start();
$isPass=true;
if ($_FILES ["file"] ["error"] > 0)
{
    die("Error: " . $_FILES ["file"] ["error"] . "<br />");
	$isPass=false;
}
else
{
	//check file type
	if($_FILES ["file"] ["type"]!='text/plain')
	{
		die("The file type must be text/plain<br />");
		$isPass=false;
	}
	//check file size
	if($_FILES ["file"] ["size"]>5000)
	{
		die("The file is too big,split your word file into small files<br />");
		$isPass=false;
	}
	//check file format
	$myFile = $_FILES ["file"] ["tmp_name"];
	$fh = fopen($myFile, 'r');
	$theData = fread($fh, filesize($myFile));
	$theData = trim($theData);
	fclose($fh);

	$word_array = explode("\n", $theData);
	/*check ERROR 1*/
	for ($i = 0; $i < count($word_array); $i++) 
	{
		$word_array1 = explode("...", $word_array[$i]);
		if(count($word_array1)!=2)
		{
			echo "unexpected format,your must have only one ... in a line,check line ".strval($i+1)."!<br />";
			$isPass=false;
		}
	}
	if(!$isPass)
	{
		die("UNEXPECTED FORMAT ERROR 1:HAVE AND MUST HAVE ONLY ONE '...' TO SPLIT YOUR WORD AND SENTENCE<br />");
	}
	/*check ERROR 2*/
	for ($i = 0; $i < count($word_array); $i++)
	{
		$word_array1 = explode("...", $word_array[$i]);
		if(!preg_match("/^[a-zA-Z]{2,23}$/i",$word_array1[0]))
		{
			echo "unexpected format,your word must be in a pattern of /^[a-zA-Z]{2,23}$/i,check line ".strval($i+1)."!<br />";
			$isPass=false;
      	}
	}
	if(!$isPass)
	{
		die("UNEXPECTED FORMAT ERROR 2:CHECK YOUR WORD'S CHARACTERS!<br />");
	}
	/*check ERROR 3*/
	for ($i = 0; $i < count($word_array); $i++)
	{
		$word_array1 = explode("...", $word_array[$i]);
		if(str_word_count($word_array1[1])>20)
		{
			echo "unexpected format,your sentence must contain less than 20 words,check line ".strval($i+1)."!<br />";
			$isPass=false;
      	}
	}
	if(!$isPass)
	{
		die("UNEXPECTED FORMAT ERROR 3:YOUR SENTENCE>20 WORDS!<br />");
	}
	/*check ERROR 4*/
	for ($i = 0; $i < count($word_array); $i++)
	{
		$word_array1 = explode("...", $word_array[$i]);
		if(!preg_match("/^[0-9a-zA-Z\r()';:,. !?\-]*$/",$word_array1[1]))
		{
			echo "unexpected format,your sentence must be in a pattern of /^[0-9a-zA-Z\r()';,. !?-:]*$/,check line ".strval($i+1)."!<br />";
			$isPass=false;
      	}
	}
	if(!$isPass)
	{
		die("UNEXPECTED FORMAT ERROR 4:CHECK YOUR SENTENCE'S CHARACTERS!<br />");
	}

	//check file exists
    /*if(file_exists ( "userdata/".$_SESSION['user']."/upload/" . $_FILES ["file"] ["name"] ))
    {
        echo $_FILES ["file"] ["name"] . " already exists.<br />";
		$isPass=false;
    }*/ 
}
if($isPass)
{
	move_uploaded_file ( $_FILES ["file"] ["tmp_name"], "userdata/".$_SESSION['user']."/upload/" . $_FILES ["file"] ["name"] );
	header ( 'Location: /SG/index.php?user='.$_SESSION['user'] );
}
?>