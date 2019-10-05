<?php
session_start();
include "connection.php";

if(isset($_POST['submit'])){	
	$clientid = $_POST[invitehire]; 
	header("location:meeting-request.php?clientid=$clientid");
} else {
	$clientid = $_POST[invitehire]; 
	header("location:invite-request.php?invitehire=$clientid");
}

?>