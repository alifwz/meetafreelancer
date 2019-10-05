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
$clientid = $inv_result[invited_userid];

mysql_query("UPDATE freelancer_mmv_member_invitation SET readstatus='1' WHERE invitation_id='$invid'");

$query = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$clientid'");
$about_res = mysql_fetch_array($query);

//Ratings
$noofrev_que = mysql_query("SELECT count(*) as con, sum(ratings) as ratingsum FROM freelancer_mmv_reviewratings WHERE reviewto='$clientid'");
$noofrev_res = mysql_fetch_array($noofrev_que);
$ratingsum = $noofrev_res[ratingsum];
$con = $noofrev_res[con];
$rateval = $ratingsum/$con;

if(isset($_POST[submit])){
				
	$qqq = mysql_query("UPDATE freelancer_mmv_member_invitation SET acceptedstatus='1' WHERE invitation_id='$invid'");
	
	if($qqq){
		echo "<script>window.location='invitation.php'</script>";
	}
}

if(isset($_POST[submitrating])){
	$ratingnum = $_POST[ratingnum];
	$reviewdesc = $_POST[review];
	$invid 		= $_POST[invid];
	
	$query3 = mysql_query("INSERT INTO freelancer_mmv_reviewratings (id, invitationid, reviewto, reviewby, ratings, reviewdesc, date) VALUES ('', '$invid', '$clientid','$loginid','$ratingnum','$reviewdesc',NOW())");
	
	if($query3==1){
		//echo "<script>alert('Review posted successfully!!')</script>";
		echo "<script>window.location='hire-detail-edit.php?id=$invid&status=posted'</script>";
	}
	echo "<script>window.location='hire-detail-edited.php?id=$invid'</script>";	
}
?>
<!--start main-->
<form name="hireedit" method="post" action="">
<div class="main">		
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
						<h3><a href="viewclient.php?id=<?php echo $clientid ?>"><?php echo $about_res[first_name].' '.$about_res[last_name] ?></a>
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
					<div class="allow-div">
						<label class="control control--checkbox">Allowed
							<input type="checkbox" disabled class="allowed" name="allowed" />
							<div class="adt_width control__not_alowed">NOT Allowed</div>
							<div class="control__indicator"></div>
						</label>
					</div>
					<!--<div class="allow-div"><a href="javascript:void(0);" class="allowBtn">Alowed <span></span></a></div>-->
				</div>
			</div>
			<div class="job-row hours-minutes">
				<div class="box-shadow ">
					<p>Number of Hours</p>	
				<?php 
				$minhr = $inv_result[hours_minutes];				
				$exp = explode(' ',$minhr); 
					 $exp[0][0].$exp[0][1];
					 $exp[1][0].$exp[1][1];
				?>					
					<div class="job-row">
						<div class="num-box"><?php echo $exp[0][0] ?></div>
						<div class="num-box"><?php echo $exp[0][1] ?></div>
					</div>
				</div>
				<div class="box-shadow second-div ">
					<p>Number of Minuts</p>				
					<div class="job-row">
						<!--<div class="num-box"><?php echo $exp[1][0] ?></div>
						<div class="num-box"><?php echo $exp[1][1] ?></div>				-->		
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
				<div class="box-shadow share-experience ">
					<p><?php echo $inv_result[meeting_topics]; ?></p>
					
				</div>
			</div>
			
			<div class="meting-note red">Please Pay meting fees to the freelancer before the strat of the meting</div>
			<div class="row intrested-edit-cancel">
				<div class="col-4 intrested-div">
					<!--<a href="javascript:void(0);" class="button acceptBtn">Accept</a>-->
					<button type="submit" name="submit" class="button acceptBtn">Accept</button>
					<!--<a href="javascript:void(0);" class="button sendBtn">Send</a>-->
				</div>
				<div class="col-4 edit-div">
					<a href="hire-detail-edit.php?id=<?php echo $invid; ?>" class="button light-yellow">Edit meeting</a>
				</div>	
				<div class="col-4 cancel-div">
					<a href="javascript:void(0);" class="button light-pink rejectBtn">Reject</a>
					<!--<a href="javascript:void(0);" class="button light-pink cancelBtn">Cancel</a>-->
				</div>
			</div>			
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
	
	$dbtimezone			 = $comm_result[timezone];				
	$meetdate 			 = $comm_result[meetingdate];
		
	if($comm_result[meetingdate]!=""){
		$converted_datetime  = converToTz($meetdate, $timezone, $dbtimezone);
		$appdate = strtotime($converted_datetime);
	} else {
		$appdate = strtotime($comm_result[meetingdate]);
	}
		
	$time=$hourmin;
    $timesplit=explode(':',$time);
    $min=($timesplit[0]*60)+($timesplit[1])+($timesplit[2]>30?1:0).' minutes';
    $strtTime = strtotime("+".$min, $appdate);
	$totaltime = $strtTime;		
	$startdate = date('Y-m-d H:i',($totaltime));
	$currentdate = date('Y-m-d H:i');

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
			$revquery = mysql_query("SELECT * FROM freelancer_mmv_reviewratings WHERE reviewto='$clientid' ORDER BY date DESC");
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