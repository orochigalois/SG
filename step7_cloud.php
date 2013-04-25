<?php
include_once('./common.php');
if(!$_SESSION['user'])
	die("user not found");
?>
<html>
<meta charset='UTF-8'>
        <title>SG</title>
        <style>
       
		</style>
    <script src="js/tagcanvas.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      window.onload = function() {
        try {
			var o = {
  textFont: 'Arial, Helvetica, sans-serif', maxSpeed: 0.05, minSpeed: 0.01,
  textColour: '#900', textHeight: 25, outlineMethod: 'colour',
  outlineColour: '#039', outlineOffset: 0, depth: 0.97, minBrightness: 0.2,
  wheelZoom: false, reverse: true, shadowBlur: 2, shuffleTags: true,
  shadowOffset: [1,1], stretchX: 1.7, initial: [0,0.1]
};
			
			var s = (new Date).getTime() / 360;
  o.initial[0] = 0.2 * Math.cos(s);
  o.initial[1] = 0.2 * Math.sin(s);

  TagCanvas.Start('myCanvas','tags',o);
          
        } catch(e) {
          // something went wrong, hide the canvas container
          document.getElementById('myCanvasContainer').style.display = 'none';
        }
      };
    </script>
  </head>
  <body>
    <h1>TagCanvas example page</h1>
    <div id="myCanvasContainer">
      
      <canvas id="myCanvas" width="580" height="250" style="">
	
        <p>Anything in here will be replaced on browsers that support the canvas element</p>
      </canvas>
    </div>
    <div id="tags">
      <ul>
        <li><a href="http://www.google.com" target="_blank">Google</a></li>
        <li><a href="/fish">Fish</a></li>
        <li><a href="/chips">Chips</a></li>
        <li><a href="/salt">Salt</a></li>
        <li><a href="/vinegar">Vinegar</a></li>
      </ul>
    </div>
  </body>

</html>