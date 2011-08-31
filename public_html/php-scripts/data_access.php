<?php
  /* Contains methods for adding users to the database */
  require_once('facebook_config.php');		//loads a isLogged() function and $facebook object
  require_once('mysql_connect.php');

function addUser($id,$token,$is_user='true'){
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
	$schoolArr = getSchoolArr($id,$token);

	$res = mysql_query("SELECT is_user,high_school_id,college_school_id,other_school_id FROM people WHERE fb_id='$id'");
		if ($is_user=='true') $token = mysql_real_escape_string($token);
		else $token = '';
	if (mysql_num_rows($res)){
		//if the user exists, only update if the user is just registering
		if ($is_user == 'true'){
		mysql_query("UPDATE people SET gender='$gender', is_user='$is_user',high_school_id='{$schoolArr['High School']['id']}',hs_year='{$schoolArr['High School']['year']}',college_school_id='{$schoolArr['College']['id']}',
		college_year='{$schoolArr['College']['year']}',other_school_id='{$schoolArr['Other']['id']}',other_year='{$schoolArr['Other']['year']}',access_token='$token' WHERE fb_id='$id'");
		}
		else{
			//if the user exists, but is not new, only update, if highschool/college/other information was mis-recorded
			$row = mysql_fetch_array($res);
			if ($row['high_school_id'] == '' && $row['college_school_id'] == '' && $row['other_school_id'] == ''){
				mysql_query("UPDATE people SET high_school_id='{$schoolArr['High School']['id']}',hs_year='{$schoolArr['High School']['year']}',college_school_id='{$schoolArr['College']['id']}',
				college_year='{$schoolArr['College']['year']}',other_school_id='{$schoolArr['Other']['id']}',other_year='{$schoolArr['Other']['year']}' WHERE fb_id='$id'");
		updateSchoolCount($schoolArr['High School']['id']);
		updateSchoolCount($schoolArr['College']['id']);
		updateSchoolCount($schoolArr['Other']['id']);
			}
		}
	}
	else{

		mysql_query("INSERT INTO people (fb_id,first_name,last_name,gender,email,is_user,high_school_id,college_school_id,other_school_id,hs_year,college_year,other_year,access_token) VALUES('$id','$first_name','$last_name','$gender','$email','$is_user',
		'{$schoolArr['High School']['id']}','{$schoolArr['College']['id']}','{$schoolArr['Other']['id']}','{$schoolArr['High School']['year']}','{$schoolArr['College']['year']}','{$schoolArr['Other']['year']}','$token')");
		updateSchoolCount($schoolArr['High School']['id']);
		updateSchoolCount($schoolArr['College']['id']);
		updateSchoolCount($schoolArr['Other']['id']);
	}

}

function getSchoolArr($id,$token){
	//returns array of schoolArr High School, College, and Other
	$user = getUser($id,$token);
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

function checkSchool($id,$name,$type){
	mysqlConnect();
	$name = mysql_real_escape_string($name);
	$type = mysql_real_escape_string($type);
	$res = mysql_query("SELECT * FROM schools WHERE school_id='$id'");
	if (mysql_num_rows($res)){
		return true;
	}
	else{
		mysql_query("INSERT INTO schools (school_id,school_name,school_type,school_count) VALUES('$id','$name','$type','1')");
	}
}

function updateSchoolCount($id){
	if (strlen($id)>0){
	
		$res = mysql_query("SELECT school_count FROM schools WHERE school_id='$id'");
		if (mysql_num_rows($res)){
			$row = mysql_fetch_array($res);
			$count = $row['school_count'];
			try {
					$count = intval($count)+1;
				}
			catch (Exception $e){
					$count = 'google';
				}
			mysql_query("UPDATE schools SET school_count='$count' WHERE school_id='$id'");
		}
	}
}

?>
