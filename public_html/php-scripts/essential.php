<?php

function getHeader(){
	  return '<h1>PleaseMatch.Me - Pick A Match! Play with networks and friends.</h1><div class="logo">
		<a href="http://pleasematch.me"><img src="images/logo3.png" alt="PleaseMatch.Me" id="logo" border="0"/></a></div>';
}

function getFooter(){
return "<p><!--<img alt='designed by Carthi Mannikarottu' border='0' height = '25' src = 'images/pennmatch-logo.png'/>-->
		  Originally PennMatch. <a href='/about'>About</a> | <a href='mailto:boss@pleasematch.me'>Contact</a> | Copyright &copy; 2011 <a href='http://twitter.com/wesleyzhao'>Wesley Zhao</a>, <a href='http://twitter.com/ajaymehta'>Ajay Mehta</a>, and <a href = 'http://twitter.com/temiri'>Tess Rinearson</a></p>";
}

function getSearch(){
	return '<div id = "search-bar"><a href = "search" class = "search">search to find your matches!</a></div>
	<div id = "search-networks-bar"><a href = "search-networks" class = "search">Bored of your classmates? Click to search for other schools! </a></div>';
}

function getNetworkSearch(){
	return '<div id = "search-networks-bar"><a href = "search-networks" class = "search">Bored of your classmates? search for a specific school! </a></div>';
}

function getRegSearch(){
	return '<div id = "search-bar"><a href = "search" class = "search">search to find your matches!</a></div>';
}

function getSearchNetworkLogin($id){
	if (!$id){
		return "Can't find your school? <fb:login-button perms='email,user_education_history,friends_education_history,offline_access,publish_stream'></fb:login-button> to be the first to add <b>your</b> school.";
	}
	else{
		return "Want to see more schools? <a name='fb_share' type='button' share_url='http://pleasematch.me'>Invite your friends!</a><script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>";
		//return '';
	}
}
?>
