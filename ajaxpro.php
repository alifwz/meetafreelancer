<?php

session_start();
include "connection.php";
$loginid = end($_SESSION[SESS_MEMBER_ID]);

$query = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$loginid'");
$about_res = mysql_fetch_array($query);
$usercountry = $about_res[country];

$pcountry = $_POST[pcountry];
$data = $_POST['image'];
$freelanceserviceid = $_POST['freelanceserviceid'];

$videolink = $_POST[video];

list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);

/* if($size<(2*1024*1024) || $size=="")
  { */

$ppquery = mysql_query("SELECT * FROM freelancer_mmv_paypalsettings WHERE id='1'");
$ppres = mysql_fetch_array($ppquery);
$ppamount = $ppres[image];
if ($ppamount == '0' || $ppamount == '0.00') {
    $status = '1';
} else {
    $status = '0';
}

$data = base64_decode($data);
$imageName = time() . '.png';
$blocation = "uploads/images/" . $imageName;
file_put_contents('uploads/images/' . $imageName, $data);

$imgquery = mysql_query("INSERT INTO freelancer_mmv_userimages (id, userid, image, type, countryid, website, date, freelanceserviceid, status) VALUES ('', '" . $loginid . "','" . $blocation . "','1','$pcountry','$videolink', NOW(),'$freelanceserviceid','$status')");
$imid = mysql_insert_id();
//max 9 post code commented by dev
/*
$countquery = mysql_query("SELECT * FROM freelancer_mmv_userimages WHERE userid='$loginid' and status = 1");
$count_res = mysql_num_rows($countquery);
if ($count_res >= 9) {
    mysql_query("DELETE FROM freelancer_mmv_userimages WHERE userid='$loginid' and status = 1 ORDER BY id ASC LIMIT 1");
}
*/
if ($ppamount == '0' || $ppamount == '0.00') {
    echo $res[data] = "nocharge";
} else {
    echo $res[data] = $imid;
}
	
	//header("location:paypal.php?imgid='.$imid.'&uid='.$loginid.'");
	//echo '<script type="text/javascript">window.location = "paypal.php?imgid='.$imid.'&uid='.$loginid.'"</script>';
/*}
else{					
	//echo "<script>alert('Max file size is 2 MB!!')</script>";
	//echo '<script type="text/javascript">window.location = "index.php"</script>';
}*/
