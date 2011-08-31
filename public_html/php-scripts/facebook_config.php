<?php
require('src/facebook.php');

$facebook = new Facebook(array(
	'appId' => '189850771044039',		//specific to PleaseMatchMe
	'secret' => 'e251e98d27aa86cfd32fc6c175167169',		//specific to PleaseMatchMe
	'cookie' => true,
	));

function isLogged(){
//reads the global $facebook variable
//returns the user fb_id if the user is signed on, else returns false
	global $facebook;
	$session = $facebook->getSession();
	if ($session){
		try{
			$uid = $facebook->getUser();
			$person = $facebook->api("/$uid");
			return $uid;
		}
		catch (FacebookApiException $e){
			return false;
		}
	}
	else{
		return false;
	}
}

function isRegistered($id){
	$con = mysql_connect('localhost','pleasematch','PleasePass123');
	mysql_select_db('pleasematch',$con);
	$res = mysql_query("SELECT is_user FROM people WHERE fb_id='$id'");
	if (mysql_num_rows($res)){
		$row = mysql_fetch_array($res);
		if ($row['is_user']=='true'){
			return true;
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}

function getUser($uid,$token=''){
global $facebook;
	$user = $facebook->api("/$uid",array('access_token'=>$token));
	return $user;
}

define('FACEBOOK_APP_ID', '189850771044039');
?>
   <div id="fb-root"></div>
   <script src="http://connect.facebook.net/en_US/all.js"></script>
   <script>
     FB.init({appId: '<?= FACEBOOK_APP_ID ?>', status: true,
              cookie: true, xfbml: true});
     FB.Event.subscribe('auth.login', function(response) {
       window.location.reload();
     });
   </script>