<?php
session_start();
include "connection.php";
include "header.php";
$imgid 	= $_REQUEST[imgid];
$uid 	= $_REQUEST[uid];
$type	= $_REQUEST[type];

$typequery = mysql_query("SELECT * FROM freelancer_mmv_paypalsettings WHERE id='1'");
$typeres = mysql_fetch_array($typequery);

if($type==1){
	$desc = "Image";
	$price  = $typeres[image];
} else if($type==2){
	$desc = "Video";
	$price  = $typeres[video];
}

?>
<div class="main">		
	<section class="contenets-main">
		<!--start form-->
		<div class="container">
			<div class="row form-main text-align-center">
				<div class="col-12"><h2>Please pay for posting your image/video</h2></div>				
				<div class="col-12">			  
				  <p class="file-return"></p>				
				</div>
				
				<div class="col-12">
					<!--<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="5C9V7B4PTPKC2">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
					<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
					  <input type="hidden" name="cmd" value="_s-xclick">
					  <input type="hidden" name="hosted_button_id" value="6RNT8A4HBBJRE">
					  <input type="image"
						src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png" alt="Buy Now">
					  <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif"
						width="1" height="1">
						<input type="hidden" name="return" value="https://www.google.co.in">
						<input type="hidden" name="rm" value="2">						
					</form>
					<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="picid" value="<?php echo $imgid ?>">
					<input type="hidden" name="uid" value="<?php echo $uid ?>">
					<input type="hidden" name="hosted_button_id" value="EQQACVQXUWCE6">
					<input type="hidden" name="rm" value="2">
					<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
					<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<div class="col-12">
						<div class="form-group">
							<div class="termscondition">
								<label><input type="checkbox" required class="" placeholder="" id="myCheck"/> Accept Terms & Condition.</label>
								<a href="#TermsCondition" class="popuplink">View T&C</a>
							</div>
						</div>
					</div>
					<input type="hidden" name="cmd" value="_s-xclick">				
					<input type="hidden" name="custom" value="<?php echo $uid.'-'.$imgid; ?>">
					<input type="hidden" name="hosted_button_id" value="EQQACVQXUWCE6">
					<input type="hidden" name="rm" value="2">
					<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>-->
					<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
					<div class="col-12">
						<div class="form-group">
							<div class="termscondition">
								<label><input type="checkbox" required class="" placeholder="" id="myCheck"/> Accept Terms & Condition.</label>
								<a href="#TermsCondition" class="popuplink">View T&C</a>
							</div>
						</div>
					</div>
						<input type="hidden" name="business" value="chanikya@design-master.com">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="item_name" value="<?php echo $desc ?>">
						<!--<input type="hidden" name="item_number" value="123"> -->
						<input type="hidden" name="amount" value="<?php echo $price ?>">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="custom" value="<?php echo $uid.'-'.$imgid; ?>">
						<!-- Specify URLs --> 
						<input type='hidden' name='cancel_return' value='<?php echo $urlpath ?>checkout_fail.php'>
						<input type='hidden' name='return' value='<?php echo $urlpath ?>checkout_complete.php'>
						<!-- Display the payment button. --> 
						<input type="image" name="submit" style="background-color:white;border:0" 
						src="images/paypal-buy-now-button.png" alt="PayPal - The safer, easier way to pay online">
						<img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
					</form>
				</div>			
			</div>
		</div>		
		<!--end form-->		 
	</section>
</div>
<!--end main-->

<?php
	$about_query = mysql_query("SELECT * from freelancer_mmv_aboutus where id=2");
	$about_res = mysql_fetch_array($about_query);
?>	
<div class="popbox">
	<div class="popupbox" id="TermsCondition">
		<h2>Terms & Condition</h2>
		<p><?php echo $about_res[content2] ?></p>
	</div>
</div>

<?php include "footer.php"; ?>
