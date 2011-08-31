<?php
require_once('facebook_config.php');

$uid = $_GET['owner_id'];
$id =$_GET['friend_id'];
$token = $_GET['token'];

if ($uid == $id){
				$attach = array(
				'access_token'=>"$token",
				'message'=>"WTF? I'm matched with some weird people....",
				'name'=>"PleaseMatchMe astonishes me",
				'link' =>"http://pleasematch.me/profile.php?id=$id",
				'description'=>'PleaseMatch.Me - Play Cupid and match up your friends or your classmates!',
				'picture'=>'http://pleasematch.me/images/logo_square_75.png');
				$facebook->api("/$id/feed",'POST',$attach);
}
else{
				$attach = array(
				'access_token'=>"$token",
				'message'=>"Teehee! I just saw your matches on PleaseMatchMe. <3",
				'name'=>"You've got matches!",
				'link' =>"http://pleasematch.me/profile.php?id=$id",
				'description'=>'PleaseMatch.Me - Play Cupid and match up your friends or your classmates!',
				'picture'=>'http://pleasematch.me/images/logo_square_75.png');
				$facebook->api("/$id/feed",'POST',$attach);
	}
echo 'done!';
?>