<?php
session_start();
include "connection.php";
include "header.php";
include "functions.php";

if($_SESSION[countryid]==""){
	$countryid = '';
} else {
	$countryid = $_SESSION[countryid];
}
?>
<!--start main-->
<div class="main">		
	<section class="contenets-main">
		<!--start job contenets-->		
		<?php				
		if($_SESSION[countryid]==""){
			$about_que = mysql_query("SELECT * from freelancer_mmv_userimages where 1=1 AND userid!='' ORDER BY id DESC");
		} else {
			$about_que = mysql_query("SELECT * from freelancer_mmv_userimages where 1=1 AND userid!='' AND countryid='$countryid' ORDER BY id DESC");
		}
		while($about_res = mysql_fetch_array($about_que))
		{	
			 $idd 		= $about_res[id];
			 $uid 		= $about_res[userid];
			 $userinfo 	= getUserinfo($uid);
			 $jobid 	= $userinfo[15];
			 $jobdesc 	= getExperience($jobid);			 
			 
			 $like_que = mysql_query("SELECT * from freelancer_mmv_member_like where workid='$idd'");
			 $count = mysql_num_rows($like_que);
			 			 
			 $userlikcount = mysql_query("SELECT * from freelancer_mmv_member_like where workid='$idd' AND user_id='$loginid'");
			 $mycount = mysql_num_rows($userlikcount);
		?>
		<div class="contenets">
			<div class="topbar">
				<div class="container clearfix">
				<?php
				$web = $about_res[website];
				if (false === strpos($web, '://')) {
					$url = 'http://' . $web;
				}
				if($about_res[website] !=""){  ?>
					<a href="<?php echo $url; ?>" target="_blank" class="view-website">View website</a>
				<?php } ?>
					<div class="doted-main">
						<a href="javascript:void(0);" class="more-link"><img src="images/dotted-img.png" alt="More"/></a>
					</div>
				</div>
			</div>			
			<?php
			$extension = end(explode(".", $about_res[image]));
			if($extension=="MP4"||$extension=="mp4") {
			?>			
			<div class="contenets-img" align="center">
				<video width="425" height="320" controls>
				  <source src="<?php echo $about_res[image]; ?>" type="video/mp4">
				  <source src="<?php echo $about_res[image]; ?>" type="video/ogg">
				Your browser does not support the video tag.
				</video>				
			</div>
			<!--<div class="photo-video gallery">
			<div class="photo-div" style="width:100%">
				<a href="https://www.youtube.com/embed/<?php echo $videoname ?>?enablejsapi=1&wmode=opaque" class="play-link video-link fancybox.iframe" data-fancybox="images">
				<img height="320px;" src="http://img.youtube.com/vi/<?php echo $videoname ?>/mqdefault.jpg" alt="photo"/><img src="images/play-icon.png" class="play-icon" alt="photo"/></a></div></div>-->	
			<?php } else { ?>
			<div class="contenets-img">
				<img src="<?php echo $about_res[image]; ?>" height="320px" alt=""/>
			</div>
			<?php } ?>
				
			
			<div class="btmbar">
				<div class="container clearfix">
					<table width="100%">
						<tr>
							<td class="job-posted-user">
							<?php if($uid==$loginid){ ?>
								<a href="profile.php"><?php echo $userinfo[3].'<br>'.$userinfo[4] ?></a>
							<?php } else { ?>
								<a href="viewclient.php?id=<?php echo $uid ?>"><?php echo $userinfo[3].'<br>'.$userinfo[4] ?></a>
							<?php } ?>
							</td>
							
							<?php if($uid==$loginid){ ?>
							<td align="center" class="job-title"><a href="profile.php"><?php echo $jobdesc ?></a></td>								
							<?php } else { ?>
							<td align="center" class="job-title"><a href="viewclient.php?id=<?php echo $uid ?>"><?php echo $jobdesc ?></a></td>								
							<?php } ?>
							
							<?php
							if($loginid!=''){
							if($mycount<1){ 
							?>
								<td class="likes-div" style="cursor:pointer"><i id="delete_<?php echo $about_res[id] ?>" class="fa">&#xf08a;</i> <a href="likers.php?id=<?php echo $idd; ?>"><span id="this<?php echo $about_res[id] ?>"><?php echo $count; ?></span> likes</a></td>
							<?php } else { ?>
								<td class="likes-div" style="cursor:pointer"><i class="fa">&#xf08a;</i><a href="likers.php?id=<?php echo $idd; ?>"> <?php echo $count; ?> likes</a></td>
							<?php } } else { ?>
								<td class="likes-div" style="cursor:pointer"><a href="#" data-fancybox data-type="inline" data-src="#loginPopup"><i class="fa">&#xf08a;</i> <?php echo $count; ?> likes</a></td>
							<?php }  ?>
						</tr>
					</table>					
				</div>
			</div>
		</div>
		<?php } ?>
		<!--end job contenets-->		
	</section>
</div>
<!--end main-->
<script>
$(function(){
	$("[id^='delete_']").click(function(){
     	var i=$(this).attr('id');		
   	 	var arr=i.split("_");
   	 	var i=arr[1];   	 	 		
   	 	 $.ajax({
			type:"POST",
			data:"id="+i,
			url:"likescript.php",
			success:function(data)
			{
				if(data!="")
				{						
					$('#this'+i).text(data);					
				}
			}
		  });		 
     });
});
</script>
<?php include "footer2.php"; ?>