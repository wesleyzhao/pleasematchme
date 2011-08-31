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
	$min = 100;
	for ($i = $min; $i<count($friends) ; $i++){
		$friend = $friends[$i];
		addUser2($friend['id'],$token,'false');
		$fr = getUser($friend['id'],$token);
		$fr_gender = $fr['gender'];
		mysql_query("INSERT INTO friends_test (friend1_id,friend2_id,friend1_name,friend2_name,friend1_gender,friend2_gender) VALUES('$id','{$friend['id']}','$name','{$friend['name']}','$gender','$fr_gender')");
	}
}

function addUser2($id,$token,$is_user='true'){
global $facebook;
mysqlConnect();
$user = getUser($id,$token);
	$first_name = mysql_real_escape_string($user['first_name']);
	$last_name = mysql_real_escape_string($user['last_name']);
	$gender = mysql_real_escape_string($user['gender']);
	try{
		$email = mysql_real_escape_string($user['email']);
	}
	catch(Exception $e){
		$email = '';
	}
	$schoolArr = getSchoolArr2($id,$token);

  echo "\n";
  echo implode("",$schoolArr);
  echo "\n";

	$res = mysql_query("SELECT is_user,high_school_id,college_school_id,other_school_id FROM people WHERE fb_id='$id'");
		if ($is_user=='true') $token = mysql_real_escape_string($token);
		else $token = '';
	if (mysql_num_rows($res)){
		if ($is_user == 'true'){
		mysql_query("UPDATE people SET gender='$gender', is_user='$is_user',high_school_id='{$schoolArr['High School']['id']}',hs_year='{$schoolArr['High School']['year']}',college_school_id='{$schoolArr['College']['id']}',
		college_year='{$schoolArr['College']['year']}',other_school_id='{$schoolArr['Other']['id']}',other_year='{$schoolArr['Other']['year']}',access_token='$token' WHERE fb_id='$id'");
		}
		else{
			$row = mysql_fetch_array($res);
			if ($row['high_school_id'] == '' && $row['college_school_id'] == '' && $row['other_school_id'] == ''){
				mysql_query("UPDATE people SET high_school_id='{$schoolArr['High School']['id']}',hs_year='{$schoolArr['High School']['year']}',college_school_id='{$schoolArr['College']['id']}',
				college_year='{$schoolArr['College']['year']}',other_school_id='{$schoolArr['Other']['id']}',other_year='{$schoolArr['Other']['year']}' WHERE fb_id='$id'");
			}
		}
	}
	else{

		mysql_query("INSERT INTO people (fb_id,first_name,last_name,gender,email,is_user,high_school_id,college_school_id,other_school_id,hs_year,college_year,other_year,access_token) VALUES('$id','$first_name','$last_name','$gender','$email','$is_user',
		'{$schoolArr['High School']['id']}','{$schoolArr['College']['id']}','{$schoolArr['Other']['id']}','{$schoolArr['High School']['year']}','{$schoolArr['College']['year']}','{$schoolArr['Other']['year']}','$token')");
	}

}

function getSchoolArr2($id,$token){
	//returns array of schoolArr High School, College, and Other
	echo $id;
	echo "\n";
	echo $token;
	echo "\n";
	$user = getUser($id,$token);
	echo implode("", $user);
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

?>
