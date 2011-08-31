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
<title>Search & Find Your Matches - PleaseMatch.Me</title>
<body>
<?php include_once('php-scripts/facebook_config.php');
include_once('php-scripts/redirect_scripts.php');
include_once('php-scripts/essential.php');
?>
<?php
	if (isLogged()){
		if (!isRegistered(isLogged())){
		?>
<script type='text/javascript'>toLoading();</script>
		<?php
		}
	
?>

<div id = 'wrapper'>
    <div id = "header">
		<?php echo getHeader();?>
	</div>
	<div id="searching">
    <h3 > Search for yourself and find your matches... or look up your friends: </h3>
     <input type="text" id="keywords" name="keywords" value="Start typing a name to search" onfocus="javascript:this.value=''" onkeyup="javascript:doResults(this.value)" size=20 maxlength="20"/>
	 </div>
	<div id = "submit_taken"><!--<input type="submit" value="OK"/>--></div>
            <!--<a href="#" class="close" title="close window">x</a>-->
	<div id ='results-container'>
		
	</div>
	<?php echo getNetworkSearch();?>
<?php
	} //end if
	else{
		?>
	<div id = 'wrapper'>
	<div id = "header">
		<?php echo getHeader();?>
	</div>
	<div id="searching">
	<h3> Log in with Facebook to see who you've been set up with!</h3> </div>
	<br><br>
	<p align="center"><fb:login-button perms="email,user_education_history,friends_education_history,offline_access,publish_stream"></fb:login-button></p>
	<br>
	</div>
		<?php
	}
?>


</div><!--end wrapper-->
	<div id = "footer">
		<?php echo getFooter(); ?>
	</div>
	
	</body>
<script type="text/javascript">
	
	function doResults(keywords){
		if (keywords.length<2)
		{ 
			document.getElementById("results-container").innerHTML="";
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
				document.getElementById("results-container").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","php-scripts/search-functions.php?keywords="+keywords,true);
		xmlhttp.send();
		document.getElementById("results-container").innerHTML="<img src='images/loading-gif.gif' alt='loading...' />";
	}
</script>
</html>
<?php
?>
