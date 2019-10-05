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

if($_SESSION[SESS_CAT_ID]==""){
	$filterid = '';
} else {	
	$filterid = "AND expsector=".$_SESSION[SESS_CAT_ID];	
}
?>

<!--<form name="meetinginvite" id="meetinginvite" action="invite-request.php" method="post">-->
<form name="meetinginvite" id="meetinginvite" action="redirect.php" method="post">
<!--start main-->
<div class="main">		
	<section class="contenets-main">
		<!--start post job -->
		
		<div class="contenets post-a-job-main" style="min-height:700px;">
			<!--<label class="control control--checkbox select-all">Select All
				<input type="checkbox" name="selectAll" />
				<div class="control__indicator"></div>
			</label>-->
			<?php
			if($_SESSION[countryid]==""){					
				$about_que = mysql_query("SELECT * from freelancer_mmv_member_master where 1=1 AND member_id!='$loginid' $filterid AND status='1'");				
			} else {				
				$about_que = mysql_query("SELECT * from freelancer_mmv_member_master where 1=1 AND country='$countryid' AND member_id!='$loginid' $filterid AND status='1'");
			}
			while($about_res = mysql_fetch_array($about_que))
			{
				$memid = $about_res[member_id];
					/*$latitudeFrom = $_GET['currentlat'];
					$longitudeFrom = $_GET['currentlong'];
					
					$latitudeTo = $about_res['loginlats'];
					$longitudeTo = $about_res['loginlong'];
					
					//Calculate distance from latitude and longitude
					$theta = $longitudeFrom - $longitudeTo;
					$dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
					$dist = acos($dist);
					$dist = rad2deg($dist);
					$miles = $dist * 60 * 1.1515;
					$distance = ($miles * 1.609344);*/
					
				//Ratings
				$noofrev_que = mysql_query("SELECT count(*) as con, sum(ratings) as ratingsum FROM freelancer_mmv_reviewratings WHERE reviewto='$memid'");
				$noofrev_res = mysql_fetch_array($noofrev_que);
				$ratingsum = $noofrev_res[ratingsum];
				$con = $noofrev_res[con];
				$rateval = $ratingsum/$con;
			?>
			<div class="control-group">
				<div class="job-thumb favourite-box for-rating">
					<div class="job-row" onClick="location.href='viewclient.php?id=<?php echo $about_res[member_id] ?>'">
						<div class="favourite-holder">
						<?php if($about_res[image] ==""){ ?>
								<img src="images/user.png" alt=""/>
							<?php } else { ?>
								<img src="uploads/users/<?php echo $about_res[image] ?>" alt=""/>
							<?php } ?>
						</div>
						<div class="favourite-dtl">
							<h3><?php echo $about_res[first_name].' '. $about_res[created]; ?>
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
							</h3>
						</div>
					</div>
					<div class="job-row thumb-row">
						<div class="favourite-holder">
							<label class="control control--checkbox"> 
								<input type="checkbox" name="invitehire" class="invitehire" id="invitehire" value="<?php echo $about_res[member_id] ?>"/>
								<input type="hidden" name="invitehireeee[]" id="invitehireeee" class="invitehireeee" value="<?php echo $about_res[member_id] ?>"/>
								<div class="control__indicator"></div>
							</label>
						</div>
						<div class="favourite-dtl">
							<p><span class="grey">Location:</span> <?php echo getNationality($about_res[nationality]) ?>, <?php echo getArea($about_res[area]) ?>  <?php echo $about_res[gender] ?>  <?php echo getMBTI($about_res[mbti]) ?>  <?php echo getEducation($about_res[education]) ?>    <?php echo getDegree($about_res[degree]) ?> <?php echo getJob($about_res[jobtitle]) ?><br />
							<span class="grey">Freelancing:</span> <strong class="black"><?php echo getExperience($about_res[expsector]) ?></strong></p>
							<div class="km-last-seen">
								<div class="km-left"><?php //echo round($distance).' km' ?></div>
								<div class="last-seen-right">Last seen 25/12/2017 | 03:13 PM</div>
							</div>
						</div>
					</div>
				</div>				
			</div>
			<?php } ?>
			<p><br><br></p>
		</div>
		
		<!--end post job -->
	</section>
</div>
<!--end main-->
<!--start meet invite-->
<div class="menu-wrapper-sub">
<div class="meet-invite">
	<div class="meet-invite-sub">
	<?php if($loginid!=''){ ?>
		<a href="#" class="meet-link">		
			<button type="submit"  name="submit" id="submit" style="border: none; background: none;cursor:pointer"> 
				<span class="meet-icon"></span>
				<span class="mi-title">Meet</span>
			</button>		
		</a>
	<?php } else { ?>
		<a href="#" data-fancybox data-type="inline" data-src="#loginPopup" class="meet-link">		
			<span class="meet-icon"> </span>
			<span class="mi-title">Meet</span>		
		</a>
	<?php } ?>

	<?php if($loginid!=''){ ?>
		<a href="#" class="invite-link">
			<button name="invitesubmit" id="invitesubmit" style="border:none; background:none;cursor:pointer"> 
				<span class="meet-icon"></span>
				<span class="mi-title">Invite</span>
			</button>
		</a>
	<?php } else { ?>
		<a href="javascript;;" data-fancybox data-type="inline" data-src="#loginPopup" class="invite-link">
		<span class="meet-icon"> </span>
		<span class="mi-title">Invite</span></a>
	<?php } ?>
	</div>
</div>
</div>
<script type='text/javascript'>
	
$("#submit").click(function(){ 
	//If more than 15 are checked - don't allow
	if($('.invitehire:checkbox:checked').length == 0){
		alert('Please select atleast one user');
		return false;
	} 
});

$("#invitesubmit").click(function(){ 
	//If more than 15 are checked - don't allow
	if($('.invitehire:checkbox:checked').length == 0){
		alert('Please select atleast one user');
		return false;
	} 
});
</script>

<!--<div class="meet-invite">
	<a href="meeting-request.html" class="meet-link">
		<span class="meet-icon"> </span>
		<span class="mi-title">Meet</span>
	</a>
	<a href="invite-request.php" id="submit" class="invite-link">
		<span class="meet-icon"> </span>
		<span class="mi-title">Invite</span>
	</a>	
</div>-->

</form>
<!--end meet invite-->
<?php include "footer.php"; ?>
<script type="text/javascript">

	/*$('.invite-link').on('click', function(e) {
		e.preventDefault(); // prevents a window.location change to the href
		$('#invitehireeee').val( $(this).data('val') );  // sets to 123 or abc, respectively
		$('#meetinginvite').submit();
	});*/
	
	/*$('#meetinginvite').on('submit', function(){ 
		alert($('#invitehireeee').val()); 
		return false;
	});
	
	$(".submit").click(function() {
		var link = $(this).attr('var');
		$('.invitehireeee').attr("value",link);
		$('.redirect').submit();
	});*/

    $(function()
    {
      $('[name="selectAll"]').change(function()
      {
        if ($(this).is(':checked')) {           
			$('.control--checkbox input').prop('checked', true);
			$('.meet-link').addClass('active');
        }
		  else{
			$('.control--checkbox input').prop('checked', false);
			  $('.meet-link').removeClass('active');
		  };
      });		
	$('.control--checkbox input').change(function()
      {
        if ($(this).is(':checked')) {           
			
        }
		  else{
			$('.select-all input').prop('checked', false);
			  $('.meet-link').removeClass('active');
		  };
      });	
    });
	
	$('#submit').addClass('invite-link');
  </script>
<script type="text/javascript">
/** NOTE: uses jQuery for quick & easy DOM manipulation **/

function getLocation(){
  var msg; 

  /** 
  first, test for feature support
  **/
  if('geolocation' in navigator){
    // geolocation is supported :)
    requestLocation();
  }else{
    // no geolocation :(
    msg = "Sorry, looks like your browser doesn't support geolocation";
    outputResult(msg); // output error message
    $('.pure-button').removeClass('pure-button-primary').addClass('pure-button-success'); // change button style
  }

  /*** 
  requestLocation() returns a message, either the users coordinates, or an error message
  **/
  function requestLocation(){
    /**
    getCurrentPosition() below accepts 3 arguments:
    a success callback (required), an error callback  (optional), and a set of options (optional)
    **/
  
    var options = {
      // enableHighAccuracy = should the device take extra time or power to return a really accurate result, or should it give you the quick (but less accurate) answer?
      enableHighAccuracy: false,
      // timeout = how long does the device have, in milliseconds to return a result?
      timeout: 5000,
      // maximumAge = maximum age for a possible previously-cached position. 0 = must return the current position, not a prior cached position
      maximumAge: 0
    };
  
    // call getCurrentPosition()
    navigator.geolocation.getCurrentPosition(success, error, options); 
  
    // upon success, do this
    function success(pos){
      // get longitude and latitude from the position object passed in
      var lng = pos.coords.longitude;
      var lat = pos.coords.latitude;
      // and presto, we have the device's location!
      msg = 'You appear to be at longitude: ' + lng + ' and latitude: ' + lat  + '<img src="https://maps.googleapis.com/maps/api/staticmap?zoom=15&size=300x300&maptype=roadmap&markers=color:red%7Clabel:A%7C' + lat + ',' + lng+ '&sensor=false">';
      outputResult(msg); // output message
      $('.pure-button').removeClass('pure-button-primary').addClass('pure-button-success'); // change button style
	 
	  document.getElementById("lats").value = lat;
	  document.getElementById("long").value = lng;
	  
	 // window.location.href = "hire.php?currentlong=" + lng+"&currentlat="+lat;
	//  window.location.href = "listing.php";
    }
  
    // upon error, do this
    function error(err){
      // return the error message
      msg = 'Error: ' + err + ' :(';
      outputResult(msg); // output button
      $('.pure-button').removeClass('pure-button-primary').addClass('pure-button-error'); // change button style
    }  
  } // end requestLocation();

  /*** 
  outputResult() inserts msg into the DOM  
  **/
  function outputResult(msg){
    $('.result').addClass('result').html(msg);
  }
} // end getLocation()

// attach getLocation() to button click
$('.pure-button').on('click', function(){
  // show spinner while getlocation() does its thing
  $('.result').html('<i class="fa fa-spinner fa-spin"></i>');
  
});
getLocation();

</script>  