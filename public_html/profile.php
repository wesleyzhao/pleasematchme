<!DOCTYPE html>
<html lang="en">
<head><link rel="stylesheet" href="main.css" type="text/css"/>
<link rel = "stylesheet" href = "profile.css" type = "text/css" />
<script type="text/javascript" src="http://use.typekit.com/ngg8qbw.js"></script>
<meta charset=utf-8>
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
<?php
	include_once("./php-scripts/profile-functions.php");
	include_once("./php-scripts/essential.php");
	$id = $_GET['id'];
	setGlobalId($id);
	
?>
<title>PleaseMatch.Me - <?php echo getName(isLogged());?>'s Profile</title>
<body>
  <div id = "topbar">
    <div id = login_top>
      <?php echo getWelcomeBar();?>
    </div>  
  </div>
<div id ='wrapper'>
	<div id = "header">
		<?php echo getHeader(); ?>
	</div>

	<div id = "inner_wrapper">
	<div id = "left-profile"><?php echo getMainBar();?>
	<div id = "post-to"><?php echo getFacebookPost($id);?>
	</div></div>
	<div id = "right-matches"><div class='one-match'></div><?php echo listMatches();?></div>
	</div>
	
<?php echo getSearch();?>
</div><!--end wrapper--> 

<div id = "footer">
	
	<?php echo getFooter();?>
</div>
	</body>


</html>
