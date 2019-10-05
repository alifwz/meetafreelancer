<?php
session_start();
include "connection.php";
include "headerinvitation.php";
include "functions.php";
include "what3wordsapp.php";
include "what3wordsmapp.php";
include "auth.php";

$invid = $_REQUEST[id];
$inv_que = mysql_query("SELECT * from freelancer_mmv_member_invitation where invitation_id='$invid'");
$inv_result = mysql_fetch_array($inv_que);
$clientid = $inv_result[user_id];
$ivitedid = $inv_result[invited_userid];

$appdate2 = strtotime($inv_result[meetingdate]);
$timedur2 = $inv_result[hours_minutes];
$arr12 = explode(':', $timedur2);
$totalMinutes2 = ((int)$arr12[0] * 60 + (int)$arr12[1]);
$strtTime2 = strtotime("+".$totalMinutes2." minutes", $appdate2);
$completedate2 = date('d M Y H:i a',$strtTime2);

mysql_query("UPDATE freelancer_mmv_member_invitation SET readstatus='1' WHERE invitation_id='$invid'");


if($ivitedid!=$loginid){
	$query = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$ivitedid'");
	$about_res = mysql_fetch_array($query);
} else {
	$query = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$clientid'");
	$about_res = mysql_fetch_array($query);
}

/*$query = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$ivitedid'");
$about_res = mysql_fetch_array($query);*/

//Ratings

if($ivitedid!=$loginid){
	$noofrev_que = mysql_query("SELECT count(*) as con, sum(ratings) as ratingsum FROM freelancer_mmv_reviewratings WHERE reviewto='$ivitedid'");
} else {
	$noofrev_que = mysql_query("SELECT count(*) as con, sum(ratings) as ratingsum FROM freelancer_mmv_reviewratings WHERE reviewto='$clientid'");
}
$noofrev_res = mysql_fetch_array($noofrev_que);
$ratingsum = $noofrev_res[ratingsum];
$con = $noofrev_res[con];
$rateval = $ratingsum/$con;

if(isset($_POST[submit])){
	$qqq = mysql_query("UPDATE freelancer_mmv_member_invitation SET acceptedstatus='1' WHERE invitation_id='$invid'");
	if($qqq){
		$_SESSION['status'] = "success";
		echo "<script>window.location='invitation.php'</script>";exit;
	}
}

if(isset($_POST[reject])){
	$qqq = mysql_query("UPDATE freelancer_mmv_member_invitation SET acceptedstatus='2' WHERE invitation_id='$invid'");
	if($qqq){

		$clieinfo 	= getUserinfo($clientid);
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
						Your meeting request with <h3>'.$userinfo[3].' '.$userinfo[4].'</h3> is Rejected.
					</td>
				</tr>
				<tr>
					<td style="padding:10px 20px 15px 20px">
						<a target="_blank" href="'.$urlpath.'index.php" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:Poppins,Open Sans,Arial,Helvetica,sans-serif;color:#ffffff;padding-top: 7px;padding-right:18px;padding-bottom:10px;padding-left:18px;display:inline-block;border:1px solid #red;text-decoration:none;cursor:pointer;background:red;font-size:16px">Rejection link</a>
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
		//mail($tou,$subjectu,$messageu,$headersu);
		smtpmailer($tou, $fullname, $from, $from_name, $subjectu, $messageu);
		$_SESSION['status'] = "success";
		echo "<script>window.location='invitation.php'</script>";exit;
	}
}

if(isset($_POST[submitrating])){
	$ratingnum = $_POST[ratingnum];
	$reviewdesc = $_POST[review];
	$invid 		= $_POST[invid];

	$query3 = mysql_query("INSERT INTO freelancer_mmv_reviewratings (id, invitationid, reviewto, reviewby, ratings, reviewdesc, date) VALUES ('', '$invid', '$clientid','$loginid','$ratingnum','$reviewdesc',NOW())");

	if($query3==1){
		$_SESSION['status'] = "posted";
		echo "<script>window.location='hire-detail-sender.php?id=$invid'</script>";exit;
	}
	echo "<script>window.location='hire-detail-sender.php?id=$invid'</script>";
}

?>
<!--start main-->
<form name="hireedit" method="post" action="">
<div class="main">
	<div id="sticktabs" class="notification-main">
		<!--<div class="notify-title">Notification</div>-->
		<table class="notification-links tabs">
			<tr>
				<td>
					<a href="invitation.php" class="active">
						<span class="tabs-title">Invitation</span>
						<?php
							$banner_que = mysql_query("SELECT * from freelancer_mmv_member_invitation where user_id='$loginid' AND readstatus=0");
							$banner_result = mysql_num_rows($banner_que);
							if($banner_result!=0){
						?>
						<span class="bell-notify"></span>
						<?php } ?>
					</a>
				</td>
				<td>
					<a href="calendar.php">
						<span class="tabs-title"><img src="images/icon-calendar.png" alt="Calendar" /></span>
						<?php
							$cal_que = mysql_query("SELECT * from freelancer_mmv_member_invitation where user_id='$loginid' AND acceptedstatus=1 AND calreadstatus=0");
							$cal_result = mysql_num_rows($cal_que);
							if($cal_result!=0){
						?>
						<span class="bell-notify"></span>
						<?php } ?>
					</a>
				</td>
				<td>
					<a href="favourite.php">
						<span class="tabs-title"><img src="images/icon-favourite.png" alt="Favourite" /></span>
						<?php
							$fav_que = mysql_query("SELECT * from freelancer_mmv_favourites where userid='$loginid' AND favstatus=0");
							$fav_result = mysql_num_rows($fav_que);
							$fav_que1 = mysql_query("SELECT * from freelancer_mmv_favourites where memberid='$loginid' AND favstatus=0");
							$fav_result1 = mysql_num_rows($fav_que1);
							if(($fav_result!=0) || ($fav_result1!=0)){
						?>
							<span class="bell-notify"></span>
						<?php } ?>
					</a>
				</td>
				<td>
					<a href="messages.php">
						<span class="tabs-title">Messages</span>
						<?php
							$mes_que = mysql_query("SELECT * from freelancer_mmv_chatmsgs where userid='$loginid' AND readstatus=0");
							$mes_result = mysql_num_rows($mes_que);
							if($mes_result!=0){
						?>
						<span class="bell-notify"></span>
						<?php } ?>
					</a>
				</td>
			</tr>
		</table>
	</div>
	<section class="contenets-main">
		<!--start post job -->
		<div class="contenets invite-main">
			<h2>Meeting</h2>
			<div class="job-thumb favourite-box for-rating invite-box">
				<div class="job-row">
					<div class="favourite-holder">
						<?php if($about_res[image] ==""){ ?>
								<img src="images/user.png" alt="user"/>
							<?php } else { ?>
								<img src="uploads/users/<?php echo $about_res[image] ?>" alt="user"/>
							<?php } ?>
					</div>
					<div class="favourite-dtl">
						<h3><a href="viewclient.php?id=<?php echo $ivitedid ?>"><?php echo $about_res[first_name].' '.$about_res[last_name] ?></a>
							<p><span class="grey">Country:</span> <?php echo getCountry($about_res[country]) ?></p>
						</h3>
					</div>
					<div class="favourite-dtl" style="margin-bottom:60px;">
						<div class="rating-review">
							<div class="rating-div">
								 <?php if($rateval>='0.5' && $rateval<'1.5'){
									echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';
									} else if($rateval>='1.5' && $rateval<'2.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';
									} else if($rateval>='2.5' && $rateval<'3.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';
									} else if($rateval>='3.5' && $rateval<'4.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';
									} else if($rateval>='4.5' && $rateval<='5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>';
									} else {
										echo '<img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';
									}
								 ?>
								 <span class="number">( <?php echo $con; ?> )</span>
							</div>
							<a href="javascript:void(0);" class="button reviewPopupBtn">Reviews</a>
						</div>
					</div>
				</div>
			</div>
			<div class="job-thumb favourite-box for-rating invite-box ">
				<div class="job-row location-text">
					<p class="grey">Location</p>
						<p class="font-size24"><?php echo $inv_result[location] ?></p>
				</div>
			</div>
			<!--<div class="exact-location"><p>(Exact Location using What3words)</p></div>
			<div class="job-thumb favourite-box for-rating invite-box">
				<div class="job-row butchers-flattening-div">
				<?php if($inv_result[what3word]!=''){ ?>
					<a target="blank" href="<?php Getwhat3wordsmap($inv_result[what3word]) ?>"><p><?php echo $inv_result[what3word]; ?></p></a>
				<?php } else { ?>
					<p>Eg: Butchers.flattening. paded</p>
				<?php } ?>
				</div>
			</div>-->
			<?php
				$meetdate = $inv_result[meetingdate];
				$dbtimezone = $inv_result[timezone];
				$converted_datetime = converToTz($meetdate, $timezone, $dbtimezone);
			?>
			<div class="job-thumb favourite-box for-rating invite-box ">
				<div class="job-row date-time-div">
					<?php echo date('d F Y h:i A', strtotime($converted_datetime)); ?>
				</div>
			</div>
			<div class="job-thumb favourite-box for-rating invite-box ">
				<div class="job-row photo-shooting-div">
					<div class="photo-shooting">Photo Shooting</div>
					<?php if($inv_result[photoshooting]==1){ ?>
						<div class="allow-div">
						<label class="control control--checkbox">Allowed
							<input type="checkbox" disabled class="allowed" id="allowed" name="allowed"/>
							<input type="hidden" name="photoshoot" id="photoshoot" value="1">
							<div class="adt_width control__not_alowed">NOT Allowed</div>
							<div class="control__indicator"></div>
						</label>
						</div>
					<?php } else { ?>
					<div class="allow-div">
						<label class="control control--checkbox">Allowed
							<input type="checkbox" checked id="allowed" class="allowed" name="allowed" />
							<input type="hidden" name="photoshoot" id="photoshoot" value="0">
							<div class="adt_width control__not_alowed">NOT Allowed</div>
							<div class="control__indicator"></div>
						</label>
						</div>
					<?php } ?>
					<!--<div class="allow-div"><a href="javascript:void(0);" class="allowBtn">Alowed <span></span></a></div>-->
				</div>
			</div>
			<div class="job-row hours-minutes">
				<div class="box-shadow ">
					<p>Number of Hours</p>
				<?php
				$minhr = $inv_result[hours_minutes];
				$exp = explode(':',$minhr);
					 $exp[0][0].$exp[0][1];
					 $exp[1][0].$exp[1][1];
				?>
					<div class="job-row">
						<div class="num-box"><?php echo $exp[0][0] ?></div>
						<div class="num-box"><?php echo $exp[0][1] ?></div>
					</div>
				</div>
				<div class="box-shadow second-div ">
					<p>Number of Minutes</p>
					<div class="job-row">
						<div class="num-box"><?php echo $exp[1][0] ?></div>
						<div class="num-box"><?php echo $exp[1][1] ?></div>
					</div>
				</div>
			</div>
			<div class="job-row hours-minutes">
				<div class="box-shadow second-div margin-left0 ">
					<p>Offered payment</p>
				<?php
					$offprice = $inv_result[offeredprice];
				?>
					<div class="job-row">
						<div class="num-box"><?php echo $offprice[0]; ?></div>
						<div class="num-box"><?php echo $offprice[1]; ?></div>
						<div class="num-box"><?php echo $offprice[2]; ?></div>
						<div class="num-box edited"><?php echo $offprice[3]; ?></div>
						<div class="num-box edited"><?php echo $offprice[4]; ?></div>
						<span class="usd-span">$</span>
					</div>
				</div>
			</div>
			<div class="meeting-topics">
				<p class="grey">Meeting Topics</p>
				<div class="box-shadow share-experience">
					<p><?php echo $inv_result[meeting_topics]; ?></p>

				</div>
			</div>
			<?php
			if($inv_result[senderedit]=='1' && $inv_result[receiveredit]=='0'){
			?>
			<div class="meting-note red">Before you start the meeting: Please handle meeting fees, that you already offered for the Freelancer, to Freelancers' hand.</div>
			<div class="row intrested-edit-cancel">
				<div class="col-4 intrested-div">
					<!--<a href="javascript:void(0);" class="button acceptBtn">Accept</a>-->
					<button type="submit" name="submit" class="button acceptBtn">Accept</button>
					<!--<a href="javascript:void(0);" class="button sendBtn">Send</a>-->
				</div>
				<div class="col-4 edit-div">
					<a href="hire-detail-senderedit.php?id=<?php echo $invid; ?>" class="button light-yellow">Edit meeting</a>
				</div>
				<div class="col-4 cancel-div">
					<!--<a href="javascript:void(0);" class="button light-pink rejectBtn">Reject</a>-->
					<button type="submit" name="reject" class="button light-pink rejectBtn">Reject</button>
					<!--<a href="javascript:void(0);" class="button light-pink cancelBtn">Cancel</a>-->
				</div>
			</div>
			<?php } else { ?>
			<div class="meting-note red">Changes done. Waiting for approval!!</div>
		  <?php } ?>
		</div>
		<!--end post job -->
	</section>
</div>
</form>
<!--end main-->

<div class="popbox">
	<div class="review-popup" id="reviewPopup">
	<?php
	//$comm_query = mysql_query("SELECT * FROM freelancer_mmv_member_invitation WHERE user_id='$loginid' AND invited_userid='$clientid' AND acceptedstatus=1");
	if($clientid!=$loginid){
		//echo "SELECT * FROM freelancer_mmv_member_invitation WHERE ((user_id='$loginid' AND invited_userid='$clientid') OR (invitation_return_reviewby='$clientid' AND invitation_return_reviewto='$invited_userid')) AND acceptedstatus=1 ORDER BY invitation_id DESC";
		$comm_query = mysql_query("SELECT * FROM freelancer_mmv_member_invitation WHERE ((user_id='$loginid' AND invited_userid='$clientid') OR (invitation_return_reviewby='$clientid' AND invitation_return_reviewto='$loginid')) AND acceptedstatus=1 ORDER BY invitation_id DESC");
		//$comm_query = mysql_query("SELECT * FROM freelancer_mmv_member_invitation WHERE user_id='$clientid' AND invited_userid='$invited_userid' AND acceptedstatus=1 ORDER BY invitation_id DESC");
	} else {
		$comm_query = mysql_query("SELECT * FROM freelancer_mmv_member_invitation WHERE ((user_id='$clientid' AND invited_userid='$loginid') OR (invitation_return_reviewby='$clientid' AND invitation_return_reviewto='$loginid')) AND acceptedstatus=1 ORDER BY invitation_id DESC");
		//$comm_query = mysql_query("SELECT * FROM freelancer_mmv_member_invitation WHERE user_id='$invited_userid' AND invited_userid='$loginid' AND acceptedstatus=1 ORDER BY invitation_id DESC");
	}
	$comm_res = mysql_num_rows($comm_query);
	$comm_result = mysql_fetch_array($comm_query);
	$appdate = strtotime($comm_result[meetingdate]);
	$hourmin = $comm_result[hours_minutes];
	$invid = $comm_result[invitation_id];

	$time=$hourmin;
    $timesplit=explode(':',$time);
    $min=($timesplit[0]*60)+($timesplit[1])+($timesplit[2]>30?1:0).' minutes';
    $strtTime = strtotime("+".$min, $appdate);
	$totaltime = $strtTime;
	$startdate = date('Y-m-d H:i',($totaltime));
	$currentdate = date('Y-m-d H:i');

	$dbtimezone			 = $comm_result[timezone];
	$meetdate 			 = $comm_result[meetingdate];

	if($comm_result[meetingdate]!=""){
		$converted_datetime  = converToTz($meetdate, $timezone, $dbtimezone);
		$appdate = strtotime($converted_datetime);
	} else {
		$appdate = strtotime($comm_result[meetingdate]);
	}

	//Check rating Query
	$rate_query 	= mysql_query("SELECT * FROM freelancer_mmv_reviewratings WHERE invitationid='$invid' AND reviewby='$loginid'");
	$rate_count 	= mysql_num_rows($rate_query);
	if($rate_count==0){
	if($comm_res>='1' && $currentdate>=$startdate){
	?>
	<form name="ratings" method="post" action="">
	<input type="hidden" name="invid" value="<?php echo $invid; ?>">
		<div class="write-comment-main">
			<h2>Add Your Comments</h2>
			<div class="rating-stars text-center">
				<ul id="stars">
					<li class="star" title="Poor" data-value="1"><i class="fa fa-star fa-fw"></i></li>
					<li class="star" title="Fair" data-value="2"><i class="fa fa-star fa-fw"></i></li>
					<li class="star" title="Good" data-value="3"><i class="fa fa-star fa-fw"></i></li>
					<li class="star" title="Excellent" data-value="4"><i class="fa fa-star fa-fw"></i></li>
					<li class="star" title="WOW!!!" data-value="5"><i class="fa fa-star fa-fw"></i></li>
				</ul>
			</div>
			  <div class="success-box">
				<div class="text-message"></div>
				<input type="hidden" name="ratingnum" id="ratingnum" value="">
				<div class="clearfix"></div>
			  </div>
			<div class="row post-a-job-row">
				<div class="col-12">
					<div class="job-inputbox">
						<textarea required name="review" class="job-input review-textarea" placeholder="Write Your Comment Here..."></textarea>
					</div>
				</div>
			</div>
			<div class="row post-a-job-row text-align-center">
				<div class="col-12 paddingtop10">
					<div class="rating-review rating-submit"><button class="button" name="submitrating" type="submit">Submit</button></div>
				</div>
			</div>
		</div>
		</form>
		<?php } } ?>
		<div class="review-main">
			<h2>Review Comments</h2>
			<?php
			if($ivitedid!=$loginid){
				$revquery = mysql_query("SELECT * FROM freelancer_mmv_reviewratings WHERE reviewto='$ivitedid' ORDER BY date DESC");
			} else {
				$revquery = mysql_query("SELECT * FROM freelancer_mmv_reviewratings WHERE reviewto='$clientid' ORDER BY date DESC");
			}

			while($revres = mysql_fetch_array($revquery)){
				$givenby = $revres[reviewby];
				$myrat = $revres[ratings];
				$resquery = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$givenby'");
				$rev_res = mysql_fetch_array($resquery);
			?>
			<div class="job-thumb favourite-box for-rating invite-box">
				<div class="job-row">
					<div class="favourite-holder">
					<?php if($rev_res[image] ==""){ ?>
						<img src="images/user.png" alt="user"/>
					<?php } else { ?>
						<img src="uploads/users/<?php echo $rev_res[image] ?>" alt="user"/>
					<?php } ?>
					</div>
					<div class="favourite-dtl">
						<h3>
						<?php if($givenby != $loginid){ ?>
							<a href="viewclient.php?id=<?php echo $givenby ?>"><?php echo $rev_res[first_name].' '.$rev_res[last_name] ?></a>
						<?php } else { ?>
							<a href="#"><?php echo $rev_res[first_name].' '.$rev_res[last_name] ?></a>
						<?php } ?>
							<div class="review-rating">
								<?php if($rateval>='0.5' && $rateval<'1.5'){
									echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';
									} else if($rateval>='1.5' && $rateval<'2.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';
									} else if($rateval>='2.5' && $rateval<'3.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';
									}else if($rateval>='3.5' && $rateval<'4.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';
									}else if($rateval>='4.5' && $rateval<='5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>';
									} else {
										echo '<img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';
									}
								 ?>
									<!--<span class="number">( 18 )</span>-->
							</div>
						</h3>
					</div>
				</div>
				<p><?php echo $revres[reviewdesc] ?></p>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php include "footer.php"; ?>

<script type="text/javascript">
   /* $(function()
    {
		$('.sendBtn,.cancelBtn').hide();
		$('[name="allowed"]').change(function()
		{
			if ($(this).is(':checked')) {
				$('.acceptBtn,.rejectBtn').hide();
				$('.sendBtn,.cancelBtn').show();
			}
			  else{
				$('.acceptBtn,.rejectBtn').show();
				$('.sendBtn,.cancelBtn').hide();
			  };
		});

    });*/
</script>
