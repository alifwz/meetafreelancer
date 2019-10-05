<?php
session_start();
include "connection.php";
$loginid = end($_SESSION[SESS_MEMBER_ID]);

	$query = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$loginid'");
	$res = mysql_fetch_array($query);
	$freelanceserviceid 	= $res[16];

	$videolink = $_REQUEST[weburl];
	$pcountry = $_REQUEST[pcountry];	
	$file_to_upload = $_FILES['croppedImage']['tmp_name'];
	$file_name = time().'.png';
	$blocation = "uploads/images/".$file_name;
	move_uploaded_file($file_to_upload, 'uploads/images/'.$file_name);
	
	$ppquery = mysql_query("SELECT * FROM freelancer_mmv_paypalsettings WHERE id='1'");
	$ppres = mysql_fetch_array($ppquery);
	$ppamount = $ppres[image];
	if($ppamount=='0' || $ppamount=='0.00'){
		$status = '1';
	} else {
		$status = '0';
	}
	
	$imgquery = mysql_query("INSERT INTO freelancer_mmv_userimages (id, userid, image, type, countryid, website, date, freelanceserviceid, status) VALUES ('', '".$loginid."','".$blocation."','1','$pcountry','$videolink', NOW(),'$freelanceserviceid','$status')");
	$imid = mysql_insert_id();
	//max 9 post code commented by dev
	/*
	$countquery = mysql_query("SELECT * FROM freelancer_mmv_userimages WHERE userid='$loginid'");
	$count_res = mysql_num_rows($countquery);
	if($count_res>9){								
		mysql_query("DELETE FROM freelancer_mmv_userimages WHERE userid='$loginid' ORDER BY id ASC LIMIT 1");
	}*/
	
	if($ppamount=='0' || $ppamount=='0.00'){
		echo "nocharge";
	} else {
		echo $imid;
	}	
  
?>