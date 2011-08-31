<?php
require_once('mysql_connect.php');

$id = isLogged();
if ($id){
//if the user is logged on
	$access_token = $facebook->getAccessToken();
	
	mysqlConnect();
	$res = mysql_query("SELECT access_token,is_user FROM people WHERE fb_id='$id'");
	if (mysql_num_rows($res)){
	//if the user exists in table
		$row = mysql_fetch_array($res);
		if ($row['access_token']=='' && $row['is_user']=='true'){
		//if the user has logged on but not tracked their access token
			mysql_query("UPDATE people SET access_token='$access_token',fixed_maybe='yes' WHERE fb_id='$id'");
			$id = escapeshellarg($id);
			$token = escapeshellarg($access_token);
			error_log("php /home/pleasematch/failure-background-task.php $id $token");
			runInBackground("php /home/pleasematch/failure-background-task.php $id $token");
		}
	}
}


function runInBackground($script) {
    $pid = shell_exec("nohup $script >/dev/null 2>&1 & echo $!");
    return $pid;
}

?>