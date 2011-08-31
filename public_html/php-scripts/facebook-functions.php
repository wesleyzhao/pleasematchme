<?php
require ('src/facebook.php');
define('FACEBOOK_APP_ID', '146707805383349');
define('FACEBOOK_SECRET', '275a73227a3b12042a857c0fb40c2735');

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '146707805383349',
  'secret' => '275a73227a3b12042a857c0fb40c2735',
  'cookie' => true,
));

$session = $facebook->getSession();

$person = null;
// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $person = $facebook->api("/$uid");
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

function checkLogIn($cookie){
	$con=mysql_connect("184.168.226.38","pennmatch","PennPass123");
	$FBid=$cookie['uid'];
	if (!$con)
		{die('Could not connect: ' . mysql_error());}
	else{
		mysql_select_db("pennmatch",$con);
		$result=mysql_query("SELECT email FROM Users WHERE fb_id='".$FBid."'");
		$exists=mysql_num_rows($result);
		if (!$exists)
			{
			$user=json_decode(file_get_contents(
			'https://graph.facebook.com/'.$FBid.'?access_token='.
			$cookie['access_token']));
			$first_name=$user->first_name;
			$last_name=$user->last_name;
			
			$test=mysql_query("INSERT INTO Users (fb_id,first_name,last_name,email)
			VALUES ('" .$FBid. "','" .$first_name. "','" .$last_name. "','" .$user->email. "')");
			
			makePost();
			}
		else{		//if user has registered and is already logged-in
		
		}
		mysql_close($con);
	}
}
function get_facebook_cookie($app_id, $application_secret) {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . $application_secret) != $args['sig']) {
    return null;
  }
  return $args;
}

function makePost(){
	global $facebook;
	$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
	$token = $cookie['access_token'];
	$id = $cookie['uid'];
	$attachment = array(
		'access_token'=>"$token",
		'message'=>'Choose your favorite possible Penn couples and see who youve been paired with!',
		'link'=>'http://pennmatch.com',
		'picture'=>'http://pennmatch.com/images/pennmatch-logo.png'
	);
	$facebook->api("/$id/feed","POST",$attachment);
}

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