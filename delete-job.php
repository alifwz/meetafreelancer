<?php

session_start();
include "connection.php";
mysql_query("DELETE from freelancer_mmv_work WHERE work_id='" . trim($_GET['id']) . "'");
$_SESSION['status'] = "jobdelete";
header("Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/listing.php");
exit;
?>