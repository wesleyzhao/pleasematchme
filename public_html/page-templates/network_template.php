<!DOCTYPE html>
<head><link rel="stylesheet" href="main.css" type="text/css"/>
<meta charset=utf-8>
<meta property = "og:image" content = "http://pleasematch.me/images/logo_square.png" />
<link rel="icon" 
      type="image/png" 
      href="/images/favicon.png" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12978591-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<title>PleaseMatch.Me - Pick A Match!</title>
<body>
<?php
require_once('php-scripts/network_functions.php');
require_once('php-scripts/network_template_config.php');
require_once('php-scripts/essential.php');


$uid = isLogged();
?>
<img src = "images/logo_square.png" class ='invis' />
  <div id = "topbar">
    <div id = login_top>
      <?php echo getWelcomeBar($uid,$page);?>
    </div>  
  </div>
<div id ='wrapper'>
	<div id = "header">
	  <?php echo getHeader();?>
		
	</div>
	<div id="message">
		<h2>Play Cupid and pair up your schoolmates</h2>
	</div>
	<?php echo getNetworks($uid,$page);?>
	<div id = 'game-container'>
	
	<div id="container">
		<div id = "left-girl">
		</div>
		<div id="shuffle-bar">
			
				
				<p><a href="javascript:shuffle();" class="shuffle"><span class = "invis">shuffle</span></a></p>
				<div id = "match-bar">
					<p><a href="javascript:makeMatch();" class="match"><span class = "invis">match</span></a></p>
				</div>
				
		</div>
	</div>
	<div id = "right-boy"> 
	</div>
	</div> <!-- end game-container-->
	
	  <div id="instruction">Click on a person to swap them or go wild and shuffle it up!</div>
	<div id = "search-bar"><a href = "search" class = "search">search to find your matches!</a></div>
	<div id = "search-networks-bar"><a href = "search-networks" class = "search">Not your school? Bored of your classmates? Click to search for other schools! </a></div>
	
	<div id = "fb_bar">
	<fb:like show_faces="true" width="450"></fb:like>
	</div>
	
</div><!--end wrapper-->

<div id = "footer">
			
		<?php echo getFooter();?>
		</div>

	</body>


</html>
<?php
require_once('php-scripts/js-functions.php');
?>
