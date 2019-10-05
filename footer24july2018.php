<?php
session_start();
include "connection.php";

$loginid = end($_SESSION[SESS_MEMBER_ID]);
$query = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$loginid'");
$res = mysql_fetch_array($query);

?>
<style>
.form-control{font-size:18px;line-height:27px;padding:15px 10px;  }
</style>
<!--start menubar-->
<div class="menu-wrapper">
	<div class="menu-main">
		<div class="menu-main-sub">
			<div class="loged-user">
				<div class="loged main-user">
					<div class="loged-user-img"><img src="uploads/users/<?php echo $res[image]?>" alt="" /></div>
					<div class="loged-user-title"><?php echo $res[first_name].' '.$res[last_name] ?></div>
				</div>
				
				<ul class="subuser">
				<?php					
				$sess = (array_unique($_SESSION['SESS_MEMBER_ID']));
				
				foreach(($sess) as $key=>$uservalue)
				{					
					$query2 = mysql_query("SELECT * FROM freelancer_mmv_member_master WHERE member_id='$uservalue'");
					$res2 = mysql_fetch_array($query2);	
					if($loginid==$uservalue){
						
				}else{
					
				?>
					<a href="changesessionval.php?id=<?php echo $uservalue ?>"><li class="loged">
						<div class="loged-user-img"><img src="uploads/users/<?php echo $res2[image]?>" alt="" /></div>
						<div class="loged-user-title"><?php echo $res2[first_name].' '.$res2[last_name] ?></div>
					</li></a>
				<?php } } ?>
					<a data-fancybox data-type="inline" data-src="#loginPopup" href="javascript:;">				
						<li class="loged add-account">
							<div class="loged-user-img"></div>
							<div class="loged-user-title">Add Account</div>
						</li>	
					</a>					
				</ul>
				
			</div>
			<div class="menu-links">
				<ul>
					<li><a href="advance-search.php"><span class="menu-icon"><img src="images/icon-search.png" alt="Advance search" /></span> Advance search</a></li>
					<?php if($loginid!=""){ ?>
						<li><a href="profile.php"><span class="menu-icon"><img src="images/icon-upload-profile.png" alt="Profile" /></span> Edit Profile </a></li>
						<li><a href="change-password.php"><span class="menu-icon"><img src="images/icon-password.png" alt="Change Password" /></span> Change Password </a></li>
						<li><a href="buy-tokens.php"><span class="menu-icon"><img src="images/icon-buy-tokens.png" alt="Buy Tokens" /></span> Buy Tokens</a></li>
						<li><a href="tokens-balance.php"><span class="menu-icon"><img src="images/icon-tokens-balance.png" alt="Tokens balance" /></span> Tokens balance</a></li>
						<li><a href="feedback.php"><span class="menu-icon"><img src="images/icon-feedback.png" alt="Feedback / Report" /></span> Feedback / Report</a></li>
						<li><a href="veryfied-user.php"><span class="menu-icon"><img src="images/icon-verified.png" alt="Verified User" /></span> Verified User</a></li>
					<?php } else { ?>
						<li><a href="#" data-fancybox data-type="inline" data-src="#loginPopup"><span class="menu-icon"><img src="images/icon-upload-profile.png" alt="Profile" /></span> Edit Profile </a></li>
						<li><a href="#" data-fancybox data-type="inline" data-src="#loginPopup"><span class="menu-icon"><img src="images/icon-password.png" alt="Change Password" /></span> Change Password </a></li>
						<li><a href="#" data-fancybox data-type="inline" data-src="#loginPopup"><span class="menu-icon"><img src="images/icon-buy-tokens.png" alt="Buy Tokens" /></span> Buy Tokens</a></li>
						<li><a href="#" data-fancybox data-type="inline" data-src="#loginPopup"><span class="menu-icon"><img src="images/icon-tokens-balance.png" alt="Tokens balance" /></span> Tokens balance</a></li>
						<li><a href="#" data-fancybox data-type="inline" data-src="#loginPopup"><span class="menu-icon"><img src="images/icon-feedback.png" alt="Feedback / Report" /></span> Feedback / Report</a></li>
						<li><a href="#" data-fancybox data-type="inline" data-src="#loginPopup"><span class="menu-icon"><img src="images/icon-verified.png" alt="Verified User" /></span> Verified User</a></li>
					<?php } ?>
					<li><a href="about-us.php"><span class="menu-icon"><img src="images/icon-about-us.png" alt="About Us" /></span> About Us</a></li>
					<li>
					<?php 
					if($loginid !=""){
					?>
						<a href="logout.php?id=<?php echo $loginid ?>"><span class="menu-icon"><img src="images/icon-logout.png" alt="Logout" /></span> Logout</a>
					<?php } else { ?>
						<a data-fancybox data-type="inline" data-src="#loginPopup" href="javascript:;"><span class="menu-icon"><img src="images/icon-logout.png" alt="Logout" /></span> Login</a>
					<?php } ?>					
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="close-menu"> </div>
</div>
<div class="popbox"><div id="sublinks" class="popupbox sublinks text-align-center"></div></div>
<!--end menubar-->
<!--start bottom bar-->
<div class="bottom-holder">
<div class="sub-bottom-bar">
	<!--<div class="photo-job-video">
		<div class="row">
			<div class="col-4 uploader"><a href="javascript:void(0);">Post a photo</a><div class="fileContainer"></div><input name="photo" type="file" id="post-photo-upload" maxlength="1" class="multi with-preview" /></div>
			<div class="col-4"><a href="post-a-job.php" class="post-a-job">Post a job</a></div>
			<div class="col-4 uploader"><a href="javascript:void(0);">Post a Video</a><div class="fileContainer"></div><input name="files[]" type="file" id="post-video-upload" maxlength="1" class="multi with-preview" /></div>
		</div>
	</div>-->
	<form name="upload" id="imageform" action='ajaximage.php' method="post" enctype="multipart/form-data">
		<div class="photo-job-video">
			<div class="row" style="margin-bottom: 0px;">
			<?php if($loginid==""){ ?>
				<div class="col-4 uploader"><a data-fancybox data-type="inline" data-src="#loginPopup" href="javascript:void(0);">Post a photo</a></div>
				<div class="col-4"><a data-fancybox data-type="inline" data-src="#loginPopup" href="javascript:void(0);" class="post-a-job">Post a job</a></div>
				<div class="col-4 uploader"><a href="javascript:void(0);" data-fancybox data-type="inline" data-src="#loginPopup">Post a Video</a></div>
			<?php } else { ?>
				<div class="col-4 uploader"><a href="javascript:void(0);" data-fancybox data-type="inline" data-src="#imgPopup">Post a photo</a><div class="fileContainer"></div>
				<!--<input name="photoimg" accept=".jpg, .jpeg, .png" type="file" id="post-photo-upload" required class="multi with-preview"/>
				<a href="javascript:void(0);" data-fancybox data-type="inline" data-src="#videoPopup">Post a Photo</a>-->
				</div>
				<div class="col-4"><a href="post-a-job.php" class="post-a-job">Post a job</a></div>
				<div class="col-4 uploader"><a href="javascript:void(0);" data-fancybox data-type="inline" data-src="#videoPopup">Post a Video</a><div class="fileContainer"></div>
				<!--<a href="javascript:void(0);" data-fancybox data-type="inline" data-src="#videoPopup">Post a Video</a>
				<input name="videoimg" accept=".mp4" type="file" id="post-video-upload" required class="multi with-preview"/>--></div>
			<?php } ?>							
			</div>			
		</div>
	</form>	
	<div class="work-hire-main">
		<div class="container clearfix">
		<?php //if($_SESSION[SESS_MEMBER_ID]==""){ ?>
			<!--<a data-fancybox data-type="inline" data-src="#loginPopup" href="javascript:;" class="home-link"><img src="images/home-icon.png" alt="Home"/></a>-->
		<?php //} else { ?>
			<a href="index.php" class="home-link"><img src="images/home-icon.png" alt="Home"/></a>
		<?php //}	?>
			<a href="listing.php" class="work-link">WORK</a>
			<a href="javascript:void(0);" class="plus-link">+</a>
			<a href="hire.php" class="hire-link">HIRE</a>
			<a href="javascript:void(0);" class="menu-link slidmenu"><img src="images/menu-icon.png" alt="Menu"/></a>
		</div>
	</div>
</div>
</div>
<!--end bottom bar-->
<!--start other popup boxes-->
<a data-fancybox="" data-type="inline" data-src="#loginPopup" href="javascript:void(0);" class="loginPopupLink none"></a>
<div class="popbox">
	<div id="loginPopup" class="popupbox text-align-center">	
		<div class="login-main">
		<form name="login" method="post" action="submitregister.php">
		<input type="hidden" name="lats" id="lats" value="">	
		<input type="hidden" name="long" id="long" value="">
			<div class="form-group">						
				<input type="text" name="lusername" required class="form-control text-align-center inputbg" placeholder="User name" id="lusername">
			</div>
			<div class="form-group">						
				<input type="password" name="lpassword" required class="form-control text-align-center inputbg" placeholder="Password" id="lpassword">
			</div>
			<div class="form-group">
				<button type="submit" name="login" class="button loginbtn">Log In</button>
				<div><a href="javascript:void(0);" class="forgot-pass">Forgot your password</a></div>
			</div>
		</form>
			<form name="login" method="post" action="submitregister.php">
				<div class="forgotpass-main">
					<div class="form-group">						
						<input type="text" name="email" class="form-control text-align-center inputbg" placeholder="Email Address" id="">
					</div>
					<div class="form-group">
						<button type="submit" name="forgot" class="button loginbtn">Reset Password</button>
					</div>
				</div>
			</form>
		</div>
	</form>
		<div class="registered-main">
			<p>Not registered yet!</p>
			<a href="register.php" class="button light-yellow registered-btn">Register Now</a>
		</div>
	</div>
	
	<div id="imgPopup" class="popupbox text-align-center">	
		<div class="login-main">		
			<form name="login" method="post" action="" enctype="multipart/form-data">
				<div class="for gotpass-main">	
				<div class="form-group">
						<div id="upload-demo" ></div>
				</div>
				<div class="form-group">					
						<input name="photoimg" accept=".jpg, .jpeg, .png" type="file" id="upload" required class="form-control with-preview inputbg"/>
					</div>
					<div class="form-group">						
						<input type="text" name="videolink" id="videolink" class="form-control text-align-center inputbg" placeholder="Website URL" id="">
					</div>
					<div class="col-md-4" style="">						
				</div>
					<div class="form-group">
						<button class="button loginbtn upload-result">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</form>		
	</div>
	
	<div id="videoPopup" class="popupbox text-align-center">	
		<div class="login-main">		
			<form name="login" method="post" action="submitregister.php" enctype="multipart/form-data">
				<div class="for gotpass-main">
					<div class="form-group">						
						<input name="videoimg" accept=".mp4" type="file" id="videoimg" required class="form-control with-preview inputbg"/>
					</div>
					<div class="form-group">						
						<input type="text" name="videolink" class="form-control text-align-center inputbg" placeholder="Website URL" id="">
					</div>
					<div class="form-group">
						<button type="submit" name="submitvideo" class="button loginbtn">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</form>		
	</div>
	
	
	
	<a data-fancybox="" data-type="inline" data-src="#alertPopup" href="javascript:void(0);" class="alertPopupLink none"></a>
	<div class="popbox">
		<div id="alertPopup" class="popupbox text-align-center abuseOption">
		<form name="abuse" method="post" action="">	
		<input type="hidden" name="postid" id="postid" value=""/>
			<h2>Alert!</h2>
			<p>Account has been activated!!</p>
			</form>
		</div>

	</div>
</div>
</div>

<script src="js/jquery.js"></script> 
<script src="js/croppie.js"></script>
<!--<link rel="stylesheet" href="css/bootstrap-3.min.css">-->
<link rel="stylesheet" href="css/croppie.css">
<script type="text/javascript">
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 300,
        height: 300,        
    },
    boundary: {
       width: 350,
	   height:350
    }
});


$('#upload').on('change', function () { 
	var reader = new FileReader();
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
    	}).then(function(){
    		console.log('jQuery bind complete');
    	});
    	
    }
    reader.readAsDataURL(this.files[0]);
});


$('.upload-result').on('click', function (ev) {
	var video = $('#videolink').val();
	var data;
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
		$.ajax({
			url: "ajaxpro.php",
			type: "POST",
			data: {"image":resp,"video":video},
			//dataType: "json",
			async: false,
			success: function (data) {
			  if(data != null){
				myFunction(data);									
			  }	
			}
		});
	});
});

</script>

<script type="text/javascript">
$(".reviewPopupBtn").on('click', function() {
  $.fancybox.open({
    src  : '#reviewPopup',
    type : 'inline',
    opts : {
      afterShow : function( instance, current ) {
        console.info('done!');
      }
    }
  });
}); 
</script>
<script>

function myFunction(data) {	
    /*var txt;	
    var r = confirm("Are you sure you want to proceed to pay $1 ?");
    if (r == true) {*/		
		  window.location.href="paypal.php?uid=<?php echo $loginid; ?>&imgid="+data; 
		  alert('Please wait..!!');
		 
    /*} else {
        txt = "You pressed Cancel!";
    }   */ 
}

$( "#selectcountry" ).change(function() {	
	var country = $( "#selectcountry" ).val();
	$.ajax({
		type:"POST",
		data:"id="+country,
		url:"backend.php",
		success:function(data)
		{
			location.reload();	
		}
	  });	
});

/*$(document).ready(function() { 		
	$('#post-photo-upload').on('change', function(){	
	$("#imageform").ajaxForm({
		success: function() {               
			myFunction();
			//location.reload();
		} ,
		error: function() {               
			alert('Upload failed!!');
		}				  
				
	}).submit();		
	});	
});*/

/*$(document).ready(function() { 		
	$('#post-video-upload').on('change', function(){	
	$("#imageform").ajaxForm({
		success: function(msg) {
			alert(msg);
			if(msg=='Max file size is 2 MB'){
				return false;
			} else if(msg=='Invalid file format..')	{
				return false;
			} else if(msg=='Failed'){
				return false;
			} else {
				//alert('Video Uploaded!!');
				myFunction();
				location.reload();
			}
			
		} ,
		error: function() {               
			alert('Upload failed!!');
		}				  
				
	}).submit();		
	});	
});*/

</script>
<script type="text/javascript" src="js/rating.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/fontsmoothie.min.js"></script>
<script type="text/javascript" src="js/jquery.selectric.js"></script>
<script type="text/javascript" src="js/file-upload.js"></script>
<script src="upload/jquery.form.js" type="text/javascript" language="javascript"></script>
<script src="upload/jquery.MetaData.js" type="text/javascript" language="javascript"></script>
<script src="upload/jquery.MultiFile.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="lightbox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!--<script type="text/javascript" src="js/geoLocation.js"></script>-->
<script>

$(window).load(function() {
	"use strict";	
	adjustWidthHeight();	
	<?php if($_REQUEST[status]=='activated'){ ?>
		//$('.alertPopupLink').trigger('click');
		$('.loginPopupLink').trigger('click');
	<?php } ?>
});

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
</body>
</html>