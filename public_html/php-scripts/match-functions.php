<?php
require('mysql_connect.php');		//loads a mysqlConnect() function that provides a connection
//to local mySQL table pleasematch

$method = $_GET['method'];
$type = $_GET['type'];

if (strlen($type)==0){
	$type = 'friends';
}

handleCall($method);

function handleCall($met){
	if ($met=='allGuys'){
		echo json_encode(getAllOf('male'));
	}
	else if ($met == 'allGirls'){
		echo json_encode(getAllOf('female'));
	}
	else if ($met == 'match'){
		makeMatch($_GET['guyID'],$_GET['guyName'],$_GET['girlID'],$_GET['girlName']);
	}
	else if ($met == 'click'){
		addClick();
	}
}

function getAllOf($gender){
	//returns an array of ALL FBids of guys
	global $type;
	mysqlConnect();
	$genders = array();
	if ($type == 'school'){
		$url = $_GET['url'];
		$schoolNameArr = array();
		$schoolIdArr = array();
		
		$schools = mysql_query("SELECT school_id,school_url FROM schools");
		if (mysql_num_rows($schools)){
			while ($row = mysql_fetch_array($schools)){
				$schoolIdArr[] = $row['school_id'];
				$schoolNameArr[$row['school_url']] = $row['school_id'];
			}
			if (in_array($url,$schoolIdArr)){
				$school_id = $url;
			}
			else if (array_key_exists($url,$schoolNameArr)){
				$school_id = $schoolNameArr[$url];
			}
			else{
				$school_id = '112520115426955';		//default is Penn
			}
		}
		else{
			$school_id = '112520115426955';		//default to Penn
		}
		
		$people =mysql_query("SELECT fb_id,first_name,last_name FROM people WHERE gender='$gender' AND (high_school_id='$school_id' OR college_school_id='$school_id' OR other_school_id='$school_id')");
		while ($row = mysql_fetch_array($people)){
			$genders[$row['fb_id']]=$row['first_name'].' '.$row['last_name'];
		}
	}
	else{
		//if friends was the selected type
		$fb_id = $_GET['fb_id'];
		$people = mysql_query("SELECT friend2_id,friend2_name FROM friends WHERE friend1_id = '$fb_id' AND friend2_gender='$gender'");
		while ($row = mysql_fetch_array($people)){
			$genders[$row['friend2_id']]=$row['friend2_name'];
		}
	}
	return $genders;
}

function addClick(){
	mysqlConnect();
	mysql_query("INSERT INTO clicks (name) VALUES ('')");
}

function makeMatch($guyID,$guyName,$girlID,$girlName){
	mysqlConnect();
	mysql_query("INSERT INTO matches (match1_id,match1_name,match2_id,match2_name) VALUES('$guyID','$guyName','$girlID','$girlName')");
	return true;
}
?>