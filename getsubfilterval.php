<?php
session_start();
include "connection.php";
$catval = $_REQUEST[subcategoryId];

if($_SESSION[SESS_SUBCAT_ID]!=""){
	unset($_SESSION['SESS_CAT_ID']); 
	unset($_SESSION['SESS_SUBCAT_ID']); 
	unset($_SESSION['SESS_CAT_NAME']); 
}
	
	//$_SESSION[SESS_SUBCAT_ID]=$catval;

	$web_que = mysql_query("SELECT * from freelancer_mmv_filter where filter_id='$catval' AND status='1'");
	$web_res = mysql_fetch_array($web_que);
	$catid = $web_res[parent_id];

	$_SESSION[SESS_CAT_ID]=$catid;

	$web_que1 = mysql_query("SELECT * from freelancer_mmv_filter where filter_id='$catid' AND status='1'");
	$web_res1 = mysql_fetch_array($web_que1);

	$catname = $web_res1[title];

	echo $_SESSION[SESS_CAT_NAME] = $catname;

?>