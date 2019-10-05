<?php
include "connection.php";

$src = $_FILES['file']['tmp_name'];
$targ = "uploads/images/".$_FILES['file']['name'];
move_uploaded_file($src, $targ);
?>
