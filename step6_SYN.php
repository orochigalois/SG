<?php
include_once('./common.php');
if(!$_SESSION['user'])
	die("user not found");
?>
<html>
    
    <head>   
        <meta charset='UTF-8'>
        <title>SG</title>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
        <style>
            * {
                margin: 0;
                padding: 0;
            }
            body {
                font: 14px Georgia, serif;
            }
            article, aside, figure, footer, header, hgroup, menu, nav, section {
                display: block;
            }
            #page-wrap {
                width: 960px;
                margin: 60px auto;
            }
            h1 {
                box-shadow: 0 0 20px black;
            }
            html {
                background: black;
            }
            html, body {
                overflow: hidden;
            }
            #poster {
                width: 1090px;
                margin: 30px auto;
            }
            #poster h1 {
                color: white;
                background: url(pic/word_show_bg.jpg) 20px -150px no-repeat;
                line-height: 0.7;
                text-align: center;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: 0px;
                -webkit-transition: all 2.5s;
                padding-bottom: 40px;
                font-family:'Tangerine', serif;
                font-size: 180px;
            }
            .step-one #poster h1 {
                padding-top: 220px;
            }
            #poster h1 span {
                -webkit-transition: all 2.5s;
                -moz-transition: all 2.5s;
                -o-transition: all 2.5s;
            }
            #poster h1 span.char1 {
                margin-left: -1450px;
            }
            #poster h1 span.char2 {
                margin-left: 200px;
            }
            #poster h1 span.char3 {
                margin-left: 200px;
            }
            #poster h1 span.char5 {
                margin-left: 1450px;
            }
            #poster h1 span.char6 {
                margin-left: 200px;
            }
            #poster h1 span.char7 {
                margin-left: 200px;
            }
            #poster h1 span.char8 {
                margin-left: 200px;
            }
            #poster h1 span.char9 {
                margin-left: 200px;
            }
            .step-one #poster h1 span {
                margin: 0;
            }
            #poster p {
                text-align: center;
                font-size: 30px;
                letter-spacing: 2px;
                font-family:'Tangerine', serif;
            }
            #poster p span {
                position: relative;
                -webkit-transition: all 2.5s ease;
                color: white;
            }
            .step-two #poster p span {
                top: 0 !important;
                left: 0 !important;
            }
            .input {
                border: 1px solid #006;
                background: #ffc;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                border-radius: 10px;
                -moz-box-shadow: 2px 2px 3px #666;
                -webkit-box-shadow: 2px 2px 3px #666;
                box-shadow: 2px 2px 3px #666;
                font-size: 20px;
                padding: 4px 7px;
                outline: 0;
                -webkit-appearance: none;
            }
            .input:hover {
                border: 1px solid #f00;
                background: #ff6;
            }
            .button {
                border: 1px solid #006;
                background: #ccf;
                -moz-border-radius: 10px;
                -webkit-border-radius: 10px;
                border-radius: 10px;
                -moz-box-shadow: 2px 2px 3px #666;
                -webkit-box-shadow: 2px 2px 3px #666;
                box-shadow: 2px 2px 3px #666;
                font-size: 20px;
                padding: 4px 7px;
                outline: 0;
                -webkit-appearance: none;
            }
            .button:hover {
                border: 1px solid #f00;
                background: #eef;
            }
            #form {
                display:none;
                margin:auto;
            }
            .step-two #form {
                display:block;
            }
			#R {
                background: url(pic/right.png)  no-repeat;
				height:100px;
				width:100px;
				margin: 30px auto;
				display:none;
            }
			#W {
                background: url(pic/wrong.png)  no-repeat;
				height:100px;
				width:100px;
				margin: 30px auto;
				display:none;
			
            }
        </style>
        <script type="text/javascript" src="js/jquery-latest.js"></script>
        <script src="js/jquery.lettering.js"></script>
        <script src="js/tagcanvas.min.js" type="text/javascript"></script>
        <script>
            var index = 0;
            var syn_arr;
			var CurrentUserScore;
			var CurrentUser;
            $(function () {
				CurrentUserScore=parseInt(document.getElementById("score").innerHTML);
				CurrentUser=document.getElementById("user").innerHTML;

                var txt = "<div id=\"poster\"><h1>" + $("tr")[index].children[0].innerHTML + "</h1><p>" + $("tr")[index].children[1].innerHTML +
                    "</p></div>";

                $("#word").append(txt);

                $("#poster h1, #poster p").lettering();
                $("#poster p span").each(function () {
                    $(this).css({
                        top: -(Math.floor(Math.random() * 1001) + 1500),
                        left: Math.floor(Math.random() * 1001) - 500,
                    });
                });
                setTimeout(function () {
                    $('html').addClass("step-one");
                }, 500);
                setTimeout(function () {
                    $('html').addClass("step-two");
                }, 2000);


                $("#go").click(function () {
                    $('body').css('cursor', 'wait');
                    syn = $("#syn")[0].value;

                    pass = false;

                    $.post("step6_SYN_get_from_bighugelabs.php", {
                        word: $("tr")[index].children[0].innerHTML,


                    }, function (data, status) {
                        $('body').css('cursor', 'default');
                        try {
                            syn_arr = JSON.parse(data);
							for (var i = 0; i < syn_arr.length; i++) {
                            if (syn == syn_arr[i])
                                pass = true;
	                        }
	                        if (pass) {
								$('#W').css({
	                                    display: 'none',
	                                });
								$('#R').css({
	                                    display: 'block',
	                                });
								
								setTimeout(function () {
	                                $('#R').css({
	                                    display: 'none',
	                                });
									CurrentUserScore+=1;
									$.post("step4_update_score_in_game.php", { score: CurrentUserScore, user: CurrentUser } );
		                            index++;
									$("#syn")[0].value="";
									$('#promptButton').css({
		                                    display: 'none',
		                                });
									$('#myCanvasContainer').css({
		                                    display: 'none',
		                                });
		                            $("#poster").remove();
		                            $("html").removeClass("step-one");
		                            $("html").removeClass("step-two");
									if (index == $("tr").length)
		                                index = 0;
		                            var txt = "<div id=\"poster\"><h1>" + $("tr")[index].children[0].innerHTML + "</h1><p>" + $("tr")[index].children[1].innerHTML +
		                                "</p></div>";
		                            
		                            $("#word").append(txt);
		                            $("#poster h1, #poster p").lettering();
		                            $("#poster p span").each(function () {
		                                $(this).css({
		                                    top: -(Math.floor(Math.random() * 1001) + 1500),
		                                    left: Math.floor(Math.random() * 1001) - 500,
		                                });
		                            });
		                            setTimeout(function () {
		                                $('html').addClass("step-one");
		                            }, 500);
		                            setTimeout(function () {
		                                $('html').addClass("step-two");
		                            }, 2000);
	                            }, 1000);
								
	                        } else {
	                        	$('#promptButton').css({
	                                    display: 'inline',
	                                });
								$('#W').css({
	                                    display: 'block',
	                                });
								
//								setTimeout(function () {
//	                                $('#W').css({
//	                                    display: 'none',
//	                                });
//	                            }, 1000);
								
	                            
								
	                        }
                        } catch (err) {
                            txt = "There was an error on this page.\n\n";
                            txt += "Error description: " + err.message + "\n\n";
                            txt += "Click OK to continue.\n\n";
                            alert(txt);
                        }



                    });
                });



                $("#promptButton").click(function () {
					$('#W').css({
	                                display: 'none',
	                            });
					$('#myCanvasContainer').css({
                                    display: 'block',
                                });

                    $("#tags").remove();
                    var txt = "<div id=\"tags\"><ul>";
                    for (var i = 0; i < syn_arr.length; i++) {
                        txt = txt + "<li><a href=\"http://dict.cn/"+syn_arr[i]+"\">" + syn_arr[i] + "</a></li>"
                    }
                    txt = txt + "</ul></div>";
                    $("body").append(txt);



                    try {
                        var o = {
                            textFont: 'Arial, Helvetica, sans-serif',
                            maxSpeed: 0.05,
                            minSpeed: 0.01,
                            textColour: '#fff',
                            textHeight: 25,
                            outlineMethod: 'colour',
                            outlineColour: '#039',
                            outlineOffset: 0,
                            depth: 0.97,
                            minBrightness: 0.2,
                            wheelZoom: false,
                            reverse: true,
                            shadowBlur: 2,
                            shuffleTags: true,
                            shadowOffset: [1, 1],
                            stretchX: 1.7,
                            initial: [0, 0.1]
                        };

                        var s = (new Date).getTime() / 360;
                        o.initial[0] = 0.2 * Math.cos(s);
                        o.initial[1] = 0.2 * Math.sin(s);

                        TagCanvas.Start('myCanvas', 'tags', o);

                    } catch (e) {
                        // something went wrong, hide the canvas container
                        document.getElementById('myCanvasContainer').style.display = 'none';
                    }




                });


            });


            $(window).keypress(function (e) {
                if (e.keyCode == 13) {
                    $("#go").click();
                }
            });
        </script>
    </head>
    
    <body>
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
        <table style="display:none">
            <?php
            $myFile=$_GET["URL"];
			$fh=fopen($myFile, 'r');
			$theData=fread($fh, filesize($myFile));
			fclose($fh);
			$theData=trim($theData);
			$word_array=explode( "\n", $theData);
			for ($i=0 ; $i < count($word_array); $i++)
			{
				$word_array1=explode( "...", $word_array[$i]);
		
				$url="http://www.stands4.com/services/v2/defs.php?uid=2773&tokenid=abbiMdmcWrNIqRFu&word=".$word_array1[0];
				
				$data=curl_return_string($url);
				$str=strstr($data,'<definition>');
				$str1=substr($str,0,strpos($str,"</definition>"));
				$defination=substr($str1,12);

				echo '<tr><td>'.$word_array1[0].
					'</td><td>'.
					$defination. '</td></tr>';
			}
			?>
        </table>
        <div id="word"></div>
        <div align="center" id="form">
        
            <input type="text" placeholder="Type a synonym" id="syn" class="input" />
            <input type="submit" value="Go" id="go" class="button" />
            <input type="submit" value="Prompt" id="promptButton" class="button" style="display:none"/>
        </div>
        <div id="W"></div>
        <div id="R"></div>
        <div id="myCanvasContainer" align="center">
        
            <canvas id="myCanvas" width="580" height="250" style="">
                <p>Anything in here will be replaced on browsers that support the canvas element</p>
            </canvas>
        </div>
    </body>

</html>