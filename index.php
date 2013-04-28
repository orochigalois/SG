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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>SG</title>
        <style>
            * {
                margin: 0;
                padding: 0;
            }
            body {
                font-family: Helvetica, Arial, Sans-Serif;
                background: #2c2c2c url(./pic/bg.jpg) top center no-repeat;
            }
            #page-wrap {
                width: 960px;
                margin: 40px auto;
                overflow: hidden;
            }
            
            h1 {
                font-size: 128px;
                letter-spacing: -1px;
                color: white;
                margin: 0 0 15px 0;
            }
            h1 span {
                color: #1f8cc5;
            }
            h3 {
                font-size: 18px;
                letter-spacing: -1px;
                margin: 0 0 5px 0;
            }
            p, label {
                font-family: Georgia, serif;
                font-style: italic;
                font-size: 18px;
                margin: 4px 0;
            }
            fieldset {
                width: 280px;
                padding: 15px;
                float: left;
                border: none;
                margin: 10px 10px 0 0;
            }
			fieldset#ranking {
                background: #FFF06A;
            }
            fieldset#step_1 {
                background: #b2e7ca;
            }
            fieldset#step_2 {
                background: #b2d9e7;
            }
            fieldset#step_3 {
                background: #e7c7b2;
            }
			fieldset#step_4 {
                background: #FFCCFF;
            }
            legend {
                font-weight: bold;
                font-size: 20px;
                background: white;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                padding: 5px 10px;
                letter-spacing: -1px;
            }
            option {
                padding: 0 5px;
            }
			.uploader{
			position:relative;
			display:inline-block;
			overflow:hidden;
			cursor:default;
			padding:0;
			margin:10px 0px;
			-moz-box-shadow:0px 0px 5px #ddd;
			-webkit-box-shadow:0px 0px 5px #ddd;
			box-shadow:0px 0px 5px #ddd;

			-moz-border-radius:5px;
			-webkit-border-radius:5px;
			border-radius:5px;
			}

			.filename{
			float:left;
			display:inline-block;
			outline:0 none;
			height:32px;
			width:180px;
			margin:0;
			padding:8px 10px;
			overflow:hidden;
			cursor:default;
			border:1px solid;
			border-right:0;
			font:9pt/100% Arial, Helvetica, sans-serif; color:#777;
			text-shadow:1px 1px 0px #fff;
			text-overflow:ellipsis;
			white-space:nowrap;

			-moz-border-radius:5px 0px 0px 5px;
			-webkit-border-radius:5px 0px 0px 5px;
			border-radius:5px 0px 0px 5px;

			background:#f5f5f5;
			background:-moz-linear-gradient(top, #fafafa 0%, #eee 100%);
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#fafafa), color-stop(100%,#f5f5f5));
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fafafa', endColorstr='#f5f5f5',GradientType=0);
			border-color:#ccc;

			-moz-box-shadow:0px 0px 1px #fff inset;
			-webkit-box-shadow:0px 0px 1px #fff inset;
			box-shadow:0px 0px 1px #fff inset;

			-moz-box-sizing:border-box;
			-webkit-box-sizing:border-box;
			box-sizing:border-box;
			}

			.button{
			float:left;
			height:32px;
			display:inline-block;
			outline:0 none;
			padding:8px 12px;
			margin:0;
			cursor:pointer;
			border:1px solid;
			font:bold 9pt/100% Arial, Helvetica, sans-serif;

			-moz-border-radius:0px 5px 5px 0px;
			-webkit-border-radius:0px 5px 5px 0px;
			border-radius:0px 5px 5px 0px;

			-moz-box-shadow:0px 0px 1px #fff inset;
			-webkit-box-shadow:0px 0px 1px #fff inset;
			box-shadow:0px 0px 1px #fff inset;
			}


			.uploader input[type=file]{
			position:absolute;
			top:0; right:0; bottom:0;
			border:0;
			padding:0; margin:0;
			height:30px;
			cursor:pointer;
			filter:alpha(opacity=0);
			-moz-opacity:0;
			-khtml-opacity: 0;
			opacity:0;
			}

			input[type=button]::-moz-focus-inner{padding:0; border:0 none; -moz-box-sizing:content-box;}
			input[type=button]::-webkit-focus-inner{padding:0; border:0 none; -webkit-box-sizing:content-box;}
			input[type=text]::-moz-focus-inner{padding:0; border:0 none; -moz-box-sizing:content-box;}
			input[type=text]::-webkit-focus-inner{padding:0; border:0 none; -webkit-box-sizing:content-box;}



			/* Green Color Scheme ------------------------ */

			.green .button{
			color:#fff;
			text-shadow:1px 1px 0px #6b7735;
			background:#7d8f33;
			background:-moz-linear-gradient(top, #93aa4c 0%, #7d8f33 100%);
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#93aa4c), color-stop(100%,#7d8f33));
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#93aa4c', endColorstr='#7d8f33',GradientType=0);
			border-color:#6b7735;
			}

			.green:hover .button{
			background:#93aa4c;
			background:-moz-linear-gradient(top, #7d8f33 0%, #93aa4c 100%);
			background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#7d8f33), color-stop(100%,#93aa4c));
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#7d8f33', endColorstr='#93aa4c',GradientType=0);
			}

			.Mybutton {
                border: 1px solid #006;
                background: #ccf;
                -moz-border-radius: 2px;
                -webkit-border-radius: 2px;
                border-radius: 4px;
                -moz-box-shadow: 2px 2px 3px #666;
                -webkit-box-shadow: 2px 2px 3px #666;
                box-shadow: 1px 1px 1px #666;
                font-size: 12px;
                padding: 4px 7px;
                outline: 0;
                -webkit-appearance: none;
            }
            .Mybutton:hover {
                border: 1px solid #f00;
                background: #eef;
            }
			code {
			
			color: #d14;
			background-color: rgb(240, 250, 5);
			border: 1px solid #e1e1e8;
			}

            
        </style>
        <script type="text/javascript" src="js/jquery-latest.js"></script>
        <script type="text/javascript" src="js/jquery.progressbar.min.js"></script>
        <script type="text/javascript">

		$(document).ready(function() {
		
		$("input[type=file]").change(function(){$(this).parents(".uploader").find(".filename").val($(this).val());});
		$("input[type=file]").each(function(){
		if($(this).val()==""){$(this).parents(".uploader").find(".filename").val("No file selected...");}
		});
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
		function newPopup1(url) {
			popupWindow = window.open(
				url,'popUpWindow','height=500,width=516,left=300,top=300,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no')
		}
		function FirstIn(user)
		{
			
			$('#selectFile')[0].selectedIndex=<?php 
			if(isset($_GET["s"]))
				echo $_GET["s"];
			else
				echo "0";

			?>
				;
			$('#selectFile').change(function() {
				locArr=location.href.split("&");
			    window.location = locArr[0]+"&s=" + $(this)[0].selectedIndex;
			});
			var whichFile,fightingURL,picURL,downWordURL,downSentenceURL,accent,showURL;
			accent=$('input[name="RadioGroup"]:checked').val();
			whichFile=document.getElementById("selectFile").value;
			picURL="/SG/m3_PICTURE.php?URL=./userdata/"+user+"/upload"+whichFile;
			fightingURL="/SG/m4_SHOOT.php?URL=./userdata/"+user+"/upload"+whichFile+"&ACCENT="+accent;
			showURL="/SG/m6_SYN.php?URL=./userdata/"+user+"/upload"+whichFile;
			
			downWordURL="/SG/m5_DICTATION_download_word.php?URL=./userdata/"+user+"/upload"+whichFile;
			downSentenceURL="/SG/m5_DICTATION_download_sentence.php?URL=./userdata/"+user+"/upload"+whichFile;


		
			document.getElementById("picURL").setAttribute('href',"JavaScript:newPopup('"+picURL+"');");
			document.getElementById("fightingURL").setAttribute('href',fightingURL);
			document.getElementById("showURL").setAttribute('href',showURL);

			document.getElementById("downWordURL").setAttribute('href',downWordURL);
			document.getElementById("downSentenceURL").setAttribute('href',downSentenceURL);
			$.post("m7_X_get_composition.php", {
                        compositionfile: "./userdata/"+user+"/composition"+whichFile,
						wordfile: "./userdata/"+user+"/upload"+whichFile
                    }, function (data, status) {
                    $("#composition").html(data); 
                        });
			$.post("m7_X_get_word_list.php", {
						wordfile: "./userdata/"+user+"/upload"+whichFile
                    }, function (data, status) {
                    $("#wordlist").html(data); 
                        });
		
		}
		function ChangeUrl(user)
		{
			var whichFile,fightingURL,picURL,downWordURL,downSentenceURL,accent,showURL;
			accent=$('input[name="RadioGroup"]:checked').val();
			whichFile=document.getElementById("selectFile").value;
			picURL="/SG/m3_PICTURE.php?URL=./userdata/"+user+"/upload"+whichFile;
			fightingURL="/SG/m4_SHOOT.php?URL=./userdata/"+user+"/upload"+whichFile+"&ACCENT="+accent;
			showURL="/SG/m6_SYN.php?URL=./userdata/"+user+"/upload"+whichFile;
			
			downWordURL="/SG/m5_DICTATION_download_word.php?URL=./userdata/"+user+"/upload"+whichFile;
			downSentenceURL="/SG/m5_DICTATION_download_sentence.php?URL=./userdata/"+user+"/upload"+whichFile;
			
			
			
			document.getElementById("picURL").setAttribute('href',"JavaScript:newPopup('"+picURL+"');");
			
			document.getElementById("fightingURL").setAttribute('href',fightingURL);
			document.getElementById("showURL").setAttribute('href',showURL);
		
			document.getElementById("downWordURL").setAttribute('href',downWordURL);
			document.getElementById("downSentenceURL").setAttribute('href',downSentenceURL);
			$.post("m7_X_get_composition.php", {
                        compositionfile: "./userdata/"+user+"/composition"+whichFile,
						wordfile: "./userdata/"+user+"/upload"+whichFile
                    }, function (data, status) {
                    $("#composition").html(data); 
                        });
			$.post("m7_X_get_word_list.php", {
						wordfile: "./userdata/"+user+"/upload"+whichFile
                    }, function (data, status) {
                    $("#wordlist").html(data); 
                        });
			
		}
		
		</script>

    </head>
    
    <body onload=FirstIn(<?php echo '"'.$_SESSION['user'].'"';?>)>
        <div id="page-wrap">
            	<h1>S<span>G</span></h1>

            
            <fieldset id="ranking">
                    <legend>RANKING</legend>
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
					
					echo '<tr><td><p>'.$eachUser.'</p> </td><td><span class="progressBar" id="pb'.$i.'">'.$BarArray[count($ScoreArray)-$i-1].'%</span>'.$eachScore.'</td></tr>';
					
				}
				?>	
				</table>
                </fieldset>
                
                <fieldset id="step_1">
                    <legend>IMPORT YOUR WORDS</legend>
                    <p>1.Prepare your word file like this:</p> 
					<img src="pic/demo.jpg"  alt="This is a demo" />
					</br>
					</br>
					</br>
					<p>2.Now you can upload it</p>
				    <form action="m2_UPLOAD_FILE.php" method="post"
				enctype="multipart/form-data">

					
					
					<div class="uploader green">
<input type="text" class="filename" readonly="readonly"/>
<input type="button" name="file" class="button" value="Browse..."/>
<input type="file" name="file" id="file" size="30"/>
</div><input type="submit" name="submit" value="Submit" class="Mybutton">

					</form>

				
					</br>
					</br>
					</br>

					<p>3.choose an input file</p>
					<p>
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
			        </br>
					</br>
					</br>
			        <p>***WORD LIST***</p>
			        <p id="wordlist"></p>
                </fieldset>
                
                <fieldset id="step_2">
                    <legend>SHOOTING GAME</legend>
                    <p>1.choose demonstrational pictures for your words</p>
                    <p><a id='picURL' href="">Go!</a></p>
                    </br>
                    <p>2.choose accent</p>
                    <p>
                    <input type="radio" name="RadioGroup" value="1" checked="checked" ONCLICK=ChangeUrl(<?php echo '"'.$_SESSION['user'].'"';?>) />British Accent
<input type="radio" name="RadioGroup" value="2" ONCLICK=ChangeUrl(<?php echo '"'.$_SESSION['user'].'"';?>) />American Accent
					</p>
					</br>
					<p>3.fighting</p>
					<p><a id='fightingURL' href="">Go!</a></p>
					</br>
					<p>Bonus.after 3,you can download word/sentence sound for dictation</p>
					<p><a id='downWordURL' href="">word</a></p>
					<p><a id='downSentenceURL' href="">sentence</a></p> 

						
                    
                </fieldset>
                
                <fieldset id="step_3">
                    <legend>SYNONYM GAME</legend>
                    <p><a id='showURL' href="">Go!</a></p>
                </fieldset>

				<fieldset id="step_4">
                    <legend>COMPOSITION GAME</legend>
                    <p id="composition"></p>
                    
	
                </fieldset>
           
        </div>
    </body>

</html>
