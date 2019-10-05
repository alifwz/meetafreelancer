<?php
session_start();
include "connection.php";
include "header.php";
include "functions.php";

$id = $_REQUEST[invitehire];
$userinfo = getUserinfo($id);

$query2 = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$id'");
$about_res2 = mysql_fetch_array($query2);

//Ratings
$noofrev_que = mysql_query("SELECT count(*) as con, sum(ratings) as ratingsum FROM freelancer_mmv_reviewratings WHERE reviewto='$id'");
$noofrev_res = mysql_fetch_array($noofrev_que);
$ratingsum = $noofrev_res[ratingsum];
$con = $noofrev_res[con];
$rateval = $ratingsum/$con;

if(isset($_POST[submit])){
	
	$datetime = $_POST[datetime];
	$location = $_POST[location];
	$invtitedid = $_POST[invitedid];
	
	//echo "INSERT INTO freelancer_mmv_member_invitation (invitation_id, user_id, invited_userid, hours_minutes, meeting_topics, photoshooting, offeredprice, date, 	location, meetingdate) VALUES ('', '$loginid','$id','','','','',NOW(),'$location','$datetime')"; die;
	
	$query = mysql_query("INSERT INTO freelancer_mmv_member_invitation (invitation_id, user_id, invited_userid, hours_minutes, meeting_topics, photoshooting, offeredprice, date, 	location, meetingdate) VALUES ('', '$loginid','$invtitedid','','','','',NOW(),'$location','$datetime')");
	
	if($query){
		echo "<script>alert('Invited successfully!!')</script>";		
	}
	echo "<script>window.location='hire.php'</script>";
}

if(isset($_POST[submitrating])){
	$ratingnum = $_POST[ratingnum];
	$reviewdesc = $_POST[review];
	
	$query3 = mysql_query("INSERT INTO freelancer_mmv_reviewratings (id, reviewto, reviewby, ratings, reviewdesc, date) VALUES ('', '$id','$loginid','$ratingnum','$reviewdesc',NOW())");
	
	if($query3==1){
		echo "<script>alert('Review posted successfully!!')</script>";
	}
	echo "<script>window.location='invite-request.php?invitehire=$id'</script>";	
}
?>
<!--start main-->
<form name="" action="" method="post" >
<div class="main" style="min-height:850px">		
	<section class="contenets-main">
		<!--start post job -->
		<div class="contenets invite-main">
			<h2>Invitation</h2>
			<div class="job-thumb favourite-box for-rating invite-box">
				<div class="job-row">
					<div class="favourite-holder">
					<?php if($userinfo[11] ==""){ ?>
								<img src="images/user.png" alt=""/>
							<?php } else { ?>
								<img src="uploads/users/<?php echo $userinfo[11]?>" alt=""/>
							<?php } ?>
					</div>
					<div class="favourite-dtl">
						<h3><?php echo $userinfo[3].' '.$userinfo[4]; ?>
							<p><span class="grey">Area:</span> <?php echo getCountry($id) ?></p>
						</h3>
						<input type="hidden" name="invitedid" value="<?php echo $id; ?>">						
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
			<div class="job-thumb favourite-box for-rating invite-box">
				<div class="job-row location-text">
					<p class="grey">Location</p>
					<textarea placeholder="Enter your Meeting Location" required name="location" class="form-control"></textarea>	
				</div>
			</div>
			<div class="exact-location"><p>(Exact Location using What3worda ap)</p></div>
			<div class="job-thumb favourite-box for-rating invite-box">
				<div class="job-row butchers-flattening-div">
					<p>Butchers.flattening. paded</p>
				</div>
			</div>
			<div class="job-thumb favourite-box for-rating invite-box">
				<div class="input-group date form_datetime" data-date="" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                    <input class="form-control" size="16" required name="datetime" placeholder="Select Date and Time" type="text" value="" >
					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
				<!--<div class="job-row date-time-div">
					Fri - Oct 20 - 2017 20:00
				</div>-->
			</div>
						 
			<div class="row intrested-edit-cancel">
				<div class="col-6">
					<!--<a href="javascript:void(0);" class="button">Send</a>-->
					<button type="submit" name="submit" style="width:183px;height:23" class="button">Send</button>
				</div>
				<div class="col-6">
					<a href="invitation.php" class="button light-pink">Cancel</a>
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
	<form name="ratings" method="post" action="">
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
		<div class="review-main">
			<h2>Review Comments</h2>
			<?php 			
			$revquery = mysql_query("SELECT * FROM freelancer_mmv_reviewratings WHERE reviewto='$id' ORDER BY date DESC");
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
    $(function()
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
		
    });
</script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
</script>	
