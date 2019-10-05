<?php
session_start();
include "connection.php";
$wid=$_POST['id'];
	
	$cheklike_que = mysql_query("UPDATE freelancer_mmv_member_like SET readstatus=1 where like_id='$wid'");
	$cheklike = mysql_num_rows($cheklike_que);
		
if($cheklike_que){
	echo "Done";	
}
?>