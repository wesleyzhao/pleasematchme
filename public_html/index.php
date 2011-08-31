<!DOCTYPE html>
<?php
	//require_once('page-templates/network_template.php');
	require_once('page-templates/search_networks.php');
	require_once('php-scripts/redirect_scripts.php');
	if (isLogged()){
	?>
	<script type='text/javascript'>toFriends();</script>
	<?php
	}
?>
