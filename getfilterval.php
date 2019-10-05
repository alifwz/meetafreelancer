<?php
session_start();
include "connection.php";
$catval = $_REQUEST[categoryId];
$_SESSION[SESS_CAT_ID]=$catval;
$filter_query = mysql_query("SELECT * FROM freelancer_mmv_filter WHERE status='1' AND filter_id='$catval'");
$filter_res = mysql_fetch_array($filter_query);
echo $filter_res[title];
?>