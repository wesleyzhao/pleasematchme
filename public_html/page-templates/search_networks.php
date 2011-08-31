<!DOCTYPE html>
<html lang="en">
<head><link rel="stylesheet" href="main.css" type="text/css"/>
<link rel = "stylesheet" href = "search.css" type = "text/css" />
<meta charset=utf-8>
<link rel="icon" 
      type="image/png" 
      href="/images/favicon.png" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12978591-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<title>Search & Find Different Networks - PleaseMatch.Me</title>
<body>
<?php include_once('php-scripts/facebook_config.php');
include_once('php-scripts/redirect_scripts.php');
include_once('php-scripts/essential.php');
include_once('php-scripts/failure_scripts.php');
?>
<div id = 'wrapper'>
    <div id = "header">
		<?php echo getHeader();?>
	</div>
	
    <div id="searching" align='center'><br><br><br>
    <h3 align = 'center'> Find your school </h3>
	
     <input type="text" id="keywords" align='center' name="keywords" value="Start typing a school name to search" onfocus="javascript:this.value=''" onkeyup="javascript:doResults(this.value)" size=20 maxlength="20"/>
	 </div>
	<div id = "submit_taken"><!--<input type="submit" value="OK"/>--></div>
            <!--<a href="#" class="close" title="close window">x</a>-->
	<div id ='results-container-networks'>
		<div id ='results-of-container'>
		</div>
		<h4 align='center'><?php echo getSearchNetworkLogin(isLogged());?></h4>
	</div>
<?php //echo getRegSearch();?>


</div><!--end wrapper-->
	<div id = "footer">
		<?php echo getFooter(); ?>
	</div>
	
	</body>
<script type="text/javascript">
	
	function doResults(keywords){
		if (keywords.length<3)
		{ 
			document.getElementById("results-of-container").innerHTML="";
			return;
		}
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
			{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("results-of-container").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","php-scripts/search-functions_networks.php?keywords="+keywords,true);
		xmlhttp.send();
		document.getElementById("results-of-container").innerHTML='<img src="images/loading-gif.gif" alt="loading"/>';
	}
</script>
</html>
<?php
?>
