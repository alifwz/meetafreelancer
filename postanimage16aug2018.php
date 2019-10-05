<?php
session_start();
include "connection.php";
include "header.php";
?>
  <script src="js/jquery.js"></script> 
  <link  href="js/cropper.min.css" rel="stylesheet">
  <script src="js/cropper.min.js"></script>
<div class="main">
		<div class="login-main">		
			<form name="login" method="post" action="" enctype="multipart/form-data">
			<input type="hidden" name="freelanceserviceid" id="freelanceserviceid" value="<?php echo $freelanceserviceid; ?>">
				<div class="for gotpass-main">	
				<div class="form-group">
						<div class="image_container" style="max-height:350px">
							<img id="blah" src="#" alt="" />
						</div>
						<div id="cropped_result" style="display:none"></div> 
				</div>
					<div class="form-group">					
						<input name="image" onchange="readURL(this);" accept=".jpg, .jpeg, .png" type="file" id="image" required class="form-control "/>
					</div>
					<div class="form-group" style="display:none">						
						<input type="text" name="videolink" id="videolink" class="form-control text-align-center inputbg" placeholder="Website URL">
					</div>
					<div class="form-group" style="display:none">						
						<select name="pcountry" id="pcountry" required class="form-control inputbg">							
							<option value="">-Select Country-</option>								
								<?php
									$country_query = mysql_query("SELECT * FROM freelancer_mmv_countries");
									while($country_res = mysql_fetch_array($country_query)){
										$selcountryid = $country_res[countries_id];
								?>
									<option value="<?php echo $selcountryid ?>"><?php echo $country_res[countries_name]; ?></option>								
								<?php } ?>				
						</select>
					</div>
					<div class="col-md-4" style="">						
				</div>
					<div class="form-group">
						<button id="crop_button" class="button loginbtn">Submit</button>						
						<a href="postanimage.php" class="button light-yellow">Reset</a> 						
					</div>
				</div>
			</form>
		</div>
	</div>
<script type="text/javascript" defer>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
            setTimeout(initCropper, 1000);
        }
    }
    function initCropper(){        
        var image = document.getElementById('blah');
        var cropper = new Cropper(image, {
          aspectRatio: 1 / 1,		 
          crop: function(e) {
            
          }
        });

        // On crop button clicked
        document.getElementById('crop_button').addEventListener('click', function(){
			
			var wweburl = document.getElementById("videolink").value;
			var eee = document.getElementById("pcountry");
			var ppcountry = eee.options[eee.selectedIndex].value;			
            var imgurl =  cropper.getCroppedCanvas().toDataURL();
            var img = document.createElement("img");
            img.src = imgurl;
            document.getElementById("cropped_result").appendChild(img);			
			
            /* ---------------- SEND IMAGE TO THE SERVER-------------------------*/			
                cropper.getCroppedCanvas().toBlob(function (blob) {
                      var formData = new FormData();
                      formData.append('croppedImage', blob);
                      // Use `jQuery.ajax` method                      
                      $.ajax('savecropimage.php', {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {                          						  
						 if(data=='nocharge'){				 
							window.location="index.php?status=success";	
							return false;			
						  } else {
							  myFunction(data);
							  return false;
						  }							  
						  
                        },
                        error: function () {
                          console.log('Upload error');
                        }
                      });
                });
           /* ----------------------------------------------------*/	
			
        })
    }
	
function myFunction(data) {	
	window.location.href="paypal.php?type=1&uid=<?php echo $loginid; ?>&imgid="+data; 
	alert('Please wait..!!'); 	
}
</script>	
	
<!--end main-->
<?php include "footer.php"; ?>