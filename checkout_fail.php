<?php
//session_start();
include "connection.php";
include "header.php";

//print_r($_REQUEST);
$amt = $_REQUEST[amt];
$cc = $_REQUEST[cc];
$cm = $_REQUEST[cm];
$item_name = $_REQUEST[item_name];
$st = $_REQUEST[st];
$tx = $_REQUEST[tx];
$date = date('d-m-Y');

$split = explode('-',$cm);
$userid = $split[0];
$imgid = $split[1];


$query = mysql_query("INSERT INTO freelancer_mmv_paypalpayments(`id`,`transactid`,`item_name`,`amt`,`cc`,`st`,`date`,`userid`,`imgid`) VALUES ('','$tx','$item_name','$amt','$cc','$st',NOW(),'$userid','$imgid')");

if($query==1){	
		//echo "<script>alert('Payment failed!!')</script>";
	   $_SESSION['status'] = "fail";
		echo '<script type="text/javascript">window.location = "index.php"</script>';exit;
}
?>
<div class="main">		
	<section class="contenets-main">
		<!--start form-->
		<div class="container">
			<div class="row form-main text-align-center">
				<div class="col-12"><h2>PayPal</h2></div>				
				<div class="col-12">			  
				  <p class="file-return"></p>				
				</div>
				<div class="col-12">
										
				</div>				
			</div>
		</div>		
		<!--end form-->		 
	</section>
</div>