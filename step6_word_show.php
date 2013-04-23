<?php
include_once('./common.php');
if(!$_SESSION['user'])
	die("user not found");
?>
<html>
    
    <head>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
        <meta charset='UTF-8'>
        <title>SG</title>
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
				font-family: 'Tangerine', serif;
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
                letter-spacing: 5px;
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
        </style>
        <script type="text/javascript" src="js/jquery-latest.js"></script>
        <script src="js/jquery.lettering.js"></script>
        <script>
        
		var index=0;
            $(function () {
				
				
                var txt = "<div id=\"poster\"><h1>" + $("tr")[index].children[0].innerHTML + "</h1><p>" + $("tr")[index].children[1].innerHTML + "</p></div>";
				index++;
                $("body").append(txt);

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
                }, 1000);

				
            });


            $(window).keypress(function (e) {
                if (e.keyCode == 32) {


                    $("#poster").remove();
                    $("html").removeClass("step-one");
                    $("html").removeClass("step-two");
                    var txt = "<div id=\"poster\"><h1>" + $("tr")[index].children[0].innerHTML + "</h1><p>" + $("tr")[index].children[1].innerHTML + "</p></div>";
					index++;
					if(index==$("tr").length)
						index=0;
                    $("body").append(txt);
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
                    }, 1000);


                }
            });
        </script>
    </head>
    
    <body>
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
				echo '<tr><td>'.$word_array1[0].
					'</td><td>'.
					$word_array1[1]. '</td></tr>';
			}
			?>
        </table>
    </body>

</html>