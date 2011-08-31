<?php
require_once('php-scripts/mysql_connect.php');

function getWelcomeBar($id,$url){
	if ($id){
		$user = getUser($id);
		$name = $user['name'];
		$network = getNetworkName($url);
		if ($network) $append = "(Current Network Play: $network)";
		else $append = "(Current Network Play: Your Friends)";
		return "Welcome, <a href='profile.php?id=$id' alt='PleaseMatchMe Profile - $name'>$name</a> $append";
	}
	else{
		//$name = getNetworkName($url);
		//return "Currently <b>only</b> playing in the $name Network. <fb:login-button perms='email,user_education_history,friends_education_history,offline_access,publish_stream'></fb:login-button> to play with <b>YOUR NETWORK & FRIENDS.</b>";
		return '';
	}
}

function getNetworkName($url){
	mysqlConnect();
	$res = mysql_query("SELECT school_name,school_url FROM schools WHERE school_id = '$url'");
	$res2 = mysql_query("SELECT school_name FROM schools WHERE school_url ='$url'");
	if (mysql_num_rows($res)){
		$row = mysql_fetch_array($res);
		$name = $row['school_name'];
	}
	else if (mysql_num_rows($res2)){
		$row2 = mysql_fetch_array($res2);
		$name = $row2['school_name'];
	}
	return $name;
}

function getNetworks($id,$url){
		$start = '<div id = "networks">';
		$end = '</div>';
	if ($id){
		
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
	
	//$html = $start."<a href='/friends'>Friends</a> | Network play is currently under construction. Check back in a bit!".$end;
		return $html;
	
	}
	else{
		$name = getNetworkName($url);
		return $start."Currently <b>only</b> playing in the $name Network.<br><fb:login-button perms='email,user_education_history,friends_education_history,offline_access,publish_stream'></fb:login-button> to play with <b>YOUR NETWORK & FRIENDS.</b>".$end;
	}
}



?>