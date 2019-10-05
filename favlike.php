<?php
include "connection.php";
$wid=$_POST['id'];

$cheklike_que = mysql_query("UPDATE freelancer_mmv_favourites SET favstatus='1' where id='$wid'");	
$cheklike = mysql_num_rows($cheklike_que);
if($cheklike_que){
	echo "Done";
}
?>