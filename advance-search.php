
<?php
$page_title = 'Meetfreelancers | Best Freelance Dating Site

';
$seo_title = 'Meetfreelancers | Best Freelance Dating Site

';
$seo_description = "eetfreelancers.com Has an feature to date people that matches your personality type,hobby,sport and Experience Sector and meet him.";
$seo_keywords = 'meetfreelancers,jobs,meet,hire,work,employee,employer,freelancers,money,earn,influencer,register,new,webapp,rating,interested,invite,list,chat,date,friends,users,free,opportunity,experience,help,find,view,creative,web design';

include "connection.php";
include "header.php";
?>
<!--start main-->
<div class="main">	
	<section class="contenets-main">
		<!--start form-->
		<form name="search" id="search" method="post" action="searchresults.php" onsubmit="return validateForm()">
		<div class="container">
			<div class="row form-main text-align-center advance-search">
				<div class="col-12"><h2>Advance Search</h2></div>
				<div class="col-12">
					<div class="select-box select-style">
						<!--<input type="text" class="form-control" placeholder="Hobby" id="">-->						
						<select name="hobby" id="hobby">
									<option value="" selected="selected">--Select Hobby--</option>
									<?php
									$hid = $res[hobby];
									$hob_query = mysql_query("SELECT * FROM freelancer_mmv_hobby");
									while($hob_res = mysql_fetch_array($hob_query)){
										$dbhid = $hob_res[id];
								?>
									<option <?php if($dbhid==$hid){ echo "selected"; } ?> value="<?php echo $hob_res[id]; ?>"><?php echo $hob_res[title]; ?></option>
								<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-12">
					<div class="select-box select-style">
						<!--<input type="text" class="form-control" placeholder="Sport" id="">-->						
						<select name="sport" id="sport">							 
									<option value="" selected="selected">-- Select Sport --</option>
									<?php
									$spid = $res[sporttoparticipate];
									$spo_query = mysql_query("SELECT * FROM freelancer_mmv_sport");
									while($spo_res = mysql_fetch_array($spo_query)){
										$dbspoid = $spo_res[id];
								?>
									<option <?php if($dbspoid==$spid){ echo "selected"; } ?> value="<?php echo $spo_res[id]; ?>"><?php echo $spo_res[title]; ?></option>
								<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-12">
					<div class="select-box select-style">
						<!--<input type="text" class="form-control" placeholder="Experience Field" id="">-->					
						<select name="expsector" id="expsector">
									<option value="">-- Select Experience Field --</option>
								<?php
									$expid = $res[expsectornew];
									$exp_query = mysql_query("SELECT * FROM freelancer_mmv_expsectornew");
									while($exp_res = mysql_fetch_array($exp_query)){
										$dbexpid = $exp_res[id];
								?>
									<option <?php if($dbexpid==$expid){ echo "selected"; } ?> value="<?php echo $exp_res[id]; ?>"><?php echo $exp_res[title]; ?></option>
								<?php } ?>	
						</select>
					</div>
				</div>
				<div class="col-12">
					<div class="select-box select-style">	
						<!--<input type="text" class="form-control" placeholder="MBTI Type" id="">-->						
						<select name="mbti" id="mbti">							 
									<option value="" selected="selected">-- Select MBTI Type --</option>
									<?php
									$mbid = $res[mbti];
									$mbit_query = mysql_query("SELECT * FROM freelancer_mmv_mbti");
									while($mbit_res = mysql_fetch_array($mbit_query)){
										$dbmbid = $mbit_res[id];
								?>
									<option <?php if($dbmbid==$mbid){ echo "selected"; } ?> value="<?php echo $mbit_res[id]; ?>"><?php echo $mbit_res[title]; ?></option>
								<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group register-main">						
						<button name="submit" class="button light-pink width325" type="submit">Search</button>
						
					</div>
				</div>
			</div>
		</div>	
		</form>	
		<!--end form-->		 
	</section>
</div>
<script>
function validateForm() {
	var p = document.getElementById('hobby');	
    var q = document.getElementById('sport');
    var r = document.getElementById('expsector'); 
    var s = document.getElementById('mbti'); 
	
    if (p.value!=="" || q.value!=="" || r.value!=="" || s.value!=="") {
        return true;
    } else {
		// alert("Please choose atleast one!");
		$_SESSION['status'] = "chooseone";
		window.location="advance-search.php"
        return false;
	}	 
}
</script>
<!--end main-->
<?php include "footer.php"; ?>