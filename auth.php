<?php
session_start();

if (!isset($_SESSION['SESS_MEMBER_ID'])) {       
	echo "<script>window.location='index.php'</script>";
}
?>