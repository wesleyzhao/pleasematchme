<?php
/* Background Task: This script is intended to be invoked by the web
 * front-end; it should be called as a background process. It should
 * probably not be in the web directory to prevent users from
 * accidentally running it. See
 * http://nsaunders.wordpress.com/2007/01/12/running-a-background-process-in-php/
 */
require_once('public_html/php-scripts/mysql_connect.php');		//allow mysqlConnect() function
require_once('public_html/php-scripts/facebook_config.php');	//load $facebook object and functions
require_once('public_html/php-scripts/data_access.php');      //load addUser method
// Do a long-running task
$ID = $argv[1];		//THE FIRST ARG IS THE FILE!!! WOW
$TOKEN = $argv[2];

echo backgroundAddFriends($ID,$TOKEN);


// Write the output somewhere
file_put_contents("/tmp/background-script-output-" . date("c") . ".txt", "Success! Got these arguments: " . implode(" ", $argv));

function backgroundAddFriends($id,$token){
	global $facebook;
	mysqlConnect();
	$user = getUser($id,$token);
	$name = $user['name'];
	$gender = $user['gender'];

	$person = $facebook->api("/$id/friends?access_token=$token");
	$friends = $person['data'];
	$min = 0;
	for ($i = $min; $i<count($friends) ; $i++){
		$friend = $friends[$i];
		addUser($friend['id'],$token,'false');
		//$fr = getUser($friend['id'],$token);
		//$fr_gender = $fr['gender'];
		//mysql_query("INSERT INTO friends (friend1_id,friend2_id,friend1_name,friend2_name,friend1_gender,friend2_gender) VALUES('$id','{$friend['id']}','$name','{$friend['name']}','$gender','$fr_gender')");
	}
}

?>
