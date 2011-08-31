<?php
	require_once('mysql_connect.php');
	$table = 'schools';
	$names = array();
	$ids =array();
	$counts = array();
	
	mysqlConnect();
	
	$search = $_GET['keywords'];
	$result = mysql_query("SELECT school_id,school_name,school_count FROM $table WHERE school_name LIKE '%$search%'");
	if (mysql_num_rows($result)){
		while ($row = mysql_fetch_array($result)){
			$name = $row['school_name'];
			$id = $row['school_id'];
			$count = $row['school_count'];
			if (!$names[$name]){
				$names[$name]= 1;
				$ids[$name] = $id;
				$counts[$name] = $count;
			}
			else{
				$num = $names[$name]+1;
				$name=$name." ($num)";
				$names[$name]= $num;
				$ids[$name] = $id;
				$counts[$name] = $count;
			}
			
		}
	}
		
	
	
	if (strlen($search)>0){
		$matches = array();
		foreach ($names as $name=>$key){
			if (stristr($name,$search)){
				$id = $ids[$name];
				$num = $counts[$name];
				if (!$num) $num = 0;
				$min_count = 10;
				if ($num>=$min_count){
					$matches[$name]=$num;
				}
			}
		}
		
		
		if (count($matches)>0){
			arsort($matches);
			echo getResults($matches);
		}
		
		else{
			echo 'no results found';
		}
	}
	else{
		echo '';
	}
	
	function cmp($a,$b){
		if ($a['count']>$b['count']) return -1;
		else if ($a['count']==$b['count']) return 0;
		else return 1;
	}
	
	function getResults($nameArr){
		$html = '';
		$start = '<div class = "result-containter">';
		$end = '</div>';
		
		foreach ($nameArr as $name=>$count){
			$html = $html.getResult($name,$count);
		}
		
		return $start.$html.$end;
	}
	
	function getResult($name,$count){
		global $ids,$names;
		$id = $ids[$name];
		$pic = getPicture($id,'square');
		
		$html = '';
		$start = "<div class = one-result>";
		$end = "</div>";
		if ($count > 45){
			$html = "<div class='result-name-network'><a href='$id'>".$name." (count: $count)</a><br></div>";
		}
		else{
			$html = "<div class='result-name-network'>".$name." (<i>Please log-in to activate this school</i>)<br></div>";
		}
		return $start.$html.$end;
		
	}
	
	function getPicture($id,$size='normal'){
		return "http://graph.facebook.com/$id/picture?type=$size";
	}
?>