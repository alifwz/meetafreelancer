<?php
session_start();
include "connection.php";
$loginid = end($_SESSION[SESS_MEMBER_ID]);
mysql_query("UPDATE freelancer_mmv_chatmsgs SET readstatus='1' WHERE userid='$loginid'");
echo "done";
?>