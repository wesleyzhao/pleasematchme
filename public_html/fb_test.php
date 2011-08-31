<html>
<head></head>
<title>FB Test</title>


<body>
<?php
error_reporting(E_ALL);
echo 'here';
echo 'here5';
try{
require('src/facebook.php');
}
catch (Exception $e){
	echo 'error: '.$e;
}
echo 'here4';
$facebook = new Facebook(array( 
	'appId' => '189850771044039',
	'secret' => 'e251e98d27aa86cfd32fc6c175167169',
	'cookie' => true,
	
	));
echo 'here3';
function isLogged(){
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
echo 'hereLogged';
if (isLogged()) {
	$ref = $facebook->getLogoutUrl();
	$log = "log-out";
	echo 'is logged in here';
}	
else{
	$ref = $facebook->getLoginUrl(array(
		'req_perms'=>'user_location,friends_location'
	));
	$log = 'log-in';
	echo 'is logged out here';
}

echo "<a href='$ref'>$log</a>";
echo 'here2';
if (isLogged()){
	$uid = isLogged();
	
	echo "<br>uid: $uid";
	$token = $facebook ->getAccessToken();
	//$friends = json_decode(file_get_contents("https://graph.facebook.com/$uid/friends?access_token=$token")->data;
	echo "<br>access token:$token";
	
	/*
	$attach = array(
		'access_token'=>"$token",
		'message'=>"Hello there sir",
		'name'=>'The Post From Hell',
		'link' =>'http://pennmatch.com',
		'description'=>'Click and stuff',
		'picture'=>'http://pennmatch.com/images/pennmatch-favicon.png');
	$facebook->api('/ajaymehta/feed','POST',$attach);
	*/
	
	$user = $facebook->api("/$uid?$token");
	$loc = $user['location']['name'];
	
	$person = $facebook->api("/$uid/friends");
	$friends =$person['data'];
	
	$count =strval(count($friends));
	
	echo "<br>friends count: $count";
	$num = 0;
	
	for ($i = 0;$i<50;$i++){
	//foreach ($friends as $fr){
	$fr = $friends[$i];
		echo "<br><b>name</b>: {$fr['name']}, <b>id</b>: {$fr['id']}";
		
$friend = $facebook->api("/{$fr['id']}?access_token=$token");
		
		$frLoc = $friend['location']['name'];
		if ($frLoc){
			echo '<ul>';
			echo "location:".$frLoc
			echo '</ul>';
		}
		else{
			echo '<br><i>location info is really private</i>';
		}
		
	}
	
	/*
	foreach ($friends as $fr){
		echo "<br><b>name</b>: {$fr['name']}, <b>id</b>: {$fr['id']}";
	}
	*/
	
}
else{
	$person = $facebook->api("/prestonmui");
	$gender = $person['gender'];
	$name = $person['name'];
	echo "<br>name: {$person['name']}, gender: {$person['gender']}";
}
?>


</body>
</html>