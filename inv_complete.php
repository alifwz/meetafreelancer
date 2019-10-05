<?php
//session_start();
include "connection.php";
include "header.php";
include "functions.php";

//print_r($_REQUEST);
$amt = $_REQUEST[amt];
$cc = $_REQUEST[cc];
$cm = $_REQUEST[cm];
$item_name = $_REQUEST[item_name];
$st = $_REQUEST[st];
$tx = $_REQUEST[tx];
$date = date('d-m-Y');

$split = explode('@',$cm);
$userid = $split[0];
$invid = $split[1];
$invsplit = explode('-',$invid);

$query = mysql_query("INSERT INTO freelancer_mmv_paypalpayments(`id`,`transactid`,`item_name`,`amt`,`cc`,`st`,`date`,`userid`,`imgid`) VALUES ('','$tx','$item_name','$amt','$cc','$st',NOW(),'$userid','$invid')");

foreach($invsplit as $inviteids){	
	mysql_query("UPDATE freelancer_mmv_member_invitation SET `status`='1', `paypalstatus`='1' WHERE invitation_id='$inviteids'");
	
	$invitedquery = mysql_query("SELECT * FROM freelancer_mmv_member_invitation WHERE invitation_id='$inviteids'");
	$invi_res = mysql_fetch_array($invitedquery);
	$inviv = $invi_res[invited_userid];
	
	$clieinfo 	= getUserinfo($inviv);
	$userinfo 	= getUserinfo($loginid);
	
	$tou = $clieinfo[1];
	$fullname = $clieinfo[3].' '.$clieinfo[4];
	$subjectu = "Freelancer Invitation";			
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
					You have received an invitation from <h3>'.$userinfo[3].' '.$userinfo[4].'</h3> please login to your freelancer account and check more information.
				</td>
			</tr>
			<tr>		
				<td style="padding:10px 20px 15px 20px">
					<a target="_blank" href="'.$urlpath.'index.php" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:Poppins,Open Sans,Arial,Helvetica,sans-serif;color:#ffffff;padding-top: 7px;padding-right:18px;padding-bottom:10px;padding-left:18px;display:inline-block;border:1px solid #red;text-decoration:none;cursor:pointer;background:red;font-size:16px">Invitation link</a>
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

	// Always set content-type when sending HTML email
	//$headersu = "MIME-Version: 1.0" . "\r\n";
	//$headersu .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	//$headersu .= 'From: <notifications@meetfreelancers.com>' . "\r\n".
	//"Reply-To: noreply@meetfreelancers.com" . "\r\n" ;
	//$headers .= 'Cc: myboss@example.com' . "\r\n";
	smtpmailer($tou, $fullname, $from, $from_name, $subjectu, $messageu);
	//mail($tou,$subjectu,$messageu,$headersu);	
}

if($query==1){		
	$_SESSION['status'] = "success";
		echo '<script type="text/javascript">window.location = "hire.php"</script>';exit;
}
?>
<div class="main">		
	<section class="contenets-main">
		<!--start form-->
		<div class="container">
			<div class="row form-main text-align-center">
				<div class="col-12"><h2>PayPal</h2></div>				
				<div class="col-12">			  
				  <p class="file-return"></p>				
				</div>
				<div class="col-12">
										
				</div>				
			</div>
		</div>		
		<!--end form-->		 
	</section>
</div>