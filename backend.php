<?php 
session_start();
include "connection.php";
//$contid = $_POST[id];
echo $_SESSION['countryid'] = $_POST['id'];
?>