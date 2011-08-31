<!DOCTYPE html>
<html lang="en">
<head><link rel="stylesheet" href="stylesheet.css" type="text/css"/>
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
<title>PennMatch - Pick A Match!</title>
<body>
<div id ='wrapper'>
	<div id = "header">
		<div id = 'search'><a href='/search'><img src='images/search-button'/></a></div>
		<div class="logo">
			<a href="http://pennmatch.com"><img src="/images/logo.png" alt="PennMatch" id="logo" /></a>
		</div>
	</div>
	<div id="message">
		<p>Play Cupid and pair up your schoolmates</p>
	</div>
	<div id = 'game-container'>
	<div id="container">
		<div id = "left-girl"></div>
		<div id="shuffle-bar">
			<p><a href="javascript:shuffle();" class="shuffle">shuffle</a></p>
				<div id = "match-bar">
					<p><a href="javascript:makeMatch();" class="match">match</a></p>
				</div>
		</div>
	</div>
	<div id = "right-boy">
	</div>
	</div> <!-- end game-container-->
	<div id="instruction">Click on a person to swap them or go wild and shuffle it up!</div>
	<div id = 'bottom-buttons-container'>
		
		<div id = "class-options">
		Play PennMatch with other classes:<br>
			<a href='/frosh'>frosh</a> | <a href='/soph'>soph</a> | <a href='/junior'>junior</a> | <a href='/senior'>senior</a>
			<!--
			<a href='/frosh'><img class = 'class-image' src = 'images/frosh-button.png'/></a>
			<a href='/soph'><img class = 'class-image' src = 'images/soph-button.png'/></a>
			<a href='/junior'><img class = 'class-image' src = 'images/junior-button.png'/></a>
			<a href='/senior'><img class = 'class-image' src = 'images/senior-button.png'/></a>
			-->
		</div>
	</div><!--end buttom-buttons-container-->
	
	<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like show_faces="true" width="450"></fb:like>
	<div id = "footer">
		<div id="picture-logo" align="center">
			<a href='http://pennmatch.com'><img alt='designed by Carthi Mannikarottu' height = '100' src = 'images/pennmatch-logo.png'/></a>
		</div>
		<p>Copyright &copy; 2011 <a href="/about">Wesley Zhao</a>, design by <a href="http://about.me/sarah_lim">Sarah Lim</a> & <a href="http://about.me/ajaymehta">Ajay Mehta</a></p>
		</div>
</div><!--end wrapper-->

	</body>
	<?php
	include_once("php-scripts/js-functions.php");
?>

</html>