<?php
	require('php-scripts/redirect_scripts.php');
	//loads toHome() and toFriends() redirect JS functions
	require ('php-scripts/facebook_config.php');
	//loads a global $facebook variable and a isLogged() function
?>
<script type="text/javascript">
<?php
	$uid = isLogged();
		$page = $_GET['url'];
		$type = $_GET['type'];
		if ($uid && !$page){
		?>
		toFriends();
		<?php
		}
		if (!$page) $page = 'penn';
		if (!$type) $type = 'school';
	
	if ($page == 'friends' && !$uid){
	//send the user to index page if friends was requested, and s/he was not logged on
		?>
		toHome();
		<?php
	}
	if ($uid && !isRegistered($uid)) {
	?>
	toLoading();
	<?php
	}
	//if code reaches here, user should be logged on
	echo 'var fb_id = '  .  json_encode($uid)  .  ";\n";
	echo 'var url = '  .  json_encode($page)  .  ";\n";
	echo 'var type = '  .  json_encode($type)  .  ";\n";
	//set php GET variables to JavaScript
?>
</script>