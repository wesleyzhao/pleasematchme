<?php
/* Background Task: This script is intended to be invoked by the web
 * front-end; it should be called as a background process. It should
 * probably not be in the web directory to prevent users from
 * accidentally running it. See
 * http://nsaunders.wordpress.com/2007/01/12/running-a-background-process-in-php/
 */
require_once('public_html/php-scripts/mysql_connect.php');		//allow mysqlConnect() function
require_once('public_html/php-scripts/facebook_config.php');		//load $facebook object and functions
// Do a long-running task

$ID = $argv[1];
$TOKEN = $argv[2];
/*
echo backgroundAddFriends($ID,$TOKEN);
*/
$token = '189850771044039|778bef820e615bb45a949600-1576770095|U3Q1-YvwS5yiRgU_Ie-pMePNhkQ';


$person = $facebook->api("/$ID/friends?access_token=$TOKEN");
$user = getUser('1576770095');
echo $person['data'];



?>