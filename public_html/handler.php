<?php
	$allURLS=array();		//will store all custom_urls
	$schoolURLS = array();
require_once('php-scripts/mysql_connect.php');	
 
 $request = $_SERVER['REQUEST_URI'];
 $exploded = explode('/',$request);	//element 0 should be tasteplug.com
 $customURL = $exploded[1];
 
 mysqlConnect();
$res = mysql_query("SELECT school_id,school_url FROM schools");
 while ($row =mysql_fetch_array($res)){
	$schoolURLS[] = $row['school_id'];
		if (strlen($row['school_url'])>0){
			$schoolURLS[] = $row['school_url'];
		}
 }
 
	if (in_array($customURL,$schoolURLS)){
	//if the customURL typed exists in the database
	//setGlobalUrl($customURL);
	//setArray(getCookie());
		$_GET['type']='school';
		$_GET['url'] = $customURL;
		include_once('page-templates/network_template.php');
	}
			else if ($customURL == 'friends'){
				$_GET['type']='friends';
				$_GET['url'] = $customURL;
				include_once('page-templates/network_template.php');
			}
			else if ($customURL=='about'){
				include_once("page-templates/about.php");
			}
			else if ($customURL == 'search'){
				include_once("page-templates/search.php");
			}
			else if ($customURL == 'search-networks'){
				include_once('page-templates/search_networks.php');
			}
			else{
				$_GET['table']=$customURL;
				include_once("page-templates/not_found.php");
			}
?>