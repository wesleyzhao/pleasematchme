<?php

require_once('php-scripts/facebook_config.php');
require_once('php-scripts/mysql_connect.php');

function getWelcomeBar($id){
	if ($id){
		$user = getUser($id);
		$name = $user['name'];
		return "Welcome, $name";
	}
	else{
		return '<fb:login-button perms="email,user_education_history,friends_education_history,publish_stream"></fb:login-button>';
	}
}

function getNetworks($id){
	if ($id){
		$start = '<div id = "networks">';
		$end = '</div>';
		mysqlConnect();
		$res = mysql_query("SELECT high_school_id,college_school_id,other_school_id FROM people WHERE fb_id = '$id'");
		$row = mysql_fetch_array($res);
		$schoolArr = array($row['high_school_id'],$row['college_school_id'],$row['other_school_id']);
		$html = "<a href='/friends'>Friends</a>";
		foreach ($schoolArr as $school_id){
			if ($school_id >0){
				$res = mysql_query("SELECT school_name,school_url FROM schools WHERE school_id = '$school_id'");
				$row = mysql_fetch_array($res);
				$school_url = $row['school_url'];
				if (strlen($school_url)>0){
					$url = $school_url;
				}
				else{
					$url = $school_id;
				}
				$name = $row['school_name'];
				$html = $html.' | '."<a href='/$url'>$name</a>";
			}
		}
	$html = $start.$html.$end;
		return $html;
	
	}
	else{
		return '';
	}
}



?>