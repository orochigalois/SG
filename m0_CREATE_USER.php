<?php
include_once('./common.php');
mkdir('./userdata');
mkdir('./userdata/'.$_GET["user"],0777);
mkdir('./userdata/'.$_GET["user"].'/sentence',0777);
mkdir('./userdata/'.$_GET["user"].'/word',0777);
mkdir('./userdata/'.$_GET["user"].'/upload',0777);
mkdir('./userdata/'.$_GET["user"].'/picture',0777);
mkdir('./userdata/'.$_GET["user"].'/composition',0777);

$filename = './userdata/'.$_GET["user"].'/upload/demo.txt'; 
$fp=fopen("$filename", "w+"); 
if ( !is_writable($filename) ){
      die("�ļ�:" .$filename. "����д�����飡");
}
fwrite($fp, "book...This is a book\nnice...Nice to meet you\nhappy...I feel very happy");
fclose($fp);  

$filename = './userdata/'.$_GET["user"].'/composition/demo.txt'; 
$fp=fopen("$filename", "w+"); 
if ( !is_writable($filename) ){
      die("�ļ�:" .$filename. "����д�����飡");
}
fwrite($fp, "I bought a new book today.That is really nice and I feel very happy.");
fclose($fp); 

$filename = './userdata/'.$_GET["user"].'/score.txt'; 
$fp=fopen("$filename", "w+");
if ( !is_writable($filename) ){
      die("�ļ�:" .$filename. "����д�����飡");
}
fwrite($fp, "0");
fclose($fp);  

echo 'User '.$_GET["user"].' has been created successfully';
?>