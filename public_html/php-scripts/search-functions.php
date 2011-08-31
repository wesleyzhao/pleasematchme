<?php
	require_once('mysql_connect.php');
	$table = 'people';
	$names = array();
	$ids =array();
	
	mysqlConnect();
	
	$result = mysql_query("SELECT first_name,last_name,fb_id FROM $table");
	if (mysql_num_rows($result)){
		while ($row = mysql_fetch_array($result)){
			$name = $row['first_name'].' '.$row['last_name'];
			$names[]= $name;
			$ids[$name] = $row['fb_id'];
		}
	}
		
	$search = $_GET['keywords'];
	
	if (strlen($search)>0){
		$hint = '';
		$matches = array();
		for ($i = 0; $i<count($names); $i++){
			if (stristr($names[$i],$search)){
				$matches[] = $names[$i];
			}
		}
		
		if (count($matches)>0){
			echo getResults($matches);
		}
		
		else{
			echo 'no results found';
		}
	}
	else{
		echo '';
	}
	
	function getResults($nameArr){
		$html = '';
		$start = '<div class = "result-containter">';
		$end = '</div>';
		
		foreach ($nameArr as $name){
			$html = $html.getResult($name);
		}
		
		return $start.$html.$end;
	}
	
	function getResult($name){
		global $ids;
		$id = $ids[$name];
		$pic = getPicture($id,'square');
		
		$html = '';
		$start = "<div class = one-result>";
		$end = "</div>";
		$html = "<a href='profile.php?id=$id'><img class = 'result-image' src='$pic'/></a><div class='result-name'><a href='profile.php?id=$id'>".$name."</a></div>";
		return $start.$html.$end;
		
	}
	
	function getPicture($id,$size='normal'){
		return "http://graph.facebook.com/$id/picture?type=$size";
	}
?>