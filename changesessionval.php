<?php
session_start();
$usarray = $_SESSION["SESS_MEMBER_ID"];
$id= $_REQUEST['id'];

array_push($_SESSION[SESS_MEMBER_ID],$id);
	/*foreach ($usarray as $key=>$uservalue){
					
		$_SESSION[SESS_MEMBER_ID][$i] = $uservalue;
		//array_pop($_SESSION[SESS_MEMBER_ID][$id]);
		$i++;
	  }
	$finalarray = ($_SESSION["SESS_MEMBER_ID"]);
	$_SESSION[finaluserarray] = array_unique($finalarray);*/
  
header("location:index.php");
?>
