<?php
require_once('facebook_config.php');		//loads a isLogged() function and $facebook object
require_once('mysql_connect.php');

$access_token = $argv[2];//$_GET['access_token'];
$fb_id = $argv[1];//$_GET['fb_id'];

addUser($fb_id,$access_token);
	$id = escapeshellarg($fb_id);
	$token = escapeshellarg($access_token);
	error_log("php /home/pleasematch/background-task_test.php $id $token");
	runInBackground("php /home/pleasematch/background-task_test.php $id $token");

addFriends($fb_id,$access_token);
makePost($fb_id,$access_token);
echo 'done';

function addUser($id,$token,$is_user='true'){
global $facebook;
mysqlConnect();
	$user = $facebook->api("/$id?access_token=$token");
	$first_name = mysql_real_escape_string($user['first_name']);
	$last_name = mysql_real_escape_string($user['last_name']);
	$gender = mysql_real_escape_string($user['gender']);
	try{
		$email = mysql_real_escape_string($user['email']);
	}
	catch(Exception $e){
		$email = '';
	}
	$schoolArr = getSchoolArr($id,$token);

		if ($is_user=='true') $token = mysql_real_escape_string($token);
		else $token = '';
	$res = mysql_query("SELECT is_user,high_school_id,college_school_id,other_school_id FROM people_test WHERE fb_id='$id'");
	if (mysql_num_rows($res)){
		if ($is_user == 'true'){
		mysql_query("UPDATE people_test SET gender='$gender', is_user='$is_user',high_school_id='{$schoolArr['High School']['id']}',hs_year='{$schoolArr['High School']['year']}',college_school_id='{$schoolArr['College']['id']}',
		college_year='{$schoolArr['College']['year']}',other_school_id='{$schoolArr['Other']['id']}',other_year='{$schoolArr['Other']['year']}',access_token='$token' WHERE fb_id='$id'");
		}
		else{
			$row = mysql_fetch_array($res);
			if ($row['high_school_id'] == '' && $row['college_school_id'] == '' && $row['other_school_id'] == ''){
				mysql_query("UPDATE people_test SET high_school_id='{$schoolArr['High School']['id']}',hs_year='{$schoolArr['High School']['year']}',college_school_id='{$schoolArr['College']['id']}',
				college_year='{$schoolArr['College']['year']}',other_school_id='{$schoolArr['Other']['id']}',other_year='{$schoolArr['Other']['year']}' WHERE fb_id='$id'");
			}
		}
	}
	else{

		mysql_query("INSERT INTO people_test (fb_id,first_name,last_name,gender,email,is_user,high_school_id,college_school_id,other_school_id,hs_year,college_year,other_year,access_token) VALUES('$id','$first_name','$last_name','$gender','$email','$is_user',
		'{$schoolArr['High School']['id']}','{$schoolArr['College']['id']}','{$schoolArr['Other']['id']}','{$schoolArr['High School']['year']}','{$schoolArr['College']['year']}','{$schoolArr['Other']['year']}','$token')");
	}

}


function getSchoolArr($id,$token){
	//returns array of schoolArr High School, College, and Other
	$user = getUser2($id,$token);
	$education = $user['education'];
	$schoolArr = array();
		$hasHS = false;
		$hasCol = false;
	$schoolArr['High School']=array('id'=>'', 'name'=>'', 'year'=>'');
	$schoolArr['College']=array('id'=>'', 'name'=>'', 'year'=>'');
	$schoolArr['Other']=array('id'=>'', 'name'=>'', 'year'=>'');
	if ($education){
	//if the user has displayed his/her education information
		foreach ($education as $school){
			if ($school['type'] == 'High School' && !$hasHS){
				$schoolArr['High School'] = array('id'=>$school['school']['id'], 'name'=>mysql_real_escape_string($school['school']['name']), 'year'=>$school['year']['name']);
				$hasHS = true;
				checkSchool($school['school']['id'],$school['school']['name'],'High School');
			}
			else if ($school['type'] == 'College' && !$hasCol){
				$schoolArr['College'] = array('id'=>$school['school']['id'], 'name'=>mysql_real_escape_string($school['school']['name']), 'year'=>$school['year']['name']);
				$hasCol = true;
				checkSchool($school['school']['id'],$school['school']['name'],'College');
			}
			else{
				$schoolArr['Other'] = array('id'=>$school['school']['id'], 'name'=>mysql_real_escape_string($school['school']['name']), 'year'=>$school['year']['name']);
				checkSchool($school['school']['id'],$school['school']['name'],$school['type']);
			}
		}	//end for $education loop
	}	//end if $education
	return $schoolArr;
}

function getUser2($uid,$token=''){
global $facebook;
  echo "\n";
  echo $uid;
  echo "\nAPP TOKEN: ";
  echo $token;
  echo "\n";
	$user = $facebook->api("/$uid", array('access_token' => $token));
	echo implode(" ",$user['education']);
	echo "\n";
	return $user;
}

function checkSchool($id,$name,$type){
	mysqlConnect();
	$name = mysql_real_escape_string($name);
	$type = mysql_real_escape_string($type);
	$res = mysql_query("SELECT * FROM schools WHERE school_id='$id'");
	if (mysql_num_rows($res)){
		return true;
	}
	else{
		mysql_query("INSERT INTO schools (school_id,school_name,school_type) VALUES('$id','$name','$type')");
	}
}

function addFriends2($id,$token){
	global $facebook;
	mysqlConnect();
	$user = getUser($id,$token);
	$name = $user['name'];
	$gender = $user['gender'];

	$person = $facebook->api("/$id/friends?access_token=$token");
	$friends = $person['data'];

	foreach ($friends as $friend){
		addUser($friend['id'],$token,'false');
		$fr = getUser($friend['id'],$token);
		$fr_gender = $fr['gender'];
		mysql_query("INSERT INTO friends_test (friend1_id,friend2_id,friend1_name,friend2_name,friend1_gender,friend2_gender) VALUES('$id','{$friend['id']}','$name','{$friend['name']}','$gender','$fr_gender')");
	}
}

function addFriends($id,$token){
	global $facebook;
	mysqlConnect();
	$user = getUser($id,$token);
	$name = $user['name'];
	$gender = $user['gender'];

	$person = $facebook->api("/$id/friends?access_token=$token");
	$friends = $person['data'];
	$limit = 25;
	if (count($friends)<25){
		$limit = count($friends);
	}
	for ($i = 0; $i<$limit ; $i++){
		$friend = $friends[$i];
		addUser($friend['id'],$token,'false');
		$fr = getUser($friend['id'],$token);
		$fr_gender = $fr['gender'];
		mysql_query("INSERT INTO friends_test (friend1_id,friend2_id,friend1_name,friend2_name,friend1_gender,friend2_gender) VALUES('$id','{$friend['id']}','$name','{$friend['name']}','$gender','$fr_gender')");
	}
	/*
	if (count($friends)>40){
		$id = escapeshellarg($id);
		$token = escapeshellarg($token);
		runInBackground("php home/pleasematch/background-task.php $id $token");
	}
	*/
}

function runInBackground($script) {
    $pid = shell_exec("nohup $script >/dev/null 2>&1 & echo $!");
    return $pid;
}

function makePost($id,$token){
	global $facebook;
	$attachment = array(
		'access_token'=>"$token",
		'message'=>'Fun and Addicting - playing cupid by matching up my friends AND my classmates!',
		'link'=>'http://pleasematch.me',
		'picture'=>'http://pleasematch.me/images/logo_square_75.png'
	);
	$facebook->api("/$id/feed","POST",$attachment);
}



?>