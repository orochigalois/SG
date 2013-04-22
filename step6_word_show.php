<!DOCTYPE html>
<html>

<head>
	<meta charset='UTF-8'>
	
	<title>SG</title> 
	
	
	
	<style>
	* { margin: 0; padding: 0; }
body { font: 14px Georgia, serif; }

article, aside, figure, footer, header, hgroup,
menu, nav, section { display: block; }

#page-wrap { width: 960px; margin: 60px auto; }

h1 { box-shadow: 0 0 20px black; }

		html { background: black; }
		html, body { overflow: hidden; }
		#poster { 
			width: 890px; 
			margin: 30px auto; 
	  		font-family: "newcomen-1","newcomen-2";
 		}
 		#poster h1 {
 			color: white; 
 			background: url(pic/word_show_bg.jpg) 20px -150px no-repeat;
			font-size: 180px;
			line-height: 0.7;
			text-align: center; 
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			letter-spacing: -8px; 
			-webkit-transition: all 2.5s; 
			padding-bottom: 40px; 
		}
 		.step-one #poster h1 {
 			padding-top: 220px; 
 		}
		#poster h1 span { 
			-webkit-transition: all 2.5s;
			-moz-transition: all 2.5s;
			-o-transition: all 2.5s;
		}
		#poster h1 span.char1 { margin-left: -1450px; } 
		#poster h1 span.char2 { margin-left: 200px; }
		#poster h1 span.char3 { margin-left: 200px; }
		#poster h1 span.char5 { margin-left: 1450px; }
		#poster h1 span.char6 { margin-left: 200px; }
		#poster h1 span.char7 { margin-left: 200px; }
		#poster h1 span.char8 { margin-left: 200px; }
		#poster h1 span.char9 { margin-left: 200px; }
		.step-one #poster h1 span { margin: 0; }
 		
 		#poster p { text-align: center; font-size: 30px; letter-spacing: 20px; }
 		#poster p span { position: relative; -webkit-transition: all 2.5s ease; color: white; }
 		.step-two #poster p span { top: 0 !important; left: 0 !important; }
	</style>
	
 <script type="text/javascript" src="js/jquery-latest.js"></script>
	<script src="js/jquery.lettering.js"></script>
	<script>
		
time=0;
	
	$(window).keypress(function(e) {
  if (e.keyCode == 32) {
  	if(time==0)
  		$("#poster h1").html("haha");
	else if(time==1)
		$("#poster h1").html("haha1");
	else if(time==2)
		$("#poster h1").html("haha2");

	time++;
    $("#poster h1, #poster p").lettering();
			$("#poster p span").each(function() {  $(this).css({ top: -(Math.floor(Math.random()*1001)+1500), left: Math.floor(Math.random()*1001)-500,  }); });
			setTimeout(function() {$('html').addClass("step-one");}, 1000);
			setTimeout(function() {$('html').addClass("step-two");}, 3000);
  }
});
	</script>
</head>

<body>

	<div id="poster">
	
		<h1>preserve</h1>
		
		<p>The only way that they can preserve their history is to recount it as sagas</p>
	
	</div>
	
</body>

</html>