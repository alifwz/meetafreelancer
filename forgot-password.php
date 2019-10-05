<?php
include "connection.php";
include "header.php";

$uid = $_REQUEST[id];

if(isset($_POST['submit']))
{	
	$npassword = md5($_POST['npassword']);			
	$cpassword = md5($_POST['cpassword']);
	
	if($npassword==$cpassword){
		
		$login_query = mysql_query("SELECT * from freelancer_mmv_member_master where member_id=$uid");
		$login_res = mysql_fetch_array($login_query);						
			
		$login_query2 =	mysql_query("UPDATE freelancer_mmv_member_master SET member_password='$cpassword' where member_id=$uid");	
		$_SESSION['status'] = "passsuccess";			
		echo "<script>window.location='index.php'</script>";	exit;							
							
	} else {
		$_SESSION['status'] = "passnotmatch";
		echo "<script>window.location='forgot-password.php'</script>";exit;		
	}	
}
?>
<!--start main-->

<div class="main">		
	<section class="contenets-main">
		<!--start post job -->
		<form name="reset" method="post" action="">
		<div class="contenets post-a-job-main">
			<h2 class="text-align-center">Reset Password</h2>			
			<div class="row post-a-job-row">
				<div class="col-12">
					<div class="job-inputbox"><input type="password" minlength="8" name="npassword" required class="job-input" placeholder="New Password" /></div>
				</div>
			</div>
			<div class="row post-a-job-row">
				<div class="col-12">
					<div class="job-inputbox"><input type="password" minlength="8" name="cpassword" required class="job-input" placeholder="Confirm Password" /></div>
				</div>
			</div>
			<div class="row post-a-job-row text-align-center">
				<div class="col-12 paddingtop10">
					<button class="button" name="submit" type="submit">Change Password</button>
				</div>
			</div>
		</div>
		</form>
		<!--end post job -->
	</section>
</div>

<!--end main-->
<?php include "footer.php"; ?>