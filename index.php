<?php 
include_once('./common.php');
/***Check if user exists*/
$isUserOK=false; 
foreach(glob('./userdata/*') as $filename){
	if(substr(strrchr($filename,"/"),1)==$_GET["user"])
		$isUserOK=true;
}
if(!$isUserOK)
	die("user not found");
$_SESSION['user']=$_GET["user"];

/***Prepare ScoreArray,score=(Times of type) * (Count of words__must_have_sounds)*/
$ScoreArray=array();
foreach(glob('./userdata/*') as $filename){
	$EachWordDir = $filename.'/word/*.*';
	$TmpCount=0;
	foreach(glob($EachWordDir) as $filename1)
	{
		$TmpCount++;
	}
	$myFile = $filename.'/score.txt';
	$fh = fopen($myFile, 'r');
	$theData = fread($fh, filesize($myFile));

	$theData=strval(intval($theData)*intval($TmpCount));
	$ScoreArray[substr(strrchr($filename,"/"),1)]=$theData.'/'.substr(strrchr($filename,"/"),1);
	fclose($fh);
}


function my_sort($a, $b)
{
	$a_value=intval(substr($a,0,strpos($a,'/')));
	$b_value=intval(substr($b,0,strpos($b,'/')));
	if ($a_value == $b_value) return 0;
	return ($a_value > $b_value) ? 1 : -1;
}
  
usort($ScoreArray, "my_sort");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en"><head>

<title>SG</title> 
<style type="text/css"> 
 
html, body { width: 800px; }
 
dt.reflect { color: #333333; border-bottom: 6px solid #DDDDDD; line-height: .2em; margin: 0; padding:0 0 0 10px; 
font-size: 150%; }

 
h3.line_drop { font-family:"Trebuchet MS", Garamond, Georgia; line-height: .88em; border-bottom: #990000 1px solid; 
color: #990000;
letter-spacing: -2px; }
 
h3.elegant { letter-spacing: -2px; font-family:Georgia, "Times New Roman", Times, serif; font-weight: 100; font-size: 
200%; text-shadow: #666666 0.2em 0.2em; }
 

p.handwriting { font-style: italic; font-weight: 100; font-family: "Comic Sans MS"; letter-spacing: 1px; font-size: 
100%; word-spacing: .25em; }
 
h3.hide { font-size: 150%; font-weight: 100; line-height: .4em; border-bottom: 7px solid #FFFF66; }
 
h3.capital { font-size: 375%; text-transform: uppercase; letter-spacing: -8px; }
h3.capital span { font-size: 70%; text-transform: lowercase; letter-spacing: -1px;}
 
 
p.letters { line-height: .64em; letter-spacing: -2px; font-family: "Courier New", Courier, monospace; font-size: 25px
; font-weight: 100; text-transform: uppercase;}
 
p.letters2 { line-height: .72em; letter-spacing: -2px; font-family: "Times New Roman", Times, serif; font-size: 25px; 
font-weight: 100; text-transform: uppercase;}
 
p.letters3 { line-height: .77em; letter-spacing: -2px; font-family: Georgia, "Times New Roman", Times, serif; font-
size: 25px; font-weight: 100; text-transform: uppercase;}
 
h3.newspaper { letter-spacing: .10em; font-size: 36px; text-transform: uppercase; font-weight: 100; border-bottom: 
groove 2px #CCCCCC; width: auto; line-height: 1em; }
 
h3.newspaper span { font-family: Georgia, "Times New Roman", Times, serif; }
 
h3.newspaper2 { letter-spacing: .10em; font-size: 36px; font-weight: 100; border-bottom: groove 2px #CCCCCC; width: 
auto; line-height: 1em; font-variant: small-caps;}
 
h3.funky { font-family: "Trebuchet MS", Garamond, Georgia; font-size: 36px;letter-spacing: 20px; line-height: .65em; 
color: #666666; font-weight: 100;}
h3.funky span { letter-spacing: 5px;}
 
h3.el { font-family: Verdana, Arial, Helvetica, sans-serif; color: #BBBBBB; border-bottom: #CCCCCC 1px solid; letter-
spacing: 1em; font-weight: 100; line-height: .8em; font-size: 9px;}
 
h3.num_blend { font-size: 36px; font-weight: 100;}
 
h3.num_blend span { font-size: 24px; line-height: 1em; font-style: italic; font-weight: bold; letter-spacing: 2px;}
 
h3.scaps { font-variant: small-caps; letter-spacing: -1px; font-size: 200%; font-family: "Courier New", Courier, 
monospace; font-weight: 100;}
 
h3.gr { font-size: 500%; margin: 0; float: left; color: #999999; font-family: Impact, Arial, Verdana; text-transform: 
uppercase; border-bottom: #CC0000 10px solid; font-weight: 100; }
h3.gr2 { font-size: 500%; margin: 25px 0;color: #999999; float: left; font-family: Impact, Arial, Verdana; text-
transform: uppercase; position: relative; font-weight: 100; }
 
h3.g { font-size: 500%; font-family: Georgia, "Times New Roman", Times, serif; font-weight: 100; float: left; margin: 
0; color: #133BC1; }
h3.o1 { font-size: 500%; font-family: Georgia, "Times New Roman", Times, serif; font-weight: 100; float: left; margin
: 0; color: #E33B21; }
h3.o2 { font-size: 500%; font-family: Georgia, "Times New Roman", Times, serif; font-weight: 100; float: left; margin
: 0; color: #E6B500; }
h3.l { font-size: 500%; font-family: Georgia, "Times New Roman", Times, serif; font-weight: 100; float: left; margin: 
0; color: #4BCE54; }
h3.lg { font-size: 500%; font-family: Georgia, "Times New Roman", Times, serif; font-weight: 100; float: left; margin
: 0; color: #0048E3; }
h3.e { font-size: 500%; font-family: Georgia, "Times New Roman", Times, serif; font-weight: 100; float: left; margin: 
0; color: #E33B21; font-style: italic; }
 
.gray { background: #000000; padding: 20px; }
 
h3.gray2 { font-size: 200%; text-transform: uppercase; font-family: Garamond, Georgia, "Times New Roman"; 
letter-spacing: .5em; font-weight: 100; color: #FFFFFF; border-top: 1px solid #CCCCCC; border-bottom: #CCCCCC 1px 
solid; width: 600px; text-align: center; }
 
h3.fed { color: #660099; letter-spacing: -.08em; font-size: 500%; font-family: Verdana, Arial, Helvetica, sans-serif; }
h3.fed span { color: #999999; margin: 0 0 0 -.1em; font-size: 105%; }
 
h3.y1 { float: left; font-size: 500%; font-family: Garamond, Georgia, "Times New Roman"; text-transform: uppercase; 
margin: 0;
font-weight: 0; color: #FF0000; }
 
h3.y2 { float: left; font-size: 350%; font-family: Garamond, Georgia, "Times New Roman"; text-transform: uppercase; 
margin: 15px 0 0 -10px; font-weight: 0; color: #FF0000; }
 
h3.y3 { float: left; font-size: 350%; font-family: Garamond, Georgia, "Times New Roman"; text-transform: uppercase; 
margin: 8px 0 0px -5px; font-weight: 0; color: #FF0000; }
 
h3.y4 { float: left; font-size: 300%; font-family: Garamond, Georgia, "Times New Roman"; text-transform: uppercase; 
margin: 12px 0 0px -5px; font-weight: 0; color: #FF0000; }
 
h3.y5 { float: left; font-size: 350%; font-family: Garamond, Georgia, "Times New Roman"; text-transform: uppercase; 
margin: 6px 0 0px -1px; font-weight: 0; color: #FF0000; }
 
h3.y6 { float: left; font-size: 350%; font-family: Verdana, Arial, Helvetica, sans-serif; margin: 4px 0 0px -1px; font
-weight: 0; color: #FF0000; }
 
p.tag a { font-size: 85%; text-align: center; color: #FF3300; }
p.tag a:hover { background: #FFFF66; }
 
</style>
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.progressbar.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
<?php
    for ($i = count($ScoreArray)-1; $i >=0; $i--)
    {
    	echo '$("#pb'.$i.'").progressBar({ showText: false});';
    }
    ?>
	
});
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}
function FirstIn(user)
{
	var whichFile,fightingURL,picURL,downWordURL,downSentenceURL,accent,showURL,cloudURL;
	accent=$('input[name="RadioGroup"]:checked').val();
	whichFile=document.getElementById("selectFile").value;
	picURL="/SG/step3_choose_picture.php?URL=./userdata/"+user+"/upload"+whichFile;
	fightingURL="/SG/step4_fighting.php?URL=./userdata/"+user+"/upload"+whichFile+"&ACCENT="+accent;
	showURL="/SG/step6_word_show.php?URL=./userdata/"+user+"/upload"+whichFile;
	cloudURL="/SG/step7_cloud.php?URL=./userdata/"+user+"/upload"+whichFile;
	downWordURL="/SG/step5_download_word.php?URL=./userdata/"+user+"/upload"+whichFile;
	downSentenceURL="/SG/step5_download_sentence.php?URL=./userdata/"+user+"/upload"+whichFile;
	document.getElementById("picURL").setAttribute('href',"JavaScript:newPopup('"+picURL+"');");
	//document.getElementById("picURL").innerHTML=picURL;
	document.getElementById("fightingURL").setAttribute('href',fightingURL);
	document.getElementById("showURL").setAttribute('href',showURL);
	document.getElementById("cloudURL").setAttribute('href',cloudURL);
	//document.getElementById("fightingURL").innerHTML=fightingURL;
	document.getElementById("downWordURL").setAttribute('href',downWordURL);
	document.getElementById("downSentenceURL").setAttribute('href',downSentenceURL);
}
function ChangeUrl(user)
{
	var whichFile,fightingURL,picURL,downWordURL,downSentenceURL,accent,showURL,cloudURL;
	accent=$('input[name="RadioGroup"]:checked').val();
	whichFile=document.getElementById("selectFile").value;
	picURL="/SG/step3_choose_picture.php?URL=./userdata/"+user+"/upload"+whichFile;
	fightingURL="/SG/step4_fighting.php?URL=./userdata/"+user+"/upload"+whichFile+"&ACCENT="+accent;
	showURL="/SG/step6_word_show.php?URL=./userdata/"+user+"/upload"+whichFile;
	cloudURL="/SG/step7_cloud.php?URL=./userdata/"+user+"/upload"+whichFile;
	downWordURL="/SG/step5_download_word.php?URL=./userdata/"+user+"/upload"+whichFile;
	downSentenceURL="/SG/step5_download_sentence.php?URL=./userdata/"+user+"/upload"+whichFile;
	document.getElementById("picURL").setAttribute('href',"JavaScript:newPopup('"+picURL+"');");
	
	//document.getElementById("picURL").innerHTML=picURL;
	document.getElementById("fightingURL").setAttribute('href',fightingURL);
	document.getElementById("showURL").setAttribute('href',showURL);
	document.getElementById("cloudURL").setAttribute('href',cloudURL);
	//document.getElementById("fightingURL").innerHTML=fightingURL;
	document.getElementById("downWordURL").setAttribute('href',downWordURL);
	document.getElementById("downSentenceURL").setAttribute('href',downSentenceURL);
}

			
			
</script>		
</head> 

<body onload=FirstIn(<?php echo '"'.$_SESSION['user'].'"';?>)>
	
<h3 class="g">F</h3><h3 class="o1">o</h3><h3 class="o2">r</h3><h3 class="l">&nbspS</h3><h3 class="o2">h
</h3> <h3 class="e">e</h3><h3 class="o2">l</h3><h3 class="l">l</h3><h3 class="e">e</h3>
<h3 class="g">y</h3>
 
<br style="clear: both;" /> 
<br style="clear: both;" /> 

 <dl>
      <dt class="reflect">Ranking</dt> 
     
      <dd> 
        <table>
        <?php 
        $BarArray=array();
        $TopScore=0;
        for ($i = count($ScoreArray)-1; $i >=0; $i--) 
		{
			
			$eachScore=substr($ScoreArray[$i],0,strpos($ScoreArray[$i],'/'));
			
			if($i == count($ScoreArray)-1)
				$TopScore=intval($eachScore);
			if($TopScore!=0)
				$BarArray[count($ScoreArray)-$i-1]=intval($eachScore)*100/$TopScore;
			else
				$BarArray[count($ScoreArray)-$i-1]=0;
			
			
		}
        for ($i = count($ScoreArray)-1; $i >=0; $i--) 
		{
			$eachUser=substr(strrchr($ScoreArray[$i],"/"),1);
			if($_SESSION['user']==$eachUser)
				$_SESSION['ranking']=count($ScoreArray)-$i;
			$eachScore=substr($ScoreArray[$i],0,strpos($ScoreArray[$i],'/'));
			
			echo '<tr><td><p class="handwriting">'.$eachUser.'</p> </td><td><span class="progressBar" id="pb'.$i.'">'.$BarArray[count($ScoreArray)-$i-1].'%</span>'.$eachScore.'</td></tr>';
			
		}
		?>	
				</table>
        
      </dd> 
    </dl> 
    <br style="clear: both;" /> 
    <dl>
      <dt class="reflect">Step.1 upload word file</dt> 
      
      <dd> 
      <p class="handwriting">1.Prepare your word file like this:</p> 
			<img src="pic/demo.jpg"  alt="This is a demo" />
			<p class="handwriting">2.Now you can upload it</p>
      <form action="step1_upload_file.php" method="post"
enctype="multipart/form-data">

<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form>
        
       
      </dd> 
    </dl> 
    <br style="clear: both;" /> 

    <dl>
      <dt class="reflect">Step.2 choose an input file</dt> 
      
      <dd>
      <p class="handwriting">
      <select id='selectFile' ONCHANGE=ChangeUrl(<?php echo '"'.$_SESSION['user'].'"';?>)>
            
            
            <?php
                foreach(glob('./userdata/'.$_SESSION['user'].'/upload/*.txt') as $filename){
                ?>
                    <option value="<?php echo strrchr($filename,"/"); ?>">
                                         <?php echo strrchr($filename,"/");?>
                    </option>
                <?php
                }
                ?>
            </select>
        </p>
      </dd> 
    </dl> 
    <br style="clear: both;" /> 
    
    <dl>
      <dt class="reflect">Step.3 choose demonstrational pictures for your words</dt> 
      
      <dd>

        <p class="handwriting"><a id='picURL' href="">Go!</a></p> 
        
      </dd> 
    </dl> 
    <br style="clear: both;" /> 

	<dl>
      <dt class="reflect">Step.4 choose accent</dt> 
      
      <dd>
<p class="handwriting">
        <input type="radio" name="RadioGroup" value="1" checked="checked" ONCLICK=ChangeUrl(<?php echo '"'.$_SESSION['user'].'"';?>) />British Accent
<input type="radio" name="RadioGroup" value="2" ONCLICK=ChangeUrl(<?php echo '"'.$_SESSION['user'].'"';?>) />American Accent
</p> 
        
      </dd> 
    </dl> 
    <br style="clear: both;" /> 
    

    <dl>
      <dt class="reflect">Step.5 fighting!</dt> 
     
      <dd> 
        <p class="handwriting"><a id='fightingURL' href="">Go!</a></p> 
        
      </dd> 
    </dl> 
    <br style="clear: both;" /> 

	<dl>
      <dt class="reflect">Bonus.1 download word/sentence sound(for dictation)</dt> 
     
      <dd> 
        <p class="handwriting"><a id='downWordURL' href="">word</a></p> 
        
      </dd> 
      <dd> 
        <p class="handwriting"><a id='downSentenceURL' href="">sentence</a></p> 
        
      </dd>
    </dl> 
    <br style="clear: both;" /> 
    <dl>
      <dt class="reflect">Bonus.2 words show</dt> 
      <dd> 
      <p class="handwriting"><a id='showURL' href="">Go!</a></p> 
        
      </dd> 
      
    </dl> 
    <br style="clear: both;" /> 

	<dl>
      <dt class="reflect">Bonus.3 synonymic cloud</dt> 
      <dd> 
      <p class="handwriting"><a id='cloudURL' href="">Go!</a></p> 
        
      </dd> 
      
    </dl> 
    <br style="clear: both;" /> 

    

    

</body></html>