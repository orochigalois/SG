<?php
include_once('./common.php');
$score = $_POST["score"];
$user = $_POST["user"];

$file="./userdata/".$user."/score.txt";

file_put_contents($file, $score);

?>