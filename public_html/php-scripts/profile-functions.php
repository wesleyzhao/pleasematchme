<?php
	require_once('mysql_connect.php');
	require_once('facebook_config.php');
	
	function getName($id){
		mysqlConnect();
		
		$peopleRes =  mysql_query("SELECT first_name,last_name FROM people WHERE fb_id='$id'");
		if (mysql_num_rows($peopleRes)){
			$nameRow = mysql_fetch_array($peopleRes);
			return $nameRow['first_name'].' '.$nameRow['last_name'];
		}
		else{
			return 'The Dude/tte';
		}
	}
	
	function setGlobalId($fb_id){
		global $id;
		$id = $fb_id;
	}
	
	function getPicture($id,$size='normal'){
		return "http://graph.facebook.com/$id/picture?type=$size";
	}
	
function getWelcomeBar(){
	global $facebook;
	$id = isLogged();
	if ($id){
		$user = getUser($id);
		$name = $user['name'];
		return "Welcome, <a href='profile.php?id=$id' alt='PleaseMatchMe Profile - $name'>$name</a>";
	}
	else{
		return "<fb:login-button perms='email,user_education_history,friends_education_history,offline_access,publish_stream'></fb:login-button> to play with <b>your</b> network and friends.";
	}
}

	function getFacebookPost($id){
	global $facebook;
	$start = "";		//"<div id='post-to'>";
	$end = "";			//"</div>";
	$uid = isLogged();
		if ($uid){
			$token = $facebook->getAccessToken();
			$name = getName($id);
			if ($uid == $id){
				$html = "<a href='javascript:toPost($uid,$id)'>WTF, mate? Tell your buddies about your crazy matches!</a>";
			}
			else{
				mysqlConnect();
				$res = mysql_query("SELECT friend2_name FROM friends WHERE friend1_id='$uid' AND friend2_id='$id'");
				if (mysql_num_rows($res)){
				$html = "<a href='javascript:toPost($uid,$id)'>Tell $name you found their matches on PleaseMatchMe</a>";
				}
				else{
					$html ="<a href='http://www.facebook.com/profile.php?id=$id' target='_blank' alt='Facebook Profile'>Interested? Curious? Find them on Facebook</a>";
				}
			}
		}
		else{
			$html = '';
		}
		return $start.$html.$end;
	}
	
	function getMatchesArr($id,$name,$toFill){
		//creates an array with the id that matches as a key, and the count of matches as the value
		//e.g. $dict = [001=>5,002=>3,1234324=>1,etc]
		//returns the dictionary sorted with the highest count first
		$keys = array_keys($toFill);
		if (in_array($id,$keys)){
			$toFill[$id]['count']=$toFill[$id]['count']+1;
		}
		else{
			$toFill[$id] = array('count'=>1,'name'=>$name);
		}
		
		return $toFill;
	}
	function cmp($a,$b){
		if ($a['count']>$b['count']) return -1;
		else if ($a['count']==$b['count']) return 0;
		else return 1;
	}
	function listMatches(){
		global $id,$table;
		$html ='';
		$start = "<div id ='matches-container'>";
		$end = "</div>";
		$arr = array();
		mysqlConnect();
		$matchesRes = mysql_query("SELECT match2_id,match2_name FROM matches WHERE match1_id='$id'");
		$matchesRes2 = mysql_query("SELECT match1_id,match1_name FROM matches WHERE match2_id='$id'");
		if (mysql_num_rows($matchesRes)){
			while ($row = mysql_fetch_array($matchesRes)){
				$arr = getMatchesArr($row['match2_id'],$row['match2_name'],$arr);
			}
		}
		if (mysql_num_rows($matchesRes2)){
			while ($row = mysql_fetch_array($matchesRes2)){
				$arr = getMatchesArr($row['match1_id'],$row['match1_name'],$arr);
			}
		}
	
		if (count($arr)>0){
			uasort($arr,'cmp');
			foreach ($arr as $key=>$count){
				$picHTML = getPicture($key,'large');
				$name = $count['name'];
				$add = "<div class = 'one-match'><img class='match-image' src='$picHTML'/><div class = 'match-name'><a href='profile.php?id=$key'>$name</a></div><div class='match-count'>Times matched: {$count['count']}</div></div>";
				$html=$html.$add;
			}
		}
		else{
			$html = '<div class="one-match">This person has not been matched yet.<br><br><br><br><br><br><img class="match-image"/><div class="match-name"></div><div class="match-count"></div></div>';
		}
		return $start.$html.$end;
	}
	
	function getMainBar(){
		global $id;
		$html = '';
		$start = '<div id ="profile-bar">';
		$end ='</div>';
		$hformat = '<h2>';
		$hformatend = '</h2>';
		$name = getName($id);
		$picHTML = getPicture($id,'large');
		$add = "<div id = 'profile-name'>$name's matches</div><img class = 'profile-image' src='$picHTML' />";
		$html = $hformat.$html.$add.$hformatend;
		return $start.$html.$end;
	}
?>
<script type='text/javascript'>
function toPost(owner, profile){
		if (window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();
		}
		else{
			xmlhttp=new ActiveXOBject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				document.getElementById('post-to').innerHTML="Posted!";
				}
		}
		xmlhttp.open("GET","php-scripts/post_to_fb.php?owner_id="+owner+"&friend_id="+profile+"&token="+'<?=$facebook->getAccessToken()?>',true);
		xmlhttp.send();	
}
</script>
