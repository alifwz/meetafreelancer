<?php
session_start();
include "connection.php";
include "functions.php";
include "timezone.php";
include "smtpfunction.php";
$loginid = end($_SESSION[SESS_MEMBER_ID]);
$id=$_REQUEST[id];

if(isset($_POST[submit])){	
	$timezone = $_POST[timezone];
	$msg = $_POST[msg];
	$invid 	= $_POST[invid];
	
	//echo "SELECT * FROM freelancer_mmv_chatmsgs WHERE userid='$loginid' AND receiverid=$id AND parent_id='0'"; die;
	$query = mysql_query("SELECT * FROM freelancer_mmv_chatmsgs WHERE userid='$loginid' AND receiverid=$id AND parent_id='0' AND invitationid=$invid");
	$count = mysql_num_rows($query);
	$about_res = mysql_fetch_array($query);
	$me = $about_res[userid];
	$you = $about_res[receiverid];
	$parentid = $about_res[id];
	
	if($count>=1){
		$query2 = mysql_query("INSERT INTO freelancer_mmv_chatmsgs (id, invitationid, parent_id, userid, receiverid, message, date, flag, msgpostedby, readstatus, timezone) VALUES ('','$invid','$parentid', '$loginid','$id','$msg','$remotedate','1', '$loginid','1','$timezone')");
		$query2 = mysql_query("INSERT INTO freelancer_mmv_chatmsgs (id, invitationid, parent_id, userid, receiverid, message, date, flag, msgpostedby, timezone) VALUES ('','$invid','$parentid', '$id','$loginid','$msg','$remotedate','1', '$loginid','$timezone')");
	}	else {
		$query2 = mysql_query("INSERT INTO freelancer_mmv_chatmsgs (id, invitationid, parent_id, userid, receiverid, message, date, flag, msgpostedby, readstatus, timezone) VALUES ('','$invid','0', '$loginid','$id','$msg','$remotedate','1', '$loginid','1','$timezone')");
		$query2 = mysql_query("INSERT INTO freelancer_mmv_chatmsgs (id, invitationid, parent_id, userid, receiverid, message, date, flag, msgpostedby, timezone) VALUES ('','$invid','0', '$id','$loginid','$msg','$remotedate','1', '$loginid','$timezone')");
	}	
		
		$clieinfo 	= getUserinfo($id);
		$userinfo 	= getUserinfo($loginid);
		
		$tou = $clieinfo[1];
		$fullname = $clieinfo[3].' '.$clieinfo[4];
		$subjectu = "Freelancer Message";			
		$messageu = '<html>
			<head>
			<meta charset="utf-8">
			<title>Freelancer</title>
			<style type="text/css">
				a:hover{background:#ac5e2a!important;border:1px solid #ac5e2a!important }
			</style>
			</head>

			<body style="margin: 0px;padding: 0px">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr><td style="padding: 25px;background:#eee ">
			<table cellpadding="0" cellspacing="0" border="0" style="background: #ffffff">
				<tr>
					<td style="padding:10px 20px;"><div style="border-bottom:1px solid #d1b555;padding-bottom:15px "><img src="" alt="Freelancer" /></div></td>
				</tr>
				<tr>
					<td style="-moz-hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-ms-text-size-adjust: 100%;hyphens: none;font-family:Open Sans,Arial,Helvetica,sans-serif;font-size:20px;line-height: 25px;color: #000;border-collapse: collapse;padding: 15px;padding:10px 20px">Welcome to Freelancer</td>
				</tr>
				<tr>
					<td style="-moz-hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-ms-text-size-adjust: 100%;hyphens: none;font-family:Open Sans,Arial,Helvetica,sans-serif;font-size:20px;line-height: 25px;color: #ac5e2a;border-collapse: collapse;padding: 15px;padding:10px 20px">Hello '.$clieinfo[3].' '.$clieinfo[4].',</td>
				</tr>
				<tr>		
					<td style="-moz-hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-ms-text-size-adjust: 100%;hyphens: none;font-family:Open Sans,Arial,Helvetica,sans-serif;font-size: 15px;line-height: 25px;color: #000;border-collapse: collapse;padding:10px 20px">
						You have received a message from <h3>'.$userinfo[3].' '.$userinfo[4].'</h3> please login to your freelancer account and check more information.
					</td>
				</tr>
				<tr>		
					<td style="padding:10px 20px 15px 20px">
						<a target="_blank" href="'.$urlpath.'messages.php" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:Poppins,Open Sans,Arial,Helvetica,sans-serif;color:#ffffff;padding-top: 7px;padding-right:18px;padding-bottom:10px;padding-left:18px;display:inline-block;border:1px solid #red;text-decoration:none;cursor:pointer;background:red;font-size:16px">Check Messages</a>
					</td>
				</tr>						
				<tr>		
					<td style="-moz-hyphens: none;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;word-break: break-word;-webkit-hyphens: none;-ms-text-size-adjust: 100%;hyphens: none;font-family:Open Sans,Arial,Helvetica,sans-serif;font-size: 15px;line-height: 25px;color: #000;border-collapse: collapse;padding:10px 20px 10px 20px">
						Thanks,<br>Freelancer.
					</td>
				</tr>	
			</table>
			</td></tr>
			</table>
			</body>
			</html>';
		
		smtpmailer($tou, $fullname, $from, $from_name, $subjectu, $messageu);
	
	if($query2){		
		header("location:messages-detail3.php?id=$id");		
	}
	
}

?>