<?php
ini_set('display_errors',0);
error_reporting(0);
$con=mysql_connect("localhost","user123_user16","r6KnZEQrWA");
if(!$con)
{
	die("Connection Unsuccessful ".mysql_error());
}
mysql_set_charset('utf8'); 
mysql_select_db("user123_meet",$con);

//Get the current path
$url = $_SERVER['REQUEST_URI']; 
$parts = explode('/',$url);
$currentpath = $_SERVER['SERVER_NAME'];
for ($i = 0; $i < count($parts) - 1; $i++) {
 $currentpath .= $parts[$i] . "/";
}
$schema = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$urlpath = $schema.$currentpath;
?>