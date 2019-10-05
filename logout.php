<?php
session_start();
$uid = $_REQUEST['id'];

//session_destroy();

foreach (array_keys($_SESSION['SESS_MEMBER_ID'], $uid) as $key=>$values) {
    unset($_SESSION['SESS_MEMBER_ID'][$values]);
}

header("location:index.php");
exit();
?>