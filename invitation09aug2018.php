<?php
session_start();
include "connection.php";
include "headerinvitation.php";
include "functions.php";
?>
<!--start main-->
<div class="main">	
	<div id="sticktabs" class="notification-main">
		<!--<div class="notify-title">Notification</div>-->
		<table class="notification-links tabs">
			<tr>
				<td>
					<a href="invitation.php" class="active">
						<span class="tabs-title">Invitation</span>
						<?php
							$banner_que = mysql_query("SELECT * from freelancer_mmv_member_invitation where status=1 AND user_id='$loginid' AND readstatus=0");
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
							$cal_que = mysql_query("SELECT * from freelancer_mmv_member_invitation where status=1 AND user_id='$loginid' AND acceptedstatus=1 AND calreadstatus=0");
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
	<div class="notification-dtl">
		<div class="notification">
			<div id="header" class="update-location-div">
				<a href="javascript:void(0);" class="update-location"><img src="images/update-location.png" alt="update location"/> Update Location</a>
			</div>	
			<?php				
			$banner_que = mysql_query("SELECT * from freelancer_mmv_member_invitation where status=1 AND invited_userid='$loginid' ORDER BY invitation_id DESC ");
			while($banner_result = mysql_fetch_array($banner_que))
			{	
				if($banner_result[invited_userid ]!='0'){
				$invitedid = $banner_result[user_id];	
				$invinfo = getUserinfo($invitedid);					
			?>			
			<div class="job-thumb cursor-pointer" >
				<div class="job-row">
				<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
					<div class="job-thumb-holder">
						<?php if($invinfo[11] ==""){ ?>
								<img src="images/user.png" alt=""/>
							<?php } else { ?>
								<img src="uploads/users/<?php echo $invinfo[11]?>" width="105" height="105" alt=""/>
							<?php } ?>
					</div>
				</a>	
					<div class="job-dtl">
						<div class="meeting-row"> 
						<?php if($banner_result[edited]==1 && $banner_result[acceptedstatus]==0) { ?>
							<span class="red">Edited Meeting</span> with <span class="km"><!--03Km--></span>
						<?php } else if ($banner_result[acceptedstatus]==1)  { ?>
							<span class="red">Accepted Meeting</span> with <span class="km"><!--03Km--></span>
						<?php }  else { ?>
							<span class="green">Invitation</span> from <span class="km"><!--03Km--></span>
						<?php } ?>						
						</div>
						<h3><a href="viewclient.php?id=<?php echo $invitedid ?>"><?php echo $invinfo[3].' '.$invinfo[4] ; ?></a></h3>
						<?php if($banner_result[edited]==1 && $banner_result[acceptedstatus]==0 && $banner_result[invitationtype]==0) { ?>
							<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
						<?php } else if ($banner_result[acceptedstatus]==1 && $banner_result[invitationtype]==0)  { ?>
							<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
						<?php }  else { ?>
							<a onClick="location.href='invitation-from.php?id=<?php echo $banner_result[invitation_id]; ?>'">
						<?php } ?>
						<div class="date-time">
							<span>Date Time: </span> <?php echo $banner_result[meetingdate]; ?>
							<!--<div class="time"><span>Time:</span> 2.30PM</div>-->
						</div>	
						</a>
					</div>
				</div>				
				<div class="job-row location-main">
					<span class="location-pin"><img src="images/location-pin.png" alt="location"/></span>
					<?php if($banner_result[acceptedstatus]==1){ ?>
						<a class="send-mesage" href="messages-detail2.php?id=<?php echo $banner_result[user_id]; ?>">Send<br />Message</a>
					<?php } ?>
					<?php if($banner_result[edited]==1 && $banner_result[acceptedstatus]==0 && $banner_result[invitationtype]==0) { ?>
							<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
						<?php } else if ($banner_result[acceptedstatus]==1 && $banner_result[invitationtype]==0)  { ?>
							<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
						<?php }  else { ?>
							<a onClick="location.href='invitation-from.php?id=<?php echo $banner_result[invitation_id]; ?>'">
						<?php } ?>
					
					<div class="location-address">
						<!--<p>Baitik Mall, Safat area, Block4, Street Amro ibnu almunthir ja- ddah3 ,Caribou Cafe</p>-->
						<p><?php echo $banner_result[location]; ?></p>
					</div>
					<div class="wordaapp">Exact Location using What 3 worda app</div>
					<div class="butchers">butchers.flattening.padded</div>
					</a>
				</div>
			</div>
			<?php } } ?>
			
			<?php				
			$banner_que = mysql_query("SELECT * from freelancer_mmv_member_invitation where status=1 AND user_id='$loginid' AND acceptedstatus =1 ORDER BY invitation_id DESC");
			while($banner_result = mysql_fetch_array($banner_que))
			{	
				if($banner_result[invited_userid ]!='0'){
				$invitedid = $banner_result[invited_userid];	
				$invinfo = getUserinfo($invitedid);					
			?>			
			<div class="job-thumb cursor-pointer">
				<div class="job-row">
				<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
					<div class="job-thumb-holder">
						<?php if($invinfo[11] ==""){ ?>
								<img src="images/user.png" alt=""/>
							<?php } else { ?>
								<img src="uploads/users/<?php echo $invinfo[11]?>" width="105" height="105"/>
							<?php } ?>
					</div>
			   </a>
					<div class="job-dtl">						
						<h3><a href="viewclient.php?id=<?php echo $invitedid ?>"><?php echo $invinfo[3].' '.$invinfo[4] ; ?></a></h3>
						<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
						<?php if($banner_result[acceptedstatus]==1){ ?>
							<div class="meeting-row">
								<span class="red">Accepted Meeting</span> <span class="km"><!--03Km--></span>
							</div>
						<?php } else if($banner_result[acceptedstatus]==2){ ?>
							<div class="meeting-row">
								<span class="red">Rejected Meeting</span> <span class="km"><!--03Km--></span>
							</div>
						<?php } ?>
						<div class="date-time">
							<span>Date Time: </span> <?php echo $banner_result[meetingdate]; ?>
							<!--<div class="time"><span>Time:</span> 2.30PM</div>-->
						</div>	
						</a>	
					</div>
				</div>									
				<div class="job-row location-main">
					<span class="location-pin"><img src="images/location-pin.png" alt="location"/></span>
					<?php if($banner_result[acceptedstatus]==1){ ?>
						<a class="send-mesage" href="messages-detail2.php?id=<?php echo $banner_result[invited_userid]; ?>">Send<br />Message</a>
					<?php } ?>
					<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
					<div class="location-address">
						<!--<p>Baitik Mall, Safat area, Block4, Street Amro ibnu almunthir ja- ddah3 ,Caribou Cafe</p>-->
						<p><?php echo $banner_result[location]; ?></p>
					</div>
					<div class="wordaapp">Exact Location using What 3 worda app</div>
					<div class="butchers">butchers.flattening.padded</div>
					</a>
				</div>				
			</div>
			<?php } } ?>
			
			<?php				
			$banner_que = mysql_query("SELECT * from freelancer_mmv_member_invitation where status=1 AND user_id='$loginid' AND acceptedstatus =2 ORDER BY invitation_id DESC");
			while($banner_result = mysql_fetch_array($banner_que))
			{	
				if($banner_result[invited_userid ]!='0'){
				$invitedid = $banner_result[invited_userid];	
				$invinfo = getUserinfo($invitedid);					
			?>			
			<div class="job-thumb cursor-pointer">
				<div class="job-row">
				<a onClick="location.href='invitation-from-rejected.php?id=<?php echo $banner_result[invitation_id]; ?>'">
					<div class="job-thumb-holder">
						<?php if($invinfo[11] ==""){ ?>
								<img src="images/user.png" alt=""/>
							<?php } else { ?>
								<img src="uploads/users/<?php echo $invinfo[11]?>" width="105" height="105"/>
							<?php } ?>
					</div>
			   </a>
					<div class="job-dtl">						
						<h3><a href="viewclient.php?id=<?php echo $invitedid ?>"><?php echo $invinfo[3].' '.$invinfo[4] ; ?></a></h3>
						<a onClick="location.href='invitation-from-rejected.php?id=<?php echo $banner_result[invitation_id]; ?>'">
						<?php if($banner_result[acceptedstatus]==1){ ?>
							<div class="meeting-row">
								<span class="red">Accepted Meeting</span> <span class="km"><!--03Km--></span>
							</div>
						<?php } else if($banner_result[acceptedstatus]==2){ ?>
							<div class="meeting-row">
								<span class="red">Rejected Meeting</span> <span class="km"><!--03Km--></span>
							</div>
						<?php } ?>
						<div class="date-time">
							<span>Date Time: </span> <?php echo $banner_result[meetingdate]; ?>
							<!--<div class="time"><span>Time:</span> 2.30PM</div>-->
						</div>	
						</a>	
					</div>
				</div>									
				<div class="job-row location-main">
					<span class="location-pin"><img src="images/location-pin.png" alt="location"/></span>
					<?php if($banner_result[acceptedstatus]==1){ ?>
						<a class="send-mesage" href="messages-detail2.php?id=<?php echo $banner_result[invited_userid]; ?>">Send<br />Message</a>
					<?php } ?>
					<a onClick="location.href='invitation-from-rejected.php?id=<?php echo $banner_result[invitation_id]; ?>'">
					<div class="location-address">
						<!--<p>Baitik Mall, Safat area, Block4, Street Amro ibnu almunthir ja- ddah3 ,Caribou Cafe</p>-->
						<p><?php echo $banner_result[location]; ?></p>
					</div>
					<div class="wordaapp">Exact Location using What 3 worda app</div>
					<div class="butchers">butchers.flattening.padded</div>
					</a>
				</div>				
			</div>
			<?php } } ?>
			
			
			<?php				
			$banner_que = mysql_query("SELECT * from freelancer_mmv_member_invitation where status=1 AND user_id='$loginid' AND edited='1' AND acceptedstatus='0' ORDER BY invitation_id DESC ");
			while($banner_result = mysql_fetch_array($banner_que))
			{	
				if($banner_result[invited_userid ]!='0'){
				$invitedid = $banner_result[invited_userid];	
				$invinfo = getUserinfo($invitedid);					
			?>			
			<div class="job-thumb cursor-pointer">
				<div class="job-row">
				<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
					<div class="job-thumb-holder">
						<?php if($invinfo[11] ==""){ ?>
								<img src="images/user.png" alt=""/>
							<?php } else { ?>
								<img src="uploads/users/<?php echo $invinfo[11]?>" width="105" height="105"/>
							<?php } ?>
					</div>
					</a>
					<div class="job-dtl">
						<div class="meeting-row">
							<span class="red">Edited Meeting</span> with <span class="km"><!--03Km--></span>
						</div>
						<h3><a href="viewclient.php?id=<?php echo $invitedid ?>"><?php echo $invinfo[3].' '.$invinfo[4] ; ?></a></h3>
						<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
						<div class="date-time">
							<span>Date Time: </span> <?php echo $banner_result[meetingdate]; ?>							
						</div>
						</a>						
					</div>
				</div>				
				<div class="job-row location-main">
					<span class="location-pin"><img src="images/location-pin.png" alt="location"/></span>
					<?php if($banner_result[acceptedstatus]==1){ ?>
						<a class="send-mesage" href="messages-detail2.php?id=<?php echo $banner_result[invited_userid]; ?>">Send<br />Message</a>
					<?php } ?>
					<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
					<div class="location-address">
						<!--<p>Baitik Mall, Safat area, Block4, Street Amro ibnu almunthir ja- ddah3 ,Caribou Cafe</p>-->
						<p><?php echo $banner_result[location]; ?></p>
					</div>
					<div class="wordaapp">Exact Location using What 3 worda app</div>
					<div class="butchers">butchers.flattening.padded</div>
					</a>
				</div>
			</div>
			<?php } } ?>
			
			<?php				
			$banner_que = mysql_query("SELECT * from freelancer_mmv_member_invitation where status=1 AND user_id='$loginid' AND edited='0' AND acceptedstatus='0' ORDER BY invitation_id DESC ");
			while($banner_result = mysql_fetch_array($banner_que))
			{	
				if($banner_result[invited_userid ]!='0'){
				$invitedid = $banner_result[invited_userid];	
				$invinfo = getUserinfo($invitedid);					
			?>			
			<div class="job-thumb cursor-pointer" onClick="location.href='hire-detail-edit.php?id=<?php echo $banner_result[invitation_id]; ?>'">
				<div class="job-row">
				<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
					<div class="job-thumb-holder">
						<?php if($invinfo[11] ==""){ ?>
								<img src="images/user.png" alt=""/>
							<?php } else { ?>
								<img src="uploads/users/<?php echo $invinfo[11]?>" width="105" height="105"/>
							<?php } ?>
					</div>
					</a>
					<div class="job-dtl">
						<div class="meeting-row">
							<span class="red">Meeting </span>request with <span class="km"><!--03Km--></span>
						</div>
						<h3><a href="viewclient.php?id=<?php echo $invitedid ?>"><?php echo $invinfo[3].' '.$invinfo[4] ; ?></a></h3>
						<div class="date-time">
							<span>Date Time: </span> <?php echo $banner_result[meetingdate]; ?>
							<!--<div class="time"><span>Time:</span> 2.30PM</div>-->
						</div>						
					</div>
				</div>				
				<div class="job-row location-main">
					<span class="location-pin"><img src="images/location-pin.png" alt="location"/></span>
					<?php if($banner_result[acceptedstatus]==1){ ?>
						<a class="send-mesage" href="messages-detail2.php?id=<?php echo $banner_result[invited_userid]; ?>">Send<br />Message</a>
					<?php } ?>
					<a onClick="location.href='hire-detail-receiver.php?id=<?php echo $banner_result[invitation_id]; ?>'">
					<div class="location-address">
						<!--<p>Baitik Mall, Safat area, Block4, Street Amro ibnu almunthir ja- ddah3 ,Caribou Cafe</p>-->
						<p><?php echo $banner_result[location]; ?></p>
					</div>
					<div class="wordaapp">Exact Location using What 3 worda app</div>
					<div class="butchers">butchers.flattening.padded</div>
					</a>
				</div>
			</div>
			<?php } } ?>
			
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