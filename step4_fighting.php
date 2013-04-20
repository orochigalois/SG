<?php 
include_once('./common.php');
if(!$_SESSION['user'])
	die("user not found");
$_SESSION['URL']=$_GET["URL"];
$_SESSION['ACCENT']=$_GET["ACCENT"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=9">

<title>
	ILoveThisGame
</title><meta name="keywords" content="HTML5"><meta name="description" content="HTML5"></head>
<body onload="shoot()">
<div id='user' style="display:none"><?php 
echo $_SESSION['user'];
?></div>
<div id='score' style="display:none">
<?php 
$file="./userdata/".$_SESSION['user']."/score.txt";
$fh = fopen($file, 'r');
$theScore = fread($fh, filesize($file));
fclose($fh);

echo $theScore;

?>
</div>

<div id='vsize' style="display:none">
<?php 
$EachWordDir="./userdata/".$_SESSION['user']."/word/*.*";
$WordCount=0;
foreach(glob($EachWordDir) as $filename1)
{
	$WordCount++;
}

echo $WordCount;

?>
</div>


<div id='ranking' style="display:none">
<?php 
echo $_SESSION['ranking'];
?>
</div>
	
 <script type="text/javascript">
     if (top.location !== self.location)
         top.location = self.location;
</script>

<style type="text/css">
           html,body {
			background-color: #25272b;
			background-image: url('');
			background-position: 54px 105px;
			background-attachment: fixed;
			background-repeat: no-repeat;
			color: #00ff00;
			font-family: helvetica, arial, sans-serif;
			margin: 0;
			padding: 0;
			font-size: 12pt;
		}
		
		#canvas {
			border: 1px solid #555;
			position: absolute;
			left: 0;
			top: 0;
			width: 360px;
			height: 640px;
			background-color: #000;
			z-index:10;
		}
		
		#game {
			position: absolute;
			left: 0;
			right: 0;
			top: 0;
			bottom: 0;
			margin: auto;
			width: 360px;
			height: 640px;
		}
        </style>
<script type="text/javascript">
	
    function shoot() {
    	
        L.module('zyinxin').requires('game.main').defines(function() {
            R.StartGame();
        });
    }
</script>


   
<!--script src="http://code.jquery.com/jquery-latest.js"></script-->
<script src="./js/jquery-latest.js"></script>
<script src="./js/WebResource.js" type="text/javascript"></script>

    		
    		<div style="position: absolute; z-index: 10; top: 90px; left: 20px; background-color: #25272b; height: 52px;">
    		<canvas id="canvas2">
    		<span>This game is based on HTML5<br>Please download <a href="http://www.google.com/chrome" target="_blank">chrome</a> to play this game</span></canvas>
    		</div>

	<div id="game"> 
	
		<canvas id="canvas" width="360" height="640"> 
		</canvas> 
		

    </div>



</body></html>
