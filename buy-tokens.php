<?php
include "connection.php";
include "header.php";
?>
<!--start main-->
<div class="main">	
	<section class="contenets-main">
		<!--start form-->
		<div class="container">
			<div class="row form-main text-align-center">
				<div class="col-12"><h2>Buy Tokens</h2></div>
				<form action="pay-now.html" class="width100">
					<div class="col-12">
						<div class="form-group">						
							<input type="text" class="form-control" placeholder="Enter USD" id="">
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">						
							<div class="tokens-amount form-control"><span class="red">Tokens : </span> <span class="red payAmt">00</span></div>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<div class="termscondition">
								<label><input type="checkbox" class="" placeholder="" id=""/> Accept Terms & Condition.</label>
								<a href="#TermsCondition" class="popuplink">View T&C</a>
							</div>
						</div>
					</div>				
					<div class="col-12">
						<div class="form-group register-main">						
							<button class="button" type="submit">Buy Now</button>
						</div>
					</div>
				</form>
			</div>
		</div>		
		<!--end form-->		 
	</section>
</div>
<div class="popbox">
	<div class="popupbox" id="TermsCondition">
		<h2>Terms & Condition</h2>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <a href="javascript:void(0);"><i>cillum dolore</i></a> eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		<h3>Consectetur adipiscing</h3>
		<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		<h3>Excepteur sint</h3>
		<p>Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
		 voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
	</div>
</div>
<!--end main-->
<?php include "footer.php"; ?>