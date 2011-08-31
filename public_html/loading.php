<!DOCTYPE html>
<html lang="en">
<head><link rel="stylesheet" href="main.css" type="text/css"/>
<meta charset=utf-8>
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
<?php 
include_once('php-scripts/facebook_config.php');
require_once('php-scripts/redirect_scripts.php');
require_once('php-scripts/essential.php');
?>
	<div id = 'wrapper'>
	<div id = "header">
	  <?php echo getHeader();?>
	</div> <br> <br>
	<h2 align = 'center'>
	Currently loading information about your network, this should take just a few seconds.</h2> <br>
	
	<h3 align = "center"><img src='images/loading-gif.gif' alt='loading...' /></h3><br>
	<h4 align="center">We'll just load a few friends for now, and you can match them up as the rest go through our servers. <br> <br>
	Stick around, Mr./Mrs. Popular. Maybe it wouldn't take as long if you weren't so cool.
	<br><br>
	Patience is a virtue.</h4>
	<h3 align = 'center'>Please enjoy this entertaining SNL Sketch (featuring the Bergs - Zucker, Eisen, and Sam) during the wait.</h3>
	<iframe title="YouTube video player" class="youtube-player" align='center' type="text/html" width="640" height="390" src="http://www.youtube.com/embed/uzELUzfx7oc" frameborder="0" allowFullScreen></iframe>
	</div>
	<div id = "footer">
			<?php echo getFooter();?>
	</div>
	
</div><!--end wrapper-->
	</body>
	<?php
	require_once('php-scripts/redirect_scripts.php');
	?>
<script type="text/javascript">
function register(id,token){
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
				toFriends();
			}
		}
		xmlhttp.open("GET","php-scripts/register_scripts.php?fb_id="+id+"&access_token="+token,true);
		xmlhttp.send();
	}
<?php
	$id = isLogged();
	if ($id){
		if (isRegistered($id)){
?>
toFriends();
<?php
		}		//end if isRegistered
		else{
		$token = $facebook->getAccessToken();
	echo 'var fb_id = '  .  json_encode($id)  .  ";\n";
	echo 'var access_token = '  .  json_encode($token)  .  ";\n";
?>
register(fb_id,access_token);
<?php
		}		//end if isRegistered ELSE
	}		//end if $id
	else{
?>
toHome();
<?php }	//end else ?>


</script>
</html>
<?php
?>