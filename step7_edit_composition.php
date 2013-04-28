<?php
	$myFile=$_GET["URL"];
   if(isset($_POST['BtnSubmit']))
   {

		if(!file_exists($myFile))
		{
			$fp=fopen("$myFile", "w+");
			if ( !is_writable($myFile) ){
		      die("文件:" .$myFile. "不可写，请检查！");
			}
			fwrite($fp, $_POST['UserComposition']);
			fclose($fp);  
		
		}
		else
			file_put_contents($myFile, $_POST['UserComposition']);
			echo "<script>window.close();</script>";
   }

	
	if(!file_exists($myFile))
		$theData="";
	else
	{
		$fh=fopen($myFile, 'r');
		$theData=fread($fh, filesize($myFile));
		fclose($fh);
		$theData=trim($theData);
	}
	

?>
<style>
code
{
	color: #d14;
	background-color: rgb(240, 250, 5);
	border: 1px solid #e1e1e8;
}
</style>
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script>

var wordlist;
window.onload = function(){
  wordlist=$("#wordlist").html();
};

window.onunload = function(){
  window.opener.location.reload();
  window.opener.$('#selectFile')[0].selectedIndex=3;
};



$(function () {

function eliminateDuplicates(arr) {
	var i,
	len=arr.length,
	out=[],
	obj={};

	for (i=0;i<len;i++) {
		obj[arr[i]]=0;
	}
	for (i in obj) {
		out.push(i);
	}
	return out;
}
$('#MyComposition').bind('input propertychange', function() {

		var words_myself =this.value.split(/[,.\r!\n?:()\/ -]/);
		var words=wordlist.split(", ");
		words_myself=eliminateDuplicates(words_myself);
		for (i = 0; i < words_myself.length; ++i)
	  	{
			for (j = 0; j < words.length; ++j)
	  		{
				if(words_myself[i].toLowerCase()==words[j].toLowerCase())
					words[j]="<code>"+words[j]+"</code>";
			}

			
			
	  	}
		var result="";
		for (j = 0; j < words.length; ++j)
  		{
			result+=words[j]+", ";
		}
		$("#wordlist").html(result);
	  
});
});
</script>
<h2>Write a composition using these words:</h2>
<?php
	$result="";
	$fh=fopen($_GET["WURL"], 'r');
	$wordData=fread($fh, filesize($_GET["WURL"]));
	fclose($fh);
	$wordData=trim($wordData);
	$rows=explode( "\n", $wordData);

	for ($i = 0; $i < count($rows); $i++) 
	{
		$columns = explode("...", $rows[$i]);
		
		$word=strtolower($columns[0]);
		$result=$result.$word.", ";
		
	}
	
	$result=substr($result,0,-2);
	echo "<p id='wordlist'>".$result."</p>";
?>
<form name="UserInformationForm" method="POST" action="#">
      
      <textarea name="UserComposition" id="MyComposition" rows="19" cols="77"><?php echo $theData; ?></textarea>
      <br/><br/>
      <input name="BtnSubmit" type="submit" value="Submit">
</form>
