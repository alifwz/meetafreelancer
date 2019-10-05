<?php
session_start();
include "connection.php";
include "headerinvitation.php";
include "functions.php";
include "auth.php";
?>
<!--start main-->
<div class="main">
	<div id="sticktabs" class="notification-main">
		<!--<div class="notify-title">Notification</div>-->
		<table class="notification-links tabs">
			<tr>
				<td>
					<a href="invitation.php">
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
					<a href="favourite.php" class="active">
						<span class="tabs-title"><img src="images/icon-favourite.png" alt="Favourite" /></span>
						<span class="bell-notify"></span>
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
	<div class="notification-dtl">
		<div class="notification">
			<div id="header" class="update-location-div">
				<a href="updatecurrentlocation.php" class="update-location"><img src="images/update-location.png" alt="update location"/> Update Current Location</a>
			</div>
			<?php			
			$subcat_query = mysql_query("SELECT * FROM freelancer_mmv_favourites WHERE userid='$loginid' AND userid!='0'");
			while($subcat_res = mysql_fetch_array($subcat_query)){
				$memid = $subcat_res[memberid];
				$userid = $subcat_res[userid];
				$workid = $subcat_res[workid];
				
				$query 		= mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$memid'");
				$about_res	= mysql_fetch_array($query);

				$query2 		= mysql_query("SELECT * FROM freelancer_mmv_work WHERE work_id='$workid'");
				$about_res2	= mysql_fetch_array($query2);
				
				//Ratings
				$noofrev_que = mysql_query("SELECT count(*) as con, sum(ratings) as ratingsum FROM freelancer_mmv_reviewratings WHERE reviewto='$memid'");
				$noofrev_res = mysql_fetch_array($noofrev_que);
				$ratingsum = $noofrev_res[ratingsum];
				$con = $noofrev_res[con];
				$rateval = $ratingsum/$con;
			?>
			<?php
				$memberid = $memid;
				/*Get Distance*/
				$login_que = mysql_query("SELECT * from freelancer_mmv_member_master where member_id='$loginid'");
				$login_result = mysql_fetch_array($login_que);			
				$login_que1 = mysql_query("SELECT * from freelancer_mmv_member_master where member_id='$memberid'");
				$login_result1 = mysql_fetch_array($login_que1);
				
				$latitudeFrom = $login_result['loginlats'];
				$longitudeFrom = $login_result['loginlong'];						
				
				$latitudeTo = $login_result1['loginlats'];
				$longitudeTo = $login_result1['loginlong'];			
				$distt = distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, "K") . " Kilometers<br>";
				$finaldist = $distt;
				/*End*/
			?>
			
			<div class="job-thumb favourite-box">
				<div class="job-row cursor-pointer" >
					<div class="favourite-holder">
					<?php if($about_res[image] ==""){ ?>
						<img src="images/user.png" alt=""/>
					<?php } else { ?>
						<img src="uploads/users/<?php echo $about_res[image] ?>" alt=""/>
					<?php } ?>					
					</div>
					<div class="favourite-dtl">
						<h3><a href="viewclient.php?id=<?php echo $memid ?>"><?php echo $about_res[first_name].' '.$about_res[last_name] ?> <br>
						<span class="km"><?php echo number_format($finaldist,1).' km' ?></span></a></h3>
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
					</div>
				</div>
				<a onClick="location.href='favtomeet.php?id=<?php echo $workid ?>'">
				<div class="job-row favourite-detail cursor-pointer">					
					<p><span class="grey">Received Interest in:</span> <strong><?php echo $about_res2[title] ?></strong></p>
					<p><span class="grey">Freelance:</span> <strong class="black"><?php echo getExperience($about_res[expsector]) ?></strong></p>
					<p><span class="grey">Post Name:</span> <strong class="black"><?php echo $about_res[jobtitle] ?></strong></p>
					<?php if($subcat_res[budget]!='0' && $subcat_res[duration]!='0') { ?>
					<p><span class="grey">Budget:</span> <strong class="black"><?php echo getBudget($subcat_res[budget]) ?></strong></p>
					<p><span class="grey">Duration:</span> <strong class="black"><?php echo getDuration($subcat_res[duration]) ?></strong></p>					
					<?php } ?>
					<p><span class="grey">Nationality:</span> 
					<?php if($about_res[nationality]!=""){ echo getNationality($about_res[nationality]) ?>  <span class="grey pipe">I</span><?php } ?>
					<?php if($about_res[area]!=""){ echo '<span class="grey">Area: </span>'. $about_res[area] ?> <span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[gender]!=""){ echo '<span class="grey">Gender: </span>'. $about_res[gender] ?> <span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[mbti]!=""){ echo '<span class="grey">MBTI: </span>'. getMBTI($about_res[mbti]) ?> <span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[education]!=""){ echo '<span class="grey">Education: </span>'. getEducation($about_res[education]) ?>  <span class="grey pipe">I</span><?php } ?>   
					<?php if($about_res[degree]!=""){ echo '<span class="grey">Degree: </span>'. getDegree($about_res[degree]) ?><span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[jobtitle]!=""){ echo '<span class="grey">Job Title: </span>'. $about_res[jobtitle]; } ?></p>					
				</div>
				</a>
			</div>
			<?php } ?>	
			<?php			
			$subcat_query = mysql_query("SELECT * FROM freelancer_mmv_favourites WHERE memberid='$loginid' AND userid!='0'");
			while($subcat_res = mysql_fetch_array($subcat_query)){				
				$userid = $subcat_res[userid];
				$workid = $subcat_res[workid];
				
				$query 		= mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$userid'");
				$about_res	= mysql_fetch_array($query);
				
				$query2 		= mysql_query("SELECT * FROM freelancer_mmv_work WHERE work_id='$workid'");
				$about_res2	= mysql_fetch_array($query2);
				
				//Ratings
				$noofrev_que1 = mysql_query("SELECT count(*) as con, sum(ratings) as ratingsum FROM freelancer_mmv_reviewratings WHERE reviewto='$userid'");
				$noofrev_res1 = mysql_fetch_array($noofrev_que1);
				$ratingsum1 = $noofrev_res1[ratingsum];
				$con1 = $noofrev_res1[con];
				$rateval1 = $ratingsum1/$con1;
			?>
			<?php
				$memberid = $userid;
				/*Get Distance*/
				$login_que = mysql_query("SELECT * from freelancer_mmv_member_master where member_id='$loginid'");
				$login_result = mysql_fetch_array($login_que);			
				$login_que1 = mysql_query("SELECT * from freelancer_mmv_member_master where member_id='$memberid'");
				$login_result1 = mysql_fetch_array($login_que1);
				
				$latitudeFrom = $login_result['loginlats'];
				$longitudeFrom = $login_result['loginlong'];						
				
				$latitudeTo = $login_result1['loginlats'];
				$longitudeTo = $login_result1['loginlong'];			
				$distt = distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, "K") . " Kilometers<br>";
				$finaldist = $distt;
				/*End*/
			?>
			
			<div class="job-thumb favourite-box">
				<div class="job-row cursor-pointer" onClick="location.href='viewclient.php?id=<?php echo $userid ?>&req=fav'">
					<div class="favourite-holder">
					<?php if($about_res[image] ==""){ ?>
						<img src="images/user.png" alt=""/>
					<?php } else { ?>
						<img src="uploads/users/<?php echo $about_res[image] ?>" alt=""/>
					<?php } ?>					
					</div>
					<div class="favourite-dtl">
						<h3><a href="viewclient.php?id=<?php echo $userid ?>&req=fav"><?php echo $about_res[first_name].' '.$about_res[last_name] ?> <br> <span class="km"><?php echo number_format($finaldist,1).' km' ?></span></h3></a><p class="red">Is interested <?php if($subcat_res[budget]!='0' && $subcat_res[duration]!='0') { echo "if"; } ?></p>
						<div class="rating-div">							
							 <?php if($rateval1>='0.5' && $rateval1<'1.5'){
									echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';									
									} else if($rateval1>='1.5' && $rateval1<'2.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';	
									} else if($rateval1>='2.5' && $rateval1<'3.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';	
									} else if($rateval1>='3.5' && $rateval1<'4.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';	
									} else if($rateval1>='4.5' && $rateval1<='5'){
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
							 <span class="number">( <?php echo $con1; ?> )</span>
						</div>						
					</div>
				</div>
				<div class="job-row favourite-detail">					
					<p><span class="grey">Received Interest in:</span> <strong><?php echo $about_res2[title] ?></strong></p>
					<p><span class="grey">Freelance:</span> <strong class="black"><?php echo getExperience($about_res[expsector]) ?></strong></p>
					<p><span class="grey">Post Name:</span> <strong class="black"><?php echo $about_res[jobtitle] ?></strong></p>
					<?php if($subcat_res[budget]!='0' && $subcat_res[duration]!='0') { ?>
					<p><span class="grey">Budget:</span> <strong class="black"><?php echo getBudget($subcat_res[budget]) ?></strong></p>
					<p><span class="grey">Duration:</span> <strong class="black"><?php echo getDuration($subcat_res[duration]) ?></strong></p>					
					<?php } ?>
					<p><span class="grey">Nationality:</span> 
					<?php if($about_res[nationality]!=""){ echo getNationality($about_res[nationality]) ?>  <span class="grey pipe">I</span><?php } ?>
					<?php if($about_res[area]!=""){ echo '<span class="grey">Area: </span>'. $about_res[area] ?> <span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[gender]!=""){ echo '<span class="grey">Gender: </span>'. $about_res[gender] ?> <span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[mbti]!=""){ echo '<span class="grey">MBTI: </span>'. getMBTI($about_res[mbti]) ?> <span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[education]!=""){ echo '<span class="grey">Education: </span>'. getEducation($about_res[education]) ?>  <span class="grey pipe">I</span><?php } ?>   
					<?php if($about_res[degree]!=""){ echo '<span class="grey">Degree: </span>'. getDegree($about_res[degree]) ?><span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[jobtitle]!=""){ echo '<span class="grey">Job Title: </span>'. $about_res[jobtitle]; } ?></p>				
				</div>
			</div>
			<?php } ?>
			<?php			
			$subcat_query = mysql_query("SELECT * FROM freelancer_mmv_member_like WHERE user_id!='$loginid' AND postedby='$loginid'");
			while($subcat_res = mysql_fetch_array($subcat_query)){				
				$workid = $subcat_res[workid];
				$userid 	= $subcat_res[user_id];
				
				$query2 	= mysql_query("SELECT * FROM freelancer_mmv_userimages WHERE id='$workid'");
				$about_res2	= mysql_fetch_array($query2);
				
				
				$query 		= mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$userid'");
				$about_res	= mysql_fetch_array($query);
								
				//Ratings
				$noofrev_que1 = mysql_query("SELECT count(*) as con, sum(ratings) as ratingsum FROM freelancer_mmv_reviewratings WHERE reviewto='$userid'");
				$noofrev_res1 = mysql_fetch_array($noofrev_que1);
				$ratingsum1 = $noofrev_res1[ratingsum];
				$con1 = $noofrev_res1[con];
				$rateval1 = $ratingsum1/$con1;
			?>
			<?php
				$memberid = $userid;
				/*Get Distance*/
				$login_que = mysql_query("SELECT * from freelancer_mmv_member_master where member_id='$loginid'");
				$login_result = mysql_fetch_array($login_que);			
				$login_que1 = mysql_query("SELECT * from freelancer_mmv_member_master where member_id='$memberid'");
				$login_result1 = mysql_fetch_array($login_que1);
				
				$latitudeFrom = $login_result['loginlats'];
				$longitudeFrom = $login_result['loginlong'];						
				
				$latitudeTo = $login_result1['loginlats'];
				$longitudeTo = $login_result1['loginlong'];			
				$distt = distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, "K") . " Kilometers<br>";
				$finaldist = $distt;
				/*End*/
				?>
			<div class="job-thumb favourite-box">
				<div class="job-row cursor-pointer" onClick="location.href='viewclient.php?id=<?php echo $userid ?>'">
					<div class="favourite-holder">
					<?php if($about_res[image] ==""){ ?>
						<img src="images/user.png" alt=""/>
					<?php } else { ?>
						<img src="uploads/users/<?php echo $about_res[image] ?>" alt=""/>
					<?php } ?>					
					</div>
					<div class="favourite-dtl">
						<h3><a href="viewclient.php?id=<?php echo $userid ?>"><?php echo $about_res[first_name].' '.$about_res[last_name] ?> <br> <span class="km"><?php echo number_format($finaldist,1).' km' ?></span></h3></a>
						<div class="rating-div">							
							 <?php if($rateval1>='0.5' && $rateval1<'1.5'){
									echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';									
									} else if($rateval1>='1.5' && $rateval1<'2.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';	
									} else if($rateval1>='2.5' && $rateval1<'3.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';	
									} else if($rateval1>='3.5' && $rateval1<'4.5'){
										echo '<img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-yellow.png" alt="star"/>
										 <img src="images/star-grey.png" alt="star"/>';	
									} else if($rateval1>='4.5' && $rateval1<='5'){
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
							 <span class="number">( <?php echo $con1; ?> )</span>
						</div><p class="red">Liked</p>
					</div>
				</div>
				<div class="job-row favourite-detail">
					<p><span class="grey">Freelance:</span> <strong class="black"><?php echo getExperience($about_res[expsector]) ?></strong></p>
					<p><span class="grey">Post Name:</span> <strong class="black"><?php echo $about_res[jobtitle] ?></strong></p>
					<p><span class="grey">Nationality:</span> 
					<?php if($about_res[nationality]!=""){ echo getNationality($about_res[nationality]) ?>  <span class="grey pipe">I</span><?php } ?>
					<?php if($about_res[area]!=""){ echo '<span class="grey">Area: </span>'. $about_res[area] ?> <span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[gender]!=""){ echo '<span class="grey">Gender: </span>'. $about_res[gender] ?> <span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[mbti]!=""){ echo '<span class="grey">MBTI: </span>'. getMBTI($about_res[mbti]) ?> <span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[education]!=""){ echo '<span class="grey">Education: </span>'. getEducation($about_res[education]) ?>  <span class="grey pipe">I</span><?php } ?>   
					<?php if($about_res[degree]!=""){ echo '<span class="grey">Degree: </span>'. getDegree($about_res[degree]) ?><span class="grey pipe">I</span><?php } ?> 
					<?php if($about_res[jobtitle]!=""){ echo '<span class="grey">Job Title: </span>'. $about_res[jobtitle]; } ?></p>
				</div>
			</div>
			<?php } ?>					
		</div>
	</div>
</div>
<!--end main-->
<?php include "footer.php"; ?>
<script type="text/javascript" src="js/jquery.sticky.js"></script>
<script type="text/javascript">
    $(window).load(function(){
		$("#header").sticky({ topSpacing: $('header').innerHeight() + $('#sticktabs').innerHeight()});
		$("#sticktabs").sticky({ topSpacing: $('header').height()});		
    });
</script>